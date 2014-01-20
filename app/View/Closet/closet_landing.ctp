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
var lifestyles = ' . json_encode($lifestyles) . ';
var threeItemPopup = ' . $show_three_item_popup. ';
var showClosetPopUp = ' . $show_closet_popup . ';

function highLightCategory(prod_id, parent_id){
    if(prod_id == parent_id){
        $("ul.product-categories li a").each(function(){
            if($(this).data("category_id")==prod_id)
            {
                $(this).addClass("hover-link");
                 
            }else{
                $(this).removeClass("hover-link");
            }
        });
    }
    else{
        $("ul.product-categories li a").each(function(){
            if($(this).data("category_id")== parent_id)
            {
                $(this).closest("li").find(".product-subcategories").eq(0).stop(false, false).slideDown(300);
                 
            }
            if($(this).data("category_id")==prod_id)
            {
                $(this).addClass("hover-link");
                 
            }else{
                $(this).removeClass("hover-link");
            }
        });        
    }     
}

$(document).ready(function(){   
    
    /**
     * Check if Lookbook slider needs to be shown. If yes setup the fancybox and trigger the action 
     */
     
    //Setup the Fancybox plugin for the Lifestyle image popup
    $(".fancybox").fancybox({ 
        afterClose : function() {
	       setCookie("showLifeStyle",1,60);   
        },  
		helpers: {
			title : {
				type : "over"
			},
			overlay : {
				speedOut : 1000
			},
		},
	}); 
    var showLifeStyle=getCookie("showLifeStyle");
    if (showLifeStyle == null || showLifeStyle == ""){
        
        // Delay the trigger to open the lookbook slider
        setTimeout(function(){
            $(".fancybox").eq(0).trigger("click");    
        }, 1000);
    }
    
    if(isLoggedIn() && threeItemPopup == 1){
        var notificationDetails = new Array();
        notificationDetails["msg"] = "' . $popUpMsg . '";
        notificationDetails["button"] = "<a href=\"' . $this->webroot . 'cart\" class=\"link-btn gold-btn\">Checkout</a>";
        showNotification(notificationDetails);  
    }    
    else if(showLifeStyle != null && showLifeStyle != ""){
        var closetInfo=getCookie("closetInfo");
        if (closetInfo==null || closetInfo==""){
            $.blockUI({message: $("#closetinfo-box"),css:{top: $(window).height()/2 - $("#closetinfo-box").height()/2}});
            $(".blockOverlay").click($.unblockUI);
        }
    }
    
    
    //Enable the Mosaic plugin for the product blocks 
    $(".fade").mosaic();
    
    //
    $(".mosaic-overlay").on("click", function(e){
        e.preventDefault();
        if($(this).hasClass("lifestyle-overlay")){
            $(".fancybox").eq(0).trigger("click");        
        }
        else{
            window.location = $(this).closest(".product-block").find(".btn-buy").attr("href");
            
        }
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
    
    /**
     * Hide Closet Popup when user opts out.
     */
    $("#hide-closet-popup").on("change", function(e){
        e.preventDefault();
        if($(this).is(":checked")){
            setCookie("closetInfo",1,60);     
        }
        else{
            deleteCookie("closetInfo");     
        }  
    });
    
    
    /**
     * Add event for product block hover. When a product is hovered highlight its category on the left sidebar.
     */
    $("div.product-block").hover(
        function(){
            var prod_id = $(this).find("input.category-id").val();
            var parent_id = $(this).find("input.parent-category-id").val();
            highLightCategory(prod_id, parent_id);    
        },
        function(){
            $("ul.product-categories li a").removeClass("hover-link");
            $(".product-subcategories").not(".product-subsubcategories").stop(false, false).slideUp(300);    
        }
    );

    
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

        if($(this).hasClass("similar-lookbooks")){
            var currentLifestyle = $(".lifestyle-id").val();
            if(currentLifestyle == lifestyles[lifestyles.length-1]["Lifestyle"]["id"]){
                
            }
            else{
                for(var i = 0; i < lifestyles.length; i++){
                    if(lifestyles[i]["Lifestyle"]["id"] == currentLifestyle){
                        nextLifestyle = i+1;
                        $(".lifestyle-id").val(lifestyles[nextLifestyle]["Lifestyle"]["id"]);
                        var lifestyleBlock = $(this).closest(".product-block");
                        lifestyleBlock.find(".btn-buy").attr({href: "' . $this->request->webroot . 'lookbooks/detail/" + lifestyles[nextLifestyle]["Lifestyle"]["id"] + "/" + lifestyles[nextLifestyle]["slug"]});
                        lifestyleBlock.find(".product-image").slideUp(300).attr({src : "' . $this->request->webroot . "lookbooks/resize/" . '" + lifestyles[nextLifestyle]["Lifestyle"]["image"] + "/158/216", alt: "Lookbooks"}).slideDown(400);
                        break;
                    }
                }
            }
        }
        else{
            var productBlock = $(this).closest(".product-block");
            var productId = productBlock.find(".product-id").val(); 
            var categoryId = productBlock.find(".parent-category-id").val();
            $.post("' . $this->request->webroot . 'api/similar", { productId: productId, categoryId: categoryId },
               function(data) {
                    var ret = $.parseJSON(data);
                    if(ret["status"] == "ok"){
                        var entity = ret["product"];
                        productBlock.find(".product-id").val(entity["Entity"]["id"]);
                        productBlock.find(".product-slug").val(entity["Entity"]["slug"]);   
                        productBlock.find(".product-name").text(entity["Entity"]["name"]);   
                        productBlock.find(".product-brand").text(entity["Brand"]["name"]); 
                        productBlock.find(".category-id").val(entity["Category"]["category_id"]);
                        var prod_id = productBlock.find(".category-id").val();
                        highLightCategory(prod_id, categoryId);
                        
                        var productPrice = (entity["Entity"]["price"]> 0) ? "$" + entity["Entity"]["price"] : "Price on request";
                        productBlock.find(".product-price").text(productPrice);
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
            )
        }
         
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
$this->Html->script("jquery.fancybox.js", array('inline' => false));
$this->Html->script('cookie.js', array('inline' => false));
$this->Html->script("//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js", array('safe' => true, 'inline' => false));
echo $this->Html->css("jquery.fancybox.css");
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->script("mosaic.1.0.1.min.js", array('inline' => false));

$meta_description = 'Show your support and desire to be an SRS member by sporting one of our iPhones/iPad cases!';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>
<div class="content-container">
    <div class="eleven columns container content inner">	
        <div class="twelve columns text-center page-heading">
            <h1>The Closet</h1>
        </div>
        <div class="twelve columns">
            <div class="two columns alpha side-filter left">
                <div class="product-filter-menu">
                    <ul class="accordian-menu">
                        <li class="toggle-tab selected open-filter"><span class="filter-block">Categories</span>
                            <ul class="toggle-body product-categories">
                            <?php foreach ($categories as $category): ?>
                                <li <?php echo ($category['Category']['slug'] == 'seasonal' || $category['Category']['slug'] == 'lookbooks') ? 'class="highlighted-cat"' : '';?>>
                                <?php if($category['Category']['slug'] == 'seasonal' || $category['Category']['slug'] == 'lookbooks') : ?>
                                    <span class="cuff-left"><img src="<?php echo $this->webroot; ?>img/icon_left.png" /></span>
                                    <span class="cuff-right"><img src="<?php echo $this->webroot; ?>img/icon_right.png" /></span>
                                <?php endif; ?>
                                
                                <?php if($category['Category']['slug'] == "lookbooks") : ?>
                                    <a href="<?php echo $this->request->webroot; ?>lookbooks/" class="lookbook-cat <?php echo $category_slug == $category['Category']['slug'] ? "active-link" : ""; ?>"  data-category_id=<?php echo $category['Category']['id']; ?> ><?php echo $category['Category']['name']; ?></a>
                                <?php else : ?>
                                    <a href="<?php echo $this->request->webroot; ?>closet/<?php echo $category['Category']['slug']; ?>" <?php echo $category_slug == $category['Category']['slug'] ? "class='active-link'" : ""; ?>  data-category_id=<?php echo $category['Category']['id']; ?> ><?php echo $category['Category']['name']; ?></a>
                                <?php endif; ?>
                                
                                <?php if ($category['children']) : ?>
                                    <ul class="product-subcategories hide">
                                        <?php foreach ($category['children'] as $subcategory): ?>
                                            <li><a href="<?php echo $this->request->webroot; ?>closet/<?php echo $subcategory['Category']['slug']; ?>" <?php echo $category_slug == $subcategory['Category']['slug'] ? "class='active-link'" : ""; ?> data-category_id=<?php echo $subcategory['Category']['id']; ?> ><?php echo $subcategory['Category']['name']; ?></a>
                                                <?php if ($subcategory['children']) : ?>
                                                    <ul class="product-subcategories product-subsubcategories">
                                                        <?php foreach ($subcategory['children'] as $subsubcategory): ?> 
                                                            <li><a href="<?php echo $this->request->webroot; ?>closet/<?php echo $subsubcategory['Category']['slug']; ?>" <?php echo $category_slug == $subsubcategory['Category']['slug'] ? "class='active-link'" : ""; ?> data-category_id=<?php echo $subsubcategory['Category']['id']; ?> ><?php echo $subsubcategory['Category']['name']; ?></a></li>    
                                                        <?php endforeach; ?>
                                                    </ul>       
                                                <?php endif; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                                
                                </li>
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
                                    <li data-color_id="<?php echo $color['Colorgroup']['id']; ?>"><?php echo $color['Colorgroup']['name']; ?></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </ul>
                        </li>
                    </ul>
                </div><br />
            </div>
            <div class="ten columns omega product-listing right">
                <!--<div class="product-top-offset"></div>-->
                <?php if($entities) : ?>
                    <?php foreach($entities as $entity) : ?>
                        <?php if($entity['Category']['parent_cat'] != $lookbook_id) : ?>
                            <div class="product-box">
                                <div class="product-block"> 
                                    <a href="" class="get-related-products"></a>
                                    <input type="hidden" value="<?php echo $entity['Entity']['slug']; ?>" class="product-slug">
                                    <input type="hidden" value="<?php echo $entity['Entity']['id']; ?>" class="product-id">
                                    <input type="hidden" value="<?php echo $entity['Category']['category_id']; ?>" class="category-id">
                                    <input type="hidden" value="<?php echo $entity['Category']['parent_cat']; ?>" class="parent-category-id">
                                    <div class="product-list-image mosaic-block fade">
                                        <div class="mosaic-overlay">
                            				<div class="mini-product-details">
                        					   <span class="product-price"><?php echo ($entity['Entity']['price'] > 0) ? "$" . $entity['Entity']['price'] : "Price on request"; ?></span>
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
                        <?php else : ?>
                            <?php if($lifestyles) : ?>
                                <div class="product-box">
                                    <div class="product-block"> 
                                        <a href="" class="get-related-products similar-lookbooks"></a>
                                        <input type="hidden" value="<?php echo $lifestyles[0]['Lifestyle']['id']; ?>" class="lifestyle-id">
                                        <div class="product-list-image lookbooks-block mosaic-block fade">
                                            <span class="highlight-lookbook"></span>
                                            <div class="mosaic-overlay lifestyle-overlay">
                                				<div class="mini-product-details">
                            					   <span class="product-name">Lookbooks</span>
                                				</div>
                                			</div>
                                            <div class="mosaic-backdrop">
                                                <img src="<?php echo $this->webroot. "lookbooks/resize/" . $lifestyles[0]['Lifestyle']['image']; ?>/158/216" alt="Lifestyle" class="product-image fadein-image" />
                                            </div>
                                        </div>
                                        <div class="product-list-links">
                                        <a href="<?php echo $this->request->webroot . 'lookbooks/detail/' . $lifestyles[0]['Lifestyle']['id'] . '/' . $lifestyles[0]['Lifestyle']['slug']; ?>" class="btn-buy">Buy</a>
                                        </div>
                                    </div>
                                </div>    
                            <?php endif; ?> 
                        <?php endif; ?>
                    <?php endforeach; ?>
                        
                       
                <?php endif; ?>
            </div>
        </div>
        <div class="clear-fix"></div>
        <div class="fourteen columns details-margin row">
            <div class="lifestyle-images">
                <?php if($lifestyles && count($lifestyles) > 0) : ?>
                    <?php foreach($lifestyles as $style) : ?>
                        <a class="fancybox" data-fancybox-group="lifestyles" title="<?php echo $style['Lifestyle']['caption']; ?>" href="#lifestyle<?php echo $style['Lifestyle']['id']; ?>"></a>
                        <div class="hide"><div class="fancybox-data-box" id="lifestyle<?php echo $style['Lifestyle']['id']; ?>"><a href="<?php echo $this->webroot . 'lookbooks/detail/' . $style['Lifestyle']['id'] . '/' . $style['Lifestyle']['slug'];?>"><img src="<?php echo $this->webroot;?>files/lifestyles/<?php echo $style['Lifestyle']['image']; ?>"></a><a href="<?php echo $this->webroot . 'lookbooks/detail/' . $style['Lifestyle']['id'] . '/' . $style['Lifestyle']['slug'];?>" class="btn-buy-look link-btn gold-btn">Get The Look</a></div></div>
                    <?php endforeach; ?>
                <?php endif; ?> 
                
            </div>
        </div>
    </div>
</div>
<div id="closetinfo-box" class="box-modal notification-box hide">
    <div class="box-modal-inside">
        <a class="notification-close info-popup-close" href=""></a>
        <div class="popup-info-text">
            <p><strong>The Closet</strong>: Browse our curated collection of products, purchase or like and dislike items to help our stylists get to know you better. We've organized your closet. Each box represents an essential piece of your wardrobe. To learn more about the brands and to appreciate them as we do, check out <a href="<?php echo $this->webroot; ?>company/brands">Our Brands</a> page and what the <a href="http://blog.savilerowsociety.com/testimonials-of-our-favorite-brands/">Press</a> is saying.</p>

            <p><strong>SRS Lookbooks</strong> are a product of the creativity of our favorite photographer, Greg Buyalos and of our premier stylists. Our winter photo shoots were styled by Joey Glazer. Like what you see? Built in convenience allows you to click and buy straight from the image!</p>
        </div>  
        <div class="popup-info-sign text-center">
            <img src="<?php echo $this->webroot; ?>img/lisa_signature.png" />
        </div>  
        <div class="popup-info-text text-left">
            <p>
                <input type="checkbox" id="hide-closet-popup" />&nbsp; Got it! Please don't show me this again
            </p>
        </div> 
    </div>
</div>