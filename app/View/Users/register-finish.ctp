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
    <div class="sixteen columns alpha omega text-center  offset-by-three">
        <div class="reg-step6"></div>
    </div>
    <div class="sixteen columns">

        <div class="hi-message fourteen columns text-center offset-by-one alpha omega">
            <h4 class="hi-message">COMPLETED</h4>
            <p>
                After registration we recommend completing your style profile. This is to ensure your stylist is aligned with your preferences. They will get to know you just like you’ve walked into a store. We look forward to many successful years.  Thank you for choosing Savile Row Society for your personal shopping services.
            </p>
            <h5 class="thank-margin">Thank you</h5>
            <h5>Your SRS Team</h5>
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
        </div>
        
    </div>
</div>