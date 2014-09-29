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
    	

    	return $outfits;
    }

}
