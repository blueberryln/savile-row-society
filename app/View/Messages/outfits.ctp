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


    //sort function

    $("#sortdate").change(function(){
                var sorting = this.value;
                var FirstPageCount = '<?php echo $my_conversation_count; ?>';
                //alert(sorting);
                //$("#limit").val(FirstPageCount);
                $.ajax({
                    type:"POST",
                    url:"<?php echo $this->webroot; ?>messages/stylistuseroutfitssorting/<?php echo $clientid; ?>",
                    data:{sorting:sorting},
                    cache: false,
                    success: function(result){
                        data = $.parseJSON(result);
                        html = '';
                    $.each(data, function(index){
                        var outfitData = this.outfit[0];
                        html = html + '<div class="twelve columns client-outfits left">';
                        html = html + '<div class="eleven columns container client-outfits-area pad-none">';
                        html = html + '<h1>'+ this.outfit[0].Outfit.outfit_name +'</h1>';
                        html = html + '<div class="twelve columns client-outfits-img pad-none">';
                        html = html + '<ul>';
                        var entitiesData = this.entities; 
                    $.each(entitiesData, function(index1){
                        html = html + '<li>';
                        html = html + '<img src="<?php echo $this->webroot; ?>files/products/'+ entitiesData[index1].Image[0].name +'" alt="" />';
                        html = html + '<div class="product-desc">';
                        html = html + '<span class="product-name">'+ entitiesData[index1].Entity.name +'</span>';
                        html = html + '<span class="product-brand">'+ entitiesData[index1].Brand.name +'</span>';
                        html = html + '<span class="product-price">$'+ entitiesData[index1].Entity.price +'</span>';
                        html = html + '<span class="product-dtls"><a href="<?php echo $this->webroot; ?>messages/outfitdetails/'+ outfitData.Outfit.id +'" title="">Details</a></span>';
                        html = html + '<span class="bottm-links outfit-page-item ">';
                        html = html + '<a class="add-to-cart"  data-product_id="'+ entitiesData[index1].Entity.id +'" href="" title="">Add to Cart +</a>';
                        html = html +'<input type="hidden" id="product_id" class="product-id" value="'+ entitiesData[index1].Entity.id +'">';
                        html = html +'<input type="hidden" id="outfit_id" class="outfit_id" value="'+ outfitData.Outfit.id +'">';
                        html = html + '<a id="'+ entitiesData[index1].Entity.id +'-'+ outfitData.Outfit.user_id +'" class="thumb-icon" href="#"/></a>';
                        html = html + '</span>';
                        html = html + '</div>';
                        html = html + '</li>';
                    });
                
                        html = html + '</ul>';
                        html = html + '</div>';
                        html = html + '<div class="twelve columns left client-outfit-bottom pad-none">';
                        html = html + '<div class="client-comments left">';
                        html = html + '<h2>Stylist Comment</h2>';
                        html = html + '<div class="client-comments-text left">'+ this.comments +'<a href="javascript:;" title="">Read More</a></div>';
                        html = html + '</div>';
                        html = html + '<div class="share-outfit right">Share Outfit</div>';
                        html = html + '</div>';
                        html = html + '</div>';
                        html = html + '</div>';
                        
                    });
                $("#ascsort").html(html);
                    }
                });
            $(".client-outfits-img li").hover(function(){
                    $(".product-desc").css("display","block");
                    },function(){
                    $(".product-desc").css("display","none");
            });    
           
        });
        
    //pagination

    $(document).on("click", "#useroutfit-pagination a",function(){
         var FirstPageCount = $("#limit").val();
         alert(FirstPageCount);
                //var sorting = this.value;
                $.ajax({
                    type:"POST",
                    url:"<?php echo $this->webroot; ?>messages/stylistuseroutfitssorting/<?php echo $clientid; ?>",
                    data:{FirstPageCount:FirstPageCount},
                    cache: false,
                    success: function(result){
                        var e = 5;
                        $("#limit").val(parseInt(FirstPageCount)+e);
                        data = $.parseJSON(result);
                        html = '';
                    $.each(data, function(index){
                        var outfitData = this.outfit[0];
                        html = html + '<div class="twelve columns client-outfits left">';
                        html = html + '<div class="eleven columns container client-outfits-area pad-none">';
                        var outfit_name = this.outfit[0].Outfit.outfit_name
                        html = html + '<h1>'+ this.outfit[0].Outfit.outfit_name +'</h1>';
                        html = html + '<div class="twelve columns client-outfits-img pad-none">';
                        html = html + '<ul>';
                        var entitiesData = this.entities; 
                    $.each(entitiesData, function(index1){
                        html = html + '<li>';
                        html = html + '<img src="<?php echo $this->webroot; ?>files/products/'+ entitiesData[index1].Image[0].name +'" alt="" />';
                        html = html + '<div class="product-desc">';
                        html = html + '<span class="product-name">'+ entitiesData[index1].Entity.name +'</span>';
                        html = html + '<span class="product-brand">'+ entitiesData[index1].Brand.name +'</span>';
                        html = html + '<span class="product-price">$'+ entitiesData[index1].Entity.price +'</span>';
                        html = html + '<span class="product-dtls"><a href="<?php echo $this->webroot; ?>messages/outfitdetails/'+ outfitData.Outfit.id +'" title="">Details</a></span>';
                        html = html + '<span class="bottm-links outfit-page-item ">';
                        html = html + '<a class="add-to-cart"  data-product_id="'+ entitiesData[index1].Entity.id +'" href="" title="">Add to Cart +</a>';
                        html = html +'<input type="hidden" id="product_id" class="product-id" value="'+ entitiesData[index1].Entity.id +'">';
                        html = html +'<input type="hidden" id="outfit_id" class="outfit_id" value="'+ outfitData.Outfit.id +'">';
                        html = html + '<a id="'+ entitiesData[index1].Entity.id +'-'+ outfitData.Outfit.user_id +'" class="thumb-icon" href="#"/></a>';
                        html = html + '</span>';
                        html = html + '</div>';
                        html = html + '</li>';
                    });
                
                        html = html + '</ul>';
                        html = html + '</div>';
                        html = html + '<div class="twelve columns left client-outfit-bottom pad-none">';
                        html = html + '<div class="client-comments left">';
                        html = html + '<h2>Stylist Comment</h2>';
                        html = html + '<div class="client-comments-text left">'+ this.comments +'<a href="javascript:;" title="">Read More</a></div>';
                        html = html + '</div>';
                        html = html + '<div class="share-outfit right">Share Outfit</div>';
                        html = html + '</div>';
                        html = html + '</div>';
                        html = html + '</div>';
                        
                    });
                $("#ascsort").append(html);
                    }
                });
            // $(".client-outfits-img li").hover(function(){
            //         $(".product-desc").css("display","block");
            //         },function(){
            //         $(".product-desc").css("display","none");
            // });    
           
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
                        <div class="myclient-flt-srch-area">
                        <div class="filter-myclient-area">
                            <div class="filter-myclient">
                                <span class="downarw"></span>
                                <select onchange="location = this.options[this.selectedIndex].value;">
                                    <option>Filter Clients</option>
                                    <?php  foreach($userlists as $userlist ): ?>
                                    <option value="<?php echo $this->webroot; ?>messages/index/<?php echo $userlist['User']['id']; ?>"><?php echo $userlist['User']['first_name'].'&nbsp;'.$userlist['User']['last_name']; ?></option>
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
                                <div class="client-img"><img src="<?php echo $this->webroot; ?>files/users/<?php echo $client['User']['profile_photo_url']; ?>" alt="" /></div>
                                <div class=" twelve columns left left-nav">
                                    <ul>
                                        <li><a href="<?php echo $this->webroot; ?>messages/userfeed/<?php echo $clientid; ?>">Activity Feed</a></li>
                                        <li><a href="<?php echo $this->webroot; ?>messages/index/<?php echo $clientid; ?>">Messages</a></li>
                                        <li class="active"><a href="<?php echo $this->webroot; ?>messages/outfits/<?php echo $clientid; ?>">Outfits</a></li>
                                        <li><a href="<?php echo $this->webroot; ?>messages/purchase/<?php echo $clientid; ?>">Purchases/Likes</a></li>
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
                                            <option value="">Sort By Date</option>
                                                <option value="DESC">Sort By Date DESC</option>
                                                <option value="ASC">Sort By Date ASC</option>
                                            </select>
                                        </div>
                                        <div id="ascsort">
                                        <?php foreach ($my_outfits as $my_outfit): //print_r($my_outfit); ?>
                                        <div class="twelve columns client-outfits left">
                                            <div class="eleven columns container client-outfits-area pad-none">
                                                <h1><?php echo $my_outfit['outfit'][0]['Outfit']['outfit_name']; ?></h1>
                                                <div class="twelve columns client-outfits-img pad-none">
                                                    <ul>
                                                    <?php foreach ($my_outfit['entities'] as $key => $value) { ?>
                                                       
                                                        <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit['entities'][$key]['Image'][0]['name']; ?>" alt="" /></li>
                                                        <?php } ?>
                                                        
                                                    </ul>
                                                    <div class="outfit-quick-view"><span class="outfit-quick-view-icons"><img src="<?php echo $this->webroot; ?>images/search-icon.png" alt="" /></span>Outfit Quick View</div>
                                                </div>
                                                <div class="twelve columns left client-outfit-bottom pad-none">
                                                    <div class="client-comments left">
                                                        <h2>Stylist Comment</h2>
                                                        <div class="client-comments-text left"> <?php echo $my_outfit['comments']; ?> <a class="client-comments-text-rm" href="javascript:;" title="">Read More</a></div>
                                                    </div>
                                                    
                                                    <div class="share-outfit right">Share Outfit</div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                        </div>
                                        
                                    </div>
                                     <?php if($my_conversation_count): ?>
                                    <div class="pagination useroutfit-pagination" id="useroutfit-pagination">
                                    <input type="hidden" id="limit" value="<?php echo $my_conversation_count; ?>">
                                    <a href="#" id="<?php echo $my_conversation_count; ?>">Load More</a>
                                    </div> 
                                <?php endif; ?>
                                </div>

                            </div>
                        
                        </div>
                    </div>
                
                </div>
                
                
                
            </div>
        </div>
    </div>
</div>