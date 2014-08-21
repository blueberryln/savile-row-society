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

        if($page == 'home'){
            $user = $this->getLoggedUser();
            
            // top highlighted stylist list limit 10
            $User = ClassRegistry::init('User');
            $Userhighlighted = ClassRegistry::init('Userhighlighted');
            $find_array = array(
            'conditions' => array( 
            ),
            'joins' => array(
                
                array('table' => 'users',
                    'alias' => 'User',
                    'type' => 'INNER',
                    'conditions' => array(
                    'Userhighlighted.user_id = User.id', 
                    )
                ),
                
             ),
            'order' => 'Userhighlighted.order_id asc',
            'limit' => 10,
            'fields' => array(
                'User.first_name,User.last_name,User.profile_photo_url,Userhighlighted.*'
            ),
            
        );
        $topstylist = $Userhighlighted->find('all', $find_array);
        //print_r($topstylist);
            $this->set(compact('user'));
        }
        else if ($page == 'tailor') {
            $this->isLogged();
            $user = $this->getLoggedUser();
            $this->set(compact('user'));
        }
        else if ($page == 'trainer') {
            $this->isLogged();
            $user = $this->getLoggedUser();
            $this->set(compact('user'));
        }
        else if ($page == 'stylist') {
            $this->isLogged();
            $user = $this->getLoggedUser();
            if(!$user['User']['preferences']){
                $this->Session->write('completeProfile', true);
                $this->redirect(array('controller' => 'profile', 'action' => 'about'));   
            }
            $this->set(compact('user'));
        }
        else if ($page == 'refer-a-friend') {
            $this->isLogged();
            $user = $this->getLoggedUser();
            $this->set(compact('user'));
        }
        
        $this->set(compact('page', 'subpage', 'title_for_layout'));
        $this->render(implode('/', $path));
    }

}
