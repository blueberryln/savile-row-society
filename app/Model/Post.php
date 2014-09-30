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
class Post extends AppModel {

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

	public function getStylistPosts($stylist_id){
		// $stylist_id = 741;
		$User = ClassRegistry::init('User');

		$client_list = $User->find('list', array(
			'conditions'	=> array('stylist_id'	=> $stylist_id, 'is_stylist !=' => '1'),
			'fields'	=> array('id'),
			));

		$find_array = array(
            'contain'   => ('User'),
			'conditions'	=> array(
				'OR'	=> array(
					array('user_id'	=> $client_list),
					array('user_id'	=> $stylist_id)	
					)
				),
			'order'			=> array('Post.id' => 'desc'),
			'limit'			=> '20'
			);
		$posts = $this->find('all', $find_array);

		$result = $this->getPostDetails($posts);

		return $result;
	}

	public function getPostDetails($posts){
		$likes_list = array();
        $message_list = array();
        $order_list = array();

        foreach($posts as $value){
        	if($value['Post']['is_like'] == "1"){
        		$likes_list[] = $value['Post']['id'];
        	}	
        	else if($value['Post']['is_order'] == "1"){
        		$order_list[] = $value['Post']['id'];
        	}	
        	else if($value['Post']['is_message'] || $value['Post']['is_request_outfit'] || $value['Post']['is_outfit']){
        		$message_list[] = $value['Post']['id'];
        	}
        }

        $wishlist = $this->formatWishlist($likes_list);
        $message = $this->formatMessage($message_list);

        $sorted_post = array();
        foreach ($posts as $value) {
            if($value['Post']['is_like'] == "1" && isset($wishlist[$value['Post']['id']])){
                $value['Wishlist'] = $wishlist[$value['Post']['id']]['Wishlist'];
                $value['Entity'] = $wishlist[$value['Post']['id']]['Entity'];
                $value['Brand'] = $wishlist[$value['Post']['id']]['Brand'];

                $sorted_post[] = $value;
            }
            else if(($value['Post']['is_message'] || $value['Post']['is_request_outfit'] || $value['Post']['is_outfit']) && isset($message[$value['Post']['id']])){
                $combined = $message[$value['Post']['id']];
                $combined['Post'] = $value['Post'];
                $combined['User'] = $value['User'];

                $sorted_post[] = $combined;
            }
        }

        return $sorted_post;
	}

	public function formatWishlist($likes_list){
		$Wishlist = ClassRegistry::init('Wishlist');

        //Format whishlist
        $wishlist = $Wishlist->getLikedProductDetails($likes_list);	

        $sorted_wishlist = array();
        foreach($wishlist as $value){
        	$sorted_wishlist[$value['Wishlist']['post_id']] = $value;
        }

        return $sorted_wishlist;
	}


	public function formatMessage($message_list){

        $Message = ClassRegistry::init('Message');
        $Outfit = ClassRegistry::init('Outfit');

      	
		//Format messages
        $messages = $Message->find('all', array(
        	'contain' => array('UserFrom', 'UserTo'),
        	'conditions'	=> array('post_id'	=> $message_list),
        	'fields'		=> array('user_to_id', 'user_from_id', 'body', 'image', 'is_outfit', 'is_request_outfit', 'outfit_id', 'post_id', 'UserFrom.id', 'UserFrom.first_name', 'UserFrom.last_name', 'UserFrom.profile_photo_url', 'UserTo.id', 'UserTo.first_name', 'UserTo.last_name', 'UserTo.profile_photo_url')
        ));

        $outfit_list = array();
        foreach($messages as $value){
        	if($value['Message']['is_outfit']){
        		$outfit_list[] = $value['Message']['outfit_id'];
        	}
        }	

        $outfits = array();
        if($outfit_list){
        	$outfits = $Outfit->getOutfitDetails($outfit_list);	
        }

        $sorted_outfits = array();
        foreach($outfits as $value){
            $sorted_outfits[$value['Outfit']['id']] = $value;
        }


        $sorted_messages = array();
        foreach($messages as $value){
            if($value['Message']['is_outfit'] && isset($sorted_outfits[$value['Message']['outfit_id']])){
                $value['Outfit'] = $sorted_outfits[$value['Message']['outfit_id']]['Outfit'];
                $value['OutfitItem'] = $sorted_outfits[$value['Message']['outfit_id']]['OutfitItem'];
            }
            
            $sorted_messages[$value['Message']['post_id']] = $value;
        }

        return $sorted_messages;

	}


}