<?php

App::uses('AppModel', 'Model');

/**
 * Attached Model
 *
 * @property Attachment $Attachment
 * @property Model $Model
 */
class StylistBio extends AppModel {
    
    public $useTable = 'stylist_bio';

    
    /**
     * hasMany associations
     *
     * @var array
     */

    public $hasOne = array(
        'StylistPhotostream' => array(
            'className' => 'StylistPhotostream',
            'foreignKey' => 'stylistbio_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    
    
}