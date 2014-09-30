<?php

class FeedController extends AppController {

	public function loadFeed(){

		$result = array();
        if ($this->getLoggedUser()){
            $user_id = $this->getLoggedUserID();
            
            $Post = ClassRegistry::init('Post');
            $posts = $Post->getStylistPosts($user_id);
            
            $result['posts'] = $posts;
            $result['status'] = 'ok';
        }
        else{
            $result = array();
            $result['status'] = 'error';
        }
        
        $this->set('data', $result);
        $this->render('/Elements/SerializeJson/');		

	}
}