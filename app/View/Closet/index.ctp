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
var filter = "' . $filter_used . '";
var checkCount = '.$check_count.'; 

function highLightCategory(prod_id, parent_id){
    if(prod_id == parent_id){
        $("ul.product-categories li a").each(function(){
            if($(this).data("category_id")==prod_id) {
                $(this).addClass("hover-link");
            }
            else {
                $(this).removeClass("hover-link");
            }
        });
    }
    else{
        $("ul.product-categories li a").each(function(){
            if($(this).data("category_id")== parent_id)
            {
                $(this).closest("li").find(".product-subcategories").eq(0).stop(false, true).slideDown(300);
                 
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
    if(checkCount == 1){
        signUp();
    } 
    
    $(".fade").mosaic();
    $(".accordian-menu").find(".toggle-body").not(":first").addClass("hide");
    
    if($(".active-link").closest("ul").hasClass("product-subsubcategories")){
        $(".active-link").closest("ul").closest("li").addClass("active-link-parent")
                        .closest("ul").closest("li").addClass("active-link-parent");
        ;    
    }

    if(filter == "color"){
        $(".color-filter").removeClass("hide").addClass("selected");    
    }
    else if(filter == "brand"){
        $(".brand-filter").removeClass("hide").addClass("selected");    
    }
    
    $("div.product-block").hover(
        function(){
            var prod_id = $(this).find("input.category-id").val();
            var parent_id = $(this).find("input.parent-category-id").val();
            console.log(prod_id);
            console.log(parent_id);
            highLightCategory(prod_id, parent_id);    
        },
        function(){
            $("ul.product-categories li a").removeClass("hover-link");
            $(".product-subcategories").not(".product-subsubcategories").each(function(){
                if($(this).closest(".cat-filter-selected").length == 0){
                    $(this).stop(false, false).slideUp(300);
                }    
            });    
        }
    );
    
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
    $(".mosaic-overlay").on("click", function(e){
        e.preventDefault();
        var productBlock = $(this).closest(".product-block");
        var productSlug = productBlock.find(".product-slug").val();
        var productId = productBlock.find(".product-id").val();
        window.location = "' . $this->request->webroot . 'product/" + productId + "/" + productSlug;
    });
      
    $(".brand-filter li, .color-filter li").on("click", function(e){
        e.preventDefault();
        $this = $(this);
        if($this.hasClass("filter-selected")){
            $this.removeClass("filter-selected");    
        }
        else{
            $this.addClass("filter-selected");    
        }
        
        var filterUsed = "brand";
        if($this.closest(".toggle-body").hasClass("color-filter")){
            filterUsed = "color";    
        }
        
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
        
        if(strBrand == "" && strColor == "" && "' . $category_slug . '" != "all"){
            window.location = "' . $this->request->webroot . 'closet/' . $category_slug . '/none/none/" + filterUsed;    
        }
        else if(strBrand == "" && strColor == "" && "' . $category_slug . '" == "all"){
            window.location = "' . $this->request->webroot . 'closet";    
        }
        else if(strColor == ""){
            window.location = "' . $this->request->webroot . 'closet/' . $category_slug . '/" + strBrand + "/none/" + filterUsed;  
        }
        else if(strBrand == ""){
            window.location = "' . $this->request->webroot . 'closet/' . $category_slug . '/none/" + strColor + "/" + filterUsed;
        }
        else{
            window.location = "' . $this->request->webroot . 'closet/' . $category_slug . '/" + strBrand + "/" + strColor + "/" + filterUsed;
        }
        
    });
    
    $(".filter-cross").on("click", function(e){
        e.preventDefault();
        window.location = "' . $this->webroot . 'closet";    
    });

    $(".pagination .prev.disabled").on("click", function(){
        var activeCat = $(".active-link").closest("li");
        if(activeCat.parent().hasClass("product-subcategories")){
            if(activeCat.prev("li").length){
                location = activeCat.prev("li").find("a").attr("href");    
            }
            else{
                if(activeCat.closest(".cat-filter-selected").prev("li").length){
                    location = activeCat.closest(".cat-filter-selected").prev("li").find("a").attr("href");
                }
            }
        }
        else if(activeCat.parent().hasClass("product-categories")){
            if(activeCat.prev("li").length){
                location = activeCat.prev("li").find("a").attr("href");    
            }
            else{
                location = $(".product-categories li").last().find("a").attr("href");    
            }
        }
    });
    
    $(".pagination .next.disabled").on("click", function(){
        var activeCat = $(".active-link").closest("li");
        if(activeCat.parent().hasClass("product-subcategories")){
            if(activeCat.next("li").length){
                location = activeCat.next("li").find("a").attr("href");    
            }
            else{
                if(activeCat.closest(".cat-filter-selected").next("li").length){
                    location = activeCat.closest(".cat-filter-selected").next("li").find("a").attr("href");
                }
            }
        }
        else if(activeCat.parent().hasClass("product-categories")){
            if(activeCat.next("li").length){
                location = activeCat.next("li").find("a").attr("href");    
            }
            else{
                location = $(".product-categories li").first().find("a").attr("href");    
            }
        }    
    });

    
    ' . $logged_script . '
});'; 

$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->script("mosaic.1.0.1.min.js", array('inline' => false));
$this->Html->script("//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js", array('safe' => true, 'inline' => false));

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
                        <li class="toggle-tab selected open-filter"><span class="filter-block"><a href="<?php echo $this->webroot; ?>closet">Categories</a></span>
                            <ul class="toggle-body product-categories">
                            <?php foreach ($categories as $category): ?>
                                <li class="<?php echo ($parent_id && $parent_id == $category['Category']['id']) ? "cat-filter-selected" : ""; ?> <?php echo ($category['Category']['slug'] == 'seasonal' || $category['Category']['slug'] == 'lookbooks') ? 'highlighted-cat' : '';?>">
                                <?php if($category['Category']['slug'] == 'seasonal' || $category['Category']['slug'] == 'lookbooks') : ?>
                                    <span class="cuff-left"><img src="<?php echo $this->webroot; ?>img/icon_left.png" /></span>
                                    <span class="cuff-right"><img src="<?php echo $this->webroot; ?>img/icon_right.png" /></span>
                                <?php endif; ?>
                                    <?php if($category['Category']['slug'] == "lookbooks") : ?>
                                        <a href="<?php echo $this->request->webroot; ?>lookbooks/" class="lookbook-cat <?php echo $category_slug == $category['Category']['slug'] ? "active-link" : ""; ?>" data-category_id=<?php echo $category['Category']['id']; ?> ><?php echo $category['Category']['name']; ?></a>
                                    <?php else : ?>
                                        <a href="<?php echo $this->request->webroot; ?>closet/<?php echo $category['Category']['slug']; ?>" <?php echo $category_slug == $category['Category']['slug'] ? "class='active-link'" : ""; ?> data-category_id=<?php echo $category['Category']['id']; ?> ><?php echo $category['Category']['name']; ?></a>
                                    <?php endif; ?>


                                    <?php if ($category['children']) : ?>
                                        <ul class="product-subcategories <?php echo ($parent_id && $parent_id == $category['Category']['id']) ? "" : "hide"; ?>">
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
                                <?php if($category['Category']['slug'] != 'seasonal' && $category['Category']['slug'] != 'lookbooks') : ?>
                                    <span class="filter-cross"></span>
                                <?php endif; ?>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li class="toggle-tab"><span class="filter-block">Brand</span>
                            <ul class="toggle-body brand-filter hide">
                            <?php if($brands) : ?>
                                <?php foreach($brands as $brand) : ?>
                                    <?php if(in_array($brand['Brand']['id'], $brand_list)) : ?>
                                        <li class="filter-selected" data-brand_id="<?php echo $brand['Brand']['id']; ?>"><?php echo $brand['Brand']['name']; ?></li>
                                    <?php else : ?>
                                        <li data-brand_id="<?php echo $brand['Brand']['id']; ?>"><?php echo $brand['Brand']['name']; ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </ul>
                        </li>
                        <li class="toggle-tab"><span class="filter-block">Color</span>
                            <ul class="toggle-body color-filter hide">
                            <?php if($colors) : ?>
                                <?php foreach($colors as $color) : ?>
                                    <?php if(in_array($color['Colorgroup']['id'], $color_list)) : ?>
                                        <li class="filter-selected" data-color_id="<?php echo $color['Colorgroup']['id']; ?>"><?php echo $color['Colorgroup']['name']; ?></li>
                                    <?php else : ?>
                                        <li data-color_id="<?php echo $color['Colorgroup']['id']; ?>"><?php echo $color['Colorgroup']['name']; ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <?php if($entities && strtolower($category_slug) != "lookbooks") : ?>
                <div class="sort-block">
                    <?php
                        $sortKey = $this->Paginator->sortKey();
                        $sortDir = $this->Paginator->sortDir();
                    ?>
                    <?php if( $sortKey == 'price' && $sortDir == 'asc') : ?>
                        <strong>Sort By Price:</strong> <span class="sort-selected">Low to High</span> | <?php echo $this->Paginator->sort('price','High to Low',array('direction' => 'desc')); ?>
                    <?php elseif ($sortKey == 'price' && $sortDir = 'desc') : ?>
                        <strong>Sort By Price:</strong> <?php echo $this->Paginator->sort('price','Low to High',array('direction' => 'asc')); ?> | <span class="sort-selected">High to Low</span>
                    <?php else : ?>
                        <strong>Sort By Price:</strong> <?php echo $this->Paginator->sort('price','Low to High',array('direction' => 'asc')); ?> | <?php echo $this->Paginator->sort('price','High to Low',array('direction' => 'desc')); ?>
                    <?php endif; ?> 
                </div>
            <?php endif; ?>
            <div class="ten columns omega product-listing right">
                <!--<div class="product-top-offset"></div>-->
                <?php if($entities && strtolower($category_slug) != "lookbooks") : ?>
                    <?php foreach($entities as $entity) : ?>
                        <div class="product-box">
                            <div class="product-block">
                                <input type="hidden" value="<?php echo $entity['Entity']['slug']; ?>" class="product-slug">
                                <input type="hidden" value="<?php echo $entity['Entity']['id']; ?>" class="product-id">
                                <input type="hidden" value="<?php echo $entity['Category']['category_id']; ?>" class="category-id">
                                <input type="hidden" value="<?php echo $entity['Category']['parent_cat']; ?>" class="parent-category-id">
                                <div class="product-list-image mosaic-block fade">
                                    <div class="mosaic-overlay">
                        				<div class="mini-product-details">
                    					   <span><?php echo ($entity['Entity']['price'] > 0) ? "$" . $entity['Entity']['price'] : "Price on request"; ?></span>
                    					   <span><?php echo $entity['Entity']['name']; ?></span>
                    					   <span><?php echo $entity['Brand']['name']; ?></span>
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
                <?php else : ?>
                <div class="product-top-offset"></div>
                <div class="closet-sorry">
                    <h4 class="text-center">SORRY!</h4> 
                    <h5>There are no products available for this category.</h5>            
                </div>                
                <?php endif; ?>
                
                <?php if($entities && count($brand_list) == 0 && count($color_list) == 0 && $category_slug != "all") : ?>
                    <div class="clear"></div>
                    <div class="pagination">
                        <?php
                        echo $this->Paginator->prev('>', array(), null, array('class' => 'prev disabled'));
                        echo $this->Paginator->numbers(array('separator' => '', 'class' => 'page-links'));
                        echo $this->Paginator->next('>', array(), null, array('class' => 'next disabled'));
                        ?>
                    </div>
                <?php elseif($entities && ($this->Paginator->hasNext() || $this->Paginator->hasPrev())) : ?>
                    <div class="clear"></div>
                    <div class="pagination">
                        <?php
                        echo $this->Paginator->prev('>', array(), null, array('class' => 'prev disabled'));
                        echo $this->Paginator->numbers(array('separator' => '', 'class' => 'page-links'));
                        echo $this->Paginator->next('>', array(), null, array('class' => 'next disabled'));
                        ?>
                    </div>
                <?php endif; ?>
            </div>
            
        </div>
        <div class="clearfix"></div>
        <div class="fourteen columns details-margin row">
            
        </div>
    </div>
</div>