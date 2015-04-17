 <?php

App::uses('Controller', 'Controller');

class AppController extends Controller {

    var $components = array('Session');
    
    /**
     * To redirect any https request to http for any request to a controller action other than Closet Controller.
     * @return none
     */
    function beforeFilter() {
        if($this->request->is('ssl')){
            if($this->request->params['controller'] != "payments"){
                $this->redirect('http://' . env('SERVER_NAME') . $this->here);
            }
        }   
    }


    /**
     * Before render:
     * 1. Set logged status.
     * 2. Check and set if stylist has been assigned.
     * 3. Set cart count.
     * 4. Check if user has admin rights.
     * 5. Check if user has stylist rights.
     * 6. Check if register popup needs to be shown.
     * 7. Get message notification.
     * 8. Check if complete style profile popup needs to be shown.
     */
    public function beforeRender() {
        parent::beforeRender();
        
        if($this->Session->check('showRegisterPopup')){
            $showRegisterPopup = 1;
            $this->Session->delete('showRegisterPopup');
            $this->set(compact('showRegisterPopup'));
        }
        else if($this->Session->check('showAffiliatePopup')){
            $showAffiliatePopup = 1;
            $landing_offer = $this->Session->read('landing_offer');
            $landing_text = $this->Session->read('landing_text');
            $this->Session->delete('showAffiliatePopup');
            $this->set(compact('showAffiliatePopup', 'landing_offer', 'landing_text'));
        }

        $has_stylist = false;
        $is_logged = false;
        if ($user = $this->getLoggedUser()) {
            
            $is_logged = true;
            $User = ClassRegistry::init('User');
            $stylist_id = $User->hasStylist($user['User']['id']);
            if($stylist_id['User']['stylist_id']){
                $has_stylist = true;
                
                //Update Session if stylist has been assigned lately
                $user = $User->getById($user['User']['id']);
                $this->Session->write('user', $user);
            }

            // if($this->Session->check('landing_offer')){
            //     $user_offer = $this->Session->read('landing_offer');
            //     $this->Session->delete('landing_offer');
            //     $offer = $user_offer['UserOffer']['offer'];

            //     $offer_details = $this->getOfferDetails($offer);
            //     if($offer_details){
            //         $pixel = $offer_details['login_pixel'];

            //         $this->set(compact('pixel'));
            //     }
            // }
        }
        else{
            if($this->Session->check('referer')){
                $User = ClassRegistry::init('User');
                $referer_id = $this->Session->read('referer'); 
                $referer_type = $this->Session->read('referer_type');
                $referer = $User->findById($referer_id);
                $this->set(compact('referer_type', 'referer'));
            } 
        }

        if($this->Session->check('landing_offer') && $this->Session->check('login_lead')){
            $user_offer = $this->Session->read('landing_offer');
            $this->Session->delete('landing_offer');
            $this->Session->delete('login_lead');
            $offer = $user_offer['UserOffer']['offer'];

            $offer_details = $this->getOfferDetails($offer);
            if($offer_details){
                $pixel = $offer_details['login_pixel'];

                $this->set(compact('pixel'));
            }
        }

        $this->getCartCount();
        $this->checkAdminRights();
        $this->checkStylistRights();
        $message_notification = $this->getMessageNotification();
        if($message_notification){
            $this->set(compact('message_notification'));
        }
        $this->set(compact('is_logged','has_stylist','user'));
        
        /**
         * Set values for profile completion popup
         */
        if($this->Session->check('completeProfile') && $this->Session->read('completeProfile')){
            if($this->params->url == "register/wardrobe"){
                $this->set('profilePopup', array('completeProfile' => true, 'isProfile' => true));
            }
            else{
                $this->set('profilePopup', array('completeProfile' => true));   
            }
            $this->Session->delete('completeProfile');    
        }  
    }


    /**
     * Get Logged User from Session
     * @return values od user session. 
     */
    function getLoggedUser() {
        return $this->Session->read('user');
    }


    /**
     * Get Logged User ID
     * @return User id of the logged user. 
     */
    function getLoggedUserID() {
        // fill $user with session data
        $user = $this->getLoggedUser();
        return $user['User']['id'];
    }


