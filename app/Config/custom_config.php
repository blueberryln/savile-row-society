<?php
define('host',$_SERVER['HTTP_HOST']);
$config['my_app'] = 'abcdef';	// gives error when commented
if(host == 'www.savilerowsociety.com' || host == 'savilerowsociety.com'){ 
	define('HTTP_URL','d2owzzusdvisuq.cloudfront.net');	//returns the site URL  
} else{
	define('HTTP_URL',$_SERVER['HTTP_HOST']);	//returns the site URL
}
Configure::write('App.cssBaseUrl', 'http://'.host.'/css/');
Configure::write('App.jsBaseUrl', 'http://'.HTTP_URL.'/js/');  
Configure::write('App.imageBaseUrl', 'http://'.HTTP_URL.'/');
define('HTTP_ROOT',"http://".HTTP_URL."/"); // cdn url for images
define('CSS_ROOT',"http://".host."/"); //cdn url for css files
define('JS_ROOT',"http://".HTTP_URL."/"); //cdn url for js files
define('ADMIN_LTE',"http://".HTTP_URL."/adminlte/"); //cdn url for new Admin layout files
define('PRE_MOD',false);	//pre moderator for comments made on outfits. Comment will be instantly visible if set to false otherwise need admin approval.
define('DEV_MODE',false);	// true when site is in development mode(to avoid email sent to sales team on new user registration), false otherwise

if(isset($_GET['cacherfrsh'])){
	Configure::write('debug', 2);
}