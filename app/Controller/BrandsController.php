<?php

App::uses('AppController', 'Controller');

/**
 * Brands Controller
 *
 * @property Brand $Brand
 */
class BrandsController extends AppController {

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
        $this->Brand->recursive = 0;
        $this->set('brands', $this->paginate());
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Brand->create();
            if ($this->Brand->save($this->request->data)) {
                $this->Session->setFlash(__('The brand has been saved'), 'flash', array('title' => 'Success!'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The brand could not be saved. Please, try again'), 'flash');
            }
        }
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        if (!$this->Brand->exists($id)) {
            throw new NotFoundException(__('Invalid brand'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Brand->save($this->request->data)) {
                $this->Session->setFlash(__('The brand has been saved'), 'flash', array('title' => 'Success!'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The brand could not be saved. Please, try again'), 'flash');
            }
        } else {
            $options = array('conditions' => array('Brand.' . $this->Brand->primaryKey => $id));
            $this->request->data = $this->Brand->find('first', $options);
        }
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        $this->Brand->id = $id;
        if (!$this->Brand->exists()) {
            throw new NotFoundException(__('Invalid brand'));
        }
        $this->request->onlyAllow('post', 'delete');
        
        $Product = ClassRegistry::init('Product');
        
        $product_count = $Product->find('count', array('conditions' => array('Product.brand_id' => $id)));
        if($product_count == 0){
            if ($this->Brand->delete()) {
                $this->Session->setFlash(__('Brand deleted'), 'flash', array('title' => 'Success!'));
                $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('Brand was not deleted. Please, try again'), 'flash');
            $this->redirect(array('action' => 'index'));
        }
        else{
            $this->Session->setFlash(__('This brand cannot be deleted. Products of the brand already exist.'), 'flash');
            $this->redirect(array('action' => 'index')); 
        }
    }

}
