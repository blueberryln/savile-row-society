<?php

App::uses('AppModel', 'Model');

/**
 * Contact Model
 *
 * @property ContactType $ContactType
 */
class Contact extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'full_name';

    /**
     * Virtual field full_name
     * @var type 
     */
    public $virtualFields = array(
        'full_name' => "CONCAT(Contact.first_name, ' ', Contact.last_name)"
    );

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'contact_type_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'email' => array(
            'email' => array(
                'rule' => array('email'),
                'message' => 'Please enter a valid e-mail',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'first_name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Please enter your first name',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'last_name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Please enter your last name',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'message' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Please enter your message',
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
        'ContactType' => array(
            'className' => 'ContactType',
            'foreignKey' => 'contact_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Attached' => array(
            'className' => 'Attached',
            'foreignKey' => 'model_id',
            'dependent' => false,
            'conditions' => array('Attached.model' => 'Contact'),
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Comment' => array(
            'className' => 'Comment',
            'foreignKey' => 'model_id',
            'dependent' => false,
            'conditions' => array('Comment.model' => 'Contact'),
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
    );

    /**
     * Get all submissions
     * @return type
     */
    function getSubmissions($contact_type_id) {
        $submissions = Cache::read($contact_type_id . '_submissions');
        if ($submissions === false) {
            $submissions = $this->find('all', array(
                'conditions' => array(
                    'Contact.contact_type_id' => $contact_type_id,
                    'Contact.show' => true
                ),
                'contain' => array('Attached' => array('Attachment'), 'Comment'),
                'order' => array('Contact.created')
                    ));
            Cache::write($contact_type_id . '_submissions', $submissions);
        }
        return $submissions;
    }

}
