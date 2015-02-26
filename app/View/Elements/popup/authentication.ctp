<!-- inside this element open signin view -->
<div id="signin-popup" style="display: none">
	<div id="signin-box" class="box-modal notification-box">
    <div class="box-modal-inside">
        <a class="notification-close" href=""></a>
        <div class="signin-content"> 
            <h5 class="sign">SIGN IN</h5>            
            <!-- <a href="<?php echo $this->request->webroot; ?>connect/facebook"><img src="<?php echo HTTP_ROOT; ?>img/facebook.png" /></a>
            <a href="<?php echo $this->request->webroot; ?>connect/linkedin"><img src="<?php echo HTTP_ROOT; ?>img/linkedin.png" /></a>  
            <h6 class="sign-or">OR</h6>  -->  
            
            <?php echo $this->Form->create('User', array('id' => 'signin-form', 'novalidate', 'url' => '/signin')); ?> 
                <?php
                    echo $this->Form->input('email', array('id' => 'signin-email', 'label' => 'Email:', 'placeholder' => 'EMAIL'));
                    echo $this->Form->input('password', array('id' => 'signin-password', 'label' => 'Password:', 'placeholder' => 'PASSWORD'));
                    echo $this->Form->input('refer_url', array('type' => 'hidden', 'id' => 'referUrlLogIn'));
                ?>                  
                
                <div class="text-left signin-options"> 
                    <span class="already-member">New User? <a href="/users/register" id="show-signup-popup">JOIN</a></span>                                       
                    <span class="forget-passwrd"><a href="<?php echo $this->request->webroot; ?>forgot">Forgot your password?</a></span> 
                </div>
                <input type="submit" class="link-btn black-btn signin-btn" value="SIGN IN" /> 
                <!-- <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">SIGN UP WITH FACEBOOK
				</fb:login-button> -->
				<a href="#" class="checkfblogin" onclick="fb_login();"><img src="<?php echo HTTP_ROOT; ?>img/btn-facebook.jpg" alt="" class="checkout-create-text"></a>
            </form> 
        </div> 
    </div>
</div>
</div>
<!-- inside this element open signin view (start signup wizard) -->
<div id="signup-popup" style="display: none">
	<div id="register-box" class="box-modal notification-box">
	    <div class="box-modal-inside">
	        <a class="notification-close" href=""></a>
	        <div class="signup-content">
	            <h5 class="sign"><img src="<?php echo HTTP_ROOT; ?>img/srs_logo_black.png" alt="" style="width: 250px"></h5> 
	            <?php if(isset($referer_type)) : ?>
	                <?php if($referer_type == 'event') : ?>
	                    <p>Thank you for attending our <?php echo ucwords($referer['User']['full_name']); ?> event. To thank you for your support and patronage, please enjoy $50 off of your first purchase of $250 or more.</p>
	                <?php elseif($referer_type == 'stylist') : ?>
	                    <p>We hear you’re a friend of our premier personal stylist <?php echo ucwords($referer['User']['first_name']); ?>. To welcome you to Savil.Me, please enjoy $50 off of your first purchase of $250 or more.</p>
	                <?php else : ?>
	                    <p>Any friend of <?php echo ucwords($referer['User']['first_name']); ?> is a friend of ours! To welcome you to Savil.Me, please enjoy $50 off of your first purchase of $250 or more. </p>
	                <?php endif; ?> 
		            <div class="text-center">
		            	<a href="<?php echo $this->webroot; ?>users/register" class="link-btn black-btn signin-btn">Start</a>
		            </div>
	            <?php else : ?>
	            	<div id="request-invite-block">
		            	<p>Due to high demand in our beta period, we will place you on our waitlist and will notify you as soon as we are able to service you.</p> 
		            
		            	<div class="input email required">
		                	<input type="text" id="invite-email" required placeholder="Enter email address...">
		                </div>
						<div class="text-center">
			            	<a href="" class="link-btn black-btn signin-btn btn-request-invite">Request Invite</a>
			            </div>
			            <span class="already-member">
			            	<a href="" id="block-vip-access-link" >Have been referred?</a>	
			            </span>
					</div>
					<div class="hide" id="request-invite-status">
						<p>Thank you for leaving us your email! <br>We have placed you on our waitlist and will notify you as soon as we are able to service you.</p>	
					</div>
	            <?php endif; ?>          
	            <!-- <a href="<?php echo $this->request->webroot; ?>connect/facebook"><img src="<?php echo HTTP_ROOT; ?>img/facebook.png" /></a>
	            <a href="<?php echo $this->request->webroot; ?>connect/linkedin"><img src="<?php echo HTTP_ROOT; ?>img/linkedin.png" /></a> 
	            <h6 class="sign-or">OR</h6>               
	            <?php echo $this->Form->create('User', array('url' => '/register/basic', 'id' => 'register-form', 'novalidate')); ?> 
	                <?php
	                    echo $this->Form->input('first_name', array('id' => 'first-name', 'label' => 'First Name:', 'placeholder' => 'FIRST NAME'));
	                    echo $this->Form->input('last_name', array('id' => 'last-name', 'label' => 'Last Name:', 'placeholder' => 'LAST NAME'));
	                    echo $this->Form->input('email', array('id' => 'register-email', 'label' => 'Email:', 'placeholder' => 'EMAIL'));
	                    echo $this->Form->input('password', array('id' => 'register-password', 'label' => 'Password:', 'placeholder' => 'PASSWORD'));
	                ?>                  
	                
	                <div class="text-left signup-options">                                       
	                    <span class="already-member">Already a Member? <a href="" id="show-signin-popup">SIGN IN</a></span> 
	                </div>
	                
	                <input type="submit" class="link-btn black-btn signup-btn" value="SIGN UP" /> 
	                
	            </form>  -->
	        </div> 
	    </div>
	</div>
