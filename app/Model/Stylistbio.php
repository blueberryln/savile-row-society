<?php

App::uses('AppModel', 'Model');

/**
 * Attached Model
 *
 * @property Attachment $Attachment
 * @property Model $Model
 */
class Stylistbio extends AppModel {
    
    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasOne = array(
        'Stylistphotostream' => array(
            'className' => 'Stylistphotostream',
            'foreignKey' => 'stylistbio_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    
    
}