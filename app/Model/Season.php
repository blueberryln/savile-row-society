<?php

App::uses('AppModel', 'Model');

/**
 * Category Model
 *
 * @property Categorised $Categorised
 */
class Season extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'slug' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        )
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Product' => array(
            'className' => 'Product',
            'foreignKey' => 'season_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

    /**
     * Get Category by ID
     * @param type $id
     * @param type $model
     * @return type
     */
    function getOneByID($id) {
        return $this->find('first', array(
                    'conditions' => array(
                        'Season.id' => $id
                    )
        ));
    }

    /**
     * Get All Categoris by slug
     * @param type $slug
     * @param type $model
     * @return type
     */
    function getAllBySlug($slug) {

        // get id by slug
        $category = $this->find('first', array(
            'conditions' => array(
                'Season.slug' => $slug,
            )
        ));
    }
}
