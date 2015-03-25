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
class StylistNote extends AppModel {

	public $useTable = 'stylist_notes';


}