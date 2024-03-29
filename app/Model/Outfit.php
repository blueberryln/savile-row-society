<?php

App::uses('AppModel', 'Model');

/**
 * Order Model
 *
 * @property User $User
 * @property Product $Product
 */
class Outfit extends AppModel {
    public $hasMany = array(
        'OutfitItem' => array(
            'className' => 'OutfitItem',
            'foreignKey' => 'outfit_id',
            'conditions' => '',
            'order' => '',
            'limit' => '',
            'dependent' => true         
        ),
        'OutfitComment' => array(
            'className' => 'OutfitComment',
            'foreignKey' => 'outfit_id',
            'conditions' => array('disabled'=>0),
            'order' => 'id desc',
            'dependent' => true         
        ),
    );

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Stylist' => array(
            'className' => 'User',
            'foreignKey' => 'stylist_id',
            'conditions' => '',
            'fields' => array('id', 'first_name', 'last_name', 'profile_photo_url'),
            'order' => ''
        ),
        ''
    );

     function getoutfitpostid($user_id){
        
        $find_array = array(
            'fields' => array('Outfit.*,OutfitItem.*'),
            'joins' => array(
                array(
                    'table' => 'outfits_items',
                    'alias' => 'OutfitItem',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Outfit.id = OutfitItem.outfit_id',
                        'Outfit.stylist_id'=>$user_id,
                        ),
                    ),
                ),
            ); 
       return  $this->find('all', $find_array);
    }

    function getOutfitUserByStylist($stylist_id,$client_id = null){
       $find_array = array(
            'fields' => array('Outfit.id,OutfitItem.product_entity_id,Outfit.outfitname'),
            'joins' => array(
                array(
                    'table' => 'outfits_items',
                    'alias' => 'OutfitItem',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Outfit.id = OutfitItem.outfit_id',
                        'Outfit.stylist_id'=>$stylist_id,
                        'Outfit.user_id' => $client_id
                        ),
                    ),
                ),
            ); 
       return  $this->find('all', $find_array); 

    }

    public function getOutfitList($user_id, $sort, $limit, $page){

        $Message = ClassRegistry::init('Message');
        $outfit_list = $Message->find('all', array(
            'conditions'  => array('user_to_id' => $user_id, 'is_outfit' => 1),
            'order' => array('id' => $sort),
            'fields' => array('id', 'user_to_id', 'user_from_id', 'body', 'is_outfit', 'outfit_id'),
            'limit' => $limit,
            'page'  => $page
        ));

        return $outfit_list;
    }


    public function getStylistOutfitList($user_id, $sort, $limit, $page){

        $Message = ClassRegistry::init('Message');
        $outfit_list = $Message->find('all', array(
            'conditions'  => array('user_from_id' => $user_id, 'is_outfit' => 1),
            'order' => array('id' => $sort),
            'fields' => array('id', 'user_to_id', 'user_from_id', 'body', 'is_outfit', 'outfit_id'),
            'limit' => $limit,
            'page'  => $page
        ));

        return $outfit_list;
    }


    public function getOutfitDetails($outfit_list, $sorted_by_list = false, $user_id = false){

        $outfits = $this->find('all', array(
            'contain'       => array('OutfitItem', 'Stylist','OutfitComment'=>array('User')),
            'conditions'     => array('Outfit.id' => $outfit_list,'Outfit.outfit_name !='=>NULL),
            ));

        $Size = ClassRegistry::init('Size');
        $sizes = $Size->find('list');

        if($outfits){
            $product_list = array();

            foreach($outfits as $outfit){
                foreach ($outfit['OutfitItem'] as $item) {
                    $product_list[] = $item['product_entity_id'];
                }
            }
            $Entity = ClassRegistry::init('Entity');

            $outfit_details = array('Image', 'Detail');

            if($user_id){
                $entities = $Entity->getEntities($product_list, $outfit_details, $user_id);
            }
            else{
                $entities = $Entity->getEntities($product_list, $outfit_details);
            }

            $sorted_entities = array();
            foreach ($entities as $entity) {
                $sorted_entities[$entity['Entity']['id']] = $entity;
            }
            $formatted_outfits = array();

            foreach($outfits as $value){
                foreach ($value['OutfitItem'] as &$item) {
                    if($item['size_id'] && isset($sizes[$item['size_id']])){
                        $item['size'] = $sizes[$item['size_id']];
                    } 
                    if(isset($sorted_entities[$item['product_entity_id']])){
                        $item['product'] = $sorted_entities[$item['product_entity_id']];
                    }
                }   

                $formatted_outfits[$value['Outfit']['id']] = $value;
            }

            if($sorted_by_list){
                $sorted_outfits = array();
                
                foreach($outfit_list as $value){
                    if(isset($formatted_outfits[$value])){
                        $sorted_outfits[] = $formatted_outfits[$value];
                    }
                }

                return $sorted_outfits;
            }
            else{
                return $formatted_outfits;
            }


        }
        else{
            return array();
        }

        return $outfits;

    }


}