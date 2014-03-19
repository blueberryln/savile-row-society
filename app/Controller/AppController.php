<?php

App::uses('Controller', 'Controller');

class AppController extends Controller {

    var $components = array('Session');
    
    /**
     * To redirect any https request to http for any request to a controller action other than Closet Controller.
     * @return none
     */
    function beforeFilter() {
        if($this->request->is('ssl')){ 
            if($this->request->params['controller'] != "closet"){
                $this->redirect('http://' . env('SERVER_NAME') . $this->here);
            }
        } 
           
    }


    /**
     * Before render:
     * 1. Set logged status.
     * 2. Check and set if stylist has been assigned.
     * 3. Set cart count.
     * 4. Check if user has admin rights.
     * 5. Check if user has stylist rights.
     * 6. Check if register popup needs to be shown.
     * 7. Get message notification.
     * 8. Check if complete style profile popup needs to be shown.
     */
    public function beforeRender() {
        parent::beforeRender();
        
        if($this->Session->check('showRegisterPopup')){
            $showRegisterPopup = 1;
            $this->Session->delete('showRegisterPopup');
            $this->set(compact('showRegisterPopup'));
        }

        $has_stylist = false;
        $is_logged = false;
        if ($user = $this->getLoggedUser()) {
            
            $is_logged = true;
            $User = ClassRegistry::init('User');
            $stylist_id = $User->hasStylist($user['User']['id']);
            if($stylist_id['User']['stylist_id']){
                $has_stylist = true;
                
                //Update Session if stylist has been assigned lately
                $user = $User->getById($user['User']['id']);
                $this->Session->write('user', $user);
            }
        }
        else{
            if($this->Session->check('referer')){
                $User = ClassRegistry::init('User');
                $referer_id = $this->Session->read('referer'); 
                $referer_type = $this->Session->read('referer_type');
                $referer = $User->findById($referer_id);
                $this->set(compact('referer_type', 'referer'));
            } 
        }

        $this->getCartCount();
        $this->checkAdminRights();
        $this->checkStylistRights();
        $message_notification = $this->getMessageNotification();
        if($message_notification){
            $this->set(compact('message_notification'));
        }
        $this->set(compact('is_logged','has_stylist','user'));
        
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
     * @return values od user session. 
     */
    function getLoggedUser() {
        return $this->Session->read('user');
    }


    /**
     * Get Logged User ID
     * @return User id of the logged user. 
     */
    function getLoggedUserID() {
        // fill $user with session data
        $user = $this->getLoggedUser();
        return $user['User']['id'];
    }


    /**
     * Check if the current user is logged in. 
     */
    function isLogged() {
        // fill $user with session data
        $user = $this->getLoggedUser();

        // If the $user is empty,
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
     * Check current logged User's
     * Stylist premissions
     */
    function checkStylistRights() {

        // fill $user with session data
        $user = $this->getLoggedUser();
        $is_stylist = false;

        if ($user['User']['is_stylist'] == 1) {
            $is_stylist = true;
        } else {
            $is_stylist = false;
        }

        $this->set('is_stylist', $is_stylist);
    }


    /**
     * Check if current user is admin
     */
    function isAdmin() {
        // fill $user with session data
        $user = $this->getLoggedUser();

        // if is_admin is not set to 1, redirect to home.
        if ($user['User']['is_admin'] == 0) {
            $this->redirect('/');
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
    
    
    /**
     * Get notification count: total, new messages, new outfits
     */
    function getMessageNotification(){
        $user_id = $this->getLoggedUserID();
        $Message = ClassRegistry::init('Message');
        $message_notification = array();
        if($user_id){
            $message_notification['total'] = $Message->getTotalNotificationCount($user_id);
            $message_notification['message'] = $Message->getNewMessageCount($user_id);
            $message_notification['outfit'] = $Message->getNewOutfitCount($user_id);
            return $message_notification;
        }    
        return false;
    } 
}
