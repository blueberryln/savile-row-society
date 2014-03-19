<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Booking Controller
 *
 * @property Booking $Booking
 */
class BookingController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $user_id = $this->getLoggedUserID();
        if(!$user_id){
            $this->Session->write('showRegisterPopup', true);
        }
        $this->isLogged();

        // init
        $BookingType = ClassRegistry::init('BookingType');

        // get data
        $booking_types = $BookingType->getAll();
        $booked = $this->Booking->getBooked();
        $user = $this->getLoggedUser();

        if ($this->request->is('post')) {
            if (isset($this->request->data['BookingType']['id']) && count($this->request->data['BookingType']['id']) > 0) {
                $this->Booking->create();
                $data = array();
                $data['Booking']['user_id'] = $this->getLoggedUserID();
                $data['Booking']['booking_type_id'] = implode(',', $this->request->data['BookingType']['id']);
                $data['Booking']['date_start'] = strtotime(date('Y-m-d'));
                $data['Booking']['date_end'] = strtotime(date('Y-m-d'));                
                $data['Booking']['comment'] = $this->request->data['Booking']['comment'];

                if ($this->Booking->save($data)) {

                    $data['Booking']['booking_type_id'] = explode(',', $data['Booking']['booking_type_id']);
                    // send personal stylist mail
                    $user = $this->getLoggedUser();
                    $email = new CakeEmail('default');
                    $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                    $email->to('fitting@savilerowsociety.com');
                    //$email->cc('joey@savilerowsociety.com');
                    $email->bcc('admin@savilerowsociety.com');
                    $email->subject('Tailor booking: ' . $user['User']['first_name'] . ' ' . $user['User']['last_name']);
                    $email->template('tailor');
                    $email->emailFormat('html');
                    $email->viewVars(compact('user', 'data'));
                    $email->send();
                    
                    //Send a confirmation
                    $user_email = new CakeEmail('default');
                    $user_email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                    $user_email->to($user['User']['email']);
                    $user_email->subject('Tailor Booking Confirmation');
                    $user_email->template('confirmation_tailor');
                    $user_email->emailFormat('html');
                    $user_email->viewVars(compact('user', 'data'));
                    $user_email->send();

                    $this->Session->setFlash(__('You will get a confirmation e-mail.'), 'flash');
                } else {
                    $this->Session->setFlash(__('There was a problem. Please, try again.'), 'flash');
                }
            } else {
                $this->Session->setFlash(__('Please select a date and appointment type!'), 'flash');
            }
        }

        // send data to view
        $this->set(compact('user', 'booking_types', 'booked'));
    }

}
