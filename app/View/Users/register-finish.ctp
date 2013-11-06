<?php
$meta_description = 'Sign up for Savile Row Society, a groundbreaking online, personalized fashion service.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>
<input type="hidden" value="<?php echo $user_id ?>" name="data[User][id]" />
<div class="container content inner ">	

    <div class="sixteen columns text-center">
        <h1>PROFILE</h1>
    </div>	
    <div class="fifteen columns offset-by-half register-steps">
        <div class="profile-tabs text-center">
                    <a class="link-btn gold-btn" href="<?php echo $this->webroot; ?>profile/about">My Style</a>
                    <a class="link-btn gray-btn" href="<?php echo $this->webroot; ?>myprofile">My Profile</a>
        </div>
    </div>
    <div class="sixteen columns text-center">
        <div class="reg-step6"><img src="<?php echo $this->webroot; ?>img/reg-step6.png"/></div>
    </div>
    <div class="sixteen columns">

        <div class="hi-message fourteen columns text-center offset-by-one alpha omega">
            <h4 class="hi-message">COMPLETED</h4>
            <p>
                Thank you for completing our quick style profile. We are matching your responses with a stylist who suits you. In the meantime, you can browse The Closet or book an appointment with our tailor. We look forward to many successful years of helping you build your wardrobe. Thank you for choosing Savile Row Society for your personal shopping services. Tailor your life. 
            </p>
            <h5 class="thank-margin">Thank you</h5>
            <h5>The SRS Team</h5>
            <br />
            <?php echo $this->Form->create('FinishStep', array('url' => '/register/saveFinish')); ?>
            <textarea name="data[Message][body]" style="width: 500px;" placeholder="Have any immediate requests? We'll assign your comments to your stylist."></textarea>
            <div class="text-center about-submit">
                <br/>                       
                <div class="submit">                
                    <input type="submit" class="submit" value="Submit" /><br />
                    <a class="link-btn gold-btn back-btn" href="<?php echo $this->webroot; ?>closet">Have a look at The Closet</a>                                                       
                </div>                        
                <br/>                    
            </div>
            </form>
        </div>
        
    </div>
</div>