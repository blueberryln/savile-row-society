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
	 var $uses = array('User','UserPreference','Style','Stylistbio','Stylistphotostream');
   
   
   //function register start
	public function register()

	{
        
        if($this->getLoggedUserID() || !$this->Session->check('referer')){
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
                }
                if($user['User']['is_srs_msg']==true){
                   $user['User']['is_srs_msg']='1'; 
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
                $this->Session->setFlash("User Data Hasbeen Saved");
                $this->redirect('/closet');
            }
            else
            {
                $this->Session->setFlash('The User could not be saved. Please, try again.');
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
     
    public function stylistbioashok(){
        
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
                $this->Session->setFlash("Stylistbio Data Hasbeen Saved");
                $this->redirect('/Auth/stylistbio/'.$id);
            }
            else
            {
                $this->Session->setFlash('The Stylistbio could not be saved. Please, try again.');
            }
        }
    }

    public function stylistbiography($id= null){
        
        $Stylistbio = ClassRegistry::init('Stylistbio');
        $Stylistphotostream = ClassRegistry::init('Stylistphotostream');
        $find_array = $Stylistbio->find('all',array(
            'joins' => array(
                    array(
                        'table'=>'stylistphotostreams',
                        'alias'=>'Stylistphotostream',
                        'type'=>'inner',
                        'conditions'=>array(
                            'Stylistbio.id = Stylistphotostream.stylistbio_id',
                            ),
                        ),
                    ),
            'fields' => array('Stylistphotostream.*,Stylistbio.*'),
            ));
        $find_array2 = $Stylistphotostream->find('all',array(
            'joins'=>array(
                array(
                    'table'=>'users',
                    'alias'=>'User',
                    'type'=>'left',
                    'conditions'=> array(
                        'User.id = Stylistphotostream.stylist_id',
                        'User.is_stylist'=>true,
                        'Stylistphotostream.is_profile'=>true,
                        ),
                    ),

                ),
            'fields'=>array('User.first_name,User.last_name,Stylistphotostream.image,User.id'),
            ));
        print_r($find_array2);
        exit;

    }

 }