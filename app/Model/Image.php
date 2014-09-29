<?php

App::uses('AppModel', 'Model');

/**
 * Attached Model
 *
 * @property Attachment $Attachment
 * @property Model $Model
 */
class Image extends AppModel {

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'products_images';

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Entity' => array(
            'className' => 'Entity',
            'joinTable' => 'products_images',
            'foreignKey' => 'product_entity_id',
        ),    
    );

    /**
     * Get image by Product Entity ID
     * 
     * @param type $product_id
     * @return type
     */
    function getByProductID($product_id) {
        return $this->find('all', array(
                    'conditions' => array(
                        'Image.product_entity_id' => $product_id,
                    )
        ));
    }
    function getByhighlightProductID($product_id) {
        return $this->find('all', array(
                    'conditions' => array(
                        'Image.product_entity_id' => $product_id,
                    ),
                    'group' => 'Image.product_entity_id',
        ));
    }
    
    /**
     * Get by ID
     * @param type $id
     * @return type
     */
    function getByID($id) {
        return $this->find('first', array(
                    'conditions' => array('Image.id' => $id)
        ));
    }

}
