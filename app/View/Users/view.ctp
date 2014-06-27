<?php
$meta_description = 'Your personal settings.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>
<div class="content-container">
    <div class="container content inner">	
        <div class="eight columns register-steps center-block">
            <div class="profile-tabs text-center">
                <a class="link-btn black-btn my-style" href="<?php echo $this->webroot; ?>register/wardrobe">My Style</a>
                <a class="link-btn gold-btn my-profile" href="<?php echo $this->webroot; ?>myprofile">My Profile</a>
            </div>
        </div>
        <?php echo $this->Form->create('User'); ?>        
        <div class="seven columns contact-container center-block">
            <div class="form">
                <?php
                echo $this->Form->input('id', array('readonly'));
                echo $this->Form->input('first_name', array('readonly'));
                echo $this->Form->input('last_name', array('readonly'));
                echo $this->Form->input('email', array('readonly'));
                echo $this->Form->input('phone', array('readonly'));
                ?>
            </div>
            <div class="profile text-center" >            
                <a class="link-btn black-btn" href="<?php echo $this->webroot . 'myprofile/edit'?>">EDIT PROFILE</a>
                <br />
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
            