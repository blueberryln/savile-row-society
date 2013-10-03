<?php
$meta_description = 'Contact us and we can help with any and all fashion obligations. Have a last minute invite to a gala and the suit you had laid out is not ready from the dry cleaners?';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>
<div class="container content inner">	
    <div class="sixteen columns text-center">
        <h1>Contact Us</h1>
    </div>
    <div class="contact-container">
        <div class="contact-form columns six offset-by-one">
            <div class="form">
                <?php echo $this->Form->create('Contact', array('url' => array('controller' => 'contacts', 'action' => 'index'))); ?>
                <?php
                echo $this->Form->hidden('contact_type_id', array('value' => 1));
                if(isset($user)){
                    echo $this->Form->input('first_name', array('value' => $user['User']['first_name']));
                    echo $this->Form->input('last_name', array('value' => $user['User']['last_name']));
                    echo $this->Form->input('email', array('value' => $user['User']['email']));
                    echo $this->Form->input('phone', array('value' => $user['User']['phone']));
                }
                else{
                    echo $this->Form->input('first_name');
                    echo $this->Form->input('last_name');
                    echo $this->Form->input('email');
                    echo $this->Form->input('phone');
                }
                echo $this->Form->input('message');
                ?>
                <?php echo $this->Form->end(array('class' => 'full-width', 'value' => 'SUBMIT')); ?>
            </div>  
        </div>
        <div class="contact-map-info columns seven offset-by-one">
            <div class="contact-map no-margin">
                <iframe width="370" height="200" scrolling="no" frameborder="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=902+Broadway,+New+York,+NY,+United+States&amp;sll=40.763641,-73.977728&amp;sspn=0.056948,0.132093&amp;ie=UTF8&amp;hq=&amp;hnear=902+Broadway,+New+York,+10010&amp;t=m&amp;z=14&amp;iwloc=A&amp;output=embed&amp;iwloc=near" marginwidth="0" marginheight="0"></iframe>
            </div>
            <div class="contact-info no-margin">
                <h4>Showroom:</h4>
                <p>902 Broadway, 6th Floor, <br />New York, NY 10010</p>
                <p class="phone">+1 347 878 7280</p>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>