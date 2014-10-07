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
?>
<?php
    $img = "";
        if(isset($client_user) && $client_user['User']['profile_photo_url'] && $client_user['User']['profile_photo_url'] != ""){
            $img = $this->webroot . "files/users/" . $client_user['User']['profile_photo_url'];
         }else{
            $img = $this->webroot . "img/dummy_image.jpg";    
        }
?>
<!--new design and code start here-->

<div>
    <div class="twelve columns container">
        <div class="eleven columns container message-box-area">
            <div class="twelve columns container left message-box">
                <div class="eleven columns container pad-none">
                        <?php echo $this->element('userAside/leftSidebar'); ?>
                            <div class="right-pannel right">
                                <div class="twelve columns message-area left pad-none">
                                    <div class="eleven columns container pad-none">
                                    
                                        <p id="loadOldMsgs" class="hide">
                                            <span class="hide"><img src="<?php echo $this->webroot; ?>img/ajax-loader.gif" width="20" /></span>
                                            <a href="">Load Old Messages</a>
                                        </p>
                                    
                                    <div class="chat-container">
                    
                                    </div>
                                    <br>
                                        
                                    </div>
                                </div>
                                <div class="twelve columns left">
                                    <div class="bottom-text">
                                        <div class="dummy-text">
                                            <textarea class="chat-msg-txtbox" id='messageToSend'></textarea>
                                        </div>
                                    </div>
                                </div>
                                <style type="text/css">
                                a#sendphoto{
                                    float: none;
                                    padding: 6px 17px;
                                }
                                </style>
                                <div class=" twelve columns left bottom-btns">
<!--
                                   <a class="link-btn black-btn" href="" id="requestanoutfit">Request an outfit</a>
                                    <a class="link-btn black-btn" href="" id="sendphoto">Upload <span class="cam-icon"><img src="<?php echo $this->webroot; ?>images/cam-icon.png" alt="" /></span> </a>
                                    <a class="link-btn black-btn"  id="sendMessages"  href="">Send Message</a>
