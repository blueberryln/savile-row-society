<?php

App::uses('Controller', 'Controller');

class AppController extends Controller {

    var $components = array('Session');
    
    public function beforeRender() {
        parent::beforeRender();

        $is_logged = false;
        if ($this->getLoggedUser()) {
            $is_logged = true;
        }

        $this->getCartCount();
        $this->checkAdminRights();

        $this->set(compact('is_logged'));
        
        /**
         * Set values for profile completion popup
         */
        if($this->Session->check('completeProfile') && $this->Session->read('completeProfile')){
            if($this->params->url == "profile/about"){
                $this->set('profilePopup', array('completeProfile' => true, 'isProfile' => true));
            }
            else{
                $this->set('profilePopup', array('completeProfile' => true));   
            }
            $this->Session->delete('completeProfile');    
        }
        
    }

    /**
     * Get Logged User from Session
     * @return type 
     */
    function getLoggedUser() {
        return $this->Session->read('user');
    }

    /**
     * Get Logged User ID
     * @return type 
     */
    function getLoggedUserID() {
        // fill $user with session data
        $user = $this->getLoggedUser();
        return $user['User']['id'];
    }

    /**
     * Check if User (client) is logged in 
     */
    function isLogged() {
        // fill $user with session data
        $user = $this->getLoggedUser();

        // if the $user is empty,
        // send user to login page
        if (!$user) {

            if ($this->request->url == 'cart') {
                $this->Session->write('return_url', $this->referer());
            } else {
                $this->Session->write('return_url', Router::url(null, true));
            }

            $this->redirect('/');
            exit();
        } else {
            $this->Session->delete('return_url');
        }
    }

    /**
     * Check current logged User's
     * Admin premissions
     */
    function checkAdminRights() {

        // fill $user with session data
        $user = $this->getLoggedUser();
        $is_admin = false;

        if ($user['User']['is_admin'] == 1) {
            $is_admin = true;
        } else {
            $is_admin = false;
        }

        $this->set('is_admin', $is_admin);
    }

    /**
     * Check if User (client) is logged in 
     */
    function isAdmin() {
        // fill $user with session data
        $user = $this->getLoggedUser();

        // if the $user is empty,
        // send user to login page
        if ($user['User']['is_admin'] == 0) {
            $this->redirect('/signin');
            exit();
        }
    }

    /**
     * Get Cart items count
     */
    function getCartCount() {
        $cart_items_count = 0;
        $user_id = $this->getLoggedUserID();
        if($user_id){
            $Cart = ClassRegistry::init('Cart');
            $cart = $Cart->getExistingUserCart($user_id);
            if($cart){
                $CartItem = ClassRegistry::init('CartItem');
                $cart_id = $cart['Cart']['id'];
                $cart_items_count = $CartItem->getCartItems($cart_id);
            }
            else{
                $cart_items_count = 0;
            }
        }
        $this->Session->write('cart_items', $cart_items_count);
        $this->set('cart_items', $cart_items_count);
    }
}
