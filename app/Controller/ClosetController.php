<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Closet Controller
 */
class ClosetController extends AppController {
    public $components = array('Paginator');
    public $helpers = array('Paginator');
    
    public $promoCodes = array('CBS20', 'SRS20', 'JOHNALLANS25', 'LMC20', 'PERKLA20', 'SRSBRANDS20', 'CYBER30', 'JOEYG25', 'FULLTHROTTLE20', 'BLOGGER20', 'SUITES20', 'EQUITY20', 'TIDE25', 'BADWIN25', 'BOBBY25', 'NISH25', 'ROGER25', 'STUART25', 'ALBERT25', 'F&F25', 'ANDREI25');
    public $promoCodesAmount = array('CBS20' => 20, 'SRS20' => 20, 'JOHNALLANS25' => 25, 'LMC20' => 20, 'PERKLA20' => 20, 'SRSBRANDS20' => 20, 'FULLTHROTTLE20' => 20, 'BLOGGER20' => 20, 'SUITES20' => 20, 'CYBER30' => 30, 'JOEYG25' => 25, 'EQUITY20' => 20, 'TIDE25' => 25, 'BADWIN25' => 25, 'BOBBY25' => 25, 'NISH25' => 25, 'ROGER25' => 25, 'STUART25' => 25, 'ALBERT25' => 25, 'F&F25' => 25, 'ANDREI25' => 25);
    public $percentCodes = array('CYBER30', 'JOEYG25');
    /**
     * Index
     */

    // function beforeFilter() {
    //     $secureActions = array('checkout', 'validatecard', 'payment', 'validate_promo_code');
        
    //     // if (in_array($this->request->params['action'], $secureActions) && !$this->request->is('ssl')) {
    //     //     $this->forceSSL();
    //     // }  
    //     // else if($this->request->is('ssl') && !in_array($this->request->params['action'], $secureActions)){
    //     //     $this->unForceSSL();  
    //     // }
    // }


    public function forceSSL() {
        $this->redirect('https://' . $_SERVER['SERVER_NAME'] . $this->here);
    }
    public function unForceSSL() {
        $this->redirect('http://' . $_SERVER['SERVER_NAME'] . $this->here);
    }
    
    
    public function index($category_slug = null, $filter_brand=null, $filter_color=null, $filter_used = null) {
        $this->redirect('/messages/index');
        exit;

        $user_id = $this->getLoggedUserID();
        // init
        $Category = ClassRegistry::init('Category');
        $Brand = ClassRegistry::init('Brand');
        $Color = ClassRegistry::init('Color');
        $Colorgroup = ClassRegistry::init('Colorgroup');
        $User = ClassRegistry::init('User');

        // get data
        $categories = $Category->getAll();
        $brands = $Brand->find('all', array('order' => "Brand.name ASC"));
        $colors = $Colorgroup->find('all', array('order' => "Colorgroup.name ASC"));

        $entities = array();

        if ($category_slug) {
            $category_slug = trim($category_slug);
            $entities = $this->categoryProducts($user_id, $categories, $category_slug, $filter_brand, $filter_color, $filter_used);
        } else {
            $entities = $this->closetProducts($user_id);
        }
        
        
        $show_add_cart_popup = 0;
        if($this->Session->read('add-cart')){
            $show_add_cart_popup = 1;
            $this->Session->delete('add-cart');
        }

        $popUpMsg = '';
        $show_three_item_popup = 0;
        if($this->Session->read('cart-three-items')){
            $show_three_item_popup = 1;
            $popUpMsg = $this->Session->read('cart-three-items-msg');
            $this->Session->delete('cart-three-items');
            $this->Session->delete('cart-three-items-msg');
        }
        
        $show_closet_popup = 0;
        if($user_id && !$this->Session->check('Message.flash')){
            $user = $User->getById($user_id); 
            if($user && $user['User']['show_closet_popup'] == 1){
                $show_closet_popup = 1;
            }
        }
        
        // send data to view
        $this->set(compact('entities', 'categories', 'category_slug', 'brands', 'colors', 'user_id','show_closet_popup','show_three_item_popup', 'popUpMsg', 'show_add_cart_popup'));

        if(!$category_slug){
            $this->render('closet_landing');     
        }
    }



