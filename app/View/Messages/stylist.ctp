<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$script = ' 
var uid = ' . $user_id . ';
var client_id = ' . $client_id . ';
var webroot = "' . $this->webroot . '";
var clientArray = ' . json_encode($client_array) . ';
var isAdmin = "' . $is_admin . '";

';
$this->Html->script('//knockoutjs.com/downloads/knockout-2.3.0.js', array('inline' => false));
$this->Html->script('outfit.js', array('inline' => false));
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->script("mosaic.1.0.1.min.js", array('inline' => false));
$this->Html->script('/js/date-format.js', array('inline' => false));
?>
<?php echo $this->Form->create('User', array('url' => '/messages/send_to_user', 'type' => 'file')); ?>
<div class="container content inner timeline">	

    <div class="sixteen columns">
        <div class="five columns user-container">
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
                <?php if($client_id) : ?>
                    <div id="user-name"><?php echo $client_user['User']['full_name']; ?></div>
                        <div class="last-user-purchase">
                            <?php if(isset($last_purchase['Order'])) : ?>
                                Last Purchase: <span>$<?php echo $last_purchase['Order']['total_price']; ?></span> <br />
                                on <?php echo date('l:jS F Y, h:ia', strtotime($last_purchase['Order']['created'])); ?>
                            <?php else : ?>
                                Last Purchase: <span>No purchases yet.</span>
                            <?php endif; ?>
                        </div>
                        <div class="recent-activity">
                            Recent Activity (30 Days): <br />
                            -Amount Spent: <span>$<?php echo $recent_purchase; ?></span><br />
                            -Messages Sent: <span><?php echo $recent_messages; ?></span>
                        </div><br />
                <?php endif; ?>
            </div>
            <?php if(!$is_admin) : ?>
                <br />
                <h5 class="new-clients-head">New Clients</h5>
                <div class="new-clients">
                <?php if(isset($new_clients) && count($new_clients) > 0) {
                    foreach($new_clients as $new_cl){
                        echo '<div class="client-row">' . 
                            '<a href="' . $this->webroot . 'messages/index/' . $new_cl['User']['id'] . '">' . $new_cl['User']['first_name'] . '</a> has been assigned to you.' . 
                        '</div>';    
                    }    
                }
                ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="ten columns aplha stylist-talk">
            <?php if($client_id) : ?>
                <ul id="stylist-options">
                    <li><a href="<?php echo $this->webroot; ?>profile/about/<?php echo $client_id; ?>" target="_blank">user profile</a></li>
                    <li><a href="<?php echo $this->webroot; ?>mycloset/liked/<?php echo $client_id; ?>" target="_blank">user closet</a></li>
                    <!--<li><a href="">conversation</a></li>-->                
                </ul>
            <?php endif; ?>
            <h4 class='nine columns talk-to'>TALK WITH YOUR CLIENT</h4>
                <?php if(!$is_admin) : ?>
                <?php
                echo $this->Form->input('user_to_id', array('label' => '', 'type' => 'select', 'options' => $clients, 'name' => 'data[Message][user_to_id]', 'empty' => "Select Client", 'class' => 'select_client', 'style' => 'max-width: 68%;'));
                ?> 
                <?php endif; ?>  
                
                <a class="link-btn gold-btn"  id="createOutfit"  href="">Create New Outfit</a>
                <textarea class="ten columns alpha omega chat-msg-txtbox" id='messageToSend' name="data[Message][body]"></textarea>
                <a class="link-btn black-btn"  id="sendMessages"  href="">Send Messages</a>
            
            <div class="chat-container">
                
            </div>
            <div class="clear"></div>
            <p id="loadOldMsgs" class="hide">
                <span class="hide"><img src="<?php echo $this->webroot; ?>img/ajax-loader.gif" width="20" /></span>
                <a href="">Load Old Messages</a>
            </p>
            <br />
        </div>
    </div>

</div>

<?php echo $this->Form->end(); ?>


