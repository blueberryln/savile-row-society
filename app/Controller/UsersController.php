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
                    $this->redirect($this->referer());
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
     * admin_assignstylist method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    

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
            $this->Session->setFlash(__('User deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
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
    public function admin_highlightedstylist(){
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
        $this->set(compact('stylists'));
        $this->Paginator->settings = array(
                'fields' => array('User.*,Userhighlighted.*'),
                'joins' => array(

                array(
                    'conditions' => array(
                        'User.is_stylist' => true,
                        'Userhighlighted.user_id = User.id',
                    ),
                    'table' => 'userhighlighteds',
                    'alias' => 'Userhighlighted',
                    'type' => 'INNER',
                ),
                ),
                'limit'=> 20,
                );
        $Userhighlight= $this->paginate();
        //print_r($Userhigh);
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

