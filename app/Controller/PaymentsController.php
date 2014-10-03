<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Closet Controller
 */
class PaymentsController extends AppController {

    public $promoCodes = array('CBS20', 'SRS20', 'JOHNALLANS25', 'LMC20', 'PERKLA20', 'SRSBRANDS20', 'CYBER30', 'JOEYG25', 'FULLTHROTTLE20', 'BLOGGER20', 'SUITES20', 'EQUITY20', 'TIDE25', 'BADWIN25', 'BOBBY25', 'NISH25', 'ROGER25', 'STUART25', 'ALBERT25', 'F&F25', 'ANDREI25');
    public $promoCodesAmount = array('CBS20' => 20, 'SRS20' => 20, 'JOHNALLANS25' => 25, 'LMC20' => 20, 'PERKLA20' => 20, 'SRSBRANDS20' => 20, 'FULLTHROTTLE20' => 20, 'BLOGGER20' => 20, 'SUITES20' => 20, 'CYBER30' => 30, 'JOEYG25' => 25, 'EQUITY20' => 20, 'TIDE25' => 25, 'BADWIN25' => 25, 'BOBBY25' => 25, 'NISH25' => 25, 'ROGER25' => 25, 'STUART25' => 25, 'ALBERT25' => 25, 'F&F25' => 25, 'ANDREI25' => 25);
    public $percentCodes = array('CYBER30', 'JOEYG25');

    function beforeFilter() {
        
        // if (!$this->request->is('ssl')) {
        //     $this->forceSSL();
        // }  
    }


    // public function forceSSL() {
    //     $this->redirect('https://' . $_SERVER['SERVER_NAME'] . $this->here);
    // }
    public function unForceSSL() {
        $this->redirect('http://' . $_SERVER['SERVER_NAME'] . $this->here);
    }
    

    /**
     * Cart
     */
    public function cart() {

        $this->isLogged();
        $user_id = $this->getLoggedUserID();
        if($user_id){
        	//Initialize classes for retrieving the data.
            $Cart = ClassRegistry::init('Cart');
            $CartItem = ClassRegistry::init('CartItem');
            $Entity = ClassRegistry::init('Entity');

            $cart = $Cart->getExistingUserCart($user_id);
            $cart_list = false;
            if($cart){
                $cart_id = $cart['Cart']['id'];

                //Update cart to avoid cart expiration
                unset($cart['Cart']['created']);
                unset($cart['Cart']['updated']);
                $Cart->save($cart);
                
                //Get a list of cart items.
                $cart_list = $CartItem->getByCartId($cart_id);
    
    			//Format cart list data.
                $entity_list = array();
                foreach($cart_list as $item){
                    $entity_list[] = $item['CartItem']['product_entity_id'];
                }
                $entities = $Entity->getEntitiesById($entity_list, $user_id);
    
                foreach($cart_list as &$item){
                    foreach($entities as $entity){
                        if($entity['Entity']['id'] == $item['CartItem']['product_entity_id']){
                            $item['Entity'] = $entity['Entity'];
                            $item['Image'] = $entity['Image'];
                            $item['Color'] = $entity['Color'];
                        }
                    }
                }
            }
            $this->set(compact('cart_list'));
        }
    }
    
    
    public function checkout() {
        $this->response->disableCache();

        $this->isLogged();
        $user_id = $this->getLoggedUserID();
        if($user_id){
            //Register Classes for fetching data
            $User = ClassRegistry::init('User');
            $Cart = ClassRegistry::init('Cart');
            $CartItem = ClassRegistry::init('CartItem');
            $Entity = ClassRegistry::init('Entity');
            $BillingAddress = ClassRegistry::init('BillingAddress');


            //Get current user cart details. Redirect to closet if cart doesnt exist.
            //Also update cart to avoid cart expiration.
            $cart = $Cart->getExistingUserCart($user_id);
            if($cart){
                $cart_id = $cart['Cart']['id'];
                //Update cart to avoid cart expiration
                unset($cart['Cart']['created']);
                unset($cart['Cart']['updated']);
                $result = $Cart->save($cart);
            }
            else{
                $this->redirect('/closet');
                exit;
            }

            
            //Get Cart items and redirect to cart page if no item exists.
            $cart_list = $CartItem->getByCartId($cart_id);
            if(!$cart_list){
                $this->redirect('/cart');
                exit;
            }
            

            //Get a list of product entitites occupying the closet and get the entity details.
            $entity_list = array();
            foreach($cart_list as $item){
                $entity_list[] = $item['CartItem']['product_entity_id'];
            }
            $entities = $Entity->getEntitiesById($entity_list, $user_id);

            //Prepare cart data
            $cart_total = 0;
            foreach($cart_list as &$item){
                foreach($entities as $entity){
                    if($entity['Entity']['id'] == $item['CartItem']['product_entity_id']){
                        $item['Entity'] = $entity['Entity'];
                        $item['Image'] = $entity['Image'];
                        $item['Color'] = $entity['Color'];
                        $cart_total = $cart_total + $item['Entity']['price'] * $item['CartItem']['quantity'];
                    }
                }
            }

            //Get user details and prepare a country list.
            $user = $User->findById($user_id);
            $country_list = array('USA' => 'USA', 'Canada' => 'Canada');

            //Prepare data for prefilling the user billing data.
            $data = array();
            $address = $BillingAddress->getByUserID($user_id);
            $data['billing']['billfirst_name'] = $user['User']['first_name'];
            $data['billing']['billlast_name'] = $user['User']['last_name'];
            $data['billing']['billemail'] = $user['User']['email'];
            $data['billing']['billphone'] = $user['User']['phone'];
            
            //Blank values
            $data['billing']['billstate'] = "";
            $data['billing']['billcity'] = "";
            $data['billing']['billcompany'] = "";
            $data['billing']['billaddress'] = "";
            $data['billing']['billzip'] = "";
            $data['billing']['billcountry'] = "";
            
            if($address){
                $data['billing']['billstate'] = $address['BillingAddress']['state'];
                $data['billing']['billcity'] = $address['BillingAddress']['city'];
                $data['billing']['billcompany'] = $address['BillingAddress']['company'];
                $data['billing']['billaddress'] = $address['BillingAddress']['address'];
                $data['billing']['billzip'] = $address['BillingAddress']['zip'];
                $data['billing']['billcountry'] = $address['BillingAddress']['country'];
            }
            $this->request->data = $data;

            //Check if user needs to be awarded the vip discount
            $discount_total = $cart_total;
            $vip_flag = false;
            if($cart_total >= 250 && $user['User']['vip_discount_flag'] && !$user['User']['vip_discount']){
                $discount_total = $cart_total - 50; 
                $vip_flag = true;
            }
                       
            $this->set(compact('cart_list', 'cart_id', 'country_list', 'user', 'cart_total', 'discount_total', 'vip_flag'));
        }
    }
    
