<?php

App::uses('AppModel', 'Model');

/**
 * Attached Model
 *
 * @property Attachment $Attachment
 * @property Model $Model
 */
class CartItem extends AppModel {
    /**
     * useTable field
     * 
     * @var string
     */
    var $useTable = 'carts_items';
    
    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Cart' => array(
            'className' => 'Cart',
            'foreignKey' => 'cart_id',
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
    

    function getCartItems($cart_id){
        return $this->find('count', array(
            'conditions' => array('CartItem.cart_id' => $cart_id)
        ));
    }

    function getByCartId($cart_id){
        return $this->find('all', array(
            'conditions' => array('CartItem.cart_id' => $cart_id),
            'joins' => array(
                array('table' => 'sizes',
                    'alias' => 'Size',
                    'type' => 'INNER',
                    'conditions' => array(
                        'CartItem.size_id = Size.id'
                    )
                ),
            ),
            'fields' => array('CartItem.*', 'Size.name'),
            'order' => array('CartItem.updated'),
        ));
    }
    
    function remove($item_id){
        return $this->deleteAll(array('CartItem.id' => $item_id));
    }
}