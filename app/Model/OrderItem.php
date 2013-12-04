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
        )
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
    
    //Function to get purchased items after last purchased id
    public function getUniqueUserItems($user_id, $last_purchased_id=0, $limit = 8){
        //$find_array = array(
//            'conditions' => array('Order.user_id' => $user_id),
//            'joins' => array(
//                array('table' => 'orders',
//                    'alias' => 'Order',
//                    'type' => 'INNER',
//                    'conditions' => array(
//                        'Order.id = OrderItem.order_id'
//                    )
//                )
//            ),
//            'group' => array('OrderItem.product_entity_id'),
//            'fields' => array('OrderItem.product_entity_id', 'MAX(OrderItem.id) AS order_id'),
//            'order' => array('order_id DESC'),
//            'limit' => $limit,
//        );
//        
//        if($last_purchased_id > 0){
//            $find_array['conditions'][] = 'OrderItem.id < ' . $last_purchased_id; 
//        }
//        
//        return $this->find('all', $find_array);
        
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
                WHERE `Order`.`user_id` = 219  
                GROUP BY `OrderItem`.`product_entity_id` 
                ORDER BY `order_id` DESC) AS Orders
                " . $condition . "               
                ORDER BY Orders.order_id DESC  
                LIMIT 10";
        
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
}