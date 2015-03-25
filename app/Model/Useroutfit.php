<?php

App::uses('AppModel', 'Model');

/**
 * Order Model
 *
 * @property User $User
 * @property Product $Product
 */
class Useroutfit extends AppModel {
    /**
     * useTable field
     * 
     * @var string
     */
    var $useTable = 'useroutfits';  
     
    
    public $belongsTo = array(
        'Outfit' => array(
            'className' => 'Outfit',
            'foreignKey' => 'outfit_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );   
}