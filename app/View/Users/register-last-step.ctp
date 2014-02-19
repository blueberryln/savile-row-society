<?php

// $script = ' var contact = ' . json_encode($contact) . '; ' .
// ' $(document).ready(function(){ 
//     if(contact.weekDays == "on"){
//         $("input[name=\"data[UserPreference][Contact][weekEnd]\"]").attr("checked","checked");   
//     }
//     $(".contact-options input[type=\"radio\"]").on("click",function(){
//         var currentRad = $(this).attr("id");
//         if (currentRad == "phone-field") {
//             $("input[type=\"text\"].phone-field").show();
//             $("input[type=\"text\"].skype-field").hide();
//         } else if(currentRad == "skype-field"){
//              $("input[type=\"text\"].skype-field").show();
//             $("input[type=\"text\"].phone-field").hide();
//         };
//      });
// });';
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
        
        <?php echo $this->Form->create('User', array('url' => '/register/saveContact', 'class' => 'form')); ?>
        <input type="hidden" value="<?php echo $user_id ?>" name="data[User][id]" />
        <div class="hi-message twelve columns text-center">
              <h4 class="hi-message">Preferred time to be reached</h4>                  
        </div>     

        <div class="finalizing seven columns center-block" >
            <div class="five columns pref-time left">
                <input type="checkbox" name="data[UserPreference][Contact][weekDays]">Week Days<br>
                <div class="pref-options">
                    <input type="radio" name="data[UserPreference][Contact][wdTime]">Morning(8am to 12am)<br>
                    <input type="radio" name="data[UserPreference][Contact][wdTime]">Lunch time(12 to 2pm)<br>
                    <input type="radio" name="data[UserPreference][Contact][wdTime]">Afternoon(2pm to 6pm)<br>
                    <input type="radio" name="data[UserPreference][Contact][wdTime]">Evening(6pm to 9pm)<br>                    
                </div>
                
            </div>
            <div class="five columns pref-time right">
                <input type="checkbox" name="data[UserPreference][Contact][weekEnd]">Week End<br>  
                <div class="pref-options">
                    <input type="radio" name="data[UserPreference][Contact][weTime]">Morning(8am to 12am)<br>
                    <input type="radio" name="data[UserPreference][Contact][weTime]">Lunch time(12 to 2pm)<br>
                    <input type="radio" name="data[UserPreference][Contact][weTime]">Afternoon(2pm to 6pm)<br>
                    <input type="radio" name="data[UserPreference][Contact][weTime]">Evening(6pm to 9pm)<br>                     
                </div>                             
            </div>
            <div class="clear-fix"></div>
        </div> 

        <div class="hi-message twelve columns text-center">
              <h4 class="hi-message">How would you like to be reached</h4>                  
        </div>
        <div class="finalizing seven columns center-block contact-options" >
            <p>SRS Chat & Email</p>
            <input type="radio" name="data[UserPreference][Contact][type]" id="phone-field" checked="checked" value="Phone"><span>Phone</span>
            <input type="radio" name="data[UserPreference][Contact][type]" id="skype-field" value="Skype"><span>Skype</span>
            <input type="text" placeholder="Enter your Phone No" class="phone-field" name="data[UserPreference][Contact][phone]">
            <input type="text" placeholder="Enter your Skype ID" class="skype-field" name="data[UserPreference][Contact][skype]">
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