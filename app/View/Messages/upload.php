<?php
$this->layout = 'ajax'
?>

<div id="signin-box" class="box-modal notification-box">
    <div class="box-modal-inside">
        <a class="notification-close" href=""></a>
        <div class="signin-content">
            <h5 class="sign">SIGN IN</h5>            
            <a href="<?php echo $this->request->webroot; ?>connect/facebook"><img src="<?php echo $this->webroot; ?>img/facebook.png" /></a>
            <a href="<?php echo $this->request->webroot; ?>connect/linkedin"><img src="<?php echo $this->webroot; ?>img/linkedin.png" /></a>  
            <h6 class="sign-or">OR</h6>   
            
            <?php echo $this->Form->create('User', array('id' => 'signin-form', 'novalidate')); ?> 
                <?php
                    echo $this->Form->input('email', array('id' => 'signin-email', 'label' => false, 'placeholder' => 'EMAIL'));
                    echo $this->Form->input('password', array('id' => 'signin-password', 'label' => false, 'placeholder' => 'PASSWORD'));
                    echo $this->Form->input('refer_url', array('type' => 'hidden', 'id' => 'referUrlLogIn'));
                ?>                  
                
                <div class="text-left signin-options">                                        
                    <span class="forget-passwrd"><a href="<?php echo $this->request->webroot; ?>forgot">Forgot your password?</a></span> 
                </div>
                 
                <!--<a class="link-btn black-btn signin-btn" href="">SIGN IN</a>-->
                <input type="submit" class="link-btn black-btn signin-btn" value="SIGN IN" /> 
            </form> 
        </div> 
    </div>
</div>