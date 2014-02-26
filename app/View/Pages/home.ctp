<?php
$meta_description = 'As people today are rarely defined by a single company or career track, clothes have become an absolute reflection of one’s values, personality, attitude, and lifestyle.';
$this->Html->meta('description', $meta_description, array('inline' => false));
$script='
    var testimonials = [
        {name : "Peter", profession: "Real estate agent", text: "Like most men, shopping can be a very daunting task, however, having my SRS personal stylist saves me the time and energy I would otherwise spend in stores."},
        {name : "Frank", profession: "Architect", text: "Savile Row Society has made shopping simple and seamless. I now have access to the best brands, the sharpest suits, and the perfect gift suggestions for friends and family. SRS is truly a lifestyle destination."},
        {name : "Scott", profession: "Investment Manager", text: "I work long hours with minimal time to dedicate to shopping. My stylist has made shopping simple by suggesting outfits and products to develop my wardrobe. Now I no longer need to worry about what I’m going to wear."},
        {name : "Tyler", profession: "Lawyer", text: "I have recently transitioned from my old suiting and shirting provider to Savile row Society’s custom wear collection. From my experience, their prices are unmatched and the quality of the garment speaks for itself. I would recommend SRS’s custom wear any day over other competitors."}
    ];
    var currentTestimonial = 0,
        testimonialBlock = $(".testimonials");
        testimonialUser = testimonialBlock.find("h3"),
        testimonialProfession = testimonialBlock.find("h4"),
        testimonialText = testimonialBlock.find("span");

    jQuery(function(){
            if(jQuery(".mg-big img")[0].complete && jQuery(".mg-small div img")[0].complete){
                vidContinerHeight()
            }
            else{
                jQuery(".mg-big img, .mg-small div img").load(function() {
                    vidContinerHeight()
                });
            }   
            
            var testimonialInterval = setInterval(function(){
                var newTestimonial = currentTestimonial = (testimonials.length == (currentTestimonial + 1)) ? 0 : currentTestimonial + 1;
                testimonialBlock.animate({opacity: 0}, 300, function(){
                    testimonialUser.text(testimonials[newTestimonial]["name"]);
                    testimonialProfession.text(testimonials[newTestimonial]["profession"]);
                    testimonialText.text(testimonials[newTestimonial]["text"]);
                    testimonialBlock.animate({opacity: 1}, 500);
                })
            }, 4000);     
    });    
   
   
    function vidContinerHeight(){
        var mbHeight = jQuery(".mg-big").height();
        var mgsHeight = jQuery(".mg-small").height();
        var mgvHeight = mbHeight - mgsHeight;
        jQuery(".mg-vid").css("height", mgvHeight);
    }
    jQuery(window).resize(function(){
           var mbHeight = jQuery(".mg-big").height();
            var mgsHeight = jQuery(".mg-small").height();
            var mgvHeight = mbHeight - mgsHeight;
            jQuery(".mg-vid").css("height", mgvHeight);
        }); 
';
if(isset($noindex)){
    echo $this->Html->meta(array('name' => 'robots', 'content' => 'noindex, nofollow'),null,array('inline'=>false));
}

