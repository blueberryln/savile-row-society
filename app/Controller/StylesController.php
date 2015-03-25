<?php

App::uses('AppController', 'Controller');
App::uses('Security', 'Utility');
App::uses('CakeEmail', 'Network/Email');

/**
 * Users Controller
 *
 * @property User $User
 */
class StylesController extends AppController {
    public $components = array('Paginator');
    public $helpers = array('Paginator');
    
   
	public function beforeRender() {
	    parent::beforeRender();
	    $this->layout = 'admin';
	    $this->isAdmin();
    }

	
	public function admin_index() {
        $this->Style->recursive = 0;
        $this->set('styles', $this->paginate());
    }
   
 	public function admin_add() {
        if ($this->request->is('post')) {
			
        	$image = null;
	        $image_type = '';
	        $image_size = '';
			if ($this->request->data['Style']['image'] && $this->request->data['Style']['image']['size'] > 0) {

	            $allowed = array('image/jpeg', 'image/gif', 'image/png', 'image/x-png', 'image/x-citrix-png', 'image/x-citrix-jpeg', 'image/pjpeg');


	            if (!in_array($this->request->data['Style']['image']['type'], $allowed)) {
	                $this->Session->setFlash(__('You have to upload an image.'), 'flash');
	            } else if ($this->request->data['Style']['image']['size'] > 5242880) {
	                $this->Session->setFlash(__('Attached image must be up to 5 MB in size.'), 'flash');
	            } else {
	                $image = time() . $this->request->data['Style']['image']['name'];
	                $image_type = $this->request->data['Style']['image']['type'];
	                $image_size = $this->request->data['Style']['image']['size'];
	                $img_path = APP . 'webroot' . DS . 'files' . DS . 'user_styles' . DS . $image;
	                move_uploaded_file($this->request->data['Style']['image']['tmp_name'], $img_path);
	            }
	        }

	        if($image){
	        	$this->Style->create();
				$this->request->data['Style']['image'] = $image;   
	            if ($this->Style->save($this->request->data)) {
	                $this->Session->setFlash(__('The Style has been saved'), 'flash', array('title' => 'Success!'));
	                $this->redirect(array('action' => 'index'));
	            } else {
	                $this->Session->setFlash(__('The brand could not be saved. Please, try again'), 'flash');
	            }

		    }
        }
    }
   


	public function admin_edit($id = null)
	{
		if (!$this->Style->exists($id)) {
	        throw new NotFoundException(__('Invalid style'));
	    }
		
		$data = $this->request->data;
	    if($this->request->is('post') || $this->request->is('put'))
		{
			$style = $this->Style->findById($id);
            $style['Style']['name'] = $data['Style']['name'];
            $style['Style']['order'] = $data['Style']['order'];
            $style['Style']['status'] = $data['Style']['status'];

            
            if($data['Style']['image'] && $data['Style']['image']['size'] > 0){
                $allowed = array('image/jpeg', 'image/gif', 'image/png', 'image/x-png', 'image/x-citrix-png', 'image/x-citrix-jpeg', 'image/pjpeg');
                
                if (!in_array($data['Style']['image']['type'], $allowed)) {
                    $this->Session->setFlash(__('You have to upload an image.'), 'flash');
                } else if ($this->request->data['Style']['image']['size'] > 5242880) {
	                $this->Session->setFlash(__('Attached image must be up to 5 MB in size.'), 'flash');
	            } else {
                    $image = time() . $this->request->data['Style']['image']['name'];
	                $image_type = $this->request->data['Style']['image']['type'];
	                $image_size = $this->request->data['Style']['image']['size'];
	                $img_path = APP . 'webroot' . DS . 'files' . DS . 'user_styles' . DS . $image;
	                move_uploaded_file($this->request->data['Style']['image']['tmp_name'], $img_path);
                }   
                
                $file = new File('files/user_styles/' . $style['Style']['image'], true, 0777);
                if ($file->exists()) {
                    $file->delete();
                } 
                if ($img) {
                    $style['Style']['image'] =$image;
                }
            }

			if($this->Style->save($style))
			{
			   $this->Session->setFlash(__('The Styles has been saved'), 'flash', array('title' => 'Success!'));
			   $this->redirect(array('action' => 'index'));
			}
			else
			{
			   $this->Session->setFlash(__('The Styles could not be saved. Please, try again'), 'flash');
			}
		}
		else
		{
			// $options = array('conditions' => array('Style.' . $this->Style->primaryKey => $id));
			$this->request->data = $this->Style->findById($id);
		}
	
	}
   
   

 // 	public function admin_edit($id= null)
	// {
	// 	if(!$id && $this->request->data)
	// 	{
 //        	$this->Session->setFlash("Invalid Movie");
	// 		$this->redirect(array('action'=>'index'));
	// 	}

	// 	if(!empty($this->request->data))
	// 	{


	// 		$image = null;
	//         $image_type = '';
	//         $image_size = '';
	// 		if ($this->request->data['Style']['image'] && $this->request->data['Style']['image']['size'] > 0) {

	//             $allowed = array('image/jpeg', 'image/gif', 'image/png', 'image/x-png', 'image/x-citrix-png', 'image/x-citrix-jpeg', 'image/pjpeg');


	//             if (!in_array($this->request->data['Style']['image']['type'], $allowed)) {
	//                 $this->Session->setFlash(__('You have to upload an image.'), 'flash');
	//             } else if ($this->request->data['Style']['image']['size'] > 5242880) {
	//                 $this->Session->setFlash(__('Attached image must be up to 5 MB in size.'), 'flash');
	//             } else {
	//                 $image = time() . $this->request->data['Style']['image']['name'];
	//                 $image_type = $this->request->data['Style']['image']['type'];
	//                 $image_size = $this->request->data['Style']['image']['size'];
	//                 $img_path = APP . 'webroot' . DS . 'files' . DS . 'user_styles' . DS . $image;
	//                 move_uploaded_file($this->request->data['Style']['image']['tmp_name'], $img_path);
	//             }
	//         }

	//         if($image){
	//         	$this->request->data['Style']['image'] = $image; 
	// 	   if($this->Style->save($this->request->data))
	// 	   {
	// 		   $this->Session->setFlash("Style Data Hasbeen Saved");
	// 		   $this->redirect(array('action'=>'index'));
	// 		}
	// 		else
	// 		{
	// 			$this->Session->setFlash('The Style could not be saved. Please, try again.');
	// 		}
			
	// 	}
	// 	}
		
	// 		if (empty($this->request->data)) {
	// 			$this->request->data = $this->Style->read(null, $id);

	// 			}
	
     	 
	// }


   
   //delete function style

	public function admin_delete($id = null) {

		if (!$id) {
			$this->Session->setFlash('Invalid id for Style');
			$this->redirect(array('action' => 'index'));
		}   

		if ($this->Style->delete($id)) {
			$this->Session->setFlash('Styles  deleted');
		} else {
			$this->Session->setFlash(__('Styles was not deleted', true));
		}

		$this->redirect(array('action' => 'index'));
	}  

}

