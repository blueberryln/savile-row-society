<?php

App::uses('AppController', 'Controller');

/**
 * Products Controller
 *
 * @property Product $Product
 */
class ProductsController extends AppController {
    
    public function beforeRender() {
        parent::beforeRender();
        $this->layout = 'admin';
        $this->isAdmin();
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->Product->recursive = 0;
        $this->set('products', $this->paginate());
    }

    /**
     * admin_add method
     *
     * @return void
     */
     public function admin_add() {
        if ($this->request->is('post')) {
            $this->Product->create();
            $user_id = $this->getLoggedUserID();
            $this->request->data['Product']['user_id'] = $user_id;
            if ($result = $this->Product->save($this->request->data)) {
                $this->Session->setFlash(__('The product has been saved'), 'flash', array('title' => 'Success!'));
                $this->redirect(array('action' => 'admin_edit', $result['Product']['id']));
                exit;
            } else {
                $this->Session->setFlash(__('The product could not be saved. Please, try again'), 'flash' );
            }
        }
        
        //$userTypes = $this->Product->UserType->find('list');
        $categories = $this->Product->Category->find('list');
        $brands = $this->Product->Brand->find('list');
        
        $this->set(compact('userTypes', 'categories', 'brands'));
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
     public function admin_edit($id = null) {
        if (!$this->Product->exists($id)) {
            throw new NotFoundException(__('Invalid product'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $user_id = $this->getLoggedUserID();
            $this->request->data['Product']['user_id'] = $user_id;
            if ($this->Product->save($this->request->data)) {
                $this->Session->setFlash(__('The product has been saved'), 'flash', array('title' => 'Success!'));
                $this->redirect(array('action' => 'admin_edit', $id));
                exit;
            } else {
                $this->Session->setFlash(__('The product could not be saved. Please, try again'), 'flash');
            }
        } else {
            $this->Product->recursive = 1;
            $options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
            $this->request->data = $this->Product->find('first', $options);
        }   
        // get data
        $categories = $this->Product->Category->find('list');
        $brands = $this->Product->Brand->find('list');
        $entities = $this->request->data['Entity'];
        

        $this->set(compact('categories', 'brands', 'entities', 'id'));
    }
    
    /**
     * admin_properties method
     * 
     * @param type $id
     */
    public function admin_entities($action = null, $id = null) {
        if($action == "add"){
            // init
            $Entity = ClassRegistry::init('Entity');
            
            //$Color = ClassRegistry::init('Color');
            $colors = $Entity->Color->find('list');
            
            if ($this->request->is('post') || $this->request->is('put')) {
                // add properties
                if ($this->request->data['Entity']) {
                    $data = array();
                    $Entity->create();
                    $data['Color'] = $this->request->data['Color'];
                    $data['Entity']['product_id'] = $id;
                    $data['Entity']['name'] = $this->request->data['Entity']['name'];
                    $data['Entity']['description'] = $this->request->data['Entity']['description'];
                    $data['Entity']['sku'] = $this->request->data['Entity']['sku'];
                    $data['Entity']['slug'] = $this->request->data['Entity']['slug'];
                    $data['Entity']['price'] = $this->request->data['Entity']['price'];
                    //$data['Entity']['stock'] = $this->request->data['Entity']['stock'];
                    $data['Entity']['show'] = $this->request->data['Entity']['show'];
                    $data['Entity']['user_id'] = $this->getLoggedUserID();
                    
                    
                    if($result = $Entity->save($data)){
                        $product_entity_id = $result['Entity']['id'];
                        $this->Session->setFlash(__('The product has been saved'), 'flash', array('title' => 'Success!'));
                        $this->redirect('entities/edit/' . $product_entity_id);
                    }
                    else{
                        $this->Session->setFlash(__('The product could not be saved. Please, try again'), 'flash');
                    }
                }
            }
            
            // set to view
            $this->set(compact('colors', 'id'));
            $this->render('admin_add_entities');
        }
        else if($action == "edit"){
            $Entity = ClassRegistry::init('Entity');
            if (!$Entity->exists($id)) {
                throw new NotFoundException(__('Invalid product'));
            } 
            
            //Get current product details
            $Entity->recursive = 1;
            $options = array('conditions' => array('Entity.' . $Entity->primaryKey => $id));
            $entity_details = $Entity->find('first', $options);
            
            $colors = $Entity->Color->find('list');
            
            if($this->request->is('post') || $this->request->is('put')){
                if ($this->request->data['Entity']) {
                    if ($Entity->save($this->request->data)) {
                        $this->Session->setFlash(__('The product has been saved'), 'flash', array('title' => 'Success!'));
                    } else {
                        $this->Session->setFlash(__('The product could not be saved. Please, try again'), 'flash');
                    }
                }
            }
            else{
                
                $this->request->data = $entity_details; 
            }
            $product_id = $this->request->data['Entity']['product_id'];
            $images = $Entity->Image->getByProductID($id);
            $sizes = $Entity->Detail->getSizeByProductID($id);
            
            // set to view
            $this->set(compact('colors', 'id', 'images', 'product_id', 'sizes'));
            $this->render('admin_edit_entities');
        }
        else if($action == "delete"){
            $Entity = ClassRegistry::init('Entity');
            if (!$Entity->exists($id)) {
                $this->redirect('index');
                exit;
            }
            $options = array('conditions' => array('Entity.' . $Entity->primaryKey => $id));
            $entity_details = $Entity->find('first', $options);
            $product_id = $entity_details['Entity']['product_id'];
            $order_items = $Entity->OrderItem->getByEntityId($id);

            if($order_items){
                $this->Session->setFlash(__('Error. This product cannot be deleted as it has already in ordered items.'), 'flash');
                $this->redirect(array('action'=> 'edit', $product_id));
                exit;
            }
            else{
                //Remove images
                $images = $this->Product->Entity->Image->getByProductID($id);
                if($images){
                    foreach($images as $img){
                        $image_id = $img['Image']['id'];
                        $file = new File('files/products/' . $img['Image']['name'], true, 0777);
                        if ($file->exists()) {
                            $file->delete();
                        }

                        // delete form db
                        $this->Product->Entity->Image->delete($image_id);
                    }
                }

                $this->Product->Entity->id = $id;
                if ($this->Product->Entity->delete()) {
                    $this->Session->setFlash(__('Product deleted'), 'flash', array('title' => 'Success!'));
                    $this->redirect(array('action' => 'index'));
                }
                $this->Session->setFlash(__('Product was not deleted. Please, try again'), 'flash');
                $this->redirect(array('action' => 'index'));

            }
        }
        else if($action == "sizeadd"){
            $this->autoLayout = false;
            
            $Detail = ClassRegistry::init('Detail');
            $existing_sizes = $Detail->getExistingSizes($id);
            
            $Size = ClassRegistry::init('Size');
            $sizes = $Size->getAvailableSizes($existing_sizes);
            
            if ($this->request->is('post') || $this->request->is('put')) {
                // add size
                if ($this->request->data['Detail']) {
    
                    $data = array();
                    $Detail->create();
                    $data['Detail']['product_entity_id'] = $id;
                    $data['Detail']['size_id'] = $this->request->data['Detail']['size_id'];
                    $data['Detail']['stock'] = $this->request->data['Detail']['stock'];
                    $data['Detail']['show'] = $this->request->data['Detail']['show'];
                    
                    if(in_array($data['Detail']['size_id'], $existing_sizes)){
                        $this->Session->setFlash(__('The size details not be saved. Please, try again'), 'flash');    
                    }
                    else{
                        if($result = $Detail->save($data)){
                            $this->Session->setFlash(__('The size details has been saved'), 'flash', array('title' => 'Success!'));
                            $this->redirect('entities/edit/' . $id);
                        }
                        else{
                            $this->Session->setFlash(__('The size details could not be saved. Please, try again'), 'flash');
                        }    
                    } 
                }
            }
            
            // set to view
            $this->set(compact('sizes', 'id'));
            $this->render('admin_add_size');
        }
        else if($action == "sizeedit"){
            $this->autoLayout = false;
            $Detail = ClassRegistry::init('Detail');
            if (!$Detail->exists($id)) {
                throw new NotFoundException(__('Invalid product size detail'));
            } 
            
            $Detail = ClassRegistry::init('Detail');
            $data = $Detail->getById($id);
            $existing_sizes = $Detail->getExistingSizes($data['Detail']['product_entity_id']);
            
            foreach($existing_sizes as $key => $value){
                if($value == $data['Detail']['size_id']){
                    unset($existing_sizes[$key]);   
                    array_values($existing_sizes);
                    break;
                }        
            }
            
            $Size = ClassRegistry::init('Size');
            $sizes = $Size->getAvailableSizes($existing_sizes);
            
            if ($this->request->is('post') || $this->request->is('put')) {
                // add size
                if ($this->request->data['Detail']) {
                    if($result = $Detail->save($this->request->data)){
                        $this->Session->setFlash(__('The size details has been saved'), 'flash', array( 'title' => 'Success!'));
                        $this->redirect('entities/edit/' . $this->request->data['Detail']['product_entity_id']);
                    }
                    else{
                        $this->Session->setFlash(__('The size details could not be saved. Please, try again'), 'flash');
                    }
                }
            }
            else{
                $this->request->data['Detail'] = $data['Detail'];   
            }
            
            // set to view
            $this->set(compact('sizes', 'id'));
            $this->render('admin_edit_size');
        }
        else if($action == "upload"){
            $this->autoLayout = false;
            
            if($this->request->is('post') || $this->request->is('put')){
                $Image = ClassRegistry::init('Image');
                
                $img = null;
                $img_type = '';
                $img_size = '';
    
                // file upload
                if ($this->request->data['Image']['name'] && $this->request->data['Image']['name']['size'] > 0) {
    
                    $allowed = array('image/jpeg', 'image/gif', 'image/png', 'image/x-png', 'image/x-citrix-png', 'image/x-citrix-jpeg', 'image/pjpeg');
                    
                    if (!in_array($this->request->data['Image']['name']['type'], $allowed)) {
                        $this->Session->setFlash(__('You have to upload an image.'), 'flash');
                    } else if ($this->request->data['Image']['name']['size'] > 3145728) {
                        $this->Session->setFlash(__('Attached image must be up to 3 MB in size.'), 'flash');
                    } else {
                        $rand = substr(uniqid ('', true), -7);
                        $img = $id . '_' . $rand . '_' . $this->request->data['Image']['name']['name'];
                        $img_type = $this->request->data['Image']['name']['type'];
                        $img_size = $this->request->data['Image']['name']['size'];
                        move_uploaded_file($this->request->data['Image']['name']['tmp_name'], APP . DS . 'webroot' . DS . 'files' . DS . 'products' . DS . $img);
                    }
                    
                    // save image
                    if ($img) {
                        // init
                        $file = array();
                        $file['Image']['product_entity_id'] = $id;
                        $file['Image']['name'] = $img;
                        $file['Image']['type'] = $img_type;
                        $file['Image']['size'] = $img_size;
                        
                        
    
                        $Image->create();
                        if ($Image->save($file)) {
                                
                        }
                    }
    
                    $this->redirect('entities/edit/' . $id);
                }
            }
            
            // set to view
            $this->set(compact('id'));
            $this->render('admin_entity_image');
        }
        else if($action == 'remove'){

            $this->autolayout = false;
            $this->autoRender = false;
            $image_id = $id;
            if ($this->request->is('ajax')) {
    
                if ($image_id) {
                    // init
                    $Image = ClassRegistry::init('Image');
    
                    // delete a file
                    $img = $Image->getByID($image_id);
                    $file = new File('files/products/' . $img['Image']['name'], true, 0777);
                    if ($file->exists()) {
                        $file->delete();
                    }
    
                    // delete form db
                    $Image->delete($image_id);
                }
            }
        }
    }
     
    /*public function admin_edit($id = null) {
        if (!$this->Product->exists($id)) {
            throw new NotFoundException(__('Invalid product'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Product']['slug'] = strtolower(Inflector::slug($this->request->data['Product']['slug'], '-'));
            if ($this->Product->save($this->request->data)) {
                $this->Session->setFlash(__('The product has been saved'), 'modal', array('class' => 'success', 'title' => 'Success!'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The product could not be saved. Please, try again'), 'modal', array('class' => 'error', 'title' => 'Houston we have a problem!'));
            }
        } else {
            $this->Product->recursive = 1;
            $options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
            $this->request->data = $this->Product->find('first', $options);
        }

        // get data
        $userTypes = $this->Product->UserType->find('list');
        $categories = $this->Product->Category->find('list');
        $brands = $this->Product->Brand->find('list');
        $attached = $this->Product->Attached->getByProductID($id);
        $properties = $this->Product->Property->getByProductID($id);

        $images_list = array();
        if ($attached) {
            foreach ($attached as $file) {
                if (isset($file['Attachment']) && $file['Color']) {
                    $images_list = array_merge($images_list, array($file['Attachment']['name'] => $file['Color'][0]['name']));
                }
            }
        } else {
            $images_list = array('' => 'None');
        }

        $this->set(compact('userTypes', 'categories', 'brands', 'attached', 'properties', 'images_list', 'id'));
    }*/

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        $this->Product->id = $id;
        if (!$this->Product->exists()) {
            throw new NotFoundException(__('Invalid product'));
        }
        $this->request->onlyAllow('post', 'delete');

        $products = $this->Product->getChildEntities($id);
        if($products && count($products['Entity']) >= 1){
            $this->Session->setFlash(__('Product cannot be deleted as it has one or more variants under it.'), 'flash');
            $this->redirect(array('action' => 'index'));
        }
        else{
            if ($this->Product->delete()) {
                $this->Session->setFlash(__('Product deleted'), 'flash', array('title' => 'Success!'));
                $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('Product was not deleted. Please, try again'), 'flash');
            $this->redirect(array('action' => 'index'));
        }
    }

    /**
     * admin_upload method
     * 
     * @param type $id
     */
    public function admin_upload($id = null) {

        $this->autoLayout = false;

        if ($this->request->is('post')) {
            $image = null;
            $image_type = '';
            $image_size = '';

            // file upload
            if ($this->request->data['Attachment']['Image'] && $this->request->data['Attachment']['Image']['size'] > 0) {

                $allowed = array('image/jpeg', 'image/gif', 'image/png', 'image/x-png', 'image/x-citrix-png', 'image/x-citrix-jpeg', 'image/pjpeg');
                
                if (!in_array($this->request->data['Attachment']['Image']['type'], $allowed)) {
                    $this->Session->setFlash(__('You have to upload an image.'), 'flash');
                } else if ($this->request->data['Attachment']['Image']['size'] > 500000) {
                    $this->Session->setFlash(__('Attached image must be up to 500 kb in size.'), 'flash');
                } else {
                    $image = $id . '_' . $this->request->data['Attachment']['Color'] . '_' . $this->request->data['Attachment']['Image']['name'];
                    $image_type = $this->request->data['Attachment']['Image']['type'];
                    $image_size = $this->request->data['Attachment']['Image']['size'];
                    move_uploaded_file($this->request->data['Attachment']['Image']['tmp_name'], APP . DS . 'webroot' . DS . 'files' . DS . 'products' . DS . $image);
                }
                
                // save image
                if ($image) {

                    // init
                    $Attachment = ClassRegistry::init('Attachment');
                    $Attached = ClassRegistry::init('Attached');

                    $file = array();
                    $file['Attachment']['name'] = $image;
                    $file['Attachment']['type'] = $image_type;
                    $file['Attachment']['size'] = $image_size;

                    $Attachment->create();
                    if ($Attachment->save($file)) {

                        $bind_file = array();
                        $bind_file['Attached']['attachment_id'] = $Attachment->getInsertID();
                        $bind_file['Attached']['model_id'] = $id;
                        $bind_file['Attached']['model'] = 'Product';
                        $bind_file['Color']['color_id'] = $this->request->data['Attachment']['Color'];

                        $Attached->create();
                        $Attached->saveAll($bind_file);
                    }
                }

                $this->redirect('edit/' . $id);
            }
        }

        // init
        $Color = ClassRegistry::init('Color');

        // get data
        $colors = $Color->find('list');

        // set to view
        $this->set(compact('colors', 'id'));
    }
    
    /**
     * admin_properties method
     * 
     * @param type $id
     */
    public function admin_properties($id = null) {

        $this->autoLayout = false;

        if ($this->request->is('post')) {

            // add properties
            if ($this->request->data['Property']) {

                // init
                $Property = ClassRegistry::init('Property');

                $data = array();
                $Property->create();
                $data['Property']['product_id'] = $id;
                $data['Property']['color_id'] = $this->request->data['Property']['color_id'];
                $data['Property']['size_id'] = $this->request->data['Property']['size_id'];
                $data['Property']['stock'] = $this->request->data['Property']['stock'];
                $data['Property']['sku'] = $this->request->data['Property']['sku'];
                $Property->save($data);

                $this->redirect('edit/' . $id);
            }
        }

        // init
        $Color = ClassRegistry::init('Color');
        $Size = ClassRegistry::init('Size');

        // get data
        $colors = $Color->find('list');
        $sizes = $Size->find('list');

        // set to view
        $this->set(compact('colors', 'sizes', 'id'));
    }

    /**
     * admin_upload_remove method
     * 
     * @param type $attachment_id
     */
    public function admin_upload_remove($attachment_id = null) {

        Configure::write('debug', 0);

        $this->autolayout = false;
        $this->autoRender = false;

        if ($this->request->is('ajax')) {

            if ($attachment_id) {

                // init
                $Attachment = ClassRegistry::init('Attachment');
                $Attached = ClassRegistry::init('Attached');

                // delete a file
                $image = $Attachment->getByID($attachment_id);
                $file = new File('files/products/' . $image['Attachment']['name'], true, 0777);
                if ($file->exists()) {
                    $file->delete();
                }

                // delete form db
                $Attached->deleteAll(array('Attached.attachment_id' => $attachment_id));
                $Attachment->delete($attachment_id);
            }
        }
    }

    /**
     * admin_properties_remove method
     * 
     * @param type $property_id
     */
    public function admin_properties_remove($property_id = null) {

        Configure::write('debug', 0);

        $this->autolayout = false;
        $this->autoRender = false;

        if ($this->request->is('ajax')) {

            if ($property_id) {

                // init
                $Property = ClassRegistry::init('Property');

                // delete form db
                $Property->delete($property_id);
            }
        }
    }
    
    public function resize($file, $w, $h, $crop=FALSE) {
        $this->autolayout = false;
        $this->autoRender = false;
        $file = APP . DS . 'webroot' . DS . 'files' . DS . 'products' . DS . $file;
        list($width, $height) = getimagesize($file);
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width-($width*abs($r-$w/$h)));
            } else {
                $height = ceil($height-($height*abs($r-$w/$h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w/$h > $r) {
                $newwidth = $h*$r;
                $newheight = $h;
            } else {
                $newheight = $w/$r;
                $newwidth = $w;
            }
        }
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if($ext == "gif"){
            $src = imagecreatefromgif($file);
        }
        else if($ext == "png"){
            $src = imagecreatefrompng($file);
        }
        else{
            $src = imagecreatefromjpeg($file);
        }
        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        
        if($ext == "png"){
            header('Content-Type: image/png');
            // Output the image
            
            imagepng($dst);    
        }
        else if($ext == "gif"){
            header('Content-Type: image/gif');
            // Output the image
            
            imagegif($dst); 
        }
        else{
            header('Content-Type: image/jpeg');
            // Output the image
            
            imagejpeg($dst);    
        }
        imagedestroy($dst);
        exit;
    }

}
