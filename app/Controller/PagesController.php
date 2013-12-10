<?php

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Pages';

    /**
     * This controller does not use a model
     *
     * @var array
     */
    public $uses = array();

    /**
     * Displays a view
     *
     * @param mixed What page to display
     * @return void
     */
    
    public function display() {
        $path = func_get_args();

        $count = count($path);
        if (!$count) {
            $this->redirect('/');
        }
        $page = $subpage = $title_for_layout = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        if (!empty($path[$count - 1])) {
            $title_for_layout = Inflector::humanize($path[$count - 1]);
        }

        /*
        if ($page == 'membership') {
            $this->isLogged();
            $user = $this->getLoggedUser();
            $this->set(compact('user'));
        }
        */

        if ($page == 'tailor') {
            $this->isLogged();
            $user = $this->getLoggedUser();
            $this->set(compact('user'));
        }

        if ($page == 'trainer') {
            $this->isLogged();
            $user = $this->getLoggedUser();
            $this->set(compact('user'));
        }
        
        if ($page == 'stylist') {
            $this->isLogged();
            $user = $this->getLoggedUser();
            if(!$user['User']['preferences']){
                $this->Session->write('completeProfile', true);
                $this->redirect(array('controller' => 'profile', 'action' => 'about'));   
            }
            $this->set(compact('user'));
        }
        
        if($page == "home"){
            //if($registerSharePopup = $this->Session->read('registerSharePopup')){
//                $this->Session->delete('registerSharePopup');
//                $this->set(compact('registerSharePopup'));    
//            } 
        }
        /* To show holiday popup
        if($page == "home"){
            $start_date = strtotime("2013-11-30 00:00:00");
            $end_date = strtotime("2013-11-30 23:59:59"); 
            
            $cur_timestamp = strtotime(gmdate("Y-m-d H:i:s"));
            $cur_date = date('Y-m-d H:i:s', strtotime('-300 minutes', $cur_timestamp));
            $cur_est_timestamp = strtotime($cur_date);
            
            $itsHoliday = false;
            if($cur_est_timestamp >= $start_date && $cur_est_timestamp <= $end_date){
                $itsHoliday = true;          
            }
            $this->set(compact('itsHoliday'));
        }*/
        
        $this->set(compact('page', 'subpage', 'title_for_layout'));
        $this->render(implode('/', $path));
    }

}
