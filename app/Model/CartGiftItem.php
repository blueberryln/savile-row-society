<?php

App::uses('AppModel', 'Model');

/**
 * Attached Model
 *
 * @property Attachment $Attachment
 * @property Model $Model
 */
class CartGiftItem extends AppModel {
    /**
     * useTable field
     * 
     * @var string
     */
    var $useTable = 'carts_gifts_items';
    
    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'CartItem' => array(
            'className' => 'CartItem',
            'foreignKey' => 'cart_item_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

    
    /**
     * Get Gift Card details using the cart item id
     * @var $cart_item_id
     */
    function getGiftCardDetails($cart_item_id){
        return $this->find('first', array(
            'conditions' => array('CartGiftItem.cart_item_id' => $cart_item_id),
        ));
    }     
}