<?php
$meta_description = 'As a member, you will be up to date on styles, always look put together, and develop a wardrobe that captures the look you desire.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>
<div class="container content inner booking">		
    <div class="sixteen columns hero">
        <h2>Personal Trainer</h2>
        <img class="three columns" src="<?php echo $this->request->webroot; ?>img/blogger-06.jpg" alt="Andrew Kalley" />
        <div class="seven columns alpha omega team-member">
            <div class="name">Andrew Kalley</div>
            <div class="title">Health and Fitness Consultant</div>
            <p>
                Andrew Kalley became a personal trainer in 2002 and a USA triathlon coach in 2006. He has a B.S. in Sports Management, a NASM CPT Certification, and a USAT Level II Triathlon Coaching Certification. Andrew has always been active. He grew up playing hockey and wrestled throughout high school. 
            </p>
        </div>

        <iframe class="six columns" height="200" src="http://www.youtube.com/embed/dWqcWgGitKQ" frameborder="0" allowfullscreen></iframe>

    </div>
    <div class="sixteen columns book-appointment">
        <h2>Contact us</h2>
    </div>
    <div class="eight columns book-appointment">
        <div class="seven columns">
            <?php echo $this->Form->create('Contact', array('url' => array('controller' => 'contacts', 'action' => 'trainer'))); ?>
            <?php
            echo $this->Form->hidden('contact_type_id', array('value' => 2));
            echo $this->Form->input('first_name', array('value' => $user['User']['first_name']));
            echo $this->Form->input('last_name', array('value' => $user['User']['last_name']));
            echo $this->Form->input('email', array('value' => $user['User']['email']));
            echo $this->Form->input('phone', array('value' => $user['User']['phone']));
            echo $this->Form->input('message');
            ?>
            <?php echo $this->Form->end(__('Send')); ?>
        </div>
    </div>
    <div class="eight columns alpha">

        <iframe width="425" height="250" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=902+Broadway,+New+York,+NY,+United+States&amp;sll=40.763641,-73.977728&amp;sspn=0.056948,0.132093&amp;ie=UTF8&amp;hq=&amp;hnear=902+Broadway,+New+York,+10010&amp;t=m&amp;z=14&amp;iwloc=A&amp;output=embed&iwloc=near"></iframe>
        <div class="seven columns">
            <h4>1350 Avenue of the Americas, New York</h4><br/>
            <h6 class="phone">785-745-1456</h6><br/>
            <h5><a href="mailto:&#099;&#111;&#110;&#116;&#097;&#099;&#116;&#117;&#115;&#064;&#115;&#097;&#118;&#105;&#108;&#101;&#114;&#111;&#119;&#115;&#111;&#099;&#105;&#101;&#116;&#121;&#046;&#099;&#111;&#109;">&#099;&#111;&#110;&#116;&#097;&#099;&#116;&#117;&#115;&#064;&#115;&#097;&#118;&#105;&#108;&#101;&#114;&#111;&#119;&#115;&#111;&#099;&#105;&#101;&#116;&#121;&#046;&#099;&#111;&#109;</a></h5><br/>
        </div>
    </div>
</div>