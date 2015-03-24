<script type="text/javascript">
//     jQuery(document).ready(function(){
//         jQuery("#menu-trigger").on("click", function(){  
//             console.log("dfbghjdfghjdfd");
//             // jQuery(this).toggleClass("mobile_menu");          
//             var menu = jQuery(".header_wrapper .mobile_nav");
//             jQuery(menu).slideToggle();  
//         });
//     });

//     $(document).on('click','.welcome-name',function(){  
//         $('.hoverNav').toggle();
//   });
//   $('html').click(function() {
// $('.hoverNav').fadeOut(10);
// });

//   $(document).ready(function(){
//     $(".shop-outfit-bottom ul li").hover(function() { 
//         $(this).children('span').fadeIn();
//             }, function() {
//         $(this).children('span').fadeOut();
//     });   
//   });

 </script> 

  <script type="text/javascript">
    $(function(){
      //SyntaxHighlighter.all();     
    });
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "slide",
        start: function(slider){
          $('body').removeClass('loading');
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
                
                <!-- top_icons -->
                <div class="top_icons">
                    <ul>
                        <li><a href="#" class="instagram">instagram</a></li>
                        <li><a href="#" class="facebook">facebook</a></li>
                        <li><a href="#" class="twitter">twitter</a></li>
                    </ul>
                    <ul class="last">
                        <li><a href="#" class="notifications">notifications</a></li>
                        <li><a href="#" class="cart">cart</a></li>
                        <li><a href="#" class="my-account">My Account</a></li>
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






