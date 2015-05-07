<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Messages Controller
 *
 * @property Message $Message
 */
class GuestController extends AppController {
    public $components = array('Paginator','RequestHandler');
    public $helpers = array('Paginator');

    public function beforeFilter(){

        $user = $this->getLoggedUser();
        if($user){
            $this->redirect('/messages/index');
        }

    }


    public function outfitdetails($outfit_id = null) {

        $User = ClassRegistry::init('User');
        $Outfit = ClassRegistry::init('Outfit');
        $Size = ClassRegistry::init('Size');
        $Message = ClassRegistry::init('Message');
        $this->autoRender = false;

        $sideBarTab = 'detail';

        $sizes = $Size->find('list');
        $outfit = $Outfit->getOutfitDetails($outfit_id, false);
        if($outfit){
            $outfit = $outfit[$outfit_id];
            $stylist = $User->findById($outfit['Outfit']['stylist_id']);

            $this->set(compact('outfit', 'outfit_id', 'stylist', 'sideBarTab', 'sizes'));
            $this->render('outfitdetails');
        }
        else{
            $this->redirect('/');
        }
           
    }


    /**
     * Cart
     */
    public function cart() {

        $data = array();
        $products = array();

        $Cart = ClassRegistry::init('Cart');
        $CartItem = ClassRegistry::init('CartItem');
        $Entity = ClassRegistry::init('Entity');
        $Size = ClassRegistry::init('Size');
        $sizes = $Size->find('list');

        $cart_list = false;
        if($this->Session->check('guest_items')){
            $cart_list = $this->Session->read('guest_items');

            $entity_list = array();
            foreach($cart_list as $item){
                $entity_list[] = $item['CartItem']['product_entity_id'];
            }
            $entities = $Entity->getEntitiesById($entity_list);

            foreach($cart_list as &$item){
                foreach($entities as $entity){
                    if($entity['Entity']['id'] == $item['CartItem']['product_entity_id']){
                        $item['Entity'] = $entity['Entity'];
                        $item['Image'] = $entity['Image'];
                        $item['Color'] = $entity['Color'];
                        $item['Size'] = array('id' => $item['CartItem']['size_id'], 'name' => $sizes[$item['CartItem']['size_id']]);
                    }
                }
            }
        }
        
        $this->set(compact('cart_list'));
    }

}