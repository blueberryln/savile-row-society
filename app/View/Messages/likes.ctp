<script type="text/javascript">
$(document).ready(function(){
    $("#sortdate").change(function(){

        var valueSelected = this.value;
        //alert(valueSelected);
        $.ajax({
            type: "POST",
            url: "<?php echo $this->webroot; ?>messages/userLikesAsc/<?php echo $clientid; ?>",
            data: {valueSelected:valueSelected},
            cache: false,
            success: function(result){
            //alert(result);
            data = $.parseJSON(result);
            html = '';
            html = html + '<ul>';
            html = html + '<li><div class="purchase-dtls-date heading left">Date</div><div class="purchase-dtls-items heading left">Item</div><div class="purchase-dtls-price heading left">Price</div></li>';
            $.each(data,  function (index){
                html = html + '<li>';7
                html = html + '<div class="purchase-dtls-date left">'+this.Wishlist.created +'</div>';
                html = html + '<div class="purchase-dtls-items left">';
                html = html + '<div class="purchase-dtls-items-img"><img src="<?php echo $this->webroot; ?>files/products/'+ this.Image[0].name+'" alt=""  /></div>';
                html = html + '<div class="purchase-dtls-items-desc">'+this.Entity.name +'<span>'+ this.Brand.name +'</span></div>';
                html = html + '</div>';
                html = html + '<div class="purchase-dtls-price left">$'+ this.Entity.price +'</div>';
                html = html + '</li>';        
                
                });
            html = html + '</ul>';
                $("#ascsort").html(html);
            }
        });

    });




//pagination

    $(".userlikes a").on('click',function(){
        var totalProductCount = $('#limit').val();
        $.ajax({
            type: "POST",
            url: "<?php echo $this->webroot; ?>messages/userLikesAsc/<?php echo $clientid; ?>",
            data: {totalProductCount:totalProductCount},
            cache: false,
            success: function(result){
                var e = 10;
                $("#limit").val(parseInt(totalProductCount)+e);
                data = $.parseJSON(result);
            html = '';
            $.each(data,  function (index){
                html = html + '<li>';
                html = html + '<div class="purchase-dtls-date left">'+this.Wishlist.created +'</div>';
                html = html + '<div class="purchase-dtls-items left">';
                html = html + '<div class="purchase-dtls-items-img"><img src="<?php echo $this->webroot; ?>files/products/'+ this.Image[0].name+'" alt=""  /></div>';
                html = html + '<div class="purchase-dtls-items-desc">'+this.Entity.name +'<span>'+ this.Brand.name +'</span></div>';
                html = html + '</div>';
                html = html + '<div class="purchase-dtls-price left">$'+ this.Entity.price +'</div>';
                html = html + '</li>';        
                
                });
                $("#ascsort").append(html);
            
            }
        });

    });

});

</script>
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
                                
                            </ul>
                        </div>
                    </div>
                </div>
                
                
                <div class="myclient-right right">
                    <div class="twelve columns left inner-content pad-none">
                         <div class="twelve columns myclient-heading pad-none">
                            <h1><?php echo $client['User']['first_name'].'&nbsp;'.$client['User']['last_name']; ?> | <span>Likes Items</span></h1>
                            <div class="client-img-small"><img src="<?php echo $img; ?>" alt="" /></div>
                        </div>
                        <div class="inner-left inner-myclient left">
<!--                            <div class="dashboard-pannel left">&nbsp;</div>-->
                            <div class="left-pannel left">
                                <div class="client-img"><img src="<?php echo $img; ?>" alt=""/></div>
                                <div class=" twelve columns left left-nav">
                                    <ul>
                                        <li><a href="#<?php echo $this->webroot; ?>messages/stylistuseractivityfeed/<?php echo $clientid; ?>">Activity Feed</a></li>
                                        <li><a href="<?php echo $this->webroot; ?>messages/index/<?php echo $clientid; ?>">Messages</a></li>
                                        <li><a href="<?php echo $this->webroot; ?>messages/outfits/<?php echo $clientid; ?>">Outfits</a></li>
                                        <li class="active"><a href="<?php echo $this->webroot; ?>messages/purchase/<?php echo $clientid; ?>">Purchases/Likes</a></li>
                                        <li><a href="<?php echo $this->webroot; ?>messages/notes/<?php echo $clientid; ?>">Notes &amp; Gallery</a></li>
                                        <li><a href="<?php echo $this->webroot; ?>messages/measurements/<?php echo $clientid; ?>">Measurements</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="right-pannel right">
                                <div class="twelve columns message-area left pad-none">
                                    <div class="eleven columns container pad-none">
                                        <div class="short-by-date">
                                            <span class="short-by-date-arrow"><img src="<?php echo $this->webroot; ?>images/down-arrow.png" alt=""/></span>
                                            <select id="sortdate">
                                                <!-- <option >Sort by Date</option> -->
                                                <option value="DESC">Sort by Date DESC</option>
                                                <option value="ASC">Sort By Date ASC</option>
                                                
                                            </select>
                                        </div>
                                        <div class="tab-btns purchase "><a href="<?php echo $this->webroot; ?>messages/purchase/<?php echo $clientid; ?>" title="">Purchase</a></div>
                                        <div class="tab-btns likes active"><a href="<?php echo $this->webroot; ?>messages/likes/<?php echo $clientid; ?>" title="">Likes</a></div>
                                        <div class="twelve columns purchase-container left pad-none">
                                            <div class="eleven columns container purchase-area pad-none">
                                                <div class="twelve columns left purchase-dtls pad-none">
                                                   <ul id="ascsort">
                                                        <li>
                                                            <div class="purchase-dtls-date heading left">Date</div>
                                                            <div class="purchase-dtls-items heading left">Item</div>
                                                            <!-- <div class="purchase-dtls-outfit heading left">Outfit</div> -->
                                                            <div class="purchase-dtls-price heading left">Price</div>
                                                       </li>
                                                       <?php
                                                        if($likeitems):
                                                         for($i = 0; $i < count($likeitems); $i++){
                                                                $likeitem = $likeitems[$i];
                                                        ?>
                                                       <li>
                                                            <div class="purchase-dtls-date left"><?php
                                                                $php_timestamp = $likeitem['Wishlist']['created'];
                                                                $php_timestamp_date = date("d/M/Y", $php_timestamp);
                                                             echo $php_timestamp_date; ?></div>
                                                            <div class="purchase-dtls-items left">
                                                                <div class="purchase-dtls-items-img"><img src="<?php echo $this->webroot; ?>files/products/<?php echo $likeitem['Image'][0]['name']; ?>" alt=""/></div>
                                                                <div class="purchase-dtls-items-desc"><?php echo $likeitem['Entity']['name']; ?><span><?php echo $likeitem['Brand']['name']; ?></span></div>
                                                           </div>
                                                            
                                                            
                                                       
                                                            <div class="purchase-dtls-price left">$<?php echo $likeitem['Entity']['price']; ?></div>
                                                       </li>
                                                       <?php } ?>
                                                       <?php else: ?>
                                                        <h1>There are no items</h1>
                                                       <?php endif; ?>
                                                       
                                                    </ul>
                                                    <div class="pagination userlikes">
                                                    <?php if($likeitemscount): ?>
                                                    <input type="hidden" id="limit" value="<?php echo $likeitemscount; ?>">
                                                    <a href="#" id="<?php echo $likeitemscount; ?>">Load More</a>
                                                <?php endif;?>
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
                
                
                
            </div>
        </div>
    </div>
</div>