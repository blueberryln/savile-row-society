<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Messages Controller
 *
 * @property Message $Message
 */
class MessagesController extends AppController {
   

    public function beforeFilter(){
        $this->isLogged();
    }

    public function index($messages_for_user_id = null) {
        $User = ClassRegistry::init('User');
        
        //Get user from session to derterminate if user is stylist
        $user = $this->getLoggedUser();
        $user_id = $user["User"]["id"];
        $is_stylist = $user["User"]["is_stylist"];
        $is_admin = $user["User"]["is_admin"];
        $user = $User->findById($user_id);
        
        /**
         * Check for different conditions and redirect as required:
         * 1: Check if the user is neither stylist or admin and has not been assigned a stlist. Redirect to home if all conditons satisfy.
         * 2: Check if user is admin and no client has been selected to chat. Redirect to admin user listing page.
         * 3. 
         */
        if(!$is_admin && !$is_stylist && (is_null($user['User']['stylist_id']) || $user['User']['stylist_id'] == "" || !($user['User']['stylist_id'] > 0) )){
            $this->redirect('/');
        }
        else if($is_admin && is_null($messages_for_user_id)){
            $this->redirect('/admin/users');
        }    
        
         // make user_id, user
        $this->set(compact('user_id', 'user', 'messages_for_user_id'));
        //print_r($user);
        /**
         * Choose to show user/stylist or admin view
         */
        if ($is_stylist || $is_admin) {

            /**
             * Check if client has been selected to chat with and client user exists.
             */
            if($messages_for_user_id && $messages_for_user_id > 0){
                $client_user = $User->getByID($messages_for_user_id);
                if($client_user){
                    $client_id = $messages_for_user_id;

                    /**
                     *  - If client user is admin redirect to admin user landing
                     *  - If client user is stylist redirect to message landing
                     *  - If current user is stylist and client is not user's client, redirect to message landing
                     */  
                    if($client_user['User']['is_admin'] == 1){
                        $this->redirect('/admin/users');   
                    }
                    else if($client_user['User']['is_stylist'] == 1){
                        $this->redirect('/messages');   
                    }
                    else if ($is_stylist && $client_user['User']['stylist_id'] != $user_id){
                        $this->redirect('/messages');    
                    }  


                    /**
                     * Get data for the outfit
                     */
                    $Category = ClassRegistry::init('Category');
                    $categories = $Category->getAll();

                    $Brand = ClassRegistry::init('Brand');
                    $brands = $Brand->find('all', array('order' => "Brand.name ASC"));

                    $Colorgroup = ClassRegistry::init('Colorgroup');
                    $colors = $Colorgroup->find('all', array('order' => "Colorgroup.name ASC"));

                    $Order = ClassRegistry::init('Order');
                

                    //Get last purchase
                    $last_purchase = $Order->find('first', array(
                                        'conditions' => array('Order.user_id' => $client_id, 'Order.Paid' => true),
                                        'order' => 'Order.id DESC'
                                    ));
                    
                    //Get number of messages in last 30 days
                    $recent_messages = $this->Message->find('count', array(
                                            'conditions' => array('Message.created >= now() - INTERVAL 30 DAY', 'Message.user_from_id' => $client_id) 
                                        ));
                    
                    //Get total puchase of last 30 days
                    $recent_purchase = $Order->find('first', array(
                                        'conditions' => array('Order.user_id' => $client_id, 'Order.Paid' => true, 'Order.created >= now() - INTERVAL 30 DAY'),
                                        'fields' => array('COALESCE(sum(Order.total_price),0) as recent_purchase'),
                                    ));
                    $recent_purchase = $recent_purchase[0]['recent_purchase'];
                                        
                    $this->set(compact('last_purchase', 'recent_messages', 'recent_purchase'));

                }

                else if($is_stylist){
                    $this->redirect('/messages');    
                }

                else if($is_admin){
                    $this->redirect('/admin/users');    
                }
            }


            //If stylist get the list of current and new users
            if($is_stylist){
                $clients = array();   
                $clients_data = $User->getUserWriteToMe($this->getLoggedUserID());
                foreach ($clients_data as $client) {
                    $clients[$client['User']['id']] = (strlen($client['User']['full_name']) < 30) ? $client['User']['full_name'] : substr($client['User']['full_name'], 0, 30) . "...";
                }

                $new_clients = $User->getNewClients($user_id);
                $this->set(compact('new_clients'));
            } 


            if($messages_for_user_id && $messages_for_user_id > 0){
                $this->set(compact('clients', 'brands', 'colors', 'categories', 'client_user', 'client_id', 'is_admin'));
                $this->render("stylist");
            }
            else if($is_stylist){
                $notification_data = $User->getStylistUserNotification($user_id);
                $this->set(compact('clients', 'notification_data', 'is_admin'));
                $this->render("clients");    
            }
        } 
        //User viewVars
        else {
            $stylist_id = $user['User']['stylist_id'];
            $client_user = $User->getByID($stylist_id);
            if(!$client_user){
                $stylist_id = $this->updateMissingStylist($user['User']['id']);
                $client_user = $User->getByID($stylist_id);
            }
            $this->set(compact('client_user'));
            $this->render("user");
        }
    }


