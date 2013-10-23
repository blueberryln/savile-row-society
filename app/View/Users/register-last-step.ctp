<?php

$script = ' var contact = ' . json_encode($contact) . '; ' .
' $(document).ready(function(){ 
    if(contact){
        $("#contact-time").val(contact.time);
        $("#contact-type").val(contact.type);         
    }
});';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
?>

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
        <div class="reg-step5"><img src="<?php echo $this->webroot; ?>img/reg-step5.png"/></div>
    </div>
    <?php echo $this->Form->create('ProfileImage', array('url' => '/register/saveContact','type' => 'file')); ?>
    <input type="hidden" value="<?php echo $user_id ?>" name="data[User][id]" />
    <div class="sixteen columns text-center">        
        <div class="hi-message fourteen columns offset-by-one alpha omega">
            <h4 class="hi-message">Hi <?php echo $full_name; ?></h4>
            <p>
                Don't be shy, you'd be surprised what we can do with a photo.
            </p>
            <div class='empty-img' id='photo-holder'>
            <img src='<?php echo $image_url ?>' id='user-photo'/>
            </div>
        <input type='button' value='Upload photo' id='upload-img'/>
<!--        <input type='file' id='uploader-btn'  />-->
        <?php
            echo $this->Form->input('', array('type' => 'file', 'id'=>'uploader-btn'));
        ?>
        </div>
        
        
        
        <div class="finalizing six columns offset-by-five text-left" >
        <h5>What is the best time for your stylist to contact you?</h5>
        <select name="data[UserPreference][Contact][time]" id="contact-time" required=required >
            <option value="">Time</option>
            <option value="9:00 AM">9:00 AM</option>
            <option value="9:15 AM">9:15 AM</option>
            <option value="9:30 AM">9:30 AM</option>
            <option value="9:45 AM">9:45 AM</option>

            <option value="10:00 AM">10:00 AM</option>
            <option value="10:15 AM">10:15 AM</option>
            <option value="10:30 AM">10:30 AM</option>
            <option value="10:45 AM">10:45 AM</option>

            <option value="11:00 AM">11:00 AM</option>
            <option value="11:15 AM">11:15 AM</option>
            <option value="11:30 AM">11:30 AM</option>
            <option value="11:45 AM">11:45 AM</option>

            <option value="12:00 PM">12:00 PM</option>
            <option value="12:15 PM">12:15 PM</option>
            <option value="12:30 PM">12:30 PM</option>
            <option value="12:45 PM">12:45 PM</option>

            <option value="1:00 PM">1:00 PM</option>
            <option value="1:15 PM">1:15 PM</option>
            <option value="1:30 PM">1:30 PM</option>
            <option value="1:45 PM">1:45 PM</option>

            <option value="2:00 PM">2:00 PM</option>
            <option value="2:15 PM">2:15 PM</option>
            <option value="2:30 PM">2:30 PM</option>
            <option value="2:45 PM">2:45 PM</option>

            <option value="3:00 PM">3:00 PM</option>
            <option value="3:15 PM">3:15 PM</option>
            <option value="3:30 PM">3:30 PM</option>
            <option value="3:45 PM">3:45 PM</option>

            <option value="4:00 PM">4:00 PM</option>
            <option value="4:15 PM">4:15 PM</option>
            <option value="4:30 PM">4:30 PM</option>
            <option value="4:45 PM">4:45 PM</option>

            <option value="5:00 PM">5:00 PM</option>
            <option value="5:15 PM">5:15 PM</option>
            <option value="5:30 PM">5:30 PM</option>
            <option value="5:45 PM">5:45 PM</option>
        </select>
        
        <h5>How would you like us to reach out ?</h5>
        <select name="data[UserPreference][Contact][type]" id="contact-type" required=required >
            <option value="">Contact type</option>
            <option value="Phone">Phone</option>
            <option value="Email">Email</option>
            <option value="Skype">Skype</option>
        </select>  
        
        <h5>who did you hear about SRS from?</h5>         
        <?php
            echo $this->Form->input('personal_shopper', array('label' => false, 'name' => 'data[User][personal_shopper]', 'maxlength' => 50, 'value' => $personal_shopper));
        ?>   
        
        <input type="hidden" value="completed" name="data[UserPreference][is_complete]" />    
        
        
        <div class="text-center about-submit">                   
            <div class="submit">
                <input type="submit" value="Upload" /> 
                <a class="link-btn black-btn back-btn1" href="<?php echo $this->webroot; ?>users/register/brands/<?php echo $user_id; ?>">Back</a>  
            </div>                        
            <br/>
            </form>
        </div>        
         
         <br /><br /><br /><br /><br />    
         </div>
    </div>    
    <br/> 
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
        $("#upload-img").click(function(){
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