</div>


<!-- inside this element open signin view -->
<div id="multi-popup" style="display: none">
	<div id="signin-box" class="box-modal notification-box">
    <div class="box-modal-inside">
        <a class="notification-close" href=""></a>
        <div class="signin-content text-left"> 
            <h5 class="sign"><img class="logo" src="<?= HTTP_ROOT; ?>img/srs_logo_black.png" alt="Savil.Me" title="Savil.Me"></h5>            
            
            <p>Not a member yet? <a class="overlay-started brown-btns" href="/users/register" title="">GET STARTED<span class="get-started-icon"><img src="<?php echo HTTP_ROOT; ?>images/btn-arrow.png"></span></a></p>
             
            <p>Already a member?  <a class="tell-more gray-btns" href="#" onclick="signIn();" title="">Login</a></p>

            <p><a href="" id="multi-vip-access">Have been refered? Click Here!</a></p>
        </div> 
    </div>
</div>
</div>


<?php if(isset($landing_text)) { ?>
<!-- inside this element open signin view (start signup wizard) -->
<div id="affiliate-popup" style="display: none">
	<div id="register-box" class="box-modal notification-box landing-offer-box">
	    <div class="box-modal-inside">
	        <div>
                <?php echo $landing_text; ?>
	            <?php echo $this->Form->create('User', array('id' => 'signin-form', 'novalidate', 'url' => '/landing')); ?>
	            	<div class="landing-form">
	                <?php
	                	echo $this->Form->input('first_name', array('id' => 'first-name', 'label' => 'First Name', 'div' => array('class' => 'offer_first_name')));
	                    echo $this->Form->input('last_name', array('id' => 'last-name', 'label' => 'Last Name', 'div' => array('class' => 'offer_last_name')));
	                    echo $this->Form->input('email', array('id' => 'signin-email', 'label' => 'Email:', 'label' => 'Email'));
	                    echo $this->Form->input('password', array('id' => 'signin-password', 'label' => 'Password'));
	                ?>      
	                </div>
					<div class="landing-buttons">
		                <input type="submit" class="link-btn btn-started" value="SIGN IN" /> 
		                <span>OR</span>
		               	<input type="button" class="link-btn btn-outfits" value="SHOP TOP OUTFITS" onclick="location='/';" />
	               	</div>

	            </form>  
	            <div class="text-center signup-options">                                       
                    <span class="already-member">already a member? <a href="" id="show-signin-popup">Sign in Here.</a></span> 
                </div>  
                 <!-- <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">SIGN UP WITH FACEBOOK 
				</fb:login-button> -->
				<a href="#" class="checkfblogin" onclick="fb_login();"><img src="<?php echo HTTP_ROOT; ?>img/btn-facebook.jpg" alt="" class="checkout-create-text"></a>

	        </div> 
	    </div>
	</div>
</div>
<?php } ?>


<div id="quick-signup-popup" style="display: none">
	<div id="register-box" class="box-modal notification-box guest-checkout-box">
	    <div class="box-modal-inside">
	        <div class="guest-signin-box"> 
	        	<img src="<?php echo HTTP_ROOT; ?>img/signin-text.png" alt="" class="checkout-text">
	            <?php echo $this->Form->create('User', array('id' => 'signin-form', 'novalidate', 'url' => '/signin', 'class' => 'checkout-sigin-from')); ?> 
	                <?php
	                    echo $this->Form->input('email', array('id' => 'signin-email', 'label' => 'Email:', 'label' => 'Email'));
	                    echo $this->Form->input('password', array('id' => 'signin-password', 'label' => 'Password'));
	                    echo $this->Form->input('refer_url', array('type' => 'hidden', 'id' => 'referUrlLogIn'));
	                ?>                  
	                
	                <div class="text-left signin-options">                                        
	                    <span class="forget-passwrd"><a href="<?php echo $this->request->webroot; ?>forgot">Forgot your password?</a></span> 
	                </div>
	                <input type="submit" class="link-btn signin-btn" value="SIGN IN" /> 
	                <!-- <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">SIGN UP WITH FACEBOOK
					</fb:login-button> -->
					<a href="#" class="checkfblogin" onclick="fb_login();"><img src="<?php echo HTTP_ROOT; ?>img/btn-facebook.jpg" alt="" class="checkout-create-text"></a>

	            </form> 
	        </div> 
	        <div class="guest-register-box">
				<img src="<?php echo HTTP_ROOT; ?>img/register-text.png" alt="" class="checkout-text">
	            <img src="<?php echo HTTP_ROOT; ?>img/guest-checkout-create.png" alt="" class="checkout-create-text">

	            <input type="submit" class="link-btn signin-btn" value="CREATE AN ACCOUNT" onclick="location = '/users/register';" />
	            <span class="checkout-option">OR</span>
	            <input type="submit" class="link-btn signin-btn guest-checkout-btn" value="GUEST CHECKOUT" onclick="location = '/guest/checkout';" />
	        </div>

	        <div class="clear-fix"></div>
	    </div>
	</div>
</div>

