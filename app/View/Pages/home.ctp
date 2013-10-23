<?php

$script ='
    
   $(".flexslider").flexslider({
	            animation: "slide",
	            slideshow: false,
                video: false,
                useCSS: false,
                controlNav: false	            
	        });
            $("#lnk-fb-share").on("click", function(e){
        e.preventDefault(); 
        window.open(
          "https://www.facebook.com/sharer/sharer.php?u="+encodeURIComponent(location.href), 
          "facebook-share-dialog", 
          "width=626,height=436"); 
    });

';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$meta_description = 'As an SRS Man, great things are expected of you. But let us take care of the details. We\'ll perfect your image from head to toe.';
$img_src = "//www.savilerowsociety.com/img/SRS_600.png";
$this->Html->meta('description', $meta_description, array('inline' => false));
$this->Html->meta(array('property'=> 'og:title', 'content' => 'Savile Row Society', ),'',array('inline'=>false));
$this->Html->meta(array('property'=> 'og:description', 'content' => $meta_description),'',array('inline'=>false));
$this->Html->meta(array('property'=> 'og:url', 'content' => "//www.savilerowsociety.com/"),'',array('inline'=>false));
$this->Html->meta(array('property'=> 'og:image', 'content' => $img_src),'',array('inline'=>false));
?>
<div class="container content inner home">	

    <div class="sixteen columns flexslider loader" style="height: 325px;">
        <ul class="slides">
            <li><img src="<?php echo $this->request->webroot; ?>img/home-1.jpg"/></li>
            <li><img src="<?php echo $this->request->webroot; ?>img/home-2.jpg"/></li>     
            <li><iframe class="max-width-adj" width="940" height="325" src="//www.youtube.com/embed/BygtFwK_Dpw?wmode=transparent&rel=0" frameborder="0" allowfullscreen></iframe>
            </li> 
        </ul>
    </div>

    <div class="sixteen columns social-bar">

        <div class="eigth columns home-side"><b>Let us </b> define your style & refine your image</div>
        <span class="launch-info">Launching Fall 2013</span>
    </div>
    
    <div class="six columns text-center">
        <img src="<?php echo $this->request->webroot; ?>img/Exclusive1.png" style="height: 200px; margin-top: 35px;" />
    </div>

    <div class="nine columns">
        <h2 style="margin-top: 55px;">
            <p>SAVILE ROW SOCIETY is a Men's Personal Shopping Platform. Our mission is to achieve an efficient, interactive, educational online shopping experience.</p> 
            <p>SAVILE ROW SOCIETY has created an exclusive men's lifestyle shopping destination on a virtual platform. SRS developed an innovative client profile merchandise matching technology while recruiting reputable industry fit &amp; styling experts. Our virtual platform is the most efficient and convenient way to shop.</p> 
        </h2>
    </div>
    
    <img class="membership-flow fifteen columns offset-by-half" src="<?php echo $this->request->webroot; ?>img/membership1.png" />
    <div class="fourteen offset-by-one columns">
        <p>
            As a SAVILE ROW SOCIETY member you will receive exclusive Personal Lifestyle Services and access to our Deluxe Perks. We have 3 levels of membership to suit your needs and allow you to grow with us.
        </p>
        <p>
            All Members receive an exclusive SRS Membership Card that provides Deluxe Perks online and in-house with our partnering hotels, restaurants, bars, salons, and clubs. We like making your life a little more enjoyable. 
        </p><br />
    </div>
    <table id="membership-table" class="membership-table-home " >
        <thead>
        <th class="mem-top-left" style="background-color: #E6E6E6; width: 40%;">Features</th>
        <th style="background-color: #80A2A1;">Day pass</th>
        <th style="background-color: #E6E6E6;">Squire circle $20/ month</th>
        <th class="mem-top-right" style="background-color: #D2C9B6;">Knight Circle $50/ month</th>
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
                    <div class="title">Free Shipping/Returns </div>
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
                    <div class="description">Get invited to our exclusive partners events</div>
                </td>
                <td ></td>
                <td ></td>
                <td class="included"></td>
            </tr>
            <tr>
                <td class="membership-service-option mem-bottom-left">
                    <div class="title">Fitness Coach Access (coming soon) </div>
                    <div class="description">Ask him any fitness question!</div>
                </td>
                <td ></td>
                <td ></td>
                <td class="included mem-bottom-right"></td>
            </tr>
        </tbody>
    </table>
    <div class="clear"></div>
</div>