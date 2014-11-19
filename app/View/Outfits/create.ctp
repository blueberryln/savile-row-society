<script>

var overall = 0;
var userId = (<?php echo $user_id; ?> > 0) ? <?php echo $user_id; ?> : 0;
var stylistId = (<?php echo $stylist_id; ?> > 0) ? <?php echo $stylist_id; ?> : 0;
var sizes = <?php echo json_encode($sizes); ?>;

function dragAndDropOutfit(){
    // jQuery UI Draggable
    $("#product li").draggable({
        // brings the item back to its place when dragging is over
        revert:true,

        // once the dragging starts, we decrease the opactiy of other items
        // Appending a class as we do that with CSS
        drag:function () {
            $(this).addClass("active");
            $(this).closest("#product").addClass("active");
        },

        // removing the CSS classes once dragging is over.
        stop:function () {
            $(this).removeClass("active").closest("#product").removeClass("active");
        }
    });

                
    // jQuery Ui Droppable
    $(".basket").droppable({

        // The class that will be appended to the to-be-dropped-element (basket)
        activeClass:"active",

        // The class that will be appended once we are hovering the to-be-dropped-element (basket)
        hoverClass:"hover",

        // The acceptance of the item once it touches the to-be-dropped-element basket
        // For different values http://api.jqueryui.com/droppable/#option-tolerance
        tolerance:"touch",
        drop:function (event, ui) {

            var basket = $(this),
            move = ui.draggable,
            itemId = basket.find("ul li[data-id='" + move.attr("data-id") + "']");
            itemsize = basket.find("ul li").not('.basket-limit').length;
            if(itemsize >= 12){
                if(!$('.basket-limit').length){
                    basket.find("ul").append("<li class='basket-limit'><span>Sorry You Have reached the item limit.</span></li>");
                    
                }   
                return false;
            }
            else if($('.basket-limit').length){
                $('.basket-limit').remove();
            }


            // To increase the value by +1 if the same item is already in the basket
            if (itemId.html() != null) {
                itemId.find("input").val(parseInt(itemId.find("input").val()) + 1);
            }
            else {
                // Add the dragged item to the basket
                addBasket(basket, move);

                // Updating the quantity by +1" rather than adding it to the basket
                move.find("input").val(parseInt(move.find("input").val()) + 1);
            }
            $("#outfit_id").val('');
        }
    });
                
    function addBasket(basket, move) {
        
        var src = move.find("img").attr('src'),
            price = move.data('price'),
            name = move.data('name'),
            brand = move.data('brand'),
            pid = move.data('id'),
            countli = basket.find(".basket ul li").length;
        
        var productList = move.find('.product-size-list').html();

        var html = '<li data-id="' + pid + '" data-price="'+ price +'">'
                    + '<span class="name">' + name + '</span>'
                    + '<span class="prc-img">' + price + '</span>'
                    + '<img src="' + src + '" />'
                    + '<select class="outfit-size-list">' + productList + '</select>'
                    + '<button class="delete">&#10005;</button></li>';

        basket.find("ul").append(html);
        
        overall = overall + parseInt(price); 
        $("#total").html(overall);
    }
    
    // The function that is triggered once delete button is pressed
    $(".basket").unbind('click').on("click", 'ul li button.delete', function () {
        var targetLi = $(this).closest("li"),
            price = parseInt(targetLi.data('price'));

        targetLi.remove();

        if($('.basket-limit').length){
            $('.basket-limit').remove();
        }

        overall = overall - price;
        $("#total").html(overall);
        $("#outfit_id").val('');
    });                      
                
}

$(function () {

});

