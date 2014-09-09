<?php
App::uses('AppController', 'Controller');

class WishlistsController extends AppController {

	public function beforeFilter(){
        $this->isLogged();
        if ($this->request->is('ajax')) {
			$this->Components->unload('Security');
		}
    }

	public function save(){
		$ret = array();
		$user_id = $this->getLoggedUserID();
		if ($user_id && $this->request->is('ajax')) {
            $error = false;
            $product_id = $this->request->data['product_id'];
            $outfit_id = $this->request->data['outfit_id'];
            $Dislike = ClassRegistry::init('Dislike');
            $Like = ClassRegistry::init('Like');
            $dislike = $Dislike->get($user_id, $product_id);
            if($dislike && $dislike['Dislike']['show']){
                $dislike['Dislike']['show'] = 0;
                if($Dislike->save($dislike)){
                    $error = false;           
                }
                else{
                    $ret['status'] = "error";
                    $ret['msg'] = 'Item could not be liked.';
                    $error = true;
                }    
            }
            
            if(!$error) {
                // get posted product id

                $wishlist = $this->Wishlist->get($user_id, $product_id, $outfit_id);
                if (!$wishlist) {
                    $wishlist['Wishlist']['user_id'] = $user_id;
                    $wishlist['Wishlist']['product_entity_id'] = $product_id;
                    $wishlist['Wishlist']['outfit_id'] = $outfit_id;
                    $this->Wishlist->create();
                    if ($this->Wishlist->save($wishlist)) {
                        //Check if present in likes
                        $like = $Like->get($user_id, $product_id, $outfit_id);
                        if(!$like){
                            $like['Like']['user_id'] = $user_id;
                            $like['Like']['product_entity_id'] = $product_id;
                            $like['Like']['outfit_id'] = $outfit_id;   
                            $Like->create(); 
                            $Like->save($like); 
                        }
                        
                        $user = $this->getLoggedUser();
                        if ($user && $user['User']['preferences']) {
                            $preferences = unserialize($user['User']['preferences']);
                        }
                        
                        if(isset($preferences) && isset($preferences['UserPreference']['is_complete']) && ($preferences['UserPreference']['is_complete'] == "completed" || $preferences['UserPreference']['is_complete'] == "1")){
                            $ret['profile_status'] = "complete";
                        }
                        else{
                            $ret['profile_status'] = "incomplete";
                            $ret['profile_msg'] = "Dear " . ucfirst($user['User']['first_name']) . ", <br>You have liked an item in The Closet, so let one of our style experts use this information to provide you with more item recommendations. Fill out our quick style profile form and get assigned a personal stylist.";
                        }
                        
                        $ret['status'] = "ok";
                        $ret['msg'] = 'Item added to liked items.';
                    } else {
                        $ret['status'] = "error";
                        $ret['msg'] = 'Item could not be liked.';
                    }
                } else {
                    $ret['status'] = "error";
                    $ret['msg'] = 'Item has already been liked.';
                }
            }
        }
        else {
        	$ret['status'] = "error";
        }

        echo json_encode($ret);
        exit;
	}

    public function remove(){
        $ret = array();
        $user_id = $this->getLoggedUserID();

        if ($this->request->is('ajax')) {
            $product_id = $this->request->data['product_id'];

            if ($result = $this->Wishlist->remove($user_id, $product_id)) {
                $ret['status'] = "ok";
                $ret['msg'] = 'Item has been removed from liked items.';
            } else {
                $ret['status'] = "error";
                $ret['msg'] = 'Sorry, item could not be removed right now.';
            }
        }

        echo json_encode($ret);
        exit;
    }
}