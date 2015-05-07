<?php

App::uses('AppModel', 'Model');

/**
 * CreditCard Model
 */
class LifestyleItem extends AppModel {
    /**
     * useTable field
     * 
     * @var string
     */
    var $useTable = 'lifestyles_items';
    
    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Lifestyle' => array(
            'className' => 'Lifestyle',
            'foreignKey' => 'lifestyle_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Entity' => array(
            'className' => 'Entity',
            'foreignKey' => 'product_entity_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    
    public function getByEntityId($lifestyle_id, $entity_id){
        return $this->find('first', array(
            'conditions' => array('LifestyleItem.lifestyle_id' => $lifestyle_id, 'LifestyleItem.product_entity_id' => $entity_id),
        ));
    }
    
    public function getLifestyleProducts($id){
        return $this->find('list', array(
            'conditions' => array('LifestyleItem.lifestyle_id' => $id),
            'fields' => array('LifestyleItem.product_entity_id')
        ));
    }

    public function getLifestyleProductsList($id){
        return $this->find('all', array(
            'conditions' => array('LifestyleItem.lifestyle_id' => $id),
            'fields' => array('LifestyleItem.product_entity_id')
        ));
    }
}
