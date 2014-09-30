<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Messages Controller
 *
 * @property Message $Message
 */
class MessagesController extends AppController {
    public $components = array('Paginator','RequestHandler');
    public $helpers = array('Paginator');

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
        $userlists = $User->find('all',array('conditions'=>array('User.stylist_id'=>$user_id,),'fields'=>array('User.id,User.updated','User.first_name','User.last_name','User.stylist_id','User.profile_photo_url')));
         //print_r($userlists);
         // make user_id, user
        $this->set(compact('user_id', 'user', 'messages_for_user_id','userlists'));
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


//stylist user filter list

    public function stylistUserFilterList($clientid = null){
        $User = ClassRegistry::init('User');
        $client = $User->getById($clientid);
        $clientid = $client['User']['id'];
        $stylist_id = $client['User']['stylist_id'];
         if($this->request->is('post')){
            $usersearch = $this->request->data['usersearch'];
            $searchdata = $User->find('all',array('conditions'=>array('User.first_name LIKE' => '%' . $usersearch . '%', 'User.stylist_id' => $stylist_id))); 
         
         }
         echo json_encode($searchdata);
         exit;


    }

    public function stylistFilterList($user_id = null){
        $User = ClassRegistry::init('User');
        $stylist_id = $user_id;
         if($this->request->is('post')){
            $usersearch = $this->request->data['usersearch'];
            $searchdata = $User->find('all',array('conditions'=>array('User.first_name LIKE' => '%' . $usersearch . '%', 'User.stylist_id' => $stylist_id))); 
         
         }
         echo json_encode($searchdata);
         exit;


    }


    // stylist user outfits

    public function stylistuseroutfits($client_id = null){
        $this->isLogged();
        $User = ClassRegistry::init('User');
        
        //Get user from session to derterminate if user is stylist
        $user = $this->getLoggedUser();
        $user_id = $user["User"]["id"]; 
        $is_admin = $user["User"]["is_admin"];
        $is_stylist = $user["User"]["is_stylist"];   
        $client = $User->getById($client_id);
        $clientid = $client['User']['id'];
        $userlists = $User->find('all',array('conditions'=>array('User.stylist_id'=>$user_id,),'fields'=>array('User.id,User.updated','User.first_name','User.last_name','User.stylist_id','User.profile_photo_url')));
        $Message = ClassRegistry::init('Message');
        
        
        if($user){

                  $find_array =  array(
                    'conditions' => array('AND' =>
                        array(
                            'OR' => array('Message.user_to_id' => $client_id, 'Message.user_from_id' => $client_id)
                        )
                    ),
                    'limit'=>5,
                    'contain' => array('UserFrom'),
                    'fields' => array(
                        'Message.id', 'Message.body', 'Message.created', 'Message.is_read','Message.user_from_id', 'Message.user_to_id', 'Message.image', 'Message.is_outfit', 'Message.outfit_id', 'UserFrom.id', 'UserFrom.first_name', 'UserFrom.last_name',
                    ),
                    'order'=>'Message.created DESC',
                 );

                    $my_conversation = $Message->find('all',$find_array);
                    $my_conversation_count = count($my_conversation);


                        //$my_conversation = $this->Message->getMyConversationWithStylist($client_id);
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
                    // print_r($my_outfits);
                    // die;
        $this->set(compact('my_outfits','client','user_id','clientid','userlists','my_conversation_count'));
    }

    // stylistuseroutfitssorting for pagiantion and sorting ajax function stylist section

    public function stylistuseroutfitssorting($client_id = null){
        $this->layout = 'ajax';
        $this->autoRender = false;
        $this->isLogged();
        $User = ClassRegistry::init('User');
        
        //Get user from session to derterminate if user is stylist
        $user = $this->getLoggedUser();
        $user_id = $user["User"]["id"]; 
        $is_admin = $user["User"]["is_admin"];
        $is_stylist = $user["User"]["is_stylist"];   
        $client = $User->getById($client_id);
        $clientid = $client['User']['id'];
        $Message = ClassRegistry::init('Message');
        
        if(isset($this->request->data['sorting'])){
           $sorting =  $this->request->data['sorting'];
        } else{
            $sorting = 'DESC';
        }

        if(isset($this->request->data['FirstPageCount'])){
           $FirstPageCount =  $this->request->data['FirstPageCount'];
        } else{
            $FirstPageCount = 0;
        }
        
        
        if($client){

                  $find_array =  array(
                    'conditions' => array('AND' =>
                        array(
                            'OR' => array('Message.user_to_id' => $client_id, 'Message.user_from_id' => $client_id,'Message.is_outfit'=>true,)
                        )
                    ),
                    'limit'=>5,
                    'offset'=>$FirstPageCount,
                    'contain' => array('UserFrom'),
                    'fields' => array(
                        'Message.id', 'Message.body', 'Message.created', 'Message.is_read','Message.user_from_id', 'Message.user_to_id', 'Message.image', 'Message.is_outfit', 'Message.outfit_id', 'UserFrom.id', 'UserFrom.first_name', 'UserFrom.last_name',
                    ),
                    'orde'=> array('Message.created' => $sorting),
                 );

                    $my_conversation = $Message->find('all',$find_array);
                    $my_conversation_count = count($my_conversation);
                    

                        //$my_conversation = $this->Message->getMyConversationWithStylist($client_id);
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
                    
        echo json_encode($my_outfits);
    }





    //

    //perticular user outfit list sent by his stylist
    public function usersoutfits($client_id = null) {
        $this->isLogged();
        $User = ClassRegistry::init('User');
        
        //Get user from session to derterminate if user is stylist
        $user = $this->getLoggedUser();
        $user_id = $user["User"]["id"]; 
        $is_admin = $user["User"]["is_admin"];
        $is_stylist = $user["User"]["is_stylist"];   
        $user = $User->getById($client_id);
        $current_user = $this->getLoggedUser();

        if($client_id != $current_user['User']['id'] && !$current_user['User']['is_admin'] && $current_user['User']['id'] != $user['User']['stylist_id'] || $client_id != $current_user['User']['id']){
            $this->redirect('/');
            exit;
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
        
        $Userdata=$User->find('all',$find_array);
        $Message = ClassRegistry::init('Message');
        
        if($user){

                    //pagination 

                 
                    $find_array = array(
                                    'conditions' => array('Message.user_to_id' => $client_id, 'Message.is_outfit' => 1,),
                                    'limit' => 2,
                                    'fields' => array(
                                        'Message.id', 'Message.body', 'Message.created', 'Message.is_read','Message.user_from_id', 'Message.user_to_id', 'Message.image', 'Message.is_outfit', 'Message.outfit_id',
                                    ),
                                    'order' =>  array('Message.created DESC'),
                                );

                    $my_conversation = $this->Message->find('all',$find_array);
                    $my_conversation_count = count($my_conversation);

                    //pagination


                        //$my_conversation = $this->Message->getMyConversationWithStylist($client_id);
                        $my_outfits = array();
                        foreach($my_conversation as $row){
                            if($row['Message']['is_outfit'] == 1 && $row['Message']['outfit_id'] > 0){
                                $outfit_id = $row['Message']['outfit_id'];
                                $comments = $row['Message']['body'];
                                $Outfit = ClassRegistry::init('Outfit');
                                $outfitnames = $Outfit->find('all', array('conditions'=> array('Outfit.id'=>$outfit_id)));
                                $OutfitItem = ClassRegistry::init('OutfitItem');
                                $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $outfit_id),));
                                $entities = array();
                                foreach($outfit as $value){
                                     $entities[] = $value['OutfitItem']['product_entity_id'];
                                }
                                $Entity = ClassRegistry::init('Entity');
                                $entity_list = $Entity->getMultipleByIdUser($entities,$user_id);
                                $my_outfits[] = array(
                                    'outfit'    => $outfitnames,
                                    'comments' =>$comments,
                                    'entities'  => $entity_list
                                    );
                                
                            }
                        }
                    }
                //print_r($my_outfits);
        $this->set(compact('my_outfits','user_id','Userdata','my_conversation_count'));
        
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
        $Message = ClassRegistry::init('Message');
        if(isset($this->request->data['sorting'])){
           $sorting =  $this->request->data['sorting'];
        } else{
            $sorting = 'DESC';
        }
        
        if(isset($this->request->data['FirstPageCount'])){
           $FirstPageCount =  $this->request->data['FirstPageCount'];
        } else{
            $FirstPageCount = 0;
        }

        if($user){
                        
                        $find_array = array(
                                'conditions' => array('Message.user_to_id' => $client_id, 'Message.is_outfit' => 1,),
                                'limit' => 2,
                                'offset' => $FirstPageCount,
                                'fields' => array(
                                    'Message.id', 'Message.body', 'Message.created', 'Message.is_read','Message.user_from_id', 'Message.user_to_id', 'Message.image', 'Message.is_outfit', 'Message.outfit_id',
                                ),
                                'order' =>  array('Message.created' => $sorting,),
                            );

                        $my_conversation = $Message->find('all',$find_array);
                        //pagination

                        //$my_conversation = $this->Message->getMyConversationWithStylistSorting($client_id,$sorting);
                        $my_outfits = array();
                        foreach($my_conversation as $row){
                            if($row['Message']['is_outfit'] == 1 && $row['Message']['outfit_id'] > 0){
                                $outfit_id = $row['Message']['outfit_id'];
                                $comments = $row['Message']['body'];
                                $Outfit = ClassRegistry::init('Outfit');
                                $outfitnames = $Outfit->find('all', array('conditions'=> array('Outfit.id'=>$outfit_id)));
                                $OutfitItem = ClassRegistry::init('OutfitItem');
                                $outfit = $OutfitItem->find('all',array('conditions'=>array('OutfitItem.outfit_id' => $outfit_id,)));
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
        echo json_encode($my_outfits);
        exit;
    }
// get stylist outfit

    public function myoutfits(){

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

        //$my_outfitss = array();
        //$stylistoutfit= $Outfit->find('all', array('conditions'=>array('Outfit.stylist_id'=>$user_id,),'fields'=> array('Outfit.outfit_name','Outfit.id'),));
        
        $my_outfitss = array();
        $stylistoutfit= $Outfit->find('all', array(
            'limit' => 5,
            'order' => 'Outfit.created DESC',
            'conditions'=>array('Outfit.stylist_id'=>$user_id,),'fields'=> array('Outfit.outfit_name','Outfit.id'),));
        
        $outfitcount = count($stylistoutfit);

        foreach($stylistoutfit as $row){
            $stylist_outfit_id = $row['Outfit']['id'];
            $Outfit = ClassRegistry::init('Outfit');
            $outfitnames = $Outfit->find('first', array('conditions'=> array('Outfit.id'=>$stylist_outfit_id)));
            $messages = $Message->find('all',array('conditions'=>array('Message.outfit_id'=>$stylist_outfit_id,),'fields'=>array('Message.body')));
            $OutfitItem = ClassRegistry::init('OutfitItem');
            $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $stylist_outfit_id)));
            $entities = array();
            foreach($outfit as $value){
                    $entities[] = $value['OutfitItem']['product_entity_id'];
                }
            $Entity = ClassRegistry::init('Entity');
            

            //pagintion
            $find_array = array(
                'limit'=>20,
                'contain' => array('Image'),
                'conditions' => array('Entity.id' => $entities),
                'joins' => array(
                    array('table' => 'products',
                        'alias' => 'Product',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Product.id = Entity.product_id'
                        )
                    ),
                    array('table' => 'brands',
                        'alias' => 'Brand',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Product.brand_id = Brand.id',
                        )
                    ),        
                ), 
                
                'fields' => array(
                    'Entity.id','Entity.price','Brand.name',
                ),

            );
            //$this->Paginator->settings = $find_array;
            $items = $Entity->find('all',$find_array);
            // //pagintion
            $my_outfitss[] =  array(
                                'outfit'    => $outfitnames,
                                'comments' => $messages,
                                'entities'  => $items
                            );

        }
        
        $this->set(compact('my_outfitss','userlist','user_id','outfitcount'));
    
    } 


    //outfit details ajax for pop up on stylist total outfit page

    public function outfitPopupQuickView($user_id = null) {
        $this->layout= 'ajax';
        $this->autoRender = false;
        //Get user from session to derterminate if user is stylist
        if($this->request->is('post')){
           $outfit_id = $this->request->data['outfitId'];
           $totalpriceoutfit = $this->request->data['totalpriceoutfit'];
        }
        $Outfit = ClassRegistry::init('Outfit');
        $outfitname = $Outfit->findById($outfit_id);
        
        $OutfitItem = ClassRegistry::init('OutfitItem');
        $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $outfit_id)));
        $Message = ClassRegistry::init('Message');
        $messages_outfit_comments = $Message->find('first',array('conditions'=>array('Message.outfit_id'=>$outfit_id,'Message.is_outfit'=>true,'Message.user_from_id' =>$user_id,),'fields'=>array('Message.body as stylist_comments','Message.user_to_id')));
        foreach ($messages_outfit_comments as $msg_rec_user) {
            $msg_recommnded_user[] = $msg_rec_user['user_to_id'];
        }
        
        $User = ClassRegistry::init('User');
        $usernames_of_recommnded = $User->find('all', array('conditions'=>array('User.id'=>$msg_recommnded_user,),'fields'=>array('User.first_name','User.last_name')));
        
        $entity_list = array();
            foreach($outfit as $value){
                $entity_list[] = $value['OutfitItem']['product_entity_id'];
            }

            $Entity = ClassRegistry::init('Entity');

            // get data
            //$entity = $Entity->getMultipleById($entity_list, $user_id,$outfit_id);
            $find_array = array(
            'contain' => array('Image.name'),
            'conditions' => array('Entity.id' => $entity_list),
            'joins' => array(
                array('table' => 'products',
                    'alias' => 'Product',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.id = Entity.product_id'
                    )
                ),
                array('table' => 'brands',
                    'alias' => 'Brand',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.brand_id = Brand.id',
                    )
                ),        
            ), 
            'fields' => array(
                'Brand.*','Entity.price','Entity.name',
            ),
        );
           $entity =  $Entity->find('all',$find_array);
            
            $entitylist[] = array(
                'outfitname'=>$outfitname,
                'recomndeduser'=>$usernames_of_recommnded,
                'product'=>$entity,
                'totalpriceoutfit'=>$totalpriceoutfit

                );
            
            echo json_encode($entitylist);
        exit;
    }

    //stylist total outfit pagination
    public function myOutfitAjax(){
        $this->layout = 'ajax';
        $this->autoRender = false;
        if(isset($this->request->data['last_limit'])){
            $last_product_id = $this->request->data['last_limit'];
        }else{
            $last_product_id = 0;
        }
        if(isset($this->request->data['sortname'])){
            $sortname = 'Outfit.outfit_name ASC';
        }else if(isset($this->request->data['sortdate'])){
            $sortname = 'Outfit.created ASC';
        }else{
            $sortname = 'Outfit.created DESC';

        }
        if(isset($this->request->data['searchbyoutfit'])){
            $searchbyoutfit = $this->request->data['searchbyoutfit'];
            $searchvalueresult = array('Outfit.outfit_name LIKE' => '%' . $searchbyoutfit . '%');
        }else{
            $searchvalueresult = '';
        }
        //echo $sortname;die;
        $User = ClassRegistry::init('User');
        //Get user from session to derterminate if user is stylist
        $user = $this->getLoggedUser();
        $user_id = $user["User"]["id"]; 
        $is_admin = $user["User"]["is_admin"];
        $is_stylist = $user["User"]["is_stylist"];   
        $Message = ClassRegistry::init('Message');
        $Outfit = ClassRegistry::init('Outfit');
        //$last_product_id = $this->request->data['last_limit'];
        $my_outfitss = array();
        $stylistoutfit= $Outfit->find('all', array(
            'limit' => 5,
            'offset'=> $last_product_id,
            'order' => $sortname,
            'conditions'=>array('Outfit.stylist_id'=>$user_id,$searchvalueresult),'fields'=> array('Outfit.outfit_name','Outfit.id')));
        
        foreach($stylistoutfit as $row){
            $stylist_outfit_id = $row['Outfit']['id'];
            $Outfit = ClassRegistry::init('Outfit');
            $outfitnames = $Outfit->find('first', array('conditions'=> array('Outfit.id'=>$stylist_outfit_id)));
            $messages = $Message->find('all',array('conditions'=>array('Message.outfit_id'=>$stylist_outfit_id,),'fields'=>array('Message.body')));
            $OutfitItem = ClassRegistry::init('OutfitItem');
            $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $stylist_outfit_id),));
            
            $entities = array();
            foreach($outfit as $value){
                    $entities[] = $value['OutfitItem']['product_entity_id'];
                }
            $Entity = ClassRegistry::init('Entity');
            

            //pagintion
            $find_array = array(
                
                'contain' => array('Image'),
                'conditions' => array('Entity.id' => $entities),
                'joins' => array(
                    array('table' => 'products',
                        'alias' => 'Product',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Product.id = Entity.product_id'
                        )
                    ),
                    array('table' => 'brands',
                        'alias' => 'Brand',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Product.brand_id = Brand.id',
                        )
                    ),        
                ), 
                
                'fields' => array(
                    'Entity.id','Entity.price','Brand.name',
                ),

            );
            $items = $Entity->find('all',$find_array);
            $my_outfitss[] =  array(
                                'outfit'    => $outfitnames,
                                'comments' => $messages,
                                'entities'  => $items
                            );

        }
         $my_outfitss =  array_filter($my_outfitss);
        echo json_encode($my_outfitss);
        
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