    /**
     * Check if the current user is logged in. 
     */
    function isLogged() {
        // fill $user with session data
        $user = $this->getLoggedUser();

        // If the $user is empty,
        // send user to login page
        if (!$user) {

            if ($this->request->url == 'cart') {
                $this->Session->write('return_url', $this->referer());
            } else {
                $this->Session->write('return_url', Router::url(null, true));
            }

            exit();
        } else {
            $this->Session->delete('return_url');
        }
    }


    /**
     * Check current logged User's
     * Admin premissions
     */
    function checkAdminRights() {

        // fill $user with session data
        $user = $this->getLoggedUser();
        $is_admin = false;

        if ($user['User']['is_admin'] == 1) {
            $is_admin = true;
        } else {
            $is_admin = false;
        }

        $this->set('is_admin', $is_admin);
    }
    

    /**
     * Check current logged User's
     * Stylist premissions
     */
    function checkStylistRights() {

        // fill $user with session data
        $user = $this->getLoggedUser();
        $is_stylist = false;

        if ($user['User']['is_stylist'] == 1) {
            $is_stylist = true;
        } else {
            $is_stylist = false;
        }

        $this->set('is_stylist', $is_stylist);
    }


    /**
     * Check if current user is admin
     */
    function isAdmin() {
        // fill $user with session data
        $user = $this->getLoggedUser();

        // if is_admin is not set to 1, redirect to home.
        if ($user['User']['is_admin'] == 0) {
            $this->redirect('/');
            exit();
        }
    }


    /**
     * Get Cart items count
     */
    function getCartCount() {
        $cart_items_count = 0;
        $user_id = $this->getLoggedUserID();
        if($user_id){
            $Cart = ClassRegistry::init('Cart');
            $cart = $Cart->getExistingUserCart($user_id);
            if($cart){
                $CartItem = ClassRegistry::init('CartItem');
                $cart_id = $cart['Cart']['id'];
                $cart_items_count = $CartItem->getCartItems($cart_id);
            }
            else{
                $cart_items_count = 0;
            }
        }
        else{
            $cart_items_count = 0;

            if($this->Session->check('guest_items')){
                $cart_items = $this->Session->read('guest_items');
                $cart_items_count = (is_array($cart_items)) ? count($cart_items) : 0;
            }
        }
        $this->Session->write('cart_items', $cart_items_count);
        $this->set('cart_items', $cart_items_count);
    }
    
    
    /**
     * Get notification count: total, new messages, new outfits
     */
    function getMessageNotification(){
        $user_id = $this->getLoggedUserID();
        $user = $this->getLoggedUser();
        $Message = ClassRegistry::init('Message');
        $User = ClassRegistry::init('User');
        $message_notification = array();
        if($user_id && $user['User']['is_stylist']){
            $message_notification['total'] = $Message->getTotalNotificationCount($user_id);
            $message_notification['message'] = $Message->getNewMessageCount($user_id);
            $message_notification['outfit'] = $Message->getNewOutfitCount($user_id);
            $message_notification['clients'] = $User->getNewClientsCount($user_id);

            $message_notification['total'] = $message_notification['total'] + $message_notification['clients'];
            return $message_notification;
        }    
        else if($user_id) {
            $message_notification['total'] = $Message->getTotalNotificationCount($user_id);
            $message_notification['message'] = $Message->getNewMessageCount($user_id);
            $message_notification['outfit'] = $Message->getNewOutfitCount($user_id);
            return $message_notification;    
        }
        return false;
    } 


