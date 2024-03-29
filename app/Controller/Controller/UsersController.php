<?php

App::uses('AppController', 'Controller');
App::uses('Security', 'Utility');
App::uses('CakeEmail', 'Network/Email');

/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

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
            
            
            //$login_allowed_list = array(
//                'admin@savilerowsociety.com',
//                'ds3167@columbia.edu',
//                'lisa@savilerowsociety.com',
//                'andrea@savilerowsociety.com',
//                'deborah@savilerowsociety.com',
//                'vincent@savilerowsociety.com',
//                'saurabh@mobikasa.com',
//                'prateek@mobikasa.com',
//                'ankit@mobikasa.com',
//                'vaibhav@mobikasa.com',
//                'rajeev@mobikasa.com',
//                'GOLDEN@CRACKERJACKANDHOUSE.COM'
//            );
//            if(!in_array($this->request->data['User']['email'], $login_allowed_list)){
//                $this->request->data = null;
//                $this->Session->setFlash(__('Thank you for visiting Savile Row Society. User login has been disabled as we are hard at work getting ready for our October launch.'), 'flash');
//                $this->redirect('/');
//                exit();
//            }
            
            
            // Remove 'required' rule from password
            $this->User->validator()->remove('email', 'unique');
            if ($this->User->validates(array('fieldList' => array('email', 'password')))) {
                
                // check submitted email and password 
                $results = $this->User->checkCredentials($this->request->data['User']['email'], Security::hash($this->request->data['User']['password']));
                if ($results) {
                    // set "user" session
                    $this->Session->write('user', $results);

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
                    $this->redirect('/');
                    exit();
                } else {
                    // login data is wrong, redirect to login page
                    $this->request->data = null;
                    $this->Session->setFlash(__('Wrong credentials! Please, try again.'), 'flash');
                    $this->redirect('/home');
                    exit();
                }
            }
            else{
                $this->request->data = null;
                $this->Session->setFlash(__('Wrong credentials! Please, try again.'), 'flash');
                $this->redirect('/');
                exit;
            }
        }
        else if ($this->request->is('ajax')){
            
        }
        else{
            $this->redirect('/');
            exit;
        }

        $this->set(compact('title_for_layout'));
    }

    /*
     * save style page profile, and open register-size page
     * */

    public function saveStyle() {
        // get edditing in user
        $user = $this->getEditingUser();
        // extract preferences
        $preferences = NULL;
        if ($user && $user['User']['preferences']) {
            $preferences = unserialize($user['User']['preferences']);
        }
        // get data from request
        $data = $this->request->data;
        
        // get actual array or string from request
        $data_arr = $data['UserPreference']['Style'];
        $wear_suit = $data['UserPreference']['wear_suit'];
        $preferences["UserPreference"]["Style"] = $data_arr;
        $preferences["UserPreference"]["wear_suit"] = $wear_suit;
        $serialized_preferences = serialize($preferences);
        $user['User']['preferences'] = $serialized_preferences;
        if ($results = $this->User->save($user)) {
            $this->Session->write('user', $results);
            $this->redirect('register/size/' . $user['User']['id']);
        } else {
            // TODO: implement error handling
        }
    }

    /*
     * save size page profile, and open register-brands page
     * */

    public function saveSize() {
        // get edditing in user
        $user = $this->getEditingUser();
        // extract preferences
        $preferences = NULL;
        if ($user && $user['User']['preferences']) {
            $preferences = unserialize($user['User']['preferences']);
        }
        // get data from request
        $data = $this->request->data;
//        print_r($data);
//        exit;
        
        // get actual array or string from request
        $data_arr = $data['UserPreference']['Size'];
        $preferences["UserPreference"]["Size"] = $data_arr;
        $serialized_preferences = serialize($preferences);
        $user['User']['preferences'] = $serialized_preferences;
        if ($results = $this->User->save($user)) {
            $this->Session->write('user', $results);
            $this->redirect('register/brands/' . $user['User']['id']);
        } else {
            // TODO: implement error handling
        }
    }

    /*
     * save size page profile, and open register-brands page
     * */

    public function saveBrands() {
        // get edditing in user
        $user = $this->getEditingUser();
        // extract preferences
        $preferences = NULL;
        if ($user && $user['User']['preferences']) {
            $preferences = unserialize($user['User']['preferences']);
        }
        // get data from request
        $data = $this->request->data;
        // get actual array or string from request
        $data_arr = $data['UserPreference']['Brands'];
        $preferences["UserPreference"]["Brands"] = $data_arr;
        $serialized_preferences = serialize($preferences);
        $user['User']['preferences'] = $serialized_preferences;
        if ($results = $this->User->save($user)) {
            $this->Session->write('user', $results);
            $this->redirect('register/last-step/' . $user['User']['id']);
        } else {
            // TODO: implement error handling
        }
    }

    /*
     * save contacts page profile..
     * */

    public function saveAbout() {
        // get edditing in user
        $user = $this->getEditingUser();
        $user["User"]["phone"] = $this->request->data["User"]["phone"];
        $user["User"]["industry"] = $this->request->data["User"]["industry"];
        $user["User"]["location"] = $this->request->data["User"]["location"];
        $user["User"]["skype"] = $this->request->data["User"]["skype"];

        if ($results = $this->User->save($user)) {
            //Write back updated results to user session            
            $this->Session->write('user', $results);
            $this->redirect('register/style/' . $user['User']['id']);
        } else {
            // TODO: implement error handling
        }
    }

    /*
     * save 
     * */

    public function saveContact() {
        if ($this->request->is('post')) {
            // get edditing in user
            $user = $this->getEditingUser();
            // extract preferences
            $preferences = NULL;
            if ($user && $user['User']['preferences']) {
                $preferences = unserialize($user['User']['preferences']);
            }
            // get data from request
            $data = $this->request->data;
            // get actual array or string from request
            $data_arr = $data['UserPreference']['Contact'];
            $preferences["UserPreference"]["Contact"] = $data_arr;
            $serialized_preferences = serialize($preferences);
            $user['User']['preferences'] = $serialized_preferences;

            // save image
            if($image = $this->saveImage()){
                $user['User']['profile_photo_url'] = $image;
            }

            if ($results = $this->User->save($user)) {
                //Write back updated results to user session
                $this->Session->write('user', $results);
                $this->redirect('register/finish/' . $user['User']['id']);
            } else {
                // TODO: implement error handling
            }
        }
    }

    public function saveImage() {
        $image = null;
        $image_type = '';
        $image_size = '';
        // get edditing in user
        $user = $this->getEditingUser();

        // file upload
        if ($this->request->data['ProfileImage'] && $this->request->data['ProfileImage']['size'] > 0) {

            $allowed = array('image/jpeg', 'image/gif', 'image/png', 'image/x-png', 'image/x-citrix-png', 'image/x-citrix-jpeg', 'image/pjpeg');

            if (!in_array($this->request->data['ProfileImage']['type'], $allowed)) {
                $this->Session->setFlash(__('You have to upload an image.'), 'flash');
            } else if ($this->request->data['ProfileImage']['size'] > 2500000) {
                $this->Session->setFlash(__('Attached image must be up to 500 kb in size.'), 'flash');
            } else {
                $image = $user['User']['email'] . '_' . $this->request->data['ProfileImage']['name'];
                $image_type = $this->request->data['ProfileImage']['type'];
                $image_size = $this->request->data['ProfileImage']['size'];
                $img_path = APP . DS . 'webroot' . DS . 'files' . DS . 'users' . DS . $image;
                move_uploaded_file($this->request->data['ProfileImage']['tmp_name'], $img_path);
                return $image;
            }
        }
    }

    /**
     * Sign up
     */
    public function register($step = null, $user_id = null) {

        $title_for_layout = '';

        // prepare source for "Heard from" combo box 
        $heard_from_options = array(
            '' => 'Please select',
            'Search Engine' => 'Search Engine',
            'Advertisement' => 'Advertisement',
            'Friend' => 'Friend',
            'Facebook' => 'Facebook',
            'Twitter' => 'Twitter',
            'Other' => 'Other'
        );

        $this->set(compact('heard_from_options', 'user_id'));
        $user = null;
        if($user_id){
            $user = $this->User->getByID($user_id);
        }
        else{
            $user = $this->getEditingUser();
        }
        // extract preferences
        $preferences = NULL;
        if ($user && $user['User']['preferences']) {
            $preferences = unserialize($user['User']['preferences']);
        }

        switch ($step) {
            case 'saveStyle':
                $this->saveStyle();
                break;
            case 'saveContact':
                $this->saveContact();
                break;
            case 'saveSize':
                $this->saveSize();
                break;
            case 'saveBrands':
                $this->saveBrands();
                break;
            case 'basic':
                $this->shortRegistration();
                break;
            case 'saveAbout':
                $this->saveAbout();
                break;
            case 'style':
                $style = ($preferences['UserPreference'] && isset($preferences['UserPreference']['Style'])) ? $preferences['UserPreference']['Style'] : "";
                $wear_suit = ($preferences['UserPreference'] && isset($preferences['UserPreference']['wear_suit'])) ? $preferences['UserPreference']['wear_suit'] : "";                                
                // debug($style);   
                $this->set(compact('style', 'wear_suit'));
                // title
                $title_for_layout = 'Sign up';
                $this->render('register-style');
                break;
            case 'size':
                // title
                $title_for_layout = 'Sign up';
                $size = ($preferences['UserPreference']) ? $preferences['UserPreference']['Size'] : null;
                // debug($size);   
                $this->set(compact('size'));
                $this->render('register-size');
                break;
            case 'brands':
                // title
                $title_for_layout = 'Sign up';
                $brands = ($preferences['UserPreference']) ? $preferences['UserPreference']['Brands'] : null;
                // debug($brands);   
                $this->set(compact('brands'));
                $this->render('register-brands');
                break;
            case 'about':
                $full_name = $user['User']['first_name'] . ' ' . $user['User']['last_name'];
                $this->data = $user;
                $this->set(compact('full_name'));
                $this->render('register-about');
                // debug($user);
                break;
            case 'last-step': // not in use

                $title_for_layout = 'Sign up';
                $full_name = $user['User']['first_name'] . ' ' . $user['User']['last_name'];
                $this->set(compact('full_name'));
                $image_url = ($user['User']['profile_photo_url']) ? $this->webroot . 'files/users/' . $user['User']['profile_photo_url'] : "#";
                $contact = ($preferences['UserPreference']) ? $preferences['UserPreference']['Contact'] : null;
                $this->set(compact('contact'));
                $this->set(compact('image_url'));
                $this->render('register-last-step');
                break;

            case 'finish':
                $this->render('register-finish');
                break;
            default:
                // title
                //$title_for_layout = 'Sign up';
                //$this->render('register');
                //$this->Session->write('user_registration_step1', $this->request->data);
                break;
        }
        $this->set(compact('title_for_layout'));
    }

    /*
     * Temporary in use for user registration.
     * Should be replaced with new sign in process
     */

    function shortRegistration() {

        $user = $this->request->data;
        $this->Session->write('completeProfile', true);
        $refer_url = $user['User']['refer_url'];
        if($refer_url != 'http://blog.savilerowsociety.com' && $refer_url != ''){
            $refer_url = "/" . $refer_url;   
        }
        
        unset($user['User']['refer_url']);
        
        if ($this->User->validates()) {

            $this->User->create();
            // hash password
            if (!empty($user['User']['password'])) {
                $user['User']['password'] = Security::hash($user['User']['password']);
            }
            // username (slug)
            $full_name = $user['User']['first_name'] . ' ' . $user['User']['last_name'];
            $user['User']['username'] = strtolower(Inflector::slug($full_name, $replacement = '.'));

            if ($this->User->save($user)) {

                // send welcome mail
                /* uncoment this to deploy code */
                /* $email = new CakeEmail('default');


                  $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                  $email->to($user['User']['email']);
                  $email->subject('Welcome to Savile Row Society!');
                  $email->template('registration');
                  $email->emailFormat('html');
                  $email->viewVars(array('name' => $user['User']['first_name']));
                  $email->send();
                 */
                $this->Session->setFlash(__('Your account is created.'), 'flash', array('title' => 'Hooray!'));
                // signin newly registered user
                // check submitted email and password 
                $results = $this->User->checkCredentials($user['User']['email'], $user['User']['password']);

                if ($results) {
                    // set "user" session
                    $this->Session->write('user', $results);

                    // redirect to done
                    //$this->redirect('/register/done');
                    if($refer_url){
                        $this->redirect($refer_url);
                        exit;
                    }
                    $this->redirect('/home');
                    exit();
                } else {
                    // redirect to home
                    $this->redirect('/home');
                    exit();
                }
            } else {
                $this->Session->setFlash(__('There was a problem. Please, try again.'), 'flash');
                $this->redirect('/home');
            }
        } else {
            $this->Session->setFlash(__('Please, sign in.'), 'flash', array('title' => 'You are already registered!'));
            $this->redirect('/home');
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
        $this->redirect('/');
        exit();
    }

    /**
     * Settings
     */
    public function edit($action = null) {

        // title
        $title_for_layout = 'Edit your account';

        $id = $this->getLoggedUserID();

        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        
        if (($this->request->is('post') || $this->request->is('put')) && $action == "edit") {
            // hash password
            if (!empty($this->request->data['User']['password_new'])) {
                $this->request->data['User']['password'] = Security::hash($this->request->data['User']['password_new']);
            }
            
            unset($this->request->data['User']['email']);

            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('Settings are saved!'), 'flash', array('title' => 'Hey!'));
                $this->redirect('/myprofile');
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
        }

        $heard_from_options = array(
            '' => 'Please select',
            'Search Engine' => 'Search Engine',
            'Advertisement' => 'Advertisement',
            'Friend' => 'Friend',
            'Facebook' => 'Facebook',
            'Twitter' => 'Twitter',
            'Other' => 'Other'
        );
        
        $this->set(compact('title_for_layout', 'heard_from_options'));
        
        if($action == "edit"){
            $this->render('edit');    
        }
        else{
            $this->render('view');
        }
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
                $email->subject('Welcome to Savile Row Society!');
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

                    //$email = new CakeEmail(array('log' => true));
                    $email = new CakeEmail('default');
                    $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                    $email->to($user['User']['email']);
                    $email->subject('Welcome to Savile Row Society!');
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
        } else {
            $this->redirect('/');
            exit();
        }

        $this->set(compact('title_for_layout'));
    }

    public function bckFinish() {
        /*
          $this->Session->delete('user_registration_step5');

          // title
          $title_for_layout = 'Sign up';
          $this->render('register-finish');
          $this->Session->write('user_registration_step5', $this->request->data);

          // get preferences from session
          $user = $this->Session->read('user_registration_step1');
          $step2 = $this->Session->read('user_registration_step2');
          $step3 = $this->Session->read('user_registration_step3');
          $step4 = $this->Session->read('user_registration_step4');
          $step5 = $this->Session->read('user_registration_step5');

          // merge all
          $preferences = Hash::merge($user, $step2, $step3, $step4, $step5);
          $user['User'] = $preferences['User'];
          unset($preferences['User']);

          // serialize for db
          $preferences = serialize($preferences);

          //debug($user);
          //debug($preferences);
          //debug(unserialize($preferences));
          // REGISTER USER HERE!

          $this->User->set($user);
          if ($this->User->validates()) {

          $this->User->create();

          // hash password
          if (!empty($user['User']['password'])) {
          $user['User']['password'] = Security::hash($user['User']['password']);
          }

          // username (slug)
          $full_name = $user['User']['first_name'] . ' ' . $user['User']['last_name'];
          $user['User']['username'] = strtolower(Inflector::slug($full_name, $replacement = '.'));

          // store preferences
          $user['User']['preferences'] = $preferences;

          if ($this->User->save($user)) {

          // send welcome mail
          $email = new CakeEmail('default');
          $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
          $email->to($user['User']['email']);
          $email->subject('Welcome to Savile Row Society!');
          $email->template('registration');
          $email->emailFormat('html');
          $email->viewVars(array('name' => $user['User']['first_name']));
          $email->send();

          //$this->Session->setFlash(__('Your account is created.'), 'modal', array('class' => 'success', 'title' => 'Hooray!'));
          // signin newly registered user
          // check submitted email and password
          $results = $this->User->checkCredentials($user['User']['email'], $user['User']['password']);

          if ($results) {
          // set "user" session
          $this->Session->write('user', $results);

          // redirect to done
          //$this->redirect('/register/done');
          $this->redirect('/stylist');
          exit();
          } else {
          // redirect to home
          $this->redirect('/signin');
          exit();
          }
          } else {
          $this->Session->setFlash(__('There was a problem. Please, try again.'), 'modal', array('class' => 'error', 'title' => 'Houston we have a problem!'));
          $this->redirect('/register');
          }
          } else {
          $this->Session->setFlash(__('Please, sign in.'), 'modal', array('class' => 'error', 'title' => 'You are already registered!'));
          $this->redirect('/signin');
          } */
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {

        $this->layout = 'admin';
        $this->isAdmin();

        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {

        $this->layout = 'admin';
        $this->isAdmin();

        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
        }
        $this->set(compact('id'));
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

        $this->set(compact('users'));
        $this->set('filename', 'SRS_Users_' . date('m.d.Y-H.i'));
        $this->render('admin_export', 'xls');
    }
    
    /**
     * Return logged in user or..
     * if come to reg pages from user administration then return user that was choosen
     */
    function getEditingUser(){
        if(isset($this->request->data['User']) && $this->request->data['User'] && $this->request->data['User']['id']){
            $user_id =  $this->request->data['User']['id'];
            return $this->User->getByID($user_id);
        }
        else{
            return $this->getLoggedUser();
        }
    }

}