//stylist user notes

    public function stylistusernotes($clientid = null) {
        $User = ClassRegistry::init('User');
        $Stylistnote = ClassRegistry::init('Stylistnote');
        $client = $User->findById($clientid);
        $clientid = $client['User']['id'];
        $stylistid = $client['User']['stylist_id'];
        $userlists = $User->find('all',array('conditions'=>array('User.stylist_id'=>$stylistid,),'fields'=>array('User.id,User.updated','User.first_name','User.last_name','User.stylist_id','User.profile_photo_url')));
       
        if($this->request->is('post')){
            $data=$this->request->data;
            $this->request->data['Stylistnote']['user_id']=$clientid;
            $this->request->data['Stylistnote']['stylist_id']=$stylistid;
            if($Stylistnote->save($this->request->data))
            {
                $this->Session->setFlash("User Data Hasbeen Saved");
                $this->redirect('/messages/stylistusernotes/'.$clientid);
            }
        }

        // get notes data

        $usernotes = $Stylistnote->find('all', array('conditions'=>array('Stylistnote.stylist_id'=>$stylistid,'Stylistnote.user_id'=>$clientid,)));



        $this->set(compact('clientid','client','usernotes','userlists'));

    }

    // remove stylist user notes

    public function removestylistusernotes($id = null){
        $Stylistnote = ClassRegistry::init('Stylistnote');

        echo $user = $this->getLoggedUser();
       print_r($user);
        exit;

        if (!$id) {
            $this->Session->setFlash('Invalid id for Stylistnote');
            $this->redirect(array('action' => '/messages/stylistusernotes'));
        }   

        if ($this->Style->delete($id)) {
            $this->Session->setFlash('Styles  deleted');
        } else {
            $this->Session->setFlash(__('Styles was not deleted', true));
        }

        $this->redirect(array('action' => 'index'));



    }
    //perticular user notes

    // public function getusernotes($client_id = null){
    //     $User = ClassRegistry::init('User');
    //     $Stylistnote = ClassRegistry::init('Stylistnote');
    //     //Get user from session to derterminate if user is stylist
    //     $user = $this->getLoggedUser();
    //     $user_id = $user["User"]["id"]; 
    //     $is_admin = $user["User"]["is_admin"];
    //     $is_stylist = $user["User"]["is_stylist"];  

    //     if($this->request->is('post')){
    //         $data=$this->request->data;
    //         $this->request->data['Stylistnote']['user_id']=$client_id;
    //         $this->request->data['Stylistnote']['stylist_id']=$user_id;
    //         $image=$data['Stylistnote']['image']['name'];
    //         $this->request->data['Stylistnote']['image']=$image;
    //         //image not upload yet pending?
    //         if($image || $this->request->data)
    //         {
    //             $Stylistnote->save($this->request->data);
    //             $this->Session->setFlash("User Data Hasbeen Saved");
    //             $this->redirect('/messages/getusernotes/'.$client_id);
    //         }
    //     }

    //     $notes=$Stylistnote->find('all',array('conditions'=>array('Stylistnote.user_id'=>$client_id,'Stylistnote.stylist_id'=>$user_id,)));
    //     $this->set('notes',$notes);
    // }



