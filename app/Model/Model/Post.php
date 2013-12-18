<?php

App::uses('AppModel', 'Model');

/**
 * Post Model
 *
 * @property User $User
 * @property Category $Category
 * @property UserType $UserType
 */
class Post extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'title';

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
        'title' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'slug' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'content' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'except' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'date' => array(
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
            'foreignKey' => 'model_id',
            'dependent' => false,
            'conditions' => array('Comment.model' => 'Post'),
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Attached' => array(
            'className' => 'Attached',
            'foreignKey' => 'model_id',
            'dependent' => false,
            'conditions' => array('Attached.model' => 'Post'),
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
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'Category' => array(
            'className' => 'Category',
            'joinTable' => 'posts_categories',
            'foreignKey' => 'post_id',
            'associationForeignKey' => 'category_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
        'UserType' => array(
            'className' => 'UserType',
            'joinTable' => 'posts_user_types',
            'foreignKey' => 'post_id',
            'associationForeignKey' => 'user_type_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        )
    );

    /**
     * Get Post by Author count
     * @return type
     */
    function getAuthorsCount() {
        return $this->find('all', array(
                    'fields' => array('COUNT(Post.user_id) as count'),
                    'conditions' => array(
                        'Post.pubished' => true
                    ),
                    'contain' => array(
                        'User' => array(
                            'fields' => array(
                                'User.id',
                                'User.first_name',
                                'User.last_name',
                                'User.username'
                            ),
                        )
                    ),
                    'group' => 'Post.user_id',
                    'order' => 'User.first_name DESC'
                ));
    }

    /**
     * Get Post by/or Author ID
     * @param type $author_id
     * @return type
     */
    function get($author_id = null) {

        $author_filter = array();

        if ($author_id) {
            $author_filter = array('Post.user_id' => $author_id);
        }

        return $this->find('all', array(
                    'fields' => array(
                        'Post.id',
                        'Post.title',
                        'Post.slug',
                        'Post.except',
                        'Post.date',
                        'Post.pubished',
                    ),
                    'conditions' => array(
                        'Post.pubished' => true,
                        $author_filter
                    ),
                    'contain' => array(
                        'User' => array(
                            'fields' => array(
                                'User.id',
                                'User.first_name',
                                'User.last_name',
                                'User.username'
                            ),
                        ),
                        'Category'
                    ),
                    'order' => 'Post.date DESC'
                ));
    }

    /**
     * Get Post by slug
     * @param type $slug
     * @return type
     */
    function getOneBySlug($slug) {

        return $this->find('first', array(
                    'fields' => array(
                        'Post.id',
                        'Post.title',
                        'Post.slug',
                        'Post.content',
                        'Post.date',
                        'Post.pubished',
                    ),
                    'conditions' => array(
                        'Post.pubished' => true,
                        'Post.slug' => $slug
                    ),
                    'contain' => array(
                        'User' => array(
                            'fields' => array(
                                'User.id',
                                'User.first_name',
                                'User.last_name'
                            ),
                        ),
                        'Category'
                    )
                ));
    }

}
