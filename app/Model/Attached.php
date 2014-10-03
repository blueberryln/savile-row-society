<?php

App::uses('AppModel', 'Model');

/**
 * Attached Model
 *
 * @property Attachment $Attachment
 * @property Model $Model
 */
class Attached extends AppModel {

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'attached';

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'model_id';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'attachment_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'model_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'model_name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
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
        'Attachment' => array(
            'className' => 'Attachment',
            'foreignKey' => 'attachment_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'Color' => array(
            'className' => 'Color',
            'joinTable' => 'attached_colors',
            'foreignKey' => 'attached_id',
            'associationForeignKey' => 'color_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        )
    );

    /**
     * Get attached by Product ID
     * 
     * @param type $product_id
     * @return type
     */
    function getByProductID($product_id) {
        return $this->find('all', array(
                    'contain' => array('Attachment', 'Color'),
                    'conditions' => array(
                        'Attached.model' => 'Product',
                        'Attached.model_id' => $product_id,
                    )
        ));
    }
    /**
     * Get attached by Message ID
     * 
     * @param type $message_id
     * @return type
     */
    function getByMessageID($message_id) {
        return $this->find('all', array(
                    'contain' => array('Attachment'),
                    'conditions' => array(
                        'Attached.model' => 'Message',
                        'Attached.model_id' => $message_id,
                    )
        ));
    }

}
