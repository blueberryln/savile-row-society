<?php
$config['my_app'] = 'abcdef';	// gives error when commented

Configure::write('App.cssBaseUrl', 'http://staging.savilerowsociety.com/css/');
Configure::write('App.jsBaseUrl', 'http://staging.savilerowsociety.com/js/');  
Configure::write('App.imageBaseUrl', 'http://staging.savilerowsociety.com/');
define('HTTP_ROOT',"http://staging.savilerowsociety.com/"); // cdn url for images
define('CSS_ROOT',"http://staging.savilerowsociety.com/"); //cdn url for css files
define('JS_ROOT',"http://staging.savilerowsociety.com/"); //cdn url for js files
define('PRE_MOD',true);	//pre moderator for comments made on outfits. Comment need not to be approved by admin if set to false.
?>