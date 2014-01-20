<?php
$script='
    jQuery(document).ready(function(){
        jQuery("#menu-switcher").on("click", function(){            
            var menu = jQuery(".header .menu");
            jQuery(menu).slideToggle();  
        });
    });
';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
?>


<div class="header">
    <div class="wrapper">
        <!--Log In Menu-->
        <div class="twelve columns card-menu">
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
                <li><a href="#" onclick="window.ref_url=''; signUp();"><img src="<?php echo $this->webroot; ?>img/cart.png" style="vertical-align: middle;" /> (<span class="cart-items-count"><?php echo $cart_items; ?></span>)</a></li>
                <?php
                    echo ' <li><a href="#" onclick="window.ref_url=\'\'; signUp();">Join</a></li> ';
                    echo ' <li><a href="#" onclick="window.ref_url=\'\'; signIn();">Sign In</a> </li> ';
                } else {
                ?>
                    <?php if($user) : ?>
                        <li class="welcome-name"><a>Welcome <?php echo $user['User']['first_name']; ?></a></li>
                    <?php endif; ?>
                <?php if(($has_stylist && !$is_admin) || $is_stylist) : ?>
                <li style="position: relative;"><a id="msg-notifications"><img src="<?php echo $this->webroot; ?>img/icon_alert.png" style="vertical-align: middle;" /> (<span id="total-notifications"><?php echo $message_notification['total']; ?></span>)</a>
                    <div class="submenu-container msg-notify-box <?php echo $is_stylist ? "stylist-notify-box" : ""; ?>">
                        <div class="submenu">
                            <div class="submenu-inner">
                                
                                <?php if(!$is_stylist) : ?>
                                    <a href="<?php echo $this->webroot; ?>messages/index/">
                                        <div class="msg-count left">
                                            <span><?php echo $message_notification['message']; ?></span><br />
                                            Messages
                                        </div>
                                        <div class="outfit-count right">
                                            <span><?php echo $message_notification['outfit']; ?></span><br />
                                            Outfits
                                        </div>
                                    </a>
                                <?php else : ?>
                                    <a href="<?php echo $this->webroot; ?>messages/index/">
                                        <div class="msg-count">
                                            <span><?php echo $message_notification['message']; ?></span><br />
                                            Messages
                                        </div>
                                    </a>    
                                <?php endif; ?>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                </li>
                <?php endif; ?>
                <li><a href="<?php echo $this->request->webroot; ?>cart"><img src="<?php echo $this->webroot; ?>img/cart.png" style="vertical-align: middle;" /> (<span class="cart-items-count"><?php echo $cart_items; ?></span>)</a></li>
                <li>
                    <a title="Account">My Account</a>
                    <div class="submenu-container">
                        <ul class="submenu">
                            <?php if ($is_admin) : ?>
                                <li><a href="<?php echo $this->request->webroot; ?>admin">Administration</a></li>
                            <?php endif; ?>
                            <li><a href="<?php echo $this->request->webroot; ?>cart">Cart (<span id="cart-items-count" class="headerMenu cart-items-count"><?php echo $cart_items; ?></span>) </a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>mycloset/liked" class="headerMenu">My Closet</a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>profile/about" class="headerMenu">Profile</a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>signout">Sign out</a></li>
                        </ul>
                    </div>
                </li>
                <?php
                }
                ?>

            </ul>
        </div>
        <!--Log In Menu Ends-->

        <!--Logo Section-->
        <div class="twelve columns text-center header-logo">
            <a href="<?php echo $this->request->webroot; ?>" style="display: inline-block;"><img class="logo" src="<?php echo $this->request->webroot; ?>img/srs_logo_white.png" alt="Savile Row Society" title="Savile Row Society" /></a>
            <!-- <span class="tagline" <?php echo (isset($page) && $page == "home") ? "style='visibility: visible'" : ""; ?> >Meet Your Personal Stylist Now!</span> -->
        </div>
        <!--Logo Section Ends-->
        
        <span id="menu-switcher">&#8801;</span>
        <!--Menu Section-->
        <div class="twelve columns alpha omega menu text-center">            
            <ul>                
                <li><a  href="<?php echo $this->request->webroot; ?>closet" data-ref="closet"><span class="underline1">The Closet</span></a></li>

                <?php if($is_logged && $has_stylist && !$is_stylist) : ?>
                    <li><a href="<?php echo $this->request->webroot; ?>messages/index/" class="headerMenu" data-ref="messages/index/"><span class="underline4">My Stylist</span></a>
                        <ul class="submenu">
                            <li><a href="<?php echo $this->request->webroot; ?>booking">My Tailor</a></li>
                        </ul>
                    </li>
                <?php elseif($is_stylist) : ?>
                    <li><a href="<?php echo $this->request->webroot; ?>messages/index/" class="headerMenu" data-ref="messages/index/"><span class="underline4">My Clients</span></a></li>
                <?php else : ?>
                    <li>  <a href="<?php echo $this->request->webroot; ?>profile/about">My Stylist</a>
                        <ul class="submenu">
                            <li><a href="<?php echo $this->request->webroot; ?>profile/about" class="headerMenu" data-ref="profile/about">Complete Style Profile</a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>booking" class="headerMenu" data-ref="booking">My Tailor</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                            
                <li ><a href="http://blog.savilerowsociety.com" data-ref="http://blog.savilerowsociety.com" target="_blank"><span>The Blog</span></a></li>
                
                
                <?php if($this->params['controller']=='pages' && $this->params['action']=='display'  && $this->params['pass'][0]=='home') : ?>
                <li class="last">
                    <span>Share:</span><a id="lnk-fb-share" href=""  data-ref="closet">share</a>
                </li> 
                <?php endif; ?>

            </ul>
        </div>
        <!--Menu Section Ends-->
        

    </div>   
</div>

