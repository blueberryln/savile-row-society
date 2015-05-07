<?php

App::uses('AppModel', 'Model');

/**
 * Attached Model
 *
 * @property Attachment $Attachment
 * @property Model $Model
 */
class Lifestyle extends AppModel {
    
    var $useTable = "lifestyles";
    
    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'LifestyleItem' => array(
            'className' => 'LifestyleItem',
            'foreignKey' => 'lifestyle_id',
            'conditions' => '',
            'order' => '',
            'limit' => '',
            'dependent' => true         
        ),
    );
    
    
    public function getByIdSlug($id, $slug){
        return $this->find('first', array(
            'conditions' => array('Lifestyle.id' => $id, 'Lifestyle.slug' => $slug) 
        ));
    }
    
    public function getByRand(){
        return $this->find('first', array(
            'order' => "rand()", 
        ));    
    }
}