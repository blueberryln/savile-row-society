<?php
$logged_script = '';
if($user_id){    
$logged_script = '
    $(".thumbs-up").click(function(e) {
        e.preventDefault();
        $this = $(this);
            var productBlock = $this.closest(".product-detail-cont");
            var productId = productBlock.find(".product-id").val();
        if(!$this.hasClass("liked")){
            $.post("' . $this->request->webroot . 'api/wishlist/save", { product_id: productId},
            function(data) {
                var ret = $.parseJSON(data);
                if(ret["status"] == "ok"){
                    $this.addClass("liked");
                    $this.closest(".product-thumbs").find(".thumbs-down").removeClass("disliked");
                }

                if(ret["profile_status"] == "incomplete"){
                    var notificationDetails = new Array();
                    notificationDetails["msg"] = ret["profile_msg"];
                    notificationDetails["button"] = "<a href=\"' . $this->webroot . 'register/wardrobe\" class=\"link-btn gold-btn\">Complete Style Profile</a>";
                    showNotification(notificationDetails);
                }
            }
        );
        }else{
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
            var productBlock = $this.closest(".product-detail-cont");
            var productId = productBlock.find(".product-id").val();
            if(!$this.hasClass("disliked")){
                $.post("' . $this->request->webroot . 'api/dislike/save", { product_id: productId},
                    function(data) {
                        var ret = $.parseJSON(data);
                        if(ret["status"] == "ok"){
                            $this.addClass("disliked");
                            $this.closest(".product-thumbs").find(".thumbs-up").removeClass("liked");
                        }
                    }
                );
            }else{
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
var threeItemPopup = ' . $show_three_item_popup. ';
var addCartPopup = ' . $show_add_cart_popup. ';
$(document).ready(function(){  

if(isLoggedIn() && threeItemPopup == 1){
var notificationDetails = new Array();
notificationDetails["msg"] = "' . $popUpMsg . '";
notificationDetails["button"] = "<a href=\"' . $this->webroot . 'cart\" class=\"link-btn gold-btn\">Checkout</a>";
showNotification(notificationDetails);  
}  
else if(isLoggedIn() && addCartPopup == 1){
var notificationDetails = new Array();
notificationDetails["msg"] = "Item has been added to the cart.";
showNotification(notificationDetails);        
}  

$(".fade").mosaic();

$(".add-to-cart").click(function(e) {
e.preventDefault();
var productBlock = $(this).closest(".outfit-page-item"),
productQuantity = productBlock.find("select.product-quantity").val(),
productSize = productBlock.find("select.product-size").val();

if(productQuantity == "")
{
productBlock.find("span.err-message").fadeIn(300);
return false;
} 
else
{
productBlock.find("span.err-message").fadeOut(300);
}
if(productSize == "")
{
productBlock.find("span.err-size-message").fadeIn(300);
return false;
} 
else
{
productBlock.find("span.err-size-message").fadeOut(300);
}

var id = $(this).data("product_id");
var quantity = parseInt(productQuantity) + 1;
var size = productSize;

$.post("' . $this->request->webroot . 'api/cart/save", { product_id: id, product_quantity: quantity, product_size: size },
function(data) {
var ret = $.parseJSON(data);
if(ret["status"] == "ok"){
$(".cart-items-count").html(ret["count"]);
location.reload();
}
else if(ret["status"] == "login"){
signUp();       
}
}
);
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
$this->Html->script("mosaic.1.0.1.min.js", array('inline' => false));
$this->Html->script("jquery.colorbox-min.js", array('inline' => false));
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->css('colorbox', null, array('inline' => false));

?>
<?php
    $img = "";
        if(isset($Userdata) && $Userdata[0]['User']['profile_photo_url'] && $Userdata[0]['User']['profile_photo_url'] != ""){
            $img = $this->webroot . "files/users/" . $Userdata[0]['User']['profile_photo_url'];
         }else{
            $img = $this->webroot . "img/dummy_image.jpg";    
        }
?>
<script type="text/javascript">
    $(document).ready(function(){


    $(".search-myclient").on('keydown',function(){
         
         //var r = $('input').focus();
         var usersearch = $("#usersearch").val();
         //alert(usersearch);
          $.ajax({
                type:"POST",
                url:"<?php echo $this->webroot; ?>messages/stylistFilterList/<?php echo $user_id; ?>",
                data:{usersearch:usersearch},
                cache: false,
                    success: function(result){
                        data = $.parseJSON(result);

            html = '';
            html = html + '<ul>';
            
            $.each(data,  function (index){
                html = html + '<li>';
                html = html + '<a href="<?php echo $this->webroot; ?>messages/index/'+ this.User.id +'" title="">';
                html = html + '<div class="myclient-img">';
                html = html + '<img src="<?php echo $this->webroot; ?>files/users/'+ this.User.profile_photo_url +'" alt=""/>';
                html = html + '</div>';
                html = html + '<div class="myclient-dtl">';
                html = html + '<span class="myclient-name">'+ this.User.first_name +'&nbsp;'+ this.User.last_name +'</span>';
                html = html + '<span class="myclient-status">last active at '+ this.User.updated +'</span>';
                html = html + '</div>';
                html = html + '</a>';
                html = html + '</li>';      
                
                });
            html = html + '</ul>';
                $("#searchuserlist").html(html);

                    }

             }); 


    });


    //copy outfit
    // $("#continue").on('click',function(){
        
    //     var user_id =  $("#selectuserid").val();
    //     var stylist_id =  $("#stylist_id").val();
    //     var outfitid = $("#outfitid").val();
        
    //       $.ajax({
    //             type:"POST",
    //             url:"<?php echo $this->webroot; ?>messages/reuseOutfit/<?php echo $user_id; ?>",
    //             data:{user_id:user_id,stylist_id:stylist_id,outfit_id:outfitid},
    //             cache: false,
    //                 success: function(result){
    //             $(".box-modal-inside").html('<h1>Your Data Has Been Submitted.</h1><a href="#" title="" class="otft-close"></a>');
    //                 }

    //          }); 


    // });


    $("#continue").on('click',function(){
    
        
        var selectvalue = $("#selectuserid option:selected" ).val();
        
        window.location = selectvalue;
    });
});

</script>

    <div class="twelve columns container">
        <div class="eleven columns container message-box-area">
            <div class="twelve columns container left message-box">
                
                
                <div class="myclient-left left">
                    <div class="myclient-topsec"> 
                        <div class="filter-myclient-area">
                            <div class="filter-myclient">
                                <span class="downarw"></span>
                                <select onchange="location = this.options[this.selectedIndex].value;">
                                    <option>Filter Clients</option>
                                    <?php  foreach($userlists as $filterclient ): ?>
                                    <option value="<?php echo $this->webroot; ?>messages/index/<?php echo $filterclient['User']['id']; ?>"><?php echo $filterclient['User']['first_name'].'&nbsp;'.$filterclient['User']['last_name']; ?></option>
                                     <?php endforeach; ?>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="search-myclient-area">
                            <div class="search-myclient">
                                <span class="srch"></span>
                                <input type="text" name="myclient-search" id="usersearch" />
                            </div>
                        </div>
                        <div class="myclient-list">
                            <ul id="searchuserlist">
                            <?php  foreach($userlists as $userlist){?>
                                <li>
                                    <a href="<?php echo $this->webroot; ?>messages/index/<?php echo $userlist['User']['id']; ?>" title="">
                                        <div class="myclient-img">
                                            <img src="<?php echo $this->webroot; ?>files/users/<?php echo $userlist['User']['profile_photo_url']; ?>" alt=""/>
                                        </div>
                                        <div class="myclient-dtl">
                                            <span class="myclient-name"><?php echo $userlist['User']['first_name'].'&nbsp;'.$userlist['User']['last_name']; ?></span>
                                            <span class="myclient-status">last active at <?php echo date ('d F Y',$userlist['User']['updated']); ?></span>
                                        </div>
                                    </a>
                                </li>
                            <?php } ?>
                                
                            </ul>
                        </div>
                    </div>
                </div>
                
                
                <div class="myotft-right">
                    <div class="eleven columns container">
                        <div class="twelve columns outfit-dtls myotft pad-none left">
                            <h1><?php echo $outfitname['Outfit']['outfitname']; ?></h1>
                            <div class="twelve columns left outfits-dtls-area pad-none">
                                <div class="twelve columns left outfit-desc myotft-dsc pad-none">
                                    <div class="outfit-dtls-date"><span>Date Created:</span> <?php echo $outfitname['Outfit']['created']; ?></div>
                                    <div class="outfit-dtls-price"><span>Outfit Price:</span>
                                         <?php $sum = 0; foreach ($entities as $entity) : ?>
                                         <?php $sum += $entity['Entity']['price'];  ?>
                                        <?php endforeach; echo '$'.$sum; ?>
                                    </div>
                                    <div class="outfit-dtls-brnads"><span>Brands:</span>
                                        <?php foreach ($entities as $entity) : ?>
                                        <?php echo str_replace(' ', ',', $entity['Brand']['name']); ?>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="outfit-dtls-brnads"><span>Recommended to:</span> Client 1, Client 2</div>
                                    <div class="outfit-dtls-brnads"><span>Sold to:</span> Client 7, Client 1, Client 2</div>
                                </div>
                                <div class="twelve columns left myotft-btn">
                                    <a class="bkmrk-btn" href="#" title="">BOOKMARKED</a>
                                    <a id="reuse-otft" href="#" title="">REUSE OUTFIT</a>                                    
                                </div>
                            </div>
                        </div>
                        <div id="reuse-otft-popup" style="display: none">
                            <div class="box-modal">
                                <div class="box-modal-inside">
                                    <a href="#" title="" class="otft-close"></a>
                                    <div class="crt-new-otft-content">
                                        <div class="five columns left otft-pop-lft">
                                            <div class="myclient-popup left">
                                                <div class="myclient-topsec"> 
                                                    <div class="filter-myclient-area">
                                                        <div class="filter-myclient">
                                                            <span class="downarw"></span>
                                                            <input type="hidden" id="outfitid" value="<?php echo $outfitname['Outfit']['id']; ?>">
                                                            <select name="data[Outfit][user_id]" id="selectuserid">
                                                            <option>Filter Clients</option>

                                                            <?php  foreach($userlists as $filterclient ): ?>
                                                            <option value="<?php echo $this->webroot; ?>messages/stylistcreateoutfits/<?php echo $filterclient['User']['id']; ?>/<?php echo $outfitname['Outfit']['id']; ?>"><?php echo $filterclient['User']['first_name'].'&nbsp;'.$filterclient['User']['last_name']; ?></option>
                                                            <?php endforeach; ?>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="search-myclient-area">
                                                        <div class="search-myclient">
                                                            <span class="srch"></span>
                                                            <input type="text" name="myclient-search" id="usersearch" />
                                                        </div>
                                                    </div>
                                                    <div class="myclient-list">
                                                    <ul id="searchuserlist">
                                                    <?php  foreach($userlists as $userlist){?>
                                                    <li>
                                                    <a href="<?php echo $this->webroot; ?>messages/index/<?php echo $userlist['User']['id']; ?>" title="">
                                                    <div class="myclient-img">
                                                    <img src="<?php echo $this->webroot; ?>files/users/<?php echo $userlist['User']['profile_photo_url']; ?>" alt=""/>
                                                    </div>
                                                    <div class="myclient-dtl">
                                                    <span class="myclient-name"><?php echo $userlist['User']['first_name'].'&nbsp;'.$userlist['User']['last_name']; ?></span>
                                                    <span class="myclient-status">last active at <?php echo date ('d F Y',$userlist['User']['updated']); ?></span>
                                                    </div>
                                                    </a>
                                                    </li>
                                                    <?php } ?>

                                                    </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="five columns right otft-pop-rgt">
                                            <div class="eleven columns container">
                                                <div class="twelve columns left otft-pop-rgt-area">
                                                    <div class="otft-pop-rgt-top">
                                                        <input type="hidden" name="data[Outfit][id]" id="outfitid" value="<?php echo $outfitname['Outfit']['id']; ?>">
                                                        <input type="hidden" name="data[Outfit][stylist_id]" id="stylist_id" value="<?php echo $user_id; ?>">
                                                        <h1>Reuse Outfit:<br><span><?php echo $outfitname['Outfit']['outfitname']; ?></span></h1>
                                                        <p>Please select a client from your client list on the left.</p>
                                                        <p class="small-txt">You have the option to rename the outfit in the next step.</p>
                                                        <a class="popup-cont-btn setp-btn" id="continue" href="#" title="">Continue</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                        <div class="twelve columns left outfit-dtls-img pad-none">
                            <div class="eleven columns container outfit-dtls-img-list otft-img-bdr pad-none">
                                <ul>
                                <?php foreach ($entities as $entity) : //print_r($entities); ?>
                                <?php 
                                if(count($entity['Image']) >= 1){
                                $img = $this->webroot . "products/resize/" . $entity["Image"][0]["name"] . "/92/143";   
                                }
                                else{
                                $img = $this->webroot . "img/image_not_available-small.png";       
                                }
                                ?>

                                <li><img src="<?php echo $img; ?>" alt="<?php echo $entity['Entity']['name']; ?>" class="product-image fadein-image" style="opacity: 1;"> </li>
                                <input type="hidden" value="<?php echo $entity['Entity']['id']; ?>" class="product-id">  
                                <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <!-- <div class="twelve columns left product-dtls pad-none">
                            <div class="twelve columns left product-view pad-none">
                                <div class="twelve columns left product-dtl-area pad-none">
                                    <div class="product-dtl-img left"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_1.jpg" alt=""/></div>
                                    <div class="product-dtl-desc left">
                                        <div class="product-dtl-desc-top left">
                                            <div class="desc-top-brand">Solid Cali | Solid &amp; Stripes</div>
                                            <div class="desc-top-brand-price">$140.00</div>

                                        </div>
                                        <div class="product-dtl-desc-middle left">
                                           <ul>
                                                <li><span>&ndash;</span>17cm inseam.</li>
                                                <li><span>&ndash;</span>Elastic waistband.</li>
                                                <li><span>&ndash;</span>Side pockets and a plain back.</li>
                                                <li><span>&ndash;</span>Cotton mesh lining for ultimate comfort.</li>
                                            </ul>

                                        </div>
                                        <div class="product-dtl-desc-bottom left">
                                            <div class="slect-options left">
                                                <div class="select-color select-style left">
                                                    <span class="selct-arrow"></span>
                                                    <select>
                                                        <option>Color</option>
                                                        <option>Blue</option>
                                                        <option>Red</option>
                                                        <option>Green</option>
                                                    </select>
                                                </div>
                                                <div class="select-size select-style left">
                                                    <span class="selct-arrow"></span>
                                                    <select>
                                                        <option>Size</option>
                                                        <option>38</option>
                                                        <option>40</option>
                                                        <option>42</option>
                                                    </select>
                                                </div>
                                                <div class="select-quantity select-style left">
                                                    <span class="selct-arrow"></span>
                                                    <select>
                                                        <option>Quantity</option>
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="product-dtl-specifiation left">Specifications preselected from Stylist  Recommendations</div>
                                        </div>
                                    </div>
                                    <div class="product-dtl-links left">
                                        <a class="product-add-cart" href="javascript:;" title="">Add to Cart</a>
                                        <a class="product-my-likes"href="javascript:;" title="">Add to My Likes</a>
                                        <div class="product-social-likes">
                                            <ul>
                                                <li><a class="product-social-likes-pintrest" href="javascript:;" title="">Pintrest</a></li>
                                                <li><a class="product-social-likes-facebook" href="javascript:;" title="">Faceboook</a></li>
                                                <li><a class="product-social-likes-twitter" href="javascript:;" title="">Twitter</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="twelve columns left product-dtl-area pad-none">
                                    <div class="product-dtl-img left"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_1.jpg" alt=""/></div>
                                    <div class="product-dtl-desc left">
                                        <div class="product-dtl-desc-top left">
                                            <div class="desc-top-brand">Solid Cali | Solid &amp; Stripes</div>
                                            <div class="desc-top-brand-price">$140.00</div>

                                        </div>
                                        <div class="product-dtl-desc-middle left">
                                           <ul>
                                                <li><span>&ndash;</span>17cm inseam.</li>
                                                <li><span>&ndash;</span>Elastic waistband.</li>
                                                <li><span>&ndash;</span>Side pockets and a plain back.</li>
                                                <li><span>&ndash;</span>Cotton mesh lining for ultimate comfort.</li>
                                            </ul>

                                        </div>
                                        <div class="product-dtl-desc-bottom left">
                                            <div class="slect-options left">
                                                <div class="select-color select-style left">
                                                    <span class="selct-arrow"></span>
                                                    <select>
                                                        <option>Color</option>
                                                        <option>Blue</option>
                                                        <option>Red</option>
                                                        <option>Green</option>
                                                    </select>
                                                </div>
                                                <div class="select-size select-style left">
                                                    <span class="selct-arrow"></span>
                                                    <select>
                                                        <option>Size</option>
                                                        <option>38</option>
                                                        <option>40</option>
                                                        <option>42</option>
                                                    </select>
                                                </div>
                                                <div class="select-quantity select-style left">
                                                    <span class="selct-arrow"></span>
                                                    <select>
                                                        <option>Quantity</option>
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="product-dtl-specifiation left">Specifications preselected from Stylist  Recommendations</div>
                                        </div>
                                    </div>
                                    <div class="product-dtl-links left">
                                        <a class="product-add-cart" href="javascript:;" title="">Add to Cart</a>
                                        <a class="product-my-likes"href="javascript:;" title="">Add to My Likes</a>
                                        <div class="product-social-likes">
                                            <ul>
                                                <li><a class="product-social-likes-pintrest" href="javascript:;" title="">Pintrest</a></li>
                                                <li><a class="product-social-likes-facebook" href="javascript:;" title="">Faceboook</a></li>
                                                <li><a class="product-social-likes-twitter" href="javascript:;" title="">Twitter</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="twelve columns left product-dtl-area pad-none">
                                    <div class="product-dtl-img left"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_1.jpg" alt=""/></div>
                                    <div class="product-dtl-desc left">
                                        <div class="product-dtl-desc-top left">
                                            <div class="desc-top-brand">Solid Cali | Solid &amp; Stripes</div>
                                            <div class="desc-top-brand-price">$140.00</div>

                                        </div>
                                        <div class="product-dtl-desc-middle left">
                                           <ul>
                                                <li><span>&ndash;</span>17cm inseam.</li>
                                                <li><span>&ndash;</span>Elastic waistband.</li>
                                                <li><span>&ndash;</span>Side pockets and a plain back.</li>
                                                <li><span>&ndash;</span>Cotton mesh lining for ultimate comfort.</li>
                                            </ul>

                                        </div>
                                        <div class="product-dtl-desc-bottom left">
                                            <div class="slect-options left">
                                                <div class="select-color select-style left">
                                                    <span class="selct-arrow"></span>
                                                    <select>
                                                        <option>Color</option>
                                                        <option>Blue</option>
                                                        <option>Red</option>
                                                        <option>Green</option>
                                                    </select>
                                                </div>
                                                <div class="select-size select-style left">
                                                    <span class="selct-arrow"></span>
                                                    <select>
                                                        <option>Size</option>
                                                        <option>38</option>
                                                        <option>40</option>
                                                        <option>42</option>
                                                    </select>
                                                </div>
                                                <div class="select-quantity select-style left">
                                                    <span class="selct-arrow"></span>
                                                    <select>
                                                        <option>Quantity</option>
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="product-dtl-specifiation left">Specifications preselected from Stylist  Recommendations</div>
                                        </div>
                                    </div>
                                    <div class="product-dtl-links left">
                                        <a class="product-add-cart" href="javascript:;" title="">Add to Cart</a>
                                        <a class="product-my-likes"href="javascript:;" title="">Add to My Likes</a>
                                        <div class="product-social-likes">
                                            <ul>
                                                <li><a class="product-social-likes-pintrest" href="javascript:;" title="">Pintrest</a></li>
                                                <li><a class="product-social-likes-facebook" href="javascript:;" title="">Faceboook</a></li>
                                                <li><a class="product-social-likes-twitter" href="javascript:;" title="">Twitter</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        
                        <!--try-->

                        <div class="twelve columns left product-dtls">
                            <div class="eleven columns container product-view outfit-page-item">
                                <?php foreach ($entities as $entity) : ?>
                                <input type="hidden" value="<?php echo $entity['Entity']['id']; ?>" class="product-id">  
                                <input type="hidden" value="<?php echo $entity['Entity']['slug']; ?>" class="product-slug">  
                                <input type="hidden" value="<?php echo Configure::read('Social.callback_url') . "product/" . $entity['Entity']['id'] . "/" . $entity['Entity']['slug'] . "/"; ?>" class="product-url"> 

                                <div class="twelve columns left product-dtl-area">
                                    <div class="product-dtl-img left"> 
                                        <?php if(count($entity['Image']) > 0) : ?>
                                        <a href="<?php echo $this->webroot . 'files/products/' . $entity['Image'][0]['name']; ?>" data-lightbox="product-images" class="group1" rel="group<?php echo $entity['Entity']['id']; ?>">

                                        <img class="zoom_01" src="<?php echo $this->webroot . 'files/products/' . $entity['Image'][0]['name']; ?>" class="fadein-image" data-zoom-image="<?php echo $this->webroot . 'files/products/' . $entity['Image'][0]['name']; ?>" />

                                        </a>
                                        <?php else : ?>
                                        <img src="<?php echo $this->webroot; ?>img/image_not_available.png" class="fadein-image" />                    
                                        <?php endif; ?>
                                    </div>


                                    <div class="product-dtl-desc left">
                                        <div class="product-dtl-desc-top left">
                                            <div class="desc-top-brand"><?php echo $entity['Entity']['name']; ?> | <?php echo $entity['Brand']['name']; ?></div>
                                            <div class="desc-top-brand-price">$ <?php echo $entity['Entity']['price']; ?></div>
                                        </div>
                                        <div class="product-dtl-desc-middle left">
                                            <ul>
                                            <li><span>&ndash;</span><?php echo nl2br($entity['Entity']['description']); ?></li>
                                            </ul>
                                        </div>
                                        <div class="product-dtl-desc-bottom left">
                                            <div class="slect-options left">
                                                <div class="select-color select-style left">
                                                    <span class="selct-arrow"></span>
                                                    <select>
                                                    <?php 
                                                    $similar = isset($entity['Similar']) ? $entity['Similar'] : false;
                                                    if($similar) : ?>
                                                    <?php foreach($similar as $product) : ?>
                                                    <?php if($product['Color'] && count($product['Color']) > 1) : ?>

                                                    <option><?php echo $product['Color'][0]['name']; ?></option>
                                                    <option><?php echo $product['Color'][1]['name']; ?></option>
                                                    <?php elseif($product['Color'] && count($product['Color']) == 1) : ?>
                                                    <option><?php echo $product['Color'][0]['name']; ?></option>
                                                    <?php endif; ?>

                                                    <?php endforeach; ?>
                                                    <?php endif; ?>
                                                    </select>
                                                </div>
                                                <div class="select-size select-style left">
                                                    <span class="selct-arrow"></span>
                                                    <?php 
                                                    $sizes = isset($entity['Detail']) ? $entity['Detail'] : false;
                                                    if($sizes) : ?>
                                                    <?php if(count($sizes) == 1 && $size_list[$sizes[0]['size_id']] == 'N/A') : ?>

                                                    <?php else : ?>

                                                    <select class="product-size">

                                                    <?php foreach($sizes as $size) : ?>
                                                    <option value="<?php echo $size['size_id']; ?>"><?php echo $size_list[$size['size_id']]; ?></option>
                                                    <?php endforeach; ?>
                                                    </select><br/>


                                                    <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="select-quantity select-style left">
                                                    <?php echo $this->Form->input('product-quantity', array('class'=>'product-quantity', 'options' => range(1,10) , 'label' => false, 'div' => false, 'style' => "")); ?>
                                                </div>
                                            </div>
                                                <div class="product-dtl-specifiation left">Specifications preselected from Stylist  Recommendations</div>
                                            </div>
                                        </div>

                                            <div class="product-dtl-links left">

                                                <a href="" class="link-btn gold-btn add-to-cart full-width text-center" data-product_id="<?php echo $entity['Entity']['id']; ?>">ADD TO CART</a>
                                                <a class="product-my-likes"href="javascript:;" title="">Add to My Likes</a>
                                                <div class="product-social-likes">
                                                <ul>
                                                <li><a class="product-social-likes-pintrest" href="javascript:;" title="">Pintrest</a></li>
                                                <li><a class="product-social-likes-facebook"  href="javascript:;" title="">Faceboook</a></li>
                                                <li><a class="product-social-likes-twitter" href="javascript:;" title="">Twitter</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                                </div>
                            </div>
                        <!--try-->

                    </div>
                </div>
                
                
                
            </div>
        </div>
    </div>
</div>