    public function closetProducts($user_id){
        $this->redirect('/messages/index');
        exit;
        $Entity = ClassRegistry::init('Entity');
        $Category = ClassRegistry::init('Category');

        $user = $this->getLoggedUser();

        //Get the list of random product list for the closet
        if($user['User']['is_stylist'] || $user['User']['is_admin']){
            $random_list = $Entity->getTeamClosestItems();
        }
        else{
            $random_list = $Entity->getClientClosestItems();    
        }

        
        $entity_list = array();
        $entity_list_cat = array();
        
        $category_list = $Category->find('threaded', array('order' => array('Category.order' => 'ASC')));
        foreach($category_list as $cat){
            $cur_list = array();
            $cur_list[] = $cat['Category']['id'];
            if(count($cat['children'])>0){
                foreach($cat['children'] as $sub){
                    $cur_list[] = $sub['Category']['id'];
                    if(count($sub['children'] > 0)){
                        foreach($sub['children'] as $subsub){
                            $cur_list[] = $subsub['Category']['id'];
                        }
                    }
                }    
            }
            
            foreach($random_list as $item){
                if(in_array($item['pc']['category_id'], $cur_list)){
                    $entity_list[] = $item['pe']['id'];
                    $entity_list_cat[$item['pe']['id']] = array('id' => $item['pe']['id'], 'parent_cat' => $cur_list[0]);
                    break;    
                }    
            }
        }
        
        $unordered_entities = $Entity->getEntitiesById($entity_list, $user_id);
        $entities = array();
        
        foreach($entity_list as $id){
            foreach($unordered_entities as $entity){
                if($id == $entity['Entity']['id']){
                    $entity['Category']['parent_cat'] = $entity_list_cat[$entity['Entity']['id']]['parent_cat'];
                    $entities[] = $entity;
                }
            }    
        }

        return $entities;
    }



    public function categoryProducts($user_id, $categories, $category_slug = null, $filter_brand=null, $filter_color=null, $filter_used = null){
        $this->redirect('/messages/index');
        exit;

        $Entity = ClassRegistry::init('Entity');
        $Category = ClassRegistry::init('Category');

        $user = $this->getLoggedUser();
            
        if($filter_used != "color" && $filter_used != "brand"){
            $filter_used = "error";
        }

        // Get the parent id
        $parent_id = false;
        if($category_slug != "all"){
            foreach($categories as $category){
                if($category_slug == $category['Category']['slug']){
                    $parent_id = $category['Category']['id'];
                    break;
                }
                elseif($category['children']){
                    foreach($category['children'] as $child){
                        if($category_slug == $child['Category']['slug']){
                            $parent_id = $category['Category']['id'];
                            break;
                        }
                        else if($child['children']){
                            foreach($child['children'] as $subchild){
                                if($category_slug == $subchild['Category']['slug']){
                                    $parent_id = $category['Category']['id'];
                                    break;
                                }    
                            }
                        }
                    }
                }
            }
            
            // Ger the category & sub category using the category slug
            $category_ids = $Category->getAllBySlug($category_slug);
        }
        
        if($category_slug != "all" && !$category_ids){
            $this->redirect('/closet');
        }
        

        // Prepare the brand filter data
        $brand_list = array();
        if($filter_brand && $filter_brand != "none"){
            $brand_list = explode('-', $filter_brand);
            $brand_list = array_values(array_unique($brand_list));
        }

        // Prepare the color filter data
        $color_list = array();
        $color_ids  = array();
        if($filter_color && $filter_color != "none"){
            $color_list = explode('-', $filter_color);
            $color_list = array_values(array_unique($color_list));
        }

        // Find array for products of a category exluding the filter and brand sub categories
        // and for a unsigned user
        $find_array = array(
            'limit' => 12,
            'contain' => array('Image', 'Color'),
            'conditions' => array(
                'Entity.show' => true 
                //'Detail.show' => true, 'Detail.stock >' => 0,
            ),
            'group' => array('Entity.id'),
            'joins' => array(
                array('table' => 'products_categories',
                    'alias' => 'Category',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Category.product_id = Entity.product_id'
                    )
                ),
                array('table' => 'products',
                    'alias' => 'Product',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.id = Entity.product_id'
                    )
                ),
                array('table' => 'brands',
                    'alias' => 'Brand',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.brand_id = Brand.id'
                    )
                ),
                
