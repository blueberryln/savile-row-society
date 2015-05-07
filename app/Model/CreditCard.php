<?php

App::uses('AppModel', 'Model');

/**
 * CreditCard Model
 */
class CreditCard extends AppModel {
    
    public $useTable = false;
    
    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'cardnumber' => array(
            'rule'    => array('cc', 'all', false, null),
        ),
        'cardcode' => array(
            'length' => array(
                'rule' => array('maxLength', 4),
            ),
        ),
    );
}
