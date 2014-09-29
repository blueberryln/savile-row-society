<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Stylists Controller
 */
class StylistsController extends AppController {

    // stylist Biography 

    public function biography($id = null) {
        $this->isLogged();
        $User = ClassRegistry::init('User');
        $Outfit = ClassRegistry::init('Outfit');
        if (!$User->exists($id)) {
                throw new NotFoundException(__('Invalid user'));
            }
        
        $user = $User->findById($id);
        $current_user = $this->getLoggedUser();
        if($id != $current_user['User']['id'] && !$current_user['User']['is_admin'] && $current_user['User']['id'] != $user['User']['stylist_id']){
            $this->redirect('/');
            exit;
        }
        $stylists = $User->find('all',array('conditions'=>array('User.is_stylist'=>true)));
        $outfits = $Outfit->find('all',array('conditions'=>array('Outfit.stylist_id'=>$id,),'fields'=>'Outfit.outfit_name,Outfit.id'));
        $StylistBio = ClassRegistry::init('StylistBio');
        //$StylistPhotostream = ClassRegistry::init('StylistPhotostream');
        $Outfit = ClassRegistry::init('Outfit');
        $StylistTopOutfit = ClassRegistry::init('StylistTopOutfit');
        $OutfitItem = ClassRegistry::init('OutfitItem');
        $Entity = ClassRegistry::init('Entity');

        $StylistBioData = $StylistBio->find('all',array('conditions'=>array('StylistBio.stylist_id'=>$id,)));


        
        $StylistTopOutfit = ClassRegistry::init('StylistTopOutfit');
        $OutfitItem = ClassRegistry::init('OutfitItem');
        $Entity = ClassRegistry::init('Entity'); 
        // get Top outfit All data
        $OutfitTopData = $StylistTopOutfit->find('all',array('conditions'=>array('StylistTopOutfit.stylist_id'=>$id,)));
        
        $my_outfit = array();
        foreach($OutfitTopData as $row){
            $outfitfirstId = $row['StylistTopOutfit']['outfit_id'];
        
            $outfitnames = $Outfit->find('all', array('conditions'=> array('Outfit.id'=>$outfitfirstId)));
            $outfitProductEntity = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $outfitfirstId)));
            $entities = array();
                foreach($outfitProductEntity as $value){
                    $entities[] = $value['OutfitItem']['product_entity_id'];
                }
           
            $find_array = array(
                'contain' => array('Image', 'Color', 'Detail'),
                'conditions' => array('Entity.id' => $entities),
                'joins' => array(
                    array('table' => 'products',
                        'alias' => 'Product',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Product.id = Entity.product_id'
                        )
                    ),
                    array('table' => 'brands',
                        'alias' => 'Brand',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Product.brand_id = Brand.id',
                        )
                    ),        
                ), 
                'fields' => array(
                    'Entity.*', 'Product.*', 'Brand.*',
                ),
            );
            $entity_list = $Entity->find('all',$find_array);
            $my_outfit[] =  array(
                'outfit'    => $outfitnames,
                'entities'  => $entity_list
                );
            }
        

        $this->set(compact('StylistBioData','stylistphoto','outfits','my_outfit','stylistoutfit','user','stylists'));
       
       //exit;
    }

    public function saveBiography($stylistId = null){
        $this->layout = 'ajax';
        $this->autoRender = false;
        $StylistBio = ClassRegistry::init('StylistBio');

        $BiographyData = $StylistBio->find('first',array('conditions'=>array('StylistBio.stylist_id'=>$stylistId,)));
        
        $StylistBioId = $BiographyData['StylistBio']['id'];
        if($BiographyData){
            $stylist_bio = $this->request->data['stylist_bio'];
            $stylist_id = $this->request->data['stylist_id'];
            $this->request->data['StylistBio']['stylist_bio'] =  $stylist_bio;
            $this->request->data['StylistBio']['stylist_id'] =  $stylist_id;
            $this->request->data['StylistBio']['id'] =  $StylistBioId;
            $StylistBio->save($this->request->data);
            
        }else{

            $stylist_bio = $this->request->data['stylist_bio'];
            $stylist_id = $this->request->data['stylist_id'];
            $this->request->data['StylistBio']['stylist_bio'] =  $stylist_bio;
            $this->request->data['StylistBio']['stylist_id'] =  $stylist_id;
            $StylistBio->save($this->request->data);
            
        }
        
        $BioData = $StylistBio->find('all',array('conditions'=>array('StylistBio.stylist_id'=>$stylist_id,)));
        echo json_encode($BioData);
        exit;

    }

    // stylist inspration
    public function saveInspiration($stylistId = null){
        $this->layout = 'ajax';
        $this->autoRender = false;
        $StylistBio = ClassRegistry::init('StylistBio');

        $BiographyData = $StylistBio->find('first',array('conditions'=>array('StylistBio.stylist_id'=>$stylistId,)));
        
        
        $StylistBioId = $BiographyData['StylistBio']['id'];
        if($BiographyData){
            $stylist_inspiration = $this->request->data['stylist_inspiration'];
            $stylist_id = $this->request->data['stylist_id'];
            $this->request->data['StylistBio']['stylist_inspiration'] =  trim($stylist_inspiration);
            $this->request->data['StylistBio']['stylist_id'] =  $stylist_id;
            $this->request->data['StylistBio']['id'] =  $StylistBioId;
            $StylistBio->save($this->request->data);
            
        }else{

            $stylist_inspiration = $this->request->data['stylist_inspiration'];
            $stylist_id = $this->request->data['stylist_id'];
            $this->request->data['StylistBio']['stylist_inspiration'] =  $stylist_inspiration;
            $this->request->data['StylistBio']['stylist_id'] =  $stylist_id;
            $StylistBio->save($this->request->data);
            
        }
        
        $BioData = $StylistBio->find('all',array('conditions'=>array('StylistBio.stylist_id'=>$stylist_id,)));
        echo json_encode($BioData);
        exit;

    }

    // stylist home town 

    public function saveHometown($stylistId = null){
        $this->layout = 'ajax';
        $this->autoRender = false;
        $StylistBio = ClassRegistry::init('StylistBio');

        $BiographyData = $StylistBio->find('first',array('conditions'=>array('StylistBio.stylist_id'=>$stylistId,)));
        
        if(isset($BiographyData['StylistBio']['id'])){
            $StylistBioId = $BiographyData['StylistBio']['id'];
        }
        
        
        if($BiographyData){
            $hometown = $this->request->data['hometown'];
            $stylist_id = $this->request->data['stylist_id'];
            $this->request->data['StylistBio']['hometown'] =  trim($hometown);
            $this->request->data['StylistBio']['stylist_id'] =  $stylist_id;
            $this->request->data['StylistBio']['id'] =  $StylistBioId;
            $StylistBio->save($this->request->data);
            
        }else{

            $hometown = $this->request->data['hometown'];
            $stylist_id = $this->request->data['stylist_id'];
            $this->request->data['StylistBio']['hometown'] =  $hometown;
            $this->request->data['StylistBio']['stylist_id'] =  $stylist_id;
            $StylistBio->save($this->request->data);
            
        }
        
        $BioData = $StylistBio->find('all',array('conditions'=>array('StylistBio.stylist_id'=>$stylist_id,)));
        echo json_encode($BioData);
        exit;

    }


    // stylist saveFunfact

    public function saveFunfact($stylistId = null){
        $this->layout = 'ajax';
        $this->autoRender = false;
        $StylistBio = ClassRegistry::init('StylistBio');

        $BiographyData = $StylistBio->find('first',array('conditions'=>array('StylistBio.stylist_id'=>$stylistId,)));
        
        $StylistBioId = $BiographyData['StylistBio']['id'];
        if($BiographyData){
            $funfact = $this->request->data['funfact'];
            $stylist_id = $this->request->data['stylist_id'];
            $this->request->data['StylistBio']['funfact'] =  trim($funfact);
            $this->request->data['StylistBio']['stylist_id'] =  $stylist_id;
            $this->request->data['StylistBio']['id'] =  $StylistBioId;
            $StylistBio->save($this->request->data);
            
        }else{

            $hometown = $this->request->data['funfact'];
            $stylist_id = $this->request->data['stylist_id'];
            $this->request->data['StylistBio']['funfact'] =  $funfact;
            $this->request->data['StylistBio']['stylist_id'] =  $stylist_id;
            $StylistBio->save($this->request->data);
            
        }
        
        $BioData = $StylistBio->find('all',array('conditions'=>array('StylistBio.stylist_id'=>$stylist_id,)));
        echo json_encode($BioData);
        exit;

    }


    // stylist saveFashionTip

    public function saveFashionTip($stylistId = null){
        $this->layout = 'ajax';
        $this->autoRender = false;
        $StylistBio = ClassRegistry::init('StylistBio');

        $BiographyData = $StylistBio->find('first',array('conditions'=>array('StylistBio.stylist_id'=>$stylistId,)));
        
        $StylistBioId = $BiographyData['StylistBio']['id'];
        if($BiographyData){
            $fashion_tip = $this->request->data['fashion_tip'];
            $stylist_id = $this->request->data['stylist_id'];
            $this->request->data['StylistBio']['fashion_tip'] =  trim($fashion_tip);
            $this->request->data['StylistBio']['stylist_id'] =  $stylist_id;
            $this->request->data['StylistBio']['id'] =  $StylistBioId;
            $StylistBio->save($this->request->data);
            
        }else{

            $fashion_tip = $this->request->data['fashion_tip'];
            $stylist_id = $this->request->data['stylist_id'];
            $this->request->data['StylistBio']['fashion_tip'] =  $fashion_tip;
            $this->request->data['StylistBio']['stylist_id'] =  $stylist_id;
            $StylistBio->save($this->request->data);
            
        }
        
        $BioData = $StylistBio->find('all',array('conditions'=>array('StylistBio.stylist_id'=>$stylist_id,)));
        echo json_encode($BioData);
        exit;

    }

    // savePhotoStream

    public function savePhoto($stylistId = null){
        $this->layout = 'ajax';
        $this->autoRender = false;
        $StylistPhotostream = ClassRegistry::init('StylistPhotostream');
            if($this->request->is('post') || $this->request->is('put')){

                $this->request->data['StylistPhotostream']['stylist_id'] =  $stylistId;
                $is_profile = $this->request->data['StylistPhotostream']['is_profile'];
                
                if($imagename = $this->savePhotostream()){
                    $this->request->data['StylistPhotostream']['image'] = $imagename;
                }else{
                    $this->request->data['StylistPhotostream']['image'] = null;
                }

                if($StylistPhotostream->save($this->request->data)){
                    $this->Session->setFlash("StylistPhotostream Data Hasbeen Saved");

                    if($is_profile == 'on'){
                        $User = ClassRegistry::init('User');
                        $user = $User->findById($stylistId);
                        $this->request->data['User']['profile_photo_url'] =  $imagename;
                        $this->request->data['User']['id'] = $stylistId;
                        $User->save($this->request->data);
                        
                    }else{
                        $this->Session->setFlash('The User Photo could not be saved. Please, try again.');
                    }
                    $this->redirect(array('action' => '/biography/'.$stylistId));    
                }else{
                    $this->Session->setFlash('The StylistPhotostream could not be saved. Please, try again.');
                }


            }

        $PhotoStreamData = $StylistPhotostream->find('all',array('conditions'=>array('StylistPhotostream.stylist_id'=>$stylistId,)));
        $this->set(compact('PhotoStreamData'));
        //exit;

    }

    // stylist  saveOutfitFirst

    public function saveOutfitFirst($stylistId = null){
        $StylistTopOutfit = ClassRegistry::init('StylistTopOutfit');
        $Outfit = ClassRegistry::init('Outfit');
        $OutfitItem = ClassRegistry::init('OutfitItem');
        $Entity = ClassRegistry::init('Entity');    
        $this->layout = 'ajax';
        $this->autoRender = false;
        $OutfitData = $StylistTopOutfit->find('first',array('conditions'=>array('StylistTopOutfit.stylist_id'=>$stylistId,'StylistTopOutfit.order_id = 1')));
        if(isset($OutfitData['StylistTopOutfit']['id'])){
            $OutfitDataId = $OutfitData['StylistTopOutfit']['id'];
        }
        if(isset($OutfitData)){
            $outfit_id = $this->request->data['outfit_id'];
            
            $this->request->data['StylistTopOutfit']['outfit_id'] =  trim($outfit_id);
            $this->request->data['StylistTopOutfit']['stylist_id'] =  $stylistId;
            $this->request->data['StylistTopOutfit']['order_id'] =  1;
            $this->request->data['StylistTopOutfit']['id'] =  $OutfitDataId;
            $StylistTopOutfit->save($this->request->data);
            
        }else{

            $outfit_id = $this->request->data['outfit_id'];
            $this->request->data['StylistTopOutfit']['outfit_id'] =  trim($outfit_id);
            $this->request->data['StylistTopOutfit']['stylist_id'] =  $stylistId;
            $StylistTopOutfit->save($this->request->data);
            
        }
        
        $OutfitTopData = $StylistTopOutfit->find('all',array('conditions'=>array('StylistTopOutfit.stylist_id'=>$stylistId,'StylistTopOutfit.order_id = 1')));
        
        // get Top outfit first data
        $my_outfit = array();
        foreach($OutfitTopData as $row){
            $outfitfirstId = $row['StylistTopOutfit']['outfit_id'];
        
            $outfitnames = $Outfit->find('first', array('conditions'=> array('Outfit.id'=>$outfitfirstId)));
            $outfitProductEntity = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $outfitfirstId)));
            $entities = array();
                foreach($outfitProductEntity as $value){
                    $entities[] = $value['OutfitItem']['product_entity_id'];
                }
           
            $find_array = array(
                'contain' => array('Image', 'Color', 'Detail'),
                'conditions' => array('Entity.id' => $entities),
                'joins' => array(
                    array('table' => 'products',
                        'alias' => 'Product',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Product.id = Entity.product_id'
                        )
                    ),
                    array('table' => 'brands',
                        'alias' => 'Brand',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Product.brand_id = Brand.id',
                        )
                    ),        
                ), 
                'fields' => array(
                    'Entity.*', 'Product.*', 'Brand.*',
                ),
            );
            $entity_list = $Entity->find('all',$find_array);
            $my_outfit[] =  array(
                'outfit'    => $outfitnames,
                'entities'  => $entity_list
                );
            }
        echo json_encode($my_outfit);
        exit;
    
    }


    // stylist  saveOutfitSecond

    public function saveOutfitSecond($stylistId = null){
        $StylistTopOutfit = ClassRegistry::init('StylistTopOutfit');
        $Outfit = ClassRegistry::init('Outfit');
        $OutfitItem = ClassRegistry::init('OutfitItem');
        $Entity = ClassRegistry::init('Entity');    
        $this->layout = 'ajax';
        $this->autoRender = false;
        $OutfitData = $StylistTopOutfit->find('first',array('conditions'=>array('StylistTopOutfit.stylist_id'=>$stylistId,'StylistTopOutfit.order_id = 2')));
        if(isset($OutfitData['StylistTopOutfit']['id'])){
            $OutfitDataId = $OutfitData['StylistTopOutfit']['id'];
        }
        
        if(isset($OutfitData)){
            $outfit_id = $this->request->data['outfit_id'];
            
            $this->request->data['StylistTopOutfit']['outfit_id'] =  trim($outfit_id);
            $this->request->data['StylistTopOutfit']['stylist_id'] =  $stylistId;
            $this->request->data['StylistTopOutfit']['order_id'] =  2;
            $this->request->data['StylistTopOutfit']['id'] =  $OutfitDataId;
            $StylistTopOutfit->save($this->request->data);
            
        }else{

            $outfit_id = $this->request->data['outfit_id'];
            $this->request->data['StylistTopOutfit']['outfit_id'] =  trim($outfit_id);
            $this->request->data['StylistTopOutfit']['stylist_id'] =  $stylistId;
            $StylistTopOutfit->save($this->request->data);
            
        }
        
        $OutfitTopData = $StylistTopOutfit->find('all',array('conditions'=>array('StylistTopOutfit.stylist_id'=>$stylistId,'StylistTopOutfit.order_id = 2')));
        
        // get Top outfit first data
        $my_outfit = array();
        foreach($OutfitTopData as $row){
            $outfitfirstId = $row['StylistTopOutfit']['outfit_id'];
        
            $outfitnames = $Outfit->find('first', array('conditions'=> array('Outfit.id'=>$outfitfirstId)));
            $outfitProductEntity = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $outfitfirstId)));
            $entities = array();
                foreach($outfitProductEntity as $value){
                    $entities[] = $value['OutfitItem']['product_entity_id'];
                }
           
            $find_array = array(
                'contain' => array('Image', 'Color', 'Detail'),
                'conditions' => array('Entity.id' => $entities),
                'joins' => array(
                    array('table' => 'products',
                        'alias' => 'Product',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Product.id = Entity.product_id'
                        )
                    ),
                    array('table' => 'brands',
                        'alias' => 'Brand',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Product.brand_id = Brand.id',
                        )
                    ),        
                ), 
                'fields' => array(
                    'Entity.*', 'Product.*', 'Brand.*',
                ),
            );
            $entity_list = $Entity->find('all',$find_array);
            $my_outfit[] =  array(
                'outfit'    => $outfitnames,
                'entities'  => $entity_list
                );
            }
        echo json_encode($my_outfit);
        exit;
    
    }


    // stylist  saveOutfitThird

    public function saveOutfitThird($stylistId = null){
        $StylistTopOutfit = ClassRegistry::init('StylistTopOutfit');
        $Outfit = ClassRegistry::init('Outfit');
        $OutfitItem = ClassRegistry::init('OutfitItem');
        $Entity = ClassRegistry::init('Entity');    
        $this->layout = 'ajax';
        $this->autoRender = false;
        $OutfitData = $StylistTopOutfit->find('first',array('conditions'=>array('StylistTopOutfit.stylist_id'=>$stylistId,'StylistTopOutfit.order_id = 3')));
        if(isset($OutfitData['StylistTopOutfit']['id'])){
            $OutfitDataId = $OutfitData['StylistTopOutfit']['id'];
        }
        if(isset($OutfitData)){
            $outfit_id = $this->request->data['outfit_id'];
            
            $this->request->data['StylistTopOutfit']['outfit_id'] =  trim($outfit_id);
            $this->request->data['StylistTopOutfit']['stylist_id'] =  $stylistId;
            $this->request->data['StylistTopOutfit']['order_id'] =  3;
            $this->request->data['StylistTopOutfit']['id'] =  $OutfitDataId;
            $StylistTopOutfit->save($this->request->data);
            
        }else{

            $outfit_id = $this->request->data['outfit_id'];
            $this->request->data['StylistTopOutfit']['outfit_id'] =  trim($outfit_id);
            $this->request->data['StylistTopOutfit']['stylist_id'] =  $stylistId;
            $StylistTopOutfit->save($this->request->data);
            
        }
        
        $OutfitTopData = $StylistTopOutfit->find('all',array('conditions'=>array('StylistTopOutfit.stylist_id'=>$stylistId,'StylistTopOutfit.order_id = 3')));
        
        // get Top outfit first data
        $my_outfit = array();
        foreach($OutfitTopData as $row){
            $outfitfirstId = $row['StylistTopOutfit']['outfit_id'];
        
            $outfitnames = $Outfit->find('first', array('conditions'=> array('Outfit.id'=>$outfitfirstId)));
            $outfitProductEntity = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $outfitfirstId)));
            $entities = array();
                foreach($outfitProductEntity as $value){
                    $entities[] = $value['OutfitItem']['product_entity_id'];
                }
           
            $find_array = array(
                'contain' => array('Image', 'Color', 'Detail'),
                'conditions' => array('Entity.id' => $entities),
                'joins' => array(
                    array('table' => 'products',
                        'alias' => 'Product',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Product.id = Entity.product_id'
                        )
                    ),
                    array('table' => 'brands',
                        'alias' => 'Brand',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Product.brand_id = Brand.id',
                        )
                    ),        
                ), 
                'fields' => array(
                    'Entity.*', 'Product.*', 'Brand.*',
                ),
            );
            $entity_list = $Entity->find('all',$find_array);
            $my_outfit[] =  array(
                'outfit'    => $outfitnames,
                'entities'  => $entity_list
                );
            }
        echo json_encode($my_outfit);
        exit;
    
    }

