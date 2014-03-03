<?php
$script = '  
var size = ' . json_encode($size) . '; 
$(document).ready(function(){ 
        
        /****Jeans Cut*****/
        $("div#jeans-cut li, div#shirt-cut li").click(function(){
            $("p.error-msg").slideUp(300);
            $(this).addClass("ui-selected").siblings().removeClass("ui-selected");
        });

        $("div.submit input").click(function(){
            if($("div#jeans-cut").find("li.ui-selected").length == 0 || $("div#shirt-cut").find("li.ui-selected").length == 0)
            {
                event.preventDefault();
                $("p.error-msg").slideDown(300);
            }            
        });   
        
});
';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));

$meta_description = 'Sign up for Savile Row Society, a groundbreaking online, personalized fashion service.';
$this->Html->meta('description', $meta_description, array('inline' => false));

?>
<script>
window.registerProcess = true;

</script>
<div class="content-container">
    <div class="container content inner preferences register-style">	
        <div class="eight columns register-steps center-block">
            <div class="profile-tabs text-center">
                <a class="link-btn gold-btn my-style" href="<?php echo $this->webroot; ?>profile/about">My Style</a>
                <a class="link-btn black-btn my-profile" href="<?php echo $this->webroot; ?>myprofile">My Profile</a>
            </div>

            <h1 class="text-center">Your Style</h1>
        </div>
        <div class="nine columns center-block">
            <?php echo $this->Form->create('User', array('url' => '/register/saveStyle', 'id' => 'register-size', 'type' => 'file')); ?>
            <div class="hi-message twelve columns text-center">
                
                <h4>Hi <?php echo ucwords($full_name); ?></h4>
                <p>
                    Not to worry, this is totally confidential 
                </p>
                <input type="hidden" value="<?php echo $user_id ?>" name="data[User][id]" />

                <div class='empty-img' id='photo-holder'>
                <img src='<?php echo $image_url; ?>' id='user-photo'/>
                </div>                
                <input type='button' value='Upload photo' id='upload-img' class="gray-btn"/>

                <?php
                    echo $this->Form->input('ProfileImage', array('type' => 'file', 'id'=>'uploader-btn', 'label' => false));
                ?>
                <div class="clear-fix"></div>
            </div>
        </div>
        <div>
            <div class="hi-message twelve columns text-center">                
                <h4>Jeans Cut</h4>
            </div>
            <div class="twelve columns center-block text-center">
                <div id="jeans-cut">
                    <input class="hide" type="checkbox" name="data[UserPreference][StyleSize]" value="Bootcut" id="1" />
                    <input class="hide" type="checkbox" name="data[UserPreference][StyleSize]" value="Relaxed" id="2" />
                    <input class="hide" type="checkbox" name="data[UserPreference][StyleSize]" value="Straight" id="3" />
                    <input class="hide" type="checkbox" name="data[UserPreference][StyleSize]" value="Slim" id="4" />
                    <ol id="selectable">
                        <li class="ui-state-default" data-id="1"><img src="<?php echo $this->request->webroot; ?>img/size/Bootcut.jpg" class="fadein-image" /><br/>Bootcut</li>
                        <li class="ui-state-default" data-id="2"><img src="<?php echo $this->request->webroot; ?>img/size/Relaxed.png" class="fadein-image" /><br/>Relaxed</li>
                        <li class="ui-state-default" data-id="3"><img src="<?php echo $this->request->webroot; ?>img/size/Straight.png" class="fadein-image" /><br/>Straight</li>
                        <li class="ui-state-default" data-id="4"><img src="<?php echo $this->request->webroot; ?>img/size/Slim.png" class="fadein-image" /><br/>Slim</li>
                    </ol>
                </div>
                <!-- <div class="input text required">
                    <label for="jeans">WHAT KIND OF JEANS DO YOU WEAR?</label>                            
                    <select name="data[UserPreference][StyleSize][denim_kind]" tabindex="" id="jeans" >
                        <option value="DON'T KNOW">Don't Know</option>
                        <option value="RELAXED FIT">Relaxed Fit</option>
                        <option value="BOOT CUT">Boot Cut</option>
                        <option value="STRAIGHT LEG">Straight Leg</option>
                        <option value="SLIM">Slim</option>
                        <option value="EXTRA SLIM">Extra Slim</option>
                    </select>
                </div>

                <div class="input text required">
                    <label for="shirtSize">Dress Shirt Cut:</label>                            
                    <select name="data[UserPreference][StyleSize][shirt_size]" tabindex="" id="shirtSize" >
                        <option value="">Size</option>
                        <option value="14">14</option>
                        <option value="14.5">14.5</option>
                        <option value="15">15</option>
                        <option value="15.5">15.5</option>
                        <option value="16">16</option>
                        <option value="16.5">16.5</option>
                        <option value="17">17</option>
                        <option value="17.5">17.5</option>
                        <option value="Other">Other</option>
                        <option value="Don't know">Don't know</option>
                    </select>
                </div> -->
            </div>
            <div class="hi-message twelve columns text-center">                
                <h4>Dress Shirt Cut</h4>
            </div>
            <div class="twelve columns center-block text-center">
                <div id="shirt-cut">
                    <input class="hide" type="checkbox" name="data[UserPreference][StyleSize]" value="Slim" id="5" />
                    <input class="hide" type="checkbox" name="data[UserPreference][StyleSize]" value="Regular" id="6" />
                    <input class="hide" type="checkbox" name="data[UserPreference][StyleSize]" value="Relaxed" id="7" />
                    <ol id="selectable">
                        <li class="ui-state-default" data-id="5"><img src="<?php echo $this->request->webroot; ?>img/size/shirt-slim.png" class="fadein-image" /><br/>Slim</li>
                        <li class="ui-state-default" data-id="6"><img src="<?php echo $this->request->webroot; ?>img/size/Regular.png" class="fadein-image" /><br/>Regular</li>
                        <li class="ui-state-default" data-id="7"><img src="<?php echo $this->request->webroot; ?>img/size/shirt-relaxed.png" class="fadein-image" /><br/>Relaxed</li>                        
                    </ol>
                </div>
            </div>
            <div class="clear-fix"></div>
            <div class="text-center about-submit">
                <br/>
                <div class="submit">                            
                    <a class="link-btn black-btn back-btn" href="<?php echo $this->webroot; ?>users/register/wardrobe/<?php echo $user_id; ?>">Back</a> 
                    <input type="submit" value="Continue" /> 
                    <p class="error-msg">All the fields are mandatory.</p>      
                </div>                 
                </form>
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