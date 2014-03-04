<?php

$script = ' var contact = ' . json_encode($contact) . '; ' .
' 
var user = ' . json_encode($user["User"]) . '
$(document).ready(function(){ 
    if(contact.weekDays == "on"){
        $("input[name=\"data[UserPreference][Contact][weekDays]\"]").attr("checked","checked"); 
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
    }
    if(contact.weekEnd == "on"){
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
    }

    if(contact.type && contact.type == "Phone"){
        $("input[name=\"data[UserPreference][Contact][type]\"][value=\"Phone\"]").attr("checked","checked");
        if(user.phone){
            $("input[type=\"text\"].phone-field").val(user.phone).show();    
        }
        else{
            $("input[type=\"text\"].phone-field").show();
        }
        $("input[type=\"text\"].skype-field").hide();
    }
    else if(contact.type && contact.type == "Skype"){
        $("input[name=\"data[UserPreference][Contact][type]\"][value=\"Skype\"]").attr("checked","checked");
        if(user.skype){
            $("input[type=\"text\"].skype-field").val(user.skype).show();    
        }
        else{
            $("input[type=\"text\"].skype-field").show();
        }
        $("input[type=\"text\"].phone-field").hide();

    }

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
    $("div.submit input").click(function(event){
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

                /*$("div.pref-time").each(function(){      
                    if(!$(this).find("input[type=\"checkbox\"]").is(":checked"))     
                    {
                        event.preventDefault();
                        $("p.error-msg").slideDown(300);    
                    }else   
                    {
                        $("p.error-msg").slideUp(300);
                    }
                });
                if(!$("div.pref-options input[type=\"radio\"]").is(":checked"))
                {
                        event.preventDefault();
                        $("p.error-msg").slideDown(300); 
                }  */                  
                
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
              <h4 class="hi-message">Preferred time to be reached</h4>                  
        </div>     

        <div class="finalizing seven columns center-block" >
            <div class="five columns pref-time left">
                <input type="checkbox" name="data[UserPreference][Contact][weekDays]">Week Days<br>
                <div class="pref-options">
                    <input type="checkbox" name="data[UserPreference][Contact][wdTime1]" value="1">Morning(8am to 12am)<br>
                    <input type="checkbox" name="data[UserPreference][Contact][wdTime2]" value="2">Lunch time(12 to 2pm)<br>
                    <input type="checkbox" name="data[UserPreference][Contact][wdTime3]" value="3">Afternoon(2pm to 6pm)<br>
                    <input type="checkbox" name="data[UserPreference][Contact][wdTime4]" value="4">Evening(6pm to 9pm)<br>                    
                </div>
                
            </div>
            <div class="five columns pref-time right">
                <input type="checkbox" name="data[UserPreference][Contact][weekEnd]">Week End<br>  
                <div class="pref-options">
                    <input type="checkbox" name="data[UserPreference][Contact][weTime1]" value="1">Morning(8am to 12am)<br>
                    <input type="checkbox" name="data[UserPreference][Contact][weTime2]" value="2">Lunch time(12 to 2pm)<br>
                    <input type="checkbox" name="data[UserPreference][Contact][weTime3]" value="3">Afternoon(2pm to 6pm)<br>
                    <input type="checkbox" name="data[UserPreference][Contact][weTime4]" value="4">Evening(6pm to 9pm)<br>                     
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
            <input type="text" placeholder="Enter your Phone No" class="phone-field" name="data[User][phone]" value="<?php echo $user['User']['phone'] ?>">
            <input type="text" placeholder="Enter your Skype ID" class="skype-field" name="data[User][skype]"value="<?php echo $user['User']['skype'] ?>">
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