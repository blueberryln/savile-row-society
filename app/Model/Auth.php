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
class Auth extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';
	
	
	
	
	
	function hasStylist($user_id){
        return $this->find('first', array(
            'conditions' => array('User.id' => $user_id),
            'fields' => array('User.stylist_id'),
        ));
    }
	
	
	
	 public function getStylistUserNotification($user_id){
        $find_array = array(
            'fields' => array('User.*', '(SUM(IF(`Message`.`is_read` = 0, 1, 0))) AS unread_count '),
            'joins' => array(
                array('table' => 'messages',
                    'alias' => 'Message',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'User.id = Message.user_from_id'
                    )
                ),
            ),
            'conditions' => array('User.stylist_id' => $user_id),
            'group' => array('User.id HAVING (SUM(IF(`Message`.`is_read` = 0, 1, 0))) > 0'),
            'order' => array('Message.unread' => 'DESC', 'Message.message_date' => 'desc'),
        );
        
        return $this->find('all', $find_array);
    }
	
}