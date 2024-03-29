<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Categories Controller
 *
 * @property Category $Category
 */
class OrdersController extends AppController {
    public $components = array('Paginator');
    public $helpers = array('Paginator');
    
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
        $this->Order->recursive = 2;
        $this->Order->User->unbindModel(array('hasOne' => array('BillingAddress'), 'belongsTo' => array('UserType'), 'hasMany' => array('Comment', 'Post', 'Wishlist', 'Message', 'Order')));
        $orders = $this->paginate('Order', array('Order.paid = 1'));
        $this->set(compact('orders'));

    }
    
    public function admin_shipped($id = null){
        if (!$this->Order->exists($id)) {
            throw new NotFoundException(__('Invalid order'));
        }    
        
        $options = array('conditions' => array('Order.' . $this->Order->primaryKey => $id));
        $order = $this->Order->find('first', $options);
        
        if($order['Order']['shipped'] == 1){
            $this->Session->setFlash(__('The order is already marked shipped.'), 'flash');    
        }
        else{
            $order['Order']['shipped'] = 1;
            if($this->Order->save($order)){
                
                //Send confirmation email to the customer.
                $this->Order->recursive = 3;
                $this->Order->OrderItem->unbindModel(array('belongsTo' => array('Order')));
                $this->Order->OrderItem->Entity->unbindModel(array('hasMany' => array('Detail', 'Wishlist', 'Dislike', 'Like', 'OrderItem', 'CartItem'), 'hasAndBelongsToMany' => array('Color'), 'belongsTo' => array('Product')));
                $this->Order->User->unbindModel(array('hasOne' => array('BillingAddress'), 'belongsTo' => array('UserType'), 'hasMany' => array('Comment', 'Post', 'Wishlist', 'Message', 'Order')));
                $options = array('conditions' => array('Order.' . $this->Order->primaryKey => $id));
                $shipped_order = $this->Order->find('first', $options);
                
                if($shipped_order['User']['email']){
                    $email = new CakeEmail('default');
                    $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                    $email->to($shipped_order['User']['email']);
                    $email->subject('Your order has been shipped.');
                    $email->template('order_shipped');
                    $email->emailFormat('html');
                    $email->viewVars(compact('shipped_order'));
                    $email->send();
                }
                $this->Session->setFlash(__('The customer has been notified by email and the order has been maked shipped.'), 'flash');
            }     
            else{
                $this->Session->setFlash(__('The order could not be marked shipped. Please try again later'), 'flash');    
            }
        }
        $this->redirect('index');
        exit;
    }
    
    
    public function admin_items(){
        $options = array(
            'conditions' => array('Order.paid' => true, 'Order.shipped' => false),
            'joins' => array(
                array('table' => 'products_entities',
                    'alias' => 'Entity',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Entity.id = OrderItem.product_entity_id',
                    )
                ),
                array('table' => 'orders',
                    'alias' => 'Order',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Order.id = OrderItem.order_id',
                    )
                ),
                array('table' => 'products',
                    'alias' => 'Product',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Entity.product_id = Product.id',
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
            'fields' => array('OrderItem.*', 'Entity.*', 'Product.*', 'Brand.*', 'Order.*'),
        );
        
        $this->Paginator->settings = $options;
        $items = $this->Paginator->paginate('OrderItem');
        
        $Color = ClassRegistry::init('Color');
        $colors = $Color->find('list');
        
        $Size = ClassRegistry::init('Size');
        $sizes = $Size->find('list');
        
        $this->set(compact('items', 'colors', 'sizes'));    
    }

}
