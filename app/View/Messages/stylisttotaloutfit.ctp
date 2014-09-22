<script type="text/javascript">
    $(document).ready(function(){


    $(".search-myclient").on('keydown',function(){
         
         //var r = $('input').focus();
         var usersearch = $("#usersearch").val();
         //alert(usersearch);
          $.ajax({
                type:"POST",
                url:"<?php echo $this->webroot; ?>messages/stylistFilterList/<?php echo $user_id; ?>",
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
                        <li><a href="#" title=""><img class="cart-icons" src="<?php echo $this->webroot; ?>images/cart-icon.png" alt="" />(<span class="no-of-items">0</span>) </a></li>
                        <li>
                            <a href="#" title=""><span class="client-nav-switcher"><img src="<?php echo $this->webroot; ?>images/menu-dropdown-icon.png" alt="" /></span></a>
                            <div class="admin-top-right-dropdown">
                                <ul>
                                    <li><a href="#" title="">view my cart/checkout</a></li>
                                    <li><a href="#" title="">refer a friend</a></li>
                                    <li><a href="#" title="">sign out</a></li>
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
                                <select onchange="location = this.options[this.selectedIndex].value;">
                                    <option>Filter Clients</option>
                                    <?php  foreach($userlist as $filterclient ): ?>
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
                        <div class="myclient-list">
                            <ul id="searchuserlist">
                            <?php  foreach($userlist as $userlist){?>
                                <li>
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
                            <?php } ?>
                                
                            </ul>
                        </div>
                    </div>
                </div>
                
                
                <div class="myoutfit-right right">
                    <div class="twelve columns left inner-content my-outfit pad-none">
                        <div class="inner-left inner-myclient left">
<!--                            <div class="dashboard-pannel left">&nbsp;</div>-->
                            <div class="left-pannel left">
                                <a id="crt-new-otft" href="#" class="crt-new-outfit">Create New Outfit</a>
                                <!--popup -->
                                <div id="create-otft-popup" style="display: none">
                                    <div class="box-modal">
                                        <div class="box-modal-inside">
                                            <a href="#" title="" class="otft-close"></a>
                                            <div class="crt-new-otft-content">
                                                <div class="five columns left otft-pop-lft">
                                                    <div class="myclient-popup left">
                                                        <div class="myclient-topsec"> 
                                                            <div class="filter-myclient-area">
                                                                <div class="filter-myclient">
                                                                    <span class="downarw"></span>
                                                                    <select  name="data[Outfit][user_id]">
                                                                    <option>Filter Clients</option>
                                                                    <?php  foreach($userlist as $filterclientforoutfit ): ?>
                                                                    <option value="<?php echo $this->webroot; ?>messages/index/<?php echo $filterclientforoutfit['User']['id']; ?>"><?php echo $filterclientforoutfit['User']['first_name'].'&nbsp;'.$filterclientforoutfit['User']['last_name']; ?></option>
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
                                                            <div class="myclient-list">
                                                            <ul id="searchuserlist">
                                                            <?php 
                                                            //$userlist = $searchforoutfit;
                                                             foreach($userlist as $usersearchforoutfit):?>
                                                                <li>
                                                                    <a href="<?php echo $this->webroot; ?>messages/index/<?php echo $usersearchforoutfit['User']['id']; ?>" title="">
                                                                        <div class="myclient-img">
                                                                            <img src="<?php echo $this->webroot; ?>files/users/<?php echo $usersearchforoutfit['User']['profile_photo_url']; ?>" alt=""/>
                                                                        </div>
                                                                        <div class="myclient-dtl">
                                                                            <span class="myclient-name"><?php echo $usersearchforoutfit['User']['first_name'].'&nbsp;'.$usersearchforoutfit['User']['last_name']; ?></span>
                                                                            <span class="myclient-status">last active at <?php echo date ('d F Y',$usersearchforoutfit['User']['updated']); ?></span>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                            <?php endforeach; ?>
                                                                
                                                            </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="five columns right otft-pop-rgt">
                                                    <div class="eleven columns container">
                                                        <div class="twelve columns left otft-pop-rgt-area">
                                                            <div class="otft-pop-rgt-top">
                                                                <h1>Create A new Outfit</h1>
                                                                <p>Please select a client from your client list on the left.</p>
                                                                <a class="popup-cont-btn setp-btn" href="#" title="">Continue</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--popup-->
                                <div class="my-outfit-filters">
                                    <div class="outfit-fltr">
                                        <p>Outfit Filter</p>
                                        <ul>
                                            <li><a href="#" title="">All Outfits</a></li>
                                            <li><a href="#" title="">Bookmarked Outfits</a></li>
                                        </ul>
                                    </div>
                                    <div class="outfit-srt">
                                        <p>Sort By</p>
                                        <ul>
                                            <li><a href="#" title="">Name A-Z</a></li>
                                            <li><a href="#" title="">Date</a></li>
                                        </ul>
                                    </div>
                                    <div class="myoutfit-srch">
                                        <span></span>
                                        <input type="text" name="" placeholder="Search Outfits" />
                                    </div>
                                </div>
                                
                                
                            </div>
                            <div class="right-pannel right">
                                <div class="twelve columns message-area left pad-none">
                                    <div class="eleven columns container pad-none">
                                       <?php foreach ($my_outfitss as  $entity_list) : ?>  
                                        
                                        <div class="twelve columns client-outfits left">
                                            <div class="eleven columns container client-outfits-area pad-none">
                                                <h1><?php echo $entity_list['outfit']['Outfit']['outfitname']; ?></h1>
                                                <div class="twelve columns client-outfits-img pad-none">
                                                   
                                                    <ul>
                                                    <?php foreach ($entity_list['entities'] as $key => $value) : ?>
                                                       
                                                        <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $value['Image'][0]['name']; ?>" alt="" /></li>

                                                    <?php endforeach; ?>
                                                    </ul>

                                                    <div class="outfit-quick-view"><a href="<?php echo $this->webroot; ?>messages/stylistoutfitsdetails/<?php  echo $entity_list['outfit']['Outfit']['id'];  ?>"><span class="outfit-quick-view-icons"><img src="<?php echo $this->webroot; ?>images/search-icon.png" alt="" /></span>Outfit Quick View</a></div>
                                                </div>
                                                <div class="twelve columns left client-outfit-bottom pad-none">
                                                    <div class="client-comments left">
                                                        <h2>Stylist Comment</h2>
                                                        <div class="client-comments-text left"><?php if($entity_list['comments'][0]['Message']['body']!=''){ echo $entity_list['comments'][0]['Message']['body'];}else{} ?><!-- <a href="javascript:;" title="">Read More</a> --></div>
                                                    </div>
                                                    <div class="bkmrk-outfit right">Bookmark Outfit</div>
                                                    <div class="share-outfit right">Share Outfit</div>
                                                </div>
                                            </div>
                                        </div>

                                        

                                     <?php endforeach; ?>
                                        
                                        <div class="pagination stylisttotaloutfit">
                    <?php
                    //echo $this->Paginator->prev('>', array(), null, array('class' => 'prev disabled'));
                    //echo $this->Paginator->numbers(array('separator' => '', 'class' => 'page-links'));
                    //echo $this->Paginator->next('>', array(), null, array('class' => 'next disabled'));
                    ?>
                </div>
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
                </div -->
            </div>
        </div>
    </div>
</div>