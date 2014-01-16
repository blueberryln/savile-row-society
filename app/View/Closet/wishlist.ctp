<?php
$script = '
$(document).ready(function(){
    $(".fade").mosaic();
    $(".remove-product").click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        var object = $(this).closest(".product-block");
        var id = object.find(".product-id").val();
        $.post("' . $this->request->webroot . 'api/wishlist/remove", { product_id: id }, 
            function(data) {
                var ret = $.parseJSON(data);
                if(ret["status"] == "ok"){
                   object.parent().remove();
                }
            }
        );
    });
    $(".mosaic-overlay").not(".remove-product").on("click", function(e){
        e.preventDefault();
        var container = $(".remove-product");
        var productBlock = $(this).closest(".product-block");
        var productSlug = productBlock.find(".product-slug").val();
        var productId = productBlock.find(".product-id").val();
        window.location = "' . $this->request->webroot . 'product/" + productId + "/" + productSlug;
    });
});
';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->script("mosaic.1.0.1.min.js", array('inline' => false));
$this->Html->meta('description', 'First mover', array('inline' => false));
?>
<div class="content-container">
    <div class="nine-five columns container content inner">	
        <div class="twelve columns text-center page-heading">
            <h1>MY CLOSET</h1>
        </div>
            <div class="eleven columns omega product-listing center-block wishlist">
                <div class="mycloset-tabs text-center">
                    <a href="<?php echo $this->webroot . 'mycloset/liked/' . $user_id; ?>" class="link-btn black-btn">Liked Items</a>
                    <a href="<?php echo $this->webroot . 'mycloset/purchased/' . $user_id; ?>" class="link-btn gray-btn">Purchased Items</a>
                </div>
                <?php if ($wishlists) : ?>
                    <?php foreach ($wishlists as $item) : ?>
                        <?php if(isset($item['Entity']) && $item['Entity']) : ?>
                            <div class="product-box">
                                <div class="product-block">
                                    <input type="hidden" value="<?php echo $item['Entity']['slug']; ?>" class="product-slug">
                                    <input type="hidden" value="<?php echo $item ['Entity']['id']; ?>" class="product-id">
                                    <div class="product-list-image mosaic-block fade">
                                        <div class="mosaic-overlay">
                                            <a href="" class="remove-product"></a>
                            				<div class="mini-product-details">
                        					   <span>$<?php echo $item['Entity']['price']; ?></span>
                        					   <span><?php echo $item['Entity']['name']; ?></span>
                            				</div>
                            			</div>
                                        <?php 
                                        if($item['Image']){
                                            $img_src = $this->request->webroot . "files/products/" . $item['Image'][0]['name'];
                                        }
                                        else{
                                            $img_src = $this->request->webroot . "img/photo_not_available.png";
                                        }
                                        ?>
                                        <div class="mosaic-backdrop">
                                            <img src="<?php echo $img_src; ?>" alt="<?php echo $item['Entity']['name']; ?>" />
                                        </div>
                                    </div>
                                    <div class="product-list-links">
                                        <a href="<?php echo $this->request->webroot . 'product/' . $item['Entity']['id'] . '/' . $item['Entity']['slug']; ?>" class="btn-buy">Buy</a>
                                    </div>
                                </div>
                            </div>
                        <?php endif;?>
                    <?php endforeach; ?>  
                <?php else: ?>
                    <h2 class="subhead text-center">There are no liked items.</h2>  
                <?php endif; ?>
                <div class="clear"></div>
                <div class="pagination my-closet">
                    <?php
                    echo $this->Paginator->prev('>', array(), null, array('class' => 'prev disabled'));
                    echo $this->Paginator->numbers(array('separator' => '', 'class' => 'page-links'));
                    echo $this->Paginator->next('>', array(), null, array('class' => 'next disabled'));
                    ?>
                </div>
                <div class="text-center">
                    <br />
                    <a href="<?php echo $this->webroot . 'closet'; ?>" class="link-btn gold-btn continue-shopping">CONTINUE BROWSING</a>                
                </div><br />
            </div>
            <div class="clear"></div>
            
    </div>
</div>
