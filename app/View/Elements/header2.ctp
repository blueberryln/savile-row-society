
<div class="header">
    <div class="container">
        <div class="sixteen columns alpha omega menu">
            <!--<div class="welcome-note">Welcome to SRS</div>-->
            <!--<div class="card">-->
                <!--<div class="card-menu">-->
                    <ul>

                        <li><a href="#">Join</a></li>
                        <li><a href="#">Sign In</a> </li>

                    </ul>
                <!--</div>-->
            <!--</div>-->
           
        </div>
        <div class="sixteen columns" style="height: 60px;">
            
<!--            <div class="banner"></div> -->
            <a href="<?php echo $this->request->webroot; ?>"><img class="logo" src="<?php echo $this->request->webroot; ?>img/logo.png" alt="Savile Row Society" title="Savile Row Society" /></a>
        </div>
        <div class="sixteen columns alpha omega menu">
            <ul>
                <li>
                    <a href="<?php echo $this->request->webroot; ?>how-it-works" class="headerMenu">How it works</a>
                    <ul class="submenu">
                        <li><a href="<?php echo $this->request->webroot; ?>membership" class="headerMenu">Membership</a></li>
                    </ul>
                </li>
                <li><a href="<?php echo $this->request->webroot; ?>stylist" class="headerMenu">My Personal Stylist</a></li>
                <li>
                    <a href="<?php echo $this->request->webroot; ?>booking" class="headerMenu">Booking</a>
                    <!-- <ul class="submenu">
                        <li><a href="<?php echo $this->request->webroot; ?>booking" class="headerMenu">Booking</a></li>
                    </ul> -->
                </li>
                <li class="highlited"><a href="<?php echo $this->request->webroot; ?>closet" class="headerMenu">The Closet</a></li>
                <li>
                    <a href="<?php echo $this->request->webroot; ?>company" class="headerMenu">Our Company</a>
                    <ul class="submenu">
                        <li><a href="<?php echo $this->request->webroot; ?>company/team" class="headerMenu">Our Team</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>company/bloggers" class="headerMenu">Our Bloggers</a></li>
                        <li><a href="<?php echo $this->request->webroot; ?>company/brands" class="headerMenu">Our Brands</a></li>
                    </ul>
                </li>
                <?php if ($is_logged) : ?>
                    <li>
                        <a href="#" title="Account">My Account</a>
                        <ul class="submenu">
                            <?php if ($is_admin) : ?>
                                <li><a href="<?php echo $this->request->webroot; ?>admin">Administration</a></li>
                            <?php endif; ?>
                            <li><a href="<?php echo $this->request->webroot; ?>cart">Cart (<span id="cart-items-count" class="headerMenu"><?php echo $cart_items; ?></span>) </a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>profile/wishlist" class="headerMenu">Wishlist</a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>settings" class="headerMenu">Settings</a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>profile/style" class="headerMenu">Profile</a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>signout" class="headerMenu">Sign out</a></li>
                        </ul>
                    </li>
                <?php else : ?> 
                    <li id="show-signup"><a href="#" title="Register">Try us on</a></li>
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
        </div>
        <!-- inside this element open signin view -->
        <div id="signin-popup" style="display: none">
           
        </div>
        <!-- inside this element open signin view (start signup wizard) -->
        <div id="signup-popup" style="display: none">
           
        </div>
    </div>
</div>