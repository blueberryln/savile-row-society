<?php
$meta_description = 'Sign up for Savile Row Society, a groundbreaking online, personalized fashion service.';
$this->Html->meta('description', $meta_description, array('inline' => false));
// call this line to exclude lyout from rendering. 
// this is necesary because this view is opening as popup, and don't need to have header, footer etc as rest of the pages.
$this->layout = 'ajax'
?>


<div id="register-box" class="box-modal notification-box">
    <div class="box-modal-inside">
        <a class="notification-close" href=""></a>
        <div class="signup-content">
            <h5 class="sign">SIGN UP</h5>            
            <a href="<?php echo $this->request->webroot; ?>connect/facebook"><img src="app/webroot/img/facebook.png" /></a>
            <a href="<?php echo $this->request->webroot; ?>connect/linkedin"><img src="app/webroot/img/linkedin.png" /></a> 
            <h6 class="sign-or">OR</h6>               
            <?php echo $this->Form->create('User', array('url' => '/register/basic', 'id' => 'register-form', 'novalidate')); ?> 
                <?php
                    echo $this->Form->input('first_name', array('id' => 'first-name', 'label' => false, 'placeholder' => 'FIRST NAME'));
                    echo $this->Form->input('last_name', array('id' => 'last-name', 'label' => false, 'placeholder' => 'LAST NAME'));
                    echo $this->Form->input('email', array('id' => 'register-email', 'label' => false, 'placeholder' => 'EMAIL'));
                    echo $this->Form->input('password', array('id' => 'register-password', 'label' => false, 'placeholder' => 'PASSWORD'));
                    echo $this->Form->input('refer_url', array('type' => 'hidden', 'id' => 'referUrl'));
                ?>                  
                
                <div class="text-left signup-options">                                       
                    <span class="already-member">Already a Member? <a href="" id="show-signin-popup">SIGN IN</a></span> 
                </div>
                 
                <!--<a class="link-btn black-btn signup-btn" href="">SIGN UP</a>-->
                <input type="submit" class="link-btn black-btn signup-btn" value="SIGN UP" /> 
                
            </form> 
        </div> 
    </div>
</div>


