<?php
$script_booked = '';
if ($booked) {
    $script_booked = ',disable: [';
    foreach ($booked as $book) {
        $script_booked .= '[' . date("Y", $book['Booking']['date_start']) . ',' . (date("m", $book['Booking']['date_start']) - 1) . ',' . date("d", $book['Booking']['date_start']) . '], ';
    }
    $script_booked .= ']';
}

$script = '
$(document).ready(function(){    
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
});
';

//$this->Html->script('pickadate.min', array('inline' => false));
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->css('ui/jquery-ui', null, array('inline' => false));
$this->Html->script('//code.jquery.com/ui/1.10.3/jquery-ui.min.js', array('inline' => false));
$meta_description = 'As a member, you will be up to date on styles, always look put together, and develop a wardrobe that captures the look you desire.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>



<div class="container content inner booking">	
    <!-- 
    <div class="sixteen columns hero">
        <h2>Tailor</h2>
        <img class="three columns fadein-image" src="<?php echo $this->request->webroot; ?>img/team-member-07.jpg" alt="Joey Glazer" />
        <div class="seven columns alpha omega team-member">
            <div class="name">Joey Glazer</div>
            <div class="title">President, Custom Clothing</div>
            <p>
                With 20 years in the industry, Fashion Stylist Joey Glazer has built a reputation in brand building and textile development in luxury clothing, dressing some of the top executives in NYC. Since childhood, Joey has been drawn to the intricate designs and details of well-made clothing and the lifestyle that begets it. This passion encouraged him to live a life dedicated to fashion. 
            </p>
        </div>

        <iframe class="six columns" height="200" src="//www.youtube.com/embed/ZIeZdN1rYAQ" frameborder="0" allowfullscreen></iframe>

    </div>
    -->
    <div class="sixteen columns flexslider loader" style="height: 438px;">
        <ul class="slides">
            <li><img src="<?php echo $this->request->webroot; ?>img/tailor-1.jpg"></li>
            <li><a href="mailto:&#070;&#105;&#116;&#116;&#105;&#110;&#103;&#064;&#083;&#097;&#118;&#105;&#108;&#101;&#082;&#111;&#119;&#083;&#111;&#099;&#105;&#101;&#116;&#121;&#046;&#099;&#111;&#109;"><img src="<?php echo $this->request->webroot; ?>img/booking-1.jpg"></a></li>
            <li><a href="<?php echo $this->request->webroot; ?>booking"><img src="<?php echo $this->request->webroot; ?>img/booking-2.jpg"></a></li>
            <li><a href="<?php echo $this->request->webroot; ?>booking"><img src="<?php echo $this->request->webroot; ?>img/booking-3.jpg"></a></li>
        </ul>
    </div>
    <div class="clearfix"></div>
    <div class="sixteen columns">
        <br/><br/>
    </div>
    
    <div class="seven columns book-appointment offset-by-one">
        <h2>Book an appointment</h2>
        <div class="srs-form six columns">
            <div class="form">
            <?php if ($user && $booking_types) : ?>
                <?php echo $this->Form->create('Booking', array('url' => array('controller' => 'booking', 'action' => 'index'))); ?>
                <h4 class="hi-message">Hi, <?php echo $user['User']['first_name'] . " " . $user['User']['last_name']; ?></h4>
                <p>When would you like to come?</p> 
                <div>
                    <label>Please select a date</label>
                    <input class="datepicker" name="data[Booking][date]" id="BookingDate" value="" type="text" placeholder="Please select a date" />
                </div>
                
                <div class="input text required">
                            <label for="BookingType">Appointment type</label>                            
                            <select name="data[BookingType][id]" tabindex="" id="BookingType">  
                                <option value="">Select Appointment Type</option>                              
                                <?php foreach($booking_types as $booking_type): ?>
                                <option value="<?php echo $booking_type['BookingType']['id']; ?>"><?php echo $booking_type['BookingType']['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                </div>

                
                <div style="margin-top:5px; margin-bottom:30px;">
                <label>ADD A COMMENT</label>
                <textarea name="data[Booking][comment]" id="BookingComment"></textarea>
                </div>
                <div class="book-it-btn">
                    <?php echo $this->Form->end(array('value'=>'BOOK NOW', 'id' => 'book-button')); ?>
                    <span class="err-message">Please complete all the fields first.</span>
                </div>
                
            <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="seven columns contact-subpage omega">
        <h2>Contact us</h2>
        <div class="contact-map-info">
            <div class="contact-map">
                <iframe width="370" height="200" scrolling="no" frameborder="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=902+Broadway,+New+York,+NY,+United+States&amp;sll=40.763641,-73.977728&amp;sspn=0.056948,0.132093&amp;ie=UTF8&amp;hq=&amp;hnear=902+Broadway,+New+York,+10010&amp;t=m&amp;z=14&amp;iwloc=A&amp;output=embed&amp;iwloc=near" marginwidth="0" marginheight="0"></iframe>
            </div>
            <div class="contact-info">
                <h4>Showroom:</h4>
                <p>902 Broadway, 6th Floor, <br />New York, NY 10010</p>
                <p class="phone">+1 347 878 7280</p>
            </div>
        </div>
    </div>
    
    <div class="clearfix"></div><br />
    <br /><br />

    <div class="seven columns text-center offset-by-one">
        <img src="<?php echo $this->request->webroot; ?>img/custom-tailor-joe.jpg" class="fadein-image booking-joey" />
        
        
    </div>
    <div class="seven columns">
            <div class="seven columns text-justify">
                <h3>Meet Joey Glazer</h3>
                <h4>MADE TO MEASURE DIRECTOR</h4>
                <p>With 20 years in the industry, Joey Glazer has built a reputation in menswear from brand building and textile development in luxury clothing to dressing top executives. Joey is  drawn to the details of well-made clothing; his  passion is easily recognized.</p>
                <p>Through this work, Joey discovered the true need for customized service in the men's fashion industry. Joining the Savile Row Society team is just one more way that is contributing to the style and wardrobes of men who demand perfection.</p>
                <div class="long-desc hide">
                    <p>When you schedule your first fitting with SRS, you will meet Joey for a one-on-one consultation and he will walk you through the our Made to Measure process, capture your measurements and get to know your garment preferences and lifestyle needs of your clothing.</p> 
                    <p>Made to Measure has never been this simple.</p>
                </div>
                <div class="text-center">
                    <a class="show-more-text" href="#" title="Show more">Show more</a>
                </div>
            </div>
    </div>    
</div>