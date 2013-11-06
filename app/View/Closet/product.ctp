<?php
$logged_script = '';
if($user_id){    
    $logged_script = '
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
                        
                        if(ret["profile_status"] == "incomplete"){
                            var notificationDetails = new Array();
                            notificationDetails["msg"] = ret["profile_msg"];
                            notificationDetails["button"] = "<a href=\"' . $this->webroot . 'profile/about\" class=\"link-btn gold-btn\">Complete Style Profile</a>";
                            showNotification(notificationDetails);
                        }
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
    ';
}

$script = '
$(document).ready(function(){    
    $(".add-to-cart").click(function(e) {
        e.preventDefault();
        if($("select#product-quantity").val()== "")
        {
            $("span.err-message").fadeIn(300);
            return false;
        } 
        else
        {
            $("span.err-message").fadeOut(300);
        }
        if($("select#product-size").val()== "")
        {
            $("span.err-size-message").fadeIn(300);
            return false;
        } 
        else
        {
            $("span.err-size-message").fadeOut(300);
        }
        var id = $(this).data("product_id");
        var quantity = parseInt($("#product-quantity").val()) + 1;
        var size = $("#product-size").val();
        $.post("' . $this->request->webroot . 'api/cart/save", { product_id: id, product_quantity: quantity, product_size: size },
            function(data) {
                var ret = $.parseJSON(data);
                if(ret["status"] == "ok"){
                    $(".cart-items-count").html(ret["count"]);
                    if(ret["count"] == 3){
                        var notificationDetails = new Array();
                        notificationDetails["msg"] = ret["cart_message"];
                        notificationDetails["button"] = "<a href=\"' . $this->webroot . 'closet\" class=\"link-btn black-btn\">Continue Shopping</a><br><a href=\"' . $this->webroot . 'cart\" class=\"link-btn gold-btn\">Checkout</a>";
                        showNotification(notificationDetails);        
                    }
                    else{
                        var notificationDetails = new Array(); 
                        notificationDetails["msg"] = "Item has been added to the cart.";
                        showNotification(notificationDetails, true);
                    }
                }
                else if(ret["status"] == "login"){
                    signUp();       
                }
            }
        );
    });
    $("#lnk-fb-share").on("click", function(e){
        e.preventDefault(); 
        window.open(
          "https://www.facebook.com/sharer/sharer.php?u="+encodeURIComponent(location.href), 
          "facebook-share-dialog", 
          "width=626,height=436"); 
    });
    
    $("select#product-quantity").change(function(){
        $("span.err-message").fadeOut(300);    
    });
    
    $("select#product-size").change(function(){
        $("span.err-size-message").fadeOut(300);    
    });    
    ' . $logged_script . '
});
';
$this->Html->script("lightbox-2.6.min.js", array('inline' => false));
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$meta_description = $entity['Entity']['name'];
if ($entity) {
    $meta_description = Sanitize::html($entity['Entity']['description'], array('remove' => true));
}
$this->Html->meta('description', $meta_description, array('inline' => false));

// Progduct information for facebook open graph tags
$page_url = "//www.savilerowsociety.com" . $this->webroot . 'product/' . $entity['Entity']['id'] . '/' . $entity['Entity']['slug'];
if(count($entity['Image']) > 0){
    $img_src = "//www.savilerowsociety.com" . $this->webroot . 'files/products/' . $entity['Image'][0]['name']; 
}
else{
    $img_src = "//www.savilerowsociety.com" . $this->webroot . 'img/image_not_available.png';                    
}

$this->Html->meta(array('property'=> 'og:title', 'content' => $entity['Entity']['name'] . ' - Savile Row Society', ),'',array('inline'=>false));
$this->Html->meta(array('property'=> 'og:description', 'content' => $entity['Entity']['description']),'',array('inline'=>false));
$this->Html->meta(array('property'=> 'og:url', 'content' => $page_url),'',array('inline'=>false));
$this->Html->meta(array('property'=> 'og:image', 'content' => $img_src),'',array('inline'=>false));


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
                <div class="product-share"><span>Share:</span> <a href="" id="lnk-fb-share"></a><a href="mailto:?subject=Welcome to SAVILE ROW SOCIETY&body=Hello, %0D%0A%0D%0AI would like to recommend this product to you. Check out <?php echo Router::url( $this->here, true ); ?>." id="lnk-email"></a></div>
                <?php if(isset($entity['Wishlist'])) : ?>
                <div class="product-thumbs">
                    <a href="" class="thumbs-up <?php echo ($entity['Wishlist']['id']) ? 'liked' : ''; ?>"></a>
                    <a href="" class="thumbs-down <?php echo ($entity['Dislike']['id']) ? 'disliked' : ''; ?>"></a>
                </div>
                <?php endif; ?>
            </div>
            <div class="clear"></div>
        </div>
     
        <div class="six offset-by-one columns product-description alpha">
            <div>
                <h2 class="product-name"><?php echo $entity['Entity']['name']; ?></h2>
                <h5 class="brand">Brand: <a href="<?php echo $this->request->webroot; ?>company/brands"><?php echo $entity['Brand']['name']; ?></a></h5>
                <h5 class="price">Price: $<?php echo $entity['Entity']['price']; ?></h5>
                <h5>Product Details</h5>
                <p class="description"><?php echo $entity['Entity']['description']; ?></p>
            </div>
            <?php if($similar) : ?>
                <label class="product-color-label">Color</label>
                <div class="product-swatches">
                <?php foreach($similar as $product) : ?>
                    <?php if($product['Color'] && count($product['Color']) > 1) : ?>
                        <div class="color-thumbnails <?php echo ($product['Entity']['id'] == $entity['Entity']['id']) ? "color-selected" : "";?>">
                            <a href="<?php echo $this->webroot . 'product/' . $product['Entity']['id'] . '/' . $product['Entity']['slug']; ?>" class="color-one" style="background-color: <?php echo $product['Color'][0]['code']; ?>;"></a>

                            <a href="<?php echo $this->webroot . 'product/' . $product['Entity']['id'] . '/' . $product['Entity']['slug']; ?>" class="color-two" style="background-color: <?php echo $product['Color'][1]['code']; ?>;"></a>
                        </div>
                    <?php elseif($product['Color'] && count($product['Color']) == 1) : ?>
                        <div class="color-thumbnails <?php echo ($product['Entity']['id'] == $entity['Entity']['id']) ? "color-selected" : "";?>">
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
                        <option value="">Select Size &nbsp;</option>
                        <?php foreach($sizes as $size) : ?>
                            <option value="<?php echo $size['Detail']['size_id']; ?>"><?php echo $size['Size']['name']; ?></option>
                        <?php endforeach; ?>
                    </select><br/>
                    <span class="err-size-message">Please select size.</span>
                    </label>
                <?php endif; ?>
            <?php endif; ?>
            <label>Quantity
                <?php echo $this->Form->input('product-quantity', array('id'=>'product-quantity', 'options' => range(1,10), 'empty' => "Select Quantity ", 'label' => false, 'div' => false)); ?>
                <br />
                <span class="err-message">Please select quantity.</span>
            </label>                                           
            <a href="" class="link-btn black-btn add-to-cart" data-product_id="<?php echo $entity['Entity']['id']; ?>">ADD TO CART</a>                
        </div>
        <div class="clear"></div> <br /><br /><br />
    </div>
</div>