<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
    <head>

        <!-- Basic Page Needs
  ================================================== -->
        <meta charset="utf-8">
        <title>Savile Row Society <?php echo $title_for_layout; ?></title>
        <!-- <meta name="description" content="Savile Row Society"> -->
        <?php echo $this->fetch('meta'); ?>
        <!-- Mobile Specific Metas
  ================================================== -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <!-- CSS
  ================================================== -->
        <link href='//fonts.googleapis.com/css?family=Droid+Serif:400,700' rel='stylesheet' type='text/css'>
        <?php        
        echo $this->Html->css('base');
        echo $this->Html->css('lightbox');
        echo $this->Html->css('mosaic');
        echo $this->Html->css('temp');
        echo $this->Html->css('flexslider');
        echo $this->Html->css('jquery.fancybox');
        echo $this->Html->css('tinyscrollbar');
//        echo $this->Html->css('jquery.cluetip');
        echo $this->Html->css('style.css?v=1'); 
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
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
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

        <!-- Start Visual Website Optimizer Asynchronous Code -->
        <script type='text/javascript'>
        var _vwo_code=(function(){
        var account_id=70612,
        settings_tolerance=2000,
        library_tolerance=2500,
        use_existing_jquery=false,
        // DO NOT EDIT BELOW THIS LINE
        f=false,d=document;return{use_existing_jquery:function(){return use_existing_jquery;},library_tolerance:function(){return library_tolerance;},finish:function(){if(!f){f=true;var a=d.getElementById('_vis_opt_path_hides');if(a)a.parentNode.removeChild(a);}},finished:function(){return f;},load:function(a){var b=d.createElement('script');b.src=a;b.type='text/javascript';b.innerText;b.onerror=function(){_vwo_code.finish();};d.getElementsByTagName('head')[0].appendChild(b);},init:function(){settings_timer=setTimeout('_vwo_code.finish()',settings_tolerance);this.load('//dev.visualwebsiteoptimizer.com/j.php?a='+account_id+'&u='+encodeURIComponent(d.URL)+'&r='+Math.random());var a=d.createElement('style'),b='body{opacity:0 !important;filter:alpha(opacity=0) !important;background:none !important;}',h=d.getElementsByTagName('head')[0];a.setAttribute('id','_vis_opt_path_hides');a.setAttribute('type','text/css');if(a.styleSheet)a.styleSheet.cssText=b;else a.appendChild(d.createTextNode(b));h.appendChild(a);return settings_timer;}};}());_vwo_settings_timer=_vwo_code.init();
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

        <?php echo $this->element('header'); ?>

        <!-- Primary Page Layout
        ================================================== -->
        <?php echo $this->Session->flash(); ?>
        <?php echo $this->fetch('content'); ?>
        

        <div class="bottom footer-bar twelve columns">
            <div class="footer">
                <!-- footer -->
                <div class="eleven columns container">
                    <div class="sixteen columns copyright left footer-buttons">
                        <ul>
                        <?php if(!$is_logged) : ?>
                            <li><a class="vip-link footer-bnt" href="" id="block-vip-access" >VIP Access</a></li>
                        <?php endif; ?>
                            <li><a class="blog-link footer-bnt" href="javascript:;" title="">Blog</a></li>
                        </ul>
                        
                    </div>
                    <div class="menu right four columns">
                        <ul>
                            <li><a href="<?php echo $this->request->webroot; ?>company">About us</a></li>
                            <!-- <li><a href="<?php echo $this->request->webroot; ?>how-it-works">How it works</a></li> -->
                            <li><a href="<?php echo $this->request->webroot; ?>company/team">Our team</a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>company/privacy">Privacy</a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>contact">Contact</a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>company/brands">Our brands</a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>faq">FAQ</a></li>
                            <!-- <li><a href="<?php echo $this->request->webroot; ?>company/bloggers">Our Bloggers</a></li> -->
                            <!-- <li><a href="<?php echo $this->request->webroot; ?>company/retailers">Our retailers</a></li> -->
                            <li><a href="<?php echo $this->request->webroot; ?>company/terms">Terms</a></li>
                        </ul>
                        <div class="footer-copyright">(c) Savile Row Society 2014</div>
                    </div>
                    
            </div>
            </div><!-- container -->
        </div>
        
        <!--Start of Zopim Live Chat Script-->

<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
$.src='//v2.zopim.com/?2EyWSdOlvawNOnH4NsrFdHDbmRHMk5Pq';z.t=+new Date;$.
type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
</script>

