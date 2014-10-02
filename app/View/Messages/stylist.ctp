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
$this->Html->script('/js/date-format.js', array('inline' => false));
?>
<?php echo $this->Form->create('User', array('url' => '/messages/send_to_user', 'type' => 'file')); ?>

<!--Client Image-->


<script type="text/javascript">
    $(document).ready(function(){


    $(".search-myclient").on('keyup',function(){
         var usersearch = $("#usersearch").val();
         usersearch = usersearch.toLowerCase();
            
         //alert(usersearch);
         $("#searchuserlist li .myclient-name").each(function(){
            var stringuser = $(this).text().toLowerCase();
            if(stringuser.indexOf(usersearch) > -1){
                $(this).closest('li').show();
            }else{
                $(this).closest('li').hide();
            }
         });
    });
});

</script>
<?php
    $img = "";
        if(isset($client) && $client['User']['profile_photo_url'] && $client['User']['profile_photo_url'] != ""){
            $img = $this->webroot . "files/users/" . $client['User']['profile_photo_url'];
         }else{
            $img = $this->webroot . "img/dummy_image.jpg";    
        }
?>

    <div class="twelve columns container">
        <div class="eleven columns container message-box-area">
            <div class="twelve columns container left message-box">
                
                
                <div class="myclient-left left">
                    <div class="myclient-topsec"> 
                        <div class="filter-myclient-area">
                            <div class="filter-myclient">
                                <span class="downarw"></span>
                                <select onchange="location = this.options[this.selectedIndex].value;">
                                    <option>Filter Clients</option>
                                    <?php  foreach($userlists as $filterclient ): ?>
                                    <option value="<?php echo $this->webroot; ?>messages/index/<?php echo $filterclient['User']['id']; ?>"><?php echo $filterclient['User']['first_name'].'&nbsp;'.$filterclient['User']['last_name']; ?></option>
                                     <?php endforeach; ?>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="search-myclient-area">
                            <div class="search-myclient">
                                <span class="srch"></span>
                                <input type="text" name="myclient-search" id="usersearch" />
                            </div>
                        </div>
                        <div class="myclient-list dsktp_only">
                            <div id="scrollbar6">
                            <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
                                <div class="viewport">
                                     <div class="overview">
                                        <ul id="searchuserlist">
                                        <?php  foreach($userlists as $searchuserclient){?>
                                            <li>
                                                <a href="<?php echo $this->webroot; ?>messages/index/<?php echo $searchuserclient['User']['id']; ?>" title="">
                                                    <div class="myclient-img">
                                                        <?php if($searchuserclient['User']['profile_photo_url']): ?>
                                                            <img src="<?php echo $this->webroot; ?>files/users/<?php echo $searchuserclient['User']['profile_photo_url']; ?>" alt=""/>
                                                        <?php else: ?>
                                                            <img src="<?php echo $this->webroot; ?>images/default-user.jpg" alt=""/>    
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="myclient-dtl">
                                                        <span class="myclient-name"><?php echo $searchuserclient['User']['first_name'].'&nbsp;'.$searchuserclient['User']['last_name']; ?></span>
                                                        <span class="myclient-status">last active at <?php echo date ('d F Y',$searchuserclient['User']['updated']); ?></span>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php } ?>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="myclient-list tab_n_mob">
                           
                                        <ul id="searchuserlist">
                                        <?php  foreach($userlist as $searchuserclient){?>
                                            <li>
                                                <a href="<?php echo $this->webroot; ?>messages/index/<?php echo $searchuserclient['User']['id']; ?>" title="">
                                                    <div class="myclient-img">
                                                        <?php if($searchuserclient['User']['profile_photo_url']): ?>
                                                            <img src="<?php echo $this->webroot; ?>files/users/<?php echo $searchuserclient['User']['profile_photo_url']; ?>" alt=""/>
                                                        <?php else: ?>
                                                            <img src="<?php echo $this->webroot; ?>images/default-user.jpg" alt=""/>    
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="myclient-dtl">
                                                        <span class="myclient-name"><?php echo $searchuserclient['User']['first_name'].'&nbsp;'.$searchuserclient['User']['last_name']; ?></span>
                                                        <span class="myclient-status">last active at <?php echo date ('d F Y',$searchuserclient['User']['updated']); ?></span>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php } ?>

                                        </ul>
                                    </div>
                    </div>
                </div>
                
                
                <div class="myclient-right right">
                    <div class="twelve columns left inner-content pad-none">
                         <div class="twelve columns myclient-heading pad-none">
                            <h1><?php echo $client_user['User']['full_name']; ?> | <span>Messages</span></h1>
                            <div class="client-img-small"><img src="<?php echo $this->webroot; ?>files/users/<?php echo $client_user['User']['profile_photo_url']; ?>" alt="" /></div>
                        </div>
                        <div class="inner-left inner-myclient left">
