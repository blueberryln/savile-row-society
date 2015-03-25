<?php

App::uses('AppModel', 'Model');

/**
 * Order Model
 *
 * @property User $User
 * @property Product $Product
 */
class OutfitItem extends AppModel {
    /**
     * useTable field
     * 
     * @var string
     */
    var $useTable = 'outfits_items';  
    
    
    public $belongsTo = array(
        'Outfit' => array(
            'className' => 'Outfit',
            'foreignKey' => 'outfit_id',
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
}