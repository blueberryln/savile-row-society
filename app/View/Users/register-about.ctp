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
        
        <div class="srs-form five columns alpha omega offset-by-two">
            <div class="form">
            <?php
            echo $this->Form->input('User.phone', array( "label"=>"Phone Number", "placeholder" => "Phone number"));
            echo $this->Form->input('User.industry', array('label' => 'Industry', 'type' => 'select', 'required' => 'required', 'options' => $industry, 'empty' => 'Select Industry'));
            ?>
            <div class="input select dob">
            <label for="UserDayDay">Date of birth</label>
            <?php 
                echo $this->Form->day('day', array('div' => false, 'empty' => 'Day', 'label' => false, 'required', 'name' => 'data[User][day]'));
                echo $this->Form->month('month', array('monthNames' => false, 'div' => false, 'empty' => 'Month', 'label' => false, 'required', 'name' => 'data[User][month]'));
                echo $this->Form->year('year', 1900, date('Y'), array('div' => false, 'empty' => 'Year', 'label' => false, 'class' => 'last', 'required', 'name' => 'data[User][year]'));         
            ?>          
            </div>         
            <div class="clear"></div>
            </div>
        </div>
        
        
        <div class="srs-form five columns alpha omega offset-by-two">
            <div class="form">
            <?php
            echo $this->Form->input('User.location', array("id"=>"location", "label"=>"City/State", "placeholder" => "City, State"));
            echo $this->Form->input('User.skype', array("id"=>"skype", "label"=>"Skype ID", "placeholder" => "Skype ID"));
            echo $this->Form->input('zip', array("label"=>"Zipcode", "placeholder" => "Zipcode"));
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