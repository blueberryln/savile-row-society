<?php

App::uses('AppModel', 'Model');

/**
 * Wishlist Model
 *
 * @property User $User
 * @property Product $Product
 */
class Wishlist extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'product_id';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'user_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'product_entity_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
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

    /**
     * Get one by User ID and Product ID
     * @return type
     */
    function get($user_id, $product_entity_id) {
        return $this->find('first', array(
                    'conditions' => array(
                        'Wishlist.user_id' => $user_id,
                        'Wishlist.product_entity_id' => $product_entity_id
                    )
                ));
    }

    /**
     * Get all by User ID
     * @param type $user_id
     * @return type
     */
    function getByUserID($user_id) {
        return $this->find('list', array(
                    'conditions' => array(
                        'Wishlist.user_id' => $user_id
                    ),
                    'fields' => array(
                        'Wishlist.product_entity_id'
                    )
                ));
    }

    /**
     * Remove by User ID and Product ID
     * @return type
     */
    function remove($user_id, $product_entity_id) {
        return $this->deleteAll(array('Wishlist.user_id' => $user_id, 'Wishlist.product_entity_id' => $product_entity_id), false, false);
    }
    
    
    function getUserLikedItems($user_id, $last_liked_id, $limit = 2){
        $find_array = array(
            'conditions' => array('Wishlist.user_id' => $user_id),
            'fields' => array('Wishlist.product_entity_id', 'Wishlist.id'),
            'order' => array('Wishlist.id DESC'),
            'limit' => $limit,
        );
        
        if($last_liked_id > 0){
            $find_array['conditions'][] = 'Wishlist.id < ' . $last_liked_id; 
        }
        
        return $this->find('all', $find_array);
    }

}
