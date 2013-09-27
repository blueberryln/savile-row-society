<?php
$script = '
$(document).ready(function(){    
    $(".thumbs-up").click(function(e) {
        e.preventDefault();
        $this = $(this);
        var productBlock = $this.closest(".product-detail-cont");
        var productId = productBlock.find(".product-id").val();
        if(!$this.hasClass("liked")){
            $.post("' . $this->request->webroot . 'api/wishlist/save", { product_id: productId},
                function(data) {
                    var ret = $.parseJSON(data);
                    if(ret["status"] == "ok"){
                        $this.addClass("liked");
                    }
                    
                    //var notificationDetails = new Array();
                    //notificationDetails["msg"] = ret["msg"];
                    //showNotification(notificationDetails, true);
                }
            );
        }
        else{
            $.post("' . $this->request->webroot . 'api/wishlist/remove", { product_id: productId},
                function(data) {
                    var ret = $.parseJSON(data);
                    if(ret["status"] == "ok"){
                        $this.removeClass("liked");
                    }
                    
                    //var notificationDetails = new Array();
                    //notificationDetails["msg"] = ret["msg"];
                    //showNotification(notificationDetails, true);
                }
            );
        }
    });
    $(".thumbs-down").click(function(e) {
        e.preventDefault();
        $this = $(this);
        var productBlock = $this.closest(".product-detail-cont");
        var productId = productBlock.find(".product-id").val();
        if(!$this.hasClass("disliked")){
            $.post("' . $this->request->webroot . 'api/dislike/save", { product_id: productId},
                function(data) {
                    var ret = $.parseJSON(data);
                    if(ret["status"] == "ok"){
                        $this.addClass("disliked");
                    }
                    
                    //var notificationDetails = new Array();
                    //notificationDetails["msg"] = ret["msg"];
                    //showNotification(notificationDetails, true);
                }
            );
        }
        else{
            $.post("' . $this->request->webroot . 'api/dislike/remove", { product_id: productId},
                function(data) {
                    var ret = $.parseJSON(data);
                    if(ret["status"] == "ok"){
                        $this.removeClass("disliked");
                    }
                    
                    //var notificationDetails = new Array();
                    //notificationDetails["msg"] = ret["msg"];
                    //showNotification(notificationDetails, true);
                }
            );
        }
    });
    $(".add-to-cart").click(function(e) {
        e.preventDefault();

        var id = $(this).data("product_id");
        var quantity = $("#product-quantity").val();
        var size = $("#product-size").val();
        $.post("' . $this->request->webroot . 'api/cart/save", { product_id: id, product_quantity: quantity, product_size: size },
            function(data) {
                var ret = $.parseJSON(data);
                if(ret["status"] == "ok"){
                    $("#cart-items-count").html(ret["count"]);
                    var notificationDetails = new Array(); 
                    notificationDetails["msg"] = "Item has been added to the cart.";
                    showNotification(notificationDetails, true);
                }
            }
        );
    });
    $("#lnk-fb-share").on("click", function(e){
        e.preventDefault(); 
    });
    
});
';
$this->Html->script("lightbox-2.6.min.js", array('inline' => false));
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));

$meta_description = $entity['Entity']['name'];
if ($entity) {
    $meta_description = Sanitize::html($entity['Entity']['description'], array('remove' => true));
}
$this->Html->meta('description', $meta_description, array('inline' => false));

