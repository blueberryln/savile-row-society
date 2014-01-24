<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Lifestyles Controller
 */
 
class PromocodesController extends AppController{
    public $components = array('Paginator');
    public $helpers = array('Paginator');
    
    public function beforeRender() {
        parent::beforeRender();
    }
    
    
    public function admin_index(){
        $this->layout = 'admin';
        $this->isAdmin();
        $this->Promocode->recursive = 0;
        $this->set('promocodes', $this->paginate());
    }
    
    public function admin_add(){
        $this->layout = 'admin';
        $this->isAdmin();
        $user_id = $this->getLoggedUserID();
        if ($user_id && $this->request->is('post') || $this->request->is('put')) {
            $data = $this->request->data;
            $this->Promocode->set($data);
            if($this->Promocode->validates()){
                print_r($data);
            }   
            else{
                $this->Session->setFlash(__('There are errors with the input values. Please, try again'), 'flash' );
            }
        }
    }
    
    // public function admin_edit($id = null){
    //     $this->layout = 'admin';
    //     $this->isAdmin();
    //     if(!$this->Lifestyle->exists($id)){
    //         throw new NotFoundException(__('Invalid Lifestyle'));
    //     }
    //     $user_id = $this->getLoggedUserID();
    //     if ($user_id && $this->request->is('post') || $this->request->is('put')) {
    //         $data = $this->request->data;
    //         if($data['Lifestyle']['name'] != "" ) {
    //             $options = array('conditions' => array('Lifestyle.' . $this->Lifestyle->primaryKey => $id));
    //             $lifestyle = $this->Lifestyle->find('first', $options);
    //             $lifestyle['Lifestyle']['name'] = $data['Lifestyle']['name'];
    //             $lifestyle['Lifestyle']['slug'] = strtolower(Inflector::slug($data['Lifestyle']['name'], '-'));
    //             $lifestyle['Lifestyle']['caption'] = $data['Lifestyle']['caption'];
                
    //             if($data['Lifestyle']['image'] && $data['Lifestyle']['image']['size'] > 0){
    //                 $allowed = array('image/jpeg', 'image/gif', 'image/png', 'image/x-png', 'image/x-citrix-png', 'image/x-citrix-jpeg', 'image/pjpeg');
                    
    //                 if (!in_array($data['Lifestyle']['image']['type'], $allowed)) {
    //                     $this->Session->setFlash(__('You have to upload an image.'), 'flash');
    //                 } else if ($data['Lifestyle']['image']['size'] > 3145728) {
    //                     $this->Session->setFlash(__('Attached image must be up to 3 MB in size.'), 'flash');
    //                 } else {
    //                     $rand = substr(uniqid ('', true), -7);
    //                     $img = $data['Lifestyle']['name'] . '_' . $rand . '_' . $data['Lifestyle']['image']['name'];
    //                     $img_type = $data['Lifestyle']['image']['type'];
    //                     $img_size = $data['Lifestyle']['image']['size'];
    //                     move_uploaded_file($data['Lifestyle']['image']['tmp_name'], APP . DS . 'webroot' . DS . 'files' . DS . 'lifestyles' . DS . $img);
    //                 }   
                    
    //                 $file = new File('files/lifestyles/' . $lifestyle['Lifestyle']['image'], true, 0777);
    //                 if ($file->exists()) {
    //                     $file->delete();
    //                 } 
    //                 if ($img) {
    //                     $lifestyle['Lifestyle']['image'] =$img;
    //                 }
    //             }
                
    //             if($this->Lifestyle->save($lifestyle)){
    //                 $this->Session->setFlash(__('Lifestyle has been updated successfully.'), 'flash');
    //                 $this->redirect('index');    
    //             }
    //         }   
    //     }
    //     else if($user_id){
    //         $this->Lifestyle->recursive = 2;
    //         $this->Lifestyle->LifestyleItem->unbindModel(array("hasMany" => array('LidestyleItem')));
    //         $options = array('conditions' => array('Lifestyle.' . $this->Lifestyle->primaryKey => $id));
    //         $this->request->data = $this->Lifestyle->find('first', $options);
    //     }
        
    //     $this->set(compact('id'));
    // }
    
    // public function admin_delete($id = null){
    //     $this->layout = 'admin';
    //     $this->isAdmin();
    //     $this->Lifestyle->id = $id;
    //     if(!$this->Lifestyle->exists()){
    //         throw new NotFoundException(__('Invalid Lifestyle'));
    //     }
    //     $this->request->onlyAllow('post', 'delete');
    //     $lifestyle = $this->Lifestyle->find('first');
    //     if($this->Lifestyle->delete()){
    //         $file = new File('files/lifestyles/' . $lifestyle['Lifestyle']['image'], true, 0777);
    //         if ($file->exists()) {
    //             $file->delete();
    //         } 
            
    //         $this->Session->setFlash(__('Lifestyle deleted'), 'flash', array('title' => 'Success!'));
    //         $this->redirect(array('action' => 'index'));    
    //     }
    //     $this->Session->setFlash(__('Lifestyle could not be deleted'), 'flash');
    //     $this->redirect(array('action' => 'index'));
    // }
}