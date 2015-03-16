<?php
class AdminsController extends AppController {
	public $uses = array('OutfitComment');

	function beforeFilter(){
		$user = $this->getLoggedUser();
        $is_admin = false;

        if ($user['User']['is_admin'] == 1) {
            $is_admin = true;
        } else {
            $is_admin = false;
            $this->redirect('/');
        }
	}

	function outfit_comments(){		//fetch recent 20 comments.
		$limit = 20;
		$conditions = array('order'=>'OutfitComment.id desc','limit'=>$limit,'recursive'=>1);
		$comments = $this->OutfitComment->get_comments('all',$conditions);
		$this->set(compact('comments'));
		pr($comments);die;
	}

	function add_comments(){
		$user = $this->Session->read('user');
		$data = $this->data;
		if(!empty($data)){
			$data['OutfitComment']['user_id'] = $user['User']['id'];
			$data['OutfitComment']['comment'] = trim($data['OutfitComment']['comment']);
			$data['OutfitComment']['disabled'] = PRE_MOD;
			$data['OutfitComment']['time'] = time();
			if($data['OutfitComment']['comment'] && $data['OutfitComment']['OutfitComment_id']){
				$result = $this->OutfitComment->save_comment($data);
				echo $result;
			}
		}
	}

	function edit_comments($id=null){
		$OutfitComment_id = convert_uudecode(base64_decode($id));
		$conditions = array('conditions'=>array('OutfitComment.id'=>$OutfitComment_id),'recursive'=>1);
		$comments = $this->OutfitComment->get_comments('first',$conditions);
		$this->set(compact('comments'));
		$data = $this->data;
		if(!empty($data)){
			$result = $this->OutfitComment->save_comment($data);
			echo $result;
		}
		die;
	}

	function status($model=null,$id=null,$status=null){
		$this->loadModel($model);
		$id = convert_uudecode(base64_decode($id));
		$updatestatus = array('0'=>1,'1'=>0);
		$this->$model->id = $id;
		$this->$model->saveField('disabled',$updatestatus[$status]);
		pr($updatestatus[$status]);
		die;
	}

	function delete($model=null,$id=null){
		$this->loadModel($model);
		$id = convert_uudecode(base64_decode($id));
		if($this->$model->delete($id)){
			echo 'success';
		}
		else{
			echo 'fail';
		}
		die;

	}

	function blog(){	//fetch recent 20 blog posts.
		$this->loadModel('Blog');
		$limit = 20;
		$conditions = array('order'=>'Blog.id desc','limit'=>$limit,);
		$posts = $this->Blog->get_posts('all',$conditions);
		$this->set(compact('posts'));
		pr($posts);
		die;
	}

	function add_blogpost(){
		$this->loadModel('Blog');
		$data = $this->data;
		if(!empty($data)){
			$data['Blog']['time'] = time();
			if($data['Blog']['link'] && $data['Blog']['image']){
				$result = $this->Blog->add_new_blogpost($data);
				echo $result;
			}

		}
		die;
	}

	function edit_blogpost($id=null){
		$this->loadModel('Blog');
		$id = convert_uudecode(base64_decode($id));
		$conditions = array('conditions'=>array('Blog.id'=>$id));
		$posts = $this->Blog->get_posts('first',$conditions);
		$this->set(compact('posts'));
		$data = $this->data;
		if($data['Blog']['link'] && $data['Blog']['title']){
			$data['Blog']['id'] = $id;
			$data['Blog']['time'] = time();
			$result = $this->Blog->update_blogpost($data,$posts['Blog']['image']);
			echo $result;
		}
		die;
	}
	
}


?>