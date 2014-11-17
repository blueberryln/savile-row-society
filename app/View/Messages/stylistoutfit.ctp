<?php
$logged_script = '';
if($user_id){    
$logged_script = '
    $(".product-my-likes").click(function(e) {
        e.preventDefault();
        $this = $(this);
            var productBlock = $this.closest(".product-detail-cont");
            //var productId = productBlock.find(".product-id").val();
            var productId = $this.data("product_id");
            var outfitId = "'.$outfit_id.'";
            //alert(outfitId);
        
            $.post("' . $this->request->webroot . 'api/wishlist/save", { product_id: productId,outfit_id:outfitId},
            function(data) {
                var ret = $.parseJSON(data);
                if(ret["status"] == "ok"){
                    $this.addClass("liked");
                    $this.closest(".product-my-likes").text("Liked");
                }
            }
        );
    });
';
}
$script = '
$(document).ready(function(){  


    $(".add-to-cart").click(function(e) {
        e.preventDefault();
        var productBlock = $(this).closest(".product-dtl-area"),
        productQuantity = productBlock.find("select.product-quantity").val(),
        productSize = productBlock.find("select.product-size").val();

        var id = $(this).data("product_id");
        var quantity = parseInt(productQuantity) + 1;
        var size = productSize;
        var outfitId = $("#outfit_id").val();

        $.post("' . $this->request->webroot . 'api/cart/save", { product_id: id, product_quantity: quantity, product_size: size, outfit_id: outfitId },
            function(data) {
                var ret = $.parseJSON(data);
                if(ret["status"] == "ok"){
                    $(".cart-items-count").html(ret["count"]);
                location.reload();
                }
                else if(ret["status"] == "login"){
                    signUp();       
                }
            });
    });

$(".btn-request-price").click(function(e) {
e.preventDefault();

var productBlock = $(this).closest(".outfit-page-item"),
productQuantity = productBlock.find("select.product-quantity").val(),
productSize = productBlock.find("select.product-size").val(),
$this = $(this);

var loader = $this.next(".loader");
if($this.hasClass("clicked")){
$this.removeClass("clicked");
loader.addClass("hide");
return false;
}
else{
$this.addClass("clicked");
loader.removeClass("hide");
}

if(productQuantity == "")
{
productBlock.find("span.err-message").fadeIn(300);
$this.removeClass("clicked");
loader.addClass("hide");
return false;
} 
else
{
productBlock.find("span.err-message").fadeOut(300);
}
if(productSize == "")
{
productBlock.find("span.err-size-message").fadeIn(300);
$this.removeClass("clicked");
loader.addClass("hide");
return false;
} 
else
{
productBlock.find("span.err-size-message").fadeOut(300);
}


var requestEmail = productBlock.find(".request-email").val();
if(!isLoggedIn()){
if(requestEmail== ""){
productBlock.find("span.err-email-message").fadeIn(300);
$this.removeClass("clicked");
loader.addClass("hide");
return false;
} 
else
{
productBlock.find("span.err-email-message").fadeOut(300);
}
} 


var id = $(this).data("product_id");
var quantity = parseInt(productQuantity) + 1;
var size = productSize;
var comment = $(".txt-price-request").val();
$.post("' . $this->request->webroot . 'api/requestprice", { product_id: id, product_quantity: quantity, product_size: size, request_comment: comment, request_email: requestEmail },
function(data) {
var ret = $.parseJSON(data);
if(ret["status"] == "ok"){
var notificationDetails = new Array();
notificationDetails["msg"] = "Your price request for the product has been submitted successfully.";
showNotification(notificationDetails, true);
$(".product-quantity").val("");
$(".txt-price-request").val("");
$(".product-size").val("");
$(".request-email").val("");
}
$this.removeClass("clicked");
loader.addClass("hide");
}
);
});

$(".lnk-fb-share").on("click", function(e){
e.preventDefault(); 
var url = $(this).closest(".product-detail-cont").find(".product-url").val();
window.open(
"https://www.facebook.com/sharer/sharer.php?u="+encodeURIComponent(url), 
"facebook-share-dialog", 
"width=626,height=436"); 
});


$(".zoom_01").elevateZoom({
zoomType: "inner",
cursor: "crosshair",
zoomWindowFadeIn: 500,
zoomWindowFadeOut: 750
}); 

$(".group1").colorbox({scalePhotos: true, maxWidth: $(window).width()-100, maxHeight: $(window).height()-100});

' . $logged_script . '
});
';
$this->Html->script("jquery.elevateZoom-3.0.8.min.js", array('inline' => false));
$this->Html->script("jquery.colorbox-min.js", array('inline' => false));
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->css('colorbox', null, array('inline' => false));

