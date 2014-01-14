<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
    <head>

        <!-- Basic Page Needs
  ================================================== -->
        <?php echo $this->Html->charset(); ?>
        <title>Savile Row Society <?php echo $title_for_layout; ?></title>
        <meta name="description" content="Savile Row Society">
        <meta name="google-site-verification" content="Mexh7IdYEzy4A8dWzHtFHjmhf0UMxyWez8SJn1HU6T0" />
        <?php echo $this->fetch('meta'); ?>
        <!-- Mobile Specific Metas
  ================================================== -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <!-- CSS
  ================================================== -->
        <link href='//fonts.googleapis.com/css?family=Droid+Serif:400,700' rel='stylesheet' type='text/css'>
        <?php        
        echo $this->Html->css('base');
        // echo $this->Html->css('layout.css?v=1');
        // echo $this->Html->css('skeleton');
        echo $this->Html->css('lightbox');
        echo $this->Html->css('mosaic');
        echo $this->Html->css('temp');
        echo $this->Html->css('style'); 
        echo $this->fetch('css');
        ?>
        <!-- Favicons
        ================================================== -->
        <!--[if lte IE 9]>
        	<link rel="stylesheet" type="text/css" href="<?php echo $this->webroot;?>css/ie.css" />
        <![endif]-->
        <link rel="shortcut icon" href="<?php echo $this->request->webroot; ?>img/favicon.ico">
        <link rel="apple-touch-icon" href="<?php echo $this->request->webroot; ?>img/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $this->request->webroot; ?>img/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $this->request->webroot; ?>img/apple-touch-icon-114x114.png">
        
        <!-- Start Visual Website Optimizer Asynchronous Code -->
        <script type='text/javascript'>
        /*var _vwo_code=(function(){
        var account_id=61410,
        settings_tolerance=2000,
        library_tolerance=2500,
        use_existing_jquery=false,
        // DO NOT EDIT BELOW THIS LINE
        f=false,d=document;return{use_existing_jquery:function(){return use_existing_jquery;},library_tolerance:function(){return library_tolerance;},finish:function(){if(!f){f=true;var a=d.getElementById('_vis_opt_path_hides');if(a)a.parentNode.removeChild(a);}},finished:function(){return f;},load:function(a){var b=d.createElement('script');b.src=a;b.type='text/javascript';b.innerText;b.onerror=function(){_vwo_code.finish();};d.getElementsByTagName('head')[0].appendChild(b);},init:function(){settings_timer=setTimeout('_vwo_code.finish()',settings_tolerance);this.load('//dev.visualwebsiteoptimizer.com/j.php?a='+account_id+'&u='+encodeURIComponent(d.URL)+'&r='+Math.random());var a=d.createElement('style'),b='body{opacity:0 !important;filter:alpha(opacity=0) !important;background:none !important;}',h=d.getElementsByTagName('head')[0];a.setAttribute('id','_vis_opt_path_hides');a.setAttribute('type','text/css');if(a.styleSheet)a.styleSheet.cssText=b;else a.appendChild(d.createTextNode(b));h.appendChild(a);return settings_timer;}};}());_vwo_settings_timer=_vwo_code.init();*/
        </script>
        <!-- End Visual Website Optimizer Asynchronous Code -->
    </head>
    <body>
    
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
    
        <!-- Header
        ================================================== -->

        <?php echo $this->element('newheader'); ?>

        <!-- Primary Page Layout
        ================================================== -->
        <?php echo $this->Session->flash(); ?>
        <?php echo $this->fetch('content'); ?>
        
        
        
        <!-- Popup script
        ================================================== -->
        <?php /*echo $this->element('popup', array()); */?>

        <div class="bottom footer-bar">
            <div class="footer">
                <!-- footer -->

                <div class="menu left">
                    <ul>
                        <li><a href="<?php echo $this->request->webroot; ?>company">About us</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>how-it-works">How it works</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>company/team">Our team</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>company/brands">Our brands</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>company/bloggers">Our Bloggers</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>company/retailers">Our retailers</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>contact">Contact us</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>faq">FAQ</a></li>
                    </ul>
                </div>
                <div class="sixteen columns copyright right">
                    &copy <?php echo date('Y'); ?> Savile Row Society, inc. All Rights reserved.
                </div>
            </div><!-- container -->
        </div>
        
        <!--Modal Notifications-->
            <div id="notification-box" class="hide box-modal notification-box">
                <div class="box-modal-inside">
                    <a class="notification-close" href=""></a>
                    <div class="notification-msg">
                        
                    </div>
                    <div class="notification-check">
                    
                    </div>
                    <div class="notification-buttons">
                    
                    </div>
                </div>
            </div>
        <!--End of Modal Notifications-->

        <!-- End Document
        ================================================== -->

        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->request->webroot; ?>js/jquery.browser.mobile.js" type="text/javascript"></script>
        <script src="<?php echo $this->request->webroot; ?>js/jquery-scrollspy.js" type="text/javascript"></script>
        <script src="<?php echo $this->request->webroot; ?>js/jquery.flexslider-min.js" type="text/javascript"></script>        
        <script src="<?php echo $this->request->webroot; ?>js/block.ui.js" type="text/javascript"></script>
        <script type="text/javascript">
            /*
             * check if user is logged in
             * return bolean
             */
            function isLoggedIn() {
                var _isLoggedIn = "<?php echo $is_logged ?>";
                if (_isLoggedIn == "") {
                    _isLoggedIn = false;
                }
                else {
                    _isLoggedIn = true;
                }
                return _isLoggedIn;
            }
        </script>
        <script src="<?php echo $this->request->webroot; ?>js/common.js" type="text/javascript"></script>

        

        <?php echo $this->fetch('script'); ?>
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-36935088-1']);
            _gaq.push(['_trackPageview']);
            
            (function() {
                var ga = document.createElement('script');
                ga.type = 'text/javascript';
                ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(ga, s);
            })();
        </script>

        <?php echo $this->element('sql_dump'); ?>

    </body>
</html>