<!-- Create outfit popup-->
<div id="outfit-box" class="hide outfit-modal container content">
    <div class="create-outfit-cont">
        <a class="outfit-close" href=""></a>
        <div class="sixteen columns text-center">
            <h1>Create a new outfit</h1>
        </div>
        <div class="fifteen columns offset-by-half product-listing">
            <br />
            <div class="three columns alpha row" id="outfit1">
                <div class="product-block">
                    <input type="hidden" value="" class="product-slug">
                    <input type="hidden" value="" class="product-id">
                    <div class="product-list-image mosaic-block fade">
                    
                    </div>
                    <div class="product-list-links">
                        <a href="" class="btn-user-closet btn-outfit">User Closet</a>
                        <a href="" class="btn-srs-closet  btn-outfit">SRS Closet</a>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            
            <div class="three columns alpha row" id="outfit2">
                <div class="product-block">
                    <input type="hidden" value="" class="product-slug">
                    <input type="hidden" value="" class="product-id">
                    <div class="product-list-image mosaic-block fade">

                    </div>
                    <div class="product-list-links">
                        <a href="" class="btn-user-closet btn-outfit">User Closet</a>
                        <a href="" class="btn-srs-closet  btn-outfit">SRS Closet</a>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            
            <div class="three columns alpha row" id="outfit3">
                <div class="product-block">
                    <input type="hidden" value="" class="product-slug">
                    <input type="hidden" value="" class="product-id">
                    <div class="product-list-image mosaic-block fade">

                    </div>
                    <div class="product-list-links">
                        <a href="" class="btn-user-closet btn-outfit">User Closet</a>
                        <a href="" class="btn-srs-closet  btn-outfit">SRS Closet</a>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            
            <div class="three columns alpha row" id="outfit4">
                <div class="product-block">
                    <input type="hidden" value="" class="product-slug">
                    <input type="hidden" value="" class="product-id">
                    <div class="product-list-image mosaic-block fade">

                    </div>
                    <div class="product-list-links">
                        <a href="" class="btn-user-closet btn-outfit">User Closet</a>
                        <a href="" class="btn-srs-closet  btn-outfit">SRS Closet</a>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            
            <div class="three columns alpha row" id="outfit5">
                <div class="product-block">
                    <input type="hidden" value="" class="product-slug">
                    <input type="hidden" value="" class="product-id">
                    <div class="product-list-image mosaic-block fade">

                    </div>
                    <div class="product-list-links">
                        <a href="" class="btn-user-closet btn-outfit">User Closet</a>
                        <a href="" class="btn-srs-closet  btn-outfit">SRS Closet</a>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            
            <div class="clear"></div>
            <br />
            <div class="form">
                <div class="six columns text-center offset-by-one">
                    <label>Location (East Coast or West Coast)</label>
                    <select name="outfit-location" id="outfit-location">
                        <option value="East Coast">East Coast</option>
                        <option value="West Coast">West Coast</option>
                    </select>
                </div>
                <div class="six columns text-center">
                    <label>Type of the outfit</label>
                    <select name="outfit-location" id="outfit-style">
                        <option>Casual</option>
                        <option>Formal</option>
                        <option>PartyWear</option>
                    </select>
                </div>
            </div>
            <div class="clear"></div>
            <div class="text-center">
                <br /><br /><br />
                <a href="" id="add-outfit" class="link-btn black-btn">Suggest the Outfit</a>
            </div>
        </div>
            <div class="clear"></div>
    </div>
    <div class="user-closet-cont hide">
        <a class="user-closet-close" href=""></a>
        <div class="sixteen columns text-center">
            <h1>User Closet</h1>
        </div>
        <div class="sixteen columns product-listing">
            <div class="mycloset-tabs text-center">
                <a href="" class="link-btn gold-btn like-cont-link">Liked Items</a>
                <a href="" class="link-btn gray-btn purchased-cont-link">Purchased Items</a>
            </div>
            <div class="user-closet-list-cont">
                <div class="purchased-list-cont hide">
                    <div class="product-listing-box">

                    </div>
                    
                    <div class="clear"></div>
                    <div class="btn-outfit-cont text-right">
                        <a href="" class="link-btn black-btn load-more-purchased">Load More</a>
                        <a href="" class="link-btn black-btn add-purchased-outfit">Add to outfit</a>
                    </div>
                </div>
                
                <div class="liked-list-cont">
                    <div class="product-listing-box">

                    </div>
                    
                    <div class="clear"></div>
                    <div class="btn-outfit-cont text-right">
                        <a href="" class="link-btn black-btn load-more-liked">Load More</a>
                        <a href="" class="link-btn black-btn add-liked-outfit">Add to outfit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="srs-closet-cont hide">
        <a class="srs-closet-close" href=""></a>
        <div class="sixteen columns text-center">
            <h1>SRS Closet</h1>
        </div>
        
        <div class="fifteen offset-by-half columns omega">
            <div class="three columns alpha">
                <div class="product-filter-menu">
                    <ul class="text-left">
                        <li class="toggle-tab selected open-filter" style="height: 140px;overflow-y: auto;"><span>Categories</span>
                            <ul class="toggle-body product-categories">
                            <?php foreach ($categories as $category): ?>
                                <li data-category_id="<?php echo $category['Category']['slug']; ?>">
                                    <a><?php echo $category['Category']['name']; ?></a>
                                    <ul class="product-subcategories">
                                        <?php foreach ($category['children'] as $subcategory): ?>
                                            <li data-category_id="<?php echo $subcategory['Category']['slug']; ?>">
                                                <a><?php echo $subcategory['Category']['name']; ?></a>
                                                <?php if ($subcategory['children']) : ?>
                                                    <ul class="product-subcategories product-subsubcategories">
                                                        <?php foreach ($subcategory['children'] as $subsubcategory): ?> 
                                                            <li data-category_id="<?php echo $subsubcategory['Category']['slug']; ?>">
                                                                <a><?php echo $subsubcategory['Category']['name']; ?></a>
                                                            </li>    
                                                        <?php endforeach; ?>
                                                    </ul>       
                                                <?php endif; ?>     
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            <?php endforeach; ?>
                            </ul>
                        </li>
                        <li class="toggle-tab" style="height: 140px;overflow-y: auto;"><span>Brand</span>
                            <ul class="toggle-body brand-filter">
                            <?php if($brands) : ?>
                                <?php foreach($brands as $brand) : ?>
                                    <li data-brand_id="<?php echo $brand['Brand']['id']; ?>"><?php echo $brand['Brand']['name']; ?></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </ul>
                        </li>
                        <li class="toggle-tab" style="height: 140px;overflow-y: auto;"><span>Color</span>
                            <ul class="toggle-body color-filter">
                            <?php if($colors) : ?>
                                <?php foreach($colors as $color) : ?>
                                        <li data-color_id="<?php echo $color['Colorgroup']['id']; ?>"><?php echo $color['Colorgroup']['name']; ?></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="twelve columns omega product-listing">
                <div class="product-top-offset">
                    <span class="text-center">Click on a product to select it.</span>
                </div>

                <div class="srs-closet-items"></div>
                <div class="clear"></div>
                <div class="btn-outfit-cont text-right">
                    <img src="<?php echo $this->webroot; ?>img/loading.gif" width="28" class="hide closet-load-icon" style="position: relative; top: 8px;" /> &nbsp;
                    <a href="" class="link-btn black-btn load-more-closet">Load More</a>
                    <a href="" class="link-btn black-btn add-closet-outfit">Add to outfit</a>
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
        
        function loadMessages(userId) {
            if(!userId){
                userId = "";
            }
            $.ajax({
                url: "<?php echo $this->webroot; ?>messages/getMyConversation/" + userId,
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
                html = html + '<div class="message-caption">You suggested new items to complete a style:</div><br>'; 
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
                                '<a href="' + webroot + 'product/' + chatMsg['Outfit'][i]['Entity']['id'] + '/' + chatMsg['Outfit'][i]['Entity']['slug'] + '" class="btn-buy" target="_blank">Buy</a>' +                             
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
                        '<div class="ten columns alpha omega chat-msg-box" data-user-id="' + chatMsg['Message']['user_from_id'] + '" data-msg-id="' + chatMsg['Message']['id'] + '">' + 
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
        
        $("#sendMessages").click(function(e) {
            e.preventDefault();
            if(!$("#messageToSend").hasClass("sending") && $("#messageToSend").val() != '') {
                $("#messageToSend").addClass("sending");
                var message = $("#messageToSend").val();
                var _data = {
                    body: message,
                    user_to_id: userId
                }
                $.ajax({
                    url: "<?php echo $this->webroot; ?>messages/send_to_user",
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
    }
    

</script>


