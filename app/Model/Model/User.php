<?php

App::uses('AppModel', 'Model');

/**
 * User Model
 *
 * @property UserType $UserType
 * @property Comment $Comment
 * @property Post $Post
 * @property Wishlist $Wishlist
 */
class User extends AppModel {

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
        'full_name' => "CONCAT(User.first_name, ' ', User.last_name)"
    );

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'user_type_id' => array(
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
            'unique' => array(
                'rule' => array('isUnique'),
                'message' => 'Please enter a different email',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'password' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Please enter password',
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
        'username' => array(
            'notempty' => array(
                'rule' => array('notempty'),
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
    public $hasOne = array(
        'BillingAddress' => array(
            'className' => 'BillingAddress',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    
    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'UserType' => array(
            'className' => 'UserType',
            'foreignKey' => 'user_type_id',
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
        'Comment' => array(
            'className' => 'Comment',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Post' => array(
            'className' => 'Post',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Wishlist' => array(
            'className' => 'Wishlist',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Order' => array(
            'className' => 'Order',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Message' => array(
            'className' => 'Message',
            'foreignKey' => 'user_to_id',
            'dependent' => false,
            'conditions' => '',
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
     * Check User credentials on Login
     * @param type $email
     * @param type $password 
     */
    public function checkCredentials($email = null, $password = null) {
        return $this->find('first', array(
                    'conditions' => array(
                        'User.email' => $email,
                        'User.password' => $password,
                        'User.active' => true
                    )
        ));
    }

    /**
     * Get all Users
     * 
     * @return type
     */
    function getAll() {
        return $this->find('all', array(
                    'order' => array('User.id')
        ));
    }

    /**
     * Get User by ID
     * @param type $id
     * @return type
     */
    function getByID($id) {
        return $this->find('first', array(
                    'conditions' => array(
                        'User.id' => $id
                    )
        ));
    }

    /**
     * Get User by username
     * @param type $username
     * @return type
     */
    function getByUsername($username) {
        return $this->find('first', array(
                    'conditions' => array(
                        'User.username' => $username
                    )
        ));
    }

    /**
     * Get User by email
     * @param type $email
     * @return type
     */
    function getByEmail($email) {
        return $this->find('first', array(
                    'conditions' => array(
                        'User.email' => $email
                    )
        ));
    }

    /**
     * Get User by Social Network ID
     * @param type $social_network_id
     * @return type
     */
    function getBySocialNetworkID($social_network_id, $social_network) {
        return $this->find('first', array(
                    'conditions' => array(
                        'User.social_network_id' => $social_network_id,
                        'User.social_network' => $social_network
                    )
        ));
    }

    /**
     * Get User by ID and Password
     * 
     * @param type $id
     * @param type $password
     * @return type
     */
    public function getByIDAndCode($id = null, $password = null) {
        return $this->find('first', array(
                    'conditions' => array(
                        'User.id' => $id,
                        'User.password' => $password
                    )
        ));
    }

    /**
     * Return list of user that write to stylist
     */
    public function getUserWriteToMe($stylist_Id) {
        return $this->query("SELECT DISTINCT User.id,
                                CONCAT(
                                        User.first_name,
                                        ' ',
                                        User.last_name
                                ) AS full_name
                            FROM users as User
                            INNER JOIN messages m ON m.user_from_id = User.id
                            WHERE m.user_to_id = $stylist_Id
                ");
    }

}
