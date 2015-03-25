<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class OutfitsController extends AppController {

    var $uses = null;

    function beforeFilter() {
        parent::beforeFilter();
        if ($this->request->is('ajax')) {
            $this->Components->unload('Security');
        }
    }
    
    public function getPurchasedItems($last_purchased_id = null){
        $logged_user_id = $this->getLoggedUserID();
        $user_id = $this->request->data['client_id'];
        $ret = array();
        if(is_null($last_purchased_id)){
            $ret['status'] = "error";    
        }    
        else if($logged_user_id && $last_purchased_id >= 0 && $user_id){
            $OrderItem = ClassRegistry::init('OrderItem');
            $Entity = ClassRegistry::init('Entity'); 
            $total_purchases = $OrderItem->getTotalUserPurchaseCount($user_id);
            if($total_purchases > 0){
                $order_item_list = $OrderItem->getUniqueUserItems($user_id, $last_purchased_id);
                $last_item_id = $last_purchased_id;
                $entity_list = array();
                foreach($order_item_list as $value){
                    $entity_list[] = $value['Orders']['product_entity_id'];
                    $last_item_id = $value['Orders']['order_id'];
                }
                $entities = $Entity->getProductDetails($entity_list, $user_id);
                if($entities){
                    $ret['status'] = "ok";
                    $ret['data'] = $entities;
                    $ret['total'] = $total_purchases; 
                    $ret['last_purchased_id'] = $last_item_id;   
                }
                else{
                    $ret['status'] = "end";        
                }
            }
            else{
                $ret['status'] = "ok";
                $ret['total'] = $total_purchases; 
            }
        }
        else{
            $ret['status'] = "error";    
        }
        
        echo json_encode($ret);
        exit;
    }
    
    public function getLikedItems($last_liked_id = null){
        $logged_user_id = $this->getLoggedUserID();
        $user_id = $this->request->data['client_id'];
        $ret = array();
        if(is_null($last_liked_id)){
            $ret['status'] = "error";    
        }    
        else if($logged_user_id && $last_liked_id >= 0 && $user_id){
            $Wishlist = ClassRegistry::init('Wishlist');
            $Entity = ClassRegistry::init('Entity'); 
            $total_likes = $Wishlist->find('count', array('conditions' => array('Wishlist.user_id'=>$user_id)));
            
            if($total_likes > 0){
               $liked_list = $Wishlist->getUserLikedItems($user_id, $last_liked_id, 10);
               $last_item_id = $last_liked_id;
                $entity_list = array();
                foreach($liked_list as $value){
                    $entity_list[] = $value['Wishlist']['product_entity_id'];
                    $last_item_id = $value['Wishlist']['id'];
                }
                
                $entities = $Entity->getProductDetails($entity_list, $user_id);
                if($entities){
                    $ret['status'] = "ok";
                    $ret['data'] = $entities;
                    $ret['total'] = $total_likes; 
                    $ret['last_liked_id'] = $last_item_id;   
                }
                else{
                    $ret['status'] = "end";        
                }
            }
            else{
                $ret['status'] = "ok";
                $ret['total'] = $total_likes; 
            }
        }
        else{
            $ret['status'] = "error";    
        }
        
        echo json_encode($ret);
        exit;    
    }
    
    //bhashit code

    public function getfavoritesItems($last_liked_id = null){
        $logged_user_id = $this->getLoggedUserID();
        $ret = array();
        if(is_null($last_liked_id)){
            $ret['status'] = "error";    
        }    
        else if($logged_user_id && $last_liked_id >= 0 ){
            $Wishlist = ClassRegistry::init('Wishlist');
            $Entity = ClassRegistry::init('Entity'); 
            $total_likes = $Wishlist->find('count', array('conditions' => array('Wishlist.user_id'=>$logged_user_id)));
            
            if($total_likes > 0){
               $liked_list = $Wishlist->getUserLikedItems($logged_user_id, $last_liked_id, 10);
               $last_item_id = $last_liked_id;
                $entity_list = array();
                foreach($liked_list as $value){
                    $entity_list[] = $value['Wishlist']['product_entity_id'];
                    $last_item_id = $value['Wishlist']['id'];
                }
                
                $entities = $Entity->getProductDetails($entity_list, $logged_user_id);
                if($entities){
                    $ret['status'] = "ok";
                    $ret['data'] = $entities;
                    $ret['total'] = $total_likes; 
                    $ret['last_liked_id'] = $last_item_id;   
                }
                else{
                    $ret['status'] = "end";        
                }
            }
            else{
                $ret['status'] = "ok";
                $ret['total'] = $total_likes; 
            }
        }
        else{
            $ret['status'] = "error";    
        }
        
        echo json_encode($ret);
        exit;  

    }

//bhashit code


    public function getClosetItems(){
        $ret = array();
        $user_id = $this->getLoggedUserID();
        if($user_id){
            $filter_brand = $this->request->data['str_brand'];
            $filter_color = $this->request->data['str_color'];
            $last_closet_item = $this->request->data['last_closet_item'];
            $category_slug = $this->request->data['category_slug'];

            $Category = ClassRegistry::init('Category');
            $categories = $Category->getAll();
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
            
            
            

            $brand_list = array();
            if($filter_brand && $filter_brand != "none"){
                $brand_list = explode('-', $filter_brand);
                $brand_list = array_values(array_unique($brand_list));
            }

            // Prepare the color filter data
            $color_list = array();
            if($filter_color){
                $color_list = explode('-', $filter_color);
                $color_list = array_values(array_unique($color_list));
            }

            // Find array for products of a category excluding the filter and brand sub categories
            $find_array = array(
                'limit' => 12,
                'contain' => array('Image', 'Color'),
                'conditions' => array(
                    'Entity.show' => true, 'Entity.id >' => $last_closet_item,
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
                ),
                'fields' => array(
                    'Entity.*','Product.*', 'Brand.*'
                ),
                'order' => array('Entity.id' => 'ASC'),
                'Group' => array('Entity.id'),
            );
        
            if($category_slug != 'all'){
                $find_array['conditions']['Category.category_id'] = $category_ids;
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


            $Entity = ClassRegistry::init('Entity');
            $data = $Entity->find('all', $find_array);

            if($data){
                foreach($data as $row){
                    $last_closet_item = $row['Entity']['id'];
                }
                $ret['last_closet_item'] = $last_closet_item;
                $ret['status'] = "ok";
                $ret['data'] = $data;
            }
            else{
                $ret['status'] = "end";
            }
        }
        else{
            $ret['status'] = "error";
        }

        echo json_encode($ret);
        exit;
    }
    
    function postOutfit(){
        $ret = array();
        $user_id = $this->getLoggedUserID();
        if($user_id){
            $Entity = ClassRegistry::init('Entity');
            $Post = ClassRegistry::init('Post');
            $User = ClassRegistry::init('User');

            $client_id = $this->request->data['user_id'];
            $client = $User->findById($client_id);
            $stylist_id = $this->request->data['stylist_id'];
            $reuse_outfit_id = (isset($this->request->data['outfit_id']) && $this->request->data['outfit_id'] != "") ? $this->request->data['outfit_id'] : false;

            if($user_id != $stylist_id){
                $ret['status'] = "error";
                $ret['message'] = "Invalid Stylist";
                echo json_encode($ret);
                exit;   
            }
            else if(!$client){
                $ret['status'] = "error";
                $ret['message'] = "Invalid User";
                echo json_encode($ret);
                exit;      
            }
            else if($client['User']['stylist_id'] != $stylist_id){
                $ret['status'] = "error";
                $ret['message'] = "Invalid Stylist";
                echo json_encode($ret);
                exit;  
            }

            $outfit_items = $this->request->data['outfit_items'];

            if(!count($outfit_items)){
                $ret['status'] = "error";
                $ret['message'] = "No product selected.";
                echo json_encode($ret);
                exit;     
            }
            else{
                $this->request->data['Post']['user_id'] = $stylist_id;
                $this->request->data['Post']['is_outfit'] = '1';
                $post = $Post->save($this->request->data);

                $Outfit = ClassRegistry::init('Outfit');
                $OutfitItem = ClassRegistry::init('OutfitItem');
                $Message = ClassRegistry::init('Message');

                if($reuse_outfit_id){
                    $outfit_id = $reuse_outfit_id;
                    $data['Message']['user_to_id'] = $client_id;
                    $data['Message']['user_from_id'] = $stylist_id;
                    $data['Message']['body'] = (isset($this->request->data['comments']) && $this->request->data['comments']) ? $this->request->data['comments'] : "";
                    $data['Message']['is_outfit'] = 1;
                    $data['Message']['outfit_id'] = $outfit_id;
                    $data['Message']['post_id'] = $post['Post']['id'];

                    $Message->create();
                    $Message->save($data);

                    $this->sendOutfitNotification($outfit_id, $client_id);
                }
                else{
                    $outfit = array();
                    $outfit['Outfit']['user_id'] = $client_id;
                    $outfit['Outfit']['stylist_id'] = $stylist_id;
                    $outfit['Outfit']['outfit_name'] = $this->request->data['outfit_name'];

                    $Outfit->create();
                    if($result = $Outfit->save($outfit)){
                        $outfit_id = $result['Outfit']['id'];
                        $data = array();
                        
                        foreach($outfit_items as $key => $value){
                            $data['OutfitItem'] = array('outfit_id' => $outfit_id, 'product_entity_id' => $value['product_entity_id'], 'size_id' => $value['size_id']);

                            $OutfitItem->create();
                            $OutfitItem->save($data);
                        }

                        $data['Message']['user_to_id'] = $client_id;
                        $data['Message']['user_from_id'] = $stylist_id;
                        $data['Message']['body'] = (isset($this->request->data['comments']) && $this->request->data['comments']) ? $this->request->data['comments'] : "";
                        $data['Message']['is_outfit'] = 1;
                        $data['Message']['outfit_id'] = $outfit_id;
                        $data['Message']['post_id'] = $post['Post']['id'];

                        $Message->create();
                        $Message->save($data);

                        $this->sendOutfitNotification($outfit_id, $client_id);

                    }   
                }
                
                
            }

            $ret['status'] = 'ok';
        }
        else{
            $ret['status'] = "redirect";
        }

        echo json_encode($ret);
        exit;    
    }
    
    public function sendOutfitNotification($outfit_id, $client_id){
        
        $User = ClassRegistry::init('User');
        $Entity = ClassRegistry::init('Entity');
        $client = $User->getByID($client_id);
        $stylist = $User->getByID($client['User']['stylist_id']);
        
        if($client){
            try{
                $email = new CakeEmail('default');
                $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                $email->replyTo(array($stylist['User']['email'] => 'Savile Row Society'));
                $email->to($client['User']['email']);
                $email->subject('Stylist Recommended Outfit');
                $email->template('new_outfit');
                $email->emailFormat('html');
                $email->viewVars(compact('client', 'outfit_id', 'stylist'));
                $email->send();
            }
            catch(Exception $e){
                
            }
        }
    }



    public function create($clientid=null) {
        $this->isLogged();
        
        $User = ClassRegistry::init('User');
        $user = $this->getLoggedUser();
        $client = $User->findById($clientid);

        $user_id = $user['User']['id'];
        $stylist_id = $client['User']['id'];

        if($client){
            if($user['User']['id'] != $client['User']['stylist_id']){
                $this->redirect('/messages/feed');
                exit;
            }
        }
        else{
            $this->redirect('/messages/feed');
            exit;
        }

        if(isset($this->request->query['reuse'])){
            $outfit_id = $this->request->query['reuse'];
            $Outfit = ClassRegistry::init('Outfit');

            $outfit = $Outfit->getOutfitDetails($outfit_id);

            if($outfit && $outfit[$outfit_id]['Outfit']['stylist_id'] == $user_id){
                $outfit = $outfit[$outfit_id];

                $this->set(compact('outfit'));
            }
            else{
                $this->redirect('/outfits/create/' . $clientid);
                exit;
            }
        }

        // init
        $Category = ClassRegistry::init('Category');
        $Brand = ClassRegistry::init('Brand');
        $Color = ClassRegistry::init('Color');
        $Colorgroup = ClassRegistry::init('Colorgroup');
        $User = ClassRegistry::init('User');
        $Entity = ClassRegistry::init('Entity');
        $Size = ClassRegistry::init('Size');

        $categories = $Category->getAll();
        $brands = $Brand->find('all', array('order' => "Brand.name ASC"));
        $colors = $Colorgroup->find('all', array('order' => "Colorgroup.name ASC"));
        $sizes = $Size->find('list');

        $entities = array();
        
        $limit = 21;
        $filter_brand = isset($this->request->data['str_brand']) ? $this->request->data['str_brand']: '';
        $filter_color = isset($this->request->data['str_color']) ? $this->request->data['str_color']: '';
        $filter_category = isset($this->request->data['str_category']) ? $this->request->data['str_category']: '';
        $search_text = isset($this->request->data['search_text']) ? strtolower($this->request->data['search_text']): '';
        $page = isset($this->request->data['page']) ? $this->request->data['page']: 1;
        $sort = isset($this->request->data['sort']) ? $this->request->data['sort'] : 'id';
        $client_id = isset($this->request->data['user_id']) ? $this->request->data['user_id'] : 0;

        if($client_id > 0){
            $user_stylist = $User->findById($client_id);

            if($user_stylist && ($user_id == $client_id || $user_stylist['User']['stylist_id'] == $user_id)){
                //user is corrct.
            }
            else{
                if($this->request->is('ajax')){
                    $ret['status'] = 'redirect';
                    echo json_encode($ret);
                    exit;
                }    
            }
        }

        $brand_list = array();
        if($filter_brand && $filter_brand != "none"){
            $brand_list = explode('-', $filter_brand);
            $brand_list = array_values(array_unique($brand_list));
        }

        $color_list = array();
        if($filter_color){
            $color_list = explode('-', $filter_color);
            $color_list = array_values(array_unique($color_list));
        }

        $category_list = array();
        if($filter_category){
            $category_list = explode('-', $filter_category);
            $category_list = array_values(array_unique($category_list));
            $category_list = $Category->getAllCategories($category_list);
        }

        $find_array = array(
                'limit' => $limit,
                'page'  => $page,
                'contain' => array('Image', 'Color', 'Detail'),
                'conditions' => array(
                    'Entity.show' => true
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
                ),
                'fields' => array(
                    'Entity.*','Product.*', 'Brand.*'
                ),
            );

        $find_array['joins'][] = array('table' => 'wishlists',
                'alias' => 'Wishlist',
                'type' => 'LEFT',
                'conditions' => array(
                    'Wishlist.user_id' => $user_id,
                    'Wishlist.product_entity_id = Entity.id'
                )
            );
        $find_array['fields'][] = 'Wishlist.*'; 

        if($sort == 'pricedesc'){
            $find_array['order'] = array('Entity.price' => 'desc');
        }
        else if($sort == 'priceasc'){
            $find_array['order'] = array('Entity.price' => 'asc');
        }
        else{
            $find_array['order'] = array('Entity.id' => 'desc');   
        }
        
        //Category filter
        if($category_list && count($category_list) > 0){

            $find_array['conditions']['Category.category_id'] = $category_list;    
        }
        
        // Color filter
        if($color_list && count($color_list) > 0){
            
            $color_data = $Colorgroup->getColors($color_list);
            if($color_data){
                foreach($color_data as $color_item){
                    $color_ids[] = $color_item['ColorItems']['color_id'];
                }
            }
            
            if(isset($color_ids) && $color_ids && count($color_ids) > 0){
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

        // Search Filter
        if($search_text != ''){
            $find_array['conditions']['OR'] = array(
                array('LOWER(Brand.name) LIKE' => '%' . $search_text . '%'),
                array('LOWER(Entity.name) LIKE' => '%' . $search_text . '%'),
                array('LOWER(Entity.description) LIKE' => '%' . $search_text . '%'),
                );
        }

        
        $entities = $Entity->find('all', $find_array);

        $this->set(compact('categories','brands','colors', 'entities', 'user', 'client', 'sizes', 'user_id', 'stylist_id', 'page'));
    
        if($this->request->is('ajax')){
            $this->layout = false;
            $this->render = false;
            $ret = array();

            if(count($entities)){
                $ret['status'] = 'ok';
                $ret['entities'] = $entities;
            }
            else{
                $ret['status'] = 'error';
                $ret['entities'] = array();
            }

            echo json_encode($ret);
            exit;
        }
    }   


}

