<?php

App::uses('AppModel', 'Model');

/**
 * UserType Model
 *
 * @property User $User
 * @property Post $Post
 * @property Product $Product
 */
class BillingAddress extends AppModel {

    public $useTable = 'billing_addresses';
    
    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
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
        'fax' => array(
            'maxLength' => array(
                'rule'    => array('maxLength', '45'),
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    
    
    public function getByUserId($user_id){
        return $this->find('first', array(
            'conditions' => array('BillingAddress.user_id' => $user_id),
        ));
    }
}
