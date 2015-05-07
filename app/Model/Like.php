<?php

App::uses('AppModel', 'Model');

/**
 * Dislike Model
 *
 * @property User $User
 * @property Product $Product
 */
class Like extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'product_entity_id';

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
                'Like.user_id' => $user_id,
                'Like.product_entity_id' => $product_entity_id
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
                'Like.user_id' => $user_id
            ),
            'fields' => array(
                'Like.product_entity_id'
            )
        ));
    }

    /**
     * Remove by User ID and Product ID
     * @return type
     */
    //function remove($user_id, $product_entity_id) {
//        return $this->deleteAll(array('Dislike.user_id' => $user_id, 'Dislike.product_entity_id' => $product_entity_id), false, false);
//    }

}
