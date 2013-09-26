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
        $user_id = $this->getLoggedUserID();
        $ret = array();
        if(is_null($last_purchased_id)){
            $ret['status'] = "error";    
        }    
        else if($user_id && $last_purchased_id >= 0){
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
        $user_id = $this->getLoggedUserID();
        $ret = array();
        if(is_null($last_liked_id)){
            $ret['status'] = "error";    
        }    
        else if($user_id && $last_liked_id >= 0){
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
}

