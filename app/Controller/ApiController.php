<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('Validation', 'Utility');

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
            $outfit_id = $this->request->data['outfit_id'];

            $error = false;
            $Like = ClassRegistry::init('Like');
            $posts = ClassRegistry::init('Post');
            
            if($this->request->is('ajax') && !$error) {
                // get posted product id
                $wishlist = $Wishlist->get($user_id, $product_id, $outfit_id);
                //bhashit code
                $User = ClassRegistry::init('User');
                $stylistid = $User->getByID($user_id);
                $sty_id = $stylistid['User']['stylist_id'];
                $this->request->data['Post']['user_id'] = $user_id;
                $this->request->data['Post']['stylist_id'] = $sty_id; 
                $this->request->data['Post']['is_like'] = '1';
                $posts->save($this->request->data);
                $post_id = $posts->getLastInsertID();
                //bhashit code end
                if (!$wishlist) {
                    //bhashit code
                    $wishlist['Wishlist']['post_id'] = $post_id;
                    //bhashit code
                    $wishlist['Wishlist']['user_id'] = $user_id;
                    $wishlist['Wishlist']['product_entity_id'] = $product_id;
                    $wishlist['Wishlist']['outfit_id'] = $outfit_id;

                    $Wishlist->create();
                    if ($Wishlist->save($wishlist)) {
                        //Check if present in likes
                        
                       $like = $Like->get($user_id, $product_id, $outfit_id);
                        if(!$like){
                            //bhashitcode
                            $like['Like']['post_id'] = $post_id;
                            //bhashitcode end
                            $like['Like']['user_id'] = $user_id;
                            $like['Like']['product_entity_id'] = $product_id;
                            $like['Like']['outfit_id'] = $outfit_id;   
                            $Like->create(); 
                            $Like->save($like); 
                        }
                        
                        $user = $this->getLoggedUser();
                        if ($user && $user['User']['preferences']) {
                            $preferences = unserialize($user['User']['preferences']);   
                        }
                        
                        if(isset($preferences) && isset($preferences['UserPreference']['is_complete']) && ($preferences['UserPreference']['is_complete'] == "completed" || $preferences['UserPreference']['is_complete'] == "1")){
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
                    //print_r($entity);
                    //print_r($ret);
                    //exit;   
                    //Prepare data array for adding cart information
                    if($entity['Entity']['is_gift']){
                        $data['CartItem']['product_entity_id'] = $entity['Entity']['id'];
                        $data['CartItem']['quantity'] = 1;
                        $data['CartItem']['size_id'] = 1; 
                        $data['CartItem']['is_gift'] = 1;
                        
                        
                        $data['CartGiftItem']['recipient_email'] = $this->request->data['recipientEmail'];
                        $data['CartGiftItem']['recipient_name'] = $this->request->data['recipientName']; 
                        $data['CartGiftItem']['message'] = $this->request->data['giftMessages'];     
                    }
                    else{
                        $data['CartItem']['product_entity_id'] = $entity['Entity']['id'];
                        $data['CartItem']['quantity'] = $this->request->data['product_quantity'];
                        if(isset($this->request->data['product_size'])){
                            $data['CartItem']['size_id'] = $this->request->data['product_size'];
                        }
                        else{
                            $data['CartItem']['size_id'] = 1;
                        }    
                    }
    
                    $cart = $Cart->getExistingUserCart($user_id);
                    if($cart){
                        $data['Cart'] = $cart['Cart'];
                        unset($data['Cart']['created']);
                        unset($data['Cart']['updated']);
                        $result = $Cart->save($data);
                        $cart_id = $result['Cart']['id'];
                        
                        $existing_item = $CartItem->getCartItemByCart($cart_id, $entity_id);
                        
                        if($existing_item && $data['CartItem']['size_id'] && $existing_item['CartItem']['size_id'] == $data['CartItem']['size_id'] && $existing_item['CartItem']['is_gift'] != 1){
                            $data['CartItem']['cart_id'] = $cart_id;
                            
                            $new_quantity = $data['CartItem']['quantity'];
                            $existing_item['CartItem']['quantity'] = intval($existing_item['CartItem']['quantity']) + $new_quantity;
                            
                            if($result = $CartItem->save($existing_item)){
                               
                                $ret['status'] = 'ok';    
                            }
                            else{
                                $ret['status'] = 'error';   
                            }
                        }
                        else{
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
                    
                    /**
                     * Check if item is a gift and add gift card details
                     */
                    if($ret['status'] == 'ok' && $entity['Entity']['is_gift']){
                        $data['CartGiftItem']['cart_item_id'] = $result['CartItem']['id'];
                        $CartGiftItem = ClassRegistry::init('CartGiftItem');
                        $CartGiftItem->create();
                        
                        $result = $CartGiftItem->save($data);     
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
                        $ret['cart_message'] = "Dear " . ucwords($user['User']['first_name']) . ",<br>We would like to remind you that you currently have three items in your cart, totaling $" . number_format($cart_total, 2) . ".";
                    }
                    
                    if($ret['status'] == "ok" && $ret['count'] != 3){
                        $this->Session->write('add-cart', 1);   
                    }
                    else if($ret['status'] == "ok" && $ret['count'] == 3){
                        $this->Session->write('cart-three-items', 1);    
                        $this->Session->write('cart-three-items-msg', $ret['cart_message']);
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
                    if($cur_item && $cur_item['CartItem']['is_gift'] != 1){
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
     * Request Price
     */
    public function requestprice($param = null) {

        //Configure::write('debug', 0);
        $this->autolayout = false;
        $this->autoRender = false;
        
        $ret = array();
        
        // init
        $Entity = ClassRegistry::init('Entity');
        $user_id = $this->getLoggedUserID();
        if ($this->request->is('ajax')) {
            $PriceRequest = ClassRegistry::init('PriceRequest');
            $User = ClassRegistry::init('User');
            $Size = ClassRegistry::init('Size');
            
            $sizes = $Size->find('list');
            
            // Get product Entity ID and Get the information for the entity
            $entity_id = $this->request->data['product_id'];
            $entity = $Entity->getById($entity_id);
            if($user_id){
                $user = $User->getByID($user_id);
            }
            else{
                $user = false;
            }
            
            //Prepare data array for adding cart information
            $data['PriceRequest']['product_entity_id'] = $entity['Entity']['id'];
            $data['PriceRequest']['quantity'] = $this->request->data['product_quantity'];
            
            if(isset($this->request->data['request_comment']) && $this->request->data['request_comment'] != ""){
                $data['PriceRequest']['comment'] = $this->request->data['request_comment'];
            }
            
            if(isset($this->request->data['product_size'])){
                $data['PriceRequest']['size_id'] = $this->request->data['product_size'];
            }
            else{
                $data['PriceRequest']['size_id'] = 1;
            }
            $data['PriceRequest']['size'] = $sizes[$data['PriceRequest']['size_id']];
            
            if($user_id){
                $data['PriceRequest']['request_email'] = $user['User']['email'];
                $request_name = $user['User']['first_name'];
            }
            else{
                $data['PriceRequest']['request_email'] = $this->request->data['request_email']; 
                $request_name = "Guest";   
            }
            
            $PriceRequest->create();
            if($PriceRequest->save($data)){
                try{
                    // $user_email = new CakeEmail('default');
                    // $user_email->from(array($data['PriceRequest']['request_email'] => $request_name));
                    // $user_email->to('admin@savilerowsociety.com');
                    // $user_email->subject('Savile Row Society: Product Price Request');
                    // $user_email->template('price_request');
                    // $user_email->emailFormat('html');
                    // $user_email->viewVars(array('entity' => $entity, 'data' => $data, 'user' => $user));
                    // $user_email->send();
                }
                catch(Exception $e){
                    
                }
                
                $ret['status'] = 'ok';    
            }
            else{
                $ret['status'] = 'error';
            }
        }
                
        echo json_encode($ret);
        exit;
    }
    
    
    /**
     * Similar Products
     */
    public function similar() {
        $this->autolayout = false;
        $this->autoRender = false;
        
        $user_id = $this->getLoggedUserID();
        $Category = ClassRegistry::init('Category');
        $Entity = ClassRegistry::init('Entity');
        $ret = array();
            
        $category_id = $this->request->data['categoryId'];
        $product_id = $this->request->data['productId'];
        
        if (!$Category->exists($category_id)) {
            $ret['status'] = 'no-rows';   
            echo json_encode($ret);
            exit; 
        }
        
        $category_children = $Category->children($category_id);
        $category_list = array();
        $category_list[] = $category_id;
        if($category_children){
            foreach($category_children as $child){
                $category_list[] = $child['Category']['id'];
            }
        }   
        
        $entity = $Entity->getSimilarProduct($category_list, $product_id, $user_id);
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
        $user_id = $this->getLoggedUserID();
        if($user_id){
            if($action != null && ($action == "hide" || $action == "show")){
                $User = ClassRegistry::init('User');
                $user = $User->getById($user_id); 
                if($action == "show"){
                    $user['User']['show_closet_popup'] = 1;
                }
                else{
                    $user['User']['show_closet_popup'] = 0;
                }
                $User->save($user);
                echo $action;
            }
        }
        exit;
    }

    /**
     * Refer Friend using email
     */
    public function referFriendEmail(){
        $emailList = $this->request->data['emailList'];
        $email_array = explode(',', $emailList);    
        $user = $this->getLoggedUser();
        $flag = 0;
        for($i=0; $i < count($email_array); $i++){
            if(Validation::email($email_array[$i])){
                try{
                    //send personal stylist mail
                    $bcc = Configure::read('Email.contact');
                    $email = new CakeEmail('default');
                    $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                    $email->to($email_array[$i]);
                    $email->bcc($bcc);
                    $email->subject("Discover Savile Row Society");
                    $email->template('refer');
                    $email->emailFormat('html');
                    $email->viewVars(compact('user'));
                    $email->send();
                    $flag = 1;
                }
                catch(Exception $e){
                    
                }    
            }
        } 
        if($flag){
            echo "success";
        }
        else{
            echo "fail";
        }
        exit;
    }
}