// stylist user measurement


    public function stylistUserMeasurements($clientid = null, $id = null) {
        $User = ClassRegistry::init('User');
        $UserSizeInformation = ClassRegistry::init('UserSizeInformation');
        $UserPreference = ClassRegistry::init('UserPreference');
        $client = $User->findById($clientid);
        $clientid = $client['User']['id'];
        $stylistid = $client['User']['stylist_id'];

        $userprofile = $UserPreference->find('all',array('conditions'=>array('UserPreference.user_id'=>$clientid,)));

        $userlists = $User->find('all',array('conditions'=>array('User.stylist_id'=>$stylistid,),'fields'=>array('User.id,User.updated','User.first_name','User.last_name','User.stylist_id','User.profile_photo_url')));
        

        if($this->request->is('post') || $this->request->is('put')){
            
             $id = $this->request->data['UserSizeInformation']['id'];
            
            $this->request->data['UserSizeInformation']['user_id']=$clientid;
            $this->request->data['UserSizeInformation']['stylist_id']=$stylistid;
            $custom_shirt_serialize = json_encode($this->request->data['UserSizeInformation']['custom_shirt_measurement']);
            $custom_jacket_serialize = json_encode($this->request->data['UserSizeInformation']['custom_jacket_measurement']);
            $custom_trouser_serialize = json_encode($this->request->data['UserSizeInformation']['custom_trouser_measurement']);
            $custom_vest_serialize = json_encode($this->request->data['UserSizeInformation']['custom_vest_measurement']);
            $this->request->data['UserSizeInformation']['custom_shirt_measurement'] = $custom_shirt_serialize;
            $this->request->data['UserSizeInformation']['custom_jacket_measurement'] = $custom_jacket_serialize;
            $this->request->data['UserSizeInformation']['custom_trouser_measurement'] = $custom_trouser_serialize;
            $this->request->data['UserSizeInformation']['custom_vest_measurement'] = $custom_vest_serialize;
            if($UserSizeInformation->save($this->request->data)){
                $this->Session->setFlash("User Data Hasbeen Saved");
                $this->redirect('/messages/stylistusermeasurements/'.$clientid);
            } else {
                $this->Session->setFlash(__('The stylistusermeasurements could not be saved. Please, try again.'), 'flash');
            }

        }  else {
            $options = array('conditions' => array('UserSizeInformation.' . $UserSizeInformation->primaryKey => $id));
            $this->request->data = $UserSizeInformation->find('first', $options);
        }

        $customdata = $UserSizeInformation->find('all',array('conditions'=>array('UserSizeInformation.user_id'=>$clientid,'UserSizeInformation.stylist_id'=>$stylistid,)));
        $this->set(compact('userlists','clientid','client','customdata','userprofile'));
    }



    // perticular user custom site measurements

    // public function getusercustomsize($client_id = null){
    //     $User = ClassRegistry::init('User');
    //     $UserSizeInformation = ClassRegistry::init('UserSizeInformation');
    //     //Get user from session to derterminate if user is stylist
    //     $user = $this->getLoggedUser();
    //     $user_id = $user["User"]["id"]; 
    //     $is_admin = $user["User"]["is_admin"];
    //     $is_stylist = $user["User"]["is_stylist"]; 

    //     if($this->request->is('post')){
    //         $this->request->data['UserSizeInformation']['user_id']=$client_id;
    //         $this->request->data['UserSizeInformation']['stylist_id']=$user_id;
    //         $custom_shirt_serialize = serialize($this->request->data['UserSizeInformation']['custom_shirt_measurement']);
    //         $custom_jacket_serialize = serialize($this->request->data['UserSizeInformation']['custom_jacket_measurement']);
    //         $custom_trouser_serialize = serialize($this->request->data['UserSizeInformation']['custom_trouser_measurement']);
    //         $custom_vest_serialize = serialize($this->request->data['UserSizeInformation']['custom_vest_measurement']);
    //         $this->request->data['UserSizeInformation']['custom_shirt_measurement'] = $custom_shirt_serialize;
    //         $this->request->data['UserSizeInformation']['custom_jacket_measurement'] = $custom_jacket_serialize;
    //         $this->request->data['UserSizeInformation']['custom_trouser_measurement'] = $custom_trouser_serialize;
    //         $this->request->data['UserSizeInformation']['custom_vest_measurement'] = $custom_vest_serialize;
    //             $UserSizeInformation->save($this->request->data);
    //             $this->Session->setFlash("User Data Hasbeen Saved");
    //             $this->redirect('/messages/getusercustomsize/'.$client_id);
            

    //     }

    // }

