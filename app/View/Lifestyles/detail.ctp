<?php
$script = '

$(document).ready(function(){   
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
    
    $(".thumbs-up").click(function(e) {
        e.preventDefault();
        $this = $(this);
        var productBlock = $this.closest(".like-dislike-links");
        var productId = productBlock.find(".product-id").val();
        if(!$this.hasClass("liked")){
            $.post("' . $this->request->webroot . 'api/wishlist/save", { product_id: productId},
                function(data) {
                    var ret = $.parseJSON(data);
                    if(ret["status"] == "ok"){
                        $this.addClass("liked");
                        productBlock.find(".thumbs-down").removeClass("disliked");
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
        var productBlock = $this.closest(".like-dislike-links");
        var productId = productBlock.find(".product-id").val();
        if(!$this.hasClass("disliked")){
            $.post("' . $this->request->webroot . 'api/dislike/save", { product_id: productId},
                function(data) {
                    var ret = $.parseJSON(data);
                    if(ret["status"] == "ok"){
                        $this.addClass("disliked");
                        productBlock.find(".thumbs-up").removeClass("liked");
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
                            <li <?php echo ($category['Category']['slug'] == 'seasonal' || $category['Category']['slug'] == 'lookbooks') ? 'class="highlighted-cat"' : '';?>>
                            <?php if($category['Category']['slug'] == 'seasonal' || $category['Category']['slug'] == 'lookbooks') : ?>
                                <span class="cuff-left"><img src="<?php echo $this->webroot; ?>img/icon_left.png" /></span>
                                <span class="cuff-right"><img src="<?php echo $this->webroot; ?>img/icon_right.png" /></span>
                            <?php endif; ?>
                            
                            <?php if($category['Category']['slug'] == "lookbooks") : ?>
                                <a href="<?php echo $this->request->webroot; ?>lookbooks/" class="lookbook-cat"  data-category_id=<?php echo $category['Category']['id']; ?> ><?php echo $category['Category']['name']; ?></a>
                            <?php else : ?>
                                <a href="<?php echo $this->request->webroot; ?>closet/<?php echo $category['Category']['slug']; ?>" data-category_id=<?php echo $category['Category']['id']; ?> ><?php echo $category['Category']['name']; ?></a>
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
        <div class="twelve columns omega product-listing">
            <div class="product-top-offset"></div>
            <div class="text-center">
                <img src="<?php echo $this->request->webroot; ?>files/lifestyles/<?php echo $lifestyle['Lifestyle']['image']; ?>" class="fadein-image max-width-adj" />
            </div>
            
            <?php if(count($entities) > 0) : ?>
            <table class="lb-products">
                <thead>    
                    <tr>               
                        <th width="15%"></th>
                        <th width="55%"></th>
                        <th width="30%"></th>
                    </tr> 
                </thead>
                
                <tbody>
                    <?php foreach($entities as $entity) : ?>
                        <?php
                            $description = String::truncate($entity['Entity']['description'], 120, array('ellipsis' => '...', 'exact' => true, 'html' => false));
                            if($entity['Image']){
                                $img_src = $this->request->webroot . 'products/resize/' . $entity['Image'][0]['name'] . '/65/87'; 
                            }
                            else{
                                $img_src = $this->request->webroot . "img/image_not_available-small.png";
                            } 
                        ?>
                        <tr class="lifestyle-product-block">
                            <td class="v-top product-thumb text-center">
                                <div class="product-thumb-cont">
                                    <a href="<?php echo $this->request->webroot . 'product/' . $entity['Entity']['id'] . '/' . $entity['Entity']['slug']; ?>"><img src="<?php echo $img_src; ?>" alt="<?php echo $entity['Entity']['name']; ?>" /></a>
                                </div>
                            </td>
                            <td class="v-top">
                                <h6><a href="<?php echo $this->request->webroot . 'product/' . $entity['Entity']['id'] . '/' . $entity['Entity']['slug']; ?>"><?php echo $entity['Entity']['name']; ?></a></h6>
                                <small class="description"><?php echo $description; ?></small>
                            </td>
                            <td class="like-dislike-links">
                                <input type="hidden" value="<?php echo $entity['Entity']['id']; ?>" class="product-id" />
                                <?php if(isset($entity['Wishlist'])) : ?>
                                    <a href="" class="thumbs-up <?php echo ($entity['Wishlist']['id']) ? 'liked' : ''; ?>"></a>                        
                                    <a class="link-btn gold-btn lb-to-cart" href="<?php echo $this->request->webroot . 'product/' . $entity['Entity']['id'] . '/' . $entity['Entity']['slug']; ?>">BUY</a>
                                    <a href="" class="thumbs-down <?php echo ($entity['Dislike']['id']) ? 'disliked' : ''; ?>"></a> 
                                <?php else : ?>
                                    <a class="link-btn gold-btn lb-to-cart" href="<?php echo $this->request->webroot . 'product/' . $entity['Entity']['id'] . '/' . $entity['Entity']['slug']; ?>">BUY</a>
                                <?php endif; ?>
                            </td>
                        </tr>    
                    <?php endforeach; ?>
                    <!--tr class="first">
                        
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
                    </tr-->
                </tbody>
            </table> 
            <?php endif; ?>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="sixteen columns">
        
    </div>
</div>