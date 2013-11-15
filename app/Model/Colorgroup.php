<?php

App::uses('AppModel', 'Model');

/**
 * Color Model
 *
 * @property Property $Property
 * @property Attached $Attached
 */
class Colorgroup extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';
    
    var $useTable = "colorgroups";


    //The Associations below have been created with all possible keys, those that are not needed can be removed

    

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Color' => array(
            'className' => 'Color',
            'foreignKey' => 'color_id',
            'conditions' => '',
            'order' => '',
            'limit' => '',
            'dependent' => true         
        ),
    );
    
    public $hasAndBelongsToMany = array(
        'Color' => array(
            'className' => 'Color',
            'joinTable' => 'colorgroups_items',
            'foreignKey' => 'colorgroup_id',
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
    
    function getColors($color_list){
        return $this->find('all', array(
            'conditions' => array('Colorgroup.id' => $color_list),
            'joins' => array(
                array('table' => 'colorgroups_items',
                    'alias' => 'ColorItems',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Colorgroup.id = ColorItems.colorgroup_id'
                    )
                ),     
            ),
            'fields' => array('ColorItems.*'),
        ));
    }
    
    function remove($color_group_id){
        return $this->delete($color_group_id);
    }
}
