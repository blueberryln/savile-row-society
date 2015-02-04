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
 </script> 

<div class="header">
    <div class="wrapper">

        <!--Logo Section-->
        <div class="header-logo left">
            <a href="/" ><img class="logo" src="<?php echo $this->request->webroot; ?>img/srs_logo_black.png" alt="Savile Row Society" title="Savile Row Society" /></a>
            <!-- <span class="tagline" <?php echo (isset($page) && $page == "home") ? "style='visibility: visible'" : ""; ?> >Meet Your Personal Stylist Now!</span> -->
        </div>
        <!--Logo Section Ends-->


        <!-- top_wrapper -->
        <div class="top_wrapper">
        <div id="menu-switcher1"><img src="<?php echo $this->webroot; ?>img/menu-switcher-icon.png" /></div>
        <!-- mobile_menu -->
        <?php if(!$user) : ?>
        <div class="mobile_menu">
            <ul>
                <li><a href="<?php echo $this->webroot; ?>users/register" class="active">Get Started</a></li>
                <li><a href="Javascript:;">Sign In</a></li>
                <li><a href="Javascript:;">Top Looks</a></li>
                <li><a href="Javascript:;">Stylists</a></li>
                <li><a href="Javascript:;">How It Works</a></li>
            </ul>
        </div>
    <?php endif; ?>
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
                <a class="shop-top-looks" href="Javascript:;">SHOP TOP LOOKS</a>
                <?php endif;?>

            </ul>
        </div>
        <!-- /top_mainNav -->

        <!-- top_rightSection -->
        <div class="top_rightSection <?php if($user){echo 'login_rightSection';}?>">
        <?php if(!$user):?>
            <a href="#" onclick="window.ref_url=''; signIn();" class="login">LOG IN</a>
            <a href="<?php echo $this->webroot; ?>users/register" class="getStarted">Get Started</a>
        <?php endif;?>
            <a href="<?php echo $this->request->webroot; ?>guest/cart" class="cart_link">(<span class="cart-items-count"><?php echo $cart_items; ?></span>)</a>
        <!--Log In Menu-->
        <div class="card-menu right">
            <ul>
               <!-- <?php
                if (!$is_logged) {
                    echo ' <li><a href="#" onclick="window.ref_url=\'\'; signUp();">Join</a></li> ';
                    echo ' <li><a href="#" onclick="window.ref_url=\'\'; signIn();">Sign In</a> </li> ';
                } else {
                    echo ' <li><a href="' . $this->request->webroot . 'cart' . '" id="basket-link">Basket</a
                                <div id="basket">
                    
                                </div>
                                </li> ';
                }
                ?> -->

                 <?php
                if (!$is_logged) {
                ?>
               <!-- <li><a href="#" onclick="window.ref_url=''; signUp();"><img class="cart-img" src="<?php echo $this->webroot; ?>img/cart-new.png" /> (<span class="cart-items-count"><?php echo $cart_items; ?></span>)</a></li>-->
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
                <?php if(($has_stylist && !$is_admin) || $is_stylist) : ?>
               


                <!-- <li style="position: relative;"><a id="msg-notifications"><img src="<?php echo $this->webroot; ?>img/icon_alert.png" style="vertical-align: middle;" /> (<span id="total-notifications"><?php echo $message_notification['total']; ?></span>)</a>
                    <div class="submenu-container msg-notify-box <?php echo $is_stylist ? "stylist-notify-box" : ""; ?>">
                        <div class="submenu">
                            <div class="submenu-inner">
                                
                                <?php if(!$is_stylist) : ?>
                                    <a href="<?php echo $this->webroot; ?>messages/index/" class="msg-count-cont">
                                        <div class="msg-count">
                                            <span><?php echo $message_notification['message']; ?></span> Messages
                                        </div>
                                    </a>
                                    <a href="<?php echo $this->webroot; ?>messages/index/">
                                        <div class="outfit-count">
                                            <span><?php echo $message_notification['outfit']; ?></span> Outfits
                                        </div>
                                    </a>
                                <?php else : ?>
                                    <a href="<?php echo $this->webroot; ?>messages/index/" class="msg-count-cont">
                                        <div class="msg-count">
                                            <span><?php echo $message_notification['message']; ?></span> Messages
                                        </div>
                                    </a>   
                                    <a href="<?php echo $this->webroot; ?>messages/index/">
                                        <div class="client-count">
                                            <span><?php echo $message_notification['clients']; ?></span> Clients
                                        </div>
                                    </a> 
                                <?php endif; ?>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                </li> -->
                <?php endif; ?>
                <!-- <li><a href="<?php echo $this->request->webroot; ?>cart"><img class="cart-img" src="<?php echo $this->webroot; ?>img/cart-new.png" /> (<span class="cart-items-count"><?php echo $cart_items; ?></span>)</a></li> -->
                <!-- <li>
                    <a title="Account" id="myaccount-drop">My Account</a>
                    <div class="submenu-container">
                        <ul class="submenu">
                            <?php if ($is_admin) : ?>
                                <li><a href="<?php echo $this->request->webroot; ?>admin">Administration</a></li>
                            <?php endif; ?>
                            <?php if ($is_stylist) : ?>
                                <li><a href="<?php echo $this->request->webroot; ?>users/editbiography/<?php echo $user['User']['id']; ?>">Stylist Biography</a></li>
                            <?php endif; ?>
                            
                            <li><a href="<?php echo $this->request->webroot; ?>cart">Cart (<span id="cart-items-count" class="headerMenu cart-items-count"><?php echo $cart_items; ?></span>) </a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>mycloset/liked" class="headerMenu">My Closet</a></li>
                            
                            <li>
                            <a href="<?php echo $this->request->webroot; ?>messages/userprofiles/<?php echo $user['User']['id']; ?>" class="headerMenu">Profile</a></li>
                        <li>    <a href="<?php echo $this->request->webroot; ?>users/profile/<?php echo $user['User']['id']; ?>" class="headerMenu">Style Profile</a></li>
                            
                            <li><a href="<?php echo $this->request->webroot; ?>refer-a-friend" class="headerMenu">Refer a friend</a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>signout">Sign out</a></li>
                        </ul>
                    </div>
                </li> -->
                <?php
                }
                ?>

            </ul>
        </div>
        <!--Log In Menu Ends-->

        
        
       
        
        <!-- <span id="menu-switcher"><img src="<?php echo $this->webroot; ?>img/menu-switcher-icon.png" /></span> -->
        
        <!--Menu Section-->
        <div class="menu right">            
            <ul> <?php if(!$user) : ?>
                <li><a href="<?php echo $this->webroot; ?>#two" title="">About</a></li>
                <li><a href="<?php echo $this->webroot; ?>#three" title="">Stylists</a></li>
                <li><a href="<?php echo $this->webroot; ?>#four" title="">Outfits</a></li>
                <li><a href="<?php echo $this->webroot; ?>#five" title="">Style on your time</a></li>
                <li><a href="<?php echo $this->webroot; ?>#six" title="">Brands</a></li>
                <?php endif;  ?>
                <!--<li><a  href="<?php echo $this->request->webroot; ?>closet" data-ref="closet"><span class="underline1">The Closet</span></a></li>

                <?php if($is_logged && $has_stylist && !$is_stylist) : ?>
                    <li><a href="<?php echo $this->request->webroot; ?>messages/index/" class="headerMenu" data-ref="messages/index/"><span class="underline4">My Stylist</span></a></li>
                <?php elseif($is_stylist) : ?>
                    <li><a href="<?php echo $this->request->webroot; ?>messages/index/" class="headerMenu" data-ref="messages/index/"><span class="underline4">My Clients</span></a></li>
                <?php elseif($is_logged) : ?>
                    <li>  <a href="<?php echo $this->request->webroot; ?>register/wardrobe">My Stylist</a></li>
                <?php else : ?>
                    <li>  <a href="#" onclick="window.ref_url=''; signUp();">My Stylist</a></li>
                <?php endif; ?>

                <?php if($is_logged && $has_stylist) : ?>
                    <li><a  href="<?php echo $this->request->webroot; ?>fitting-room" data-ref="closet"><span class="underline1">The Fitting room</span></a></li> 
                 <?php elseif($is_logged) : ?>
                    <li><a  href="<?php echo $this->request->webroot; ?>register/wardrobe" data-ref="closet"><span class="underline1">The Fitting room</span></a></li> 
                <?php else : ?>
                    <li><a href="#" onclick="window.ref_url=''; signUp();"><span class="underline1">The Fitting room</span></a></li> 
                <?php endif; ?>                           
                <li ><a href="http://blog.savilerowsociety.com" data-ref="http://blog.savilerowsociety.com" target="_blank"><span>The Blog</span></a></li>-->

            </ul>
        </div>
        <!--Menu Section Ends-->
        <!--<span class="call-us-at"><!-- <img src="<?php echo $this->webroot; ?>img/call-us.png" /> --><!--Call us at +1 347 878 7280</span>-->
         <!--<?php if($user) : ?>
                         <span class="welcome-name">Welcome <?php echo $user['User']['first_name']; ?></span> 
                <?php endif; ?>-->
        

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
                       <li><a href="<?php echo $this->request->webroot; ?>cart"><img class="cart-icons" src="<?php echo $this->webroot; ?>images/cart-icon.png" alt="" /> (<span class="cart-items-count"><?php echo $cart_items; ?></span>)</a></li>
                        <li> 
                            <a href="#" title=""><span class="client-nav-switcher"><img src="<?php echo $this->webroot; ?>images/menu-dropdown-icon.png" alt="" /></span></a>
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
                        <li><a href="<?php echo $this->request->webroot; ?>guest/cart"><img class="cart-icons" src="<?php echo $this->webroot; ?>images/cart-icon.png" alt="" /> (<span class="cart-items-count"><?php echo $cart_items; ?></span>)</a></li>
                    </ul>    
                </div>
           
            </div>
    </div>
    <?php endif;?>   
    
    </div>
</div>
</div></div></div>
