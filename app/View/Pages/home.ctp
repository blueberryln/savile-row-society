<script type="text/javascript">
    // $(document).ready(function(){
    //     $('.product_placeholder ul li a').hover(function(){
    //         $('.hover_part').hide();
    //         $('.hover_part',this).show();
    //     });
    // });
    /*$(window).load(function(){
        $('.slick-slide h3 a').hover(function(){
            $('.hover_part').hide();
            $('.hover_part',this).show();
        });
    });*/   

$('.nav_wrapper a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
    var target = $(this.hash);
     target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top - 70
        }, 1000);
        return false;
      }
    }
});


$(document).ready(function()
{


if($(window).width() <=499)
{
    $( "ul.two-column > li" ).each(function( index ) {
        var shopLook =  $(this).children('div.right_box').children('div.box4_wrapper');
        $(this).children('div.left_box').prepend(shopLook);
        $(this).children('div.right_box').children('div.box4_wrapper').remove();
    });
}

// $(window).resize(function()
// {
//       $( "ul.two-column > li" ).each(function( index ) {
//         var shopLook =  $(this).children('div.right_box').children('div.box4');
//         $(this).children('div.left_box').prepend(shopLook);
//         $(this).children('div.right_box').children('div.box4').remove();
//     });  
// }
// else
// {
//          $( "ul.two-column > li" ).each(function( index ) {
//         var shopLook =  $(this).children('div.right_box').children('div.box4');
//                 $(this).children('div.right_box').children('div.box4').after(shopLook); 
// }


$('a.tell-me-more[href*=#]:not([href=#])').click(function() {
    console.log('123');
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
    var target = $(this.hash);
     target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top - 70
        }, 1000);
        return false;
      }
    }
});

});

$('.container a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
    var target = $(this.hash);
     target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
         //console.log(target.offset().top());
      if (target.length) {                         
        $('html,body').animate({
          scrollTop: target.offset().top - 105
        }, 1000);
        return false;
      }
    }
});

$(document).on('click','.view_all_comments',function(){
    var outfit_id = $(this).attr('rel');
    $.ajax({
        url: '/Pages/get_comment/'+outfit_id,
        success: function(response){
            $('.comment_append'+outfit_id).html(response);
        }
    });
    //$(this).remove();
});



