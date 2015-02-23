<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("#menu-switcher1").on("click", function(){  
            console.log("dfbghjdfghjdfd");
            // jQuery(this).toggleClass("mobile_menu");          
            var menu = jQuery(".header .mobile_menu");
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

<div class="header">
    <div class="wrapper">

        <!--LogoSection-->
        <div class="header-logo left">
            <a href="/" ><img class="logo" src="<?php echo HTTP_ROOT; ?>img/srs_logo_new.jpg" alt="Savile Row Society" title="Savile Row Society" /></a>
            <!-- <span class="tagline" <?php echo (isset($page) && $page == "home") ? "style='visibility: visible'" : ""; ?> >Meet Your Personal Stylist Now!</span> -->
        </div>
        <!--LogoSection Ends-->


        <!-- top_wrapper -->
        <div class="top_wrapper">
        <div id="menu-switcher1"><img src="<?php echo HTTP_ROOT; ?>img/menu-switcher-icon.png" /></div>
        <!-- mobile_menu -->
        
        <div class="mobile_menu">
            <ul>
            <?php if(!$user) : ?>
                <li><a href="<?php echo $this->webroot; ?>users/register" >Get Started</a></li>
                <li><a href="#" onclick="window.ref_url=''; signIn();">Sign In</a></li>
            <?php endif; ?>
                <li><a href="<?php echo $this->webroot; ?>#four">Looks</a></li>
                <li><a href="<?php echo $this->webroot; ?>#three">Stylists</a></li>
                <li><a href="<?php echo $this->webroot; ?>#two">How It Works</a></li>
            </ul>
        </div>
    
        <!-- /mobile_menu -->

        <!-- top_mainNav -->
        <div class="top_mainNav second-screen">
            <ul>
                <li><a href="<?php echo $this->webroot; ?>#four">LOOKS</a></li>
                <li><a href="<?php echo $this->webroot; ?>#three">STYLISTS</a></li>
                <?php if(!$user):?>
                <li><a href="<?php echo $this->webroot; ?>#two">HOW IT WORKS</a></li>
                <li><a href="<?php echo $this->webroot; ?>#six">BRANDS</a></li>
                <?php else: ?>
                
                <!-- <a class="shop-top-looks" href="Javascript:;">SHOP TOP LOOKS</a> -->
                <?php endif;?>

            </ul>
        </div>
        <!-- /top_mainNav -->

        <!-- top_rightSection -->
        <div class="top_rightSection <?php if($user){echo 'login_rightSection';}?>">
        <?php if(!$user):?>
            <a href="#" onclick="window.ref_url=''; signIn();" class="login">LOG IN</a>
            <a href="<?php echo $this->webroot; ?>users/register" class="getStarted">Get Started</a>
            <a href="<?php echo $this->request->webroot; ?>guest/cart" class="cart_link">(<span class="cart-items-count">
            <?php echo $cart_items; ?></span> )</a>
        <?php else:?>
            <a href="<?php echo $this->request->webroot; ?>cart" class="cart_link">(<span class="cart-items-count">
            <?php echo $cart_items; ?></span> )</a>
        <?php endif;?>
        <!--Log In Menu-->
        <div class="card-menu right">
            <ul>

                 <?php
                if (!$is_logged) {
                ?>
                <?php 
                    echo ' <li><a class="login btn" href="#" onclick="window.ref_url=\'\'; signIn();">Login</a> </li> ';
                    echo ' <li><a class="get-stated btn" href="/users/register">Get Started</a></li> ';
                    
                } else {
                ?>
                    <?php if($user) : ?>
                        <li class="welcome-name"><a href="Javascript:;">Hi <?php echo $user['User']['first_name']; ?></a></li>
                        <div class="hoverNav">
                            <ul>
                                  
                                    <?php if ($is_admin) : ?>
                                    <li><a href="<?php echo $this->request->webroot; ?>admin">Administration</a></li>
                                    <?php endif; ?>
                                    <?php if ($is_stylist) : ?>
                                    <li><a href="<?php echo $this->request->webroot; ?>stylists/biography/<?php echo $user['User']['id']; ?>" title="">Stylist Biography</a></li>
                                    <li><a href="/refer" title="">refer a friend</a></li>
                                    <?php endif; ?>
                                     <?php if(!$is_stylist) : ?>
                                    <li><a href="<?php echo $this->request->webroot; ?>cart" title="">view my cart/checkout</a></li>
                                    <li><a href="/messages/index" title="">Messages</a></li>
                                    <li><a href="<?php echo $this->request->webroot; ?>messages/profiles/<?php echo $user['User']['id']; ?>">Profile</a></li>
                                    <li><a href="/refer-a-friend" title="">refer a friend</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo $this->request->webroot; ?>signout" title="">sign out</a></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                <?php //if(($has_stylist && !$is_admin) || $is_stylist) : ?>
               <?php } ?>


            </ul>
        </div>
        <!--Log In Menu Ends-->

        
        
       
        
        <!-- <span id="menu-switcher"><img src="<?php echo HTTP_ROOT; ?>img/menu-switcher-icon.png" /></span> -->
        
        <!--Menu Section-->
        <div class="menu right">            
            <ul> <?php if(!$user) : ?>
                <li><a href="<?php echo $this->webroot; ?>#two" title="">About</a></li>
                <li><a href="<?php echo $this->webroot; ?>#three" title="">Stylists</a></li>
                <li><a href="<?php echo $this->webroot; ?>#four" title="">Outfits</a></li>
                <li><a href="<?php echo $this->webroot; ?>#five" title="">Style on your time</a></li>
                <li><a href="<?php echo $this->webroot; ?>#six" title="">Brands</a></li>
                <?php endif;  ?>
            </ul>
        </div>
    </div>   
</div>


<?php //if($is_stylist): ?>
<div class="content-container-header">
    <?php if($user) : ?>
    <div class="twelve columns black">
        <div class="eleven columns container">
           <div class="twelve columns container left pad-none">
                <div class="ten columns left admin-nav">
                    <ul>
                    <?php if ($is_stylist || $is_admin ) : ?>
                        <li><a href="<?php echo $this->request->webroot; ?>messages/sales" title="">My Clients</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>messages/feed">Dashboard</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>messages/myoutfits">My outfits</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>stylists/closet">The CLoset</a></li>
                    <?php endif; ?>
                    </ul>
                </div>
                
                <div class="two columns right admin-top-right">
                    <ul>
                       <li><a href="<?php echo $this->request->webroot; ?>cart"><img class="cart-icons" src="<?php echo HTTP_ROOT; ?>images/cart-icon.png" alt="" /> (<span class="cart-items-count"><?php echo $cart_items; ?></span>)</a></li>
                        <li> 
                            <a href="#" title=""><span class="client-nav-switcher"><img src="<?php echo HTTP_ROOT; ?>images/menu-dropdown-icon.png" alt="" /></span></a>
                            <div class="admin-top-right-dropdown">
                                <ul>
                                    <?php if ($is_stylist || $is_admin ) : ?>
                                        <li class="m-ver-dd-menu"><a href="<?php echo $this->request->webroot; ?>messages/sales" title="">My Clients</a></li>
                                        <li class="m-ver-dd-menu"><a href="<?php echo $this->request->webroot; ?>messages/feed">Dashboard</a></li>
                                        <li class="m-ver-dd-menu"><a href="<?php echo $this->request->webroot; ?>messages/myoutfits">My outfits</a></li>
                                        <li class="m-ver-dd-menu"><a href="<?php echo $this->request->webroot; ?>stylists/closet">The CLoset</a></li>
                                    <?php endif; ?>
                                    <?php if ($is_admin) : ?>
                                    <li><a href="<?php echo $this->request->webroot; ?>admin">Administration</a></li>
                                    <?php endif; ?>
                                    <?php if ($is_stylist) : ?>
                                    <li><a href="<?php echo $this->request->webroot; ?>stylists/biography/<?php echo $user['User']['id']; ?>" title="">Stylist Biography</a></li>
                                    <li><a href="/refer" title="">refer a friend</a></li>
                                    <?php endif; ?>
                                     <?php if(!$is_stylist) : ?>
                                    <li><a href="<?php echo $this->request->webroot; ?>cart" title="">view my cart/checkout</a></li>
                                    <li><a href="/messages/index" title="">Messages</a></li>
                                    <li><a href="<?php echo $this->request->webroot; ?>messages/profiles/<?php echo $user['User']['id']; ?>">Profile</a></li>
                                    <li><a href="/refer-a-friend" title="">refer a friend</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo $this->request->webroot; ?>signout" title="">sign out</a></li>
                                </ul>
                            </div>
                        </li>

                    </ul>    
                </div>
           
            </div>
    </div>
    <?php else: ?>
    <div class="twelve columns black">
        <div class="eleven columns container">
           <div class="twelve columns container left pad-none">
                <div class="two columns right admin-top-right">
                    <ul>
                        <li><a href="<?php echo $this->request->webroot; ?>guest/cart"><img class="cart-icons" src="<?php echo HTTP_ROOT; ?>images/cart-icon.png" alt="" /> (<span class="cart-items-count"><?php echo $cart_items; ?></span>)</a></li>
                    </ul>    
                </div>
           
            </div>
        </div>
    <?php endif;?>
    </div>
</div>
</div></div>
</div>

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
    appId      : '395602070536997',  //1537568826493647
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