<script type="text/javascript">
    $(document).ready(function(){


    $(".search-myclient").on('keydown',function(){
         
         //var r = $('input').focus();
         var usersearch = $("#usersearch").val();
         //alert(usersearch);
          $.ajax({
                type:"POST",
                url:"<?php echo $this->webroot; ?>messages/stylistUserFilterList/<?php echo $clientid; ?>",
                data:{usersearch:usersearch},
                cache: false,
                    success: function(result){
                        data = $.parseJSON(result);

            html = '';
            html = html + '<ul>';
            
            $.each(data,  function (index){
                html = html + '<li>';
                html = html + '<a href="<?php echo $this->webroot; ?>messages/index/'+ this.User.id +'" title="">';
                html = html + '<div class="myclient-img">';
                html = html + '<img src="<?php echo $this->webroot; ?>files/users/'+ this.User.profile_photo_url +'" alt=""/>';
                html = html + '</div>';
                html = html + '<div class="myclient-dtl">';
                html = html + '<span class="myclient-name">'+ this.User.first_name +'&nbsp;'+ this.User.last_name +'</span>';
                html = html + '<span class="myclient-status">last active at '+ this.User.updated +'</span>';
                html = html + '</div>';
                html = html + '</a>';
                html = html + '</li>';      
                
                });
            html = html + '</ul>';
                $("#searchuserlist").html(html);

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
<div class="content-container">
    <div class="twelve columns black">
        <div class="eleven columns container">
            <div class="twelve columns container left ">
                <div class="ten columns left admin-nav">
                    <ul>
                        <li class="active"><a href="#" title="">My Clients</a></li>
                        <li><a href="#" title="">Dashboard</a></li>
                        <li><a href="#" title="">My outfits</a></li>
                        <li><a href="#" title="">The CLoset</a></li>
                    </ul>
                </div>
                <div class="two columns right admin-top-right">
                    <ul>
                    <li><a href="<?php echo $this->request->webroot; ?>cart"><img class="cart-icons" src="<?php echo $this->webroot; ?>images/cart-icon.png" alt="" /> (<span class="cart-items-count"><?php echo $cart_items; ?></span>)</a></li>
                        <!-- <li><a href="#" title=""><img class="cart-icons" src="<?php echo $this->webroot; ?>images/cart-icon.png" alt="" />(<span class="no-of-items">0</span>) </a></li> -->
                        <li>
                            <a href="#" title=""><span class="client-nav-switcher"><img src="<?php echo $this->webroot; ?>images/menu-dropdown-icon.png" alt="" /></span></a>
                            <div class="admin-top-right-dropdown">
                                <ul>
                                    <li><a href="#" title="">view my cart/checkout</a></li>
                                    <li><a href="#" title="">refer a friend</a></li>
                                    <li><a href="<?php echo $this->request->webroot; ?>signout" title="">sign out</a></li>
                                </ul>
                            </div>
                        </li>

                    </ul>    
                </div>
            </div>
        </div>
        
    </div>
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
                                <input type="text" name="myclient-search" id="usersearch" />
                            </div>
                        </div>
                        <div class="myclient-list">
                            <ul id="searchuserlist">
                            <?php  foreach($userlists as $userlist ): ?>
                                <li <?php if($userlist['User']['id']==$clientid){ echo "class='active'"; } ?>>
                                    <a href="<?php echo $this->webroot; ?>messages/index/<?php echo $userlist['User']['id']; ?>" title="">
                                        <div class="myclient-img">
                                            <img src="<?php echo $this->webroot; ?>files/users/<?php echo $userlist['User']['profile_photo_url']; ?>" alt=""/>
                                        </div>
                                        <div class="myclient-dtl">
                                            <span class="myclient-name"><?php echo $userlist['User']['first_name'].'&nbsp;'.$userlist['User']['last_name']; ?></span>
                                            <span class="myclient-status">last active at <?php echo date ('d F Y',$userlist['User']['updated']); ?></span>
                                        </div>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                                <!-- <li class="active">
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
                                </li> -->
                            </ul>
                        </div>
                    </div>
                    <div class="myclient-btmsec"> &nbsp;  </div>
                </div>
                
                
                <div class="myclient-right right">
                    <div class="twelve columns left inner-content pad-none">
                         <div class="twelve columns myclient-heading pad-none">
                            <h1><?php echo $client['User']['first_name'].'&nbsp;'.$client['User']['last_name']; ?> | <span>Outfits</span></h1>
                            <div class="client-img-small"><img src="<?php echo $this->webroot; ?>files/users/<?php echo $client['User']['profile_photo_url']; ?>" alt="" /></div>
                        </div>
                        <div class="inner-left inner-myclient left">
<!--                            <div class="dashboard-pannel left">&nbsp;</div>-->
                            <div class="left-pannel left">
                                <div class="client-img"><img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt=""/></div>
                                <div class=" twelve columns left left-nav">
                                    <ul>
                                        <li><a href="<?php echo $this->webroot; ?>messages/stylistuseractivityfeed/<?php echo $clientid; ?>">Activity Feed</a></li>
                                        <li><a href="<?php echo $this->webroot; ?>messages/index/<?php echo $clientid; ?>">Messages</a></li>
                                        <li class="active"><a href="<?php echo $this->webroot; ?>messages/stylistuseroutfits/<?php echo $clientid; ?>">Outfits</a></li>
                                        <li><a href="javascript:;">Purchases/Likes</a></li>
                                        <li><a href="javascript:;">Notes &amp; Gallery</a></li>
                                        <li><a href="javascript:;">Measurements</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="right-pannel right">
                                <div class="twelve columns message-area left pad-none">
                                    <div class="eleven columns container pad-none">
                                        <div class="short-by-date">
                                            <span class="short-by-date-arrow"><img src="<?php echo $this->webroot; ?>images/down-arrow.png" alt=""/></span>
                                            <select id="sortdate">
                                            <option value="">Sort By Date</option>
                                                <option value="DESC">Sort By Date DESC</option>
                                                <option value="ASC">Sort By Date ASC</option>
                                            </select>
                                        </div>
                                        <?php foreach ($my_outfits as $my_outfit): ?>
                                        <div class="twelve columns client-outfits left">
                                            <div class="eleven columns container client-outfits-area pad-none">
                                                <h1><?php echo $my_outfit['outfit'][0]['Outfit']['outfitname']; ?></h1>
                                                <div class="twelve columns client-outfits-img pad-none">
                                                    <ul>
                                                    <?php foreach ($my_outfit['entities'] as $key => $value) { ?>
                                                       
                                                        <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit['entities'][$key]['Image'][0]['name']; ?>" alt="" /></li>
                                                        <?php } ?>
                                                        <!-- <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit['entities'][$key]['Image'][0]['name']; ?>" alt="" /></li>
                                                        <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit['entities'][$key]['Image'][0]['name']; ?>" alt="" /></li>
                                                        <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit['entities'][$key]['Image'][0]['name']; ?>" alt="" /></li>
                                                        <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit['entities'][$key]['Image'][0]['name']; ?>" alt="" /></li> -->
                                                    </ul>
                                                    <div class="outfit-quick-view"><span class="outfit-quick-view-icons"><img src="<?php echo $this->webroot; ?>images/search-icon.png" alt="" /></span>Outfit Quick View</div>
                                                </div>
                                                <div class="twelve columns left client-outfit-bottom pad-none">
                                                    <div class="client-comments left">
                                                        <h2>Stylist Comment</h2>
                                                        <div class="client-comments-text left">Kyle-  <?php echo $my_outfit['comments']; ?> <a href="javascript:;" title="">Read More</a></div>
                                                    </div>
                                                    
                                                    <div class="share-outfit right">Share Outfit</div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>

                                        <!-- <div class="twelve columns client-outfits left">
                                            <div class="eleven columns container client-outfits-area pad-none">
                                                <h1>BEACH DAY</h1>
                                                <div class="twelve columns client-outfits-img pad-none">
                                                    <ul>
                                                        <li><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_1.jpg" alt="" /></li>
                                                        <li><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_2.jpg" alt="" /></li>
                                                        <li><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_3.jpg" alt="" /></li>
                                                        <li><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_4.jpg" alt="" /></li>
                                                        <li><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_5.jpg" alt="" /></li>
                                                    </ul>
                                                    <div class="outfit-quick-view"><span class="outfit-quick-view-icons"><img src="<?php echo $this->webroot; ?>images/search-icon.png" alt="" /></span>Outfit Quick View</div>
                                                </div>
                                                <div class="twelve columns left client-outfit-bottom pad-none">
                                                    <div class="client-comments left">
                                                        <h2>Stylist Comment</h2>
                                                        <div class="client-comments-text left">Kyle- Your upcoming trip to Hawaii<br>would be a great chance to wear.... <a href="javascript:;" title="">Read More</a></div>
                                                    </div>
                                                    <div class="share-outfit right">Share Outfit</div>
                                                </div>
                                            </div>
                                        </div>  -->
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