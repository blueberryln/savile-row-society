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
        
        if($current_user['User']['id'] != $id || !$current_user['User']['is_stylist']){
            $this->redirect('/');
            exit;
        }

        $userlists = $User->find('all',array('conditions'=>array('User.stylist_id'=>$id),'fields'=>array('User.id,User.updated','User.first_name','User.last_name','User.stylist_id','User.profile_photo_url')));

        $stylists = $User->find('all',array('conditions'=>array('User.is_stylist'=>true)));
        $outfits = $Outfit->find('all',array('conditions'=>array('Outfit.stylist_id'=>$id,),'fields'=>'Outfit.outfit_name,Outfit.id'));
        $StylistBio = ClassRegistry::init('StylistBio');
        //$StylistPhotostream = ClassRegistry::init('StylistPhotostream');
        $Outfit = ClassRegistry::init('Outfit');
        $StylistTopOutfit = ClassRegistry::init('StylistTopOutfit');
        $OutfitItem = ClassRegistry::init('OutfitItem');
        $Entity = ClassRegistry::init('Entity');

        $StylistBioData = $StylistBio->find('first',array('conditions'=>array('StylistBio.stylist_id'=>$id,)));


        $StylistPhotostream = ClassRegistry::init('StylistPhotostream');
        $photostreampicsstylist = $StylistPhotostream->find('all',array('conditions'=>array('StylistPhotostream.stylist_id'=>$id,)));
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
        

        $this->set(compact('StylistBioData','stylistphoto','outfits','my_outfit','stylistoutfit','user','stylists','photostreampicsstylist', 'userlists'));
       
    }

    public function saveBiography($stylistId = null){
        $this->layout = 'ajax';
        $this->autoRender = false;
        $StylistBio = ClassRegistry::init('StylistBio');

        $user = $this->getLoggedUser();

        if($user['User']['id'] != $stylistId){
            exit;
        }

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

        $user = $this->getLoggedUser();

        if($user['User']['id'] != $stylistId){
            exit;
        }

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

        $user = $this->getLoggedUser();

        if($user['User']['id'] != $stylistId){
            exit;
        }

        $user = $this->getLoggedUser();

        if($user['User']['id'] != $stylistId){
            exit;
        }

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

        $user = $this->getLoggedUser();

        if($user['User']['id'] != $stylistId){
            exit;
        }

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

        $user = $this->getLoggedUser();

        if($user['User']['id'] != $stylistId){
            exit;
        }

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

        $user = $this->getLoggedUser();

        if($user['User']['id'] != $stylistId){
            exit;
        }
        $StylistPhotostream = ClassRegistry::init('StylistPhotostream');
            if($this->request->is('post') || $this->request->is('put')){

                $this->request->data['StylistPhotostream']['stylist_id'] =  $stylistId;
               
                if (isset($this->request->data['StylistPhotostream']['is_profile'])) {
                    $is_profile = $this->request->data['StylistPhotostream']['is_profile'];
                }
                if($imagename = $this->savePhotostream()){
                    $this->request->data['StylistPhotostream']['image'] = $imagename;
                }else{
                    $this->request->data['StylistPhotostream']['image'] = null;
                }

                if($StylistPhotostream->save($this->request->data)){
                    if(isset($is_profile)){
                        $User = ClassRegistry::init('User');
                        $user = $User->findById($stylistId);
                        $this->request->data['User']['profile_photo_url'] =  $imagename;
                        $this->request->data['User']['id'] = $stylistId;
                        $User->save($this->request->data);   
                    }
                    $this->Session->setFlash('The photo has been saved to the photostream.', 'flash');
                    $this->redirect(array('action' => '/biography/'.$stylistId));    
                }else{
                    $this->Session->setFlash('The StylistPhotostream could not be saved. Please, try again.', 'flash');
                }


            }

        $PhotoStreamData = $StylistPhotostream->find('all',array('conditions'=>array('StylistPhotostream.stylist_id'=>$stylistId,)));
        $this->set(compact('PhotoStreamData'));
        //exit;

    }


    public function saveProfilePhoto($stylistId = null){
        $this->layout = 'ajax';
        $this->autoRender = false;

        $user = $this->getLoggedUser();

        if($user['User']['id'] != $stylistId){
            $this->redirect('/');
        }
        if($this->request->is('post') || $this->request->is('put')){
           
            $imagename = false;
            $image_type = '';
            $image_size = '';


            if ($this->request->data['User']['profile_photo_url'] && $this->request->data['User']['profile_photo_url']['size'] > 0) {
                $allowed = array('image/jpeg', 'image/gif', 'image/png', 'image/x-png', 'image/x-citrix-png', 'image/x-citrix-jpeg', 'image/pjpeg');

                if (!in_array($this->request->data['User']['profile_photo_url']['type'], $allowed)) {
                    $this->Session->setFlash(__('You have to upload an image.'), 'flash');
                } else if ($this->request->data['User']['profile_photo_url']['size'] > 5242880) {
                    $this->Session->setFlash(__('Attached image must be up to 5 MB in size.'), 'flash');
                    // $this->redirect(array('action' => '/biography/'.$stylistId));
                    exit;
                } else {
                    $imagename = time() .  '_' . $this->request->data['User']['profile_photo_url']['name'];
                    $image_type = $this->request->data['User']['profile_photo_url']['type'];
                    $image_size = $this->request->data['User']['profile_photo_url']['size'];
                    $profile_path = APP . 'webroot' . DS . 'files' . DS . 'users' . DS . $imagename;
                    move_uploaded_file($this->request->data['User']['profile_photo_url']['tmp_name'], $profile_path);
                    
                }
            }

            if($imagename){
                $User = ClassRegistry::init('User');
                $user = $User->findById($stylistId);
                $this->request->data['User']['profile_photo_url'] =  $imagename;
                $this->request->data['User']['id'] = $stylistId;
                $User->save($this->request->data);   
                $this->redirect(array('action' => '/biography/'.$stylistId));    
            }else{
                $this->Session->setFlash('The image could not be uploaded. Please, try again.', 'flash');
            }


        }

        // $this->redirect(array('action' => '/biography/'.$stylistId));    

    }


    public function saveTwitter($stylistId = null){
        $this->layout = 'ajax';
        $this->autoRender = false;
        $StylistBio = ClassRegistry::init('StylistBio');

        $user = $this->getLoggedUser();

        if($user['User']['id'] != $stylistId){
            exit;
        }

        $BiographyData = $StylistBio->find('first',array('conditions'=>array('StylistBio.stylist_id'=>$stylistId,)));
        
        $StylistBioId = $BiographyData['StylistBio']['id'];
        if($BiographyData){
            $social_links = json_decode($BiographyData['StylistBio']['stylist_social_link'], true);
            $social_links['twitter'] = $this->request->data['twitter'];

            $BiographyData['StylistBio']['stylist_social_link'] = json_encode($social_links);

            print_r($BiographyData);
            $StylistBio->save($BiographyData);
            
        }
        else{
            $social_links['twitter'] = $this->request->data['twitter'];
            $stylist_id = $this->request->data['stylist_id'];
            $this->request->data['StylistBio']['stylist_id'] =  $stylist_id;
            $this->request->data['StylistBio']['stylist_social_link'] = json_encode($social_links);
            $StylistBio->save($this->request->data);
            
        }
        echo "success";
        exit;

    }


    public function saveLinkedin($stylistId = null){
        $this->layout = 'ajax';
        $this->autoRender = false;
        $StylistBio = ClassRegistry::init('StylistBio');

        $user = $this->getLoggedUser();

        if($user['User']['id'] != $stylistId){
            exit;
        }

        $BiographyData = $StylistBio->find('first',array('conditions'=>array('StylistBio.stylist_id'=>$stylistId,)));
        
        $StylistBioId = $BiographyData['StylistBio']['id'];
        if($BiographyData){
            $social_links = json_decode($BiographyData['StylistBio']['stylist_social_link'], true);
            $social_links['linkdin'] = $this->request->data['linkdin'];

            $BiographyData['StylistBio']['stylist_social_link'] = json_encode($social_links);

            print_r($BiographyData);
            $StylistBio->save($BiographyData);
            
        }
        else{
            $social_links['linkdin'] = $this->request->data['linkdin'];
            $stylist_id = $this->request->data['stylist_id'];
            $this->request->data['StylistBio']['stylist_id'] =  $stylist_id;
            $this->request->data['StylistBio']['stylist_social_link'] = json_encode($social_links);
            $StylistBio->save($this->request->data);
            
        }
        echo "success";
        exit;

    }


    public function saveFacebook($stylistId = null){
        $this->layout = 'ajax';
        $this->autoRender = false;
        $StylistBio = ClassRegistry::init('StylistBio');

        $user = $this->getLoggedUser();

        if($user['User']['id'] != $stylistId){
            exit;
        }

        $BiographyData = $StylistBio->find('first',array('conditions'=>array('StylistBio.stylist_id'=>$stylistId,)));
        
        $StylistBioId = $BiographyData['StylistBio']['id'];
        if($BiographyData){
            $social_links = json_decode($BiographyData['StylistBio']['stylist_social_link'], true);
            $social_links['facebook'] = $this->request->data['facebook'];

            $BiographyData['StylistBio']['stylist_social_link'] = json_encode($social_links);

            print_r($BiographyData);
            $StylistBio->save($BiographyData);
            
        }
        else{
            $social_links['facebook'] = $this->request->data['facebook'];
            $stylist_id = $this->request->data['stylist_id'];
            $this->request->data['StylistBio']['stylist_id'] =  $stylist_id;
            $this->request->data['StylistBio']['stylist_social_link'] = json_encode($social_links);
            $StylistBio->save($this->request->data);
            
        }
        echo "success";
        exit;

    }


    public function savePinterest($stylistId = null){
        $this->layout = 'ajax';
        $this->autoRender = false;
        $StylistBio = ClassRegistry::init('StylistBio');

        $user = $this->getLoggedUser();

        if($user['User']['id'] != $stylistId){
            exit;
        }

        $BiographyData = $StylistBio->find('first',array('conditions'=>array('StylistBio.stylist_id'=>$stylistId,)));
        
        $StylistBioId = $BiographyData['StylistBio']['id'];
        if($BiographyData){
            $social_links = json_decode($BiographyData['StylistBio']['stylist_social_link'], true);
            $social_links['pinterest'] = $this->request->data['pinterest'];

            $BiographyData['StylistBio']['stylist_social_link'] = json_encode($social_links);

            print_r($BiographyData);
            $StylistBio->save($BiographyData);
            
        }
        else{
            $social_links['pinterest'] = $this->request->data['pinterest'];
            $stylist_id = $this->request->data['stylist_id'];
            $this->request->data['StylistBio']['stylist_id'] =  $stylist_id;
            $this->request->data['StylistBio']['stylist_social_link'] = json_encode($social_links);
            $StylistBio->save($this->request->data);
            
        }
        echo "success";
        exit;

    }


    public function removePhoto($stylistId = null){
        $this->layout = 'ajax';
        $this->autoRender = false;
        $StylistPhotostream = ClassRegistry::init('StylistPhotostream');

        $user = $this->getLoggedUser();

        if($user['User']['id'] != $stylistId){
            exit;
        }

        $photo_id = $this->request->data['photo_id'];

        $photo = $StylistPhotostream->find('first',array('conditions'=>array('id'=>$photo_id)));
        
        if($photo){
            $StylistPhotostream->delete($photo_id);
            try{
                $photo_path = APP . 'webroot' . DS . 'files' . DS . 'users' . DS . $photo['StylistPhotostream']['image'];
                unlink($photo_path);        
            }
            catch(Exception $e){

            }  
        }
        echo "success";
        exit;
    }

    // stylist  saveOutfitFirst

    public function saveOutfitFirst($stylistId = null){
        $StylistTopOutfit = ClassRegistry::init('StylistTopOutfit');
        $Outfit = ClassRegistry::init('Outfit');
        $OutfitItem = ClassRegistry::init('OutfitItem');
        $Entity = ClassRegistry::init('Entity');    
        $this->layout = 'ajax';
        $this->autoRender = false;

        $user = $this->getLoggedUser();

        if($user['User']['id'] != $stylistId){
            exit;
        }
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

        $user = $this->getLoggedUser();

        if($user['User']['id'] != $stylistId){
            exit;
        }
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

        $user = $this->getLoggedUser();

        if($user['User']['id'] != $stylistId){
            exit;
        }
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

        $user = $this->getLoggedUser();

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
                $profile_path = APP . 'webroot' . DS . 'files' . DS . 'users' . DS . $imagename;
                move_uploaded_file($this->request->data['StylistPhotostream']['image']['tmp_name'], $img_path);
                copy($img_path, $profile_path);
                
                return $imagename;
            //print_r($imagename);
            }
        }
    }


