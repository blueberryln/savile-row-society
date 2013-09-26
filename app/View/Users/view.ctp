<?php
$meta_description = 'Your personal settings.';
$this->Html->meta('description', $meta_description, array('inline' => false));
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
                echo $this->Form->input('id', array('readonly'));
                echo $this->Form->input('first_name', array('readonly'));
                echo $this->Form->input('last_name', array('readonly'));
                echo $this->Form->input('email', array('readonly'));
                echo $this->Form->input('password_new', array('label' => 'New password', 'type' => 'password', 'readonly'));
                ?>
            </div>
        </div>
        <div class="srs-form columns five offset-by-two alpha">
            <div class="form form1">
                <?php
                echo $this->Form->input('phone', array('readonly'));
                //echo $this->Form->input('title');
                echo $this->Form->input('industry', array('readonly'));
                echo $this->Form->input('location', array('readonly'));
                echo $this->Form->input('heard_from', array('label' => 'How did you hear about us', 'readonly'));
                ?>
            </div>  
        </div>
        <div class="clear"></div>
        <div class="profile text-center" >
            <br />
            <a class="link-btn black-btn" href="<?php echo $this->webroot . 'myprofile/edit'?>">EDIT PROFILE</a>
            <br /><br /><br /><br />
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
            