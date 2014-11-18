<script type="text/javascript">
    $(document).ready(function(){

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
                        var outfit_name = (this.outfit[0].Outfit.outfit_name) ? this.outfit[0].Outfit.outfit_name : '';
                        html = html + '<h1>'+ outfit_name +'</h1>';
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
         // alert(FirstPageCount);
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
                        var outfit_name = (this.outfit[0].Outfit.outfit_name) ? this.outfit[0].Outfit.outfit_name : '';
                        html = html + '<h1>'+ outfit_name +'</h1>';
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
                
                
                <?php echo $this->element('clientAside/userFilterBar'); ?>
                
                
                <div class="myclient-right right">
                    <div class="twelve columns left inner-content pad-none">

                            <?php echo $this->element('clientAside/userLinksLeft'); ?>

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