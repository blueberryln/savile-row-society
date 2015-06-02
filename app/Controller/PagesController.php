<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
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
            $this->loadModel('SlideBlog');
            $limit = 6;
            $conditions = array('order'=>'Blog.id desc','limit'=>$limit,'conditions'=>array('Blog.disabled'=>0));
            $posts = $this->Blog->get_posts('all',$conditions);
            $slideBlog = $this->SlideBlog->find('first',array('conditions'=>array('disabled'=>false),'order'=>'time desc'));
            $this->set(compact('user','topStylists','topOutfits', 'firstStylist','posts','slideBlog'));
       
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

    /* return the stylists that are checked by the admin as view_stylist */
    function fashion_consultants(){
        $this->loadModel('User');
        $title_for_layout = 'Our Fashion Consultants';
        $limit = 16;
        $conditions = array('conditions'=>array('is_stylist'=>true,'view_stylist'=>true),'limit'=>$limit);
        $this->paginate = $conditions;
        $stylists = $this->paginate('User');
        $this->set(compact('stylists','title_for_layout','limit'));  
    }

    /* return the paginated stylists that are checked by the admin as view_stylist */
    function fashion_consultants_pager(){
        if($this->request->is('ajax')){
            $this->loadModel('User');
            $conditions = array('conditions'=>array('is_stylist'=>true,'view_stylist'=>true),'limit'=>$_POST['limit'],'offset'=>$_POST['offset']);
            $this->paginate = $conditions;
            $stylists = $this->paginate('User');
            $append = '';
            if(!empty($stylists)){
                foreach($stylists as $stylist){
                    if($stylist['User']['profile_photo_url']){
                        $profile_pic = HTTP_ROOT.'files/users/'.$stylist['User']['profile_photo_url'];
                    }
                    else{
                        $profile_pic = HTTP_ROOT.'images/default-user.jpg';
                    }
                    $append.='<li class="column-4">'.
                    '<div class="consultant-container">'.
                        '<h3>'.
                            '<a href="/stylists/stylistbiography/'.$stylist['User']['id'].'">'.
                                '<img src="'.$profile_pic.'"/>'.
                                '<span class="hover_part2">'.
                                    '<span class="get_started" style="">GET STARTED</span>'.
                                '</span>'.
                            '</a>'.
                        '</h3>'.
                    '</div>'.
                    '<a href="/stylists/stylistbiography/'.$stylist['User']['id'].'">'.
                        '<span class="consultant-name">'.substr($stylist['User']['full_name'],0,25).'</span>'.
                    '</a>'.
                '</li>';
                }
            }
            echo $append;die;
        } else{
            $this->redirect($this->referer());
        }
    }

    /* sends notification email to the team when user enters thee email from coming soon page */
    function coming_soon_email(){
        if($_POST['email']){
            try{
                $team = array('shubham@yopmail.com');
                $bcc = Configure::read('Email.contact');
                $email = new CakeEmail('default');
                $email->from(array('admin@savilerowsociety.com' => 'Savile Row Society'));
                $email->to($team);
                $email->subject('Coming Soon');
                $email->bcc($bcc);
                $email->template('coming_soon');
                $email->emailFormat('html');
                $email->viewVars(array('email' => $_POST['email']));
                if($email->send()){
                    $this->Session->setFlash(__('Thank You! We will notify you shorly.'), 'flash');
                    $this->redirect($this->referer());
                }
            }
            catch(Exception $e){
                
            }
        }
        else{
            $this->redirect('/coming-soon');
        }
    }

}
