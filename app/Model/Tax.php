<?php

App::uses('AppModel', 'Model');

/**
 * Attached Model
 *
 * @property Attachment $Attachment
 * @property Model $Model
 */
class Tax extends AppModel {

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'taxes';


    /**
     * Get image by Product Entity ID
     * 
     * @param type $product_id
     * @return type
     */
    function getByZip($zip) {
        return $this->find('first', array(
                    'conditions' => array(
                        'Tax.zip' => $zip,
                    )
        ));
    }

}

