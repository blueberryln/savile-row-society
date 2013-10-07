<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$script = ' 
var uid = ' . $user_id . ';
var webroot = "' . $this->webroot . '";
';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->script('outfit.js', array('inline' => false));
//$this->Html->script('http://knockoutjs.com/downloads/knockout-2.3.0.js', array('inline' => false));
//$this->Html->script('http://stevenlevithan.com/assets/misc/date.format.js', array('inline' => false));
$this->Html->script("mosaic.1.0.1.min.js", array('inline' => false));
$this->Html->script('/js/date-format.js', array('inline' => false));
?>
<div class="container content inner timeline">	

    <div class="sixteen columns">
        <div class=" five columns stylist-img">
            <img src="<?php echo $this->webroot; ?>img/messages-casey.png" class="fadein-image" alt="Casey Golden" />
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
            <div class="clear"></div>
            <br /><br /><br />
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
            if(chatMsg['Message']['is_outfit'] == 1){
                html = html + '<div class="ten columns alpha omega chat-msg-box cur-user-msg" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">';  
                html = html + '<div class="message-caption">' + chatMsg['UserFrom']['first_name'] + ' suggested new items to complete a style:</div><br>'; 
                html = html + '<div class="chat-outfit-box">';
                for(var i=0; i<chatMsg['Outfit'].length; i++){
                    var imgSrc = webroot + "img/image_not_available-small.png";
                    if(typeof(chatMsg['Outfit'][i]["Image"]) != "undefined" && chatMsg['Outfit'][i]["Image"].length > 0){
                        imgSrc = webroot + "products/resize/" + chatMsg['Outfit'][i]["Image"][0]["name"] + "/98/135";
                    }
                    html = html + 
                    '<div class="two columns alpha row">' +
                        '<div class="product-block">' + 
                            '<input type="hidden" value="' + chatMsg['Outfit'][i]['Entity']['slug'] + '" class="product-slug">' + 
                            '<input type="hidden" value="' + chatMsg['Outfit'][i]['Entity']['id'] + '" class="product-id">' + 
                            '<div class="product-list-image mosaic-block fade">' + 
                                '<div class="mosaic-overlay" style="display: block;">' + 
                    				'<div class="mini-product-details">' + 
                					   '<span>$' + chatMsg['Outfit'][i]['Entity']['price'] + '</span>' + 
                					   '<span>' + chatMsg['Outfit'][i]['Entity']['name'] + '</span>' + 
                    				'</div>' + 
                    			'</div>' + 
                            '<div class="mosaic-backdrop" style="display: block;">' + 
                                    '<img src="' + imgSrc + '" alt="' + chatMsg['Outfit'][i]['Entity']['name'] + '" class="product-image fadein-image" style="opacity: 1;">' + 
                                '</div>' + 
                            '</div>' + 
                            '<div class="product-list-links">' + 
                                '<a href="" class="btn-buy" target="_blank">Buy</a>' + 
                            '</div>' + 
                        '</div>' + 
                    '</div>';        
                } 
                html = html + '</div>' + 
                    '<div class="message-date">' +
                        '<small>' + chatMsg['Message']['created'] + '</small>' +
                    '</div>' + 
                    '</div>';
            }
            else{
                if(chatMsg['UserFrom']['id'] == uid){
                    html = '' + 
                        '<div class="ten columns alpha omega chat-msg-box cur-user-msg" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">' + 
                            '<div class="message-caption">You Said:</div>' + 
                            '<div class="message-body">' + chatMsg['Message']['body'] + '</div>' + 
                            '<div class="message-date">' +
                                '<small>' + chatMsg['Message']['created'] + '</small>' +
                            '</div>' + 
                        '</div>';
                }
                else{
                    html = '' + 
                        '<div class="ten columns alpha omega chat-msg-box" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">' + 
                            '<div class="message-caption">' + chatMsg['UserFrom']['first_name'] + ' Said:</div>' + 
                            '<div class="message-body">' + chatMsg['Message']['body'] + '</div>' + 
                            '<div class="message-date">' +
                                '<small>' + chatMsg['Message']['created'] + '</small>' +
                            '</div>' + 
                        '</div>';
                }    
            }
            return html;
            
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