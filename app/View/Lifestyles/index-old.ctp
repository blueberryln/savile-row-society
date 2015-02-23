<?php  
$script = '
$(document).ready(function(){
    
    // Manage the left sidebar accordian
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
    
    // Handle click on sidebar links
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
    
    
     
});
'; 

$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->script("//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js", array('safe' => true, 'inline' => false));
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
                            <li <?php echo ($category['Category']['slug'] == 'seasonal' || $category['Category']['slug'] == 'lookbooks') ? 'class="highlighted-cat"' : '';?>>
                            <?php if($category['Category']['slug'] == 'seasonal' || $category['Category']['slug'] == 'lookbooks') : ?>
                                <span class="cuff-left"><img src="<?php echo HTTP_ROOT; ?>img/icon_left.png" /></span>
                                <span class="cuff-right"><img src="<?php echo HTTP_ROOT; ?>img/icon_right.png" /></span>
                            <?php endif; ?>
                            
                            <?php if($category['Category']['slug'] == "lookbooks") : ?>
                                <a href="<?php echo $this->request->webroot; ?>lookbooks/" class="lookbook-cat active-link"  data-category_id=<?php echo $category['Category']['id']; ?> ><?php echo $category['Category']['name']; ?></a>
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
            <?php if($lifestyles) : ?>
                <?php foreach($lifestyles as $lifestyle) : ?>
                    <div class="three columns alpha row">
                        <div class="product-block"> 
                            <div class="product-list-image">
                                <a href="<?php echo $this->request->webroot . 'lookbooks/detail/' . $lifestyle['Lifestyle']['id'] . '/' . $lifestyle['Lifestyle']['slug']; ?>">
                                <div>
                                    <img src="<?php echo HTTP_ROOT. "lookbooks/resize/" . $lifestyle['Lifestyle']['image']; ?>/158/216" alt="Lifestyle" class="product-image fadein-image" />
                                </div>
                                </a>
                            </div>
                            <div class="product-list-links">
                                    <a href="<?php echo $this->request->webroot . 'lookbooks/detail/' . $lifestyle['Lifestyle']['id'] . '/' . $lifestyle['Lifestyle']['slug']; ?>" class="btn-buy">Buy</a>
                            </div>
                        </div>
                    </div> 
                <?php endforeach; ?>       
            <?php else : ?>
            <div class="product-top-offset"></div>
            <div class="closet-sorry">
                <h4 class="text-center">SORRY!</h4> 
                <h5>There are no lookbooks available.</h5>            
            </div>                
            <?php endif; ?>
            <?php if($lifestyles && ($this->Paginator->hasNext() || $this->Paginator->hasPrev())) : ?>
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