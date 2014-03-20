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
}