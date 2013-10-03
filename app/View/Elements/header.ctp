
<div class="header">

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
                    echo ' <li><a href="#" onclick="window.ref_url=\'\'; signUp();">Join</a></li> ';
                    echo ' <li><a href="#" onclick="window.ref_url=\'\'; signIn();">Sign In</a> </li> ';
                } else {
                ?>
                <li>
                    <a title="Account">My Account</a>
                    <div class="submenu-container">
                        <ul class="submenu">
                            <?php if ($is_admin) : ?>
                                <li><a href="<?php echo $this->request->webroot; ?>admin">Administration</a></li>
                            <?php endif; ?>
                            <li><a href="<?php echo $this->request->webroot; ?>cart">Cart (<span id="cart-items-count" class="headerMenu"><?php echo $cart_items; ?></span>) </a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>closet/liked" class="headerMenu">My Closet</a></li>
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

        <div class="sixteen columns text-center header-logo" style="/*height: 75px;*/">

            <!--            <div class="banner"></div> -->
            <a href="<?php echo $this->request->webroot; ?>" style="display: inline-block;"><img class="logo" src="<?php echo $this->request->webroot; ?>img/srs_logo_white.png" alt="Savile Row Society" title="Savile Row Society" /></a>
        </div>
        <div class="sixteen columns alpha omega menu" style="margin-top: 10px; margin-bottom:20px;">
            <ul>
                
                <li><a href="<?php echo $this->request->webroot; ?>closet" data-ref="closet">The Closet</a></li> 
                <li>
                    <a href="<?php echo $this->request->webroot; ?>stylist" class="headerMenu" data-ref="stylist">My Stylist</a>
                </li>
                <li>
                    <a href="<?php echo $this->request->webroot; ?>booking" class="headerMenu" data-ref="booking">My Tailor</a>
                </li>                
                <li ><a href="http://blog.savilerowsociety.com" data-ref="http://blog.savilerowsociety.com">The Blog</a></li>
                <?php if($is_logged) : ?>
                    <li><a href="<?php echo $this->request->webroot; ?>messages/index/" class="headerMenu" data-ref="messages/index/">Chat</a></li>
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
        
        <div id="profile-popup" style="display: none;">
            <div style="width:430px;" class="container content">	
                <div class="text-center">
                    <h1>Welcome to Savile Row Society!</h1>
                    <p>To be able to match you with one of our premier personal stylists, please complete this quick style profile.</p>
                    <p><a href="<?php echo $this->request->webroot; ?>profile/about" class="text-center complete-profile">Complete my style profile</a></p>
                    <br />
                    <p>Or you can book an appointment with our <a href="<?php echo $this->request->webroot; ?>booking">tailor</a>, or check out our highlighted products in <a href="<?php echo $this->request->webroot; ?>closet">The Closet</a></p>
                </div>
            </div>
        </div>
    </div>
</div>