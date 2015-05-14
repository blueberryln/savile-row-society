<script type="text/javascript">
  $(document).ready(function(){
    $('.menu_switcher').on('click', function(){
      $(this).addClass('opened');    
      $('body').toggleClass('of-toggle');
      $(".wrapper_mobile").toggleClass('show'); 
      $('.container_wrapper,#header_wrapper .header_center_row .logo_details').toggleClass('menu-show'); 
      $('#header_wrapper .header_center_row .top_icons').toggleClass('cart-right');
    });
    $(window).on('resize load', function(){
      if($(window).width() >= 752){
        $('.menu_switcher').removeClass('opened');
        $('body').removeClass('of-toggle');
        $(".wrapper_mobile").removeClass('show');
        $('.container_wrapper,#header_wrapper .header_center_row .logo_details').removeClass('menu-show'); 
        $('#header_wrapper .header_center_row .top_icons').removeClass('cart-right');
        slickDim();
      }
    });
  });
  function slickDim(){
    var xCont = jQuery('.slick-slide');
    var x = xCont.width();
    jQuery('.slick-slide').height(x);
    var y = jQuery('.slick-slide').outerWidth();
    var z = jQuery('.slick-slide').outerHeight()
    jQuery('.last_slide').css({'width':y, 'height':z});
  }

    $(document).ready(function(){
      $(window).scroll(function () {
        var x = $(this).scrollTop();
        if(x<=30)
        {
           $('.promotionalBar').show();
           $('#header_wrapper').removeClass('header_bar');
           $('.menu_switcher').removeClass('scrolled');
        }
        else
        {
          $('.promotionalBar').hide();
          $('#header_wrapper').addClass('header_bar');
          $('.menu_switcher').addClass('scrolled');
        }
      });
    });

    jQuery(document).ready(function(){
        jQuery("#menu-trigger").on("click", function(){
            var menu = jQuery(".header_wrapper .mobile_nav");
            jQuery(menu).slideToggle();  
        });
    });
    jQuery(document).ready(function(){
      jQuery("a.notifications").on("hover", function(){
        jQuery(".notification_dropdown").show().siblings('.dropdown_wrapper').hide();
      });
      jQuery(".icon_cross, body").on("click", function(){
        jQuery(".notification_dropdown").hide();
      });
      jQuery("a.cart").on("hover", function(e){
         
        jQuery(".cart_dropdown").show().siblings('.dropdown_wrapper').hide();
      });
      jQuery(".icon_cross, body").on("click", function(){
        jQuery(".cart_dropdown").hide();
      });
      jQuery('.cart_dropdown .content_section').click(function(e){
          e.stopPropagation();
         return false;
      });
      jQuery("a.my-account").on("hover", function(){
        jQuery(".myAccount_dropdown").show().siblings('.dropdown_wrapper').hide();
      });
      jQuery(".icon_cross, body").on("click", function(){
        jQuery(".myAccount_dropdown").hide();
      });
      jQuery(window).resize(function(){
        jQuery(".dropdown_wrapper").hide();
      });
    });


    $(document).ready(function(){
      $('.latest_news').carouFredSel({
        direction: 'up',
        prev: '#prev_item',
        next: '#next_item',
        auto: false,
        scroll: 3,
        items: 3,
        circular: false,
      });
    });

  </script>
  <?php if ($is_stylist){ ?>
  <style>
  .blank-space{padding-top:100px !important;}
.container{padding-bottom: 0px !important;}
.stylistbio-section{margin-top: 138px !important;}
#banner_wrapper{margin-top:142px !important;}
.rightImages{margin-top:142px !important;}

  </style>

  <?php } ?>

        <!--Mobile menu wrapper-->
        <div class="wrapper_mobile">
            <!-- mobile_menu_wrapper -->
            <div class="mobile_menu_wrapper">
              <ul>
                <?php if(empty($user)){ ?>
                <li><a href="javascript:void(0)" onclick="window.ref_url=''; signIn();">Sign In</a></li>
                <li><a href="/users/register">Sign Up</a></li>
                <?php } else { ?>
                <li><a href="/user/profile">My Account</a></li>
                <li><a href="/signout">Sign Out</a></li>
                <?php } ?>
                <span>&nbsp;</span>
                <li><a href="/#two">Shop</a></li>
                <li><a href="/#three">Stylist</a></li>
                <li><a target="_blank" href="http://www.savilerowsociety.com/blog/">Blog</a></li>
                <span>&nbsp;</span>
                <li><a target="_blank" href="https://instagram.com/savilerowsociety">Instagram</a></li>
                <li><a target="_blank" href="https://www.facebook.com/SavileRowSociety">Facebook</a></li>
                <li><a target="_blank" href="https://twitter.com/SRSocietydotcom">Twitter</a></li>
                <span>&nbsp;</span>
                <li><a href="#">Vip Access</a></li>
                <span>&nbsp;</span>
                <li><a href="<?php echo $this->webroot; ?>#two">About Us</a></li>
                <li><a href="<?php echo $this->request->webroot; ?>company/team">Our Team</a></li>
                <li><a href="<?php echo $this->request->webroot; ?>company/brands">Our Brands</a></li>
                <span>&nbsp;</span>
                <li><a href="#">Sign Up For Savil.Me News</a></li>
              </ul>
            </div>
            <!-- /mobile_menu_wrapper -->

            <!-- menu_switcher -->
            <a href="#" class="menu_switcher"><img src="<?php echo HTTP_ROOT ?>img/home/icon_menu_switcher.jpg" alt="Menu" /></a>
            <!-- /menu_switcher -->

        </div>
        <!-- header -->
        <header id="header_wrapper">
            
            <!-- promotionalBar -->
            <div class="promotionalBar">
                Free Delivery & Returns on ALL Orders | Call Us <a href="tel:+13478787280">+1 347 878 7280</a>
            </div>
            <!-- /promotionalBar -->

            <div class="center_row">
                <!-- logo_details -->   
                <div class="logo_details">
                    <a href="/"><img src="<?php echo HTTP_ROOT ?>img/srs_logo_new.png" alt="Savil.Me" /></a>
                </div>
                <!-- /logo_details -->  

                <!-- top_icons -->
                <div class="top_icons">
                    <ul class="social_icon_list">
                        <li><a target="_blank" href="https://instagram.com/savilerowsociety" class="instagram">instagram</a></li>
                        <li><a target="_blank" href="https://www.facebook.com/SavileRowSociety" class="facebook">facebook</a></li>
                        <li><a target="_blank" href="https://twitter.com/SRSocietydotcom" class="twitter">twitter</a></li>
                    </ul>

                    <!-- notification_dropdown -->
                    <div class="notification_dropdown dropdown_wrapper">

                      <!-- pointer -->
                      <div class="pointer">
                        <img src="<?php echo HTTP_ROOT ?>img/home/icon_dropdown_pointer.jpg" alt="^" />
                      </div>
                      <!-- /pointer -->

                      <!-- Heading -->
                      <div class="heading_section">
                        Looking for style? <a href="#" class="icon_cross TextReplaceByImage">X</a> 
                      </div>
                      <!-- /Heading -->

                      <!-- content_section -->
                      <div class="content_section">
                        Our Personal Stylists are here to help. <br />
                        Chat with a stylists now!.
                        <a href="#" class="stylist_profile_icon"><img src="<?php echo HTTP_ROOT ?>img/home/stylist_profile_icon.png" alt="Stylists" /></a>

                        <!-- <a href="/messages/index" class="btn_chat_now">Chat Now</a> <br /><br />
                        Call Us <span><a href="tel:+13478787280">+1 347 878 7280</a></span> -->

                        <a <?php if(!empty($user)) {?>href="/messages/index" <?php } else {?> href="javascript:void(0)" onclick="window.ref_url=''; signIn();" <?php } ?> class="btn_chat_now">Chat Now</a> <br /><br />
                        Call Us <span><a href="tel:+13478787280">+1 347 878 7280</a></span>

                      </div>
                      <!-- /content_section -->

                      <!-- bottom_section -->
                      <div class="bottom_section">
                      <?php if(empty($user)) {?>
                      Don't have an account? <a href="/users/register">Sign up for Free</a>
                      <?php } ?>
                      </div>
                      <!-- /bottom_section -->
                    </div>
                    <!-- /notification_dropdown -->

                    <!-- cart_dropdown -->
                    <div class="cart_dropdown dropdown_wrapper">
                      <!-- pointer -->
                      <div class="pointer">
                        <img src="<?php echo HTTP_ROOT ?>img/home/icon_dropdown_pointer.jpg" alt="^" />
                      </div>
                      <!-- /pointer -->
                      <!-- Heading -->
                      <div class="heading_section">
                        <?php
                        $count =0;
                         echo $count = count(@$cart_user) > count(@$cart_guest) ? count(@$cart_user) : count(@$cart_guest)  ?> Items <a href="#" class="icon_cross TextReplaceByImage">X</a> 
                      </div>
                      <!-- /Heading -->
                      <!-- content_section -->
                      <div class="content_section" style="margin-bottom: 0px;">
                         
                      <?php if(empty($cart_user) && empty($cart_guest)){?>
                        <br />Your shopping cart <br />
                        is empty... <br /> <br /><br />
                      <?php } ?>

                      <div class="caroufredsel_wrapper" style="<?php if(empty($cart_user) && empty($cart_guest)){ echo 'display: none';} ?>">
                        <ul class="latest_news">
                        <?php if(!empty($cart_user) && !empty($user) && $count) { ?>
                          <?php foreach($cart_user as $cart_list) { ?>
                          <li>

                              <a href="/messages/outfitdetails/<?php echo $cart_list['CartItem']['outfit_id'] ?>"><img src="<?php echo HTTP_ROOT.'files/products/'.$cart_list['Entity']['Image']['0']['name']; ?>" alt="<?php echo $cart_list['Product']['name'] ?>" /></a>
                              <span>
                                <?php echo $cart_list['Entity']['Product']['Brand']['name'].' : '.$cart_list['Entity']['name']; ?> <br /><br />
                                Qty: <?php echo $cart_list['CartItem']['quantity'] ?><br />
                                Size: <?php echo $size[$cart_list['CartItem']['size_id']] ?><br /><br />
                                $<?php echo $cart_list['Entity']['price']; ?>
                              </span>
                          </li>
                          <?php } ?>
                        <?php } else if(!empty($cart_guest) && empty($user) && $count) { ?>
                          <?php foreach($cart_guest as $cart_list) { ?>
                            <li>
                                <a href="/guest/outfitdetails/<?php echo $cart_list['CartItem']['outfit_id'] ?>"><img src="<?php echo HTTP_ROOT.'files/products/'.$cart_list['ProductsImage']['0']['name']; ?>" alt="<?php echo $cart_list['Product']['name'] ?>" /></a>
                                <span>
                                  <?php echo $cart_list['Product']['Brand']['name'].' : '.$cart_list['ProductsEntity']['name']; ?> <br /><br />
                                  Qty: <?php echo $cart_list['CartItem']['quantity'] ?><br />
                                  Size: <?php echo $size[$cart_list['CartItem']['size_id']] ?><br /><br />
                                  $<?php echo $cart_list['ProductsEntity']['price']; ?>
                                </span>
                            </li>
                          <?php } ?>
                        <?php } ?>
                        </ul>
                        </div>
                        <?php if($count > 1){ ?>
                        <a href="#" title="Next" id="next_item">Next</a>
                        <a href="#" title="Previous" id="prev_item">Previous</a>
                        <?php } ?>


                      </div>
                      <!-- /content_section -->


                        <!-- bottom_buttons_area -->
                        <div class="bottom_buttons_area" style="margin-bottom: 12px;">
                          <a href="<?php if(!empty($user)){echo "/cart"; } else{ echo "/guest/cart"; } ?>" class="viewCart">View Cart</a>
                          <?php if($count > 0){ ?>
                          <a href="<?php if(!empty($user)){echo "/checkout"; } else{ echo "/guest/cart"; } ?>" class="proceeToPurchase">Proceed To Purchase</a>
                          <?php } ?>
                        </div>
                        <!-- /bottom_buttons_area -->





                      <!-- bottom_section -->
                      <div class="bottom_section">
                      Free Delivery & Returns on ALL Orders| Call Us <span><a href="tel:+13478787280">+1 347 878 7280</a></span>
                      </div>
                      <!-- /bottom_section -->
                    </div>
                    <!-- /cart_dropdown -->


                    <!-- myAccount_dropdown -->
                    <div class="myAccount_dropdown dropdown_wrapper">

                      <!-- pointer -->
                      <div class="pointer">
                        <img src="<?php echo HTTP_ROOT ?>img/home/icon_dropdown_pointer.jpg" alt="^" />
                      </div>
                      <!-- /pointer -->

                      <!-- Heading -->
                      <div class="heading_section">
                       <?php if(!$user) {?>
                        My Account 
                      <?php } else{
                        echo 'Hello '.$user['User']['first_name'].'!';
                        } ?><a href="#" class="icon_cross TextReplaceByImage">X</a> 
                      </div>
                      <!-- /Heading -->

                      <!-- content_section -->
                      <?php if($user){?>
                      <div class="content_section">
                        <?php if ($is_stylist) { ?>
                        <a href="<?php echo $this->request->webroot; ?>stylists/biography/<?php echo $user['User']['id']; ?>" title="Stylist Biography">Stylist Biography</a>
                        <a href="/refer-a-friend">Refer A Friend</a>
                        <?php }else if ($is_admin) { ?>
                          <a href="<?php echo $this->request->webroot; ?>admin">Administration</a>
                        <?php } else { ?>
                        <a href="#">My Orders</a>
                        <a href="/user/profile">Account Details</a>
                        <a href="/refer-a-friend">Refer A Friend</a>
                        <?php } ?>
                      </div>
                      <div class="bottom_section">
                        <a href="/signout">Sign Out</a>
                      </div>
                      <?php } else{ ?>
                      <!-- /content_section -->
                      <div class="content_section">
                        <a href="javascript:void(0)" onclick="window.ref_url=''; signIn();">Sign In</a>
                        <a href="/users/register">Get Started</a>
                      </div>
                      <div class="bottom_section">
                        
                      </div>
                      <?php } ?>
                      
                    </div>
                    <!-- /myAccount_dropdown -->



                    <ul class="last">
                        <li><a href="#" class="notifications">notifications</a></li>
                        <?php if(!$user):?>
                        <li><a href="<?php echo $this->request->webroot; ?>guest/cart" class="cart">cart</a></li>
                        <?php else:?>
                        <li><a href="<?php echo $this->request->webroot; ?>cart" class="cart">cart</a></li>
                        <?php endif;?>
                        <li><a href="javascript:void(0)" class="my-account">My Account</a></li>
                    </ul>
                </div>
                <!-- /top_icons -->
                <!-- nav -->
                <div class="nav_wrapper">
                    <ul>
                        <!-- <li><a href="/#two">Shop</a></li>
                        <li><a href="/#three">Stylists</a></li> -->
                        <li><a href="/">Home</a></li>
                        <li><a class="tell-me-more" href="/#nine9">About</a></li>
                        <li><a target="_blank" href="http://www.savilerowsociety.com/blog/">Blog</a></li>
                        <li><a class="fashion"  href="/stylists">Fashion Consultants</a></li>
                    </ul>
                </div>
                <!-- /nav -->
            </div>
            <div class="content-container-header">
            <?php if ($is_stylist) : ?>
            <div class="twelve columns black">
                <div class="eleven columns container">
                   <div class="twelve columns container left pad-none">
                        <div class="ten columns left admin-nav">
                            <ul>
                            <?php if ($is_stylist) : ?>
                                <li><a href="<?php echo $this->request->webroot; ?>messages/sales" title="">My Clients</a></li>
                                <li><a href="<?php echo $this->request->webroot; ?>messages/feed">Dashboard</a></li>
                                <li><a href="<?php echo $this->request->webroot; ?>messages/myoutfits">My outfits</a></li>
                                <li><a href="<?php echo $this->request->webroot; ?>stylists/closet">The Closet</a></li>
                            <?php endif; ?>
                            </ul>
                        </div>
                        
                        <div class="two columns right admin-top-right">
                            <ul>
                               
                                <li> 
                                    <a href="#" title=""><span class="client-nav-switcher"><img src="<?php echo $this->webroot; ?>images/menu-dropdown-icon.png" alt="" /></span></a>
                                    <div class="admin-top-right-dropdown">
                                        <ul>
                                            <?php if ($is_stylist) : ?>
                                                <li class="m-ver-dd-menu"><a href="<?php echo $this->request->webroot; ?>messages/sales" title="">My Clients</a></li>
                                                <li class="m-ver-dd-menu"><a href="<?php echo $this->request->webroot; ?>messages/feed">Dashboard</a></li>
                                                <li class="m-ver-dd-menu"><a href="<?php echo $this->request->webroot; ?>messages/myoutfits">My outfits</a></li>
                                                <li class="m-ver-dd-menu"><a href="<?php echo $this->request->webroot; ?>stylists/closet">The CLoset</a></li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </li>

                            </ul>    
                        </div>
                   
                    </div>
            </div>
         
            <?php endif;?>   

        </div>
      </div>
    </header>
        <!-- /header -->
