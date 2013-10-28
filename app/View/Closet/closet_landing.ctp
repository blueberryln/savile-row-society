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
    $(".fade").mosaic();
    $(".accordian-menu").find(".toggle-body").not(":first").addClass("hide");
    $(".mosaic-overlay").on("click", function(e){
        e.preventDefault();
        var productBlock = $(this).closest(".product-block");
        var productSlug = productBlock.find(".product-slug").val();
        var productId = productBlock.find(".product-id").val();
        window.location = "' . $this->request->webroot . 'product/" + productId + "/" + productSlug;
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
        <h1>The Closet</h1>
    </div>
    <div class="fifteen offset-by-half columns omega">
        <div class="three columns alpha">
            <div class="product-filter-menu">
                <ul class="accordian-menu">
                    <li class="toggle-tab selected open-filter"><span class="filter-block">Categories</span>
                        <ul class="toggle-body product-categories">
                        <?php foreach ($categories as $category): ?>
                            <li><a href="<?php echo $this->request->webroot; ?>closet/<?php echo $category['Category']['slug']; ?>" <?php echo $category_slug == $category['Category']['slug'] ? "class='active-link'" : ""; ?> ><?php echo $category['Category']['name']; ?></a>
                        <?php endforeach; ?>
                        </ul>
                    </li>
                    <li class="toggle-tab"><span class="filter-block">Brand</span>
                        <ul class="toggle-body brand-filter">
                        <?php if($brands) : ?>
                            <?php foreach($brands as $brand) : ?>
                                <li data-brand_id="<?php echo $brand['Brand']['id']; ?>"><?php echo $brand['Brand']['name']; ?></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </ul>
                    </li>
                    <li class="toggle-tab"><span class="filter-block">Color</span>
                        <ul class="toggle-body color-filter">
                        <?php if($colors) : ?>
                            <?php foreach($colors as $color) : ?>
                                <li data-color_id="<?php echo $color['Color']['id']; ?>"><?php echo $color['Color']['name']; ?></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="twelve columns omega product-listing">
            <div class="product-top-offset"></div>
            <?php if($entities) : ?>
                <?php foreach($entities as $entity) : ?>
                    <div class="three columns alpha row">
                        <div class="product-block"> 
                            <a href="" class="get-related-products"></a>
                            <input type="hidden" value="<?php echo $entity['Entity']['slug']; ?>" class="product-slug">
                            <input type="hidden" value="<?php echo $entity['Entity']['id']; ?>" class="product-id">
                            <input type="hidden" value="<?php echo $entity['Category']['category_id']; ?>" class="product-category-id">
                            <div class="product-list-image mosaic-block fade">
                                <div class="mosaic-overlay">
                    				<div class="mini-product-details">
                					   <span class="product-price">$<?php echo $entity['Entity']['price']; ?></span>
                					   <span class="product-name"><?php echo $entity['Entity']['name']; ?></span>
                					   <span class="product-brand"><?php echo $entity['Brand']['name']; ?></span>
                    				</div>
                    			</div>
                                <?php 
                                if($entity['Image']){
                                    //$img_src = $this->request->webroot . "files/products/" . $entity['Image'][0]['name'];
                                    $img_src = $this->request->webroot . 'products/resize/' . $entity['Image'][0]['name'] . '/158/216'; 
                                }
                                else{
                                    $img_src = $this->request->webroot . "img/image_not_available-small.png";
                                } 
                                ?>
                                <div class="mosaic-backdrop">
                                    <img src="<?php echo $img_src; ?>" alt="<?php echo $entity['Entity']['name']; ?>" class="product-image fadein-image" />
                                </div>
                            </div>
                            <div class="product-list-links">
                                <?php if(isset($entity['Wishlist'])) : ?>
                                    <a href="" class="thumbs-up <?php echo ($entity['Wishlist']['id']) ? 'liked' : ''; ?>"></a>
                                    <a href="<?php echo $this->request->webroot . 'product/' . $entity['Entity']['id'] . '/' . $entity['Entity']['slug']; ?>" class="btn-buy">Buy</a>
                                    <a href="" class="thumbs-down <?php echo ($entity['Dislike']['id']) ? 'disliked' : ''; ?>"></a>
                                <?php else : ?>
                                    <a href="<?php echo $this->request->webroot . 'product/' . $entity['Entity']['id'] . '/' . $entity['Entity']['slug']; ?>" class="btn-buy">Buy</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>    
            <?php endif; ?>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="sixteen columns">
        <br /><br /><br />
    </div>
</div>