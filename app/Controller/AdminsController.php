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

	function outfit_comments(){		//fetch recent 15 comments.
		$limit = 10;
		$this->layout = 'adminlte';
		$conditions = array('order'=>'OutfitComment.id desc','limit'=>$limit,'recursive'=>1);
		//	$data = $this->OutfitComment->get_comments('all');
		$this->paginate = $conditions;
		$comments = $this->paginate('OutfitComment');
		$this->set(compact('comments'));
		//pr($comments);die;
	}
	

	function add_comments(){
		$this->loadModel('User');
		$stylists = $this->User->find('all',array('conditions'=>array('User.is_stylist'=>1),'fields'=>array('id','full_name')));
		$user = $this->Session->read('user');
		$this->layout = 'adminlte';
		$data = $this->data;
		$this->set(compact('data','stylists'));
		if(!empty($data)){
			$data['OutfitComment']['user_id'] = $user['User']['id'];
			$data['OutfitComment']['comment'] = trim($data['OutfitComment']['comment']);
			$data['OutfitComment']['time'] = time();
			if($data['OutfitComment']['comment'] && $data['OutfitComment']['outfit_id']){
				$result = $this->OutfitComment->save_comment($data);
				if($result == 'success'){
					$this->redirect(array('controller'=>'admins','action'=>'outfit_comments'));
				}
			}
			else{
				$this->redirect($this->referer());
			}
		}
	}

	function edit_comments($id=null){
		$this->layout = 'adminlte';
		$this->loadModel('User');
		$stylists = $this->User->find('all',array('conditions'=>array('User.is_stylist'=>1),'fields'=>array('id','full_name')));
		$OutfitComment_id = convert_uudecode(base64_decode($id));
		$conditions = array('conditions'=>array('OutfitComment.id'=>$OutfitComment_id),'recursive'=>1);
		$comments = $this->OutfitComment->get_comments('first',$conditions);
		$this->set(compact('comments','stylists'));
		$data = $this->data;
		if(!empty($data)){
			$data['OutfitComment']['id'] = $OutfitComment_id;
			$result = $this->OutfitComment->save_comment($data);
			if($result == 'success'){
					$this->redirect(array('controller'=>'admins','action'=>'outfit_comments'));
				}
			else{
			$this->redirect($this->referer());
			}
		}
			
	}
	/* Ajax functions begins */
	function status($model=null,$id=null,$status=null){
		if ($this->request->is('ajax')) {
			$this->loadModel($model);
			//$id = convert_uudecode(base64_decode($id));
			$updatestatus = array('0'=>1,'1'=>0);
			$this->$model->id = $id;
			if($this->$model->saveField('disabled',$updatestatus[$status])){
				echo $updatestatus[$status];
			}
			else {
				echo 'fail';
			}
		}
		else{
			$this->redirect('/admins/blog');
		}	
		die;
	}

	function delete($model=null,$id=null){
		if ($this->request->is('ajax')) {
			$this->loadModel($model);
			$id = convert_uudecode(base64_decode($id));
			if($model == 'Blog'){
				$image = $this->Blog->findById($id);
				$oldImg = $image['Blog']['image'];
				$destination = realpath('../../app/webroot/files/blog'). '/';
				unlink($destination.$oldImg);
			}
			if($this->$model->delete($id)){
				echo $id;
			}
			else{
				echo 'fail';
			}
		}
		else{
			$this->redirect('/admins/blog');
		}	
		die;

	}
	// function to fetch outfits listed by stylist_id
	function select_outfit($stylist_id = null){
		$this->loadModel('Outfit');
		$this->layout = '';
		$outfits = $this->Outfit->find('all',array('conditions'=>array('Outfit.stylist_id'=>$stylist_id,'Outfit.outfit_name !='=>NULL),'fields'=>array('id','outfit_name')));
		if(!empty($outfits)){
			$list .= '<option value="" >--Select--</option>';
			foreach($outfits as $outfit){
				$list .= '<option value = '.$outfit['Outfit']['id'].'>'.$outfit['Outfit']['outfit_name'].'</option>';
			}
		} else{
			$list .= '<option value="" >No Outfits added by the stylist.</option>';
		}	
		echo $list;die;
	}

	/* Ajax functions ends */
	
	function blog(){	//fetch recent 15 blog posts.
		$this->loadModel('Blog');
		$this->layout = 'adminlte';
		$limit = 15;
		$conditions = array('order'=>'Blog.id desc','limit'=>$limit,);
		//$data = $this->Blog->get_posts('all');
		$this->paginate = $conditions;
		$posts = $this->paginate('Blog');
		$this->set(compact('posts'));
		//pr($posts);
		//die;
	}

	function add_blogpost(){
		$this->loadModel('Blog');
		$this->layout = 'adminlte';
		$data = $this->data;
		$this->set(compact('data'));
		if(!empty($data)){
			$data['Blog']['time'] = time();
			if($data['Blog']['link'] && $data['Blog']['file']){
				$result = $this->Blog->add_new_blogpost($data);
				if($result == 'success'){
					$this->redirect(array('controller'=>'admins','action'=>'blog'));
				}
			}
		}
	}

	function edit_blogpost($id=null){
		$this->loadModel('Blog');
		$this->layout = 'adminlte';
		$id = convert_uudecode(base64_decode($id));
		$conditions = array('conditions'=>array('Blog.id'=>$id));
		$posts = $this->Blog->get_posts('first',$conditions);
		$this->set(compact('posts'));
		$data = $this->data;
		if(!empty($data)){
			if($data['Blog']['link'] && $data['Blog']['title']){
				$data['Blog']['id'] = $id;
				$data['Blog']['time'] = time();
				$result = $this->Blog->update_blogpost($data,$posts['Blog']['image']);
				if($result == 'success'){
					$this->redirect(array('controller'=>'admins','action'=>'blog'));
				}
			}
			else{
				echo 'All Fields are mandatory.';
			}
		}
	}
}


?>