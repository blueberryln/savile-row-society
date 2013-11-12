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
Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
Router::connect('/signin', array('controller' => 'users', 'action' => 'signin'));
Router::connect('/register/*', array('controller' => 'users', 'action' => 'register'));
Router::connect('/signout', array('controller' => 'users', 'action' => 'signout'));
Router::connect('/forgot', array('controller' => 'users', 'action' => 'forgot'));
Router::connect('/reset/*', array('controller' => 'users', 'action' => 'reset'));
Router::connect('/myprofile/*', array('controller' => 'users', 'action' => 'edit'));
Router::connect('/mycloset/liked/*', array('controller' => 'closet', 'action' => 'liked'));
Router::connect('/mycloset/purchased/*', array('controller' => 'closet', 'action' => 'purchased'));
Router::connect('/closet/validatecard/*', array('controller' => 'closet', 'action' => 'validatecard'));
Router::connect('/closet/validate_promo_code/*', array('controller' => 'closet', 'action' => 'validate_promo_code'));
Router::connect('/temp2', array('controller' => 'closet', 'action' => 'temp2'));
Router::connect('/closet/*', array('controller' => 'closet', 'action' => 'index'));
Router::connect('/cart', array('controller' => 'closet', 'action' => 'cart'));
Router::connect('/checkout', array('controller' => 'closet', 'action' => 'checkout'));
Router::connect('/payment', array('controller' => 'closet', 'action' => 'payment'));
Router::connect('/confirmation', array('controller' => 'closet', 'action' => 'confirmation'));
Router::connect('/product/*', array('controller' => 'closet', 'action' => 'product'));
Router::connect('/profile/*', array('controller' => 'users', 'action' => 'register'));

/* Admin */
Router::connect('/admin', array('controller' => 'products', 'action' => 'index', 'admin' => true));

//Router::connect('/contacts', array('controller' => 'contacts', 'action' => 'stylist'));
//Router::connect('/personal-stylist', array('controller' => 'contacts', 'action' => 'stylist'));
//Router::connect('/personal-stylist/gallery', array('controller' => 'contacts', 'action' => 'stylist_gallery'));
//Router::connect('/personal-stylist/submissions', array('controller' => 'contacts', 'action' => 'stylist_submissions'));
//Router::connect('/personal-stylist/ask', array('controller' => 'contacts', 'action' => 'stylist_ask'));
//Router::connect('/coach', array('controller' => 'contacts', 'action' => 'coach'));
//Router::connect('/coach/ask', array('controller' => 'contacts', 'action' => 'coach_ask'));
//Router::connect('/custom-wear', array('controller' => 'contacts', 'action' => 'custom_wear'));
//Router::connect('/custom-wear/submissions', array('controller' => 'contacts', 'action' => 'custom_wear_submissions'));
//Router::connect('/custom-wear/ask', array('controller' => 'contacts', 'action' => 'custom_wear_ask'));

/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
Router::connect('/home', array('controller' => 'pages', 'action' => 'display', 'home'));

Router::connect('/company', array('controller' => 'pages', 'action' => 'display', 'company'));
Router::connect('/company/team', array('controller' => 'pages', 'action' => 'display', 'company/team'));
Router::connect('/company/bloggers', array('controller' => 'pages', 'action' => 'display', 'company/bloggers'));

Router::connect('/company/brands', array('controller' => 'pages', 'action' => 'display', 'company/brands'));
Router::connect('/company/retailers', array('controller' => 'pages', 'action' => 'display', 'company/retailers'));
Router::connect('/membership', array('controller' => 'pages', 'action' => 'display', 'membership'));
Router::connect('/contact', array('controller' => 'pages', 'action' => 'display', 'contact'));
Router::connect('/how-it-works', array('controller' => 'pages', 'action' => 'display', 'how-it-works'));
Router::connect('/tailor', array('controller' => 'pages', 'action' => 'display', 'tailor'));
Router::connect('/stylist', array('controller' => 'pages', 'action' => 'display', 'stylist'));
//Router::connect('/trainer', array('controller' => 'pages', 'action' => 'display', 'trainer'));
Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
Router::connect('/faq', array('controller' => 'pages', 'action' => 'display', 'faq'));


/**
 * New pages for closet
 */
Router::connect('/temp', array('controller' => 'pages', 'action' => 'display', 'temp'));

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
