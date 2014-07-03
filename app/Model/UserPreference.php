<?php

App::uses('AppModel', 'Model');

/**
 * User Model
 *
 * @property UserType $UserType
 * @property Comment $Comment
 * @property Post $Post
 * @property Wishlist $Wishlist
 */
class UserPreference extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
	public $useTable = 'user_preferences';
   
 
	public $displayField = 'name';

        public $belongsTo = array(
            'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
            )
        );
}