<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$script = ' 
var uid = ' . $user_id . ';
var client_id = ' . $client_id . ';
var webroot = ' . $this->webroot . ';
';
$this->Html->script('http://knockoutjs.com/downloads/knockout-2.3.0.js', array('inline' => false));
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
                <div class="profile-img">
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
                <div id="user-name"><?php echo $client_user['User']['full_name']; ?></div>
            </div>
        
        </div>
        <div class="ten columns aplha stylist-talk">
            <ul id="stylist-options">
                <li><a href="<?php echo $this->webroot; ?>profile/about/<?php echo $client_id; ?>">user profile</a></li>
                <li><a href="">user closet</a></li>
                <li><a href="">conversation</a></li>                
            </ul>
            <h4 class='nine columns talk-to'>TALK WITH YOUR CLIENT</h4>
                <?php
//echo $this->Form->input('', array('options'=>$clients, 'displayField' => 'full_name', '   default'=>'m'));
                echo $this->Form->input('user_to_id', array('label' => '', 'type' => 'select', 'options' => $clients, 'name' => 'data[Message][user_to_id]', 'empty' => "Select Client", 'class' => 'select_client'));
                /* , 'name' => 'data[Message][user_to_id]' */
                ?>                
                <!--<input type="button" value="Create Outfit" id="createOutfit"/>-->
                <a class="link-btn gold-btn"  id="createOutfit"  href="">Create New Outfit</a>
                <!--<input type="button" value="Load user conversation" id="loadMessages" />-->
                <a class="link-btn black-btn"  id="loadMessages"  href="">Load User</a>

            <textarea class="ten columns alpha omega chat-msg-txtbox" id='messageToSend' name="data[Message][body]"></textarea>
            <a class="link-btn black-btn"  id="sendMessages"  href="">Send Messages</a>
            
            <div class="chat-container">
                
            </div>
            <div class="clear"></div>
            <br /><br /><br />
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
                        <option value="East Cost">East Cost</option>
                        <option value="West Cost">West Cost</option>
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
                                <li data-category_id="<?php echo $category['Category']['slug']; ?>"><?php echo $category['Category']['name']; ?>
                                    <ul class="product-subcategories">
                                        <?php foreach ($category['children'] as $subcategory): ?>
                                            <li data-category_id="<?php echo $subcategory['Category']['slug']; ?>"><?php echo $subcategory['Category']['name']; ?></li>
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
                                        <li data-color_id="<?php echo $color['Color']['id']; ?>"><?php echo $color['Color']['name']; ?></li>
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
            reqNewMsgDelay=6000;
        
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
        
        $("#loadMessages").click(function(e) {
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
            });
        });
    }
    

</script>