<script>
var if_clik =0;

$(document).on('click','.checkfblogin',function(){
var if_clik =1;
//alert(if_clik);
});
<?php //if(!$user) { ?>

  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      //document.getElementById('status').innerHTML = 'Please log ' +'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
     // document.getElementById('status').innerHTML = 'Please log ' + 'into Facebook.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '507420839292016',  //1537568826493647
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.1' // use version 2.1
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
     // alert(JSON.stringify(response)); 
     if(if_clik==1) {
      location.href = '/connect/facebook';
      console.log('Successful login for: ' + response.name);
    }
      //document.getElementById('status').innerHTML = 'Thanks for logging in, ' + response.name + '!';
    });
  }

<?php //} ?>
function fb_login(){
    FB.login(function(response) {

        if (response.authResponse) {
            console.log('Welcome!  Fetching your information.... ');
            //console.log(response); // dump complete info
            access_token = response.authResponse.accessToken; //get access token
            user_id = response.authResponse.userID; //get FB UID
            FB.api('/me', function(response) {
                user_email = response.email;  
                location.href = '/connect/facebook'; //get user email
          // you can store this data into your database             
            });

        } else {
            //user hit cancel button
            console.log('User cancelled login or did not fully authorize.');

        }
    }, {
        scope: 'publish_stream,email'
    });
}
/*(function() {
    var e = document.createElement('script');
    e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
    e.async = true;
    document.getElementById('fb-root').appendChild(e);
}());
*/

</script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("#menu-trigger").on("click", function(){  
            console.log("dfbghjdfghjdfd");
            // jQuery(this).toggleClass("mobile_menu");          
            var menu = jQuery(".header_wrapper .mobile_nav");
            jQuery(menu).slideToggle();  
        });
    });

    $(document).on('click','.welcome-name',function(){  
        $('.hoverNav').toggle();
  });
  $('html').click(function() {
$('.hoverNav').fadeOut(10);
});

  $(document).ready(function(){
    $(".shop-outfit-bottom ul li").hover(function() { 
        $(this).children('span').fadeIn();
            }, function() {
        $(this).children('span').fadeOut();
    });   
  });

 </script> 