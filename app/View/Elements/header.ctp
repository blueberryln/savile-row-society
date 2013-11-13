<?php
$script = '
$(document).ready(function(){

    var url = window.location.href;
    if(url.indexOf("/closet") != -1){
        $(".underline1").css("border-bottom","1px solid #ffffff");
    }
    else if(url.indexOf("/stylist") != -1){
        $(".underline2").css("border-bottom","1px solid #ffffff");
    }
    else if(url.indexOf("/booking") != -1){
        $(".underline3").css("border-bottom","1px solid #ffffff");
    }
    else if(url.indexOf("/messages") != -1){
        $(".underline4").css("border-bottom","1px solid #ffffff");
    }
});
';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
?>

<div class="header">
    <img class="p_code" src="<?php echo $this->webroot; ?>img/SRS_20.png" />
    

    <div class="container">

        <div class="sixteen columns card-menu">
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
                <?php if($has_stylist) : ?>
                <li style="position: relative;"><a id="msg-notifications"><img src="<?php echo $this->webroot; ?>img/icon_alert.png" style="vertical-align: middle;" /> (<span id="total-notifications"><?php echo $message_notification['total']; ?></span>)</a>
                    <div class="submenu-container msg-notify-box">
                        <div class="submenu">
                            <div class="submenu-inner">
                                <a href="<?php echo $this->webroot; ?>messages/index/">
                                <div class="msg-count">
                                    <span><?php echo $message_notification['message']; ?></span><br />
                                    Messages
                                </div>
                                <div class="outfit-count">
                                    <span><?php echo $message_notification['outfit']; ?></span><br />
                                    Outfits
                                </div>
                                </a>
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

        <div class="sixteen columns text-center header-logo" style="height: 65px;">

            <!--            <div class="banner"></div> -->
            <a href="<?php echo $this->request->webroot; ?>" style="display: inline-block;"><img class="logo" src="<?php echo $this->request->webroot; ?>img/srs_logo_white.png" alt="Savile Row Society" title="Savile Row Society" /></a>
        </div>
        <div class="sixteen columns alpha omega menu">
            <ul>
                
                <li><a  href="<?php echo $this->request->webroot; ?>closet" data-ref="closet"><span class="underline1">The Closet</span></a></li>
                <li>
                    <a href="<?php echo $this->request->webroot; ?>stylist" class="headerMenu" data-ref="stylist"><span class="underline2">My Stylist</span></a>
                     <?php if($is_logged && $has_stylist) : ?>
                        <!--ul class="submenu">
                            <li><a href="<?php echo $this->request->webroot; ?>messages/index/" class="headerMenu" data-ref="messages/index/">Style Suggestion</a></li>
                        </ul-->
                    <?php endif; ?>
                </li>
                <li>
                    <a href="<?php echo $this->request->webroot; ?>booking" class="headerMenu" data-ref="booking"><span class="underline3">My Tailor</span></a>
                </li>                
                <li ><a href="http://blog.savilerowsociety.com" data-ref="http://blog.savilerowsociety.com" target="_blank"><span>The Blog</span></a></li>
                
                <?php if($is_logged && $has_stylist) : ?>
                    <li><a href="<?php echo $this->request->webroot; ?>messages/index/" class="headerMenu" data-ref="messages/index/"><span class="underline4">Style Suggestion</span></a></li>
                <?php endif; ?>  
                
                <?php if($this->params['controller']=='pages' && $this->params['action']=='display'  && $this->params['pass'][0]=='home') : ?>
                <li class="last">
                    <span>Share:</span><a id="lnk-fb-share" href=""  data-ref="closet">share</a>
                </li> 
                <?php endif; ?>

            </ul>
        </div>
        <div id="signup-box-wrapper">
            <div id="signup-box" >
                <div>
                    <div style=" height: 60px;"><a href="#" id="closeSignUp"><i class="cancel" style="float:right;"></i></a></div>
                </div>
                <a class="signin-social" href="<?php echo $this->request->webroot; ?>connect/linkedin">Try us on with LinkedIn <img src="<?php echo $this->request->webroot; ?>img/linkedin-small-logo.png" /></a>
                <a class="signin-social" href="<?php echo $this->request->webroot; ?>connect/facebook">Try us on with Facebook <img src="<?php echo $this->request->webroot; ?>img/facebook-small-logo.png" /></a>

                <div class="separator" ><span>OR</span></div>

                <input type="text" class="signin-email" placeholder="YOUR EMAIL ADDRESS" id="enter-email"/>
                <br/>
                <a class="register" id="show-registration-popup" href="#">Enter</a>
                <br/>                
                <br/>
                Already a Member? 

                <a class="signin" id="show-signin-popup" href="#">Sign in</a>

                <!--<a class="register" href="<?php echo $this->request->webroot; ?>register">Sign up</a> -->
                <!-- <a class="register" id="show-registration-popup" href="#">Sign up</a> -->
                <!--<a class="signin" id="signin-box" href="<?php echo $this->request->webroot; ?>signin">Sign in</a>-->
                <!-- <a class="signin" id="show-signin-popup" href="#">Sign in</a> -->
            </div>
            
            <div id="presignup-box" style="display: none;">
                <div style="width:90%" class="container content">
                    <h1>Welcome to Savile Row Society!</h1>
                    <p class="sign-up-notice text-center">Thank you for visiting Savile Row Society. We are hard at work getting ready for our October launch. In the meantime, sign up now and you will receive a $30 credit toward your first Savile Row Society purchase! <br />
<strong>"Live a Tailored Life"</strong></p>
                </div>
                <br />
                <form action="<?php echo $this->request->webroot; ?>newusers" method="post" id="presignup-box-form">
                    <input type="text" class="signin-email" placeholder="YOUR EMAIL ADDRESS" id="enter-email" name="email" style="width: 88%;" />
                    <br />
                    <br />
                    <a class="register" id="btn-presignup" href="#">Submit</a>
                </form>
                <br/>                
                <br/>
                <br />
                <br />

                <!--<a class="register" href="<?php echo $this->request->webroot; ?>register">Sign up</a> -->
                <!-- <a class="register" id="show-registration-popup" href="#">Sign up</a> -->
                <!--<a class="signin" id="signin-box" href="<?php echo $this->request->webroot; ?>signin">Sign in</a>-->
                <!-- <a class="signin" id="show-signin-popup" href="#">Sign in</a> -->
            </div>
        </div>
        
        <!-- inside this element open signin view -->
        <div id="signin-popup" style="display: none">

        </div>
        <!-- inside this element open signin view (start signup wizard) -->
        <div id="signup-popup" style="display: none">

        </div>

        <div id="profile-popup" class="hide box-modal notification-box">
            <div class="box-modal-inside">
                <a class="notification-close" href=""></a>
                    <h5 class="welcome-srs">Welcome to savile row society!</h5> 
                    <div class="notification-msg">To be able to match you with one of our premier personal stylists, please complete this quick style profile.</div>                   
                    <div class="notification-buttons">
                        <a class="link-btn black-btn complete-style-btn" href="<?php echo $this->request->webroot; ?>profile/about">COMPLETE MY STYLE PROFILE</a>
                    </div>
                    <h6 class="popup-or">OR</h6>
                    <p>Check out our curated collection in <a href="<?php echo $this->request->webroot; ?>closet">The Closet</a> or book an appointment with our <a href="<?php echo $this->request->webroot; ?>booking">tailor</a>.</p>   
            </div>
        </div>
        
    </div>
</div>