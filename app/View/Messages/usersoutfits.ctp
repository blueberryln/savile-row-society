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

    $(document).on("click", ".like", function(e) {
        e.preventDefault();
        $this = $(this);
        var productBlock = $this.closest(".bottm-links");
        var productId = productBlock.find("#product_id").val();
        var outfit_id = productBlock.find("#outfit_id").val();

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
        var sortOrder = $(this).val();
        location = location.href.split('?')[0] + '?sort=' + sortOrder;
    });
    
    $("#ascsort").on("click",".add-to-cart", function(e) {
        e.preventDefault();
        var productBlock = $(this).closest(".outfit-page-item"),
            productQuantity = productBlock.find("select.product-quantity").val(),
            productSize = productBlock.find(".product-size").val();
            var id = productBlock.find(".product-id").val();
            var outfitid = productBlock.find(".outfit_id").val();
            var quantity = parseInt(productQuantity) + 1;
            var size = productSize;
            
        
        $.post("<?php echo $this->request->webroot; ?>api/cart/save", { product_id: id, product_quantity: 1, product_size: 23, outfit_id: outfitid },
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
</script>   


<?php
$script = '

';
$this->Html->script("jquery.colorbox-min.js", array('inline' => false));
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->script("mosaic.1.0.1.min.js", array('inline' => false));
$this->Html->css('colorbox', null, array('inline' => false));
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
                                            if(count($outfits)){
                                            foreach ($outfits as $outfit){
                                        ?>
                                            
                                            <div class="twelve columns client-outfits left" >
                                                <div class="eleven columns container client-outfits-area pad-none" >
                                                    <?php if($outfit['Outfit']['outfit_name']){ 
                                                            echo  "<h1>" . ucfirst($outfit['Outfit']['outfit_name']) . "</h1>";    
                                                        }
                                                        else{
                                                            echo "<h1></h1>";
                                                        }
                                                    ?>
                                                    <div class="twelve columns client-outfits-img pad-none">
                                                        <ul>
                                                            <?php 
                                                            $entities = $outfit['OutfitItem'];
                                                            foreach($entities as $entity){
                                                            ?>
                                                        
                                                            <li>
                                                                <?php
                                                                    if(count($entity['product']['Image'])){
                                                                        echo '<img src="' . $this->webroot . 'files/products/' . $entity['product']['Image'][0]['name'] . '" alt="" />';
                                                                    }
                                                                    else{
                                                                        echo '<img src="' . $this->webroot . 'images/image_not_available.png" alt="">';
                                                                    }
                                                                ?>
                                                                
                                                                <div class="product-desc">
                                                                    <span class="product-name"><?php echo $entity['product']['Entity']['name']; ?></span>
                                                                    <span class="product-brand"><?php echo $entity['product']['Brand']['name']; ?></span>
                                                                    <span class="product-price">$<?php echo $entity['product']['Entity']['price']; ?></span>
                                                                    <span class="product-dtls"><a href="<?php echo $this->webroot; ?>messages/outfitdetails/<?php echo $outfit['Outfit']['id']; ?>" title="">Details</a></span>
                                                                    <span class="bottm-links outfit-page-item">
                                                                        <a class="add-to-cart" data-product_id="<?php echo $entity['product']['Entity']['id']; ?>" href="" title="">Add to Cart +</a>
                                                                        <input type="hidden" id="product_id" class="product-id" value="<?php echo $entity['product']['Entity']['id']; ?>">
                                                                        <input type="hidden" id="outfit_id" class="outfit_id" value="<?php echo $outfit['Outfit']['id']; ?>"> 
                                                                       
                                                                        <a href="#" id="<?php echo $entity['product']['Entity']['id'].'-'.$user_id; ?>" class="thumb-icon"></a>
                                                                      
                                                                    </span>
                                                                </div>
                                                            </li>
                                                            <?php }  ?>
                                                        </ul>
                                                    </div>
                                                
                                                    <div class="twelve columns left client-outfit-bottom pad-none">
                                                        <div class="client-comments left">
                                                            <h2>Stylist Comment</h2>
                                                            <div class="client-comments-text left"><b><?php echo ucfirst($outfit['Stylist']['first_name']); ?></b> - <?php echo $outfit['Message']['body']; ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php 
                                        }
                                        }else{
                                            echo "<h1>There are no outfits to display. Contact your stylist to get started..</h1>";
                                        }
                                        ?>
                                        
                                        </div>  

                                    </div>
                                    
                                    <div class="pagination useroutfit-pagination" id="useroutfit-pagination">
                                        <input type="hidden" id="pageNumber" value="<?php echo $page; ?>">
                                        <a href="" class="load-more">Load More</a>
                                    </div> 
                                </div>
                            </div>

                       
                        </div> 
                        
                        <?php echo $this->element('userAside/rightSidebar'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>