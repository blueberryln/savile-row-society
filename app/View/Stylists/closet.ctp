<script type="text/javascript">
var sizes = <?php echo json_encode($sizes); ?>;
$(document).ready(function(){
    var userId = (<?php echo $user_id; ?> > 0) ? <?php echo $user_id; ?> : 0;

    if(userId == 0){
        location = '/messages/index';
    }

    $('.myclst-rgt-nav .tab-nav>a').on('click', function(e){
        e.preventDefault();
        $('.myclst-rgt-nav li').removeClass('active');
        $(this).closest('li').addClass('active');
        $('#listPage').val(1);

        $('.colorsearch:checked').each(function(){
            $(this).attr('checked', false);
        });
        $('.closet-tab label').removeClass('checked');

        if($(this).closest('li').hasClass('closet-tab')){
            loadProducts(true);
        }
        else if($(this).closest('li').hasClass('bookmark-tab')){
            loadBookmark(true);
        }
        else if($(this).closest('li').hasClass('purchased-tab')){
            loadPurchased(true);
        }
    });

    var currentRequest = false;

    $('#load-more').on('click', function(e){
        e.preventDefault();
        var activeTab = $('.myclst-rgt-nav li.active');

        if(activeTab.hasClass('closet-tab')){
            loadProducts();
        }
        else if(activeTab.hasClass('bookmark-tab')){
            loadBookmark();
        }
        else if(activeTab.hasClass('purchased-tab')){
            loadPurchased();
        }
    });

    $('.colorsearch').on('click', function(){
        if(!$('.closet-tab').hasClass('active')){
            $('.myclst-rgt-nav li').removeClass('active');
            $('.closet-tab').addClass('active');
        }
        $('#listPage').val(1);
        loadProducts(true);
    });

    $('#closettextsearch').on('input', function(){
        $('#listPage').val(1);

        var activeTab = $('.myclst-rgt-nav li.active');

        if(activeTab.hasClass('closet-tab')){
            loadProducts(true);
        }
        else if(activeTab.hasClass('bookmark-tab')){
            loadBookmark(true);
        }
        else if(activeTab.hasClass('purchased-tab')){
            loadPurchased(true);
        }
    });

    $('#sortbydate').on('change', function(){
       $('#listPage').val(1);
       var activeTab = $('.myclst-rgt-nav li.active');

        if(activeTab.hasClass('closet-tab')){
            loadProducts(true);
        }
        else if(activeTab.hasClass('bookmark-tab')){
            loadBookmark(true);
        }
        else if(activeTab.hasClass('purchased-tab')){
            loadPurchased(true);
        }
    });

    function loadProducts(reset){
        if(currentRequest){
            currentRequest.abort();
        }

        if(typeof reset == 'undefined'){
            reset = false;
        }

        var productCont = $('#listdat'),
            pageVal = parseInt($('#listPage').val()),
            searchText = $('#closettextsearch').val(),
            sortOrder = $('#sortbydate').val(),
            strBrand = '',
            strColor = '',
            strCategory = '',
            arrBrand = new Array(),
            arrColor = new Array(),
            arrCategory = new Array();

        $(".colorsearch:checked").each(function(){
            if($(this).hasClass('check-category')){
                arrCategory.push($(this).val());
            }
            else if($(this).hasClass('check-brand')){
                arrBrand.push($(this).val());
            }
            else if($(this).hasClass('check-color')){
                arrColor.push($(this).val());
            }
        });

        strColor = arrColor.join('-');
        strCategory = arrCategory.join('-');
        strBrand = arrBrand.join('-');
            

        currentRequest = $.ajax({
            url: '/stylists/closet',
            type: 'POST',
            cache: false,
            data: {
                user_id: userId,
                page: pageVal,
                search_text: searchText,
                sort: sortOrder,
                str_brand: strBrand,
                str_color: strColor,
                str_category: strCategory
            },
            success: function(data){
                var ret = $.parseJSON(data);

                if(reset){
                    productCont.html('');
                    $('#load-more').show();
                }
                if(ret['status'] == 'ok'){
                    $('#listPage').val(pageVal + 1);
                    var entities = ret['entities'];
                    for(var i = 0; i < entities.length; i++ ){
                        var product = entities[i];
                        var productImage = '';
                        var productImageUrl = '';

                        if(product['Image'].length > 0){
                            productImage = '<div class="myclst-prdt-img">' + 
                                                '<img src="<?php echo $this->webroot; ?>files/products/' + product['Image'][0]['name'] + '" alt="" />' + 
                                            '</div>';

                            productImageUrl = '<?php echo $this->webroot; ?>files/products/' + product['Image'][0]['name'];
                        }
                        else{
                            productImage = '<div class="myclst-prdt-img">' + 
                                                '<img src="<?php echo $this->webroot; ?>images/image_not_available.png" alt="" />' + 
                                            '</div>';

                            productImageUrl = '<?php echo $this->webroot; ?>images/image_not_available.png';
                        }

                        var sizeOptions = '';
                        for(var j=0; j<product['Detail'].length; j++){
                            sizeOptions += '<option value="' + product['Detail'][j]['size_id'] + '">' + sizes[product['Detail'][j]['size_id']] + '</option>';
                        }

                        var wishlist = (product['Wishlist']['product_entity_id'] == product['Entity']['id']) ? 1 : 0;

                        var html = '<li ' +  
                                        'data-name="' + product['Entity']['name'] + '" ' + 
                                        'data-desc="' + product['Entity']['description'] + '" ' +
                                        'data-image="' + productImageUrl + '" ' + 
                                        'data-id="' + product['Entity']['id'] + '" ' + 
                                        'data-price="' + product['Entity']['price'] + '" ' + 
                                        'data-brand="' + product['Brand']['name'] + '" ' +
                                        'data-wishlist="' + wishlist + '"' + 
                                        '>' + 
                                        '<select class="hide product-size-list">' +
                                            sizeOptions +         
                                        '</select>' +
                                        '<a class="myclst-quick-view" href="#">' + 
                                            productImage +
                                            '<div class="myclst-prdt-overlay">' + 
                                                '<input type="hidden" value="' + product['Entity']['id'] + '" id="prid">' + 
                                                '<h3>' + product['Entity']['name'] + '</h3>' + 
                                                '<p>' + product['Entity']['description'] + '</p>' + 
                                            '</div>' +
                                        '</a>' + 
                                    '</li>';

                        productCont.append(html);
                    }
                }
                else if(ret['status'] == 'redirect'){
                    location = '/messages/index';
                }
                else{
                    $('#load-more').hide();
                }
            }

        });

    } 


    function loadBookmark(reset){
        if(currentRequest){
            currentRequest.abort();
        }

        if(typeof reset == 'undefined'){
            reset = false;
        }

        var productCont = $('#listdat'),
            pageVal = parseInt($('#listPage').val()),
            searchText = $('#closettextsearch').val(),
            sortOrder = $('#sortbydate').val();

        currentRequest = $.ajax({
            url: '/stylists/likes',
            type: 'POST',
            cache: false,
            data: {
                user_id: userId,
                page: pageVal,
                search_text: searchText,
                sort: sortOrder
            },
            success: function(data){
                var ret = $.parseJSON(data);

                if(reset){
                    productCont.html('');
                    $('#load-more').show();
                }
                if(ret['status'] == 'ok'){
                    $('#listPage').val(pageVal + 1);
                    var entities = ret['entities'];
                    for(var i = 0; i < entities.length; i++ ){
                        var product = entities[i];
                        var productImage = '';

                        if(product['Image'].length > 0){
                            productImage = '<div class="myclst-prdt-img">' + 
                                                '<img src="<?php echo $this->webroot; ?>files/products/' + product['Image'][0]['name'] + '" alt="" />' + 
                                            '</div>';
                        }
                        else{
                            productImage = '<div class="myclst-prdt-img">' + 
                                                '<img src="<?php echo $this->webroot; ?>images/image_not_available.png" alt="" />' + 
                                            '</div>';
                        }

                        var sizeOptions = '';
                        for(var j=0; j<product['Detail'].length; j++){
                            sizeOptions += '<option value="' + product['Detail'][j]['size_id'] + '">' + sizes[product['Detail'][j]['size_id']] + '</option>';
                        }

                        var wishlist = (product['Wishlist']['product_entity_id'] == product['Entity']['id']) ? 1 : 0;

                        var html = '<li ' + 
                                        'data-name="' + product['Entity']['name'] + '" ' + 
                                        'data-desc="' + product['Entity']['description'] + '" ' +
                                        'data-image="<?php echo $this->webroot; ?>files/products/' + product['Image'][0]['name'] + '" ' + 
                                        'data-id="' + product['Entity']['id'] + '" ' + 
                                        'data-price="' + product['Entity']['price'] + '" ' + 
                                        'data-brand="' + product['Brand']['name'] + '" ' +
                                        'data-wishlist="' + wishlist + '"' + 
                                        '>' + 
                                        '<select class="hide product-size-list">' +
                                            sizeOptions +         
                                        '</select>' +
                                        '<a class="myclst-quick-view" href="#">' + 
                                            productImage +
                                            '<div class="myclst-prdt-overlay">' + 
                                                '<input type="hidden" value="' + product['Entity']['id'] + '" id="prid">' + 
                                                '<h3>' + product['Entity']['name'] + '</h3>' + 
                                                '<p>' + product['Entity']['description'] + '</p>' + 
                                            '</div>' +
                                        '</a>' + 
                                    '</li>';

                        productCont.append(html);
                    }
                }
                else{
                    $('#load-more').hide();
                }
            }

        });

    } 


    function loadPurchased(reset){
        if(currentRequest){
            currentRequest.abort();
        }

        if(typeof reset == 'undefined'){
            reset = false;
        }

        var productCont = $('#listdat'),
            pageVal = parseInt($('#listPage').val()),
            searchText = $('#closettextsearch').val(),
            sortOrder = $('#sortbydate').val();

        currentRequest = $.ajax({
            url: '/stylists/purchased',
            type: 'POST',
            cache: false,
            data: {
                user_id: userId,
                page: pageVal,
                search_text: searchText,
                sort: sortOrder
            },
            success: function(data){
                var ret = $.parseJSON(data);

                if(reset){
                    productCont.html('');
                    $('#load-more').show();
                }
                if(ret['status'] == 'ok'){
                    $('#listPage').val(pageVal + 1);
                    var entities = ret['entities'];
                    for(var i = 0; i < entities.length; i++ ){
                        var product = entities[i];
                        var productImage = '';

                        if(product['Image'].length > 0){
                            productImage = '<div class="myclst-prdt-img">' + 
                                                '<img src="<?php echo $this->webroot; ?>files/products/' + product['Image'][0]['name'] + '" alt="" />' + 
                                            '</div>';
                        }
                        else{
                            productImage = '<div class="myclst-prdt-img">' + 
                                                '<img src="<?php echo $this->webroot; ?>images/image_not_available.png" alt="" />' + 
                                            '</div>';
                        }

                        var sizeOptions = '';
                        for(var j=0; j<product['Detail'].length; j++){
                            sizeOptions += '<option value="' + product['Detail'][j]['size_id'] + '">' + sizes[product['Detail'][j]['size_id']] + '</option>';
                        }

                        var wishlist = (product['Wishlist']['product_entity_id'] == product['Entity']['id']) ? 1 : 0;

                        var html = '<li ' + 
                                        'data-name="' + product['Entity']['name'] + '" ' + 
                                        'data-desc="' + product['Entity']['description'] + '" ' +
                                        'data-image="<?php echo $this->webroot; ?>files/products/' + product['Image'][0]['name'] + '" ' + 
                                        'data-id="' + product['Entity']['id'] + '" ' + 
                                        'data-price="' + product['Entity']['price'] + '" ' + 
                                        'data-brand="' + product['Brand']['name'] + '" ' +
                                        'data-wishlist="' + wishlist + '"' + 
                                        '>' + 
                                        '<select class="hide product-size-list">' +
                                            sizeOptions +         
                                        '</select>' +
                                        '<a class="myclst-quick-view" href="#">' + 
                                            productImage +
                                            '<div class="myclst-prdt-overlay">' + 
                                                '<input type="hidden" value="' + product['Entity']['id'] + '" id="prid">' + 
                                                '<h3>' + product['Entity']['name'] + '</h3>' + 
                                                '<p>' + product['Entity']['description'] + '</p>' + 
                                            '</div>' +
                                        '</a>' + 
                                    '</li>';

                        productCont.append(html);
                    }
                }
                else{
                    $('#load-more').hide();
                }
            }

        });

    } 

    $('#listdat').on('click', '.myclst-quick-view', function(e){
        e.preventDefault();
        var productBlock = $(this).closest('li');

        var image = productBlock.data('image'),
            name = productBlock.data('name'),
            desc = productBlock.data('desc'),
            brand = productBlock.data('brand'),
            price = productBlock.data('price'),
            productid = productBlock.data('id'),
            wishlist = productBlock.data('wishlist'),
            sizes = productBlock.find('.product-size-list').html();

            if(wishlist){
                var addLikes = '<a class="product-my-likes liked" href="javascript:;" title="" data-product_id="' + productid + '">Liked</a>';
            }
            else{
                var addLikes = '<a class="product-my-likes" href="javascript:;" title="" data-product_id="' + productid + '">Add to My Likes</a>';
            }

            if(sizes != ""){
                sizeBox = '<div class="select-size select-style left">' +
                    '<span class="selct-arrow"></span>' +
                    '<select>' +
                    sizes +     
                    '</select>' +
                '</div>';
            }
            else{
                sizeBox = "";
            }

        var html = '<div class="twelve columns left product-dtl-area pad-none">' + 
                        '<div class="product-dtl-img left"><img src="' + image + '" alt=""/></div>' + 
                        '<div class="product-dtl-desc left">' + 
                            '<h3>Item Quickview</h3>' + 
                            '<div class="product-dtl-desc-top left">' + 
                                '<div class="desc-top-brand">' + brand + '</div>' +
                                '<div class="desc-top-brand-price">$' + price + '</div>' +
                            '</div>' +
                            '<div class="product-dtl-desc-middle left"><ul><li>' +
                            desc +
                            '</li></ul></div>' +
                            '<div class="product-dtl-desc-bottom left" style="width: 100%">' +
                                '<div class="slect-options left">' +
                                    sizeBox + 
                                    '<div class="select-quantity select-style left">' +
                                        '<span class="selct-arrow"></span>' +
                                        '<select>' +
                                            '<option>1</option>' +
                                            '<option>2</option>' +
                                            '<option>3</option>' +
                                            '<option>4</option>' +
                                            '<option>5</option>' +
                                        '</select>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                        '<div class="product-dtl-links left">' +
                            '<a class="product-add-cart" href="javascript:;" title="" data-product_id="' + productid + '">Add to Cart</a>' +
                            addLikes +
                        '</div>' +
                    '</div>';

        $("#myclst-popup .myclst-popup-content").html(html);

        var blockTop = $(window).height()/2 - $("#myclst-popup").height()/2;
        $.blockUI({message: $('#myclst-popup'), css: {position: "absolute", top: (blockTop > 0) ? blockTop : "0px"}});
        $('.blockOverlay').click($.unblockUI);
    });



    $("#myclst-popup").on('click', '.product-my-likes', function(e) {
        e.preventDefault();
            $this = $(this);
            var productId = $this.data("product_id");

            if($this.hasClass('liked')){
                $.post("/api/wishlist/remove", { product_id: productId},
                    function(data) {
                        var ret = $.parseJSON(data);
                        if(ret["status"] == "ok"){
                            $this.removeClass("liked");
                            $this.closest(".product-my-likes").text("Add to My Likes");
                        }
                    }
                );
            }
            else{
                $.post("/api/wishlist/save", { product_id: productId},
                    function(data) {
                        var ret = $.parseJSON(data);
                        if(ret["status"] == "ok"){
                            $this.addClass("liked");
                            $this.closest(".product-my-likes").text("Liked");
                        }
                    }
                );
            }
    });


    $("#myclst-popup").on('click', '.product-add-cart', function(e) {
        e.preventDefault();
        $this = $(this);
        var productBlock = $(this).closest(".myclst-popup-content"),
        productQuantity = productBlock.find(".select-quantity select").val(),
        productSize = productBlock.find(".select-size select").val();

        var id = $this.data("product_id");
        var quantity = parseInt(productQuantity);
        var size = productSize;
        var outfitId = 0;

        $.post("/api/cart/save", { product_id: id, product_quantity: quantity, product_size: size, outfit_id: outfitId },
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
    
    

});
</script>
<?php
$this->Html->script("jquery.elevateZoom-3.0.8.min.js", array('inline' => false));
$this->Html->script("mosaic.1.0.1.min.js", array('inline' => false));
$this->Html->script("jquery.colorbox-min.js", array('inline' => false));
$this->Html->css('colorbox', null, array('inline' => false));

?>



    <div class="twelve columns container">
        <div class="eleven columns container message-box-area">
            <div class="twelve columns container left message-box">
                <div class="eleven columns container">
                    <div class="twelve columns left mycloset-section">
                        <div class="twelve columns left myclst-rgt-heading">
                                <div class="eleven columns container myclst-nav-section ">
                                    <div class="seven columns left myclst-rgt-nav">
                                        <ul>
                                            <li class="active closet-tab tab-nav"><a href="#" title="" id="closetdata">The Closet</a>
                                                <ul>
                                                <div class="ctg-one">
                                                    <div id="scrollbar3">
                                                        <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
                                                            <div class="viewport">
                                                                 <div class="overview">
                                                                    <?php foreach ($categories as $category): ?>
                                                                    <h3>
                                                                        <input type="checkbox" name="" title="category" class="colorsearch check-category" value="<?php echo $category['Category']['id']; ?>" id="ca<?php echo $category['Category']['id']; ?>" data-category_id="<?php echo $category['Category']['id']; ?>" />
                                                                        <label for="ca<?php echo $category['Category']['id']; ?>" class=""><?php echo $category['Category']['name']; ?><span></span></label>
                                                                    </h3>
                                                                        <?php if ($category['children']) : ?>
                                                                            <?php foreach ($category['children'] as $subcategory): ?>
                                                                                <input type="checkbox" name="" title="subcategory" class="colorsearch check-category" value="<?php echo $subcategory['Category']['id']; ?>" id="s<?php echo $subcategory['Category']['id']; ?>" data-category_id="<?php echo $subcategory['Category']['id']; ?>" />
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
                                                                            <input type="checkbox" name="" title="brand" class="colorsearch check-brand" value="<?php echo $brand['Brand']['id']; ?>" id="b<?php echo $brand['Brand']['id']; ?>" data-brand_id="<?php echo $brand['Brand']['id']; ?>" />
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
                                                                            <input type="checkbox" name="color[]" title="colour" class="colorsearch check-color" data-color_id="<?php echo $color['Colorgroup']['id']; ?>" value="<?php echo $color['Colorgroup']['id']; ?>" id="c<?php echo $color['Colorgroup']['id']; ?>" />
                                                                            <label for="c<?php echo $color['Colorgroup']['id']; ?>"  class=""><?php echo $color['Colorgroup']['name']; ?><span></span></label>
                                                                        <?php endforeach; ?>
                                                                    <?php endif; ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </ul>
                                            </li>
                                            <li class="bookmark-tab tab-nav"><a href="#" title="" id="stylistbookmarks">My Bookmarks</a></li>
                                            <li class="purchased-tab tab-nav"><a href="#" title="">Purchased Items</a></li>
                                        </ul>
                                    </div>
                                    <div class="myclst-right-top">
                                        <div class="myclst-right-top-srch">
                                            <span></span>
                                            <input type="text" name="" id="closettextsearch" />
                                        </div>
                                        <div class="myclst-right-top-srt">
                                            <select id="sortbydate">
                                                <option>Sort</option>
                                                <option value="pricedesc">Sort By Price DESC</option>
                                                <option value="priceasc"> Sort By Price ASC</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="twelve columns left myclst-prdct-list" >
                                <div id="posts-list">
                                    <ul id="listdat">
                                        <?php  for($i = 0; $i < count($entities); $i++){
                                            $product = $entities[$i];
                                            $wishlist = ($product['Wishlist']['product_entity_id'] == $product['Entity']['id']) ? 1 : 0;
                                        ?>
                                            <li data-name="<?php echo $product['Entity']['name']; ?>" data-desc="<?php echo $product['Entity']['description']; ?>" data-image="<?php echo $this->webroot; ?>files/products/<?php echo $product['Image'][0]['name']; ?>" data-id="<?php echo $product['Entity']['id']; ?>" data-price="<?php echo $product['Entity']['price']; ?>" data-brand="<?php echo $product['Brand']['name']; ?>" data-wishlist="<?php echo $wishlist; ?>">

                                                <select class="hide product-size-list">
                                                <?php 
                                                    foreach ($product['Detail'] as $key => $details) 
                                                { ?>
                                                        <option value="<?php echo $details['size_id']; ?>"><?php echo $sizes[$details['size_id']]; ?></option>
                                                <?php 
                                                    } 
                                                ?>
                                                </select>
                                                <a class="myclst-quick-view" href="#">
                                                <?php //foreach ($product['Image'] as $images):?>
                                                
                                                    <div class="myclst-prdt-img"><img src="<?php echo $this->webroot; ?>files/products/<?php echo $product['Image'][0]['name']; ?>" alt="" /></div>
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
                                <input type="hidden" id="listPage" value="<?php echo $page + 1; ?>">
                                <a href="" id="load-more">Load More Products</a>
                            </p>
                            
                        </div>
                    </div>
                
                
                
                <!--pop up quick view-->

                <div id="myclst-popup" style="display: none">
                    <div class="box-modal">
                        <div class="box-modal-inside">
                            <a href="#" title="" class="otft-close"></a>
                            <div class="myclst-popup-content">
                                
                            </div>
                        </div>
                    </div>
                </div>

                <!--popup quick view-->
                
                
                
                
            </div>
        </div>
    </div>
</div>
