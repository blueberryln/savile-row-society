<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Contacts Controller
 *
 * @property Contact $Contact
 */
class ContactsController extends AppController {
    public function index() {
        $user_id = $this->getLoggedUserID();
        $user = $this->getLoggedUser();
        if($user_id){
            $this->set(compact('user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Contact->validates()) {
                $this->Contact->create();

                if ($this->Contact->save($this->request->data)) {
                    //send personal stylist mail
                    $email = new CakeEmail('default');
                    $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                    $email->to('casey@savilerowsociety.com');
                    $email->cc('contactus@savilerowsociety.com');
                    $email->cc('admin@savilerowsociety.com');
                    $email->subject('Contact Request: ' . $this->request->data['Contact']['first_name'] . ' ' . $this->request->data['Contact']['last_name']);
                    $email->template('stylist');
                    $email->emailFormat('html');
                    $email->viewVars(array('contact' => $this->request->data['Contact']));
                    $email->send();
                    
                    //Send user a confirmation email
                    $user_email = new CakeEmail('default');
                    $user_email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                    $user_email->to($this->request->data['Contact']['email']);
                    $user_email->subject('Savile Row Society: Contact Request Confirmation');
                    $user_email->template('contact_confirmation');
                    $user_email->emailFormat('html');
                    $user_email->viewVars(array('contact' => $this->request->data['Contact']));
                    $user_email->send();

                    $this->Session->setFlash(__('Your message is sent!'), 'flash', array('title' => 'Great!'));
                    $this->redirect('/contact');
                } else {
                    $this->Session->setFlash(__('Please, try again.'), 'flash');
                }
            }
        }

        $this->redirect('/contact');
    }
    
    public function stylist() {
        $this->isLogged();

        if ($this->request->is('post')) {
            if ($this->Contact->validates()) {
                $this->Contact->create();

                if ($this->Contact->save($this->request->data)) {

                    // send personal stylist mail
                    $email = new CakeEmail('default');
                    $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                    $email->to('casey@savilerowsociety.com');
                    $email->cc('contactus@savilerowsociety.com');
                    $email->cc('admin@savilerowsociety.com');
                    $email->subject('Personal stylist: ' . $this->request->data['Contact']['first_name'] . ' ' . $this->request->data['Contact']['last_name']);
                    $email->template('stylist');
                    $email->emailFormat('html');
                    $email->viewVars(array('contact' => $this->request->data['Contact']));
                    $email->send();

                    $this->Session->setFlash(__('Your message is sent!'), 'flash', array('title' => 'Great!'));
                    $this->redirect('/stylist');
                } else {
                    $this->Session->setFlash(__('Please, try again.'), 'flash');
                }
            }
        }

        $this->redirect('/stylist');
    }

//    public function trainer() {
//
//        $this->isLogged();
//
//        if ($this->request->is('post')) {
//
//            if ($this->Contact->validates()) {
//                $this->Contact->create();
//
//                if ($this->Contact->save($this->request->data)) {
//                    // send personal coach mail
//                    $email = new CakeEmail('default');
//                    $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
//                    $email->to('andrew.kalley@gmail.com');
//                    $email->bcc('contactus@savilerowsociety.com');
//                    $email->bcc('admin@savilerowsociety.com');
//                    $email->subject('Trainer: ' . $this->request->data['Contact']['first_name'] . ' ' . $this->request->data['Contact']['last_name']);
//                    $email->template('trainer');
//                    $email->emailFormat('html');
//                    $email->viewVars(array('contact' => $this->request->data['Contact']));
//                    $email->send();
//
//                    $this->Session->setFlash(__('Your message is sent!'), 'modal', array('class' => 'success', 'title' => 'Great!'));
//                    $this->redirect('/trainer');
//                } else {
//                    $this->Session->setFlash(__('Please, try again.'), 'modal', array('class' => 'error', 'title' => 'Houston we have a problem!'));
//                }
//            }
//        }
//
//        $this->redirect('/trainer');
//    }

}
