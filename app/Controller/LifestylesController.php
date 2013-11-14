<?php

App::uses('AppController', 'Controller');

/**
 * Lifestyles Controller
 */
 
class LifestylesController extends AppController{
    public function beforeRender() {
        parent::beforeRender();
    }
    
    public function index($id = null, $slug = null){
        if($id == null || $slug == null){
            throw new NotFoundException;    
        }
        
        $user_id = $this->getLoggedUserID();
        $lifestyle = $this->Lifestyle->getByIdSlug($id, $slug);
        
        if(!$lifestyle){
            throw new NotFoundException;     
        }
        
        
        $Category = ClassRegistry::init('Category');
        $Brand = ClassRegistry::init('Brand');
        $Color = ClassRegistry::init('Color');
        $User = ClassRegistry::init('User');

        // get data
        $categories = $Category->getAll();
        $brands = $Brand->find('all', array('order' => "Brand.name ASC"));
        $colors = $Color->find('all', array('order' => "Color.name ASC"));
        
        $entity_list = $this->Lifestyle->LifestyleItem->getLifestyleProducts($id);
        
        $Entity = ClassRegistry::init('Entity');
        if($user_id){
            $entities = $Entity->getEntitiesById($entity_list, $user_id);    
        }
        else{
            $entities = $Entity->getEntitiesById($entity_list);    
        }
        
        $this->set(compact('categories', 'brands', 'colors', 'lifestyle', 'entities'));
    }
    
    public function admin_index(){
        $this->layout = 'admin';
        $this->isAdmin();
        $this->Lifestyle->recursive = 0;
        $this->set('lifestyles', $this->paginate());
    }
    
    public function admin_add(){
        $this->layout = 'admin';
        $this->isAdmin();
        $user_id = $this->getLoggedUserID();
        if ($user_id && $this->request->is('post') || $this->request->is('put')) {
            $data = $this->request->data;
            if($data['Lifestyle']['name'] != "" && $data['Lifestyle']['image'] && $data['Lifestyle']['image']['size'] > 0) {
                $lifestyle['Lifestyle']['user_id'] = $user_id;
                $lifestyle['Lifestyle']['name'] = $data['Lifestyle']['name'];
                $lifestyle['Lifestyle']['slug'] = strtolower(Inflector::slug($data['Lifestyle']['name'], '-'));
                
                if($data['Lifestyle']['caption']){
                    $lifestyle['Lifestyle']['caption'] = $data['Lifestyle']['caption'];
                }
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
        $this->layout = 'admin';
        $this->isAdmin();
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
                $lifestyle['Lifestyle']['slug'] = strtolower(Inflector::slug($data['Lifestyle']['name'], '-'));
                $lifestyle['Lifestyle']['caption'] = $data['Lifestyle']['caption'];
                
                if($data['Lifestyle']['image'] && $data['Lifestyle']['image']['size'] > 0){
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
                    
                    $file = new File('files/lifestyles/' . $lifestyle['Lifestyle']['image'], true, 0777);
                    if ($file->exists()) {
                        $file->delete();
                    } 
                    if ($img) {
                        $lifestyle['Lifestyle']['image'] =$img;
                    }
                }
                
                if($this->Lifestyle->save($lifestyle)){
                    $this->Session->setFlash(__('Lifestyle has been updated successfully.'), 'flash');
                    $this->redirect('index');    
                }
            }   
        }
        else if($user_id){
            $this->Lifestyle->recursive = 2;
            $this->Lifestyle->LifestyleItem->unbindModel(array("hasMany" => array('LidestyleItem')));
            $options = array('conditions' => array('Lifestyle.' . $this->Lifestyle->primaryKey => $id));
            $this->request->data = $this->Lifestyle->find('first', $options);
        }
        
        $this->set(compact('id'));
    }
    
    public function admin_delete($id = null){
        $this->layout = 'admin';
        $this->isAdmin();
        $this->Lifestyle->id = $id;
        if(!$this->Lifestyle->exists()){
            throw new NotFoundException(__('Invalid Lifestyle'));
        }
        $this->request->onlyAllow('post', 'delete');
        $lifestyle = $this->Lifestyle->find('first');
        if($this->Lifestyle->delete()){
            $file = new File('files/lifestyles/' . $lifestyle['Lifestyle']['image'], true, 0777);
            if ($file->exists()) {
                $file->delete();
            } 
            
            $this->Session->setFlash(__('Lifestyle deleted'), 'flash', array('title' => 'Success!'));
            $this->redirect(array('action' => 'index'));    
        }
        $this->Session->setFlash(__('Lifestyle could not be deleted'), 'flash');
        $this->redirect(array('action' => 'index'));
    }
    
    public function admin_add_items($id = null){
        $this->layout = 'admin';
        $this->isAdmin();
        if(!$this->Lifestyle->exists($id)){
            throw new NotFoundException(__('Invalid Lifestyle'));
        }
        $data = $this->request->data;
        
        if($this->request->is('post') || $this->request->is('put')){
            $options = array('conditions' => array('Lifestyle.' . $this->Lifestyle->primaryKey => $id));
            $lifestyle = $this->Lifestyle->find('first', $options);
            $Entity = ClassRegistry::init('Entity'); 
            if($data['Lifestyle']['product_entity_id'] > 0 && $Entity->exists($data['Lifestyle']['product_entity_id'])){
                $data['LifestyleItem']['lifestyle_id'] = $id;
                $data['LifestyleItem']['product_entity_id'] = $data['Lifestyle']['product_entity_id'];
                
                $LifestyleItem = ClassRegistry::init('LifestyleItem');
                
                $existing_entity = $LifestyleItem->getByEntityId($id, $data['Lifestyle']['product_entity_id']);
                if($existing_entity){
                    $this->Session->setFlash(__('Lifestyle item already exists.'), 'flash');            
                }
                else{
                    $this->Lifestyle->LifestyleItem->create();
                    if($this->Lifestyle->LifestyleItem->save($data)){
                        $this->Session->setFlash(__('Lifestyle item added successfully.'), 'flash');    
                    }
                    else{
                        $this->Session->setFlash(__('Lifestyle item could not be added.'), 'flash');
                    } 
                }    
            }   
            else{
                $this->Session->setFlash(__('Lifestyle item could not be added.'), 'flash');    
            }
        } 
        $this->redirect('edit/'. $id);   
    }
    
    public function admin_delete_item($id = null){
        $this->layout = 'admin';
        $this->isAdmin();
        $this->Lifestyle->LifestyleItem->id = $id;
        if(!$this->Lifestyle->LifestyleItem->exists()){
            throw new NotFoundException(__('Invalid Lifestyle Product'));
        }
        $this->request->onlyAllow('post', 'delete');
        
        if($this->Lifestyle->LifestyleItem->delete()){
            $this->Session->setFlash(__('Lifestyle product deleted'), 'flash', array('title' => 'Success!'));
            $this->redirect(array('action' => 'index'));    
        }
        $this->Session->setFlash(__('Lifestyle product could not be deleted'), 'flash');
        $this->redirect(array('action' => 'index'));   
    }
}