<!--                            <div class="dashboard-pannel left">&nbsp;</div>-->
                            <div class="left-pannel left">
                                <div class="client-img"><img src="<?php echo $this->webroot; ?>files/users/<?php echo $client_user['User']['profile_photo_url']; ?>" alt="" /></div>
                                <div class=" twelve columns left left-nav">
                                    <ul>
                                        <li><a href="<?php echo $this->webroot; ?>messages/userfeed/<?php echo $client_id; ?>">Activity Feed</a></li>
                                        <li class="active"><a href="<?php echo $this->webroot; ?>messages/index/<?php echo $client_id; ?>">Messages</a></li>
                                        <li><a href="<?php echo $this->webroot; ?>messages/outfits/<?php echo $client_id; ?>">Outfits</a></li>
                                        <li><a href="<?php echo $this->webroot; ?>messages/purchase/<?php echo $client_id; ?>">Purchases/Likes</a></li>
                                        <li><a href="<?php echo $this->webroot; ?>messages/notes/<?php echo $client_id; ?>">Notes &amp; Gallery</a></li>
                                        <li><a href="<?php echo $this->webroot; ?>messages/measurements/<?php echo $client_id; ?>">Measurements</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="right-pannel right">
                                <div class="twelve columns message-area left pad-none">
                                    <div class="eleven columns container pad-none">
                                        
                                        
                                        <p id="loadOldMsgs" class="hide">
                                            <span class="hide"><img src="<?php echo $this->webroot; ?>img/ajax-loader.gif" width="20" /></span>
                                            <a href="">Load Old Messages</a>
                                        </p>
                                        <br />
                                        
                                         <div class="chat-container">
                    
                                        </div>
                                    
                                    </div>
                                </div>
                                <div class="twelve columns left">
                                    <div class="bottom-text">
                                        <div class="dummy-text"><textarea class="chat-msg-txtbox" id='messageToSend' name="data[Message][body]"></textarea></div>
                                    </div>
                                </div>
                                <div class=" twelve columns left bottom-btns">
                                   <!--  <a class="create-outfit left" href="#" title="">Create Outfit</a>
                                    <a class="upload" href="#" title="">Upload<span class="cam-icon"><img src="<?php echo $this->webroot; ?>images/cam-icon.png" alt="" /></span></a>
                                    <a class="send-btn right" href="#" title="">Send</a> -->
                                    <!-- <a class="create-outfit left" href="#" title="">Create Outfit</a> -->
                                    <a class="link-btn gold-btn"  id="createOutfit"  href="">Create New Outfit</a>
                                    <!-- <a class="upload" href="#" title="">Upload<span class="cam-icon"><img src="<?php echo $this->webroot; ?>images/cam-icon.png" alt="" /></span></a> -->
                                    <a class="link-btn black-btn" href="" id="sendphoto">Send Photo</a>
                                    <a class="link-btn black-btn"  id="sendMessages"  href="">Send Message</a>
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

<script>
    window.onload = function() {
        // prepare data for ui binding. 
        // notReadedMessages is object from server serialized into  json format (see ref1)
        var isFirstLoad = true,
            chatContainer = $('.chat-container'),
            callInAction = false,
            reqNewMsgDelay=6000,
            firstMsgId = 0;
        
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
                //html = html + '<div class="chat-msg-box" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">';  
                //html = html + '<div class="message-caption">' + chatMsg['UserFrom']['first_name'] + ' suggested new items to complete a style:</div>'; 
                if(chatMsg['Message']['body'] != '' && chatMsg['Message']['body'] != 'outfit'){
                    //html = html + '<div class="message-body">' + chatMsg['Message']['body'] + '</div><br>';
                }
                
                html = html +   '<div class="client-outfit">'+
                                    '<div class="client-msg-reply"><span>Beach Day</span></div>' + 
                                        '<ul>';
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
                    
                        '<input type="hidden" value="' + chatMsg['Outfit'][i]['Entity']['slug'] + '" class="product-slug">' + 
                            '<input type="hidden" value="' + chatMsg['Outfit'][i]['Entity']['id'] + '" class="product-id">' + 
                            '<li><img src="' + imgSrc + '" alt="' + chatMsg['Outfit'][i]['Entity']['name'] + '" alt="" /></li>'; 
                }

                    html = html +  '</ul>' +
                                    '<div class="msg-date">' + chatMsg['Message']['created'] + '</div>' +
                                    '</div>';
            }
            else if(chatMsg['Message']['image']){
                html = '' + 
                        '<div class="chat-msg-box" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">' + 
                            '<div class="message-caption">' + chatMsg['UserFrom']['first_name'] + ' sent an image:</div>' + 
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
        })
        
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
            if(!$("#messageToSend").hasClass("sending") && $("#messageToSend").val() != '') {
                $("#messageToSend").addClass("sending");
                var message = $("#messageToSend").val();
                var _data = {
                    body: message,
                    user_to_id: userId
                }

                var html = showSentMessage(message, uid);
                chatContainer.append(html);
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


        $("#sendphoto").on('click', function(e){
            e.preventDefault();
            $.blockUI({message: $("#chatimage-box")});   
        });

        $(".chat-container").on("click", ".mosaic-overlay", function(e){
            e.preventDefault();
            var productBlock = $(this).closest(".product-block");
            window.location = productBlock.find(".btn-buy").attr("href");
        });
    }
    

</script>