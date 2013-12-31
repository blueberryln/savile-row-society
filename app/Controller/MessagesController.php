<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Messages Controller
 *
 * @property Message $Message
 */
class MessagesController extends AppController {

    public function index($messages_for_user_id = null) {
        //$this->Message->markMessagesRead();
        $this->isLogged();
        // init
        $User = ClassRegistry::init('User');
        
        // get user from session to derterminate if user is stylist
        $user = $this->getLoggedUser();
        $is_stylist = $user["User"]["is_stylist"];
        if($user["User"]["is_admin"]){
            $is_admin = 1;
        }
        else{
            $is_admin = 0;
        }
        
        /**
         * Check if user should be shown the screen
         */
        
        if(!$is_admin && !$is_stylist && (is_null($user['User']['stylist_id']) || $user['User']['stylist_id'] == "" || !($user['User']['stylist_id'] > 0) )){
            $this->redirect('/');
        }        
        
        
         // make user_id, user
        $user_id = $this->getLoggedUserID();
        $this->set(compact('user_id', 'user', 'messages_for_user_id'));

        //chose witch view to render
        if ($is_stylist || $is_admin) {
            $Category = ClassRegistry::init('Category');
            $Brand = ClassRegistry::init('Brand');
            $Color = ClassRegistry::init('Color');
            $Colorgroup = ClassRegistry::init('Colorgroup');
            
            // get data
            $categories = $Category->getAll();
            $brands = $Brand->find('all', array('order' => "Brand.name ASC"));
            $colors = $Colorgroup->find('all', array('order' => "Colorgroup.name ASC"));
            
            // if stylist load user that write to logged in user.
            $clients = array();
                
            $clients_data = $User->getUserWriteToMe($this->getLoggedUserID());
            
            $client_id = 0;
            
            //If stylist get the list of new users
            if($is_stylist){
                $new_clients = $User->getNewClients($user_id);
                $this->set(compact('new_clients'));
            } 
            
            
            if($messages_for_user_id){
                $client_user = $User->getByID($messages_for_user_id);
                $client_id = $messages_for_user_id;
                
                /**
                 *  - If client user is admin redirect to message landing
                 *  - If client user is stylist redirect to message landing
                 *  - If current user is stylist and client is not user's client, redirect to message landing
                 */  
                if($client_user['User']['is_admin'] == 1 || $client_user['User']['is_stylist'] == 1){
                    $this->redirect('/messages');    
                }
                else if ($client_user['User']['stylist_id'] != $user_id && $is_admin == 0){
                    $this->redirect('/messages');    
                }
                
                $Order = ClassRegistry::init('Order');
                
                //Get last purchase
                $last_purchase = $Order->find('first', array(
                                    'conditions' => array('Order.user_id' => $client_id, 'Order.Paid' => true),
                                    'order' => 'Order.id DESC'
                                ));
                //print_r($last_purchase);
//                exit;
                
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
            else if($is_admin && is_null($messages_for_user_id)){
                $this->redirect('/admin/users');
            }
            
            $client_array = array();
            foreach ($clients_data as $client) {
                $client_array[] = $client['User']['id'];
                $clients[$client['User']['id']] = $client['User']['full_name'];
            }

            $this->set(compact('clients', 'brands', 'colors', 'categories', 'client_user', 'client_id', 'client_array', 'is_admin'));
            $this->render("stylist");
        } else {
            $stylist_id = $user['User']['stylist_id'];
            $client_user = $User->getByID($stylist_id);
            $this->set(compact('client_user'));
            $this->render("user");
        }
    }


    /**
     * Only available when logged user is not stylist
     */
    public function send_message_to_stylist() {

        // init
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
        $notification['message'] = $res['Message']['body'];
        $notification['to_name'] = $to_user['User']['first_name'];
        $notification['from_name'] = $from_user['User']['first_name'];
        $notification['to_email'] = $to_user['User']['email'];
        $notification['from_email'] = $from_user['User']['email']; 
        
        $this->sendEmailNotification($notification);

        $this->render('/Elements/SerializeJson/');
    }
    
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

        // init
        $User = ClassRegistry::init('User');
        // create message instance
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
            $notification['message'] = $res['Message']['body'];
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

    /*
     * Get my messages
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
                        $entity_list = $Entity->getEntitiesById($entities, $user_id);
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
                        $entity_list = $Entity->getEntitiesById($entities, $user_id);
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
     * Get new messages
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
                            $entity_list = $Entity->getEntitiesById($entities, $user_id);
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
            
            $user = $this->getLoggedUser();
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
    
    function clients(){
        $this->isLogged();
        // init
        $User = ClassRegistry::init('User');
        
        // Get user details
        $user_id = $this->getLoggedUserID();
        $user = $User->getById($user_id);
        $user_admin = 0;
        if($user["User"]["is_admin"]){
            $user_admin = 1;
        }
        
        // Check if the logged in user is stylist; if not then redirect to chat page
        if($user && $user['User']['is_stylist'] == 1){
            $new_clients = $User->getNewClients($user_id);
            $this->set(compact('new_clients'));
            
            $notification_data = $User->getStylistUserNotification($user_id); 
            $clients = array();
            $client_array = array();
            $clients_data = $User->getUserWriteToMe($this->getLoggedUserID());
            foreach ($clients_data as $client) {
                $client_array[] = $client['User']['id'];
                $clients[$client['User']['id']] = $client['User']['full_name'];
            }  
            
            $this->set(compact('clients','client_array','user_id', 'user_admin', 'notification_data')); 
        }
        else{
            $this->redirect('/messages');
            exit;
        }
    }
}
