<?php 
$pass = (isset($this->request->params) && isset($this->request->params['pass'][0]) && $this->request->params['pass'][0] == 'refer-a-friend') ? true : false;

if($pass) : ?>
<!-- Facebook javascript API
    ================================ -->
    <div id="fb-root"></div>
    <script>
	  window.fbAsyncInit = function() {
	    // init the FB JS SDK
	    FB.init({
	      appId      : '507420839292016', // App ID from the App Dashboard
	      frictionlessRequests : true,
	      status     : true, // check the login status upon init?
	      cookie     : true, // set sessions cookies to allow your server to access the session?
	      xfbml      : true,  // parse XFBML tags on this page?
	      oauth		 : true    	    });
	  };

	  // Load the SDK's source Asynchronously
	  (function(d, s, id, debug){
	     var js, fjs = d.getElementsByTagName(s)[0];
	     if (d.getElementById(id)) {return;}
	     js = d.createElement(s); js.id = id;
	     js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
	     fjs.parentNode.insertBefore(js, fjs);
	    }(document, 'script', 'facebook-jssdk', false));
	</script>
<!-- Facebook javascript API ends
================================ -->
<?php endif; ?>