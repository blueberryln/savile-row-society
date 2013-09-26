<?php

App::uses('AppController', 'Controller');

/**
 * Colors Controller
 *
 * @property Color $Color
 */
class ColorsController extends AppController {

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
        $this->Color->recursive = 0;
        $this->set('colors', $this->paginate());
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Color->create();
            if ($this->Color->save($this->request->data)) {
                $this->Session->setFlash(__('The color has been saved'), 'flash', array('title' => 'Success!'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The color could not be saved. Please, try again'), 'flash');
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
        if (!$this->Color->exists($id)) {
            throw new NotFoundException(__('Invalid color'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Color->save($this->request->data)) {
                $this->Session->setFlash(__('The color has been saved'), 'flash', array('title' => 'Success!'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The color could not be saved. Please, try again'), 'flash');
            }
        } else {
            $options = array('conditions' => array('Color.' . $this->Color->primaryKey => $id));
            $this->request->data = $this->Color->find('first', $options);
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
        $this->Color->id = $id;
        if (!$this->Color->exists()) {
            throw new NotFoundException(__('Invalid color'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Color->delete()) {
            $this->Session->setFlash(__('Color deleted'), 'flash', array('title' => 'Success!'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Color was not deleted. Please, try again'), 'flash');
        $this->redirect(array('action' => 'index'));
    }

}
