<?php

App::uses('AppModel', 'Model');

/**
 * Product Model
 *
 * @property Brand $Brand
 * @property Order $Order
 * @property Property $Property
 * @property Wishlist $Wishlist
 * @property Category $Category
 * @property UserType $UserType
 */
class Product extends AppModel {

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
        'brand_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            ),
        ),
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        )
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Brand' => array(
            'className' => 'Brand',
            'foreignKey' => 'brand_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Season' => array(
            'className' => 'Season',
            'foreignKey' => 'season_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        /*'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),*/
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Entity' => array(
            'className' => 'Entity',
            'foreignKey' => 'product_id',
            'conditions' => '',
            'order' => '',
            'limit' => '',
            'dependent' => true         
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
            'joinTable' => 'products_categories',
            'foreignKey' => 'product_id',
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
    );

    /**
     * Get all
     * 
     * @return type
     */
    function getAll() {

        $products = $this->find('all', array(
            'contain' => array('Category'),
            'conditions' => array(
                'Product.show' => true
            ),
            'order' => array('Product.order ASC')
        ));

        return $products;
    }

    ///**
//     * Get by Category
//     * 
//     * @param type $category
//     * @return type
//     */
//    function getByCategory($category_ids) {
//
//        $products = $this->find('all', array(
//            'conditions' => array(
//                'Product.show' => true
//            ),
//            'joins' => array(
//                array('table' => 'products_categories',
//                    'alias' => 'Category',
//                    'type' => 'INNER',
//                    'conditions' => array(
//                        'Category.category_id' => $category_ids,
//                        'Category.product_id = Product.id'
//                    )
//                )
//            ),
//            'order' => array('Product.order ASC')
//        ));
//
//        return $products;
//    }

    /**
     * Get by ID
     * 
     * @param type $id
     * @return type
     */
    function getByID($id) {
        return $this->find('first', array(
                    'contain' => array('Category'),
                    'conditions' => array('Product.id' => $id)
        ));
    }

    /**
     * Get by ID
     * 
     * @param type $id
     * @return type
     */
    function getAllByID($id) {
        return $this->find('all', array(
                    'contain' => array('Category'),
                    'conditions' => array('Product.id' => $id)
        ));
    }

    /**
     * Get by ID
     *
     * @param type $id
     * @return type
     */
    function getChildEntities($id) {
        return $this->find('first', array(
            'contain' => array('Entity'),
            'conditions' => array('Product.id' => $id)
        ));
    }

    /**
     * Reduce stock by one
     * 
     * @param type $id
     * @return type
     */
    function removeFromStock($id) {
        return $this->updateAll(array('Product.stock' => 'Product.stock-1'), array('Product.id' => $id));
    }
}
