<?php

App::uses('AppModel', 'Model');

/**
 * Promocode Model
 *
 */
class Promocode extends AppModel {
    
    var $useTable = "promocodes";
    
    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'code' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        ),
        'total_available' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            ),
            'range' => array(
                'rule' => array('comparison', '>=', 0),
                'message' => 'Please enter a number greater than or equal to zero.',
            ),
            'required' => false,
        ),
        'total_available' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            ),
            'use_per_customer' => array(
                'rule' => array('comparison', '>=', 0),
                'message' => 'Please enter a number greater than or equal to zero.',
            ),
            'required' => false,
        )
    );
}