    function getOfferDetails($offer){

        $current_offers = array('giveaway50', 'giveaway100', 'cybermonday', 'holiday-offer', '1218301', '1218310', '1218311', '1218303', '1218302', 'tmi', 'concierge_service', 'tdr', 'ivylife', 'engiestyle', '1218340', '1218370', '1218371', '1218320', '1218304', '1218310','1218399');
        $offer_details = array(
            'giveaway50' => array('discount' => 50, 'minimum' => 250, 'phone' => false, 'email_cnf' => false), 
            'giveaway100' => array('discount' => 100, 'minimum' => 250, 'phone' => false, 'email_cnf' => false), 
            'cybermonday' => array('discount' => 100, 'minimum' => 100, 'phone' => false, 'email_cnf' => false), 
            'holiday-offer' => array('discount' => 100, 'minimum' => 250, 'phone' => false, 'email_cnf' => false),
            '1218301' => array('discount' => 50, 'minimum' => 250, 'phone' => false, 'email_cnf' => true),
            '1218310' => array('discount' => 100, 'minimum' => 250, 'phone' => false, 'email_cnf' => false),
            '1218311' => array('discount' => 50, 'minimum' => 100, 'phone' => false, 'email_cnf' => false),
            '1218303' => array('discount' => 50, 'minimum' => 250, 'phone' => false, 'email_cnf' => false),
            '1218302' => array('discount' => 50, 'minimum' => 250, 'phone' => false, 'email_cnf' => false),
            'tmi' => array('discount' => 15, 'minimum' => 100, 'phone' => false, 'email_cnf' => false),
            'concierge_service' => array('discount' => 15, 'minimum' => 100, 'phone' => false, 'email_cnf' => false),
            'tdr' => array('discount' => 25, 'minimum' => 50, 'phone' => false, 'email_cnf' => false),
            'ivylife' => array('discount' => 25, 'minimum' => 50, 'phone' => false, 'email_cnf' => false),
            'engiestyle' => array('discount' => 100, 'minimum' => 150, 'phone' => false, 'email_cnf' => false),
            '1218340' => array('discount' => 110, 'minimum' => 150, 'phone' => false, 'email_cnf' => false),
            '1218370' => array('discount' => 50, 'minimum' => 100, 'phone' => false, 'email_cnf' => false),
            '1218371' => array('discount' => 50, 'minimum' => 100, 'phone' => false, 'email_cnf' => false),
            '1218320' => array('discount' => 100, 'minimum' => 100, 'phone' => false, 'email_cnf' => false),
            '1218304' => array('discount' => 50, 'minimum' => 250, 'phone' => false, 'email_cnf' => false),
            '1218399' => array('discount' => 50, 'minimum' => 250, 'phone' => true, 'email_cnf' => false)
        ); 
 

        $text = '';
        $login_pixel = '';
        $sale_pixel = '';
        if($offer == 'giveaway50'){
            $text = "<p>Welcome to Savile Row Society.</p>  
                    <p>In addition to Zero Membership Fees,<br>
                    Please enjoy this exclusive offer of<br>
                    $50 Off Your First Order <br>
                    of $250 or More.</p>
                    <p>Welcome to the new you!</p>";
        }
        else if($offer == 'giveaway100'){
            $text = "<p>Welcome to Savile Row Society.</p>  
                    <p>In addition to Zero Membership Fees,<br>
                    Please enjoy this exclusive offer of<br>
                    $100 Off Your First Order <br>
                    of $250 or More.</p>
                    <p>Welcome to the new you!</p>";
        }
        else if($offer == 'cybermonday'){
            $text = "<p>Welcome to Savile Row Society.</p>  
                    <p>In addition to Zero Membership Fees,<br>
                    Please enjoy this exclusive offer of<br>
                    $100 Off Your First Order <br>
                    of $100 or More.</p>
                    <p>Welcome to the new you!</p>";
        }
        else if($offer == 'holiday-offer'){
            $text = "<p>Welcome to Savile Row Society.</p>  
                    <p>Please enjoy this exclusive Holiday offer of<br>
                    $100 Off Your Order<br>
                    of $250 or More.</p>
                    <p>Happy Holidays from all of us at SRS!</p>
                    <p>Welcome to the new you!</p>";
        }
        else if($offer == '1218310'){
            $text = "<p>Welcome to Savile Row Society.</p>  
                    <p>In addition to Zero Membership Fees,<br>
                    Please enjoy this exclusive offer of<br>
                    $100 Off Your First Order <br>
                    of $250 or More.</p>
                    <p>Welcome to the new you!</p>";
        }
        else if($offer == '1218311'){
            $text = "<p>Welcome to Savile Row Society.</p>  
                    <p>In addition to Zero Membership Fees,<br>
                    Please enjoy this exclusive offer of<br>
                    $50 Off Your First Order <br>
                    of $100 or More.</p>
                    <p>Welcome to the new you!</p>";
        }
        else if($offer == '1218301'){
            $text = "<p class='landing_title'>Welcome to Savile Row Society.</p>  
                    <span class='landing_border'></span>
                    <p class='landing_desc'><span class='landing_desc_top'>In addition to Zero Membership Fees</span>,<br>
                    Please enjoy this exclusive offer of<br><span class='landing_desc_emp'>
                    $50 Off Your First Order 
                    of $250 or More.</span></p>";

            $login_pixel = "<script type='text/javascript' src='http://www.mlinktracker.com/third/e2c4x294b4t2v2/" . uniqid() . "'></script>";
            $sale_pixel = "<script type='text/javascript' src='http://www.mlinktracker.com/third/e2c4x294b4t2w2/" . uniqid() . "'></script>";
        }
        else if($offer == '1218302'){
            $text = "<p class='landing_title'>Welcome to Savile Row Society.</p>  
                    <span class='landing_border'></span>
                    <p class='landing_desc'><span class='landing_desc_top'>In addition to Zero Membership Fees</span>,<br>
                    Please enjoy this exclusive offer of<br><span class='landing_desc_emp'>
                    $50 Off Your First Order 
                    of $250 or More.</span></p>";

            $login_pixel = "<iframe src='http://eng.trkcnv.com/pixel?cid=11374&refid=login" . uniqid() . "' width='1' height='1'></iframe>";
            $sale_pixel = "<iframe src='http://eng.trkcnv.com/pixel?cid=11374&refid=TransactionIDHere' width='1' height='1'></iframe>";
        }
        else if($offer == '1218303'){
            $text = "<p class='landing_title'>Welcome to Savile Row Society.</p>  
                    <span class='landing_border'></span>
                    <p class='landing_desc'><span class='landing_desc_top'>In addition to Zero Membership Fees</span>,<br>
                    Please enjoy this exclusive offer of<br><span class='landing_desc_emp'>
                    $50 Off Your First Order 
                    of $250 or More.</span></p>";
        }
        else if($offer == 'tmi'){
            $text = "<p class='landing_title'>Welcome to Savile Row Society.</p>  
                    <span class='landing_border'></span>
                    <p class='landing_desc'>As someone referred by <b>TMI</b> we are glad to have you join us at Savile Row Society, please fill in the information below to get started!</p>";
        }
        else if($offer == 'concierge_service'){
            $text = "<p class='landing_title'>Welcome to Savile Row Society.</p>  
                    <span class='landing_border'></span>
                    <p class='landing_desc'>As someone referred by <b>Joshua Labonte Concierge</b> we are glad to have you join us at Savile Row Society, please fill in the information below to get started!</p>";
        }
        else if($offer == 'tdr'){
            $text = "<p>Welcome to Savile Row Society.</p>  
                    <p>In addition to Zero Membership Fees,<br>
                    Please enjoy this exclusive offer of<br>
                    $25 Off Your First Order <br>
                    of $50 or More.</p>
                    <p>Welcome to the new you!</p>";
        }
        else if($offer == 'ivylife'){
            $text = "<p>Welcome to Savile Row Society.</p>  
                    <p>In addition to Zero Membership Fees,<br>
                    Please enjoy this exclusive offer of<br>
                    $25 Off Your First Order <br>
                    of $50 or More.</p>
                    <p>Welcome to the new you!</p>";
        }
        else if($offer == 'engiestyle'){
            $text = "<p>Welcome to Savile Row Society.</p>  
                    <p>In addition to Zero Membership Fees,<br>
                    Please enjoy this exclusive offer of<br>
                    $100 Off Your First Order <br>
                    of $150 or More.</p>
                    <p>Welcome to the new you!</p>";
        }
        else if($offer == '1218340'){
            $text = "<p>Welcome to Savile Row Society.</p>  
                    <p>In addition to Zero Membership Fees,<br>
                    Please enjoy this exclusive offer of<br>
                    $110 Off Your First Order <br>
                    of $150 or More.</p>
                    <p>Welcome to the new you!</p>";
        }
        else if($offer == '1218370'){
            $text = "<p>Welcome to Savile Row Society</p>  
                    <p>In addition to Zero Membership Fees,<br>
                    Please enjoy this exclusive offer of<br>
                    $50 Off Your First Order <br>
                    of $100 or More.</p>
                    <p>Welcome to the new you!</p>";
        }
        else if($offer == '1218371'){
            $text = "<p>Welcome to Savile Row Society</p>  
                    <p>In addition to Zero Membership Fees,<br>
                    Please enjoy this exclusive offer of<br>
                    $50 Off Your First Order <br>
                    of $100 or More.</p>
                    <p>Welcome to the new you!</p>";
        }
        else if($offer == '1218320'){
            $text = "<p class='landing_title'>Welcome to Savile Row Society</p>  
                    <span class='landing_border'></span>
                    <p class='landing_desc'><span class='landing_desc_top'>In addition to Zero Membership Fees</span>,<br>
                    Please enjoy this exclusive offer of<br><span class='landing_desc_emp'>
                    $100 Off Your First Order 
                    of $100 or More.</span></p>";
        }
        else if($offer == '1218304'){
            $text = "<p class='landing_title'>Welcome to Savile Row Society</p>  
                    <span class='landing_border'></span>
                    <p class='landing_desc'><span class='landing_desc_top'>In addition to Zero Membership Fees</span>,<br>
                    Please enjoy this exclusive offer of<br><span class='landing_desc_emp'>
                    $50 Off Your First Order 
                    of $250 or More.</span></p>";
        }
        else if($offer == '1218399'){
            $text = "<p class='landing_title'>Welcome to Savile Row Society.</p>  
                    <span class='landing_border'></span>
                    <p class='landing_desc'><span class='landing_desc_top'>In addition to Zero Membership Fees</span>,<br>
                    Please enjoy this exclusive offer of<br><span class='landing_desc_emp'>
                    $50 Off Your First Order 
                    of $250 or More.</span></p>";
        }


        if(in_array($offer, $current_offers)){
            $selected_offer = $offer_details[$offer];
            $selected_offer['text'] = $text;
            $selected_offer['login_pixel'] = $login_pixel;
            $selected_offer['sale_pixel'] = $sale_pixel;
            
            return $selected_offer;
        }

        return false;
    }

