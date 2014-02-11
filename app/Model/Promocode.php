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
                'rule' => array('numeric')
            ),
            'range' => array(
                'rule' => array('comparison', '>=', 0),
                'message' => 'Please enter a number greater than or equal to zero.',
            )
        ),
        'use_per_customer' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            ),
            'range' => array(
                'rule' => array('comparison', '>=', 0),
                'message' => 'Please enter a number greater than or equal to zero.',
            )
        ),
        'type' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
            'allowedChoice' => array(
                 'rule'    => array('inList', array('Fixed', 'Percentage')),
                 'message' => 'Enter either Fixed or Percentage.'
             )
        ),
        'discount_amount' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            ),
            'range' => array(
                'rule' => array('comparison', '>', 0),
                'message' => 'Please enter a number greater than zero.',
            )
        ),
    );
}