    public function payment() {

        $this->response->disableCache();
        $this->isLogged();
        $user_id = $this->getLoggedUserID();
        if($user_id){

            //Initialize classes
            $Cart = ClassRegistry::init('Cart');
            $CartItem = ClassRegistry::init('CartItem');
            $Entity = ClassRegistry::init('Entity');
            $ShippingAddress = ClassRegistry::init('ShippingAddress');  

            //Get current user cart details. Redirect to closet if cart doesnt exist.
            $cart = $Cart->getExistingUserCart($user_id);
            if($cart){
                $cart_id = $cart['Cart']['id'];    
            }
            else{
                $this->Session->setFlash(__('There was a problem in processing the request. Please try again.'), 'flash');
                $this->redirect('/cart');
                exit;
            }
            
            //Get Cart items and redirect to cart page if no item exists.
            $cart_list = $CartItem->getByCartId($cart_id);
            if(!$cart_list){
                $this->redirect('/cart');
                exit;
            }

            //Get a list of product entitites occupying the closet and get the entity details.
            $entity_list = array();
            foreach($cart_list as $item){
                $entity_list[] = $item['CartItem']['product_entity_id'];
            }
            $entities = $Entity->getEntitiesById($entity_list, $user_id);

            //Prepare cart data
            $cart_total = 0;
            foreach($cart_list as &$item){
                foreach($entities as $entity){
                    if($entity['Entity']['id'] == $item['CartItem']['product_entity_id']){
                        $item['Entity'] = $entity['Entity'];
                        $item['Image'] = $entity['Image'];
                        $item['Color'] = $entity['Color'];
                        $cart_total = $cart_total + $item['Entity']['price'] * $item['CartItem']['quantity'];
                    }
                }
            }
            
            $user = $this->getLoggedUser();
            $error_cart = false;
            $error = false;

            //Get the prepared data for the payment.
            $data = $this->preparePaymentData($this->request->data);
            
            //Validate Transaction Details
            $error_transaction = $this->validatePaymentDetails($data['Transaction']);
            

            //Validate Billing and Shipping data
            $error_shipping = $this->validateShipping($data);
            $error_billing = $this->validateBilling($data);
            

            // Get cart data and calculate total price
            $request_cart_id = $this->request->data['checkout-cart-id'];
            $request_total_price = $this->request->data['checkout-total-price'];


            //Validate Cart Data
            $data = $this->validateCart($data, $cart_total, $cart_id);
            $error_cart = $data['Order']['cart_error'];
            if($error_cart){
                $error = true;
            }
            
            
            if($error_billing || $error_cart || $error_shipping || $error_transaction){
                $error = true;
                $this->Session->write('transaction_complete', "fail");
            }

            //Add or update billing address
            if(!$this->updateBillingAddress($data, $user_id)){
                $error = true;
                $this->Session->write('transaction_complete', "fail");
            }

            //Add order
            if($data['Order']['discount']){
                $order_id = $this->addOrder($cart_list, $data['Order']['final_price'], $data['Order']['tax'], $data['Order']['taxAmount'], $data['Order']['promocode'], $data['Order']['discount'], $data['Order']['final_price']);
            }
            else{
                $order_id = $this->addOrder($cart_list, $data['Order']['final_price'], $data['Order']['tax'], $data['Order']['taxAmount']);
            }
            
            //Add shipping address
            $data['ShippingAddress']['order_id'] = $order_id;
            $data['ShippingAddress']['user_id'] = $user_id;
            $ShippingAddress->create();
            if(!$ShippingAddress->save($data)){
                // TODO: if shipping address could not be saved.
                $error = true;
                $this->Session->write('transaction_complete', "fail");
            }
            
            //If all order data has been added. Continue transaction.
            $transaction_data['card_num'] = $data['Transaction']['CreditCard']['cardnumber'];
            $transaction_data['card_code'] = $data['Transaction']['CreditCard']['cardcode'];
            $transaction_data['card_expiry'] = $data['Transaction']['CreditCard']['expiry_month'] . $data['Transaction']['CreditCard']['expiry_year'];
            $transaction_data['total'] = $data['Order']['final_price'];
            $transaction_data['order_id'] = $order_id;
            $transaction_data['user_id'] = $user_id;
            $transaction_data['address'] = $data['BillingAddress']['address'];
            $transaction_data['city'] = $data['BillingAddress']['city'];
            $transaction_data['state'] = $data['BillingAddress']['state'];
            $transaction_data['country'] = $data['BillingAddress']['country'];
            $transaction_data['zip'] = $data['BillingAddress']['zip'];
            $transaction_data['phone'] = $data['BillingAddress']['phone'];
            $transaction_data['first_name'] = $data['User']['first_name'];
            $transaction_data['last_name'] = $data['User']['last_name'];
            $transaction_data['email'] = $user['User']['email'];
            
            if(!$error){
                $transaction_result = $this->makePayment($transaction_data);
                if($transaction_result['status']){

                    $Order = ClassRegistry::init('Order');
                    $ret = $Order->markPaid($order_id);
                    
                    $this->sendConfirmationEmail($order_id);
                    
                    //Check if order had gift card and send gift card email to the user
                    $this->checkOrderGiftCard($order_id);
                    
                    //Reduce the item stock
                    $this->reduceStock($cart_list);
                    
                    $Cart->remove($cart_id);
                    $this->removeLikes($entity_list, $user_id);
    
                    $this->Session->write('transaction_complete', "success");
                    $this->Session->write('transaction_data', $transaction_result);

                    //Write VIP discount data
                    if(isset($this->request->data['vip-discount'])){
                        $User = ClassRegistry::init('User'); 
                        $user = $User->findById($user_id);
                        $user['User']['vip_discount_flag']  = 0;
                        $user['User']['vip_discount']  = 1; 

                        $User->save($user);
                    }
                    // $this->Session->setFlash(__('Success'), 'flash');
                }
                else{
                    $this->Session->write('transaction_complete', "fail");
                    $this->Session->write('transaction_data', $transaction_result);
                    // $this->Session->setFlash(__('Fail'), 'flash');
                }
            }
            $this->redirect('/confirmation');
            exit;            
        }
    }


