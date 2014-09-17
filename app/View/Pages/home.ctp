<?php

$brands_info = array(
    "barbour" => array("title" => "The legendary maker of weatherproof clothing.", "desc" => "The famous brand of waxed jackets, quilted jackets, motorcycle jackets; of country gear and casual clothing. A British brand to the core. Founded in 1894 by John Barbour, in South Shields in the North East of England, the company supplied oilskins and other garments to protect the growing community of sailors, fishermen and dockers. Since then, Barbour has continued to thrive on the unique values of the British countryside, and offers a full range of wardrobe essentials and this year marks the 120th anniversary.", "id" => "5"),
    "lacoste" => array("title" => "For The Man Who Can Be Found At The Country Club", "desc" => "Founded in 1933 by tennis player and inventor Rene Lacoste, Olympic medalist in 1924, the Crocodile brand has always accompanied teams and athletes all around the world. When he revolutionized sports, Rene Lacoste also revolutionized fashion; his quest for comfort and freedom of movement made him more competitive without losing an ounce of elegance.", "id" => "12"),
    "smathers" => array("title" => "For The Man Who Can Be Found At The Derby", "desc" => "In 2004, while roommates at Bowdoin College, we decided to start a company that offered needlepoint belts. We set out to make the belts more available, attractive and affordable. We began testing the market in the spring of 2005, and quickly, the once treasured gift became the epicenter of a thriving business. Smathers amp; Branson defines their mission: &apos;to offer the finest products with customer service to match.&apos;", "id" => "9"),
    "nagrani" => array("title" => "For The Man Who Takes Risks", "desc" => "Great clothing should be made to get better with age and be designed to offer a timeless aesthetic. In addition, it must function to enhance your way of life. It is this philosophy that I bring forth each time I create a new garment. Reserved for men of discerning taste, I continuously work to find ways to make something better. I never set out to be something for everyone; instead, I want to be everything to someone.", "id" => "16"),
    "colehaan" => array("title" => "", "desc" => "Trafton Cole and Eddie Haan began Cole Haan in 1928, resolving to make good goods and nothing but good goods. Their entrepreneurial spirit and timeless vision still inspire. Today Cole Haan create shoes, bags and finishing touches for people who are ingenuous, resourceful and want to make a difference. Their intrepid tribe manages to look good wether at work or play, and believes a sense of style and sense of humor are perfect complements.", "id" => ""),
    "paulevans" => array("title" => "For The Man Who Takes Pride In His Shoes", "desc" => "Luxury men's footwear based in New York City.<br><br> High quality dress shoes made in Europe using time-honored craftsmanship and the finest materials.<br><br>Calf leather uppers, matching leather soles, leather lining. Goodyear/blake construction. Smart colors.<br><br>What do your shoes say about you?", "id" => "19"),    
    "allenedmonds" => array("title" => "", "desc" => "Allen Edmonds began handcrafting Made in U.S.A. shoes in 1922 on the shores of Lake Michigan in Wisconsin. Today we continue this manufacturing tradition and offer the finest men's dress and casual shoes available featuring classic American styling and fine craftsmanship. Allen Edmonds prides itself on using superior leathers such as calf skin and cordovan. These materials are combined with cork footbeds to create unmatched comfort. ", "id" => "43"),
    "dw" => array("title" => "", "desc" => "The &quot;preppy&quot; trend is bigger than ever before. And while there are many big players in the fashion industry that caters to preppy needs, such as Ralph Lauren, Gant and Brooks Brothers, we felt that there was an empty space in the watch market. There was something missing.<br><br>We believe that Daniel Wellington fills that gap. Our vision is that when someone thinks of a preppy dressed person, he or she is wearing a Daniel Wellington watch.", "id" => "22"),
    "agave" => array("title" => "For The Man With That West Coast Mentality", "desc" => "Designed in Portland and handcrafted in California, Agave remains true to its roots of designing and crafting the best tailored, most beautiful and highest quality denim jeans, authentically sewn and hand-finished exclusively in California. Agave is represented by friends, artisans and passionate people who stand for Courage, Compassion amp; Conservation. Agave is an adventure lifestyle with an ecological point of view combined with luxury and ALWAYS beautiful denim and sumptuous tees.", "id" => "3"),
    "saxx" => array("title" => "For The Active Man", "desc" => "On a fishing trip in Alaska, our inventor experienced intense chafing that left him wondering why men&apos;s underwear wasn&apos;t designed for how men are actually built. When he returned, he couldn&apos;t shake the notion that a better design was possible. He teamed up with a designer and started brainstorming and working on prototypes. On the fourteenth attempt they combined four key innovations resulting in a new level of comfort and performance.", "id" => "15"),
    "mclip" => array("title" => "For The Man Who Is Tired Of His Wallet", "desc" => "The World&apos;s Finest Money Clip&apos; and &apos;Finally, A Money Clip that Works&apos; ... these are the registered trademarks and descriptions that we take very seriously about our product. From superior base metal materials and ultra-high machined tolerances for each component part, to individually hand selected hides and finishes, the M-Clip is constructed and assembled by hand with one goal in mind: to make the absolute best, most functional, highest quality money clip you can buy - anywhere.", "id" => "11"),
    "edwardamrah" => array("title" => "For The Man Who Loves To Rock A Bowtie", "desc" => "Edward Armah: A Signature Name for High-End Designer Dress Furnishing for Men High-end affordable designer garments allure every man. Our custom bowties are an embodiment of the vividness in our style, class, design and exuberant taste and passion towards offering the finest quality accessories for men. Be it our custom fashion bowties or 4 in 1 bowties, Edward Armah has been instrumental in revolutionizing the way men used to dress formally.", "id" => "20"),
    
);

