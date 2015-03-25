<?php

App::uses('AppModel', 'Model');

/**
 * Category Model
 *
 * @property Categorised $Categorised
 */
class Category extends AppModel {

    public $actsAs = array('Tree');

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'name' => array(
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
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'Product' => array(
            'className' => 'Product',
            'joinTable' => 'products_categories',
            'foreignKey' => 'category_id',
            'associationForeignKey' => 'product_id',
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
    );

    /**
     * Get All Categories
     *
     * @return type
     */
    function getAll() {
        return $this->find('threaded', array(
                'order' => array('Category.order' => 'ASC'),
            )
        );
    }

    /**
     * Get Category by ID
     * @param type $id
     * @param type $model
     * @return type
     */
    function getOneByID($id, $model) {
        return $this->find('first', array(
                    'conditions' => array(
                        'Category.id' => $id,
                        'Category.model' => $model
                    )
        ));
    }

    /**
     * Get Category by ID
     * @param type $id
     * @param type $model
     * @return type
     */
    function getOneWithPostsBySlug($slug, $model) {
        return $this->find('first', array(
                    'conditions' => array(
                        'Category.slug' => $slug,
                        'Category.model' => $model
                    ),
                    'contain' => array(
                        'Post' => array(
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
                            ),
                            'User' => array(
                                'fields' => array(
                                    'User.id',
                                    'User.first_name',
                                    'User.last_name',
                                    'User.username'
                                ),
                            ),
                        )
                    )
        ));
    }

    /**
     * Get Category by slug
     * @param type $slug
     * @param type $model
     * @return type
     */
    function getOneBySlug($slug, $model) {
        return $this->find('first', array(
                    'conditions' => array(
                        'Category.slug' => $slug,
                        'Category.model' => $model
                    )
        ));
    }

    /**
     * Get All Categoris by slug
     * @param type $slug
     * @param type $model
     * @return type
     */
    function getAllBySlug($slug) {

        // get id by slug
        $category = $this->find('first', array(
            'conditions' => array(
                'Category.slug' => $slug,
            )
        ));

        // get all by parent category
        if ($category) {
            $category_ids = array();
            $cat_children = $this->children($category['Category']['id']);
            array_push($category_ids, $category['Category']['id']);
            foreach($cat_children as $child){
                array_push($category_ids, $child['Category']['id']);    
            }
            return $category_ids;
        } else {
            return 0;
        }
    }


    /**
     * Get All Categoris by multiple slug
     * @param type $slug
     * @param type $model
     * @return type
     */
    function getAllCategories($list) {

        // get id by slug
        $category = $this->find('first', array(
            'conditions' => array(
                'Category.id' => $list,
            )
        ));

        // get all by parent category
        if ($category) {

            $category_ids = array();
            foreach($category as $value){
                $cat_children = $this->children($category['Category']['id']);
                array_push($category_ids, $category['Category']['id']);
                foreach($cat_children as $child){
                    array_push($category_ids, $child['Category']['id']);    
                }
            }
            
            return $category_ids;
        } else {
            return 0;
        }
    }


    /**
     * Get Category by model
     * @param type $model
     * @return type
     */
    function getByModel($model) {
        return $this->find('all', array(
                    'conditions' => array(
                        'Category.model' => $model
                    )
        ));
    }

    function getParentCategories(){
        return $this->find('list', array(
           'conditions' => array('Category.parent_id IS NULL'),
            'fields' => array('Category.id')
        ));
    }
}
