<?php

App::uses('AppController', 'Controller');

/**
 * Colors Controller
 *
 * @property Color $Color
 */
class ColorgroupsController extends AppController {

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
        $this->Colorgroup->recursive = 0;
        $this->set('colors', $this->paginate());
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Colorgroup->create();
            if ($this->Colorgroup->save($this->request->data)) {
                $this->Session->setFlash(__('The color group has been saved'), 'flash', array('title' => 'Success!'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The color group could not be saved. Please, try again'), 'flash');
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
        if (!$this->Colorgroup->exists($id)) {
            throw new NotFoundException(__('Invalid color group'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Colorgroup->save($this->request->data)) {
                $this->Session->setFlash(__('The color group has been saved'), 'flash', array('title' => 'Success!'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The color group could not be saved. Please, try again'), 'flash');
            }
        } else {
            $options = array('conditions' => array('Colorgroup.' . $this->Colorgroup->primaryKey => $id));
            $this->request->data = $this->Colorgroup->find('first', $options);
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
        $this->Colorgroup->id = $id;
        if (!$this->Colorgroup->exists()) {
            throw new NotFoundException(__('Invalid color group'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Colorgroup->remove($id)) {
            $this->Session->setFlash(__('Color group deleted'), 'flash', array('title' => 'Success!'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Color group was not deleted. Please, try again'), 'flash');
        $this->redirect(array('action' => 'index'));
    }

}
