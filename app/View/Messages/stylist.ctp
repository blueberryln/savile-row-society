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

<?php
                        $img = "";
                        if(isset($client_user) && $client_user['User']['profile_photo_url'] && $client_user['User']['profile_photo_url'] != ""){
                            $img = $this->webroot . "files/users/" . $client_user['User']['profile_photo_url'];
                        }
                        else{
                            $img = $this->webroot . "img/dummy_image.jpg";    
                        }
                    ?>
<!--client image end-->






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

<!-- Create outfit popup-->
<div id="outfit-box" class="hide outfit-modal container content">
    <div class="create-outfit-cont">
        <a class="outfit-close" href=""></a>
        <div class="text-center">
            <h1 class="pop-heading">Create a new outfit</h1>
        </div>
        <div class="eleven columns center-block product-listing">            
            <div class="outfit-item" id="outfit1">
                <div class="product-block">
                    <input type="hidden" value="" class="product-slug">
                    <input type="hidden" value="" class="product-id">
                    <div class="product-list-image mosaic-block fade">
                    
                    </div>
                    <div class="product-list-links">
                        <a href="" class="btn-user-closet btn-outfit">User Closet</a>
                        <a href="" class="btn-srs-closet  btn-outfit">SRS Closet</a>
                        <div class="clear-fix"></div>
                    </div>

                    <!--bhashit code-->
                    <div class="four columns text-center">
                    <label>Size</label>
                    <select name="outfit-size1" id="outfit-size1">
                        <option value="0">Please select Size</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                    </select>
                </div>
                    <!--bhashit code end-->

                </div>
            </div>
            
            <div class="outfit-item" id="outfit2">
                <div class="product-block">
                    <input type="hidden" value="" class="product-slug">
                    <input type="hidden" value="" class="product-id">
                    <div class="product-list-image mosaic-block fade">

                    </div>
                    <div class="product-list-links">
                        <a href="" class="btn-user-closet btn-outfit">User Closet</a>
                        <a href="" class="btn-srs-closet  btn-outfit">SRS Closet</a>
                        <div class="clear-fix"></div>
                    </div>

                    <!--bhashit code-->
                    <div class="four columns text-center">
                    <label>Size</label>
                    <select name="outfit-size2" id="outfit-size2">
                        <option value="0">Please select Size</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                    </select>
                </div>
                    <!--bhashit code end-->
                </div>
            </div>
            
            <div class="outfit-item" id="outfit3">
                <div class="product-block">
                    <input type="hidden" value="" class="product-slug">
                    <input type="hidden" value="" class="product-id">
                    <div class="product-list-image mosaic-block fade">

                    </div>
                    <div class="product-list-links">
                        <a href="" class="btn-user-closet btn-outfit">User Closet</a>
                        <a href="" class="btn-srs-closet  btn-outfit">SRS Closet</a>
                        <div class="clear-fix"></div>
                    </div>

                    <!--bhashit code-->
                    <div class="four columns text-center">
                    <label>Size</label>
                    <select name="outfit-size3" id="outfit-size3">
                    <option value="0">Please select Size</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                    </select>
                </div>
                    <!--bhashit code end-->
                </div>
            </div>
            
            <div class="outfit-item" id="outfit4">
                <div class="product-block">
                    <input type="hidden" value="" class="product-slug">
                    <input type="hidden" value="" class="product-id">
                    <div class="product-list-image mosaic-block fade">

                    </div>
                    <div class="product-list-links">
                        <a href="" class="btn-user-closet btn-outfit">User Closet</a>
                        <a href="" class="btn-srs-closet  btn-outfit">SRS Closet</a>
                        <div class="clear-fix"></div>
                    </div>

                    <!--bhashit code-->
                    <div class="four columns text-center">
                    <label>Size</label>
                    <select name="outfit-size4" id="outfit-size4">
                    <option value="0">Please select Size</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                    </select>
                </div>
                    <!--bhashit code end-->
                </div>
            </div>
            
            <div class="outfit-item" id="outfit5">
                <div class="product-block">
                    <input type="hidden" value="" class="product-slug">
                    <input type="hidden" value="" class="product-id">
                    <div class="product-list-image mosaic-block fade">

                    </div>
                    <div class="product-list-links">
                        <a href="" class="btn-user-closet btn-outfit">User Closet</a>
                        <a href="" class="btn-srs-closet  btn-outfit">SRS Closet</a>
                        <div class="clear-fix"></div>
                    </div>

                    <!--bhashit code-->
                    <div class="four columns text-center">
                    <label>Size</label>
                    <select name="outfit-size5" id="outfit-size5">
                    <option value="0">Please select Size</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                    </select>
                </div>
                    <!--bhashit code end-->
                </div>
            </div>
            
            <div class="clear-fix"></div>            
            <div class="form outfit-form">
                <div class="four columns text-center">
                    <label>Location (East Coast or West Coast)</label>
                    <select name="outfit-location" id="outfit-location">
                        <option value="East Coast">East Coast</option>
                        <option value="West Coast">West Coast</option>
                    </select>
                </div>
                <!--<div class="four columns text-center">
                    <label>Type of the outfit</label>
                    <select name="outfit-location" id="outfit-style">-->
                        <!-- <option>Casual</option>
                        <option>Formal</option>
                        <option>PartyWear</option>-->
                        <!--bhashit code-->
                       <!-- <option>OutFit Look 1</option>
                        <option>OutFit Look 2</option>
                        <option>OutFit Look 3</option>
                        <option>OutFit Look 4</option>
                        <option>OutFit Look 5</option>
                        <option>OutFit Look 6</option>
                        <option>OutFit Look 7</option>-->
                        <!--bhashit code end-->
                   <!-- </select>
                </div>-->
                 <div class="clear-fix"></div>
                <div class="four columns text-center">
                    <label>OutFit Name:</label>
                    <input type="text" name="out-name" id='out-name'>        
                </div>
            


                <div class="clear-fix"></div>
                <div class="eight columns text-center">
                    <label>Message:</label>
                    <textarea id='outfitMessageToSend'></textarea>        
                </div>
            </div>

            <div class="clear-fix"></div>
            <div class="text-center">
                <a href="" id="add-outfit" class="link-btn black-btn">Suggest the Outfit</a>
                <div class="hide suggest-outfit-loader"><img src="<?php echo $this->webroot; ?>img/loader.gif"></div>
            </div>
        </div>
            <div class="clear-fix"></div>
    </div>
    <div class="user-closet-cont hide">
        <a class="user-closet-close" href=""></a>
        <div class="sixteen columns text-center">
            <h1>User Closet</h1>
        </div>
        <div class="sixteen columns product-listing">
            <div class="mycloset-tabs text-center">
                <a href="" class="link-btn black-btn like-cont-link">Liked Items</a>
                <a href="" class="link-btn gray-btn purchased-cont-link">Purchased Items</a>
                <!--bhashit code start-->
                <a href="" class="link-btn gray-btn favorites-cont-link">My Favorites</a>
                <!--bhashit code end-->
            </div>
            <div class="user-closet-list-cont nine-five columns center-block text-left">
                <div class="purchased-list-cont hide">
                    <div class="product-listing-box">

                    </div>
                    
                    <div class="clear-fix"></div>
                    <div class="btn-outfit-cont text-right">
                        <!-- <a href="" class="link-btn black-btn load-more-purchased">Load More</a> -->
                        <a href="" class="link-btn black-btn add-purchased-outfit">Add to outfit</a>
                    </div>
                </div>

                <!--bhashit code-->
                <div class="favorites-list-cont hide">
                   <div class="product-listing-box">

                    </div> 
                    <div class="clear-fix"></div>
                    <div class="btn-outfit-cont text-right">
                        <!-- <a href="" class="link-btn black-btn load-more-purchased">Load More</a> -->
                        <a href="" class="link-btn black-btn add-favorites-outfit">Add to outfit</a>
                    </div>
                </div>
                <!--bhashit code-->
                
                <div class="liked-list-cont">
                    <div class="product-listing-box">

                    </div>
                    
                    <div class="clear-fix"></div>
                    <div class="btn-outfit-cont text-right">
                        <!-- <a href="" class="link-btn black-btn load-more-liked">Load More</a> -->
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
        
        <div class="nine-five columns omega center-block">
            <div class="two columns alpha left">
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
            <div class="nine columns product-listing right text-left">
                <div class="product-top-offset text-center">
                    <span class="text-center">Click on a product to select it.</span>
                </div>

                <div class="srs-closet-items"></div>
                <div class="clear-fix"></div>
                <div class="btn-outfit-cont text-right">
                    <img src="<?php echo $this->webroot; ?>img/loading.gif" width="28" class="hide closet-load-icon" style="position: relative; top: 8px;" /> &nbsp;
                    <a href="" class="link-btn black-btn clear-all-closet">Clear All</a>
                    <!-- <a href="" class="link-btn black-btn load-more-closet">Load More</a> -->
                    <a href="" class="link-btn black-btn add-closet-outfit">Add to outfit</a>
                </div>
                    
            </div>
            <div class="clear-fix"></div>
            
        </div>
        
        
        
        
    </div>
    </div>
