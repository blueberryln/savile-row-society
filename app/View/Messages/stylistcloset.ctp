<script type="text/javascript">
    $(document).ready(function(){

     function productpopload(){

        $(document).on('click', ".myclst-quick-view",function(){
        $this = $(this);
        var productBlock = $this.closest(".myclst-quick-view");
        var productid = productBlock.find("#prid").val();
        //alert(id);
                $.ajax({
                        type:"POST",
                        url:"<?php echo $this->webroot; ?>Messages/closetAjaxQuickPopData/<?php echo $user_id ?>",
                        data:{productid:productid},
                        cache: false,
                        success: function(result){
                            //alert(result);

                        data = $.parseJSON(result);
                        html = '';
                        $.each(data, function(index){
                        html = html + '<div id="myclst-popup" style="display: none">';
                        html = html + '<div class="box-modal">';
                        html = html + '<div class="box-modal-inside">';
                        html = html + '<a href="#" title="" class="otft-close"></a>';
                        html = html + '<div class="myclst-popup-content">';
                        html = html + '<div class="twelve columns left product-dtl-area pad-none">';
                        html = html + '<div class="product-dtl-img left"><img src="<?php echo $this->webroot; ?>files/products/'+ this.Image[0].name +'" alt=""/></div>';
                        html = html + '<div class="product-dtl-desc left">';
                        html = html + '<h3>Item Quickview</h3>';
                        html = html + '<div class="product-dtl-desc-top left">';
                        html = html + '<div class="desc-top-brand">'+ this.Entity.name +'| '+ this.Brand.name +'</div>';
                        html = html + '<div class="desc-top-brand-price">$'+ this.Entity.price +'</div>';
                        html = html + '</div>';
                        html = html + '<div class="product-dtl-desc-middle left">';
                        html = html + '<ul>';
                        html = html + '<li><span>&ndash;</span>'+ this.Entity.description +'.</li>';
                        html = html + '</ul>';
                        html = html + '</div>';
                        html = html + '<div class="product-dtl-desc-bottom left">';
                        html = html + '<div class="slect-options left">';
                        html = html + '<div class="select-color select-style left">';
                        html = html + '<span class="selct-arrow"></span>';
                        html = html + '<select>';
                        var entitycolor = this.Color;
                        html = html + '<option>Color</option>';
                        $.each(entitycolor, function(index1){
                            html = html + '<option>'+ entitycolor[index1].name +'</option>';
                        });
                        html = html + '</select>';
                        html = html + '</div>';
                        html = html + '<div class="select-size select-style left">';
                        html = html + '<span class="selct-arrow"></span>';
                        html = html + '<select>';
                        var entitysize = this.Detail;
                        $.each(entitysize, function(index2){
                            html = html + '<option>Size</option>';
                            html = html + '<option>'+ entitysize[index2].size_id +'</option>';
                        });
                        html = html + '</select>';
                        html = html + '</div>';
                        html = html + '<div class="select-quantity select-style left">';
                        html = html + '<span class="selct-arrow"></span>';
                        html = html + '<select>';
                        html = html + '<option>Quantity</option>';
                        html = html + '<option>1</option>';
                        html = html + '<option>2</option>';
                        html = html + '<option>3</option>';
                        html = html + '<option>4</option>';
                        html = html + '<option>5</option>';
                        html = html + '</select>';
                        html = html + '</div>';
                        html = html + '</div>';
                        html = html + '</div>';
                        html = html + '</div>';
                        html = html + '<div class="product-dtl-links left">';
                        html = html + '<a class="product-add-cart" href="javascript:;" title="">Add to Cart</a>';
                        html = html + '<a class="product-my-likes"href="javascript:;" title="">Add to My Likes</a>';
                        html = html + '<div class="product-social-likes">';
                        html = html + '<ul>';
                        html = html + '<li><a class="product-social-likes-pintrest" href="javascript:;" title="">Pintrest</a></li>';
                    html = html + '<li><a class="product-social-likes-facebook" href="javascript:;" title="">Faceboook</a></li>';
                        html = html + '<li><a class="product-social-likes-twitter" href="javascript:;" title="">Twitter</a></li>';
                        html = html + '</ul>';
                        html = html + '</div>';
                        html = html + '</div>';
                        html = html + '</div>';
                        html = html + '</div>';
                        html = html + '</div>';
                        html = html + '</div>';
                        html = html + '</div>';
                    });
                        $("#productquickview").html(html);

                    }
                });


        

    })

     }



        //var firstPageId = 0;

        $("#loadMoreProduct a").on('click', function(e){
            e.preventDefault();
            $this = $(this);
            
            var firstPageId = $("#limit").val();
            //var id = $("p#loadMoreProduct a").attr('id');
            //alert(firstPageId);
            $.ajax({
                url: '<?php echo $this->webroot; ?>messages/closetAjaxProductData',
                cache: false,
                type: 'POST',
                data : {last_limit:firstPageId},
                success: function(data){
                    data = jQuery.parseJSON(data);
                    var e = 20;
                    $("#limit").val(parseInt(firstPageId)+e);
                    html = '';
                    
                         $.each(data,  function (index){
                            html = html + '<li >';
                            html = html + '<a class="myclst-quick-view" href="#">';
                            html = html + '<div class="myclst-prdt-img"><img src="<?php echo $this->webroot; ?>files/products/'+ this.Image[0].name +'" alt="" /></div>';
                            html = html + '<div class="myclst-prdt-overlay">';
                            html = html + '<input type="hidden" value="'+ this.Entity.id +'" id="prid">';
                            html = html + '<h3>'+ this.Entity.name +'</h3>';
                            var desr = this.Entity.description;
                            html = html + '<p>'+ desr.substr(0,25) +'</p>';
                            html = html + '</div>';
                            html = html + '</a>';
                            html = html + '</li>';

                        });
                         //productpopload();
                        
                        $("#listdat").append(html);
                    
                }    
            });
        });

    //get stylist like data
            $("#stylistbookmarks").live("click", function () {
                //var stylist_id = $("#stylist_id").val();

                $.ajax({
                        type:"POST",
                        url:"<?php echo $this->webroot; ?>Messages/getUserLikeAjax/<?php echo $user_id; ?>",
                        //data:{stylist_id:stylist_id},
                        cache: false,
                        success: function(result){
                            //alert(result);
                        data = $.parseJSON(result);
                            html = '';
                            html = html + '<div>';
                            html = html + '<ul>';
            
                        $.each(data,  function (index){
                            html = html + '<li>';
                            html = html + '<a href="#">';
                            html = html + '<div class="myclst-prdt-img"><img src="<?php echo $this->webroot; ?>files/products/'+ this.Image[0].name +'" alt="" /></div>';
                            html = html + '<div class="myclst-prdt-overlay">';
                            html = html + '<h3>'+ this.Entity.name +'</h3>';
                            var desr = this.Entity.description;
                            html = html + '<p>'+ desr.substr(0,25) +'</p>';
                            html = html + '</div>';
                            html = html + '</a>';
                            html = html + '</li>';

                        });
                        html = html + '<ul>';            
                        html = html + '</div>';
                        $(".myclst-prdct-list").html(html);   
                                
                    }
                });
            });

//get closet ajax data 
            $("#closetdata").live("click", function () {
                
                $.ajax({
                        type:"POST",
                        url:"<?php echo $this->webroot; ?>Messages/closetAjaxProductData/<?php echo $user_id ?>",
                        //data:{firstPageId:firstPageId},
                        cache: false,
                        success: function(result){
                            //alert(result);

                        data = $.parseJSON(result);
                            html = '';
                            html = html + '<div  id="updated_div_id">';
                            html = html + '<ul>';
            
                        $.each(data,  function (index){
                            html = html + '<li>';
                            html = html + '<a href="#">';
                            var entityimg = this.Image;
                        $.each(entityimg,  function (index1){
                            html = html + '<div class="myclst-prdt-img"><img src="<?php echo $this->webroot; ?>files/products/'+ entityimg[index1].name +'" alt="" /></div>';
                        });
                            html = html + '<div class="myclst-prdt-overlay">';
                            html = html + '<h3>'+ this.Entity.name +'</h3>';
                            var desr = this.Entity.description;
                            html = html + '<p>'+ desr.substr(0,25) +'</p>';
                            html = html + '</div>';
                            html = html + '</a>';
                            html = html + '</li>';

                        });
                        html = html + '<ul>';            
                        html = html + '</div>';
                        $(".myclst-prdct-list").html(html);   
                                
                    }
                });
            });

        var myCheckboxescolour = new Array();
        var mycolour;
        var myCheckboxesbrand = new Array();
        var mybrand;
        var myCheckboxessubcategory = new Array();
        var mysubcategory;
        $('.colorsearch').live("click",function() {
            var firstPageId = '<?php echo $ProductRowCount; ?>';
                mycolour='';
                mybrand='';
                mysubcategory='';
                if(jQuery(this).attr('title')=='colour')
                {    
                    if(this.checked==true)
                    {
                        myCheckboxescolour.push(jQuery(this).val());
                    }
                    else
                    {   
                        removindexitem =new Array(); 
                        removindexitem= jQuery.inArray(jQuery(this).val(), myCheckboxescolour);// Uncheckbox here 
                        myCheckboxescolour.splice(removindexitem ,1);
                    
                    }
                }
                else if(jQuery(this).attr('title')=='brand')
                {    
                    if(this.checked==true)
                    {
                        myCheckboxesbrand.push(jQuery(this).val());
                    }
                    else
                    {   
                        removindexitem =new Array(); 
                        removindexitem= jQuery.inArray(jQuery(this).val(), myCheckboxesbrand);// Uncheckbox here 
                        myCheckboxesbrand.splice(removindexitem ,1);
                    
                    }
                }
                else if(jQuery(this).attr('title')=='subcategory')
                {    
                    if(this.checked==true)
                    {
                        myCheckboxessubcategory.push(jQuery(this).val());
                    }
                    else
                    {   
                        removindexitem =new Array(); 
                        removindexitem= jQuery.inArray(jQuery(this).val(), myCheckboxessubcategory);// Uncheckbox here 
                        myCheckboxessubcategory.splice(removindexitem ,1);
                    
                    }
                }
                mycolour = myCheckboxescolour.join(",");
                mybrand = myCheckboxesbrand.join(",");
                mysubcategory = myCheckboxessubcategory.join(",");
                //console.log(mybrand);
                $.ajax({
                        type:"POST",
                        url:"<?php echo $this->webroot; ?>messages/closetAjaxColorProductSearchData",
                        data:{colorid:mycolour,brandid:mybrand,subcategoryid:mysubcategory,firstPageId:firstPageId},
                        cache: false,
                        success: function(result){
                            var e = 10;
                     $("#limit").val(parseInt(firstPageId)+e);
                            data = $.parseJSON(result);
                            html = '';
                            html = html + '<div>';
                            html = html + '<ul>';
            
                        $.each(data,  function (index){
                            html = html + '<li>';
                            html = html + '<a href="#">';
                            var entityimg = this.Image;
                        $.each(entityimg,  function (index1){
                            html = html + '<div class="myclst-prdt-img"><img src="<?php echo $this->webroot; ?>files/products/'+ entityimg[index1].name +'" alt="" /></div>';
                        });
                            html = html + '<div class="myclst-prdt-overlay">';
                            html = html + '<h3>'+ this.Entity.name +'</h3>';
                            var desr = this.Entity.description;
                            html = html + '<p>'+ desr.substr(0,25) +'</p>';
                            html = html + '</div>';
                            html = html + '</a>';
                            html = html + '</li>';

                        });
                        html = html + '<ul>';            
                        html = html + '</div>';
                        $(".myclst-prdct-list").append(html);
                        // if(firstPageId >= 10){
                        //     $(".myclst-prdct-list").append(html);
                        // }else{


                        // $(".myclst-prdct-list").html(html); 
                        // }    
                    }
                });
            });


    // closet product popup quick view

    $(document).on('click', ".myclst-quick-view",function(){
        $this = $(this);
        var productBlock = $this.closest(".myclst-quick-view");
        var productid = productBlock.find("#prid").val();
        //alert(id);
                $.ajax({
                        type:"POST",
                        url:"<?php echo $this->webroot; ?>Messages/closetAjaxQuickPopData/<?php echo $user_id ?>",
                        data:{productid:productid},
                        cache: false,
                        success: function(result){
                            //alert(result);

                        data = $.parseJSON(result);
                        html = '';
                        $.each(data, function(index){
                        html = html + '<div id="myclst-popup" style="display: none">';
                        html = html + '<div class="box-modal">';
                        html = html + '<div class="box-modal-inside">';
                        html = html + '<a href="#" title="" class="otft-close"></a>';
                        html = html + '<div class="myclst-popup-content">';
                        html = html + '<div class="twelve columns left product-dtl-area pad-none">';
                        html = html + '<div class="product-dtl-img left"><img src="<?php echo $this->webroot; ?>files/products/'+ this.Image[0].name +'" alt=""/></div>';
                        html = html + '<div class="product-dtl-desc left">';
                        html = html + '<h3>Item Quickview</h3>';
                        html = html + '<div class="product-dtl-desc-top left">';
                        html = html + '<div class="desc-top-brand">'+ this.Entity.name +'| '+ this.Brand.name +'</div>';
                        html = html + '<div class="desc-top-brand-price">$'+ this.Entity.price +'</div>';
                        html = html + '</div>';
                        html = html + '<div class="product-dtl-desc-middle left">';
                        html = html + '<ul>';
                        html = html + '<li><span>&ndash;</span>'+ this.Entity.description +'.</li>';
                        html = html + '</ul>';
                        html = html + '</div>';
                        html = html + '<div class="product-dtl-desc-bottom left">';
                        html = html + '<div class="slect-options left">';
                        html = html + '<div class="select-color select-style left">';
                        html = html + '<span class="selct-arrow"></span>';
                        html = html + '<select>';
                        var entitycolor = this.Color;
                        html = html + '<option>Color</option>';
                        $.each(entitycolor, function(index1){
                            html = html + '<option>'+ entitycolor[index1].name +'</option>';
                        });
                        html = html + '</select>';
                        html = html + '</div>';
                        html = html + '<div class="select-size select-style left">';
                        html = html + '<span class="selct-arrow"></span>';
                        html = html + '<select class="product-size">';
                        html = html + '<option>Size</option>';
                        var entitysize = this.Detail;
                        $.each(entitysize, function(index2){
                            html = html + '<option>'+ entitysize[index2].size_id +'</option>';
                        });
                        html = html + '</select>';
                        html = html + '</div>';
                        html = html + '<div class="select-quantity select-style left">';
                        html = html + '<span class="selct-arrow"></span>';
                        html = html + '<select class="product-quantity">';
                        html = html + '<option>Quantity</option>';
                        html = html + '<option>1</option>';
                        html = html + '<option>2</option>';
                        html = html + '<option>3</option>';
                        html = html + '<option>4</option>';
                        html = html + '<option>5</option>';
                        html = html + '</select>';
                        html = html + '</div>';
                        html = html + '</div>';
                        html = html + '</div>';
                        html = html + '</div>';
                        html = html + '<div class="product-dtl-links left">';
                        
                        html = html + '<a href="#" class="link-btn gold-btn add-to-cart full-width text-center" data-product_id="'+ this.Entity.id +'">ADD TO CART</a>';
                        html = html + '<a class="product-my-likes" href="#" title="">Add to My Likes</a>';
                        html = html + '<input type="hidden" id="productId" class="product-id" value="'+ this.Entity.id +'">';
                        html = html + '<input type="hidden" value="'+ this.Entity.slug +'" class="product-slug">';
                        html = html + '<div class="product-social-likes">';
                        html = html + '<ul>';
                        html = html + '<li><a class="product-social-likes-pintrest" href="javascript:;" title="">Pintrest</a></li>';
                    html = html + '<li><a class="product-social-likes-facebook" href="javascript:;" title="">Faceboook</a></li>';
                        html = html + '<li><a class="product-social-likes-twitter" href="javascript:;" title="">Twitter</a></li>';
                        html = html + '</ul>';
                        html = html + '</div>';
                        html = html + '</div>';
                        html = html + '</div>';
                        html = html + '</div>';
                        html = html + '</div>';
                        html = html + '</div>';
                        html = html + '</div>';
                    });
                        $("#productquickview").html(html);

                    }
                });


        

    });


});
</script>
<script type="text/javascript">
    $(document).ready(function(){


    $(document).on("click", ".product-my-likes",function(e) {
        e.preventDefault();
        $this = $(this);
            var productBlock = $this.closest(".product-dtl-links");
        var productid = productBlock.find("#productId").val();
        alert(productid);
        //console.log(productId);
             $.ajax({
                type:"POST",
                url:"<?php echo $this->webroot; ?>api/wishlist/save",
                data:{product_id:productid,},
                cache: false,
                success: function(result){    
                var ret = $.parseJSON(data);
                if(ret["status"] == "ok"){
                    $this.addClass("liked");
                    $this.closest(".product-my-likes").text("Liked");
                }
            }

        });
        
    });
});

