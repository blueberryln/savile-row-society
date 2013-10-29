<?php
$meta_description = 'As a member, you will be up to date on styles, always look put together, and develop a wardrobe that captures the look you desire.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>
<div class="container content inner booking">
    <div class="sixteen columns text-center ">
        <img src="<?php echo $this->webroot; ?>img/home-4.jpg" style="margin-top: 10px;">
    </div>
    <div class="sixteen columns hero">
        <div class="sixteen columns text-center">
            <h1>Welcome to Savile Row Society!</h1>
            <h6>
                We've matched you with Casey, our premier personal stylist. <br/>
                You can make any request to her or <a href="<?php echo $this->request->webroot; ?>booking">book an appointment</a> with our tailor. <br/>
                Before we get to know you, check out our highlighted products available in the <a href="<?php echo $this->request->webroot; ?>closet">The Closet</a>.
            </h6>
            <br/><br/>
        </div>
        <h2>SRS Selected Stylist for You</h2>
        <div class="team-member">
            <img class="three columns fadein-image" src="<?php echo $this->request->webroot; ?>img/blogger-05.2.jpg" alt="Casey Golden" />
            <!-- <div class="ten columns alpha omega team-member text-justiy">        -->
       
            <div class="ten columns text-justify" >

                <div class="name">Casey Golden</div>
                <div class="title">Stylist</div>
                <p>Casey's seen more men in their boxers than she should ever admit.  She has been a personal shopper and stylist for nearly a decade. Her specialty is immediately identifying your unique style and creating a lifestyle functional wardrobe around it. Casey accomplishes these tasks in a truly effortless way, leaving you with a style that looks polished, yet natural. In her own words, Casey reassures you that  "You can take all the credit--I was never here."</p>
                <div class="long-desc hide">
                    <p>She truly believes that getting dressed in the morning should be easier than brewing a pot of coffee and that NO "style" or "matching" decisions should occur that early in the morning. Casey creates an effortless wardrobe based on function, and then finds the best pieces in key elements that will allow you to perfectly coordinate outfits without having to think it-because she already did. Her experience in the best (and some of the worst) closets allows SRS to develop our member's wardrobes at any pace by using her unique lifestyle mapping guide to evolve your style naturally.</p>
                    <p>Casey studied International Business in France at the American University of Paris before coming back to the States to spend two years in apparel design.  After realizing she knew more about sewing than her classmates, she sold her books and began working at Mario's, a luxury specialty store well-known for its menswear collection.</p>
                     
                    <p><strong><em><ins>Ask the Stylist</ins></em></strong></p>
                    <p><strong>Ask the Stylist</strong>: For the man who is on a budget but willing to spend on a few good pieces, which items should he invest in first?<br />
                    <strong>Casey says</strong>: Great fitting jeans and a pair of "real" shoes.</p>
                    
                    <p><strong>Ask the Stylist</strong>: Who's your personal fashion icon?<br />
                    <strong>Casey says</strong>: My greatest style inspiration is Brunello Cucinelli because it is the only collection I can look at 60 hours a week season after season and still love every piece. The style speaks to me with the intertwining textures of satin, suede, cashmere, leather, wool, cotton and fur; his line will always evoke a reaction of love and admiration for details. "The King of Cashmere" will always be my #1.</p>
                    
                    <p><strong>Ask the Stylist</strong>: What three items could you not live without?<br />
                    <strong>Casey says</strong>: My surfboard, a pen, and paper.</p>
                    <br />
                    <div>
                        <iframe class="max-width-adj" width="460" height="315"  src="//www.youtube.com/embed/VlLYFFr7dU8" frameborder="0" allowfullscreen></iframe>
                        <br /><br />
                    </div>
                </div>
                <div class="text-center">
                    <a class="show-more-text" href="#" title="Show more">Show more</a>
                </div>
            </div>
        </div>       
    </div>
    <div class="fifteen offset-by-half columns book-appointment">
        <br />
        <h2>Contact us</h2>
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