</div>



 





<!--bhashit new code start -->

<div class="content-container">
    <div class="twelve columns black">&nbsp;</div>
    <div class="twelve columns container">
        <div class="eleven columns container message-box-area">
            <div class="twelve columns container left message-box">
                <div class="eleven columns container pad-none">
                    <div class="twelve columns message-box-heading pad-none">
                        <h1><?php echo $client_user['User']['full_name']; ?> | <span>Messages</span></h1>
                        <div class="client-img-small"><img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt="" data-name="Haspel" /></div>
                    </div>

                    

                    <div class="my-profile-img m-ver">
                       <!--  <h2>LISA D.<span>My Stylist</span></h2> -->
                        <!-- <div class="client-img-small right">
                        <a href="javascript:;" title=""><img src="<?php echo $this->webroot; ?>images/my-profile/my-profile-img.jpg" alt="" /></a>
                        </div> -->
                        <span id="dd-nav-switcher"><img src="<?php echo $this->webroot; ?>images/nav-switcher-icon.png" alt="" /></span>
                    </div>
                    <div class="dd-nav">
                        <ul>
                            <li class="active"><a href="javascript:;">Messages</a></li>
                            <li><a href="javascript:;">Outfits</a></li>
                            <li><a href="javascript:;">Purchases/Likes</a></li>
                            <li><a href="javascript:;">Profile</a></li>
                        </ul>
                    </div>
                    <div class="twelve columns left inner-content pad-none">
                        <div class="inner-left left">
                            <div class="left-pannel left">
                                <div class="client-img"><img src="<?php echo $img; ?>" id="user_image" /></div>
                                <div class=" twelve columns left left-nav">
                                    <ul>
                                        <li class="active"><a href="javascript:;">Messages</a></li>
                                        <li><a href="javascript:;">Outfits</a></li>
                                        <li><a href="javascript:;">Purchases/Likes</a></li>
                                        <li><a href="javascript:;">Profile</a></li>
                                        <li>
                            <?php if(!$is_admin) : ?>
                        <?php
                    echo $this->Form->input('user_to_id', array('label' => '', 'type' => 'select', 'options' => $clients, 'name' => 'data[Message][user_to_id]', 'empty' => "Select Client", 'class' => 'select_client', 'style' => 'max-width: 68%;'));
                    ?> 
                    <?php endif; ?></li>
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
                                <div class="twelve coloumns left">
                                    <div class="bottom-text">
                                        <div class="dummy-text">
                                            
                    <textarea class="chat-msg-txtbox" id='messageToSend' name="data[Message][body]"></textarea>
                   

                                        </div>
                                    </div>
                                </div>
                                <div class=" twelve columns left bottom-btns">
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

<!--bhashit code end-->



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