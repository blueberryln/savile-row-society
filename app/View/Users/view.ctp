<?php
$meta_description = 'Your personal settings.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>
<div class="content-container">
    <div class="container content inner">	
        <div class="eight columns text-center page-heading">
            <h1>PROFILE</h1>
        </div>
        <div class="eight columns register-steps center-block">
            <div class="profile-tabs text-center">
                        <a class="link-btn gray-btn my-style" href="<?php echo $this->webroot; ?>profile/about">My Style</a>
                        <a class="link-btn black-btn my-profile" href="<?php echo $this->webroot; ?>myprofile">My Profile</a>
            </div>
        </div>
        <?php echo $this->Form->create('User'); ?>        
        <div class="nine columns contact-container center-block">
            <div class="srs-form five columns left">
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
            <div class="srs-form five columns right">
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
            <div class="clear-fix"></div>
            <div class="profile text-center" >            
                <a class="link-btn black-btn" href="<?php echo $this->webroot . 'myprofile/edit'?>">EDIT PROFILE</a>
                <br />
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
            