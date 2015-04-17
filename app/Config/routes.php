<?php

/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */

/**
 * User section routes
 */
Router::connect('/user/purchases', array('controller'=>'messages', 'action'=>'userpurchases'));
Router::connect('/user/likes', array('controller'=>'messages', 'action'=>'userlikes'));
Router::connect('/user/profile', array('controller'=>'messages', 'action'=>'profiles'));
Router::connect('/user/outfits', array('controller'=>'messages', 'action'=>'usersoutfits'));


Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
Router::connect('/refer-a-friend', array('controller' => 'pages', 'action' => 'display', 'refer-a-friend'));
Router::connect('/refer', array('controller' => 'pages', 'action' => 'display', 'refer'));
Router::connect('/fitting-room', array('controller' => 'booking'));
Router::connect('/signin', array('controller' => 'users', 'action' => 'signin'));
Router::connect('/landing', array('controller' => 'users', 'action' => 'landing'));
Router::connect('/register/*', array('controller' => 'users', 'action' => 'register'));
Router::connect('/signout', array('controller' => 'users', 'action' => 'signout'));
Router::connect('/forgot', array('controller' => 'users', 'action' => 'forgot'));
Router::connect('/reset/*', array('controller' => 'users', 'action' => 'reset'));
Router::connect('/myprofile/*', array('controller' => 'users', 'action' => 'edit'));
Router::connect('/mycloset/liked/*', array('controller' => 'closet', 'action' => 'liked'));
Router::connect('/mycloset/purchased/*', array('controller' => 'closet', 'action' => 'purchased'));
Router::connect('/closet/validatecard/*', array('controller' => 'closet', 'action' => 'validatecard'));
Router::connect('/payments/validate_promo_code/*', array('controller' => 'payments', 'action' => 'validate_promo_code'));
Router::connect('/closet/*', array('controller' => 'closet', 'action' => 'index'));
Router::connect('/lookbooks', array('controller' => 'lifestyles'));
Router::connect('/lookbooks/:action/*', array('controller' => 'lifestyles'));
Router::connect('/cart', array('controller' => 'closet', 'action' => 'cart'));
Router::connect('/guest/checkout', array('controller' => 'payments', 'action' => 'guestcheckout'));
Router::connect('/checkout', array('controller' => 'payments', 'action' => 'checkout'));
Router::connect('/payment', array('controller' => 'payments', 'action' => 'payment'));
Router::connect('/confirmation', array('controller' => 'payments', 'action' => 'confirmation'));
Router::connect('/product/*', array('controller' => 'closet', 'action' => 'product'));
Router::connect('/user-outfit/*', array('controller' => 'closet', 'action' => 'userOutfit'));
Router::connect('/profile/*', array('controller' => 'users', 'action' => 'register'));
Router::connect('/thankyou/*', array('controller' => 'offers', 'action' => 'thankyou'));

/* Admin */
Router::connect('/admin', array('controller' => 'products', 'action' => 'index', 'admin' => true));


/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
Router::connect('/home', array('controller' => 'pages', 'action' => 'display', 'home'));

Router::connect('/company', array('controller' => 'pages', 'action' => 'display', 'company'));
Router::connect('/company/team', array('controller' => 'pages', 'action' => 'display', 'company/team'));
Router::connect('/company/privacy', array('controller' => 'pages', 'action' => 'display', 'company/privacy'));
Router::connect('/company/terms', array('controller' => 'pages', 'action' => 'display', 'company/terms'));
Router::connect('/company/brands', array('controller' => 'pages', 'action' => 'display', 'company/brands'));
Router::connect('/contact', array('controller' => 'pages', 'action' => 'display', 'contact'));
Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
Router::connect('/faq', array('controller' => 'pages', 'action' => 'display', 'faq'));
Router::connect('/activation/*', array('controller' => 'users', 'action' => 'account_activation'));
/**
 * Load all plugin routes.  See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';