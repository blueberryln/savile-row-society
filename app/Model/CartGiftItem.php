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
}