<!--End of Zopim Live Chat Script-->

        <!-- Popup Script
        ================================================== -->
        <!--Login and register popup-->
            <?php
            if (!$is_logged){
                echo $this->element('popup/authentication'); 
                echo $this->element('popup/vip_access');     
            }
            ?>

        <!--Modal Notifications-->
            <?php
                echo $this->element('popup/notification');    
            ?>    


        <!-- End Document
        ================================================== -->

        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
        <script src="<?php echo $this->request->webroot; ?>js/jquery.browser.mobile.js" type="text/javascript"></script>
        <script src="<?php echo $this->request->webroot; ?>js/jquery-scrollspy.js" type="text/javascript"></script>      
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

            /**
             * Set and control message notifier
             */
            var messageInterval = null;
            var showRegisterPopup = <?php echo isset($showRegisterPopup) ? 1 : 0; ?>;
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
                            if(typeof ret['clients'] != "undefined") {
                                $(".client-count span").text(ret['clients']);
                            }
                        }
                    }    
                });    
            }

            $(document).ready(function() { 
                startMessageNotifier();
            });
        </script>
        <script src="<?php echo $this->request->webroot; ?>js/common.js" type="text/javascript"></script>
        <script src="<?php echo $this->request->webroot; ?>js/jquery.flexsliderv2.js" type="text/javascript"></script>
        <script src="<?php echo $this->request->webroot; ?>js/jquery.bxslider.js" type="text/javascript"></script>
        <script src="<?php echo $this->request->webroot; ?>js/jquery.fancybox.pack.js" type="text/javascript"></script>
        <script src="<?php echo $this->request->webroot; ?>js/jquery.tinyscrollbar.js" type="text/javascript"></script>
        <script src="<?php echo $this->request->webroot; ?>js/jPages.js" type="text/javascript"></script>
