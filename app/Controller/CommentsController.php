<?php 
class CommentsController extends AppController {
	public $uses = array('OutfitComment');
	public function add_comment() {
		$user = $this->Session->read('user');
		$data = $this->data;
		if($user)
		{
			$data['OutfitComment']['user_id'] = $user['User']['id'];
		}
		$data['OutfitComment']['comment'] = trim($data['OutfitComment']['comment']);
		$data['OutfitComment']['disabled'] = PRE_MOD;
		$data['OutfitComment']['time'] = time();
		if($data['OutfitComment']['comment']){
			$result = $this->OutfitComment->save_comment($data);
			echo $result;
		}
		die;
	}
}

?>