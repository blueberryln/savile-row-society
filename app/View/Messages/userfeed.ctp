<?php
$this->Html->script('/js/jquery-dateFormat.min.js', array('inline' => false));
?>

    <div class="twelve columns container">
        <div class="eleven columns container message-box-area">
            <div class="twelve columns container left message-box">
                
                <?php echo $this->element('clientAside/userFilterBar'); ?>
                
                
                <div class="myclient-right right">
                    <div class="twelve columns left inner-content pad-none">
                            
                            <?php echo $this->element('clientAside/userLinksLeft'); ?>

                            <div class="right-pannel right">
                                <div class="twelve columns message-area left pad-none">
                                    <div class="eleven columns container pad-none">
                                        <div class="twelve columns left activity-feed-section">
                                            <ul>
                                               
                                                
                                                
                                            </ul>
                                            <p class="pagination loadOldFeed">
                                                <span class="hide"><img src="/img/ajax-loader.gif" width="20"></span>
                                                <a href="#">Load More Products</a>
                                            </p>
                                        </div>
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
                                <a class="left pop-outfit-reuse" href="" title="">Resuse Outfit</a>
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

    $(document).ready(function(){
        var isFirstLoad = true,
            feedContainer = $('.activity-feed-section>ul'),
            callInAction = false,
            reqNewMsgDelay=6000,
            lastPostId = 0,
            firstPostId = 0,
            user_id = <?php echo $client_user['User']['id']; ?>;
        
        loadFeed();

        $(".loadOldFeed").on('click', function(e){
            e.preventDefault();
            loadOldFeed();

        });

        function loadFeed(userId) {
            if(!userId){
                userId = "";
            }
            $.ajax({
                url: "<?php echo $this->webroot; ?>feed/loadFeed/" + user_id,
                cache: false,
                type: 'POST',
                success: function(res) {
                    res = jQuery.parseJSON(res);
                    if (res['status']=='ok') {
                        var arrPost = res['posts'];
                        if(arrPost.length){
                            for(var i=0; i < arrPost.length; i++){
                                if(firstPostId == 0){
                                    firstPostId = arrPost[i]['Post']['id'];
                                }
                                var html = showFeed(arrPost[i]);
                                feedContainer.append(html);
                                lastPostId = arrPost[i]['Post']['id'];
                                
                            }
                        }
                        else{  
                            
                        } 
                    }
                    setInterval(loadNewFeed, reqNewMsgDelay);
                },
                error: function(res) {
                    
                }
            });
        }


        function loadNewFeed(userId) {
            if(!userId){
                userId = "";
            }
            $.ajax({
                url: "<?php echo $this->webroot; ?>feed/loadNewFeed/" + user_id,
                data: {'first_post_id': firstPostId},
                cache: false,
                type: 'POST',
                success: function(res) {
                    res = jQuery.parseJSON(res);
                    if (res['status']=='ok') {
                        var arrPost = res['posts'];
                        if(arrPost.length){
                            firstPostId = arrPost[arrPost.length-1]['Post']['id'];
                            for(var i=0; i < arrPost.length; i++){
                                var html = showFeed(arrPost[i]);
                                feedContainer.prepend(html);
                            }
                        }
                    }
                },
                error: function(res) {
                    
                }
            });
        }


        function loadOldFeed(userId) {
            if(!userId){
                userId = "";
            }

            $.ajax({
                url: "<?php echo $this->webroot; ?>feed/loadOldFeed/" + user_id,
                data: {'last_post_id': lastPostId},
                cache: false,
                type: 'POST',
                success: function(res) {
                    res = jQuery.parseJSON(res);
                    if (res['status']=='ok') {
                        var arrPost = res['posts'];
                        if(arrPost.length){
                            for(var i=0; i < arrPost.length; i++){
                                var html = showFeed(arrPost[i]);
                                feedContainer.append(html);
                                lastPostId = arrPost[i]['Post']['id'];
                            }
                        }
                        else{  
                            $('.loadOldFeed').hide();     
                        } 
                    }
                },
                error: function(res) {
                    
                }
            });
        }

        function showFeed(feed) {
            var html = ''; 
            if(feed['Post']['is_like'] == 1){
                var profile_url = (feed['User']['profile_photo_url']) ? 'files/users/' + feed['User']['profile_photo_url'] : 'images/default-user.jpg';
                var prodcut_url = '';
                html =  '<li class="activity-wishlist" data-post_id="' + feed['Post']['id'] + '">' + 
                            '<div class="activity-content-area">' + 
                                '<div class="activity-icn"></div>' +
                                '<div class="activity-user-img"><img src="<?php echo $this->webroot; ?>' + profile_url + '" alt=""/></div>' + 
                                '<div class="activity-msg-area">' + 
                                    '<div class="activity-user-name"><strong>' + feed['User']['first_name'].capitalize() + ' ' + feed['User']['last_name'].capitalize() + '</strong> liked an item,</div>' + 
                                    '<div class="activity-msg-dtl">' + 
                                        '<span class="activity-prdct-img"><img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt=""/></span>' + 
                                        '<span class="activity-product-dtl">' + 
                                            '<strong>' + feed['Entity']['name'] + '</strong><br>' + 
                                            feed['Brand']['name'] + '<br>' + 
                                            '$' + feed['Entity']['price'] + 
                                        '</span>' + 
                                    '</div>' +    
                                '</div>' + 
                                '<div class="activity-date-section">' + 
                                    $.format.date(feed['Post']['created'], "MMMM d, yyyy") + '<br>' + 
                                    $.format.date(feed['Post']['created'], "HH:mm p") + ' EST<br>' + 
                                    '<a href="<?php echo $this->webroot; ?>messages/index/' + feed['User']['id'] + '" title="">Send a Message</a>' +                                                                                                             
                                '</div>' + 
                            '</div>' + 
                        '</li>';
            }
            else if(feed['Post']['is_request_outfit'] == 1){
                var profile_url = (feed['User']['profile_photo_url']) ? 'files/users/' + feed['User']['profile_photo_url'] : 'images/default-user.jpg';
                html = '<li class="activity-notification" data-post_id="' + feed['Post']['id'] + '">' + 
                            '<div class="activity-content-area">' + 
                                '<div class="activity-icn"></div>' +
                                '<div class="activity-user-img"><img src="<?php echo $this->webroot; ?>' + profile_url + '" alt=""/></div>' +  
                                '<div class="activity-msg-area">' + 
                                    '<div class="activity-user-name"><strong>' + feed['UserFrom']['first_name'].capitalize() + ' ' + feed['UserFrom']['last_name'].capitalize() + '</strong> requested an outfit.</div>' + 
                                    '<div class="activity-msg-dtl">' + 
                                        '<span class="activity-product-dtl">' + 
                                            '“'+ feed['Message']['body'] +'”' + 
                                        '</span>' + 
                                    '</div>' +                     
                                '</div>' + 
                                '<div class="activity-date-section">' + 
                                    $.format.date(feed['Post']['created'], "MMMM d, yyyy") + '<br>' + 
                                    $.format.date(feed['Post']['created'], "HH:mm p") + ' EST<br>' + 
                                    '<a href="<?php echo $this->webroot; ?>messages/index/' + feed['User']['id'] + '" title="">Send a Message</a>' +                                                                                                             
                                '</div>' + 
                            '</div>' + 
                        '</li>';
            }     
            else if(feed['Post']['is_message'] == 1){
                var profile_url = (feed['User']['profile_photo_url']) ? 'files/users/' + feed['User']['profile_photo_url'] : 'images/default-user.jpg';

                var activity_title = '';
                if(user_id == feed['UserFrom']['id']){
                    activity_title = '<strong>' + feed['UserFrom']['first_name'].capitalize() + ' ' + feed['UserFrom']['last_name'].capitalize() + '</strong> sent you a message.';
                }
                else{
                    activity_title = 'You sent a message to ' + '<strong>' + feed['UserTo']['first_name'].capitalize() + ' ' + feed['UserTo']['last_name'].capitalize() + '.';
                }

                html = '<li class="activity-msg" data-post_id="' + feed['Post']['id'] + '">' + 
                            '<div class="activity-content-area">' + 
                                '<div class="activity-icn"></div>' +
                                '<div class="activity-user-img"><img src="<?php echo $this->webroot; ?>' + profile_url + '" alt=""/></div>' +  
                                '<div class="activity-msg-area">' + 
                                    '<div class="activity-user-name">' + activity_title + '</div>' + 
                                    '<div class="activity-msg-dtl">' + 
                                        '<span class="activity-product-dtl">' + 
                                            '“'+ feed['Message']['body'] +'”' + 
                                        '</span>' + 
                                    '</div>' +                     
                                '</div>' + 
                                '<div class="activity-date-section">' + 
                                    $.format.date(feed['Post']['created'], "MMMM d, yyyy") + '<br>' + 
                                    $.format.date(feed['Post']['created'], "HH:mm p") + ' EST<br>' + 
                                    '<a href="<?php echo $this->webroot; ?>messages/index/' + feed['User']['id'] + '" title="">Send a Message</a>' +                                                                                                             
                                '</div>' + 
                            '</div>' + 
                        '</li>';
            }         
            else if(feed['Post']['is_outfit'] == 1){
                var profile_url = (feed['User']['profile_photo_url']) ? 'files/users/' + feed['User']['profile_photo_url'] : 'images/default-user.jpg';
                var outfit_name = (feed['Outfit']['outfit_name'] ) ? '<h1><a href="/messages/outfitdetails/' + feed['Outfit']['id'] + '" class="outfit-name">' + feed['Outfit']['outfit_name'].capitalize() + '</a></h1>' : ''; 
                var outfit_name_val = (feed['Outfit']['outfit_name'] ) ? feed['Outfit']['outfit_name'].toUpperCase() : ''; 
                var outfit_list = '';
                var userList = [],
                    outfitPrice = 0,
                    brandList = [];

                for(var i = 0; i < feed['OutfitItem'].length; i++){
                    if(typeof feed['OutfitItem'][i]['product']['Image'] != 'undefined' && feed['OutfitItem'][i]['product']['Image'].length){
                        outfit_list += '<li><img src="<?php echo $this->webroot; ?>files/products/' + feed['OutfitItem'][i]['product']['Image'][0]['name'] + '" alt="" /></li>';
                    }
                    if(feed['OutfitItem'][i]['product']['Brand']['name'])
                        brandList.push(feed['OutfitItem'][i]['product']['Brand']['name']);
                    outfitPrice += parseInt(feed['OutfitItem'][i]['product']['Entity']['price']);
                }

                for(var j = 0; j < feed['AllMessages'].length; j++){
                    userList.push(feed['AllMessages'][j]['UserTo']['first_name'].capitalize() + ' ' + feed['AllMessages'][j]['UserTo']['last_name'].capitalize());
                }

                brandList = brandList.unique();
                userList = userList.unique();
                brandList = brandList.join(',');
                userList = userList.join(',');


                html = '<li class="activity-outfit" data-post_id="' + feed['Post']['id'] + '">' + 
                            '<div class="activity-content-area">' +  
                                '<div class="activity-icn"></div>' +
                                '<div class="activity-user-img"><img src="<?php echo $this->webroot; ?>' + profile_url + '" alt=""/></div>' + 
                                '<div class="activity-msg-area">' + 
                                    '<div class="activity-user-name">You created <strong>' + feed['UserTo']['first_name'].capitalize() + ' ' + feed['UserTo']['last_name'].capitalize() + '</strong> an outfit, <strong>"' + feed['Outfit']['outfit_name'].capitalize() + '"</strong></div>' + 
                                '</div>' + 
                                '<div class="activity-date-section">' + 
                                    $.format.date(feed['Post']['created'], "MMMM d, yyyy") + '<br>' + 
                                    $.format.date(feed['Post']['created'], "HH:mm p") + ' EST<br>' + 
                                    '<a href="<?php echo $this->webroot; ?>messages/index/' + feed['User']['id'] + '" title="">Send a Message</a>' +                                                                                                             
                                '</div>' + 
                                '<div class="ten columns container">' + 
                                    '<div class="twelve columns left client-outfits-area">' + 
                                        outfit_name +
                                        '<input type="hidden" id="outfitidquickview" class="outfit-id" data-id="' + feed['Outfit']['id'] + '" value="' + feed['Outfit']['id'] + '">' + 
                                        '<div class="twelve columns client-outfits-img pad-none">' + 
                                            '<ul>' + 
                                                outfit_list +
                                                '<a href="#" class="outfit-quick-view"><span class="outfit-quick-view-icons"><img src="/images/search-icon.png" alt=""></span>Outfit Quick View</a>' +
                                            '</ul>' +
                                            '<input type="hidden" id="totalpriceoutfit" class="outfit-price" value="' + outfitPrice + '">' + 
                                            '<input type="hidden" class="outfit-brands" value="' + brandList + '">' + 
                                            '<input type="hidden" class="outfit-users" value="' + userList + '">' +  
                                        '</div>' + 
                                    '</div>' + 
                                '</div>' + 
                            '</div>' + 
                        '</li>';
            }       
            else if(feed['Post']['is_order']){
                html = '<li class="activity-purchase" data-post_id="' + feed['Post']['id'] + '">' + 
                            '<div class="activity-content-area">' + 
                                '<div class="activity-icn"></div>' +
                                '<div class="activity-user-img"><img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt=""/></div>' + 
                                '<div class="activity-msg-area">' + 
                                    '<div class="activity-user-name"><strong>Kyle Harper</strong> purchased an item.</div>' + 
                                    '<div class="activity-msg-dtl">' + 
                                        '<span class="activity-prdct-img"><img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt=""/></span>' + 
                                        '<span class="activity-product-dtl">' + 
                                            '<strong>Nice Loafers</strong><br>' + 
                                            'Prada<br>' + 
                                            '$650.00' + 
                                        '</span>' + 
                                    '</div>' + 
                                '</div>' + 
                                '<div class="activity-date-section">' + 
                                    $.format.date(feed['Post']['created'], "MMMM d, yyyy") + '<br>' + 
                                    $.format.date(feed['Post']['created'], "HH:mm p") + ' EST<br>' + 
                                    '<a href="<?php echo $this->webroot; ?>messages/index/' + feed['User']['id'] + '" title="">Send a Message</a>' +                                                                                                             
                                '</div>' + 
                            '</div>' + 
                        '</li>';
            }
            return html;
        }

        $('.activity-feed-section').on('click', '.outfit-quick-view', function(e){
            e.preventDefault();
            
            var clientOutfit = $(this).closest('.activity-outfit'),
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

        String.prototype.capitalize = function() {
            return this.charAt(0).toUpperCase() + this.slice(1);
        }

    });
</script>