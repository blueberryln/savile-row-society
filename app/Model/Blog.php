<?php
class Blog extends AppModel{

	function get_posts($num=null,$conditions=null){
		$Blog = ClassRegistry::init('Blog');
		$posts = $Blog->find($num,$conditions);
		return $posts;
	}
	
	function add_new_blogpost($data){
		$Blog = ClassRegistry::init('Blog');
		//pr($data);
		$allowedImgTypes = array('image/gif','image/jpeg','image/png');
		$destination = realpath('../webroot/files/blog');
		if(in_array($data['Blog']['image']['type'],$allowedImgTypes)){
			$newImgName = time().'_'.rand(1000,10000000);
			$fileType = explode('/',$data['Blog']['image']['type']);
			$newImgName = $newImgName.'.'.$fileType[1];
			$destination = realpath('../webroot/files/blog'). '/'.$newImgName;
			if(move_uploaded_file($data['Blog']['image']['tmp_name'], $destination.$newImgName)){
				$data['Blog']['image'] = $newImgName;
			}
			else{
				return 'file not uploaded';
			}
		}
		if($Blog->save($data)){
			return 'success';
		}	
		else{
			return 'fail';
		}
	}

	function update_blogpost($data=null,$oldImg=null){
		$Blog = ClassRegistry::init('Blog');
		//pr($posts);die;
		$allowedImgTypes = array('image/gif','image/jpeg','image/png');
		$destination = realpath('../webroot/files/blog');
		if(in_array($data['Blog']['image']['type'],$allowedImgTypes)){
			$newImgName = time().'_'.rand(1000,10000000);
			$fileType = explode('/',$data['Blog']['image']['type']);
			$newImgName = $newImgName.'.'.$fileType[1];
			$destination = realpath('../webroot/files/blog'). '/';
			unlink($destination.$oldImg);
			if(move_uploaded_file($data['Blog']['image']['tmp_name'], $destination.$newImgName)){
				$data['Blog']['image'] = $newImgName;
				
			}
			else{
				return 'file not uploaded';
			}
		}
		if($Blog->save($data)){
			return 'success';
		}	
		else{
			return 'fail';
		}
	}




}
?>