<?php

App::uses('AppController', 'Controller');

/**
 * Sizes Controller
 *
 * @property Size $Size
 */
class SizesController extends AppController {

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
        $this->Size->recursive = 0;
        $this->set('sizes', $this->paginate());
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Size->create();
            if ($this->Size->save($this->request->data)) {
                $this->Session->setFlash(__('The size has been saved'), 'flash', array('title' => 'Success!'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The product size not be saved. Please, try again'), 'flash');
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
        if (!$this->Size->exists($id)) {
            throw new NotFoundException(__('Invalid size'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Size->save($this->request->data)) {
                $this->Session->setFlash(__('The size has been saved'), 'flash', array('title' => 'Success!'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The product size not be saved. Please, try again'), 'flash');
            }
        } else {
            $options = array('conditions' => array('Size.' . $this->Size->primaryKey => $id));
            $this->request->data = $this->Size->find('first', $options);
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
        $this->Size->id = $id;
        if (!$this->Size->exists()) {
            throw new NotFoundException(__('Invalid size'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Size->delete()) {
            $this->Session->setFlash(__('Size deleted'), 'flash', array('title' => 'Success!'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Size was not deleted. Please, try again'), 'flash');
        $this->redirect(array('action' => 'index'));
    }

}
