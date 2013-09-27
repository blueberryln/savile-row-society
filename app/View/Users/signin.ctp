<?php
$meta_description = 'Sign in to Savile Row Society, a groundbreaking online, personalized fashion service.';
$this->Html->meta('description', $meta_description, array('inline' => false));
// call this line to exclude lyout from rendering. 
// this is necesary because this view is opening as popup, and don't need to have header, footer etc as rest of the pages.
$this->layout = 'ajax'
?>

<!--<div id="signin-box" class="box-modal notification-box">
    <div class="box-modal-inside">
        <a class="notification-close" href=""></a>
        <div class="signin-content">
            <h5 class="sign">SIGN IN</h5>            
            <img src="app/webroot/img/facebook.png" />
            <img src="app/webroot/img/linkedin.png" /> 
            <h6 class="sign-or">OR</h6>   
            <form id="register-form" method="" action="">
            <?php echo $this->Form->create('User', array('id' => 'register-form')); ?> 
                <?php
                    echo $this->Form->input('email', array('id' => 'register-email', 'label' => false, 'placeholder' => 'EMAIL'));
                    echo $this->Form->input('password', array('id' => 'register-password', 'label' => false, 'placeholder' => 'PASSWORD'));
                    echo $this->Form->input('refer_url', array('type' => 'hidden', 'id' => 'referUrlLogIn'));
                ?>  
                <input type="text" id="register-email" placeholder="EMAIL" />
                <input type="password" id="register-password" placeholder="PASSWORD" />
                
                <div class="text-left signin-options">
                    <input id="remember-me" type="checkbox" />  
                    <label for="remember-me">Remember me</label>                    
                    <span class="forget-passwrd"><a href="<?php echo $this->request->webroot; ?>forgot">Forgot your password?</a></span> 
                </div>
                 
                <input type="submit" class="link-btn black-btn signin-btn" value="SIGN IN" /> 
            </form> 
        </div> 
    </div>
</div>-->

<div class="container content inner" style="width:430px;">	
    <div class="seven columns text-center " style="width:430px;">
        <h1>Sign in</h1>
    </div>
    <div class="seven columns" style="width:430px;">
        <?php echo $this->Form->create('User'); ?>
        <div class="five columns offset-by-one">
            <?php
            echo $this->Form->input('email');
            echo $this->Form->input('password');
            echo $this->Form->input('refer_url', array('type' => 'hidden', 'id' => 'referUrlLogIn'));
            ?>
        </div>
        <div class="clearfix"></div>
        <div class="text-center">
            <br/>
            <?php echo $this->Form->end(__('Sign in')); ?>
            <br/>
            <div>
                <a tabindex="-1" href="#" onclick="signUp()">Register a new account</a> | 
                Forgot your <a tabindex="-1" href="<?php echo $this->request->webroot; ?>forgot">password</a>?
            </div>
        </div>
        <br/>
        
    </div>
</div>