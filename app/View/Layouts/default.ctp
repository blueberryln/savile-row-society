<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
    <head>

        <!-- Basic Page Needs
  ================================================== -->
        <meta charset="utf-8">
        <title><?php echo isset($title_for_layout) ? $title_for_layout : 'Savile Row Society'; ?></title>
        <!-- <meta name="description" content="Savile Row Society"> -->
        <?php echo $this->fetch('meta'); ?>
        <!-- Mobile Specific Metas
  ================================================== -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <!-- CSS
  ================================================== -->
        <?php        
        echo $this->Html->css('base');
        echo $this->Html->css('lightbox');
        echo $this->Html->css('mosaic');
        echo $this->Html->css('temp');
        // echo $this->Html->css('flexslider');
        echo $this->Html->css('jquery.fancybox');
        echo $this->Html->css('tinyscrollbar');
        echo $this->Html->css('jcarousel.responsive');
        echo $this->Html->css('style'); 
        echo $this->fetch('css');
       
        ?>
        <!-- Favicons
        ================================================== -->
        <link rel="shortcut icon" href="<?php echo HTTP_ROOT; ?>img/favicon.ico">
        <link rel="apple-touch-icon" href="<?php echo HTTP_ROOT; ?>img/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo HTTP_ROOT; ?>img/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo HTTP_ROOT; ?>img/apple-touch-icon-114x114.png">

        
        <?php
            if(!isset($canonical_url)){
                $canonical_url = Router::url($this->request->here, true);   
            } 

            echo '<link rel="canonical" href="'. $canonical_url .'">'; 
        ?>
        <!-- Favicons end -->
        
        <!--[if lt IE 9]>
            <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
        <!--<script src="/js/jquery-1.9.1.min.js"></script>-->



<!-- Start Default -->
<link rel="stylesheet" type="text/css" href="<?php echo CSS_ROOT ?>css/new-style.css" />
<!-- End Default -->

