<?php
$script = '
$(document).ready(function(){ 
    $("#inviteFriendsEmail").click(function(e){
        e.preventDefault();
        $(".referStatus").text();
        if($("#emailList").val() != "" && !$(this).hasClass("activeRefer")) {
            $this = $(this);
            $this.addClass("activeRefer");
            $this.text("Wait");
            $.ajax({
                url: "api/referFriendEmail",
                type: "post",
                data: {
                    emailList : $("#emailList").val(),    
                },
            }).done(function(res) {
                if(res=="success"){
                    var notificationDetails = new Array();
                    notificationDetails["msg"] = "Referral invite send";
                    showNotification(notificationDetails, true);
                }   
                else{
                    var notificationDetails = new Array();
                    notificationDetails["msg"] = "Email could not be sent. Try again.";
                    showNotification(notificationDetails, true);
                } 
                $this.text("Send");
                $("#emailList").val("");
            });
        }
    });

    $("#inviteFriendsFB").click(function(e){
        e.preventDefault();
        FB.ui({
          method: "send",
          link: "http://www.savilerowsociety.com/users/refer/' . $user['User']['id'] . '",
        });
    });           
});
';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));


$meta_description = 'As a member, you will be up to date on styles, always look put together, and develop a wardrobe that captures the look you desire.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>

<div>
    <div class="eleven columns container content inner stylistbio">
        <div class="twelve columns container stylistbio-section left">
            
            <?php echo $this->element('clientAside/userFilterBar'); ?>

            <div class="stylistbio-section-right">
                <div class="eleven columns container">
                    <div class="myclient-right right">
                        <div class="eleven right columns">
                            
                        </div>
                    </div>
                </div>
            </div>
            
            
        </div>
        
    </div>
</div>