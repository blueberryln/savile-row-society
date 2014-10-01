<?php
// $script='
//     jQuery(document).ready(function(){
//         jQuery("#menu-switcher").on("click", function(){  
//             jQuery(this).toggleClass("menu-anim");          
//             var menu = jQuery(".header .menu");
//             jQuery(menu).slideToggle();  
//         });
//     });
// ';
// $this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
?>

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("#menu-switcher").on("click", function(){  
            jQuery(this).toggleClass("menu-anim");          
            var menu = jQuery(".header .menu");
            jQuery(menu).slideToggle();  
        });
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

        <!--Log In Menu-->
        <div class="card-menu right">
            <ul>
               <!-- <?php
                if (!$is_logged) {
                    echo ' <li><a href="#" onclick="window.ref_url=\'\'; signUp();">Join</a></li> ';
                    echo ' <li><a href="#" onclick="window.ref_url=\'\'; signIn();">Sign In</a> </li> ';
                } else {
                    echo ' <li><a href="' . $this->request->webroot . 'cart' . '" id="basket-link">Basket</a>
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
                    echo ' <li><a class="get-stated btn" href="#" onclick="window.ref_url=\'\'; signUp();">Get Started</a></li> ';
                    
                } else {
                ?>
                    <!-- <?php if($user) : ?>
                        <li class="welcome-name"><a>Welcome <?php echo $user['User']['first_name']; ?></a></li>
                    <?php endif; ?> -->
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

       
        
        <span id="menu-switcher"><!-- &#8801; --><img src="<?php echo $this->webroot; ?>img/menu-switcher-icon.png" /></span>
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
         <?php if($user) : ?>
                        <span class="welcome-name">Welcome <?php echo $user['User']['first_name']; ?></span>
                <?php endif; ?>
        

    </div>   
</div>


<?php //if($is_stylist): ?>
<div class="content-container">
     <?php if($user) : ?>
    <div class="twelve columns black">
        <div class="eleven columns container">
           
            <div class="twelve columns container left ">
                <div class="ten columns left admin-nav">
                    <ul>
                    <?php if ($is_stylist || $is_admin ) : ?>
                        <li><a href="<?php echo $this->request->webroot; ?>messages/sales" title="">My Clients</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>messages/feed">Dashboard</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>messages/myoutfits">My outfits</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>messages/closet">The CLoset</a></li>
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
                                    <?php if ($is_admin) : ?>
                                    <li><a href="<?php echo $this->request->webroot; ?>admin">Administration</a></li>
                                    <?php endif; ?>
                                    <?php if ($is_stylist) : ?>
                                    <li><a href="<?php echo $this->request->webroot; ?>stylists/biography/<?php echo $user['User']['id']; ?>" title="">Stylist Biography</a></li>
                                    <li><a href="#" title="">refer a friend</a></li>
                                    <?php endif; ?>
                                     <?php if(!$is_stylist) : ?>
                                    <li><a href="<?php echo $this->request->webroot; ?>cart" title="">view my cart/checkout</a></li>
                                    <li><a href="#" title="">refer a friend</a></li>
                                    <li><a href="<?php echo $this->request->webroot; ?>users/profile/<?php echo $user['User']['id']; ?>">Style Profile</a></li>
                                    <li><a href="<?php echo $this->request->webroot; ?>messages/profiles/<?php echo $user['User']['id']; ?>">Profile</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo $this->request->webroot; ?>signout" title="">sign out</a></li>
                                </ul>
                            </div>
                        </li>

                    </ul>    
                </div>
           
            </div>
    </div>
      <?php endif;?>   
    </div>
<?php //endif; ?>
