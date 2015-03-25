<?php

App::uses('AppController', 'Controller');

/**
 * Blog Controller
 */
class BlogController extends AppController {

    var $uses = null;

    /**
     * index method
     *
     * @return void
     */
    public function index() {

        // init
        $Post = ClassRegistry::init('Post');
        $Category = ClassRegistry::init('Category');

        // get data
        $posts = $Post->get();
        $authors = $Post->getAuthorsCount();
        $categories = $Category->getByModel('Post');

        $this->set(compact('posts', 'authors', 'categories'));
    }

    /**
     * index method
     *
     * @return void
     */
    public function view($slug = null) {
        
        App::uses('Sanitize', 'Utility');

        $post = array();
        $authors = array();
        $categories = array();
        $comments = array();
        $user_id = null;

        if (!empty($slug)) {

            // init
            $Post = ClassRegistry::init('Post');
            $Category = ClassRegistry::init('Category');
            $Comment = ClassRegistry::init('Comment');

            // get data
            $post = $Post->getOneBySlug($slug);
            $authors = $Post->getAuthorsCount();
            $categories = $Category->getByModel('Post');

            if ($post) {
                $comments = $Comment->getByPostID($post['Post']['id']);
                $user_id = $this->getLoggedUserID();

                // posting a comment
                if ($this->request->is('post')) {
                    if ($user_id && $this->request->data) {
                        $Comment->create();
                        $this->request->data['Comment']['user_id'] = $user_id;
                        $this->request->data['Comment']['model_id'] = $post['Post']['id'];
                        $this->request->data['Comment']['model'] = 'Post';
                        if ($Comment->save($this->request->data)) {
                            $this->redirect(array('controller' => 'blog', 'action' => 'view', $post['Post']['slug']));
                        }
                    }
                }
            }
        }

        $this->set(compact('post', 'authors', 'categories', 'comments', 'user_id'));
    }

    /**
     * index method
     *
     * @return void
     */
    public function author($username = null) {

        $posts = array();
        $authors = array();
        $categories = array();
        $author = array();

        if (!empty($username)) {

            // init
            $Post = ClassRegistry::init('Post');
            $Category = ClassRegistry::init('Category');
            $User = ClassRegistry::init('User');

            // get data
            $author = $User->getByUsername($username);

            if ($author) {
                $posts = $Post->get($author['User']['id']);
                $authors = $Post->getAuthorsCount();
                $categories = $Category->getByModel('Post');
            }
        }

        $this->set(compact('posts', 'authors', 'author', 'categories'));
    }

    /**
     * index method
     *
     * @return void
     */
    public function category($slug = null) {

        $authors = array();
        $categories = array();
        $category = array();

        if (!empty($slug)) {

            // init
            $Post = ClassRegistry::init('Post');
            $Category = ClassRegistry::init('Category');

            // get data
            $category = $Category->getOneWithPostsBySlug($slug, 'Post');

            if ($category) {
                $authors = $Post->getAuthorsCount();
                $categories = $Category->getByModel('Post');
            }
        }

        $this->set(compact('authors', 'categories', 'category'));
    }

}
