<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$script = ' var uid = ' . $user_id . '; ';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
//$this->Html->script('http://knockoutjs.com/downloads/knockout-2.3.0.js', array('inline' => false));
//$this->Html->script('http://stevenlevithan.com/assets/misc/date.format.js', array('inline' => false));
?>
<div class="container content inner timeline">	

    <div class="sixteen columns">
        <div class=" five columns stylist-img">
            <img src="<?php echo $this->webroot; ?>img/messages-casey.png" alt="Casey Golden" />
            <input type='button' value='MY PROFILE' class='my-profile'/>
            <br /><br /><br />
        </div>
        <div class="ten columns aplha stylist-talk">
            <h4 class='eight columns '>TALK WITH YOUR STYLIST</h4>
            <textarea class="eight columns alpha omega chat-msg-txtbox" id='messageToSend'></textarea>
            <!--<input type="button" value="Send messages" id="sendMessages" />-->
            <a class="link-btn black-btn"  id="sendMessages"  href="">Send Messages</a>
            <div class="chat-container">
                
            </div>
        </div>
    </div>

</div>

<script>
    window.onload = function() {
        // prepare data for ui binding. 
        // notReadedMessages is object from server serialized into  json format (see ref1)
        var isFirstLoad = true,
            chatContainer = $('.chat-container'),
            callInAction = false,
            reqNewMsgDelay=6000;
            
        function loadMessages() {
            $.ajax({
                url: "<?php echo $this->webroot; ?>messages/getMyConversation",
                success: function(res) {
                    res = jQuery.parseJSON(res);
                    if (isFirstLoad && res['status'] == 'ok') {
                        isFirstLoad = false;
                        var arrMsg = res['Messages'];
                        for(var i=0; i < arrMsg.length; i++){
                            var html = showChatMsg(arrMsg[i]);
                            chatContainer.append(html);
                        }
                    }
                },
                error: function(res) {
                }
            });
        }
        function loadNewMessages(){
            callInAction = true;
            $.ajax({
                url: "<?php echo $this->webroot; ?>messages/getNewMessages",
                success: function(res) {
                    res = jQuery.parseJSON(res);
                    if (res['status']=='ok') {
                        var arrMsg = res['Messages'];
                        for(var i=0; i < arrMsg.length; i++){
                            var html = showChatMsg(arrMsg[i]);
                            chatContainer.prepend(html);
                        }
                    }
                },
                error: function(res) {
                    
                }
            }).done(function(res){
                callInAction = false;
            });    
        }
        function showChatMsg(chatMsg) {
            var html = '';           
            if(chatMsg['OutfitItem']['is_outfit'] == 1){
                
            }
            else{
                if(chatMsg['UserFrom']['id'] == uid){
                    html = '' + 
                        '<div class="eight columns alpha omega chat-msg-box cur-user-msg" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">' + 
                            '<div class="message-caption">You Said:</div>' + 
                            '<div class="message-body">' + chatMsg['Message']['body'] + '</div>' + 
                            '<div class="message-date">' +
                                '<small>' + chatMsg['Message']['created'] + '</small>' +
                            '</div>' + 
                        '</div>';
                }
                else{
                    html = '' + 
                        '<div class="eight columns alpha omega chat-msg-box" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">' + 
                            '<div class="message-caption">' + chatMsg['UserFrom']['first_name'] + ' Said:</div>' + 
                            '<div class="message-body">' + chatMsg['Message']['body'] + '</div>' + 
                            '<div class="message-date">' +
                                '<small>' + chatMsg['Message']['created'] + '</small>' +
                            '</div>' + 
                        '</div>';
                }
                return html;    
            }
            
        }

        loadMessages();
        setInterval(
            function(){
                if(!callInAction){
                    loadNewMessages();
                }
            },
            reqNewMsgDelay
        );

        $("#sendMessages").click(function(e) {
            e.preventDefault();
            var message = $("#messageToSend").val();
            var _data = {
                body: message
            }
            $.ajax({
                url: "<?php echo $this->webroot; ?>messages/send_message_to_stylist",
                type: 'POST',
                data: _data,
                success: function(res) {
                    $("#messageToSend").val("");
                    res = jQuery.parseJSON(res);
                    if(res['status'] == 'ok'){
                        var html = showChatMsg(res);
                        chatContainer.prepend(html);
                    }
                },
                error: function(res) {
                    // alert("error");
                }
            }).done(function(res){
            });
        })
        
        $(".my-profile").click(function(){
           window.location.href = '<?php echo $this->webroot; ?>profile/about'; 
        });
    }

</script>