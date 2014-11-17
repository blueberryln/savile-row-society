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
        $sideBarTab = 'message';
        //Get user from session to derterminate if user is stylist
        $user = $this->getLoggedUser();
        $user_id = $user["User"]["id"];
        $is_stylist = $user["User"]["is_stylist"];
        $is_admin = $user["User"]["is_admin"];
        $user = $User->findById($user_id);

        $stylist = $User->findById($user['User']['stylist_id']);
        $sideBarTab = 'message';

        $new_user = false;
        if($this->Session->check('new_user')){
            $new_user = true;
            $this->Session->delete('new_user');
        }
        
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
        $userlists = $User->getStylistClients($user_id);
         //print_r($userlists);
         // make user_id, user
        $this->set(compact('user_id', 'user', 'messages_for_user_id','userlists', 'sideBarTab', 'new_user'));
        //print_r($user);
        /**
         * Choose to show user/stylist or admin view
         */
        if ($is_stylist) {
            if($messages_for_user_id == null){
                $this->redirect('/messages/feed');
                exit;
            }
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

            // $this->redirect('/messages/feed');
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
            $this->set(compact('client_user', 'sideBarTab', 'stylist'));
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
            $body = "Hi " . ucwords($user['User']['first_name']) . ",

                    Your personal stylist, " . ucwords($stylist['User']['first_name']) . " , has sent you a new message:

                    Thank you for registering with Savile Row Society. My name is " . ucwords($stylist['User']['first_name']) . " and I will be your personal stylist. Feel free to check out my profile and ask me any style questions you may have.  I would also like to get to know you better; please tell me more about your wardrobe goals. I will get back to you shortly.
                    
                    If interested, I would also be happy to meet with you in our New York City based showroom, schedule a phone call, or just chat through the SRS platform. 

                    Welcome to Savile Row Society!

                    Sincerely, 
                    " . ucwords($stylist['User']['first_name']) . " and The Savile Row Society Team
                    ";

            $stylist_message = "Thank you for registering with Savile Row Society. My name is " . ucwords($stylist['User']['first_name']) . " and I will be your personal stylist. Feel free to check out my profile and ask me any style questions you may have.  I would also like to get to know you better; please tell me more about your wardrobe goals. I will get back to you shortly.
                    
                    If interested, I would also be happy to meet with you in our New York City based showroom, schedule a phone call, or just chat through the SRS platform. 

                    Welcome to Savile Row Society!";


            $this->Message->data['Message']['user_from_id'] = $stylist_id;
            $this->Message->data['Message']['user_to_id'] = $user_id;
            $this->Message->data['Message']['body'] = $body;

            if ($this->Message->validates($this->Message->data)) {
                // store in db
                $res = $this->Message->save($this->Message->data);

                try{
                    $email = new CakeEmail('default');
                    $email->to($stylist['User']['email']);
                    $email->template('stylist_notification');
                    $email->emailFormat('html');
                    
                    $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                    $email->subject('New Client');
                    $email->viewVars(compact('stylist', 'user'));
                    $email->send();
                }
                catch(Exception $e){

                }


                // Prepare data for email notification
                $notification['is_photo'] = false;
                $notification['to_stylist'] = false;
                $notification['message'] = $stylist_message;
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
        // get conversation for logged in user.
        $Outfit = ClassRegistry::init('Outfit');

        $result = array();
        $Outfit = ClassRegistry::init('Outfit');
        if ($this->getLoggedUser()){
            $user_id = $this->getLoggedUserID();
            if($with_user_id){
                // if with user id is not null load data for stylist
                $User = ClassRegistry::init('User');
                $user = $User->getById($with_user_id);

                if($user){
                    $result['User'] = array('full_name' => $user['User']['full_name'], 'profile_photo_url'=>$user['User']['profile_photo_url']);
                    $my_conversation = $this->Message->getMyConversationWith($with_user_id);
                    $outfit_list = array();
                    foreach($my_conversation as $row){
                        if($row['Message']['is_outfit'] == 1 && $row['Message']['outfit_id'] > 0){
                            $outfit_list[] = $row['Message']['outfit_id'];
                        }
                    }

                    $outfits = $Outfit->getOutfitDetails($outfit_list);

                    $messages = $this->Message->find('all', array(
                        'conditions'    => array('Message.outfit_id' => $outfit_list),
                        'contain'       => array('UserTo'),
                        'fields'        => array('Message.id', 'Message.body', 'Message.created', 'Message.is_read','Message.user_from_id', 'Message.user_to_id', 'Message.image', 'Message.is_request_outfit', 'Message.is_outfit', 'Message.outfit_id', 'UserTo.id', 'UserTo.first_name', 'UserTo.last_name'),
                        'order'         => array('Message.id' => 'desc'),
                        ));

                    $sorted_messages = array();
                    foreach($messages as $value){
                        $sorted_messages[$value['Message']['outfit_id']][] = $value;
                    }

                    foreach($my_conversation as &$row){
                        if(isset($outfits[$row['Message']['outfit_id']])){
                            $outfit = $outfits[$row['Message']['outfit_id']];
                            $row['Outfit'] = $outfit['OutfitItem'];
                            $row['OutfitDetail'] = $outfit['Outfit'];   
                            $row['AllMessage'] = $sorted_messages[$row['Message']['outfit_id']];
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
                $outfit_list = array();
                foreach($my_conversation as $row){
                    if($row['Message']['is_outfit'] == 1 && $row['Message']['outfit_id'] > 0){
                        $outfit_list[] = $row['Message']['outfit_id'];
                    }
                }

                $outfits = $Outfit->getOutfitDetails($outfit_list);
                $messages = $this->Message->find('all', array(
                    'conditions'    => array('Message.outfit_id' => $outfit_list),
                    'contain'       => array('UserTo'),
                    'fields'        => array('Message.id', 'Message.body', 'Message.created', 'Message.is_read','Message.user_from_id', 'Message.user_to_id', 'Message.image', 'Message.is_request_outfit', 'Message.is_outfit', 'Message.outfit_id', 'UserTo.id', 'UserTo.first_name', 'UserTo.last_name'),
                    'order'         => array('Message.id' => 'desc'),
                    ));

                $sorted_messages = array();
                foreach($messages as $value){
                    $sorted_messages[$value['Message']['outfit_id']][] = $value;
                }

                foreach($my_conversation as &$row){
                    if(isset($outfits[$row['Message']['outfit_id']])){
                        $outfit = $outfits[$row['Message']['outfit_id']];
                        $row['Outfit'] = $outfit['OutfitItem'];
                        $row['OutfitDetail'] = $outfit['Outfit'];    
                        $row['AllMessage'] = $sorted_messages[$row['Message']['outfit_id']];
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

        $Outfit = ClassRegistry::init('Outfit');
        if ($user_id){
            if($with_user_id){
                // if with user id is not null load data for stylist
                $User = ClassRegistry::init('User');
                $user = $User->getById($with_user_id);

                if($user){
                    $result['User'] = array('full_name' => $user['User']['full_name'], 'profile_photo_url'=>$user['User']['profile_photo_url']);
                    $my_conversation = $this->Message->getUnreadMessagesWith($with_user_id);
                    $outfit_list = array();
                    foreach($my_conversation as $row){
                        if($row['Message']['is_outfit'] == 1 && $row['Message']['outfit_id'] > 0){
                            $outfit_list[] = $row['Message']['outfit_id'];
                        }
                    }

                    $outfits = $Outfit->getOutfitDetails($outfit_list);

                    foreach($my_conversation as &$row){
                        if(isset($outfits[$row['Message']['outfit_id']])){
                            $outfit = $outfits[$row['Message']['outfit_id']];
                            $row['Outfit'] = $outfit['OutfitItem'];
                            $row['OutfitDetail'] = $outfit['Outfit'];    
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
                $my_conversation = $this->Message->getUnreadMessages($user_id);
                $outfit_list = array();
                foreach($my_conversation as $row){
                    if($row['Message']['is_outfit'] == 1 && $row['Message']['outfit_id'] > 0){
                        $outfit_list[] = $row['Message']['outfit_id'];
                    }
                }

                $outfits = $Outfit->getOutfitDetails($outfit_list);

                foreach($my_conversation as &$row){
                    if(isset($outfits[$row['Message']['outfit_id']])){
                        $outfit = $outfits[$row['Message']['outfit_id']];
                        $row['Outfit'] = $outfit['OutfitItem'];
                        $row['OutfitDetail'] = $outfit['Outfit'];    
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
        
        $Outfit = ClassRegistry::init('Outfit');
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
                    $outfit_list = array();
                    foreach($my_conversation as $row){
                        if($row['Message']['is_outfit'] == 1 && $row['Message']['outfit_id'] > 0){
                            $outfit_list[] = $row['Message']['outfit_id'];
                        }
                    }

                    $outfits = $Outfit->getOutfitDetails($outfit_list);

                    foreach($my_conversation as &$row){
                        if(isset($outfits[$row['Message']['outfit_id']])){
                            $outfit = $outfits[$row['Message']['outfit_id']];
                            $row['Outfit'] = $outfit['OutfitItem'];
                            $row['OutfitDetail'] = $outfit['Outfit'];    
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
                $outfit_list = array();
                foreach($my_conversation as $row){
                    if($row['Message']['is_outfit'] == 1 && $row['Message']['outfit_id'] > 0){
                        $outfit_list[] = $row['Message']['outfit_id'];
                    }
                }

                $outfits = $Outfit->getOutfitDetails($outfit_list);

                foreach($my_conversation as &$row){
                    if(isset($outfits[$row['Message']['outfit_id']])){
                        $outfit = $outfits[$row['Message']['outfit_id']];
                        $row['Outfit'] = $outfit['OutfitItem'];
                        $row['OutfitDetail'] = $outfit['Outfit'];    
                    }
                }

                $result['Messages'] = $my_conversation;
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


    // STYLIST SECTION IN USER OUTFIT LIST ASSIGN BY USER AJAX DATA FOR SORTING AND PAGINATION
    
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
    

    // STYLIST SECTION ALL USERS SALES(PRURCHASE DATA) SECTION

    public function sales($clientid = null) {
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
        $userlists = $User->getStylistClients($user_id);
        
        if(count($userlists)){
            $first_user = $userlists[0]['User'];

            $this->redirect('/messages/index/' . $first_user['id']);
            exit;
        }
        else{
            $this->redirect('/messages/feed');
            exit;
        }

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
        $postvalues = $posts->find('all', array('conditions'=>array('Post.is_order'=>true)));
        if(!empty($postvalues)):
          
            
        $saleshistory = array();
        foreach ($postvalues as  $postvalue) {
            $post_id = $postvalue['Post']['id'];
            
            
            $salesarray = array(
                'fields' => array('OrderItem.order_id','Order.user_id,Order.id'),
                'joins' => array(
                array(
                    'conditions' => array(
                        'OrderItem.order_id = Order.id',
                        'OrderItem.post_id' =>$post_id
                    ),
                    'table' => 'orders',
                    'alias' => 'Order',
                    'type' => 'INNER',
                  ),
                ),
            );
            
            //$orderlist = $OrderItem->find('all', array('conditions'=>array('OrderItem.post_id'=>$post_id)));
            $orderlist = $OrderItem->find('all',$salesarray);
            foreach ($orderlist as $orderlist) {
               $orderuserid =  isset($orderlist['Order']['user_id']);
               
               $orderid =  $orderlist['OrderItem']['order_id'];
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
        endif;
         if(!empty($post_id) ||!empty($orderid) ):

        //$totalSale = $Order->find('all',array('conditions'=>array('Order.user_id'=>$orderuserid,'Order.post_id'=>$post_id,),'fields'=>array('sum(Order.final_price) as finalamount')));
        $totalSalearray =  array(
                'fields' => array('sum(Order.final_price) as finalamount'),
                'joins' => array(
                array(
                    'conditions' => array(
                        'Order.id = OrderItem.id',
                        'OrderItem.post_id' => $post_id,
                        'Order.user_id'=> $orderuserid,
                    ),
                    'table' => 'orders_items',
                    'alias' => 'OrderItem',
                    'type' => 'INNER',
                  ),
                ),
            );    
        
        $totalSale = $Order->find('all',$totalSalearray);
        endif; 
        $this->set(compact('saleshistory','userclient','totalSale','userlists','clientid'));

    }


    // stylist all user sales


    public function usersales($clientid = null) {
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
        $userlists = $User->getStylistClients($user_id);
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
        $userlists = $User->getStylistClients($user_id);
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


    /****
    fixed code
    ***/
    public function userPurchases(){
        if(isset($this->request->query['sort'])){
            $pageOrder = ($this->request->query['sort'] == "desc") ? 'desc' : 'asc';
        }
        else{
            $pageOrder = 'asc';
        }
        $sideBarTab = 'purchase';

        $user = $this->getLoggedUser();
        $User= ClassRegistry::init('User');
        $stylist = $User->findById($user['User']['stylist_id']);
        
        if($user['User']['is_stylist']){
            $this->redirect('/messages/feed');
            exit;
        }

        $OrderItem = ClassRegistry::init('OrderItem');
        $Entity = ClassRegistry::init('Entity'); 
        
        $purchases = $OrderItem->getUserItemList($user['User']['id'], $pageOrder);

        if(count($purchases)){
            $entity_list = array();
            foreach($purchases as $value){
                $entity_list[] = $value['OrderItem']['product_entity_id'];
            }

            $entities = $Entity->getEntities($entity_list, array('Image'));
            $sorted_entities = array();
            
            foreach($entities as $value){
                $sorted_entities[$value['Entity']['id']] = $value;
            }

            //sort purchases

            foreach($purchases as &$value){
                $value['Entity'] = $sorted_entities[$value['OrderItem']['product_entity_id']]['Entity'];
                $value['Brand'] = $sorted_entities[$value['OrderItem']['product_entity_id']]['Brand'];
                $value['Image'] = $sorted_entities[$value['OrderItem']['product_entity_id']]['Image'];
            }    
        }
        else{
            $purchases = array();
        }
        
        $this->set(compact('purchases','user', 'pageOrder', 'stylist', 'sideBarTab'));
        
    }


    public function userLikes(){

        if(isset($this->request->query['sort'])){
            $pageOrder = ($this->request->query['sort'] == "desc") ? 'desc' : 'asc';
        }
        else{
            $pageOrder = 'asc';
        }
        $sideBarTab = 'like';

        $user = $this->getLoggedUser();
        $User= ClassRegistry::init('User');
        $stylist = $User->findById($user['User']['stylist_id']);
        
        if($user['User']['is_stylist']){
            $this->redirect('/messages/feed');
            exit;
        }


        $Wishlist = ClassRegistry::init('Wishlist');
        $Entity = ClassRegistry::init('Entity'); 

        $likeitems = $Wishlist->getUserLikeList($user['User']['id'], $pageOrder);

        if(count($likeitems)){
            $entity_list = array();
            foreach($likeitems as $value){
                $entity_list[] = $value['Wishlist']['product_entity_id'];
            }

            $entities = $Entity->getEntities($entity_list, array('Image'));
            $sorted_entities = array();
            
            foreach($entities as $value){
                $sorted_entities[$value['Entity']['id']] = $value;
            }

            //sort likeitems

            foreach($likeitems as &$value){
                $value['Entity'] = $sorted_entities[$value['Wishlist']['product_entity_id']]['Entity'];
                $value['Brand'] = $sorted_entities[$value['Wishlist']['product_entity_id']]['Brand'];
                $value['Image'] = $sorted_entities[$value['Wishlist']['product_entity_id']]['Image'];
            }    
        }
        else{
            $likeitems = array();
        }
        
        $this->set(compact('likeitems','user', 'pageOrder', 'stylist', 'sideBarTab'));
        
    }

    public function profiles() {
        
        $user = $this->getLoggedUser();
        $User= ClassRegistry::init('User');
        $stylist = $User->findById($user['User']['stylist_id']);
        $sideBarTab = 'profile';
        
        if($user['User']['is_stylist']){
            $this->redirect('/messages/feed');
            exit;
        }
        
        $this->set(compact('user', 'stylist', 'sideBarTab'));

        if($this->request->is('post') || $this->request->is('put')){
            if($this->request->data['User']['password'] != ''){
                $this->request->data['User']['password'] = Security::hash($this->request->data['User']['password']);
            }
            else{
                unset($this->request->data['User']['password']);   
            }

            if(isset($this->request->data['User']['is_phone']) && $this->request->data['User']['is_phone']==true){
                $this->request->data['User']['is_phone']='1'; 
            }
            else{
                $this->request->data['User']['is_phone']='0';    
            }
            if(isset($this->request->data['User']['is_skype']) && $this->request->data['User']['is_skype']==true){
               $this->request->data['User']['is_skype']='1'; 
            }else{
                $this->request->data['User']['is_skype']='0'; 
            }
            if(isset($this->request->data['User']['is_srs_msg']) && $this->request->data['User']['is_srs_msg']==true){
               $this->request->data['User']['is_srs_msg']=1; 
            }

            if($User->save($this->request->data)){
                $this->Session->setFlash("User Data Hasbeen Saved", 'flash');
                $this->redirect('/user/profile');
            } else {
                $this->Session->setFlash(__('The User could not be saved. Please, try again.'), 'flash');
            }
        } else {
                $options = array('conditions' => array('User.' . $User->primaryKey => $user['User']['id']));
                $this->request->data = $User->find('first', $options);
        }

    }

    public function usersoutfits() {

        if(isset($this->request->query['sort'])){
            $pageOrder = ($this->request->query['sort'] == "desc") ? 'desc' : 'asc';
        }
        else{
            $pageOrder = 'asc';
        }

        $user = $this->getLoggedUser();
        $user_id = $user['User']['id'];
        $User= ClassRegistry::init('User');
        $stylist = $User->findById($user['User']['stylist_id']);
        $sideBarTab = 'outfit';  
        $Outfit = ClassRegistry::init('Outfit');
        
        if($user['User']['is_stylist']){
            $this->redirect('/messages/feed');
            exit;
        }

        $page = (isset($this->request->data['page']) && $this->request->data['page'] > 0) ? $this->request->data['page'] : 1; 

        if($user){
            $limit = 50;
            $message_outfit_list = $Outfit->getOutfitList($user_id, $pageOrder, $limit, $page);
            $outfit_list = array();
            foreach($message_outfit_list as $value){
                $outfit_list[] = $value['Message']['outfit_id'];
            }

            $outfits = $Outfit->getOutfitDetails($outfit_list, true);
            $sorted_outfit = array();

            foreach($outfits as $value){
                $sorted_outfit[$value['Outfit']['id']] = $value;
            }

            $outfits = array();
            foreach($message_outfit_list as $value){
                $value['Outfit'] = $sorted_outfit[$value['Message']['outfit_id']]['Outfit'];
                $value['Stylist'] = $sorted_outfit[$value['Message']['outfit_id']]['Stylist'];
                $value['OutfitItem'] = $sorted_outfit[$value['Message']['outfit_id']]['OutfitItem'];

                $outfits[] = $value;
            }

            if($page > 1){
                echo json_encode($outfits);
                exit;
            }
            $page++;

            $this->set(compact('user', 'stylist', 'sideBarTab', 'outfits', 'user_id', 'page'));
        }
        else{
            $this->redirect('/messages/index');
            exit;
        }
        
    }

    public function outfitdetails($outfit_id = null) {

        $User = ClassRegistry::init('User');
        $Outfit = ClassRegistry::init('Outfit');
        $Size = ClassRegistry::init('Size');
        $this->autoRender = false;

        $user = $this->getLoggedUser();
        $user_id = $user["User"]["id"]; 

        if($user['User']['is_stylist'] == 1){
            $sideBarTab = 'detail';

            $sizes = $Size->find('list');
            $outfit = $Outfit->getOutfitDetails($outfit_id, false, $user_id);
            if($outfit){
                $outfit = $outfit[$outfit_id];

                $message = $this->Message->find('first', array(
                    'conditions' => array('user_to_id' => $user_id, 'outfit_id' => $outfit_id),
                    'order' => array('id' => 'desc'),
                    ));

                $userlists = $User->getStylistClients($user_id);
                
                $this->set(compact('outfit', 'outfit_id', 'message', 'user_id', 'user', 'sideBarTab', 'sizes', 'userlists'));
                $this->render('stylistoutfit');
            }
            else{
                $this->redirect('/messages/index');
            }
        }
        else if($user['User']['is_admin'] == 1){
            $this->redirect('/messages/index');
            exit;
        }
        else{
            $sideBarTab = 'detail';
            $stylist = $User->findById($user['User']['stylist_id']);

            $sizes = $Size->find('list');
            $outfit = $Outfit->getOutfitDetails($outfit_id, false, $user_id);
            if($outfit){
                $outfit = $outfit[$outfit_id];

                $message = $this->Message->find('first', array(
                    'conditions' => array('user_to_id' => $user_id, 'outfit_id' => $outfit_id),
                    'order' => array('id' => 'desc'),
                    ));
                $this->set(compact('outfit', 'outfit_id', 'message', 'user_id', 'user', 'stylist', 'sideBarTab', 'sizes'));
                $this->render('outfitdetails');
            }
            else{
                $this->redirect('/messages/index');
            }
        }
           
    }



    /**
     * Less Formatted code
     * Stylist section client code
     */
    public function purchase($clientid = null) {
        $sideBarTab = 'purchase';
        if(isset($this->request->query['sort'])){
            $pageOrder = ($this->request->query['sort'] == "desc") ? 'desc' : 'asc';
        }
        else{
            $pageOrder = 'asc';
        }
        $user = $this->getLoggedUser();
        $User= ClassRegistry::init('User');
        $client_user = $User->getById($clientid);
        if(!$client_user){
            $this->redirect('/messages/index');
            exit;
        }
        $clientid = $client_user['User']['id'];
        $stylist_id = $client_user['User']['stylist_id'];

        if($user['User']['id'] != $stylist_id){
            $this->redirect('/messages/index');
            exit;
        }

        $userlists = $User->getStylistClients($stylist_id);
   
        $OrderItem = ClassRegistry::init('OrderItem');
        $Entity = ClassRegistry::init('Entity'); 
        
        $purchases = $OrderItem->getUserItemList($clientid, $pageOrder);

        if(count($purchases)){
            $entity_list = array();
            foreach($purchases as $value){
                $entity_list[] = $value['OrderItem']['product_entity_id'];
            }

            $entities = $Entity->getEntities($entity_list, array('Image'));
            $sorted_entities = array();
            
            foreach($entities as $value){
                $sorted_entities[$value['Entity']['id']] = $value;
            }

            foreach($purchases as &$value){
                $value['Entity'] = $sorted_entities[$value['OrderItem']['product_entity_id']]['Entity'];
                $value['Brand'] = $sorted_entities[$value['OrderItem']['product_entity_id']]['Brand'];
                $value['Image'] = $sorted_entities[$value['OrderItem']['product_entity_id']]['Image'];
            }    
        }
        else{
            $purchases = array();
        }
        

        $this->set(compact('purchases','clientid','client_user','userlists', 'sideBarTab', 'pageOrder'));

    }


    public function likes($clientid = null) {
        $sideBarTab = 'purchase';
        if(isset($this->request->query['sort'])){
            $pageOrder = ($this->request->query['sort'] == "desc") ? 'desc' : 'asc';
        }
        else{
            $pageOrder = 'asc';
        }
        $user = $this->getLoggedUser();
        $User= ClassRegistry::init('User');
        $client_user = $User->getById($clientid);
        if(!$client_user){
            $this->redirect('/messages/index');
            exit;
        }
        $clientid = $client_user['User']['id'];
        $stylist_id = $client_user['User']['stylist_id'];

        if($user['User']['id'] != $stylist_id){
            $this->redirect('/messages/index');
            exit;
        }

        $userlists = $User->getStylistClients($stylist_id);
   
         $Wishlist = ClassRegistry::init('Wishlist');
        $Entity = ClassRegistry::init('Entity'); 

        $likeitems = $Wishlist->getUserLikeList($user['User']['id'], $pageOrder);

        if(count($likeitems)){
            $entity_list = array();
            foreach($likeitems as $value){
                $entity_list[] = $value['Wishlist']['product_entity_id'];
            }

            $entities = $Entity->getEntities($entity_list, array('Image'));
            $sorted_entities = array();
            
            foreach($entities as $value){
                $sorted_entities[$value['Entity']['id']] = $value;
            }

            //sort likeitems

            foreach($likeitems as &$value){
                $value['Entity'] = $sorted_entities[$value['Wishlist']['product_entity_id']]['Entity'];
                $value['Brand'] = $sorted_entities[$value['Wishlist']['product_entity_id']]['Brand'];
                $value['Image'] = $sorted_entities[$value['Wishlist']['product_entity_id']]['Image'];
            }    
        }
        else{
            $likeitems = array();
        }
        

        $this->set(compact('likeitems','clientid','client_user','userlists', 'sideBarTab', 'pageOrder'));

    }


    public function outfits($client_id = null){
        $sideBarTab = 'outfit';
        $User = ClassRegistry::init('User');
        
        //Get user from session to derterminate if user is stylist
        $user = $this->getLoggedUser();
        $user_id = $user["User"]["id"]; 
        $is_admin = $user["User"]["is_admin"];
        $is_stylist = $user["User"]["is_stylist"];   
        $client_user = $User->getById($client_id);
        $clientid = $client_user['User']['id'];
        $userlists = $User->getStylistClients($user_id);
        $Message = ClassRegistry::init('Message');
        if($user){
            $find_array =  array(
                'conditions' => array('AND' =>
                    array(
                        'OR' => array('Message.user_to_id' => $client_id, 'Message.user_from_id' => $client_id)
                    )
                ),
                'limit'=>10,
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
                    
        $this->set(compact('my_outfits','client_user','user_id','clientid','userlists','my_conversation_count', 'sideBarTab'));
    }


    public function notes($clientid = null) {
        $sideBarTab = 'note';

        $user = $this->getLoggedUser();
        $User = ClassRegistry::init('User');
        $StylistNote = ClassRegistry::init('StylistNote');

        $client_user = $User->findById($clientid);
        if(!$client_user){
            $this->redirect('/messages/index');
            exit;
        }

        $clientid = $client_user['User']['id'];
        $stylistid = $client_user['User']['stylist_id'];
        if($user['User']['id'] != $stylistid){
            $this->redirect('/messages/index');
            exit;
        }

        $userlists = $User->getStylistClients($stylistid);
       
        if($this->request->is('post')){
            $data=$this->request->data;
            $this->request->data['StylistNote']['user_id']=$clientid;
            $this->request->data['StylistNote']['stylist_id']=$stylistid;

            if($StylistNote->save($this->request->data))
            {
                $this->Session->setFlash("User data has been saved", 'flash');
                $this->redirect('/messages/notes/'.$clientid);
            }
        }

        // get notes data

        $usernotes = $StylistNote->find('all', array('conditions'=>array('StylistNote.stylist_id'=>$stylistid,'StylistNote.user_id'=>$clientid, 'is_image' => 0)));

        $imagenotes = $StylistNote->find('all', array('conditions'=>array('StylistNote.stylist_id'=>$stylistid,'StylistNote.user_id'=>$clientid, 'is_image' => 1)));



        $this->set(compact('clientid','client_user','usernotes','userlists', 'sideBarTab', 'imagenotes'));

    }


    public function removenotes($id = null){
        $StylistNote = ClassRegistry::init('StylistNote');
        $note = $StylistNote->findById($id);

        $user = $this->getLoggedUser();

        if($note){
            $User = ClassRegistry::init('User');
            $client = $User->findById($note['StylistNote']['user_id']);

            if($client['User']['stylist_id'] != $user['User']['id']){
                $this->Session->setFlash('Note could not be deleted.', 'flash');
                $this->redirect('/messages/notes/' . $client['User']['id']);
                exit;
            }
        }
        else{
            $this->Session->setFlash('Note could not be deleted.', 'flash');
            $this->redirect('/messages/notes/' . $client['User']['id']);
            exit;
        }  

        if ($StylistNote->delete($id)) {
            $this->Session->setFlash('Note deleted', 'flash');
        } else {
            $this->Session->setFlash('Note could not be deleted.', 'flash');
        }

        $this->redirect('/messages/notes/' . $client['User']['id']);
        exit;

    }


    public function saveNotesPhoto($client_id = null){
        $this->layout = 'ajax';
        $this->autoRender = false;
        $User = ClassRegistry::init('User');

        $client = $User->findById($client_id);
        $user = $this->getLoggedUser();

        if($user['User']['id'] != $client['User']['stylist_id']){
            $this->redirect('/');
        }
        if($this->request->is('post') || $this->request->is('put')){
            $imagename = false;
            $image_type = '';
            $image_size = '';


            if ($this->request->data['Messages']['note_url'] && $this->request->data['Messages']['note_url']['size'] > 0) {
                $allowed = array('image/jpeg', 'image/gif', 'image/png', 'image/x-png', 'image/x-citrix-png', 'image/x-citrix-jpeg', 'image/pjpeg');

                if (!in_array($this->request->data['Messages']['note_url']['type'], $allowed)) {
                    $this->Session->setFlash(__('You have to upload an image.'), 'flash');
                } else if ($this->request->data['Messages']['note_url']['size'] > 5242880) {
                    $this->Session->setFlash(__('Attached image must be up to 5 MB in size.'), 'flash');
                    exit;
                } else {
                    $imagename = time() .  '_' . $this->request->data['Messages']['note_url']['name'];
                    $image_type = $this->request->data['Messages']['note_url']['type'];
                    $image_size = $this->request->data['Messages']['note_url']['size'];
                    $profile_path = APP . 'webroot' . DS . 'files' . DS . 'attachments' . DS . $imagename;
                    move_uploaded_file($this->request->data['Messages']['note_url']['tmp_name'], $profile_path);
                    
                }
            }

            if($imagename){
                $StylistNote = ClassRegistry::init('StylistNote');
                $data['user_id'] = $client_id;
                $data['stylist_id'] = $user['User']['id'];
                $data['image'] = $imagename;
                $data['is_image'] = 1;

                $StylistNote->create();
                $StylistNote->save($data);
                
                $this->redirect(array('action' => '/notes/'.$client_id));    
            }else{
                $this->Session->setFlash('The image could not be uploaded. Please, try again.', 'flash');
            }


        }  

    }


    public function measurements($clientid = null) {

        $sideBarTab = 'measurement';
        $User = ClassRegistry::init('User');
        $UserSizeInformation = ClassRegistry::init('UserSizeInformation');
        $UserPreference = ClassRegistry::init('UserPreference');
        $client_user = $User->findById($clientid);

        if(!$client_user){
            $this->redirect('/messages/feed');
            exit;
        }
        $clientid = $client_user['User']['id'];
        $stylistid = $client_user['User']['stylist_id'];

        $user = $this->getLoggedUser();

        if(!$user['User']['is_stylist'] || $user['User']['id'] != $stylistid){
            $this->redirect('/messages');
            exit;
        }


        $userlists = $User->getStylistClients($stylistid);

        $userprofile = $UserPreference->find('first',array('conditions'=>array('UserPreference.user_id'=>$clientid)));
        

        if($this->request->is('post') || $this->request->is('put')){
            
             $id = $this->request->data['UserSizeInformation']['id'];
            
            $this->request->data['UserSizeInformation']['user_id']=$clientid;
            //$this->request->data['UserSizeInformation']['stylist_id']=$stylistid;
            $custom_shirt_serialize = json_encode($this->request->data['UserSizeInformation']['custom_shirt_measurement']);
            $custom_jacket_serialize = json_encode($this->request->data['UserSizeInformation']['custom_jacket_measurement']);
            $custom_trouser_serialize = json_encode($this->request->data['UserSizeInformation']['custom_trouser_measurement']);
            $custom_vest_serialize = json_encode($this->request->data['UserSizeInformation']['custom_vest_measurement']);
            $this->request->data['UserSizeInformation']['custom_shirt_measurement'] = $custom_shirt_serialize;
            $this->request->data['UserSizeInformation']['custom_jacket_measurement'] = $custom_jacket_serialize;
            $this->request->data['UserSizeInformation']['custom_trouser_measurement'] = $custom_trouser_serialize;
            $this->request->data['UserSizeInformation']['custom_vest_measurement'] = $custom_vest_serialize;
            if($UserSizeInformation->save($this->request->data)){
                $this->redirect('/messages/measurements/'.$clientid);
            } else {
                $this->Session->setFlash(__('The stylistusermeasurements could not be saved. Please, try again.'), 'flash');
            }

        }  else {
            $options = array('conditions' => array('user_id' => $clientid));
            $this->request->data = $UserSizeInformation->find('first', $options);
        }

        $customdata = $UserSizeInformation->find('first',array('conditions'=>array('UserSizeInformation.user_id'=>$clientid)));
        $this->set(compact('userlists','clientid','client_user','customdata','userprofile', 'sideBarTab'));
    }



    public function feed(){
        $User = ClassRegistry::init('User');
        $user = $this->getLoggedUser();
        if($user['User']['is_stylist'] != 1){
            $this->redirect('/');
        }

        $stylist_id = $user['User']['stylist_id'];
        $userlists = $User->getStylistClients($user['User']['id']);
        $usercount  = count($userlists);

        $this->set(compact('user','userlists','stylist_id','usercount'));
    }


    public function userfeed($id){
        $sideBarTab = 'feed';
        $User = ClassRegistry::init('User');
        $user = $this->getLoggedUser();
        $client_user = $User->findById($id);
        $stylist_id = $client_user['User']['stylist_id'];
        if($client_user && $client_user['User']['stylist_id'] == $user['User']['id']){

            $userlists = $User->getStylistClients($stylist_id);
            $this->set(compact('client_user','userlists','stylist_id','sideBarTab'));
        }
        else{
            $this->redirect('feed');
            exit;
        }
    }


    public function myoutfits(){

        $User = ClassRegistry::init('User');
        
        //Get user from session to derterminate if user is stylist
        $user = $this->getLoggedUser();
        $user_id = $user["User"]["id"]; 

        if(!$user['User']['is_stylist']){
            $this->redirect('/');
        }

        $userlists = $User->getStylistClients($user_id);

        $Message = ClassRegistry::init('Message');
        $Outfit = ClassRegistry::init('Outfit');
        $posts = ClassRegistry::init('Post');


        $page = (isset($this->request->data['page']) && $this->request->data['page'] > 0) ? $this->request->data['page'] : 1; 

        $limit = 10;
        $sort = 'desc';
        $message_outfit_list = $Outfit->find('all', array(
            'conditions'  => array('stylist_id' => $user_id),
            'order' => array('id' => $sort),
            'limit' => $limit,
            'page'  => $page
        ));

        $outfit_list = array();
        foreach($message_outfit_list as $value){
            $outfit_list[] = $value['Outfit']['id'];
        }

        $outfits = $Outfit->getOutfitDetails($outfit_list, true);
        $sorted_outfit = array();

        foreach($outfits as $value){
            $sorted_outfit[$value['Outfit']['id']] = $value;
        }


        $messages = $Message->find('all', array(
            'conditions'    => array('Message.outfit_id' => $outfit_list),
            'contain'       => array('UserTo'),
            'fields'        => array('Message.id', 'Message.body', 'Message.created', 'Message.is_read','Message.user_from_id', 'Message.user_to_id', 'Message.image', 'Message.is_request_outfit', 'Message.is_outfit', 'Message.outfit_id', 'UserTo.id', 'UserTo.first_name', 'UserTo.last_name'),
            'order'         => array('Message.id' => 'desc'),
            ));

        $sorted_messages = array();
        foreach($messages as $value){
            $sorted_messages[$value['Message']['outfit_id']][] = $value;
        }

        $outfits = array();
        foreach($message_outfit_list as $value){
            $value['Outfit'] = $sorted_outfit[$value['Outfit']['id']]['Outfit'];
            $value['Message'] = $sorted_messages[$value['Outfit']['id']];
            $value['Stylist'] = $sorted_outfit[$value['Outfit']['id']]['Stylist'];
            $value['OutfitItem'] = $sorted_outfit[$value['Outfit']['id']]['OutfitItem'];

            $outfits[] = $value;
        }

        $page++;

        $outfitcount = count($outfits);
        
        if($this->request->is('ajax')){
            $this->layout = false;
            $this->render = false;
            $ret = array();

            if(count($outfits)){
                $ret['status'] = 'ok';
                $ret['outfits'] = $outfits;
            }
            else{
                $ret['status'] = 'error';
                $ret['outfits'] = array();
            }

            echo json_encode($ret);
            exit;
        }


        $this->set(compact('outfits','userlists','user_id','outfitcount', 'page'));
    
    }
}
