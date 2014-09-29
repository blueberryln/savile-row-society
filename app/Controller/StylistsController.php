<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Stylists Controller
 */
class StylistsController extends AppController {

    public function savePhotostream() {
        $imagename = null;
        $image_type = '';
        $image_size = '';
        // get edditing in user

        // file upload

        if ($this->request->data['Stylistphotostream']['image'] && $this->request->data['Stylistphotostream']['image']['size'] > 0) {

            $allowed = array('image/jpeg', 'image/gif', 'image/png', 'image/x-png', 'image/x-citrix-png', 'image/x-citrix-jpeg', 'image/pjpeg');

            if (!in_array($this->request->data['Stylistphotostream']['image']['type'], $allowed)) {
                $this->Session->setFlash(__('You have to upload an image.'), 'flash');
            } else if ($this->request->data['Stylistphotostream']['image']['size'] > 5242880) {
                $this->Session->setFlash(__('Attached image must be up to 5 MB in size.'), 'flash');
                $this->redirect('Auth/stylistbio/' . $id);
                exit;
            } else {
                $imagename = time() .  '_' . $this->request->data['Stylistphotostream']['image']['name'];
                $image_type = $this->request->data['Stylistphotostream']['image']['type'];
                $image_size = $this->request->data['Stylistphotostream']['image']['size'];
                $img_path = APP . 'webroot' . DS . 'files' . DS . 'photostream' . DS . $imagename;
                move_uploaded_file($this->request->data['Stylistphotostream']['image']['tmp_name'], $img_path);
                return $imagename;
            //print_r($imagename);
            }
        }
    }
     
    public function stylistbio($id= null){
        $this->isLogged();
        if (!$this->User->exists($id)) {
                throw new NotFoundException(__('Invalid user'));
            }
        $user = $this->User->findById($id);
        $current_user = $this->getLoggedUser();
        if($id != $current_user['User']['id'] && !$current_user['User']['is_admin'] && $current_user['User']['id'] != $user['User']['stylist_id']){
            $this->redirect('/');
            exit;
        }
        if($this->request->is('post') || $this->request->is('put')){
            $this->request->data['Stylistphotostream']['stylist_id'] = $id;
            $this->request->data['Stylistphotostream']['is_profile'] = '1';
            $this->request->data['Stylistbio']['stylist_id'] = $id;
            $facebookdata = json_encode($this->request->data['Stylistbio']['stylist_social_link']);
            $this->request->data['Stylistbio']['stylist_social_link'] = $facebookdata;
            if($imagename = $this->savePhotostream()){
                    $this->request->data['Stylistphotostream']['image'] = $imagename;
                }
            else{
                    $this->request->data['Stylistphotostream']['image'] = null;    
                }
            if($this->Stylistbio->saveAll($this->request->data))
            {
                $this->Session->setFlash("Stylistbio Data Hasbeen Saved");
                $this->redirect('/Auth/stylistbio/'.$id);
            }
            else
            {
                $this->Session->setFlash('The Stylistbio could not be saved. Please, try again.');
            }
        }
    }

