<script type="text/javascript">
  $(document).ready(function(){
    $('.menu_switcher').on('click', function(){    
      $(".wrapper_mobile").toggleClass('show');    
    });  
  });
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






