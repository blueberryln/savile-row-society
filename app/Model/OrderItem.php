<?php

App::uses('AppModel', 'Model');

/**
 * Attached Model
 *
 * @property Attachment $Attachment
 * @property Model $Model
 */
class OrderItem extends AppModel {
    /**
     * useTable field
     * 
     * @var string
     */
    var $useTable = 'orders_items';
    
    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Order' => array(
            'className' => 'Order',
            'foreignKey' => 'order_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Entity' => array(
            'className' => 'Entity',
            'foreignKey' => 'product_entity_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        
        'Image' => array(
            'className' => 'Image',
            'foreignKey' => 'product_entity_id',
            'conditions' => '',
            'fields' => 'name',
            'order' => ''
        ),
        'Outfit' => array(
            'className' => 'Outfit',
            'foreignKey' => 'outfit_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

    public function getByOrderId($order_id){
        return $this->find('all', array(
            'contain' => array('Entity'),
            'conditions' => array('OrderItem.order_id' => $order_id), 
        ));
    }
    
    public function getByEntityId($entity_id){
        return $this->find('first', array(
            'conditions' => array('OrderItem.product_entity_id' => $entity_id),
        ));
    }

    public function getByUserID($user_id){
        $this->recursive = 1;
        return $this->find('all', array(
            'contain' => array('Entity'),
            'joins' => array(
                array('table' => 'orders',
                    'alias' => 'Order',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Order.id = OrderItem.order_id'
                    )
                )
            ),
            'conditions' => array('Order.paid' => true, 'Order.user_id' => $user_id),
            'fields' => array('OrderItem.*', 'Entity.*'),
        ));
    }

    public function getUserItemList($user_id, $pageOrder = 'desc'){

        $find_array = array(
            'joins' => array(
                array('table' => 'orders',
                    'alias' => 'Order',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Order.id = OrderItem.order_id',
                        'Order.user_id' => $user_id,
                        'Order.paid'    => 1
                    )
                )
            ),
            'contain'   => array('Outfit'),
            'fields'    => array('OrderItem.*', 'Outfit.*'),
            'order'     => array('OrderItem.id' => $pageOrder),
            );

        return $this->find('all', $find_array);
    }

    
    //Function to get purchased items after last purchased id
    public function getUniqueUserItems($user_id, $last_purchased_id=0){
        
        $db = $this->getDataSource();
        $user_id = $db->value($user_id);
        $last_purchased = $db->value($last_purchased_id);
        
        $condition = "";
        if($last_purchased_id > 0){
            $condition = 'WHERE Orders.order_id < ' . $last_purchased;
        }
        
        $sql = "
                SELECT Orders.product_entity_id, Orders.order_id 
                FROM (SELECT `OrderItem`.`product_entity_id`, MAX(`OrderItem`.`id`) AS order_id 
                FROM `srs_development`.`orders_items` AS `OrderItem` 
                INNER JOIN `srs_development`.`orders` AS `Order` ON (`Order`.`id` = `OrderItem`.`order_id`) 
                WHERE `Order`.`user_id` = " . $user_id . " AND Order.paid = 1 
                GROUP BY `OrderItem`.`product_entity_id` 
                ORDER BY `order_id` DESC) AS Orders
                " . $condition . "               
                ORDER BY Orders.order_id DESC  
                LIMIT 10";
        
        $result = $this->query($sql);
        return $result;
    }

    public function getUniqueUserItemPurchase($user_id){
        
        $db = $this->getDataSource();
        $user_id = $db->value($user_id);
            $sql = "
                SELECT Orders.product_entity_id, Orders.order_id
                FROM (SELECT `OrderItem`.`product_entity_id`, MAX(`OrderItem`.`id`) AS order_id 
                FROM `srs_development`.`orders_items` AS `OrderItem` 
                INNER JOIN `srs_development`.`orders` AS `Order` ON (`Order`.`id` = `OrderItem`.`order_id`) 
                WHERE `Order`.`user_id` = " . $user_id . " AND Order.paid = 1 
                GROUP BY `OrderItem`.`product_entity_id` 
                ORDER BY `order_id` DESC ) AS Orders
                ORDER BY Orders.order_id DESC";  
                
        
        $result = $this->query($sql);
        return $result;
    }

    public function getUniqueUserItemPurchaseSorting($user_id,$sortingorder){
        
        $db = $this->getDataSource();
        $user_id = $db->value($user_id);
            $sql = "
                SELECT Orders.product_entity_id, Orders.order_id, Orders.created 
                FROM (SELECT `OrderItem`.`product_entity_id`, MAX(`OrderItem`.`id`) AS order_id, Order.created 
                FROM `srs_development`.`orders_items` AS `OrderItem` 
                INNER JOIN `srs_development`.`orders` AS `Order` ON (`Order`.`id` = `OrderItem`.`order_id`) 
                WHERE `Order`.`user_id` = " . $user_id . " AND Order.paid = 1 
                GROUP BY `OrderItem`.`product_entity_id` 
                ORDER BY `created` ".$sortingorder.") AS Orders
                ORDER BY Orders.created ".$sortingorder;  
                
        
        $result = $this->query($sql);
        return $result;
    }
    

    //Function to get total purchased items of a user
    function getTotalUserPurchaseCount($user_id){
        $find_array = array(
            'conditions' => array('Order.user_id' => $user_id),
            'joins' => array(
                array('table' => 'orders',
                    'alias' => 'Order',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Order.id = OrderItem.order_id'
                    )
                )
            ),
        );
        
        return $this->find('count', $find_array);    
    }

    //bhashit code

    function getUserPurchaseDetail($orderid){
        $find_array =   array(
            'contain' => array('Entity','Image'),
            'joins' => array(
                array('table' => 'orders',
                    'alias' => 'Order',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Order.id = OrderItem.order_id'
                    )
                ),
                array('table' => 'products',
                    'alias' => 'Product',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.id = OrderItem.product_entity_id'
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
            'conditions' => array('Order.id' => $orderid),
            'fields' => array('OrderItem.*', 'Entity.*','Brand.*'),
        );
        return $this->find('all',$find_array);
    }



    function getEachUserPurchasingData($clientid, $post_id){
        $find_array =   array(
            'contain' => array('Entity','Image'),
            'joins' => array(
                array('table' => 'orders',
                    'alias' => 'Order',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Order.id = OrderItem.order_id'
                    )
                ),
                array('table' => 'products',
                    'alias' => 'Product',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Product.id = OrderItem.product_entity_id'
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
            'conditions' => array('Order.user_id' => $clientid,'Order.post_id'=> $post_id,),
            'fields' => array('OrderItem.*', 'Entity.*','Brand.*'),
        );
        return $this->find('all',$find_array);
    }
}