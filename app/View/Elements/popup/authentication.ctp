<!-- inside this element open signin view -->
<div id="signin-popup" style="display: none">
	<div id="signin-box" class="box-modal notification-box">
    <div class="box-modal-inside">
        <a class="notification-close" href=""></a>
        <div class="signin-content">
            <h5 class="sign">SIGN IN</h5>            
            <a href="<?php echo $this->request->webroot; ?>connect/facebook"><img src="<?php echo $this->webroot; ?>img/facebook.png" /></a>
            <a href="<?php echo $this->request->webroot; ?>connect/linkedin"><img src="<?php echo $this->webroot; ?>img/linkedin.png" /></a>  
            <h6 class="sign-or">OR</h6>   
            
            <?php echo $this->Form->create('User', array('id' => 'signin-form', 'novalidate', 'url' => '/signin')); ?> 
                <?php
                    echo $this->Form->input('email', array('id' => 'signin-email', 'label' => 'Email:', 'placeholder' => 'EMAIL'));
                    echo $this->Form->input('password', array('id' => 'signin-password', 'label' => 'Password:', 'placeholder' => 'PASSWORD'));
                    echo $this->Form->input('refer_url', array('type' => 'hidden', 'id' => 'referUrlLogIn'));
                ?>                  
                
                <div class="text-left signin-options"> 
                    <span class="already-member">New User? <a href="" id="show-signup-popup">JOIN</a></span>                                       
                    <span class="forget-passwrd"><a href="<?php echo $this->request->webroot; ?>forgot">Forgot your password?</a></span> 
                </div>
                <input type="submit" class="link-btn black-btn signin-btn" value="SIGN IN" /> 
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
	            <h5 class="sign">SIGN UP</h5> 
	            <?php if(isset($referer_type)) : ?>
	                <?php if($referer_type == 'event') : ?>
	                    <p>Thank you for attending our <?php echo ucwords($referer['User']['full_name']); ?> event. To thank you for your support and patronage, please enjoy $50 off of your first purchase of $250 or more.</p>
	                <?php elseif($referer_type == 'stylist') : ?>
	                    <p>We hear you’re a friend of our premier personal stylist <?php echo ucwords($referer['User']['first_name']); ?>. To welcome you to Savile Row Society, please enjoy $50 off of your first purchase of $250 or more. </p>
	                <?php else : ?>
	                    <p>Any friend of <?php echo ucwords($referer['User']['first_name']); ?> is a friend of ours! To welcome you to Savile Row Society, please enjoy $50 off of your first purchase of $250 or more. </p>
	                <?php endif; ?> 
	            <?php endif; ?>          
	            <a href="<?php echo $this->request->webroot; ?>connect/facebook"><img src="<?php echo $this->webroot; ?>img/facebook.png" /></a>
	            <a href="<?php echo $this->request->webroot; ?>connect/linkedin"><img src="<?php echo $this->webroot; ?>img/linkedin.png" /></a> 
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
	                
	            </form> 
	        </div> 
	    </div>
	</div>
</div>