    /**
     * Function to prepare payment data from the request data.
     */
    function preparePaymentData($request_data){
        $data = array();
        $billing_data = $request_data['billing'];

        // Prepare the billing data
        $data['User']['first_name'] = $billing_data['billfirst_name'];
        $data['User']['last_name'] = $billing_data['billlast_name'];
        $data['BillingAddress']['company'] = $billing_data['billcompany'];
        $data['BillingAddress']['address'] = $billing_data['billaddress'];
        $data['BillingAddress']['city'] = $billing_data['billcity'];
        $data['BillingAddress']['state'] = $billing_data['billstate'];
        $data['BillingAddress']['country'] = $billing_data['billcountry'];
        $data['BillingAddress']['zip'] = $billing_data['billzip'];
        $data['BillingAddress']['phone'] = $billing_data['billphone'];
        
        
        // Prepare shipping data
        if(isset($billing_data['copybilling']) && $billing_data['copybilling'] == 1){
            $data['ShippingAddress']['first_name'] = $data['User']['first_name'];
            $data['ShippingAddress']['last_name'] = $data['User']['last_name'];
            $data['ShippingAddress']['company'] = $data['BillingAddress']['company'];
            $data['ShippingAddress']['address'] = $data['BillingAddress']['address'];
            $data['ShippingAddress']['city'] = $data['BillingAddress']['city'];
            $data['ShippingAddress']['state'] = $data['BillingAddress']['state'];
            $data['ShippingAddress']['country'] = $data['BillingAddress']['country'];
            $data['ShippingAddress']['zip'] = $data['BillingAddress']['zip'];
        }
        else{
            $data['ShippingAddress']['first_name'] = $billing_data['shipfirst_name'];
            $data['ShippingAddress']['last_name'] = $billing_data['shiplast_name'];
            $data['ShippingAddress']['company'] = $billing_data['shipcompany'];
            $data['ShippingAddress']['address'] = $billing_data['shipaddress'];
            $data['ShippingAddress']['city'] = $billing_data['shipcity'];
            $data['ShippingAddress']['state'] = $billing_data['shipstate'];
            $data['ShippingAddress']['country'] = $billing_data['shipcountry'];
            $data['ShippingAddress']['zip'] = $billing_data['shipzip'];
        } 

        //Prepare Transaction data
        $data['Transaction']['CreditCard']['cardnumber'] = $billing_data['billcardnumber'];
        $data['Transaction']['CreditCard']['cardcode'] = $billing_data['billcardcode'];
        $data['Transaction']['CreditCard']['expiry_month'] = intval($billing_data['exp']['month']);
        $data['Transaction']['CreditCard']['expiry_year'] = intval($billing_data['exp']['year']);

        //Prepare Cart Data
        $data['Cart']['id'] = $request_data['checkout-cart-id'];
        $data['Cart']['total'] = $this->request->data['checkout-total-price'];
        $data['Cart']['tax'] = $this->request->data['checkout-tax'];
        if(isset($this->request->data['vip-discount'])){
            $data['Cart']['vipDiscountSet'] = true;
        }
        else{
            $data['Cart']['vipDiscountSet'] = false;
        }

        if(isset($billing_data['promocode'])){
            $data['Cart']['promocodeSet'] = true;
            $data['Cart']['promocode'] = strtoupper($billing_data['promocode']);
        }
        else{
            $data['Cart']['promocodeSet'] = false;
        }

        return $data;
    }