$meta_description = 'As people today are rarely defined by a single company or career track, clothes have become an absolute reflection of one’s values, personality, attitude, and lifestyle.';
$this->Html->meta('description', $meta_description, array('inline' => false));
$script='
    var brandsInfo = ' . json_encode($brands_info) . ';
    var testimonials = [
        {name : "Peter", profession: "Real Estate Agent", text: "Like most men, shopping can be a very daunting task, however, having my SRS personal stylist saves me the time and energy I would otherwise spend in stores."},
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
//            if(jQuery(".mg-big img")[0].complete && jQuery(".mg-small img")[0].complete){
//                vidContinerHeight()
//            }
//            else{
//                jQuery(".mg-big img, .mg-small img").load(function() {
//                    vidContinerHeight()
//                });
//            }   
            
            var testimonialInterval = setInterval(function(){
                var newTestimonial = currentTestimonial = (testimonials.length == (currentTestimonial + 1)) ? 0 : currentTestimonial + 1;
                testimonialBlock.animate({opacity: 0}, 400, function(){
                    testimonialUser.text(testimonials[newTestimonial]["name"]);
                    testimonialProfession.text(testimonials[newTestimonial]["profession"]);
                    testimonialText.text(testimonials[newTestimonial]["text"]);
                    testimonialBlock.animate({opacity: 1}, 700);
                })
            }, 7000);    

            $("ul#branding-partners li").click(function(){
                var brandImage = $(this).find("img");
                var brandName = brandImage.data("name");
                var brandDesc = brandsInfo[brandName]["desc"];
                var brandTitle = brandsInfo[brandName]["title"];
                var brandID = brandsInfo[brandName]["id"];
                imgSrc = brandImage.attr("src");
                $("div.brand-logo img").attr("src",imgSrc);
                $("p.brand-title").html(brandTitle);
                $("p.brand-desc").html(brandDesc);  
                if(brandID != ""){
                    $(".brand-info .link-btn").attr({href:"' .$this->webroot . 'closet/all/" + brandID + "/none/brand"});
                    $(".brand-info .link-btn").show();
                }
                else{
                    $(".brand-info .link-btn").hide();
                }
                $.blockUI({message: $("#brandinfo-box"), css: {top: $(window).height()/2 - $("#brandinfo-box").height()/2}});
                $(".blockOverlay").click($.unblockUI);        
            }); 
    });    
    /*$(window).load(function() {
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
        
    });*/
   
    function vidContinerHeight(){
        var mbHeight = jQuery(".mg-big").height();
        var mgsHeight = jQuery(".mg-small").height();
        var mgvHeight = mbHeight - mgsHeight;
        jQuery(".mg-vid").css("height", mgvHeight -6);
    }
    jQuery(window).resize(function(){
           var mbHeight = jQuery(".mg-big").height();
            var mgsHeight = jQuery(".mg-small").height();
            var mgvHeight = mbHeight - mgsHeight;
            jQuery(".mg-vid").css("height", mgvHeight-6);
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
$this->Html->script("//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js", array('safe' => true, 'inline' => false));
$this->Html->script('cookie.js', array('inline' => false));
?>
<div class="content-container">

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
            <span class="small-size">online &amp; in person.</span>
            <div class="overlay-bnts left">
                <a class="tell-more gray-btns" href="#" title="">Tell Me More</a>
                <a class="overlay-started brown-btns" href="#" title="">GET STARTED<span class="get-started-icon"><img src="<?php echo $this->request->webroot; ?>images/btn-arrow.png"</span></a>
            </div>
        </div>
        
        <!--<div class="mg-big">
            <?php if($is_logged && $has_stylist) : ?>
                <a class="over-img" href="<?php echo $this->request->webroot; ?>messages/index/">
            <?php elseif($is_logged) : ?>
                <a class="over-img" href="<?php echo $this->request->webroot; ?>auth/profile/<?php echo $user['User']['id']; ?>">
            <?php else : ?>
                <a class="over-img" href="#" onclick="window.ref_url=''; signUp();">
            <?php endif; ?>
                <img src="<?php echo $this->webroot; ?>img/h_1.jpg" />
            </a>
            <div id="my-stylist" style="left: 0; top: 40px;">
                <?php if($is_logged && $has_stylist) : ?>
                    <a class="link-btn gold-btn" href="<?php echo $this->request->webroot; ?>messages/index/">Meet My Stylist</a>
                <?php elseif($is_logged) : ?>
                    <a class="link-btn gold-btn" href="<?php echo $this->request->webroot; ?>auth/profile/<?php echo $user['User']['id']; ?>">Meet My Stylist</a>
                <?php else : ?>
                    <a class="link-btn gold-btn" href="#" onclick="window.ref_url=''; signUp();">Meet My Stylist</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="mg-vid">            
            <img src="<?php echo $this->webroot; ?>img/h_2.jpg" />
            <div class="mgs-btn" style="right: 0; top: 40px;">
                <a class="link-btn gold-btn" href="<?php echo $this->request->webroot; ?>lookbooks/#29" style="margin-right: 0;">GET THIS LOOK</a>
            </div>          
        </div>-->
        <!--<div class="mg-small">
            <img src="<?php echo $this->webroot; ?>img/h_4.jpg" />-->

            <!-- <div class="mg-small-1"> 
                <?php if($is_logged) : ?>
                    <a href="<?php echo $this->request->webroot; ?>fitting-room" class="over-img"><img src="<?php echo $this->webroot; ?>img/h_2.jpg" /></a>
                <?php else : ?>
                    <a href="#" onclick="window.ref_url=''; signUp();" class="over-img"><img src="<?php echo $this->webroot; ?>img/h_2.jpg" /></a>
                <?php endif; ?>    
                <div class="mgs-btn">
                    <?php if($is_logged) : ?>
                        <a class="link-btn black-btn" href="<?php echo $this->request->webroot; ?>fitting-room">Make a fitting <br />appointment</a>
                    <?php else : ?>
                        <a class="link-btn black-btn" href="#" onclick="window.ref_url=''; signUp();">Make a fitting <br />appointment</a>
                    <?php endif; ?> 
                </div> 
            </div>
            <div class="mg-small-2">                
                <a href="<?php echo $this->request->webroot; ?>lookbooks/" class="over-img"><img src="<?php echo $this->webroot; ?>img/h_3.jpg" /></a>              
                <div class="mgs-btn">
                    <a class="link-btn black-btn" href="<?php echo $this->request->webroot; ?>lookbooks/">Buy this <br> look</a>
                </div> 
            </div>  -->
        <!--</div>-->
        <div class="clear-fix"></div> 
    </div>
   
    <div class="eleven columns container container-box" id="two">
        <div class="blank-space">&nbsp;</div>
        <div class="twelve columns text-center page-heading">
            <h1>How Savile Row Society Works</h1>
            <h3>Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum.</h3>
            <h3>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</h3>
            
        </div>
        <div class="eleven columns container works-boxes">
            <div class="work-box">
                <?php if($is_logged && $has_stylist) : ?>
                    <a href="<?php echo $this->request->webroot; ?>auth/profile/<?php echo $user['User']['id']; ?>" class="over-img">
                <?php elseif($is_logged) : ?>
                    <a href="<?php echo $this->request->webroot; ?>auth/profile/<?php echo $user['User']['id']; ?>" class="over-img">
                <?php else : ?>
                    <a href="#" onclick="window.ref_url=''; signUp();" class="over-img">
                <?php endif; ?>
                    <img src="<?php echo $this->webroot; ?>images/how-it-works/Step1.jpg" />
                </a>

                <span class="works-heading">Style Profile</span>
                <span class="works-desc">Fill out a quick style profile and you will be matched with your very own personal shopper.</span>


                <?php if($is_logged && $has_stylist) : ?>
                    <div class="wrok-btn-box only-mob"><a class="works-btn" href="<?php echo $this->request->webroot; ?>auth/profile/<?php echo $user['User']['id']; ?>">Register</a></div>
                <?php elseif($is_logged) : ?>
                    <div class="wrok-btn-box only-mob"><a class="works-btn" href="<?php echo $this->request->webroot; ?>auth/profile/<?php echo $user['User']['id']; ?>">Register</a></div>
                <?php else : ?>
                    <div class="wrok-btn-box only-mob"><a class="works-btn" href="#" onclick="window.ref_url=''; signUp();">Register</a></div>
                <?php endif; ?>
            </div> 
             <div class="work-box">
                <?php if($is_logged && $has_stylist) : ?>
                    <a href="<?php echo $this->request->webroot; ?>messages/index/" class="over-img">
                <?php elseif($is_logged) : ?>
                    <a href="<?php echo $this->request->webroot; ?>auth/profile/<?php echo $user['User']['id']; ?>" class="over-img">
                <?php else : ?>
                    <a href="#" onclick="window.ref_url=''; signUp();" class="over-img">
                <?php endif; ?>
                    <img src="<?php echo $this->webroot; ?>images/how-it-works/Step2.jpg" />
                </a>

                <span class="works-heading">Start Shopping</span>
                <span class="works-desc">Communicate on the website, on the phone or in-person. Buy what you want from your stylist’s recommendations.</span>


                <?php if($is_logged && $has_stylist) : ?>
                    <div class="wrok-btn-box only-mob"><a class="works-btn" href="<?php echo $this->request->webroot; ?>messages/index/">Talk & shop</a></div>
                <?php elseif($is_logged) : ?>
                    <div class="wrok-btn-box only-mob"><a class="works-btn" href="<?php echo $this->request->webroot; ?>auth/profile/<?php echo $user['User']['id']; ?>">Talk & shop</a></div>
                <?php else : ?>
                    <div class="wrok-btn-box only-mob"><a class="works-btn" href="#" onclick="window.ref_url=''; signUp();">Talk & shop</a></div>
                <?php endif; ?>
            </div> 
             <div class="work-box">
                <?php if($is_logged && $has_stylist) : ?>
                    <a href="<?php echo $this->request->webroot; ?>lookbooks/" class="over-img">
                <?php elseif($is_logged) : ?>
                    <a href="<?php echo $this->request->webroot; ?>auth/profile/<?php echo $user['User']['id']; ?>" class="over-img">
                <?php else : ?>
                    <a href="#" onclick="window.ref_url=''; signUp();" class="over-img">
                <?php endif; ?>
                    <img src="<?php echo $this->webroot; ?>images/how-it-works/Step3.jpg" />
                </a>

                <span class="works-heading">Free Delivery</span>
                <span class="works-desc">Have your purchases delivered for free. Verify that the fit is perfect. Dress for the life you want.</span>


                <?php if($is_logged && $has_stylist) : ?>
                    <div class="wrok-btn-box only-mob"><a class="works-btn" href="<?php echo $this->request->webroot; ?>lookbooks/">Look sharp</a></div>
                <?php elseif($is_logged) : ?>
                    <div class="wrok-btn-box only-mob"><a class="works-btn" href="<?php echo $this->request->webroot; ?>auth/profile/<?php echo $user['User']['id']; ?>">Look sharp</a></div>
                <?php else : ?>
                    <div class="wrok-btn-box only-mob"><a class="works-btn" href="#" onclick="window.ref_url=''; signUp();">Look sharp</a></div>
                <?php endif; ?>
            </div> 
        </div>
    </div>             
    <div class="eleven columns container works-boxes only-desktop">
        <div class="work-box">
            <?php if($is_logged && $has_stylist) : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="<?php echo $this->request->webroot; ?>auth/profile/<?php echo $user['User']['id']; ?>">Register</a></div>
            <?php elseif($is_logged) : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="<?php echo $this->request->webroot; ?>auth/profile/<?php echo $user['User']['id']; ?>">Register</a></div>
            <?php else : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="#" onclick="window.ref_url=''; signUp();">Register</a></div>
            <?php endif; ?>
        </div> 
         <div class="work-box">
            <?php if($is_logged && $has_stylist) : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="<?php echo $this->request->webroot; ?>messages/index/">Talk & shop</a></div>
            <?php elseif($is_logged) : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="<?php echo $this->request->webroot; ?>auth/profile/<?php echo $user['User']['id']; ?>">Talk & shop</a></div>
            <?php else : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="#" onclick="window.ref_url=''; signUp();">Talk & shop</a></div>
            <?php endif; ?>
        </div> 
         <div class="work-box">
            <?php if($is_logged && $has_stylist) : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="<?php echo $this->request->webroot; ?>lookbooks/">Look sharp</a></div>
            <?php elseif($is_logged) : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="<?php echo $this->request->webroot; ?>auth/profile/<?php echo $user['User']['id']; ?>">Look sharp</a></div>
            <?php else : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="#" onclick="window.ref_url=''; signUp();">Look sharp</a></div>
            <?php endif; ?>
        </div> 
    </div>
    
    <div class="eleven columns container container-box" id="three"> 
        <div class="blank-space">&nbsp;</div>
        <div class="twelve columns text-center page-heading">
            <h1>Featured Stylists</h1>
            <h3>Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum.</h3>
            <h3>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</h3>
        </div>
        <div class="eleven columns container stylist-boxes">
            <div class="featured-stylist ten columns container">
                <ul class="slider1">
                    <?php foreach($topstylists as $topstylist): ?>
                    <li>
                        <img src="<?php echo $this->webroot; ?>files/users/<?php echo $topstylist['User']['profile_photo_url']; ?>"  />
                        <a href="<?php echo $this->webroot; ?>Auth/stylistbiography/<?php echo $topstylist['User']['id']; ?>"><div class="featured-stylist-hover">
                            <span class="featured-stylist-hover-text"><?php echo $topstylist['User']['first_name'].'&nbsp'.$topstylist['User']['last_name']; ?></span>
                            <span class="featured-stylist-hover-img"><img src="<?php echo $this->webroot; ?>images/how-it-works/featured-hover.png" /></span>
                        </div>
                        </a>
                    </li>
                <?php endforeach; ?>
                    <!-- <li>
                        <img src="<?php echo $this->webroot; ?>images/how-it-works/fs_img_2.jpg" />
                        <div class="featured-stylist-hover">
                            <span class="featured-stylist-hover-text">Stylist Stylist</span>
                            <span class="featured-stylist-hover-img"><img src="<?php echo $this->webroot; ?>images/how-it-works/featured-hover.png" /></span>
                        </div>
                    </li>
                    <li>
                        <img src="<?php echo $this->webroot; ?>images/how-it-works/fs_img_3.jpg" />
                        <div class="featured-stylist-hover">
                            <span class="featured-stylist-hover-text">Stylist Stylist</span>
                            <span class="featured-stylist-hover-img"><img src="<?php echo $this->webroot; ?>images/how-it-works/featured-hover.png" /></span>
                        </div>
                    </li>
                    <li>
                        <img src="<?php echo $this->webroot; ?>images/how-it-works/fs_img_4.jpg" />
                        <div class="featured-stylist-hover">
                            <span class="featured-stylist-hover-text">Stylist Stylist</span>
                            <span class="featured-stylist-hover-img"><img src="<?php echo $this->webroot; ?>images/how-it-works/featured-hover.png" /></span>
                        </div>
                    </li> -->
                </ul>
            </div>
            
<!--
            <div class="shopping-box">
                <a href="<?php echo $this->request->webroot; ?>closet" class="over-img">
                    <img src="<?php echo $this->webroot; ?>img/how-it-works/The_Closet.png" />
                </a>
                <h3>Shop online</h3>
                <span class="shopping-desc">Browse our curated selection. In the Closet, you will find samples of everything from dress shoes to swimsuits.</span>
            </div> 
-->
<!--
             <div class="shopping-box">
                <?php if($is_logged && $has_stylist) : ?>
                    <a href="<?php echo $this->request->webroot; ?>fitting-room" class="over-img">
                <?php elseif($is_logged) : ?>
                    <a href="<?php echo $this->request->webroot; ?>auth/profile/<?php echo $user['User']['id']; ?>" class="over-img">
                <?php else : ?>
                    <a href="#" onclick="window.ref_url=''; signUp();" class="over-img">
                <?php endif; ?>
                    <img src="<?php echo $this->webroot; ?>img/how-it-works/My_Stylist.png" />
                </a>
                <h3>My Stylist</h3>
                <span class="shopping-desc">Have a conversation with your stylist and see her personalized recommendations. Our stylists have access to our entire collection. </span>
            </div> 
-->
<!--
             <div class="shopping-box">
                <?php if($is_logged && $has_stylist) : ?>
                    <a href="<?php echo $this->request->webroot; ?>messages/index/" class="over-img">
                <?php elseif($is_logged) : ?>
                    <a href="<?php echo $this->request->webroot; ?>auth/profile/<?php echo $user['User']['id']; ?>" class="over-img">
                <?php else : ?>
                    <a href="#" onclick="window.ref_url=''; signUp();" class="over-img">
                <?php endif; ?>
                    <img src="<?php echo $this->webroot; ?>img/how-it-works/The_Fitting_Room.png" />
                </a>
                <h3>The Fitting Room</h3>
                <span class="shopping-desc">Make an appointment to meet with your stylist, try on our collection or get measured for our made-to-measure collection. </span>
            </div> 
-->
        </div>
    </div>
                        
    <div class="eleven columns container container-box" id="four"> 
        <div class="blank-space">&nbsp;</div>
        <div class="twelve columns text-center page-heading">
            <h1>Top Outfits</h1>
            <h3>Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum.</h3>
            <h3>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</h3>
        </div>
        <div class="eleven columns container outfit-boxes">
            <div class="outfit-stylist eleven columns container">
                <ul class="slider2">
                    <?php foreach ($my_outfit as $topoutfit) {  //print_r($topoutfit);
                        ?>
                    <li>
                        <div class="shop-outfit left">
                            <div class="shop-outfit-top">
                                <div class="outfit-main-img left"><img src="<?php echo $this->webroot; ?>files/users/<?php echo $topoutfit['stylistimage']['User']['profile_photo_url']; ?>"  /></div>
                                <div class="outfit-top-content left">
                                    <div class="outfit-month"><?php echo $topoutfit['outfit']['Outfit']['outfitname']; ?></div>                                    
                                    <div class="outfit-brand">Styled by <span class="outfit-brand-name"><?php echo $topoutfit['stylistname']['User']['first_name']; ?></span></div>
                                </div>
                            </div>
                            <div class="shop-outfit-bottom">
                                <ul>
                                <?php foreach($topoutfit['entities'] as $rt) { $rt = end($rt); ?>
                                    
                                    <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $rt['name']; ?>" /></li>
                                    <?php } ?>
                                    <!-- <li><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_2.jpg" /></li>
                                    <li><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_3.jpg" /></li>
                                    <li><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_4.jpg" /></li>
                                    <li><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_5.jpg" /></li> -->
                                </ul>
                                <a class="shop-outfit-bottom-link" href="javascript:;" title="">Shop Outfit</a>
                            </div>
                        </div>
                        <div class="outfit-link-btn"><a href="<?php echo $this->webroot; ?>Auth/stylistbiography/<?php echo $topoutfit['stylistname']['User']['id']; ?>" title="" class="outfilt-btns">Learn about <?php echo $topoutfit['stylistname']['User']['first_name']; ?></a></div>
                    </li>
                    <?php } ?>
                    <!-- <li>
                        <div class="shop-outfit left">
                            <div class="shop-outfit-top">
                                <div class="outfit-main-img left"><img src="<?php echo $this->webroot; ?>images/outfits/img_1.jpg" /></div>
                                <div class="outfit-top-content left">
                                    <div class="outfit-month">Fourth of July</div>                                    
                                    <div class="outfit-brand">Styled by <span class="outfit-brand-name">Lisa</span></div>
                                </div>
                            </div>
                            <div class="shop-outfit-bottom left">
                                <ul>
                                    <li><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_1.jpg" /></li>
                                    <li><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_2.jpg" /></li>
                                    <li><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_3.jpg" /></li>
                                    <li><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_4.jpg" /></li>
                                    <li><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_5.jpg" /></li>
                                </ul>
                                <a class="shop-outfit-bottom-link" href="javascript:;" title="">Shop Outfit</a>
                            </div>
                        </div>
                        <div class="outfit-link-btn"><a href="javascript:;" title="" class="outfilt-btns">Learn about Lisa</a></div>
                    </li>
                    <li>
                        <div class="shop-outfit left">
                            <div class="shop-outfit-top">
                                <div class="outfit-main-img left"><img src="<?php echo $this->webroot; ?>images/outfits/img_1.jpg" /></div>
                                <div class="outfit-top-content left">
                                    <div class="outfit-month">Fourth of July</div>                                    
                                    <div class="outfit-brand">Styled by <span class="outfit-brand-name">Lisa</span></div>
                                </div>
                            </div>
                            <div class="shop-outfit-bottom left">
                                <ul>
                                    <li><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_1.jpg" /></li>
                                    <li><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_2.jpg" /></li>
                                    <li><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_3.jpg" /></li>
                                    <li><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_4.jpg" /></li>
                                    <li><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_5.jpg" /></li>
                                </ul>
                                <a class="shop-outfit-bottom-link" href="javascript:;" title="">Shop Outfit</a>
                            </div>
                        </div>
                        <div class="outfit-link-btn"><a href="javascript:;" title="" class="outfilt-btns">Learn about Lisa</a></div>
                    </li> -->
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
                            <img src="<?php echo $this->webroot; ?>images/outfits/st_img_1.jpg">
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
                            <img src="<?php echo $this->webroot; ?>images/outfits/st_img_2.jpg">
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
                <a class="style-time-link" href="http://www.savilerowsociety.com/contact" title="">Come visit your stylist at our NYC showroom.</a>
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
    

<!--
    <div class="ten columns text-center page-heading">
        <h1>Our brands</h1>        
    </div>
-->
<!--
    <div class="eleven columns home-branding-partners center-block">
        <span class="nine columns brands-desc">Savile Row Society selects the best of the best. 
From big name brands such as Barbour and Lacoste, to boutique brands such as Bernard Zins and VK Nagrani, our goal is to bring you the brands that we believe are the best in class and the best in their category. </span>
        <ul id="branding-partners" class="eight columns center-block">
                        <li><img src="<?php echo $this->webroot; ?>img/branding-partners/barbourlogo.jpg" class="fadein-image" alt="Barbour" data-name="barbour"/></li>
                        <li><img src="<?php echo $this->webroot; ?>img/branding-partners/lacoste_logo.png" class="fadein-image" alt="Lacoste"data-name="lacoste" /></li>
                        <li><img src="<?php echo $this->webroot; ?>img/branding-partners/smathersAndBransonLogo.png" class="fadein-image" alt="Smathers and Branson" data-name="smathers"/></li>
                        <li><img src="<?php echo $this->webroot; ?>img/branding-partners/vknagrani.png" class="fadein-image" alt="VK Nagrani" data-name="nagrani"/></li>
                        <li><img src="<?php echo $this->webroot; ?>img/branding-partners/Cole_Haan_Logo.jpg" class="fadein-image" alt="Cole Haan" data-name="colehaan"/></li>
                        <li><img src="<?php echo $this->webroot; ?>img/branding-partners/paulevans.png" class="fadein-image" alt="Paul Evans" data-name="paulevans"/></li>
                        <li><img src="<?php echo $this->webroot; ?>img/branding-partners/allen-edmonds-logo.jpg" class="fadein-image" alt="Allen Edmonds" data-name="allenedmonds"/></li>
                        <li><img src="<?php echo $this->webroot; ?>img/branding-partners/DW_logo.png" class="fadein-image" alt="Daniel Wellington" data-name="dw"/></li>
                        <li><img src="<?php echo $this->webroot; ?>img/branding-partners/agave.jpg" class="fadein-image" alt="Agave Denim" data-name="agave" /></li>
                        <li><img src="<?php echo $this->webroot; ?>img/branding-partners/saxx-underwear.png" class="fadein-image" alt="SAXX-Underwear" data-name="saxx"></li>
                        <li><img src="<?php echo $this->webroot; ?>img/branding-partners/mclip.png" class="fadein-image" alt="M-Clip" data-name="mclip" /></li>
                        <li><img src="<?php echo $this->webroot; ?>img/branding-partners/edward.png" class="fadein-image" alt="Edward Harmah" data-name="edwardamrah"/></li>
        </ul>
    </div>
-->

<!--
     <div class="ten columns text-center page-heading">
        <h1>See what others are saying about us</h1>
    </div>
-->
<!--
    <div class="eight columns text-center center-block testimonials">
        <h3>Peter</h3>
        <h4>Real Estate Agent</h4>
        <span class="testi-desc">"Like most men, shopping can be a very daunting task, however, having my SRS personal stylist saves me the time and energy I would otherwise spend in stores."</span>
    </div>
-->
        
</div>
<div id="brandinfo-box" class="box-modal notification-box hide">
        <div class="box-modal-inside">
            <a class="notification-close" href=""></a>
            <div class="brand-info">
                <div class="brand-logo"><img src="" class="fadein-image" alt="" /></div>  
                <div class="notification-msg">
                    <p class="brand-title"></p>
                    <p class="brand-desc">
                    </p>  
                </div>
                <a href="" class="link-btn black-btn brand-btn">see products</a> 
                 
            </div> 
        </div>
    </div>
</div>