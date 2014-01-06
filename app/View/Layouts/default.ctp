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
        <meta name="author" content="30 Hills">
        <meta name="google-site-verification" content="Mexh7IdYEzy4A8dWzHtFHjmhf0UMxyWez8SJn1HU6T0" />
        <?php echo $this->fetch('meta'); ?>
        <!-- Mobile Specific Metas
  ================================================== -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <!-- CSS
  ================================================== -->
        <?php
        echo $this->Html->css('base');
        echo $this->Html->css('skeleton');
        echo $this->Html->css('layout.css?v=1');
        echo $this->Html->css('flexslider');
        echo $this->Html->css('lightbox');
        echo $this->Html->css('mosaic');
        echo $this->Html->css('temp');
        echo $this->fetch('css');
        ?>
        <link href='//fonts.googleapis.com/css?family=Droid+Serif:400,700' rel='stylesheet' type='text/css'>
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
    	      oauth		 : true
    	    });
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

        <?php echo $this->element('header', array('is_logged' => $is_logged, 'is_admin' => $is_admin, 'cart_items' => $cart_items)); ?>

        <!-- Primary Page Layout
        ================================================== -->
        <?php echo $this->Session->flash(); ?>
        <?php echo $this->fetch('content'); ?>
        
        
        
        <!-- Popup script
        ================================================== -->
        <?php echo $this->element('popup', array()); ?>

        <div class="container bottom ">
            <div class=" sixteen columns footer">
                <!-- footer -->

                <div class=" menu">
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
                <div class="sixteen columns copyright">
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

        <script>
            var popupWidth = 480; // Global width of the popup
            /*
             * Change default behavior. Check is user is logged in before go to requested page.
             */
            $(".headerMenu").each(function(index, el) {
                var href = $(el).attr("href");
                //$(el).attr("href", "#");
                $(el).click(function(e) {
                    e.preventDefault();
                    var isLogedIn = "<?php echo $is_logged ?>";
                    if (isLogedIn == "") {
                        isLogedIn = false;
                    }
                    else {
                        isLogedIn = true;
                    }
                    if (!isLogedIn) {
                        window.ref_url = $(this).data('ref');
                        signUp();
                    }
                    else {
                        window.location = href;
                    }
                })
            });
            fadeInImages();
            
            function fadeInImages(){
                $(".fadein-image").each(function() {
                    if (this.complete) {
                        //$(this).animate({opacity : 1}, 300);
                        $(this).fadeTo(300, 1);
                    } else {
                        $(this).load(function() {
                            //$(this).animate({opacity : 1}, 300);
                            $(this).fadeTo(300,1);
                        });
                    }
                });
                
                
            }
            /*
             * show basket on basket icon mouse hover
             */
            $(document).ready(function() {
                $("#basket-link").mouseover(function() {
                    $("#basket").fadeIn(250);
                });
//                 $("#basket-link").mouseout(function(){
//                     if($("#basket").css("display") != "none"){
//                        $("#basket").fadeOut(250);
//                     }
//                });
                $("#basket").mouseout(function() {
                    $("#basket").fadeOut(250);
                });
                
                
            });
        </script>

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
            /*
             * check if user is logged in
             * open registration popup if not
             */
            function checkUserLogedInStatus() {
                if (!window.registerProcess && !isLoggedIn()) {
                    //startTimerForRegistration();
                }
            }
            /* registration wizard
             * go to style page step #2
             * TODO: delete when finish with registratino provess if it's not in use
             * */
            function gotoStylePage() {
                // serialize form data (#step 1)
                var _data = $("register-step1").serialize();
                $.ajax({
                    url: "<?php echo $this->request->webroot; ?>register/style"
                            , data: _data
                            , method: 'POST'
                }).done(function(res) {
                    $("#signup-popup").html(res);
                })
            }
            /* registration wizard
             * go to size page step #3
             * TODO: delete when finish with registratino provess if it's not in use
             * */
            function gotoSizePage() {
                // serialize form data (#step 1)
                var _data = $("register-size").serialize();
                $.ajax({
                    url: "<?php echo $this->request->webroot; ?>register/size"
                            , data: _data
                            , method: 'POST'
                }).done(function(res) {
                    $("#signup-popup").html(res);
                })
            }
            
            
            /** 
             * go to brands page step #3
             * TODO: delete when finish with registratino provess if it's not in use
             */
            function gotoBrandsPage() {
                // serialize form data (#step 1)
                var _data = $("register-step3").serialize();
                $.ajax({
                    url: "<?php echo $this->request->webroot; ?>register/brands"
                            , data: _data
                            , method: 'POST'
                }).done(function(res) {
                    $("#signup-popup").html(res);
                })
            }
            
            
            /* function to show signin popup*/
            function signIn() {
                $.ajax({
                    url: "<?php echo $this->request->webroot; ?>signin"
                }).done(function(res) {
                    $("#signin-popup").html(res);
                    $('.blockOverlay').click($.unblockUI);$.blockUI({message: $('#signin-popup'), css: {top: $(window).height()/2 - $('#signin-popup').height()/2}});
                    addReferrerToLogIn();
                });
            }
            /* call function to show registration popup with facebook and linked in registration options*/
            function signUp(e) {
                $('.blockOverlay').click($.unblockUI);
                $.ajax({
                    url: "<?php echo $this->request->webroot; ?>register"
                }).done(function(res) {
                    $("#signup-popup").html(res);
                    $('.blockOverlay').click($.unblockUI);$.blockUI({message: $('#signup-popup'), css: {top: $(window).height()/2 - $('#signup-popup').height()/2}});
                });
            }
            
            function addReferrerToLogIn(){
                if(ref_url != undefined){
                    $('#referUrlLogIn').val(ref_url);
                }
            }
            
            function showNotification(notificationDetails, isFade){
                if(isFade === undefined)
                    isFade = false;
                $(".notification-check").addClass('hide');
                $(".notification-buttons").addClass('hide');
                $(".notification-msg").html(notificationDetails['msg']);
                
                if(notificationDetails['check']){
                    $(".notification-check").removeClass('hide');
                    $(".notification-check").html(notificationDetails['check']);
                }
                if(notificationDetails['button']){
                    $(".notification-buttons").removeClass('hide');
                    $(".notification-buttons").html(notificationDetails['button']);
                }
                if(isFade){
                    $.blockUI({message: $('#notification-box'), css: {top: $(window).height()/2 - $('#notification-box').height()/2}, timeout: 3000});
                }
                else{
                    $.blockUI({message: $('#notification-box'), css: {top: $(window).height()/2 - $('#notification-box').height()/2}});
                }   
            }
            
            /**
             * Set and control message notifier
             */
            var messageInterval = null;
            function startMessageNotifier(){
                <?php if($this->request->params['action'] != "checkout") : ?>
                if(isLoggedIn()){
                    messageInterval = setInterval(function(){updateNotifications()}, 10000);
                }
                <?php endif; ?>
            }
            
            function updateNotifications(){
                $.ajax({
                    url: '<?php echo $this->Html->url('/', true); ?>api/messageNotification',
                    type: 'POST',
                    data: {},
                    success: function(data){
                        var ret = $.parseJSON(data);
                        if(ret){
                            $("#total-notifications").html(ret['total']); 
                            $(".msg-count span").text(ret['message']);   
                            $(".outfit-count span").text(ret['outfit']);
                        }
                    }    
                });    
            }
            
            $(document).ready(function() { 
                startMessageNotifier();
                
                $("#msg-notifications").on('click', function(e){
                    e.preventDefault(e);
                        
                });
                
                if($('#flash-box').length){
                    $.blockUI({message: $('#flash-box'), css: {top: $(window).height()/2 - $('#flash-box').height()/2}, timeout: 5000});
                }
                $('.blockOverlay, .notification-close').on('click', function(e){
                    e.preventDefault();
                    $.unblockUI();
                });
                $('#signup-popup, #signin-popup').on('click', '.notification-close', function(e){
                    e.preventDefault();
                    $.unblockUI();
                });
                
                $('#signin-popup').on('click', '.signin-btn', function(e){ 
                    e.preventDefault();
                    var error = false;
                    if($("#signin-email").val() == "")
                    {              
                        $("#signin-email").addClass("err-msg");
                        error = true;                   
                    }
                    else{
                        $("#signin-email").removeClass("err-msg");
                    }
                    if($("#signin-password").val() == "")
                    {              
                        $("#signin-password").addClass("err-msg"); 
                        error = true;                 
                    }
                    else{
                        $("#signin-password").removeClass("err-msg");
                    }
                    
                    if(error){
                        var authElement = $(".err-msg");
                        if(authElement.length){
                            authElement.first().focus(); 
                        }     
                        return false;    
                    }   else{            
                        $("#signin-form").submit();
                    }   
                });
    
                $('#signup-popup').on('click', '.signup-btn', function(e){
                    e.preventDefault();
                    var error = false;
                    if($("#first-name").val() == "")
                    {
                        $("#first-name").addClass("err-msg");
                        error = true;
                    }
                    else{
                        $("#first-name").removeClass("err-msg");
                    }
                    if($("#last-name").val() == "")
                    {
                        $("#last-name").addClass("err-msg");
                        error = true;
                    }
                    else{
                        $("#last-name").removeClass("err-msg");   
                    }
                    if($("#register-email").val() == "")
                    {              
                        $("#register-email").addClass("err-msg");
                        error = true;                   
                    }
                    else{
                        $("#register-email").removeClass("err-msg");
                    }
                    if($("#register-password").val() == "")
                    {              
                        $("#register-password").addClass("err-msg"); 
                        error = true;                 
                    }
                    else{
                        $("#register-password").removeClass("err-msg");
                    }
                    
                    if(error){
                        var authElement = $(".err-msg");
                        if(authElement.length){
                            authElement.first().focus(); 
                        }     
                        return false;    
                    }   else{            
                        $("#register-form").submit();
                    } 
                       
                });
                
                
                $(window).resize(function(){
                   $(".blockMsg").css({'left' : $(window).width() / 2 - popupWidth/2});
                });
                
                $("#show-signup").click(function(e) {
                    signUp(e);
                });
                /* attach to sign in event on signup popup form.
                 * on click opent sign-in popup form
                 * */
                $('#signup-popup').on('click', '#show-signin-popup', function(e){
                    e.preventDefault();
                    signIn();
                });
                
                /* attach to sign up event on signin popup form.
                 * on click open sign-up popup form
                 * */
                $('#signin-popup').on('click', '#show-signup-popup', function(e){
                    e.preventDefault();
                    signUp();
                });
                
                /*
                 * attach event that start registration wizard (from signup popup form)
                 */
                $("#show-registration-popup").click(function() {
                    singUpWizard();

                });
                /*
                 * attach trigger to close sign up dialog
                 */
                $("#closeSignUp").click(function() {
                    $.unblockUI();
                });
                
                $("#btn-presignup").on('click',function(e){
                    e.preventDefault(e);
                    $("#presignup-box-form").submit();
                });

                $(".show-more").toggle(function() {
                    var obj = $(this).parent().parent().find('.reveal');
                    if (obj.length == 0) {
                        obj = $(this).parent().parent().find('.revealLong');
                    }
                    if (obj.length == 0) {
                        obj = $(this).parent().parent().find('.reveal-220');
                    }
                    var currentHeight = obj.css("height");
                    obj.css("height", "auto");
                    var animateHeight = obj.css("height");
                    obj.css("height", currentHeight);
                    obj.animate({height: animateHeight}, 800);
                    $(this).addClass('up');
                }, function() {
                    $(this).parent().parent().find('.reveal').animate({height: 186, overflow: 'hidden'}, 800);
                    $(this).parent().parent().find('.revealLong').animate({height: 252, overflow: 'hidden'}, 800);
                    $(this).parent().parent().find('.reveal-220').animate({height: 220, overflow: 'hidden'}, 800);
                    $(this).removeClass('up');
                });
                
                $(".show-more-text").toggle(function() {
                    $(this)
                        .addClass('up')
                        .parent()
                            .parent()
                                .find('.long-desc')
                                .slideDown(800); 
                }, function() {
                    $(this)
                        .removeClass('up')
                        .parent()
                            .parent()
                                .find('.long-desc')
                                .slideUp(800);
                });

                if ($(".alert").length > 0) {
                    $(".alert").delay(2000).fadeOut();
                    $("#overlay").delay(2000).fadeOut();
                }
                checkUserLogedInStatus();
            });
            $(document).mouseup(function(e) {
                var container = $("#signup-box");
                if (container.has(e.target).length === 0) {
                    container.fadeOut();
                }
                var profileContainer = $("#profile-popup");
                if (profileContainer.is(":visible") && profileContainer.has(e.target).length === 0) {
                    profileContainer.fadeOut();
                    $(".blockOverlay").fadeOut();
                }

                var alert_container = $(".alert");
                if (alert_container.has(e.target).length === 0) {
                    alert_container.fadeOut();
                    $("#overlay").fadeOut();
                }
            });
            $(window).load(function() {
                if ($(".flexslider").length > 0) {
                    $('.flexslider').flexslider({
                        animation: "slide",
                        controlNav: false,
                        directionNav: true,
                        animationLoop: true,
                        slideshow: true,
                        slideshowSpeed: 7000
                    });
                }
            });
        </script>

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