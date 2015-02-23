<?php
$logged_script = '';
if($user_id){    
$logged_script = '
    $(".product-my-likes").click(function(e) {
        e.preventDefault();
        $this = $(this);
            var productBlock = $this.closest(".product-detail-cont");
            //var productId = productBlock.find(".product-id").val();
            var productId = $this.data("product_id");
            var outfitId = "'.$outfit_id.'";
            //alert(outfitId);
        
            $.post("' . $this->request->webroot . 'api/wishlist/save", { product_id: productId,outfit_id:outfitId},
            function(data) {
                var ret = $.parseJSON(data);
                if(ret["status"] == "ok"){
                    $this.addClass("liked");
                    $this.closest(".product-my-likes").text("Liked");
                }
            }
        );
    });
';
}
$script = '
$(document).ready(function(){  
$(".disabled-cart").on("click", function(e){
    e.preventDefault();
});
$(".fade").mosaic();

$(".add-to-cart").click(function(e) {
e.preventDefault();
var productBlock = $(this).closest(".product-dtl-area"),
productQuantity = productBlock.find("select.product-quantity").val(),
productSize = productBlock.find("select.product-size").val();

var id = $(this).data("product_id");
var quantity = parseInt(productQuantity) + 1;
var size = productSize;
var outfitId = $("#outfit_id").val();

$.post("' . $this->request->webroot . 'api/cart/save", { product_id: id, product_quantity: quantity, product_size: size, outfit_id: outfitId },
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
<div>
    <div class="twelve columns container">
        <div class="eleven columns container message-box-area">
            <div class="twelve columns container left message-box">
                <div class="eleven columns container pad-none">

                    <?php echo $this->element('userAside/leftSidebar'); ?>

                    <div class="right-pannel product-detials right">
                        <div class="twelve columns message-area product-area left pad-none">
                            <div class="eleven columns container pad-none">
                                <div class="twelve columns outfit-dtls left">
                                    <h1><?php echo ucfirst($outfit['Outfit']['outfit_name']); ?></h1>
                                    <input id="outfit_id" value="<?php echo $outfit['Outfit']['id']; ?>" type="hidden">
                                    <div class="eleven columns container outfits-dtls-area pad-none">
                                        <div class="twelve columns left outfit-desc">
                                            <div class="outfit-dtls-date">
                                                <span>Date Created:</span> <?php echo date('m/d/Y', strtotime($outfit['Outfit']['created'])); ?>
                                            </div>
                                            <div class="outfit-dtls-price"><span>Outfit Price:</span>
                                                <?php
                                                    $sum = 0;
                                                    $brand_list = array();
                                                    foreach($outfit['OutfitItem'] as $value){
                                                        $sum += $value['product']['Entity']['price'];
                                                        $brand_list[] = $value['product']['Brand']['name'];
                                                    }
                                                    $brand_list = implode(',', array_unique($brand_list));
                                                    echo '$'.$sum; 
                                                ?>
                                            </div>
                                            <div class="outfit-dtls-brnads"><span>Brands in Outfit:</span></div>
                                            <div class="outfit-dtls-brand-name">
                                                <?php echo $brand_list; ?>
                                            </div>
                                            <div class="outfit-stylst-comment"><span>Stylist Comment:</span></div>
                                            <div class="outfit-stylst-comment-dtl">
                                                <?php 
                                                    echo $message['Message']['body'];
                                                ?>
                                            </div>
                                        </div>   
                                    </div>
                                </div>
                                <div class="twelve columns left outfit-dtls-img">
                                    <div class="eleven columns container outfit-dtls-img-list pad-none">
                                        <ul>
                                            <?php 
                                            foreach ($outfit['OutfitItem'] as $entity){
                                                if(count($entity['product']['Image']) >= 1){
                                                    $img = HTTP_ROOT . "products/resize/" . $entity['product']["Image"][0]["name"] . "/92/143";   
                                                }
                                                else{
                                                    $img = HTTP_ROOT . "img/image_not_available-small.png";       
                                                }            
                                            ?>

                                            <li><img src="<?php echo $img; ?>" alt="<?php echo $entity['product']['Entity']['name']; ?>" class="product-image fadein-image" style="opacity: 1;"> </li>
                                            <input type="hidden" value="<?php echo $entity['product']['Entity']['id']; ?>" class="product-id">  
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="twelve columns left product-dtls">
                                    <div class="eleven columns container product-view outfit-page-item">
                                    <?php foreach ($outfit['OutfitItem'] as $entity) : ?>
                                        <input type="hidden" value="<?php echo $entity['product']['Entity']['id']; ?>" class="product-id">  
                                        <input type="hidden" value="<?php echo $entity['product']['Entity']['slug']; ?>" class="product-slug">  
                                        <input type="hidden" value="<?php echo Configure::read('Social.callback_url') . "product/" . $entity['product']['Entity']['id'] . "/" . $entity['product']['Entity']['slug'] . "/"; ?>" class="product-url"> 

                                        <div class="twelve columns left product-dtl-area">
                                            <div class="product-dtl-img left"> 
                                            <?php if(count($entity['product']['Image']) > 0) : ?>
                                                <a href="<?php echo $this->webroot . 'files/products/' . $entity['product']['Image'][0]['name']; ?>" data-lightbox="product-images" class="group1" rel="group<?php echo $entity['product']['Entity']['id']; ?>">

                                                    <img class="zoom_01" src="<?php echo HTTP_ROOT . 'files/products/' . $entity['product']['Image'][0]['name']; ?>" class="fadein-image" data-zoom-image="<?php echo HTTP_ROOT . 'files/products/' . $entity['product']['Image'][0]['name']; ?>" />

                                                </a>
                                            <?php else : ?>
                                                <img src="<?php echo HTTP_ROOT; ?>img/image_not_available.png" class="fadein-image" />                    
                                            <?php endif; ?>
                                        </div>

                                        <div class="product-dtl-desc left">
                                            <div class="product-dtl-desc-top left">
                                                <div class="desc-top-brand">
                                                    <?php echo $entity['product']['Entity']['name']; ?> | <?php echo $entity['product']['Brand']['name']; ?>
                                                </div>
                                                <div class="desc-top-brand-price">
                                                    $ <?php echo $entity['product']['Entity']['price']; ?>
                                                </div>
                                            </div>
                                            <div class="product-dtl-desc-middle left">
                                                <ul>
                                                    <li><span>&ndash;</span><?php echo nl2br($entity['product']['Entity']['description']); ?></li>
                                                </ul>

                                            </div>
                                        <div class="product-dtl-desc-bottom left">
                                        <div class="slect-options left">
                                        <div class="select-size select-style left">
                                        <?php if($entity['size_id'] && $outfit['Outfit']['stylist_id'] == $user['User']['stylist_id']){
                                            echo '<select class="product-size">';
                                            echo '<option value="' . $entity['size_id'] . '">' . $sizes[$entity['size_id']] . '</option>';
                                            echo '</select>';
                                        }
                                        else{
                                            if(count($entity['product']['Detail'])){
                                                echo '<select class="product-size">';
                                                foreach($entity['product']['Detail'] as $detail){
                                                    echo '<option value="' . $detail['size_id'] . '">' . $sizes[$detail['size_id']] . '</option>';
                                                }  
                                                echo '</select>';  
                                            }
                                        }
                                        ?>
                                        <br/>
                                        </div>
                                        <div class="select-quantity select-style left">

                                        <?php echo $this->Form->input('product-quantity', array('class'=>'product-quantity', 'options' => range(1,10) , 'label' => false, 'div' => false, 'style' => "")); ?>
                                        </div>
                                        </div>
                                        <div class="product-dtl-specifiation left">Specifications preselected from Stylist  Recommendations</div>
                                        </div>
                                        </div>

                                        <div class="product-dtl-links left">
                                        
                                        <?php if($entity['product']['Entity']['show']) : ?>
                                        <a href="" class="gold-btn add-to-cart product-add-cart text-center" data-product_id="<?php echo $entity['product']['Entity']['id']; ?>">ADD TO CART</a>
                                        <?php else: ?>
                                        <a href="" class="product-my-likes text-center disabled-cart">Not Available</a>
                                        <?php endif; ?>

                                        <a class="product-my-likes"href="#" id="likes" data-product_id="<?php echo $entity['product']['Entity']['id']; ?>"><?php echo ($entity['product']['Wishlist']['id']) ? 'liked' : 'Add to My Likes'; ?></a>


                                        </div>
                                        </div>
                                        <?php endforeach; ?>

</div>
</div>
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
</div>