// for photo stream images

    public function savePhotostream() {
        $imagename = null;
        $image_type = '';
        $image_size = '';
        // get edditing in user

        // file upload

        if ($this->request->data['StylistPhotostream']['image'] && $this->request->data['StylistPhotostream']['image']['size'] > 0) {

            $allowed = array('image/jpeg', 'image/gif', 'image/png', 'image/x-png', 'image/x-citrix-png', 'image/x-citrix-jpeg', 'image/pjpeg');

            if (!in_array($this->request->data['StylistPhotostream']['image']['type'], $allowed)) {
                $this->Session->setFlash(__('You have to upload an image.'), 'flash');
            } else if ($this->request->data['StylistPhotostream']['image']['size'] > 5242880) {
                $this->Session->setFlash(__('Attached image must be up to 5 MB in size.'), 'flash');
                $this->redirect('Auth/stylistbio/' . $id);
                exit;
            } else {
                $imagename = time() .  '_' . $this->request->data['StylistPhotostream']['image']['name'];
                $image_type = $this->request->data['StylistPhotostream']['image']['type'];
                $image_size = $this->request->data['StylistPhotostream']['image']['size'];
                $img_path = APP . 'webroot' . DS . 'files' . DS . 'photostream' . DS . $imagename;
                move_uploaded_file($this->request->data['StylistPhotostream']['image']['tmp_name'], $img_path);
                return $imagename;
            //print_r($imagename);
            }
        }
    }


