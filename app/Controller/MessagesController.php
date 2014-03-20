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
            $body = ucwords($user['User']['first_name']) . ",
                    
                    Thank you for registering with Savile Row Society and for taking the time to fill out your style profile. We have paired you with our premier personal stylist " . $stylist['User']['first_name'] . ". She will be reaching out to you shortly, however, do not hesitate to reach out to her if you have any questions or concerns. In the meantime, help " . $stylist['User']['first_name'] . " get to know you even better by liking and disliking the products we have suggested for you. We appreciate your support and patronage and look forward to being a destination for your wardrobe and lifestyle needs. 

                    Sincerely, 
                    The Savile Row Society Team ";

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

        $this->Message->create();

        // get stylist ID
        $user = $User->getByID($this->getLoggedUserID());
        $s_id = $user["User"]["stylist_id"];

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
        $notification['from_email'] = $from_user['User']['email']; 
        
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
                        $notification['from_email'] = $from_user['User']['email'];
                        
                        $this->sendEmailNotification($notification);
                    }
                }
            }
        }
        $this->redirect('index');    
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
            $email->bcc('admin@savilerowsociety.com');
            $email->template('message_notification');
            $email->emailFormat('html');
            
            if($to_stylist){
                $email->from(array($from_email => $from_name));
                $email->subject('SRS Team: New Message from' . $from_name);
                if($is_photo){
                    $email->viewVars(compact('to_name','from_name','photo_url','to_stylist','is_photo', 'client_id'));
                }
                else{
                    $email->viewVars(compact('to_name','from_name', 'message', 'to_stylist','is_photo','photo_url', 'client_id'));    
                } 
            }  
            else{
                $email->from(array($from_email => 'SRS Team'));
                $email->subject('SRS Team: New Message');
                $email->viewVars(compact('to_name','from_name','message','to_stylist','is_photo'));
            }
            
            $email->send();
        }
        catch(Exception $e){
            
        } 
    }
}
