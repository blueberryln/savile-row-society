<?php
$meta_description = 'Your personal settings.';
$this->Html->meta('description', $meta_description, array('inline' => false));
$script = '
    $(document).ready(function(){
        $(".submit-profile").on("click", function(e){
            e.preventDefault();
            $(this).closest("form").submit(); 
        });

        $("#UserHeardFrom").on("change", function(){
            if($(this).val() == "Friend"){
                $("#UserFriendEmail").closest("div.input").slideDown(300);
            }
            else{
                $("#UserFriendEmail").closest("div.input").slideUp(300);
            }
        });

        if($("#UserHeardFrom").val() == "Friend"){
            $("#UserFriendEmail").closest("div.input").slideDown(300);
        }
        else{
            $("#UserFriendEmail").closest("div.input").hide(300);
        }
    });
';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
?>
<div class="container content inner">	
    <div class="sixteen columns text-center">
        <h1>PROFILE</h1>
    </div>
    <div class="fifteen columns offset-by-half">
        <div class="profile-tabs text-center">
                    <a class="link-btn gray-btn" href="">My Style</a>
                    <a class="link-btn gold-btn" href="">My Profile</a>
        </div>
    </div>
    <?php echo $this->Form->create('User'); ?>        
    <div class="contact-container">
        <div class="srs-form columns five offset-by-two omega">
            <div class="form">
                <?php
                echo $this->Form->input('id');
                echo $this->Form->input('first_name');
                echo $this->Form->input('last_name');
                echo $this->Form->input('email', array('readonly'));
                echo $this->Form->input('password_new', array('label' => 'New password', 'type' => 'password'));
                ?>
            </div>
        </div>
        <div class="srs-form columns five offset-by-two alpha">
            <div class="form form1">
                <?php
                echo $this->Form->input('phone');
                //echo $this->Form->input('title');
                echo $this->Form->input('industry');
                echo $this->Form->input('location');
                echo $this->Form->input('heard_from', array('label' => 'How did you hear about us', 'type' => 'select', 'required' => 'required', 'options' => $heard_from_options));
                echo $this->Form->input('friend_email');
                ?>
            </div>  
        </div>
        <div class="clear"></div>
        <div class="profile text-center" >
            <br />
            <a class="link-btn black-btn submit-profile" href="">SUBMIT</a>
            <br /><br /><br /><br />
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>