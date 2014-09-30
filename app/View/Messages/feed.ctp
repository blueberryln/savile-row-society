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

    $(document).ready(function(){
        var isFirstLoad = true,
            feedContainer = $('.activity-feed-section>ul'),
            callInAction = false,
            reqNewMsgDelay=6000,
            firstMsgId = 0;
        
        loadFeed();
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
                                var html = showFeed(arrPost[i]);
                                feedContainer.append(html);
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

        function showFeed(feed) {
            console.log(feed);
            var html = ''; 
            if(feed['Post']['is_like'] == 1){
                var profile_url = (feed['User']['profile_photo_url']) ? 'files/users/' + feed['User']['profile_photo_url'] : 'images/default-user.jpg';
                var prodcut_url = '';
                html =  '<li class="activity-wishlist">' + 
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
                                    dateFormat(feed['Post']['created'], "mmmm d,yyyy") + '<br>' + 
                                    dateFormat(feed['Post']['created'], "HH:MM TT") + ' EST<br>' + 
                                    '<a href="<?php echo $this->webroot; ?>messages/index/' + feed['User']['id'] + '" title="">Send a Message</a>' +                                                                                                             
                                '</div>' + 
                            '</div>' + 
                        '</li>';
            }
            else if(feed['Post']['is_request_outfit'] == 1){
                var profile_url = (feed['User']['profile_photo_url']) ? 'files/users/' + feed['User']['profile_photo_url'] : 'images/default-user.jpg';
                html = '<li class="activity-notification">' + 
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
                                    dateFormat(feed['Post']['created'], "mmmm d,yyyy") + '<br>' + 
                                    dateFormat(feed['Post']['created'], "HH:MM TT") + ' EST<br>' + 
                                    '<a href="<?php echo $this->webroot; ?>messages/index/' + feed['User']['id'] + '" title="">Send a Message</a>' +                                                                                                             
                                '</div>' + 
                            '</div>' + 
                        '</li>';
            }     
            else if(feed['Post']['is_message'] == 1){
                var profile_url = (feed['User']['profile_photo_url']) ? 'files/users/' + feed['User']['profile_photo_url'] : 'images/default-user.jpg';
                html = '<li class="activity-notification">' + 
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
                                    dateFormat(feed['Post']['created'], "mmmm d,yyyy") + '<br>' + 
                                    dateFormat(feed['Post']['created'], "HH:MM TT") + ' EST<br>' + 
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

                html = '<li class="activity-notification">' + 
                            '<div class="activity-content-area">' +  
                                '<div class="activity-user-img"><img src="<?php echo $this->webroot; ?>' + profile_url + '" alt=""/></div>' + 
                                '<div class="activity-msg-area">' + 
                                    '<div class="activity-user-name"><strong>You created ' + feed['UserTo']['first_name'].capitalize() + ' ' + feed['UserTo']['last_name'].capitalize() + ' an outfit,</strong> “Beach Day”</div>' + 
                                '</div>' + 
                                '<div class="activity-date-section">' + 
                                    dateFormat(feed['Post']['created'], "mmmm d,yyyy") + '<br>' + 
                                    dateFormat(feed['Post']['created'], "HH:MM TT") + ' EST<br>' + 
                                    '<a href="<?php echo $this->webroot; ?>messages/index/' + feed['User']['id'] + '" title="">Send a Message</a>' +                                                                                                             
                                '</div>' + 
                                '<div class="ten columns container">' + 
                                    '<div class="twelve columns left client-outfits-area">' + 
                                        outfit_name +
                                        '<div class="twelve columns client-outfits-img pad-none">' + 
                                            '<ul>' + 
                                                outfit_list +
                                            '</ul>' + 
                                        '</div>' + 
                                    '</div>' + 
                                '</div>' + 
                            '</div>' + 
                        '</li>';
            }       
            else if(feed['Post']['is_order']){
                html = '<li class="activity-purchase">' + 
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
                                    dateFormat(feed['Post']['created'], "mmmm d,yyyy") + '<br>' + 
                                    dateFormat(feed['Post']['created'], "HH:MM TT") + ' EST<br>' + 
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