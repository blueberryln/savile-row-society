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
                $.post("' . $this->request->webroot . 'wishlists/save", { product_id: productId},
                    function(data) {
                        var ret = $.parseJSON(data);
                        if(ret["status"] == "ok"){
                            $this.addClass("liked");
                            $this.closest(".product-thumbs").find(".thumbs-down").removeClass("disliked");
                        }
                        
                        if(ret["profile_status"] == "incomplete"){
                            var notificationDetails = new Array();
                            notificationDetails["msg"] = ret["profile_msg"];
                            notificationDetails["button"] = "<a href=\"' . $this->webroot . 'register/wardrobe\" class=\"link-btn gold-btn\">Complete Style Profile</a>";
                            showNotification(notificationDetails);
                        }
                    }
                );
            }
            else{
                $.post("' . $this->request->webroot . 'wishlists/remove", { product_id: productId},
                    function(data) {
                        var ret = $.parseJSON(data);
                        if(ret["status"] == "ok"){
                            $this.removeClass("liked");
                        }
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
                            $this.closest(".product-thumbs").find(".thumbs-up").removeClass("liked");
                        }
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
                    }
                );
            }
        });
    ';
}

$script = '
var checkCount = '.$check_count.';

$(document).ready(function(){  
    if(checkCount == 1){
        signUp();
    }
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
                    location = "' . $this->webroot . 'closet";
                }
                else if(ret["status"] == "login"){
                    signUp();       
                }
            }
        );
    });
    
    $(".btn-request-price").click(function(e) {
        e.preventDefault();
        $this = $(this);
        var loader = $this.next(".loader");
        if($this.hasClass("clicked")){
            return false;
        }
        else{
            $this.addClass("clicked");
            loader.removeClass("hide");
        }

        if($("select#product-quantity").val()== "")
        {
            $("span.err-message").fadeIn(300);
            $this.removeClass("clicked");
            loader.addClass("hide");
            return false;
        } 
        else
        {
            $("span.err-message").fadeOut(300);
        }
        if($("select#product-size").val()== "")
        {
            $("span.err-size-message").fadeIn(300);
            $this.removeClass("clicked");
            loader.addClass("hide");
            return false;
        } 
        else
        {
            $("span.err-size-message").fadeOut(300);
        }


        var requestEmail = "";
        if(!isLoggedIn()){
            if($("#request-email").val()== ""){
                $("span.err-email-message").fadeIn(300);
                $this.removeClass("clicked");
                loader.addClass("hide");
                return false;
            } 
            else
            {
                $("span.err-email-message").fadeOut(300);
            }
            requestEmail = $("#request-email").val();
        } 


        var id = $this.data("product_id");
        var quantity = parseInt($("#product-quantity").val()) + 1;
        var size = $("#product-size").val();
        var comment = $(".txt-price-request").val();
        $.post("' . $this->request->webroot . 'api/requestprice", { product_id: id, product_quantity: quantity, product_size: size, request_comment: comment, request_email: requestEmail },
            function(data) {
                $this.removeClass("clicked");
                loader.addClass("hide");
                var ret = $.parseJSON(data);
                if(ret["status"] == "ok"){
                    var notificationDetails = new Array();
                    notificationDetails["msg"] = "Your price request for the product has been submitted successfully.";
                    showNotification(notificationDetails, true);
                    $("#product-quantity").val("");
                    $(".txt-price-request").val("");
                    $("#product-size").val("");
                    $("#request-email").val("");
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
    
    $("#request-email").change(function(){
        $("span.err-email-message").fadeOut(300);    
    });

    $("select#product-quantity").change(function(){
        $("span.err-message").fadeOut(300);    
    });
    
    $("select#product-size").change(function(){
        $("span.err-size-message").fadeOut(300);    
    });    

    var offset = $(".product-default-image").offset();

    $("#zoom_01").elevateZoom({
        zoomType: "inner",
        cursor: "crosshair",
        zoomWindowFadeIn: 500,
        zoomWindowFadeOut: 750,
    }); 

    $(".group1").colorbox({rel:"group1", scalePhotos: true, maxWidth: $(window).width()-100, maxHeight: $(window).height()-100});

    ' . $logged_script . '
});
';
$this->Html->script("jquery.elevateZoom-3.0.8.min.js", array('inline' => false));
//$this->Html->script("lightbox-2.6.min.js", array('inline' => false));
$this->Html->script("jquery.colorbox-min.js", array('inline' => false));
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->css('colorbox', null, array('inline' => false));

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
<div class="content-container">
    <div class="container content inner">	
        <div class="one columns">&nbsp;</div>
        <div class="ten columns details-margin row center-block">
            <p class="product-breadcrumb" >
                <a href="<?php echo $this->webroot . "closet" ; ?>">Closet</a>
                <?php if(isset($parent_category)) : ?>
                    &gt; <a href="<?php echo $this->webroot . "closet/" . $parent_category['Category']['slug'] ; ?>"><?php echo $parent_category['Category']['name']; ?></a>
                <?php endif; ?>
                &gt; <a href="<?php echo $this->webroot . "closet/" . $category['Category']['slug'] ; ?>"><?php echo $category['Category']['name']; ?></a></p>
        </div>
        <div class="ten columns product-detail-cont center-block">
            <input type="hidden" value="<?php echo $entity['Entity']['id']; ?>" class="product-id">            
            <div class="six columns left">
                <div class="product-default-image">
                    <?php if(count($entity['Image']) > 0) : ?>
                        <a href="<?php echo $this->webroot . 'files/products/' . $entity['Image'][0]['name']; ?>" data-lightbox="product-images" class="group1"><img id="zoom_01" src="<?php echo HTTP_ROOT . 'files/products/' . $entity['Image'][0]['name']; ?>" class="fadein-image" data-zoom-image="<?php echo HTTP_ROOT . 'files/products/' . $entity['Image'][0]['name']; ?>" /></a>
                    <?php else : ?>
                        <img src="<?php echo HTTP_ROOT; ?>img/image_not_available.png" class="fadein-image" />                    
                    <?php endif; ?>
                </div>
                
                <?php if(count($entity['Image']) > 1) : ?>
                    <div class="product-icon-cont">
                        <ul>
                            <?php for($i=1; $i < count($entity['Image']); $i++) : ?> 
                                <?php if($i != 4) : ?>
                                    <li><a href="<?php echo $this->webroot . 'files/products/' . $entity['Image'][$i]['name']; ?>" data-lightbox="product-images1" class="group1"><img src="<?php echo HTTP_ROOT . 'products/resize/' . $entity['Image'][$i]['name'] . '/68/92'; ?>" class="fadein-image" /></a></li>
                                <?php else : ?>
                                    <li class="last"><a href="<?php echo $this->webroot . 'files/products/' . $entity['Image'][$i]['name']; ?>" data-lightbox="product-images" class="group1"><img src="<?php echo HTTP_ROOT . 'products/resize/' . $entity['Image'][$i]['name'] . '/68/92'; ?>" class="fadein-image" /></a></li>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <div class="clear-fix"></div>
                <div class="product-actions">
                    <div class="product-share"><span>Share:</span> <a href="" id="lnk-fb-share"></a><a href="mailto:?subject=Welcome to Savile Row Society&body=Hello, %0D%0A%0D%0AI would like to recommend this product to you. Check out <?php echo Router::url( $this->here, true ); ?>." id="lnk-email"></a></div>
                    <?php if(isset($entity['Wishlist'])) : ?>
                    <div class="product-thumbs">
                        <a href="#" class="thumbs-up <?php echo ($entity['Wishlist']['id']) ? 'liked' : ''; ?>"></a>
                        <a href="#" class="thumbs-down <?php echo ($entity['Dislike']['id']) ? 'disliked' : ''; ?>"></a>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="clear-fix"></div>
            </div>
         
            <div class="five columns product-description right">
                <div>
                    <h2 class="product-name"><?php echo $entity['Entity']['name']; ?></h2>
                    <h5 class="brand">Brand: <a href="<?php echo $this->request->webroot; ?>company/brands"><?php echo $entity['Brand']['name']; ?></a></h5>
                    <?php if($entity['Entity']['price'] > 0) : ?>
                    <h5 class="price">Price: $ <?php echo $entity['Entity']['price']; ?></h5>
                    <?php endif; ?>
                    <h5 class="product-details">Product Details :</h5>
                    <p class="description"><?php echo nl2br($entity['Entity']['description']); ?></p>
                </div>
                <?php if($similar) : ?>
                    <label class="product-color-label">Color</label>
                    <div class="product-swatches">
                    <?php foreach($similar as $product) : ?>
                        <div class="thumb-cont <?php echo ($product['Entity']['id'] == $entity['Entity']['id']) ? "color-selected" : "";?>">
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
                        </div>
                    <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <div class="clear-fix"></div>
                
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
                    <?php echo $this->Form->input('product-quantity', array('id'=>'product-quantity', 'options' => range(1,10) , 'label' => false, 'div' => false, 'style' => "")); ?>
                    <br />
                    <span class="err-message">Please select quantity.</span>
                </label>   
                
                
                <?php if($entity['Entity']['price'] > 0) : ?>                                        
                    <a href="" class="link-btn gold-btn add-to-cart full-width text-center" data-product_id="<?php echo $entity['Entity']['id']; ?>">ADD TO CART</a>
                <?php elseif($user_id) : ?>
                    <br>
                    <textarea class="txt-price-request" placeholder="Comments"></textarea>
                    <a href="" class="link-btn gold-btn btn-request-price full-width text-center" data-product_id="<?php echo $entity['Entity']['id']; ?>">Request Price</a>
                    <p class="loader hide"><img src="<?php echo HTTP_ROOT; ?>img/loader.gif"></p>
                <?php else : ?>
                    <br>
                    <input type="text" placeholder="Email" id="request-email">
                    <span class="err-email-message">Please enter an email.</span>
                    <textarea class="txt-price-request" placeholder="Comments" style="margin-top:6px;"></textarea>
                    <a href="" class="link-btn gold-btn btn-request-price full-width text-center" data-product_id="<?php echo $entity['Entity']['id']; ?>">Request Price</a>
                    <p class="loader hide"><img src="<?php echo HTTP_ROOT; ?>img/loader.gif"></p>
                <?php endif; ?>                
            </div>
            <div class="clear-fix"></div>
        </div>
    </div>
</div>