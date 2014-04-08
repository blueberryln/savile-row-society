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
            if(jQuery(".mg-big img")[0].complete && jQuery(".mg-small img")[0].complete){
                vidContinerHeight()
            }
            else{
                jQuery(".mg-big img, .mg-small img").load(function() {
                    vidContinerHeight()
                });
            }   
            
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
    $(window).load(function() {
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
        
    });
   
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
    
    <div class="mega-banner">
        <div class="mg-big">
            <?php if($is_logged && $has_stylist) : ?>
                <a class="over-img" href="<?php echo $this->request->webroot; ?>messages/index/">
            <?php elseif($is_logged) : ?>
                <a class="over-img" href="<?php echo $this->request->webroot; ?>profile/about">
            <?php else : ?>
                <a class="over-img" href="#" onclick="window.ref_url=''; signUp();">
            <?php endif; ?>
                <img src="<?php echo $this->webroot; ?>img/h_1.jpg" />
            </a>
            <div id="my-stylist" style="left: 0; top: 5%;">
                <?php if($is_logged && $has_stylist) : ?>
                    <a class="link-btn gold-btn" href="<?php echo $this->request->webroot; ?>messages/index/">Meet My<br>Stylist</a>
                <?php elseif($is_logged) : ?>
                    <a class="link-btn gold-btn" href="<?php echo $this->request->webroot; ?>profile/about">Meet My<br>Stylist</a>
                <?php else : ?>
                    <a class="link-btn gold-btn" href="#" onclick="window.ref_url=''; signUp();">Meet My<br>Stylist</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="mg-vid">            
            <img src="<?php echo $this->webroot; ?>img/h_2.jpg" />
            <div class="mgs-btn" style="right: 0; top: 40%;">
                <a class="link-btn gold-btn" href="<?php echo $this->request->webroot; ?>lookbooks/#29" style="margin-right: 0;">GET THIS <br>LOOK</a>
            </div>
            <!-- <iframe class="max-width-adj" src="http://www.youtube.com/embed/f6eqZnrWuQ8?enablejsapi=1&rel=0&version=3&wmode=transparent" frameborder="0" allowfullscreen></iframe>  -->           
        </div>
        <div class="mg-small">
            <img src="<?php echo $this->webroot; ?>img/h_4.jpg" />

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
        </div>
        <div class="clear-fix"></div> 
    </div>
   

    <div class="ten columns text-center page-heading">
        <h1>How it works</h1>
    </div>
    <div class="eleven columns container works-boxes">
        <div class="work-box">
            <?php if($is_logged && $has_stylist) : ?>
                <a href="<?php echo $this->request->webroot; ?>myprofile" class="over-img">
            <?php elseif($is_logged) : ?>
                <a href="<?php echo $this->request->webroot; ?>profile/about" class="over-img">
            <?php else : ?>
                <a href="#" onclick="window.ref_url=''; signUp();" class="over-img">
            <?php endif; ?>
                <img src="<?php echo $this->webroot; ?>img/how-it-works/Step1.jpg" />
            </a>

            <span class="c-no"><img src="<?php echo $this->webroot; ?>img/how-it-works/no_1.png" /></span>
            <span class="works-desc">Fill out a quick style profile and you will be matched with your very own personal shopper.</span>
            
            
            <?php if($is_logged && $has_stylist) : ?>
                <div class="wrok-btn-box only-mob"><a class="works-btn" href="<?php echo $this->request->webroot; ?>myprofile">Register</a></div>
            <?php elseif($is_logged) : ?>
                <div class="wrok-btn-box only-mob"><a class="works-btn" href="<?php echo $this->request->webroot; ?>profile/about">Register</a></div>
            <?php else : ?>
                <div class="wrok-btn-box only-mob"><a class="works-btn" href="#" onclick="window.ref_url=''; signUp();">Register</a></div>
            <?php endif; ?>
        </div> 
         <div class="work-box">
            <?php if($is_logged && $has_stylist) : ?>
                <a href="<?php echo $this->request->webroot; ?>messages/index/" class="over-img">
            <?php elseif($is_logged) : ?>
                <a href="<?php echo $this->request->webroot; ?>profile/about" class="over-img">
            <?php else : ?>
                <a href="#" onclick="window.ref_url=''; signUp();" class="over-img">
            <?php endif; ?>
                <img src="<?php echo $this->webroot; ?>img/how-it-works/Step2.jpg" />
            </a>

            <span class="c-no"><img src="<?php echo $this->webroot; ?>img/how-it-works/no_2.png" /></span>
            <span class="works-desc">Communicate on the website, on the phone or in-person. Buy what you want from your stylist’s recommendations.</span>
            
            
            <?php if($is_logged && $has_stylist) : ?>
                <div class="wrok-btn-box only-mob"><a class="works-btn" href="<?php echo $this->request->webroot; ?>messages/index/">Talk & shop</a></div>
            <?php elseif($is_logged) : ?>
                <div class="wrok-btn-box only-mob"><a class="works-btn" href="<?php echo $this->request->webroot; ?>profile/about">Talk & shop</a></div>
            <?php else : ?>
                <div class="wrok-btn-box only-mob"><a class="works-btn" href="#" onclick="window.ref_url=''; signUp();">Talk & shop</a></div>
            <?php endif; ?>
        </div> 
         <div class="work-box">
            <?php if($is_logged && $has_stylist) : ?>
                <a href="<?php echo $this->request->webroot; ?>lookbooks/" class="over-img">
            <?php elseif($is_logged) : ?>
                <a href="<?php echo $this->request->webroot; ?>profile/about" class="over-img">
            <?php else : ?>
                <a href="#" onclick="window.ref_url=''; signUp();" class="over-img">
            <?php endif; ?>
                <img src="<?php echo $this->webroot; ?>img/how-it-works/Step3.jpg" />
            </a>

            <span class="c-no"><img src="<?php echo $this->webroot; ?>img/how-it-works/no_3.png" /></span>
            <span class="works-desc">Have your purchases delivered for free. Verify that the fit is perfect. Dress for the life you want.</span>
            
            
            <?php if($is_logged && $has_stylist) : ?>
                <div class="wrok-btn-box only-mob"><a class="works-btn" href="<?php echo $this->request->webroot; ?>lookbooks/">Look sharp</a></div>
            <?php elseif($is_logged) : ?>
                <div class="wrok-btn-box only-mob"><a class="works-btn" href="<?php echo $this->request->webroot; ?>profile/about">Look sharp</a></div>
            <?php else : ?>
                <div class="wrok-btn-box only-mob"><a class="works-btn" href="#" onclick="window.ref_url=''; signUp();">Look sharp</a></div>
            <?php endif; ?>
        </div> 
    </div>
    <div class="eleven columns container works-boxes only-desktop">
        <div class="work-box">
            <?php if($is_logged && $has_stylist) : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="<?php echo $this->request->webroot; ?>myprofile">Register</a></div>
            <?php elseif($is_logged) : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="<?php echo $this->request->webroot; ?>profile/about">Register</a></div>
            <?php else : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="#" onclick="window.ref_url=''; signUp();">Register</a></div>
            <?php endif; ?>
        </div> 
         <div class="work-box">
            <?php if($is_logged && $has_stylist) : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="<?php echo $this->request->webroot; ?>messages/index/">Talk & shop</a></div>
            <?php elseif($is_logged) : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="<?php echo $this->request->webroot; ?>profile/about">Talk & shop</a></div>
            <?php else : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="#" onclick="window.ref_url=''; signUp();">Talk & shop</a></div>
            <?php endif; ?>
        </div> 
         <div class="work-box">
            <?php if($is_logged && $has_stylist) : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="<?php echo $this->request->webroot; ?>lookbooks/">Look sharp</a></div>
            <?php elseif($is_logged) : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="<?php echo $this->request->webroot; ?>profile/about">Look sharp</a></div>
            <?php else : ?>
                <div class="wrok-btn-box"><a class="works-btn" href="#" onclick="window.ref_url=''; signUp();">Look sharp</a></div>
            <?php endif; ?>
        </div> 
    </div>
    
    <!-- <div class="ten columns text-center page-heading">
        <h1>our idea of stylist</h1>
    </div>
    <div class="eleven columns stylist-boxes">
        <div class="stylist-box">
            <?php if($is_logged && $has_stylist) : ?>
                <a href="<?php echo $this->request->webroot; ?>messages/index/" class="over-img">
            <?php elseif($is_logged) : ?>
                <a href="<?php echo $this->request->webroot; ?>profile/about" class="over-img">
            <?php else : ?>
                <a href="#" onclick="window.ref_url=''; signUp();" class="over-img">
            <?php endif; ?>
                <div class="img-box">
                    <img src="<?php echo $this->webroot; ?>img/how-it-works/img_1.png" />
                    <div class="overlay"></div>
                </div>            
            </a>
            <h3>Your own very stylist</h3>
            <span class="stylist-desc">Signing up with Savile Row Society means you’ll be assigned a personal stylist who will get to know your tastes and preferences, catering to all of your wardrobe and lifestyle needs.</span>
        </div> 
         <div class="stylist-box">
           <?php if($is_logged && $has_stylist) : ?>
                <a href="<?php echo $this->request->webroot; ?>messages/index/" class="over-img">
            <?php elseif($is_logged) : ?>
                <a href="<?php echo $this->request->webroot; ?>profile/about" class="over-img">
            <?php else : ?>
                <a href="#" onclick="window.ref_url=''; signUp();" class="over-img">
            <?php endif; ?>
                <div class="img-box">
                    <img src="<?php echo $this->webroot; ?>img/how-it-works/img_2.jpg" />
                    <div class="overlay"></div>
                </div>   
            </a>         
            <h3>A real expert</h3>
            <span class="stylist-desc">Algorithms are great to find the cheapest flight, but fashion is about more than logic. Our tenured stylists are the best of the best, and will work hard to make our virtual closet, your reality.</span>
        </div> 
         <div class="stylist-box">
            <?php if($is_logged && $has_stylist) : ?>
                <a href="<?php echo $this->request->webroot; ?>messages/index/" class="over-img">
            <?php elseif($is_logged) : ?>
                <a href="<?php echo $this->request->webroot; ?>profile/about" class="over-img">
            <?php else : ?>
                <a href="#" onclick="window.ref_url=''; signUp();" class="over-img">
            <?php endif; ?>
               <div class="img-box">
                    <img src="<?php echo $this->webroot; ?>img/how-it-works/img_3.jpg" />
                    <div class="overlay"></div>
                </div>    
            </a>        
            <h3>Communicate easily</h3>
            <span class="stylist-desc">You can chat with your stylist online, on the phone, or even in person during an appointment at our showroom.</span>            
        </div>
        <div class="stylist-box">
           <a href="<?php echo $this->request->webroot; ?>closet" class="over-img">
               <div class="img-box">
                    <img src="<?php echo $this->webroot; ?>img/how-it-works/img_4.jpg" />
                    <div class="overlay"></div>
                </div>            
            </a>
            <h3>Rate products</h3>
            <span class="stylist-desc">Your personal stylist wants your feedback! Like and dislike their suggestions to give them a better sense of your style preferences.</span>
        </div>  
    </div> -->

    <div class="ten columns text-center page-heading">
        <h1>How To Shop With Us</h1>
    </div>
    <div class="eleven columns container shopping-boxes">
        <div class="shopping-box">
            <a href="<?php echo $this->request->webroot; ?>closet" class="over-img">
                <img src="<?php echo $this->webroot; ?>img/how-it-works/The_Closet.png" />
            </a>
            <h3>Shop online</h3>
            <span class="shopping-desc">Browse our curated selection. In the Closet, you will find samples of everything from dress shoes to swimsuits.</span>
        </div> 
         <div class="shopping-box">
            <?php if($is_logged && $has_stylist) : ?>
                <a href="<?php echo $this->request->webroot; ?>fitting-room" class="over-img">
            <?php elseif($is_logged) : ?>
                <a href="<?php echo $this->request->webroot; ?>profile/about" class="over-img">
            <?php else : ?>
                <a href="#" onclick="window.ref_url=''; signUp();" class="over-img">
            <?php endif; ?>
                <img src="<?php echo $this->webroot; ?>img/how-it-works/My_Stylist.png" />
            </a>
            <h3>My Stylist</h3>
            <span class="shopping-desc">Have a conversation with your stylist and see her personalized recommendations. Our stylists have access to our entire collection. </span>
        </div> 
         <div class="shopping-box">
            <?php if($is_logged && $has_stylist) : ?>
                <a href="<?php echo $this->request->webroot; ?>messages/index/" class="over-img">
            <?php elseif($is_logged) : ?>
                <a href="<?php echo $this->request->webroot; ?>profile/about" class="over-img">
            <?php else : ?>
                <a href="#" onclick="window.ref_url=''; signUp();" class="over-img">
            <?php endif; ?>
                <img src="<?php echo $this->webroot; ?>img/how-it-works/The_Fitting_Room.png" />
            </a>
            <h3>The Fitting Room</h3>
            <span class="shopping-desc">Make an appointment to meet with your stylist, try on our collection or get measured for our made-to-measure collection. </span>
        </div> 
    </div>

    <div class="ten columns text-center page-heading">
        <h1>Our brands</h1>        
    </div>
    <div class="eleven columns home-branding-partners center-block">
        <span class="nine columns brands-desc">We select the best of the best. From big name brands such as Barbour and Lacoste, to boutique brands such as Bernard Zins and VK Nagrani, our goal is to bring you the brands that we believe are the best in class and the best in their category. One thing is for sure, all of our partnering brands are passionate about clothing. <a href="<?php echo $this->request->webroot; ?>company/brands">See more brands</a></span>
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

     <div class="ten columns text-center page-heading">
        <h1>See what others are saying about us</h1>
    </div>
    <div class="eight columns text-center center-block testimonials">
        <h3>Peter</h3>
        <h4>Real Estate Agent</h4>
        <span class="testi-desc">"Like most men, shopping can be a very daunting task, however, having my SRS personal stylist saves me the time and energy I would otherwise spend in stores."</span>
    </div>
        
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