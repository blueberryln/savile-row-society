<?php

App::uses('AppModel', 'Model');

/**
 * Order Model
 *
 * @property User $User
 * @property Product $Product
 */
class CopyUserOutfit extends AppModel {
    /**
     * useTable field
     * 
     * @var string
     */
    var $useTable = 'copys_users_outfits';  
     
    
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