    public function stylistbiography($id= null){
        $User = ClassRegistry::init('User');
        $Stylistbio = ClassRegistry::init('Stylistbio');
        $StylistTopOutfit = ClassRegistry::init('StylistTopOutfit');
        $Outfit = ClassRegistry::init('Outfit');
        $OutfitItem = ClassRegistry::init('OutfitItem');
        $Entity = ClassRegistry::init('Entity');
        $user = $User->findById($id);
        $user_profile_photo = $user['User']['profile_photo_url'];
        $user_first_name = $user['User']['first_name'];
        $user_last_name = $user['User']['last_name'];    
        
        //get stylist list

        $stylistlist = $User->find('all',array('conditions'=>array('User.is_stylist'=>true,),'fields'=>array('User.first_name,User.last_name,User.id,User.profile_photo_url')));


        //check data outfit start
        
        
        $my_outfit = array();
        $stylistoutfit= $StylistTopOutfit->find('all', array('conditions'=>array('StylistTopOutfit.stylist_id'=>$id,),'order'=>'StylistTopOutfit.order_id  asc',));
        foreach($stylistoutfit as $row){
            $stylist_outfit_id = $row['StylistTopOutfit']['outfit_id'];
            $outfitnames = $Outfit->find('first', array('conditions'=> array('Outfit.id'=>$stylist_outfit_id)));
            $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $stylist_outfit_id)));
            $entities = array();
            foreach($outfit as $value){
                    $entities[] = $value['OutfitItem']['product_entity_id'];
                }
            $entity_list = $Entity->getMultipleById($entities);
            $my_outfit[] =  array(
                                'outfit'    => $outfitnames,
                                //'username' => $userlist,
                                'entities'  => $entity_list
                            );
        }
        $Stylistphotostream = ClassRegistry::init('Stylistphotostream');
        $stylistphoto = $Stylistphotostream->find('all',
            array(
            'conditions'=>array(
            'Stylistphotostream.stylist_id'=>$id,
            ),
             'fields'=>array('Stylistphotostream.image,Stylistphotostream.caption'),
            ));

        //check data outfit end

        $find_array = $Stylistbio->find('all',array(
            'joins' => array(
                    array(
                        'table'=>'users',
                        'alias'=>'User',
                        'type'=>'inner',
                        'conditions'=>array(
                            'User.id = Stylistbio.stylist_id',
                            'User.id' => $id,
                            ),
                    ),
                ),
            'fields' => array('Stylistbio.*,User.*'),
            ));
            
            
        
        $this->set(compact('find_array','my_outfit','stylistlist','stylistphoto','user_profile_photo','user_first_name','user_last_name'));
    }

    

    public function editbiography($id = null) {
       $this->isLogged();
        if (!$this->User->exists($id)) {
                throw new NotFoundException(__('Invalid user'));
            }
        $user = $this->User->findById($id);
        $current_user = $this->getLoggedUser();
        if($id != $current_user['User']['id'] && !$current_user['User']['is_admin'] && $current_user['User']['id'] != $user['User']['stylist_id']){
            $this->redirect('/');
            exit;
        }
        $User = ClassRegistry::init('User');
        $Stylistbio = ClassRegistry::init('Stylistbio');
        $Stylistphotostream = ClassRegistry::init('Stylistphotostream');
        $Outfit = ClassRegistry::init('Outfit');
        $StylistTopOutfit = ClassRegistry::init('StylistTopOutfit');
        $OutfitItem = ClassRegistry::init('OutfitItem');
        $Entity = ClassRegistry::init('Entity');
        $find_array = $Stylistbio->find('all',array(
            'joins' => array(
                    array(
                        'table'=>'stylistphotostreams',
                        'alias'=>'Stylistphotostream',
                        'type'=>'inner',
                        'conditions'=>array(
                            'Stylistbio.id = Stylistphotostream.stylistbio_id',
                            'Stylistphotostream.is_profile'=>true,
                            ),
                    ),
                    array(
                        'table'=>'users',
                        'alias'=>'User',
                        'type'=>'inner',
                        'conditions'=>array(
                            'User.id = Stylistbio.stylist_id',
                            'User.id' => $id,
                            ),
                    ),
                ),
            'fields' => array('Stylistphotostream.*,Stylistbio.*,User.*'),
            ));
            
           
        $stylistphoto = $Stylistphotostream->find('all',
            array(
            'conditions'=>array(
            'Stylistphotostream.stylist_id'=>$id,
            ),
             'fields'=>array('Stylistphotostream.image,Stylistphotostream.caption'),
            ));
        
        $outfits = $Outfit->find('all',array('conditions'=>array('Outfit.stylist_id'=>$id,),'fields'=>'Outfit.outfitname,Outfit.id'));

        $my_outfit = array();
        $stylistoutfit= $StylistTopOutfit->find('all', array('conditions'=>array('StylistTopOutfit.stylist_id'=>$id,)));
        foreach($stylistoutfit as $row){
            $stylist_outfit_id = $row['StylistTopOutfit']['outfit_id'];
            $outfitnames = $Outfit->find('first', array('conditions'=> array('Outfit.id'=>$stylist_outfit_id)));
            $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $stylist_outfit_id)));
            $entities = array();
            foreach($outfit as $value){
                    $entities[] = $value['OutfitItem']['product_entity_id'];
                }
            $entity_list = $Entity->getMultipleById($entities);
            $my_outfit[] =  array(
                                'outfit'    => $outfitnames,
                                'entities'  => $entity_list
                            );
        }

        $this->set(compact('find_array','stylistphoto','outfits','my_outfit','stylistoutfit','user'));
    }

    public function updatestylistbiographyfunfect($stylistbioid = null){
        
        $Stylistbio = ClassRegistry::init('Stylistbio');
        if (!$Stylistbio->exists($stylistbioid)) {
            throw new NotFoundException(__('Invalid Userhighlighted'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $stylistbiographyid = $Stylistbio->findById($stylistbioid);
             $id = $stylistbiographyid['Stylistbio']['stylist_id'];
            if ($Stylistbio->save($this->request->data)) {
                $this->Session->setFlash("Stylistbio Data Hasbeen Saved");
                $this->redirect('/Auth/editbiography/'.$id);
            } else {
                $this->Session->setFlash(__('The Stylistbio could not be saved. Please, try again.'), 'flash');
            }
        } else {
            $options = array('conditions' => array('Stylistbio.' . $Stylistbio->primaryKey => $stylistbioid));
            $this->request->data = $Stylistbio->find('first', $options);
        }
    }


    public function updatestylistbiographyhometown($stylistbioid = null){
        $Stylistbio = ClassRegistry::init('Stylistbio');
        if (!$Stylistbio->exists($stylistbioid)) {
            throw new NotFoundException(__('Invalid Userhighlighted'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $stylistbiographyid = $Stylistbio->findById($stylistbioid);
            $id = $stylistbiographyid['Stylistbio']['stylist_id'];
            if ($Stylistbio->save($this->request->data)) {
                $this->Session->setFlash("Stylistbio Data Hasbeen Saved");
                $this->redirect('/Auth/editbiography/'.$id);
            } else {
                $this->Session->setFlash(__('The Stylistbio could not be saved. Please, try again.'), 'flash');
            }
        } else {
            $options = array('conditions' => array('Stylistbio.' . $Stylistbio->primaryKey => $stylistbioid));
            $this->request->data = $Stylistbio->find('first', $options);
        }

    }

    public function updatestylistbiographyInspiration($stylistbioid = null){
        $Stylistbio = ClassRegistry::init('Stylistbio');
        if (!$Stylistbio->exists($stylistbioid)) {
            throw new NotFoundException(__('Invalid Userhighlighted'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $stylistbiographyid = $Stylistbio->findById($stylistbioid);
            $id = $stylistbiographyid['Stylistbio']['stylist_id'];

            if ($Stylistbio->save($this->request->data)) {
                $this->Session->setFlash("Stylistbio Data Hasbeen Saved");
                $this->redirect('/Auth/editbiography/'.$id);
            } else {
                $this->Session->setFlash(__('The Stylistbio could not be saved. Please, try again.'), 'flash');
            }
        } else {
            $options = array('conditions' => array('Stylistbio.' . $Stylistbio->primaryKey => $stylistbioid));
            $this->request->data = $Stylistbio->find('first', $options);
        }

    }

    public function updateStylistBiographyBio($stylistbioid = null){
        $Stylistbio = ClassRegistry::init('Stylistbio');
        if (!$Stylistbio->exists($stylistbioid)) {
            throw new NotFoundException(__('Invalid Userhighlighted'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $stylistbiographyid = $Stylistbio->findById($stylistbioid);
            $id = $stylistbiographyid['Stylistbio']['stylist_id'];

            if ($Stylistbio->save($this->request->data)) {
                $this->Session->setFlash("Stylistbio Data Hasbeen Saved");
                $this->redirect('/Auth/editbiography/'.$id);
            } else {
                $this->Session->setFlash(__('The Stylistbio could not be saved. Please, try again.'), 'flash');
            }
        } else {
            $options = array('conditions' => array('Stylistbio.' . $Stylistbio->primaryKey => $stylistbioid));
            $this->request->data = $Stylistbio->find('first', $options);
        }

    }

    public function updateStylistBiographyFashionTip($stylistbioid = null){
        $Stylistbio = ClassRegistry::init('Stylistbio');
        if (!$Stylistbio->exists($stylistbioid)) {
            throw new NotFoundException(__('Invalid Userhighlighted'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $stylistbiographyid = $Stylistbio->findById($stylistbioid);
            $id = $stylistbiographyid['Stylistbio']['stylist_id'];

            if ($Stylistbio->save($this->request->data)) {
                $this->Session->setFlash("Stylistbio Data Hasbeen Saved");
                $this->redirect('/Auth/editbiography/'.$id);
            } else {
                $this->Session->setFlash(__('The Stylistbio could not be saved. Please, try again.'), 'flash');
            }
        } else {
            $options = array('conditions' => array('Stylistbio.' . $Stylistbio->primaryKey => $stylistbioid));
            $this->request->data = $Stylistbio->find('first', $options);
        }

    }

    public function updateStylistBiographyimage($stylistid = null){
        $Stylistphotostream = ClassRegistry::init('Stylistphotostream');
        
        if ($this->request->is('post')) {

            $this->request->data['Stylistphotostream']['stylist_id'] = $stylistid;
            $this->request->data['Stylistphotostream']['is_profile'] = '1';
            $this->request->data['Stylistphotostream']['image'] = $this->request->data['image'];
            $this->request->data['Stylistphotostream']['caption'] = $this->request->data['caption'];
            $this->request->data['Stylistphotostream']['image'];

            $imagename = null;
            $image_type = '';
            $image_size = '';

                $imagename = time() .  '_' . $this->request->data['Stylistphotostream']['image']['name'];
                $image_type = $this->request->data['Stylistphotostream']['image']['type'];
                $image_size = $this->request->data['Stylistphotostream']['image']['size'];
                $img_path = APP . 'webroot' . DS . 'files' . DS . 'photostream' . DS . $imagename;
                move_uploaded_file($this->request->data['Stylistphotostream']['image']['tmp_name'], $img_path);
                $this->request->data['Stylistphotostream']['image'] = $imagename;
                if ($Stylistphotostream->save($this->request->data)) {
                //print_r($Stylistphotostream->save($this->request->data));
                //exit;
                
                $this->Session->setFlash("Stylistphotostream Data Hasbeen Saved");
                $this->redirect('/Auth/editbiography/'.$stylistid);
            } else {
                $this->Session->setFlash(__('The Stylistphotostream could not be saved. Please, try again.'), 'flash');
            }
        }else{
                $this->Session->setFlash('The Stylistphotostream could not be saved. Please, try again.');
        }
    }

    public function updateStylistBiographyoutfit($stylistid = null){
        $StylistTopOutfit = ClassRegistry::init('StylistTopOutfit');
        $Outfit = ClassRegistry::init('Outfit');
        $OutfitItem = ClassRegistry::init('OutfitItem');
        $Entity = ClassRegistry::init('Entity');    
        
        if ($this->request->is('post') || $this->request->is('put')) {
            $topoutfitdata = $StylistTopOutfit->getStylistOrderOne($stylistid);
            
            if($topoutfitdata != null){
                $id = $topoutfitdata['StylistTopOutfit']['id'];
            }
            $this->request->data['StylistTopOutfit']['stylist_id'] = $stylistid;
            $this->request->data['StylistTopOutfit']['outfit_id'] = $this->request->data['outfit_id'];
            $this->request->data['StylistTopOutfit']['id'] = $this->request->data['id'];
            $this->request->data['StylistTopOutfit']['order_id'] = $this->request->data['order_id'];
            if ($StylistTopOutfit->save($this->request->data)) {

                    $my_outfit = array();
                    $stylistoutfit= $StylistTopOutfit->find('all', array('conditions'=>array('StylistTopOutfit.stylist_id'=>$stylistid,'StylistTopOutfit.order_id'=>1,),'order'=>'StylistTopOutfit.order_id  asc',));
                    foreach($stylistoutfit as $row){
                    $stylist_outfit_id = $row['StylistTopOutfit']['outfit_id'];
                    $outfitnames = $Outfit->find('first', array('conditions'=> array('Outfit.id'=>$stylist_outfit_id)));
                    $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $stylist_outfit_id)));
                    $entities = array();
                    foreach($outfit as $value){
                    $entities[] = $value['OutfitItem']['product_entity_id'];
                    }
                    $entity_list = $Entity->getMultipleById($entities);
                    $my_outfit[] =  array(
                        'outfit'    => $outfitnames,
                        'entities'  => $entity_list
                    );
                    }
                    echo json_encode($my_outfit);

                $this->Session->setFlash("StylistTopOutfit Data Hasbeen Saved");
                $this->redirect('/Auth/editbiography/'.$stylistid);
            } else {
                $this->Session->setFlash(__('The Stylistbio could not be saved. Please, try again.'), 'flash');
            }
        } else {
            $options = array('conditions' => array('StylistTopOutfit.' . $StylistTopOutfit->primaryKey => $id));
            $this->request->data = $StylistTopOutfit->find('first', $options);
        }
    }


public function updateStylistBiographyoutfit2($stylistid = null){
        $StylistTopOutfit = ClassRegistry::init('StylistTopOutfit');
        $Outfit = ClassRegistry::init('Outfit');
        $OutfitItem = ClassRegistry::init('OutfitItem');
        $Entity = ClassRegistry::init('Entity');    
        
        if ($this->request->is('post') || $this->request->is('put')) {
            $topoutfitdata = $StylistTopOutfit->getStylistTopOutfittwo($stylistid);
            
            if($topoutfitdata != null){
                $id = $topoutfitdata['StylistTopOutfit']['id'];
            }
            $this->request->data['StylistTopOutfit']['stylist_id'] = $stylistid;
            $this->request->data['StylistTopOutfit']['outfit_id'] = $this->request->data['outfit_id'];
            $this->request->data['StylistTopOutfit']['id'] = $this->request->data['id'];
            $this->request->data['StylistTopOutfit']['order_id'] = $this->request->data['order_id'];
            if ($StylistTopOutfit->save($this->request->data)) {

                    $my_outfit = array();
                    $stylistoutfit= $StylistTopOutfit->find('all', array('conditions'=>array('StylistTopOutfit.stylist_id'=>$stylistid,'StylistTopOutfit.order_id'=>2,),'order'=>'StylistTopOutfit.order_id  asc',));
                    foreach($stylistoutfit as $row){
                    $stylist_outfit_id = $row['StylistTopOutfit']['outfit_id'];
                    $outfitnames = $Outfit->find('first', array('conditions'=> array('Outfit.id'=>$stylist_outfit_id)));
                    $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $stylist_outfit_id)));
                    $entities = array();
                    foreach($outfit as $value){
                    $entities[] = $value['OutfitItem']['product_entity_id'];
                    }
                    $entity_list = $Entity->getMultipleById($entities);
                    $my_outfit[] =  array(
                        'outfit'    => $outfitnames,
                        'entities'  => $entity_list
                    );
                    }
                    echo json_encode($my_outfit);

                $this->Session->setFlash("StylistTopOutfit Data Hasbeen Saved");
                $this->redirect('/Auth/editbiography/'.$stylistid);
            } else {
                $this->Session->setFlash(__('The Stylistbio could not be saved. Please, try again.'), 'flash');
            }
        } else {
            $options = array('conditions' => array('StylistTopOutfit.' . $StylistTopOutfit->primaryKey => $id));
            $this->request->data = $StylistTopOutfit->find('first', $options);
        }
    }



    public function updateStylistBiographyoutfit3($stylistid = null){
        $StylistTopOutfit = ClassRegistry::init('StylistTopOutfit');
        $Outfit = ClassRegistry::init('Outfit');
        $OutfitItem = ClassRegistry::init('OutfitItem');
        $Entity = ClassRegistry::init('Entity');    
        
        if ($this->request->is('post') || $this->request->is('put')) {
            $topoutfitdata = $StylistTopOutfit->getStylistOrderTopOutfitthree($stylistid);
            
            if($topoutfitdata != null){
                $id = $topoutfitdata['StylistTopOutfit']['id'];
            }
            $this->request->data['StylistTopOutfit']['stylist_id'] = $stylistid;
            $this->request->data['StylistTopOutfit']['outfit_id'] = $this->request->data['outfit_id'];
            $this->request->data['StylistTopOutfit']['id'] = $this->request->data['id'];
            $this->request->data['StylistTopOutfit']['order_id'] = $this->request->data['order_id'];
            if ($StylistTopOutfit->save($this->request->data)) {

                    $my_outfit = array();
                    $stylistoutfit= $StylistTopOutfit->find('all', array('conditions'=>array('StylistTopOutfit.stylist_id'=>$stylistid,'StylistTopOutfit.order_id'=>3,),'order'=>'StylistTopOutfit.order_id  asc',));
                    foreach($stylistoutfit as $row){
                    $stylist_outfit_id = $row['StylistTopOutfit']['outfit_id'];
                    $outfitnames = $Outfit->find('first', array('conditions'=> array('Outfit.id'=>$stylist_outfit_id)));
                    $outfit = $OutfitItem->find('all', array('conditions'=>array('OutfitItem.outfit_id' => $stylist_outfit_id)));
                    $entities = array();
                    foreach($outfit as $value){
                    $entities[] = $value['OutfitItem']['product_entity_id'];
                    }
                    $entity_list = $Entity->getMultipleById($entities);
                    $my_outfit[] =  array(
                        'outfit'    => $outfitnames,
                        'entities'  => $entity_list
                    );
                    }
                    echo json_encode($my_outfit);

                $this->Session->setFlash("StylistTopOutfit Data Hasbeen Saved");
                $this->redirect('/Auth/editbiography/'.$stylistid);
            } else {
                $this->Session->setFlash(__('The Stylistbio could not be saved. Please, try again.'), 'flash');
            }
        } else {
            $options = array('conditions' => array('StylistTopOutfit.' . $StylistTopOutfit->primaryKey => $id));
            $this->request->data = $StylistTopOutfit->find('first', $options);
        }
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