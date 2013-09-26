<?php

App::uses('AppModel', 'Model');

/**
 * Color Model
 *
 * @property Property $Property
 * @property Attached $Attached
 */
class Color extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';


    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Property' => array(
            'className' => 'Property',
            'foreignKey' => 'color_id',
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
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'Attached' => array(
            'className' => 'Attached',
            'joinTable' => 'attached_colors',
            'foreignKey' => 'color_id',
            'associationForeignKey' => 'attached_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
        'Entity' => array(
            'className' => 'Entity',
            'joinTable' => 'product_entity_id',
            'foreignKey' => 'colors_entities',
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
        ),
    );
}