    /**
     * Outfit page
     */
    public function detail($id){
        $User = ClassRegistry::init('User');
        //Get user from session to derterminate if user is stylist
        $user = $this->getLoggedUser();
        $user_id = $user["User"]["id"]; 
        $is_admin = $user["User"]["is_admin"];
        $is_stylist = $user["User"]["is_stylist"];   

        $msg = $this->Message->findById($id);

        //If invalid message id or message is not an outfit, redirect to index.
        if(!$msg || !$msg['Message']['is_outfit']){
            $this->redirect('/messages/index');
        }

        if($msg['Message']['user_from_id'] == $user_id || $msg['Message']['user_to_id'] == $user_id || $is_admin){
            $outfit_id = $msg['Message']['outfit_id'];

            //Check if outfit exists else show page not found.
            $Outfit = ClassRegistry::init('Outfit');
            if(!$Outfit->exists($outfit_id)){
                $this->redirect('/messages/index');
            }

            //Get all the products present in the outfit.
            $OutfitItem = ClassRegistry::init('OutfitItem');
            $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $outfit_id)));
            $entity_list = array();
            foreach($outfit as $value){
                $entity_list[] = $value['OutfitItem']['product_entity_id'];
            }

            $Entity = ClassRegistry::init('Entity');

            // get data
            $entity = $Entity->getMultipleById($entity_list, $user_id);
            $products_list = array();
            foreach ($entity as $key => $value) {
                $products_list[] = $value['Entity']['product_id'];
            }
        
            $similar_results = $Entity->getSimilarProducts($outfit_id, $products_list);
            $similar = array();
            foreach($similar_results as $row){
                if($row['Color'] && count($row['Color']) > 0){
                    $similar[$row['Entity']['product_id']][] = $row; 
                }
            }

            $entities = array();

            foreach ($entity as $key => $value) {
                $entities[$value['Entity']['id']] = $value;
                if(isset($similar[$value['Entity']['product_id']])){
                    $entities[$value['Entity']['id']]['Similar'] = $similar[$value['Entity']['product_id']];
                }
            }

            //Get other users data
            if($user_id == $msg['Message']['user_from_id']){
                $second_user_id = $msg['Message']['user_to_id'];
            }
            else{
                $second_user_id = $msg['Message']['user_from_id'];    
            }

            $second_user = $User->findById($second_user_id);

            $Size = ClassRegistry::init('Size');
            $size_list = $Size->find('list');
            

            $show_add_cart_popup = 0;
            if($this->Session->read('add-cart')){
                $show_add_cart_popup = 1;
                $this->Session->delete('add-cart');
            }

            $popUpMsg = '';
            $show_three_item_popup = 0;
            if($this->Session->read('cart-three-items')){
                $show_three_item_popup = 1;
                $popUpMsg = $this->Session->read('cart-three-items-msg');
                $this->Session->delete('cart-three-items');
                $this->Session->delete('cart-three-items-msg');
            }

            $this->set(compact('entities', 'size_list', 'user_id', 'msg', 'second_user', 'second_user_id', 'is_admin', 'is_stylist', 'show_add_cart_popup','show_three_item_popup', 'popUpMsg'));
            
        }
        else{
            $this->redirect('/messages/index');
        }

    }



    /**
     * Assign stylist to a user who has a unknown stylist.
     * Return stylist id.
     */
    function updateMissingStylist($user_id){
        App::import('Controller', 'Users');
        $Users = new UsersController;
        $stylist_id = $Users->assign_refer_stylist($user_id);

        return $stylist_id;
    }


    /**
     * Send first message to the user when he/she is assigned the stylist.
     */
    public function send_welcome_message($user_id, $stylist_id){
        $this->autoLayout = false;
        $this->autoRender = false;
        $User = ClassRegistry::init('User');
        
        $user = $User->getById($user_id);

        if($user && $stylist_id){
            $this->Message->create();    

            $stylist = $User->getById($stylist_id);
            $body = "Hi " . ucwords($user['User']['first_name']) . ",

                    Thank you for registering with Savile Row Society. My name is " . ucwords($stylist['User']['first_name']) . " and I will be your personal stylist. Feel free to ask me any questions about our services and products, and I will get back to you shortly. In the meantime, you can browse the samples from our collection that we are currently featuring in The Closet. 
If interested, I would also be happy to meet with you in our New York City based showroom.
                    
                    Welcome to Savile Row Society!";

            $this->Message->data['Message']['user_from_id'] = $stylist_id;
            $this->Message->data['Message']['user_to_id'] = $user_id;
            $this->Message->data['Message']['body'] = $body;

            if ($this->Message->validates($this->Message->data)) {
                // store in db
                $res = $this->Message->save($this->Message->data);

                // Prepare data for email notification
                $notification['is_photo'] = false;
                $notification['to_stylist'] = false;
                $notification['message'] = $res['Message']['body'];
                $notification['to_name'] = $user['User']['first_name'];
                $notification['from_name'] = $stylist['User']['first_name']; 
                $notification['to_email'] = $user['User']['email'];
                // $notification['from_email'] = Configure::read('Email.admin'); 
                $notification['from_email'] = $stylist['User']['email']; 

                $this->sendEmailNotification($notification, $user);    
            }
        }    
    }


    /**
     * Only available when logged user is not stylist
     */
    public function send_message_to_stylist() {
        $User = ClassRegistry::init('User');
        $posts = ClassRegistry::init('Post');
        //bhashit code
        $userid = $User->getByID($this->getLoggedUserID());
        $sty_id = $userid['User']['stylist_id'];
        $this->request->data['Post']['user_id'] = $this->getLoggedUserID();
        $this->request->data['Post']['is_message'] = '1';
        $this->request->data['Post']['stylist_id'] = $sty_id;
        $posts->save($this->request->data);
        $post_id = $posts->getLastInsertID();
        //bhashitcode end

        $this->Message->create();

        // get stylist ID
        //bhashit code
        $user = $User->getByID($this->getLoggedUserID());
        $s_id = $user["User"]["stylist_id"];
        $this->Message->data['Message']['post_id'] = $post_id;
        //bhashit code
        $this->Message->data['Message']['user_to_id'] = $s_id;
        $this->Message->data['Message']['user_from_id'] = $this->getLoggedUserID();
        $this->Message->data['Message']['body'] = $this->request->data('body');

        // validate message
        if ($this->Message->validates()) {
            // store in db
            $res = $this->Message->save($this->Message->data);
            $msg['status'] = 'ok';            
            $msg['Message'] = $res['Message'];
            $timestamp = strtotime($msg['Message']['created']);
            $msg['Message']['created']  = date('Y-m-d H:i:s', strtotime('-286 minutes', $timestamp));
            $msg['Message']['body'] = nl2br($msg['Message']['body']);
            $msg['UserFrom'] = array(
                                    'id' => $user['User']['id'],
                                    'first_name' => $user['User']['first_name'],
                                    'last_name' => $user['User']['last_name']
                                );
            $this->set('data', $msg);
        }
        
        // Prepare data for email notification
        $to_user = $User->getById($msg['Message']['user_to_id']);
        $from_user = $User->getById($msg['Message']['user_from_id']);
        
        $notification['is_photo'] = false;
        $notification['to_stylist'] = true;
        $notification['client_id'] = $msg['Message']['user_from_id'];
        $notification['message'] = nl2br($res['Message']['body']);
        $notification['to_name'] = $to_user['User']['first_name'];
        $notification['from_name'] = $from_user['User']['first_name'];
        $notification['to_email'] = $to_user['User']['email'];
        $notification['from_email'] = Configure::read('Email.admin'); 
        
        $this->sendEmailNotification($notification);

        $this->render('/Elements/SerializeJson/');
    }
    
    /**
     * Action to allow user to send photo to the stylist
     */
    public function sendPhoto(){
        $this->autoLayout = false;
            
        if($this->request->is('post') || $this->request->is('put')){
            $Image = ClassRegistry::init('Image');
            
            $img = null;
            $img_type = '';
            $img_size = '';
            // file upload
            if ($this->request->data['Message']['Image']['name'] && $this->request->data['Message']['Image']['size'] > 0) {
                $allowed = array('image/jpeg', 'image/gif', 'image/png', 'image/x-png', 'image/x-citrix-png', 'image/x-citrix-jpeg', 'image/pjpeg');
                $data_image = $this->request->data['Message']['Image'];
                
                if (!in_array($data_image['type'], $allowed)) {
                    $this->Session->setFlash(__('You have to upload an image.'), 'flash');
                } else if ($data_image['size'] > 5242880) {
                    $this->Session->setFlash(__('Attached image must be up to 5 MB in size.'), 'flash');
                } else {
                    $rand = substr(uniqid ('', true), -7);
                    $img = $rand . '_' . $data_image['name'];
                    $img_type = $data_image['type'];
                    $img_size = $data_image['size'];
                    move_uploaded_file($data_image['tmp_name'], APP . DS . 'webroot' . DS . 'files' . DS . 'chat' . DS . $img);
                }
                
                // save image
                if ($img) {
                    $User = ClassRegistry::init('User');
            
                    // get stylist ID
                    $user = $User->getByID($this->getLoggedUserID());
                    $s_id = $user["User"]["stylist_id"];
                    
                    $data = array();
                    $data['Message']['user_to_id'] = $s_id;
                    $data['Message']['user_from_id'] = $user['User']['id'];
                    $data['Message']['body'] = "user image";
                    $data['Message']['image'] = $img;

                    $this->Message->create();
                    if ($this->Message->validates($data)) {
                        $res = $this->Message->save($data);
                        
                        // Prepare data for email notification
                        $to_user = $User->getById($res['Message']['user_to_id']);
                        $from_user = $User->getById($res['Message']['user_from_id']);
                        
                        $notification['is_photo'] = true;
                        $notification['to_stylist'] = true;
                        $notification['client_id'] = $res['Message']['user_from_id'];
                        $notification['photo_url'] = $res['Message']['image'];
                        $notification['to_name'] = $to_user['User']['first_name'];
                        $notification['from_name'] = $from_user['User']['first_name']; 
                        $notification['to_email'] = $to_user['User']['email'];
                        $notification['from_email'] = Configure::read('Email.admin');
                        
                        $this->sendEmailNotification($notification);
                    }
                }
            }
        }
        $this->redirect('index');    
    }


    /**
     * Action to allow stylist to send photo to the user
     */
    public function sendPhotoToUser($id){
        $this->autoLayout = false;
            
        if($this->request->is('post') || $this->request->is('put')){
            $Image = ClassRegistry::init('Image');
            
            $img = null;
            $img_type = '';
            $img_size = '';
            // file upload
            if ($this->request->data['Message']['Image']['name'] && $this->request->data['Message']['Image']['size'] > 0) {
                $allowed = array('image/jpeg', 'image/gif', 'image/png', 'image/x-png', 'image/x-citrix-png', 'image/x-citrix-jpeg', 'image/pjpeg');
                $data_image = $this->request->data['Message']['Image'];
                
                if (!in_array($data_image['type'], $allowed)) {
                    $this->Session->setFlash(__('You have to upload an image.'), 'flash');
                } else if ($data_image['size'] > 5242880) {
                    $this->Session->setFlash(__('Attached image must be up to 5 MB in size.'), 'flash');
                } else {
                    $rand = substr(uniqid ('', true), -7);
                    $img = $rand . '_' . $data_image['name'];
                    $img_type = $data_image['type'];
                    $img_size = $data_image['size'];
                    move_uploaded_file($data_image['tmp_name'], APP . DS . 'webroot' . DS . 'files' . DS . 'chat' . DS . $img);
                }
                
                // save image
                if ($img) {
                    $User = ClassRegistry::init('User');
            
                    // get stylist ID
                    $user = $User->getByID($this->getLoggedUserID());
                    $client_id = $id;
                    $client = $User->getByID($client_id);

                    if(!$client || $client['User']['stylist_id'] != $user['User']['id']){
                        $this->redirect('index');
                        exit;
                    }
                    
                    $data = array();
                    $data['Message']['user_to_id'] = $client_id;
                    $data['Message']['user_from_id'] = $user['User']['id'];
                    $data['Message']['body'] = "user image";
                    $data['Message']['image'] = $img;

                    $this->Message->create();
                    if ($this->Message->validates($data)) {
                        $res = $this->Message->save($data);
                        
                        // Prepare data for email notification
                        $to_user = $User->getById($res['Message']['user_to_id']);
                        $from_user = $User->getById($res['Message']['user_from_id']);
                        
                        $notification['is_photo'] = true;
                        $notification['to_stylist'] = false;
                        $notification['photo_url'] = $res['Message']['image'];
                        $notification['to_name'] = $to_user['User']['first_name'];
                        $notification['from_name'] = $from_user['User']['first_name']; 
                        $notification['to_email'] = $to_user['User']['email'];
                        $notification['from_email'] = $from_user['User']['email']; 
                        
                        $this->sendEmailNotification($notification);
                    }
                }
            }
        }
        $this->redirect('index/' . $id);    
    }


    /**
     * Send message from stylist to user
     */
    public function send_to_user() {

        $User = ClassRegistry::init('User');

        
        $this->Message->create();

        //debug($this->request->data);
        $user = $User->getByID($this->getLoggedUserID());
        $body = $this->request->data('body');
        $to_id = $this->request->data('user_to_id');
        
        $this->Message->data['Message']['user_from_id'] = $this->getLoggedUserID();
        $this->Message->data['Message']['user_to_id'] = $to_id;
        $this->Message->data['Message']['body'] = $body;
        
        if($to_id > 0){
            if ($this->Message->validates()) {
                // store in db
                $res = $this->Message->save($this->Message->data);

                $msg['status'] = 'ok';            
                $msg['Message'] = $res['Message'];
                $timestamp = strtotime($msg['Message']['created']);
                $msg['Message']['created']  = date('Y-m-d H:i:s', strtotime('-286 minutes', $timestamp));
                $msg['Message']['body'] = nl2br($msg['Message']['body']);
                $msg['UserFrom'] = array(
                                        'id' => $user['User']['id'],
                                        'first_name' => $user['User']['first_name'],
                                        'last_name' => $user['User']['last_name']
                                    );
                $this->set('data', $msg);
                
            }
            
            // Prepare data for email notification
            $to_user = $User->getById($msg['Message']['user_to_id']);
            $from_user = $User->getById($msg['Message']['user_from_id']);

            if($to_user['User']['stylist_notification']){
                $User->disableStylistNotification($to_id);
            }
            
            $notification['is_photo'] = false;
            $notification['to_stylist'] = false;
            $notification['message'] = nl2br($res['Message']['body']);
            $notification['to_name'] = $to_user['User']['first_name'];
            $notification['from_name'] = $from_user['User']['first_name']; 
            $notification['to_email'] = $to_user['User']['email'];
            $notification['from_email'] = $from_user['User']['email'];  
            
            $this->sendEmailNotification($notification);
            
            $this->render('/Elements/SerializeJson/');
        }
        else{
            $msg['status'] = 'error';
            $this->set('data', $msg);
            $this->render('/Elements/SerializeJson/');
        }
    }


    /**
     * Get initial message list
     */
    public function getMyConversation($with_user_id = null) {
        // get converzation for logged in user.

        $result = array();
        if ($this->getLoggedUser()){
            $user_id = $this->getLoggedUserID();
            if($with_user_id){
                // if with user id is not null load data for stylist
                $User = ClassRegistry::init('User');
                $user = $User->getById($with_user_id);

                if($user){
                    $result['User'] = array('full_name' => $user['User']['full_name'], 'profile_photo_url'=>$user['User']['profile_photo_url']);
                    $my_conversation = $this->Message->getMyConversationWith($with_user_id);
                    foreach($my_conversation as &$row){
                        if($row['Message']['is_outfit'] == 1 && $row['Message']['outfit_id'] > 0){
                            $outfit_id = $row['Message']['outfit_id'];
                            
                            $OutfitItem = ClassRegistry::init('OutfitItem');
                            $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $outfit_id)));
                            $entities = array();
                            foreach($outfit as $value){
                                $entities[] = $value['OutfitItem']['product_entity_id'];
                            }
                            $Entity = ClassRegistry::init('Entity');
                            $entity_list = $Entity->getProductDetails($entities);
                            $row['Outfit'] = $entity_list;
                        }
                    }
                    $result['Messages'] = $my_conversation;
                }
                else{
                    $result['status'] = 'error';    
                    $this->set('data', $result);
                    $this->render('/Elements/SerializeJson/');
                }
            }
            else{
                // load data for user
                $my_conversation = $this->Message->getMyConversation($user_id);
                foreach($my_conversation as &$row){
                    if($row['Message']['is_outfit'] == 1 && $row['Message']['outfit_id'] > 0){
                        $outfit_id = $row['Message']['outfit_id'];
                        
                        $OutfitItem = ClassRegistry::init('OutfitItem');
                        $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $outfit_id)));
                        $entities = array();
                        foreach($outfit as $value){
                            $entities[] = $value['OutfitItem']['product_entity_id'];
                        }
                        $Entity = ClassRegistry::init('Entity');
                        $entity_list = $Entity->getProductDetails($entities);
                        $row['Outfit'] = $entity_list;
                    }
                }
                $result['Messages'] = $my_conversation;
            }
            
            //Get a list of message ids and mark them read if not already read
            $mark_read_list = array();
            $last_conv_id = 0;
            if($my_conversation){
                $mark_read_list = array();
                foreach($result['Messages'] as &$msg){
                    $timestamp = strtotime($msg['Message']['created']);
                    $msg['Message']['created']  = date('Y-m-d H:i:s', strtotime('-286 minutes', $timestamp));
                    $msg['Message']['body'] = nl2br($msg['Message']['body']);
                    if($msg['Message']['is_read'] == 0 && ($msg['Message']['user_to_id'] == $user_id)){
                        $mark_read_list[] = array('id' => $msg['Message']['id'], 'is_read' => 1);         
                    }
                    $last_conv_id = $msg['Message']['id'];
                }
                if(count($mark_read_list) > 0){
                    $this->Message->saveAll($mark_read_list);
                }
            
                $msgs_remaining = $this->Message->getMessageCount($last_conv_id, $user_id);
                
                $result['msg_remaining'] = $msgs_remaining;
                $result['status'] = 'ok';
            }
            else{
                
            }
            
            $result['status'] = 'ok';
        }
        else{
            $result = array();
            $result['status'] = 'error';
        }
        
        $this->set('data', $result);
        $this->render('/Elements/SerializeJson/');
    }
    

    /*
     * Get new messages
     */
    public function getNewMessages($with_user_id = null){
        if(!$this->request->is('ajax')){
            $this->redirect('/');
        }
        $result = array();
        $user_id = $this->getLoggedUserID();
        if ($user_id){
            if($with_user_id){
                // if with user id is not null load data for stylist
                $User = ClassRegistry::init('User');
                $user = $User->getById($with_user_id);

                if($user){
                    $result['User'] = array('full_name' => $user['User']['full_name'], 'profile_photo_url'=>$user['User']['profile_photo_url']);
                    $my_conversation = $this->Message->getUnreadMessagesWith($with_user_id);
                    if($my_conversation){
                        foreach($my_conversation as &$row){
                            if($row['Message']['is_outfit'] == 1 && $row['Message']['outfit_id'] > 0){
                                $outfit_id = $row['Message']['outfit_id'];
                                
                                $OutfitItem = ClassRegistry::init('OutfitItem');
                                $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $outfit_id)));
                                $entities = array();
                                foreach($outfit as $value){
                                    $entities[] = $value['OutfitItem']['product_entity_id'];
                                }
                                $Entity = ClassRegistry::init('Entity');
                                $entity_list = $Entity->getProductDetails($entities);
                                $row['Outfit'] = $entity_list;
                            }
                        }
                        $result['Messages'] = $my_conversation;
                    }
                }
                else{
                    $result['status'] = 'error';    
                    $this->set('data', $result);
                    $this->render('/Elements/SerializeJson/');
                }
            }
            else{
                // load data for user
                $my_conversation = $this->Message->getUnreadMessages($user_id);
                foreach($my_conversation as &$row){
                    if($row['Message']['is_outfit'] == 1 && $row['Message']['outfit_id'] > 0){
                        $outfit_id = $row['Message']['outfit_id'];
                        
                        $OutfitItem = ClassRegistry::init('OutfitItem');
                        $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $outfit_id)));
                        $entities = array();
                        foreach($outfit as $value){
                            $entities[] = $value['OutfitItem']['product_entity_id'];
                        }
                        $Entity = ClassRegistry::init('Entity');
                        $entity_list = $Entity->getProductDetails($entities);
                        $row['Outfit'] = $entity_list;
                    }
                }
                $result['Messages'] = $my_conversation;
            }
            
            //Get a list of message ids and mark them read if not already read
            $mark_read_list = array();
            if($my_conversation){
                foreach($result['Messages'] as &$msg){
                    $timestamp = strtotime($msg['Message']['created']);
                    $msg['Message']['created']  = date('Y-m-d H:i:s', strtotime('-286 minutes', $timestamp));
                    $msg['Message']['body'] = nl2br($msg['Message']['body']);
                    if($msg['Message']['is_read'] == 0 && ($msg['Message']['user_to_id'] == $user_id)){
                        $mark_read_list[] = array('id' => $msg['Message']['id'], 'is_read' => 1);         
                    }
                }
                if(count($mark_read_list) > 0){
                    $this->Message->saveAll($mark_read_list);
                }
                
                $result['status'] = 'ok';
            }
            else{
                $result['status'] = 'error';    
            }
        }
        else{
            $result = array();
            $result['status'] = 'error';
        }
        $this->set('data', $result);
        $this->render('/Elements/SerializeJson/');    
    }
    

    /*
     * Get old messages
     */
    public function getOldMessages($with_user_id = null){
        
        $result = array();
        $last_msg_id = $this->request->data['last_msg_id'];
        if ($last_msg_id >= 0 && $this->getLoggedUser()){
            $user_id = $this->getLoggedUserID();
   
            if($with_user_id){
                if($last_msg_id == 0){
                    $last_msg_data = $this->Message->getLastUserMessage($with_user_id);
                    if($last_msg_data){
                        $last_msg_id = $last_msg_data['Message']['id'] + 1;
                    }
                    else{
                        $result['status'] = 'error';  
                        $this->set('data', $result);
                        $this->render('/Elements/SerializeJson/');
                    }
                }
                // if with user id is not null load data for stylist
                $User = ClassRegistry::init('User');
                $user = $User->getById($with_user_id);

                if($user){
                    $result['User'] = array('full_name' => $user['User']['full_name'], 'profile_photo_url'=>$user['User']['profile_photo_url']);
                    $my_conversation = $this->Message->getOldMessagesWith($last_msg_id, $with_user_id);
                    $msg_count = count($my_conversation);
                    $result['msg_count'] = $msg_count;
                    foreach($my_conversation as &$row){
                        if($row['Message']['is_outfit'] == 1 && $row['Message']['outfit_id'] > 0){
                            $outfit_id = $row['Message']['outfit_id'];
                            
                            $OutfitItem = ClassRegistry::init('OutfitItem');
                            $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $outfit_id)));
                            $entities = array();
                            foreach($outfit as $value){
                                $entities[] = $value['OutfitItem']['product_entity_id'];
                            }
                            $Entity = ClassRegistry::init('Entity');
                            $entity_list = $Entity->getProductDetails($entities);
                            $row['Outfit'] = $entity_list;
                        }
                    }
                    $result['Messages'] = $my_conversation;
                }
                else{
                    $result['status'] = 'error';    
                    $this->set('data', $result);
                    $this->render('/Elements/SerializeJson/');
                }
            }
            else{
                if($last_msg_id == 0){
                    $last_msg_data = $this->Message->getLastUserMessage($user_id);
                    $last_msg_id = $last_msg_data['Message']['id'] + 1;
                }
                
                $result['last_msg'] = $last_msg_id;
                
                // load data for user
                $my_conversation = $this->Message->getOldMessages($last_msg_id, $user_id);
                $msg_count = count($my_conversation);
                $result['msg_count'] = $msg_count;
                if($msg_count > 0){
                    foreach($my_conversation as &$row){
                        if($row['Message']['is_outfit'] == 1 && $row['Message']['outfit_id'] > 0){
                            $outfit_id = $row['Message']['outfit_id'];
                            
                            $OutfitItem = ClassRegistry::init('OutfitItem');
                            $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $outfit_id)));
                            $entities = array();
                            foreach($outfit as $value){
                                $entities[] = $value['OutfitItem']['product_entity_id'];
                            }
                            $Entity = ClassRegistry::init('Entity');
                            $entity_list = $Entity->getProductDetails($entities);
                            $row['Outfit'] = $entity_list;
                        }
                    }
                    $result['Messages'] = $my_conversation;
                }
            }
            
            $mark_read_list = array();
            $last_conv_id = 0;
            if($my_conversation){
                foreach($result['Messages'] as &$msg){
                    $timestamp = strtotime($msg['Message']['created']);
                    $msg['Message']['created']  = date('Y-m-d H:i:s', strtotime('-286 minutes', $timestamp));
                    $msg['Message']['body'] = nl2br($msg['Message']['body']);
                    if($msg['Message']['is_read'] == 0 && ($msg['Message']['user_to_id'] == $user_id)){
                        $mark_read_list[] = array('id' => $msg['Message']['id'], 'is_read' => 1);         
                    }
                    $last_conv_id = $msg['Message']['id'];
                }
                if(count($mark_read_list) > 0){
                    $this->Message->saveAll($mark_read_list);
                }
                
                $msgs_remaining = $this->Message->getMessageCount($last_conv_id, $user_id);
                
                $result['msg_remaining'] = $msgs_remaining;
                $result['status'] = 'ok';
            }
            else{
                $result['status'] = 'error';    
            }
        }
        else{
            $result = array();
            $result['status'] = 'error';
        }
        $this->set('data', $result);
        $this->render('/Elements/SerializeJson/');    
    }

    
    function sendEmailNotification($notification){
        extract($notification);
        try{
            $email = new CakeEmail('default');
            $email->to($to_email);
            $email->template('message_notification');
            $email->emailFormat('html');
            
            if($to_stylist){
                $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                $email->subject('You Have A New Message!');
                if($is_photo){
                    $email->viewVars(compact('to_name','from_name','photo_url','to_stylist','is_photo', 'client_id'));
                }
                else{
                    $email->viewVars(compact('to_name','from_name', 'message', 'to_stylist','is_photo','photo_url', 'client_id'));    
                } 
            }  
            else{
                $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                $email->replyTo(array($from_email => 'Savile Row Society'));
                $email->subject('You Have A New Message!');
                if($is_photo){
                    $email->viewVars(compact('to_name','from_name','photo_url','to_stylist','is_photo'));
                }
                else{
                    $email->viewVars(compact('to_name','from_name','message','to_stylist','is_photo'));
                }
            }
            
            $email->send();
        }
        catch(Exception $e){
            
        } 
    }



    //bhashit code
    //perticular user outfit list sent by his stylist
    // public function getuseroutfit($client_id = null) {

    //     $User = ClassRegistry::init('User');
        
    //     //Get user from session to derterminate if user is stylist
    //     $user = $this->getLoggedUser();
    //     $user_id = $user["User"]["id"]; 
    //     $is_admin = $user["User"]["is_admin"];
    //     $is_stylist = $user["User"]["is_stylist"];   
    //     $user = $User->getById($client_id);
    //     //print_r($user);
    //     $Message = ClassRegistry::init('Message');
    //     if($user){
    //                     $my_conversation = $this->Message->getMyConversationWith($client_id);
    //                     $my_outfit = array();
    //                     foreach($my_conversation as &$row){
    //                         if($row['Message']['is_outfit'] == 1 && $row['Message']['outfit_id'] > 0){
    //                             $outfit_id = $row['Message']['outfit_id'];
    //                             $msg = $Message->find('first',array('conditions'=>array('Message.outfit_id'=>$outfit_id,)));
    //                             print_r($msg);
    //                             $Outfit = ClassRegistry::init('Outfit');
    //                             $outfitnames = $Outfit->find('first', array('conditions'=> array('Outfit.id'=>$outfit_id)));
    //                             $OutfitItem = ClassRegistry::init('OutfitItem');
    //                             $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $outfit_id)));
    //                             $entities = array();
    //                             foreach($outfit as $value){
    //                                  $entities[] = $value['OutfitItem']['product_entity_id'];
                                
    //                             }
    //                             $Entity = ClassRegistry::init('Entity');

    //                             $entity_list = $Entity->getMultipleById($entities);
                                
    //                             $my_outfit[] = array(
    //                                 'outfit'    => $outfitnames,
    //                                 'msg' =>$msg,
    //                                 'entities'  => $entity_list
    //                                 );
                                
    //                         }
    //                     }
    //               }
    //             print_r($my_outfit);
    //             die();
                    
    // }



    //perticular user outfit list sent by his stylist
    public function usersoutfits($client_id = null) {

        $User = ClassRegistry::init('User');
        
        //Get user from session to derterminate if user is stylist
        $user = $this->getLoggedUser();
        $user_id = $user["User"]["id"]; 
        $is_admin = $user["User"]["is_admin"];
        $is_stylist = $user["User"]["is_stylist"];   
        $user = $User->getById($client_id);
        $find_array = array(
                'fields' => array('User.*,User1.*'),
                'joins' => array(
                array(
                    'conditions' => array(
                        'User.id = User1.stylist_id',
                        'User1.id'=>$user_id,
                    ),
                    'table' => 'users',
                    'alias' => 'User1',
                    'type' => 'INNER',
                ),
                ),
            );
                

        $Userdata=$User->find('all',$find_array);
        //echo $sorting;
        //print_r($user);
        $Message = ClassRegistry::init('Message');
        
        if($user){

                        $my_conversation = $this->Message->getMyConversationWithStylist($client_id);
                        $my_outfits = array();
                        foreach($my_conversation as $row){
                            if($row['Message']['is_outfit'] == 1 && $row['Message']['outfit_id'] > 0){
                                $outfit_id = $row['Message']['outfit_id'];
                                $comments = $row['Message']['body'];
                                $Outfit = ClassRegistry::init('Outfit');
                                $outfitnames = $Outfit->find('all', array('conditions'=> array('Outfit.id'=>$outfit_id)));
                                $OutfitItem = ClassRegistry::init('OutfitItem');
                                $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $outfit_id),));
                                //print_r($outfit);
                                $entities = array();
                                foreach($outfit as $value){
                                     $entities[] = $value['OutfitItem']['product_entity_id'];
                                
                                }
                                $Entity = ClassRegistry::init('Entity');

                                $entity_list = $Entity->getMultipleByIdUser($entities);
                                
                                $my_outfits[] = array(
                                    'outfit'    => $outfitnames,
                                    'comments' =>$comments,
                                    'entities'  => $entity_list
                                    );
                                
                            }
                        }
                    }
                    //print_r($Userdata);
       
                    //die;
        $this->set(compact('my_outfits','user_id','Userdata'));
        // json_encode($my_outfits);

    }


    // outfits sorting 

    public function usersoutfitssorting($client_id = null) {

        $User = ClassRegistry::init('User');
        
        //Get user from session to derterminate if user is stylist
        $user = $this->getLoggedUser();
        $user_id = $user["User"]["id"]; 
        $is_admin = $user["User"]["is_admin"];
        $is_stylist = $user["User"]["is_stylist"];   
        $user = $User->getById($client_id);
        
        //echo $sorting;
        //print_r($user);
        $Message = ClassRegistry::init('Message');
        //$sorting = $this->->data['sorting'];
        if($this->request->is('post')){
           $sorting =  $this->request->data['sorting'];
        } else{
            $sorting = 'DESC';
        }
        if($user){

                        $my_conversation = $this->Message->getMyConversationWithStylistSorting($client_id,$sorting);
                        //print_r($my_conversation);
                        //die;
                        $my_outfits = array();
                        foreach($my_conversation as $row){
                            if($row['Message']['is_outfit'] == 1 && $row['Message']['outfit_id'] > 0){
                                $outfit_id = $row['Message']['outfit_id'];
                                $comments = $row['Message']['body'];
                                $Outfit = ClassRegistry::init('Outfit');
                                $outfitnames = $Outfit->find('all', array('conditions'=> array('Outfit.id'=>$outfit_id)));
                                $OutfitItem = ClassRegistry::init('OutfitItem');
                                $outfit = $OutfitItem->find('all',array('conditions'=>array('OutfitItem.outfit_id' => $outfit_id,)));
                                // $outfit = $OutfitItem->find('all', 
                                //     array(
                                //         'conditions'=>array('OutfitItem.outfit_id' => $outfit_id),
                                //         'order'=> array('OutfitItem.created'=> $sorting,),
                                //         ));

                                //print_r($outfit);
                                $entities = array();
                                foreach($outfit as $value){
                                     $entities[] = $value['OutfitItem']['product_entity_id'];
                                
                                }
                                $Entity = ClassRegistry::init('Entity');

                                $entity_list = $Entity->getMultipleByIdUser($entities);
                                
                                $my_outfits[] = array(
                                    'outfit'    => $outfitnames,
                                    'comments' =>$comments,
                                    'entities'  => $entity_list
                                    );
                                
                            }
                        }
                    }
                    //print_r($my_outfits);
       
                    //die;
        //$this->set(compact('my_outfits','user_id'));
        echo json_encode($my_outfits);

    }

    // perticular stylist total outfit list

    public function getstylistoutfit($user_id = null){

        $User = ClassRegistry::init('User');
        
        //Get user from session to derterminate if user is stylist
        $user = $this->getLoggedUser();
        $user_id = $user["User"]["id"]; 
        $is_admin = $user["User"]["is_admin"];
        $is_stylist = $user["User"]["is_stylist"];   
        $Message = ClassRegistry::init('Message');
        $Outfit = ClassRegistry::init('Outfit');
        $posts = ClassRegistry::init('Post');
        
        $userlist = $User->find('all', array('conditions'=>array('User.stylist_id'=>$user_id,)));

        $my_outfit = array();
        $stylistoutfit= $Outfit->find('all', array('conditions'=>array('Outfit.stylist_id'=>$user_id,)));
        foreach($stylistoutfit as $row){
            $stylist_outfit_id = $row['Outfit']['id'];
            $Outfit = ClassRegistry::init('Outfit');
            $outfitnames = $Outfit->find('first', array('conditions'=> array('Outfit.id'=>$stylist_outfit_id)));
            $OutfitItem = ClassRegistry::init('OutfitItem');
            $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $stylist_outfit_id)));
            $entities = array();
            foreach($outfit as $value){
                    $entities[] = $value['OutfitItem']['product_entity_id'];
                }
            $Entity = ClassRegistry::init('Entity');
            $entity_list = $Entity->getMultipleById($entities);
            $my_outfit[] =  array(
                                'outfit'    => $outfitnames,
                                //'username' => $userlist,
                                'entities'  => $entity_list
                            );

        }
        
        $this->set(compact('my_outfit','userlist','user_id'));
    
    } 

    //perticular user notes

    public function getusernotes($client_id = null){
        $User = ClassRegistry::init('User');
        $Stylistnote = ClassRegistry::init('Stylistnote');
        //Get user from session to derterminate if user is stylist
        $user = $this->getLoggedUser();
        $user_id = $user["User"]["id"]; 
        $is_admin = $user["User"]["is_admin"];
        $is_stylist = $user["User"]["is_stylist"];  

        if($this->request->is('post')){
            $data=$this->request->data;
            $this->request->data['Stylistnote']['user_id']=$client_id;
            $this->request->data['Stylistnote']['stylist_id']=$user_id;
            $image=$data['Stylistnote']['image']['name'];
            $this->request->data['Stylistnote']['image']=$image;
            //image not upload yet pending?
            if($image || $this->request->data)
            {
                $Stylistnote->save($this->request->data);
                $this->Session->setFlash("User Data Hasbeen Saved");
                $this->redirect('/messages/getusernotes/'.$client_id);
            }
        }

        $notes=$Stylistnote->find('all',array('conditions'=>array('Stylistnote.user_id'=>$client_id,'Stylistnote.stylist_id'=>$user_id,)));
        $this->set('notes',$notes);
    }

    // perticular user custom site measurements

    public function getusercustomsize($client_id = null){
        $User = ClassRegistry::init('User');
        $UserSizeInformation = ClassRegistry::init('UserSizeInformation');
        //Get user from session to derterminate if user is stylist
        $user = $this->getLoggedUser();
        $user_id = $user["User"]["id"]; 
        $is_admin = $user["User"]["is_admin"];
        $is_stylist = $user["User"]["is_stylist"]; 

        if($this->request->is('post')){
            $this->request->data['UserSizeInformation']['user_id']=$client_id;
            $this->request->data['UserSizeInformation']['stylist_id']=$user_id;
            $custom_shirt_serialize = serialize($this->request->data['UserSizeInformation']['custom_shirt_measurement']);
            $custom_jacket_serialize = serialize($this->request->data['UserSizeInformation']['custom_jacket_measurement']);
            $custom_trouser_serialize = serialize($this->request->data['UserSizeInformation']['custom_trouser_measurement']);
            $custom_vest_serialize = serialize($this->request->data['UserSizeInformation']['custom_vest_measurement']);
            $this->request->data['UserSizeInformation']['custom_shirt_measurement'] = $custom_shirt_serialize;
            $this->request->data['UserSizeInformation']['custom_jacket_measurement'] = $custom_jacket_serialize;
            $this->request->data['UserSizeInformation']['custom_trouser_measurement'] = $custom_trouser_serialize;
            $this->request->data['UserSizeInformation']['custom_vest_measurement'] = $custom_vest_serialize;
                $UserSizeInformation->save($this->request->data);
                $this->Session->setFlash("User Data Hasbeen Saved");
                $this->redirect('/messages/getusercustomsize/'.$client_id);
            

        }

    }

    //All user's news feed
    public function newsfeeds($client_id = null) {
        $User = ClassRegistry::init('User');
        $posts = ClassRegistry::init('Post');
        $user = $this->getLoggedUser();
        $user_id = $user["User"]["id"]; 
        $is_admin = $user["User"]["is_admin"];
        $is_stylist = $user["User"]["is_stylist"]; 
        
        
        $post = $posts->find('all', array('conditions'=>array(
                                            'OR' =>
                                            array(
                                            'AND' => array(
                                                          array('Post.is_like' => true),
                                                          array('Post.stylist_id' => $client_id)
                                                    ),

                                                          array('Post.is_message' => true,
                                                          'Post.stylist_id' => $client_id),
                                                          array('Post.is_outfit' => true,
                                                          'Post.stylist_id' => $client_id),

                                                   
                                            ),
                              )));
        
        $mynewsfeeds = array();
        foreach ($post as  $post) {
                $post_id =  $post['Post']['id'];
                $like_user_id = $post['Post']['user_id'];

                $username = $User->find('all', array('conditions'=>array('User.id'=>$like_user_id)));
                $userdetails = array();
                foreach ($username as  $username) {
                    $userdetails = $username['User']['first_name'];
                }
                $like = ClassRegistry::init('Like');
                $likes = $like->find('all', array('conditions' => array('Like.post_id' => $post_id)));
                $like_product_id = array();
                foreach ($likes as  $likes) {
                        $like_product_id = $likes['Like']['product_entity_id'];
                        
                }
                $Entity = ClassRegistry::init('Entity');
                $entity_list = $Entity->getMultipleById($like_product_id);
                
                $Message = ClassRegistry::init('Message');
                $messages[] = $Message->find('all', array('conditions'=>array('Message.post_id'=>$post_id)));
                
                $Outfit = ClassRegistry::init('Outfit');
                $outfits = $Outfit->find('all', array('conditions'=>array('Outfit.post_id'=>$post_id,)));
                $styoutfitid = array();
                foreach ($outfits as $outfits) {
                      $styoutfitid[] = $outfits['Outfit']['id'];
                }
                
                $OutfitItem = ClassRegistry::init('OutfitItem');
                $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $styoutfitid)));
                
                $outfitentities = array();
                foreach($outfit as $value){
                $outfitentities[] = $value['OutfitItem']['product_entity_id'];
                }
                $outfitentity_list = $Entity->getMultipleById($outfitentities);

                $mynewsfeeds[] = array(
                                'entities'  => $entity_list,
                                'Post_user_id' =>  $like_user_id,
                                'userdetails' => $userdetails,
                                'Message' => $messages,
                                'outfitlist' => $outfitentity_list,
                                'Outfitname' => $outfits
                                );
                
        }
        print_r($mynewsfeeds);
        exit;
        
        
        
    }

    public function copyoutfituser($user_id = null){
        $User = ClassRegistry::init('User');
        $posts = ClassRegistry::init('Post');
        $Useroutfit = ClassRegistry::init('Useroutfit');
        $user = $this->getLoggedUser();
        $user_id = $user["User"]["id"]; 
        $is_admin = $user["User"]["is_admin"];
        $is_stylist = $user["User"]["is_stylist"]; 
        if($this->request->is('post')){
                    $outfitid = $this->request->data['OutfitItem']['outfit_id'];
                    $clientid = $this->request->data['Useroutfit']['user_id'];
                    $this->request->data['Post']['user_id'] = $clientid;
                    $this->request->data['Post']['stylist_id'] = $user_id;
                    $this->request->data['Post']['is_outfit'] = '1';
                    $posts->save($this->request->data);
                    $post_id = $posts->getLastInsertID();
                    $Useroutfit->data['Useroutfit']['outfit_id'] = $outfitid;
                    $Useroutfit->data['Useroutfit']['user_id'] = $clientid;
                    $Useroutfit->data['Useroutfit']['stylist_id'] = $user_id;
                    $Useroutfit->data['Useroutfit']['post_id'] = $post_id;
            if($Useroutfit->save($this->request->data)){
                    $this->Session->setFlash("User Data Hasbeen Saved");
                    $this->redirect('/messages/getstylistoutfit/'.$user_id);
            }
        }
    }

    public function getstylistsales($user_id = null) {
        $User = ClassRegistry::init('User');
        $posts = ClassRegistry::init('Post');
        $Useroutfit = ClassRegistry::init('Useroutfit');
        $Order = ClassRegistry::init('Order');
        $Entity = ClassRegistry::init('Entity');
        $OrderItem = ClassRegistry::init('OrderItem');
        $Product = classRegistry::init('Product');
        $user = $this->getLoggedUser();
        $user_id = $user["User"]["id"]; 
        $is_admin = $user["User"]["is_admin"];
        $is_stylist = $user["User"]["is_stylist"];

        $postvalue = $posts->find('all', array('conditions'=>array('Post.is_order'=>true)));
        $saleshistory = array();
        foreach ($postvalue as $key => $postvalue) {

            $post_id = $postvalue['Post']['id'];
            $orderlist = $Order->find('all', array('conditions'=>array('Order.post_id'=>$post_id)));
            foreach ($orderlist as $orderlist) {

               $orderuserid =  $orderlist['Order']['user_id']; 
            }
            $username = $User->getByID($orderuserid);
            $orderdetailsuser = $OrderItem->getUserPurchaseDetail($orderuserid);
            foreach ($orderdetailsuser as $orderdetailsuser) {
            
            $productid[] = $orderdetailsuser['OrderItem']['product_entity_id'];
            
            }
            $productdetail = $Product->findById($productid);
            $brand_id = $productdetail['Product']['brand_id'];
                
            $Brand = classRegistry::init('Brand');
            $branddetails = $Brand->find('all',array('conditions'=>array('Brand.id'=>$brand_id)));


            //print_r($prid);exit;

            $saleshistory[] = array(
                'orderlist' =>  $orderlist,
                'userdetail' => $username,
                'orderdetailsuser' => $orderdetailsuser,
                'brand' => $branddetails
            );
        } 
        //print_r($saleshistory);
        $this->set('saleshistory',$saleshistory);
    }

    public function requestanoutfit() {
        $this->autoLayout = false;
        $Message = ClassRegistry::init('Message');
        $User= ClassRegistry::init('User');
        $posts = ClassRegistry::init('Post');
        $user = $this->getLoggedUser();
        $user_id = $user['User']['id'];
        $stylist_id = $user['User']['stylist_id'];
            $this->request->data['Post']['user_id'] = $user_id;
            $this->request->data['Post']['stylist_id'] = $stylist_id;
            $this->request->data['Post']['is_outfit_request'] = '1';
            $posts->save($this->request->data);
            $post_id = $posts->getLastInsertID();
        if($this->request->is('post') || $this->request->is('put')){
            $Message->data['Message']['user_from_id'] = $user_id;
            $Message->data['Message']['user_to_id'] = $stylist_id;
            $Message->data['Message']['is_request_outfit'] = '1';
            $Message->data['Message']['post_id'] =  $post_id;

            if($Message->save($this->request->data)){
                $this->Session->setFlash("Request Outfit Data Hasbeen Send");
                $this->redirect('/messages/index');
            }
            //print_r($this->request->data);
            //exit;

        }    
    }
    
    public function userLikes($user_id = null){
         $User= ClassRegistry::init('User');
         $user = $User->findById($user_id);
         $stylist_id = $user['User']['stylist_id'];
         //print_r($stylist_id);  
        //echo $user_id;
        
        $find_array = array(
                'fields' => array('User.*,User1.*'),
                'joins' => array(
                array(
                    'conditions' => array(
                        'User.id = User1.stylist_id',
                        'User1.id'=>$user_id,
                    ),
                    'table' => 'users',
                    'alias' => 'User1',
                    'type' => 'INNER',
                ),
                ),
            );
                

        $Userdata=$User->find('all',$find_array);
        $Wishlist = ClassRegistry::init('Wishlist');
        $Entity = ClassRegistry::init('Entity'); 
        $liked_list = $Wishlist->getUserLikeProduct($user_id);
        
                $entity_list = array();
                foreach($liked_list as $value){
                    $entity_list[] = $value['Wishlist']['product_entity_id'];
                    $last_item_id = $value['Wishlist']['id'];
                    
                }
        $likeitems = $Entity->getEntitiesByIdLikes($entity_list, $user_id);
    
        $this->set(compact('likeitems','user_id','Userdata'));
        
    }

    
    public function userLikesAsc($user_id = null){
        $Wishlist = ClassRegistry::init('Wishlist');
        $Entity = ClassRegistry::init('Entity'); 
        $sortingorder = $this->request->data['valueSelected'];
        $liked_list = $Wishlist->getUserLikeProductAsc($user_id);
                $entity_list = array();
                foreach($liked_list as $value){
                    $entity_list[] = $value['Wishlist']['product_entity_id'];
                    $last_item_id = $value['Wishlist']['id'];
                    
                }
                
        $likeitems = $Entity->getEntitiesByIdLikesAsc($entity_list, $user_id, $sortingorder);
        echo json_encode($likeitems);
        exit;
        
    }

    public function userPurchases($user_id = null){

            $User= ClassRegistry::init('User');
            $OrderItem = ClassRegistry::init('OrderItem');
            $Entity = ClassRegistry::init('Entity'); 
            $total_purchases = $OrderItem->getTotalUserPurchaseCount($user_id);
            
            if($total_purchases > 0){
                $order_item_list = $OrderItem->getUniqueUserItemPurchase($user_id);
                $entity_list = array();
                foreach($order_item_list as $value){
                    $entity_list[] = $value['Orders']['product_entity_id'];
                    $last_item_id = $value['Orders']['order_id'];
                }

            $purchases = $Entity->getEntitiesByIdPurchaseDes($entity_list);
            
        }
        $find_array = array(
                'fields' => array('User.*,User1.*'),
                'joins' => array(
                array(
                    'conditions' => array(
                        'User.id = User1.stylist_id',
                        'User1.id'=>$user_id,
                    ),
                    'table' => 'users',
                    'alias' => 'User1',
                    'type' => 'INNER',
                ),
                ),
            );
                
        //print_r($purchases);
        $Userdata=$User->find('all',$find_array);
        $this->set(compact('purchases','user_id','Userdata'));
        
    }
    //user purchase sorting

    public function userPurchasesSorting($user_id = null){
            $User= ClassRegistry::init('User');
            $OrderItem = ClassRegistry::init('OrderItem');
            $Entity = ClassRegistry::init('Entity'); 
            if($this->request->is('post')){
                $sortingorder = $this->request->data['valueSelected'];

            }else{
                $sortingorder = 'DESC';
            }
            $total_purchases = $OrderItem->getTotalUserPurchaseCount($user_id);
            if($total_purchases > 0){
                $order_item_list = $OrderItem->getUniqueUserItemPurchaseSorting($user_id,$sortingorder);
                $entity_list = array();
                foreach($order_item_list as $value){
                    $entity_list[] = $value['Orders']['product_entity_id'];
                    $last_item_id = $value['Orders']['order_id'];
                }
            $purchases = $Entity->getEntitiesByIdPurchaseSorting($entity_list,$sortingorder);
                 
        }
        echo json_encode($purchases);
        exit;
    }

    public function outfitdetails($outfit_id = null) {
       
        $User = ClassRegistry::init('User');
        //Get user from session to derterminate if user is stylist
        $user = $this->getLoggedUser();
        $user_id = $user["User"]["id"]; 
        $is_admin = $user["User"]["is_admin"];
        $is_stylist = $user["User"]["is_stylist"];
        $Outfit = ClassRegistry::init('Outfit');
        $outfitname = $Outfit->findById($outfit_id);
        $OutfitItem = ClassRegistry::init('OutfitItem');
        $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $outfit_id)));
        $entity_list = array();
            foreach($outfit as $value){
                $entity_list[] = $value['OutfitItem']['product_entity_id'];
                $size_list[] = $value['OutfitItem']['size_id'];
            }

            $Entity = ClassRegistry::init('Entity');

            // get data
            $entity = $Entity->getMultipleById($entity_list, $user_id);
            //print_r($entity);
            $products_list = array();
            foreach ($entity as $key => $value) {
                $products_list[] = $value['Entity']['product_id'];
            }
            $similar_results = $Entity->getSimilarProducts($outfit_id, $products_list);
            $similar = array();
            foreach($similar_results as $row){
                if($row['Color'] && count($row['Color']) > 0){
                    $similar[$row['Entity']['product_id']][] = $row; 
                }
            }

            $entities = array();

            foreach ($entity as $key => $value) {
                $entities[$value['Entity']['id']] = $value;
                if(isset($similar[$value['Entity']['product_id']])){
                    $entities[$value['Entity']['id']]['Similar'] = $similar[$value['Entity']['product_id']];
                }
            }

            $Size = ClassRegistry::init('Size');
            $size_list = $Size->find('list');
            

            $show_add_cart_popup = 0;
            if($this->Session->read('add-cart')){
                $show_add_cart_popup = 1;
                $this->Session->delete('add-cart');
            }

            $popUpMsg = '';
            $show_three_item_popup = 0;
            if($this->Session->read('cart-three-items')){
                $show_three_item_popup = 1;
                $popUpMsg = $this->Session->read('cart-three-items-msg');
                $this->Session->delete('cart-three-items');
                $this->Session->delete('cart-three-items-msg');
            }

            $this->set(compact('entities','outfitname', 'size_list', 'user_id', 'msg', 'second_user', 'second_user_id', 'is_admin', 'is_stylist', 'show_add_cart_popup','show_three_item_popup', 'popUpMsg'));
            //print_r($entities);
        //}
        //else{
            //$this->redirect('/messages/usersoutfits/'.$user_id);
        //}
    }

    public function userprofiles($user_id = null) {
        //echo $user_id;
        $User = ClassRegistry::init('User');
        $user = $User->findById($user_id);
        //print_r($user);
        $stylist_id = $user['User']['stylist_id'];
        $find_array = array(
                'fields' => array('User.*,User1.*'),
                'joins' => array(
                array(
                    'conditions' => array(
                        'User.id = User1.stylist_id',
                        'User1.id'=>$user_id,
                    ),
                    'table' => 'users',
                    'alias' => 'User1',
                    'type' => 'INNER',
                ),
                ),
            );
    $Userdata= $User->find('all',$find_array);
    $this->set(compact('Userdata'));

    if($this->request->is('post') || $this->request->is('put')){
        
        //$User->request->data['User']['comments'] = $this->request->data['comments'];
        
        if($User->save($this->request->data)){
            //print_r($User->save($this->request->data));
                $this->Session->setFlash("User Data Hasbeen Saved");
                $this->redirect('/messages/userprofiles/'.$user_id);
            } else {
                $this->Session->setFlash(__('The User could not be saved. Please, try again.'), 'flash');
            }


    } else {
            $options = array('conditions' => array('User.' . $User->primaryKey => $user_id));
            $this->request->data = $User->find('first', $options);
        }

    }


    //bhashit code end

}
