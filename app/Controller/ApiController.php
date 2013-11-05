<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class ApiController extends AppController {

    var $uses = null;

    function beforeFilter() {
        parent::beforeFilter();
        if ($this->request->is('ajax')) {
            $this->Components->unload('Security');
        }
    }

    /**
     * Wishlist
     */
    public function wishlist($param = null) {

        Configure::write('debug', 0);
        
        $ret = array();
        $this->autolayout = false;
        $this->autoRender = false;

        // init
        $Wishlist = ClassRegistry::init('Wishlist');
        $user_id = $this->getLoggedUserID();

        // save wishlist item
        if ($user_id && $param && $param == 'save') {
            $product_id = $this->request->data['product_id'];

            $Dislike = ClassRegistry::init('Dislike');
            $Like = ClassRegistry::init('Like');
            $dislike = $Dislike->get($user_id, $product_id);
            if($dislike && $dislike['Dislike']['show']){
                $ret['status'] = "error";
                $ret['msg'] = 'Item already been disliked.';
            }
            else if($this->request->is('ajax')) {
                // get posted product id

                $wishlist = $Wishlist->get($user_id, $product_id);

                if (!$wishlist) {
                    $wishlist['Wishlist']['user_id'] = $user_id;
                    $wishlist['Wishlist']['product_entity_id'] = $product_id;

                    $Wishlist->create();
                    if ($Wishlist->save($wishlist)) {
                        //Check if present in likes
                        $like = $Like->get($user_id, $product_id);
                        if(!$like){
                            $like['Like']['user_id'] = $user_id;
                            $like['Like']['product_entity_id'] = $product_id;   
                            $Like->create(); 
                            $Like->save($like); 
                        }
                        
                        $user = $this->getLoggedUser();
                        if ($user && $user['User']['preferences']) {
                            $preferences = unserialize($user['User']['preferences']);
                        }
                        
                        if(isset($preferences) && isset($preferences['UserPreference']['is_complete']) && $preferences['UserPreference']['is_complete'] == "completed"){
                            $ret['profile_status'] = "complete";
                        }
                        else{
                            $ret['profile_status'] = "incomplete";
                            $ret['profile_msg'] = "Dear " . ucfirst($user['User']['first_name']) . ", <br>You have liked an item in The Closet, so let one of our style experts use this information to provide you with more item recommendations. Fill out our quick style profile form and get assigned a personal stylist.";
                        }
                        
                        $ret['status'] = "ok";
                        $ret['msg'] = 'Item added to liked items.';
                    } else {
                        $ret['status'] = "error";
                        $ret['msg'] = 'Item could not be liked.';
                    }
                } else {
                    $ret['status'] = "error";
                    $ret['msg'] = 'Item has already been liked.';
                }
            }
        } elseif ($user_id && $param && $param == 'remove') {

            if ($this->request->is('ajax')) {
                // get posted product id
                $product_id = $this->request->data['product_id'];

                if ($result = $Wishlist->remove($user_id, $product_id)) {
                    $ret['status'] = "ok";
                    $ret['msg'] = 'Item has been removed from liked items.';
                } else {
                    $ret['status'] = "error";
                    $ret['msg'] = 'Sorry, item could not be removed right now.';
                }
            }
        } else {
            $ret['status'] = "error";
            $ret['msg'] = 'To like an item, you need to sign in first';
        }
        echo json_encode($ret);
        exit;
    }

    /**
     * Dislikes
     */
    public function dislike($param = null) {

        Configure::write('debug', 0);

        $this->autolayout = false;
        $this->autoRender = false;

        // init
        $Dislike = ClassRegistry::init('Dislike');
        $user_id = $this->getLoggedUserID();

        // save dislike item
        if ($user_id && $param && $param == 'save') {
            $product_id = $this->request->data['product_id'];

            $Wishlist = ClassRegistry::init('Wishlist');
            $wishlist = $Wishlist->get($user_id, $product_id);
            if($wishlist){
                $ret['status'] = "error";
                $ret['msg'] = 'Item already been liked.';
            }
            elseif ($this->request->is('ajax')) {
                // get posted product id

                $dislike = $Dislike->get($user_id, $product_id);

                if (!$dislike) {
                    $dislike['Dislike']['user_id'] = $user_id;
                    $dislike['Dislike']['product_entity_id'] = $product_id;

                    $Dislike->create();
                    if ($Dislike->save($dislike)) {
                        $ret['status'] = "ok";
                        $ret['msg'] = 'Item added to disliked items.';
                    } else {
                        $ret['status'] = "error";
                        $ret['msg'] = 'Item could not be diliked.';
                    }
                } else {
                    $dislike['Dislike']['show'] = 1;
                    if($Dislike->save($dislike)){
                        $ret['status'] = "ok";
                        $ret['msg'] = 'Item added to disliked items.';    
                    }
                    else{
                        $ret['status'] = "error";
                        $ret['msg'] = 'Sorry, item could not be added right now.';
                    }
                }
            }
        } elseif ($user_id && $param && $param == 'remove') {

            if ($this->request->is('ajax')) {
                // get posted product id
                $product_id = $this->request->data['product_id'];
                $dislike = $Dislike->get($user_id, $product_id);
                if ($dislike) {
                    $dislike['Dislike']['show'] = 0;
                    if($Dislike->save($dislike)){
                        $ret['status'] = "ok";
                        $ret['msg'] = 'Item has been removed from disliked items.';    
                    }
                    else{
                        $ret['status'] = "ok";
                        $ret['msg'] = 'Item has been removed from disliked items.';
                    }
                } else {
                    $ret['status'] = "error";
                    $ret['msg'] = 'Sorry, item could not be removed right now.';
                }
            }
        } else {
            $ret['status'] = "error";
            $ret['msg'] = 'To dislike an item, you need to sign in first';
        }
        echo json_encode($ret);
        exit;
    }

    /**
     * Comment
     * Post comment
     */
    public function comment($param = null) {

        Configure::write('debug', 0);

        $this->autolayout = false;
        $this->autoRender = false;

        // init
        $Comment = ClassRegistry::init('Comment');
        $user_id = $this->getLoggedUserID();

        // save wishlist item
        if ($user_id && $param && $param == 'save') {

            if ($this->request->is('ajax')) {
                $user = $this->getLoggedUser();
                $model_id = $this->request->data['model_id'];
                $model = $this->request->data['model'];
                $text = $this->request->data['text'];

                $Comment->create();
                $comment['Comment']['user_id'] = $user_id;
                $comment['Comment']['model_id'] = $model_id;
                $comment['Comment']['model'] = $model;
                $comment['Comment']['text'] = $text;

                if ($Comment->save($comment)) {
                    echo $user['User']['full_name'];
                }
            }
        }
    }

    /**
     * Cart
     */
    public function cart($param = null) {

        //Configure::write('debug', 0);
        $this->autolayout = false;
        $this->autoRender = false;
        
        $ret = array();
        
        // init
        $Entity = ClassRegistry::init('Entity');
        $user_id = $this->getLoggedUserID();

        
        if($user_id){
            if ($user_id && $param && $param == 'save') {
    
                if ($this->request->is('ajax')) {
                    $Cart = ClassRegistry::init('Cart');
                    $CartItem = ClassRegistry::init('CartItem');
                    
                    // Get product Entity ID and Get the information for the entity
                    $entity_id = $this->request->data['product_id'];
                    $entity = $Entity->getById($entity_id, $user_id);
                    
                    //Prepare data array for adding cart information
                    $data['CartItem']['product_entity_id'] = $entity['Entity']['id'];
                    $data['CartItem']['quantity'] = $this->request->data['product_quantity'];
                    if(isset($this->request->data['product_size'])){
                        $data['CartItem']['size_id'] = $this->request->data['product_size'];
                    }
                    else{
                        $data['CartItem']['size_id'] = 1;
                    }
    
                    $cart = $Cart->getExistingUserCart($user_id);
                    if($cart){
                        $data['Cart'] = $cart['Cart'];
                        unset($data['Cart']['created']);
                        unset($data['Cart']['updated']);
                        $result = $Cart->save($data);
                        
                        $data['CartItem']['cart_id'] = $result['Cart']['id'];
                        $cart_id = $result['Cart']['id'];
                        $CartItem->create();
                        if($result = $CartItem->save($data)){
                            $ret['status'] = 'ok';   
                        }
                        else{
                            $ret['status'] = 'error';  
                        }
                    }
                    else{
                        $data['Cart']['user_id'] = $user_id;
                        $Cart->create();
                        $result = $Cart->save($data);
                        
                        $data['CartItem']['cart_id'] = $result['Cart']['id'];
                        $cart_id = $result['Cart']['id'];
                        $CartItem->create();
                        if($result = $CartItem->save($data)){
                            $ret['status'] = 'ok';    
                        }
                        else{
                            $ret['status'] = 'error';   
                        }
                    }
                    $ret['count'] = $this->cartCount($cart_id);
                    
                    if($ret['count'] == 3){
                        $user = $this->getLoggedUser();
                        $cart_list = $CartItem->getByCartId($cart_id);
    
                        $entity_list = array();
                        foreach($cart_list as $item){
                            $entity_list[] = $item['CartItem']['product_entity_id'];
                        }
                        $entities = $Entity->getEntitiesById($entity_list, $user_id);
            
                        $cart_total = 0;
                        foreach($cart_list as &$item){
                            foreach($entities as $entity){
                                if($entity['Entity']['id'] == $item['CartItem']['product_entity_id']){
                                    $cart_total += $item['CartItem']['quantity'] * $entity['Entity']['price'];
                                }
                            }
                        }
                        
                        $ret['cart_total'] = $cart_total;
                        $ret['cart_message'] = "Dear " . ucwords($user['User']['full_name']) . ",<br>We would like to remind you that you currently have three items in your cart, totaling $" . number_format($cart_total, 2) . ".";
                    }
                    
                    echo json_encode($ret);
                    exit;
                }
            } 
            else if($user_id && $param && $param == 'update') {
                $Cart = ClassRegistry::init('Cart');
                $CartItem = ClassRegistry::init('CartItem');
                $item_list = $this->request->data['items'];
                foreach($item_list as $item){
                    $cur_item = $CartItem->findById($item["item-id"]);
                    if($cur_item){
                        $cur_item['CartItem']['quantity'] = $item["quantity"];
                        $CartItem->save($cur_item);   
                    }
                }         
            }
            elseif ($user_id && $param && $param == 'remove') {
    
                if ($this->request->is('ajax')) {
                    // get posted product id
                    $item_id = $this->request->data['cart_item_id'];
                    
                    
                    $Cart = ClassRegistry::init('Cart');
                    $CartItem = ClassRegistry::init('CartItem');
                    
                    $item = $CartItem->findById($item_id);
                    $cart = $Cart->getExistingUserCart($user_id);
                    
                    if($item['CartItem']['cart_id'] == $cart['Cart']['id']){
                        $CartItem->remove($item_id);
                        $ret['status'] = 'ok';
                    }
                    else{
                        $ret['status'] = 'error';
                    }
                    
                    $this->getCartCount();
                    $ret['count'] = $this->Session->read('cart_items');
                    
                    echo json_encode($ret);
                    exit;
                    
                }
            } elseif ($user_id && $param && $param == 'count') {
    
                if ($this->request->is('ajax')) {
                    $cart_items_count = 0;
                    $cart_storage = $this->Session->read('cart_storage');
                    if ($cart_storage && is_array($cart_storage)) {
                        $cart_items_count = count($cart_storage);
                    }
                    echo json_encode(array('count' => $cart_items_count));
                }
            }
        }
        else{
            $ret['status'] = 'login';
            echo json_encode($ret);
        }
    }
    
    
    /**
     * Similar Products
     */
    public function similar() {
        $this->autolayout = false;
        $this->autoRender = false;
        
        $user_id = $this->getLoggedUserID();
        $Entity = ClassRegistry::init('Entity');
        $ret = array();
            
        $category_id = $this->request->data['categoryId'];
        $product_id = $this->request->data['productId'];
        
        $entity = $Entity->getSimilarProduct($category_id, $product_id, $user_id);
        if($entity){
            $ret['status'] = 'ok';
            $ret['product'] = $entity;   
        }
        else{
            $ret['status'] = 'no-rows';
        }
            
        echo json_encode($ret);
        exit;
    }
    
    
    /**
     * Message Notification
     */
    public function messageNotification() {
        $this->autolayout = false;
        $this->autoRender = false;
        
        $user_id = $this->getLoggedUserID();
        $message_notification = $this->getMessageNotification();
            
        echo json_encode($message_notification);
        exit;
    }
    
    /**
     * Message Notification
     */
    public function getNewClients() {
        $this->autolayout = false;
        $this->autoRender = false;
        $ret = array();
        
        $user = $this->getLoggedUser();
        $user_id = $user['User']['id'];
        $client_string = $this->request->data['clientString'];
        $client_array = explode(',', $client_string);
        if($user_id && $user['User']['is_stylist'] == '1' && $client_array && $client_array != "" && count($client_array) > 0){
            $User = ClassRegistry::init('User');
            $new_clients = $User->getNewClients($client_array, $user_id);
            if($new_clients){
                $ret['status'] = 'ok';
                $ret['clients'] = $new_clients;        
            }
            else{
                $ret['status'] = 'error';    
            }
        }
        else{
            $ret['status'] = 'error1';
        }
            
        echo json_encode($ret);
        exit;
    }
    
    
    /**
     * Get cart count
     */
    public function cartCount($cart_id){
        $cart_item_count = 0;
        if($cart_id){
            $CartItem = ClassRegistry::init('CartItem');
            $cart_item_count = $CartItem->getCartItems($cart_id);
        }
        
        return $cart_item_count;    
    }
    
    /**
     * Show/Hide Popup
     */
    public function toggleClosetPopup($action = null){
        if($action != null && ($action == "hide" || $action == "show")){
            if($action == "show"){
                if($this->Session->read('hide-closet-popup')){
                    $this->Session->delete('hide-closet-popup');
                    echo "show";    
                }
            }
            else{
                $this->Session->write('hide-closet-popup','hide');
                echo "hide";
            }
        }
        exit;
    }
}