    // new user registration mail to sales team
    function mailto_sales_team($user = null,$stylist_id = null){
         try{
                $User = ClassRegistry::init('User');
                $stylist = $User->findById($stylist_id);

                $bcc = Configure::read('Email.contact');
                $sales_team = array('Tyler@savilerowsociety.com','Mitch@savilerowsociety.com','Lisa@savilerowsociety.com','matt@savilerowsociety.com',$stylist['User']['email']);
                $email = new CakeEmail('default');
                $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                $email->to($sales_team);
                $email->subject('New User Registration.');
                $email->bcc($bcc);
                $email->template('sales_team');
                $email->emailFormat('html');
                $email->viewVars(array('f_name' => $user['User']['first_name'],'l_name' => $user['User']['last_name'],'stylist_id'=>$stylist_id,'stylist_first_name' => $stylist['User']['first_name'],'stylist_last_name' => $stylist['User']['last_name'], 'e_mail'=>$user['User']['email'],'mobile'=>$user['User']['phone']));
                $email->send();
            }
            catch(Exception $e){

            }
    }


    

    function confirmation_email($results = null){   //  account activation mailer

        $results = $this->User->findById($results['User']['id']);
        if(!$results['User']['active']) {
                try{
                    $bcc = Configure::read('Email.contact');
                    $email = new CakeEmail('default');
                    $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                    $email->to($results['User']['email']);
                    $email->subject('Activate your account.');
                    $email->bcc($bcc);
                    $email->template('confirmation_email');
                    $email->emailFormat('html');
                    $email->viewVars(array('results' => $results));
                    $email->send();
                }
                catch(Exception $e){
                    
                }
        }        
    }


}
