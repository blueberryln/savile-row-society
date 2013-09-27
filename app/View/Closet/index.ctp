<?php
$script = '
$(document).ready(function(){
    $(".fade").mosaic();
    $(".accordian-menu").find(".toggle-body").not(":first").addClass("hide");
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
                    //var notificationDetails = new Array();
                    //notificationDetails["msg"] = ret["msg"];
                    //showNotification(notificationDetails, true);
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
      
    $(".brand-filter li, .color-filter li").on("click", function(e){
        e.preventDefault();
        $this = $(this);
        if($this.hasClass("filter-selected")){
            $this.removeClass("filter-selected");    
        }
        else{
            $this.addClass("filter-selected");    
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
        
        if(strBrand == "" && strColor == ""){
            window.location = "' . $this->request->webroot . 'closet/' . $category_slug . '";    
        }
        else if(strColor == ""){
            window.location = "' . $this->request->webroot . 'closet/' . $category_slug . '/" + strBrand;
        }
        else if(strBrand == ""){
            window.location = "' . $this->request->webroot . 'closet/' . $category_slug . '/none/" + strColor;
        }
        else{
            window.location = "' . $this->request->webroot . 'closet/' . $category_slug . '/" + strBrand + "/" + strColor;
        }
        
    });
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
                    <li class="toggle-tab selected open-filter"><span>Categories</span>
                        <ul class="toggle-body product-categories">
                        <?php foreach ($categories as $category): ?>
                            <li>
                            <a href="<?php echo $this->request->webroot; ?>closet/<?php echo $category['Category']['slug']; ?>" <?php echo $category_slug == $category['Category']['slug'] ? "class='active-link'" : ""; ?> ><?php echo $category['Category']['name']; ?></a>
                            <?php if ($category['children'] && $parent_id && $parent_id == $category['Category']['id']) : ?>
                                    <ul class="product-subcategories">
                                        <?php foreach ($category['children'] as $subcategory): ?>
                                            <li><a href="<?php echo $this->request->webroot; ?>closet/<?php echo $subcategory['Category']['slug']; ?>" <?php echo $category_slug == $subcategory['Category']['slug'] ? "class='active-link'" : ""; ?> ><?php echo $subcategory['Category']['name']; ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li class="toggle-tab"><span>Brand</span>
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
                    <li class="toggle-tab"><span>Color</span>
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
        <div class="twelve columns omega product-listing">
            <div class="product-top-offset"></div>
            <?php if($entities) : ?>
                <?php foreach($entities as $entity) : ?>
                    <div class="three columns alpha row">
                        <div class="product-block">
                            <input type="hidden" value="<?php echo $entity['Entity']['slug']; ?>" class="product-slug">
                            <input type="hidden" value="<?php echo $entity['Entity']['id']; ?>" class="product-id">
                            <div class="product-list-image mosaic-block fade">
                                <div class="mosaic-overlay">
                    				<div class="mini-product-details">
                					   <span>$<?php echo $entity['Entity']['price']; ?></span>
                					   <span><?php echo $entity['Entity']['name']; ?></span>
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
                                <a href="" class="thumbs-up <?php echo ($entity['Wishlist']['id']) ? 'liked' : ''; ?>"></a>
                                <a href="<?php echo $this->request->webroot . 'product/' . $entity['Entity']['id'] . '/' . $entity['Entity']['slug']; ?>" class="btn-buy">Buy</a>
                                <a href="" class="thumbs-down <?php echo ($entity['Dislike']['id']) ? 'disliked' : ''; ?>"></a>
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