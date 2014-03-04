<?php
$script = '  
var size = ' . json_encode($size) . '; 
$(document).ready(function(){ 

        /****Jeans Cut*****/
        $("div#jeans-cut li").click(function(){
            $("p.error-msg").slideUp(300);
            $(this).addClass("ui-selected").siblings().removeClass("ui-selected");
            var selected_id = $(this).data("id");
            $("#jeans-cut input:checkbox#" + selected_id).prop("checked", true);
        });

        $("div#shirt-cut li").click(function(){
            $("p.error-msg").slideUp(300);
            $(this).addClass("ui-selected").siblings().removeClass("ui-selected");
            var selected_id = $(this).data("id");
            $("#shirt-cut input:checkbox#" + selected_id).prop("checked", true);
        });

        $("div.submit input").click(function(){
            if($("div#jeans-cut").find("li.ui-selected").length == 0 || $("div#shirt-cut").find("li.ui-selected").length == 0)
            {
                event.preventDefault();
                $("p.error-msg").slideDown(300);
            }            
        });   

        function getIdFromString(s){
            switch(s){
                case "Bootcut": return 1;
                case "Relaxed": return 2;
                case "Straight": return 3;
                case "Slim": return 4;
                case "SlimShirt": return 5;
                case "RegularShirt": return 6;
                case "RelaxedShirt": return 6;
                default: return 0;    
            }
        }
        
        if(size["denim_kind"]){
            // Mark saved style as selected
            var selectedId = getIdFromString(size["denim_kind"]);
            if(selectedId != 0){
                var liCondition = \'li[data-id = "\' + selectedId + \'"]\';            
                var inputCondition = "#" + selectedId;

                $(liCondition).attr("class", "ui-state-default ui-selectee ui-selected");
                $(inputCondition).prop("checked", true);
            }
        }

        if(size["shirt_size"]){
            // Mark saved style as selected
            var selectedId = getIdFromString(size["shirt_size"]);
            if(selectedId != 0){
                var liCondition = \'li[data-id = "\' + selectedId + \'"]\';            
                var inputCondition = "#" + selectedId;

                $(liCondition).attr("class", "ui-state-default ui-selectee ui-selected");
                $(inputCondition).prop("checked", true);
            }
        }
        
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
        <?php echo $this->Form->create('User', array('url' => '/register/saveStyle', 'id' => 'register-size', 'type' => 'file')); ?>
        <div class="nine columns center-block">
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
                    <input class="hide" type="radio" name="data[UserPreference][StyleSize][denim_kind]" value="Bootcut" id="1" />
                    <input class="hide" type="radio" name="data[UserPreference][StyleSize][denim_kind]" value="Relaxed" id="2" />
                    <input class="hide" type="radio" name="data[UserPreference][StyleSize][denim_kind]" value="Straight" id="3" />
                    <input class="hide" type="radio" name="data[UserPreference][StyleSize][denim_kind]" value="Slim" id="4" />
                    <ol id="selectable">
                        <li class="ui-state-default" data-id="1"><img src="<?php echo $this->request->webroot; ?>img/size/Bootcut.jpg" class="fadein-image" /><br/>Bootcut</li>
                        <li class="ui-state-default" data-id="2"><img src="<?php echo $this->request->webroot; ?>img/size/Relaxed.png" class="fadein-image" /><br/>Relaxed</li>
                        <li class="ui-state-default" data-id="3"><img src="<?php echo $this->request->webroot; ?>img/size/Straight.png" class="fadein-image" /><br/>Straight</li>
                        <li class="ui-state-default" data-id="4"><img src="<?php echo $this->request->webroot; ?>img/size/Slim.png" class="fadein-image" /><br/>Slim</li>
                    </ol>
                </div>
            </div>

            <div class="hi-message twelve columns text-center">                
                <h4>Dress Shirt Cut</h4>
            </div>
            <div class="twelve columns center-block text-center">
                <div id="shirt-cut">
                    <input class="hide" type="radio" name="data[UserPreference][StyleSize][shirt_size]" value="SlimShirt" id="5" />
                    <input class="hide" type="radio" name="data[UserPreference][StyleSize][shirt_size]" value="RegularShirt" id="6" />
                    <input class="hide" type="radio" name="data[UserPreference][StyleSize][shirt_size]" value="RelaxedShirt" id="7" />
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