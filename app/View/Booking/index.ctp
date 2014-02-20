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
                
                $("#BookingDate").datepicker({ dateFormat: "d MM, yy" });
                    $("#book-button").on("click", function(e){
                        e.preventDefault();
                        var error = false;
                        if($("#BookingDate").val() == ""){
                            error = true;    
                        }
                        if($("#BookingType").val() == ""){
                            error = true;    
                        }
                        if($("#BookingComment").val() == ""){
                            error = true;    
                        }
                        
                        if(error){
                            $(".book-it-btn .err-message").show();
                        }
                        else{
                            $(".book-it-btn .err-message").hide();
                            $("#BookingIndexForm").submit();
                        }
                    });

                jQuery("#book-apt").on("click", function(){
                    $.blockUI({message: $("#bookapt-box")});
                    $(".blockOverlay").click($.unblockUI); 
                });  
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
$this->Html->css('ui/jquery-ui', null, array('inline' => false));
$this->Html->script('//code.jquery.com/ui/1.10.3/jquery-ui.min.js', array('inline' => false));
$meta_description = 'As a member, you will be up to date on styles, always look put together, and develop a wardrobe that captures the look you desire.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>

<!-- <div class="container content inner home" style="margin-top: 93px;">   
    
</div> -->
    <div class="super" style="margin-top:91px; width:100%; height:500px;">
        
    </div>
    <!--Arrow Navigation-->
    <!-- <a id="prevslide" class="load-item"></a>
    <a id="nextslide" class="load-item"></a> -->
    <div id="book-apt"><a href="#" class="link-btn gold-btn">Make an appointment</a></div>
    <div id="bookapt-box" class="box-modal notification-box hide">
        <div class="box-modal-inside">
            <a class="notification-close" href=""></a>
            <div class="book-apt-info">
                <h5 class="book-apt-title">Book An Appointment</h5>

                <div class="book-apt-content">
                    <div class="showroom">                       
                        <div class="contact-info left text-left">
                            <h4>Showroom:</h4>
                            <p>902 Broadway, 6th Floor, <br />New York, NY 10010</p>                            
                            <p class="phone">+1 347 878 7280</p>
                        </div>
                        <div class="s-map right">                          
                            <iframe height="105" scrolling="no" frameborder="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=902+Broadway,+New+York,+NY,+United+States&amp;sll=40.763641,-73.977728&amp;sspn=0.056948,0.132093&amp;ie=UTF8&amp;hq=&amp;hnear=902+Broadway,+New+York,+10010&amp;t=m&amp;z=14&amp;iwloc=A&amp;output=embed&amp;iwloc=near" marginwidth="0" marginheight="0">                                
                        </iframe>
                        </div>
                        <div class="clear-fix"></div>
                    </div>

                    <div class="apt-form">
                        <?php if ($user && $booking_types) : ?>
                            <?php echo $this->Form->create('Booking', array('url' => array('controller' => 'booking', 'action' => 'index'))); ?>                
                            <p class="apt-form-title">When would you like to come?</p> 
                            <div>
                                <input type="text" style="height: 0; visibility: hidden; padding:0; margin: 0; border: none; position: absolute; text-indent: -999999;">
                                <label>Please select a date</label>
                                <input class="datepicker" name="data[Booking][date]" id="BookingDate" value="" type="text" placeholder="Please select a date" />
                            </div>
                            
                            <div class="input text required text-left">
                                        <label class="apt-type-title">Appointment type</label>
                                         <?php foreach($booking_types as $booking_type): ?>
                                         <input type="checkbox" value="<?php echo $booking_type['BookingType']['id']; ?>" name="data[BookingType][id]"><span class="apt-type-lbl"><?php echo $booking_type['BookingType']['name']; ?></span><br />
                                         <?php endforeach; ?>                                         
                            </div>
                            
                            <div class="apt-comment">
                            <label>ADD A COMMENT</label>
                            <textarea name="data[Booking][comment]" id="BookingComment"></textarea>
                            </div>
                            <div class="book-it-btn">
                                <?php echo $this->Form->end(array('value'=>'Submit', 'id' => 'book-button')); ?>
                                <span class="err-message">Please complete all the fields first.</span>
                            </div>
                            
                        <?php endif; ?>
                    </div>
                    
                </div>               
            </div> 
        </div>
    </div>