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

            $data['Promocode']['code'] = strtoupper($data['Promocode']['code']);
            $data['Promocode']['valid_from'] = date('Y-m-d H:i:s', strtotime($data['Promocode']['valid_from']));
            $data['Promocode']['valid_to'] = date('Y-m-d H:i:s', strtotime($data['Promocode']['valid_to']));

            $this->Promocode->set($data);
            if($this->Promocode->validates()){
                $this->Promocode->create();
                $result = $this->Promocode->save($data);
                $this->Session->setFlash(__('Promo Code added successfully.'), 'flash' );
                $this->redirect(array('action' => 'index'));
            }   
            else{
                $this->Session->setFlash(__('There are errors with the input values. Please, try again'), 'flash' );
            }
        }
    }
    
    public function admin_edit($id = null){
        $this->layout = 'admin';
        $this->isAdmin();
        if(!$this->Promocode->exists($id)){
            throw new NotFoundException(__('Invalid Promocode'));
        }
        $user_id = $this->getLoggedUserID();
        if ($user_id && $this->request->is('post') || $this->request->is('put')) {
            $data = $this->request->data;

            $data['Promocode']['code'] = strtoupper($data['Promocode']['code']);
            //Check if promo code has been used. If yes then disallow changes to code and the discount amount.
            unset($data['Promocode']['code']);
            $this->Promocode->set($data);
            $this->Promocode->validator()->remove('code');
            if($this->Promocode->save()){     
                $this->Session->setFlash(__('Promo Code updated successfully.'), 'flash' );
                $this->redirect(array('action' => 'edit', $id));
            }
            else{
                $this->Session->setFlash(__('There was a problem updating the promo code. Please try again.'), 'flash' );
                //$this->redirect(array('action' =>  'edit', $id));   
            }
        }
        else if($user_id){
            $options = array('conditions' => array('Promocode.' . $this->Promocode->primaryKey => $id));
            $this->request->data = $this->Promocode->find('first', $options);
        }
        
        $this->set(compact('id'));
    }
    
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