    /**
     * Function to validate Payment Details (Credit Card Details)
     */
    function validatePaymentDetails($transaction_details) {
        // Validate Credit Card Info
        $CreditCard = ClassRegistry::init('CreditCard');
        $CreditCard->set($transaction_details);
        if(!$CreditCard->validates()){
            return true;
        }
        if($transaction_details['CreditCard']['expiry_year'] < intval(date('Y')) || $transaction_details['CreditCard']['expiry_year'] >= intval(date('Y', strtotime('+10 year'))) ){
            return true;
        }

        return false;
    }


    /**
     * Function to validate shipping data
     */
    function validateShipping($data){
        // Validate Shipping Data
        $ShippingAddress = ClassRegistry::init('ShippingAddress');
        $ShippingAddress->set($data);
        if(!$ShippingAddress->validates()){
            return true;
        }

        return false;
    }


    /**
     * Function to validate billing data
     */
    function validateBilling($data){
        // Validate Billing Data
        $BillingAddress = ClassRegistry::init('BillingAddress');
        $BillingAddress->set($data);
        if(!$BillingAddress->validates()){
            return true;
        }

        return false;
    }


    /**
     * Function to validate the cart data
     */
    function validateCart($data, $cart_total, $cart_id){
        $error_cart = false;

        //Check if cart id is same
        if($data['Cart']['id'] != $cart_id){
            $error_cart = true;
        }

        //Check for applied discount
        if($data['Cart']['vipDiscountSet']){
            $promo_code = ""; 
            $discount = 50;
            $discounted_price = $cart_total - $discount;
        }
        else{
            //Check if promocode is valid
            $promo_code = $data['Cart']['promocodeSet'] ? $data['Cart']['promocode'] : "";
            $promo_result = false;
            $discount = false;
            $discounted_price = 0;
            $final_price = 0;
            if($promo_code != ""){
                $promo_result = $this->validate_promo_code($promo_code, true);    
            }
            
            if($promo_result){
                if($promo_result['status']=="ok"){
                    if(isset($promo_result['percent'])){
                        
                        $discount = $promo_result['amount'] * $cart_total / 100;
                        $discount = round($discount, 2);

                        $discounted_price = $cart_total - $discount;
                        $discounted_price = round($discounted_price, 2); 
                    }
                    else{
                        $discount = $promo_result['amount'];  
                        $discounted_price = $cart_total - $discount;
                    }
                }   
                else{
                    $this->Session->setFlash(__('The promo code used is not valid.'), 'flash');
                    $this->redirect('/checkout');
                } 
            }
            else{  
                $discounted_price = $cart_total;
            }
        }


        //Calculate tax and get the total price.
        if($data['Cart']['tax'] == 0){
            $data['Order']['tax'] = 0;
            $data['Order']['taxAmount'] = 0;
            $final_price = $discounted_price;
        }
        else{
            $chargeable_tax = $this->calculateTax($data['ShippingAddress']['zip'], true);
            if($chargeable_tax == $data['Cart']['tax']){
                $tax_amount = $discounted_price * $chargeable_tax / 100;
                $tax_amount = $this->round_up($tax_amount);

                $final_price = $this->round_up($discounted_price + $tax_amount);


                $data['Order']['tax'] = $chargeable_tax;
                $data['Order']['taxAmount'] = $tax_amount;
            }
            else{
                $error_cart = true;
            }
        }

        if($final_price != $data['Cart']['total']){
            $error_cart = true;
        }


        $data['Order']['final_price'] = $final_price;
        $data['Order']['discount'] = $discount;
        $data['Order']['promocode'] = $promo_code;
        $data['Order']['cart_error'] = $error_cart;

        return $data;

    }
    
