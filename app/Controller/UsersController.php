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
    var $uses = array('User','UserPreference','Style','InvitedUser');

    //Industry options
    public $industry_options = array(
        'Agriculture'=>'Agriculture',
        'Accounting'=>'Accounting',
        'Advertising'=>'Advertising',
        'Aerospace'=>'Aerospace',
        'Aircraft'=>'Aircraft',
        'Airline'=>'Airline',
        'Apparel & Accessories'=>'Apparel & Accessories',
        'Automotive'=>'Automotive',
        'Banking'=>'Banking',
        'Broadcasting'=>'Broadcasting',
        'Brokerage'=>'Brokerage',
        'Biotechnology'=>'Biotechnology',
        'Call Centers'=>'Call Centers',
        'Cargo Handling'=>'Cargo Handling',
        'Chemical'=>'Chemical',
        'Computer'=>'Computer',
        'Consulting'=>'Consulting',
        'Consumer Products'=>'Consumer Products',
        'Cosmetics'=>'Cosmetics',
        'Defense'=>'Defense',
        'Department Stores'=>'Department Stores',
        'Education'=>'Education',
        'Electronics'=>'Electronics',
        'Energy'=>'Energy',
        'Entertainment & Leisure'=>'Entertainment & Leisure',
        'Executive Search'=>'Executive Search',
        'Financial Services'=>'Financial Services',
        'Food, Beverage & Tobacco'=>'Food, Beverage & Tobacco',
        'Grocery'=>'Grocery',
        'Health Care'=>'Health Care',
        'Internet Publishing'=>'Internet Publishing',
        'Investment Banking'=>'Investment Banking',
        'Legal'=>'Legal',
        'Manufacturing'=>'Manufacturing',
        'Motion Picture & Video'=>'Motion Picture & Video',
        'Music'=>'Music',
        'Newspaper Publishers'=>'Newspaper Publishers',
        'Online Auctions'=>'Online Auctions',
        'Pension Funds'=>'Pension Funds',
        'Pharmaceuticals'=>'Pharmaceuticals',
        'Private Equity'=>'Private Equity',
        'Publishing'=>'Publishing',
        'Real Estate'=>'Real Estate',
        'Retail & Wholesale'=>'Retail & Wholesale',
        'Securities & Commodity Exchanges'=>'Securities & Commodity Exchanges',
        'Service'=>'Service',
        'Soap & Detergent'=>'Soap & Detergent',
        'Software'=>'Software',
        'Sports'=>'Sports',
        'Technology'=>'Technology',
        'Telecommunications'=>'Telecommunications',
        'Television'=>'Television',
        'Transportation'=>'Transportation',
        'Venture Capital'=>'Venture Capital',
    );

    public function savefbimage(){
        Configure::write('debug', 2);
        $fullpath = APP . DS . 'webroot' . DS . 'files' . DS . 'users' . DS . "saurabh.jpg";

        $my_img = "https://fbcdn-profile-a.akamaihd.net/hprofile-ak-frc1/t1.0-1/c25.0.81.81/s80x80/252231_1002029915278_1941483569_s.jpg";

        $ch = curl_init ($my_img);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
        $rawdata=curl_exec($ch);
        curl_close ($ch);
        if(file_exists($fullpath)){
            unlink($fullpath);
        }
        $fp = fopen($fullpath,'x');
        fwrite($fp, $rawdata);
        fclose($fp);

        exit;
    }

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
                $email->cc(array('contactus@savilerowsociety.com' => 'Savile Row Society'));
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
     * save contacts page profile..
     * */

    public function saveAbout() {
        // get edditing in user
        $user = $this->getEditingUser();
        $id = $this->getLoggedUserID();
        
        $user["User"]["industry"] = $this->request->data["User"]["industry"];
        $user["User"]["zip"] = $this->request->data["User"]["zip"];
        if(checkdate($this->request->data["User"]["month"],$this->request->data["User"]["day"], $this->request->data["User"]["year"])){
            $user["User"]["birthdate"] = date('Y-m-d', strtotime($this->request->data["User"]["year"] . "-" . $this->request->data["User"]["month"] . "-" . $this->request->data["User"]["day"]));
        }

        if ($this->User->save($user)) {
            $result = $this->User->getByID($id);
            $this->Session->write('user', $result); 
            $this->redirect('register/brands/' . $user['User']['id']);
        } else {
            // TODO: implement error handling
        }
    }

    /*
     * save style page profile, and open register-size page
     * */

    public function saveWardrobe() {
        // get edditing in user
        $user = $this->getEditingUser();
        $id = $this->getLoggedUserID();
        // extract preferences
        $preferences = NULL;
        if ($user && $user['User']['preferences']) {
            $preferences = unserialize($user['User']['preferences']);
        }
        // get data from request
        $data = $this->request->data;
        if(isset($data['UserPreference']['Style']) || isset($data['UserPreference']['made_to_measure'])){
            if(isset($data['UserPreference']['Style'])){
                $data_arr = $data['UserPreference']['Style'];  
                $preferences["UserPreference"]["Style"] = $data_arr;  
            }
            if(isset($data['UserPreference']['made_to_measure'])){
                $made_to_mesaure = $data['UserPreference']['made_to_measure'];
                $preferences["UserPreference"]["made_to_measure"] = $made_to_mesaure;        
            }
            
            $serialized_preferences = serialize($preferences);
            $user['User']['preferences'] = $serialized_preferences;
            if ($this->User->save($user)) {
                $result = $this->User->getByID($id);
                $this->Session->write('user', $result); 
            } else {
                // TODO: implement error handling
            }
            
        }
        $this->redirect('register/style/' . $user['User']['id']);
    }

    /*
     * save style page profile, and open register-size page
     * */

    public function saveStyle() {
        // get edditing in user
        $user = $this->getEditingUser();
        $id = $this->getLoggedUserID();
        // extract preferences
        $preferences = NULL;
        if ($user && $user['User']['preferences']) {
            $preferences = unserialize($user['User']['preferences']);
        }
        // get data from request
        $data = $this->request->data;

        if(isset($data['UserPreference']['StyleSize'])){
            $data_arr = $data['UserPreference']['StyleSize'];
            $preferences["UserPreference"]["StyleSize"] = $data_arr;
            $serialized_preferences = serialize($preferences);
            $user['User']['preferences'] = $serialized_preferences;
        }

        // save image
        if($image = $this->saveImage()){
            $user['User']['profile_photo_url'] = $image;
        }
        
        if ($this->User->save($user)) {
            $result = $this->User->getByID($id);
            $this->Session->write('user', $result);
            $this->redirect('register/size/' . $user['User']['id']);
        } 
    }

    /*
     * save size page profile, and open register-brands page
     * */

    public function saveSize() {
        // get edditing in user
        $user = $this->getEditingUser();
        $id = $this->getLoggedUserID();
        // extract preferences
        $preferences = NULL;
        if ($user && $user['User']['preferences']) {
            $preferences = unserialize($user['User']['preferences']);
        }
        // get data from request
        $data = $this->request->data;
        
        // get actual array or string from request
        $data_arr = $data['UserPreference']['Size'];
        $preferences["UserPreference"]["Size"] = $data_arr;
        $serialized_preferences = serialize($preferences);
        $user['User']['preferences'] = $serialized_preferences;
        if ($this->User->save($user)) {
            $result = $this->User->getByID($id);
            $this->Session->write('user', $result); 
            $this->redirect('/profile/about/' . $user['User']['id']);
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
        $id = $this->getLoggedUserID();
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
        if ($this->User->save($user)) {
            $result = $this->User->getByID($id);
            $this->Session->write('user', $result); 
            $this->redirect('register/last-step/' . $user['User']['id']);
        } else {
            // TODO: implement error handling
        }
    }

    
    
    
    
    /*
     * Save and send immidiate user request to SRS admin
     * */
    public function saveFinish() {
        // get edditing in user
        $user = $this->getEditingUser();
        $msg = $this->request->data;
        if($msg['Message']['body'] != ""){
            $msg['Message']['user_from_id'] = $user['User']['id'];
            $admin_user = $this->User->getAdminUser();
            $msg['Message']['user_to_id'] = $admin_user['User']['id'];
            
            $Message = ClassRegistry::init('Message');
            $Message->create();
            $Message->save($msg);
        }
        $this->Session->setFlash(__('Your request has been sent to our team.'), 'flash');
        $this->redirect('/closet');
    }



    /*
     * save 
     * */

    public function saveContact() {
        if ($this->request->is('post')) {
            // get edditing in user
            $user = $this->getEditingUser();
            $id = $this->getLoggedUserID();
            // extract preferences
            $preferences = NULL;
            if ($user && $user['User']['preferences']) {
                $preferences = unserialize($user['User']['preferences']);
            }
            // get data from request
            $data = $this->request->data;

            $user['User']['phone'] = $data['User']['phone'];
            $user['User']['skype'] = $data['User']['skype'];

            // get actual array or string from request
            $data_arr = $data['UserPreference']['Contact'];
            $preferences["UserPreference"]["Contact"] = $data_arr;
            $preferences['UserPreference']['is_complete'] = 1;
            $serialized_preferences = serialize($preferences);
            $user['User']['preferences'] = $serialized_preferences;
            
            if ($this->User->save($user)) {
                $result = $this->User->getByID($id);

                //Assign Stylist
                if(!$result['User']['stylist_id']){
                    $stylist_id = $this->assign_refer_stylist($id);

                    App::import('Controller', 'Messages');
                    $Messages = new MessagesController;
                    $Messages->send_welcome_message($id, $stylist_id);
                }

                $this->Session->write('user', $result);

                $this->redirect('/messages');
            } 
        }
    }

    public function saveImage() {
        $image = null;
        $image_type = '';
        $image_size = '';
        // get edditing in user
        $user = $this->getEditingUser();
        $id = $this->getLoggedUserID();

        // file upload
        if ($this->request->data['User']['ProfileImage'] && $this->request->data['User']['ProfileImage']['size'] > 0) {

            $allowed = array('image/jpeg', 'image/gif', 'image/png', 'image/x-png', 'image/x-citrix-png', 'image/x-citrix-jpeg', 'image/pjpeg');

            if (!in_array($this->request->data['User']['ProfileImage']['type'], $allowed)) {
                $this->Session->setFlash(__('You have to upload an image.'), 'flash');
            } else if ($this->request->data['User']['ProfileImage']['size'] > 5242880) {
                $this->Session->setFlash(__('Attached image must be up to 5 MB in size.'), 'flash');
                $this->redirect('register/style/' . $id);
                exit;
            } else {
                $image = $user['User']['email'] . '_' . $this->request->data['User']['ProfileImage']['name'];
                $image_type = $this->request->data['User']['ProfileImage']['type'];
                $image_size = $this->request->data['User']['ProfileImage']['size'];
                $img_path = APP . DS . 'webroot' . DS . 'files' . DS . 'users' . DS . $image;
                move_uploaded_file($this->request->data['User']['ProfileImage']['tmp_name'], $img_path);
                return $image;
            }
        }
    }

    /**
     * Sign up
     */
    public function register($step = null, $user_id = null) {
        $this->redirect('/');
        exit;

        $this->set(compact('user_id'));
        $user = null;
        $register_cases = array('saveStyle', 'saveContact', 'saveSize', 'saveBrands', 'saveAbout', 'style', 'size', 'brands', 'about', 'last-step', 'wardrobe', 'saveWardrobe');
        if(in_array($step, $register_cases)){
            if($user_id){
                $user = $this->getEditingUser($user_id);
            }
            else{
                $user = $this->getEditingUser();
            }
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
            case 'saveWardrobe':
                $this->saveWardrobe();
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
            case 'saveFinish':
                $this->saveFinish();
                break;
            case 'wardrobe':
                $style = ($preferences['UserPreference'] && isset($preferences['UserPreference']['Style'])) ? $preferences['UserPreference']['Style'] : "";  
                $made_to_measure = ($preferences['UserPreference'] && isset($preferences['UserPreference']['made_to_measure'])) ? $preferences['UserPreference']['made_to_measure'] : "";                             
                // debug($style);   
                $this->set(compact('style', 'made_to_measure'));
                // title
                $title_for_layout = 'Sign up';
                $this->render('register-wardrobe');
                break;
            case 'style':
                $full_name = $user['User']['first_name'] . ' ' . $user['User']['last_name'];
                $image_url = ($user['User']['profile_photo_url']) ? $this->webroot . 'files/users/' . $user['User']['profile_photo_url'] : $this->webroot . "img/dummy_image.jpg";                             
                $size = ($preferences['UserPreference'] && isset($preferences['UserPreference']['StyleSize'])) ? $preferences['UserPreference']['StyleSize'] : null; 
                $this->set(compact('size'));
                $this->set(compact('image_url', 'full_name'));
                // title
                $title_for_layout = 'Sign up';
                $this->render('register-style');
                break;
            case 'size':
                // title
                $title_for_layout = 'Sign up';         
                $size = ($preferences['UserPreference'] && isset($preferences['UserPreference']['Size'])) ? $preferences['UserPreference']['Size'] : null; 
                // debug($size);   
                $this->set(compact('size'));
                $this->render('register-size');
                break;
            case 'brands':
                // title
                $title_for_layout = 'Sign up';
                $brands = ($preferences['UserPreference'] && isset($preferences['UserPreference']['Brands'])) ? $preferences['UserPreference']['Brands'] : null;
                // debug($brands);   
                $this->set(compact('brands'));
                $this->render('register-brands');
                break;
            case 'about':
                $full_name = $user['User']['first_name'] . ' ' . $user['User']['last_name'];
                if($user['User']['birthdate']){
                    $user['User']['day'] = date('d', strtotime($user['User']['birthdate']));
                    $user['User']['month'] = date('m', strtotime($user['User']['birthdate']));
                    $user['User']['year'] = date('Y', strtotime($user['User']['birthdate']));
                }
                $this->data = $user;
                $industry = $this->industry_options;
                $this->set(compact('full_name','industry'));
                $this->render('register-about');
                // debug($user);
                break;
            case 'last-step': // not in use
                $title_for_layout = 'Sign up';
                $phone = $user['User']['phone'];
                $skype = $user['User']['skype'];
                $full_name = $user['User']['first_name'] . ' ' . $user['User']['last_name'];
                $contact = ($preferences['UserPreference'] && isset($preferences['UserPreference']['Contact'])) ? $preferences['UserPreference']['Contact'] : null; 
                $this->set(compact('full_name', 'contact', 'user', 'phone', 'skype'));
                
                $this->render('register-last-step');
                break;

            // case 'finish':
            //     $this->isLogged();
            //     $user_id = $this->getLoggedUserID();
            //     $user = $this->User->getByID($user_id);
            //     $this->Session->write('user', $user);
            //     $this->render('register-finish');
            //     break;
            default:
                if($this->Session->check('referer')){
                    $User = ClassRegistry::init('User');
                    $referer_id = $this->Session->read('referer'); 
                    $referer_type = $this->Session->read('referer_type');
                    $referer = $User->findById($referer_id);
                    $this->set(compact('referer_type', 'referer'));
                }    
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
     * Assign VIP dicsount
     */
    public function assignVipDiscount($referer_id){
        $referer = $this->User->findById($referer_id);  
        if(!$referer['User']['vip_discount']){
            $referer['User']['vip_discount_flag'] = 1;
            $this->User->save($referer);    
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
        $this->redirect($this->referer());
        exit();
    }

    /**
     * Settings
     */
    public function edit($action = null) {
        $this->isLogged();
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
                $result = $this->User->getByID($id);
                $this->Session->write('user', $result);
                $this->Session->setFlash(__('Settings are saved!'), 'flash', array('title' => 'Hey!'));
                $this->redirect('/myprofile');
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
        }
        
        $industry = $this->industry_options;
        
        $this->set(compact('title_for_layout', 'heard_from_options','industry'));
        
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

    public function assign_refer_stylist($user_id){
        $user = $this->User->findById($user_id);
        $default_stylist = $this->User->findByEmail("Leslie@srsstylist.com");
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

        $this->User->updateAll(
            array('User.stylist_id' => $user['User']['stylist_id'], 'User.stylist_notification' => 1),
            array('User.id' => $user['User']['id'])
        );
        //$this->User->save($user);

        $stylist_email = $new_stylist['User']['email'];
        $stylist_name = $new_stylist['User']['first_name'];
        
        //Get user data
        $name = $user['User']['first_name'];

        try{
            // $email = new CakeEmail('default');
            // $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
            // $email->to($user['User']['email']);
            // $email->subject('Savile Row Stylist: Your stylist!');
            // $email->template('user_stylist');
            // $email->emailFormat('html');
            // $email->viewVars(compact('name', 'stylist_name'));
            // $email->send();

            $bcc = Configure::read('Email.contact');
            $email = new CakeEmail('default');
            $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
            $email->to($stylist_email);
            $email->bcc($bcc);
            $email->subject('You Have A New Client!');
            $email->template('stylist_notification');
            $email->emailFormat('html');
            $email->viewVars(compact('name', 'stylist_name'));
            $email->send();
        }
        catch(Exception $e){
            
        }

        return $new_stylist['User']['id'];
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
        // $this->Paginator->settings = array(
        //         'fields' => array('User.*'),
        //         'limit' => 20,
        //         'order' => array('User.id' => 'DESC', ),
        //         'join'  => array(
        //             array('table' => 'users_preferences',
        //                 'alias' => 'UserPreference',
        //                 'type' => 'LEFT',
        //                 'conditions' => array(
        //                     'User.id = UserPreference.user_id',
        //                 )
        //             ),
        //         ),
        // );

        $users = $this->Paginator->paginate(); 
        $this->set(compact('stylists','users'));


        $styles = $this->Style->find('all');
         // print_r($styles);exit;
        $this->set('styles', $styles);
    }
    
    /**
     * admin_newusers method
     *
     * @return void
     */
    public function admin_newusers() {
        // Default order: Users to be listed ranked by uresers with uread messages first and date of last message sent.
        $this->layout = 'admin';
        $this->isAdmin();
        $this->Paginator->settings = array(
                'fields' => array('User.*'),
                'limit' => 20,
                'conditions' => array(
                    'OR' => array('User.stylist_id IS NULL', 'User.stylist_id' => '')
                ),
                'order' => array('User.created' => 'desc'),
        );
        
        $this->set('users', $this->Paginator->paginate());
    }
    

    //stylist tab start

    // public function admin_stylist(){
    // 	$this->layout = 'admin';
    // 	$this->isAdmin();
    // 	$this->Paginator->settings = array(
    // 		'fields' => array('User.*') ,
    // 		'limit'  => 20,
    // 		'conditions' => array('User.is_stylist' => '1'),
    // 		'order' => array('User.created' => 'desc'), 
    // 	);
    // 	$this->set('ustylist', $this->Paginator->paginate());
    // }


    //stylist tab end







     /**
     * admin_assignstylist method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_assign_stylist($id = null) {
        $this->layout = 'admin';
        $this->isAdmin();

        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if($this->request->data['User']['stylist_id'] == ""){
                unset($this->request->data['User']['stylist_id']);
            }
            else{
                $this->request->data['User']['stylist_notification'] = 1;
            }
            if ($this->User->save($this->request->data)) {
                if(isset($this->request->data['User']['stylist_id']) && $this->request->data['User']['stylist_id'] > 0){
                    //Get stylist data
                    $options = array('conditions' => array('User.' . $this->User->primaryKey =>$this->request->data['User']['stylist_id']));
                    $stylist_data = $this->User->find('first', $options);
                    $stylist_email = $stylist_data['User']['email'];
                    $stylist_name = $stylist_data['User']['first_name'];
                    
                    //Get user data
                    $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
                    $user_data = $this->User->find('first', $options);  
                    $name = $user_data['User']['first_name'];
                    
                    try{

                        $bcc = Configure::read('Email.contact');
                        $email = new CakeEmail('default');
                        $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                        $email->to($stylist_email);
                        $email->bcc($bcc);
                        $email->subject('You Have A New Client!');
                        $email->template('stylist_notification');
                        $email->emailFormat('html');
                        $email->viewVars(compact('name', 'stylist_name'));
                        $email->send();
                    }
                    catch(Exception $e){
                        
                    }
                }
                $this->Session->setFlash(__('Stylist assigned successfully.'), 'flash');
                $this->redirect(array('action' => 'newusers'));
                
            } else {
                $this->Session->setFlash(__('Stylist could not be assigned. Please, try again.'), 'flash');
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
        }
        $stylists = $this->User->find('list', array('conditions'=>array('is_stylist' => true,)));
        
        $this->set(compact('id', 'stylists'));
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

}