// columns size
$columns = 'eleven';
?>
<div class="container content inner">	
    <div class="one columns alpha omega">&nbsp;</div>
    <div class="fourteen columns details-margin row">
        <p class="product-breadcrumb" >
            <a href="<?php echo $this->webroot . "closet" ; ?>">CATEGORIES</a>
            <?php if(isset($parent_category)) : ?>
                &gt; <a href="<?php echo $this->webroot . "closet/" . $parent_category['Category']['slug'] ; ?>"><?php echo $parent_category['Category']['name']; ?></a>
            <?php endif; ?>
            &gt; <a href="<?php echo $this->webroot . "closet/" . $category['Category']['slug'] ; ?>"><?php echo $category['Category']['name']; ?></a></p>
    </div>
    <div class="sixteen columns product-detail-cont">
        <input type="hidden" value="<?php echo $entity['Entity']['id']; ?>" class="product-id">
        <div class="one columns alpha omega">&nbsp;</div>
        <div class="seven columns">
            <div class="product-default-image">
                <?php if(count($entity['Image']) > 0) : ?>
                    <a href="<?php echo $this->webroot . 'files/products/' . $entity['Image'][0]['name']; ?>" data-lightbox="product-images"><img src="<?php echo $this->webroot . 'files/products/' . $entity['Image'][0]['name']; ?>" class="fadein-image" /></a>
                <?php else : ?>
                    <img src="<?php echo $this->webroot; ?>img/image_not_available.png" class="fadein-image" />                    
                <?php endif; ?>
            </div>
            
            <?php if(count($entity['Image']) > 1) : ?>
                <div class="product-icon-cont">
                    <ul>
                        <?php for($i=1; $i < count($entity['Image']); $i++) : ?> 
                            <?php if($i != 4) : ?>
                                <li><a href="<?php echo $this->webroot . 'files/products/' . $entity['Image'][$i]['name']; ?>" data-lightbox="product-images"><img src="<?php echo $this->webroot . 'products/resize/' . $entity['Image'][$i]['name'] . '/68/92'; ?>" class="fadein-image" /></a></li>
                            <?php else : ?>
                                <li class="last"><a href="<?php echo $this->webroot . 'files/products/' . $entity['Image'][$i]['name']; ?>" data-lightbox="product-images"><img src="<?php echo $this->webroot . 'products/resize/' . $entity['Image'][$i]['name'] . '/68/92'; ?>" class="fadein-image" /></a></li>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <div class="clear"></div>
            <div class="product-actions">
                <div class="product-share"><span>Share:</span> <a href="" id="lnk-fb-share"></a><a href="mailto:contactus@savilerowsociety.com" id="lnk-email"></a></div>
                <div class="product-thumbs">
                    <a href="" class="thumbs-up <?php echo ($entity['Wishlist']['id']) ? 'liked' : ''; ?>"></a>
                    <a href="" class="thumbs-down <?php echo ($entity['Dislike']['id']) ? 'disliked' : ''; ?>"></a></div>
            </div>
            <div class="clear"></div>
        </div>
     
        <div class="six offset-by-one columns product-description alpha">
            <div>
                <h2 class="product-name"><?php echo $entity['Entity']['name']; ?></h2>
                <h5 class="price">Price: $<?php echo $entity['Entity']['price']; ?></h5>
                <h5>Product Details</h5>
                <p class="description"><?php echo $entity['Entity']['description']; ?></p>
            </div>
            <?php if($similar) : ?>
                <label class="product-color-label">Color</label>
                <div class="product-swatches">
                <?php if($entity['Color'] && count($entity['Color']) > 1) :?>
                    <div class="color-thumbnails color-selected">
                        <a href="<?php echo $this->webroot . 'product/' . $entity['Entity']['id'] . '/' . $entity['Entity']['slug']; ?>" class="color-one" style="background-color: <?php echo $entity['Color'][0]['code']; ?>;"></a>

                        <a href="<?php echo $this->webroot . 'product/' . $entity['Entity']['id'] . '/' . $entity['Entity']['slug']; ?>" class="color-two" style="background-color: <?php echo $entity['Color'][1]['code']; ?>;"></a>
                    </div>
                <?php elseif($entity['Color'] && count($entity['Color']) == 1) : ?>
                    <div class="color-thumbnails color-selected">
                        <a href="<?php echo $this->webroot . 'product/' . $entity['Entity']['id'] . '/' . $entity['Entity']['slug']; ?>" class="color-single" style="background-color: <?php echo $entity['Color'][0]['code']; ?>;"></a>
                    </div>
                <?php endif; ?>


                <?php foreach($similar as $product) : ?>
                    <?php if($product['Color'] && count($product['Color']) > 1) : ?>
                        <div class="color-thumbnails">
                            <a href="<?php echo $this->webroot . 'product/' . $product['Entity']['id'] . '/' . $product['Entity']['slug']; ?>" class="color-one" style="background-color: <?php echo $product['Color'][0]['code']; ?>;"></a>

                            <a href="<?php echo $this->webroot . 'product/' . $product['Entity']['id'] . '/' . $product['Entity']['slug']; ?>" class="color-two" style="background-color: <?php echo $product['Color'][1]['code']; ?>;"></a>
                        </div>
                    <?php elseif($product['Color'] && count($product['Color']) == 1) : ?>
                        <div class="color-thumbnails">
                            <a href="<?php echo $this->webroot . 'product/' . $product['Entity']['id'] . '/' . $product['Entity']['slug']; ?>" class="color-single" style="background-color: <?php echo $product['Color'][0]['code']; ?>;"></a>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="clear"></div>
            
            <?php if($sizes) : ?>
                <?php if(count($sizes) == 1 && $sizes[0]['Size']['name'] == 'N/A') : ?>

                <?php else : ?>
                    <label>Size
                    <select id="product-size">
                        <option value="">Select Size</option>
                        <?php foreach($sizes as $size) : ?>
                            <option value="<?php echo $size['Detail']['size_id']; ?>"><?php echo $size['Size']['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    </label>
                <?php endif; ?>
            <?php endif; ?>
            <label>Quantity
                <select id="product-quantity">
                  <option value="">Select Quantity</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                </select>
            </label>                         
            <a href="" class="link-btn black-btn add-to-cart" data-product_id="<?php echo $entity['Entity']['id']; ?>">ADD TO CART</a>                
        </div>
        <div class="clear"></div> <br /><br /><br /><br /><br />
    </div>
</div>