<?php

class MigrateController extends AppController {

	public function index(){

		$Message = ClassRegistry::init('Message');
		$Post = ClassRegistry::init('Post');
		$messages = $Message->find('all', array('fields' => array('id','user_from_id', 'user_to_id', 'is_outfit', 'is_request_outfit'), 'oder'));

		foreach($messages as $value){
			$data = array();

			if($value['Message']['is_outfit']){
				$data['Post'] = array(
					'user_id' => $value['Message']['user_from_id'],
					'is_outfit'	=> 1,
				);
			}
			else if($value['Message']['is_request_outfit']){
				$data['Post'] = array(
					'user_id' => $value['Message']['user_from_id'],
					'is_request_outfit'	=> 1,
				);
			}
			else{
				$data['Post'] = array(
					'user_id' => $value['Message']['user_from_id'],
					'is_message'	=> 1,
				);
			}

			$Post->create();

			$post = $Post->save($data);
			if($post){
				$value['Message']['post_id'] = $post['Post']['id'];

				$Message->save($value);
			}
		}
	}

}