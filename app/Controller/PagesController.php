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
            
            //Get Top Stylists
            $TopStylist = ClassRegistry::init('TopStylist');
            $topStylists = $TopStylist->getTopStylists();
            
            //Get Top Outfits
            $TopOutfit = ClassRegistry::init('TopOutfit');
            $topOutfits = $TopOutfit->getTopOutfits();
            $title_for_layout = "Savile Row Society Home";

            $this->set(compact('user','topStylists','topOutfits'));
       
        }
        else if ($page == 'tailor') {
            $this->isLogged();
            $user = $this->getLoggedUser();
            $this->set(compact('user'));
        }
        else if ($page == 'contact') {
            $title_for_layout = "Contact Us - Savile Row Society";
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
            $sideBarTab = 'refer';

            $user = $this->getLoggedUser();
            $User= ClassRegistry::init('User');
            $stylist = $User->findById($user['User']['stylist_id']);

            $this->set(compact('user', 'sideBarTab', 'stylist'));
        }
        else if ($page == 'company/brands') {
            $title_for_layout = "Brands - Savile Row Society";
        }
        else if ($page == 'company/team') {
            $title_for_layout = "Team - Savile Row Society";
        }
        
        $this->set(compact('page', 'subpage', 'title_for_layout'));
        $this->render(implode('/', $path));
    }

}