<link rel="stylesheet" type="text/css" href="<?php echo JS_ROOT ?>js/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo JS_ROOT ?>js/slick/slick-theme.css"/>
<script type="text/javascript" src="<?php echo JS_ROOT ?>js/slick/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="<?php echo JS_ROOT ?>js/slick/slick.js"></script>
<script type="text/javascript" src="<?php echo JS_ROOT ?>js/slick/prism.js"></script>
<script type="text/javascript">
$(window).load(function() {
    $('.multiple-items').slick({
        dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 4,
        slidesToScroll: 1
    }).removeClass('after-load');    
});    
</script>
<!-- Start Flexslider -->
<script src="<?php echo JS_ROOT ?>js/flexslider/modernizr.js"></script>
<script defer src="<?php echo JS_ROOT ?>js/flexslider/jquery.flexslider.js"></script>
<link rel="stylesheet" href="<?php echo JS_ROOT ?>js/flexslider/flexslider.css" type="text/css" media="screen" />
<!-- End Flexslider -->

    </head>
    <body>

        <?php echo $this->element('scripts/fb'); ?>
        
    
        <!-- Header
        ================================================== -->

        <?php echo $this->element('header'); ?>

        <!-- Primary Page Layout
        ================================================== -->
        <?php echo $this->Session->flash(); ?>
        <?php echo $this->fetch('content'); ?>
        
        
        <?php echo $this->element('footer'); ?>


        <!-- Popup Script
        ================================================== -->
        <!--Login and register popup-->
            <?php
            if (!$is_logged){
                echo $this->element('popup/authentication'); 
                echo $this->element('popup/vip_access');     
            }
            if(!empty($thankyou)){
                echo $this->element('popup/thankyou');     
            }
            ?>

        <!--Modal Notifications-->
            <?php
                echo $this->element('popup/notification');    
            ?>    


        <!-- End Document
        ================================================== -->


        <script src="<?php echo JS_ROOT; ?>js/jquery.browser.mobile.js" type="text/javascript"></script>
        <!--<script src="<?php echo $this->request->webroot; ?>js/jquery-scrollspy.js" type="text/javascript"></script>-->      
        <script src="<?php echo JS_ROOT; ?>js/block.ui.js" type="text/javascript"></script>
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
            var showAffiliatePopup = <?php echo isset($showAffiliatePopup) ? 1 : 0; ?>;
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
        <script src="<?php echo JS_ROOT; ?>js/common.js" type="text/javascript"></script>
        
        <script src="<?php echo JS_ROOT; ?>js/jquery.bxslider.js" type="text/javascript"></script>
        <script src="<?php echo JS_ROOT; ?>js/jquery.fancybox.pack.js" type="text/javascript"></script>
        <script src="<?php echo JS_ROOT; ?>js/jPages.js" type="text/javascript"></script>
        <script src="<?php echo JS_ROOT; ?>js/jquery.responsiveTabs.js" type="text/javascript"></script>
        <script src="<?php echo JS_ROOT; ?>js/highcharts.js" type="text/javascript"></script>
        <script src="<?php echo JS_ROOT; ?>js/jquery.highchartTable.js" type="text/javascript"></script>
        <script src="<?php echo JS_ROOT; ?>js/jquery-ui.min.js" type="text/javascript"></script>
        
        <script src="<?php echo JS_ROOT; ?>js/jquery.jcarousel.min.js" type="text/javascript"></script>
        <script src="<?php echo JS_ROOT; ?>js/jcarousel.responsive.js" type="text/javascript"></script>
        <script src="<?php echo JS_ROOT; ?>js/jquery.validate.js" type="text/javascript"></script>
        <?php
        if(isset($pixel)){
            echo $pixel;
        }
        ?>
        
        <script type="text/javascript">

            $(document).ready(function(){

                $("#chkall").click(function(){
                if($(this).is(':checked')){
                    $('.profile-stp2').find('select').val("I don’t know");
                }
                else{ 
                    $('.profile-stp2').find('select').val("");
                    }
                    });
                
                $('.flexslider').flexslider({
                    animation: "slide",
                    controlNav: true,
                    directionNav: true
                });
                
                $('.slider2').bxSlider({
                slideWidth: 495,
                minSlides: 1,
                maxSlides: 2,
                moveSlides: 1,
                slideMargin: 20
                });
                
                  $('.slider1').bxSlider({
                slideWidth: 220,
                minSlides: 1,
                maxSlides: 10,
                moveSlides: 1,
                slideMargin: 20
                  });
                
                $('.slider3').bxSlider({
                slideWidth: 202,
                minSlides: 1,
                maxSlides: 3,
                moveSlides: 1,
                slideMargin: 40
                });
                
                 $('.slider4').bxSlider({
                slideWidth: 202,
                mode:'vertical',
                minSlides: 3,
                maxSlides: 3,
                moveSlides: 1,
                slideMargin: 1
                });
                
            $('table.highchart').highchartTable();
            
                if (isLoggedIn()) {
                   $('#menu-switcher').hide()
                   $('.stylist-biography-section, .content-container-team, .content-container-privacy, .content-container-contact, .content-container-brands, .content-container-faq, .content-container-terms').css('margin-top', '0')
                }
                
                
            $('#horizontalTab').responsiveTabs({
                rotate: false,
                startCollapsed: 'accordion',
                collapsible: 'accordion',
                setHash: true,
                //disabled: [3,4],
//                activate: function(e, tab) {
//                    $('.info').html('Tab <strong>' + tab.id + '</strong> activated!');
//                },
                activateState: function(e, state) {
                    //console.log(state);
                    $('.info').html('Switched from <strong>' + state.oldState + '</strong> state to <strong>' + state.newState + '</strong> state!');
                }
            });
                
                $('input, textarea').placeholder();

            
                $('.otft-rgt-nav li ul input:checkbox, .myclst-rgt-nav li ul input:checkbox').change(function() {
                    var label = $('label[for="'+$(this).attr('id')+'"]');
                    if ($(this).filter(":checked").length) {
                      label.addClass("checked");
                    } else {
                      label.removeClass("checked");
                    }
                  }).trigger("change");
                
                $('.ctg-one > label').on('click', 'span', function(){
                    $(this).removeClass("checked");
                });
                
                $('.client-comments-text > a').click(function(){
                    $('.client-comments-text').css({height:'auto'});
                });
                
                $(".fancybox").fancybox({
                    helpers : {
                        title : {
                            type : 'over'
                        }
                    }
                });
  
                var wit = $(window).width();
                if(wit == '768' ){
                    var homepagebanner = function () {
                    var overlay = $('.mega-banner-overlay'),
                        mbanner = $('.mega-banner'),
                        overlay_height = (!isLoggedIn()) ? (overlay.height()+40) : (overlay.height()+100),
                        mbanner_height = mbanner.height(),
                        top_offset = -(overlay_height)/2
                        $('.mega-banner-overlay').css({"margin-top":top_offset})

                    };
                }else{
                
                    var homepagebanner = function () {
                    var overlay = $('.mega-banner-overlay'),
                        mbanner = $('.mega-banner'),
                        overlay_height = (!isLoggedIn()) ? (overlay.height()+40) : (overlay.height()+100),
                        mbanner_height = mbanner.height(),
                        top_offset = -(overlay_height)/2
                        $('.mega-banner-overlay').css({"margin-top":top_offset})

                    };
                }

                $(function () {
                    $(document).resize(function () {
                        homepagebanner();
                    }).resize();
                });
                
                
               $("a.open-left-pannel").click(function(){
                   $(this).hide(1000);
                  $(".stylistbio-section-left").animate({left:'0px'}, 1000);
                });

                $(".stylistbion-arrow").on("click", "img", function(){
                    $("a.open-left-pannel").css({display:'block'});
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

//                $('.featured-stylist-hover').css('opacity', 0);  
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
                      $(this).find('.outfit-products-details').stop().fadeTo('', 1);  
                   },  
                   function(){  
                      $(this).find('.outfit-products-details').stop().fadeTo('', 0);  
                   });
                
               
                  $('.menu a[href*=#]:not([href=#])').click(function() {
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
                
                 $('.page-content a[href*=#]:not([href=#])').click(function() {
                    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                    var target = $(this.hash);
                     target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                         //console.log(target.offset().top());
                      if (target.length) {                         
                        $('html,body').animate({
                          scrollTop: target.offset().top - 105
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
            
            
            
             $(".stylistbion-arrow img.back-for-mobile").click(function(){
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
                $("#hometown").focus();
            });
            $('.fun-edit-section').click(function(){
                $('.fun-edit').fadeIn();
                $("#funfact").focus();
            });
            $('.tip-edit-section').click(function(){
                $('.tip-edit').fadeIn();
                $("#fashion_tip").focus();
            });
            $('.edit-section-stylistbio-heading').click(function(){
                $('.stylistbio-heading-edit').fadeIn();
                $("#StylebioStylistBio").focus();
            });
            $('.edit-section-stylist-insp').click(function(){
                $('.stylist-insp-edit').fadeIn();
                $("#inspiration").focus();
            });
            
            $('.beachday-content-update1').click(function(){
                $('.beachday-update1').fadeIn();
            });
            $('.beachday-content-update2').click(function(){
                $('.beachday-update2').fadeIn();
            });
            $('.beachday-content-update3').click(function(){
                $('.beachday-update3').fadeIn();
            });
            $('.edit-caption-txt').click(function(){                
                $('.edit-caption-area').fadeIn();
            });
            
            $('.social-ntwrk-edit-pintrst').click(function(){
                $('.sosl-link-edit-pintrst').fadeIn();
            });
            
            $('.social-ntwrk-edit-twtr').click(function(){
                $('.sosl-link-edit-twtr').fadeIn();
            });
            
            $('.social-ntwrk-edit-linkin').click(function(){
                $('.sosl-link-edit-linkin').fadeIn();
            });
            
            $('.social-ntwrk-edit-fb').click(function(){
                $('.sosl-link-edit-fb').fadeIn();
            });
            
            
            
            
            
            $('.edit-save-btn, .cancel-btn').click(function(){
                $('.home-edit, .tip-edit, .fun-edit, .stylistbio-heading-edit, .stylist-insp-edit, .beachday-update1, .beachday-update2, .beachday-update3, .edit-caption-area, .sosl-link-edit-pintrst, .sosl-link-edit-twtr, .sosl-link-edit-linkin, .sosl-link-edit-fb').fadeOut();
            });
            
            $('.delete-potostream-img').click(function(){
                $(this).parent().parent().remove();
            });
            
            $('.edit-outfit-section').click (function(){
                $('.edit-beachday-section').toggle();
            });
            
            $(".otft-pop-rgt-top").height($(".myclient-popup").height());
            
//            $(".otft-pop-rgt").css({'height':($(".otft-pop-lft").height()+'px'});
            
            
            
            
//            // validate User Registeration form
//		$("#UserRegisterForm").validate({
//			rules: {
//				register-password: {
//					required: true,
//					minlength: 8
//				},
//				confirm-register-password: {
//					equalTo: "#register-password"
//				}
//			},
//			messages: {
//				register-password: {
//					required: "Please provide a password",
//					minlength: "Your password must be at least 5 characters long"
//				},
//				confirm-register-password: {
//					required: "Please provide a password",
//					equalTo: "Please enter the same password as above"
//				}
//			}
//		});
            
            
        </script>
        <script src="<?php echo JS_ROOT; ?>js/jquery.tinyscrollbar.js" type="text/javascript"></script>
        <script type="text/javascript">
           jQuery(window).load(function (){
                $("#scrollbar1").tinyscrollbar({ axis: "y"});
                $("#scrollbar2").tinyscrollbar({ axis: "y"});
                $("#scrollbar3").tinyscrollbar({ axis: "y"});
                $("#scrollbar4").tinyscrollbar({ axis: "y"});
                $("#scrollbar5").tinyscrollbar({ axis: "y"});
                $("#scrollbar6").tinyscrollbar({ axis: "y"});
                $("#scrollbar7").tinyscrollbar({ axis: "y"});
                $("#scrollbar8").tinyscrollbar({ axis: "y"});
            });
              
        
        </script>

        <script>
/*! http://mths.be/placeholder v2.0.8 by @mathias */
;(function(window, document, $) {

	var isOperaMini = Object.prototype.toString.call(window.operamini) == '[object OperaMini]';
	var isInputSupported = 'placeholder' in document.createElement('input') && !isOperaMini;
	var isTextareaSupported = 'placeholder' in document.createElement('textarea') && !isOperaMini;
	var prototype = $.fn;
	var valHooks = $.valHooks;
	var propHooks = $.propHooks;
	var hooks;
	var placeholder;

	if (isInputSupported && isTextareaSupported) {

		placeholder = prototype.placeholder = function() {
			return this;
		};

		placeholder.input = placeholder.textarea = true;

	} else {

		placeholder = prototype.placeholder = function() {
			var $this = this;
			$this
				.filter((isInputSupported ? 'textarea' : ':input') + '[placeholder]')
				.not('.placeholder')
				.bind({
					'focus.placeholder': clearPlaceholder,
					'blur.placeholder': setPlaceholder
				})
				.data('placeholder-enabled', true)
				.trigger('blur.placeholder');
			return $this;
		};

		placeholder.input = isInputSupported;
		placeholder.textarea = isTextareaSupported;

		hooks = {
			'get': function(element) {
				var $element = $(element);

				var $passwordInput = $element.data('placeholder-password');
				if ($passwordInput) {
					return $passwordInput[0].value;
				}

				return $element.data('placeholder-enabled') && $element.hasClass('placeholder') ? '' : element.value;
			},
			'set': function(element, value) {
				var $element = $(element);

				var $passwordInput = $element.data('placeholder-password');
				if ($passwordInput) {
					return $passwordInput[0].value = value;
				}

				if (!$element.data('placeholder-enabled')) {
					return element.value = value;
				}
				if (value == '') {
					element.value = value;
					// Issue #56: Setting the placeholder causes problems if the element continues to have focus.
					if (element != safeActiveElement()) {
						// We can't use `triggerHandler` here because of dummy text/password inputs :(
						setPlaceholder.call(element);
					}
				} else if ($element.hasClass('placeholder')) {
					clearPlaceholder.call(element, true, value) || (element.value = value);
				} else {
					element.value = value;
				}
				// `set` can not return `undefined`; see http://jsapi.info/jquery/1.7.1/val#L2363
				return $element;
			}
		};

		if (!isInputSupported) {
			valHooks.input = hooks;
			propHooks.value = hooks;
		}
		if (!isTextareaSupported) {
			valHooks.textarea = hooks;
			propHooks.value = hooks;
		}

		$(function() {
			// Look for forms
			$(document).delegate('form', 'submit.placeholder', function() {
				// Clear the placeholder values so they don't get submitted
				var $inputs = $('.placeholder', this).each(clearPlaceholder);
				setTimeout(function() {
					$inputs.each(setPlaceholder);
				}, 10);
			});
		});

		// Clear placeholder values upon page reload
		$(window).bind('beforeunload.placeholder', function() {
			$('.placeholder').each(function() {
				this.value = '';
			});
		});

	}

	function args(elem) {
		// Return an object of element attributes
		var newAttrs = {};
		var rinlinejQuery = /^jQuery\d+$/;
		$.each(elem.attributes, function(i, attr) {
			if (attr.specified && !rinlinejQuery.test(attr.name)) {
				newAttrs[attr.name] = attr.value;
			}
		});
		return newAttrs;
	}

	function clearPlaceholder(event, value) {
		var input = this;
		var $input = $(input);
		if (input.value == $input.attr('placeholder') && $input.hasClass('placeholder')) {
			if ($input.data('placeholder-password')) {
				$input = $input.hide().next().show().attr('id', $input.removeAttr('id').data('placeholder-id'));
				// If `clearPlaceholder` was called from `$.valHooks.input.set`
				if (event === true) {
					return $input[0].value = value;
				}
				$input.focus();
			} else {
				input.value = '';
				$input.removeClass('placeholder');
				input == safeActiveElement() && input.select();
			}
		}
	}

	function setPlaceholder() {
		var $replacement;
		var input = this;
		var $input = $(input);
		var id = this.id;
		if (input.value == '') {
			if (input.type == 'password') {
				if (!$input.data('placeholder-textinput')) {
					try {
						$replacement = $input.clone().attr({ 'type': 'text' });
					} catch(e) {
						$replacement = $('<input>').attr($.extend(args(this), { 'type': 'text' }));
					}
					$replacement
						.removeAttr('name')
						.data({
							'placeholder-password': $input,
							'placeholder-id': id
						})
						.bind('focus.placeholder', clearPlaceholder);
					$input
						.data({
							'placeholder-textinput': $replacement,
							'placeholder-id': id
						})
						.before($replacement);
				}
				$input = $input.removeAttr('id').hide().prev().attr('id', id).show();
				// Note: `$input[0] != input` now!
			}
			$input.addClass('placeholder');
			$input[0].value = $input.attr('placeholder');
		} else {
			$input.removeClass('placeholder');
		}
	}

	function safeActiveElement() {
		// Avoid IE9 `document.activeElement` of death
		// https://github.com/mathiasbynens/jquery-placeholder/pull/99
		try {
			return document.activeElement;
		} catch (err) {}
	}

    

}(this, document, jQuery));
  </script>
        
        <?php echo $this->fetch('script'); ?>

        <?php echo $this->element('scripts/srs_scripts'); ?>
        <?php echo $this->element('sql_dump'); ?>
    </body>
</html>