$meta_description = 'As an SRS Man, great things are expected of you. But let us take care of the details. We\'ll perfect your image from head to toe.';
$img_src = "//www.savilerowsociety.com/img/SRS_600.png";
$meta_keywords="mens personal shopping,professional fashion advice,mens shopping advice,mens personal styling,mens fashion consulting,mens clothing stylist,mens personal branding,mens personal outfits,mens professional stylist,made to measure suits,tailored suits,mens business suits,bespoke suits,custom suit,high quality suits,mens tailor nyc,suits in nyc,custom suiting,tailor in nyc,custom bespoke suits,tailor in new york city,trunk club,tailor in manhattan,suits in new york city,men made to measure suits,bombfell";
$this->Html->meta("keywords", $meta_keywords, array("inline" => false));
$this->Html->meta('description', $meta_description, array('inline' => false));
$this->Html->meta(array('property'=> 'og:title', 'content' => 'Savile Row Society', ),'',array('inline'=>false));
$this->Html->meta(array('property'=> 'og:description', 'content' => $meta_description),'',array('inline'=>false));
$this->Html->meta(array('property'=> 'og:url', 'content' => "//www.savilerowsociety.com/"),'',array('inline'=>false));
$this->Html->meta(array('property'=> 'og:image', 'content' => $img_src),'',array('inline'=>false));
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
?>
<div class="content-container">
    <div class="twelve columns content inner homepage"> 
    <div class="mega-banner">
        <div class="mg-big">
            <a href="#" class="over-img">
                <img src="<?php echo $this->webroot; ?>img/h_1.jpg" />
            </a>
            <div id="my-stylist">
                <?php if($is_logged && $has_stylist) : ?>
                    <a class="link-btn gold-btn" href="<?php echo $this->request->webroot; ?>messages/index/">Meet My Stylist</a>
                <?php elseif($is_logged) : ?>
                    <a class="link-btn gold-btn" href="<?php echo $this->request->webroot; ?>profile/about">Meet My Stylist</a>
                <?php else : ?>
                    <a class="link-btn gold-btn" href="#" onclick="window.ref_url=''; signUp();">Meet My Stylist</a>
                <?php endif; ?>
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
                    <a class="link-btn black-btn" href="/fitting-room">Make a fitting <br />appointment</a>
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
    <div class="eleven columns container works-boxes">
        <div class="work-box">
            <a href="#" class="over-img"><img src="<?php echo $this->webroot; ?>img/how-it-works/1.png" /></a>
            <span class="c-no"><img src="<?php echo $this->webroot; ?>img/how-it-works/no_1.png" /></span>
            <span class="works-desc">Give us your information, and be assigned a personal shopper</span>
            <div class="wrok-btn-box"><a class="works-btn">Register</a></div>

            <?php if($is_logged && $has_stylist) : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="<?php echo $this->request->webroot; ?>myprofile">Register</a></div>
            <?php elseif($is_logged) : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="<?php echo $this->request->webroot; ?>profile/about">Register</a></div>
            <?php else : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="#" onclick="window.ref_url=''; signUp();">Register</a></div>
            <?php endif; ?>
        </div> 
         <div class="work-box">
            <a href="#" class="over-img"><img src="<?php echo $this->webroot; ?>img/how-it-works/2.png" /></a>
            <span class="c-no"><img src="<?php echo $this->webroot; ?>img/how-it-works/no_2.png" /></span>
            <span class="works-desc">Communicate on the website, on the phone or make an in-showroom appointment</span>
            <?php if($is_logged && $has_stylist) : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="<?php echo $this->request->webroot; ?>messages/index/">Talk & shop</a></div>
            <?php elseif($is_logged) : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="<?php echo $this->request->webroot; ?>profile/about">Talk & shop</a></div>
            <?php else : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="#" onclick="window.ref_url=''; signUp();">Talk & shop</a></div>
            <?php endif; ?>
        </div> 
         <div class="work-box">
            <a href="#" class="over-img"><img src="<?php echo $this->webroot; ?>img/how-it-works/3.png" /></a>
            <span class="c-no"><img src="<?php echo $this->webroot; ?>img/how-it-works/no_3.png" /></span>
            <span class="works-desc">dress for the life you want</span>
            <?php if($is_logged && $has_stylist) : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="<?php echo $this->request->webroot; ?>messages/index/">Look sharp</a></div>
            <?php elseif($is_logged) : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="<?php echo $this->request->webroot; ?>profile/about">Look sharp</a></div>
            <?php else : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="#" onclick="window.ref_url=''; signUp();">Look sharp</a></div>
            <?php endif; ?>
        </div> 
    </div>
    
    <div class="ten columns text-center page-heading">
        <h1>our idea of stylist</h1>
    </div>
    <div class="eleven columns stylist-boxes">
        <div class="stylist-box">
            <a href="#" class="over-img">
                <div class="img-box">
                    <img src="<?php echo $this->webroot; ?>img/how-it-works/img_1.png" />
                    <div class="overlay"></div>
                </div>            
            </a>
            <h3>Your own very stylist</h3>
            <span class="stylist-desc">Signing up with Savile Row Society means you’ll be assigned a personal stylist who will get to know your tastes and preferences, catering to all of your wardrobe and lifestyle needs.</span>
        </div> 
         <div class="stylist-box">
            <a href="#" class="over-img">
                <div class="img-box">
                    <img src="<?php echo $this->webroot; ?>img/how-it-works/img_2.jpg" />
                    <div class="overlay"></div>
                </div>   
            </a>         
            <h3>A real expert</h3>
            <span class="stylist-desc">Algorithms are great to find the cheapest flight, but fashion is about more than logic. Our tenured stylists are the best of the best, and will work hard to make our virtual closet, your reality.</span>
        </div> 
         <div class="stylist-box">
           <a href="#" class="over-img">
               <div class="img-box">
                    <img src="<?php echo $this->webroot; ?>img/how-it-works/img_3.jpg" />
                    <div class="overlay"></div>
                </div>    
            </a>        
            <h3>Communicate easily</h3>
            <span class="stylist-desc">You can chat with your stylist online, on the phone, or even in person during an appointment at our showroom.</span>            
        </div>
        <div class="stylist-box">
           <a href="#" class="over-img">
               <div class="img-box">
                    <img src="<?php echo $this->webroot; ?>img/how-it-works/img_4.png" />
                    <div class="overlay"></div>
                </div>            
            </a>
            <h3>Rate products</h3>
            <span class="stylist-desc">Your personal stylist wants your feedback! Like and dislike their suggestions to give them a better sense of your style preferences.</span>
        </div>  
    </div>

    <div class="ten columns text-center page-heading">
        <h1>Seamless Shopping</h1>
    </div>
    <div class="eleven columns container shopping-boxes">
        <div class="shopping-box text-left">
            <a href="#" class="over-img">
                <div class="img-box">
                    <img src="<?php echo $this->webroot; ?>img/how-it-works/img_5.jpg" />
                    <div class="overlay"></div>
                </div>
            </a>
            <h3>Shop online</h3>
            <span class="shopping-desc">From your personal stylist’s selection curated solely for you.<br />In the Closet, where we display a selection of our products.<br />Get free shipping and hassle free return.
