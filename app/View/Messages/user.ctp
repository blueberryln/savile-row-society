<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$script = ' 
var uid = ' . $user_id . ';
var webroot = "' . $this->webroot . '";';

$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->script('outfit.js', array('inline' => false));
$this->Html->script("mosaic.1.0.1.min.js", array('inline' => false));
$this->Html->script('/js/date-format.js', array('inline' => false));
?>
<div class="content-container">
    <div class="container content inner timeline">	
        <div class="sixteen columns">
            <div class="user-container">
                <div class="img-container">
                    <div class="profile-img text-center">
                    <?php
                        $img = "";
                        if(isset($client_user) && $client_user['User']['profile_photo_url'] && $client_user['User']['profile_photo_url'] != ""){
                            $img = $this->webroot . "files/users/" . $client_user['User']['profile_photo_url'];
                        }
                        else{
                            $img = $this->webroot . "img/dummy_image.jpg";    
                        }
                    ?>
                        <img src="<?php echo $img; ?>" id="user_image" />
                    </div>
                </div>
                <div class="info-container">
                    <div id="user-name"><?php echo $client_user['User']['full_name']; ?><br />
                        <span class="stylist-name">Your Personal Stylist</span>
                    </div>     
                       
                    <div class="stylist-info">
                        <a href="mailto:<?php echo $client_user['User']['email']; ?>"><span><img src="<?php echo $this->webroot; ?>img/email.png" class="fadein-image" /><?php echo $client_user['User']['email']; ?></span></a><br />
                    </div>               
                </div>   
            </div>
            <div class="stylist-talk">
                <h4 class='eight columns '>TALK WITH YOUR STYLIST</h4>
                <textarea class="chat-msg-txtbox" id='messageToSend'></textarea>
                <!--<input type="button" value="Send messages" id="sendMessages" />-->
                <a class="link-btn black-btn"  id="sendMessages"  href="">Send Message</a><a class="link-btn black-btn" href="" id="sendphoto">Send Photo</a>
                <div class="clear-fix"></div>
                
                <div class="chat-container">
                    
                </div>
                <div class="clear-fix"></div>
                <p id="loadOldMsgs" class="hide">
                    <span class="hide"><img src="<?php echo $this->webroot; ?>img/ajax-loader.gif" width="20" /></span>
                    <a href="">Load Old Messages</a>
                </p>
                <br />
            </div>
        </div>
    </div>
</div>
<div id="chatimage-box" class="box-modal notification-box hide">
    <div class="box-modal-inside">
        <a class="notification-close" href=""></a>
        <div class="signin-content">
            <h5 class="sign">Send Photo</h5>  
            
            <?php echo $this->Form->create('Message', array('type' => 'file', 'url' => '/messages/sendPhoto')); ?> 
                <?php
                    echo $this->Form->input('Image', array('type' => 'file', 'label' => false, 'class' => 'style-photo'));
                ?>
                <input type="submit" class="link-btn black-btn signin-btn" value="Upload Photo" /> 
                <br /><br />
            </form> 
        </div> 
    </div>
</div>

