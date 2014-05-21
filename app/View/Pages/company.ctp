<?php

$script ='
   var player; 
   $(".flexslider").flexslider({
                animation: "fade",
                animationSpeed: 300,  
                animationLoop: false,
                slideshow: true,          
                slideshowSpeed: 6000, 
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
$this->Html->css('flexslider', null, array("inline" => false));
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));

$meta_description = 'As people today are rarely defined by a single company or career track, clothes have become an absolute reflection of one’s values, personality, attitude, and lifestyle.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>
<div class="content-container">
    <div class="container content inner aboutus">   
    <div class="ten columns text-center page-heading">
        <h1>About Us</h1>
    </div>
    <div class="eleven columns page-content">
        <div class="flexslider loader">
            <ul class="slides">
                
                <li><a href="<?php echo $this->request->webroot; ?>closet"><img src="<?php echo $this->request->webroot; ?>img/home-6-big.jpg"/></a></li>
                

                <?php
                    if (!$is_logged && false) {
                        echo '<li><a href="#" onclick="signUp();"><img src="' . $this->webroot . 'img/home-5-big.jpg"/></a></li> ';                   
                    } else {
                        echo ' <li><img src="' . $this->webroot . 'img/home-5-big.jpg"/></li>';
                    }
                    ?> 

                <li class="highlight-slide danielle">
                    <img src="<?php echo $this->request->webroot; ?>img/home-7-big.jpg" style="max-height: 438px; width: auto !important; display: inline;" />
                    <div class="home-slider-overlay hide"><span>Check Out Danielle Wellington</span></div>
                </li>

                <?php
                    if (!$is_logged && false) {
                        echo '<li><a href="#" onclick="signUp();"><img src="' . $this->webroot . 'img/home-2-big.jpg"/></a></li> ';                   
                    } else {
                        echo ' <li><img src="' . $this->webroot . 'img/home-2-big.jpg"/></li>';
                    }
                    ?>    
                
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
            </ul>
        </div>
        
        <div class="clear"></div>

        <!--Flexslider ends here -->

        <p>
            Savile Row Society is an exclusive <strong>Men’s</strong> club, designed to enhance the personal 
            branding of professional men and transform their shopping <strong>experience</strong> through 
            a personalized <strong>web-based retail shopping and styling</strong> service. 
        </p>
        <p>
            We are rarely defined by the company we work for or the career track we have chosen. 
            Clothing has become an absolute reflection of one’s personal values, personality, 
            attitude, and lifestyle. Now more than ever, people are incorporating freedom and 
            movement and their lives and Savile Row Society (SRS) is here to sharpen your game.
        </p>
        <div class="text-center">
            <img alt="" src="<?php echo $this->request->webroot; ?>img/home-blok.png" class="fadein-image max-width-adj">
        </div>

        <p>
            Savile Row Society assists you in building a distinctive personal brand that exudes 
            confidence and fits your lifestyle at your own pace. You can refresh staples (new boxer briefs?), 
            take care of Social Event needs (attending a wedding?), upgrade a complete work wardrobe to ensure 
            you are putting your best foot forward in an increasingly competitive environment, or learn how to 
            dress casually and find your own personal style. 
        </p>
        <p>
            No need to try on clothes picked by salespeople who know little to nothing about the clothing they're 
            selling and will never take the time to get to know you or attempt to develop your style. This is 
            for your own good, we have professionals for this! SRS will hone in on your current wardrobe, tastes, 
            passions, career expectations, and lifestyle to present you with wardrobe options that are uniquely 
            designed to augment your success. 
        </p>
        <p>
            We have relationships with retailers, brands and manufacturers that have strong value structures,
            exude a passion for the business and allow us to bring our members the best of the best. Shop with us 
            and know we’ve done the homework; we’ll stretch and spend your dollar wisely. Savile Row Society 
            products, partnerships and members are loved like family. 
        </p>

        <br>

        <p class="text-center">
            <em class="font-big font-bold">"When your clothes fit you completely, all they’ll remember is the man"</em> 
            <br><strong>- Ralph Waldo Emerson</strong>
        </p>

        <br/>

        <!-- <div class="text-center">
            <iframe class="max-width-adj" width="560" height="315" src="//www.youtube.com/embed/h6MnC98hd_c" frameborder="0" allowfullscreen></iframe>
        </div> -->

    </div>
</div>
</div>
<script src="/js/jquery.flexslider-min.js"></script>
