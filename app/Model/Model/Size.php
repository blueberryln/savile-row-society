<?php

App::uses('AppModel', 'Model');

/**
 * Size Model
 *
 * @property Property $Property
 */
class Size extends AppModel {

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
            'foreignKey' => 'size_id',
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
     * get available colours for a product type
     * @param type $id, $existing_colors
     * @return available colors 
     */
     function getAvailableSizes($existing_sizes){
        return $this->find('list', array(
                    'conditions' => array(
                        'NOT' => array('Size.id' => $existing_sizes)
                    )
            
        ));
     }

}
