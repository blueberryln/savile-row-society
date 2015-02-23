<?php
$script = '
function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
$(document).ready(function(){    
    $("#Contact-Us").on("click", function(e){
        e.preventDefault();
        var error = false;
        var errMsg = "Please complete the required fields.";
        $("#ContactDisplayForm input[type=text], #ContactDisplayForm textarea").each(function(){
            if($(this).data("required") && $(this).val() == ""){
                error = true;    
            }
            else if($(this).attr("id") == "ContactEmail"){
                if(!IsEmail($(this).val())){
                    error = true;    
                    errMsg = "Please enter a valid email address."
                }
            }
        });
        
        if(error){
            $(".err-message").text(errMsg);
            $(".err-message").fadeIn(300);
        }
        else{
            $(".err-message").fadeOut(300);
            $("#ContactDisplayForm").submit();
        }
    });
});
';

$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));

$meta_description = 'Contact us via email, give us a call(347-878-7280) or visit us in our showroom. Savile Row Society is New York based online shopping website online.';
$meta_keywords = 'Savile Row Society, online fashion website, Online shopping website, online fashion shopping';

$this->Html->meta("keywords", $meta_keywords, array("inline" => false));
$this->Html->meta('description', $meta_description, array('inline' => false));
?>
<div class="content-container content-container-contact">
    <div class="eleven columns container content inner">
        <div class="twelve columns container left message-box">
            <div class="blank-space">&nbsp;</div>
            <div class="container content inner">	
                <div class="ten columns text-center page-heading">
                    <h1>Contact Us</h1>
                </div>
                <div class="contact-container ten columns page-content">
                    <div class="contact-form five columns page-content left">
                        <div class="form">
                            <?php echo $this->Form->create('Contact', array('url' => array('controller' => 'contacts', 'action' => 'index'))); ?>
                            <?php
                            echo $this->Form->hidden('contact_type_id', array('value' => 1));
                            if(isset($user)){
                                echo $this->Form->input('first_name', array('value' => $user['User']['first_name'], 'label' => 'First Name*', 'required' => false, 'data-required' => 'required'));
                                echo $this->Form->input('last_name', array('value' => $user['User']['last_name'], 'label' => 'Last Name*', 'required' => false, 'data-required' => 'required'));
                                echo $this->Form->input('email', array('type' => 'text', 'value' => $user['User']['email'], 'label' => 'Email*', 'required' => false, 'data-required' => 'required'));
                                echo $this->Form->input('phone', array('value' => $user['User']['phone'], 'required' => false));
                            }
                            else{
                                echo $this->Form->input('first_name', array('label' => 'First Name*', 'required' => false, 'data-required' => 'required'));
                                echo $this->Form->input('last_name', array('label' => 'Last Name*', 'required' => false, 'data-required' => 'required'));
                                echo $this->Form->input('email', array('type' => 'text', 'label' => 'Email*', 'required' => false, 'data-required' => 'required'));
                                echo $this->Form->input('phone');
                            }
                            echo $this->Form->input('message', array('label' => 'Message*', 'required' => false, 'data-required' => 'required'));
                            ?>
                            <?php echo $this->Form->end(array('class' => 'full-width black-btn', 'id' => 'Contact-Us', 'value' => 'SUBMIT')); ?>
                            <span class="err-message">Please complete the required fields.</span>
                        </div>  
                    </div>
                    <div class="contact-map-info five columns page-content right">
                        <div class="contact-map no-margin">
                            <iframe width="370" height="200" scrolling="no" frameborder="0" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3022.99474281726!2d-73.9924649!3d40.7401412!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259a30dea63cf%3A0x2249fd473bf11f33!2s1115+Broadway!5e0!3m2!1sen!2sin!4v1394536779484" marginwidth="0" marginheight="0"></iframe>
                        </div>
                        <div class="contact-info no-margin">
                            <h4>Showroom:</h4>
                            <p>1115 Broadway | 10th Floor<br />New York, NY  10010</p>
                            <p class="phone">+1 347 878 7280</p>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</div>