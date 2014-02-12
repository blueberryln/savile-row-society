<?php
$meta_description = 'As people today are rarely defined by a single company or career track, clothes have become an absolute reflection of one’s values, personality, attitude, and lifestyle.';
$this->Html->meta('description', $meta_description, array('inline' => false));
$script='
    jQuery(document).ready(function(){        
        function vidContinerHeight(){
            var mbHeight = jQuery(".mg-big").height();
            var mgsHeight = jQuery(".mg-small").height();
            var mgvHeight = mbHeight - mgsHeight;
            jQuery(".mg-vid").css("height", mgvHeight);
        }
        vidContinerHeight();               
    });
    jQuery(window).resize(function(){
           var mbHeight = jQuery(".mg-big").height();
            var mgsHeight = jQuery(".mg-small").height();
            var mgvHeight = mbHeight - mgsHeight;
            jQuery(".mg-vid").css("height", mgvHeight);
        }); 
';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
?>
<div class="content-container">
    <div class="twelve columns content inner homepage"> 
    <div class="mega-banner">
        <div class="mg-big">
            <img src="<?php echo $this->webroot; ?>img/h_1.jpg" />
            <div id="my-stylist">
                <a class="link-btn gold-btn" href="">Meet My Stylist</a>
            </div>
        </div>
        <div class="mg-vid">
            <img src="<?php echo $this->webroot; ?>img/h_4.jpg" />
            <!-- <iframe class="max-width-adj" src="http://www.youtube.com/embed/f6eqZnrWuQ8?enablejsapi=1&rel=0&version=3&wmode=transparent" frameborder="0" allowfullscreen></iframe>  -->           
        </div>
        <div class="mg-small">
            <div class="mg-small-1">
                <img src="<?php echo $this->webroot; ?>img/h_2.jpg" />
                <div class="mgs-btn">
                    <a class="link-btn black-btn" href="">Make a fitting <br />appointment</a>
                </div>
            </div>
            <div class="mg-small-2">
                <img src="<?php echo $this->webroot; ?>img/h_3.jpg" />
                <div class="mgs-btn">
                    <a class="link-btn black-btn" href="">get this look<br /> from the closet</a>
                </div>
            </div>
        </div>
        <div class="clear-fix"></div> 
    </div>
   

    <div class="ten columns text-center page-heading">
        <h1>How it works</h1>
    </div>
    <div class="container works-boxes">
        <div class="work-box">
            <img src="<?php echo $this->webroot; ?>img/how-it-works/1.png" />
            <span class="c-no"><img src="<?php echo $this->webroot; ?>img/how-it-works/no_1.png" /></span>
            <span class="works-desc">Give us your information, and be assigned a personal shopper</span>
            <div class="wrok-btn-box"><a class="works-btn">Register</a></div>
        </div> 
         <div class="work-box">
            <img src="<?php echo $this->webroot; ?>img/how-it-works/2.png" />
            <span class="c-no"><img src="<?php echo $this->webroot; ?>img/how-it-works/no_2.png" /></span>
            <span class="works-desc">Communicate on the website, on the phone or make an in-showroom appointment</span>
            <div class="wrok-btn-box"><a class="works-btn">Talk & shop</a></div>
        </div> 
         <div class="work-box">
            <img src="<?php echo $this->webroot; ?>img/how-it-works/3.png" />
            <span class="c-no"><img src="<?php echo $this->webroot; ?>img/how-it-works/no_3.png" /></span>
            <span class="works-desc">dress for the life you want</span>
            <div class="wrok-btn-box"><a class="works-btn">Look sharp</a></div>
        </div> 
    </div>
    
    <div class="ten columns text-center page-heading">
        <h1>our idea of stylist</h1>
    </div>
    <div class="eleven columns stylist-boxes">
        <div class="stylist-box">
            <div class="img-box">
                <img src="<?php echo $this->webroot; ?>img/how-it-works/img_1.png" />
                <div class="overlay"></div>
            </div>            
            <h3>Your own very stylist</h3>
            <span class="stylist-desc">Signing up with Savile Row Society means you’ll be assigned a personal stylist who will get to know your tastes and preferences, catering to all of your wardrobe and lifestyle needs.</span>
        </div> 
         <div class="stylist-box">
            <div class="img-box">
                <img src="<?php echo $this->webroot; ?>img/how-it-works/img_2.png" />
                <div class="overlay"></div>
            </div>            
            <h3>A real expert</h3>
            <span class="stylist-desc">Algorithms are great to find the cheapest flight, but fashion is about more than logic. Our tenured stylists are the best of the best, and will work hard to make our virtual closet, your reality.</span>
        </div> 
         <div class="stylist-box">
           <div class="img-box">
                <img src="<?php echo $this->webroot; ?>img/how-it-works/img_3.png" />
                <div class="overlay"></div>
            </div>            
            <h3>Communicate easily</h3>
            <span class="stylist-desc">You can chat with your stylist online, on the phone, or even in person during an appointment at our showroom.</span>            
        </div>
        <div class="stylist-box">
           <div class="img-box">
                <img src="<?php echo $this->webroot; ?>img/how-it-works/img_4.png" />
                <div class="overlay"></div>
            </div>            
            <h3>Rate products</h3>
            <span class="stylist-desc">Your personal stylist wants your feedback! Like and dislike their suggestions to give them a better sense of your style preferences.</span>
        </div>  
    </div>

    <div class="ten columns text-center page-heading">
        <h1>Seamless Shopping</h1>
    </div>
    <div class="container shopping-boxes">
        <div class="shopping-box text-left">
            <img src="<?php echo $this->webroot; ?>img/how-it-works/img_5.png" />
            <h3>Shop online</h3>
            <span class="shopping-desc">From your personal stylist’s selection curated solely for you.<br />In the Closet, where we display a selection of our products.<br />Get free shipping and hassle free return.