    public function sendConfirmationEmail($id = null){
        $Order = ClassRegistry::init('Order');
        if (!$Order->exists($id)) {
            throw new NotFoundException(__('Invalid order'));
        }    
        
        $options = array('conditions' => array('Order.' . $Order->primaryKey => $id));
        $order = $Order->find('first', $options);
        $order['Order']['confirmed'] = 1;
        if($Order->save($order)){

            //Send confirmation email to the customer.
            $Order->recursive = 2;
            $Order->OrderItem->unbindModel(array('belongsTo' => array('Order')));
            $Order->OrderItem->Entity->unbindModel(array('hasMany' => array('Detail', 'Wishlist', 'OrderItem', 'CartItem'), 'belongsTo' => array('Product')));
            $Order->User->unbindModel(array('hasMany' => array('Post', 'Wishlist', 'Message', 'Order')));
            $options = array('conditions' => array('Order.' . $Order->primaryKey => $id));
            $shipped_order = $Order->find('first', $options);

            $Size = ClassRegistry::init('Size');
            $sizes = $Size->find('list');
            
            if($shipped_order['User']['email']){
                try{               
                    $bcc = Configure::read('Email.contact');     
                    $email = new CakeEmail('default');
                    $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                    $email->to($shipped_order['User']['email']);
                    $email->bcc($bcc);
                    $email->subject('Order Confirmation');
                    $email->template('order_confirmation');
                    $email->emailFormat('html');
                    $email->viewVars(compact('shipped_order','sizes'));
                    $email->send();
                }
                catch(Exception $e){
                    
                }
            };
        } 
    }

    public function confirmation(){
        $this->response->disableCache();
        $transaction_data = false;
        if($this->Session->check('transaction_complete')){
            $transaction_complete = $this->Session->read('transaction_complete');
            $this->Session->delete('transaction_complete');
            
            if($transaction_complete == "success"){
                $transaction_data = $this->Session->read('transaction_data');
            }
        }
        else{
            $this->redirect('/closet');
            exit;
        }

        $this->set(compact('transaction_complete', 'transaction_data'));
    }
    
    public function updateBillingAddress($data, $user_id){
        $BillingAddress = ClassRegistry::init('BillingAddress');
        $address = $BillingAddress->getByUserID($user_id);
        $data['BillingAddress']['user_id'] = $user_id;
        
        if($address){
            $data['BillingAddress']['id'] = $address['BillingAddress']['id'];
            $result = $BillingAddress->save($data);
        }
        else{
            $BillingAddress->create();
            $result = $BillingAddress->save($data);
        } 
        
        if($result){
            return true;
        }
        else{
            return false;    
        }
        
    }
    
