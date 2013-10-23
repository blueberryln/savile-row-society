<?php

App::uses('AppController', 'Controller');

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
        //... but if $user_id is not null then always show stylist preview
        //if($messages_for_user_id){
//            // if $messages_for_user_id is not null, then admin come to this page from users administration.
//            // and page should act as stylist is logged in. 
//            $is_stylist = true;
//        }
        
         // make user_id, user
        $user_id = $this->getLoggedUserID();
        $this->set(compact('user_id', 'user', 'messages_for_user_id'));

        //chose witch view to render
        if ($is_stylist) {
            $Category = ClassRegistry::init('Category');
            $Brand = ClassRegistry::init('Brand');
            $Color = ClassRegistry::init('Color');
            
            // get data
            $categories = $Category->getAll();
            $brands = $Brand->find('all');
            $colors = $Color->find('all');
            // if stylist load user that write to logged in user.
            $clients = array();
                
            $clients_data = $User->getUserWriteToMe($this->getLoggedUserID());
            
            $client_id = 0;
            if($messages_for_user_id){
                $client_user = $User->getByID($messages_for_user_id);
                $client_id = $messages_for_user_id;
                
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
            
            foreach ($clients_data as $client) {
                $clients[$client['User']['id']] = $client[0]['full_name'];
            }

            $this->set(compact('clients', 'brands', 'colors', 'categories', 'client_user', 'client_id'));
            $this->render("stylist");
        } else {
            $stylist_id = $user['User']['stylist_id'];
            $client_user = $User->getByID($stylist_id);
            $this->set(compact('client_user'));
            $this->render("user");
        }
    }

    /*
     * Reply to message. NOT WORKING!!!!!! 
     */

    public function reply() {

        // init
        $User = ClassRegistry::init('User');

        $this->Message->create();
        // set attribures from gui: body, user_from_id, user_to_id, reply_to_id
        // TODO: think about format from client to enable something like this: $this->Message->set($this->data);
        // $this->Message->data['Message']['body'] = $this->request->data('body');
        $this->Message->data['Message']['user_to_id'] = $this->request->data('user_to_id');
        $this->Message->data['Message']['user_from_id'] = $this->request->data('user_from_id');
        $this->Message->data['Message']['reply_to_id'] = $this->request->data('reply_to_id');
        // set date
        $this->Message->data['Message']['date'] = date('Y-m-d H:i:s');

        // format message -> add previous message text
        // first load from db
        $readed_message = $this->Message->getById($this->request->data('reply_to_id'));
        $sender = $User->getById($this->request->data($this->getLoggedUserID()));
        if (count($readed_message) > 0) {
            $this->Message->data['Message']['body'] = $readed_message["Message"]["body"] . "<br/> <b>" . $sender["User"]["first_name"] . " " . $sender["User"]["last_name"] . "</b>: " . $this->request->data('body');
        } else {
            $this->Message->data['Message']['body'] = $sender["User"]["first_name"] . " " . $sender["User"]["last_name"] . "</b>: " . $this->request->data('body');
        }
        if ($this->Message->validates()) {
            // store in db
            $this->Message->save($this->Message->data);
        }
        if (count($readed_message) > 0) {
            // now update readed message
            // set is_read t- true. it's acctualy is answered in this case. consider adding or renaming columns in db
            $readed_message["Message"]["is_read"] = 1;
            // update...
            $this->Message->save($readed_message);
        }
        $this->set('data', $readed_message["Message"]["id"]);

        // set json layout
        $this->render('/Elements/SerializeJson/');
    }

    public function loadClientConversation($id) {

        // init
        $User = ClassRegistry::init('User');
        $user = $User->getByID($id);
    }

    /**
     * Send message to user or to stylist
     */
    public function send_message() {

        $this->Message->create();

        $this->Message->data['Message']['user_to_id'] = $this->request->data('user_to_id');
        $this->Message->data['Message']['user_from_id'] = $this->getLoggedUserID();
        $this->Message->data['Message']['body'] = $this->request->data('body');
        // set date to today
        $this->Message->data['Message']['date'] = date('Y-m-d H:i:s');

        // validate message
        if ($this->Message->validates()) {
            // store in db
            $this->Message->save($this->Message->data);
            $this->set('data', "ok");
        }

        $this->render('/Elements/SerializeJson/');
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
            $msg['UserFrom'] = array(
                                    'id' => $user['User']['id'],
                                    'first_name' => $user['User']['first_name'],
                                    'last_name' => $user['User']['last_name']
                                );
            $this->set('data', $msg);
        }

        $this->render('/Elements/SerializeJson/');
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

        if ($this->Message->validates()) {
            // store in db
            $res = $this->Message->save($this->Message->data);
            $msg['status'] = 'ok';            
            $msg['Message'] = $res['Message'];
            $msg['UserFrom'] = array(
                                    'id' => $user['User']['id'],
                                    'first_name' => $user['User']['first_name'],
                                    'last_name' => $user['User']['last_name']
                                );
            $this->set('data', $msg);
            
        }
        
        $this->render('/Elements/SerializeJson/');
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
                $my_conversation = $this->Message->getMyConversationWith($user_id,$with_user_id);
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
                        $entity_list = $Entity->getProductDetails($entities);
                        $row['Outfit'] = $entity_list;
                    }
                }
                $result['Messages'] = $my_conversation;
            }
            
            //Get a list of message ids and mark them read if not already read
            $mark_read_list = array();
            foreach($result['Messages'] as $msg){
                if($msg['Message']['user_to_id'] == $user_id){
                    $mark_read_list[] = array('id' => $msg['Message']['id'], 'is_read' => 1);         
                }
            }
            if(count($mark_read_list) > 0){
                $this->Message->saveAll($mark_read_list);
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
        if ($this->getLoggedUser()){
            $user_id = $this->getLoggedUserID();
            if($with_user_id){
                // if with user id is not null load data for stylist
                $User = ClassRegistry::init('User');
                $user = $User->getById($with_user_id);
                $result['User'] = array('full_name' => $user['User']['full_name'], 'profile_photo_url'=>$user['User']['profile_photo_url']);
                $my_conversation = $this->Message->getUnreadMessagesWith($user_id,$with_user_id);
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
            foreach($result['Messages'] as $msg){
                if($msg['Message']['user_to_id'] == $user_id){
                    $mark_read_list[] = array('id' => $msg['Message']['id'], 'is_read' => 1);         
                }
            }
            if(count($mark_read_list) > 0){
                $this->Message->saveAll($mark_read_list);
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
}
