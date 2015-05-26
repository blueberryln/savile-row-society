<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$script = ' 
var uid = ' . $user_id . ';
var client_id = ' . $client_id . ';
var webroot = "' . $this->webroot . '";

';
$this->Html->script('outfit.js', array('inline' => false));
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->script("mosaic.1.0.1.min.js", array('inline' => false));
$this->Html->script('date-format.js', array('inline' => false));
?>
<?php echo $this->Form->create('User', array('url' => '/messages/send_to_user', 'type' => 'file')); ?>


    <div class="twelve columns container">
        <div class="eleven columns container message-box-area">
            <div class="twelve columns container left message-box">
                
                <?php echo $this->element('clientAside/userFilterBar'); ?>
                
                <div class="myclient-right right">
                    <div class="twelve columns left inner-content pad-none">
                        
                            <?php echo $this->element('clientAside/userLinksLeft'); ?>

                            <div class="right-pannel right">
                                
                                <div class="twelve columns message-area left pad-none">
                                    
                                    <!-- <div id="scrollbar2">
                                            <div class="scrollbar" style="display:block; right: 4px;"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
                                            <div class="viewport">
                                                <div class="overview"> -->
                                    <div class="eleven columns container pad-none">
                                        
                                        
                                        <p id="loadOldMsgs">
                                            <span class="hide"><img src="<?php echo HTTP_ROOT; ?>img/ajax-loader.gif" width="20" /></span>
                                            <a href="">Load Old Messages</a>
                                        </p>
                                        <br />
                                        
                                        
                                        <div id="scrollbar1">
                                            <div class="scrollbar" style="display: block;"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
                                            <div class="viewport">
                                                <div class="overview" style="width: 100%;">
                                                    <div class="chat-container">
                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="message-pane-bottom clear-fix" style="overflow: hidden;">
                                    <div class="twelve columns left">
                                        <div class="bottom-text">
                                            <div class="dummy-text"><textarea rows="5" class="chat-msg-txtbox" id='messageToSend' name="data[Message][body]"></textarea></div>
                                        </div>
                                    </div>
                                    <div class=" twelve columns left bottom-btns">
                                       <!--  <a class="link-btn gold-btn" href="#" title="">Create Outfit</a>
                                        <a class=" link-btn black-btn" href="#" title="">Send Photo Upload<span class="cam-icon"><img src="<?php echo $this->webroot; ?>images/cam-icon.png" alt="" /></span></a>
                                        <a class="link-btn black-btn" href="#" title="">Send</a> -->
                                        <!-- <a class="create-outfit left" href="#" title="">Create Outfit</a> -->
                                        <a class=" create-outfit left"  id=""  href="/outfits/create/<?php echo $client_id; ?>">Create New Outfit</a>
                                        <!-- <a class="upload" href="#" title="">Upload<span class="cam-icon"><img src="<?php echo $this->webroot; ?>images/cam-icon.png" alt="" /></span></a> -->
                                        <a class="upload" href="" id="sendphoto">Upload<span class="cam-icon"><img src="<?php echo HTTP_ROOT; ?>images/cam-icon.png" alt="" /></span></a>
                                        <a class="send-btn right"  id="sendMessages"  href="">Send Message</a>
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                    </div>
                
                </div>
                
                
                
            </div>
        </div>
    </div>
</div>

<?php echo $this->Form->end(); ?>

<div id="chatimage-box" class="box-modal notification-box hide">
    <div class="box-modal-inside">
        <a class="notification-close" href=""></a>
        <div class="signin-content">
            <h5 class="sign">Send Photo</h5>  
            
            <?php echo $this->Form->create('Message', array('type' => 'file', 'url' => '/messages/sendPhotoToUser/' . $client_id)); ?> 
                <?php
                    echo $this->Form->input('Image', array('type' => 'file', 'label' => false, 'class' => 'style-photo'));
                ?>
                <input type="submit" class="link-btn black-btn signin-btn" value="Upload Photo" /> 
                <br /><br />
            </form> 
        </div> 
    </div>
</div>

