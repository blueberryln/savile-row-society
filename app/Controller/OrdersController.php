<?php

App::uses('AppController', 'Controller');

/**
 * Categories Controller
 *
 * @property Category $Category
 */
class OrdersController extends AppController {
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
        $orders = $this->paginate();
        $this->set(compact('orders'));

    }

}
