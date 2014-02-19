<?php

$script = ' var contact = ' . json_encode($contact) . '; ' .
' $(document).ready(function(){ 
    $(".contact-options input[type=\"radio\"]").on("click",function(){
            var currentRad = $(this).attr("id");
            if (currentRad == "phone-field") {
                $("input[type=\"text\"].phone-field").show();
                $("input[type=\"text\"].skype-field").hide();
            } else if(currentRad == "skype-field"){
                 $("input[type=\"text\"].skype-field").show();
                $("input[type=\"text\"].phone-field").hide();
            };
         });
});';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
?>
<div class="content-container">
    <div class="container content inner register-last-step">
        <div class="eight columns register-steps center-block">
          <div class="profile-tabs text-center">
              <a class="link-btn gold-btn my-style" href="<?php echo $this->webroot; ?>profile/about">My Style</a>
              <a class="link-btn black-btn my-profile" href="<?php echo $this->webroot; ?>myprofile">My Profile</a>
          </div>

          <h1 class="text-center">Finalizing</h1>
        </div>        
        
        <?php echo $this->Form->create('ProfileImage', array('url' => '/register/saveContact', 'class' => 'form')); ?>
        <input type="hidden" value="<?php echo $user_id ?>" name="data[User][id]" />
        <div class="hi-message twelve columns text-center">
              <h4 class="hi-message">Preferred time to be reached</h4>                  
        </div>     

        <div class="finalizing seven columns center-block" >
            <div class="five columns pref-time left">
                <input type="checkbox" name="week-days">Week Days<br>
                <div class="pref-options">
                    <input type="radio" name="wd-morning">Morning(8am to 12am)<br>
                    <input type="radio" name="wd-lunch">Lunch time(12 to 2pm)<br>
                    <input type="radio" name="wd-afternoon">Afternoon(2pm to 6pm)<br>
                    <input type="radio" name="wd-evening">Evening(6pm to 9pm)<br>                    
                </div>
                
            </div>
            <div class="five columns pref-time right">
                <input type="checkbox" name="week-end">Week End<br>  
                <div class="pref-options">
                    <input type="radio" name="we-morning">Morning(8am to 12am)<br>
                    <input type="radio" name="we-lunch">Lunch time(12 to 2pm)<br>
                    <input type="radio" name="we-afternoon">Afternoon(2pm to 6pm)<br>
                    <input type="radio" name="we-evening">Evening(6pm to 9pm)<br>                     
                </div>                             
            </div>
            <div class="clear-fix"></div>
        </div> 

        <div class="hi-message twelve columns text-center">
              <h4 class="hi-message">How would you like to be reached</h4>                  
        </div>
        <div class="finalizing seven columns center-block contact-options" >
            <p>SRS Chat & Email</p>
            <input type="radio" name="contact-type" id="phone-field" checked="checked"><span>Phone</span>
            <input type="radio" name="contact-type" id="skype-field"><span>Skype</span>
            <input type="text" placeholder="Enter your phone no." class="phone-field">
            <input type="text" placeholder="Enter your skype ID" class="skype-field">
        </div>
        <div class="clear-fix"></div>   
        <div class="clear-fix"></div>
            <div class="text-center about-submit">
                <br/>                       
                <div class="submit">                            
                    <a class="link-btn black-btn back-btn" href="<?php echo $this->webroot; ?>users/register/brands/<?php echo $user_id; ?>">Back</a> 
                    <input type="submit" value="Continue" />                                                       
                </div>
            </div>
        </form>
    </div>            
</div>