<?php
$script = ' 
    $(function(){
        $("div.submit input").click(function(event){             
            if($("input").val() == "" || $("select").val() == "")
            {                                      
                $("p.error-msg").slideDown(300);                
                event.preventDefault();            
            }
        });
    });
';

$this->Html->script('//code.jquery.com/ui/1.10.3/jquery-ui.min.js', array('inline' => false));
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
?>

<div class="content-container">
    <div class="container content inner register-about">	
        <div class="eight columns register-steps center-block">
            <div class="profile-tabs text-center">
                <a class="link-btn gold-btn my-style" href="<?php echo $this->webroot; ?>profile/about">My Style</a>
                <a class="link-btn black-btn my-profile" href="<?php echo $this->webroot; ?>myprofile">My Profile</a>
            </div>

            <h1 class="text-center">About You</h1>
        </div>

        <!-- <div class="eight columns text-center page-heading">
            <h1>About You</h1>
        </div> -->
        <div class="seven columns center-block">
            <?php echo $this->Form->create('User', array('url' => '/register/saveAbout')); ?>
            <input type="hidden" value="<?php echo $user_id ?>" name="data[User][id]" />
            <div class="hi-message">
                <h4 class="hi-message"><?php echo ucwords($full_name); ?></h4>
                <p>
                    Use this space to introduce yourself, tell us
                </p>
            </div>
            
            <div class="srs-form">
                <div class="form">
                <?php
                echo $this->Form->input('User.industry', array('label' => 'Industry', 'type' => 'select', 'required' , 'options' => $industry, 'empty' => 'Select Industry'));
                ?>
                <div class="input select dob">
                <label for="UserDayDay">Date of birth</label>
                <?php 
                    echo $this->Form->day('day', array('div' => false, 'empty' => 'Day', 'label' => false, 'required', 'name' => 'data[User][day]'));
                    echo $this->Form->month('month', array('monthNames' => false, 'div' => false, 'empty' => 'Month', 'label' => false, 'required', 'name' => 'data[User][month]'));
                    echo $this->Form->year('year', 1900, date('Y'), array('div' => false, 'empty' => 'Year', 'label' => false, 'class' => 'last', 'required', 'name' => 'data[User][year]'));         
                ?>          
                </div>      
                <?php   
                    echo $this->Form->input('zip', array("label"=>"Zipcode",'required', "placeholder" => "Zipcode"));
                ?>
                <div class="clear-fix"></div>
                </div>
            </div>

            <div class="text-center about-submit">
                <br/>
                <?php echo $this->Form->end(__('Continue')); ?> 
                <p class="error-msg">All the fields are mandatory.</p>    
                   
            </div>
            
        </div>
        
    </div>
</div>