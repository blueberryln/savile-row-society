<?php
$meta_description = 'Sign up for Savile Row Society, a groundbreaking online, personalized fashion service.';
$this->Html->meta('description', $meta_description, array('inline' => false));
// call this line to exclude lyout from rendering. 
// this is necesary because this view is opening as popup, and don't need to have header, footer etc as rest of the pages.
$this->layout = 'ajax'
?>

<div class="container content inner" style="width:430px;">	
    <div class="columns text-center">
         <h1>Sign up</h1>
         <p class="sign-up-notice text-center">Thank you for visiting Savile Row Society. We are hard at work getting ready for our October launch. In the meantime, sign up now and you will receive a $30 credit toward your first Savile Row Society purchase! <br />
<strong>"Live a Tailored Life"</strong></p>
         <h5>Use this space to introduce yourself, tell us</h5>
    </div>
    <div class="columns">
        <?php echo $this->Form->create('User', array('url' => '/register/basic', 'id' => 'register-step1')); ?>
        <div class="five columns offset-by-one">
           
        <?php
            echo $this->Form->input('first_name');
            echo $this->Form->input('last_name');
            echo $this->Form->input('email');
            echo $this->Form->input('password');
            echo $this->Form->input('refer_url', array('type' => 'hidden', 'id' => 'referUrl'));
            ?>
        </div>
        <div class="clearfix"></div>
        <div class="text-center">
            <br/>
            <div class="submit">
            <input type="submit" value="Sign Up" style="float:inline" /> 
            </div>
            <br/>
            <div>
                <a tabindex="-1" href="#" onclick="signIn()">Sign in</a> | 
                Forgot your <a tabindex="-1" href="<?php echo $this->request->webroot; ?>forgot">password</a>?
            </div>
        </div>
        <br/>
        
    </div>
</div>


<script>
    
    
</script>
