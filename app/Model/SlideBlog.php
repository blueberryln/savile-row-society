<?php
class SlideBlog extends AppModel{

	function get_posts($num=null,$conditions=null){
		$SlideBlog = ClassRegistry::init('SlideBlog');
		$posts = $SlideBlog->find($num,$conditions);
		return $posts;
	}
	
	function add_slide_blog_post($data){
		$SlideBlog = ClassRegistry::init('SlideBlog');
		//pr($data);
		$allowedImgTypes = array('image/gif','image/jpeg','image/png');
		$destination = realpath('../webroot/files/blog');
		if(in_array($data['SlideBlog']['file']['type'],$allowedImgTypes)){
			$newImgName = time().'_'.rand(1000,10000000);
			$fileType = explode('/',$data['SlideBlog']['file']['type']);
			$newImgName = $newImgName.'.'.$fileType[1];
			$destination = realpath('../../app/webroot/files/blog'). '/';
			if(move_uploaded_file($data['SlideBlog']['file']['tmp_name'], $destination.$newImgName)){
				$data['SlideBlog']['image'] = $newImgName;
			}
			else{
				return 'file not uploaded';
			}
		}
		if($SlideBlog->save($data)){
			return 'success';
		}	
		else{
			return 'fail';
		}
	}

	function update_slide_blogpost($data=null,$oldImg=null){
		$SlideBlog = ClassRegistry::init('SlideBlog');
		//pr($posts);die;
		$allowedImgTypes = array('image/gif','image/jpeg','image/png');
		$destination = realpath('../webroot/files/blog');
		if(in_array($data['SlideBlog']['file']['type'],$allowedImgTypes)){
			$newImgName = time().'_'.rand(1000,10000000);
			$fileType = explode('/',$data['SlideBlog']['file']['type']);
			$newImgName = $newImgName.'.'.$fileType[1];
			$destination = realpath('../../app/webroot/files/blog'). '/';
			unlink($destination.$oldImg);
			if(move_uploaded_file($data['SlideBlog']['file']['tmp_name'], $destination.$newImgName)){
				$data['SlideBlog']['image'] = $newImgName;
			}
			else{
				return 'file not uploaded';
			}
		}
		if($SlideBlog->save($data)){
			return 'success';
		}	
		else{
			return 'fail';
		}
	}




}
?>