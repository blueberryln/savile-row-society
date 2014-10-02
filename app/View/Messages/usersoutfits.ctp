<?php
if($user_id){   
?>
<script type="text/javascript">
 $(document).ready(function(){
    $(document).on("click", ".thumb-icon", function(e) {
        e.preventDefault();
        $this = $(this);
        var productBlock = $this.closest(".bottm-links");
        var productId = productBlock.find("#product_id").val();
        var outfit_id = productBlock.find("#outfit_id").val();
            $.ajax({
                type:"POST",
                url : "<?php echo $this->request->webroot; ?>api/wishlist/save",
                data:{product_id: productId,outfit_id:outfit_id},
                cache: false,
                success: function(result){
                    $this.addClass('like');
                $this.closest(".bottm-links").find(".thumbs-icon").addClass('like');
                //$this.closest(".bottm-links").find(".thumbs-icon").replaceWith(".thumbs-icon-like");

               }
            });
                       
        
    });

//remove like
    $(document).on("click", ".like", function(e) {
        e.preventDefault();
        $this = $(this);
        var productBlock = $this.closest(".bottm-links");
        var productId = productBlock.find("#product_id").val();
        var outfit_id = productBlock.find("#outfit_id").val();
        //if(!$this.hasClass(".thumbs-icon-like")){
            $.ajax({
                type:"POST",
                url : "<?php echo $this->request->webroot; ?>api/wishlist/remove",
                data:{product_id: productId,outfit_id:outfit_id},
                cache: false,
                success: function(result){
                    $this.removeClass('like');
                $this.closest(".bottm-links").find(".like").removeClass( "like" );
                //$this.closest(".bottm-links").find(".thumbs-icon").replaceWith(".thumbs-icon-like");

               }
            });
        
    });

        $("#sortdate").change(function(){
                var sorting = this.value;
                var FirstPageCount = '<?php echo $my_conversation_count; ?>';
                //alert(FirstPageCount);
                $("#limit").val(FirstPageCount);
                $.ajax({
                    type:"POST",
                    url:"<?php echo $this->webroot; ?>messages/usersoutfitssorting/<?php echo $user_id; ?>",
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




    // user outfit pagination

    $(document).on("click", "#useroutfit-pagination a",function(){
         var FirstPageCount = $("#limit").val();
         //alert(FirstPageCount);
                //var sorting = this.value;
                $.ajax({
                    type:"POST",
                    url:"<?php echo $this->webroot; ?>messages/usersoutfitssorting/<?php echo $user_id; ?>",
                    data:{FirstPageCount:FirstPageCount},
                    cache: false,
                    success: function(result){
                        var e = 2;
                        $("#limit").val(parseInt(FirstPageCount)+e);
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
}
$this->Html->script("mosaic.1.0.1.min.js", array('inline' => false));
$this->Html->meta('description', 'First mover', array('inline' => false));
?>
<?php
$script = '
$(document).ready(function(){  
    
    $(document).on("click",".add-to-cart", function(e) {
        e.preventDefault();
        var productBlock = $(this).closest(".outfit-page-item"),
            productQuantity = productBlock.find("select.product-quantity").val(),
            productSize = productBlock.find(".product-size").val();
            var id = productBlock.find(".product-id").val();
            var outfitid = productBlock.find(".outfit_id").val();
            var quantity = parseInt(productQuantity) + 1;
            var size = productSize;
            
        
        $.post("' . $this->request->webroot . 'api/cart/save", { product_id: id, product_quantity: 1, product_size: 23, outfit_id: outfitid },
            function(data) {
                var ret = $.parseJSON(data);
                if(ret["status"] == "ok"){
                    $(".cart-items-count").html(ret["count"]);
                    location.reload();
                }
                else if(ret["status"] == "login"){
                    signUp();       
                }
            }
        
        );
    });
    
    
});
';
$this->Html->script("jquery.colorbox-min.js", array('inline' => false));
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->css('colorbox', null, array('inline' => false));
?>
<?php
    $img = "";
        if(isset($Userdata) && $Userdata[0]['User']['profile_photo_url'] && $Userdata[0]['User']['profile_photo_url'] != ""){
            $img = $this->webroot . "files/users/" . $Userdata[0]['User']['profile_photo_url'];
         }else{
            $img = $this->webroot . "img/dummy_image.jpg";    
        }
?>
   <div class="twelve columns container">
        <div class="eleven columns container message-box-area">
            <div class="twelve columns container left message-box">
                <div class="eleven columns container pad-none">
                        <?php echo $this->element('userAside/leftSidebar'); ?>

                            <div class="right-pannel right">
                                <div class="twelve columns message-area useroutfit_area left pad-none">
                                    <div class="eleven columns container pad-none">
                                        <div class="short-by-date">
                                            <span class="short-by-date-arrow"><img src="<?php echo $this->webroot; ?>images/down-arrow.png" alt=""/></span>
                                            <select id="sortdate">
                                            <option value="">Sort By Date</option>
                                                <option value="desc">Sort By Date DESC</option>
                                                <option value="asc">Sort By Date ASC</option>
                                            </select>
                                        </div>
                                        <div id="ascsort">

                                        <?php
                                            if(count($my_outfits)):
                                            foreach ($my_outfits as $my_outfit):
                                        ?>
                                            
                                        <div class="twelve columns client-outfits left" >

                                            <div class="eleven columns container client-outfits-area pad-none" >
                                                <h1><?php echo $my_outfit['outfit'][0]['Outfit']['outfit_name']; ?></h1>
                                                <div class="twelve columns client-outfits-img pad-none">
                                                <ul>
                                                <?php $entit = $my_outfit['entities']; ?>
                                                <?php foreach($entit as $enti){ ?>

                                                
                                                    <li>
                                                        <img src="<?php echo $this->webroot; ?>files/products/<?php echo $enti['Image'][0]['name']; ?>" alt="" />
                                                        <div class="product-desc">
                                                                <span class="product-name"><?php echo $enti['Entity']['name']; ?></span>
                                                                <span class="product-brand"><?php echo $enti['Brand']['name']; ?></span>
                                                                <span class="product-price">$<?php echo $enti['Entity']['price']; ?></span>
                                                                <span class="product-dtls"><a href="<?php echo $this->webroot; ?>messages/outfitdetails/<?php echo $my_outfit['outfit'][0]['Outfit']['id']; ?>" title="">Details</a></span>
                                                                <span class="bottm-links outfit-page-item">
                                                                    <a class="add-to-cart" data-product_id="<?php echo $enti['Entity']['id']; ?>" href="" title="">Add to Cart +</a>
                                                                    
                                                                    <input type="hidden" id="product_id" class="product-id" value="<?php echo $enti['Entity']['id']; ?>">
                                                                    
                                                                    <input type="hidden" id="outfit_id" class="outfit_id" value="<?php echo $my_outfit['outfit'][0]['Outfit']['id']; ?>"> 
                                                                   
                                                                   
                                                                <a href="#" id="<?php echo $enti['Entity']['id'].'-'.$user_id; ?>" class="thumb-icon <?php echo ($enti['Wishlist']['id']) ? 'like' : ''; ?>"></a>
                                                                
                                                                
                                                                      
                                                                </span>
                                                            </div>
                                                    </li>
                                                    <?php }  ?>
                                                </ul>
                                                   

                                                </div>
                                            
                                                 
                                                <div class="twelve columns left client-outfit-bottom pad-none">
                                                    <div class="client-comments left">
                                                        <h2>Stylist Comment</h2>
                                                        <div class="client-comments-text left">Kyle- <?php echo $my_outfit['comments']; ?> <a href="javascript:;" title="">Read More</a></div>
                                                    </div>
                                                    <div class="share-outfit right">Share Outfit</div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php 
                                        endforeach;
                                        else :
                                        echo "<h1>There are no outfits to display. Contact your stylist to get started..</h1>";
                                        endif;
                                    ?>
                                        
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
                        
                        <?php echo $this->element('userAside/rightSidebar'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