    public function addOrder($cart_items, $total_price, $tax, $tax_amount, $promo_code = false, $discount = false, $discounted_price = false){
        $user_id = $this->getLoggedUserID();
        //bhashit
                $posts = ClassRegistry::init('Post');
                $this->request->data['Post']['user_id'] = $user_id;
                //$this->request->data['Post']['stylist_id'] = ''; 
                $this->request->data['Post']['is_order'] = '1';
                $posts->save($this->request->data);
                $post_id = $posts->getLastInsertID();
                //bhashit
        $data = array();
        if($user_id){
            $transaction_error = false;
            $data['Order']['orderid'] = uniqid();
            $data['Order']['user_id'] = $user_id;  
            $data['Order']['tax'] = $tax;
            $data['Order']['tax_amount'] = $tax_amount;
            $data['Order']['total_price'] = $total_price;
            $data['Order']['final_price'] = $total_price; 
            $data['Order']['paid'] = 0;    
            $data['Order']['confirmed'] = 0;
            $data['Order']['shipped'] = 0;
            $data['Order']['post_id'] = $post_id;     

            if($promo_code !== false){
                $data['Order']['final_price'] = $discounted_price; 
                $data['Order']['promo_discount'] = $discount;
                $data['Order']['promo_code'] = $promo_code;
                $data['Order']['post_id'] = $post_id;   
            }
            
            $Order = ClassRegistry::init('Order');
            $CartGiftItem = ClassRegistry::init('CartGiftItem');
            $OrderGiftItem = ClassRegistry::init('OrderGiftItem');
            $Order->create();
            $result = $Order->save($data);
            $order_id = false;
            if($result){
                $order_id = $result['Order']['id'];
                $OrderItem = ClassRegistry::init('OrderItem');


                $Post = ClassRegistry::init('Post');
                
                foreach($cart_items as $row){
                    $post = array();
                    $post['Post']['user_id'] = $user_id;
                    $post['Post']['is_order'] = 1;
                    $Post->create();
                    $post = $Post->save($post);


                    $data['OrderItem'] = array();
                    $data['OrderItem']['order_id'] = $result['Order']['id'];
                    $data['OrderItem']['product_entity_id'] = $row['Entity']['id'];
                    $data['OrderItem']['quantity'] = $row['CartItem']['quantity'];
                    $data['OrderItem']['size_id'] = $row['CartItem']['size_id'];
                    $data['OrderItem']['outfit_id'] = $row['CartItem']['outfit_id'];
                    $data['OrderItem']['post_id'] = $post['Post']['id'];
                    $data['OrderItem']['price'] = $row['Entity']['price'];
                    
                    //Check if item is a gift item
                    if($row['Entity']['is_gift'] != "" && $row['Entity']['is_gift'] == 1){
                        $data['OrderItem']['is_gift'] = 1;
                    }
                    
                    $OrderItem->create();
                    $item_result = $OrderItem->save($data);
                    if($item_result){
                        if(isset($data['OrderItem']['is_gift']) && $data['OrderItem']['is_gift'] == 1){
                            $gift_details = $CartGiftItem->getGiftCardDetails($row['CartItem']['id']);
                            $gift_card_uniqid = 'SRS-Gift-' . uniqid();
                            
                            $data['OrderGiftItem']['order_item_id'] = $item_result['OrderItem']['id'];
                            $data['OrderGiftItem']['recipient_email'] = $gift_details['CartGiftItem']['recipient_email'];
                            $data['OrderGiftItem']['recipient_name'] = $gift_details['CartGiftItem']['recipient_name'];
                            $data['OrderGiftItem']['message'] = $gift_details['CartGiftItem']['message'];
                            $data['OrderGiftItem']['gift_card_uniqid'] = $gift_card_uniqid;
                            
                            $OrderGiftItem->create();
                            $OrderGiftItem->save($data);    
                        }    
                    }
                    else{
                        $transaction_error = true;
                    }
                }
            }
        }
        
        if($transaction_error){
            // TODO: transaction error. Take necessary action.
        }
        
        return $order_id;
    }
    
    public function emptyCart($card_id, $cart_list){
        $Cart = ClassRegistry::init('Cart');
        $CartItem = ClassRegistry::init('CartItem');
        
        $item_list = array();
        
        foreach($cart_list as $item){
            $item_list[] = $item['CartItem']['id'];
        }        
        
        //Remove Cart items.
        if($item_list){
            $CartItem->remove($item_list);
        }
        
        //Remove cart id.
        $Cart->remove($card_id);
    }
    
