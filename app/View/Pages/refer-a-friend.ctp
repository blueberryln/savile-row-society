<?php
$script = '
$(document).ready(function(){ 
    $("#inviteFriendsEmail").click(function(e){
        e.preventDefault();
        $.ajax({
            url: "api/referFriendEmail",
            type: "post",
            data: {
                emailList : $("#emailList").val(),    
            },
        }).done(function(res) {
            if(res=="success"){
                $(".referStatus").text("Email Sent");
            }   
            else{
                $(".referStatus").text("Email could not be sent. Try again.");
            } 
        });
    });

    $("#inviteFriendsFB").click(function(e){
        e.preventDefault();
        FB.ui({
          method: "send",
          link: "http://www.savilerowsociety.com/user/refer/' . $user['User']['id'] . '",
        });
    });           
});
';
$this->Html->css('ui/jquery-ui', null, array('inline' => false));
$this->Html->css('ui/jquery.ui.theme', null, array('inline' => false));
$this->Html->script('//code.jquery.com/ui/1.10.3/jquery-ui.min.js', array('inline' => false));
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));


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
            <?php if($user['User']['vip_discount']) : ?>       
                <p>You were hooked up with Savile Row Society - now it's time to hook up others. Share <span class="gold">SRS</span> with your friends and family and they'll receive <span class="gold">$50</span> off of their first purchase of <span class="gold">$250</span> or more.</p>
            <?php else :?>
                <p>Share SRS with your friends and family; you will both receive <span class="gold">$50</span> off of your first purchase of <span class="gold">$250</span> or more.</p>
            <?php endif; ?>
        </div>
        <div class="eight columns page-content refer-options">
            <div class="refer-way one">
                <div class="icon">
                    <img class="" src="<?php echo $this->request->webroot; ?>img/ic_srs.png" /> 
                </div>
                <div class="rw-content nine columns">
                    <h3>Your personal refer link:</h3>
                    <div class="rw-field">
                        <input class="eleven columns" type="text" readonly value="http://www.savilerowsociety.com/user/refer/<?php echo $user['User']['id']; ?>">                        
                    </div>                    
                </div>
            </div>
            <div class="refer-way two">
                <div class="icon">
                    <img class="" src="<?php echo $this->request->webroot; ?>img/mail@2x.png" /> 
                </div>
                <div class="rw-content nine columns">
                    <h3>Mail it</h3>
                    <span>To</span>
                    <div class="rw-field">
                        <input class="ten columns" type="text" placeholder="Email address (comma seperated)" id="emailList" > 
                        <a href="" class="link-btn gold-btn" id="inviteFriendsEmail">Send</a>                       
                    </div>
                    <div class="rw-field">
                        <span class="gold referStatus"></span>
                    </div>
                </div>
            </div>
            <div class="refer-way three">
                <div class="icon">
                    <img class="" src="<?php echo $this->request->webroot; ?>img/fb@2x.png" /> 
                </div>
                <div class="rw-content nine columns">
                    <h3><a href="" id="inviteFriendsFB">Share it on Facebook</a></h3>                    
                </div>
            </div>
            
        </div>        
       
    </div>
</div>