</span>
        </div> 
         <div class="shopping-box text-left">
            <img src="<?php echo $this->webroot; ?>img/how-it-works/img_6.png" />
            <h3>Shop in person</h3>
            <span class="shopping-desc">Try on our ready to wear by booking a free appointment in our showroom.<br />Tailor your life with our made-to-measure collection by scheduling a free consultation with our tailor.<br />Our showroom is located in New York.</span>
        </div> 
         <div class="shopping-box text-left">
            <img src="<?php echo $this->webroot; ?>img/how-it-works/img_7.png" />
            <h3>You decide</h3>
            <span class="shopping-desc">Your personal stylist is here to guide you through our collection and find the best products for your lifestyle, however, you and only you, decide what you want on your doorstep at the end of the day</span>
        </div> 
    </div>

    <div class="ten columns text-center page-heading">
        <h1>Our brands</h1>        
    </div>
    <div class="home-branding-partners center-block">
        <span class="brands-desc">We select the best of the best. From big name brands such as Barbour and Lacoste, to boutique brands such as Bernard Zins and VK Nagrani, our goal is to bring you the brands that we believe are the best in class and the best in their category. One thing is for sure, all of our partnering brands are passionate about clothing. <a href="<?php echo $this->request->webroot; ?>company/brands">See more brands</a></span>
        <ul id="branding-partners">
                       <li><img src="<?php echo $this->webroot; ?>img/branding-partners/Bernard_zins.jpg" class="fadein-image" alt="Bernard Zins" /></li>
                        <li><img src="<?php echo $this->webroot; ?>img/branding-partners/7diamonds.png" class="fadein-image" alt="7 Diamonds" /></li>
                        <li><img src="<?php echo $this->webroot; ?>img/branding-partners/agave.jpg" class="fadein-image" alt="AGAVE" /></li>
                        <li><img src="<?php echo $this->webroot; ?>img/branding-partners/CafeBleu.png" class="fadein-image" alt="CafeBleu" /></li>
                        <li><img src="<?php echo $this->webroot; ?>img/branding-partners/castaway.jpg" class="fadein-image" alt="Castaway" /></li>
                        <li><img src="<?php echo $this->webroot; ?>img/branding-partners/edward.png" class="fadein-image" alt="Edward Amrah" /></li>
                        <li><img src="<?php echo $this->webroot; ?>img/branding-partners/mclip.gif" class="fadein-image" alt="M-Clip" /></li>
                        <li><img src="<?php echo $this->webroot; ?>img/branding-partners/MooreandGiles.jpg" class="fadein-image" alt="MooreandGiles" /></li>
                        <li><img src="<?php echo $this->webroot; ?>img/branding-partners/paulevans.png" class="fadein-image" alt="Paul & Evans" /></li>
                        <li><img src="<?php echo $this->webroot; ?>img/branding-partners/petiti.png" class="fadein-image" alt="Margo Petite" /></li>
                        <li><img src="<?php echo $this->webroot; ?>img/branding-partners/saxx-underwear.png" class="fadein-image" alt="SAXX-Underwear" /></li>
                        <li><img src="<?php echo $this->webroot; ?>img/branding-partners/smathersAndBransonLogo.png" class="fadein-image" alt="Smathers And Branson" /></li>
        </ul>
    </div>

     <div class="ten columns text-center page-heading">
        <h1>Testimonials</h1>
    </div>
    <div class="six columns text-center center-block testimonials">
        <h3>Peter</h3>
        <h4>real estate agent</h4>
        <span class="testi-desc">“Like most men, shopping can be a very daunting task, however, having my SRS personal stylist saves me the time and energy I would otherwise spend in stores.”</span>
    </div>
        
</div>
</div>
