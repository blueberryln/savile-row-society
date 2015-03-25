
<?php

App::uses('AppModel', 'Model');

/**
 * Attached Model
 *
 * @property Attachment $Attachment
 * @property Model $Model
 */
class StylistTopOutfit extends AppModel {
    /**
     * useTable field
     * 
     * @var string
     */
    var $useTable = 'stylist_top_outfits';
    
  	public function getStylistOrderOne($stylistid){
        return $this->find('first',array('conditions'=>array('StylistTopOutfit.stylist_id'=>$stylistid,'StylistTopOutfit.order_id'=>1,)));

    }
    public function getStylistTopOutfittwo($stylistid){
        return $this->find('first',array('conditions'=>array('StylistTopOutfit.stylist_id'=>$stylistid,'StylistTopOutfit.order_id'=>2,)));

    }
    public function getStylistOrderTopOutfitthree($stylistid){
        return $this->find('first',array('conditions'=>array('StylistTopOutfit.stylist_id'=>$stylistid,'StylistTopOutfit.order_id'=>3,)));

    }   
}