<script>
    window.onload = function() {
        var isFirstLoad = true,
            chatContainer = $('.chat-container'),
            callInAction = false,
            reqNewMsgDelay=6000,
            firstMsgId = 0;
        
        /**
         * To load the initial conversation
         */
        function loadMessages() {
            $.ajax({
                url: "<?php echo $this->webroot; ?>messages/getMyConversation",
                cache: false,
                type: 'POST',
                success: function(res) {
                    res = jQuery.parseJSON(res);
                    if (isFirstLoad && res['status'] == 'ok') {
                        isFirstLoad = false;
                        var arrMsg = res['Messages'];
                        if(arrMsg.length){
                            for(var i=0; i < arrMsg.length; i++){
                                var html = showChatMsg(arrMsg[i]);
                                chatContainer.append(html);
                                firstMsgId = arrMsg[i]['Message']['id'];
                            }
                            if(res['msg_remaining'] > 0){
                                $("#loadOldMsgs").fadeIn(300);    
                            }
                            
                        }
                        else{  
                                
                        } 
                    }
                },
                error: function(res) {
                }
            });
        }


        /**
         * To load new messages
         */
        function loadNewMessages(){
            callInAction = true;
            $.ajax({
                url: "<?php echo $this->webroot; ?>messages/getNewMessages",
                cache: false,
                type: 'POST',
                success: function(res) {
                    res = jQuery.parseJSON(res);
                    if (res['status']=='ok') {
                        var arrMsg = res['Messages'];
                        for(var i=0; i < arrMsg.length; i++){
                            var html = showChatMsg(arrMsg[i]);
                            chatContainer.prepend(html);
                        }
                    }
                    callInAction = false;   
                },
                error: function(res) {
                    callInAction = false;    
                }
            }).done(function(res){

            });    
        }

        /**
         * Format the message to show the chat block
         */
        function showChatMsg(chatMsg) {
            var html = '';   


            if(chatMsg['Message']['is_outfit'] == 1){
                html = html + '<div class="chat-msg-box" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">';  
                html = html + '<div class="message-caption">' + chatMsg['UserFrom']['first_name'] + ' suggested new items to complete a style:</div>'; 
                if(chatMsg['Message']['body'] != '' && chatMsg['Message']['body'] != 'outfit'){
                    html = html + '<div class="message-body">' + chatMsg['Message']['body'] + '</div><br>';
                }
                
                html = html + '<div class="chat-outfit-box">';
                for(var i=0; i<chatMsg['Outfit'].length; i++){
                    var imgSrc = webroot + "img/image_not_available-small.png";
                    if(typeof(chatMsg['Outfit'][i]["Image"]) != "undefined" && chatMsg['Outfit'][i]["Image"].length > 0){
                        imgSrc = webroot + "products/resize/" + chatMsg['Outfit'][i]["Image"][0]["name"] + "/98/135";
                    }
                    
                    var likedClass = "";
                    var dislikedClass = "";
                    if(chatMsg['Outfit'][i]['Wishlist'] && chatMsg['Outfit'][i]['Wishlist']['id'] && chatMsg['Outfit'][i]['Wishlist']['id'] > 0){
                        likedClass = "liked"    
                    }
                    
                    if(chatMsg['Outfit'][i]['Dislike'] && chatMsg['Outfit'][i]['Dislike']['id'] && chatMsg['Outfit'][i]['Dislike']['id'] > 0){
                        dislikedClass = "disliked"    
                    }
                    
                    
                    html = html + 
                    '<div class="chat-product-box">' +
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
                            //'<a href="" class="thumbs-up ' + likedClass + '"></a>' +
                                '<a href="' + webroot + 'messages/detail/' + chatMsg['Message']['id'] + '/" class="btn-buy" target="_blank">Buy</a>' + 
                                //'<a href="" class="thumbs-down ' + dislikedClass + '"></a>' +
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


            else if(chatMsg['Message']['image']){
                html = '' + 
                        '<div class="chat-msg-box cur-user-msg" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">' + 
                            '<div class="message-caption">You sent an image:</div>' + 
                            '<div class="message-image"><img src="<?php echo $this->webroot; ?>files/chat/' + chatMsg['Message']['image'] + '" /></div>' + 
                            '<div class="message-date">' +
                                '<small>' + chatMsg['Message']['created'] + '</small>' +
                            '</div>' + 
                        '</div>';
            }


            else{
                if(chatMsg['UserFrom']['id'] == uid){
                    html = '' + 
                        '<div class="chat-msg-box cur-user-msg" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">' + 
                            '<div class="message-caption">You Said:</div>' + 
                            '<div class="message-body">' + chatMsg['Message']['body'] + '</div>' + 
                            '<div class="message-date">' +
                                '<small>' + chatMsg['Message']['created'] + '</small>' +
                            '</div>' + 
                        '</div>';
                }
                else{
                    html = '' + 
                        '<div class="chat-msg-box" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">' + 
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

        Date.prototype.format = function(format) //author: meizz
        {
          var o = {
            "M+" : this.getMonth()+1, //month
            "d+" : this.getDate(),    //day
            "h+" : this.getHours(),   //hour
            "m+" : this.getMinutes(), //minute
            "s+" : this.getSeconds(), //second
            "q+" : Math.floor((this.getMonth()+3)/3),  //quarter
            "S" : this.getMilliseconds() //millisecond
          }

          if(/(y+)/.test(format)) format=format.replace(RegExp.$1,
            (this.getFullYear()+"").substr(4 - RegExp.$1.length));
          for(var k in o)if(new RegExp("("+ k +")").test(format))
            format = format.replace(RegExp.$1,
              RegExp.$1.length==1 ? o[k] :
                ("00"+ o[k]).substr((""+ o[k]).length));
          return format;
        }

        
        function nl2br (str, is_xhtml) {   
            var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';    
            return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
        }

        function showSentMessage(message, uid){
            var curDate = new Date().format("yyyy-MM-dd h:mm:ss")
            var html = '' + 
                '<div class="chat-msg-box cur-user-msg" data-user-id="' + uid + '" data-msg-id="">' + 
                    '<div class="message-caption">You Said:</div>' + 
                    '<div class="message-body">' + nl2br(message) + '</div>' + 
                    '<div class="message-date">' +
                        '<small>' + curDate + '</small>' +
                    '</div>' + 
                '</div>';  
            return html;   
        }



        $("#sendMessages").click(function(e) {
            e.preventDefault();
            
            if(!$("#messageToSend").hasClass("sending") && $("#messageToSend").val() != '') {
                $("#messageToSend").addClass("sending");
                var message = $("#messageToSend").val();
                var _data = {
                    body: message
                }

                var html = showSentMessage(message, uid);
                chatContainer.prepend(html);
                $("#messageToSend").val("");
                
                $("#messageToSend").removeClass("sending");
                $.ajax({
                    url: "<?php echo $this->webroot; ?>messages/send_message_to_stylist",
                    cache: false,
                    type: 'POST',
                    data: _data,
                    success: function(res) {
                        res = jQuery.parseJSON(res);
                        if(res['status'] == 'ok'){
                            // var html = showChatMsg(res);
                            // chatContainer.prepend(html);
                        }
                    },
                    error: function(res) {
                        
                    }
                });
            }
        })
        
        $(".my-profile").click(function(){
            var redirectURL = $(this).data('redirect');
           window.location.href = '<?php echo $this->webroot; ?>' + redirectURL; 
        });
        
        $("#sendphoto").on('click', function(e){
            e.preventDefault();
            $.blockUI({message: $("#chatimage-box")});   
        });
        
        $("#loadOldMsgs a").on('click', function(e){
            e.preventDefault();
            $this = $(this);
            $this.siblings('span').show();
            $.ajax({
                url: '<?php echo $this->webroot; ?>messages/getOldMessages',
                cache: false,
                type: 'POST',
                data : {
                    'last_msg_id': firstMsgId,        
                },
                success: function(data){
                    $this.siblings('span').hide();
                    res = jQuery.parseJSON(data);
                    if (res['status']=='ok') {
                        if(res['msg_count'] > 0){
                            var arrMsg = res['Messages'];
                            for(var i=0; i < arrMsg.length; i++){
                                var html = showChatMsg(arrMsg[i]);
                                chatContainer.append(html);
                                
                                firstMsgId = arrMsg[i]['Message']['id'];
                            }
                            if(res['msg_remaining'] == 0){
                                $("#loadOldMsgs").fadeOut(300);    
                            }
                        }
                        else{
                            $("#loadOldMsgs").fadeOut(300);    
                        }
                    }
                    else{
                        $("#loadOldMsgs").fadeOut(300);    
                    }   
                }    
            });
        });

        $(".chat-container").on("click", ".mosaic-overlay", function(e){
            e.preventDefault();
            var productBlock = $(this).closest(".product-block");
            window.location = productBlock.find(".btn-buy").attr("href");
        });
        
    }

</script>