<?php

App::uses('AppModel', 'Model');

/**
 * CreditCard Model
 */
class ShippingAddress extends AppModel {
    
    public $useTable = 'shipping_addresses';
    
    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'first_name' => array(
            'notEmpty' => array(
                'rule'    => 'notEmpty',
            ),
            'maxLength' => array(
                'rule'    => array('maxLength', '45'),
            ),
        ),
        'last_name' => array(
            'notEmpty' => array(
                'rule'    => 'notEmpty',
            ),
            'maxLength' => array(
                'rule'    => array('maxLength', '45'),
            ),
        ),
        'company' => array(
            'maxLength' => array(
                'rule'    => array('maxLength', '45'),
            ),
        ),
        'address' => array(
            'notEmpty' => array(
                'rule'    => 'notEmpty',
            ),
            'maxLength' => array(
                'rule'    => array('maxLength', '255'),
            ),
        ),
        'city' => array(
            'notEmpty' => array(
                'rule'    => 'notEmpty',
            ),
            'maxLength' => array(
                'rule'    => array('maxLength', '45'),
            ),
        ),
        'state' => array(
            'notEmpty' => array(
                'rule'    => 'notEmpty',
            ),
            'maxLength' => array(
                'rule'    => array('maxLength', '45'),
            ),
        ),
        'zip' => array(
            'notEmpty' => array(
                'rule'    => 'notEmpty',
            ),
            'maxLength' => array(
                'rule'    => array('maxLength', '16'),
            ),
        ),
        'country' => array(
            'notEmpty' => array(
                'rule'    => 'notEmpty',
            ),
            'maxLength' => array(
                'rule'    => array('maxLength', '45'),
            ),
        ),
    );
}
