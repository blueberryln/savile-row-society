<?php

App::uses('AppModel', 'Model');

/**
 * Attached Model
 *
 * @property Attachment $Attachment
 * @property Model $Model
 */
class StylistPhotostream extends AppModel {
    
    public $useTable = 'stylist_photostream';

    
        public $belongsTo = array(
            'StylistBio' => array(
            'className' => 'StylistBio',
            'foreignKey' => 'stylistbio_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
            )
        );
    
    
}