// stylist biography details

    public function stylistbiography($id= null){

        if(isset($this->request->query['refer'])){
            $this->Session->write('stylist_refer', $this->request->query['refer']);   
        }

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
        $StylistPhotostream = ClassRegistry::init('StylistPhotostream');

        $photostreampicsstylist = $StylistPhotostream->find('all',array('conditions'=>array('StylistPhotostream.stylist_id'=>$id,)));
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
        
            // print_r($StylistBioData);
            // exit;
        $this->set(compact('users','StylistBioData','stylistphoto','outfits','my_outfit','stylistoutfit','stylists','photostreampicsstylist'));

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


    public function closet() {
        $this->isLogged();
        $user = $this->getLoggedUser();
        $user_id = $user['User']['id'];
        
        if(!$user['User']['is_stylist']){
            $this->redirect('/');
            exit;
        }

        // init
        $Category = ClassRegistry::init('Category');
        $Brand = ClassRegistry::init('Brand');
        $Color = ClassRegistry::init('Color');
        $Colorgroup = ClassRegistry::init('Colorgroup');
        $User = ClassRegistry::init('User');
        $Entity = ClassRegistry::init('Entity');
        
        // get data
        $categories = $Category->getAll();
        $brands = $Brand->find('all', array('order' => "Brand.name ASC"));
        $colors = $Colorgroup->find('all', array('order' => "Colorgroup.name ASC"));

        $entities = array();

        $limit = 25;
        $filter_brand = isset($this->request->data['str_brand']) ? $this->request->data['str_brand']: '';
        $filter_color = isset($this->request->data['str_color']) ? $this->request->data['str_color']: '';
        $filter_category = isset($this->request->data['str_category']) ? $this->request->data['str_category']: '';
        $search_text = isset($this->request->data['search_text']) ? strtolower($this->request->data['search_text']): '';
        $page = isset($this->request->data['page']) ? $this->request->data['page']: 1;
        $sort = isset($this->request->data['sort']) ? $this->request->data['sort'] : 'id';
        $client_id = isset($this->request->data['user_id']) ? $this->request->data['user_id'] : 0;

        if($client_id > 0){
            $user_stylist = $User->findById($client_id);

            if($user_stylist && ($user_id == $client_id || $user_stylist['User']['stylist_id'] == $user_id)){
                //user is corrct.
            }
            else{
                if($this->request->is('ajax')){
                    $ret['status'] = 'redirect';
                    echo json_encode($ret);
                    exit;
                }    
            }
        }

        $brand_list = array();
        if($filter_brand && $filter_brand != "none"){
            $brand_list = explode('-', $filter_brand);
            $brand_list = array_values(array_unique($brand_list));
        }

        $color_list = array();
        if($filter_color){
            $color_list = explode('-', $filter_color);
            $color_list = array_values(array_unique($color_list));
        }

        $category_list = array();
        if($filter_category){
            $category_list = explode('-', $filter_category);
            $category_list = array_values(array_unique($category_list));
            $category_list = $Category->getAllCategories($category_list);
        }

        $find_array = array(
                'limit' => $limit,
                'page'  => $page,
                'contain' => array('Image', 'Color', 'Detail'),
                'conditions' => array(
                    'Entity.show' => true
                ),
                'group' => array('Entity.id'),
                'joins' => array(
                    array('table' => 'products_categories',
                        'alias' => 'Category',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Category.product_id = Entity.product_id'
                        )
                    ),
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
                            'Product.brand_id = Brand.id'
                        )
                    ),
                ),
                'fields' => array(
                    'Entity.*','Product.*', 'Brand.*'
                ),
            );

        if($sort == 'pricedesc'){
            $find_array['order'] = array('Entity.price' => 'desc');
        }
        else if($sort == 'priceasc'){
            $find_array['order'] = array('Entity.price' => 'asc');
        }
        else{
            $find_array['order'] = array('Entity.id' => 'desc');   
        }
        
        //Category filter
        if($category_list && count($category_list) > 0){

            $find_array['conditions']['Category.category_id'] = $category_list;    
        }
        
        // Color filter
        if($color_list && count($color_list) > 0){
            
            $color_data = $Colorgroup->getColors($color_list);
            if($color_data){
                foreach($color_data as $color_item){
                    $color_ids[] = $color_item['ColorItems']['color_id'];
                }
            }
            
            if(isset($color_ids) && $color_ids && count($color_ids) > 0){
                $color_join = array('table' => 'colors_entities',
                    'alias' => 'Color1',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Color1.color_id' => $color_ids,
                        'Color1.product_entity_id = Entity.id'
                    )
                );
                $find_array['joins'][] = $color_join;
            }
        }

        // Brand Filter
        if($brand_list && count($brand_list) > 0){
            $find_array['conditions']['Product.brand_id'] = $brand_list;
        }

        // Search Filter
        if($search_text != ''){
            $find_array['conditions']['OR'] = array(
                array('LOWER(Brand.name) LIKE' => '%' . $search_text . '%'),
                array('LOWER(Entity.name) LIKE' => '%' . $search_text . '%'),
                );
        }

        
        $entities = $Entity->find('all', $find_array);

        $this->set(compact('entities', 'products', 'categories', 'brands', 'colors', 'user', 'user_id', 'page'));

        if($this->request->is('ajax')){
            $this->layout = false;
            $this->render = false;
            $ret = array();

            if(count($entities)){
                $ret['status'] = 'ok';
                $ret['entities'] = $entities;
            }
            else{
                $ret['status'] = 'error';
                $ret['entities'] = array();
            }

            echo json_encode($ret);
            exit;
        }
    }



    public function purchased() {
        $user = $this->getLoggedUser();
        $user_id = $user['User']['id'];
        
        // init
        $User = ClassRegistry::init('User');
        $OrderItem = ClassRegistry::init('OrderItem');
        $Entity = ClassRegistry::init('Entity'); 
        

        $entities = array();

        $limit = 25;
        $search_text = isset($this->request->data['search_text']) ? strtolower($this->request->data['search_text']): '';
        $page = isset($this->request->data['page']) ? $this->request->data['page']: 1;
        $sort = isset($this->request->data['sort']) ? $this->request->data['sort'] : 'id';
        $client_id = isset($this->request->data['user_id']) ? $this->request->data['user_id'] : 0;

        if($client_id > 0){
            $user_stylist = $User->findById($client_id);

            if($user_stylist && ($user_id == $client_id || $user_stylist['User']['stylist_id'] == $user_id)){
                //user is corrct.
            }
            else{
                if($this->request->is('ajax')){
                    $ret['status'] = 'redirect';
                    echo json_encode($ret);
                    exit;
                }    
            }
        }


        $purchase_array = array(
            'joins' => array(
                array('table' => 'orders',
                    'alias' => 'Order',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Order.id = OrderItem.order_id',
                        'Order.user_id' => $client_id,
                        'Order.paid'    => 1
                    )
                )
            ),
            'fields'    => array('OrderItem.product_entity_id')
        );

        $purchase_list = $OrderItem->find('list', $purchase_array);
        $purchase_list = array_values($purchase_list);

        $find_array = array(
                'limit' => $limit,
                'page'  => $page,
                'contain' => array('Image', 'Color', 'Detail'),
                'conditions' => array(
                    'Entity.show' => true,
                    'Entity.id' => $purchase_list,
                ),
                'group' => array('Entity.id'),
                'joins' => array(
                    array('table' => 'products_categories',
                        'alias' => 'Category',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Category.product_id = Entity.product_id'
                        )
                    ),
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
                            'Product.brand_id = Brand.id'
                        )
                    ),
                ),
                'fields' => array(
                    'Entity.*','Product.*', 'Brand.*'
                ),
            );

        if($sort == 'pricedesc'){
            $find_array['order'] = array('Entity.price' => 'desc');
        }
        else if($sort == 'priceasc'){
            $find_array['order'] = array('Entity.price' => 'asc');
        }
        else{
            $find_array['order'] = array('Entity.id' => 'desc');   
        }

        // Search Filter
        if($search_text != ''){
            $find_array['conditions']['OR'] = array(
                array('LOWER(Brand.name) LIKE' => '%' . $search_text . '%'),
                array('LOWER(Entity.name) LIKE' => '%' . $search_text . '%'),
                );
        }

        
        $entities = $Entity->find('all', $find_array);

        if($this->request->is('ajax')){
            $this->layout = false;
            $this->render = false;
            $ret = array();

            if(count($entities)){
                $ret['status'] = 'ok';
                $ret['entities'] = $entities;
            }
            else{
                $ret['status'] = 'error';
                $ret['entities'] = array();
            }

            echo json_encode($ret);
            exit;
        }
    }



    public function likes() {
        $user = $this->getLoggedUser();
        $user_id = $user['User']['id'];
        
        // init
        $User = ClassRegistry::init('User');
        $Wishlist = ClassRegistry::init('Wishlist');
        $Entity = ClassRegistry::init('Entity'); 
        

        $entities = array();

        $limit = 25;
        $search_text = isset($this->request->data['search_text']) ? strtolower($this->request->data['search_text']): '';
        $page = isset($this->request->data['page']) ? $this->request->data['page']: 1;
        $sort = isset($this->request->data['sort']) ? $this->request->data['sort'] : 'id';
        $client_id = isset($this->request->data['user_id']) ? $this->request->data['user_id'] : 0;

        if($client_id > 0){
            $user_stylist = $User->findById($client_id);

            if($user_stylist && ($user_id == $client_id || $user_stylist['User']['stylist_id'] == $user_id)){
                //user is corrct.
            }
            else{
                if($this->request->is('ajax')){
                    $ret['status'] = 'redirect';
                    echo json_encode($ret);
                    exit;
                }    
            }
        }


        $like_array = array(
            'conditions'    => array('user_id' => $client_id),
            'fields'    => array('Wishlist.product_entity_id')
        );

        $liked_list = $Wishlist->find('list', $like_array);
        $liked_list = array_values($liked_list);

        $find_array = array(
                'limit' => $limit,
                'page'  => $page,
                'contain' => array('Image', 'Color', 'Detail'),
                'conditions' => array(
                    'Entity.show' => true,
                    'Entity.id' => $liked_list,
                ),
                'group' => array('Entity.id'),
                'joins' => array(
                    array('table' => 'products_categories',
                        'alias' => 'Category',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Category.product_id = Entity.product_id'
                        )
                    ),
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
                            'Product.brand_id = Brand.id'
                        )
                    ),
                ),
                'fields' => array(
                    'Entity.*','Product.*', 'Brand.*'
                ),
            );

        if($sort == 'pricedesc'){
            $find_array['order'] = array('Entity.price' => 'desc');
        }
        else if($sort == 'priceasc'){
            $find_array['order'] = array('Entity.price' => 'asc');
        }
        else{
            $find_array['order'] = array('Entity.id' => 'desc');   
        }

        // Search Filter
        if($search_text != ''){
            $find_array['conditions']['OR'] = array(
                array('LOWER(Brand.name) LIKE' => '%' . $search_text . '%'),
                array('LOWER(Entity.name) LIKE' => '%' . $search_text . '%'),
                );
        }

        
        $entities = $Entity->find('all', $find_array);

        if($this->request->is('ajax')){
            $this->layout = false;
            $this->render = false;
            $ret = array();

            if(count($entities)){
                $ret['status'] = 'ok';
                $ret['entities'] = $entities;
            }
            else{
                $ret['status'] = 'error';
                $ret['entities'] = array();
            }

            echo json_encode($ret);
            exit;
        }
    }

}