?>
<div>
    <div class="twelve columns container">
        <div class="eleven columns container message-box-area">
            <div class="twelve columns container left message-box">

                    <?php echo $this->element('clientAside/userFilterBar'); ?>

                <div class="myotft-right right">
                    <div class="eleven columns container">
                        <div class="twelve columns outfit-dtls myotft pad-none left">
                            <div class="twelve columns outfit-dtls left">
                                <h1><?php echo ucfirst($outfit['Outfit']['outfit_name']); ?></h1>
                                <input id="outfit_id" value="<?php echo $outfit['Outfit']['id']; ?>" type="hidden">
                                <div class="twelve columns container outfits-dtls-area pad-none">
                                    <div class="twelve columns left outfit-desc">
                                        <div class="outfit-dtls-date">
                                            <span>Date Created:</span> <?php echo $outfit['Outfit']['created']; ?>
                                        </div>
                                        <div class="outfit-dtls-price"><span>Outfit Price:</span>
                                            <?php
                                                $sum = 0;
                                                $brand_list = array();
                                                foreach($outfit['OutfitItem'] as $value){
                                                    $sum += $value['product']['Entity']['price'];
                                                    $brand_list[] = $value['product']['Brand']['name'];
                                                }
                                                $brand_list = implode(',', array_unique($brand_list));
                                                echo '$'.$sum; 
                                            ?>
                                        </div>
                                        <div class="outfit-dtls-brnads"><span>Brands in Outfit:</span></div>
                                        <div class="outfit-dtls-brand-name">
                                            <?php echo $brand_list; ?>
                                        </div>
                                    </div>   
                                    <div class="twelve columns left myotft-btn">
                                        <a class="bkmrk-btn" href="#" title="">BOOKMARKED</a>
                                        <a id="reuse-otft" href="#" title="">REUSE OUTFIT</a>                                    
                                    </div>
                                </div>
                            </div>
                            <div class="twelve columns left outfit-dtls-img pad-none">
                                <div class="eleven columns container outfit-dtls-img-list otft-img-bdr pad-none">
                                    <ul>
                                        <?php 
                                        foreach ($outfit['OutfitItem'] as $entity){
                                            if(count($entity['product']['Image']) >= 1){
                                                $img = $this->webroot . "products/resize/" . $entity['product']["Image"][0]["name"] . "/92/143";   
                                            }
                                            else{
                                                $img = $this->webroot . "img/image_not_available-small.png";       
                                            }            
                                        ?>

                                        <li><img src="<?php echo $img; ?>" alt="<?php echo $entity['product']['Entity']['name']; ?>" class="product-image fadein-image" style="opacity: 1;"> </li>
                                        <input type="hidden" value="<?php echo $entity['product']['Entity']['id']; ?>" class="product-id">  
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="twelve columns left product-dtls pad-none">
                                <div class="twelve columns left product-view pad-none">
                                <?php foreach ($outfit['OutfitItem'] as $entity) : ?>

                                <div class="twelve columns left product-dtl-area pad-none">
                                    <input type="hidden" value="<?php echo $entity['product']['Entity']['id']; ?>" class="product-id">  
                                    <input type="hidden" value="<?php echo $entity['product']['Entity']['slug']; ?>" class="product-slug">  
                                    <input type="hidden" value="<?php echo Configure::read('Social.callback_url') . "product/" . $entity['product']['Entity']['id'] . "/" . $entity['product']['Entity']['slug'] . "/"; ?>" class="product-url"> 

                                        <div class="product-dtl-img left"> 
                                        <?php if(count($entity['product']['Image']) > 0) : ?>
                                            <a href="<?php echo $this->webroot . 'files/products/' . $entity['product']['Image'][0]['name']; ?>" data-lightbox="product-images" class="group1" rel="group<?php echo $entity['product']['Entity']['id']; ?>">

                                                <img class="zoom_01" src="<?php echo $this->webroot . 'files/products/' . $entity['product']['Image'][0]['name']; ?>" class="fadein-image" data-zoom-image="<?php echo $this->webroot . 'files/products/' . $entity['product']['Image'][0]['name']; ?>" />

                                            </a>
                                        <?php else : ?>
                                            <img src="<?php echo $this->webroot; ?>img/image_not_available.png" class="fadein-image" />                    
                                        <?php endif; ?>
                                        </div>

                                        <div class="product-dtl-desc left">
                                            <div class="product-dtl-desc-top left">
                                                <div class="desc-top-brand">
                                                    <?php echo $entity['product']['Entity']['name']; ?> | <?php echo $entity['product']['Brand']['name']; ?>
                                                </div>
                                                <div class="desc-top-brand-price">
                                                    $ <?php echo $entity['product']['Entity']['price']; ?>
                                                </div>
                                            </div>
                                            <div class="product-dtl-desc-middle left">
                                                <ul>
                                                    <li><span>&ndash;</span><?php echo nl2br($entity['product']['Entity']['description']); ?></li>
                                                </ul>

                                            </div>
                                            <div class="product-dtl-desc-bottom left">
                                                <div class="slect-options left">
                                                    <div class="select-size select-style left">
                                                    <?php if($entity['size_id']){
                                                        echo '<select class="product-size">';
                                                        echo '<option value="' . $entity['size_id'] . '">' . $sizes[$entity['size_id']] . '</option>';
                                                        echo '</select>';
                                                    }
                                                    else{
                                                        if(count($entity['product']['Detail'])){
                                                            echo '<select class="product-size">';
                                                            foreach($entity['product']['Detail'] as $detail){
                                                                echo '<option value="' . $detail['size_id'] . '">' . $sizes[$detail['size_id']] . '</option>';
                                                            }  
                                                            echo '</select>';  
                                                        }
                                                    }
                                                    ?>
                                                    <br/>
                                                    </div>
                                                    <div class="select-quantity select-style left">
                                                        <?php echo $this->Form->input('product-quantity', array('class'=>'product-quantity', 'options' => range(1,10) , 'label' => false, 'div' => false, 'style' => "")); ?>
                                                    </div>
                                                </div>
                                            <div class="product-dtl-specifiation left">
                                                Specifications preselected from Stylist  Recommendations
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-dtl-links left">
                                        <a href="" class="gold-btn add-to-cart product-add-cart text-center" data-product_id="<?php echo $entity['product']['Entity']['id']; ?>">ADD TO CART</a>

                                        <a class="product-my-likes"href="#" id="likes" data-product_id="<?php echo $entity['product']['Entity']['id']; ?>"><?php echo ($entity['product']['Wishlist']['id']) ? 'liked' : 'Add to My Likes'; ?></a>
                                    </div>
                                </div>
                                <?php endforeach; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div id="create-otft-popup" style="display: none">
    <div class="box-modal">
        <div class="box-modal-inside">
            <a href="#" title="" class="otft-close"></a>
            <div class="crt-new-otft-content">
                <div class="five columns left otft-pop-lft">
                    <div class="myclient-popup left">
                        <div class="myclient-topsec"> 
                            <input type="hidden" id="reuse-outfit-id" value="<?php echo $outfit_id; ?>">
                            <div class="filter-myclient-area">
                                <div class="filter-myclient" >
                                    <span class="downarw"></span>
                                    <select id="selectfilter">
                                    <option value="">Filter Clients</option>
                                    <?php foreach($userlists as $clientout): ?>
                                    <option value="<?php echo $this->webroot; ?>outfits/create/<?php echo $clientout['User']['id']; ?>"><?php echo $clientout['User']['first_name'].'&nbsp;'.$clientout['User']['last_name']; ?></option>
                                     <?php endforeach; ?>
                                    
                                </select>
                                </div>
                            </div>
                            <div class="search-myclient-area">
                                <div class="search-myclient modal-user-search">
                                    <span class="srch"></span>
                                    <input type="text" name="myclient-search" id="modalusersearch" />
                                </div>
                            </div>
                            <div class="myclient-list">
                                <div id="scrollbar3">
                                    <div class="scrollbar">
                                        <div class="track">
                                            <div class="thumb">
                                                <div class="end"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="viewport">
                                        <div class="overview">
                                            <ul id="searchuserlist">
                                            <?php 
                                            //$userlist = $searchforoutfit;
                                             foreach($userlists as $usersearchforoutfit):?>
                                                <li>
                                                    <a href="<?php echo $this->webroot; ?>outfits/create/<?php echo $usersearchforoutfit['User']['id']; ?>" title="" class="create-outfit-user-row">
                                                        <div class="myclient-img">
                                                            <?php if($usersearchforoutfit['User']['profile_photo_url']): ?>
                                                                <img src="<?php echo $this->webroot; ?>files/users/<?php echo $usersearchforoutfit['User']['profile_photo_url']; ?>" alt=""/>
                                                            <?php else: ?>
                                                                <img src="<?php echo $this->webroot; ?>images/default-user.jpg" alt=""/>    
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="myclient-dtl">
                                                            <span class="myclient-name"><?php echo $usersearchforoutfit['User']['first_name'].'&nbsp;'.$usersearchforoutfit['User']['last_name']; ?></span>
                                                            <span class="myclient-status">last active at <?php echo date ('d F Y',$usersearchforoutfit['User']['updated']); ?></span>
                                                        </div>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                                
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="five columns right otft-pop-rgt">
                    <div class="eleven columns container">
                        <div class="twelve columns left otft-pop-rgt-area">
                            <div class="otft-pop-rgt-top">
                                <h1>Create A new Outfit</h1>
                                <p>Please select a client from your client list on the left.</p>
                                <a class="popup-cont-btn setp-btn" href="#" id="createoutfitbitton" title="">Continue</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
$(document).ready(function(){
    var $scrollbar  = $('#scrollbar3');
    $scrollbar.tinyscrollbar({ axis: "y"});
    var scrollbarData = $scrollbar.data("plugin_tinyscrollbar");
    
    $("#createoutfitbitton").on('click',function(){
        var selectvalue = $("#selectfilter option:selected" ).val();

        var reuseOutfitId = $("#reuse-outfit-id").val(),
            reuseQueryString = "";

        if(reuseOutfitId != ""){
            reuseQueryString = "?reuse=" + reuseOutfitId;
        }
        window.location = selectvalue + reuseQueryString;
    });

    $(".create-outfit-user-row").on('click', function(e){
        e.preventDefault();

        var reuseOutfitId = $("#reuse-outfit-id").val(),
            userOutfitUrl = $(this).attr('href'),
            reuseQueryString = "";

        if(reuseOutfitId != ""){
            reuseQueryString = "?reuse=" + reuseOutfitId;
        }
        window.location = userOutfitUrl + reuseQueryString; 
    });

    $("#reuse-otft").on('click', function(e){
        e.preventDefault();
        outFit();
        scrollbarData.update();
    });
});  
</script>