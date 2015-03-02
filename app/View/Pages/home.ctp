<?php

if(isset($noindex)){
    echo $this->Html->meta(array('name' => 'robots', 'content' => 'noindex, nofollow'),null,array('inline'=>false));
}

$meta_description = "Savile Row Society is a mens personal shopping platform that connects professional men with personal stylists. Buy Mens designer fashion clothing Online at USA favourite online fashion shopping website - savilerowsociety.com";
$meta_keywords = "Savile Row Society, Personal stylist, personal shopping, Menswear online shopping, Men's fashion clothing Online, Buy Mens Clothing Online, personal online shopping, online fashion website, Online shopping website, online fashion shopping";
$img_src = "//www.savilerowsociety.com/img/SRS_600.png";

$this->Html->meta("keywords", $meta_keywords, array("inline" => false));
$this->Html->meta('description', $meta_description, array('inline' => false));
$this->Html->meta(array('property'=> 'og:title', 'content' => 'Savile Row Society', ),'',array('inline'=>false));
$this->Html->meta(array('property'=> 'og:description', 'content' => $meta_description),'',array('inline'=>false));
$this->Html->meta(array('property'=> 'og:url', 'content' => "//www.savilerowsociety.com/"),'',array('inline'=>false));
$this->Html->meta(array('property'=> 'og:image', 'content' => $img_src),'',array('inline'=>false));
?>
<div class="content-container-home">

    <div class="twelve columns content inner homepage"> 
    
    <div class="mega-banner" id="one">
        <div class="flexslider">
            <ul class="slides">
                <li><img src="<?php echo HTTP_ROOT; ?>images/h_banner_1.jpg"/></li>
                <li><img src="<?php echo HTTP_ROOT; ?>images/h_banner_2.jpg"/></li>
            </ul>
        </div>
        <div class="mega-banner-overlay">
            <span class="large-size">shop now with your personal stylist</span>
            <span class="small-size">Your personal stylist will select the clothes you want, <br>tailored to your style and needs at - NO cost.</span>
            <div class="overlay-bnts left">
                <a class="tell-more gray-btns" href="/#two" title="">Tell Me More</a>
                <?php if($is_logged): ?>
                    <a class="overlay-started brown-btns" href="/messages/index" title="">GET STARTED<span class="get-started-icon"><img src="<?php echo HTTP_ROOT; ?>images/btn-arrow.png"</span></a>
                <?php else: ?>
                    <a class="overlay-started brown-btns" href="/users/register" title="">GET STARTED<span class="get-started-icon"><img src="<?php echo HTTP_ROOT; ?>images/btn-arrow.png"</span></a>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="clear-fix"></div> 
    </div>
   



    <div class="eleven columns container container-box" id="one_topLooks"> 
        <div class="blank-space">&nbsp;</div>
        <div class="twelve columns text-center page-heading topLooks_wrapper">
            <h1>Top Looks</h1>
            <h3>Curated by Savile Row Stylists.</h3>
            <!-- <h3>our premier personal stylists</h3> -->
             

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
                                        <a href="<?php echo $this->webroot; ?>stylists/stylistbiography/<?php echo $outfit['Stylist']['id']; ?>?refer=<?php echo $outfit['Stylist']['id']; ?>">
                                        <?php if($outfit['Stylist']['profile_photo_url']): ?>
                                              <img src="<?php echo HTTP_ROOT; ?>files/users/<?php echo $outfit['Stylist']['profile_photo_url']; ?>"  />                      
                                        <?php else: ?>
                                            <img src="<?php echo HTTP_ROOT; ?>images/default-user.jpg"  />                       
                                        <?php endif; ?>
                                        <!-- <img src="<?php echo $this->webroot; ?>images/profile_new.png"  />   -->
                                        </a>
                                        </div>
                                        <div class="outfit-top-content right">
                                            <div class="outfit-month" style="line-height: initial;"><?php echo $outfit['Outfit']['outfit_name']; ?><!--The Essentials--></div>                                    
                                            <!-- <div class="outfit-brand">Styled by <a href="<?php echo $this->webroot; ?>stylists/stylistbiography/<?php echo $outfit['Stylist']['id']; ?>?refer=<?php echo $outfit['Stylist']['id']; ?>"><span class="outfit-brand-name"><?php echo $outfit['Stylist']['first_name']; ?></span></a></div> -->
                                            <p class="content_peragraph">Essentials never go out of style. selected products in this outfit make a man's wardrobe.</p>
                                            <p class="author_name"><?php echo $outfit['Stylist']['first_name'].' '.$outfit['Stylist']['last_name']; ?>, Stylist</p>
                                        </div>
                                    </div>
                                    <div class="shop-outfit-bottom">
                                         <ul>
                                            <?php 
                                            $count = 1;
                                            if($user) {
                                                $path = 'messages/'; 
                                            }
                                            else {
                                                $path = 'guest/';
                                            }
                                            foreach($outfit['OutfitItem'] as $item) {
                                                if(count($item['product']['Image']) && $count++ <= 6){
                                            ?>
                                                <a href="<?php echo $this->webroot;
                                                     echo $path.'outfitdetails/'.$outfit['Outfit']['id']; ?>">
                                                <li><img src="<?php echo HTTP_ROOT; ?>files/products/<?php echo $item['product']['Image'][0]['name']; ?>" />
                                                     <?php //if($item['product']['Entity']['price']) { ?>
                                                     <span class="hover_overlay"><?php echo "$".$item['product']['Entity']['price']; ?></span>
                                                     <?php //} ?>
                                                </li>
                                                </a>
                                                    }
                                            <?php 
                                                }
                                            } 
                                            ?>
                                        </ul>

                                        <!--ul>
                                            <li><a href="#"><img src="<?php echo $this->webroot; ?>images/bag.jpg"/></a>  </li>
                                            <li><a href="#"><img src="<?php echo $this->webroot; ?>images/coat.jpg"/></a> </li>
                                            <li><a href="#"><img src="<?php echo $this->webroot; ?>images/shoe.jpg"/></a> </li>
                                        </ul>
                                        <ul>
                                            <li><a href="#"><img src="<?php echo $this->webroot; ?>images/watch.jpg"/></a> </li>
                                            <li><a href="#"><img src="<?php echo $this->webroot; ?>images/paint.jpg"/></a> </li>
                                            <li><a href="#"><img src="<?php echo $this->webroot; ?>images/shirt.jpg"/></a> </li>
                                        </ul-->                                        

                                        <!-- bottom_buttons -->
                                        <div class="bottom_buttons">
                                        <a href="<?php echo $this->webroot; ?>stylists/stylistbiography/<?php echo $outfit['Stylist']['id']; ?>" class="meet_whitney">Meet <?php echo $outfit['Stylist']['first_name'];?></a>
                                        <?php if($user): ?>
                                        <a href="<?php echo $this->webroot; ?>messages/outfitdetails/<?php echo $outfit['Outfit']['id']; ?>" class="meet_shop_thisLook">Shop This Look</a>
                                        <?php else: ?>
                                            <a href="<?php echo $this->webroot; ?>guest/outfitdetails/<?php echo $outfit['Outfit']['id']; ?>" class="meet_shop_thisLook">Shop This Look</a>
                                        <?php endif; ?>    
                                        </div>
                                        <!-- /bottom_buttons -->

                                       <!--  <?php if($user): ?>
                                            <a class="shop-outfit-bottom-link" href="/messages/outfitdetails/<?php echo $outfit['Outfit']['id']; ?>" title="">Shop Outfit</a>
                                        <?php else: ?>
                                            <a class="shop-outfit-bottom-link" href="/guest/outfitdetails/<?php echo $outfit['Outfit']['id']; ?>" title="">Shop Outfit</a>
                                        <?php endif; ?> -->
                                    </div>
                                </div>
                                <!-- <div class="outfit-link-btn"><a href="<?php echo $this->webroot; ?>stylists/stylistbiography/<?php echo $outfit['Stylist']['id']; ?>?refer=<?php echo $outfit['Stylist']['id']; ?>" title="" class="outfilt-btns">Meet <?php echo $outfit['Stylist']['first_name']; ?></a></div> -->
                            </li>
                        <?php } ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>


    <!-- client_signUp_section -->
    <div class="eleven columns container bgColor" id="client_signUp_section">
        <p>Want personalized looks minus the hassle and cost?</p>
        <a href="Javascript:;">SIGN UP AS A CLIENT</a>
    </div>
    <!-- /client_signUp_section -->


    <div class="eleven columns container container-box" id="two"> 
        <div class="blank-space">&nbsp;</div>
        <div class="twelve columns text-center page-heading">
            <h1>Featured Stylists</h1>
            <!-- <h3>Check out some of our featured Personal Stylists</h3>
            <?php if($firstStylist) : ?>
                <h3>below and <a href="/stylists/stylistbiography/<?php echo $firstStylist['User']['id']; ?>?refer=<?php echo $firstStylist['User']['id']; ?>" title="">click here to see our full roster</a></h3>
            <?php endif; ?> -->
        </div>
        <div class="eleven columns container stylist-boxes">
            <div class="featured-stylist ten columns container">
                <div class="jcarousel-wrapper">
                    <div class="jcarousel">
                <ul>
                    <?php foreach($topStylists as $topstylist): ?>
                    <li>
                        <a href="<?php echo $this->webroot; ?>stylists/stylistbiography/<?php echo $topstylist['User']['id']; ?>?refer=<?php echo $topstylist['User']['id']; ?>"><div class="featured-stylist-hover">
                            <span class="featured-stylist-hover-text"><?php echo $topstylist['User']['first_name'].'&nbsp'.$topstylist['User']['last_name']; ?></span>
                            <span class="featured-stylist-hover-img"><img src="<?php echo HTTP_ROOT; ?>images/how-it-works/featured-hover.png" /></span>
                        </div>
                       <?php if($topstylist['User']['profile_photo_url']): ?>
                        <img src="<?php echo HTTP_ROOT; ?>files/users/<?php echo $topstylist['User']['profile_photo_url']; ?>"  />                      
                    <?php else: ?>
                        <img src="<?php echo HTTP_ROOT; ?>images/default-user.jpg"  />                       
                        <?php endif; ?>
                         
                        </a>
                    </li>
                <?php endforeach; ?>
                <!--     <li><img src="<?php echo $this->webroot; ?>images/stylists_img1.jpg"/></li>
                    <li><img src="<?php echo $this->webroot; ?>images/stylists_img2.jpg"/></li>
                    <li><img src="<?php echo $this->webroot; ?>images/stylists_img3.jpg"/></li>
                    <li><img src="<?php echo $this->webroot; ?>images/stylists_img4.jpg"/></li>
                    <li><a href="Javascript:;" class="stylists_see_all">See All Stylists</a></li>
                    <li><img src="<?php echo $this->webroot; ?>images/stylists_img4.jpg"/></li>
                    <li><img src="<?php echo $this->webroot; ?>images/stylists_img3.jpg"/></li>
                    <li><a href="Javascript:;" class="stylists_see_all">See All Stylists</a></li> -->
                </ul>
                    </div>
                    
                    <div class="jcarousel-control-wrapper">
                        <a href="#" class="jcarousel-control-prev">&lsaquo;</a>
                        <a href="#" class="jcarousel-control-next">&rsaquo;</a>
                        <p class="jcarousel-pagination"></p>
                    </div>

                
                </div>
            </div>
        </div>
    </div>


    <div class="eleven columns container container-box howItWork_wrapper bgColor" id="three">
        <div class="blank-space">&nbsp;</div>
        <div class="twelve columns text-center page-heading">
            <h1>How IT Works</h1>
            <h3>Complete your style profile, start shopping with your personal stylists, and</h3>
            <h4>have your new wardrobe delivered to your doorstep free of charge</h4>
            
        </div>
        <div class="eleven columns container works-boxes">
            <div class="work-box">
                <?php if($is_logged) : ?>
                    <a href="<?php echo $this->request->webroot; ?>messages/index" class="over-img">
                <?php else : ?>
                    <a href="#" class="over-img multi-action">
                <?php endif; ?>
                    <img src="<?php echo HTTP_ROOT; ?>images/how-it-works/Step1.jpg" alt="How Savile Row Society Works" />
                </a>

                <span class="works-heading">Get Started with your Stylist</span>
                <span class="works-desc">Sign Up, fill out your style profile & Connect With Your Stylist.</span>

            </div> 
             <div class="work-box">
                <?php if($is_logged) : ?>
                    <a href="<?php echo $this->request->webroot; ?>messages/index" class="over-img">
                <?php else : ?>
                    <a href="#" class="over-img multi-action">
                <?php endif; ?>
                    <img src="<?php echo HTTP_ROOT; ?>images/how-it-works/Step2.jpg" alt="How Savile Row Society Works" />
                </a>

                <span class="works-heading">Get Your Hand Selected Looks</span>
                <span class="works-desc">Your stylist handpicks items individualized to your style, taste and needs</span>

            </div> 
             <div class="work-box">
                <?php if($is_logged) : ?>
                    <a href="<?php echo $this->request->webroot; ?>messages/index" class="over-img">
                <?php else : ?>
                    <a href="#" class="over-img multi-action">
                <?php endif; ?>
                    <img src="<?php echo HTTP_ROOT; ?>images/how-it-works/Step3.jpg" alt="How Savile Row Society Works" />
                </a>

                <span class="works-heading">Your Looks, to Your Doorstep</span>
                <span class="works-desc">Order only the items you want and get them delivered to your doorstep</span>

            </div> 
        </div>
    </div>             
    
    <!-- <div class="eleven columns container container-box" id="five">
        <div class="blank-space">&nbsp;</div>
        <div class="twelve columns text-center page-heading">
            <h1>Style, On Your Time</h1>
            <h3>Savile Row Society provides a shopping experience that is tailored to fit your individual lifestyle.</h3>
            <h3>Stylists are available online, and in person-all at no charge.</h3>
        </div>
        <div class="eleven columns container style-time-boxes">
            <div class="style-time eleven columns container">
                <ul>
                    <li>
                        <div class="style-time-img">
                            <img src="<?php echo $this->webroot; ?>images/outfits/st_img_1.jpg" alt="Savile Row Society Personal Stylists are available online or in person">
                            <div class="style-time-hover">
                                <?php if($is_logged): ?>
                                    <h1><a href="/messages/index" title="">Online</a></h1>
                                <?php else: ?>
                                    <h1><a href="#" title="" class="multi-action">Online</a></h1>
                                <?php endif; ?>

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
                                <?php if($is_logged): ?>
                                    <h1><a href="/contact" title="">In-person</a></h1>
                                <?php else: ?>
                                    <h1><a href="#" title="" class="multi-action">In-person</a></h1>
                                <?php endif; ?>                                
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
                <a class="style-time-link" href="/contact" title="">Meet with your stylist in our NYC-based showroom</a>
            </div>
        </div>
    </div> -->
        
    <div class="eleven columns container container-box" id="four">
        <div class="blank-space">&nbsp;</div>
        <div class="six columns text-center page-heading">
            <h1>Our brands</h1>
            <h3>Savile Row Society selects the best of the best.</h3>
            <h3>From big name brands such as Barbour and Lacoste, to boutique brands such as Bernard Zins and VK Nagrani, our goal is to bring you the brands that we believe are the best in class and the best in their category.</h3>
        </div>
        <div class="eleven columns container brand-boxes">
            <div class="nine columns container">
                <ul id="branding-ptners">
                    <li><img src="<?php echo HTTP_ROOT; ?>images/branding-partners/Hook+Albert_new.png" alt="" /></li>
                    <li class="no-mrgn"><img src="<?php echo HTTP_ROOT; ?>images/branding-partners/smathersAndBranson_new.png" alt="" /></li>
                    <li><img src="<?php echo HTTP_ROOT; ?>images/branding-partners/Cole_Haan_new.jpg" alt="" /></li><br>
                    <li><img src="<?php echo HTTP_ROOT; ?>images/branding-partners/paulevans_new.png" alt="" /></li>
                    <li><img src="<?php echo HTTP_ROOT; ?>images/branding-partners/ben-sherman_new.jpg" alt="" /></li>
                    <li><img src="<?php echo HTTP_ROOT; ?>images/branding-partners/lacoste_new.png" alt="" /></li>
                    <li><img src="<?php echo HTTP_ROOT; ?>images/branding-partners/Solid-&-Striped_new.png" alt="" /></li>
                    <li><img src="<?php echo HTTP_ROOT; ?>images/branding-partners/tateossian_new.png" alt="" /></li>
                </ul>
            </div>
            <!-- <a class="brands-link" href="<?php echo HTTP_ROOT; ?>company/brands" title="">See &amp; Learn More about Our Brands</a> -->
        </div>
    </div>
                        



    <div class="eleven columns container container-box press_wrapper bgColor">
        <div class="blank-space2">&nbsp;</div>
        <div class="eleven columns text-center page-heading">
            <h1>Press</h1>
        </div>
        <div class="nine columns container press_wrapper">
            <div class="press_companies">
                <img src="<?php echo HTTP_ROOT; ?>images/press_logo1.jpg" alt="" class="first" />
                <p>"Let your personal stylist find your new kick ass wardrobe <br/> at Savile Row Society. Savile Row Society is a men's <br/>personal styling platform and our mission <br/> is to enhance the way men shop"<br><br></p>
            </div> 
            <div class="press_companies">
                <img src="<?php echo HTTP_ROOT; ?>images/press_logo2.jpg" alt="" />
                <p>The idea: Bring a top-notch selection of clothing <br> --suits, wingtips high-quality dress-shirts-- <br> straight to guys, with a spectrum of buying options <br> depending on how involved in the process <br> of stocking their closet they want to be.</p>
            </div> 
            <div class="press_companies">
                <img src="<?php echo HTTP_ROOT; ?>images/press_logo3.jpg" alt="" class="last" />
                <p>The platform provides clients with personal stylists <br> after initial consultations and strikes partnerships <br> with brands to add  o its own bespoke line. <br> Tiered pricing and a variety of entry points makes <br> SRS potentially attractive to many affluent  emographics.</p>
            </div> 
        </div>
    </div>             



    <!-- <div class="eleven columns container bottom-btn"> 
        <a class="bottom-get-started" href="/users/register" title="">Get Started</a>
    </div> -->
        
</div>
<script>
    $(function(){
        $(".shop-outfit-bottom").on('click', function(){
            location = $(this).find('a.shop-outfit-bottom-link').attr('href');
        });
    });
</script>