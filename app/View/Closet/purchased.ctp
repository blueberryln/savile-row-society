<?php
$script = '
$(document).ready(function(){
    $(".fade").mosaic();
    $(".remove").click(function(e) {
        e.preventDefault();

        var object = $(this).parent();
        var id = $(this).data("product_id");
        $.post("' . $this->request->webroot . 'api/wishlist/remove", { product_id: id }, 
            function(data) {
                if(data != 0){
                   object.fadeOut(800);
                }
            }
        );
    });
    $(".mosaic-overlay").on("click", function(e){
        e.preventDefault();
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
            <div class="eleven columns product-listing center-block purchased text-center">
                <div class="mycloset-tabs text-center">
                    <a href="<?php echo $this->webroot . 'mycloset/liked/' . $user_id; ?>" class="link-btn black-btn">Liked Items</a>
                    <a href="<?php echo $this->webroot . 'mycloset/purchased/' . $user_id; ?>" class="link-btn gold-btn">Purchased Items</a>
                </div>
                <?php if ($purchased_list) : ?>
                    <?php 
                    for($i = 0; $i < 5; $i++){
                        $item = $purchased_list[$i];
                    ?>
                        <?php if(isset($item['Entity']) && $item['Entity']) : ?>
                            <div class="product-box">
                                <div class="product-block">
                                    <input type="hidden" value="<?php echo $item['Entity']['slug']; ?>" class="product-slug">
                                    <input type="hidden" value="<?php echo $item ['Entity']['id']; ?>" class="product-id">
                                    <div class="product-list-image mosaic-block fade">
                                        <div class="mosaic-overlay">
                            				<div class="mini-product-details">
                        					   <span>$<?php echo $item['OrderItem']['price']; ?></span>
                        					   <span><?php echo $item['Entity']['name']; ?></span>
                        					   <span>Quantity: <?php echo $item['OrderItem']['quantity']; ?></span>
                        					   <span>Size: <?php echo $sizes[$item['OrderItem']['size_id']]; ?></span>
                                               <?php
                                                    $color_text = "";
                                                    if($item['Color'] && count($item['Color']) > 0){
                                                        $color_text = $item['Color'][0]['name'];
                                                        for($j=1; $j<count($item['Color']); $j++){
                                                            $color_text = $color_text . '/ ' . $item['Color'][$j]['name'];
                                                        }
                                                    }
                                               ?>
                        					   <span>Color: <?php echo $color_text; ?></span>
                        					   <span><?php echo date('d/m/Y', strtotime($item['OrderItem']['created'])); ?></span>
                            				</div>
                            			</div>
                                        <?php 
                                        if($item['Image']){
                                            $img_src = HTTP_ROOT . "files/products/" . $item['Image'][0]['name'];
                                        }
                                        else{
                                            $img_src = HTTP_ROOT . "img/photo_not_available.png";
                                        }
                                        ?>
                                        <div class="mosaic-backdrop">
                                            <img src="<?php echo $img_src; ?>" alt="<?php echo $item['Entity']['name']; ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php
                        if($i == (count($purchased_list)-1) && count($purchased_list) % 5 == 4){
                            echo '<div class="product-box"><div class="product-block"></div></div>';
                        }
                        if($i == (count($purchased_list)-1) && count($purchased_list) % 5 == 3){
                            echo '<div class="product-box"><div class="product-block"></div></div>';
                            echo '<div class="product-box"><div class="product-block"></div></div>';  
                        }
                        else if($i == (count($purchased_list)-1) && count($purchased_list) % 5 == 2){
                            echo '<div class="product-box"><div class="product-block"></div></div>'; 
                            echo '<div class="product-box"><div class="product-block"></div></div>'; 
                            echo '<div class="product-box"><div class="product-block"></div></div>'; 
                        }
                        else if($i == (count($purchased_list)-1) && count($purchased_list) % 5 == 1){
                            echo '<div class="product-box"><div class="product-block"></div></div>'; 
                            echo '<div class="product-box"><div class="product-block"></div></div>'; 
                            echo '<div class="product-box"><div class="product-block"></div></div>'; 
                            echo '<div class="product-box"><div class="product-block"></div></div>'; 
                        }
                    }
                    ?>    
                <?php else: ?>
                    <h2 class="subhead text-center">You haven't purchased anything yet.</h2>  
                <?php endif; ?>
            </div>
            <div class="clear"></div>
            <div class="pagination my-closet">
                    <?php
                    echo $this->Paginator->prev('>', array(), null, array('class' => 'prev disabled'));
                    echo $this->Paginator->numbers(array('separator' => '', 'class' => 'page-links'));
                    echo $this->Paginator->next('>', array(), null, array('class' => 'next disabled'));
                    ?>
                </div><br />
            
    </div>
</div>
