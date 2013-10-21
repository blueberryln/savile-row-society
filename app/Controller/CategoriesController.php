<?php

App::uses('AppController', 'Controller');

/**
 * Categories Controller
 *
 * @property Category $Category
 */
class CategoriesController extends AppController {
    public function beforeRender() {
        parent::beforeRender();
        $this->layout = 'admin';
        $this->isAdmin();
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->Category->recursive = 0;
        $this->set('categories', $this->paginate());
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Category->create();
            if ($this->request->data['Category']['parent_id'] == 0 || $this->request->data['Category']['parent_id'] == '') {
                unset($this->request->data['Category']['parent_id']);
            }
            if($this->request->data['Category']['SubCategory'] != ""){
                $this->request->data['Category']['parent_id'] = $this->request->data['Category']['SubCategory'];       
            }
            
            $this->request->data['Category']['slug'] = Inflector::slug(trim($this->request->data['Category']['slug']), '-');
            
            if ($result = $this->Category->save($this->request->data)) {
                $this->Session->setFlash(__('The category has been saved'), 'flash', array('title' => 'Success!'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The category could not be saved. Please, try again'), 'flash');
            }
        }
        
        $category_list = array();
        $category_thread = $this->Category->find('threaded');
        foreach($category_thread as $row){
            $category_list[$row['Category']['id']] = $row;
        }
        $parents = $this->Category->find('list', array('conditions' => array('Category.parent_id IS NULL')));
        $this->set(compact('parents', 'category_list'));
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        if (!$this->Category->exists($id)) {
            throw new NotFoundException(__('Invalid category'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->request->data['Category']['parent_id'] == 0 || $this->request->data['Category']['parent_id'] == '') {
                $this->request->data['Category']['parent_id'] = null;
            }
            if($this->request->data['Category']['SubCategory'] != ""){
                $this->request->data['Category']['parent_id'] = $this->request->data['Category']['SubCategory'];       
            }
            $this->request->data['Category']['slug'] = Inflector::slug(trim($this->request->data['Category']['slug']), '-');
            
            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash(__('The category has been saved'), 'flash', array('title' => 'Success!'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The category could not be saved. Please, try again'), 'flash');
            }
        } else {
            $options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
            $this->request->data = $this->Category->find('first', $options);
        }
        
        $category_list = array();
        $category_thread = $this->Category->find('threaded');
        foreach($category_thread as $row){
            $category_list[$row['Category']['id']] = $row;
        }
        
        $parent_id = 0;
        $parent_parent_id = 0;
        if($this->request->data['Category']['parent_id']){
            $parent_id = $this->request->data['Category']['parent_id'];
            $parent_data = $this->Category->find('first', array('conditions' => array('Category.id' => $parent_id)));
            if($parent_data && $parent_data['Category']['parent_id']){
                $parent_parent_id = $parent_data['Category']['parent_id'];    
            }
        }  
        
        $parents = $this->Category->find('list', array('conditions' => array('Category.parent_id IS NULL')));
        
        $this->set(compact('parents', 'category_list', 'parent_id', 'parent_parent_id'));
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Category->delete()) {
            //$this->Category->reorder();
            $this->Session->setFlash(__('Category deleted'), 'flash', array('title' => 'Success!'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Category was not deleted. Please, try again'), 'flash');
        $this->redirect(array('action' => 'index'));
    }

}
