<script type="text/javascript">
  $(document).ready(function(){
    $('.menu_switcher').on('click', function(){    
      $(".wrapper_mobile").toggleClass('show');    
    });  
  });
 </script> 

  <script type="text/javascript">
    $(function(){
      SyntaxHighlighter.all();     
    });
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "slide",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });

    $(document).ready(function(){
      $(window).scroll(function () {
        var x = $(this).scrollTop();
        if(x<=30)
        {
           $('.promotionalBar').show();
           $('#header_wrapper').removeClass('header_bar');
        }
        else
        {
          $('.promotionalBar').hide();
          $('#header_wrapper').addClass('header_bar');
        }
      });
        
    });


  </script>

        
        <!-- header -->
        <header id="header_wrapper">
            
            <!-- promotionalBar -->
            <div class="promotionalBar">
                Free Delivery & Returns On ALL Orders | Call Us <span>+1 347 878 7280</span> 
            </div>
            <!-- /promotionalBar -->

            <div class="center_row">
                <!-- logo_details -->   
                <div class="logo_details">
                    <a href="/"><img src="<?php echo HTTP_ROOT ?>img/home/logo.jpg" alt="Savil.Me" /></a>
                </div>
                <!-- /logo_details -->  
                
                <div class="wrapper_mobile">
                    <!-- mobile_menu_wrapper -->
                    <div class="mobile_menu_wrapper">
                      <ul>
                        <li><a href="#">My Account</a></li>
                        <span>&nbsp;</span>
                        <li><a href="#">Shop</a></li>
                        <li><a href="#">Stylist</a></li>
                        <li><a href="#">Blog</a></li>
                        <span>&nbsp;</span>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Intagaram</a></li>
                        <span>&nbsp;</span>
                        <li><a href="#">Vip Access</a></li>
                        <span>&nbsp;</span>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Our Team</a></li>
                        <li><a href="#">Our Brands</a></li>
                        <span>&nbsp;</span>
                        <li><a href="#">Sign Up For Savil.Me News</a></li>
                      </ul>
                    </div>
                    <!-- /mobile_menu_wrapper -->

                    <!-- menu_switcher -->
                    <a href="#" class="menu_switcher"><img src="<?php echo HTTP_ROOT ?>img/home/icon_menu_switcher.jpg" alt="Menu" /></a>
                    <!-- /menu_switcher -->

                </div>




                <!-- top_icons -->
                <div class="top_icons">
                    <ul>
                        <li><a href="#" class="instagram">instagram</a></li>
                        <li><a href="#" class="facebook">facebook</a></li>
                        <li><a href="#" class="twitter">twitter</a></li>
                    </ul>
                    <ul class="last">
                        
                        <?php if(!$user):?>
                        <li><a href="<?php echo $this->request->webroot; ?>guest/cart" class="cart">cart</a></li>
                        <?php else:?>
                        <li><a href="#" class="notifications">notifications</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>cart" class="cart">cart</a></li>
                        <?php endif;?>
                        <li><a href="#" onclick="window.ref_url=''; signIn();" class="my-account">My Account</a></li>
                    </ul>
                </div>
                <!-- /top_icons -->
                <!-- nav -->
                <div class="nav_wrapper">
                    <ul>
                        <li><a href="#">Shop</a></li>
                        <li><a href="#">Stylists</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>
                <!-- /nav -->
            </div>
        </header>
        <!-- /header -->
<script>
var if_clik =0;

$(document).on('click','.checkfblogin',function(){
var if_clik =1;
//alert(if_clik);
});
<?php if(!$user) { ?>

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

<?php } ?>
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