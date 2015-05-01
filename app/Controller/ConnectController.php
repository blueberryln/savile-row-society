<?php

App::uses('CakeEmail', 'Network/Email');

class ConnectController extends AppController {

    var $uses = null;

    function beforeFilter() {
        parent::beforeFilter();

        //Configure::write('debug', 0);

        App::uses('Security', 'Utility');

        // Import Social classes
        App::import('Vendor', 'LinkedIn/linkedin');
        App::import('Vendor', 'Facebook/facebook');
        //App::import('Vendor', 'Google/Google_Client');
        //App::import('Vendor', 'Google/contrib/Google_Oauth2Service');
    }


    /**
     * Connect Facebook account 
     */
    public function facebook() {
        Configure::write('debug', 2);
        // delete user session before any login attempt
        $this->Session->delete('user');

        $this->autoRender = false;
        $this->autoLayout = false;

        // get facebook app secret
        $facebook_app_id = Configure::read('Facebook.app_id');
        $facebook_app_secret = Configure::read('Facebook.app_secret');

        //instantiate the Facebook library
        $facebook = new Facebook(array(
            'appId' => $facebook_app_id,
            'secret' => $facebook_app_secret,
            'cookie' => true
        ));


        // init
        $User = ClassRegistry::init('User');

        //Get the FB UID of the currently logged in user
        $facebook_user = $facebook->getUser();

        if ($facebook_user) {

            //get the user's access token and app secret
            $access_token = $facebook->getAccessToken();
            $access_secret = $facebook->getApiSecret();

            try {
                $profile = $facebook->api('/me?fields=id,email,first_name,last_name,username,picture.width(200).height(200)', 'GET', array('access_token' => $access_token));

                // check if user account exists in db
                $account = $User->getByEmail($profile['email']);

                if (!$account) {

                    $fb_data = array();
                    $fb_data['User']['user_type_id'] = 1;
                    $fb_data['User']['email'] = $profile['email'];
                    $fb_data['User']['password'] = Security::generateAuthKey();
                    $fb_data['User']['first_name'] = $profile['first_name'];
                    $fb_data['User']['last_name'] = $profile['last_name'];
                    $fb_data['User']['username'] = strtolower(Inflector::slug($profile['first_name'] . ' ' . $profile['last_name'], $replacement = '.'));
                    $fb_data['User']['profile_image'] = $profile['picture']['data']['url'];
                    $fb_data['User']['social_network'] = 'Facebook';
                    $fb_data['User']['social_network_id'] = $profile['id'];
                    $fb_data['User']['social_network_token'] = $access_token;
                    $fb_data['User']['social_network_secret'] = $access_secret;

                    //save social media image
                    if($fb_data['User']['profile_image'] && $fb_data['User']['email']) {
                        $fb_data['User']['profile_photo_url'] = $this->saveSocialMediaImage($fb_data['User']['profile_image'], $fb_data['User']['email']);
                    }

                    if($this->Session->check('referer')){
                        $fb_data['User']['referred_by'] = $this->Session->read('referer');  
                        $fb_data['User']['vip_discount_flag'] = 1; 
                    } 
                    pr($fb_data);die;
                    /*code to assign stylist */
                    if($this->Session->check('stylist_refer')){
                        $stylist_refer = $this->Session->read('stylist_refer');
                        $refered_stylist = $User->getByID($stylist_refer);

                        if(!$refered_stylist){
                            $stylist_refer = false;
                        }
                    }
                    else{
                        $stylist_refer = false;    
                    }


                    if($fb_data['User']['referred_by']){
                        $referer = $User->getByID($fb_data['User']['referred_by']);
                        if($referer && $referer['User']['is_stylist']){
                            $fb_data['User']['stylist_id'] = $referer['User']['id'];
                        }
                        else if ($referer && $referer['User']['stylist_id'] && $user_stylist = $User->getByID($referer['User']['stylist_id'])){
                            $fb_data['User']['stylist_id'] = $referer['User']['stylist_id'];
                        }
                        else{
                            $stylist = $User->find('first', array('order' => 'rand()', 'conditions' => array('is_stylist' => true,'random_stylist' => true))); 
                            if($stylist){
                                $fb_data['User']['stylist_id'] = $stylist['User']['id']; 
                            }   
                        }
                    }
                    else{
                        if($stylist_refer){
                            $fb_data['User']['stylist_id'] = $refered_stylist['User']['id']; 
                        }
                        else{
                            $stylist = $User->find('first', array('order' => 'rand()', 'conditions' => array('is_stylist' => true,'random_stylist' => true))); 
                            if($stylist){
                                $fb_data['User']['stylist_id'] = $stylist['User']['id']; 
                            }   
                        }    
                    }
                    /*code to assign stylist */
                    
                    $User->create();
                    if ($User->save($fb_data)) {

                        if($this->Session->check('referer')){
                            $this->Session->delete('referer');
                            $this->Session->delete('showRegisterPopup'); 
                            $this->Session->delete('referer_type');
                        }     

                        // set "user" session
                        $fb_data['User']['id'] = $User->getInsertID();
                        $this->Session->write('user', $fb_data);
                       /* App::import('Controller', 'Users');
                        $Users = new UsersController;
                        $stylist_id = $Users->assign_refer_stylist($fb_data['User']['id']);*/
                        App::import('Controller', 'Messages');
                        $Messages = new MessagesController;
                        $Messages->send_welcome_message($fb_data['User']['id'], $stylist_id);
                        $this->mailto_sales_team($fb_data,$stylist_id);    // sends an email to the sales team
                        $this->redirect('/thankyou');
                        exit();
                    } else {
                        $this->Session->setFlash(__('There was a problem. Please, try again.'), 'flash');
                        $this->redirect('/');
                        exit();
                    }
                } else {
                    $account['User']['profile_image'] = $profile['picture']['data']['url'];
                    $account['User']['social_network'] = 'Facebook';
                    $account['User']['social_network_id'] = $profile['id'];
                    $account['User']['social_network_token'] = $access_token;
                    $account['User']['social_network_secret'] = $access_secret;
                    unset($account['User']['updated']);

                    if($this->Session->check('referer')){
                        $this->Session->delete('referer');
                        $this->Session->delete('showRegisterPopup'); 
                        $this->Session->delete('referer_type');
                    } 

                    if ($User->save($account)) {
                        // set "user" session
                        $this->Session->write('user', $account);
                            
                        // redirect to home
                        //$this->Session->setFlash(__('Welcome to SRS!'), 'modal', array('class' => 'success', 'title' => 'Hey!'));
                        //$this->redirect('/register/wardrobe');    
                        $this->redirect('/');  //changed by shubham
                        exit();
                    } else {
                        $this->Session->setFlash(__('There was a problem. Please, try again.'), 'flash');
                        $this->redirect('/');
                        exit();
                    }
                }
            } catch (FacebookApiException $e) {
                error_log($e);
                $facebook_user = null;
            }
        } else {

            $login_url_params = array(
                'scope' => 'email',
                'redirect_uri' => Configure::read('Social.callback_url') . 'connect/facebook',
                'next' => Configure::read('Social.callback_url') . 'connect/facebook'
            );
            $login_url = $facebook->getLoginUrl($login_url_params);

            //redirect to the login URL on facebook
            header("Location: $login_url");
            exit();
        }
    }