<!--        <script src="<?php echo $this->request->webroot; ?>js/jquery.cluetip.js" type="text/javascript"></script>-->
        
        <script type="text/javascript">
            $(document).ready(function(){
                $('.flexslider').flexslider({
                    animation: "slide",
                    controlNav: true,
                    directionNav: true
                });
                $('.slider1').bxSlider({
                slideWidth: 222,
                minSlides: 1,
                maxSlides: 10,
                moveSlides: 1,
                slideMargin: 10
              });
                $('.slider2').bxSlider({
                slideWidth: 495,
                minSlides: 1,
                maxSlides: 6,
                moveSlides: 1,
                slideMargin: 20
              });
               //$('.fancybox').fancybox();
                $(".fancybox").fancybox({
                    helpers : {
                        title : {
                            type : 'over'
                        }
                    }
                });
                
               $("a.open-left-pannel").click(function(){
                   $(this).hide(1000);
                  $(".stylistbio-section-left").animate({left:'0px'}, 1000);
                });
                
                $(".stylistbion-arrow img").click(function(){
                    $("a.open-left-pannel").show(1000);
                    $(".stylistbio-section-left").animate({left:'-50%'}, 1000);
                });

                $('.tt-icon').hover(function(){
                    $('#div'+$(this).attr('target')).css({'opacity': 1, 'z-index':9999});
                });
                    
                $('.tt-icon').mouseleave(function(){
                    $('#div'+$(this).attr('target')).css({'opacity': 0, 'z-index':0});
                });
                
//                $('.brands img').click(function(){
//                    $('.brand-details').slideToggle();
//                });
                
                $('ul#branding-ptners>li:nth-child(3n)').after('<div class="clear-fix"></div>');
                $('ul#branding-ptners li').click(function(){
                     $('.brand-details').slideDown('');
                });
                $('ul#branding-ptners li').dblclick(function(){
                     $('.brand-details').slideUp('');
                });
//                                
//                $('ul#branding-ptners li').toggle(function() {
//                    $('.brand-details').slideDown('');
//                    return false;
//                  },
//                    function() {
//                      $('.brand-details').slideUp('');
//                    return false;
//                  });
//                
//                             
//                
//                $('ul#branding-ptners li').click(function() {
//                    $(this).addClass('active').siblings().removeClass('active');
//                })
                
                jQuery("#dd-nav-switcher").on("click", function(){  
                    jQuery(this).toggleClass("menu-anim");          
                    var menu = jQuery(".dd-nav");
                    jQuery(menu).slideToggle();  
                });
                
               
                
                
                
                $("div.holder").jPages({
                  containerID : "itemContainer",
                  //animation   : "bounceInUp"
                    fallback    : 1000,
                    previous: "Older Photos",
                    next: "Newer Photos",
                });

//                $('.link-older-photos').click( function(){
//                    $('.photostream-section').css('margin-left', '-100px');
//                });
                
                //$(".link-older-photos").click(function(event){       
                  //  event.preventDefault();
                    //$('.photostream-section').animate({scrollLeft:$(this.hash).offset().left}, 1700);
                //});
                
//                $('.style-time-hover').css('opacity', 0);  
//                $('.style-time-img').hover(  
//                   function(){  
//                      $(this).find('.style-time-hover').stop().fadeTo('slow', 1);  
//                   },  
//                   function(){  
//                      $(this).find('.style-time-hover').stop().fadeTo('slow', 0);  
//                   });
                
                
                $('.featured-stylist-hover').css('opacity', 0);  
                $('.featured-stylist ul li').hover(  
                   function(){  
                      $(this).find('.featured-stylist-hover').stop().fadeTo('slow', 1);  
                   },  
                   function(){  
                      $(this).find('.featured-stylist-hover').stop().fadeTo('slow', 0);  
                   });
                
                $('.outfit-products-details').css('opacity', 0);  
                $('.outfit-products li').hover(  
                   function(){  
                      $(this).find('.outfit-products-details').stop().fadeTo('slow', 1);  
                   },  
                   function(){  
                      $(this).find('.outfit-products-details').stop().fadeTo('slow', 0);  
                   });
                
               
                  $('a[href*=#]:not([href=#])').click(function() {
                    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                    var target = $(this.hash);
                      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                      if (target.length) {
                        $('html,body').animate({
                          scrollTop: target.offset().top
                        }, 1000);
                        return false;
                      }
                    }
                  });
                
                var $scrollingDiv = $(".header");
                   $(window).scroll(function () {
                       $scrollingDiv.stop()
                       $scrollingDiv.css("background-color", (($(window).scrollTop() / $(document).height()) > 0.01) ? "white" : "");
                   });
           
            });
            $(document).ready( function(){
            $("#scrollbar1").tinyscrollbar({ axis: "y"});
            $("#scrollbar2").tinyscrollbar({ axis: "y"});
            });
            
            
             $(".stylistbion-arrow img").click(function(){
                    $("a.open-left-pannel").show(1000);
                    $(".stylistbio-section-left").animate({left:'-50%'}, 1000);
                });
            
            
            $('.product-desc').css('opacity', 0);  
                $('.client-outfits-img li').hover(  
                   function(){  
                      $(this).find('.product-desc').stop().fadeTo('slow', 1);  
                   },  
                   function(){  
                      $(this).find('.product-desc').stop().fadeTo('slow', 0);  
                   });
            
            
            $(".new-address").click(function(){
                $(".address-overlay").fadeIn()
                $(".newaddress-popup").fadeIn();
            });
            $(".notification-close,.address-overlay").click(function(){
                $(".address-overlay").fadeOut()
                $(".newaddress-popup").fadeOut(200);
            });
            
            $('.home-edit-section').click(function(){
                $('.home-edit').fadeIn();
            });
            $('.fun-edit-section').click(function(){
                $('.fun-edit').fadeIn();
            });
            $('.tip-edit-section').click(function(){
                $('.tip-edit').fadeIn();
            });
            $('.edit-section-stylistbio-heading').click(function(){
                $('.stylistbio-heading-edit').fadeIn();
            });
            $('.edit-section-stylist-insp').click(function(){
                $('.stylist-insp-edit').fadeIn();
            });
            
            
            
            $('.edit-save-btn, .cancel-btn').click(function(){
                $('.home-edit, .tip-edit, .fun-edit, .stylistbio-heading-edit, .stylist-insp-edit').fadeOut();
            });
            
            
            
            
            
        </script>
        
               
        <!-- Google Code for Remarketing Tag -->
        <script type="text/javascript">
        /* <![CDATA[ */
        var google_conversion_id = 979436043;
        var google_custom_params = window.google_tag_params;
        var google_remarketing_only = true;
        /* ]]> */
        </script>
        <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
        </script>
        <noscript>
        <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/979436043/?value=0&amp;guid=ON&amp;script=0"/>
        </div>
        </noscript>
        
        <?php echo $this->fetch('script'); ?>

        <?php echo $this->element('sql_dump'); ?>
    </body>
</html>