$(document).ready(function(){
    var calculatedHeight = $(window).height()-$('.header').height() - 50;
    var $scrollbar  = $('#scrollbar1');
    $scrollbar.tinyscrollbar({ axis: "y", trackSize: calculatedHeight});
    var scrollbarData = $scrollbar.data("plugin_tinyscrollbar");
    $scrollbar.find('.viewport').height(calculatedHeight);

    $('.product-list-block').on('click', function(e){
        e.preventDefault();
    });
    // $("#total").text(overall);
    dragAndDropOutfit();

    $("#outfitname").on('input', function(e){
        $("#outfit_id").val('');
    });

    $(".sbmt-btn").on("click", function (e) {
            
        if(!$('.basket ul li').length || $("#outfitname").val() == "" || $("#comments").val() == ""){
            $('.error-outfit').show();
            return false;   
        }
        else{
            $('.error-outfit').hide();
            var outfitData = '';
            $('.basket ul li').not('.basket-limit').each(function(){
                outfitData = outfitData + '<li >';
                outfitData = outfitData + '<img src="'+ $(this).find('img').attr('src') +'" alt="" />';
                outfitData = outfitData + '<div class="cnfrm-otft-prdct-dtl">' + $(this).find('.name').text() + '<br />Whit &amp; co<br />' + $(this).find('.prc-img').text() + '</div>';
                outfitData = outfitData + '</li>';

            });


            var html = '';
            html = html +   '<div class="box-modal">'+
                                    '<div class="box-modal-inside">'+
                                        '<a href="#" title="" class="otft-close"></a>'+
                                            '<div class="twelve columns left cnfrm-otft-content">'+
                                                '<div class="twelve columns left cnfrm-otft-top">'+
                                                    '<h1>'+ $("#outfitname").val() +'</h1>'+
                                                    '<span class="otft-prc right">Outfit price: $'+ $("#total").text() +'</span>'+
                                                '</div>'+
                                                '<div class="twelve columns left cnfrm-otft-middle">'+
                                                    '<div class="eleven columns container">'+
                                                        '<div class="twelve columns left cnfrm-otft-itms">'+
                                                            '<ul>' +
                                                            outfitData +  
                                                            '</ul>' + 
                                                        '</div>' + 
                                                    '</div>' + 
                                                '</div>' + 
                                                '<div class="twelve columns left cnfrm-otft-bottom">' + 
                                                    '<div class="eleven columns container">' + 
                                                        '<div class="twelve columns left otft-stylist-review">' + 
                                                            $("#comments").val() + 
                                                        '</div>' + 
                                                    '</div>' + 
                                                '</div>' + 
                                                '<div class="twelve columns left cnfrm-bottom-link">' + 
                                                    '<div class="eleven columns container">' + 
                                                        '<div class="twelve columns left otft-btm-links">' + 
                                                            '<div class="cnfrm-otft-edit left"><a class="cnfrm-otft-edit-sec" href="#" title="">Edit</a></div>' + 
                                                            '<div class="cnfrm-otft-social left">' + 
                                                            '</div>' + 
                                                        '<div class="cnfrm-otft-send right"><a href="#" title="" id="subfinaloutfit">Send <span></span></a></div>' + 
                                                    '</div>' + 
                                                '</div>' + 
                                            '</div>' + 
                                        '</div>' + 
                                    '</div>' + 
                                '</div>'; 

            $("#cnfrm-otft-popup").html(html); 
            cnfrmoutFit();    
        }
        
    });

    $("#subfinaloutfit").live("click", function (e) {
        e.preventDefault();     
        var outfitname = $("#outfitname").val();
        var stylist_id = $("#stylist_id").val();
        var user_id = $("#user_id").val();
        var comments = $("#comments").val();
        var outfit_id = $("#outfit_id").val();

        var outfit_items = [];
        $('.basket ul li').each(function(){
            var product = {
                'product_entity_id': $(this).data('id'),
                'size_id': $(this).find('.outfit-size-list').val()
            };
            outfit_items.push(product);
        });
        
        var postData = {
            'outfit_name': outfitname,
            'stylist_id': stylist_id,
            'user_id': user_id,
            'comments': comments, 
            'outfit_items': outfit_items,
            'outfit_id': outfit_id
        };

        $.ajax({
            type:"POST",
            url:"<?php echo $this->webroot; ?>outfits/postOutfit",
            data: postData,
            cache: false,
            success: function(result){
                var ret = $.parseJSON(result);

                if(ret['status'] == 'ok'){
                    location = '/messages/index/' + user_id;    
                }
                else{
                    location = '/messages/feed';
                }
                
            }
        }); 
    });



    $('.otft-rgt-nav .tab-nav>a').on('click', function(e){
        e.preventDefault();
        $('.otft-rgt-nav li').removeClass('active');
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
        else if($(this).closest('li').hasClass('likes-tab')){
            loadLikes(true);
        }casey
    });

    var currentRequest = false;

    $('#load-more').on('click', function(e){
        e.preventDefault();
        var activeTab = $('.otft-rgt-nav li.active');

        if(activeTab.hasClass('closet-tab')){
            loadProducts();
        }
        else if(activeTab.hasClass('bookmark-tab')){
            loadBookmark();
        }
        else if(activeTab.hasClass('purchased-tab')){
            loadPurchased();
        }
        else if(activeTab.hasClass('likes-tab')){
            loadLikes();
        }
    });

    $('.colorsearch').on('click', function(){
        if(!$('.closet-tab').hasClass('active')){
            $('.otft-rgt-nav li').removeClass('active');
            $('.closet-tab').addClass('active');
        }
        $('#listPage').val(1);
        loadProducts(true);
    });

    $('#closettextsearch').on('input', function(){
        $('#listPage').val(1);

        var activeTab = $('.otft-rgt-nav li.active');

        if(activeTab.hasClass('closet-tab')){
            loadProducts(true);
        }
        else if(activeTab.hasClass('bookmark-tab')){
            loadBookmark(true);
        }
        else if(activeTab.hasClass('purchased-tab')){
            loadPurchased(true);
        }
        else if(activeTab.hasClass('likes-tab')){
            loadLikes(true);
        }
    });

    $('#sortbydate').on('change', function(){
       $('#listPage').val(1);
       var activeTab = $('.otft-rgt-nav li.active');

        if(activeTab.hasClass('closet-tab')){
            loadProducts(true);
        }
        else if(activeTab.hasClass('bookmark-tab')){
            loadBookmark(true);
        }
        else if(activeTab.hasClass('purchased-tab')){
            loadPurchased(true);
        }
        else if(activeTab.hasClass('likes-tab')){
            loadLikes(true);
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
            console.log($(this).val());
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
                        scrollbarData.update("relative");
                    }
                }
                else if(ret['status'] == 'redirect'){
                    location = '/messages/index';
                }
                else{
                    $('#load-more').hide();
                }

                dragAndDropOutfit(); 


            }

        });

    } 


    function loadLikes(reset){
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
                user_id: stylistId,
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
                        scrollbarData.update("relative");
                    }
                }
                else{
                    $('#load-more').hide();
                }

                dragAndDropOutfit(); 
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
                        scrollbarData.update("relative");
                    }
                }
                else{
                    $('#load-more').hide();
                }

                dragAndDropOutfit(); 
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
                user_id: stylistId,
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
                        scrollbarData.update("relative");
                    }
                }
                else{
                    $('#load-more').hide();
                }

                dragAndDropOutfit(); 
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
        

    <div class="twelve columns container">
        <div class="eleven columns container message-box-area">
            <div class="twelve columns container left message-box">
                <div class="eleven columns container">
                    <div class="twelve columns left myoutfit-section">
                        <div class="four columns left otft-lft">
                            <div class="eleven columns container">
                                <div class="twelve columns left">
                                    <div class="twelve columns left otft-lft-top">
                                        <h3>Create a New Outfit</h3>
                                        <p>Drag &amp; Drop up to 12 items from <br />the closet to the box below</p>
                                    </div>
                                    <div class="eleven columns container">
                                        <div class="twelve columns left otft-lft-title">
                                            <h1>Outfit Title</h1>
                                            <input type="text" name="" placeholder="" id="outfitname" value="<?php echo isset($outfit) ? $outfit['Outfit']['outfit_name'] : '';?>" />
                                            <input type="hidden" name="" placeholder="" id="outfit_id" value="<?php echo isset($outfit) ? $outfit['Outfit']['id'] : '';?>" />
                                            <input type="hidden" name="" placeholder="" id="user_id" value="<?php echo $client['User']['id']; ?>" />
                                            <input type="hidden" name="" placeholder="" id="stylist_id" value="<?php echo $user['User']['id']; ?>" />
                                            <p>styled for  <?php echo ucwords($client['User']['first_name'] . ' ' . $client['User']['last_name']); ?> <!--<span>(</span> <span class="otft-lft-txt">Change</span> <span>)</span>--></p>
                                        </div>
                                    </div>
                                    <div class="eleven columns container">
                                        <div class="twelve columns left drp-section">
                                            <div class="eleven columns container otft-drp-area">
                                                <div class="twelve columns left pdct-drp-sec">
                                                    <div class="basket">
                                                        <div class="basket_list">
                                                            <ul id="dataid">
                                                            <?php 
                                                            $total_price = 0;
                                                            if(isset($outfit)): 
                                                                foreach($outfit['OutfitItem'] as $value):
                                                                    $total_price += $value['product']['Entity']['price'];
                                                                    if(count($value['product']['Image'])){
                                                                        $productImageUrl = $this->webroot . 'files/products/' . $value['product']['Image'][0]['name'];
                                                                    }
                                                                    else{
                                                                        $productImageUrl = $this->webroot . 'images/image_not_available.png';
                                                                    }
                                                            ?>
                                                                <li data-id="<?php echo $value['product_entity_id']; ?>" data-price="<?php echo $value['product']['Entity']['price']; ?>">
                                                                <span class="name"><?php echo $value['product']['Entity']['name']; ?></span>
                                                                <span class="prc-img"><?php echo $value['product']['Entity']['price']; ?></span>
                                                                <img src="<?php echo $productImageUrl; ?>" />
                                                                <select class="outfit-size-list"></select>
                                                                <button class="delete">&#10005;</button></li>
                                                            <?php 
                                                                endforeach;
                                                            endif; 
                                                            ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="twelve columns left otft-drp-ttl">
                                                        Total Amount is $<span id="total"><?php echo $total_price; ?></span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="eleven columns container">
                                        <div class="twelve columns left otft-stylst-cmnt">
                                            <div class="left otft-stylst-cmnt-heading">
                                                <h1>Stylist Comments</h1>
                                                <textarea placeholder="Write a comment to your client before you send outfit" id="comments"></textarea>
                                                <a id="sbmt-cnfrmation" class="sbmt-btn" href="#" title="">Submit Outfit</a>
                                            </div>
                                            <p class="error-outfit hide">All fields are mandatory.</p>
                                        </div>
                                    </div>

                                    <!--popupsubmit-->
                                    <div id="cnfrm"></div>
                                    <div id="cnfrm-otft-popup" style="display: none"></div>
                                     
                                    <!--popup submit-->

                                </div>
                            </div>
                        </div>
                        <div class="eight columns right otft-rgt">
                            <div class="twelve columns left otft-rgt-heading">
                                <div class="eleven columns container">
                                    <div class="twelve columns left otft-rgt-nav">
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
                                            <li>|</li>
                                            <li class="likes-tab tab-nav"><a href="#" title="" id="clientlikes">Client Likes</a></li>
                                            <li>|</li>
                                            <li class="purchased-tab tab-nav"><a href="#" title="">Purchased</a></li>
                                            <li>|</li>
                                            <li class="bookmark-tab tab-nav"><a href="#" title="" id="stylistlikes">My Bookmarks</a></li>
                                            <li>|</li>
                                        </ul>
                                    </div>
                                    <div class="otft-right-top">
                                        <div class="otft-right-top-srch">
                                            <span></span>
                                            <input type="text" name="" id="closettextsearch" />
                                        </div>
                                        <div class="otft-right-top-srt">
                                            <select id="sortbydate">
                                                <option>Sort</option>
                                                <option value="pricedesc">Sort By Price DESC</option>
                                                <option value="priceasc"> Sort By Price ASC</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="twelve columns left otft-prdct-list">
                                <div id="scrollbar1">
                                    <div class="scrollbar" style="display: block;"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
                                    <div class="viewport">
                                        <div class="overview">
                                        <div id="product">
                                            <ul class="clear" id="listdat">
                                            <?php  for($i = 0; $i < count($entities); $i++){
                                                        $product = $entities[$i];
                                                        $wishlist = ($product['Wishlist']['product_entity_id'] == $product['Entity']['id']) ? 1 : 0;
                                            ?>
                                                <li  data-name="<?php echo $product['Entity']['name']; ?>" data-desc="<?php echo $product['Entity']['description']; ?>" data-image="<?php echo $this->webroot; ?>files/products/<?php echo $product['Image'][0]['name']; ?>" data-id="<?php echo $product['Entity']['id']; ?>" data-price="<?php echo $product['Entity']['price']; ?>" data-brand="<?php echo $product['Brand']['name']; ?>" data-wishlist="<?php echo $wishlist; ?>">

                                                <select class="hide product-size-list">
                                                <?php 
                                                    foreach ($product['Detail'] as $key => $details) 
                                                { ?>
                                                        <option value="<?php echo $details['size_id']; ?>"><?php echo $sizes[$details['size_id']]; ?></option>
                                                <?php 
                                                    } 
                                                ?>
                                                </select>
                                                
                                                    <a href="#" class="product-list-block myclst-quick-view">
                                                        <div class="otft-prdt-img"><img src="<?php echo $this->webroot; ?>files/products/<?php echo $product['Image'][0]['name']; ?>" alt="" /></div>
                                                       <div class="otft-prdt-overlay">
                                                            <p><?php echo $product['Entity']['name']; ?></p>
                                                            <p><?php echo $product['Brand']['name']; ?></p>
                                                            <p><?php echo $product['Entity']['price']; ?></p>
                                                        </div>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            </ul>
                                            
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <p id="loadMoreProduct">
                                    <span class="hide"><img src="<?php echo $this->webroot; ?>img/ajax-loader.gif" width="20" /></span>
                                    <input type="hidden" id="listPage" value="<?php echo $page + 1; ?>">
                                    <a href="" id="load-more">Load More Products</a>
                                </p>
                            </div>
                        </div>
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
