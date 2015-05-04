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

            $firstStylist = count($topStylists) ? $topStylists[0] : false;
            
            //Get Top Outfits
            $TopOutfit = ClassRegistry::init('TopOutfit');
            $topOutfits = $TopOutfit->getTopOutfits();
            $title_for_layout = "Personal Stylist Menswear Online Fashion Shopping Website - Buy Mens Designer Clothes";
            $this->loadModel('Blog');
            $limit = 6;
            $conditions = array('order'=>'Blog.id desc','limit'=>$limit,'conditions'=>array('Blog.disabled'=>0));
            $posts = $this->Blog->get_posts('all',$conditions);
            $this->set(compact('user','topStylists','topOutfits', 'firstStylist','posts'));
       
        }
        else if ($page == 'contact') {
            $title_for_layout = "Savile Row Society - Contact Us | Online Fashion Shopping Website";
        }
        else if ($page == 'refer-a-friend') {
            $this->isLogged();
            $sideBarTab = 'refer';

            $user = $this->getLoggedUser();

            if($user['User']['is_stylist']){
                $this->redirect('/messages/feed');
                exit;
            }

            $User= ClassRegistry::init('User');
            $stylist = $User->findById($user['User']['stylist_id']);

            $this->set(compact('user', 'sideBarTab', 'stylist'));
        }
        else if ($page == 'refer') {
            $this->isLogged();
            $sideBarTab = 'refer';

            $User= ClassRegistry::init('User');
            $user = $this->getLoggedUser();

            $userlists = $User->find('all', array('conditions'=>array('User.stylist_id' => $user['User']['id'], 'User.is_stylist' => 0, 'User.is_admin' => 0)));
            $this->set(compact('user', 'sideBarTab', 'stylist', 'userlists'));
            
            if(!$user['User']['is_stylist']){
                $this->redirect('/messages/index');
                exit;
            }
            

            $this->set(compact('user', 'sideBarTab', 'userlists'));

        }
        else if ($page == 'company/brands') {
            $title_for_layout = "Mens Fashion - Mens Fashion Clothing Online - Personal Online Shopping Stylist";
        }
        else if ($page == 'company/team') {
            $title_for_layout = "Savile Row Society Team Management - Designer Menswear Specialists - Lifestyle Fashionistas";
        }
        
        $this->set(compact('page', 'subpage', 'title_for_layout'));
        $this->render(implode('/', $path));
    }

    function get_comment($outfit_id = null){
        $this->loadModel('OutfitComment');
        $html_data = '';
        if ($this->request->is('ajax')) {
            $conditions = array('conditions'=>array('OutfitComment.outfit_id'=>$outfit_id,'OutfitComment.disabled'=>0),'order'=>'OutfitComment.id desc','contain'=>array('User'));
            $comments = $this->OutfitComment->get_comments('all',$conditions);
            $comment_count = count($comments);
            $html_data .= '';
            //pr($comments);die;
            foreach($comments as $comment){
                $ago = $this->ago($comment['OutfitComment']['time'],'');
                 if($comment['OutfitComment']['user_id']){
                   $name =  $comment['User']['full_name'];
                } 
                else{
                   $name = 'Guest';
                }
                $html_data .= '<span class="golden-heading">'.$name.'</span> says: '.$comment['OutfitComment']['comment'].'<br>';
            }
            echo $html_data;
        }
        die;
    }

}
