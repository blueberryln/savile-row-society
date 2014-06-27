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
                $.post("' . $this->request->webroot . 'api/wishlist/remove", { product_id: productId},
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
var threeItemPopup = ' . $show_three_item_popup. ';
var addCartPopup = ' . $show_add_cart_popup. ';
$(document).ready(function(){  
    
    if(isLoggedIn() && threeItemPopup == 1){
        var notificationDetails = new Array();
        notificationDetails["msg"] = "' . $popUpMsg . '";
        notificationDetails["button"] = "<a href=\"' . $this->webroot . 'cart\" class=\"link-btn gold-btn\">Checkout</a>";
        showNotification(notificationDetails);  
    }  
    else if(isLoggedIn() && addCartPopup == 1){
        var notificationDetails = new Array();
        notificationDetails["msg"] = "Item has been added to the cart.";
        showNotification(notificationDetails);        
    }  

    $(".fade").mosaic();

    $(".add-to-cart").click(function(e) {
        e.preventDefault();
        var productBlock = $(this).closest(".outfit-page-item"),
            productQuantity = productBlock.find("select.product-quantity").val(),
            productSize = productBlock.find("select.product-size").val();
        
        if(productQuantity == "")
        {
            productBlock.find("span.err-message").fadeIn(300);
            return false;
        } 
        else
        {
            productBlock.find("span.err-message").fadeOut(300);
        }
        if(productSize == "")
        {
            productBlock.find("span.err-size-message").fadeIn(300);
            return false;
        } 
        else
        {
            productBlock.find("span.err-size-message").fadeOut(300);
        }

        var id = $(this).data("product_id");
        var quantity = parseInt(productQuantity) + 1;
        var size = productSize;
        
        $.post("' . $this->request->webroot . 'api/cart/save", { product_id: id, product_quantity: quantity, product_size: size },
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
    
    $(".btn-request-price").click(function(e) {
        e.preventDefault();
        
        var productBlock = $(this).closest(".outfit-page-item"),
            productQuantity = productBlock.find("select.product-quantity").val(),
            productSize = productBlock.find("select.product-size").val(),
            $this = $(this);
        
        var loader = $this.next(".loader");
        if($this.hasClass("clicked")){
            $this.removeClass("clicked");
            loader.addClass("hide");
            return false;
        }
        else{
            $this.addClass("clicked");
            loader.removeClass("hide");
        }

        if(productQuantity == "")
        {
            productBlock.find("span.err-message").fadeIn(300);
            $this.removeClass("clicked");
            loader.addClass("hide");
            return false;
        } 
        else
        {
            productBlock.find("span.err-message").fadeOut(300);
        }
        if(productSize == "")
        {
            productBlock.find("span.err-size-message").fadeIn(300);
            $this.removeClass("clicked");
            loader.addClass("hide");
            return false;
        } 
        else
        {
            productBlock.find("span.err-size-message").fadeOut(300);
        }


        var requestEmail = productBlock.find(".request-email").val();
        if(!isLoggedIn()){
            if(requestEmail== ""){
                productBlock.find("span.err-email-message").fadeIn(300);
                $this.removeClass("clicked");
                loader.addClass("hide");
                return false;
            } 
            else
            {
                productBlock.find("span.err-email-message").fadeOut(300);
            }
        } 


        var id = $(this).data("product_id");
        var quantity = parseInt(productQuantity) + 1;
        var size = productSize;
        var comment = $(".txt-price-request").val();
        $.post("' . $this->request->webroot . 'api/requestprice", { product_id: id, product_quantity: quantity, product_size: size, request_comment: comment, request_email: requestEmail },
            function(data) {
                var ret = $.parseJSON(data);
                if(ret["status"] == "ok"){
                    var notificationDetails = new Array();
                    notificationDetails["msg"] = "Your price request for the product has been submitted successfully.";
                    showNotification(notificationDetails, true);
                    $(".product-quantity").val("");
                    $(".txt-price-request").val("");
                    $(".product-size").val("");
                    $(".request-email").val("");
                }
                $this.removeClass("clicked");
                loader.addClass("hide");
            }
        );
    });
    
    $(".lnk-fb-share").on("click", function(e){
        e.preventDefault(); 
        var url = $(this).closest(".product-detail-cont").find(".product-url").val();
        window.open(
          "https://www.facebook.com/sharer/sharer.php?u="+encodeURIComponent(url), 
          "facebook-share-dialog", 
          "width=626,height=436"); 
    });
    
    // $("#request-email").change(function(){
    //     $("span.err-email-message").fadeOut(300);    
    // });

    // $("select#product-quantity").change(function(){
    //     $("span.err-message").fadeOut(300);    
    // });
    
    // $("select#product-size").change(function(){
    //     $("span.err-size-message").fadeOut(300);    
    // });    

    $(".zoom_01").elevateZoom({
        zoomType: "inner",
        cursor: "crosshair",
        zoomWindowFadeIn: 500,
        zoomWindowFadeOut: 750
    }); 

    $(".group1").colorbox({scalePhotos: true, maxWidth: $(window).width()-100, maxHeight: $(window).height()-100});

    ' . $logged_script . '
});
';
$this->Html->script("jquery.elevateZoom-3.0.8.min.js", array('inline' => false));
$this->Html->script("mosaic.1.0.1.min.js", array('inline' => false));
$this->Html->script("jquery.colorbox-min.js", array('inline' => false));
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->css('colorbox', null, array('inline' => false));

?>
<div class="content-container">
    <div class="container content inner timeline">	
        <div>
            <div class="user-container">
                <div class="img-container">
                    <div class="profile-img text-center">
                    <?php
                        $img = "";
                        if(isset($second_user) && $second_user['User']['profile_photo_url'] && $second_user['User']['profile_photo_url'] != ""){
                            $img = $this->webroot . "files/users/" . $second_user['User']['profile_photo_url'];
                        }
                        else{
                            $img = $this->webroot . "img/dummy_image.jpg";    
                        }
                    ?>
                        <img src="<?php echo $img; ?>" id="user_image" />
                    </div>
                </div>
                <div class="info-container">
                    <?php if($second_user && $second_user['User']['is_stylist']) : ?>
                        <div id="user-name"><?php echo $second_user['User']['full_name']; ?><br />

                            <span class="stylist-name">Your Personal Stylist</span>
                        </div>
                        <div class="stylist-info">
                            <a href="mailto:<?php echo $second_user['User']['email']; ?>"><span><img src="<?php echo $this->webroot; ?>img/email.png" class="fadein-image" /><?php echo $second_user['User']['email']; ?></span></a><br />
                        </div>  
                    <?php else : ?>
                        <div id="user-name" style="border-bottom: none;"><?php echo $second_user['User']['full_name']; ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="stylist-talk">
                <div class="chat-container-detail">
                    <div class="chat-msg-box cur-user-msg" data-user-id="<?php echo $msg['Message']['user_from_id']; ?>" data-msg-id="<?php echo $msg['Message']['id']; ?>">
                        <div class="message-caption">
                            <?php
                            if($is_stylist || $is_admin){
                                echo "You suggested new items to complete a style:";
                            }
                            else{
                                echo $second_user['User']['first_name'] . " suggested new items to complete a style:";
                            }
                        ?>
                        </div>
                        <?php 
                        if($msg['Message']['body'] != '' && $msg['Message']['body'] != 'outfit'){
                            echo "<div class='message-body'>" . $msg['Message']['body'] . "</div><br>";
                        }
                        ?>
                    
                        <div class="chat-outfit-box">
                            <?php foreach ($entities as $entity) : ?>
                                <?php 
                                if(count($entity['Image']) >= 1){
                                    $img = $this->webroot . "products/resize/" . $entity["Image"][0]["name"] . "/98/131";   
                                }
                                else{
                                    $img = $this->webroot . "img/image_not_available-small.png";       
                                }
                                ?>
                                <div class="chat-product-box" style="float:left;">
                                    <div class="product-block"> 
                                        <input type="hidden" value="<?php echo $entity['Entity']['slug']; ?>" class="product-slug"> 
                                        <input type="hidden" value="<?php echo $entity['Entity']['id']; ?>" class="product-id"> 
                                        <div class="product-list-image mosaic-block fade"> 
                                            <div class="mosaic-overlay" style="display: block;"> 
                                                <div class="mini-product-details"> 
                                                   <span>$<?php echo $entity['Entity']['price']; ?></span> 
                                                   <span><?php echo $entity['Entity']['name']; ?></span> 
                                                </div> 
                                            </div> 
                                            <div class="mosaic-backdrop" style="display: block;"> 
                                                <img src="<?php echo $img; ?>" alt="<?php echo $entity['Entity']['name']; ?>" class="product-image fadein-image" style="opacity: 1;"> 
                                            </div> 
                                        </div> 
                                        <div class="product-list-links">
                                            <a href="<?php echo $this->webroot . "product/" . $entity['Entity']['id'] . "/" . $entity['Entity']['slug']; ?>" class="btn-buy">Buy</a>                             
                                        </div> 
                                    </div> 
                                </div>
                            <?php endforeach; ?>
                            <div class="clear-fix"></div> 
                        </div> 
                        <div class="message-date">
                            <small><?php echo $msg['Message']['created']; ?></small>
                        </div> 
                    </div>   
                </div>
                <br />
                <div class="one columns alpha omega">&nbsp;</div>
                <?php
                foreach ($entities as $entity) :
                ?>
                    <div class="twelve columns product-detail-cont center-block outfit-page-item">
                        <input type="hidden" value="<?php echo $entity['Entity']['id']; ?>" class="product-id">  
                        <input type="hidden" value="<?php echo $entity['Entity']['slug']; ?>" class="product-slug">  
                        <input type="hidden" value="<?php echo Configure::read('Social.callback_url') . "product/" . $entity['Entity']['id'] . "/" . $entity['Entity']['slug'] . "/"; ?>" class="product-url">        
                        <div class="six columns left">
                            <div class="product-default-image">
                                <?php if(count($entity['Image']) > 0) : ?>
                                    <a href="<?php echo $this->webroot . 'files/products/' . $entity['Image'][0]['name']; ?>" data-lightbox="product-images" class="group1" rel="group<?php echo $entity['Entity']['id']; ?>"><img class="zoom_01" src="<?php echo $this->webroot . 'files/products/' . $entity['Image'][0]['name']; ?>" class="fadein-image" data-zoom-image="<?php echo $this->webroot . 'files/products/' . $entity['Image'][0]['name']; ?>" /></a>
                                <?php else : ?>
                                    <img src="<?php echo $this->webroot; ?>img/image_not_available.png" class="fadein-image" />                    
                                <?php endif; ?>
                            </div>
                            
                            <?php if(count($entity['Image']) > 1) : ?>
                                <div class="product-icon-cont">
                                    <ul>
                                        <?php for($i=1; $i < count($entity['Image']); $i++) : ?> 
                                            <?php if($i != 4) : ?>
                                                <li><a href="<?php echo $this->webroot . 'files/products/' . $entity['Image'][$i]['name']; ?>" data-lightbox="product-images1" class="group1" rel="group<?php echo $entity['Entity']['id']; ?>"><img src="<?php echo $this->webroot . 'products/resize/' . $entity['Image'][$i]['name'] . '/68/92'; ?>" class="fadein-image" /></a></li>
                                            <?php else : ?>
                                                <li class="last"><a href="<?php echo $this->webroot . 'files/products/' . $entity['Image'][$i]['name']; ?>" data-lightbox="product-images" class="group1"rel="group<?php echo $entity['Entity']['id']; ?>"><img src="<?php echo $this->webroot . 'products/resize/' . $entity['Image'][$i]['name'] . '/68/92'; ?>" class="fadein-image" /></a></li>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <div class="clear-fix"></div>
                            <div class="product-actions">
                                <div class="product-share"><span>Share:</span> <a href="" id="lnk-fb-share" class="lnk-fb-share"></a><a href="mailto:?subject=Welcome to SAVILE ROW SOCIETY&body=Hello, %0D%0A%0D%0AI would like to recommend this product to you. Check out <?php echo Configure::read('Social.callback_url') . "product/" . $entity['Entity']['id'] . "/" . $entity['Entity']['slug'] . "/"; ?>" id="lnk-email"></a></div>
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
                            <?php 
                            $similar = isset($entity['Similar']) ? $entity['Similar'] : false;
                            if($similar) : ?>
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
                            
                            <?php 
                            $sizes = isset($entity['Detail']) ? $entity['Detail'] : false;
                            if($sizes) : ?>
                                <?php if(count($sizes) == 1 && $size_list[$sizes[0]['size_id']] == 'N/A') : ?>

                                <?php else : ?>
                                    <label>Size
                                    <select class="product-size">
                                        <option value="">Select Size &nbsp;</option>
                                        <?php foreach($sizes as $size) : ?>
                                            <option value="<?php echo $size['size_id']; ?>"><?php echo $size_list[$size['size_id']]; ?></option>
                                        <?php endforeach; ?>
                                    </select><br/>
                                    <span class="err-size-message">Please select size.</span>
                                    </label>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <label>Quantity
                                <?php echo $this->Form->input('product-quantity', array('class'=>'product-quantity', 'options' => range(1,10) , 'label' => false, 'div' => false, 'style' => "")); ?>
                                <br />
                                <span class="err-message">Please select quantity.</span>
                            </label>   
                            
                            
                            <?php if($entity['Entity']['price'] > 0) : ?>                                        
                                <a href="" class="link-btn gold-btn add-to-cart full-width text-center" data-product_id="<?php echo $entity['Entity']['id']; ?>">ADD TO CART</a>
                            <?php elseif($user_id) : ?>
                                <br>
                                <textarea class="txt-price-request" placeholder="Comments"></textarea>
                                <a href="" class="link-btn gold-btn btn-request-price full-width text-center" data-product_id="<?php echo $entity['Entity']['id']; ?>">Request Price</a>
                                <p class="loader hide"><img src="<?php echo $this->webroot; ?>img/loader.gif"></p>
                            <?php else : ?>
                                <br>
                                <input type="text" placeholder="Email" class="request-email">
                                <span class="err-email-message">Please enter an email.</span>
                                <textarea class="txt-price-request" placeholder="Comments" style="margin-top:6px;"></textarea>
                                <a href="" class="link-btn gold-btn btn-request-price full-width text-center" data-product_id="<?php echo $entity['Entity']['id']; ?>">Request Price</a>
                                <p class="loader hide"><img src="<?php echo $this->webroot; ?>img/loader.gif"></p>
                            <?php endif; ?>                 
                        </div>
                        <div class="clear-fix"></div>
                    </div>

                <?php endforeach; ?>
            </div>   
            <div class="clear-fix"></div>         
        </div>    
    </div>
</div>