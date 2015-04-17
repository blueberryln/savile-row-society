<?php

App::uses('AppController', 'Controller');
App::uses('Security', 'Utility');
App::uses('CakeEmail', 'Network/Email');
App::uses('Validation', 'Utility');

/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {
    public $components = array('Paginator');
    public $helpers = array('Paginator');
    var $uses = array('User','UserPreference','Style','InvitedUser','Userhighlighted');

   
    /**
     * User Referral
     */
    public function refer($refer_id = null){
        $user = $this->getLoggedUser();
        if(!$user && $refer_id && $refer_id > 0 && $this->User->exists($refer_id)){
            $referer = $this->User->findById($refer_id);

            if($referer['User']['is_stylist']){
                $this->Session->write('referer_type', 'stylist');        
            }
            else if($referer['User']['is_event']){
                $this->Session->write('referer_type', 'event');        
            }
            else{
                $this->Session->write('referer_type', 'user');
            }

            $this->Session->write('referer', $refer_id);
            $this->Session->write('showRegisterPopup', true);

            $noindex = 1;
            $this->set(compact('noindex'));
        }
        else{
            $this->redirect('/');
            exit;
        }
        $this->render('/Pages/home');
    }


    public function requestinvite(){
        if ($this->request->is('ajax')) {
        	$toemail = $this->request->data['invite-email'];

	        $this->InvitedUser->create();
	       	$this->InvitedUser->data['InvitedUser']['email'] = $this->request->data['invite-email'];
	        $this->InvitedUser->save($this->InvitedUser->data['InvitedUser']['email']);
            
            $ret = array();
			if ($toemail && Validation::email($toemail) && !$this->User->findByEmail($toemail)) {
                $email = new CakeEmail('default');
                $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                $email->to($toemail);
                $email->cc(array('contact@savilerowsociety.com' => 'Savile Row Society'));
                $email->subject('Thank you!');
                $email->template('requestinvite');
                $email->emailFormat('html');
                $email->viewVars(compact($toemail));

                if ($email->send()) {
                    $ret['status'] = 'ok';
                } else {
                    $ret['status'] = 'error';
                }
            } 
            else if ($toemail && Validation::email($toemail) && $this->User->findByEmail($toemail)){
                $ret['status'] = 'member';
            }
            else {
                $ret['status'] = 'invalid-email';
            }
        }

        echo json_encode($ret);
        exit;
    }

    
    /**
     * Sign in
     */
    public function signin() {

        // title
        $title_for_layout = 'Sign in';

        if ($this->request->is('post')) {
            
            $this->User->set($this->request->data);
            
            $refer_url = $this->request->data['User']['refer_url'];
            if($refer_url != 'http://blog.savilerowsociety.com' && $refer_url != ''){
                $refer_url = "/" . $refer_url;   
            }
            
            
            // Remove 'required' rule from password
            $this->User->validator()->remove('email', 'unique');
            if ($this->User->validates(array('fieldList' => array('email', 'password')))) {
                
                // check submitted email and password 
                $results = $this->User->checkCredentials($this->request->data['User']['email'], Security::hash($this->request->data['User']['password']));
                $results_inactive = $this->User->checkCredentials_inactive($this->request->data['User']['email'], Security::hash($this->request->data['User']['password']));
                if ($results) {
                    
                    // set "user" session
                    $this->Session->write('user', $results);
                    
                    // Delete refer sessions
                    if($this->Session->check('referer')){
                        $this->Session->delete('referer');
                        $this->Session->delete('showRegisterPopup'); 
                        $this->Session->delete('referer_type');
                    }   

                    if($this->Session->check('landing_offer')){
                        $user_offer = $this->Session->read('landing_offer');
                        $this->Session->delete('landing_offer');
                        $this->Session->delete('landing_text');
                        
                        $UserOffer = ClassRegistry::init('UserOffer');
                        $existing_offer = $UserOffer->findByUserId($results['User']['id']);
                        if(!$existing_offer){
                            $user_offer['UserOffer']['user_id'] = $results['User']['id'];    
                            $UserOffer->create();
                            $UserOffer->save($user_offer);
                        }
                    }


                    if($this->Session->check('guest_items')){
                        $cart_list = $this->Session->read('guest_items');

                        $Cart = ClassRegistry::init('Cart');
                        $CartItem = ClassRegistry::init('CartItem');

                        $data = array();
                        $data['Cart']['user_id'] = $results['User']['id'];
                        $Cart->create();
                        $result = $Cart->save($data);

                        $cart_id = $result['Cart']['id'];
                        foreach($cart_list as $item){
                            $item['CartItem']['user_id'] = $results['User']['id'];
                            $item['CartItem']['cart_id'] = $cart_id;
                            $CartItem->create();
                            $result = $CartItem->save($item);
                        }


                        $this->Session->delete('guest_items');
                    }

                    
                    //Set complete style profile popup if style profile not complete
                    if (!$results['User']['preferences']) {
                        $this->Session->write('completeProfile', true);       
                    }
                    else {
                        $preferences = unserialize($results['User']['preferences']);
                        if(!isset($preferences['UserPreference']['is_complete'])){
                            $this->Session->write('completeProfile', true);     
                        }
                        else if(!$preferences['UserPreference']['is_complete']) {
                            $this->Session->write('completeProfile', true);     
                        }
                    }
                    
                    
                    if(!empty($refer_url)){
                        $this->redirect($refer_url);
                        exit;
                    }
                    // redirect to home
                    //$this->Session->setFlash(__('Welcome to SRS!'), 'modal', array('class' => 'success', 'title' => 'Hey!'));
                    // redirect if return url is set
                    $retrun_url = $this->Session->read('return_url');
                    if (!empty($retrun_url)) {
                        $this->redirect($retrun_url);
                        exit();
                    }
                    $this->redirect('/messages/index');
                    exit();
                }
                else if($results_inactive){
                    $this->Session->write('results_inactive',$results_inactive);
                    $this->Session->setFlash(__('Your account needs to be activated. You need to confirm your account by clicking on the activation link sent in an email. Click button below to resend the email.'), 'forgot_flash');
                    $this->redirect($this->referer());
                    exit();

                } 
                else {
                    // login data is wrong, redirect to login page
                    $this->request->data = null;
                    $this->Session->setFlash(__('Wrong credentials! Please, try again.'), 'forgot_flash');
                    $this->redirect($this->referer());
                    exit();
                }
            }
            else{
                $this->request->data = null;
                $this->Session->setFlash(__('Wrong credentials! Please, try again.'), 'forgot_flash');
                $this->redirect($this->referer());
                exit;
            }
        }
        else{
            $this->redirect('/');
            exit;
        }
    }

   
   
    /*
     * Temporary in use for user registration.
     * Should be replaced with new sign in process
     */

    function shortRegistration() {
        $user = $this->request->data;
        
        if ($this->User->validates()) {
            $registered = $this->User->find('count', array('conditions' => array('User.email' => $user['User']['email'])));
            if($registered){
                $this->Session->setFlash(__('You are already registered. Please sign in.'), 'flash');
                $this->redirect($this->referer());
                exit;    
            }
            
            $this->User->create();
            // hash password
            if (!empty($user['User']['password'])) {
                $user['User']['password'] = Security::hash($user['User']['password']);
            }
            // username (slug)
            $full_name = $user['User']['first_name'] . ' ' . $user['User']['last_name'];
            $user['User']['username'] = strtolower(Inflector::slug($full_name, $replacement = '.'));

            if($this->Session->check('referer')){
                $user['User']['referred_by'] = $this->Session->read('referer');  
                $user['User']['vip_discount_flag'] = 1; 
            }

            if ($this->User->save($user)) {
                if($this->Session->check('referer')){
                    $this->Session->delete('referer');
                    $this->Session->delete('showRegisterPopup'); 
                    $this->Session->delete('referer_type');
                }


                //$this->Session->write('completeProfile', true);
                // send welcome mail
                /* uncoment this to deploy code */
                try{
                  $bcc = Configure::read('Email.contact');
                  $email = new CakeEmail('default');


                  $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                  $email->to($user['User']['email']);
                  $email->subject('Welcome To Savile Row Society');
                  $email->bcc($bcc);
                  $email->template('registration');
                  $email->emailFormat('html');
                  $email->viewVars(array('name' => $user['User']['first_name']));
                  $email->send();
                }
                catch(Exception $e){
                        
                }
                // signin newly registered user
                // check submitted email and password 
                $results = $this->User->checkCredentials($user['User']['email'], $user['User']['password']);

                if ($results) {
                    
                    // set "user" session
                    $this->Session->write('user', $results);

                    if($results['User']['vip_discount_flag'] && $results['User']['referred_by']){
                        $this->assignVipDiscount($results['User']['referred_by']);
                    }

                    $this->redirect('/register/wardrobe');
                    exit;
                } else {
                    // redirect to home
                    $this->redirect($this->referer());
                    exit;
                }
            } else {
                $this->Session->setFlash(__('There was a problem. Please, try again.'), 'flash');
                $this->redirect($this->referer());
            }
        } else {
            $this->Session->setFlash(__('Please, sign in.'), 'flash', array('title' => 'You are already registered!'));
            $this->redirect($this->referer());
        }
    }

   
    /**
     * Sign out
     */
    function signout() {
        $this->autoRender = false;
        $this->autoLayout = false;

        // destroy all sessions
        $this->Session->delete('user');
        $this->Session->destroy();

        //$this->Session->setFlash(__('We hope that you\'ll come back'), 'modal', array('class' => 'info', 'title' => 'Good bye :('));
        $this->redirect($this->referer());
        exit();
    }

   
    /**
     * Forgot password 
     */
    public function forgot() {
        // title
        $title_for_layout = 'Reset password';

        if ($this->request->is('post')) {

            $user = $this->User->getByEmail($this->request->data['User']['email']);
            if ($user) {
                //$email = new CakeEmail(array('log' => true));
                $email = new CakeEmail('default');
                $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                $email->to($user['User']['email']);
                $email->subject('Forgotten Password');
                $email->template('forgot');
                $email->emailFormat('html');
                $email->viewVars(array('user' => $user));

                if ($email->send()) {
                    $this->Session->setFlash(__('Password reset instructions are sent'), 'flash', array( 'title' => 'Check your E-mail!'));
                    $this->redirect('/');
                } else {
                    $this->Session->setFlash(__('We cannot reset your password at the moment'), 'flash');
                }
            } else {
                $this->Session->setFlash(__('We cannot reset your password at the moment'), 'flash');
            }
        }

        $this->set(compact('title_for_layout'));
    }

    /**
     * Forgot reset password 
     */
    public function reset($user_id = null, $reset_code = null) {

        $this->autolayout = false;
        $this->autoRender = false;

        // title
        $title_for_layout = 'Reset password';

        if (!empty($user_id) && !empty($reset_code)) {

            // get data
            $user = $this->User->getByIDAndCode($user_id, $reset_code);

            if ($user) {

                // random password
                $new_password = Security::generateAuthKey();

                // save new password
                unset($user['User']['updated']);
                $user['User']['password'] = Security::hash($new_password);

                if ($this->User->save($user)) {

                    $email = new CakeEmail('default');
                    $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                    $email->to($user['User']['email']);
                    $email->subject('New Password!');
                    $email->template('password_new');
                    $email->emailFormat('html');
                    $email->viewVars(array('user' => $user));
                    $email->viewVars(array('new_password' => $new_password));
                    $email->send();

                    $this->Session->setFlash(__('A new password has been sent to your e-mail address.'), 'flash', array('title' => 'Now, you can sign in!'));

                    //redirect to dashboard
                    $this->redirect('/signin');
                } else {
                    $this->Session->setFlash(__('We cannot reset your password at the moment'), 'flash');
                }
            }
            else{
                $this->redirect('/');
                exit();    
            }
        } else {
            $this->redirect('/');
            exit();
        }

        $this->set(compact('title_for_layout'));
    }

       
    /**
     * Return logged in user or..
     * if come to reg pages from user administration then return user that was choosen
     */
    function getEditingUser($user_id = null){
        $this->isLogged();
        $logged_user = $this->getLoggedUser();
        if($user_id || (isset($this->request->data['User']) && $this->request->data['User'] && $this->request->data['User']['id'])){
            if(isset($this->request->data['User']) && $this->request->data['User'] && $this->request->data['User']['id']){
                $user_id =  $this->request->data['User']['id'];    
            }    
            
            $editing_user = $this->User->getByID($user_id);
            
            //Check if the logged user is admin or the stylist for the editing user; otherwise redirect to home
            if($logged_user['User']['id'] == $user_id || $logged_user['User']['is_admin'] == 1 || ($logged_user['User']['is_stylist'] == 1 && $logged_user['User']['id'] == $editing_user['User']['stylist_id'])){
                return $editing_user;
            }
            else{
                $this->redirect('/');
                exit();
            }
        }
        else{
            $user_id = $logged_user['User']['id'];
            $editing_user = $this->User->getByID($user_id);
            return $editing_user;
        }
    }

    //bhashit code shift from auth controll 25/9/14 2:58 AM

    //function register start
    public function register()

    {
        $title_for_layout = "Sign up for Savile Row Society - Featured Personal Stylists";

        if(isset($this->request->query['refer'])){
            $this->Session->write('stylist_refer', $this->request->query['refer']);   
        }

        if($this->getLoggedUserID()){
            $this->redirect('/messages/index');
            exit();   
        }
        else if($this->request->is('post') ){
            $user = $this->request->data;
            
            if ($this->User->validates()) {
                $registered = $this->User->find('count', array('conditions' => array('User.email' => $user['User']['email'])));
                if($registered){
                    $this->Session->setFlash(__('You are already registered. Please sign in.'), 'flash');
                    $this->redirect('/');
                    exit;    
                }

                $user['User']['password'] = Security::hash($user['User']['password']);
                $full_name = $user['User']['first_name'] . ' ' . $user['User']['last_name'];
                $user['User']['username'] = strtolower(Inflector::slug($full_name, $replacement = '.'));
                $user['UserPreference']['style_pref'] = implode(',', $user['UserPreference']['style_pref']);

                if(isset($user['User']['is_phone']) && $user['User']['is_phone']==true){
                    $user['User']['is_phone']='1'; 
                }
                else{
                    $user['User']['is_phone']='0';    
                }
                if(isset($user['User']['is_skype']) && $user['User']['is_skype']==true){
                   $user['User']['is_skype']='1'; 
                }else{
                    $user['User']['is_skype']='0'; 
                }
                if(isset($user['User']['is_srs_msg']) && $user['User']['is_srs_msg']==true){
                   $user['User']['is_srs_msg']=1; 
                }

                if($image = $this->saveImage()){
                    $user['User']['profile_photo_url'] = $image;
                }
                else{
                    $user['User']['profile_photo_url'] = null;    
                }

                if($this->Session->check('referer')){
                    $user['User']['referred_by'] = $this->Session->read('referer');  
                    $user['User']['vip_discount_flag'] = 1; 
                }


                if ($this->User->saveAll($user)) {
                    if($this->Session->check('referer')){
                        $this->Session->delete('referer');
                        $this->Session->delete('showRegisterPopup'); 
                        $this->Session->delete('referer_type');
                    }

                    $results = $this->User->checkCredentials($user['User']['email'], $user['User']['password']);

                    if($this->Session->check('landing_offer')){
                        $user_offer = $this->Session->read('landing_offer');
                        $this->Session->delete('landing_text');
                        
                        $user_offer['UserOffer']['user_id'] = $results['User']['id'];

                        $UserOffer = ClassRegistry::init('UserOffer');
                        $UserOffer->create();
                        $UserOffer->save($user_offer);
                    }


                    if($this->Session->check('guest_items')){
                        $cart_list = $this->Session->read('guest_items');

                        $Cart = ClassRegistry::init('Cart');
                        $CartItem = ClassRegistry::init('CartItem');

                        $data = array();
                        $data['Cart']['user_id'] = $results['User']['id'];
                        $Cart->create();
                        $result = $Cart->save($data);

                        $cart_id = $result['Cart']['id'];
                        foreach($cart_list as $item){
                            $item['CartItem']['user_id'] = $results['User']['id'];
                            $item['CartItem']['cart_id'] = $cart_id;
                            $CartItem->create();
                            $result = $CartItem->save($item);
                        }


                        $this->Session->delete('guest_items');
                    }


                    try{
                      $bcc = Configure::read('Email.contact');
                      $email = new CakeEmail('default');


                      $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                      $email->to($user['User']['email']);
                      $email->subject('Welcome To Savile Row Society');
                      $email->bcc($bcc);
                      $email->template('registration');
                      $email->emailFormat('html');
                      $email->viewVars(array('name' => $user['User']['first_name']));
                      $email->send();
                    }
                    catch(Exception $e){
                            
                    }
                    // signin newly registered user
                    // check submitted email and password 

                    if ($results) {
                        $stylist_id = $this->assign_refer_stylist($results['User']['id']);
                        $this->mailto_sales_team($user,$stylist_id);    // sends an email to the sales team
                        App::import('Controller', 'Messages');
                        $Messages = new MessagesController;
                        $Messages->send_welcome_message($results['User']['id'], $stylist_id);

                        // set "user" session
                        $this->Session->write('user', $results);

                        if($results['User']['vip_discount_flag'] && $results['User']['referred_by']){
                            $this->assignVipDiscount($results['User']['referred_by']);
                        }

                        $this->Session->write('new_user', 'new_user');

                        $this->redirect(array('controller' => 'messages'));
                    } else {
                        // redirect to home
                        $this->redirect($this->referer());
                        exit;
                    }
                } else {
                    $this->Session->setFlash(__('There was a problem. Please, try again.'), 'flash');
                    $this->redirect($this->referer());
                }
            }   
        }
        else{

            if($this->Session->check('new_user')){
                $new_user = $this->Session->read('new_user');
                $this->Session->delete('new_user');
                $this->request->data['User'] = $new_user['User'];
            }
        }

        $styles = $this->Style->find('all');
        $this->set(compact('styles', 'title_for_layout'));  
    }


    public function landing()
    {

        if($this->getLoggedUserID()){
            $this->redirect('/messages/index');
            exit();   
        }
        else if($this->request->is('post') ){
            $user = $this->request->data;
            
            if ($this->User->validates()) {
                $registered = $this->User->find('count', array('conditions' => array('User.email' => $user['User']['email'])));
                if($registered){
                    $this->Session->setFlash(__('You are already registered. Please sign in.'), 'flash');
                    $this->redirect('/');
                    exit;    
                }
                $user['User']['lead'] = 1;
                $user['User']['confirm_password'] = $user['User']['password'];
                $user['User']['password'] = Security::hash($user['User']['password']);
                $full_name = $user['User']['first_name'] . ' ' . $user['User']['last_name'];
                $user['User']['username'] = strtolower(Inflector::slug($full_name, $replacement = '.'));
                //$user['UserPreference']['style_pref'] = implode(',', $user['UserPreference']['style_pref']);
                
                $user['User']['is_phone']='0';    
                
                $user['User']['is_skype']='0'; 
              
                $user['User']['profile_photo_url'] = null;    
                

                if ($this->User->saveAll($user)) {
                   
                    if($user['User']['active']=='0'){
                        $results = $this->User->checkCredentials_inactive($user['User']['email'], $user['User']['password']);
                    }
                    else{
                        $results = $this->User->checkCredentials($user['User']['email'], $user['User']['password']);
                    }

                    if($this->Session->check('landing_offer')){
                        $user_offer = $this->Session->read('landing_offer');
                        $this->Session->write('thankyou',$this->Session->read('landing_offer'));
                        $this->Session->delete('landing_text');
                        
                        $user_offer['UserOffer']['user_id'] = $results['User']['id'];

                        $UserOffer = ClassRegistry::init('UserOffer');
                        $UserOffer->create();
                        $UserOffer->save($user_offer);

                        $this->Session->write('login_lead', 1);
                    }


                    if($this->Session->check('guest_items')){
                        $cart_list = $this->Session->read('guest_items');

                        $Cart = ClassRegistry::init('Cart');
                        $CartItem = ClassRegistry::init('CartItem');

                        $data = array();
                        $data['Cart']['user_id'] = $results['User']['id'];
                        $Cart->create();
                        $result = $Cart->save($data);

                        $cart_id = $result['Cart']['id'];
                        foreach($cart_list as $item){
                            $item['CartItem']['user_id'] = $results['User']['id'];
                            $item['CartItem']['cart_id'] = $cart_id;
                            $CartItem->create();
                            $result = $CartItem->save($item);
                        }


                        $this->Session->delete('guest_items');
                    }


                    try{
                      $bcc = Configure::read('Email.contact');
                      $email = new CakeEmail('default');


                      $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                      $email->to($user['User']['email']);
                      $email->subject('Welcome To Savile Row Society');
                      $email->bcc($bcc);
                      $email->template('registration');
                      $email->emailFormat('html');
                      $email->viewVars(array('name' => $user['User']['first_name']));
                      $email->send();
                    }
                    catch(Exception $e){
                            
                    }

                    if ($results) {
                        $stylist_id = $this->assign_refer_stylist($results['User']['id']);
                        $this->mailto_sales_team($user,$stylist_id);    // sends an email to the sales team
                        App::import('Controller', 'Messages');
                        $Messages = new MessagesController;
                        $Messages->send_welcome_message($results['User']['id'], $stylist_id);

                        
                        if($results['User']['active']){
                           $this->Session->write('user', $results);
                        }
                        else{
                            $this->confirmation_email($results);
                        }

                        if($results['User']['vip_discount_flag'] && $results['User']['referred_by']){
                            $this->assignVipDiscount($results['User']['referred_by']);
                        }

                        //$this->Session->write('new_user', 'new_user');

                        if($results['User']['active']){
                            $this->redirect(array('controller' => 'messages'));
                        }else{  // runs when User.active is false
                            $this->Session->write('results_inactive',$results);
                            $this->Session->setFlash(__('Please check ur email inbox for account activation email.'), 'forgot_flash');
                            $this->redirect($this->referer());
                            exit();
                        }
                    } else {
                        $this->redirect($this->referer());
                        exit;
                    }
                } else {
                    $this->Session->setFlash(__('There was a problem. Please, try again.'), 'flash');
                    $this->redirect($this->referer());
                }
            }   
        }
    }


    public function quickregister()

    {
        if(isset($this->request->query['refer'])){
            $this->Session->write('stylist_refer', $this->request->query['refer']);   
        }

        if($this->getLoggedUserID()){
            $this->redirect('/messages/index');
            exit();   
        }
        else if($this->request->is('post') ){
            $user = $this->request->data;

            $cart_list = false;
            if($this->Session->check('guest_items')){
                $cart_list = $this->Session->read('guest_items');
            }

            if ($this->User->validates()) {
                $registered = $this->User->find('count', array('conditions' => array('User.email' => $user['User']['email'])));
                if($registered){
                    $this->Session->setFlash(__('You are already registered. Please sign in.'), 'flash');
                    $this->redirect('/guest/cart');
                    exit;    
                }

                $user['User']['password'] = Security::hash($user['User']['password']);

                if($this->Session->check('referer')){
                    $user['User']['referred_by'] = $this->Session->read('referer');  
                    $user['User']['vip_discount_flag'] = 1; 
                }


                if ($this->User->saveAll($user)) {
                    if($this->Session->check('referer')){
                        $this->Session->delete('referer');
                        $this->Session->delete('showRegisterPopup'); 
                        $this->Session->delete('referer_type');
                    }


                    $results = $this->User->checkCredentials($user['User']['email'], $user['User']['password']);

                    if($this->Session->check('landing_offer')){
                        $user_offer = $this->Session->read('landing_offer');
                        $this->Session->delete('landing_offer');
                        $this->Session->delete('landing_text');
                        
                        $user_offer['UserOffer']['user_id'] = $results['User']['id'];

                        $UserOffer = ClassRegistry::init('UserOffer');
                        $UserOffer->create();
                        $UserOffer->save($user_offer);
                    }

                    if($cart_list){
                        $Cart = ClassRegistry::init('Cart');
                        $CartItem = ClassRegistry::init('CartItem');

                        $data = array();
                        $data['Cart']['user_id'] = $results['User']['id'];
                        $Cart->create();
                        $result = $Cart->save($data);

                        $cart_id = $result['Cart']['id'];
                        foreach($cart_list as $item){
                            $item['CartItem']['user_id'] = $results['User']['id'];
                            $item['CartItem']['cart_id'] = $cart_id;
                            $CartItem->create();
                            $result = $CartItem->save($item);
                        }


                        $this->Session->delete('guest_items');
                    }



                    try{
                      $bcc = Configure::read('Email.contact');
                      $email = new CakeEmail('default');


                      $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                      $email->to($user['User']['email']);
                      $email->subject('Welcome To Savile Row Society');
                      $email->bcc($bcc);
                      $email->template('registration');
                      $email->emailFormat('html');
                      $email->send();
                    }
                    catch(Exception $e){
                            
                    }
                   

                    if ($results) {
                        $this->Session->write('user', $results);

                        if($results['User']['vip_discount_flag'] && $results['User']['referred_by']){
                            $this->assignVipDiscount($results['User']['referred_by']);
                        }

                        $this->redirect('/cart');
                    } else {

                        // redirect to home
                        $this->redirect($this->referer());
                        exit;

                    }
                } else {
                    $this->Session->setFlash(__('There was a problem. Please, try again.'), 'flash');
                    $this->redirect($this->referer());
                }
            }   
        }

        $styles = $this->Style->find('all');
        $this->set('styles', $styles);  
    }

       
         /**
     * Assign VIP dicsount
     */
    public function assignVipDiscount($referer_id){
        $referer = $this->User->findById($referer_id);  
        if(!$referer['User']['vip_discount']){
            $referer['User']['vip_discount_flag'] = 1;
            $this->User->save($referer);    
        }
    }

                     
 public function assign_refer_stylist($user_id){
        $user = $this->User->findById($user_id);
        $new_stylist = array();

        if($this->Session->check('stylist_refer')){
            $stylist_refer = $this->Session->read('stylist_refer');
            $refered_stylist = $this->User->getByID($stylist_refer);

            if(!$refered_stylist){
                $stylist_refer = false;
            }
        }
        else{
            $stylist_refer = false;    
        }


        if($user['User']['referred_by']){
            $referer = $this->User->getByID($user['User']['referred_by']);
            if($referer && $referer['User']['is_stylist']){
                $user['User']['stylist_id'] = $referer['User']['id'];
                $new_stylist = $referer;
            }
            else if ($referer && $referer['User']['stylist_id'] && $user_stylist = $this->User->getByID($referer['User']['stylist_id'])){
                $user['User']['stylist_id'] = $referer['User']['stylist_id'];    
                $new_stylist = $user_stylist;
            }
            else{
                $stylist = $this->User->find('first', array('order' => 'rand()', 'conditions' => array('is_stylist' => true,'random_stylist' => true))); 
                if($stylist){
                    $user['User']['stylist_id'] = $stylist['User']['id']; 
                    $new_stylist = $stylist;         
                }   
            }
        }
        else{
            if($stylist_refer){
                $user['User']['stylist_id'] = $refered_stylist['User']['id']; 
                $new_stylist = $refered_stylist;    
            }
            else{
                $stylist = $this->User->find('first', array('order' => 'rand()', 'conditions' => array('is_stylist' => true,'random_stylist' => true))); 
                if($stylist){
                    $user['User']['stylist_id'] = $stylist['User']['id']; 
                    $new_stylist = $stylist;         
                }   
            }    
        }
        $this->User->save($user);

        $stylist_email = $new_stylist['User']['email'];
        $stylist_name = $new_stylist['User']['first_name'];
        
       

        return $new_stylist['User']['id'];
    }

    public function saveImage() {
        $image = null;
        $image_type = '';
        $image_size = '';
        // get edditing in user

        // file upload

        if ($this->request->data['User']['profile_photo_url'] && $this->request->data['User']['profile_photo_url']['size'] > 0) {

            $allowed = array('image/jpeg', 'image/gif', 'image/png', 'image/x-png', 'image/x-citrix-png', 'image/x-citrix-jpeg', 'image/pjpeg');

            if (!in_array($this->request->data['User']['profile_photo_url']['type'], $allowed)) {
                $this->Session->setFlash(__('You have to upload an image.'), 'flash');
            } else if ($this->request->data['User']['profile_photo_url']['size'] > 5242880) {
                $this->Session->setFlash(__('Attached image must be up to 5 MB in size.'), 'flash');
                $this->redirect('register/style/' . $id);
                exit;
            } else {
                $image = time() .  '_' . $this->request->data['User']['profile_photo_url']['name'];
                $image_type = $this->request->data['User']['profile_photo_url']['type'];
                $image_size = $this->request->data['User']['profile_photo_url']['size'];
                $img_path = APP . 'webroot' . DS . 'files' . DS . 'users' . DS . $image;
                move_uploaded_file($this->request->data['User']['profile_photo_url']['tmp_name'], $img_path);
                return $image;
            }
        }
    }




    public function profile($id= null){
        $this->isLogged();
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $user = $this->User->findById($id);
        $current_user = $this->getLoggedUser();

        if($id != $current_user['User']['id'] && !$current_user['User']['is_admin'] && $current_user['User']['id'] != $user['User']['stylist_id']){
            $this->redirect('/');
            exit;
        }
        if($user['User']['stylist_id']){
            $this->redirect('/');
            exit;   
        }

        if($this->request->is('post') || $this->request->is('put')){
            if(!empty($this->request->data['User']['is_phone'])){
                $this->request->data['User']['is_phone']='1'; 
            }else{
                $this->request->data['User']['is_phone']='0';
            }
            if(!empty($this->request->data['User']['is_skype'])){
                $this->request->data['User']['is_skype']='1'; 
            }else{
                $this->request->data['User']['is_skype']='0';
            }
            if(!empty($this->request->data['User']['is_srs_msg'])){
                $this->request->data['User']['is_srs_msg']='1'; 
            }else{
                $this->request->data['User']['is_srs_msg']='0';
            }
            if($image = $this->saveImage()){
                $this->request->data['User']['profile_photo_url'] = $image;
            }
            else{
                unset($this->request->data['User']['profile_photo_url']);
            }

            unset($this->request->data['User']['email']);
            unset($this->request->data['User']['password']);


            $this->request->data['UserPreference']['style_pref'] = implode(',', $this->request->data['UserPreference']['style_pref']);
            if($this->User->saveAll($this->request->data))
            {
                $stylist_id = $this->assign_refer_stylist($user['User']['id']);
                App::import('Controller', 'Messages');
                $Messages = new MessagesController;
                $Messages->send_welcome_message($user['User']['id'], $stylist_id);

                $user = $this->User->findById($id);

                $this->Session->write('user', $user);

                $this->Session->setFlash("User data has been Saved", 'flash');
                $this->redirect('/');
            }
            else
            {
                $this->Session->setFlash('The User could not be saved. Please, try again.', 'flash');
            }
        }
        if (empty($this->request->data)) {
                $this->request->data = $this->User->find('first',
                        array(
                            'contain' => array('UserPreference'),
                            'conditions' => array('User.id' => $id  ),
                        )
                    );
        }
        $styles = $this->Style->find('all');
        $this->set('styles', $styles);  
    }
    

    

    /**
     * Actions for the admin below.
     * All user actions above this.
     */



    /**
     * admin_index method
     *
     * @return void
     */
    //bhashit code
    public function admin_index() {
        $this->layout = 'admin';
        $this->isAdmin();
        $this->Paginator->settings = array(
                 'fields' => array('User.*', 'UserPreference.*'),
                 'joins' => array(
                     array('table' => 'messages',
                         'alias' => 'Message',
                         'type' => 'LEFT',
                         'conditions' => array(
                             'User.id = Message.user_from_id'
                         )
                     ),
                     array('table' => 'users_preferences',
                         'alias' => 'UserPreference',
                         'type' => 'LEFT',
                         'conditions' => array(
                             'User.id = UserPreference.user_id'
                         )
                     ),

                 ),
                 'limit' => 20,
                 'group' => array('User.id'),
                 'order' => array('User.id' => 'DESC', 'Message.unread' => 'DESC', 'Message.message_date' => 'desc'),
        );
        $stylists = $this->User->find('list', array('conditions'=>array('is_stylist' => true,)));
        
        $users = $this->Paginator->paginate(); 
        $this->set(compact('stylists','users'));
        $styles = $this->Style->find('all');
        $this->set('styles', $styles);


    }
    
    /**
     * admin_stylist method
     *
     * @return void
     */
    //bhashit code
    public function admin_stylist(){
         
        $this->layout = 'admin';
        $this->isAdmin();
        $this->Paginator->settings= array(
                'fields' => array('User.*,count(User.id) as usercount'),
                'joins' => array(

                array(
                    'conditions' => array(
                        'User.is_stylist' => true,
                        'User1.stylist_id = User.id',
                    ),
                    'table' => 'users',
                    'alias' => 'User1',
                    'type' => 'INNER',
                ),
                ),
                'group' => array(
                'User.id',
                ),
                'limit'=> 20,
                'order' => array('User.id'=>'DESC'),
                
                );
        //$Stylsts = $this->User->find('all',$options);
        $Stylsts=$this->Paginator->paginate();
        $this->set(compact('Stylsts',$Stylsts));
        //print_r($Stylsts);
        
        
    }
    

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    //bhashit code
    public function admin_edit($id = null) {

        $this->layout = 'admin';
        $this->isAdmin();

        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $user_data = $this->User->findById($id);
            if($this->request->data['User']['stylist_id'] == ""){
                $this->request->data['User']['stylist_id'] = null;
            }

            if($user_data['User']['password'] != $this->request->data['User']['password']) {
                $this->request->data['User']['password'] = Security::hash($this->request->data['User']['password']);
            }
            else{
                unset($this->request->data['User']['password']);
            }

            
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'), 'flash');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'flash');
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
        }
        $stylists = $this->User->find('list', array('conditions'=>array('is_stylist' => true,)));
        
        $this->set(compact('id', 'stylists'));
    }



    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {

        $this->layout = 'admin';
        $this->isAdmin();

        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'), 'flash');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'), 'flash');
        $this->redirect(array('action' => 'index'));
    }



    /**
     * Export to Excel
     */
    function admin_export() {

        $this->autoRender = false;
        $this->autoLayout = 'xls';
        $this->isAdmin();

        $users = $this->User->getAll();
        $stylists = $this->User->find('list', array('conditions'=>array('is_stylist' => true,)));
        $this->set(compact('users', 'stylists'));
        $this->set('filename', 'SRS_Users_' . date('m.d.Y-H.i'));
        $this->render('admin_export', 'xls');
    }


    /**
     * admin_search method: search user filters(user id, name, email)
     *
     * @param $user_id ID of the user
     * @param   $user_name name of the user; can be either first/ last name.
     * @param   $email user email
     */
    public function admin_search($user_id = null, $user_name = null, $email = null) {
        $this->layout = 'admin';
        $this->isAdmin();

        //Check if atleast one input has a value
        if((is_null($user_id) || $user_id == '') && (is_null($user_name) || $user_name == '') && (is_null($email) || $email == '')) {
            $products = null;
        }
        else {
            $find_array = array(
                'limit' => 20,
                'conditions' => array('OR' => array()),    
            );

            if((!is_null($user_id) && $user_id != '')){
                $find_array['conditions']['OR']['id'] = $user_id; 
            }

            if((!is_null($user_name) && $user_name != '')){
                $find_array['conditions']['OR']['LOWER(first_name) LIKE'] = '%' . strtolower($user_name) . '%'; 
                $find_array['conditions']['OR']['LOWER(last_name) LIKE'] = '%' . strtolower($user_name) . '%'; 
            }

            if((!is_null($email) && $email != '')){
                $find_array['conditions']['OR']['LOWER(email)'] = strtolower($email); 
            }

            $this->Paginator->settings = $find_array;
            $users = $this->Paginator->paginate($this->User);

        }
        $user_id = is_null($user_id) || $user_id == 'null' ? '' : $user_id;
        $user_name = is_null($user_name) || $user_name == 'null'  ? '' : $user_name;
        $email = is_null($email) || $email == 'null'  ? '' : $email;
        $this->set(compact('users', 'user_id', 'user_name', 'email'));
    }


    //bhashit code
    public function admin_topstylist(){
        $this->layout = 'admin';
        $this->isAdmin();
       
        if($this->request->is('post')){

            $userhighlights = $this->request->data;
             if ($this->Userhighlighted->validates()) {
                $checkhighlight = $this->Userhighlighted->find('count', array('conditions' => array('Userhighlighted.order_id' => $userhighlights['Userhighlighted']['order_id'])));
                if($checkhighlight){
                    $this->Session->setFlash(__('This order number is already added. Please Used anthor.'), 'flash');
                    $this->redirect(array('action' => 'highlightedstylist'));
                    exit;    
                }
            }


            if($this->Userhighlighted->save($this->request->data)){
                $this->Session->setFlash(__('The Userhighlighted has been saved'), 'flash');
                $this->redirect(array('action' => 'highlightedstylist'));
            } else {
                $this->Session->setFlash(__('The Userhighlighted could not be saved. Please, try again.'), 'flash');
            }
        
        }

        $stylists = $this->User->find('all', array('conditions'=>array('is_stylist' => true,)));
        
        // $topStylists = getTopStylists

        $this->set(compact('stylists'));
        $this->set('Userhighlight',$Userhighlight);

    }

    public function admin_highlightedstylistedit($highlighted_id = null) {
        $this->layout = 'admin';
        $this->isAdmin();

        if (!$this->Userhighlighted->exists($highlighted_id)) {
            throw new NotFoundException(__('Invalid Userhighlighted'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            //print_r($this->request->data);exit;
            $user_data = $this->Userhighlighted->findById($highlighted_id);
            if ($this->Userhighlighted->save($this->request->data)) {
                $this->Session->setFlash(__('The Userhighlighted has been saved'), 'flash');
                $this->redirect(array('action' => 'highlightedstylist'));
            } else {
                $this->Session->setFlash(__('The Userhighlighted could not be saved. Please, try again.'), 'flash');
            }
        } else {
            $options = array('conditions' => array('Userhighlighted.' . $this->Userhighlighted->primaryKey => $highlighted_id));
            $this->request->data = $this->Userhighlighted->find('first', $options);
            //print_r($this->request->data);exit;
        }
        
        $higtlited_condition = $this->Paginator->settings = array(
                'fields' => array('User.*,Userhighlighted.*'),
                'joins' => array(

                array(
                    'conditions' => array(
                        'User.is_stylist' => true,
                        'Userhighlighted.user_id = User.id',
                        'Userhighlighted.id' => $highlighted_id
                    ),
                    'table' => 'userhighlighteds',
                    'alias' => 'Userhighlighted',
                    'type' => 'INNER',
                ),
                ),
                );

        $highlight = $this->User->find('all', $higtlited_condition);
        $this->set('highlight',$highlight);
        

    }

    function account_activation($user_id = null,$offer = null) {    //account activation when user click link in email
        //$this->loadModel('User');
        $id = convert_uudecode(base64_decode($user_id));
        $offer = convert_uudecode(base64_decode($offer));
        $user = $this->User->getByID($id);
        if($user['User']['active'] == 0){
            $this->User->id = $user['User']['id'];
            $this->User->saveField('active','1');
            $results = $this->User->checkCredentials($user['User']['email'], $user['User']['password']);
            $this->Session->write('user',$results);
            $offer_details['UserOffer'] = $this->getOfferDetails($offer);
            if(!empty($offer_details['UserOffer'])){
                $offer_details['UserOffer']['offer'] = $offer;
                $this->Session->write('thankyou',$offer_details);
                $this->redirect('/thankyou/'.$offer);
            }
            else{
                $this->Session->setFlash(__('Your account has been activated.'), 'flash');
                $this->redirect('/');
            }
            //echo '<pre>';print_r($user);die;
        }
        else{
            $this->Session->setFlash(__('Your account is already active.'), 'flash');
            $this->redirect('/');
        }
    }

    public function send_activation_email(){    //  account activation email request from popup.
        $this->autoRender = false;
        if($this->request->is('ajax')) {
            $results = json_decode($_POST['data'], true);
            if(!empty($results)){
                $this->confirmation_email($results);
                echo '1';
            }
            else{
                '0';
            }
        }
        die;
    }


}

