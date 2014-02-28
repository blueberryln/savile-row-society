<?php
$meta_description = 'Your personal settings.';
$this->Html->meta('description', $meta_description, array('inline' => false));
$script = '
$(function(){
    $(".submit-profile").on("click", function(e){
        e.preventDefault();
        $("#UserEditForm").submit();
    });    
});
';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
?>
<div class="content-container">
    <div class="container content inner">	
        <div class="eight columns register-steps center-block">
            <div class="profile-tabs text-center">
                <a class="link-btn black-btn my-style" href="<?php echo $this->webroot; ?>profile/about">My Style</a>
                <a class="link-btn gold-btn my-profile" href="<?php echo $this->webroot; ?>myprofile">My Profile</a>
            </div>
        </div>
        <?php echo $this->Form->create('User'); ?>        
        <div class="seven columns contact-container center-block">
            <div class="form">
                <?php
                echo $this->Form->input('id');
                echo $this->Form->input('first_name');
                echo $this->Form->input('last_name');
                echo $this->Form->input('email', array('readonly'));
                echo $this->Form->input('phone');
                echo $this->Form->input('password_new', array('label' => 'New password', 'type' => 'password'));
                ?>
            </div>
            <div class="profile text-center" >            
                <a class="link-btn black-btn submit-profile" href="">SUBMIT</a>            
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>