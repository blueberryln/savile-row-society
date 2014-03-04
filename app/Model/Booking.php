<?php

App::uses('AppModel', 'Model');

/**
 * Booking Model
 *
 * @property User $User
 * @property BookingType $BookingType
 */
class Booking extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'date_start';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'user_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'date_start' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'date_end' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
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
        ),
        'BookingType' => array(
            'className' => 'BookingType',
            'foreignKey' => 'booking_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * Get booked
     * @return type
     */
    function getBooked() {
        return $this->find('all', array(
                    'conditions' => array(
                        'Booking.date_start >=' => strtotime(date('Y-m-d H:i:s')),
                        'Booking.is_confirmed' => true
                    ),
                    'order' => 'Booking.date_start ASC'
        ));
    }

}
