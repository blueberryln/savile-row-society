<?php

App::uses('AppModel', 'Model');

/**
 * Attached Model
 *
 * @property Attachment $Attachment
 * @property Model $Model
 */
class Cart extends AppModel {
    
    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'CartItem' => array(
            'className' => 'CartItem',
            'foreignKey' => 'cart_id',
            'conditions' => '',
            'order' => '',
            'limit' => '',
            'dependent' => true         
        ),
    );
    
    function getExistingUserCart($user_id){
        return $this->find('first', array(
            'conditions' => array(
                'Cart.user_id' => $user_id,
                'Cart.updated >= now() - INTERVAL 1 DAY'
            ),
        ));
    }
    
    function remove($cart_id){
        return $this->deleteAll(array('Cart.id' => $cart_id));
    }
}