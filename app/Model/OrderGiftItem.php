<?php

App::uses('AppModel', 'Model');

/**
 * Attached Model
 *
 * @property Attachment $Attachment
 * @property Model $Model
 */
class OrderGiftItem extends AppModel {
    /**
     * useTable field
     * 
     * @var string
     */
    var $useTable = 'orders_gifts_items';
    
    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'OrderItem' => array(
            'className' => 'OrderItem',
            'foreignKey' => 'order_item_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    ); 

    
    /**
     * Get Gift Card details using the order item id
     * @var $order_item_id
     */
    function getGiftCardDetails($order_item_id){
        return $this->find('first', array(
            'conditions' => array('OrderGiftItem.order_item_id' => $order_item_id),
        ));
    }     
}