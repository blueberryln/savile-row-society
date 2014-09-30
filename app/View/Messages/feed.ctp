<?php

$this->Html->script('/js/date-format.js', array('inline' => false));
?>

<div class="content-container">
    <div class="twelve columns container">
        <div class="eleven columns container message-box-area">
            <div class="twelve columns container left message-box">
                
                
                <div class="myclient-left left">
                    <div class="myclient-topsec"> 
                        <div class="filter-myclient-area">
                            <div class="filter-myclient">
                                <span class="downarw"></span>
                                <select>
                                    <option>Filter Clients</option>
                                    <option>Filter Clients</option>
                                    <option>Filter Clients</option>
                                </select>
                            </div>
                        </div>
                        <div class="search-myclient-area">
                            <div class="search-myclient">
                                <span class="srch"></span>
                                <input type="text" name="myclient-search" />
                            </div>
                        </div>
                        <div class="myclient-list">
                            <ul>
                                <li>
                                    <a href="#" title="">
                                        <div class="myclient-img">
                                            <img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt=""/>
                                        </div>
                                        <div class="myclient-dtl">
                                            <span class="myclient-name">Kyle HARPER</span>
                                            <span class="myclient-status">last active at 4:30 PM</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="active">
                                    <a href="#" title="">
                                        <div class="myclient-img">
                                            <img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt=""/>
                                        </div>
                                        <div class="myclient-dtl">
                                            <span class="myclient-name">Kyle HARPER</span>
                                            <span class="myclient-status">last active at 4:30 PM</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="">
                                        <div class="myclient-img">
                                            <img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt=""/>
                                        </div>
                                        <div class="myclient-dtl">
                                            <span class="myclient-name">Kyle HARPER</span>
                                            <span class="myclient-status">last active at 4:30 PM</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="">
                                        <div class="myclient-img">
                                            <img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt=""/>
                                        </div>
                                        <div class="myclient-dtl">
                                            <span class="myclient-name">Kyle HARPER</span>
                                            <span class="myclient-status">last active at 4:30 PM</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                
                <div class="mydesbrd-right right">
                    <div class="twelve columns left inner-content mydesbrd-inner pad-none">
                         
                        <div class="inner-left inner-myclient left">
                            <div class="left-pannel right">
                                <div class="twelve columns left mydesbrd-right-area">
                                    <div class="twelve columns left mydesbrd-acc">
                                        <div class="mydesbrd-heading">Account Analytics</div>
                                        <div class="mydesbrd-acc-content">
                                            <p><span>Clients:</span> 25 clients</p>
                                            <p><span>Month to Date Sales:</span> $1000</p>
                                            <p><span>Average Monthly Sales:</span> $1500</p>
                                            <a href="#" title="">See More Details</a>
                                        </div>
                                    </div>
                                    <div class="twelve columns left mydesbrd-items">
                                        <div class="mydesbrd-heading">New Items</div>
                                        <div class="mydesbrd-items-content">
                                            <ul class="slider4">
                                                <li><img src="<?php echo $this->webroot; ?>images/jacket2.jpg" alt=""/></li>
                                                <li><img src="<?php echo $this->webroot; ?>images/jacket2.jpg" alt=""/></li>
                                                <li><img src="<?php echo $this->webroot; ?>images/jacket2.jpg" alt=""/></li>
                                                <li><img src="<?php echo $this->webroot; ?>images/jacket2.jpg" alt=""/></li>
                                                <li><img src="<?php echo $this->webroot; ?>images/jacket2.jpg" alt=""/></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="right-pannel left">
                                <div class="twelve columns message-area mydesbrd-msgara left pad-none">
                                    
                                        <div class="twelve columns left activity-feed-section">
                                            <ul>

                                                <!-- <li class="activity-wishlist">
                                                    <div class="activity-content-area">
                                                        <div class="activity-user-img"><img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt=""/></div>
                                                        <div class="activity-msg-area">
                                                            <div class="activity-user-name"><strong>Kyle Harper</strong> liked an item,</div>
                                                            <div class="activity-msg-dtl">
                                                                <span class="activity-prdct-img"><img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt=""/></span>
                                                                <span class="activity-product-dtl">
                                                                    <strong>Nice Loafers</strong><br>
                                                                    Prada<br>
                                                                    $650.00
                                                                </span>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="activity-date-section">
                                                            August 7, 2013<br>
                                                            12:30 pm EST<br>
                                                            <a href="#" title="">Send a Message</a>                                                                                                            </div>
                                                    </div>
                                                </li>
                                                
                                                <li class="activity-notification">
                                                    <div class="activity-content-area">
                                                        <div class="activity-user-img"><img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt=""/></div>
                                                        <div class="activity-msg-area">
                                                            <div class="activity-user-name"><strong>Kyle Harper</strong> requested an outfit.</div>
                                                            <div class="activity-msg-dtl">
                                                                <span class="activity-product-dtl">
                                                                    “I need an outfit appropriate for a business conference in Shanghai.”
                                                                </span>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="activity-date-section">
                                                            August 7, 2013<br>
                                                            12:30 pm EST<br>
                                                            <a href="#" title="">Create an Outfit</a>                                                                                                            </div>
                                                    </div>
                                                </li>
                                                
                                                <li class="activity-purchase">
                                                    <div class="activity-content-area">
                                                        <div class="activity-user-img"><img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt=""/></div>
                                                        <div class="activity-msg-area">
                                                            <div class="activity-user-name"><strong>Kyle Harper</strong> purchased an item.</div>
                                                            <div class="activity-msg-dtl">
                                                                <span class="activity-prdct-img"><img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt=""/></span>
                                                                <span class="activity-product-dtl">
                                                                    <strong>Nice Loafers</strong><br>
                                                                    Prada<br>
                                                                    $650.00
                                                                </span>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="activity-date-section">
                                                            August 7, 2013<br>
                                                            12:30 pm EST<br>
                                                            <a href="#" title="">Send a Message</a>                                                                                                            </div>
                                                    </div>
                                                </li>
                                                
                                                <li class="activity-refferal">
                                                    <div class="activity-content-area">
                                                        <div class="activity-user-img"><img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt=""/></div>
                                                        <div class="activity-msg-area">
                                                            <div class="activity-user-name"><strong>Kyle Harper</strong> referred a friend, Emmanuel Garcia.</div>
                                                        </div>
                                                        <div class="activity-date-section">
                                                            August 7, 2013<br>
                                                            12:30 pm EST<br>
                                                            <a href="#" title="">Send a Message</a>                                                                                                            </div>
                                                    </div>
                                                </li>
                                                
                                                <li class="activity-msg">
                                                    <div class="activity-content-area">
                                                        <div class="activity-user-img"><img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt=""/></div>
                                                        <div class="activity-msg-area">
                                                            <div class="activity-user-name"><strong>Kyle Harper</strong> sent you a message.</div>
                                                            <div class="activity-msg-dtl">
                                                                <span class="activity-product-dtl">
                                                                    “Hi Lisa, I had a quick question about the pants I bought......” <a href="#" title="">Read more</a>
                                                                </span>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="activity-date-section">
                                                            August 7, 2013<br>
                                                            12:30 pm EST<br>
                                                            <a href="#" title="">Create an Outfit</a>                                                                                                            </div>
                                                    </div>
                                                </li> -->
                                            </ul>
                                        </div>
                                    
                                </div>
                            </div>
                        
                        </div>
                    </div>
                
                </div>
                
                
                <div class="eleven columns container pad-none">
                    <div class="my-profile-img m-ver">
                        <h2>LISA D.<span>My Stylist</span></h2>
                        <div class="client-img-small right">
                        <a href="javascript:;" title=""><img src="<?php echo $this->webroot; ?>images/my-profile/my-profile-img.jpg" alt="" /></a>
                        </div>
                        <span id="dd-nav-switcher"><img src="<?php echo $this->webroot; ?>images/nav-switcher-icon.png" alt="" /></span>
                    </div>
                    <div class="dd-nav">
                        <ul>
                            <li><a href="javascript:;">Messages</a></li>
                            <li class="active"><a href="javascript:;">Outfits</a></li>
                            <li><a href="javascript:;">Purchases/Likes</a></li>
                            <li><a href="javascript:;">Profile</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).read(function(){
        var isFirstLoad = true,
            chatContainer = $('.chat-container'),
            callInAction = false,
            reqNewMsgDelay=6000,
            firstMsgId = 0;
        

        function loadFeed(userId) {
            if(!userId){
                userId = "";
            }
            $.ajax({
                url: "<?php echo $this->webroot; ?>messages/loadFeed/",
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

    });
    
        // var isFirstLoad = true,
        //     chatContainer = $('.chat-container'),
        //     callInAction = false,
        //     reqNewMsgDelay=6000,
        //     firstMsgId = 0;
        
        // function loadMessages(userId) {
        //     if(!userId){
        //         userId = "";
        //     }
        //     $.ajax({
        //         url: "<?php echo $this->webroot; ?>messages/getMyConversation/" + userId,
        //         cache: false,
        //         type: 'POST',
        //         success: function(res) {
        //             res = jQuery.parseJSON(res);
        //             if (res['status']=='ok') {
        //                 var arrMsg = res['Messages'];
        //                 if(arrMsg.length){
        //                     for(var i=0; i < arrMsg.length; i++){
        //                         var html = showChatMsg(arrMsg[i]);
        //                         chatContainer.append(html);
        //                         firstMsgId = arrMsg[i]['Message']['id'];
        //                     }
        //                     if(res['msg_remaining'] > 0){
        //                         $("#loadOldMsgs").fadeIn(300);    
        //                     }
                            
        //                 }
        //                 else{  
                            
        //                 } 
        //             }
        //         },
        //         error: function(res) {
                    
        //         }
        //     });
        // }
        
        // function loadNewMessages(){
        //     callInAction = true;
        //     $.ajax({
        //         url: "<?php echo $this->webroot; ?>messages/getNewMessages/" + userId,
        //         cache: false,
        //         type: 'POST',
        //         success: function(res) {
        //             res = jQuery.parseJSON(res);
        //             if (res['status']=='ok') {
        //                 var arrMsg = res['Messages'];
        //                 for(var i=0; i < arrMsg.length; i++){
        //                     var html = showChatMsg(arrMsg[i]);
        //                     chatContainer.append(html);
        //                 }
        //             }
        //         },
        //         error: function(res) {
                    
        //         }
        //     }).done(function(res){
        //         callInAction = false;
        //     });    
        // }
        
        // function showChatMsg(chatMsg) {
        //     var html = ''; 
        //     if(chatMsg['Message']['is_outfit'] == 1){
        //         //html = html + '<div class="chat-msg-box" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">';  
        //         //html = html + '<div class="message-caption">' + chatMsg['UserFrom']['first_name'] + ' suggested new items to complete a style:</div>'; 
        //         if(chatMsg['Message']['body'] != '' && chatMsg['Message']['body'] != 'outfit'){
        //             //html = html + '<div class="message-body">' + chatMsg['Message']['body'] + '</div><br>';
        //         }
                
        //         html = html +   '<div class="client-outfit">'+
        //                             '<div class="client-msg-reply"><span>Beach Day</span></div>' + 
        //                                 '<ul>';
        //         ;
        //         for(var i=0; i<chatMsg['Outfit'].length; i++){
        //             var imgSrc = webroot + "img/image_not_available-small.png";
        //             if(typeof(chatMsg['Outfit'][i]["Image"]) != "undefined" && chatMsg['Outfit'][i]["Image"].length > 0){
        //                 imgSrc = webroot + "products/resize/" + chatMsg['Outfit'][i]["Image"][0]["name"] + "/98/135";
        //             }
                    
        //             var likedClass = "";
        //             var dislikedClass = "";
        //             if(chatMsg['Outfit'][i]['Wishlist'] && chatMsg['Outfit'][i]['Wishlist']['id'] && chatMsg['Outfit'][i]['Wishlist']['id'] > 0){
        //                 likedClass = "liked"    
        //             }
                    
        //             if(chatMsg['Outfit'][i]['Dislike'] && chatMsg['Outfit'][i]['Dislike']['id'] && chatMsg['Outfit'][i]['Dislike']['id'] > 0){
        //                 dislikedClass = "disliked"    
        //             }
                    
                    
        //             html = html + 
                    
        //                 '<input type="hidden" value="' + chatMsg['Outfit'][i]['Entity']['slug'] + '" class="product-slug">' + 
        //                     '<input type="hidden" value="' + chatMsg['Outfit'][i]['Entity']['id'] + '" class="product-id">' + 
        //                     '<li><img src="' + imgSrc + '" alt="' + chatMsg['Outfit'][i]['Entity']['name'] + '" alt="" /></li>'; 
        //         }

        //             html = html +  '</ul>' +
        //                             '<div class="msg-date">' + chatMsg['Message']['created'] + '</div>' +
        //                             '</div>';
        //     }
        //     else if(chatMsg['Message']['image']){
        //         html = '' + 
        //                 '<div class="chat-msg-box" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">' + 
        //                     '<div class="message-caption">' + chatMsg['UserFrom']['first_name'] + ' sent an image:</div>' + 
        //                     '<div class="message-image"><img src="<?php echo $this->webroot; ?>files/chat/' + chatMsg['Message']['image'] + '" /></div>' + 
        //                     '<div class="message-date">' +
        //                         '<small>' + chatMsg['Message']['created'] + '</small>' +
        //                     '</div>' + 
        //                 '</div>';
        //     }
        //     else{
        //         if(chatMsg['UserFrom']['id'] == uid){
                    
        //             html = '' + 
        //                 '<div class="chat-msg-box cur-user-msg" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">' + 
        //                     '<div class="client-msg">' + 
        //                     '<div class="client-msg-reply">' + chatMsg['Message']['body'] + '</div>' + 
        //                         '<div class="msg-date">' + chatMsg['Message']['created'] + '</idv>' +
        //                 '</div>';
        //         }
        //         else{
                    
        //             html = '' + 
        //                 '<div class="chat-msg-box" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">' +
        //                     '<div class="user-msg">' + 
        //                     '<div class="msg">' + chatMsg['Message']['body'] + '</div>' + 
        //                         '<div class="msg-date">' + chatMsg['Message']['created'] + '</div>' +
        //                     '</div>' + 
        //                 '</div>';
        //         }
        //     }       
        //     return html;
        // }
    

</script>