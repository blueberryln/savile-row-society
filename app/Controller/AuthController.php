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

		if ($this->request->is('post'))
		{

            $data = $this->request->data;
            $data['UserPreference']['style_pref'] = implode(',', $data['UserPreference']['style_pref']); 
			$this->User->create();
			if($res = $this->User->saveAll($data)){
				$user = $this->User->findByEmail($data['User']['email']);
				$stylist_id = $this->assign_refer_stylist($user['User']['id']);

			    $this->redirect(array('action'=>'message'));
			}
			else{
				
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





    public function requestinvite() {
        $title_for_layout = 'Request Invitation';
        if ($this->request->is('post')) {
            print_r($this->request->data);exit;
             $toemail = $this->request->data['email'];
                    if ($toemail) {
                        //$email = new CakeEmail(array('log' => true));
                        $email = new CakeEmail('default');
                        $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                        $email->to($toemail);
                        $email->subject('Welcome to Savile Row Society!');
                        $email->template('requestinvite');
                        $email->emailFormat('html');
                        $email->viewVars(compact($toemail));

                            if ($email->send()) {
                                $this->Session->setFlash(__('requestinvite  are sent'), 'flash', array( 'title' => 'Check your E-mail!'));
                                $this->redirect('/');
                            } else {
                                $this->Session->setFlash(__('We cannot send requestinvite  at the moment'), 'flash');
                            }
                    } else {
                        $this->Session->setFlash(__('We cannot send requestinvite  at the moment'), 'flash');
                    }
                }

            $this->set(compact('title_for_layout'));
        }




	 
//End Auth Controller	 
 }