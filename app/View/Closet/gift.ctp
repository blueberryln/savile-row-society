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
var checkCount = '.$check_count.';

function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

//Function to validate gift card details
function checkGiftCardDetails(){
    var error = false;
    var giftId = $("#product-gift-id");
    var recipientName  = $("#RecipientName");
    var recipientEmail  = $("#RecipientEmail");
    
    if(giftId.val() == ""){
        error = true;
        giftId.closest(".input").find(".err-message").slideDown(300);     
    }
    else{
        giftId.closest(".input").find(".err-message").hide();    
    }
    
    if(recipientName.val() == ""){
        error = true;
        recipientName.closest(".input").find(".err-message").slideDown(300);     
    }
    else{
        recipientName.closest(".input").find(".err-message").hide();    
    }
    
    if(recipientEmail.val() == ""){
        error = true;
        recipientEmail.closest(".input").find(".err-message-invalid").hide();   
        recipientEmail.closest(".input").find(".err-message").not(".err-message-invalid").slideDown(300);     
    }
    else if(!IsEmail(recipientEmail.val())){
        error = true;
        recipientEmail.closest(".input").find(".err-message").hide();
        recipientEmail.closest(".input").find(".err-message-invalid").slideDown(300);  
    }
    else{
        recipientEmail.closest(".input").find(".err-message").hide();
        recipientEmail.closest(".input").find(".err-message-invalid").hide();    
    }
    
    return error;
}

$(document).ready(function(){  
    if(checkCount == 1){
        signUp();
    }
    $(".add-to-cart").click(function(e) {
        e.preventDefault();
        if(!checkGiftCardDetails()){
            var giftId = $("#product-gift-id").val();
            var recipientName  = $("#RecipientName").val();
            var recipientEmail  = $("#RecipientEmail").val();
            var giftMessages = $("#CardMessage").val();
            $.post("' . $this->request->webroot . 'api/cart/save", { product_id: giftId, recipientName: recipientName, recipientEmail: recipientEmail, giftMessages: giftMessages },
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
        }
    });
    
    $("#lnk-fb-share").on("click", function(e){
        e.preventDefault(); 
        window.open(
          "https://www.facebook.com/sharer/sharer.php?u="+encodeURIComponent(location.href), 
          "facebook-share-dialog", 
          "width=626,height=436"); 
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
            <div class="one columns alpha omega">&nbsp;</div>
            <div class="six columns left">
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
         
            <div class="five columns product-description right">
                <div>
                    <h2 class="product-name"><?php echo $entity['Entity']['name']; ?></h2>
                    <?php if($entity['Entity']['price'] > 0) : ?>
                    <h5 class="price">Price: $ <?php echo $entity['Entity']['price']; ?></h5>
                    <?php endif; ?>
                    <h5 class="product-details">Product Details :</h5>
                    <p class="description"><?php echo $entity['Entity']['description']; ?></p>
                </div>  
                <br />
                <div class="form gift-product-form">
                    <div class="input select">
                        <label>Gift Card Amount: </label>
                        <select name="data[gift-id]" id="product-gift-id">
                            <option value="">Select Amount &nbsp;</option>
                        <?php
                            foreach($gift_cards as $card){
                                
                                if($entity['Entity']['id'] == $card['Entity']['id']){
                                    echo "<option value='" . $card['Entity']['id'] . "' selected>$" . $card['Entity']['price'] . " &nbsp;</option>";    
                                }
                                else{
                                    echo "<option value='" . $card['Entity']['id'] . "'>$" . $card['Entity']['price'] . " &nbsp;</option>";
                                } 
                            }
                        ?>
                        </select>
                        <br />
                        <span class="err-message">Please select a gift card.</span>
                    </div>
                    <div class="input">
                        <label for="RecipientName">Recipient's Name</label>
                        <input name="data[recipient-name]" placeholder="Recipient's Name" type="text" id="RecipientName">
                        <br />
                        <span class="err-message">Please enter Recipient's Name.</span>
                    </div> 
                    <div class="input email">
                        <label for="RecipientEmail">Recipient's Email</label>
                        <input name="data[recipient-email]" placeholder="Recipient's Email" type="email" id="RecipientEmail">
                        <span class="err-message">Please enter Recipient's Email.</span>
                        <span class="err-message err-message-invalid">Please enter a valid email.</span>
                    </div>  
                    <div class="input">
                        <label for="CardMessage">Message</label>
                        <textarea name="data[recipient-message]" placeholder="Message" id="CardMessage"></textarea>
                    </div>   
                </div> 
                <div class="clear"></div>
                                                      
                <a href="" class="link-btn black-btn add-to-cart" data-product_id="<?php echo $entity['Entity']['id']; ?>">ADD TO CART</a>
                <a href="<?php echo $this->webroot; ?>closet" class="link-btn gold-btn prd-continue" >Continue Shopping</a>                 
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>