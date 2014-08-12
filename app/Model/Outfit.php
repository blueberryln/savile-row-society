<?php

App::uses('AppModel', 'Model');

/**
 * Order Model
 *
 * @property User $User
 * @property Product $Product
 */
class Outfit extends AppModel {
     public $hasMany = array(
        'OrderItem' => array(
            'className' => 'OrderItem',
            'foreignKey' => 'outfit_id',
            'conditions' => '',
            'order' => '',
            'limit' => '',
            'dependent' => true         
        ),
    );

     function getoutfitpostid($user_id){
        
        $find_array = array(
            'fields' => array('Outfit.*,OutfitItem.*'),
            'joins' => array(
                array(
                    'table' => 'outfits_items',
                    'alias' => 'OutfitItem',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Outfit.id = OutfitItem.outfit_id',
                        'Outfit.stylist_id'=>$user_id,
                        ),
                    ),
                ),
            ); 
       return  $this->find('all', $find_array);
        //$this->find('all',array('conditions'=>array('Outfit.stylist_id' => $user_id)));


    }
}