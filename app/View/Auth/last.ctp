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
<script>
window.registerProcess = true;

</script>
<div class="content-container">
    <div class="container content inner preferences register-size">	
        <div class="eight columns register-steps center-block">
            

            <ul style="list-style-type: disc;"><li style="float: left;margin-left:109px; color:#ccc"><br /><div style="margin: 0px 0px 0px -30px; color:#ccc">Style</div></li><li style="float: left;margin-left:200px;color:#ccc"><br /><div style="margin: 0px 0px 0px -30px; color:#ccc">Size</div></li><li style="float: left;margin-left:200px;color:#396"><br /><div style="margin: 0px 0px 0px -30px;color:#396">Info</div></li></ul>
           <hr / style="margin-bottom:5px;">
            <h1 class="text-center" style="font-size: 20px;">Tell us more about yourself</h1>
          
        </div>
        


         <div class="hi-message">
               
                <p style='margin: -15px 0px 30px 185px;
width: 630px;'>
                    Help our stylists get to know you better to create a more personalized experience.
                </p>
            </div>
        <div class="seven columns center-block" style="border:1px solid #396; ">
            <?php echo $this->Form->create('User'); ?>
          <style>
          .content .input,
		  select#contact-type {
margin: 0 0 18px 38px;
width: 210px;
float: left;
}
          </style>
            
           <?php
                    echo $this->Form->input('User.first_name', array('id' => 'first-name', 'label' => 'First Name:','required', 'placeholder' => 'FIRST NAME'));
                    echo $this->Form->input('User.last_name', array('id' => 'last-name', 'label' => 'Last Name:','required', 'placeholder' => 'LAST NAME'));
                    echo $this->Form->input('User.email', array('id' => 'register-email', 'label' => 'Email:','required', 'placeholder' => 'EMAIL'));
                    echo $this->Form->input('User.zip', array("label"=>"Zipcode", "placeholder" => "Zipcode"));
				    echo $this->Form->input('User.skype', array( 'label' => 'Skype Id:', 'placeholder' => 'Skype Id'));
					echo $this->Form->input('User.password', array('id' => 'register-password', 'label' => 'Password:','required', 'placeholder' => 'PASSWORD'));
					echo $this->Form->input('User.Confirm_password', array('id' => 'register-password', 'label' => 'Confirm Password:', 'placeholder' => 'CONFIRM PASSWORD'));
					
                ?>     
                        
            <div class="clear-fix"></div>
            <div class="text-center about-submit">
                 <br/>   
                                     
                    <div class="submit">                            
                        <!--<a class="link-btn black-btn back-btn" href="<?php echo $this->webroot; ?>users/register/style/">Back</a>--> 
                        <?php echo $this->Form->end(__('Continue')); ?>
                        <p class="error-msg">All the fields are mandatory.</p>
                    </div>
                 </form>
            </div>
        </div>
    </div>
</div>