// stylist user activity feed perticuler user

    public function stylistUserActivityFeed($clientid = null) {
        $User = ClassRegistry::init('User');
        $Post = ClassRegistry::init('Post');
        $stylist = $this->getLoggedUser();
        $stylistid = $stylist["User"]["id"];
        $client = $User->findById($clientid);
        $clientid = $client['User']['id'];

        $posts = $Post->find('all', array('conditions'=>array(
                                            'OR' =>
                                            array(
                                            'AND' => array(
                                                          array('Post.is_like' => true),
                                                          array('Post.stylist_id' => $stylistid,'Post.user_id'=>$clientid,)
                                                    ),

                                                          array('Post.is_message' => true,
                                                          'Post.stylist_id' => $stylistid,'Post.user_id'=>$clientid,),
                                                          array('Post.is_outfit' => true,
                                                          'Post.stylist_id' => $stylistid,'Post.user_id'=>$clientid,),

                                                   
                                            ),
                              ),'fields' => array('Post.id','Post.user_id'),));
        //print_r($post);
        //exit;
        $useractivitys = array();
        foreach ($posts as  $post) {
                $post_id[] =  $post['Post']['id'];
                $like_user_id[] = $post['Post']['user_id'];
        }

        $like = ClassRegistry::init('Like');
        $likes = $like->find('all', array('conditions' => array('Like.post_id' => $post_id)));
        foreach ($likes as  $likes) {
                $like_product_id[] = $likes['Like']['product_entity_id'];
                
        }
        $like_product_list = array();
        $Entity = ClassRegistry::init('Entity');
        $entity_list = $Entity->getMultipleById($like_product_id);
        $like_product_list = array(
                'like_post_id' => $post_id,
                'like_product_id' => $like_product_id,
                'like_product' => $entity_list 
            );
        print_r($like_product_list);



                // $username = $User->find('all', array('conditions'=>array('User.id'=>$like_user_id)));
                // $userdetails = array();
                // foreach ($username as  $username) {
                //     $userdetails = $username['User']['first_name'];
                // }
                // $like = ClassRegistry::init('Like');
                // $likes = $like->find('all', array('conditions' => array('Like.post_id' => $post_id)));
                // $like_product_id = array();
                // foreach ($likes as  $likes) {
                //         $like_product_id = $likes['Like']['product_entity_id'];
                        
                // }
                // $Entity = ClassRegistry::init('Entity');
                // $entity_list = $Entity->getMultipleById($like_product_id);
                
                // $Message = ClassRegistry::init('Message');
                // $messages[] = $Message->find('all', array('conditions'=>array('Message.post_id'=>$post_id)));
                
                // $Outfit = ClassRegistry::init('Outfit');
                // $outfits = $Outfit->find('all', array('conditions'=>array('Outfit.post_id'=>$post_id,)));
                // $styoutfitid = array();
                // foreach ($outfits as $outfits) {
                //       $styoutfitid[] = $outfits['Outfit']['id'];
                // }
                
                // $OutfitItem = ClassRegistry::init('OutfitItem');
                // $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $styoutfitid)));
                
                // $outfitentities = array();
                // foreach($outfit as $value){
                // $outfitentities[] = $value['OutfitItem']['product_entity_id'];
                // }
                // $outfitentity_list = $Entity->getMultipleById($outfitentities);

                $useractivitys[] = array(
                                //'entities'  => $entity_list,
                                //'Post_user_id' =>  $like_user_id,
                                //'userdetails' => $userdetails,
                                //'Message' => $messages,
                                //'outfitlist' => $outfitentity_list,
                                //'Outfitname' => $outfits
                                );
                
        
        //print_r($useractivitys);






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

    // public function copyoutfituser($user_id = null){
    //     $User =  ClassRegistry::init('User');
    //     $posts = ClassRegistry::init('Post');
    //     $Useroutfit = ClassRegistry::init('Useroutfit');
    //     $user = $this->getLoggedUser();
    //     $user_id = $user["User"]["id"]; 
    //     $is_admin = $user["User"]["is_admin"];
    //     $is_stylist = $user["User"]["is_stylist"]; 
    //     if($this->request->is('post')){
    //                 $outfitid = $this->request->data['OutfitItem']['outfit_id'];
    //                 $clientid = $this->request->data['Useroutfit']['user_id'];
    //                 $this->request->data['Post']['user_id'] = $clientid;
    //                 $this->request->data['Post']['stylist_id'] = $user_id;
    //                 $this->request->data['Post']['is_outfit'] = '1';
    //                 $posts->save($this->request->data);
    //                 $post_id = $posts->getLastInsertID();
    //                 $Useroutfit->data['Useroutfit']['outfit_id'] = $outfitid;
    //                 $Useroutfit->data['Useroutfit']['user_id'] = $clientid;
    //                 $Useroutfit->data['Useroutfit']['stylist_id'] = $user_id;
    //                 $Useroutfit->data['Useroutfit']['post_id'] = $post_id;
    //         if($Useroutfit->save($this->request->data)){
    //                 $this->Session->setFlash("User Data Hasbeen Saved");
    //                 $this->redirect('/messages/getstylistoutfit/'.$user_id);
    //         }
    //     }
    // }

    public function reuseOutfit($user_id = null){
        $User =  ClassRegistry::init('User');
        $Post = ClassRegistry::init('Post');
        $CopyUserOutfit = ClassRegistry::init('CopyUserOutfit');
        $user = $this->getLoggedUser();
        $user_id = $user["User"]["id"]; 
        $is_admin = $user["User"]["is_admin"];
        $is_stylist = $user["User"]["is_stylist"]; 
        if($this->request->is('post')){
                    $outfitid = $this->request->data['outfit_id'];
                    $clientid = $this->request->data['user_id'];
                    $stylistid = $this->request->data['stylist_id'];
                    $this->request->data['Post']['user_id'] = $clientid;
                    $this->request->data['Post']['stylist_id'] = $stylistid;
                    $this->request->data['Post']['is_outfit'] = '1';
                    $Post->save($this->request->data);
                    $post_id = $Post->getLastInsertID();
                    $CopyUserOutfit->data['CopyUserOutfit']['outfit_id'] = $outfitid;
                    $CopyUserOutfit->data['CopyUserOutfit']['user_id'] = $clientid;
                    $CopyUserOutfit->data['CopyUserOutfit']['stylist_id'] = $stylistid;
                    $CopyUserOutfit->data['CopyUserOutfit']['post_id'] = $post_id;
            $CopyUserOutfit->save($this->request->data);
                $submitdata = "User Data Hasbeen Saved";
                echo  json_encode($submitdata);
                exit;
        }
    }
// stylist all user sales


    public function stylistallusersales($clientid = null) {
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
        $userlists = $User->find('all',array('conditions'=>array('User.stylist_id'=>$user_id,),'fields'=>array('User.id,User.updated','User.first_name','User.last_name','User.stylist_id','User.profile_photo_url')));
        $find_array2 = array(
                'fields' => array('count(User.id) as usercount'),
                'joins' => array(
                array(
                    'conditions' => array(
                        'User.is_stylist' => true,
                        'User1.stylist_id = User.id',
                        'User.id' => $user_id
                    ),
                    'table' => 'users',
                    'alias' => 'User1',
                    'type' => 'INNER',
                  ),
                ),
                'group' => array('User.id',),
            );
        $userclient = $User->find('all',$find_array2);
        $postvalue = $posts->find('all', array('conditions'=>array('Post.is_order'=>true)));
        $saleshistory = array();
        foreach ($postvalue as  $postvalue) {
            $post_id = $postvalue['Post']['id'];
            $orderlist = $Order->find('all', array('conditions'=>array('Order.post_id'=>$post_id)));
            foreach ($orderlist as $orderlist) {
               $orderuserid =  $orderlist['Order']['user_id'];
               $orderid =  $orderlist['Order']['id'];
            }
            $username = $User->getByID($orderuserid);
            $orderdetailsuser = $OrderItem->getUserPurchaseDetail($orderid);
            foreach ($orderdetailsuser as $orderdetailsuser) {
             $productid = $orderdetailsuser['OrderItem']['product_entity_id'];
            }
            $productdetail = $Product->findById($productid);
            $brand_id = $productdetail['Product']['brand_id'];
                
            $Brand = classRegistry::init('Brand');
            $branddetails = $Brand->find('all',array('conditions'=>array('Brand.id'=>$brand_id)));
            

             $saleshistory[] = array(
                'orderlist' =>  $orderlist,
                'userdetail' => $username,
                'orderdetailsuser' => $orderdetailsuser,
                'brand' => $branddetails
               
            );
        }
        $totalSale = $Order->find('all',array('conditions'=>array('Order.user_id'=>$orderuserid,'Order.post_id'=>$post_id,),'fields'=>array('sum(Order.final_price) as finalamount')));
            
        $this->set(compact('saleshistory','userclient','totalSale','userlists','clientid'));

    }


    // stylist all user sales


    public function stylisteachusersales($clientid = null) {
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
        $userlists = $User->find('all',array('conditions'=>array('User.stylist_id'=>$user_id,),'fields'=>array('User.id,User.updated','User.first_name','User.last_name','User.stylist_id','User.profile_photo_url')));
        $client = $User->findById($clientid);

        $find_array2 = array(
                'fields' => array('count(User.id) as usercount'),
                'joins' => array(
                array(
                    'conditions' => array(
                        'User.is_stylist' => true,
                        'User1.stylist_id = User.id',
                        'User.id' => $user_id
                    ),
                    'table' => 'users',
                    'alias' => 'User1',
                    'type' => 'INNER',
                  ),
                ),
                'group' => array('User.id',),
            );
        $userclient = $User->find('all',$find_array2);
        //print_r($userclient);die;
        $postvalue = $posts->find('all', array('conditions'=>array('Post.is_order'=>true,'Post.user_id'=>$clientid,)));
       
        $saleshistory = array();
        foreach ($postvalue as  $postvalue) {
            $post_id = $postvalue['Post']['id'];
            
            $orderlist = $Order->find('all', array('conditions'=>array('Order.post_id'=>$post_id,'Order.user_id'=>$clientid,'Order.post_id != "" ',)));
            
            $username = $User->getByID($clientid);
            $orderdetailsuser = $OrderItem->getEachUserPurchasingData($clientid,$post_id);
            //print_r($orderdetailsuser);
            foreach ($orderdetailsuser as $orderdetailsuser) {
                $productid[] = $orderdetailsuser['OrderItem']['product_entity_id'];
            }
            //print_r($productid);
            $productdetail = $Product->findById($productid);
            //print_r($productdetail);
            $brand_id = $productdetail['Product']['brand_id'];
                
            $Brand = classRegistry::init('Brand');
            $branddetails = $Brand->find('all',array('conditions'=>array('Brand.id'=>$brand_id)));
            

             $saleshistory[] = array(
                'orderlist' =>  $orderlist,
                'userdetail' => $username,
                'orderdetailsuser' => $orderdetailsuser,
                'brand' => $branddetails,
                //'totalSale' => $totalSale
            );
        }
       //print_r($saleshistory);
        $totalSale = $Order->find('all',array('conditions'=>array('Order.user_id'=>$clientid,'Order.post_id'=>$post_id,),'fields'=>array('sum(Order.final_price) as finalamount')));
            
        $this->set(compact('saleshistory','userclient','totalSale','userlists','clientid','client'));

    }


    // public function getstylistsales($user_id = null) {
    //     $User = ClassRegistry::init('User');
    //     $posts = ClassRegistry::init('Post');
    //     $Useroutfit = ClassRegistry::init('Useroutfit');
    //     $Order = ClassRegistry::init('Order');
    //     $Entity = ClassRegistry::init('Entity');
    //     $OrderItem = ClassRegistry::init('OrderItem');
    //     $Product = classRegistry::init('Product');
    //     $user = $this->getLoggedUser();
    //     $user_id = $user["User"]["id"]; 
    //     $is_admin = $user["User"]["is_admin"];
    //     $is_stylist = $user["User"]["is_stylist"];

    //     $postvalue = $posts->find('all', array('conditions'=>array('Post.is_order'=>true)));
    //     $saleshistory = array();
    //     foreach ($postvalue as $key => $postvalue) {

    //         $post_id = $postvalue['Post']['id'];
    //         $orderlist = $Order->find('all', array('conditions'=>array('Order.post_id'=>$post_id)));
    //         foreach ($orderlist as $orderlist) {

    //            $orderuserid =  $orderlist['Order']['user_id']; 
    //         }
    //         $username = $User->getByID($orderuserid);
    //         $orderdetailsuser = $OrderItem->getUserPurchaseDetail($orderuserid);
    //         foreach ($orderdetailsuser as $orderdetailsuser) {
            
    //         $productid[] = $orderdetailsuser['OrderItem']['product_entity_id'];
            
    //         }
    //         $productdetail = $Product->findById($productid);
    //         $brand_id = $productdetail['Product']['brand_id'];
                
    //         $Brand = classRegistry::init('Brand');
    //         $branddetails = $Brand->find('all',array('conditions'=>array('Brand.id'=>$brand_id)));


    //         //print_r($prid);exit;

    //         $saleshistory[] = array(
    //             'orderlist' =>  $orderlist,
    //             'userdetail' => $username,
    //             'orderdetailsuser' => $orderdetailsuser,
    //             'brand' => $branddetails
    //         );
    //     } 
    //     print_r($saleshistory);
    //     die;
    //     $this->set('saleshistory',$saleshistory);
    // }

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
            $this->request->data['Post']['is_request_outfit'] = '1';
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



// stylist user likes


    public function stylistuserlikes($clientid = null) {
        $this->isLogged();
        $User= ClassRegistry::init('User');
        $client = $User->findById($clientid);
        $clientid = $client['User']['id'];
        $stylist_id = $client['User']['stylist_id'];
        $current_user = $this->getLoggedUser();
        $userlists = $User->find('all',array('conditions'=>array('User.stylist_id'=>$stylist_id,),'fields'=>array('User.id,User.updated','User.first_name','User.last_name','User.stylist_id','User.profile_photo_url')));
       

        $Wishlist = ClassRegistry::init('Wishlist');
        $Entity = ClassRegistry::init('Entity'); 
        $liked_list = $Wishlist->getUserLikeProduct($clientid);
                $entity_list = array();
                foreach($liked_list as $value){
                    $entity_list[] = $value['Wishlist']['product_entity_id'];
                    $last_item_id = $value['Wishlist']['id'];
                }
        ///$likeitems = $Entity->getEntitiesByIdLikes($entity_list, $clientid);
        
        //pagination
        $find_array = array(
             'limit' => 10,
            'contain' => array('Image'),
            'conditions' => array(
                'Entity.show' => true,
                'Entity.id' => $entity_list
            ),
            'joins' => array(
                array('table' => 'products',
                    'alias' => 'Product',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.id = Entity.product_id'
                    )
                ),
                array('table' => 'brands',
                    'alias' => 'Brand',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.brand_id = Brand.id'
                    )
                ),

              
            ),
            'fields' => array(
                'Entity.*', 'Product.*', 'Brand.*',
            ),
            'order' => array('FROM_UNIXTIME(Wishlist.created) DESC'),

           
        );
        
       
        if($clientid){
            $find_array['joins'][] = array('table' => 'wishlists',
                                        'alias' => 'Wishlist',
                                        'type' => 'LEFT',
                                        'conditions' => array(
                                            'Wishlist.user_id' => $clientid,
                                            'Wishlist.product_entity_id = Entity.id'
                                        ),
                                        
                                        
                                    );
        $find_array['joins'][] = array('table' => 'outfits',
                    'alias' => 'Outfit',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Outfit.id = Wishlist.outfit_id',
                    )
                );

            
        
            $find_array['fields'][] = 'Wishlist.*';
            $find_array['fields'][] = 'Outfit.*';

             
        }
        //pagiantion


        $this->Paginator->settings = $find_array;
        $likeitems = $this->Paginator->paginate($Entity);

        $this->set(compact('likeitems','clientid','client','userlists'));
    }


    public function userLikes($user_id = null){
         $this->isLogged();
         $User= ClassRegistry::init('User');
         $user = $User->findById($user_id);

         $stylist_id = $user['User']['stylist_id'];
         
        $current_user = $this->getLoggedUser();

        if($user_id != $current_user['User']['id'] && !$current_user['User']['is_admin'] && $current_user['User']['id'] != $user['User']['stylist_id']){
            $this->redirect('/');
            exit;
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
                

        $Userdata=$User->find('all',$find_array);
        $Wishlist = ClassRegistry::init('Wishlist');
        $Entity = ClassRegistry::init('Entity'); 
        $liked_list = $Wishlist->getUserLikeProduct($user_id);
        
                $entity_list = array();
                foreach($liked_list as $value){
                    $entity_list[] = $value['Wishlist']['product_entity_id'];
                    $last_item_id = $value['Wishlist']['id'];
                    
                }

        ///$likeitems = $Entity->getEntitiesByIdLikes($entity_list, $user_id);
        
        //pagination
        $find_array = array(
             'limit' => 10,
            'contain' => array('Image'),
            'conditions' => array(
                'Entity.show' => true,
                'Entity.id' => $entity_list
            ),
            'joins' => array(
                array('table' => 'products',
                    'alias' => 'Product',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.id = Entity.product_id'
                    )
                ),
                array('table' => 'brands',
                    'alias' => 'Brand',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.brand_id = Brand.id'
                    )
                ),

              
            ),
            'fields' => array(
                'Entity.*', 'Product.*', 'Brand.*',
            ),
            'order' => array('FROM_UNIXTIME(Wishlist.created) DESC'),

           
        );
        
       
        if($user_id){
            $find_array['joins'][] = array('table' => 'wishlists',
                                        'alias' => 'Wishlist',
                                        'type' => 'LEFT',
                                        'conditions' => array(
                                            'Wishlist.user_id' => $user_id,
                                            'Wishlist.product_entity_id = Entity.id'
                                        ),
                                        
                                        
                                    );
        // $find_array['joins'][] = array('table' => 'outfits',
        //             'alias' => 'Outfit',
        //             'type' => 'INNER',
        //             'conditions' => array(
        //                 'Outfit.id = Wishlist.outfit_id',
        //             )
        //         );

            
        
            $find_array['fields'][] = 'Wishlist.*';
            // $find_array['fields'][] = 'Outfit.*';

             
        }
        //pagiantion

        $likeitems = $Entity->find('all',$find_array);
        $likeitemscount = count($likeitems);
        //$this->Paginator->settings = $find_array;
        //$likeitems = $this->Paginator->paginate($Entity);
        //print_r($likeitems);
        $this->set(compact('likeitems','user_id','Userdata','likeitemscount'));
        //$this->render('userlikes');
    }

    
    public function userLikesAsc($user_id = null){
        $Wishlist = ClassRegistry::init('Wishlist');
        $Entity = ClassRegistry::init('Entity'); 
        
        if(isset($this->request->data['valueSelected'])){
            $sortingorder = $this->request->data['valueSelected'];
        }else{
            $sortingorder = 'DESC';
        }
        $liked_list = $Wishlist->getUserLikeProductAsc($user_id);
                $entity_list = array();
                foreach($liked_list as $value){
                    $entity_list[] = $value['Wishlist']['product_entity_id'];
                    $last_item_id = $value['Wishlist']['id'];
                    
                }
        //pagination
        if(isset($this->request->data['totalProductCount'])){
            $totalProductCount = $this->request->data['totalProductCount'];
        }else{
            $totalProductCount = 0;
        }
        $find_array = array(
            'limit'=> 10,
            'offset'=>$totalProductCount, 
            'contain' => array('Image'),
            'conditions' => array(
                'Entity.show' => true,
                'Entity.id' => $entity_list
            ),
            'joins' => array(
                array('table' => 'products',
                    'alias' => 'Product',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.id = Entity.product_id'
                    )
                ),
                array('table' => 'brands',
                    'alias' => 'Brand',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.brand_id = Brand.id'
                    )
                ),
            ),
            'fields' => array(
                'Entity.*', 'Product.*', 'Brand.*',
            ),
            'order' => array('FROM_UNIXTIME(Wishlist.created)' => $sortingorder),
            
        );
        
        
        if($user_id){
            $find_array['joins'][] = array('table' => 'wishlists',
                                        'alias' => 'Wishlist',
                                        'type' => 'LEFT',
                                        'conditions' => array(
                                            'Wishlist.user_id' => $user_id,
                                            'Wishlist.product_entity_id = Entity.id'
                                        ),
                                        
                                    );
            $find_array['joins'][] = array('table' => 'outfits',
                    'alias' => 'Outfit',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Outfit.id = Wishlist.outfit_id',
                    )
                );

            
            $find_array['fields'][] = 'Wishlist.*';
            $find_array['fields'][] = 'Outfit.*';
             
        }

        //pagination        
        //$likeitems = $Entity->getEntitiesByIdLikesAsc($entity_list, $user_id, $sortingorder);
        //$this->Paginator->settings = $find_array;
        //$likeitems = $this->Paginator->paginate($Entity);
        $likeitems = $Entity->find('all',$find_array);
        echo json_encode($likeitems);
        exit;
        
    }