    function makePayment($transaction_data){
        $user_id = $this->getLoggedUserID();
        if($user_id && $user_id == $transaction_data['user_id']){
            //Uses core.php config file for settings.
            //Sandbox mode is triggered for development mode only.
            
            $ret = array();
            App::import('Vendor', 'AuthorizeNet/AuthorizeNet');
            $api_login_id = Configure::read('AuthorizeNet.api_login_id');
            $transaction_key = Configure::read('AuthorizeNet.transaction_key');
            $sandbox_mode = Configure::read('AuthorizeNet.sandbox');
            
            $sale = new AuthorizeNetAIM($api_login_id, $transaction_key);
            $sale->setSandbox($sandbox_mode);
            $sale->setFields(
                array(
                    'amount' => $transaction_data['total'],
                    'card_num' => $transaction_data['card_num'],
                    'exp_date' => $transaction_data['card_expiry'],
                    'card_code' => $transaction_data['card_code'],
                    'method'   => 'CC',
                    'invoice_num' => $transaction_data['order_id'],
                )
            );
            $customer = (object)array();
            $customer->first_name = $transaction_data['first_name'];
            $customer->last_name = $transaction_data['last_name'];
            $customer->address = $transaction_data['address'];
            $customer->city = $transaction_data['city'];
            $customer->state = $transaction_data['state'];
            $customer->zip = $transaction_data['zip'];
            $customer->country = $transaction_data['country'];
            $customer->phone = $transaction_data['phone'];
            $customer->email = $transaction_data['email'];
            $customer->cust_id = $transaction_data['user_id'];
            $sale->setFields($customer);


            $response = $sale->authorizeAndCapture();
            $ret['Transaction']['user_id'] = $transaction_data['user_id'];
            $ret['Transaction']['order_id'] = $transaction_data['order_id'];
            $ret['Transaction']['response_code'] = $response->response_code;
            $ret['Transaction']['authorization_code'] = $response->authorization_code;
            $ret['Transaction']['avs_response'] = $response->avs_response;
            $ret['Transaction']['transaction_id'] = $response->transaction_id;
            $ret['Transaction']['amount'] = $response->amount;
            $ret['Transaction']['method'] = $response->method;
            $ret['Transaction']['transaction_type'] = $response->transaction_type;
            $ret['Transaction']['md5_hash'] = $response->md5_hash;
            $ret['Transaction']['account_number'] = $response->account_number;
            $ret['Transaction']['card_code_response'] = $response->card_code_response;
            $ret['Transaction']['card_type'] = $response->card_type;
            
            if ($response->approved) {
                $ret['status'] = true;
            } 
            else {
                $ret['status'] = false;
            }
            
            //Store transaction data
            $Transaction = ClassRegistry::init('Transaction');
            $Transaction->create();
            if($Transaction->save($ret)){
                $ret['transact_status'] = true;
            }
            else{
                //TODO: Incase there is an error in storing the transaction record to our database.
                $ret['transact_status'] = false;
            }
        }
        else{
            $ret['status'] = false;    
        }
        return $ret;
    }

    function reduceStock($cart_list){
        $Detail = ClassRegistry::init('Detail');

        foreach($cart_list as $row){
            $Detail->removeFromStock($row['CartItem']['product_entity_id'], $row['CartItem']['size_id'], $row['CartItem']['quantity']);
        }
    }

    function removeLikes($entity_list, $user_id){
        $Wishlist = ClassRegistry::init('Wishlist');
        $Wishlist->remove($user_id, $entity_list);
    }
    
    public function checkOrderGiftCard($order_id){
        $this->autoLayout = false;
        $this->autoRender = false;
        
        $OrderItem = ClassRegistry::init('OrderItem');
        $OrderGiftItem = ClassRegistry::init('OrderGiftItem');
        $order_items = $OrderItem->getByOrderId($order_id);
        
        if($order_items){
            foreach($order_items as $item){
                if(!is_null($item['OrderItem']['is_gift']) && $item['OrderItem']['is_gift'] == 1){
                    $Order = ClassRegistry::init('Order');
                    $Order->recursive = 0;
                    $order = $Order->findById($order_id);
                    $Image = ClassRegistry::init('Image');
                    
                    $item_image = $Image->getByProductID($item['OrderItem']['product_entity_id']);
                    $img_src = "";
                    if($item_image){
                        $img_src = $item_image[0]['Image']['name'];
                    }
                    
                    $gift_details = $OrderGiftItem->getGiftCardDetails($item['OrderItem']['id']);
                    
                    // Check that order exists
                    if($order){
                        $User = ClassRegistry::init('User');
                        $user_id = $order['Order']['user_id'];
                        $user = $User->getByID($user_id);
                        
                        try{
                            $email = new CakeEmail('default');
                            $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                            $email->to($gift_details['OrderGiftItem']['recipient_email']);
                            $email->cc($user['User']['email']);
                            $email->bcc('admin@savilerowsociety.com');
                            $email->subject('SRS Team: New Gift Card.');
                            $email->template('gift_purchase');
                            $email->emailFormat('html');
                            $email->viewVars(compact('user','item','img_src','gift_details'));
                            $email->send();
                        }
                        catch(Exception $e){
                            
                        }
                    }     
                }
            }   
        }
    }
    
    
    public function validatecard(){
        //Configure::write('debug', 2);
        
        $ret = array();
        $this->autolayout = false;
        $this->autoRender = false;
        $user_id = $this->getLoggedUserID();
        $ret = array();
        if($user_id && ($this->request->is('ajax') || $this->request->is('post'))){
            // Arrange transaction data
            $user_transaction_detail = array();
            $user_transaction_detail['CreditCard']['cardnumber'] = $this->request->data['cardNumber'];
            $user_transaction_detail['CreditCard']['cardcode'] = $this->request->data['cardCode'];
            
            // Validate Credit Card Info
            $CreditCard = ClassRegistry::init('CreditCard');
            $CreditCard->set($user_transaction_detail);
            if($CreditCard->validates()){
                $ret['status'] = "ok";
            }
            else{
                $ret['status'] = "error";
                $ret['errors'] = $CreditCard->validationErrors;
            }
        }
        else{
            $ret['status'] = "error";
        }
        echo json_encode($ret);
        exit;
    }
    
