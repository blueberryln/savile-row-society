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
$this->Html->css('ui/jquery-ui', null, array('inline' => false));
$this->Html->css('ui/jquery.ui.theme', null, array('inline' => false));
$this->Html->script('//code.jquery.com/ui/1.10.3/jquery-ui.min.js', array('inline' => false));
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));


$meta_description = 'As a member, you will be up to date on styles, always look put together, and develop a wardrobe that captures the look you desire.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>

    <div class="twelve columns container">
        <div class="eleven columns container message-box-area">
            <div class="twelve columns container left message-box">
                <div class="eleven columns container pad-none">
                    
                        <?php echo $this->element('userAside/leftSidebar'); ?>


                            <div class="right-pannel right rfr-a-frnd">
                                <!-- <div class="twelve columns message-area left pad-none">
                                    <div class="eight columns page-content refer-options">
                                        <div class="refer-way one">
                                            <div class="icon">
                                                <img class="" src="<?php echo $this->request->webroot; ?>img/ic_srs.png" /> 
                                            </div>
                                            <div class="rw-content nine columns">
                                                <h3>Your personal refer link:</h3>
                                                <div class="rw-field">
                                                    <input class="eleven columns" type="text" readonly value="http://www.savilerowsociety.com/users/refer/<?php echo $user['User']['id']; ?>">                        
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

                                </div> -->
                                <div class="twelve columns left">
                                    <div class="eleven columns left refer-frnd-area pad-none">
                                        <div class="frnd-refer-user prsnl-refer"><span>&nbsp;</span>SRS Personal Reference link</div>
                                        <div class="input text required">
                                             <input name="referral" required="required"  type="text" value="http://www.savilerowsociety.com/users/refer/<?php echo $user['User']['id']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="eleven columns left refer-frnd-area pad-none">
                                        <div class="frnd-refer-user email-refer"><span>&nbsp;</span>Email Referral</div>
                                        <div class="input text required">
                                            <input name="email" required="required" placeholder="enter email address" type="text" id="emailList">
                                            <p class="referStatus"></p>
                                        </div>
                                        <a class="send-referral" href="#" title="" id="inviteFriendsEmail">Send</a>
                                    </div>
                                    <div class="eleven columns left refer-frnd-area pad-none">
                                        <div class="frnd-refer-user fb-refer"><span>&nbsp;</span><a href="#" title="" id="inviteFriendsFB">Refer via Facebook</a></div>
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                        
                        <?php echo $this->element('userAside/rightSidebar'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

