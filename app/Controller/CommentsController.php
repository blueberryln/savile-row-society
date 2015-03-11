<?php 
class CommentsController extends AppController {
	
	public function add_comment() {
		$this->loadModel('OutfitComment');
		$user = $this->getLoggedUser();
		if($user && !$user['User']['is_admin'])
		{
			$data['OutfitComment']['user_name'] = $user['User']['full_name'];
			$data['OutfitComment']['user_id'] = $user['User']['id'];
		}
		else{
			$data['OutfitComment']['user_name'] = 'Guest';
		}
		if($user['User']['is_admin']){
			$data['OutfitComment']['user_name'] = 'Admin';
		}
		$data['OutfitComment']['outfit_id'] = $_POST['outfit_id'];
		$data['OutfitComment']['outfit_name'] = $_POST['outfit_name'];
		$data['OutfitComment']['comment'] = trim($_POST['comment']);
		if(PRE_MOD){
			$data['OutfitComment']['disabled'] = 1;
		}
		else{
			$data['OutfitComment']['disabled'] = 0;
		}
		$data['OutfitComment']['time'] = time();
		if($data['OutfitComment']['comment']){
			$this->OutfitComment->save($data);
			echo 'success';
		}
		//print_r($data);
		die;
	}
}

?>