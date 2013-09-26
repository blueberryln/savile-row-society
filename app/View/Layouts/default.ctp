<?php
if(isset($profilePopup) && $profilePopup['completeProfile']){
    $profileLinkScript = '';
    if(isset($profilePopup['isProfile']) && $profilePopup['isProfile']){
        $profileLinkScript = '
            $(".complete-profile").click(function(e){
                e.preventDefault();
                $("#profile-popup").fadeOut();
                $(".blockOverlay").fadeOut();
            });
        ';
    }
    $scriptProfile = '
        $(document).ready(function(){
            $.blockUI({message: $("#profile-popup")});
        ' . $profileLinkScript . '   
        });
    ';   
    $this->Html->scriptBlock($scriptProfile, array('safe' => true, 'inline' => false));
}
?>
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

        <!-- Mobile Specific Metas
  ================================================== -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <!-- CSS
  ================================================== -->
        <?php
        echo $this->Html->css('base');
        echo $this->Html->css('skeleton');
        echo $this->Html->css('layout');
        echo $this->Html->css('flexslider');
        echo $this->Html->css('lightbox');
        echo $this->Html->css('mosaic');
        echo $this->Html->css('temp');
        echo $this->fetch('css');
        ?>
        <link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700' rel='stylesheet' type='text/css'>
        <!-- Favicons
        ================================================== -->
        <link rel="shortcut icon" href="<?php echo $this->request->webroot; ?>img/favicon.ico">
        <link rel="apple-touch-icon" href="<?php echo $this->request->webroot; ?>img/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $this->request->webroot; ?>img/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $this->request->webroot; ?>img/apple-touch-icon-114x114.png">
    </head>
    <body>
        <!-- Header
        ================================================== -->

        <?php echo $this->element('header', array('is_logged' => $is_logged, 'is_admin' => $is_admin, 'cart_items' => $cart_items)); ?>

        <!-- Primary Page Layout
        ================================================== -->
        <?php echo $this->Session->flash(); ?>
        <?php echo $this->fetch('content'); ?>

        <div class="container bottom ">
            <div class=" sixteen columns footer">
                <!-- footer -->

                <div class=" menu">
                    <ul>
                        <li style='border-left: none'><a href="<?php echo $this->request->webroot; ?>company">About us</a></li>                    
                        <li><a href="<?php echo $this->request->webroot; ?>how-it-works">How it works</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>company/team">Our team</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>company/brands">Our brands</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>company/bloggers">Our Bloggers</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>company/retails">Our retailers</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>contact">Contact us</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>faq">FAQ</a></li>
                    </ul>
                </div>
                <div class="sixteen columns ">
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
                    <div class="notification-buttons hide">
                    </div>
                </div>
            </div>
        <!--End of Modal Notifications-->

        <!-- End Document
        ================================================== -->

        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
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
                $(el).attr("href", "#");
                $(el).click(function() {
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
            $(window).load(function(){
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
            /* registration wizard
             * go to brands page step #3
             * TODO: delete when finish with registratino provess if it's not in use
             * */
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
                clearInterval(popUpInterval);
                $.blockUI({message: $('#signin-popup')});
                $('.blockOverlay').click($.unblockUI);
                $.ajax({
                    url: "<?php echo $this->request->webroot; ?>signin"
                }).done(function(res) {
                    $("#signin-popup").html(res);
                    addReferrerToLogIn();
                });
            }
            /* functino to show signup popup (registration wizard)*/
            function singUpWizard() {
                $.blockUI({message: $('#signup-popup'), css: {top: '8%'}});
                $('.blockOverlay').click($.unblockUI);
                $.ajax({
                    url: "<?php echo $this->request->webroot; ?>register"
                }).done(function(res) {
                    $("#signup-popup").html(res);
                    overrideEmail();
                    addReferrerToSignUp();
                });
            }
            /* call function to show registration popup with facebook and linked in registration options*/
            function signUp(e) {
                $.blockUI({message: $('#signup-box'), css: {top: '15%', 'width' : popupWidth + 'px', 'left' : $(window).width() / 2 - popupWidth/2}});
                $('.blockOverlay').click($.unblockUI);
                clearInterval(popUpInterval);
            }

            function addReferrerToSignUp(){
                if(ref_url != 'undefined'){
                    $('#referUrl').val(ref_url);
                }
            }
            
            function addReferrerToLogIn(){
                if(ref_url != 'undefined'){
                    $('#referUrlLogIn').val(ref_url);
                }
            }
            
            function overrideEmail() {
                $("#UserEmail").val($("#enter-email").val());
            }
            
            function showNotification(notificationDetails, isFade){
                if(isFade === undefined)
                    isFade = false;
                
                $(".notification-msg").text(notificationDetails['msg']);
                if(isFade){
                    $.blockUI({message: $('#notification-box'), timeout: 3000});
                }
                else{
                    $.blockUI({message: $('#notification-box')});
                }   
            }
            /*
             * start timer to show registration form
             */
            var popUpInterval = null;
            function startTimerForRegistration() {
                popUpInterval = setTimeout(function() {
                    signUp();
                }, 30000);
            }
            $(document).ready(function() {
                if($('#flash-box').length){
                    $.blockUI({message: $('#flash-box'), timeout: 5000});
                }
                $('.blockOverlay, .notification-close').on('click', function(e){
                    e.preventDefault();
                    $.unblockUI();
                });
                
                /* if (!jQuery.browser.mobile) {
                 var height = $(document).height();
                 $('.header').scrollspy({
                 min: $('.header').offset().top + 99,
                 max: height,
                 onEnter: function(element, position) {
                 $(".header").addClass('small');
                 $(".content.inner").css('margin-top', 249);
                 $("#signup-box").addClass('small');
                 },
                 onLeave: function(element, position) {
                 $(".header").removeClass('small');
                 $(".content.inner").css('margin-top', 0);
                 $("#signup-box").removeClass('small');
                 }
                 });
                 } */
                
                $(window).resize(function(){
                   $(".blockMsg").css({'left' : $(window).width() / 2 - popupWidth/2});
                });
                
                $("#show-signup").click(function(e) {
                    signUp(e);
                });
                /* attach to sign in event on signup popup form.
                 * on click opent sign-in popup form
                 * */
                $("#show-signin-popup").click(function() {
                    signIn();
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
                
                var notificationBox = $("#notification-box");
                if(notificationBox.is(":visible") && notificationBox.has(e.target).length == 0) {
                    $.unblockUI();    
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

<!--        <script type="text/javascript">-->
<!--            var vglnk = {api_url: '//api.viglink.com/api',-->
<!--                key: '7f852b253a258ba36039af3e7455efbc'};-->
<!---->
<!--            (function(d, t) {-->
<!--                var s = d.createElement(t);-->
<!--                s.type = 'text/javascript';-->
<!--                s.async = true;-->
<!--                s.src = ('https:' == document.location.protocol ? vglnk.api_url :-->
<!--                        '//cdn.viglink.com/api') + '/vglnk.js';-->
<!--                var r = d.getElementsByTagName(t)[0];-->
<!--                r.parentNode.insertBefore(s, r);-->
<!--            }(document, 'script'));-->
<!--        </script>-->
<!---->
<!--        <script type="text/javascript">-->
<!--            var _gaq = _gaq || [];-->
<!--            _gaq.push(['_setAccount', 'UA-36935088-1']);-->
<!--            _gaq.push(['_trackPageview']);-->
<!---->
<!--            (function() {-->
<!--                var ga = document.createElement('script');-->
<!--                ga.type = 'text/javascript';-->
<!--                ga.async = true;-->
<!--                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';-->
<!--                var s = document.getElementsByTagName('script')[0];-->
<!--                s.parentNode.insertBefore(ga, s);-->
<!--            })();-->
<!--        </script>-->

        <!-- Google Code for Remarketing Tag -->
        <!--------------------------------------------------
        Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup
        --------------------------------------------------->
<!--        <script type="text/javascript">-->
<!--            /* <![CDATA[ */-->
<!--            var google_conversion_id = 979436043;-->
<!--            var google_custom_params = window.google_tag_params;-->
<!--            var google_remarketing_only = true;-->
<!--            /* ]]> */-->
<!--        </script>-->
<!--        <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">-->
<!--        </script>-->
<!--        <noscript>-->
<!--        <div style="display:inline;">-->
<!--            <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/979436043/?value=0&amp;guid=ON&amp;script=0"/>-->
<!--        </div>-->
<!--        </noscript>-->


        <?php echo $this->element('sql_dump'); ?>

    </body>
</html>