<?php

App::uses('AppController', 'Controller');
App::uses('Security', 'Utility');
App::uses('CakeEmail', 'Network/Email');

/**
 * Auth Controller
 *
 * @property Auth $Auth
 */
 
 class AuthController extends AppController
 {
	 
	 public $components = array('Paginator');
     public $helpers = array('Paginator');
	 var $uses = array('User','UserPreference','Style');
   
   
   //function register start
	public function register()

	{
        if($this->getLoggedUserID() || !$this->Session->check('referer')){
            $this->redirect('/');
            exit();   
        }
        else if($this->request->is('post')){
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

                        $this->redirect('/messages/index/');
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
                $img_path = APP . DS . 'webroot' . DS . 'files' . DS . 'users' . DS . $image;
                move_uploaded_file($this->request->data['User']['profile_photo_url']['tmp_name'], $img_path);
                return $image;
            }
        }
    }


 }