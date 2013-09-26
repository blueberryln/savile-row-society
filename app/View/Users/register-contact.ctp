<?php
$meta_description = 'Sign up for Savile Row Society, a groundbreaking online, personalized fashion service.';
$this->Html->meta('description', $meta_description, array('inline' => false));
$script = ' var contact = ' . json_encode($contact) . '; ' .
' $(document).ready(function(){ 
    if(contact){
        debugger;
        $("#contact-time").val(contact.time);
        $("#contact-type").val(contact.type);        
        $("#heard_from").val(contact.heard_from);        
        
        $("#phone").val(contact.phone);
        $("#industry").val(contact.industry);
        $("#location").val(contact.location);
        $("#skype").val(contact.skype);


    }
});';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
?>
<script>
window.registerProcess = true;
</script>
<div class="container content inner">	
    <div class="sixteen columns text-center">
        <h1>Contact info</h1>
    </div>
    <div class="sixteen columns">
        <?php echo $this->Form->create('User', array('url' => '/register/saveContact')); ?>
        <input type="hidden" value="<?php echo $user_id ?>" name="data[User][id]" />
        <div class="seven columns offset-by-two alpha omega">
            <label for="contact-time">What is the best time <br/>for your stilyst to contact you?</label>
            <select name="data[UserPreference][Contact][time]" id="contact-time" required=required >
                <option value="">Time</option>
                <option value="9:00 AM">9:00 AM</option>
                <option value="9:15 AM">9:15 AM</option>
                <option value="9:30 AM">9:30 AM</option>
                <option value="9:45 AM">9:45 AM</option>

                <option value="10:00 AM">10:00 AM</option>
                <option value="10:15 AM">10:15 AM</option>
                <option value="10:30 AM">10:30 AM</option>
                <option value="10:45 AM">10:45 AM</option>

                <option value="11:00 AM">11:00 AM</option>
                <option value="11:15 AM">11:15 AM</option>
                <option value="11:30 AM">11:30 AM</option>
                <option value="11:45 AM">11:45 AM</option>

                <option value="12:00 PM">12:00 PM</option>
                <option value="12:15 PM">12:15 PM</option>
                <option value="12:30 PM">12:30 PM</option>
                <option value="12:45 PM">12:45 PM</option>

                <option value="1:00 PM">1:00 PM</option>
                <option value="1:15 PM">1:15 PM</option>
                <option value="1:30 PM">1:30 PM</option>
                <option value="1:45 PM">1:45 PM</option>

                <option value="2:00 PM">2:00 PM</option>
                <option value="2:15 PM">2:15 PM</option>
                <option value="2:30 PM">2:30 PM</option>
                <option value="2:45 PM">2:45 PM</option>

                <option value="3:00 PM">3:00 PM</option>
                <option value="3:15 PM">3:15 PM</option>
                <option value="3:30 PM">3:30 PM</option>
                <option value="3:45 PM">3:45 PM</option>

                <option value="4:00 PM">4:00 PM</option>
                <option value="4:15 PM">4:15 PM</option>
                <option value="4:30 PM">4:30 PM</option>
                <option value="4:45 PM">4:45 PM</option>

                <option value="5:00 PM">5:00 PM</option>
                <option value="5:15 PM">5:15 PM</option>
                <option value="5:30 PM">5:30 PM</option>
                <option value="5:45 PM">5:45 PM</option>
            </select>
            <br/><br/>
            <label for="contact-type">How would you like us <br/>to reach you?</label>
            <select name="data[UserPreference][Contact][type]" id="contact-type" required=required >
                <option value="">Contact type</option>
                <option value="Phone">Phone</option>
                <option value="Email">Email</option>
                <option value="Skype">Skype</option>
            </select>
            <br/><br/>
            <?php
            echo $this->Form->input('User.heard_from', array('label' => 'How did you hear about us', 'type' => 'select', 'required' => 'required', 'options' => $heard_from_options, 'name' => "data[UserPreference][Contact][heard_from]", "id"=>"heard_from"));
            ?>
        </div>
        <div class="five columns alpha omega text-center">
            <?php
            echo $this->Form->input('User.phone', array("id"=>"phone", "name"=>"data[UserPreference][Contact][phone]"));
            echo $this->Form->input('User.industry', array("id"=>"industry", "name"=>"data[UserPreference][Contact][industry]"));
            echo $this->Form->input('User.location', array("id"=>"location", "name"=>"data[UserPreference][Contact][location]"));
            echo $this->Form->input('User.skype', array("id"=>"skype", "name"=>"data[UserPreference][Contact][skype]"));
            ?>
        </div>
        <div class="clearfix"></div>

        <div class="text-center">
            <br/>
            <?php echo $this->Form->end(__('Finish sign up')); ?>
            <br/>
        </div>
    </div>
</div>