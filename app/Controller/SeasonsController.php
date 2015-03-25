<?php

App::uses('AppController', 'Controller');

/**
 * Seasons Controller
 *
 * @property Season $Season
 */
class SeasonsController extends AppController {
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
        $this->Season->recursive = 0;
        $this->set('seasons', $this->paginate());
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Season->create();
            if($this->request->data['Season']['slug'] == ''){
                $this->request->data['Season']['slug'] = Inflector::slug(trim($this->request->data['Season']['name']), '-');    
            }
            else{
                $this->request->data['Season']['slug'] = Inflector::slug(trim($this->request->data['Season']['slug']), '-');    
            }
            
            
            if ($result = $this->Season->save($this->request->data)) {
                $this->Session->setFlash(__('The season has been saved'), 'flash');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The season could not be saved. Please, try again'), 'flash');
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
        if (!$this->Season->exists($id)) {
            throw new NotFoundException(__('Invalid Season'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Season']['slug'] = Inflector::slug(trim($this->request->data['Season']['slug']), '-');
            
            if ($this->Season->save($this->request->data)) {
                $this->Session->setFlash(__('The season has been saved'), 'flash');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The season could not be saved. Please, try again'), 'flash');
            }
        } else {
            $options = array('conditions' => array('Season.' . $this->Season->primaryKey => $id));
            $this->request->data = $this->Season->find('first', $options);
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
        $this->Season->id = $id;
        if (!$this->Season->exists()) {
            throw new NotFoundException(__('Invalid Season'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Season->delete()) {
            //$this->Category->reorder();
            $this->Session->setFlash(__('Season deleted'), 'flash');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Season was not deleted. Please, try again'), 'flash');
        $this->redirect(array('action' => 'index'));
    }

}