</script>
   


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
<?php if(empty($slideBlog)){
    $slideBlog['SlideBlog']['title'] = 'Twillory and SRS: A Shared Personal Style';
    $slideBlog['SlideBlog']['description'] = 'We’re getting you that personalized style with Twillory';
    $slideBlog['SlideBlog']['image'] = 'img/home/HomeImageBlog.png';
    $slideBlog['SlideBlog']['link'] = 'http://www.savilerowsociety.com/blog/';
    } else{
        $slideBlog['SlideBlog']['image'] = 'files/blog/'.$slideBlog['SlideBlog']['image'];
        } ?>
    <!-- Wrapper -->
    <div class="container_wrapper">
        <!-- banner -->
        <section id="banner_wrapper">
            <section class="slider">
                <div class="flexslider">
                    <ul class="slides">
                        <li>
                            <img src="<?php echo HTTP_ROOT ?>img/home/slide1.jpg" alt="SHOP NOW WITH YOUR PERSONAL STYLIST" />
                            <span >
                                <div style="margin-top:25px;"class="heading">TAKE IT TO THE NEXT LEVEL</div>
                                <!-- <p>Online & In-Person</p>
                                <a class="tell-me-more" href="/#nine9">Tell Me More</a> -->
                                <a href="<?php echo $this->webroot; ?>users/register" class="getStarted">Get Started</a>
                                <p style="padding:20px;">Free to Sign Up & Browse</p>
                            </span>
                        </li>
                        <li class="slide_second">
                            <img src="<?php echo HTTP_ROOT.$slideBlog['SlideBlog']['image'] ?>" alt="SHOP NOW WITH YOUR PERSONAL STYLIST" />
                            <span>
                                <div class="heading"><a target="_blank" style="outline: none;margin: 0;padding: 0;color: #fff;text-decoration: none;text-transform: uppercase;font-size: 31px;line-height: normal;background:none;" href="<?php echo $slideBlog['SlideBlog']['link']; ?>"><?php echo $slideBlog['SlideBlog']['title']; ?></a></div>
                                <p><?php echo $slideBlog['SlideBlog']['description']; ?><br><br><a target="_blank" style="outline: none;margin: 0;padding: 0;color: #fff;text-decoration: none;text-transform: uppercase;font-size: 17px;line-height: normal;background:none;"  href = "<?php echo $slideBlog['SlideBlog']['link']; ?>">Read on...</a></p>
                            </span>
                        </li>
                        <li class="GetSocial">
                            <img src="<?php echo HTTP_ROOT ?>img/home/slide2.jpg" alt="SHOP NOW WITH YOUR PERSONAL STYLIST" />
                            <span>
                                <div class="heading">get social</div>
                                <p>For the latest news and access to special offers, follow us on social media.</p>
                                <ul>
                                    <li><a target="_blank" href="https://instagram.com/savilerowsociety" class="instagram">@savilerowsociety</a></li>
                                    <li><a target="_blank" href="https://www.facebook.com/SavileRowSociety" class="facebook">SavileRowSociety</a></li>
                                    <li><a target="_blank" href="https://twitter.com/SRSocietydotcom" class="twitter">@SRSocietydotcom</a></li>
                                </ul>
                            </span>
                        </li>
                        <!-- <li>
                            <img src="<?php echo HTTP_ROOT ?>img/home/slide1.jpg" alt="SHOP NOW WITH YOUR PERSONAL STYLIST" />
                        </li>
                        <li>
                            <img src="<?php echo HTTP_ROOT ?>img/home/slide3.jpg" alt="SHOP NOW WITH YOUR PERSONAL STYLIST" />
                        </li> -->
                    </ul>
                </div>
            </section>
        </section>
        <!-- /banner -->

        <!-- rightImages -->
        <div class="rightImages">
            <!-- <a href="#"><img src="<?php //echo HTTP_ROOT ?>img/home/img1.jpg" alt="looks by occasion" />
                <span class="hover_section"><img src="<?php //echo HTTP_ROOT ?>img/home/img1-hover.jpg" alt="looks by occasion" /></span>
            </a>
            <a href="#"><img src="<?php //echo HTTP_ROOT ?>img/home/img2.jpg" alt="shop by items" />
                <span class="hover_section"><img src="<?php //echo HTTP_ROOT ?>img/home/img2-hover.jpg" alt="shop by items" /></span>
            </a>
            <a href="#"><img src="<?php //echo HTTP_ROOT ?>img/home/img3.jpg" alt="shop men's" />
                <span class="hover_section"><img src="<?php //echo HTTP_ROOT ?>img/home/img3-hover.jpg" alt="shop men's" /></span>
            </a> -->

            <a href="/coming-soon" class="looksByOccasion"><span><span class="col-text">looks by occasion</span></span></a>
            <a href="/coming-soon" class="shopByItems"><span><span class="col-text">shop by item</span></span></a>
            <a href="/coming-soon" class="shopMen"><span><span class="col-text">shop top looks</span></span></a>


        </div>
        <!-- /rightImages -->
        <div id="two" style="margin-top:0px;"></div>
        <!-- Top Outfits -->
        <section id="top_outfits_wrapper">
            <div class="center_row">
                
                <!-- Section_Main_Heading -->
                <div class="Section_Main_Heading">
                    <h1>TOP LOOKS</h1>
                    <h3>Need inspiration? Browse what's hot right now through the lens of our fashion consultants.</h3>
                </div>
                <!-- /Section_Main_Heading -->

                <!-- column -->
                 <!-- <div style="position: relative;">
                    <div class="for_mobile_product"> -->
                        <div class="product-content" style="position:relative">
                        
                            <ul class="multiple-items1 slider after-load">                                
                                <!-- Dummy Product Items-->

                                <li>
                                    <div class="link-button small-device">
                                        <div class="shop-button">
                                            <a href="/guest/outfitdetails/498">SHOP</a>              
                                        </div>    
                                    </div>
                                    <div class="row heading_title">
                                        <div class="author_name"> <!-- Styled by <span>Leslie Gilbert-Morales</span> --> 
                                            <a href="/stylists/stylistbiography/741">
                                                <img src="http://srs/images/default-user.jpg" alt="">
                                            </a>  
                                        </div>
                                        <div class="designer_name"> By LESLIE GILBERT-MORALES /</div>
                                        <div class="heading_wrapper">
                                            <span>try to weeekend dressup</span>
                                        </div>
                                   </div>
                                   <div class="left_box">
                                        <div class="box1_wrapper">
                                            <div class="box1">
                                                <a href="/guest/outfitdetails/498">
                                                    <img src="http://srs/files/products/705_7566823_Untitled.jpg">
                                                </a>
                                            </div>
                                            <div class="tooplooks_box_hover">
                                                <div class="tooplooks_box_desc">
                                                    <div class="tooplooks_box_desc_type">V Neck T-shirt</div>
                                                    <div class="tooplooks_box_desc_brand">Calida</div>
                                                    <div class="tooplooks_box_desc_price">$ 35.00</div>
                                                    <div class="tooplooks_box_desc_btn_cart"><a href="javascript:void(0);">Add to Cart</a></div>
                                                    <div class="tooplooks_box_desc_btn_checkout"><a href="javascript:void(0)">Check it out</a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box2_wrapper">
                                             <div class="box2">
                                                <a href="/guest/outfitdetails/498">
                                                    <img src="http://srs/files/products/715_1849192_AlanPaineAlbury1.jpg">
                                                </a>
                                            </div>
                                            <div class="tooplooks_box_hover">
                                                <div class="tooplooks_box_desc">
                                                    <div class="tooplooks_box_desc_type">V Neck T-shirt</div>
                                                    <div class="tooplooks_box_desc_brand">Calida</div>
                                                    <div class="tooplooks_box_desc_price">$ 35.00</div>
                                                    <div class="tooplooks_box_desc_btn_cart"><a href="javascript:void(0);">Add to Cart</a></div>
                                                    <div class="tooplooks_box_desc_btn_checkout"><a href="javascript:void(0)">Check it out</a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box3_wrapper">  
                                            <div class="box3">
                                                <a href="/guest/outfitdetails/498">
                                                    <img src="http://srs/files/products/870_7142481_navy west.png">
                                                </a>
                                            </div> 
                                            <div class="tooplooks_box_hover">
                                                <div class="tooplooks_box_desc">
                                                    <div class="tooplooks_box_desc_type">V Neck T-shirt</div>
                                                    <div class="tooplooks_box_desc_brand">Calida</div>
                                                    <div class="tooplooks_box_desc_price">$ 35.00</div>
                                                    <div class="tooplooks_box_desc_btn_cart"><a href="javascript:void(0);">Add to Cart</a></div>
                                                    <div class="tooplooks_box_desc_btn_checkout"><a href="javascript:void(0)">Check it out</a></div>
                                                </div>
                                            </div>
                                        </div>  
                                    </div> 
                                    <div class="right_box">
                                        <div class="box4_wrapper"> 
                                            <div class="box4">
                                            <!--shop button begins -->
                                                <div class="link-button">
                                                    <div class="shop-button">
                                                        <a href="/guest/outfitdetails/498">SHOP</a>              
                                                    </div>    
                                                </div>   
                                                <a href="/guest/outfitdetails/498">
                                                    <img src="http://srs/files/products/566_6890157_FriJays_Revised_-_T_S_grande.jpg">
                                                </a>
                                            </div>  
                                            <div class="tooplooks_box_hover">
                                                <div class="tooplooks_box_desc">
                                                    <div class="tooplooks_box_desc_type">V Neck T-shirt</div>
                                                    <div class="tooplooks_box_desc_brand">Calida</div>
                                                    <div class="tooplooks_box_desc_price">$ 35.00</div>
                                                    <div class="tooplooks_box_desc_btn_cart"><a href="javascript:void(0);">Add to Cart</a></div>
                                                    <div class="tooplooks_box_desc_btn_checkout"><a href="javascript:void(0)">Check it out</a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box5_wrapper"> 
                                            <div class="box5">
                                                <a href="/guest/outfitdetails/498">
                                                    <img src="http://srs/files/products/786_5725733_CitizensSidUltimateFront.jpg">
                                                </a>
                                            </div> 
                                            <div class="tooplooks_box_hover">
                                                <div class="tooplooks_box_desc">
                                                    <div class="tooplooks_box_desc_type">V Neck T-shirt</div>
                                                    <div class="tooplooks_box_desc_brand">Calida</div>
                                                    <div class="tooplooks_box_desc_price">$ 35.00</div>
                                                    <div class="tooplooks_box_desc_btn_cart"><a href="javascript:void(0);">Add to Cart</a></div>
                                                    <div class="tooplooks_box_desc_btn_checkout"><a href="javascript:void(0)">Check it out</a></div>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="text-content" style="float:left; width:100%; height:auto; text-align:left;">                        
                                        <span class="golden-heading">
                                            <div class="fb-like facebook-like fb_iframe_widget" data-href="http://srs/guest/outfitdetails/498" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false" fb-xfbml-state="rendered" fb-iframe-plugin-query="action=like&amp;app_id=507420839292016&amp;container_width=100&amp;href=http%3A%2F%2Fsrs%2Fguest%2Foutfitdetails%2F498&amp;layout=button_count&amp;locale=en_US&amp;sdk=joey&amp;share=false&amp;show_faces=false"><span style="vertical-align: bottom; width: 76px; height: 20px;"><iframe name="f39aaa1f5" width="1000px" height="1000px" frameborder="0" allowtransparency="true" allowfullscreen="true" scrolling="no" title="fb:like Facebook Social Plugin" src="http://www.facebook.com/v2.1/plugins/like.php?action=like&amp;app_id=507420839292016&amp;channel=http%3A%2F%2Fstatic.ak.facebook.com%2Fconnect%2Fxd_arbiter%2FQrU_tEEWym9.js%3Fversion%3D41%23cb%3Df15d38c018%26domain%3Dsrs%26origin%3Dhttp%253A%252F%252Fsrs%252Ff6eb4aa8%26relation%3Dparent.parent&amp;container_width=100&amp;href=http%3A%2F%2Fsrs%2Fguest%2Foutfitdetails%2F498&amp;layout=button_count&amp;locale=en_US&amp;sdk=joey&amp;share=false&amp;show_faces=false" style="border: none; visibility: visible; width: 76px; height: 20px;" class=""></iframe></span></div>
                                        </span>                        
                                                                                <p class="view-all">
                                            <span rel="498" style="cursor:pointer" class="golden-heading ">0 comments / view all</span>
                                        </p>
                                        <div>
                                            <div class="comment_append498 comment_view">
                                                                                            </div>
                                        </div>
                                        <form method="POST" class="comment_form send_comment">
                                            <input type="hidden" name="data[OutfitComment][outfit_id]" class="outfit_id" value="498">
                                            <input type="text" name="data[OutfitComment][comment]" class="comment_box input-post">
                                            <input class="post-submit submit_comment" value="POST" type="submit">
                                        </form>
                                    </div>
                                </li>
                                <li>
                                    <div class="link-button small-device">
                                        <div class="shop-button">
                                            <a href="/guest/outfitdetails/498">SHOP</a>              
                                        </div>    
                                    </div>
                                    <div class="row heading_title">
                                        <div class="author_name"> <!-- Styled by <span>Leslie Gilbert-Morales</span> --> 
                                            <a href="/stylists/stylistbiography/741">
                                                <img src="http://srs/images/default-user.jpg" alt="">
                                            </a>  
                                        </div>
                                        <div class="designer_name"> By LESLIE GILBERT-MORALES /</div>
                                        <div class="heading_wrapper">
                                            <span>try to weeekend dressup</span>
                                        </div>
                                   </div>
                                   <div class="left_box">
                                        <div class="box1_wrapper">
                                            <div class="box1">
                                                <a href="/guest/outfitdetails/498">
                                                    <img src="http://srs/files/products/705_7566823_Untitled.jpg">
                                                </a>
                                            </div>
                                            <div class="tooplooks_box_hover">
                                                <div class="tooplooks_box_desc">
                                                    <div class="tooplooks_box_desc_type">V Neck T-shirt</div>
                                                    <div class="tooplooks_box_desc_brand">Calida</div>
                                                    <div class="tooplooks_box_desc_price">$ 35.00</div>
                                                    <div class="tooplooks_box_desc_btn_cart"><a href="javascript:void(0);">Add to Cart</a></div>
                                                    <div class="tooplooks_box_desc_btn_checkout"><a href="javascript:void(0)">Check it out</a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box2_wrapper">
                                             <div class="box2">
                                                <a href="/guest/outfitdetails/498">
                                                    <img src="http://srs/files/products/715_1849192_AlanPaineAlbury1.jpg">
                                                </a>
                                            </div>
                                            <div class="tooplooks_box_hover">
                                                <div class="tooplooks_box_desc">
                                                    <div class="tooplooks_box_desc_type">V Neck T-shirt</div>
                                                    <div class="tooplooks_box_desc_brand">Calida</div>
                                                    <div class="tooplooks_box_desc_price">$ 35.00</div>
                                                    <div class="tooplooks_box_desc_btn_cart"><a href="javascript:void(0);">Add to Cart</a></div>
                                                    <div class="tooplooks_box_desc_btn_checkout"><a href="javascript:void(0)">Check it out</a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box3_wrapper">  
                                            <div class="box3">
                                                <a href="/guest/outfitdetails/498">
                                                    <img src="http://srs/files/products/870_7142481_navy west.png">
                                                </a>
                                            </div> 
                                            <div class="tooplooks_box_hover">
                                                <div class="tooplooks_box_desc">
                                                    <div class="tooplooks_box_desc_type">V Neck T-shirt</div>
                                                    <div class="tooplooks_box_desc_brand">Calida</div>
                                                    <div class="tooplooks_box_desc_price">$ 35.00</div>
                                                    <div class="tooplooks_box_desc_btn_cart"><a href="javascript:void(0);">Add to Cart</a></div>
                                                    <div class="tooplooks_box_desc_btn_checkout"><a href="javascript:void(0)">Check it out</a></div>
                                                </div>
                                            </div>
                                        </div>  
                                    </div> 
                                    <div class="right_box">
                                        <div class="box4_wrapper"> 
                                            <div class="box4">
                                            <!--shop button begins -->
                                                <div class="link-button">
                                                    <div class="shop-button">
                                                        <a href="/guest/outfitdetails/498">SHOP</a>              
                                                    </div>    
                                                </div>   
                                                <a href="/guest/outfitdetails/498">
                                                    <img src="http://srs/files/products/566_6890157_FriJays_Revised_-_T_S_grande.jpg">
                                                </a>
                                            </div>  
                                            <div class="tooplooks_box_hover">
                                                <div class="tooplooks_box_desc">
                                                    <div class="tooplooks_box_desc_type">V Neck T-shirt</div>
                                                    <div class="tooplooks_box_desc_brand">Calida</div>
                                                    <div class="tooplooks_box_desc_price">$ 35.00</div>
                                                    <div class="tooplooks_box_desc_btn_cart"><a href="javascript:void(0);">Add to Cart</a></div>
                                                    <div class="tooplooks_box_desc_btn_checkout"><a href="javascript:void(0)">Check it out</a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box5_wrapper"> 
                                            <div class="box5">
                                                <a href="/guest/outfitdetails/498">
                                                    <img src="http://srs/files/products/786_5725733_CitizensSidUltimateFront.jpg">
                                                </a>
                                            </div> 
                                            <div class="tooplooks_box_hover">
                                                <div class="tooplooks_box_desc">
                                                    <div class="tooplooks_box_desc_type">V Neck T-shirt</div>
                                                    <div class="tooplooks_box_desc_brand">Calida</div>
                                                    <div class="tooplooks_box_desc_price">$ 35.00</div>
                                                    <div class="tooplooks_box_desc_btn_cart"><a href="javascript:void(0);">Add to Cart</a></div>
                                                    <div class="tooplooks_box_desc_btn_checkout"><a href="javascript:void(0)">Check it out</a></div>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="text-content" style="float:left; width:100%; height:auto; text-align:left;">                        
                                        <span class="golden-heading">
                                            <div class="fb-like facebook-like fb_iframe_widget" data-href="http://srs/guest/outfitdetails/498" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false" fb-xfbml-state="rendered" fb-iframe-plugin-query="action=like&amp;app_id=507420839292016&amp;container_width=100&amp;href=http%3A%2F%2Fsrs%2Fguest%2Foutfitdetails%2F498&amp;layout=button_count&amp;locale=en_US&amp;sdk=joey&amp;share=false&amp;show_faces=false"><span style="vertical-align: bottom; width: 76px; height: 20px;"><iframe name="f39aaa1f5" width="1000px" height="1000px" frameborder="0" allowtransparency="true" allowfullscreen="true" scrolling="no" title="fb:like Facebook Social Plugin" src="http://www.facebook.com/v2.1/plugins/like.php?action=like&amp;app_id=507420839292016&amp;channel=http%3A%2F%2Fstatic.ak.facebook.com%2Fconnect%2Fxd_arbiter%2FQrU_tEEWym9.js%3Fversion%3D41%23cb%3Df15d38c018%26domain%3Dsrs%26origin%3Dhttp%253A%252F%252Fsrs%252Ff6eb4aa8%26relation%3Dparent.parent&amp;container_width=100&amp;href=http%3A%2F%2Fsrs%2Fguest%2Foutfitdetails%2F498&amp;layout=button_count&amp;locale=en_US&amp;sdk=joey&amp;share=false&amp;show_faces=false" style="border: none; visibility: visible; width: 76px; height: 20px;" class=""></iframe></span></div>
                                        </span>                        
                                                                                <p class="view-all">
                                            <span rel="498" style="cursor:pointer" class="golden-heading ">0 comments / view all</span>
                                        </p>
                                        <div>
                                            <div class="comment_append498 comment_view">
                                                                                            </div>
                                        </div>
                                        <form method="POST" class="comment_form send_comment">
                                            <input type="hidden" name="data[OutfitComment][outfit_id]" class="outfit_id" value="498">
                                            <input type="text" name="data[OutfitComment][comment]" class="comment_box input-post">
                                            <input class="post-submit submit_comment" value="POST" type="submit">
                                        </form>
                                    </div>
                                </li>
                                <li>
                                    <div class="link-button small-device">
                                        <div class="shop-button">
                                            <a href="/guest/outfitdetails/498">SHOP</a>              
                                        </div>    
                                    </div>
                                    <div class="row heading_title">
                                        <div class="author_name"> <!-- Styled by <span>Leslie Gilbert-Morales</span> --> 
                                            <a href="/stylists/stylistbiography/741">
                                                <img src="http://srs/images/default-user.jpg" alt="">
                                            </a>  
                                        </div>
                                        <div class="designer_name"> By LESLIE GILBERT-MORALES /</div>
                                        <div class="heading_wrapper">
                                            <span>try to weeekend dressup</span>
                                        </div>
                                   </div>
                                   <div class="left_box">
                                        <div class="box1_wrapper">
                                            <div class="box1">
                                                <a href="/guest/outfitdetails/498">
                                                    <img src="http://srs/files/products/705_7566823_Untitled.jpg">
                                                </a>
                                            </div>
                                            <div class="tooplooks_box_hover">
                                                <div class="tooplooks_box_desc">
                                                    <div class="tooplooks_box_desc_type">V Neck T-shirt</div>
                                                    <div class="tooplooks_box_desc_brand">Calida</div>
                                                    <div class="tooplooks_box_desc_price">$ 35.00</div>
                                                    <div class="tooplooks_box_desc_btn_cart"><a href="javascript:void(0);">Add to Cart</a></div>
                                                    <div class="tooplooks_box_desc_btn_checkout"><a href="javascript:void(0)">Check it out</a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box2_wrapper">
                                             <div class="box2">
                                                <a href="/guest/outfitdetails/498">
                                                    <img src="http://srs/files/products/715_1849192_AlanPaineAlbury1.jpg">
                                                </a>
                                            </div>
                                            <div class="tooplooks_box_hover">
                                                <div class="tooplooks_box_desc">
                                                    <div class="tooplooks_box_desc_type">V Neck T-shirt</div>
                                                    <div class="tooplooks_box_desc_brand">Calida</div>
                                                    <div class="tooplooks_box_desc_price">$ 35.00</div>
                                                    <div class="tooplooks_box_desc_btn_cart"><a href="javascript:void(0);">Add to Cart</a></div>
                                                    <div class="tooplooks_box_desc_btn_checkout"><a href="javascript:void(0)">Check it out</a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box3_wrapper">  
                                            <div class="box3">
                                                <a href="/guest/outfitdetails/498">
                                                    <img src="http://srs/files/products/870_7142481_navy west.png">
                                                </a>
                                            </div> 
                                            <div class="tooplooks_box_hover">
                                                <div class="tooplooks_box_desc">
                                                    <div class="tooplooks_box_desc_type">V Neck T-shirt</div>
                                                    <div class="tooplooks_box_desc_brand">Calida</div>
                                                    <div class="tooplooks_box_desc_price">$ 35.00</div>
                                                    <div class="tooplooks_box_desc_btn_cart"><a href="javascript:void(0);">Add to Cart</a></div>
                                                    <div class="tooplooks_box_desc_btn_checkout"><a href="javascript:void(0)">Check it out</a></div>
                                                </div>
                                            </div>
                                        </div>  
                                    </div> 
                                    <div class="right_box">
                                        <div class="box4_wrapper"> 
                                            <div class="box4">
                                            <!--shop button begins -->
                                                <div class="link-button">
                                                    <div class="shop-button">
                                                        <a href="/guest/outfitdetails/498">SHOP</a>              
                                                    </div>    
                                                </div>   
                                                <a href="/guest/outfitdetails/498">
                                                    <img src="http://srs/files/products/566_6890157_FriJays_Revised_-_T_S_grande.jpg">
                                                </a>
                                            </div>  
                                            <div class="tooplooks_box_hover">
                                                <div class="tooplooks_box_desc">
                                                    <div class="tooplooks_box_desc_type">V Neck T-shirt</div>
                                                    <div class="tooplooks_box_desc_brand">Calida</div>
                                                    <div class="tooplooks_box_desc_price">$ 35.00</div>
                                                    <div class="tooplooks_box_desc_btn_cart"><a href="javascript:void(0);">Add to Cart</a></div>
                                                    <div class="tooplooks_box_desc_btn_checkout"><a href="javascript:void(0)">Check it out</a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box5_wrapper"> 
                                            <div class="box5">
                                                <a href="/guest/outfitdetails/498">
                                                    <img src="http://srs/files/products/786_5725733_CitizensSidUltimateFront.jpg">
                                                </a>
                                            </div> 
                                            <div class="tooplooks_box_hover">
                                                <div class="tooplooks_box_desc">
                                                    <div class="tooplooks_box_desc_type">V Neck T-shirt</div>
                                                    <div class="tooplooks_box_desc_brand">Calida</div>
                                                    <div class="tooplooks_box_desc_price">$ 35.00</div>
                                                    <div class="tooplooks_box_desc_btn_cart"><a href="javascript:void(0);">Add to Cart</a></div>
                                                    <div class="tooplooks_box_desc_btn_checkout"><a href="javascript:void(0)">Check it out</a></div>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="text-content" style="float:left; width:100%; height:auto; text-align:left;">                        
                                        <span class="golden-heading">
                                            <div class="fb-like facebook-like fb_iframe_widget" data-href="http://srs/guest/outfitdetails/498" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false" fb-xfbml-state="rendered" fb-iframe-plugin-query="action=like&amp;app_id=507420839292016&amp;container_width=100&amp;href=http%3A%2F%2Fsrs%2Fguest%2Foutfitdetails%2F498&amp;layout=button_count&amp;locale=en_US&amp;sdk=joey&amp;share=false&amp;show_faces=false"><span style="vertical-align: bottom; width: 76px; height: 20px;"><iframe name="f39aaa1f5" width="1000px" height="1000px" frameborder="0" allowtransparency="true" allowfullscreen="true" scrolling="no" title="fb:like Facebook Social Plugin" src="http://www.facebook.com/v2.1/plugins/like.php?action=like&amp;app_id=507420839292016&amp;channel=http%3A%2F%2Fstatic.ak.facebook.com%2Fconnect%2Fxd_arbiter%2FQrU_tEEWym9.js%3Fversion%3D41%23cb%3Df15d38c018%26domain%3Dsrs%26origin%3Dhttp%253A%252F%252Fsrs%252Ff6eb4aa8%26relation%3Dparent.parent&amp;container_width=100&amp;href=http%3A%2F%2Fsrs%2Fguest%2Foutfitdetails%2F498&amp;layout=button_count&amp;locale=en_US&amp;sdk=joey&amp;share=false&amp;show_faces=false" style="border: none; visibility: visible; width: 76px; height: 20px;" class=""></iframe></span></div>
                                        </span>                        
                                                                                <p class="view-all">
                                            <span rel="498" style="cursor:pointer" class="golden-heading ">0 comments / view all</span>
                                        </p>
                                        <div>
                                            <div class="comment_append498 comment_view">
                                                                                            </div>
                                        </div>
                                        <form method="POST" class="comment_form send_comment">
                                            <input type="hidden" name="data[OutfitComment][outfit_id]" class="outfit_id" value="498">
                                            <input type="text" name="data[OutfitComment][comment]" class="comment_box input-post">
                                            <input class="post-submit submit_comment" value="POST" type="submit">
                                        </form>
                                    </div>
                                </li>
                                
                              




                                <!-- End Dummy Product Items-->
                            </ul>                            
                        </div>
                   <!--  </div>
                </div> -->
        
                <!-- /column -->
            </div>
        </section>
        <!-- /Top Outfits -->

        <!-- SignUp_Wrapper -->
        <div id="SignUp_Wrapper">
            <div class="center_row">
                <span>Want personalized looks minus the hassle and cost?</span>
                <a href="<?php echo $this->webroot; ?>users/register" class="btn_signUp">Sign Up</a>
            </div>
        </div>
        <!-- /SignUp_Wrapper -->
        <div id="three"></div>


        <!-- featuredStylists-Wrapper -->
        <div class="featuredStylists-Wrapper">
            <div class="center_row">
                <!-- Section_Main_Heading -->
                <div class="Section_Main_Heading">
                    <h1>OUR FASHION CONSULTANTS</h1>
                </div>
                <!-- /Section_Main_Heading -->

                <div style="position: relative;">
                    <div class="for_mobile_device">
                        <div class="multiple-items slider after-load">
                        <?php foreach($topStylists as $topstylist): ?>
                            <div>
                                <h3>
                                    <a title = "<?php echo $topstylist['User']['first_name'].' '.$topstylist['User']['last_name']; ?>" href="<?php echo $this->webroot; ?>stylists/stylistbiography/<?php echo $topstylist['User']['id']; ?>?refer=<?php echo $topstylist['User']['id']; ?>">
                                    
                                    <?php if($topstylist['User']['profile_photo_url']): ?>
                                    <img src="<?php echo HTTP_ROOT; ?>files/users/<?php echo $topstylist['User']['profile_photo_url']; ?>"  />                      
                                    <?php else: ?>
                                    <img src="<?php echo HTTP_ROOT; ?>images/default-user.jpg"  />                       
                                    <?php endif; ?>
                                    <span class="hover_part">
                                    <span class="get_started" style="" >GET STARTED</span>
                                        <!-- <a href="#">Get Started</a> -->
                                        <span style="display:block;">with <?php echo $topstylist['User']['first_name'].' '.$topstylist['User']['last_name']; ?></span>
                                    </span>
                                    </a>
                                </h3>
                            </div>
                        <?php endforeach; ?>    
                        </div>
                    </div>
                    <!-- <div class="last_slide">
                        <a href="/stylists"><img src="<?php echo HTTP_ROOT ?>img/home/see_all_stylists.jpg" /> <span class="btn_seeAllStylists">See All Fashion Consultants</span></a>
                    </div> -->
                </div>
            </div>
        </div>
        <!-- /featuredStylists-Wrapper -->



        <div id = "nine9"></div>
        <!-- three_steps_wrapper -->
        <div class="three_steps_wrapper">
            <div class="center_row">
            
                <!-- Section_Main_Heading -->
                <div class="Section_Main_Heading">
                    <h1>How it Works</h1>
                    <span style="font-size: 17px;line-height: normal;font-weight: normal;font-family: 'Open sans';">Our goal is to make your shopping experience as seamless as possible.</span>
                </div>
                <!-- /Section_Main_Heading -->

                <!-- Steps_Section -->
                <div class="Steps_Section">
                    
                    <!-- column -->
                    <div class="column">
                        <a href="#"><img src="<?php echo HTTP_ROOT ?>img/home/step1.jpg" /></a>
                        <h2>Get started with your fashion consultant</h2>
                        <span>&nbsp;</span>
                        <p>Sign Up, fill out your style profile & connect with your fashion consultant however you please: phone, Skype, email or in-person</p>
                    </div>
                    <!-- /column -->

                    <!-- column -->
                    <div class="column">
                        <a href="#"><img src="<?php echo HTTP_ROOT ?>img/home/step2.jpg" /></a>
                        <h2>Review your hand-selected looks</h2>
                        <span>&nbsp;</span>
                        <p>Your fashion consultant handpicks items tailored to your lifestyle, body shape, coloring, likes, needs and personal taste</p>
                    </div>
                    <!-- /column -->

                    <!-- column -->
                    <div class="column">
                        <a href="#"><img src="<?php echo HTTP_ROOT ?>img/home/step3.jpg" /></a>
                        <h2>Have it all delivered to your door</h2>
                        <span>&nbsp;</span>
                        <p>Order only the items you want and have them delivered to your door free of charge</p>
                    </div>
                    <!-- /column -->

                </div>
                <!-- /Steps_Section -->
            </div>
        </div>
        <!-- /three_steps_wrapper -->
        <div id="four"></div>
        <!-- blog_wrapper -->

        <div class="blog_wrapper">
            <div class="center_row">
                <!-- Section_Main_Heading -->
                <div class="Section_Main_Heading">
                    <h1>the <span>blog</span></h1>
                </div>
                <!-- /Section_Main_Heading -->

                <!-- row -->
                <div class="row">
                <?php foreach($posts as $post) {?>
                    <a href="<?= $post['Blog']['link'] ?>">    
                        <div class="column">
                            <img src="<?php echo HTTP_ROOT.'files/blog/'.$post['Blog']['image']; ?>" alt="" />
                        <span><?php echo String::truncate($post['Blog']['title'],35,array('ellipsis' => '  ...  ','exact' => false  ));?></span>
                        </div>
                    </a>
                <?php } ?>
                </div>
                <!-- /row -->
            </div>
        </div>
        <!-- /blog_wrapper -->


    </div>
    <!-- /Wrapper -->

    <script>
    /*-----Outfit comment submit start-------*/
    
    $('.comment_form').submit(function(e){
        e.preventDefault();
    });
    $('.submit_comment').click(function(e){
        //e.preventDefault();
        var cmnt = $(this).prev('.comment_box').val().trim();
        var data = $(this).parent('form').serialize();
        var user = '<?php echo $user['User']['full_name']; ?>';
        var outfit_id = $(this).parent().children('.outfit_id').val();
        var pre_mod = '<?= PRE_MOD ?>';
        if(user == ''){
            user = 'Guest';
        }

        var apnd = '<span class="golden-heading">'+user+'</span> says: '+cmnt+'<br>';
        if(cmnt){
            $.ajax({
                url : '/comments/add_comment',
                type: 'POST',
                data : data,
                success: function(res){
                    if(res=='success'){
                        if(pre_mod != 1){
                            $('.comment_append'+outfit_id).prepend(apnd);
                        }

                    }
                }
            });
            $(this).prev('.comment_box').val('');
        }
    });
    /*-----Outfit comment submit end-------*/


</script>