               //  array('table' => 'products_details',
               //     'alias' => 'Detail',
               //     'type' => 'INNER',
               //     'conditions' => array(
               //         'Detail.product_entity_id = Entity.id',
               //     )
               // ),
            ),
            'order' => array('Entity.order' => 'ASC'),
            'fields' => array(
                'Entity.*', 'Product.*', 'Brand.*', 'Category.category_id'
            ),
            'Group' => array('Entity.id'),
        );
        
        if($category_slug != 'all'){
            $find_array['conditions']['Category.category_id'] = $category_ids;
        }

        //Hide products restricted for website user (hide_from_client)
        if(!$user['User']['is_stylist'] && !$user['User']['is_admin']){
            $find_array['conditions']['Entity.hide_from_client'] = false; 
        }
        
        //Query additions for a logged in user
        if($user_id){
            //Join Like
            $find_array['joins'][] = array('table' => 'wishlists',
                                        'alias' => 'Wishlist',
                                        'type' => 'LEFT',
                                        'conditions' => array(
                                            'Wishlist.product_entity_id = Entity.id',
                                            'Wishlist.user_id' => $user_id
                                        )
                                    );
            
                     
            //Fields for likes              
            $find_array['fields'][] = 'Wishlist.*';
        }
        
        // Color filter
        if($color_list && count($color_list) > 0){
            
            //Get product color ids based on colour group ids
            $Colorgroup = ClassRegistry::init('Colorgroup');
            $color_data = $Colorgroup->getColors($color_list);
            if($color_data){
                foreach($color_data as $color_item){
                    $color_ids[] = $color_item['ColorItems']['color_id'];
                }
            }
            
            if($color_ids && count($color_ids) > 0){
                $color_join = array('table' => 'colors_entities',
                    'alias' => 'Color1',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Color1.color_id' => $color_ids,
                        'Color1.product_entity_id = Entity.id'
                    )
                );
                $find_array['joins'][] = $color_join;
            }
        }

        // Brand Filter
        if($brand_list && count($brand_list) > 0){
            $find_array['conditions']['Product.brand_id'] = $brand_list;
        }
        

        
        if(count($color_ids) == 0 && ($category_slug == null || $category_slug ==  "all") && count($brand_list) == 0 ){
            $data = array();
        }
        else{
            $this->Paginator->settings = $find_array;
            $data = $this->Paginator->paginate($Entity);
            foreach($data as &$entity){
                if($entity['Category']['category_id']){
                    $parent = $Category->getParentNode($entity['Category']['category_id']);
                    if($parent){
                        $root_parent = $Category->getParentNode($parent['Category']['id']);
                        if($root_parent){
                            $entity['Category']['parent_cat'] = $root_parent['Category']['id'];    
                        }
                        else{
                            $entity['Category']['parent_cat'] = $parent['Category']['id'];
                        }
                    }
                    else{
                        $entity['Category']['parent_cat'] = $entity['Category']['category_id'];
                    }
                }
            }    
        }
        
        // check for login popup
        $check_count = 0;
        if(!$user_id && (count($brand_list) > 0 || (isset($category_ids) && count($category_ids)>0))){

            $count = $this->Session->read("count-click");

            if($count){
                $count++;
                if($count==3)
                {
                    $check_count=1;
                }
                $this->Session->write("count-click", $count);
            }
            else{
                $this->Session->write("count-click", 1);
            }


        } 
        
        $this->set(compact('parent_id', 'brand_list', 'color_list', 'filter_used','check_count'));
        return $data;
    }

    /**
     * Product details
     */
    public function product($id = null, $slug = null) {
        $this->redirect('/messages/index');
        exit;

        $this->autoRender = false;
        $user_id = $this->getLoggedUserID();
        App::uses('Sanitize', 'Utility');

        if ($slug && $id) {

            // init
            $Entity = ClassRegistry::init('Entity');
            $Category = ClassRegistry::init('Category');
            $Product = ClassRegistry::init('Product');

            // get data
            $entity = $Entity->getById($id, $user_id);
            
            if($slug != $entity['Entity']['slug']){
                $this->redirect('/product/' . $id . '/' . $entity['Entity']['slug']);
                exit;    
            }

            if (!$entity) {
                throw new NotFoundException;
            }
            
            
            $category = $Entity->getCategory($id);
                
            if($category['Category']['parent_id']){
                $parent_category = $Category->findById($category['Category']['parent_id']);
            }

            $check_count = 0;
            if(!$user_id){
    
                $count = $this->Session->read("count-click");
    
                if($count){
                    $count++;
                    if($count==3)
                    {
                        $check_count=1;
                    }
                    $this->Session->write("count-click", $count);
                }
                else{
                    $this->Session->write("count-click", 1);
                }
    
    
            }
            //Check if product is a gift card
            if($entity['Entity']['is_gift'] && $entity['Entity']['price'] > 0){
                //Get all the gift cards
                $gift_cards = $Entity->getGiftCards();
                
                $this->set(compact('entity', 'category', 'parent_category', 'user_id', 'check_count', 'gift_cards'));
                $this->render('gift');       
            }
            else if($entity['Entity']['is_gift'] && $entity['Entity']['price'] <= 0){
                $this->redirect('/closet');       
            }
            else{
                $sizes = $Entity->Detail->getAvailableSize($id);
            
                $product_id = $entity['Entity']['product_id'];
                $similar_results = $Entity->getSimilarProducts($id, $product_id);
                $similar = array();
                foreach($similar_results as $row){
                    if($row['Color'] && count($row['Color']) > 0){
                        $similar[] = $row;
                    }
                }
                
                // send data to view
                $this->set(compact('entity', 'sizes', 'category', 'parent_category', 'similar', 'user_id', 'check_count'));
                
                $this->render('product');    
            }   
        }
    }


    /**
     * Action to fetch and display outfit items on a single page
     * @id : outfit id
     */
    public function userOutfit($id = null) {
        $this->redirect('/messages/index');
        exit;

        //$this->isLogged();
        $user_id = $this->getLoggedUserID();
        App::uses('Sanitize', 'Utility');

        if ($id) {
            //Check if outfit exists else show page not found.
            $Outfit = ClassRegistry::init('Outfit');
            if(!$Outfit->exists($id)){
                throw new NotFoundException(__('Outfit Not Found.'));
            }

            //Get all the products present in the outfit.
            $OutfitItem = ClassRegistry::init('OutfitItem');
            $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $id)));
            $entity_list = array();
            foreach($outfit as $value){
                $entity_list[] = $value['OutfitItem']['product_entity_id'];
            }

            $Entity = ClassRegistry::init('Entity');

            // get data
            $entity = $Entity->getMultipleById($entity_list, $user_id);
            $products_list = array();
            foreach ($entity as $key => $value) {
                $products_list[] = $value['Entity']['product_id'];
            }
        
            $similar_results = $Entity->getSimilarProducts($id, $products_list);
            $similar = array();
            foreach($similar_results as $row){
                if($row['Color'] && count($row['Color']) > 0){
                    $similar[$row['Entity']['product_id']][] = $row; 
                }
            }

            $entities = array();

            foreach ($entity as $key => $value) {
                $entities[$value['Entity']['id']] = $value;
                if(isset($similar[$value['Entity']['product_id']])){
                    $entities[$value['Entity']['id']]['Similar'] = $similar[$value['Entity']['product_id']];
                }
            }

            $Size = ClassRegistry::init('Size');
            $size_list = $Size->find('list');
            
            $this->set(compact('entities', 'size_list', 'user_id'));
            
            $this->render('outfit');    
            
        }
        else{
            throw new NotFoundException(__('Outfit Not Found.'));    
        }
    }

    /**
     * Cart
     */
    public function cart() {

        $this->isLogged();
        $user_id = $this->getLoggedUserID();
        if($user_id){
            $data = array();
            $products = array();

            $Cart = ClassRegistry::init('Cart');
            $CartItem = ClassRegistry::init('CartItem');
            $Entity = ClassRegistry::init('Entity');
            $cart = $Cart->getExistingUserCart($user_id);
            $cart_list = false;
            if($cart){
                $cart_update = $cart;
                
                //Update cart to avoid cart expiration
                unset($cart_update['Cart']['created']);
                unset($cart_update['Cart']['updated']);
                $result = $Cart->save($cart_update);
                
                $cart_id = $cart['Cart']['id'];
    
                $cart_list = $CartItem->getByCartId($cart_id);
    
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
        $this->redirect('/messages/index');
        exit;

        $this->response->disableCache();

        $this->isLogged();
        $user_id = $this->getLoggedUserID();
        if($user_id){
            $Cart = ClassRegistry::init('Cart');
            $cart = $Cart->getExistingUserCart($user_id);
            if($cart){
                $cart_id = $cart['Cart']['id'];
            }
            else{
                $this->redirect('/closet');
                exit;
            }


            $data = array();
            $products = array();

            $CartItem = ClassRegistry::init('CartItem');
            $Entity = ClassRegistry::init('Entity');
            $User = ClassRegistry::init('User');
            $BillingAddress = ClassRegistry::init('BillingAddress');
            $cart = $Cart->getExistingUserCart($user_id);
            
            if(!$cart){
                $this->redirect('/cart');
                exit;    
            }
            
            $cart_id = $cart['Cart']['id'];

            $cart_list = $CartItem->getByCartId($cart_id);
            $cart_update = $cart;
            
            //Update cart to avoid cart expiration
            unset($cart_update['Cart']['created']);
            unset($cart_update['Cart']['updated']);
            $result = $Cart->save($cart_update);

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
            $user = $User->findById($user_id);
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
            $country_list = array('USA' => 'USA', 'Canada' => 'Canada');
            $this->request->data = $data;
            
            if(!$cart_list){
                $this->redirect('/cart');
                exit;
            }
                       
            $this->set(compact('cart_list', 'cart_id', 'country_list', 'user'));
        }
    }
    
    public function payment() {
        $this->redirect('/messages/index');
        exit;

        $this->response->disableCache();
        //TODO: beforerender for not displaying page again.
        $this->isLogged();
        $user_id = $this->getLoggedUserID();
        if($user_id){

            //Initialize classes
            $Cart = ClassRegistry::init('Cart');
            $CartItem = ClassRegistry::init('CartItem');
            $Entity = ClassRegistry::init('Entity');

            $cart = $Cart->getExistingUserCart($user_id);
            if($cart){
                $cart_id = $cart['Cart']['id'];    
            }
            else{
                $this->Session->setFlash(__('There was a problem in processing the request. Please try again.'), 'flash');
                $this->redirect('/cart');
                exit;
            }
            
            
            $user = $this->getLoggedUser();
            $error_billing = false;
            $error_shipping = false;
            $error_transaction = false;
            $error_cart = false;
            $error = false;
            
            $request_data = $this->request->data['billing'];
            
            if(isset($request_data['promocode'])){
                $promo_code = strtoupper($request_data['promocode']);
            }
            else{
                $promo_code = "";
            }
            //Arrange Billing data
            $data['User']['first_name'] = $request_data['billfirst_name'];
            $data['User']['last_name'] = $request_data['billlast_name'];
            $data['BillingAddress']['company'] = $request_data['billcompany'];
            $data['BillingAddress']['address'] = $request_data['billaddress'];
            $data['BillingAddress']['city'] = $request_data['billcity'];
            $data['BillingAddress']['state'] = $request_data['billstate'];
            $data['BillingAddress']['country'] = $request_data['billcountry'];
            $data['BillingAddress']['zip'] = $request_data['billzip'];
            $data['BillingAddress']['phone'] = $request_data['billphone'];
            
            
            // Arrange shipping data
            if(isset($request_data['copybilling']) && $request_data['copybilling'] == 1){
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
                $data['ShippingAddress']['first_name'] = $request_data['shipfirst_name'];
                $data['ShippingAddress']['last_name'] = $request_data['shiplast_name'];
                $data['ShippingAddress']['company'] = $request_data['shipcompany'];
                $data['ShippingAddress']['address'] = $request_data['shipaddress'];
                $data['ShippingAddress']['city'] = $request_data['shipcity'];
                $data['ShippingAddress']['state'] = $request_data['shipstate'];
                $data['ShippingAddress']['country'] = $request_data['shipcountry'];
                $data['ShippingAddress']['zip'] = $request_data['shipzip'];
            }
            
            // Arrange transaction data
            $user_transaction_detail = array();
            $user_transaction_detail['CreditCard']['cardnumber'] = $request_data['billcardnumber'];
            $user_transaction_detail['CreditCard']['cardcode'] = $request_data['billcardcode'];
            $user_transaction_detail['CreditCard']['expiry_month'] = intval($request_data['exp']['month']);
            $user_transaction_detail['CreditCard']['expiry_year'] = intval($request_data['exp']['year']);
            
            // Validate Credit Card Info
            $CreditCard = ClassRegistry::init('CreditCard');
            $CreditCard->set($user_transaction_detail);
            if(!$CreditCard->validates()){
                $error_transaction = true;
            }
            if($user_transaction_detail['CreditCard']['expiry_year'] < intval(date('Y')) || $user_transaction_detail['CreditCard']['expiry_year'] >= intval(date('Y', strtotime('+10 year'))) ){
                $error_transaction = true;
            }
            
            // Validate Shipping Data
            $ShippingAddress = ClassRegistry::init('ShippingAddress');
            $ShippingAddress->set($data);
            if(!$ShippingAddress->validates()){
                $error_shipping = true;
            }
            
            // Validate Billing Data
            $BillingAddress = ClassRegistry::init('BillingAddress');
            $BillingAddress->set($data);
            if(!$BillingAddress->validates()){
                $error_billing = true;
            }

            // Get cart data and calculate total price
            $request_cart_id = $this->request->data['checkout-cart-id'];
            $request_total_price = $this->request->data['checkout-total-price'];

            $cart_list = $CartItem->getByCartId($cart_id);

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

            $total_price = 0.00;
            foreach($cart_list as $row){
                $total_price = $total_price + ($row['Entity']['price'] * $row['CartItem']['quantity']);
            }

            //Check if cart id is same
            if($request_cart_id != $cart_id){
                $error_cart = true;
            }

            if(isset($this->request->data['vip-discount'])){
                $promo_code = ""; 
                $discount = 50;
                $discounted_price = $total_price - $discount;
                if($request_total_price != $discounted_price){
                    $error_cart = true;
                } 
                $final_price = $discounted_price;
            }
            else{
                //Check if promocode is valid
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
                            
                            $discount = floor($promo_result['amount'] * $total_price / 100);  
                            $discounted_price = $total_price - $discount;
                            if($request_total_price != $discounted_price){
                                $error_cart = true;
                            }    
                            $final_price = $discounted_price;    
                        }
                        else{
                            $discount = $promo_result['amount'];  
                            $discounted_price = $total_price - $discount;
                            if($request_total_price != $discounted_price){
                                $error_cart = true;
                            }    
                            $final_price = $discounted_price;    
                        }
                    }   
                    else{
                        $this->Session->setFlash(__('The promo code used is not valid.'), 'flash');
                        $this->redirect('/checkout');
                    } 
                }
                else{
                    if($request_total_price != $total_price){
                        $error_cart = true;
                    }    
                    $final_price = $total_price;
                }
            }

            
            if($error_billing || $error_cart || $error_shipping || $error_transaction){
                $error = true;
                $this->Session->write('transaction_complete', "fail");
                // $this->Session->setFlash(__('Input'), 'flash');
            }
            
            //Add or update billing address
            if(!$this->updateBillingAddress($data, $user_id)){
                // TODO: if billing address could not be saved.
                $error = true;
                $this->Session->write('transaction_complete', "fail");
                // $this->Session->setFlash(__('Billing'), 'flash');
            }

            //Add order
            if($discount){
                $order_id = $this->addOrder($cart_list, $total_price, $promo_code, $discount, $discounted_price);
            }
            else{
                $order_id = $this->addOrder($cart_list, $total_price);
            }
            
            //Add shipping address
            $data['ShippingAddress']['order_id'] = $order_id;
            $data['ShippingAddress']['user_id'] = $user_id;
            $ShippingAddress->create();
            if(!$ShippingAddress->save($data)){
                // TODO: if shipping address could not be saved.
                $error = true;
                $this->Session->write('transaction_complete', "fail");
                // $this->Session->setFlash(__('Shipping'), 'flash');
            }
            
            //If all order data has been added. Continue transaction.
            $transaction_data['card_num'] = $user_transaction_detail['CreditCard']['cardnumber'];
            $transaction_data['card_code'] = $user_transaction_detail['CreditCard']['cardcode'];
            $transaction_data['card_expiry'] = $user_transaction_detail['CreditCard']['expiry_month'] . $user_transaction_detail['CreditCard']['expiry_year'];
            $transaction_data['total'] = $final_price;
            $transaction_data['order_id'] = $order_id;
            $transaction_data['user_id'] = $user_id;
            $transaction_data['card_num'] = $user_transaction_detail['CreditCard']['cardnumber'];
            $transaction_data['card_code'] = $user_transaction_detail['CreditCard']['cardcode'];
            $transaction_data['card_expiry'] = $user_transaction_detail['CreditCard']['expiry_month'] . $user_transaction_detail['CreditCard']['expiry_year'];
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
    
    public function sendConfirmationEmail($id = null){
        $this->redirect('/messages/index');
        exit;

        $Order = ClassRegistry::init('Order');
        if (!$Order->exists($id)) {
            throw new NotFoundException(__('Invalid order'));
        }    
        
        $options = array('conditions' => array('Order.' . $Order->primaryKey => $id));
        $order = $Order->find('first', $options);
        $order['Order']['confirmed'] = 1;
        if($Order->save($order)){
            
            //Send confirmation email to the customer.
            $Order->recursive = 3;
            $Order->OrderItem->unbindModel(array('belongsTo' => array('Order')));
            $Order->OrderItem->Entity->unbindModel(array('hasMany' => array('Detail', 'Wishlist', 'Like', 'OrderItem', 'CartItem'), 'hasAndBelongsToMany' => array('Color'), 'belongsTo' => array('Product')));
            $Order->User->unbindModel(array('hasOne' => array('BillingAddress'), 'belongsTo' => array('UserType'), 'hasMany' => array('Comment', 'Post', 'Wishlist', 'Message', 'Order')));
            $options = array('conditions' => array('Order.' . $Order->primaryKey => $id));
            $shipped_order = $Order->find('first', $options);
            $Size = ClassRegistry::init('Size');
            $sizes = $Size->find('list');
            
            if($shipped_order['User']['email']){
                try{
                    /*
                    $email = new CakeEmail('default');
                    $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                    $email->to($shipped_order['User']['email']);
                    $email->bcc('admin@savilerowsociety.com');
                    $email->subject('Purchase Complete.');
                    $email->template('purchased');
                    $email->emailFormat('html');
                    $email->viewVars(compact('shipped_order','sizes'));
                    $email->send();
                    */
                    
                    $email = new CakeEmail('default');
                    $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                    $email->to($shipped_order['User']['email']);
                    $email->subject('Your order transaction is complete.');
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
        $this->redirect('/messages/index');
        exit;

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
        $this->redirect('/messages/index');
        exit;

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
    
    public function addOrder($cart_items, $total_price, $promo_code = false, $discount = false, $discounted_price = false){
        $this->redirect('/messages/index');
        exit;

        $user_id = $this->getLoggedUserID();
        $data = array();
        if($user_id){
            $transaction_error = false;
            $data['Order']['orderid'] = uniqid();
            $data['Order']['user_id'] = $user_id;  
            $data['Order']['total_price'] = $total_price;
            $data['Order']['final_price'] = $total_price; 
            $data['Order']['paid'] = 0;    
            $data['Order']['confirmed'] = 0;
            $data['Order']['shipped'] = 0;  
            
            if($promo_code !== false){
                $data['Order']['final_price'] = $discounted_price; 
                $data['Order']['promo_discount'] = $discount;
                $data['Order']['promo_code'] = $promo_code;   
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
                foreach($cart_items as $row){
                    $data['OrderItem'] = array();
                    $data['OrderItem']['order_id'] = $result['Order']['id'];
                    $data['OrderItem']['product_entity_id'] = $row['Entity']['id'];
                    $data['OrderItem']['quantity'] = $row['CartItem']['quantity'];
                    $data['OrderItem']['size_id'] = $row['CartItem']['size_id'];
                    $data['OrderItem']['price'] = $row['Entity']['price'];
                    
                    //Check if item is a gift item
                    if($row['Entity']['is_gift'] != "" && $row['Entity']['is_gift'] == 1){
                        $data['OrderItem']['is_gift'] = 1;
                    }
                    
                    $OrderItem->create();
                    $item_result = $OrderItem->save($data);
                    if($item_result){
                        // if($data['OrderItem']['is_gift'] == 1){
                        //     $gift_details = $CartGiftItem->getGiftCardDetails($row['CartItem']['id']);
                        //     $gift_card_uniqid = 'SRS-Gift-' . uniqid();
                            
                        //     $data['OrderGiftItem']['order_item_id'] = $item_result['OrderItem']['id'];
                        //     $data['OrderGiftItem']['recipient_email'] = $gift_details['CartGiftItem']['recipient_email'];
                        //     $data['OrderGiftItem']['recipient_name'] = $gift_details['CartGiftItem']['recipient_name'];
                        //     $data['OrderGiftItem']['message'] = $gift_details['CartGiftItem']['message'];
                        //     $data['OrderGiftItem']['gift_card_uniqid'] = $gift_card_uniqid;
                            
                        //     $OrderGiftItem->create();
                        //     $OrderGiftItem->save($data);    
                        // }    
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
        $this->redirect('/messages/index');
        exit;

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
        $this->redirect('/messages/index');
        exit;

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
        $this->redirect('/messages/index');
        exit;

        $Detail = ClassRegistry::init('Detail');

        foreach($cart_list as $row){
            $Detail->removeFromStock($row['CartItem']['product_entity_id'], $row['CartItem']['size_id'], $row['CartItem']['quantity']);
        }
    }

    function removeLikes($entity_list, $user_id){
        $this->redirect('/messages/index');
        exit;

        $Wishlist = ClassRegistry::init('Wishlist');
        $Wishlist->remove($user_id, $entity_list);
    }
    
    public function checkOrderGiftCard($order_id){
        $this->redirect('/messages/index');
        exit;

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

    /**
     * Liked Items
     */
    public function liked($id = null) {
        $this->redirect('/messages/index');
        exit;

        $this->isLogged();
        if($id){
            $user_id = $id;
            $User = ClassRegistry::init('User');
            $user_data = $User->find('first', array('conditions'=>array('User.id' => $user_id)));
            $logged_user_id = $this->getLoggedUserID();
            $logged_user = $this->getLoggedUser();
            if($user_data){
                
            }
            else{
                $this->redirect('liked');
                exit;
            }
            if($user_data['User']['stylist_id'] != $logged_user_id && $user_id != $logged_user_id &&  !$logged_user['User']['is_admin']){
                $this->redirect('liked');
                exit;
            }
        }
        else{
            $user_id = $this->getLoggedUserID();
        }
        
        // init
        $Wishlist = ClassRegistry::init('Wishlist');
        $Entity = ClassRegistry::init('Entity');
        // get data
        $wish_list = $Wishlist->getByUserID($user_id);
        //$wishlists = $Entity->getEntitiesById($wish_list);
        
        $find_array = array(
            'limit' => 15,
            'contain' => array('Image', 'Color'),
            'conditions' => array(
                'Entity.show' => true,
                'Wishlist.user_id' => $user_id,
            ),
            'joins' => array(
                array('table' => 'wishlists',
                    'alias' => 'Wishlist',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Wishlist.product_entity_id = Entity.id'
                    )
                )
            ),
            'fields' => array(
                'Entity.*', 'Wishlist.*'
            ),
            'order' => 'Wishlist.id DESC'
        );
        
        $Entity->recursive = 0;
        $this->Paginator->settings = $find_array;
        try{
            $wishlists = $this->Paginator->paginate($Entity);
        }
        catch(Exception $e){
            $this->redirect('/mycloset/liked');    
        }
        
        // send data to view
        $this->set(compact('wishlists', 'user_id'));
        
        $this->render('wishlist');
    }
    
    /**
     * Purchased Items
     */
    public function purchased($id = null) {
        $this->redirect('/messages/index');
        exit;

        $this->isLogged();
        
        if($id){
            $user_id = $id;
            $User = ClassRegistry::init('User');
            $user_data = $User->find('first', array('conditions'=>array('User.id' => $user_id)));
            $logged_user_id = $this->getLoggedUserID();
            $logged_user = $this->getLoggedUser();
            if($user_data){
            }
            else{
                $this->redirect('purchased');
                exit;
            }
            
            if($user_data['User']['stylist_id'] != $logged_user_id && $user_id != $logged_user_id &&  !$logged_user['User']['is_admin']){
                $this->redirect('purchased');
                exit;
            }
        }
        else{
            $user_id = $this->getLoggedUserID();
        }
        // init
        $OrderItem = ClassRegistry::init('OrderItem');
        $Entity = ClassRegistry::init('Entity');
        $Size = ClassRegistry::init('Size');
        
        $sizes = $Size->find('list'); 

        $find_array = array(
            'limit' => 15,
            'joins' => array(
                array('table' => 'orders',
                    'alias' => 'Order',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Order.id = OrderItem.order_id'
                    )
                ),
                array('table' => 'products_entities',
                    'alias' => 'Entity',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Entity.id = OrderItem.product_entity_id'
                    )
                ),
                array('table' => 'products_categories',
                    'alias' => 'PCategory',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Entity.product_id = PCategory.product_id'
                    )
                )
            ),
            'conditions' => array('Order.paid' => true, 'Order.user_id' => $user_id),
            'fields' => array('OrderItem.*'),
        );

        $this->Paginator->settings = $find_array;
        $purchased_list = $this->Paginator->paginate($OrderItem);
        
        $entity_list = array();
        foreach($purchased_list as $item){
            $entity_list[] = $item['OrderItem']['product_entity_id'];
        }
        
        if($entity_list){
            $entities = $Entity->getEntitiesById($entity_list, $user_id);  
        }
        foreach($purchased_list as &$row){
            for($i=0; $i < count($entities); $i++){
                if($row['OrderItem']['product_entity_id'] == $entities[$i]['Entity']['id']){
                    $row['Entity'] = $entities[$i]['Entity'];
                    $row['Image'] = $entities[$i]['Image'];
                    $row['Color'] = $entities[$i]['Color'];
                }     
            }            
        }
        
        
        $this->set(compact('purchased_list', 'sizes', 'user_id'));
        
    }
}
