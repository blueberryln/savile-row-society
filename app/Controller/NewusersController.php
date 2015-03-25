<?php

App::uses('AppController', 'Controller');
App::uses('Security', 'Utility');

/**
 * Newusers Controller
 */
class NewusersController extends AppController {
    
    public function index(){
        if($this->request->is('post')){
            $this->Newuser->create();
            if ($this->Newuser->validates()) {
                $this->Newuser->set($this->request->data);
                if ($this->Newuser->save($this->request->data)) {
                    $this->Session->setFlash(__('We have recorded your email address. We will inform you once the website has been launched.'), 'modal', array('class' => 'success', 'title' => 'Thank You'));
                } else {
                    $this->Session->setFlash(__('There was a problem. Please try later.'), 'modal', array('class' => 'error', 'title' => 'Houston we have a problem!'));
                }
                $this->redirect('/');
            }
        }
        else {
            $this->Session->setFlash(__('Error! Please, use a different email.'), 'modal', array('class' => 'error'));
            $this->redirect('/');
        }
    }       
}
?>