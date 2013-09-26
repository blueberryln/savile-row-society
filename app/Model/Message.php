<?php
App::uses('AppModel', 'Model');
/**
 * Message Model
 *
 * @property UserFrom $UserFrom
 * @property UsersTo $UsersTo
 */
class Message extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'body';
        
        

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_from_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'users_to_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'body' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_read' => array(
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
        
	public $belongsTo = array(
		'UserFrom' => array(
			'className' => 'User',
			'foreignKey' => 'user_from_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
                        'dependent' => true
		),
		'UsersTo' => array(
			'className' => 'User',
			'foreignKey' => 'users_to_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
        
        public $hasMany = array(
            'Attached' => array(
            'className' => 'Attached',
            'foreignKey' => 'model_id',
            'dependent' => false,
            'conditions' => array('Attached.model' => 'Message'),
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
            )
        );
        /**
     * Get those messages for user witch he is not already read
     * 
     * @param type $id
     */
    public function getNotReadedMessages($user_id){
        return $this->find('all', array(
                    'conditions' => array('Message.user_to_id' => $user_id, 'Message.is_read' => false),
                    'contain' => array('UserFrom'),
                    'fields' => array('Message.id', 
                        'Message.body', 'Message.created', 'Message.is_read','Message.user_from_id', 'Message.user_to_id',
                        'UserFrom.id', 'UserFrom.user_type_id', 'UserFrom.email', 'UserFrom.password', 'UserFrom.first_name', 'UserFrom.last_name', 'UserFrom.username', 
'UserFrom.profile_photo_url', 'UserFrom.phone', 'UserFrom.social_network',
                        'Attached.attachment_id'
                      ),
        ));
    }
    
    
    public function getUnreadMessages($user_id){
        return $this->find('all', array(
                    'conditions' => array('Message.user_to_id' => $user_id, 'Message.is_read' => false),
                    'contain' => array('UserFrom'),
                    'order' => "Message.created ASC",
                    'fields' => array('Message.id', 
                        'Message.id', 'Message.body', 'Message.created', 'Message.is_read','Message.user_from_id', 'Message.user_to_id', 'UserFrom.id', 'UserFrom.first_name', 'UserFrom.last_name',
                    ),
        ));
    }
    
    public function getUnreadMessagesWith($user_id, $user_id_with){
        return $this->find('all', array(
                    'conditions' => array('Message.user_to_id' => $user_id, 'Message.user_from_id' => $user_id_with, 'Message.is_read' => false),
                    'contain' => array('UserFrom'),
                    'order' => "Message.created ASC",
                    'fields' => array('Message.id', 
                        'Message.id', 'Message.body', 'Message.created', 'Message.is_read','Message.user_from_id', 'Message.user_to_id', 'UserFrom.id', 'UserFrom.first_name', 'UserFrom.last_name',
                    ),
        ));
    }
    
    public function getMyConversation($user_id){
        return $this->find('all', array(
                    'conditions' => array('OR' => array('Message.user_to_id' => $user_id, 'Message.user_from_id' => $user_id), 'Message.created >= ' => date('Y-m-d') . ' 00:00:00'),
                    'contain' => array('UserFrom'),
                    'order' => "Message.created DESC",
                    'fields' => array(
                        'Message.id', 'Message.body', 'Message.created', 'Message.is_read','Message.user_from_id', 'Message.user_to_id', 'UserFrom.id', 'UserFrom.first_name', 'UserFrom.last_name',
                    ),
        ));
    }
    
    public function getMyConversationWith($user_id, $user_id_with){
        return $this->find('all', array(
                    'conditions' => array('AND' =>
                        array(
                            'OR' => array('Message.user_to_id' => $user_id, 'Message.user_from_id' => $user_id),
                            'OR' => array('Message.user_to_id' => $user_id_with, 'Message.user_from_id' => $user_id_with),
                            'Message.created >= ' => date('Y-m-d') . ' 00:00:00'
                        )
                    ),
            
                    'contain' => array('UserFrom'),
                    'order' => "Message.created DESC",
                    'fields' => array(
                        'Message.id', 'Message.body', 'Message.created', 'Message.is_read','Message.user_from_id', 'Message.user_to_id', 'UserFrom.id', 'UserFrom.first_name', 'UserFrom.last_name',
                    ),
        ));
    }
    
    public function getUserWriteToMe($id){
        return $this->find('list', array( 
            'contain' => array(
                'UserFrom'
             ),
            'conditions' => array('user_to_id' => $id)//,
            //'fields' => array("distinct UserFrom.id as id, CONCAT (UserFrom.first_name,  ' ' , UserFrom.last_name) as full_name")
            ));
    }
    
    public function markMessagesRead($mark_read_list = null){
        $this->saveMany(
            array('Message.is_read' => true),
            array('Message.is_read' => false) 
        );
    }
    
    /**
     * Get all messages that user receive
     * 
     * @param type $id
     */
    public function getAllReveivedMessages($id){
        return $this->find('all', array(
                    'contain' => array('UserFrom'),
                    'conditions' => array('Message.user_to_id' => $id)
        ));
    }
    
    public function getSendMessages($id){
        return $this->find('all', array(
                    'conditions' => array('Message.user_from_id' => $id)
        ));
    }
    
    /**
     * Get by id
     * @param type $id
     * @return Message
     */
    function getByID($id) {
        return $this->find('first', array(
                    'conditions' => array(
                        'Message.id' => $id
                    )
        ));
    }
}
