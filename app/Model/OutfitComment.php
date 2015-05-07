<?php 
class OutfitComment extends AppModel{
	var $name = 'OutfitComment';
	public $belongsTo = array(
						'Outfit' => array(
				            'className' => 'Outfit',
				            'foreignKey' => 'outfit_id',
				            'fields'=>array(
				            	'id','outfit_name'
				            )
				        ),
						'User' => array(
				            'className' => 'User',
				            'foreignKey' => 'user_id',
				            'fields'=>array(
				            	'id','first_name','full_name'
				            )
				        )
	);

	function get_comments($num=null,$conditions=null){	//fetch outfit comments
		$OutfitComment = ClassRegistry::init('OutfitComment');
		$comments = $OutfitComment->find($num,$conditions);
		return $comments;
		
	}

	function save_comment($data=null){	//	add or update a comment
		$OutfitComment = ClassRegistry::init('OutfitComment');
		if($OutfitComment->save($data))	{
			return 'success';
		}
		else{
			return 'fail';
		}
	}
	
}

?>