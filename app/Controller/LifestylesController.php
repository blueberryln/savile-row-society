<?php

App::uses('AppController', 'Controller');

/**
 * Lifestyles Controller
 */
 
class LifestylesController extends AppController{
    public function beforeRender() {
        parent::beforeRender();
        $this->layout = 'admin';
        $this->isAdmin();
    }
    
    public function admin_index(){
        $this->Lifestyle->recursive = 0;
        $this->set('lifestyles', $this->paginate());
    }
    
    public function admin_add(){
        $user_id = $this->getLoggedUserID();
        if ($user_id && $this->request->is('post') || $this->request->is('put')) {
            $data = $this->request->data;
            if($data['Lifestyle']['name'] != "" && $data['Lifestyle']['image'] && $data['Lifestyle']['image']['size'] > 0) {
                $lifestyle['Lifestyle']['user_id'] = $user_id;
                $lifestyle['Lifestyle']['name'] = $data['Lifestyle']['name'];
                
                $allowed = array('image/jpeg', 'image/gif', 'image/png', 'image/x-png', 'image/x-citrix-png', 'image/x-citrix-jpeg', 'image/pjpeg');
                    
                if (!in_array($data['Lifestyle']['image']['type'], $allowed)) {
                    $this->Session->setFlash(__('You have to upload an image.'), 'flash');
                } else if ($data['Lifestyle']['image']['size'] > 3145728) {
                    $this->Session->setFlash(__('Attached image must be up to 3 MB in size.'), 'flash');
                } else {
                    $rand = substr(uniqid ('', true), -7);
                    $img = $data['Lifestyle']['name'] . '_' . $rand . '_' . $data['Lifestyle']['image']['name'];
                    $img_type = $data['Lifestyle']['image']['type'];
                    $img_size = $data['Lifestyle']['image']['size'];
                    move_uploaded_file($data['Lifestyle']['image']['tmp_name'], APP . DS . 'webroot' . DS . 'files' . DS . 'lifestyles' . DS . $img);
                }
                
                // save image
                if ($img) {
                    // init
                    $lifestyle['Lifestyle']['image'] =$img;

                    $this->Lifestyle->create();
                    if ($this->Lifestyle->save($lifestyle)) {
                        $this->Session->setFlash(__('Lifestyle has been added successfully.'), 'flash');
                        $this->redirect('index');
                    }
                }   
            }   
        }
    }
    
    public function admin_edit($id = null){
        if(!$this->Lifestyle->exists($id)){
            throw new NotFoundException(__('Invalid Lifestyle'));
        }
        $user_id = $this->getLoggedUserID();
        if ($user_id && $this->request->is('post') || $this->request->is('put')) {
            $data = $this->request->data;
            if($data['Lifestyle']['name'] != "" ) {
                $options = array('conditions' => array('Lifestyle.' . $this->Lifestyle->primaryKey => $id));
                $lifestyle = $this->Lifestyle->find('first', $options);
                $lifestyle['Lifestyle']['name'] = $data['Lifestyle']['name'];
                
                if($this->Lifestyle->save($lifestyle)){
                    $this->Session->setFlash(__('Lifestyle has been updated successfully.'), 'flash');
                    $this->redirect('index');    
                }
            }   
        }
        else if($user_id){
            $this->Lifestyle->recursive = 1;
            $options = array('conditions' => array('Lifestyle.' . $this->Lifestyle->primaryKey => $id));
            $this->request->data = $this->Lifestyle->find('first', $options);
        }
    }
}