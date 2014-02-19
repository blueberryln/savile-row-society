<?php
$this->Html->css("supersized", null, array("inline" => false));
$this->Html->script("supersized.3.2.7.js", array("inline" => false));
$this->Html->script("//code.jquery.com/ui/1.10.3/jquery-ui.min.js", array("inline" => false));
            
$script = ' 
            jQuery(function($){
                
                $.supersized({
                
                    // Functionality
                    slideshow               :   1,          // Slideshow on/off
                    autoplay                :   1,          // Slideshow starts playing automatically
                    start_slide             :   1,          // Start slide (0 is random)
                    stop_loop               :   0,          // Pauses slideshow on last slide
                    random                  :   0,          // Randomize slide order (Ignores start slide)
                    slide_interval          :   3000,       // Length between transitions
                    transition              :   6,          // 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
                    transition_speed        :   1000,       // Speed of transition
                    new_window              :   1,          // Image links open in new window/tab
                    pause_hover             :   0,          // Pause slideshow on hover
                    keyboard_nav            :   1,          // Keyboard navigation on/off
                    performance             :   1,          // 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
                    image_protect           :   0,          // Disables image dragging and right click with Javascript
                                                               
                    // Size & Position                         
                    min_width               :   0,          // Min width allowed (in pixels)
                    min_height              :   0,          // Min height allowed (in pixels)
                    vertical_center         :   1,          // Vertically center background
                    horizontal_center       :   1,          // Horizontally center background
                    fit_always              :   0,          // Image will never exceed browser width or height (Ignores min. dimensions)
                    fit_portrait            :   1,          // Portrait images will not exceed browser height
                    fit_landscape           :   0,          // Landscape images will not exceed browser width
                                                               
                    // Components                           
                    slide_links             :   "blank",    // Individual links for each slide (Options: false, "num", "name", "blank")
                    thumb_links             :   1,          // Individual thumb links for each slide
                    thumbnail_navigation    :   0,          // Thumbnail navigation
                    slides                  :   [           // Slideshow Images
                                                            {image : "img/fitting-room/Fitting-1.jpg", title : "" ,url : ""},
                                                            {image : "img/fitting-room/Fitting-2.jpg", title : "" ,url : ""},
                                                            {image : "img/fitting-room/Fitting-3.jpg", title : "" ,url : ""},
                                                            {image : "img/fitting-room/Fitting-4.jpg", title : "" ,url :""}                                                          
                                                ],
                                                
                    // Theme Options               
                    progress_bar            :   1,          // Timer for each slide                         
                    mouse_scrub             :   0
                    
                });

                jQuery("div.footer").addClass("h-f");
                var winH = jQuery(window).height();
                var hH = jQuery("div.header").height();
                var fH = jQuery("div.footer").height();
                console.log(winH);
                jQuery("div.super").css("height", winH - (hH + fH));
                jQuery("div.super").css("margin-top",hH);

            });
            jQuery(window).resize(function(){
                var winH = jQuery(window).height();
                var hH = jQuery("div.header").height();
                var fH = jQuery("div.footer").height();
                console.log(winH);
                jQuery("div.super").css("height", winH - (hH + fH));
                jQuery("div.super").css("margin-top",hH);
            });

';      
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
?>

<!-- <div class="container content inner home" style="margin-top: 93px;">   
    
</div> -->
    <div class="super" style="margin-top:91px; width:100%; height:500px;">
        
    </div>
    <!--Arrow Navigation-->
    <a id="prevslide" class="load-item"></a>
    <a id="nextslide" class="load-item"></a>
    <div id="book-apt"><a href="#" class="link-btn gold-btn">Make an appointment</a></div>