// stylist biography details

    public function stylistbiography($id= null){

        $User = ClassRegistry::init('User');
        $StylistBio = ClassRegistry::init('StylistBio');
        $StylistTopOutfit = ClassRegistry::init('StylistTopOutfit');
        $Outfit = ClassRegistry::init('Outfit');
        $OutfitItem = ClassRegistry::init('OutfitItem');
        $Entity = ClassRegistry::init('Entity');
        $users = $User->findById($id);
        //print_r($user);
        $stylists = $User->find('all',array('conditions'=>array('User.is_stylist'=>true)));
        $outfits = $Outfit->find('all',array('conditions'=>array('Outfit.stylist_id'=>$id,),'fields'=>'Outfit.outfit_name,Outfit.id'));
        $StylistBio = ClassRegistry::init('StylistBio');
        //$StylistPhotostream = ClassRegistry::init('StylistPhotostream');
        $StylistBioData = $StylistBio->find('all',array('conditions'=>array('StylistBio.stylist_id'=>$id,)));

        // get Top outfit All data
        $OutfitTopData = $StylistTopOutfit->find('all',array('conditions'=>array('StylistTopOutfit.stylist_id'=>$id,)));
        
        $my_outfit = array();
        foreach($OutfitTopData as $row){
            $outfitfirstId = $row['StylistTopOutfit']['outfit_id'];
        
            $outfitnames = $Outfit->find('all', array('conditions'=> array('Outfit.id'=>$outfitfirstId)));
            $outfitProductEntity = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $outfitfirstId)));
            $entities = array();
                foreach($outfitProductEntity as $value){
                    $entities[] = $value['OutfitItem']['product_entity_id'];
                }
           
            $find_array = array(
                'contain' => array('Image', 'Color', 'Detail'),
                'conditions' => array('Entity.id' => $entities),
                'joins' => array(
                    array('table' => 'products',
                        'alias' => 'Product',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Product.id = Entity.product_id'
                        )
                    ),
                    array('table' => 'brands',
                        'alias' => 'Brand',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Product.brand_id = Brand.id',
                        )
                    ),        
                ), 
                'fields' => array(
                    'Entity.*', 'Product.*', 'Brand.*',
                ),
            );
            $entity_list = $Entity->find('all',$find_array);
            $my_outfit[] =  array(
                'outfit'    => $outfitnames,
                'entities'  => $entity_list
                );
            }
        

        $this->set(compact('users','StylistBioData','stylistphoto','outfits','my_outfit','stylistoutfit','stylists'));

    }
     
    


	public function admin_topstylist(){
        $this->layout = 'admin';
        $this->isAdmin();
       
       	$TopStylist = ClassRegistry::init('TopStylist');
        if($this->request->is('post')){
            $data = $this->request->data;
            $stylist = $TopStylist->getByUserId($data['TopStylist']['user_id']);

            // $total = $TopStylist->find('count');

            // echo $total;
            // exit;

            if($stylist){
            	$this->Session->setFlash(__('Stylist already exists.'), 'flash');
                $this->redirect(array('action' => 'topstylist'));
                exit;
            }
            else if ($stylist = $TopStylist->save($data)){
            	$TopStylist->updateAll(
	        		array('order_id' => 'order_id + 1'),
	        		array('order_id >= ' => $data['TopStylist']['order_id'], 'id !=' => $stylist['TopStylist']['id'])
        		);

            	$this->Session->setFlash(__('The stylist has been added.'), 'flash');
                $this->redirect(array('action' => 'topstylist'));
                exit;
            }
            else{
            	$this->Session->setFlash(__('The stylist could not be saved. Please, try again.'), 'flash');
            	$this->redirect(array('action' => 'topstylist'));
            	exit;
            }
        }

        $User = ClassRegistry::init('User');
        $stylists = $User->find('all', array('conditions'=>array('is_stylist' => true)));
        
        $topStylists = $TopStylist->getTopStylists();

        $this->set(compact('stylists', 'topStylists'));
    }


    public function admin_edit_topstylist($id){
        $this->layout = 'admin';
        $this->isAdmin();
       
       	$TopStylist = ClassRegistry::init('TopStylist');

        if (!$TopStylist->exists($id)) {
            throw new NotFoundException(__('Invalid Stylist'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            
        	$data = $TopStylist->findById($id);
        	$old_order_id = $data['TopStylist']['order_id'];
        	if($this->request->data['TopStylist']['order_id'] > 0){
        		$data['TopStylist']['order_id'] = $this->request->data['TopStylist']['order_id'];
        	}

            if ($TopStylist->save($data)) {
            	if($old_order_id < $data['TopStylist']['order_id']){
            		$TopStylist->updateAll(
		        		array('order_id' => 'order_id - 1'),
		        		array('order_id > ' => $old_order_id, 'order_id <=' => $data['TopStylist']['order_id'],'id !=' => $data['TopStylist']['id'])
	        		);	
            	}
            	else if($old_order_id > $data['TopStylist']['order_id']){
            		$TopStylist->updateAll(
		        		array('order_id' => 'order_id + 1'),
		        		array('order_id < ' => $old_order_id, 'order_id >=' => $data['TopStylist']['order_id'],'id !=' => $data['TopStylist']['id'])
	        		);	
            	}


                $this->Session->setFlash(__('The stylist has been saved.'), 'flash');
                $this->redirect(array('action' => 'topstylist'));
                exit;
            } else {
                $this->Session->setFlash(__('The stylist could not be saved. Please, try again.'), 'flash');
            	$this->redirect(array('action' => 'topstylist'));
            	exit;
            }
        } else {
            $this->request->data = $TopStylist->findById($id);
            $User = ClassRegistry::init('User');
            $stylist = $User->findById($this->request->data['TopStylist']['user_id']);

            $this->set(compact('stylist'));
        }
    }



    public function admin_delete_topstylist($id){
        $this->layout = 'admin';
        $this->isAdmin();
       
       	$TopStylist = ClassRegistry::init('TopStylist');

        if (!$TopStylist->exists($id)) {
            throw new NotFoundException(__('Invalid Stylist'));
        }
            
    	$data = $TopStylist->findById($id);

        if ($data) {
        	$TopStylist->id = $id;
        	$TopStylist->delete();

        	$TopStylist->updateAll(
        		array('order_id' => 'order_id - 1'),
        		array('order_id > ' => $data['TopStylist']['order_id'])
        		);

            $this->Session->setFlash(__('The stylist has been removed.'), 'flash');
            $this->redirect(array('action' => 'topstylist'));
            exit;
        } else {
            $this->Session->setFlash(__('The stylist could not be deleted. Please, try again.'), 'flash');
        	$this->redirect(array('action' => 'topstylist'));
        	exit;
        }

    }

}