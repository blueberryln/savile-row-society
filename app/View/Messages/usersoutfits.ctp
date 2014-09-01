<?php
$script = '
$(document).ready(function(){
    $(".fade").mosaic();
    $(".remove-product").click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        var object = $(this).closest(".product-block");
        var id = object.find(".product-id").val();
        $.post("' . $this->request->webroot . 'api/wishlist/remove", { product_id: id }, 
            function(data) {
                var ret = $.parseJSON(data);
                if(ret["status"] == "ok"){
                   object.parent().remove();
                }
            }
        );
    });
    $(".mosaic-overlay").not(".remove-product").on("click", function(e){
        e.preventDefault();
        var container = $(".remove-product");
        var productBlock = $(this).closest(".product-block");
        var productSlug = productBlock.find(".product-slug").val();
        var productId = productBlock.find(".product-id").val();
        window.location = "' . $this->request->webroot . 'product/" + productId + "/" + productSlug;
    });
});
';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->script("mosaic.1.0.1.min.js", array('inline' => false));
$this->Html->meta('description', 'First mover', array('inline' => false));
?>

<div class="content-container">
    <div class="twelve columns black">&nbsp;</div>
    <div class="twelve columns container">
        <div class="eleven columns container message-box-area">
            <div class="twelve columns container left message-box">
                <div class="eleven columns container pad-none">
                    <div class="twelve columns message-box-heading pad-none">
                        <h1>Kyle Harper | <span>Messages</span></h1>
                        <div class="client-img-small"><img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt="" /></div>
                    </div>
                    <div class="my-profile-img m-ver">
                        <h2>LISA D.<span>My Stylist</span></h2>
                        <div class="client-img-small right">
                        <a href="javascript:;" title=""><img src="<?php echo $this->webroot; ?>images/my-profile/my-profile-img.jpg" alt="" /></a>
                        </div>
                        <span id="dd-nav-switcher"><img src="<?php echo $this->webroot; ?>images/nav-switcher-icon.png" alt="" /></span>
                    </div>
                    <div class="dd-nav">
                        <ul>
                            <li><a href="javascript:;">Messages</a></li>
                            <li class="active"><a href="javascript:;">Outfits</a></li>
                            <li><a href="javascript:;">Purchases/Likes</a></li>
                            <li><a href="javascript:;">Profile</a></li>
                        </ul>
                    </div>
                    <div class="twelve columns left inner-content pad-none">
                        <div class="inner-left left">
                            <div class="left-pannel left">
                                <div class="client-img"><img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt=""/></div>
                                <div class=" twelve columns left left-nav">
                                    <ul>
                                        <li><a href="javascript:;">Messages</a></li>
                                        <li class="active"><a href="javascript:;">Outfits</a></li>
                                        <li><a href="javascript:;">Purchases/Likes</a></li>
                                        <li><a href="javascript:;">Profile</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="right-pannel right">
                                <div class="twelve columns message-area left pad-none">
                                    <div class="eleven columns container pad-none">
                                        <div class="short-by-date">
                                            <span class="short-by-date-arrow"><img src="<?php echo $this->webroot; ?>images/down-arrow.png" alt=""/></span>
                                            <select>
                                                <option>Sort by Date</option>
                                                <option>7-Aug-2014</option>
                                                <option>7-Aug-2014</option>
                                                <option>7-Aug-2014</option>
                                                <option>7-Aug-2014</option>
                                                <option>7-Aug-2014</option>
                                            </select>
                                        </div>
                                        
                                        <?php foreach ($my_outfits as $my_outfit): ?>
                                            <?php //print_r($my_outfit); ?>
                                        <div class="twelve columns client-outfits left">
                                            <div class="eleven columns container client-outfits-area pad-none">
                                                <h1><?php echo $my_outfit['outfit'][0]['Outfit']['outfitname']; ?></h1>
                                                <div class="twelve columns client-outfits-img pad-none">
                                                    <ul>
                                                        <li>
                                                            <img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit['entities'][0]['Image'][0]['name']; ?>" alt="" />
                                                            <div class="product-desc">
                                                                <span class="product-name"><?php echo $my_outfit['entities'][0]['Entity']['name']; ?></span>
                                                                <span class="product-brand"><?php echo $my_outfit['entities'][0]['Brand']['name']; ?></span>
                                                                <span class="product-price">$<?php echo $my_outfit['entities'][0]['Entity']['price']; ?></span>
                                                                <span class="product-dtls"><a href="javascript:;" title="">Details</a></span>
                                                                <span class="bottm-links">
                                                                    <a class="add-to-cart" href="javascript:;" title="">Add to Cart +</a>
                                                                    <img class="thumb-icon" src="<?php echo $this->webroot; ?>images/thumb-icon.png" alt="" />
                                                                       
                                                                </span>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit['entities'][1]['Image'][0]['name']; ?>" alt="" />
                                                            <div class="product-desc">
                                                                <span class="product-name"><?php echo $my_outfit['entities'][1]['Entity']['name']; ?></span>
                                                                <span class="product-brand"><?php echo $my_outfit['entities'][1]['Brand']['name']; ?></span>
                                                                <span class="product-price">$<?php echo $my_outfit['entities'][1]['Entity']['price']; ?></span>
                                                                <span class="product-dtls"><a href="javascript:;" title="">Details</a></span>
                                                                <span class="bottm-links">
                                                                    <a class="add-to-cart" href="javascript:;" title="">Add to Cart +</a>
                                                                    <img class="thumb-icon" src="<?php echo $this->webroot; ?>images/thumb-icon.png" alt="" />
                                                                       
                                                                </span>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit['entities'][2]['Image'][0]['name']; ?>" alt="" />
                                                            <div class="product-desc">
                                                                <span class="product-name"><?php echo $my_outfit['entities'][2]['Entity']['name']; ?></span>
                                                                <span class="product-brand"><?php echo $my_outfit['entities'][2]['Brand']['name']; ?></span>
                                                                <span class="product-price">$<?php echo $my_outfit['entities'][2]['Entity']['price']; ?></span>
                                                                <span class="product-dtls"><a href="javascript:;" title="">Details</a></span>
                                                                <span class="bottm-links">
                                                                    <a class="add-to-cart" href="javascript:;" title="">Add to Cart +</a>
                                                                    <img class="thumb-icon" src="<?php echo $this->webroot; ?>images/thumb-icon.png" alt="" />
                                                                       
                                                                </span>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit['entities'][3]['Image'][0]['name']; ?>" alt="" />
                                                            <div class="product-desc">
                                                                <span class="product-name"><?php echo $my_outfit['entities'][3]['Entity']['name']; ?></span>
                                                                <span class="product-brand"><?php echo $my_outfit['entities'][3]['Brand']['name']; ?></span>
                                                                <span class="product-price">$<?php echo $my_outfit['entities'][3]['Entity']['price']; ?></span>
                                                                <span class="product-dtls"><a href="javascript:;" title="">Details</a></span>
                                                                <span class="bottm-links">
                                                                    <a class="add-to-cart" href="javascript:;" title="">Add to Cart +</a>
                                                                    <img class="thumb-icon" src="<?php echo $this->webroot; ?>images/thumb-icon.png" alt="" />
                                                                       
                                                                </span>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit['entities'][4]['Image'][0]['name']; ?>" alt="" />
                                                            <div class="product-desc">
                                                                <span class="product-name"><?php echo $my_outfit['entities'][4]['Entity']['name']; ?></span>
                                                                <span class="product-brand"><?php echo $my_outfit['entities'][4]['Brand']['name']; ?></span>
                                                                <span class="product-price">$<?php echo $my_outfit['entities'][4]['Entity']['price']; ?></span>
                                                                <span class="product-dtls"><a href="javascript:;" title="">Details</a></span>
                                                                <span class="bottm-links">
                                                                    <a class="add-to-cart" href="javascript:;" title="">Add to Cart +</a>
                                                                    <img class="thumb-icon" src="<?php echo $this->webroot; ?>images/thumb-icon.png" alt="" />
                                                                       
                                                                </span>
                                                            </div>
                                                        </li>
                                                       
                                                    </ul>
                                                </div>
                                            
                                                 
                                                <div class="twelve columns left client-outfit-bottom pad-none">
                                                    <div class="client-comments left">
                                                        <h2>Stylist Comment</h2>
                                                        <div class="client-comments-text left">Kyle- Your upcoming trip to Hawaii<br>would be a great chance to wear.... <a href="javascript:;" title="">Read More</a></div>
                                                    </div>
                                                    <div class="share-outfit right">Share Outfit</div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        
                        </div> 
                        <div class="inner-right right">
                            <div class="twelve columns text-center my-profile">
                                <div class="my-profile-img">
                                    <a href="javascript:;" title=""><img src="<?php echo $this->webroot; ?>images/my-profile/my-profile-img.jpg" alt="" data-name="Haspel" /></a>
                                </div>
                                <div class="my-profile-detials">
                                    LISA D.
                                    <span>My Stylist</span>
                                    <a class="view-profile" href="javascript:;">View My Profile</a> 
                                </div>
                                
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>