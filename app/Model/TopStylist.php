<?php

App::uses('AppModel', 'Model');

/**
 * TopStylist Model
 *
 */
class TopStylist extends AppModel {

	/**
     * useTable field
     * 
     * @var string
     */
    var $useTable = 'top_stylists';


    /**
     * Get top/highlighted stylists.
     * 
     * @return array
     */
    public function getTopStylists(){

    	$users = $this->find('all', array(
    		'joins' => array(
                array('table' => 'users',
                    'alias' => 'User',
                    'type' => 'INNER',
                    'conditions' => array(
                        'User.id = TopStylist.user_id',
                    )
                ),
            ),
    		'fields'		=> array('User.id,User.first_name,User.last_name,User.profile_photo_url, TopStylist.order_id, TopStylist.id'),
    		'order'			=> array('TopStylist.order_id' => 'asc')
    		));

    	return $users;
    }


    /**
     * Get by user_id
     * 
     * @return array
     */
    public function getByUserId($user_id){

        $user = $this->find('first', array(
            'conditions'   => array('user_id'  => $user_id)
            ));

        return $user;

    }

}
	