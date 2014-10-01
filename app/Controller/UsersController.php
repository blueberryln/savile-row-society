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
            //$this->redirect('/');
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
                if ($results) {
                    
                    // set "user" session
                    $this->Session->write('user', $results);
                    
                    // Delete refer sessions
                    if($this->Session->check('referer')){
                        $this->Session->delete('referer');
                        $this->Session->delete('showRegisterPopup'); 
                        $this->Session->delete('referer_type');
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
                } else {
                    // login data is wrong, redirect to login page
                    $this->request->data = null;
                    $this->Session->setFlash(__('Wrong credentials! Please, try again.'), 'flash');
                    $this->redirect($this->referer());
                    exit();
                }
            }
            else{
                $this->request->data = null;
                $this->Session->setFlash(__('Wrong credentials! Please, try again.'), 'flash');
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
        
        if($this->getLoggedUserID()){
            $this->redirect('/');
            exit();   
        }

        else
         if($this->request->is('post') ){
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

                if($user['User']['is_phone']==true){
                   $user['User']['is_phone']='1'; 
                }
                if($user['User']['is_skype']==true){
                   $user['User']['is_skype']='1'; 
                }else{
                    $user['User']['is_skype']='0'; 
                }
                if($user['User']['is_srs_msg']==true){
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
                        $stylist_id = $this->assign_refer_stylist($results['User']['id']);
                        App::import('Controller', 'Messages');
                        $Messages = new MessagesController;
                        $Messages->send_welcome_message($results['User']['id'], $stylist_id);

                        // set "user" session
                        $this->Session->write('user', $results);

                        if($results['User']['vip_discount_flag'] && $results['User']['referred_by']){
                            $this->assignVipDiscount($results['User']['referred_by']);
                        }

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
        $default_stylist = $this->User->findByEmail("contactus@savilerowsociety.com");
        $new_stylist = array();
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
            else if($default_stylist){
                $user['User']['stylist_id'] = $default_stylist['User']['id']; 
                $new_stylist = $default_stylist;   
            }
            else{
                $casey = $this->User->findByEmail("casey@savilerowsociety.com"); 
                if($casey){
                    $user['User']['stylist_id'] = $casey['User']['id']; 
                    $new_stylist = $casey;         
                }   
            }
        }
        else{
            if($default_stylist){
                $user['User']['stylist_id'] = $default_stylist['User']['id']; 
                $new_stylist = $default_stylist;    
            }
            else{
                $casey = $this->User->findByEmail("casey@savilerowsociety.com"); 
                if($casey){
                    $user['User']['stylist_id'] = $casey['User']['id'];  
                    $new_stylist = $casey;   
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
            $this->request->data['UserPreference']['style_pref'] = implode(',', $this->request->data['UserPreference']['style_pref']);
            if($this->User->saveAll($this->request->data))
            {
                $this->Session->setFlash("User Data Hasbeen Saved", 'flash');
                $this->redirect('/messages/profiles/'.$id);
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
    
    public function savePhotostream() {
        $imagename = null;
        $image_type = '';
        $image_size = '';
        // get edditing in user

        // file upload

        if ($this->request->data['Stylistphotostream']['image'] && $this->request->data['Stylistphotostream']['image']['size'] > 0) {

            $allowed = array('image/jpeg', 'image/gif', 'image/png', 'image/x-png', 'image/x-citrix-png', 'image/x-citrix-jpeg', 'image/pjpeg');

            if (!in_array($this->request->data['Stylistphotostream']['image']['type'], $allowed)) {
                $this->Session->setFlash(__('You have to upload an image.'), 'flash');
            } else if ($this->request->data['Stylistphotostream']['image']['size'] > 5242880) {
                $this->Session->setFlash(__('Attached image must be up to 5 MB in size.'), 'flash');
                $this->redirect('Auth/stylistbio/' . $id);
                exit;
            } else {
                $imagename = time() .  '_' . $this->request->data['Stylistphotostream']['image']['name'];
                $image_type = $this->request->data['Stylistphotostream']['image']['type'];
                $image_size = $this->request->data['Stylistphotostream']['image']['size'];
                $img_path = APP . 'webroot' . DS . 'files' . DS . 'photostream' . DS . $imagename;
                move_uploaded_file($this->request->data['Stylistphotostream']['image']['tmp_name'], $img_path);
                return $imagename;
            //print_r($imagename);
            }
        }
    }
     
    public function stylistbio($id= null){
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
        if($this->request->is('post') || $this->request->is('put')){
            $this->request->data['Stylistphotostream']['stylist_id'] = $id;
            $this->request->data['Stylistphotostream']['is_profile'] = '1';
            $this->request->data['Stylistbio']['stylist_id'] = $id;
            $facebookdata = json_encode($this->request->data['Stylistbio']['stylist_social_link']);
            $this->request->data['Stylistbio']['stylist_social_link'] = $facebookdata;
            if($imagename = $this->savePhotostream()){
                    $this->request->data['Stylistphotostream']['image'] = $imagename;
                }
            else{
                    $this->request->data['Stylistphotostream']['image'] = null;    
                }
            if($this->Stylistbio->saveAll($this->request->data))
            {
                $this->Session->setFlash("Stylistbio Data Hasbeen Saved", 'flash');
                $this->redirect('/Auth/stylistbio/'.$id);
            }
            else
            {
                $this->Session->setFlash('The Stylistbio could not be saved. Please, try again.', 'flash');
            }
        }
    }

    public function stylistbiography($id= null){
        $User = ClassRegistry::init('User');
        $Stylistbio = ClassRegistry::init('Stylistbio');
        $StylistTopOutfit = ClassRegistry::init('StylistTopOutfit');
        $Outfit = ClassRegistry::init('Outfit');
        $OutfitItem = ClassRegistry::init('OutfitItem');
        $Entity = ClassRegistry::init('Entity');
        $user = $User->findById($id);
        $user_profile_photo = $user['User']['profile_photo_url'];
        $user_first_name = $user['User']['first_name'];
        $user_last_name = $user['User']['last_name'];    
        
        //get stylist list

        $stylistlist = $User->find('all',array('conditions'=>array('User.is_stylist'=>true,),'fields'=>array('User.first_name,User.last_name,User.id,User.profile_photo_url')));


        //check data outfit start
        
        
        $my_outfit = array();
        $stylistoutfit= $StylistTopOutfit->find('all', array('conditions'=>array('StylistTopOutfit.stylist_id'=>$id,),'order'=>'StylistTopOutfit.order_id  asc',));
        foreach($stylistoutfit as $row){
            $stylist_outfit_id = $row['StylistTopOutfit']['outfit_id'];
            $outfitnames = $Outfit->find('first', array('conditions'=> array('Outfit.id'=>$stylist_outfit_id)));
            $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $stylist_outfit_id)));
            $entities = array();
            foreach($outfit as $value){
                    $entities[] = $value['OutfitItem']['product_entity_id'];
                }
            $entity_list = $Entity->getMultipleById($entities);
            $my_outfit[] =  array(
                                'outfit'    => $outfitnames,
                                //'username' => $userlist,
                                'entities'  => $entity_list
                            );
        }
        $Stylistphotostream = ClassRegistry::init('Stylistphotostream');
        $stylistphoto = $Stylistphotostream->find('all',
            array(
            'conditions'=>array(
            'Stylistphotostream.stylist_id'=>$id,
            ),
             'fields'=>array('Stylistphotostream.image,Stylistphotostream.caption'),
            ));

        //check data outfit end

        $find_array = $Stylistbio->find('all',array(
            'joins' => array(
                    array(
                        'table'=>'users',
                        'alias'=>'User',
                        'type'=>'inner',
                        'conditions'=>array(
                            'User.id = Stylistbio.stylist_id',
                            'User.id' => $id,
                            ),
                    ),
                ),
            'fields' => array('Stylistbio.*,User.*'),
            ));
            
            
        $title_for_layout = 'Meet The Savile Row Society Stylists'; 
        $this->set(compact('find_array','my_outfit','stylistlist','stylistphoto','user_profile_photo','user_first_name','user_last_name', 'title_for_layout'));
    }

    

    public function editbiography($id = null) {
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
        $User = ClassRegistry::init('User');
        $Stylistbio = ClassRegistry::init('Stylistbio');
        $Stylistphotostream = ClassRegistry::init('Stylistphotostream');
        $Outfit = ClassRegistry::init('Outfit');
        $StylistTopOutfit = ClassRegistry::init('StylistTopOutfit');
        $OutfitItem = ClassRegistry::init('OutfitItem');
        $Entity = ClassRegistry::init('Entity');
        $find_array = $Stylistbio->find('all',array(
            'joins' => array(
                    array(
                        'table'=>'stylistphotostreams',
                        'alias'=>'Stylistphotostream',
                        'type'=>'inner',
                        'conditions'=>array(
                            'Stylistbio.id = Stylistphotostream.stylistbio_id',
                            'Stylistphotostream.is_profile'=>true,
                            ),
                    ),
                    array(
                        'table'=>'users',
                        'alias'=>'User',
                        'type'=>'inner',
                        'conditions'=>array(
                            'User.id = Stylistbio.stylist_id',
                            'User.id' => $id,
                            ),
                    ),
                ),
            'fields' => array('Stylistphotostream.*,Stylistbio.*,User.*'),
            ));
            
           
        $stylistphoto = $Stylistphotostream->find('all',
            array(
            'conditions'=>array(
            'Stylistphotostream.stylist_id'=>$id,
            ),
             'fields'=>array('Stylistphotostream.image,Stylistphotostream.caption'),
            ));
        
        $outfits = $Outfit->find('all',array('conditions'=>array('Outfit.stylist_id'=>$id,),'fields'=>'Outfit.outfitname,Outfit.id'));

        $my_outfit = array();
        $stylistoutfit= $StylistTopOutfit->find('all', array('conditions'=>array('StylistTopOutfit.stylist_id'=>$id,)));
        foreach($stylistoutfit as $row){
            $stylist_outfit_id = $row['StylistTopOutfit']['outfit_id'];
            $outfitnames = $Outfit->find('first', array('conditions'=> array('Outfit.id'=>$stylist_outfit_id)));
            $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $stylist_outfit_id)));
            $entities = array();
            foreach($outfit as $value){
                    $entities[] = $value['OutfitItem']['product_entity_id'];
                }
            $entity_list = $Entity->getMultipleById($entities);
            $my_outfit[] =  array(
                                'outfit'    => $outfitnames,
                                'entities'  => $entity_list
                            );
        }

        $this->set(compact('find_array','stylistphoto','outfits','my_outfit','stylistoutfit','user'));
    }

    public function updatestylistbiographyfunfect($stylistbioid = null){
        
        $Stylistbio = ClassRegistry::init('Stylistbio');
        if (!$Stylistbio->exists($stylistbioid)) {
            throw new NotFoundException(__('Invalid Userhighlighted'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $stylistbiographyid = $Stylistbio->findById($stylistbioid);
             $id = $stylistbiographyid['Stylistbio']['stylist_id'];
            if ($Stylistbio->save($this->request->data)) {
                $this->Session->setFlash("Stylistbio Data Hasbeen Saved", 'flash');
                $this->redirect('/Auth/editbiography/'.$id);
            } else {
                $this->Session->setFlash(__('The Stylistbio could not be saved. Please, try again.'), 'flash');
            }
        } else {
            $options = array('conditions' => array('Stylistbio.' . $Stylistbio->primaryKey => $stylistbioid));
            $this->request->data = $Stylistbio->find('first', $options);
        }
    }


    public function updatestylistbiographyhometown($stylistbioid = null){
        $Stylistbio = ClassRegistry::init('Stylistbio');
        if (!$Stylistbio->exists($stylistbioid)) {
            throw new NotFoundException(__('Invalid Userhighlighted'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $stylistbiographyid = $Stylistbio->findById($stylistbioid);
            $id = $stylistbiographyid['Stylistbio']['stylist_id'];
            if ($Stylistbio->save($this->request->data)) {
                $this->Session->setFlash("Stylistbio Data Hasbeen Saved", 'flash');
                $this->redirect('/Auth/editbiography/'.$id);
            } else {
                $this->Session->setFlash(__('The Stylistbio could not be saved. Please, try again.'), 'flash');
            }
        } else {
            $options = array('conditions' => array('Stylistbio.' . $Stylistbio->primaryKey => $stylistbioid));
            $this->request->data = $Stylistbio->find('first', $options);
        }

    }

    public function updatestylistbiographyInspiration($stylistbioid = null){
        $Stylistbio = ClassRegistry::init('Stylistbio');
        if (!$Stylistbio->exists($stylistbioid)) {
            throw new NotFoundException(__('Invalid Userhighlighted'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $stylistbiographyid = $Stylistbio->findById($stylistbioid);
            $id = $stylistbiographyid['Stylistbio']['stylist_id'];

            if ($Stylistbio->save($this->request->data)) {
                $this->Session->setFlash("Stylistbio Data Hasbeen Saved", 'flash');
                $this->redirect('/Auth/editbiography/'.$id);
            } else {
                $this->Session->setFlash(__('The Stylistbio could not be saved. Please, try again.'), 'flash');
            }
        } else {
            $options = array('conditions' => array('Stylistbio.' . $Stylistbio->primaryKey => $stylistbioid));
            $this->request->data = $Stylistbio->find('first', $options);
        }

    }

    public function updateStylistBiographyBio($stylistbioid = null){
        $Stylistbio = ClassRegistry::init('Stylistbio');
        if (!$Stylistbio->exists($stylistbioid)) {
            throw new NotFoundException(__('Invalid Userhighlighted'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $stylistbiographyid = $Stylistbio->findById($stylistbioid);
            $id = $stylistbiographyid['Stylistbio']['stylist_id'];

            if ($Stylistbio->save($this->request->data)) {
                $this->Session->setFlash("Stylistbio Data Hasbeen Saved", 'flash');
                $this->redirect('/Auth/editbiography/'.$id);
            } else {
                $this->Session->setFlash(__('The Stylistbio could not be saved. Please, try again.'), 'flash');
            }
        } else {
            $options = array('conditions' => array('Stylistbio.' . $Stylistbio->primaryKey => $stylistbioid));
            $this->request->data = $Stylistbio->find('first', $options);
        }

    }

    public function updateStylistBiographyFashionTip($stylistbioid = null){
        $Stylistbio = ClassRegistry::init('Stylistbio');
        if (!$Stylistbio->exists($stylistbioid)) {
            throw new NotFoundException(__('Invalid Userhighlighted'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $stylistbiographyid = $Stylistbio->findById($stylistbioid);
            $id = $stylistbiographyid['Stylistbio']['stylist_id'];

            if ($Stylistbio->save($this->request->data)) {
                $this->Session->setFlash("Stylistbio Data Hasbeen Saved", 'flash');
                $this->redirect('/Auth/editbiography/'.$id);
            } else {
                $this->Session->setFlash(__('The Stylistbio could not be saved. Please, try again.'), 'flash');
            }
        } else {
            $options = array('conditions' => array('Stylistbio.' . $Stylistbio->primaryKey => $stylistbioid));
            $this->request->data = $Stylistbio->find('first', $options);
        }

    }

    public function updateStylistBiographyimage($stylistid = null){
        $Stylistphotostream = ClassRegistry::init('Stylistphotostream');
        
        if ($this->request->is('post')) {

            $this->request->data['Stylistphotostream']['stylist_id'] = $stylistid;
            $this->request->data['Stylistphotostream']['is_profile'] = '1';
            $this->request->data['Stylistphotostream']['image'] = $this->request->data['image'];
            $this->request->data['Stylistphotostream']['caption'] = $this->request->data['caption'];
            $this->request->data['Stylistphotostream']['image'];

            $imagename = null;
            $image_type = '';
            $image_size = '';

                $imagename = time() .  '_' . $this->request->data['Stylistphotostream']['image']['name'];
                $image_type = $this->request->data['Stylistphotostream']['image']['type'];
                $image_size = $this->request->data['Stylistphotostream']['image']['size'];
                $img_path = APP . 'webroot' . DS . 'files' . DS . 'photostream' . DS . $imagename;
                move_uploaded_file($this->request->data['Stylistphotostream']['image']['tmp_name'], $img_path);
                $this->request->data['Stylistphotostream']['image'] = $imagename;
                if ($Stylistphotostream->save($this->request->data)) {
                //print_r($Stylistphotostream->save($this->request->data));
                //exit;
                
                $this->Session->setFlash("Stylistphotostream Data Hasbeen Saved", 'flash');
                $this->redirect('/Auth/editbiography/'.$stylistid);
            } else {
                $this->Session->setFlash(__('The Stylistphotostream could not be saved. Please, try again.'), 'flash');
            }
        }else{
                $this->Session->setFlash('The Stylistphotostream could not be saved. Please, try again.', 'flash');
        }
    }

    public function updateStylistBiographyoutfit($stylistid = null){
        $StylistTopOutfit = ClassRegistry::init('StylistTopOutfit');
        $Outfit = ClassRegistry::init('Outfit');
        $OutfitItem = ClassRegistry::init('OutfitItem');
        $Entity = ClassRegistry::init('Entity');    
        
        if ($this->request->is('post') || $this->request->is('put')) {
            $topoutfitdata = $StylistTopOutfit->getStylistOrderOne($stylistid);
            
            if($topoutfitdata != null){
                $id = $topoutfitdata['StylistTopOutfit']['id'];
            }
            $this->request->data['StylistTopOutfit']['stylist_id'] = $stylistid;
            $this->request->data['StylistTopOutfit']['outfit_id'] = $this->request->data['outfit_id'];
            $this->request->data['StylistTopOutfit']['id'] = $this->request->data['id'];
            $this->request->data['StylistTopOutfit']['order_id'] = $this->request->data['order_id'];
            if ($StylistTopOutfit->save($this->request->data)) {

                    $my_outfit = array();
                    $stylistoutfit= $StylistTopOutfit->find('all', array('conditions'=>array('StylistTopOutfit.stylist_id'=>$stylistid,'StylistTopOutfit.order_id'=>1,),'order'=>'StylistTopOutfit.order_id  asc',));
                    foreach($stylistoutfit as $row){
                    $stylist_outfit_id = $row['StylistTopOutfit']['outfit_id'];
                    $outfitnames = $Outfit->find('first', array('conditions'=> array('Outfit.id'=>$stylist_outfit_id)));
                    $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $stylist_outfit_id)));
                    $entities = array();
                    foreach($outfit as $value){
                    $entities[] = $value['OutfitItem']['product_entity_id'];
                    }
                    $entity_list = $Entity->getMultipleById($entities);
                    $my_outfit[] =  array(
                        'outfit'    => $outfitnames,
                        'entities'  => $entity_list
                    );
                    }
                    echo json_encode($my_outfit);

                $this->Session->setFlash("StylistTopOutfit Data Hasbeen Saved", 'flash');
                $this->redirect('/Auth/editbiography/'.$stylistid);
            } else {
                $this->Session->setFlash(__('The Stylistbio could not be saved. Please, try again.'), 'flash');
            }
        } else {
            $options = array('conditions' => array('StylistTopOutfit.' . $StylistTopOutfit->primaryKey => $id));
            $this->request->data = $StylistTopOutfit->find('first', $options);
        }
    }


public function updateStylistBiographyoutfit2($stylistid = null){
        $StylistTopOutfit = ClassRegistry::init('StylistTopOutfit');
        $Outfit = ClassRegistry::init('Outfit');
        $OutfitItem = ClassRegistry::init('OutfitItem');
        $Entity = ClassRegistry::init('Entity');    
        
        if ($this->request->is('post') || $this->request->is('put')) {
            $topoutfitdata = $StylistTopOutfit->getStylistTopOutfittwo($stylistid);
            
            if($topoutfitdata != null){
                $id = $topoutfitdata['StylistTopOutfit']['id'];
            }
            $this->request->data['StylistTopOutfit']['stylist_id'] = $stylistid;
            $this->request->data['StylistTopOutfit']['outfit_id'] = $this->request->data['outfit_id'];
            $this->request->data['StylistTopOutfit']['id'] = $this->request->data['id'];
            $this->request->data['StylistTopOutfit']['order_id'] = $this->request->data['order_id'];
            if ($StylistTopOutfit->save($this->request->data)) {

                    $my_outfit = array();
                    $stylistoutfit= $StylistTopOutfit->find('all', array('conditions'=>array('StylistTopOutfit.stylist_id'=>$stylistid,'StylistTopOutfit.order_id'=>2,),'order'=>'StylistTopOutfit.order_id  asc',));
                    foreach($stylistoutfit as $row){
                    $stylist_outfit_id = $row['StylistTopOutfit']['outfit_id'];
                    $outfitnames = $Outfit->find('first', array('conditions'=> array('Outfit.id'=>$stylist_outfit_id)));
                    $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $stylist_outfit_id)));
                    $entities = array();
                    foreach($outfit as $value){
                    $entities[] = $value['OutfitItem']['product_entity_id'];
                    }
                    $entity_list = $Entity->getMultipleById($entities);
                    $my_outfit[] =  array(
                        'outfit'    => $outfitnames,
                        'entities'  => $entity_list
                    );
                    }
                    echo json_encode($my_outfit);

                $this->Session->setFlash("StylistTopOutfit Data Hasbeen Saved", 'flash');
                $this->redirect('/Auth/editbiography/'.$stylistid);
            } else {
                $this->Session->setFlash(__('The Stylistbio could not be saved. Please, try again.'), 'flash');
            }
        } else {
            $options = array('conditions' => array('StylistTopOutfit.' . $StylistTopOutfit->primaryKey => $id));
            $this->request->data = $StylistTopOutfit->find('first', $options);
        }
    }



    public function updateStylistBiographyoutfit3($stylistid = null){
        $StylistTopOutfit = ClassRegistry::init('StylistTopOutfit');
        $Outfit = ClassRegistry::init('Outfit');
        $OutfitItem = ClassRegistry::init('OutfitItem');
        $Entity = ClassRegistry::init('Entity');    
        
        if ($this->request->is('post') || $this->request->is('put')) {
            $topoutfitdata = $StylistTopOutfit->getStylistOrderTopOutfitthree($stylistid);
            
            if($topoutfitdata != null){
                $id = $topoutfitdata['StylistTopOutfit']['id'];
            }
            $this->request->data['StylistTopOutfit']['stylist_id'] = $stylistid;
            $this->request->data['StylistTopOutfit']['outfit_id'] = $this->request->data['outfit_id'];
            $this->request->data['StylistTopOutfit']['id'] = $this->request->data['id'];
            $this->request->data['StylistTopOutfit']['order_id'] = $this->request->data['order_id'];
            if ($StylistTopOutfit->save($this->request->data)) {

                    $my_outfit = array();
                    $stylistoutfit= $StylistTopOutfit->find('all', array('conditions'=>array('StylistTopOutfit.stylist_id'=>$stylistid,'StylistTopOutfit.order_id'=>3,),'order'=>'StylistTopOutfit.order_id  asc',));
                    foreach($stylistoutfit as $row){
                    $stylist_outfit_id = $row['StylistTopOutfit']['outfit_id'];
                    $outfitnames = $Outfit->find('first', array('conditions'=> array('Outfit.id'=>$stylist_outfit_id)));
                    $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $stylist_outfit_id)));
                    $entities = array();
                    foreach($outfit as $value){
                    $entities[] = $value['OutfitItem']['product_entity_id'];
                    }
                    $entity_list = $Entity->getMultipleById($entities);
                    $my_outfit[] =  array(
                        'outfit'    => $outfitnames,
                        'entities'  => $entity_list
                    );
                    }
                    echo json_encode($my_outfit);

                $this->Session->setFlash("StylistTopOutfit Data Hasbeen Saved", 'flash');
                $this->redirect('/Auth/editbiography/'.$stylistid);
            } else {
                $this->Session->setFlash(__('The Stylistbio could not be saved. Please, try again.'), 'flash');
            }
        } else {
            $options = array('conditions' => array('StylistTopOutfit.' . $StylistTopOutfit->primaryKey => $id));
            $this->request->data = $StylistTopOutfit->find('first', $options);
        }
    }


    
    
    

    //bhashit code shift 









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


}

