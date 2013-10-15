<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="container content inner">
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
        <div class="reg-step1"><img src="<?php echo $this->webroot; ?>img/reg-step1.png"/></div>
    </div>
    <div class="sixteen columns">
        <?php echo $this->Form->create('User', array('url' => '/register/saveAbout')); ?>
        <input type="hidden" value="<?php echo $user_id ?>" name="data[User][id]" />
        <div class="hi-message fourteen columns offset-by-two alpha omega">
            <h4 class="hi-message"><?php echo $full_name; ?></h4>
            <p>
                Use this space to introduce yourself, tell us
            </p>
        </div>
        
        <div class="srs-form five columns alpha omega text-center offset-by-two">
            <div class="form">
            <?php
            echo $this->Form->input('User.phone', array( "label"=>"", "placeholder" => "Phone number"));
            //echo $this->Form->input('User.industry', array("id"=>"industry", "label" => "", "placeholder" => "Occupational Industry"));
            echo $this->Form->input('User.industry', array('label' => '', 'type' => 'select', 'required' => 'required', 'options' => $industry, 'empty' => 'Select Industry'));
            ?>
            <div class="input select dob">
            <?php 
                echo $this->Form->input('user.month', array('label' => '','div' => false, 'type' => 'select', 'required' => 'required', 'options' => '', 'empty' => 'Month'));   
                echo $this->Form->input('user.day', array('label' => '','div' => false, 'type' => 'select', 'required' => 'required', 'options' => '', 'empty' => 'Day'));
                echo $this->Form->input('user.year', array('label' => '','div' => false,'class' => 'last', 'type' => 'select', 'required' => 'required', 'options' => '', 'empty' => 'Year'));         
                ?>          
            </div>            
            <div class="clear"></div>
            </div>
        </div>
        
        
        <div class="srs-form five columns alpha omega text-center offset-by-two">
            <div class="form">
            <?php
            echo $this->Form->input('User.location', array("id"=>"location", "label"=>"", "placeholder" => "City, State"));
            echo $this->Form->input('User.skype', array("id"=>"skype", "label"=>"", "placeholder" => "Skype ID"));
            echo $this->Form->input('User.zipcode', array("id"=>"zipcode", "label"=>"", "placeholder" => "Zipcode"));
            ?>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="text-center about-submit">
            <br/>
            <?php echo $this->Form->end(__('Continue')); ?>
            <br/><br/><br /><br />
        </div>
        
    </div>
    
</div>