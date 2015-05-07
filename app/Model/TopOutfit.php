<?php

App::uses('AppModel', 'Model');

/**
 * TopOutfit Model
 *
 */
class TopOutfit extends AppModel {
     
     /**
     * useTable field
     * 
     * @var string
     */
    var $useTable = 'top_outfits';


    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Outfit' => array(
            'className' => 'Outfit',
            'foreignKey' => 'outfit_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );


    /**
     * Get top outfits
     * 
     * @return array
     */
    public function getTopOutfits(){

    	$outfit_list = $this->find('list', array(
    			'fields'		=> array('outfit_id'),
    			'order'			=> array('order_id'	=> 'asc')
    		));

    	$outfits = array();
    	if($outfit_list){
    		$Outfit = ClassRegistry::init('Outfit');
    		$outfits = $Outfit->getOutfitDetails($outfit_list, true);	
    	}

        $top_outfits = $this->find('all');

        $sorted_outfit = array();
        foreach($top_outfits as $value){
            $sorted_outfit[$value['TopOutfit']['outfit_id']] = $value; 
        }

        foreach($outfits as &$outfit){
            $outfit['TopOutfit'] = $sorted_outfit[$outfit['Outfit']['id']]['TopOutfit'];
        }
    	

    	return $outfits;
    }

    /**
     * Get by user_id
     * 
     * @return array
     */
    public function getByUserId($outfit_id){

        $user = $this->find('first', array(
            'conditions'   => array('outfit_id'  => $outfit_id)
            ));

        return $user;

    }

}
