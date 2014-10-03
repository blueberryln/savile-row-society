
<?php

if(isset($noindex)){
    echo $this->Html->meta(array('name' => 'robots', 'content' => 'noindex, nofollow'),null,array('inline'=>false));
}

$meta_description = 'Savile Row Society is a men’s personal shopping platform that connects professional men with personal stylists.';
$meta_keywords = 'Savile Row Society, Personal stylist, personal shopping';
$img_src = "//www.savilerowsociety.com/img/SRS_600.png";

$this->Html->meta("keywords", $meta_keywords, array("inline" => false));
$this->Html->meta('description', $meta_description, array('inline' => false));
$this->Html->meta(array('property'=> 'og:title', 'content' => 'Savile Row Society', ),'',array('inline'=>false));
$this->Html->meta(array('property'=> 'og:description', 'content' => $meta_description),'',array('inline'=>false));
$this->Html->meta(array('property'=> 'og:url', 'content' => "//www.savilerowsociety.com/"),'',array('inline'=>false));
$this->Html->meta(array('property'=> 'og:image', 'content' => $img_src),'',array('inline'=>false));
$this->Html->script("//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js", array('safe' => true, 'inline' => false));
$this->Html->script('cookie.js', array('inline' => false));
?>
<div class="content-container-home">

    <div class="twelve columns content inner homepage"> 

    <?php if (!$is_logged) { ?>
    <div id="sign-up-drop-down">
        <div class="close"><a href="#"> &#215;</a></div>
        <p><span>Tailor</span> Your <span>Life</span></p>
        <div class="initial-module container">
            <div class="fourteen columns offset-by-one">
                <?php
                    echo '<input type="button"  value="Join Now" class = "join_button" onclick="window.ref_url=\'\'; signUp();" >';
                    echo '<p class="show-login-form">Savile Row Society is not going to be free forever.<br>Sign-up now, and get FREE MEMBERSHIP for life.</p>';
        
                ?>
            </div>
        </div>

    </div>
    <?php } ?>
    
    <div class="mega-banner" id="one">
        <div class="flexslider">
            <ul class="slides">
                <li><img src="<?php echo $this->request->webroot; ?>images/h_banner_1.jpg"/></li>
                <li><img src="<?php echo $this->request->webroot; ?>images/h_banner_2.jpg"/></li>
            </ul>
        </div>
        <div class="mega-banner-overlay">
            <span class="large-size">shop with your personal stylist</span>
            <span class="small-size">Online &amp; In-person</span>
            <div class="overlay-bnts left">
                <a class="tell-more gray-btns" href="/#two" title="">Tell Me More</a>
                <a class="overlay-started brown-btns" href="/users/register" title="">GET STARTED<span class="get-started-icon"><img src="<?php echo $this->request->webroot; ?>images/btn-arrow.png"</span></a>
            </div>
        </div>
        
        <div class="clear-fix"></div> 
    </div>
   
    <div class="eleven columns container container-box" id="two">
        <div class="blank-space">&nbsp;</div>
        <div class="twelve columns text-center page-heading">
            <h1>How Savile Row Society Works</h1>
            <h3>Complete your Style Profile, start shopping with your personal stylist and</h3>
            <h3>get your new wardrobe delivered to your doorstep for free.</h3>
            
        </div>
        <div class="eleven columns container works-boxes">
            <div class="work-box">
                <?php if($is_logged && $has_stylist) : ?>
                    <a href="<?php echo $this->request->webroot; ?>users/profile/<?php echo $user['User']['id']; ?>" class="over-img">
                <?php elseif($is_logged) : ?>
                    <a href="<?php echo $this->request->webroot; ?>users/profile/<?php echo $user['User']['id']; ?>" class="over-img">
                <?php else : ?>
                    <a href="#" onclick="window.ref_url=''; signUp();" class="over-img">
                <?php endif; ?>
                    <img src="<?php echo $this->webroot; ?>images/how-it-works/Step1.jpg" alt="How Savile Row Society Works" />
                </a>

                <span class="works-heading">Style Profile</span>
                <span class="works-desc">Fill out a quick style profile and you will be matched with your very own personal shopper.</span>


                <?php if($is_logged && $has_stylist) : ?>
                    <div class="wrok-btn-box only-mob"><a class="works-btn" href="<?php echo $this->request->webroot; ?>users/profile/<?php echo $user['User']['id']; ?>">Register</a></div>
                <?php elseif($is_logged) : ?>
                    <div class="wrok-btn-box only-mob"><a class="works-btn" href="<?php echo $this->request->webroot; ?>users/profile/<?php echo $user['User']['id']; ?>">Register</a></div>
                <?php else : ?>
                    <div class="wrok-btn-box only-mob"><a class="works-btn" href="#" onclick="window.ref_url=''; signUp();">Register</a></div>
                <?php endif; ?>
            </div> 
             <div class="work-box">
                <?php if($is_logged && $has_stylist) : ?>
                    <a href="<?php echo $this->request->webroot; ?>messages/index/" class="over-img">
                <?php elseif($is_logged) : ?>
                    <a href="<?php echo $this->request->webroot; ?>users/profile/<?php echo $user['User']['id']; ?>" class="over-img">
                <?php else : ?>
                    <a href="#" onclick="window.ref_url=''; signUp();" class="over-img">
                <?php endif; ?>
                    <img src="<?php echo $this->webroot; ?>images/how-it-works/Step2.jpg" alt="How Savile Row Society Works" />
                </a>

                <span class="works-heading">Start Shopping</span>
                <span class="works-desc">Communicate on the website, on the phone or in-person. Buy what you want from your stylist’s recommendations.</span>


                <?php if($is_logged && $has_stylist) : ?>
                    <div class="wrok-btn-box only-mob"><a class="works-btn" href="<?php echo $this->request->webroot; ?>messages/index/">Talk & shop</a></div>
                <?php elseif($is_logged) : ?>
                    <div class="wrok-btn-box only-mob"><a class="works-btn" href="<?php echo $this->request->webroot; ?>users/profile/<?php echo $user['User']['id']; ?>">Talk & shop</a></div>
                <?php else : ?>
                    <div class="wrok-btn-box only-mob"><a class="works-btn" href="#" onclick="window.ref_url=''; signUp();">Talk & shop</a></div>
                <?php endif; ?>
            </div> 
             <div class="work-box">
                <?php if($is_logged && $has_stylist) : ?>
                    <a href="<?php echo $this->request->webroot; ?>lookbooks/" class="over-img">
                <?php elseif($is_logged) : ?>
                    <a href="<?php echo $this->request->webroot; ?>users/profile/<?php echo $user['User']['id']; ?>" class="over-img">
                <?php else : ?>
                    <a href="#" onclick="window.ref_url=''; signUp();" class="over-img">
                <?php endif; ?>
                    <img src="<?php echo $this->webroot; ?>images/how-it-works/Step3.jpg" alt="How Savile Row Society Works" />
                </a>

                <span class="works-heading">Free Delivery</span>
                <span class="works-desc">Have your purchases delivered for free. Verify that the fit is perfect. Dress for the life you want.</span>


                <?php if($is_logged && $has_stylist) : ?>
                    <div class="wrok-btn-box only-mob"><a class="works-btn" href="<?php echo $this->request->webroot; ?>lookbooks/">Look sharp</a></div>
                <?php elseif($is_logged) : ?>
                    <div class="wrok-btn-box only-mob"><a class="works-btn" href="<?php echo $this->request->webroot; ?>users/profile/<?php echo $user['User']['id']; ?>">Look sharp</a></div>
                <?php else : ?>
                    <div class="wrok-btn-box only-mob"><a class="works-btn" href="#" onclick="window.ref_url=''; signUp();">Look sharp</a></div>
                <?php endif; ?>
            </div> 
        </div>
    </div>             
    <div class="eleven columns container works-boxes only-desktop">
        <div class="work-box">
            <?php if($is_logged && $has_stylist) : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="<?php echo $this->request->webroot; ?>users/profile/<?php echo $user['User']['id']; ?>">Register</a></div>
            <?php elseif($is_logged) : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="<?php echo $this->request->webroot; ?>users/profile/<?php echo $user['User']['id']; ?>">Register</a></div>
            <?php else : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="#" onclick="window.ref_url=''; signUp();">Register</a></div>
            <?php endif; ?>
        </div> 
         <div class="work-box">
            <?php if($is_logged && $has_stylist) : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="<?php echo $this->request->webroot; ?>messages/index/">Talk & shop</a></div>
            <?php elseif($is_logged) : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="<?php echo $this->request->webroot; ?>users/profile/<?php echo $user['User']['id']; ?>">Talk & shop</a></div>
            <?php else : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="#" onclick="window.ref_url=''; signUp();">Talk & shop</a></div>
            <?php endif; ?>
        </div> 
         <div class="work-box">
            <?php if($is_logged && $has_stylist) : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="<?php echo $this->request->webroot; ?>lookbooks/">Look sharp</a></div>
            <?php elseif($is_logged) : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="<?php echo $this->request->webroot; ?>users/profile/<?php echo $user['User']['id']; ?>">Look sharp</a></div>
            <?php else : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="#" onclick="window.ref_url=''; signUp();">Look sharp</a></div>
            <?php endif; ?>
        </div> 
    </div>
    
    <div class="eleven columns container container-box" id="three"> 
        <div class="blank-space">&nbsp;</div>
        <div class="twelve columns text-center page-heading">
            <h1>Featured Stylists</h1>
            <h3>Check out some of our featured Personal Stylists</h3>
            <h3>below and <a href="/stylists/stylistbiography/741" title="">click here to see our full roster</a></h3>
        </div>
        <div class="eleven columns container stylist-boxes">
            <div class="featured-stylist ten columns container">
                <div class="jcarousel-wrapper">
                    <div class="jcarousel">
                <ul>
                    <?php foreach($topStylists as $topstylist): ?>
                    <li>
                       <?php if($topstylist['User']['profile_photo_url']): ?>
                        <img src="<?php echo $this->webroot; ?>files/users/<?php echo $topstylist['User']['profile_photo_url']; ?>"  />                      
                    <?php else: ?>
                        <img src="<?php echo $this->webroot; ?>images/default-user.jpg"  />                       
                        <?php endif; ?>
                        <a href="<?php echo $this->webroot; ?>stylists/stylistbiography/<?php echo $topstylist['User']['id']; ?>"><div class="featured-stylist-hover">
                            <span class="featured-stylist-hover-text"><?php echo $topstylist['User']['first_name'].'&nbsp'.$topstylist['User']['last_name']; ?></span>
                            <span class="featured-stylist-hover-img"><img src="<?php echo $this->webroot; ?>images/how-it-works/featured-hover.png" /></span>
                        </div>
                        </a>
                    </li>
                <?php endforeach; ?>
                    
                </ul>
                    </div>
                    <a href="#" class="jcarousel-control-prev">&lsaquo;</a>
                <a href="#" class="jcarousel-control-next">&rsaquo;</a>

                <p class="jcarousel-pagination"></p>
                    </div>
            </div>
        </div>
    </div>
                        
    <div class="eleven columns container container-box" id="four"> 
        <div class="blank-space">&nbsp;</div>
        <div class="twelve columns text-center page-heading">
            <h1>Top Outfits</h1>
            <h3>Check out the top outfits recently recommended by</h3>
            <h3>our premier Personal Stylists</h3>
             

        </div>
        <div class="eleven columns container outfit-boxes">
            <div class="outfit-stylist eleven columns container">
                <ul class="slider2">
                    <?php if($topOutfits): ?>
                        <?php foreach ($topOutfits as $outfit) {  ?>
                            <li>
                                <div class="shop-outfit left">
                                    <div class="shop-outfit-top">
                                        <div class="outfit-main-img left">
                                        
                                        <img src="<?php echo $this->webroot; ?>files/users/<?php echo $outfit['Stylist']['profile_photo_url']; ?>"  />
                                        </div>
                                        <div class="outfit-top-content left">
                                            <div class="outfit-month"><?php echo $outfit['Outfit']['outfit_name']; ?></div>                                    
                                            <div class="outfit-brand">Styled by <a href="<?php echo $this->webroot; ?>stylists/stylistbiography/<?php echo $outfit['Stylist']['id']; ?>"><span class="outfit-brand-name"><?php echo $outfit['Stylist']['first_name']; ?></span></a></div>
                                        </div>
                                    </div>
                                    <div class="shop-outfit-bottom">
                                        <ul>
                                            <?php foreach($outfit['OutfitItem'] as $item) {
                                                if(count($item['product']['Image'])){
                                            ?>
                                                <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $item['product']['Image'][0]['name']; ?>" /></li>
                                            <?php 
                                                }
                                            } 
                                            ?>
                                        </ul>
                                        <a class="shop-outfit-bottom-link" href="/users/register" title="">Shop Outfit</a>
                                    </div>
                                </div>
                                <div class="outfit-link-btn"><a href="<?php echo $this->webroot; ?>stylists/stylistbiography/<?php echo $outfit['Stylist']['id']; ?>" title="" class="outfilt-btns">Learn about <?php echo $outfit['Stylist']['first_name']; ?></a></div>
                            </li>
                        <?php } ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="eleven columns container container-box" id="five">
        <div class="blank-space">&nbsp;</div>
        <div class="twelve columns text-center page-heading">
            <h1>Style, On Your Time</h1>
            <h3>Savile Row Society provides a shopping experience that is tailored to fit your individual lifestyle.</h3>
            <h3>Stylists are available online, and in person- all at no charge.</h3>
        </div>
        <div class="eleven columns container style-time-boxes">
            <div class="style-time eleven columns container">
                <ul>
                    <li>
                        <div class="style-time-img">
                            <img src="<?php echo $this->webroot; ?>images/outfits/st_img_1.jpg" alt="Savile Row Society Personal Stylists are available online or in person">
                            <div class="style-time-hover">
                                <h1><a href="#" title="">Online</a></h1>                                
                                <div class="style-time-hover-content">
                                    Talk to your stylist.<br />
                                    See your outfit suggestions.<br />
                                    Buy the clothes you want.<br />
                                    Delivered to your doorstep.<br />
                                    All at no charge. 
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="style-time-img">
                            <img src="<?php echo $this->webroot; ?>images/outfits/st_img_2.jpg" alt="Savile Row Society Personal Stylists are available online or in person">
                            <div class="style-time-hover">
                                <h1><a href="javascritp:;" title="">In person</a></h1>                                
                                <div class="style-time-hover-content">
                                    Meet with your stylist.<br />
                                    Try on our samples.<br />
                                    Get measured, for the perfect fit.<br />
                                    Buy the clothes you want. 
                                </div>
                            </div>
                        </div>
                    </li>
                    
                </ul>
                <a class="style-time-link" href="http://www.savilerowsociety.com/contact" title="">Come visit your stylist at our NYC showroom</a>
            </div>
        </div>
    </div>
                        
    <div class="eleven columns container container-box" id="six">
        <div class="blank-space">&nbsp;</div>
        <div class="six columns text-center page-heading brand">
            <h1>Our brands</h1>
            <h3>Savile Row Society selects the best of the best.</h3>
            <h3>From big name brands such as Barbour and Lacoste, to boutique brands such as Bernard Zins and VK Nagrani, our goal is to bring you the brands that we believe are the best in class and the best in their category.</h3>
        </div>
        <div class="eleven columns container brand-boxes">
            <div class="brands nine columns container">
                <ul id="branding-ptners">
                    <li><img src="<?php echo $this->webroot; ?>images/branding-partners/Hook+Albert_new.png" alt="" /><span class="brand-divider"></span></li>
                    <li><img src="<?php echo $this->webroot; ?>images/branding-partners/Ben-Sherman_new.png" alt="" /><span class="brand-divider"></span></li>
                    <li><img src="<?php echo $this->webroot; ?>images/branding-partners/Cole_Haan_new.png" alt="" /></li>
                    <li><img src="<?php echo $this->webroot; ?>images/branding-partners/paulevans_new.png" alt="" /><span class="brand-divider"></span></li>
                    <li><img src="<?php echo $this->webroot; ?>images/branding-partners/smathersAndBranson_new.png" alt="" /><span class="brand-divider"></span></li>
                    <li><img src="<?php echo $this->webroot; ?>images/branding-partners/7diamonds_new.png" alt="" /></li>
                    <li><img src="<?php echo $this->webroot; ?>images/branding-partners/lacoste_new.png" alt="" /><span class="brand-divider"></span></li>
                    <li><img src="<?php echo $this->webroot; ?>images/branding-partners/Solid-&-Striped_new.png" alt="" /><span class="brand-divider"></span></li>
                    <li><img src="<?php echo $this->webroot; ?>images/branding-partners/tateossian_new.png" alt="" /></li>
                </ul>
            </div>
            <a class="brands-link" href="<?php echo $this->webroot; ?>company/brands" title="">See &amp; Learn More about Our Brands</a>
        </div>
    </div>
                        
    <div class="eleven columns container bottom-btn"> 
        <a class="bottom-get-started" href="#" title="">Get Started</a>
    </div>
        
</div>