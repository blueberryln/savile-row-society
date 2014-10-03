<?php

$this->Html->script('/js/jquery-dateFormat.min.js', array('inline' => false));
?>
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
<div id="view-otft-popup" style="display: none">
    <div class="box-modal">
        <div class="box-modal-inside">
            <a href="#" title="" class="otft-close"></a>
            <div class="view-otft-content">
                <h1>Outfit Quickview</h1>
                <div class="three columns left">
                    <div class="twelve columns left">
                        <div class="view-otft-list">
                            <ul>
                                <li><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_1.jpg" alt="" /></li>
                                <li><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_2.jpg" alt="" /></li>
                                <li><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_3.jpg" alt="" /></li>
                                <li><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_4.jpg" alt="" /></li>
                                <li><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_5.jpg" alt="" /></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="eight columns right">
                    <div class="twelve columns left">
                        <div class="view-otft-dtl">
                            <div class="view-otft-dtl-top">
                                <p>Outfit Name: Beach Day</p>
                                <p>Total Cost: $1300.00</p>
                            </div>
                            <div class="otft-overview-box">
                                <span class="otft-overview-box-head">Overview</span>
                                <div class="otft-overview-box-recmnd">
                                    <p>Recommended To:</p>
                                    <ul>
                                        <li>Vincent Bourzelx</li>
                                        <li>Jacques Chirac</li>
                                    </ul>
                                </div>
                                <div class="otft-overview-box-brnds">
                                    <p>Brands:</p>
                                    <ul>
                                        <li>Lacoste</li>
                                        <li>Solld and Stripes</li>
                                        <li>Southern Proper</li>
                                        <li>Hudson Sutler</li>
                                        <li>Austen Heller</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="twelve columns left otft-overview-links ">
                                <a class="left" href="#" title="">Resuse Outfit</a>
                                <a class="right" href="#" title="">See Full Outfit Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div>
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
                
                
                <div class="mydesbrd-right right">
                    <div class="twelve columns left inner-content mydesbrd-inner pad-none">
                         
                        <div class="inner-left inner-myclient left">
                            <div class="left-pannel right">
                                <div class="twelve columns left mydesbrd-right-area">
                                    <div class="twelve columns left mydesbrd-acc">
                                        <div class="mydesbrd-heading">Account Analytics</div>
                                        <div class="mydesbrd-acc-content">
                                            <p><span>Clients:</span> <?php if($usercount): echo $usercount; else:  echo "No"; endif; ?> clients</p>
                                            <p><span>Month to Date Sales:</span> $1000</p>
                                            <p><span>Average Monthly Sales:</span> $1500</p>
                                            <a href="<?php echo $this->request->webroot; ?>messages/feed" title="">See More Details</a>
                                        </div>
                                    </div>
                                    <!-- <div class="twelve columns left mydesbrd-items">
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
                                    </div> -->
                                </div>
                            </div>
                            <div class="right-pannel left">
                                <div class="twelve columns message-area mydesbrd-msgara left pad-none">
                                    
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
                
                
                <!-- <div class="eleven columns container pad-none">
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
                </div> -->
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
            firstPostId = 0;
        
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
                url: "<?php echo $this->webroot; ?>feed/loadFeed/",
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
                        setInterval(loadNewFeed, reqNewMsgDelay);
                    }
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
                url: "<?php echo $this->webroot; ?>feed/loadNewFeed/",
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
                url: "<?php echo $this->webroot; ?>feed/loadOldFeed/",
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
                                '<div class="activity-user-img"><img src="<?php echo $this->webroot; ?>' + profile_url + '" alt=""/></div>' + 
                                '<div class="activity-msg-area">' + 
                                    '<div class="activity-user-name"><strong>' + feed['User']['full_name'] + '</strong> liked an item,</div>' + 
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
                                '<div class="activity-user-img"><img src="<?php echo $this->webroot; ?>' + profile_url + '" alt=""/></div>' +  
                                '<div class="activity-msg-area">' + 
                                    '<div class="activity-user-name"><strong>' + feed['User']['full_name'] + '</strong> requested an outfit.</div>' + 
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
                html = '<li class="activity-notification" data-post_id="' + feed['Post']['id'] + '">' + 
                            '<div class="activity-content-area">' + 
                                '<div class="activity-user-img"><img src="<?php echo $this->webroot; ?>' + profile_url + '" alt=""/></div>' +  
                                '<div class="activity-msg-area">' + 
                                    '<div class="activity-user-name"><strong>' + feed['User']['full_name'] + '</strong> sent you a message.</div>' + 
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
                var outfit_name = (feed['Outfit']['outfit_name'] ) ? '<h1>' + feed['Outfit']['outfit_name'] + '</h1>' : ''; 
                var outfit_list = '';

                for(var i = 0; i < feed['OutfitItem'].length; i++){
                    if(typeof feed['OutfitItem'][i]['product']['Image'] != 'undefined' && feed['OutfitItem'][i]['product']['Image'].length){
                        outfit_list += '<li><img src="<?php echo $this->webroot; ?>files/products/' + feed['OutfitItem'][i]['product']['Image'][0]['name'] + '" alt="" /></li>';
                    }
                }

                console.log(outfit_list);

                html = '<li class="activity-notification" data-post_id="' + feed['Post']['id'] + '">' + 
                            '<div class="activity-content-area">' +  
                                '<div class="activity-user-img"><img src="<?php echo $this->webroot; ?>' + profile_url + '" alt=""/></div>' + 
                                '<div class="activity-msg-area">' + 
                                    '<div class="activity-user-name"><strong>You created ' + feed['UserTo']['first_name'].capitalize() + ' ' + feed['UserTo']['last_name'].capitalize() + ' an outfit,</strong> “Beach Day”</div>' + 
                                '</div>' + 
                                '<div class="activity-date-section">' + 
                                    $.format.date(feed['Post']['created'], "MMMM d, yyyy") + '<br>' + 
                                    $.format.date(feed['Post']['created'], "HH:mm p") + ' EST<br>' +    
                                    '<a href="<?php echo $this->webroot; ?>messages/index/' + feed['User']['id'] + '" title="">Send a Message</a>' +                                                                                                             
                                '</div>' + 
                                '<div class="ten columns container">' + 
                                    '<div class="twelve columns left client-outfits-area">' + 
                                        outfit_name +
                                        '<div class="twelve columns client-outfits-img pad-none">' + 
                                            '<ul>' + 
                                                outfit_list +
                                                '<a href="#" class="outfit-quick-view"><span class="outfit-quick-view-icons"><img src="/images/search-icon.png" alt=""></span>Outfit Quick View</a>' +
                                            '</ul>' + 
                                        '</div>' + 
                                    '</div>' + 
                                '</div>' + 
                            '</div>' + 
                        '</li>';
            }       
            else if(feed['Post']['is_order']){
                html = '<li class="activity-purchase" data-post_id="' + feed['Post']['id'] + '">' + 
                            '<div class="activity-content-area">' + 
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

        String.prototype.capitalize = function() {
            return this.charAt(0).toUpperCase() + this.slice(1);
        }

    });
</script>