// stylist user purchase

    public function stylistuserpurchase($clientid = null) {
        $this->isLogged();
            $User= ClassRegistry::init('User');
            $client = $User->getById($clientid);
            $clientid = $client['User']['id'];
            $stylist_id = $client['User']['stylist_id'];
            $userlists = $User->find('all',array('conditions'=>array('User.stylist_id'=>$stylist_id,),'fields'=>array('User.id,User.updated','User.first_name','User.last_name','User.stylist_id','User.profile_photo_url')));
       

            $OrderItem = ClassRegistry::init('OrderItem');
            $Entity = ClassRegistry::init('Entity'); 
            $total_purchases = $OrderItem->getTotalUserPurchaseCount($clientid);
            //print_r($total_purchases);
            if($total_purchases > 0){
                $order_item_list = $OrderItem->getUniqueUserItemPurchase($clientid);
                //print_r($order_item_list);
                $entity_list = array();
                foreach($order_item_list as $value){
                    $entity_list[] = $value['Orders']['product_entity_id'];
                    $last_item_id = $value['Orders']['order_id'];
                }
                print_r($entity_list);

            $purchases = $Entity->getEntitiesByIdPurchaseDes($entity_list);
            //print_r($purchases);
        }
        $this->set(compact('purchases','clientid','client','userlists'));

    }


    public function userPurchases($user_id = null){
            $this->isLogged();
            $User= ClassRegistry::init('User');
            $user = $User->getById($user_id);
            $current_user = $this->getLoggedUser();

            if($user_id != $current_user['User']['id'] && !$current_user['User']['is_admin'] && $current_user['User']['id'] != $user['User']['stylist_id']){
                $this->redirect('/');
                exit;
            }
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
        $this->isLogged();
        $User = ClassRegistry::init('User');
        $user = $this->getLoggedUser();
        $user_id = $user["User"]["id"]; 
        $user = $User->findById($user_id);
        $is_admin = $user["User"]["is_admin"];
        $is_stylist = $user["User"]["is_stylist"];
        
         $current_user = $this->getLoggedUser();
        if($user_id != $current_user['User']['id'] && !$current_user['User']['is_admin'] && $current_user['User']['id'] != $user['User']['stylist_id']){
            $this->redirect('/');
            exit;
        }
        //Get user from session to derterminate if user is stylist
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
        $Outfit = ClassRegistry::init('Outfit');
        $outfitname = $Outfit->findById($outfit_id);
        $OutfitItem = ClassRegistry::init('OutfitItem');
        $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $outfit_id)));
        $Message = ClassRegistry::init('Message');
        $messages_outfit_comments = $Message->find('first',array('conditions'=>array('Message.outfit_id'=>$outfit_id,'Message.is_outfit'=>true,),'fields'=>array('Message.body as stylist_comments')));
        $entity_list = array();
            foreach($outfit as $value){
                $entity_list[] = $value['OutfitItem']['product_entity_id'];
                $size_list[] = $value['OutfitItem']['size_id'];
            }

            $Entity = ClassRegistry::init('Entity');

            // get data
            $entity = $Entity->getMultipleById($entity_list, $user_id,$outfit_id);
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
                //print_r($entities);
            $this->set(compact('outfit_id','messages_outfit_comments', 'entities','outfitname', 'size_list', 'user_id', 'msg', 'second_user', 'second_user_id', 'is_admin', 'is_stylist', 'show_add_cart_popup','show_three_item_popup', 'popUpMsg','Userdata'));
           
    }


    //stylist outfit details

    public function stylistOutfitsDetails($outfit_id = null) {
        $User = ClassRegistry::init('User');
        $user = $this->getLoggedUser();
        $user_id = $user["User"]["id"]; 
        $user = $User->findById($user_id);
        $is_admin = $user["User"]["is_admin"];
        $is_stylist = $user["User"]["is_stylist"];
        $Outfit = ClassRegistry::init('Outfit');
        $outfitname = $Outfit->findById($outfit_id);
        $userlists = $User->find('all',array('conditions'=>array('User.stylist_id'=>$user_id,),'fields'=>array('User.id,User.updated','User.first_name','User.last_name','User.stylist_id','User.profile_photo_url')));
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

            $this->set(compact('userlists','entities','outfitname', 'size_list', 'user_id', 'msg', 'second_user', 'second_user_id', 'is_admin', 'is_stylist', 'show_add_cart_popup','show_three_item_popup', 'popUpMsg'));

    }

    public function userprofiles($user_id = null) {
        $this->isLogged();
        $User = ClassRegistry::init('User');
        $user = $User->findById($user_id);
        $current_user = $this->getLoggedUser();
        
        if($user_id != $current_user['User']['id'] && !$current_user['User']['is_admin'] && $current_user['User']['id'] != $user['User']['stylist_id'] || $user_id != $current_user['User']['id'] ){
            $this->redirect('/');
            exit;
        }
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


    //stylist create outfits

    public function stylistCreateOutfits($clientid=null,$outfitid = null) {
        $User = ClassRegistry::init('User');
        $client = $User->findById($clientid);
        $clientname = $client['User']['username'];
        $client_id = $client['User']['id'];
        $current_user = $this->getLoggedUser();
        $stylist_id = $current_user['User']['id'];
        $Category = ClassRegistry::init('Category');
        $Brand = ClassRegistry::init('Brand');
        $Color = ClassRegistry::init('Color');
        $Colorgroup = ClassRegistry::init('Colorgroup');
        $Entity = ClassRegistry::init('Entity');
        $OutfitItem = ClassRegistry::init('OutfitItem');
        $Outfit = ClassRegistry::init('Outfit');
        $Message = ClassRegistry::init('Message');
        // if outfit is reused
        $messages = $Message->find('all',array('conditions'=>array('Message.outfit_id'=>$outfitid),'fields'=>array('Message.body')));
        $outfitname = $Outfit->findById($outfitid);
        $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $outfitid)));
        $entity_list = array();
            foreach($outfit as $value){
                $entity_list[] = $value['OutfitItem']['product_entity_id'];
                $size_list[] = $value['OutfitItem']['size_id'];
            }

        $Entity = ClassRegistry::init('Entity');

            // get data
        $find_array2 = array(
            'contain' => array('Image', 'Color', 'Detail'),
            'conditions' => array('Entity.id' => $entity_list),
            'joins' => array(
                array('table' => 'products',
                    'alias' => 'Product',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.id = Entity.product_id'
                    )
                ),
                array('table' => 'brands',
                    'alias' => 'Brand',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.brand_id = Brand.id',
                    )
                ),        
            ), 
            'fields' => array(
                'Entity.*', 'Product.*', 'Brand.*',
            ),
        );
        $entity = $Entity->find('all',$find_array2);
        //$entity = $Entity->getMultipleById($entity_list, $user_id);
            //print_r($entity);
        $products_list = array();
            foreach ($entity as $key => $value) {
                $products_list[] = $value['Entity']['product_id'];
            }
            $similar_results = $Entity->getSimilarProducts($outfitid, $products_list);
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

        //if outfit is reused
        $find_array = array(
            'limit' => 20,
            'contain' => array('Image', 'Color','Detail'),
            'conditions' => array(
                'Entity.show' => true,
                
            ),
            'joins' => array(
                array('table' => 'products_categories',
                    'alias' => 'Category',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Category.product_id = Entity.product_id'
                    )
                ),
                array('table' => 'products',
                    'alias' => 'Product',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.id = Entity.product_id'
                    )
                ),
                array('table' => 'brands',
                    'alias' => 'Brand',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.brand_id = Brand.id'
                    )
                ),
            ),
            'fields' => array(
                'Entity.*', 'Category.category_id', 'Product.*', 'Brand.*',
            ),
            'order' => 'Category.category_id ASC'
        );

    //$this->Paginator->settings = $find_array;
    //$products = $this->Paginator->paginate($Entity);
    //$pro = $Entity->find('all',$find_array);
    $products = $Entity->find('all',$find_array);
    $ProductRowCount = count($products);
    //print_r($pro);
    $this->set(compact('ProductRowCount','clientname','products','client_id','stylist_id','outfitid','entities','outfitname','messages'));
    }   

    function postOutfit(){
        $ret = array();
        $user_id = $this->getLoggedUserID();
        if($user_id){
            $Entity = ClassRegistry::init('Entity');
            $outfit_array = array();
            $client_id = $this->request->data['user_id'];
            //bhashit code
            $posts = ClassRegistry::init('Post');
            $this->request->data['Post']['user_id'] = $client_id;
            $this->request->data['Post']['stylist_id'] = $user_id;
            $this->request->data['Post']['is_outfit'] = '1';
            $posts->save($this->request->data);
            $post_id = $posts->getLastInsertID();
            //bhashit code
            $outfitid = $this->request->data['outfitid'];
            $outfit_array = explode(',', $outfitid); 
           
            
            $data['Outfit']['user_id'] = $client_id;
            $data['Outfit']['stylist_id'] = $user_id;
            //bhashit code
            $data['Outfit']['post_id'] = $post_id;
            //bhashit code

            //bhashit code start
            
            $out_name = $this->request->data['out_name'];
            $data['Outfit']['outfitname'] = $out_name;
            $outsize_array = array();
            $outsize = $this->request->data['size_id'];
            $outsize_array = explode(',', $outsize);
            
            $outsize_array = array_unique($outsize_array);
            //bhashit code end 

            $outfit_array = array_unique($outfit_array);
            
            if(count($outfit_array) >= 1){
                $Outfit = ClassRegistry::init('Outfit');
                $OutfitItem = ClassRegistry::init('OutfitItem');
                $Useroutfit = ClassRegistry::init('Useroutfit');
                //bhashit code start
                //$data['Outfit']['typeoutfit'] = $typeoutfit;
                $data['Outfit']['outfitname'] = $out_name;


                //bhashit code end
                
                $Outfit->create();
                if($result = $Outfit->save($data)){
                    $outfit_id = $result['Outfit']['id'];
                    $data['OutfitItem']['outfit_id'] = $outfit_id;
                    // $data['Useroutfit']['user_id'] = $client_id;
                    // $data['Useroutfit']['stylist_id'] = $user_id;
                    // $data['Useroutfit']['outfit_id'] = $outfit_id;
                    // //bhashit code
                    //$data['Useroutfit']['post_id'] = $post_id;
                    //bhashit code
                    //$Useroutfit->create();  
                    
                    foreach($outfit_array as $key => $value)
                    {
                        $data['OutfitItem']['product_entity_id'] = $value;
                        //bhashit code
                        $data['OutfitItem']['post_id'] = $post_id;
                        //bhashit code
                        if(isset($outsize_array[$key])){
                            $data['OutfitItem']['size_id'] = $outsize_array[$key];
                            
                        }
                        $OutfitItem->create();
                        $OutfitItem->save($data);
                        //$Useroutfit->save($data);    
                    }

                    
                    
                    $Message = ClassRegistry::init('Message');
                    $data['Message']['user_to_id'] = $client_id;
                    $data['Message']['user_from_id'] = $user_id;
                    $data['Message']['body'] = (isset($this->request->data['outfit_msg']) && $this->request->data['outfit_msg']) ? $this->request->data['outfit_msg'] : "outfit";
                    $data['Message']['is_outfit'] = 1;
                    $data['Message']['outfit_id'] = $outfit_id;
                    $Message->create();
                    if ($Message->validates()) {
                        $Message->save($data);

                        $User = ClassRegistry::init('User');
                        $to_user = $User->getById($client_id);
                        if($to_user['User']['stylist_notification']){
                            $User->disableStylistNotification($client_id);
                        }

                        $this->sendOutfitNotification($outfit_id, $outfit_array, $client_id);
                    }
                    
                    $ret['status'] = "ok";
                }  
            }
            else{
                $ret['status'] = "error";
                $ret['msg'] = "Select atleast one product to create an outfit.";    
            }
        }
        else{
            $ret['status'] = "redirect";
        }

        echo json_encode($ret);
        exit;    
    }


    //client likes ajax 
    public function getUserLikeAjax($clientid=null){
    
        $this->isLogged();
        $User= ClassRegistry::init('User');
        $client = $User->findById($clientid);
        $clientid = $client['User']['id'];
        $stylist_id = $client['User']['stylist_id'];
        $Wishlist = ClassRegistry::init('Wishlist');
        $Entity = ClassRegistry::init('Entity'); 
        $liked_list = $Wishlist->getUserLikeProduct($clientid);
                $entity_list = array();
                foreach($liked_list as $value){
                    $entity_list[] = $value['Wishlist']['product_entity_id'];
                    $last_item_id = $value['Wishlist']['id'];
                }
                
        $likeitems = $Entity->getOutfitClientLikes($entity_list, $clientid);
        echo json_encode($likeitems);
        exit;
    }

    //client likes ajax 
    public function getStylistLikeAjax($stylist_id=null){
    
        $this->isLogged();
        $User= ClassRegistry::init('User');
        $client = $User->findById($stylist_id);
        $clientid = $client['User']['id'];
        $stylist_id = $client['User']['stylist_id'];
        $Wishlist = ClassRegistry::init('Wishlist');
        $Entity = ClassRegistry::init('Entity'); 
        $liked_list = $Wishlist->getUserLikeProduct($stylist_id);
                $entity_list = array();
                foreach($liked_list as $value){
                    $entity_list[] = $value['Wishlist']['product_entity_id'];
                    $last_item_id = $value['Wishlist']['id'];
                }
        $likeitems = $Entity->getOutfitStylistLikes($entity_list, $stylist_id);
        
        echo json_encode($likeitems);
        exit;
    }
    
    public function setFinalOutfitData(){

        if($this->request->is('post')){
            $outfit_array = array();
            $outfitid = $this->request->data['outfitid'];

            $outfit_array = explode(',', $outfitid); 
            $out_name = $this->request->data['out_name'];
            $data['Outfit']['outfitname'] = $out_name;
            $outsize_array = array();
            $outsize = $this->request->data['size_id'];
            $outsize_array = explode(',', $outsize);
            $outsize_array = array_unique($outsize_array);
            $outimg_array = array();
            $outimg = $this->request->data['src'];
            $outimg_array = explode(',', $outimg);
            $outimg_array = array_unique($outimg_array);
            //bhashit code end 

            $outfit_array = array_unique($outfit_array);
            $outfitid = $this->request->data['outfit_msg'];

            //$mydata = array();

            $mydata[]  = array(
                    'outfitname' =>$out_name,
                    'outfitid' => $outfit_array,
                    'outfit_size' =>$outsize_array,
                    'src' =>$outimg_array

                );
            echo json_encode($mydata);
            exit;

        }
    }

    // outfit closet ajax data 
    public function closetAjaxProductData($user_id = null) {
        
        
        if(isset($this->request->data['last_limit'])){
            $last_product_id = $this->request->data['last_limit'];
        }else{
            $last_product_id = '0';
        }   
        $Category = ClassRegistry::init('Category');
        $Brand = ClassRegistry::init('Brand');
        $Color = ClassRegistry::init('Color');
        $Colorgroup = ClassRegistry::init('Colorgroup');
        $Entity = ClassRegistry::init('Entity');
        if(isset($this->request->data['sorting'])){
            $sorting = $this->request->data['sorting'];
        }else{
            $sorting = 'DESC';
        }
        if(isset($this->request->data['closettextsearch'])){
            $closettextsearch = $this->request->data['closettextsearch'];
        }else{
            $closettextsearch = '';
        }

        $productSearchs = $Entity->find('all',array('conditions'=>array('Entity.name Like' => '%' . $closettextsearch . '%',)));
        $entities = array();
        foreach ($productSearchs as $productSearch) {
            $entities[] = $productSearch['Entity']['id'];
        }
        
        if(isset($this->request->data['closettextsearch'])){
            $entitiesData = array('Entity.id' => $entities);
        }else{
            $entitiesData = '';
        }

        //print_r($productSearch);
        //exit;
        $find_array = array(
            'limit' => 20,
            'offset'=> $last_product_id,
            'contain' => array('Image', 'Color','Detail'),
            'conditions' => array(
             'Entity.show' => true,
              $entitiesData
             ),
            'joins' => array(
                array('table' => 'products_categories',
                    'alias' => 'Category',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Category.product_id = Entity.product_id'
                    )
                ),
                array('table' => 'products',
                    'alias' => 'Product',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.id = Entity.product_id'
                    )
                ),
                array('table' => 'brands',
                    'alias' => 'Brand',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.brand_id = Brand.id'
                    )
                ),
            ),
            'fields' => array(
                'Entity.*', 'Category.category_id', 'Product.*', 'Brand.*',
            ),
            'order' => array('Entity.created' => $sorting),
            'Group' => 'Entity.id',
        );

    // if($closettextsearch){
    //             $closettextsearch_join = array('table' => 'products_entities',
    //                 'alias' => 'Entity',
    //                 'type' => 'INNER',
    //                 'conditions' => array(
    //                     'Entity.id' => $entities,
    //                 )
    //             );
    //             $find_array['joins'][] = $closettextsearch_join;
    //         }
    $products = $Entity->find('all',$find_array);

    echo json_encode($products);
    exit;
    }





