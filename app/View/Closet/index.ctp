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
var filter = "' . $filter_used . '" 
$(document).ready(function(){
    $(".fade").mosaic();
    $(".accordian-menu").find(".toggle-body").not(":first").addClass("hide");
    
    if(filter == "color"){
        $(".color-filter").removeClass("hide").addClass("selected");    
    }
    else if(filter == "brand"){
        $(".brand-filter").removeClass("hide").addClass("selected");    
    }
    
    
    
    $("div.product-block").mouseover(function(){
        var prod_id = $(this).find("input.category-id").val();
        var parent_prod_id = $(this).find("input.parent-category-id").val();
        var flag = false;        
        $("ul.product-categories li a").each(function(){
            if($(this).data("category_id")==prod_id)
            {
                $(this).addClass("hover-link");
                flag = true;          
            }
        });
        
        if(!flag && prod_id != parent_prod_id){
            $("ul.product-categories li a").each(function(){
                if($(this).data("category_id")==parent_prod_id)
                {
                    $(this).addClass("hover-link");
                    flag = true;          
                }
            });    
        }
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
    
    ' . $logged_script . '
});'; 

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
                    <li class="toggle-tab selected open-filter"><span class="filter-block"><a href="<?php echo $this->webroot; ?>closet">Categories</a></span>
                        <ul class="toggle-body product-categories">
                        <?php foreach ($categories as $category): ?>
                            <li <?php echo ($parent_id && $parent_id == $category['Category']['id']) ? "class='cat-filter-selected'" : ""; ?>>
                            <a href="<?php echo $this->request->webroot; ?>closet/<?php echo $category['Category']['slug']; ?>" <?php echo $category_slug == $category['Category']['slug'] ? "class='active-link'" : ""; ?> data-category_id=<?php echo $category['Category']['id']; ?> ><?php echo $category['Category']['name']; ?></a>
                                <?php if ($category['children'] && $parent_id && $parent_id == $category['Category']['id']) : ?>
                                    <ul class="product-subcategories">
                                        <?php foreach ($category['children'] as $subcategory): ?>
                                            <li><a href="<?php echo $this->request->webroot; ?>closet/<?php echo $subcategory['Category']['slug']; ?>" <?php echo $category_slug == $subcategory['Category']['slug'] ? "class='active-link'" : ""; ?> data-category_id=<?php echo $subcategory['Category']['id']; ?> ><?php echo $subcategory['Category']['name']; ?></a>
                                                <?php if ($subcategory['children']) : ?>
                                                    <ul class="product-subcategories">
                                                        <?php foreach ($subcategory['children'] as $subsubcategory): ?> 
                                                            <li><a href="<?php echo $this->request->webroot; ?>closet/<?php echo $subsubcategory['Category']['slug']; ?>" <?php echo $category_slug == $subsubcategory['Category']['slug'] ? "class='active-link'" : ""; ?> data-category_id=<?php echo $subsubcategory['Category']['id']; ?> ><?php echo $subsubcategory['Category']['name']; ?></a></li>    
                                                        <?php endforeach; ?>
                                                    </ul>       
                                                <?php endif; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            <span class="filter-cross"></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li class="toggle-tab"><span class="filter-block">Brand</span>
                        <ul class="toggle-body brand-filter">
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
                        <ul class="toggle-body color-filter">
                        <?php if($colors) : ?>
                            <?php foreach($colors as $color) : ?>
                                <?php if(in_array($color['Color']['id'], $color_list)) : ?>
                                    <li class="filter-selected" data-color_id="<?php echo $color['Color']['id']; ?>"><?php echo $color['Color']['name']; ?></li>
                                <?php else : ?>
                                    <li data-color_id="<?php echo $color['Color']['id']; ?>"><?php echo $color['Color']['name']; ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
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
        <div class="twelve columns omega product-listing">
            <div class="product-top-offset"></div>
            <?php if($entities) : ?>
                <?php foreach($entities as $entity) : ?>
                    <div class="three columns alpha row">
                        <div class="product-block">
                            <input type="hidden" value="<?php echo $entity['Entity']['slug']; ?>" class="product-slug">
                            <input type="hidden" value="<?php echo $entity['Entity']['id']; ?>" class="product-id">
                            <input type="hidden" value="<?php echo $entity['Category']['category_id']; ?>" class="category-id">
                            <input type="hidden" value="<?php echo $entity['Category']['parent_cat']; ?>" class="parent-category-id">
                            <div class="product-list-image mosaic-block fade">
                                <div class="mosaic-overlay">
                    				<div class="mini-product-details">
                					   <span>$<?php echo $entity['Entity']['price']; ?></span>
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
                <h5 class="text-center">Sorry! No products are available for this category.</h5>
            <?php endif; ?>
            <div class="clear"></div>
            <div class="pagination">
                <?php
                echo $this->Paginator->prev('>', array(), null, array('class' => 'prev disabled'));
                echo $this->Paginator->numbers(array('separator' => '', 'class' => 'page-links'));
                echo $this->Paginator->next('>', array(), null, array('class' => 'next disabled'));
                ?>
            </div>
        </div>
        
    </div>
    <div class="clearfix"></div>
    <div class="sixteen columns">
        <br /><br /><br />
    </div>
</div>