<?php
$meta_description = 'Sign up for Savile Row Society, a groundbreaking online, personalized fashion service.';
$this->Html->meta('description', $meta_description, array('inline' => false));
// call this line to exclude lyout from rendering. 
// this is necesary because this view is opening as popup, and don't need to have header, footer etc as rest of the pages.
$this->layout = 'ajax';
?>


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