<?php
$script = '

$(document).ready(function(){   
    
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
                            <li><a href="<?php echo $this->request->webroot; ?>closet/<?php echo $category['Category']['slug']; ?>"  data-category_id=<?php echo $category['Category']['id']; ?> ><?php echo $category['Category']['name']; ?></a>
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