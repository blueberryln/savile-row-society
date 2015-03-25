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
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'Entity' => array(
            'className' => 'Entity',
            'joinTable' => 'colors_entities',
            'foreignKey' => 'color_id',
            'associationForeignKey' => 'product_entity_id',
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
        'Colorgroup' => array(
            'className' => 'Colorgroup',
            'joinTable' => 'colorgroups_items',
            'foreignKey' => 'color_id',
            'associationForeignKey' => 'colorgroup_id',
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
    
    function remove($color_id){
        return $this->delete($color_id, true);
    }
}
