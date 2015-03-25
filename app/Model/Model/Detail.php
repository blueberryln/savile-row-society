<?php

App::uses('AppModel', 'Model');

/**
 * Attached Model
 *
 * @property Attachment $Attachment
 * @property Model $Model
 */
class Detail extends AppModel {

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'products_details';
    
    public $validate = array(
        'stock' => array(
            'numeric' => array(
                'rule' => array('naturalNumber', true),
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
        'Entity' => array(
            'className' => 'Entity',
            'foreignKey' => 'product_entity_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );


    /**
     * get Sizes By Product Entity Id
     * @param type $id
     * @return sizes
     */
     function getSizeByProductID($id){
        return $this->find('all', array(
                    'fields' => array(
                        'Detail.id, Detail.size_id, Detail.stock,Detail.show, Size.name'  
                    ),
                    'joins' => array(
                        array(
                            'table' => 'sizes',
                            'alias' => 'Size',
                            'type' => 'INNER',
                            'conditions' => array(
                                'Detail.size_id = Size.id'
                            )
                        )
                    ),
                    'conditions' => array('Detail.product_entity_id' => $id)
        ));
     }

    /**
     * get Available Sizes By Product Entity Id
     * @param type $id
     * @return sizes
     */
    function getAvailableSize($id){

        $find_array = array(
            'fields' => array(
                'Detail.id, Detail.size_id, Detail.stock,Detail.show,Size.name'
            ),
            'joins' => array(
                array(
                    'table' => 'sizes',
                    'alias' => 'Size',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Detail.size_id = Size.id'
                    )
                )
            ),
            'conditions' => array('Detail.product_entity_id' => $id, 'Detail.stock > 0', 'Detail.show' => true)
        );

        return $this->find('all', $find_array);
    }
     
     /**
     * get By Id
     * @param type $id
     * @return sizes
     */
     function getByID($id){
        return $this->find('first', array(
                    'conditions' => array('Detail.id' => $id)
        ));
     }
     
     /**
     * get existing sizes for a product
     * @param type $id
     * @return existing sizes 
     */
     function getExistingSizes($id){
        return $this->find('list', array(
                    'fields' => array(
                        'Detail.size_id'
                    ),
                    'conditions' => array(
                        'Detail.product_entity_id' => $id
                    )
        ));
     }

    function removeFromStock($entity_id, $size_id, $quantity) {
        return $this->updateAll(array('Detail.stock' => 'Detail.stock-' . $quantity), array('Detail.product_entity_id' => $entity_id, 'Detail.size_id' => $size_id));
    }
}