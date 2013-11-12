<?php
$logged_script = '';
if($user_id){    
    $logged_script = '
        $(".thumbs-up").click(function(e) {
            e.preventDefault();
            $this = $(this);
            var productBlock = $this.closest(".product-block");
            var productId = productBlock.find(".product-id").val();
            if(!$this.hasClass("liked")){
                $.post("' . $this->request->webroot . 'api/wishlist/save", { product_id: productId},
                    function(data) {
                        var ret = $.parseJSON(data);
                        if(ret["status"] == "ok"){
                            $this.addClass("liked");
                            $this.closest(".product-list-links").find(".thumbs-down").removeClass("disliked");
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
                    }
                );
            }
        });
        
        $(".thumbs-down").click(function(e) {
            e.preventDefault();
            $this = $(this);
            var productBlock = $this.closest(".product-block");
            var productId = productBlock.find(".product-id").val();
            if(!$this.hasClass("disliked")){
                $.post("' . $this->request->webroot . 'api/dislike/save", { product_id: productId},
                    function(data) {
                        var ret = $.parseJSON(data);
                        if(ret["status"] == "ok"){
                            $this.addClass("disliked");
                            $this.closest(".product-list-links").find(".thumbs-up").removeClass("liked");
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
var showClosetPopUp = ' . $show_closet_popup . ';
$(document).ready(function(){   
    $(".fade").mosaic();
    $(".accordian-menu").find(".toggle-body").not(":first").addClass("hide");
    $(".mosaic-overlay").on("click", function(e){
        e.preventDefault();
        var productBlock = $(this).closest(".product-block");
        var productSlug = productBlock.find(".product-slug").val();
        var productId = productBlock.find(".product-id").val();
        window.location = "' . $this->request->webroot . 'product/" + productId + "/" + productSlug;
    });
    
    if(isLoggedIn() && threeItemPopup == 1){
        var notificationDetails = new Array();
        notificationDetails["msg"] = "' . $popUpMsg . '";
        notificationDetails["button"] = "<a href=\"' . $this->webroot . 'cart\" class=\"link-btn gold-btn\">Checkout</a>";
        showNotification(notificationDetails);  
    }    
    else if(isLoggedIn() && showClosetPopUp == 1){
        var notificationDetails = new Array();
        notificationDetails["msg"] = "Welcome to the Closet! Like and Dislike items to help our stylists get to know you better. Use the arrow on the side of each picture to see a new product in that category. Happy Browsing!";    
        notificationDetails["check"] = "<input type=checkbox id=hideClosetPopUp> Don\'t show me this message again"; 
        showNotification(notificationDetails);
    }
    
    $("div.product-block").mouseover(function(){
        var prod_id = $(this).find("input.category-id").val();        
        $("ul.product-categories li a").each(function(){
            if($(this).data("category_id")==prod_id)
            {
                $(this).addClass("hover-link");
                 
            }else{
                $(this).removeClass("hover-link");
            }
        });
    });
    $("div.product-block").mouseout(function(){
        $("ul.product-categories li a").removeClass("hover-link");
    });
    
    $(".toggle-tab").on("click", function(e){
        if(!$(this).find(".toggle-body").is(":visible")){
            $(this)
                .addClass("selected")
                .find(".toggle-body")
                    .slideDown(300)
                    .end()
                .siblings(".toggle-tab")
                    .not(".open-filter")
                    .removeClass("selected")
                    .find(".toggle-body")
                    .slideUp(300);
        }
        else{
            $(this)
                .not(".open-filter")
                .removeClass("selected")
                .find(".toggle-body")
                .slideUp(300);
        }
    });
    
    
    $(".brand-filter li, .color-filter li").on("click", function(e){
        e.preventDefault();
        $this = $(this);
        $this.addClass("filter-selected");    
        
        var arrBrand = new Array();
        var arrColor = new Array();
        $(".brand-filter .filter-selected").each(function(){
            arrBrand.push($(this).data("brand_id")); 
        });
        $(".color-filter .filter-selected").each(function(){
            arrColor.push($(this).data("color_id")); 
        });
        
        var strBrand = arrBrand.join("-");
        var strColor = arrColor.join("-");
        
        var filterUsed = "brand";
        if($this.closest(".toggle-body").hasClass("color-filter")){
            filterUsed = "color";    
        }
        
        if(strColor != ""){  
            window.location = "' . $this->request->webroot . 'closet/all/none/" + strColor + "/" + filterUsed;
        }
        else if(strBrand != ""){
            window.location = "' . $this->request->webroot . 'closet/all/" + strBrand + "/none/" + filterUsed;
        }
    });
    
    $(".get-related-products").on("click", function(e){
        e.preventDefault();
        var productBlock = $(this).closest(".product-block");
        var productId = productBlock.find(".product-id").val(); 
        var categoryId = productBlock.find(".product-category-id").val();
        $.post("' . $this->request->webroot . 'api/similar", { productId: productId, categoryId: categoryId },
           function(data) {
                var ret = $.parseJSON(data);
                if(ret["status"] == "ok"){
                    var entity = ret["product"];
                    productBlock.find(".product-id").val(entity["Entity"]["id"]);
                    productBlock.find(".product-slug").val(entity["Entity"]["slug"]);   
                    productBlock.find(".product-name").text(entity["Entity"]["name"]);   
                    productBlock.find(".product-brand").text(entity["Brand"]["name"]); 
                    productBlock.find(".product-price").text("$" + entity["Entity"]["price"]);
                    productBlock.find(".btn-buy").attr({href: "' . $this->request->webroot . 'product/" + entity["Entity"]["id"] + "/" + entity["Entity"]["slug"]});
                    
                    if(entity["Wishlist"]){
                        if(entity["Wishlist"]["id"]){
                            productBlock.find(".thumbs-up").addClass("liked");
                        }
                        else{
                            productBlock.find(".thumbs-up").removeClass("liked");
                        }
                        if(entity["Dislike"]["id"]){
                            productBlock.find(".thumbs-down").addClass("disliked");
                        }
                        else{
                            productBlock.find(".thumbs-down").removeClass("disliked");
                        }
                    }
                    
                    var productImage = productBlock.find(".product-image");
                    productImage.slideUp(300, function(){  
                        if(typeof(entity["Image"]) != "undefined" && entity["Image"].length > 0){
                            productImage.attr({src : "' . $this->request->webroot . "products/resize/" . '" + entity["Image"][0]["name"] + "/158/216", alt: entity["Entity"]["name"]});
                        }
                        else{
                            productImage.attr({src : "' . $this->request->webroot . 'img/image_not_available-small.png", alt: entity["Entity"]["name"]});
                        }
                        if (productImage.complete) {
                            $(this).slideDown(400);
                        } else {
                            $(this).load(function() {
                                $(this).slideDown(400);
                            });
                        }
                    });
                }
           }
        );
         
    });
    
    $("#notification-box").on("change", "#hideClosetPopUp", function(e){
        var hidePopUp = $(this).is(":checked") ? "hide" : "show";
        
        $.ajax({
            url: "' . $this->webroot . 'api/toggleClosetPopup/" + hidePopUp,
            type: "POST",
            data: {},
            success: function(data){
                
            }
        });
    });
    
    ' . $logged_script . '
});
';

$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->script("mosaic.1.0.1.min.js", array('inline' => false));

$meta_description = 'Show your support and desire to be an SRS member by sporting one of our iPhones/iPad cases!';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>
<div class="container content inner">	
    <div class="sixteen columns text-center">
        <h1>Lookbooks</h1>
    </div>
    <div class="fifteen offset-by-half columns omega">
        <div class="three columns alpha">
            <div class="product-filter-menu">
                <ul class="accordian-menu">
                    <li class="toggle-tab selected open-filter"><span class="filter-block">Categories</span>
                        <ul class="toggle-body product-categories">
                        <?php foreach ($categories as $category): ?>
                            <li><a href="<?php echo $this->request->webroot; ?>closet/<?php echo $category['Category']['slug']; ?>" <?php echo $category_slug == $category['Category']['slug'] ? "class='active-link'" : ""; ?>  data-category_id=<?php echo $category['Category']['id']; ?> ><?php echo $category['Category']['name']; ?></a>
                        <?php endforeach; ?>
                        </ul>
                    </li>
                    <li class="toggle-tab"><span class="filter-block">Brand</span>
                        <ul class="toggle-body brand-filter hide">
                        <?php if($brands) : ?>
                            <?php foreach($brands as $brand) : ?>
                                <li data-brand_id="<?php echo $brand['Brand']['id']; ?>"><?php echo $brand['Brand']['name']; ?></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </ul>
                    </li>
                    <li class="toggle-tab"><span class="filter-block">Color</span>
                        <ul class="toggle-body color-filter hide">
                        <?php if($colors) : ?>
                            <?php foreach($colors as $color) : ?>
                                <li data-color_id="<?php echo $color['Color']['id']; ?>"><?php echo $color['Color']['name']; ?></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </ul>
                    </li>
                </ul>
            </div><br />
        </div>
        <div class="twelve columns omega product-listing">
            <div class="product-top-offset"></div>
            <img src="<?php echo $this->request->webroot; ?>img/lb.jpg" class="fadein-image max-width-adj" />
            
            <table class="lb-products">
                <thead>                    
                    <th width="15%"></th>
                    <th width="55%"></th>
                    <th width="30%"></th>
                </thead>
                
                <tbody>
                    <tr class="first">
                        
                        <td class="v-top product-thumb text-center"><img src="<?php echo $this->request->webroot; ?>img/lb-thumb.jpg" /></td>
                        <td class="v-top">
                            <h6>Stone Rose Tie</h6>
                            <small class="description">Stone Rose Neck Tie</small>
                        </td>
                        <td class="like-dislike-links">
                            <a href="" class="thumbs-up"></a>                        
                            <a class="link-btn gold-btn lb-to-cart">ADD TO CART</a>
                            <a href="" class="thumbs-down"></a> 
                        </td>
                    </tr>
                    
                    <tr>
                        
                        <td class="v-top product-thumb text-center"><img src="<?php echo $this->request->webroot; ?>img/lb-thumb.jpg" /></td>
                        <td class="v-top">
                            <h6>Stone Rose Tie</h6>
                            <small class="description">Stone Rose Neck Tie</small>
                        </td>
                        <td class="like-dislike-links">
                            <a href="" class="thumbs-up"></a>                        
                            <a class="link-btn gold-btn lb-to-cart">ADD TO CART</a>
                            <a href="" class="thumbs-down"></a> 
                        </td>
                    </tr>
                    <tr>
                        
                        <td class="v-top product-thumb text-center"><img src="<?php echo $this->request->webroot; ?>img/lb-thumb.jpg" /></td>
                        <td class="v-top">
                            <h6>Stone Rose Tie</h6>
                            <small class="description">Stone Rose Neck Tie</small>
                        </td>
                        <td class="like-dislike-links">
                            <a href="" class="thumbs-up"></a>                        
                            <a class="link-btn gold-btn lb-to-cart">ADD TO CART</a>
                            <a href="" class="thumbs-down"></a> 
                        </td>
                    </tr>
                    <tr>
                        
                        <td class="v-top product-thumb text-center"><img src="<?php echo $this->request->webroot; ?>img/lb-thumb.jpg" /></td>
                        <td class="v-top">
                            <h6>Stone Rose Tie</h6>
                            <small class="description">Stone Rose Neck Tie</small>
                        </td>
                        <td class="like-dislike-links">
                            <a href="" class="thumbs-up"></a>                        
                            <a class="link-btn gold-btn lb-to-cart">ADD TO CART</a>
                            <a href="" class="thumbs-down"></a> 
                        </td>
                    </tr>
                </tbody>
            </table> 
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="sixteen columns">
        
    </div>
</div>