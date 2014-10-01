<?php

class FeedController extends AppController {

	public function loadFeed($id = false){

		$result = array();
        if ($this->getLoggedUser()){
            $user_id = $this->getLoggedUserID();
            
            $Post = ClassRegistry::init('Post');
            $posts = $Post->getStylistPosts($user_id, $id);
            
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


    public function loadOldFeed($id = false){
        $last_post_id = $this->request->data['last_post_id'];

        $result = array();
        if ($this->getLoggedUser() && $last_post_id > 0){
            $user_id = $this->getLoggedUserID();
            
            $Post = ClassRegistry::init('Post');
            $posts = $Post->getOldStylistPosts($user_id, $id, $last_post_id);
            
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


    public function loadNewFeed($id = false){
        $first_post_id = $this->request->data['first_post_id'];

        $result = array();
        if ($this->getLoggedUser() && $first_post_id > 0){
            $user_id = $this->getLoggedUserID();
            
            $Post = ClassRegistry::init('Post');
            $posts = $Post->getNewStylistPosts($user_id, $id, $first_post_id);
            
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