-->
                                    
                                    
                                    
                                    
                                     <a class=" create-outfit left"  id="requestanoutfit"  href="">Request an outfit</a>
                                    <!-- <a class="upload" href="#" title="">Upload<span class="cam-icon"><img src="<?php echo $this->webroot; ?>images/cam-icon.png" alt="" /></span></a> -->
                                    <a class="upload" href="" id="sendphoto">Upload<span class="cam-icon"><img src="<?php echo $this->webroot; ?>images/cam-icon.png" alt="" /></span></a>
                                    <a class="send-btn right"  id="sendMessages"  href="">Send Message</a>
                                    
                                </div>
                            </div>
                        
                        </div>
                        
                        <?php echo $this->element('userAside/rightSidebar'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--file photo -->
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

<!--bhashit code-->
<div id="chatrequest-box" class="box-modal notification-box hide">
    <div class="box-modal-inside">
        <a class="notification-close" href=""></a>
        <div class="signin-content">
            <h5 class="sign">Request an Outfit</h5>  
            
            <?php echo $this->Form->create('Message', array('url' => '/messages/requestanoutfit')); ?> 
                <?php
                    echo $this->Form->input('Message.body', array('type' => 'textarea', 'label' => false, 'class' => 'style-photo'));
                ?>
                <input type="submit" class="link-btn black-btn signin-btn" value="Request an Outfit" /> 
                <br /><br />
            </form> 
        </div> 
    </div>
</div> 
<!--new code end here -->



<!--bhashit code-->

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
                                chatContainer.prepend(html);
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
                            chatContainer.append(html);
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
                //html = html + '<div class="chat-msg-box" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">';  
                //html = html + '<div class="message-caption">' + chatMsg['UserFrom']['first_name'] + ' suggested new items to complete a style:</div>'; 
                if(chatMsg['Message']['body'] != '' && chatMsg['Message']['body'] != 'outfit'){
                    //html = html + '<div class="message-body">' + chatMsg['Message']['body'] + '</div><br>';
                }
                var outfitName = (chatMsg['OutfitDetail']['name']) ? chatMsg['OutfitDetail']['name'] : ''; 

                html = html +   '<div class="client-outfit">'+
                                    '<div class="client-msg-reply"><span>' + outfitName + '</span></div>' + 
                                        '<ul class="client-outfit-img-lst">';
                ;
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
                            '<li>' + 
                                '<input type="hidden" value="' + chatMsg['Outfit'][i]['Entity']['slug'] + '" class="product-slug">' + 
                                '<input type="hidden" value="' + chatMsg['Outfit'][i]['Entity']['id'] + '" class="product-id">' + 
                                '<img src="' + imgSrc + '" alt="' + chatMsg['Outfit'][i]['Entity']['name'] + '" alt="" /></li>';  
                }

                    html = html +  
                                    '<a id="quickoutfit" class="outfit-quick-view" href="/messages/outfitdetails/' + chatMsg['Message']['outfit_id'] + '">' + 
                                        '<span class="outfit-quick-view-icons">' +
                                            '<img alt="" src="/images/search-icon.png">' +
                                        '</span>' + 
                                        'Outfit Quick View'
                                    '</a>' + 
                                    '</ul>' +
                                        
                                    '<div class="msg-date">' + chatMsg['Message']['created'] + '</div>' +
                                    '</div>';
            }


            else if(chatMsg['Message']['image']){
                if(chatMsg['UserFrom']['id'] == uid){
                    
                    html = '' + 
                        '<div class="chat-msg-box" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">' + 
                            '<div class="user-message-image-area">' +
                                '<div class="message-caption">' + chatMsg['UserFrom']['first_name'] + ' sent an image:</div>' + 
                                '<div class="message-image"><img src="<?php echo $this->webroot; ?>files/chat/' + chatMsg['Message']['image'] + '" /></div>' + 
                                '<div class="message-date">' + chatMsg['Message']['created'] + '</div>' +
                            '</div>' +   
                        '</div>';
                }
                else{
                    
                    html = '' + 
                        '<div class="chat-msg-box" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">' +
                            '<div class="message-image-area">' +
                                '<div class="message-caption">' + chatMsg['UserFrom']['first_name'] + ' sent an image:</div>' + 
                                '<div class="message-image"><img src="<?php echo $this->webroot; ?>files/chat/' + chatMsg['Message']['image'] + '" /></div>' + 
                                '<div class="message-date">' + chatMsg['Message']['created'] + '</div>' +
                            '</div>' + 
                        '</div>';
                }
            }
            else if(chatMsg['Message']['is_request_outfit'] == 1){
                if(chatMsg['UserFrom']['id'] == uid){
                    
                     html = '' + 
                        '<div class="chat-msg-box otft-rqst" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">' +
                            '<div class="user-msg">' + 
                            '<div class="otft-request">Outfit Request</div>' +
                            '<div class="msg">' + chatMsg['Message']['body'] + '</div>' + 
                                '<div class="msg-date">' + chatMsg['Message']['created'] + '</div>' +
                            '</div>' + 
                        '</div>';
                }
                else{
                    
                     html = '' + 
                        '<div class="chat-msg-box cur-user-msg" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">' + 
                            '<div class="client-msg">' + 
                            '<div class="client-msg-reply">' + chatMsg['Message']['body'] + '</div>' + 
                                '<div class="msg-date">' + chatMsg['Message']['created'] + '</idv>' +
                        '</div>';
                }
            } 

            else{
                if(chatMsg['UserFrom']['id'] == uid){
                     html = '' + 
                         '<div class="chat-msg-box cur-user-msg" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">' + 
                             '<div class="user-msg">' + 
                             '<div class="msg">' + chatMsg['Message']['body'] + '</div>' + 
                             '<div class="message-date">' +
                                 '<div class="msg-date">' + chatMsg['Message']['created'] + '</div>' +
                             '</div>' + 
                         '</div>';

                }
                else{
                    html = '' + 
                        '<div class="client-msg" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">' + 
                            //'<div class="message-caption">' + chatMsg['UserFrom']['first_name'] + ' Said:</div>' + 
                            '<div class="client-msg-reply">' + chatMsg['Message']['body'] + '</div>' + 
                                '<div class="msg-date">' + chatMsg['Message']['created'] + '</div>' +
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
                '<div class="user-msg" cur-user-msg" data-user-id="' + uid + '" data-msg-id="">' + 
                    '<div class="msg">' + nl2br(message) + '</div>' + 
                    '<div class="message-date">' +
                        '<div class="msg-date">' + curDate + '</div>' +
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
                chatContainer.append(html);
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

        $("#requestanoutfit").on('click', function(e){
            e.preventDefault();
            $.blockUI({message: $("#chatrequest-box")});   
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
                                chatContainer.prepend(html);
                                
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