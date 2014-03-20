<?php

$script = ' var contact = ' . json_encode($contact) . '; ' .
' 
var user = ' . json_encode($user["User"]) . '
$(document).ready(function(){  
    
    //Check contact timings checkboxes
    if(contact.wdTime1){
        $("input[name=\"data[UserPreference][Contact][wdTime1]\"]").attr("checked","checked");    
    }
    if(contact.wdTime2){
        $("input[name=\"data[UserPreference][Contact][wdTime2]\"]").attr("checked","checked");    
    }
    if(contact.wdTime3){
        $("input[name=\"data[UserPreference][Contact][wdTime3]\"]").attr("checked","checked");    
    }
    if(contact.wdTime4){
        $("input[name=\"data[UserPreference][Contact][wdTime4]\"]").attr("checked","checked");    
    }
    $("input[name=\"data[UserPreference][Contact][weekEnd]\"]").attr("checked","checked");   
    if(contact.weTime1){
        $("input[name=\"data[UserPreference][Contact][weTime1]\"]").attr("checked","checked");   
    }
    if(contact.weTime2){
        $("input[name=\"data[UserPreference][Contact][weTime2]\"]").attr("checked","checked");   
    }
    if(contact.weTime3){
        $("input[name=\"data[UserPreference][Contact][weTime3]\"]").attr("checked","checked");   
    }
    if(contact.weTime4){
        $("input[name=\"data[UserPreference][Contact][weTime4]\"]").attr("checked","checked");   
    }

    if(contact.type &&  $.inArray("Chat", contact.type) >= 0){
        $("input[type=\"checkbox\"][value=\"Chat\"]").attr("checked","checked");
    }
    if(contact.type && $.inArray("Phone", contact.type) >= 0){
        $("input[type=\"checkbox\"][value=\"Phone\"]").attr("checked","checked");
    }
    if(contact.type && $.inArray("Skype", contact.type) >= 0){
        $("input[type=\"checkbox\"][value=\"Skype\"]").attr("checked","checked");
    }

    $("div.submit input").click(function(event){
        var contactCount = 0;
            timingsCount = 0;
        $(".contact-options input[type=\"checkbox\"]").each(function(){
            if($(this).is(":checked")){
                contactCount++;
            }
        });

        if(!contactCount){
            event.preventDefault();
            $("p.error-msg").slideDown(300);
        }

        if($("#phone-field").is(":checked") && $("input.phone-field").val() == "" )
        {
            event.preventDefault();
            $("p.error-msg").slideDown(300);                    
        }  
        if($("#skype-field").is(":checked") && $("input.skype-field").val() == "" )
        {
            event.preventDefault();
            $("p.error-msg").slideDown(300);                    
        }   

        $(".pref-time input[type=\"checkbox\"]").each(function(){
            if($(this).attr("checked") == "checked"){
                timingsCount++;
            }
        });
        if(!timingsCount){
            event.preventDefault();
            $("p.error-msg").slideDown(300);    
        }
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
        
        <?php echo $this->Form->create('User', array('url' => '/register/saveContact', 'class' => 'form')); ?>
        <input type="hidden" value="<?php echo $user_id ?>" name="data[User][id]" />
        <div class="hi-message twelve columns text-center">
              <h4 class="hi-message">Preferred time to be reached?</h4>                  
        </div>     

        <div class="finalizing seven columns center-block" >
            <div class="five columns pref-time left">
                <p>Week Days</p>
                <div class="pref-options">
                    <input type="checkbox" name="data[UserPreference][Contact][wdTime1]" value="1">Morning (8am to 12am)<br>
                    <input type="checkbox" name="data[UserPreference][Contact][wdTime2]" value="2">Lunch time (12 to 2pm)<br>
                    <input type="checkbox" name="data[UserPreference][Contact][wdTime3]" value="3">Afternoon (2pm to 6pm)<br>
                    <input type="checkbox" name="data[UserPreference][Contact][wdTime4]" value="4">Evening (6pm to 9pm)<br>                    
                </div>
                
            </div>
            <div class="five columns pref-time right">
                <p>Week End</p>
                <div class="pref-options">
                    <input type="checkbox" name="data[UserPreference][Contact][weTime1]" value="1">Morning (8am to 12am)<br>
                    <input type="checkbox" name="data[UserPreference][Contact][weTime2]" value="2">Lunch time (12 to 2pm)<br>
                    <input type="checkbox" name="data[UserPreference][Contact][weTime3]" value="3">Afternoon (2pm to 6pm)<br>
                    <input type="checkbox" name="data[UserPreference][Contact][weTime4]" value="4">Evening (6pm to 9pm)<br>                     
                </div>                             
            </div>
            <div class="clear-fix"></div>
        </div> 

        <div class="hi-message twelve columns text-center">
              <h4 class="hi-message">How would you like to be reached?</h4>                  
        </div>
        <div class="finalizing seven columns center-block contact-options" >
            <ul>
                <li><input type="checkbox" name="data[UserPreference][Contact][type][]" id="srs-chat" value="Chat"> SRS Chat &amp; Email</li>
                <li>
                    <input type="checkbox" name="data[UserPreference][Contact][type][]" id="phone-field" value="Phone"><span> Phone</span>
                    <input type="text" placeholder="Enter your Phone No" class="phone-field" name="data[User][phone]" value="<?php echo $user['User']['phone'] ?>"><br>
                </li>
                <li>
                    <input type="checkbox" name="data[UserPreference][Contact][type][]" id="skype-field" value="Skype"><span> Skype </span>
                    <input type="text" placeholder="Enter your Skype ID" class="skype-field" name="data[User][skype]"value="<?php echo $user['User']['skype'] ?>">
                </li>
            </ul>
        </div>
        <div class="clear-fix"></div>   
        <div class="clear-fix"></div>
            <div class="text-center about-submit">
                <br/>                       
                <div class="submit">                            
                    <a class="link-btn black-btn back-btn" href="<?php echo $this->webroot; ?>users/register/brands/<?php echo $user_id; ?>">Back</a> 
                    <input type="submit" value="Continue" />
                    <p class="error-msg">All the fields are mandatory.</p> 
                </div>
            </div>
        </form>
    </div>            
</div>