<?php
$config['my_app'] = 'abcdef';	// gives error when commented
define('HTTP_URL',$_SERVER['HTTP_HOST']);	//returns the site URL
Configure::write('App.cssBaseUrl', 'http://'.HTTP_URL.'/css/');
Configure::write('App.jsBaseUrl', 'http://'.HTTP_URL.'/js/');  
Configure::write('App.imageBaseUrl', 'http://'.HTTP_URL.'/');
define('HTTP_ROOT',"http://".HTTP_URL."/"); // cdn url for images
define('CSS_ROOT',"http://".HTTP_URL."/"); //cdn url for css files
define('JS_ROOT',"http://".HTTP_URL."/"); //cdn url for js files
define('ADMIN_LTE',"http://".HTTP_URL."/adminlte/"); //cdn url for new Admin layout files
define('PRE_MOD',true);	//pre moderator for comments made on outfits. Comment need not to be approved by admin if set to false.
define('PAGE_SIZE',20);	//define pagination size in new Admin Panel (Admins Controller)