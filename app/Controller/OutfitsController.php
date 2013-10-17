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
                $liked_list = $Wishlist->getUserLikedItems($user_id, $last_liked_id);
                
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
    
    public function getClosetItems(){
        $ret = array();
        $user_id = $this->getLoggedUserID();
        if($user_id){
            $filter_brand = $this->request->data['str_brand'];
            $filter_color = $this->request->data['str_color'];
            $last_closet_item = $this->request->data['last_closet_item'];
            $category_slug = $this->request->data['category_slug'];

            $Category = ClassRegistry::init('Category');
            $category_id = $Category->getAllBySlug($category_slug);

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
                'limit' => 10,
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
                            'Category.category_id' => $category_id,
                            'Category.product_id = Entity.product_id'
                        )
                    ),
                ),
                'fields' => array(
                    'Entity.*'
                ),
                'Order' => array('Entity.id ASC'),
                'Group' => array('Entity.id'),
            );

            // Color filter
            if($color_list && count($color_list) > 0){
                $color_join = array('table' => 'colors_entities',
                    'alias' => 'Color1',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Color1.color_id' => $color_list,
                        'Color1.product_entity_id = Entity.id'
                    )
                );
                $find_array['joins'][] = $color_join;
            }

            // Brand Filter
            if($brand_list && count($brand_list) > 0){
                $brand_join = array('table' => 'products',
                    'alias' => 'Product',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.brand_id' => $brand_list,
                        'Product.id = Entity.product_id'
                    )
                );
                $find_array['joins'][] = $brand_join;
            }

            // Sub query to check stock using the products_details table and the items already added to valid carts
            //$sub_query = new stdClass();
//            $sub_query->type = "expression";
//            $sub_query->value = "Detail.show = 1 AND Detail.stock > (SELECT COALESCE(sum(Item.quantity),0) as usedstock FROM carts_items Item INNER JOIN carts Cart ON Item.cart_id = Cart.id WHERE Cart.updated > (now() - INTERVAL 1 DAY) AND Item.product_entity_id = Entity.id AND Detail.size_id = Item.size_id) ";
//            $find_array['conditions'][] = $sub_query;

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
            $client_id = $this->request->data['user_id'];
            $outfit_id1 = $this->request->data['outfit1'];    
            $outfit_id2 = $this->request->data['outfit2'];  
            $outfit_id3 = $this->request->data['outfit3'];  
            $outfit_id4 = $this->request->data['outfit4'];  
            $outfit_id5 = $this->request->data['outfit5'];
            $data['Outfit']['user_id'] = $client_id;
            $data['Outfit']['stylist_id'] = $user_id;
            
            $outfit_array = array($outfit_id1, $outfit_id2, $outfit_id3, $outfit_id4, $outfit_id5);
            $outfit_array = array_unique($outfit_array);
            
            if(count($outfit_array) == 5){
                $Outfit = ClassRegistry::init('Outfit');
                $OutfitItem = ClassRegistry::init('OutfitItem');
                $Outfit->create();
                if($result = $Outfit->save($data)){
                    $outfit_id = $result['Outfit']['id'];
                    $data1['OutfitItem']['outfit_id'] = $outfit_id;
                    $data1['OutfitItem']['product_entity_id'] = $outfit_id1;
                    $OutfitItem->create();
                    $OutfitItem->save($data1);
                    
                    $data2['OutfitItem']['outfit_id'] = $outfit_id;
                    $data2['OutfitItem']['product_entity_id'] = $outfit_id2;
                    $OutfitItem->create();
                    $OutfitItem->save($data2);
                    
                    
                    $data3['OutfitItem']['outfit_id'] = $outfit_id;
                    $data3['OutfitItem']['product_entity_id'] = $outfit_id3;
                    $OutfitItem->create();
                    $OutfitItem->save($data3);
                    
                    
                    $data4['OutfitItem']['outfit_id'] = $outfit_id;
                    $data4['OutfitItem']['product_entity_id'] = $outfit_id4;
                    $OutfitItem->create();
                    $OutfitItem->save($data4);
                    
                    
                    $data5['OutfitItem']['outfit_id'] = $outfit_id;
                    $data5['OutfitItem']['product_entity_id'] = $outfit_id5;
                    $OutfitItem->create();
                    $OutfitItem->save($data5);
                    
                    $Message = ClassRegistry::init('Message');
                    $data['Message']['user_to_id'] = $client_id;
                    $data['Message']['user_from_id'] = $user_id;
                    $data['Message']['body'] = 'outfit';
                    $data['Message']['is_outfit'] = 1;
                    $data['Message']['outfit_id'] = $outfit_id;
                    $Message->create();
                    if ($Message->validates()) {
                        $Message->save($data);
                        $entity_list = array($outfit_id1, $outfit_id2, $outfit_id3, $outfit_id4, $outfit_id5);
                        $this->sendOutfitNotification($entity_list, $client_id);
                    }
                    
                    $ret['status'] = "ok";
                }  
            }
            else{
                $ret['status'] = "error";
                $ret['msg'] = "Select 5 distinct items to create an outfit.";    
            }
        }
        else{
            $ret['status'] = "redirect";
        }

        echo json_encode($ret);
        exit;    
    }
    
    public function sendOutfitNotification($entity_list, $client_id){
        
        $User = ClassRegistry::init('User');
        $Entity = ClassRegistry::init('Entity');
        $entities = $Entity->getProductDetails($entity_list);
        $client = $User->getByID($client_id);
        
        if($entities && $client){
            try{
                $email = new CakeEmail('default');
                $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                $email->to($client['User']['email']);
                $email->subject('Savile Row Society: New Outfit');
                $email->template('new_outfit');
                $email->emailFormat('html');
                $email->viewVars(compact('entities', 'client'));
                $email->send();
            }
            catch(Exception $e){
                
            }
        }
    }
}

