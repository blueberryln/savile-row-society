<?php

App::uses('AppModel', 'Model');

/**
 * Attached Model
 *
 * @property Attachment $Attachment
 * @property Model $Model
 */
class Stylistphotostream extends AppModel {
    
    /**
     * hasMany associations
     *
     * @var array
     */
    public $useTable = 'stylistphotostreams';
   
 
	

        public $belongsTo = array(
            'Stylistbio' => array(
            'className' => 'Stylistbio',
            'foreignKey' => 'stylistbio_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
            )
        );
    
    
}