    /**
     * Save user profile image from a url
     */
    public function saveSocialMediaImage($url, $email) {
        $image_name = $email . "-usersocial.jpg";
        $img_path = APP . DS . 'webroot' . DS . 'files' . DS . 'users' . DS . $image_name;

        $ch = curl_init ($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
        $rawdata=curl_exec($ch);
        curl_close ($ch);
        if(file_exists($img_path)){
            unlink($img_path);
        }
        $fp = fopen($img_path,'x');
        fwrite($fp, $rawdata);
        fclose($fp);

        return $image_name;
    }

    /**
     * Connect Google (Gmail) account 
     */
//    public function google() {
//        // delete user session before any login attempt
//        $this->Session->delete('user');
//
//        $this->autoRender = false;
//        $this->autoLayout = false;
//
//        $client = new Google_Client();
//        $client->setApplicationName("API Test");
//        $client->setClientId(Configure::read('Google.client_id'));
//        $client->setClientSecret(Configure::read('Google.client_secret'));
//        $client->setRedirectUri(Configure::read('Social.callback_url') . 'connect/google/');
//        $client->setDeveloperKey(Configure::read('Google.developer_key'));
//        $oauth2 = new Google_Oauth2Service($client);
//
//        if (isset($_GET['code'])) {
//            // init
//            $User = ClassRegistry::init('User');
//            $client->authenticate($_GET['code']);
//
//            if ($client->getAccessToken()) {
//
//                $profile = $oauth2->userinfo->get();
//
//                // check if user account exists in db
//                $account = $User->getByEmail($profile['email']);
//
//                if (!$account) {
//
//                    $g_data = array();
//                    $g_data['User']['user_type_id'] = 1;
//                    $g_data['User']['email'] = $profile['email'];
//                    $g_data['User']['password'] = Security::generateAuthKey();
//                    $g_data['User']['first_name'] = $profile['given_name'];
//                    $g_data['User']['last_name'] = $profile['family_name'];
//                    $g_data['User']['username'] = strtolower(Inflector::slug($profile['given_name'] . ' ' . $profile['family_name'], $replacement = '.'));
//                    $g_data['User']['profile_image'] = $profile['picture'];
//                    $g_data['User']['social_network'] = 'Google';
//                    $g_data['User']['social_network_id'] = $profile['id'];
//                    $g_data['User']['social_network_token'] = $client->getAccessToken();
//                    $User->create();
//                    if ($User->save($g_data)) {
//                        // set "user" session
//                        $g_data['User']['id'] = $User->getInsertID();
//                        $this->Session->write('user', $g_data);
//
//                        // send welcome mail
//                        $email = new CakeEmail('default');
//                        $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
//                        $email->to($profile['email']);
//                        $email->subject('Welcome to Savile Row Society!');
//                        $email->template('registration');
//                        $email->emailFormat('html');
//                        $email->viewVars(array('name' => $profile['given_name']));
//                        $email->send();
//
//                        // redirect to home
//                        $this->Session->setFlash(__('Your account is created with your Google data.'), 'modal', array('class' => 'success', 'title' => 'Hooray!'));
//                        $this->redirect('/');
//                        exit();
//                    } else {
//                        $this->Session->setFlash(__('There was a problem. Please, try again.'), 'modal', array('class' => 'error', 'title' => 'Houston we have a problem!'));
//                        $this->redirect('/');
//                        exit();
//                    }
//                } else {
//                    $account['User']['profile_image'] = $profile['picture'];
//                    ;
//                    $account['User']['social_network'] = 'Google';
//                    $account['User']['social_network_id'] = $profile['id'];
//                    $account['User']['social_network_token'] = $client->getAccessToken();
//                    unset($account['User']['updated']);
//
//                    if ($User->save($account)) {
//                        // set "user" session
//                        $this->Session->write('user', $account);
//
//                        // redirect to home
//                        $this->Session->setFlash(__('Welcome to SRS!'), 'modal', array('class' => 'success', 'title' => 'Hey!'));
//                        $this->redirect('/');
//                        exit();
//                    } else {
//                        $this->Session->setFlash(__('There was a problem. Please, try again.'), 'modal', array('class' => 'error', 'title' => 'Houston we have a problem!'));
//                        $this->redirect('/');
//                        exit();
//                    }
//                }
//            }
//        } else {
//            $login_url = $client->createAuthUrl();
//
//            //redirect to the login URL on Google
//            header("Location: $login_url");
//            exit();
//        }
//    }
}

?>