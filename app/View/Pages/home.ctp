<?php

$script ='
   var player; 
   $(".flexslider").flexslider({
	            animation: "fade",
                animationSpeed: 300,  
                animationLoop: false,
	            slideshow: true,          
                slideshowSpeed: 4000, 
                video: true,
                useCSS: false,
                pauseOnAction: false,
                manualControls: ".flex-control-nav li",
                controlsContainer: ".flexslider",
                controlNav: true,
                directionNav: false,
                keyboard: false,
                start: function(slider){
                    jQuery(".flex-control-nav li a").mouseover(function(){
                         var activeSlide = "false";
                         if (jQuery(this).hasClass("flex-active")){  
                            activeSlide = "true";                       
                         }
                         if (activeSlide == "false"){
                            var position = $(this).position();
                            jQuery(this).trigger("click"); 
                            $(".flex-active-bar").stop(false, false).animate({left: position.left + "px"}, 500, "swing");
                         }
                     });      
                },
                before: function(slider){
                    var slideTo = slider.animatingTo;
                    var nextSlide = $(".flex-control-nav li").eq(slideTo);
                    var position = nextSlide.position();
                    $(".flex-active-bar").stop(false, false).animate({left: position.left + "px"}, 500, "swing");
                },
	        });
    $("#lnk-fb-share").on("click", function(e){
        e.preventDefault(); 
        window.open(
          "https://www.facebook.com/sharer/sharer.php?u="+encodeURIComponent(location.href), 
          "facebook-share-dialog", 
          "width=626,height=436"); 
    });
    
    $(".register-popup-share-link").on("click", function(e){
        e.preventDefault();
        $("#lnk-fb-share").click();
        $.unblockUI();    
    });
    
    //Load you tube api
    var tag = document.createElement("script");
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName("script")[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    
    function onYouTubeIframeAPIReady() {
        player = new YT.Player("homeVideoHowItWorks", {
          events: {
            "onStateChange": function(event) {
                if (event.data == 1 || event.data == 3) {
                    $(".flexslider").flexslider("pause");
                }
                else if (event.data == 0 || event.data == 2 || event.data == 5) {
                    $(".flexslider").flexslider("play");
                }
            }
          }
        });
    }
    
    $(document).ready(function(){
        
        $("#closetCuffLink").hover(
            function(){
                $("#closet-slide-banner").fadeIn(300);      
            },
            function(){
                $("#closet-slide-banner").delay(200).fadeOut(300);      
            }
        );
        $("#tailorCuffLink").hover(
            function(){
                $("#tailor-slide-banner").fadeIn(300);      
            },
            function(){
                $("#tailor-slide-banner").delay(200).fadeOut(300);      
            }
        );
        $("#stylistCuffLink").hover(
            function(){
                $("#stylist-slide-banner").fadeIn(300);      
            },
            function(){
                $("#stylist-slide-banner").delay(200).fadeOut(300);      
            }
        );
        
        $(".highlight-slide").hover(
            function(){
                var $this = $(this);
                var hoverText = $this.find(".home-slider-overlay span");
                hoverText.css({top: $this.height()/2 - hoverText.height()/2});
                $(this).find(".home-slider-overlay").fadeOut(300);
                $(this).find(".home-slider-overlay").fadeIn(300);
            },
            function(){
                var $this = $(this);
                var hoverText = $this.find(".home-slider-overlay span");
                $(this).find(".home-slider-overlay").fadeOut(300);
            }
        );

        $(".danielle").on("click", function(e){  
            location = "http://www.savilerowsociety.com/closet/all/22/none/brand";
        });
    });

';
$script1 ='
$(window).load(function() {
    //var dropdown=getCookie("dropdown");
    var dropdown = getCookie("cyberDropdown");
    if (dropdown==null || dropdown=="")
    {
        setTimeout(function (){
            $("#sign-up-drop-down").slideDown(1000, "easeOutBack");
        }, 500);
    }


    $(".close").click(function(e){
        e.preventDefault();
        //setCookie("dropdown",1,1);
        setCookie("cyberDropdown",1,1);
        $("#sign-up-drop-down").slideUp(600, "easeInBack");
    });
    
});
';
$this->Html->scriptBlock($script1, array('safe' => true, 'inline' => false));
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$meta_description = 'As an SRS Man, great things are expected of you. But let us take care of the details. We\'ll perfect your image from head to toe.';
$img_src = "//www.savilerowsociety.com/img/SRS_600.png";
$meta_keywords="mens personal shopping,professional fashion advice,mens shopping advice,mens personal styling,mens fashion consulting,mens clothing stylist,mens personal branding,mens personal outfits,mens professional stylist,made to measure suits,tailored suits,mens business suits,bespoke suits,custom suit,high quality suits,mens tailor nyc,suits in nyc,custom suiting,tailor in nyc,custom bespoke suits,tailor in new york city,trunk club,tailor in manhattan,suits in new york city,men made to measure suits,bombfell";
$this->Html->meta("keywords", $meta_keywords, array("inline" => false));
$this->Html->meta('description', $meta_description, array('inline' => false));
$this->Html->meta(array('property'=> 'og:title', 'content' => 'Savile Row Society', ),'',array('inline'=>false));
$this->Html->meta(array('property'=> 'og:description', 'content' => $meta_description),'',array('inline'=>false));
$this->Html->meta(array('property'=> 'og:url', 'content' => "//www.savilerowsociety.com/"),'',array('inline'=>false));
$this->Html->meta(array('property'=> 'og:image', 'content' => $img_src),'',array('inline'=>false));
$this->Html->script("//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js", array('safe' => true, 'inline' => false));
$this->Html->script('cookie.js', array('inline' => false));
//$this->Html->script('jquery.rwdImageMaps.min.js', array('inline' => false));
?>

<div style="width: 100%; margin-top: 124px;">
<?php if (!$is_logged) { ?>
<div id="sign-up-drop-down">
    <div class="close"><a href="#"> &#215;</a></div>
    <p>Tailor Your Life</p>
    <div class="initial-module container">
        <div class="fourteen columns offset-by-one">
            <?php
                echo '<input type="button"  value="Join Now" class = "join_button" onclick="window.ref_url=\'\'; signUp();" >';
                echo '<p class="show-login-form">Don\'t be shy! Help us, help you by filling our your Style Profile. We want to get to know you so that we can cater to all of your wardrobe needs.</p>';
    
            ?>
        </div>
    </div>

</div>
<?php } ?>
<div class="container content inner home" style="margin-top: 0px;">	

    <div class="sixteen columns flexslider loader" style="height: 438px;">
        <ul class="slides">
            
            <li><a href="<?php echo $this->request->webroot; ?>closet"><img src="<?php echo $this->request->webroot; ?>img/home-6-big.jpg"/></a></li>
             <?php
                if (!$is_logged) {
                    echo '<li><a href="#" onclick="window.ref_url=\'\'; signUp();"><img src="' . $this->webroot . 'img/home-1-big.jpg"/></a></li> ';                   
                } else {
                    echo ' <li><img src="' . $this->webroot . 'img/home-1-big.jpg"/></li>';
                }
                ?>
            <li>
                <div class="slides-cont">
                    <img src="<?php echo $this->request->webroot; ?>img/home-3-big.jpg" usemap="#getstyled" id="getStyledImage" />
                    <img src="<?php echo $this->request->webroot; ?>img/1.png" id="closet-slide-banner" />
                    <img src="<?php echo $this->request->webroot; ?>img/2.png" id="tailor-slide-banner" />
                    <img src="<?php echo $this->request->webroot; ?>img/3.png" id="stylist-slide-banner" />
                </div>
            </li>

            <?php
                if (!$is_logged) {
                    echo '<li><a href="#" onclick="window.ref_url=\'\'; signUp();"><img src="' . $this->webroot . 'img/home-5-big.jpg"/></a></li> ';                   
                } else {
                    echo ' <li><img src="' . $this->webroot . 'img/home-5-big.jpg"/></li>';
                }
                ?> 

            <li class="highlight-slide danielle">
                <img src="<?php echo $this->request->webroot; ?>img/home-7-big.jpg" style="max-height: 438px; width: auto !important; display: inline;" />
                <div class="home-slider-overlay hide"><span>Check Out Danielle Wellington</span></div>
            </li>

            <li><img src="<?php echo $this->request->webroot; ?>img/home-8-big.jpg" style="max-height: 438px; width: auto !important; display: inline;" /></li>
            <?php
                if (!$is_logged) {
                    echo '<li><a href="#" onclick="window.ref_url=\'\'; signUp();"><img src="' . $this->webroot . 'img/home-2-big.jpg"/></a></li> ';                   
                } else {
                    echo ' <li><img src="' . $this->webroot . 'img/home-2-big.jpg"/></li>';
                }
                ?>     
            <li>
                <iframe id="homeVideoHowItWorks" width="100%" height="438" src="//www.youtube.com/embed/f6eqZnrWuQ8?enablejsapi=1&rel=0&version=3&wmode=transparent" frameborder="0" allowfullscreen></iframe>
            </li>    
            
        </ul>
    </div>
    <div class="clear"></div>    
    <div class="custom-flex-cont sixteen columns">
        <div class="flex-active-bar"></div>
        <ul class="flex-control-nav">
            <li><a href="">1</a></li>
            <li><a href="">2</a></li>
            <li><a href="">3</a></li>
            <li><a href="">4</a></li>
            <li><a href="">5</a></li>
            <li><a href="">6</a></li>
            <li><a href="">7</a></li>
            <li><a href="">8</a></li>
        </ul>
    </div>
    
    <div class="clear"></div>
    <map id="getstyledMap" name="getstyled">
        <area shape="rect" alt="" title="" coords="433,52,564,150" href="<?php echo $this->request->webroot; ?>closet" id="closetCuffLink" />
        <area shape="rect" alt="" title="" coords="100,291,215,376" href="<?php echo $this->request->webroot; ?>booking" id="tailorCuffLink" />
        <area shape="poly" alt="" title="" coords="528,315,531,396,645,393,642,308" href="<?php echo $this->request->webroot; ?>stylist" id="stylistCuffLink" />
    </map>
    
    <div class="six columns text-center">
        <img src="<?php echo $this->request->webroot; ?>img/Exclusive1.png" style="height: 200px; margin-top: 35px;" />
    </div>

    <div class="nine columns">
        <h2 style="margin-top: 55px;">
            <p>Savile Row Society is a men's personal shopping platform. Our mission is to achieve an efficient, interactive, educational online shopping experience.</p> 
            <p>Savile Row Society has created an exclusive men's lifestyle shopping destination on a virtual platform. SRS developed an innovative client profile merchandise matching technology while recruiting reputable industry fit &amp; styling experts. Our virtual platform is the most efficient and convenient way to shop.</p> 
        </h2>
    </div>
    
    <img class="membership-flow fifteen columns offset-by-half" src="<?php echo $this->request->webroot; ?>img/membership1.png" />
    <div class="clear"></div>
        
    <div class="four columns text-center">
        <img src="<?php echo $this->request->webroot; ?>img/free_beta.png" style="margin-top: 30px;" />
    </div>

    <div class="eleven columns">
        <p>
            As a Savile Row Society member you will receive exclusive personal lifestyle services and access to our deluxe perks. We have 3 levels of membership to suit your needs and allow you to grow with us.
        </p>
        <p>
            All Members receive deluxe perks online and in-house with our partnering hotels, restaurants, bars, salons, and clubs. We like making your life a little more enjoyable. 
        </p>
        <p style="color: #AF9A59; font-weight: bold;">
            Sign up now during our free beta period and be grandfathered into a free membership once the beta period ends! Thank you for giving us a shot! We look forward to getting to know you.
        </p>
    </div>
    <div class="clear"></div>
    <br />
    
    <table id="membership-table" class="membership-table-home " >
        <thead>
        <th class="mem-top-left" style="background-color: #E6E6E6; width: 40%;">Features</th>
        <th style="background-color: #80A2A1;">Day pass</th>
        <th style="background-color: #E6E6E6;">Squire circle $20/month</th>
        <th class="mem-top-right" style="background-color: #D2C9B6;">Knight Circle $50/month</th>
        </thead>
        <tbody>
            <tr>
                <td class="membership-service-option">
                    <div class="title">Access to The Closet </div>
                    <div class="description">Shop SRS exclusive brands and merchandise</div>
                </td>
                <td class="included"></td>
                <td class="included"></td>
                <td class="included"></td>
            </tr>
            <tr>
                <td class="membership-service-option">
                    <div class="title">Invitation to SRS Events </div>
                    <div class="description">Shop SRS exclusive brands and merchandise</div>
                </td>
                <td class="included"></td>
                <td class="included"></td>
                <td class="included"></td>
            </tr>
            <tr>
                <td class="membership-service-option">
                    <div class="title">Custom Suiting Appointments </div>
                    <div class="description">Get professionally fitted for a custom SRS suit</div>
                </td>
                <td class="included"></td>
                <td class="included"></td>
                <td class="included"></td>
            </tr>
            <tr>
                <td class="membership-service-option">
                    <div class="title">Online Stylist Access </div>
                    <div class="description">Interact online with your own personal stylist</div>
                </td>
                <td ></td>
                <td class="included"></td>
                <td class="included"></td>
            </tr>
            <tr>
                <td class="membership-service-option">
                    <div class="title">Free Shipping</div>
                    <div class="description">Shipping is always on us!</div>
                </td>
                <td ></td>
                <td class="included"></td>
                <td class="included"></td>
            </tr>
            <tr>
                <td class="membership-service-option">
                    <div class="title">SRS Deluxe Perks </div>
                    <div class="description">Access to exclusive member benefits!</div>
                </td>
                <td ></td>
                <td class="included"></td>
                <td class="included"></td>
            </tr>
            <tr>
                <td class="membership-service-option">
                    <div class="title">Stylist response  within 30 minutes</div>
                    <div class="description">Get instant responses to any fashion query</div>
                </td>
                <td ></td>
                <td ></td>
                <td class="included"></td>
            </tr>
            <tr>
                <td class="membership-service-option">
                    <div class="title">Person-to-Person or in Home Consultation </div>
                    <div class="description">(Fee may apply)</div>
                </td>
                <td ></td>
                <td ></td>
                <td class="included"></td>
            </tr>
            <tr>
                <td class="membership-service-option">
                    <div class="title">Assistance in Fashion Emergencies </div>
                    <div class="description">Your stylist will always find a solution</div>
                </td>
                <td ></td>
                <td ></td>
                <td class="included"></td>
            </tr>
            <tr>
                <td class="membership-service-option">
                    <div class="title">Exclusive Events Invitation </div>
                    <div class="description">Get invited to our exclusive partners' events</div>
                </td>
                <td ></td>
                <td ></td>
                <td class="included"></td>
            </tr>
            <tr>
                <td class="membership-service-option mem-bottom-left">
                    <div class="title">Fitness Coach Access (coming soon) </div>
                    <div class="description">Ask our professional fitness coach any question!</div>
                </td>
                <td ></td>
                <td ></td>
                <td class="included mem-bottom-right"></td>
            </tr>
        </tbody>
    </table>
    <div class="clear"></div>
</div>
</div>