</script>
<?php
$logged_script = '';
if($user_id){    
$logged_script 
?>

<?php
}
$logged_script = '';
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

$(document).on("click", ".add-to-cart", function(e) {
    
e.preventDefault();
var productBlock = $(this).closest(".box-modal"),
productQuantity = productBlock.find("select.product-quantity").val(),
productSize = productBlock.find("select.product-size").val();
alert(productQuantity);
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
alert(id);
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
alert(id);
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
productpopload();
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



<div class="content-container">
    <div class="twelve columns black">
        <div class="eleven columns container">
            <div class="twelve columns container left ">
                <div class="ten columns left admin-nav">
                    <ul>
                        <li class="active"><a href="#" title="">My Clients</a></li>
                        <li><a href="#" title="">Dashboard</a></li>
                        <li><a href="#" title="">My outfits</a></li>
                        <li><a href="#" title="">The CLoset</a></li>
                    </ul>
                </div>
                <div class="two columns right admin-top-right">
                    <ul>
                        <li><a href="#" title=""><img class="cart-icons" src="<?php echo $this->webroot; ?>images/cart-icon.png" alt="" />(<span class="no-of-items">0</span>) </a></li>
                        <li>
                            <a href="#" title=""><span class="client-nav-switcher"><img src="<?php echo $this->webroot; ?>images/menu-dropdown-icon.png" alt="" /></span></a>
                            <div class="admin-top-right-dropdown">
                                <ul>
                                    <li><a href="#" title="">view my cart/checkout</a></li>
                                    <li><a href="#" title="">refer a friend</a></li>
                                    <li><a href="#" title="">sign out</a></li>
                                </ul>
                            </div>
                        </li>

                    </ul>    
                </div>
            </div>
        </div>
        
    </div>
    <div class="twelve columns container">
        <div class="eleven columns container message-box-area">
            <div class="twelve columns container left message-box">
                <div class="eleven columns container">
                    <div class="twelve columns left mycloset-section">
                        <div class="twelve columns left myclst-rgt-heading">
                                <div class="eleven columns container myclst-nav-section ">
                                    <div class="seven columns left myclst-rgt-nav">
                                        <ul>
                                            <li class="active"><a href="#" title="" id="closetdata">The Closet</a>
                                                <ul>
                                                <div class="ctg-one">
                                                    <div id="scrollbar3">
                                                        <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
                                                            <div class="viewport">
                                                                 <div class="overview">
                                                                    <?php foreach ($categories as $category): ?>
                                                                    <h3><?php echo $category['Category']['name']; ?></h3>
                                                                        <?php if ($category['children']) : ?>
                                                                            <?php foreach ($category['children'] as $subcategory): ?>
                                                                                <input type="checkbox" name="" title="subcategory" class="colorsearch" value="<?php echo $subcategory['Category']['id']; ?>" id="s<?php echo $subcategory['Category']['id']; ?>" data-category_id="<?php echo $subcategory['Category']['id']; ?>" />
                                                                                <label for="s<?php echo $subcategory['Category']['id']; ?>" class=""><?php echo $subcategory['Category']['name']; ?><span></span></label>
                                                                            <?php endforeach; ?>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                

                                                
                                                    <div class="ctg-one third-block">
                                                        <div id="scrollbar4">
                                                        <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
                                                            <div class="viewport">
                                                                 <div class="overview">
                                                                    <h3>Brands</h3>
                                                                    <?php if($brands) : ?>
                                                                        <?php foreach($brands as $brand) : ?>
                                                                            <input type="checkbox" name="" title="brand" class="colorsearch" value="<?php echo $brand['Brand']['id']; ?>" id="b<?php echo $brand['Brand']['id']; ?>" data-brand_id="<?php echo $brand['Brand']['id']; ?>" />
                                                                            <label for="b<?php echo $brand['Brand']['id']; ?>" class=""><?php echo $brand['Brand']['name']; ?><span></span></label>
                                                                        <?php endforeach; ?>
                                                                    <?php endif; ?>


                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="ctg-one forth-block">
                                                        <div id="scrollbar5">
                                                        <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
                                                            <div class="viewport">
                                                                 <div class="overview">
                                                                    <h3>Colors</h3>

                                                                    <?php if($colors) : ?>
                                                                        <?php foreach($colors as $color) :?>
                                                                            <input type="checkbox" name="color[]" title="colour" class="colorsearch" data-color_id="<?php echo $color['Colorgroup']['id']; ?>" value="<?php echo $color['Colorgroup']['id']; ?>" id="c<?php echo $color['Colorgroup']['id']; ?>" />
                                                                            <label for="c<?php echo $color['Colorgroup']['id']; ?>"  class=""><?php echo $color['Colorgroup']['name']; ?><span></span></label>
                                                                        <?php endforeach; ?>
                                                                    <?php endif; ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </ul>
                                            </li>
                                            <li><a href="#" title="" id="stylistbookmarks">My Bookmarks</a></li>
                                            <li><a href="#" title="">Purchased Items</a></li>
                                        </ul>
                                    </div>
                                    <div class="myclst-right-top">
                                        <div class="myclst-right-top-srch">
                                            <span></span>
                                            <input type="text" name="" />
                                        </div>
                                        <div class="myclst-right-top-srt">
                                            <select>
                                                <option>Sort By</option>
                                                <option>Sort By</option>
                                                <option>Sort By</option>
                                                <option>Sort By</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="twelve columns left myclst-prdct-list" id="findproductid">
                                <div id="posts-list">
                                    <ul id="listdat">

                                    <?php  for($i = 0; $i < count($products); $i++){
                                                $product = $products[$i];
                                                //print_r($product);
                                                    ?>
                                        <li>
                                            <a class="myclst-quick-view" href="#">
                                            <?php //foreach ($product['Image'] as $images):?>
                                            
                                                <div class="myclst-prdt-img" ><img src="<?php echo $this->webroot; ?>files/products/<?php echo $product['Image'][0]['name']; ?>" alt="" /></div>
                                            <?php //endforeach; ?>
                                               <div class="myclst-prdt-overlay">

                                                    <input type="hidden" value="<?php echo $product['Entity']['id']; ?>" id="prid">
                                                    <h3><?php echo $product['Entity']['name']; ?></h3>
                                                    <p><?php echo substr($product['Entity']['description'],0,25); ?></p>
                                                </div>
                                            </a>
                                        </li>
                                    <?php } ?>

                                       
                                       

                                    </ul>
                                </div>
                            </div>
                            
                            
                            <p id="loadMoreProduct">
                                <span class="hide"><img src="<?php echo $this->webroot; ?>img/ajax-loader.gif" width="20" /></span>
                                <input type="hidden" id="limit" value="<?php echo $ProductRowCount; ?>">
                                <a href="" id="<?php echo $ProductRowCount; ?>">Load More Products</a>
                            </p>
                            
                        </div>
                    </div>
                
                
                
                <!--pop up quick view-->

                <div id="productquickview"></div>

                <!--popup quick view-->
                
                
                
                
            </div>
        </div>
    </div>
</div>