</span>
        </div> 
         <div class="shopping-box text-left">
            <a href="#" class="over-img">
                <div class="img-box">
                    <img src="<?php echo $this->webroot; ?>img/how-it-works/img_6.jpg" />
                    <div class="overlay"></div>
                </div>
            </a>
            <h3>Shop in person</h3>
            <span class="shopping-desc">Try on our ready to wear by booking a free appointment in our showroom.<br />Tailor your life with our made-to-measure collection by scheduling a free consultation with our tailor.<br />Our showroom is located in New York.</span>
        </div> 
         <div class="shopping-box text-left">
            <a href="#" class="over-img">
                <div class="img-box">
                    <img src="<?php echo $this->webroot; ?>img/how-it-works/img_7.jpg" />
                    <div class="overlay"></div>
                </div>
            </a>
            <h3>You decide</h3>
            <span class="shopping-desc">Your personal stylist is here to guide you through our collection and find the best products for your lifestyle, however, you and only you, decide what you want on your doorstep at the end of the day</span>
        </div> 
    </div>

    <div class="ten columns text-center page-heading">
        <h1>Our brands</h1>        
    </div>
    <div class="eleven columns home-branding-partners center-block">
        <span class="nine columns brands-desc">We select the best of the best. From big name brands such as Barbour and Lacoste, to boutique brands such as Bernard Zins and VK Nagrani, our goal is to bring you the brands that we believe are the best in class and the best in their category. One thing is for sure, all of our partnering brands are passionate about clothing. <a href="<?php echo $this->request->webroot; ?>company/brands">See more brands</a></span>
        <ul id="branding-partners" class="eight columns center-block">
                        <li><a href="http://blog.savilerowsociety.com/louis-walton/"><img src="<?php echo $this->webroot; ?>img/branding-partners/louis-walton.png" class="fadein-image" alt="Louis Walton" /></a></li>
                        <li><a href="http://blog.savilerowsociety.com/soxfords/"><img src="<?php echo $this->webroot; ?>img/branding-partners/soxfords.png" class="fadein-image" alt="Soxfords" /></a></li>
                        <li><a href="http://blog.savilerowsociety.com/austen-heller/"><img src="<?php echo $this->webroot; ?>img/branding-partners/austen-heller.png" class="fadein-image" alt="Austen Heller" /></a></li>
                        <li><a href="http://blog.savilerowsociety.com/clay-tompkins-press/"><img src="<?php echo $this->webroot; ?>img/branding-partners/tompkins.png" class="fadein-image" alt="Clay Tompkins" /></a></li>
                        <li><a href="http://blog.savilerowsociety.com/lacoste-press/"><img src="<?php echo $this->webroot; ?>img/branding-partners/lacoste_logo.png" class="fadein-image" alt="Lacoste" /></a></li>
                        <li><a href="http://blog.savilerowsociety.com/paul-evans/"><img src="<?php echo $this->webroot; ?>img/branding-partners/paulevans.png" class="fadein-image" alt="Paul Evals" /></a></li>
                        <li><a href="http://blog.savilerowsociety.com/daniel-wellington/"><img src="<?php echo $this->webroot; ?>img/branding-partners/DW_logo.png" class="fadein-image" alt="Daniel Wellington" /></a></li>
                        <li><a href="http://blog.savilerowsociety.com/margo-petitti-2/"><img src="<?php echo $this->webroot; ?>img/branding-partners/petiti.png" class="fadein-image" alt="Margo Petitti" /></a></li>
                        <li><a href="http://blog.savilerowsociety.com/bernard-zins/"><img src="<?php echo $this->webroot; ?>img/branding-partners/Bernard_zins.jpg" class="fadein-image" alt="Bernard Zins" /></a></li>
                        <li><a href="http://blog.savilerowsociety.com/vk-nagrani/"><img src="<?php echo $this->webroot; ?>img/branding-partners/vknagrani.png" class="fadein-image" alt="VK Nagrani" /></a></li>
                        <li><a href="http://blog.savilerowsociety.com/smathers-and-branson/"><img src="<?php echo $this->webroot; ?>img/branding-partners/smathersAndBransonLogo.png" class="fadein-image" alt="Smathers and Branson" /></a></li>
                        <li><a href="http://blog.savilerowsociety.com/7-diamonds/"><img src="<?php echo $this->webroot; ?>img/branding-partners/7diamonds.png" class="fadein-image" alt="7 Diamonds" /></a></li>
                        <li><a href="http://blog.savilerowsociety.com/m-clip/"><img src="<?php echo $this->webroot; ?>img/branding-partners/mclip.gif" class="fadein-image" alt="M-Clip" /></a></li>
                        <li><a href="http://blog.savilerowsociety.com/edward-armah/"><img src="<?php echo $this->webroot; ?>img/branding-partners/edward.png" class="fadein-image" alt="Edward Armah" /></a></li>
                        <li><a href="http://blog.savilerowsociety.com/moore-and-giles/"><img src="<?php echo $this->webroot; ?>img/branding-partners/MooreandGiles.jpg" class="fadein-image" alt="Moore and Giles" /></a></li>
                        <li><a href="http://blog.savilerowsociety.com/agave-denim/"><img src="<?php echo $this->webroot; ?>img/branding-partners/agave.jpg" class="fadein-image" alt="Agave Denim" /></a></li>
                        <li><a href="http://blog.savilerowsociety.com/castaway-nantucket-island/"><img src="<?php echo $this->webroot; ?>img/branding-partners/castaway.jpg" class="fadein-image" alt="Castaway Nantucket Island" /></a></li>
                        <li><a href="http://blog.savilerowsociety.com/cafe-blue/"><img src="<?php echo $this->webroot; ?>img/branding-partners/CafeBleu.png" class="fadein-image" alt="Cafe Blue" /></a></li>
        </ul>
    </div>

     <div class="ten columns text-center page-heading">
        <h1>Testimonials</h1>
    </div>
    <div class="eight columns text-center center-block testimonials">
        <h3>Peter</h3>
        <h4>real estate agent</h4>
        <span class="testi-desc">"Like most men, shopping can be a very daunting task, however, having my SRS personal stylist saves me the time and energy I would otherwise spend in stores."</span>
    </div>
        
</div>
</div>
