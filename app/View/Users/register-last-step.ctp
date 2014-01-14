<?php

$script = ' var contact = ' . json_encode($contact) . '; ' .
' $(document).ready(function(){ 
    if(contact){
        $("#contact-time").val(contact.time);
        $("#contact-type").val(contact.type);   
        $("#refer_medium").val("' . $refer_medium . '");      
    }
    $("#contact-info-submit").click(function(event){ 
        if($("#ProfileImagePersonalShopper").val() != "" || $("#ProfileImageEmailAddress").val() != ""){
            $("p.error-msg").slideUp(300);
        }
        else{
            $("p.error-msg").slideDown(300);
            event.preventDefault();    
        }
    });
});';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
?>
<div class="content-container">
    <div class="container content inner register-last-step">	
        <div class="eight columns text-center page-heading">
            <h1>PROFILE</h1>
        </div>	
        <div class="eight columns register-steps center-block">
            <div class="profile-tabs text-center">
                <a class="link-btn gray-btn my-style" href="<?php echo $this->webroot; ?>profile/about">My Style</a>
                <a class="link-btn black-btn my-profile" href="<?php echo $this->webroot; ?>myprofile">My Profile</a>
            </div>
        </div>    
        <div class="twelve columns text-center" id="reg-step">
            <div class="reg-step5"><img src="<?php echo $this->webroot; ?>img/reg-step5.png"/></div>
        </div>
        <?php echo $this->Form->create('ProfileImage', array('url' => '/register/saveContact','type' => 'file', 'class' => 'form')); ?>
        <input type="hidden" value="<?php echo $user_id ?>" name="data[User][id]" />
        <div class="nine columns center-block">        
            <div class="hi-message twelve columns text-center">
                <h4 class="hi-message">Hi <?php echo ucwords($full_name); ?></h4>
                <p>
                    Don't be shy, you'd be surprised what we can do with a photo.
                </p>
                <div class='empty-img' id='photo-holder'>
                <img src='<?php echo $image_url ?>' id='user-photo'/>
                </div>                
                <input type='button' value='Upload photo' id='upload-img' class="gray-btn"/>
            
            </div>
            
            
            
            <div class="finalizing six columns center-block" >
            <?php
                echo $this->Form->input('', array('type' => 'file', 'id'=>'uploader-btn'));
            ?>
            <h5>Is there a specific time or day when you prefer to be reached?</h5>        
            <?php
                echo $this->Form->input('time', array('label' => false, 'name' => 'data[UserPreference][Contact][time]', 'id'=>'contact-time', 'maxlength' => 50, 'required', 'value' => ''));
            ?>  
            
            <h5>How would you like to be reached?</h5>
            <select name="data[UserPreference][Contact][type]" id="contact-type" required=required >
                <option value="">Contact type</option>
                <option value="Phone">Phone</option>
                <option value="Email">Email</option>
                <option value="Skype">Skype</option>
            </select>  
            
            <h5>Who referred you to SRS?</h5>
            <label style="display: none;">Name</label>         
            <?php
                echo $this->Form->input('personal_shopper', array('label' => false, 'name' => 'data[User][personal_shopper]','placeholder'=>'Name','class'=>'no-margin', 'maxlength' => 50, 'value' => $personal_shopper));
            ?> 
            <label style="display: none;">Email Address</label> 
            <?php
                echo $this->Form->input('email_address', array('label' => false, 'name' => 'data[User][shopper_email]', 'placeholder'=> 'Email Address','class'=>'no-margin', 'maxlength' => 50, 'value' => $shopper_email));
            ?>
            <label style="display: none;">Refer Medium</label> 
            <select name="data[User][refer_medium]" id="refer_medium">
                <option value="">Select Medium</option>            
                <option value="Event">Event</option>
                <option value="Other">Other</option>
            </select>   
            
            <input type="hidden" value="completed" name="data[UserPreference][is_complete]" />    
            
            
                <div class="text-center about-submit">                   
                    <div class="submit">
                        <input type="submit" value="SUBMIT" id="contact-info-submit" class="full-width" />
                        <a class="link-btn black-btn full-width" href="<?php echo $this->webroot; ?>users/register/brands/<?php echo $user_id; ?>">Back</a>
                        <p class="error-msg">Please provide either referrer name or email.</p>  
                    </div> 
                    </form>
                </div>  
            </div>
        </div>    
        
    </div>
</div>

<style>
    #upload-img{
        width:100px;
    }
    #uploader-btn{
        display: none;
    }
    #user-photo{
        /*width:100px;*/
        height: 100px;
        opacity: 0;
        
    }
</style>
<script>
    window.onload=function(){
        $("#upload-img").click(function(e){
            e.preventDefault();
            $("#uploader-btn").click();
        });
        $("#uploader-btn").change(function(){
        
            var input = document.getElementById("uploader-btn");
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#user-photo' ).attr('src', e.target.result);
                    $('#user-photo' ).css('opacity', 1);
                    $('#photo-holder' ).attr('class', '');
                };
                reader.readAsDataURL(input.files[0]);
//                    if (self.showName) {
//                        $(self).append("<p>" + input.files[0].name + "</p>");
//                    }
                // 
            }
        });
        if($('#user-photo').attr('src') != "#"){
            $('#user-photo').css('opacity', 1);
            $('#photo-holder' ).attr('class', '');
        }
    }
</script>    