//closetAjaxColorProductSearchData
    public function closetAjaxColorProductSearchData($colorid=null,$brandid=null,$subcategoryid=null){
        $this->layout = 'ajax';
        $Category = ClassRegistry::init('Category');
        $Brand = ClassRegistry::init('Brand');
        $Color = ClassRegistry::init('Color');
        $Colorgroup = ClassRegistry::init('Colorgroup');
        $Entity = ClassRegistry::init('Entity');
        
        $find_array = array(
            'limit' => 10,
            'contain' => array('Image', 'Color'),
            'conditions' => array(
                'Entity.show' => true 
            ),
            'group' => array('Entity.id'),
            'joins' => array(
                array('table' => 'products_categories',
                    'alias' => 'Category',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Category.product_id = Entity.product_id'
                    )
                ),
                array('table' => 'products',
                    'alias' => 'Product',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.id = Entity.product_id'
                    )
                ),
                array('table' => 'brands',
                    'alias' => 'Brand',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.brand_id = Brand.id'
                    )
                ),
            ),
            'order' => array('Entity.order' => 'ASC'),
            'fields' => array('Entity.*', 'Product.*', 'Brand.*', 'Category.category_id'),
            'Group' => array('Entity.id'),
        );
    //for color

    
    $colorid = $this->request->data['colorid'];
    $colorids = explode(',', $colorid);
    if($colorid){
                $color_join = array('table' => 'colors_entities',
                    'alias' => 'Color1',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Color1.color_id' => $colorids,
                        'Color1.product_entity_id = Entity.id'
                    )
                );
                $find_array['joins'][] = $color_join;
            }
    

    //for brand
    $brandid = $this->request->data['brandid'];
    $brandids = explode(',', $brandid);
    if($brandid){
        
            $find_array['conditions']['Product.brand_id'] = $brandids;
        }
    //for subcategoryid
    $subcategoryid = $this->request->data['subcategoryid'];
    $subcategoryids = explode(',', $subcategoryid);

    if($subcategoryid){
            $subcategoryid_join = array('table' => 'products_categories',
                'alias' => 'ProductCategory',
                'type' => 'INNER',
                'conditions' => array(
                    'ProductCategory.category_id' => $subcategoryids,
                    'ProductCategory.product_id = Entity.id'
                )
            );
            $find_array['joins'][] = $subcategoryid_join;
        }
    $this->Paginator->settings = $find_array;
    $products = $this->Paginator->paginate($Entity);
    //$products = $Entity->find('all',$find_array);
    echo json_encode($products);
    exit;
    }

   //stylistTotalOutfitSortByName ajax


    public function stylistFilterOutfitListName($user_id = null){

        $User = ClassRegistry::init('User');
        
        //Get user from session to derterminate if user is stylist
           
        $Message = ClassRegistry::init('Message');
        $Outfit = ClassRegistry::init('Outfit');
        $posts = ClassRegistry::init('Post');
        
        $my_outfitss = array();
        $stylistoutfit= $Outfit->find('all', array('conditions'=>array('Outfit.stylist_id'=>$user_id,),'fields'=> array('Outfit.outfit_name','Outfit.id'),'order'=>array('Outfit.outfit_name')));
        
        foreach($stylistoutfit as $row){
            $stylist_outfit_id = $row['Outfit']['id'];
            $Outfit = ClassRegistry::init('Outfit');
            $outfitnames = $Outfit->find('first', array('conditions'=> array('Outfit.id'=>$stylist_outfit_id)));
            $messages = $Message->find('all',array('conditions'=>array('Message.outfit_id'=>$stylist_outfit_id,),'fields'=>array('Message.body')));
            $OutfitItem = ClassRegistry::init('OutfitItem');
            $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $stylist_outfit_id)));
            $entities = array();
            foreach($outfit as $value){
                    $entities[] = $value['OutfitItem']['product_entity_id'];
                }
            $Entity = ClassRegistry::init('Entity');
            

            //pagintion
            $find_array = array(

                'contain' => array('Image'),
                'conditions' => array('Entity.id' => $entities),
                'joins' => array(
                    array('table' => 'products',
                        'alias' => 'Product',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Product.id = Entity.product_id'
                        )
                    ),
                    array('table' => 'brands',
                        'alias' => 'Brand',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Product.brand_id = Brand.id',
                        )
                    ),        
                ), 
                
                'fields' => array(
                    'Entity.id','Entity.price','Brand.name',
                ),

            );
            
            $items = $Entity->find('all',$find_array);
            $my_outfitss[] =  array(
                                'outfit'    => $outfitnames,
                                'comments' => $messages,
                                'entities'  => $items
                            );

        }
        echo json_encode($my_outfitss);
        exit;
    }


    //stylistFilterOutfitDate
    public function stylistFilterOutfitDate($user_id = null){

        $User = ClassRegistry::init('User');
        
        //Get user from session to derterminate if user is stylist
           
        $Message = ClassRegistry::init('Message');
        $Outfit = ClassRegistry::init('Outfit');
        $posts = ClassRegistry::init('Post');
        
        $my_outfitss = array();
        $stylistoutfit= $Outfit->find('all', array('conditions'=>array('Outfit.stylist_id'=>$user_id,),'fields'=> array('Outfit.outfitname','Outfit.id'),'order'=>array('Outfit.created DESC')));
        
        foreach($stylistoutfit as $row){
            $stylist_outfit_id = $row['Outfit']['id'];
            $Outfit = ClassRegistry::init('Outfit');
            $outfitnames = $Outfit->find('first', array('conditions'=> array('Outfit.id'=>$stylist_outfit_id)));
            $messages = $Message->find('all',array('conditions'=>array('Message.outfit_id'=>$stylist_outfit_id,),'fields'=>array('Message.body')));
            $OutfitItem = ClassRegistry::init('OutfitItem');
            $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $stylist_outfit_id)));
            $entities = array();
            foreach($outfit as $value){
                    $entities[] = $value['OutfitItem']['product_entity_id'];
                }
            $Entity = ClassRegistry::init('Entity');
            

            //pagintion
            $find_array = array(
                'limit'=>20,
                'contain' => array('Image'),
                'conditions' => array('Entity.id' => $entities),
                'joins' => array(
                    array('table' => 'products',
                        'alias' => 'Product',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Product.id = Entity.product_id'
                        )
                    ),
                    array('table' => 'brands',
                        'alias' => 'Brand',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Product.brand_id = Brand.id',
                        )
                    ),        
                ), 
                
                'fields' => array(
                    'Entity.id','Entity.price','Brand.name',
                ),

            );
            //$this->Paginator->settings = $find_array;
            $items = $Entity->find('all',$find_array);
            // //pagintion
            $my_outfitss[] =  array(
                                'outfit'    => $outfitnames,
                                'comments' => $messages,
                                'entities'  => $items
                            );

        }
        

        //$this->set(compact('my_outfitss','userlist','user_id'));
        echo json_encode($my_outfitss);
        exit;
    }




    // Stylist Closet Data

    public function Closet($category_slug = null, $filter_brand=null, $filter_color=null, $filter_used = null) {
        
        $user_id = $this->getLoggedUserID();
        // init
        $Category = ClassRegistry::init('Category');
        $Brand = ClassRegistry::init('Brand');
        $Color = ClassRegistry::init('Color');
        $Colorgroup = ClassRegistry::init('Colorgroup');
        $User = ClassRegistry::init('User');
        $Entity = ClassRegistry::init('Entity');
        // get data
        $categories = $Category->getAll();
        $brands = $Brand->find('all', array('order' => "Brand.name ASC"));
        $colors = $Colorgroup->find('all', array('order' => "Colorgroup.name ASC"));

        $entities = array();

        if ($category_slug) {
            $category_slug = trim($category_slug);
            $entities = $this->categoryProducts($user_id, $categories, $category_slug, $filter_brand, $filter_color, $filter_used);
        } else {
            $entities = $this->closetProducts($user_id);
        }
        
        // for closet products data

        $find_array2 = array(
            'limit'=>20,
            'contain' => array('Image', 'Color', 'Detail'),
            //'conditions' => array('Entity.id' => $entity_list),
            'joins' => array(
                array('table' => 'products',
                    'alias' => 'Product',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.id = Entity.product_id'
                    )
                ),
                array('table' => 'brands',
                    'alias' => 'Brand',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.brand_id = Brand.id',
                    )
                ),        
            ), 
            'order' =>array('Entity.created DESC'),
            'fields' => array(
                'Entity.*', 'Product.*', 'Brand.*',
            ),
        );
        
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

        $this->Paginator->settings = $find_array2;
        $products = $this->Paginator->paginate($Entity);
        $ProductRowCount = count($products);
        
        
        // send data to view
        //$products = $Entity->find('all',$find_array2);
        $this->set(compact('entities', 'products','ProductRowCount', 'categories', 'category_slug', 'brands', 'colors', 'user_id','show_closet_popup','show_three_item_popup', 'popUpMsg', 'show_add_cart_popup'));

        if(!$category_slug){
            $this->render('stylistcloset');     
        }
    }


    // closet page quick pop product data

    public function closetAjaxQuickPopData(){
        $this->layout= 'ajax';
        $this->autoRender = false;

        $productid = $this->request->data['productid'];

        $Entity = ClassRegistry::init('Entity');

        $find_array = array(
            'contain' => array('Image', 'Color', 'Detail'),
            'conditions' => array('Entity.id' => $productid),
            'joins' => array(
                array('table' => 'products',
                    'alias' => 'Product',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.id = Entity.product_id'
                    )
                ),
                array('table' => 'brands',
                    'alias' => 'Brand',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.brand_id = Brand.id',
                    )
                ),        
            ), 
            'order' =>array('Entity.created DESC'),
            'fields' => array(
                'Entity.*', 'Product.*', 'Brand.*',
            ),
        );
        $entitydata = $Entity->find('all',$find_array);
        echo json_encode($entitydata);

    }

    public function closetProducts($user_id){
        $Entity = ClassRegistry::init('Entity');
        $Category = ClassRegistry::init('Category');

        $user = $this->getLoggedUser();

        //Get the list of random product list for the closet
        if($user['User']['is_stylist'] || $user['User']['is_admin']){
            $random_list = $Entity->getTeamClosestItems();
        }
        else{
            $random_list = $Entity->getClientClosestItems();    
        }

        
        $entity_list = array();
        $entity_list_cat = array();
        
        $category_list = $Category->find('threaded', array('order' => array('Category.order' => 'ASC')));
        foreach($category_list as $cat){
            $cur_list = array();
            $cur_list[] = $cat['Category']['id'];
            if(count($cat['children'])>0){
                foreach($cat['children'] as $sub){
                    $cur_list[] = $sub['Category']['id'];
                    if(count($sub['children'] > 0)){
                        foreach($sub['children'] as $subsub){
                            $cur_list[] = $subsub['Category']['id'];
                        }
                    }
                }    
            }
            
            foreach($random_list as $item){
                if(in_array($item['pc']['category_id'], $cur_list)){
                    $entity_list[] = $item['pe']['id'];
                    $entity_list_cat[$item['pe']['id']] = array('id' => $item['pe']['id'], 'parent_cat' => $cur_list[0]);
                    break;    
                }    
            }
        }
        
        $unordered_entities = $Entity->getEntitiesById($entity_list, $user_id);
        $entities = array();
        
        foreach($entity_list as $id){
            foreach($unordered_entities as $entity){
                if($id == $entity['Entity']['id']){
                    $entity['Category']['parent_cat'] = $entity_list_cat[$entity['Entity']['id']]['parent_cat'];
                    $entities[] = $entity;
                }
            }    
        }

        return $entities;
    }
    public function categoryProducts($user_id, $categories, $category_slug = null, $filter_brand=null, $filter_color=null, $filter_used = null){
        $Entity = ClassRegistry::init('Entity');
        $Category = ClassRegistry::init('Category');

        $user = $this->getLoggedUser();
            
        if($filter_used != "color" && $filter_used != "brand"){
            $filter_used = "error";
        }

        // Get the parent id
        $parent_id = false;
        if($category_slug != "all"){
            foreach($categories as $category){
                if($category_slug == $category['Category']['slug']){
                    $parent_id = $category['Category']['id'];
                    break;
                }
                elseif($category['children']){
                    foreach($category['children'] as $child){
                        if($category_slug == $child['Category']['slug']){
                            $parent_id = $category['Category']['id'];
                            break;
                        }
                        else if($child['children']){
                            foreach($child['children'] as $subchild){
                                if($category_slug == $subchild['Category']['slug']){
                                    $parent_id = $category['Category']['id'];
                                    break;
                                }    
                            }
                        }
                    }
                }
            }
            
            // Ger the category & sub category using the category slug
            $category_ids = $Category->getAllBySlug($category_slug);
        }
        
        if($category_slug != "all" && !$category_ids){
            $this->redirect('/closet');
        }
        

        // Prepare the brand filter data
        $brand_list = array();
        if($filter_brand && $filter_brand != "none"){
            $brand_list = explode('-', $filter_brand);
            $brand_list = array_values(array_unique($brand_list));
        }

        // Prepare the color filter data
        $color_list = array();
        $color_ids  = array();
        if($filter_color && $filter_color != "none"){
            $color_list = explode('-', $filter_color);
            $color_list = array_values(array_unique($color_list));
        }

        // Find array for products of a category exluding the filter and brand sub categories
        // and for a unsigned user
        $find_array = array(
            //'limit' => 12,
            'contain' => array('Image', 'Color'),
            'conditions' => array(
                'Entity.show' => true 
                //'Detail.show' => true, 'Detail.stock >' => 0,
            ),
            'group' => array('Entity.id'),
            'joins' => array(
                array('table' => 'products_categories',
                    'alias' => 'Category',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Category.product_id = Entity.product_id'
                    )
                ),
                array('table' => 'products',
                    'alias' => 'Product',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.id = Entity.product_id'
                    )
                ),
                array('table' => 'brands',
                    'alias' => 'Brand',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.brand_id = Brand.id'
                    )
                ),
                
               //  array('table' => 'products_details',
               //     'alias' => 'Detail',
               //     'type' => 'INNER',
               //     'conditions' => array(
               //         'Detail.product_entity_id = Entity.id',
               //     )
               // ),
            ),
            'order' => array('Entity.order' => 'ASC'),
            'fields' => array(
                'Entity.*', 'Product.*', 'Brand.*', 'Category.category_id'
            ),
            'Group' => array('Entity.id'),
        );
        
        if($category_slug != 'all'){
            $find_array['conditions']['Category.category_id'] = $category_ids;
        }

        //Hide products restricted for website user (hide_from_client)
        if(!$user['User']['is_stylist'] && !$user['User']['is_admin']){
            $find_array['conditions']['Entity.hide_from_client'] = false; 
        }
        
        //Query additions for a logged in user
        if($user_id){
            //Join Like and Dislike tables
            $find_array['joins'][] = array('table' => 'wishlists',
                                        'alias' => 'Wishlist',
                                        'type' => 'LEFT',
                                        'conditions' => array(
                                            'Wishlist.product_entity_id = Entity.id',
                                            'Wishlist.user_id' => $user_id
                                        )
                                    );
            $find_array['joins'][] = array('table' => 'dislikes',
                                        'alias' => 'Dislike',
                                        'type' => 'LEFT',
                                        'conditions' => array(
                                            'Dislike.product_entity_id = Entity.id',
                                            'Dislike.user_id' => $user_id,
                                            'Dislike.show' => true
                                        )
                                    );   
                     
            //Fields for likes and dislikes               
            $find_array['fields'][] = 'Wishlist.*';
            $find_array['fields'][] = 'Dislike.*';
        }
        
        // Color filter
        if($color_list && count($color_list) > 0){
            
            //Get product color ids based on colour group ids
            $Colorgroup = ClassRegistry::init('Colorgroup');
            $color_data = $Colorgroup->getColors($color_list);
            if($color_data){
                foreach($color_data as $color_item){
                    $color_ids[] = $color_item['ColorItems']['color_id'];
                }
            }
            
            if($color_ids && count($color_ids) > 0){
                $color_join = array('table' => 'colors_entities',
                    'alias' => 'Color1',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Color1.color_id' => $color_ids,
                        'Color1.product_entity_id = Entity.id'
                    )
                );
                $find_array['joins'][] = $color_join;
            }
        }

        // Brand Filter
        if($brand_list && count($brand_list) > 0){
            $find_array['conditions']['Product.brand_id'] = $brand_list;
        }
        

        
        if(count($color_ids) == 0 && ($category_slug == null || $category_slug ==  "all") && count($brand_list) == 0 ){
            $data = array();
        }
        else{
            $this->Paginator->settings = $find_array;
            $data = $this->Paginator->paginate($Entity);
            foreach($data as &$entity){
                if($entity['Category']['category_id']){
                    $parent = $Category->getParentNode($entity['Category']['category_id']);
                    if($parent){
                        $root_parent = $Category->getParentNode($parent['Category']['id']);
                        if($root_parent){
                            $entity['Category']['parent_cat'] = $root_parent['Category']['id'];    
                        }
                        else{
                            $entity['Category']['parent_cat'] = $parent['Category']['id'];
                        }
                    }
                    else{
                        $entity['Category']['parent_cat'] = $entity['Category']['category_id'];
                    }
                }
            }    
        }
        
        // check for login popup
        $check_count = 0;
        if(!$user_id && (count($brand_list) > 0 || (isset($category_ids) && count($category_ids)>0))){

            $count = $this->Session->read("count-click");

            if($count){
                $count++;
                if($count==3)
                {
                    $check_count=1;
                }
                $this->Session->write("count-click", $count);
            }
            else{
                $this->Session->write("count-click", 1);
            }


        } 
        
        $this->set(compact('parent_id', 'brand_list', 'color_list', 'filter_used','check_count'));
        return $data;
    }
 //bhashit code end


    public function feed(){
        
    }
}
