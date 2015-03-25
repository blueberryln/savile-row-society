<?php

App::uses('AppModel', 'Model');

/**
 * Comment Model
 *
 * @property User $User
 * @property Model $Model
 */
class Comment extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'text';

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
        'model_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'model' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'text' => array(
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
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Post' => array(
            'className' => 'Post',
            'foreignKey' => 'model_id',
            'conditions' => array('Comment.model' => 'Post'),
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * Get Comments by PostID
     * @param type $post_id
     * @return type
     */
    function getByPostID($post_id) {
        return $this->find('all', array(
                    'conditions' => array(
                        'Comment.model_id' => $post_id
                    ),
                    'contain' => array(
                        'User' => array(
                            'fields' => array(
                                'User.id',
                                'User.first_name',
                                'User.last_name'
                            ),
                        )
                    ),
                    'order' => 'Comment.created DESC'
                ));
    }

}