    /**
     * Function to validate the use of a promo code
     */ 
    public function validate_promo_code($code = null, $inline = false){
        if(!$inline){
            $this->autoLayout = false;
            $this->autoRender = false;
        }
        
        $user_id = $this->getLoggedUserID();
        $code = strtoupper($code);
        $ret = array();
        if($user_id && $code != null){
            if(in_array($code, $this->promoCodes)){
                $Order = ClassRegistry::init('Order');
                $is_used = false;
                $used_promo = $Order->usedUserPromo($user_id);
                if($used_promo){
                    foreach($used_promo as $promo){
                        if(strtoupper($promo) == $code){
                            $is_used = true;
                            break;
                        }    
                    }
                }
                
                if($is_used){
                    $ret['status'] = "error";
                    $ret['info'] = "used";    
                }
                else if($code == "CYBER30"){
                    // Only valid for 02nd december 2013 EST
                    $start_date = strtotime("2013-12-03 00:00:00");
                    $end_date = strtotime("2013-12-03 23:59:59"); 
                    
                    $cur_timestamp = strtotime(gmdate("Y-m-d H:i:s"));
                    $cur_date = date('Y-m-d H:i:s', strtotime('-300 minutes', $cur_timestamp));
                    $cur_est_timestamp = strtotime($cur_date);
                    
                    if($cur_est_timestamp >= $start_date && $cur_est_timestamp <= $end_date){
                        if(in_array($code, $this->percentCodes)){
                            $ret['percent'] = "percent";
                        }
                        $ret['status'] = "ok";
                        $ret['info'] = "valid"; 
                        $ret['amount'] = $this->promoCodesAmount[$code];    
                    }
                    else{
                        $ret['status'] = "error";
                        $ret['info'] = "invalid";        
                    }    
                }
                else{
                    if(in_array($code, $this->percentCodes)){
                        $ret['percent'] = "percent";
                    }
                    $ret['status'] = "ok";
                    $ret['info'] = "valid"; 
                    $ret['amount'] = $this->promoCodesAmount[$code];   
                }
            }
            else{
                $ret['status'] = "error";
                $ret['info'] = "invalid";    
            }    
        }
        else if($code != null){
            $ret['status'] = "error";
            $ret['info'] = "login";    
        }
        else{
            $ret['status'] = "error";
            $ret['info'] = "null";
        }
        
        if(!$inline){
            echo json_encode($ret);
            exit;
        }
        return $ret;
    }

    public function calculateTax($zipcode, $inline = false) {
        $this->autoRender = false;
        $this->autoLayout = false;
        $ret = array();

        $Tax = ClassRegistry::init('Tax');
        if($zipcode){
            $result = $Tax->getByZip($zipcode);
            if($result) {
                $ret['tax'] = $result['Tax']['tax'];
            }
            else{
                $ret['tax'] = 0;
            }
        }
        else{
            $ret['tax'] = 0;
        }

        if(!$inline){
            echo json_encode($ret);
            exit;
        }
        return $ret['tax'];
    }

    public function calculateTaxTotal($zipcode){
        $this->autoRender = false;
        $this->autoLayout = false;
        $ret = array();
        $total = $this->request->data['total'];
        $country = $this->request->data['country'];

        $Tax = ClassRegistry::init('Tax');
        if($zipcode && $country == 'USA'){
            $result = $Tax->getByZip($zipcode);
            if($result) {
                $tax = $result['Tax']['tax'];
                $tax_amount = $total * $tax / 100;
                $tax_amount = $this->round_up($tax_amount);

                $new_total = $this->round_up($total + $tax_amount);

                $ret['new_total'] = $new_total;
                $ret['tax_amount'] = $tax_amount;
                $ret['tax'] = $tax;
                $ret['test'] = $this->round_up(12.236);

            }
            else{
                $ret['tax'] = 0;
            }
        }
        else{
            $ret['tax'] = 0;
        }

        echo json_encode($ret);
        exit; 
    }

    function round_up($number, $precision = 3){
        $this->autoRender = false;
        $this->autoLayout = false;
        $fig = (int) str_pad('1', $precision, '0');
        return (ceil($number * $fig) / $fig);
    }
}