<div id="view-otft-popup" style="display: none">
    <div class="box-modal">
        <div class="box-modal-inside">
            <a href="#" title="" class="otft-close"></a>
            <input type="hidden" id="pop-outfit-id" value="">
            <div class="view-otft-content">
                <h1>Outfit Quickview</h1>
                <div class="three columns left">
                    <div class="twelve columns left">
                        <div class="view-otft-list">
                            <ul>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="eight columns right">
                    <div class="twelve columns left">
                        <div class="view-otft-dtl">
                            <div class="view-otft-dtl-top">
                                <p>Outfit Name: <span class="pop-outfit-name"></span></p>
                                <p>Total Cost: $<span class="pop-outfit-price"></span></p>
                            </div>
                            <div class="otft-overview-box">
                                <span class="otft-overview-box-head">Overview</span>
                                <div class="otft-overview-box-recmnd">
                                    <p>Recommended To:</p>
                                    <ul>
                                        
                                    </ul>
                                </div>
                                <div class="otft-overview-box-brnds">
                                    <p>Brands:</p>
                                    <ul>
                                       
                                    </ul>
                                </div>
                            </div>
                            <div class="twelve columns left otft-overview-links">
                                <a class="left pop-outfit-reuse" href="" title="">Reuse Outfit</a>
                                <a class="right pop-outfit-details" href="" title="">See Full Outfit Details</a>
                            </div>
                        </div>
                    </div>
                </div>
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
            reqNewMsgDelay=6000,
            firstMsgId = 0;

        var calculatedHeight = $(window).height()- $('.header').height() - $('.message-pane-bottom').height() - 100;
        console.log(calculatedHeight);
        var $scrollbar  = $('#scrollbar1');
        $scrollbar.tinyscrollbar({ axis: "y", trackSize: calculatedHeight});
        var scrollbarData = $scrollbar.data("plugin_tinyscrollbar");
        $scrollbar.find('.viewport').height(calculatedHeight);
        
        function loadMessages(userId) {
            if(!userId){
                userId = "";
            }
            $.ajax({
                url: "<?php echo $this->webroot; ?>messages/getMyConversation/" + userId,
                cache: false,
                type: 'POST',
                success: function(res) {
                    res = jQuery.parseJSON(res);
                    if (res['status']=='ok') {
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

                        scrollbarData.update("bottom");
                        $(window).resize();
                    }
                },
                error: function(res) {
                    
                }
            });
        }
        
        function loadNewMessages(){
            callInAction = true;
            $.ajax({
                url: "<?php echo $this->webroot; ?>messages/getNewMessages/" + userId,
                cache: false,
                type: 'POST',
                success: function(res) {
                    res = jQuery.parseJSON(res);
                    if (res['status']=='ok') {
                        var arrMsg = res['Messages'];
                        for(var i=0; i < arrMsg.length; i++){
                            var html = showChatMsg(arrMsg[i]);
                            chatContainer.append(html);
                            scrollbarData.update("relative");
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
                

                var outfitName = (typeof(chatMsg['OutfitDetail']['outfit_name']) != "undefined") ? chatMsg['OutfitDetail']['outfit_name'].capitalize() : ''; 
                var userList = [],
                    outfitPrice = 0,
                    brandList = [];
                
                html = html +   '<div class="client-outfit">'+
                                    '<div class="client-msg-reply"><span class="outfit-name"><a href="/messages/outfitdetails/' + chatMsg['OutfitDetail']['id'] + '">' + outfitName + '</a></span></div>' + 
                                    '<input type="hidden" id="outfitidquickview" class="outfit-id" data-id="' + chatMsg['OutfitDetail']['id'] + '" value="' + chatMsg['OutfitDetail']['id'] + '">' + 
                                        '<ul>';
                ;
                for(var i=0; i<chatMsg['Outfit'].length; i++){
                    var imgSrc = webroot + "img/image_not_available-small.png";
                    if(typeof(chatMsg['Outfit'][i]['product']["Image"]) != "undefined" && chatMsg['Outfit'][i]['product']["Image"].length > 0){
                        imgSrc = webroot + "products/resize/" + chatMsg['Outfit'][i]['product']["Image"][0]["name"] + "/98/135";
                    }
                    else{
                        imgSrc = webroot + "images/image_not_available.png";    
                    }
                    
                    html = html + 
                            '<li>' + 
                                '<img src="' + imgSrc + '" alt="' + chatMsg['Outfit'][i]['product']['Entity']['name'] + '" alt="" /></li>'; 

                    brandList.push(chatMsg['Outfit'][i]['product']['Brand']['name']);
                    outfitPrice += parseInt(chatMsg['Outfit'][i]['product']['Entity']['price']);
                }

                for(var j = 0; j < chatMsg['AllMessage'].length; j++){
                    userList.push(chatMsg['AllMessage'][j]['UserTo']['first_name'].capitalize() + ' ' + chatMsg['AllMessage'][j]['UserTo']['last_name'].capitalize());
                }

                brandList = brandList.unique();
                userList = userList.unique();
                brandList = brandList.join(',');
                userList = userList.join(',');

                    html = html +  '</ul>' +
                                    '<input type="hidden" id="totalpriceoutfit" class="outfit-price" value="' + outfitPrice + '">' + 
                                    '<input type="hidden" class="outfit-brands" value="' + brandList + '">' + 
                                    '<input type="hidden" class="outfit-users" value="' + userList + '">' + 
                                    '<div class="outfit-quick-view"><a href="#" id="quickoutfit"><span class="outfit-quick-view-icons"><img src="<?php echo HTTP_ROOT; ?>images/search-icon.png" alt="" /></span>Outfit Quick View</a></div>' +
                                    '<div class="msg-date">' + chatMsg['Message']['created'] + '</div>' +
                                    '</div>';
            }
            else if(chatMsg['Message']['image']){
                if(chatMsg['UserFrom']['id'] == uid){
                    
                    html = '' + 
                        '<div class="chat-msg-box" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">' + 
                            '<div class="message-image-area">' +
                                '<div class="message-caption">' + chatMsg['UserFrom']['first_name'] + ' sent an image:</div>' + 
                                '<div class="message-image"><img src="<?php echo HTTP_ROOT; ?>files/chat/' + chatMsg['Message']['image'] + '" /></div>' + 
                                '<div class="message-date">' + chatMsg['Message']['created'] + '</div>' +
                            '</div>' +   
                        '</div>';
                }
                else{
                    
                    html = '' + 
                        '<div class="chat-msg-box" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">' +
                            '<div class="user-message-image-area">' +
                                '<div class="message-caption">' + chatMsg['UserFrom']['first_name'] + ' sent an image:</div>' + 
                                '<div class="message-image"><img src="<?php echo HTTP_ROOT; ?>files/chat/' + chatMsg['Message']['image'] + '" /></div>' + 
                                '<div class="message-date">' + chatMsg['Message']['created'] + '</div>' +
                            '</div>' + 
                        '</div>';
                }
            }
            else if(chatMsg['Message']['is_request_outfit'] == 1){
                if(chatMsg['UserFrom']['id'] == uid){
                    
                    html = '' + 
                        '<div class="chat-msg-box cur-user-msg" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">' + 
                            '<div class="client-msg">' + 
                            '<div class="client-msg-reply">' + chatMsg['Message']['body'] + '</div>' + 
                                '<div class="msg-date">' + chatMsg['Message']['created'] + '</idv>' +
                        '</div>';
                }
                else{
                    
                    html = '' + 
                        '<div class="chat-msg-box" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">' +
                            '<div class="user-msg">' + 
                            '<div class="msg">' + chatMsg['Message']['body'] + '</div>' + 
                                '<div class="msg-date">' + chatMsg['Message']['created'] + '</div>' +
                            '</div>' + 
                        '</div>';
                }
            } 
            else{
                if(chatMsg['UserFrom']['id'] == uid){
                    
                    html = '' + 
                        '<div class="chat-msg-box cur-user-msg" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">' + 
                            '<div class="client-msg">' + 
                            '<div class="client-msg-reply">' + chatMsg['Message']['body'] + '</div>' + 
                                '<div class="msg-date">' + chatMsg['Message']['created'] + '</idv>' +
                        '</div>';
                }
                else{
                    
                    html = '' + 
                        '<div class="chat-msg-box" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">' +
                            '<div class="user-msg">' + 
                            '<div class="msg">' + chatMsg['Message']['body'] + '</div>' + 
                                '<div class="msg-date">' + chatMsg['Message']['created'] + '</div>' +
                            '</div>' + 
                        '</div>';
                }
            }       
            return html;
        }
        
        $("#UserUserToId").change(function(e) {
            e.preventDefault();
            userId =  $("#UserUserToId").val();
            window.location = webroot + "messages/index/" + userId;
        });
        
        var userId = null;
        
         <?php 
            if ($messages_for_user_id){
                echo 'userId = ' . $messages_for_user_id . ';';
            }
        ?>
     
        if(!userId){            
            userId = $("#UserUserToId").val();
        }else{
            $("#UserUserToId").val(userId);
        }
        
        
        
        if(client_id > 0){
            loadMessages(userId);
            setInterval(
                function(){
                    if(!callInAction){
                        loadNewMessages();
                    }
                },
                reqNewMsgDelay
            );
        }

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
                            '<div class="client-msg">' + 
                            '<div class="client-msg-reply">' + nl2br(message) + '</div>' + 
                            '<div class="msg-date">' + curDate + '</div>' + 
                        '</div>'; 
            return html;   
        }
        
        $("#sendMessages").click(function(e) {
            e.preventDefault();
            //if(!$("#messageToSend").hasClass("sending") && $("#messageToSend").val() != '') {
            if($("#messageToSend").val() != '') {
                $("#messageToSend").addClass("sending");
                var message = $("#messageToSend").val();
                var _data = {
                    body: message,
                    user_to_id: userId
                }

                var html = showSentMessage(message, uid);
                chatContainer.append(html);
                scrollbarData.update("bottom");

                $("#messageToSend").val("");

                $.ajax({
                    url: "<?php echo $this->webroot; ?>messages/send_to_user",
                    cache: false,
                    type: 'POST',
                    data: _data,
                    success: function(res) {
                        res = jQuery.parseJSON(res);
                        if(res['status'] == 'ok'){
                             //var html = showChatMsg(res);
                             //chatContainer.append(html);
                        }
                    },
                    error: function(res) {
                              
                    }
                }).done(function(res){
                    $("#messageToSend").removeClass("sending");
                });
            }
        });
        
        
        
        $("#loadOldMsgs a").on('click', function(e){
            e.preventDefault();
            $this = $(this);
            $this.siblings('span').show();
            $.ajax({
                url: '<?php echo $this->webroot; ?>messages/getOldMessages/' + userId,
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

                            scrollbarData.update();
                        }
                        else{
                            $("#loadOldMsgs").fadeOut(300);    
                        }
                    }  
                    else{
                        $("#loadOldMsgs").fadeOut(300);     
                    } 


                    // $("#scrollbar2").trigger('resize');
                }    
            });
        });


        $("#sendphoto").on('click', function(e){
            e.preventDefault();
            $.blockUI({message: $("#chatimage-box")});   
        });

        $(".chat-container").on("click", ".mosaic-overlay", function(e){
            e.preventDefault();
            var productBlock = $(this).closest(".product-block");
            window.location = productBlock.find(".btn-buy").attr("href");
        });


        $('.chat-container').on('click', '.outfit-quick-view', function(e){
            e.preventDefault();
            
            var clientOutfit = $(this).closest('.client-outfit'),
                outfitName = clientOutfit.find('.outfit-name').text(),
                outfitId = clientOutfit.find('.outfit-id').val(),
                outfitPrice = clientOutfit.find('.outfit-price').val(),
                brandList = clientOutfit.find('.outfit-brands').val().split(","),
                userList = clientOutfit.find('.outfit-users').val().split(",");
            
            $('.pop-outfit-name').text(outfitName);
            $('#pop-outfit-id').val(outfitId);
            $('.pop-outfit-price').text(outfitPrice);

            var brandListHtml = $('.otft-overview-box-brnds ul');
            brandListHtml.html('');
            for(var i=0; i<brandList.length; i++){
                brandListHtml.append('<li>' + brandList[i] + '</li>');
            }

            var userListHtml = $('.otft-overview-box-recmnd');
            userListHtml.html('');
            for(var i=0; i<userList.length; i++){
                userListHtml.append('<li>' + userList[i] + '</li>');
            }

            var imgListHtml = $('.view-otft-list'),
                curImgPath = '';
            imgListHtml.html('');

            clientOutfit.find('ul li img').each(function(){
                curImgPath = $(this).attr('src');
                imgListHtml.append('<li><img src="' + curImgPath + '"></li>');
            });

            $('.pop-outfit-details').attr('href', '/messages/outfitdetails/' + outfitId);
            $('.pop-outfit-reuse').attr('href', '/messages/outfitdetails/' + outfitId);
            


            var blockTop = $(window).height()/2 - $("#view-otft-popup").height()/2 + $(window).scrollTop();
            $.blockUI({message: $('#view-otft-popup'), css: {position: "absolute", top: (blockTop > 0) ? blockTop : "0px"}});
            $('.blockOverlay').click($.unblockUI);
        });
    }
    

</script>