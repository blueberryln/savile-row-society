<?php
$meta_description = 'As a member, you will be up to date on styles, always look put together, and develop a wardrobe that captures the look you desire.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>
<div class="content-container">
    <div class="container content inner refer-a-friend">           
        <div class="eight columns text-center page-heading">
            <h1>Be a Hero</h1>
            <h1>End the shopping nightmare for your friends.</h1>
        </div>
        <div class="eight columns page-content">        
            <p>You were hooked up with Savile Row Society - now it's time to hook up others. Share <span class="gold">SRS</span> with your friends and family and they'll receive <span class="gold">$50</span> off of their first purchase of <span class="gold">$250</span> or more </p>
        </div>
        <div class="eight columns page-content refer-options">
            <div class="refer-way one">
                <div class="icon">
                    <img class="" src="<?php echo $this->request->webroot; ?>img/facebook-small.png" /> 
                </div>
                <div class="rw-content nine columns">
                    <h3>Your personal refer link:</h3>
                    <div class="rw-field">
                        <input class="ten columns" type="text" placeholder="http://www.savilerowsociety.com" >                        
                    </div>                    
                </div>
            </div>
            <div class="refer-way two">
                <div class="icon">
                    <img class="" src="<?php echo $this->request->webroot; ?>img/facebook-small.png" /> 
                </div>
                <div class="rw-content nine columns">
                    <h3>Mail it</h3>
                    <span>To</span>
                    <div class="rw-field">
                        <input class="ten columns" type="text" placeholder="david123456@gmail.com" > 
                        <a href="" class="link-btn gold-btn">Send</a>                       
                    </div>
                </div>
            </div>
            <div class="refer-way three">
                <div class="icon">
                    <img class="" src="<?php echo $this->request->webroot; ?>img/facebook-small.png" /> 
                </div>
                <div class="rw-content nine columns">
                    <h3>Share it on Facebook</h3>                    
                </div>
            </div>
            
        </div>        
       
    </div>
</div>