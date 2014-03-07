var lastLikedItem = 0,
    lastPurchasedItem = 0,
    lastClosetItem = 0,
    inAjaxTransaction = false;

/**
 * Purchased items
 */
// Function to add purchased items to purchased container
function addPurchasedItems(items){
    var data = "";
    var purchasedCont = $(".purchased-list-cont .product-listing-box");
    for(var i=0; i<items.length; i++){
        data = items[i];
        var img_src = webroot + "img/image_not_available-small.png";
        if(data['Image'].length > 0){
            img_src = webroot + "products/resize/" + data['Image'][0]['name'] + '/158/216';    
        }
        var html = "";
        html =  "<div class='outfit-item'>" + 
                    "<div class='product-block'>" + 
                        "<input type='hidden' value='" + data['Entity']['slug'] + "' class='product-slug'>" + 
                        "<input type='hidden' value='" + data['Entity']['id'] + "' class='product-id'>" + 
                        "<div class='product-list-image mosaic-block fade'>" + 
                            "<div class='mosaic-overlay' style='display: block;'>" + 
                                "<span class='select-item'></span>" +
                				"<div class='mini-product-details'>" + 
            					   "<span class='entity-price'>$" + data['Entity']['price'] + "</span>" +
            					   "<span class='entity-name'>" + data['Entity']['name'] + "</span>" +
                				"</div>" + 
                			"</div>" + 
                            "<div class='mosaic-backdrop' style='display: block;'>" + 
                                "<img src='" + img_src + "' alt='" + data['Entity']['name'] + "' data-src='" + img_src + "'>" +
                            "</div>" + 
                        "</div>" + 
                    "</div>" + 
                "</div>";
                
        purchasedCont.append(html);
    }
}
// Function to get purchased items
function getPurchasedItems(){
    $.ajax({
        url: webroot + "outfits/getPurchasedItems/" + lastPurchasedItem,
        cache: false,
        type: 'POST',
        data: {
            'client_id': client_id
        },
        success: function(data){
            var ret = $.parseJSON(data);
            if(ret["status"] == "ok"){
                if(ret["total"] == 0){
                    $(".purchased-list-cont .product-listing-box").html("<p>User has not purchased any item yet.");         
                }
                else{
                    if(lastPurchasedItem == 0){
                        $(".purchased-list-cont .product-listing-box").html("");        
                    }
                    lastPurchasedItem = ret['last_purchased_id'];
                    addPurchasedItems(ret["data"]);
                }
            }
            else if(ret['status'] == "end"){
                $(".load-more-purchased").fadeOut(300);    
            }
        }
    });
}


/**
 * Liked items
 */
// Function to add liked items to liked container
function addLikedItems(items){
    var data = "";
    var likedCont = $(".liked-list-cont .product-listing-box");
    for(var i=0; i<items.length; i++){
        data = items[i];
        var img_src = webroot + "img/image_not_available-small.png";
        if(data['Image'].length > 0){
            img_src = webroot + "products/resize/" + data['Image'][0]['name'] + '/158/216';    
        }
        var html = "";
        html =  "<div class='outfit-item'>" + 
                    "<div class='product-block'>" + 
                        "<input type='hidden' value='" + data['Entity']['slug'] + "' class='product-slug'>" + 
                        "<input type='hidden' value='" + data['Entity']['id'] + "' class='product-id'>" + 
                        "<div class='product-list-image mosaic-block fade'>" + 
                            "<div class='mosaic-overlay' style='display: block;'>" + 
                                "<span class='select-item'></span>" +
                				"<div class='mini-product-details'>" + 
            					   "<span class='entity-price'>$" + data['Entity']['price'] + "</span>" +
            					   "<span class='entity-name'>" + data['Entity']['name'] + "</span>" +
                				"</div>" + 
                			"</div>" + 
                            "<div class='mosaic-backdrop' style='display: block;'>" + 
                                "<img src='" + img_src + "' alt='" + data['Entity']['name'] + "' data-src='" + img_src + "'>" +
                            "</div>" + 
                        "</div>" + 
                    "</div>" + 
                "</div>";
                
        likedCont.append(html);
    }
}
// Function to get liked items
function getLikedItems(lastPurchasedItem){
    $.ajax({
        url: webroot + "outfits/getLikedItems/" + lastLikedItem,
        cache: false,
        type: 'POST',
        data: {
            'client_id': client_id
        },
        success: function(data){
            var ret = $.parseJSON(data);
            if(ret["status"] == "ok"){
                if(ret["total"] == 0){
                    $(".liked-list-cont .product-listing-box").html("<p>User has not liked any item yet.</p>");
                }
                else{
                    if(lastPurchasedItem == 0){
                        $(".liked-list-cont .product-listing-box").html("");        
                    }
                    lastLikedItem = ret['last_liked_id'];
                    addLikedItems(ret["data"]);
                }
            }
            else if(ret['status'] == "end"){
                $(".load-more-liked").fadeOut(300);    
            }   
        }
    });
}



/**
 * Closet items
 */
// Function to add closet items to srs closet container
function addClosetItems(items){
    var data;
    var closet = $(".srs-closet-items");
    for(var i=0; i<items.length; i++){
        data = items[i];
        var img_src = webroot + "img/image_not_available-small.png";
        if(data['Image'].length > 0){
            img_src = webroot + "products/resize/" + data['Image'][0]['name'] + '/158/216';
        }
        var html = "";
        html =  "<div class='outfit-item'>" +
            "<div class='product-block'>" +
            "<input type='hidden' value='" + data['Entity']['slug'] + "' class='product-slug'>" +
            "<input type='hidden' value='" + data['Entity']['id'] + "' class='product-id'>" +
            "<div class='product-list-image mosaic-block fade'>" +
            "<div class='mosaic-overlay' style='display: block;'>" +
            "<span class='select-item'></span>" +
            "<div class='mini-product-details'>" +
            "<span class='entity-price'>$" + data['Entity']['price'] + "</span>" +
            "<span class='entity-name'>" + data['Entity']['name'] + "</span>" +
            "</div>" +
            "</div>" +
            "<div class='mosaic-backdrop' style='display: block;'>" +
            "<img src='" + img_src + "' alt='" + data['Entity']['name'] + "' data-src='" + img_src + "'>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>";

        closet.append(html);
    }
}
// Function to get closet items
function getClosetProducts(){
    var categoryId = $(".product-categories li a.filter-selected").closest("li").data("category_id");
    //console.log(categoryId);
    if(categoryId == undefined){
        categoryId = "all";
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
    
    //console.log(strBrand);
    //console.log(strColor);
    inAjaxTransaction = true;
    $(".load-more-closet").hide();
    $(".closet-load-icon").show();
    $.post(webroot + "outfits/getClosetItems/",{category_slug : categoryId,str_brand : strBrand, str_color : strColor, last_closet_item : lastClosetItem}, function(data){
        //console.log(data);
        
        var ret = $.parseJSON(data);
        inAjaxTransaction = false;
        if(ret['status'] == "ok"){
            if(ret['data'].length == 0){
                $(".srs-closet-items").html("<p>No products available.</p>");
            }
            else{
                addClosetItems(ret['data']);
                lastClosetItem = ret['last_closet_item'];
            }
            $(".load-more-closet").show();
            $(".closet-load-icon").hide();
        }
        else if(ret['status'] == "end"){
            $(".closet-load-icon").hide();    
        }

    });

}

//Resets the outfit box to initial state.
function resetOutfitBox(){
    $('.purchased-list-cont .product-listing-box').html();
    $('.liked-list-cont .product-listing-box').html();

    $("#outfit-box .outfit-item").each(function() {
        clearOutfitItem($(this));
    });

    $(".like-cont-link").click();

    lastLikedItem = 0;
    lastPurchasedItem = 0;
    lastClosetItem = 0;
    inAjaxTransaction = false;    
}

function displayOutfitItem(outfitEntity){
    var productBlock = null;
    $(".create-outfit-cont .outfit-item").each(function(){
        if($(this).find('.product-id').val() == "" && !productBlock){
            productBlock = $(this);
        }    
    });
    if(productBlock){
        productBlock = productBlock.find(".product-block");
        productBlock.find(".product-id").val(outfitEntity["id"]);
        productBlock.find(".product-slug").val(outfitEntity["slug"]);

        var html = "<div class='mosaic-overlay' style='display: block; opacity: 0;'>" +
                "<a href='' class='remove-product'></a>" +
                "<div class='mini-product-details'>" +
                    "<span class='outfit-detail-size'>$" + outfitEntity['price'] + "</span>" +
                    "<span class='outfit-detail-name'>" + outfitEntity['name'] + "</span>" +
                "</div>" +
            "</div>" +
            "<div class='mosaic-backdrop' style='display: block;'>" +
                "<img src='" + outfitEntity['img'] + "' alt='" + outfitEntity['name'] + "'>" +
            "</div>";
        productBlock.find(".product-list-image").html(html);
    }
}

function clearOutfitItem(object){
    object.find(".product-id").val("");
    object.find(".product-slug").val("");
    object.find(".product-list-image").html("");
}

function getOutfitItemCount(){
    var outfitItemCount = 0;
    $(".create-outfit-cont .outfit-item").each(function(){
        if($(this).find('.product-id').val() != '' && $(this).find('.product-id').val() > 0){
            outfitItemCount++;        
        }
    });

    return outfitItemCount;
}

// Get a count of selected items at a time.
function getSelectedCount(){
    var selectedCount = 0;
    $(".srs-closet-items .selected-outfit-item, .purchased-list-cont .selected-outfit-item, .liked-list-cont .selected-outfit-item").each(function(){
        selectedCount = selectedCount + 1;
    });

    return selectedCount;
}

// Check if an item exists in the current outfit.
function outfitItemExists(selectedProductId){
    var isItemAdded = false;

    $(".create-outfit-cont .outfit-item").each(function(){
        if($(this).find('.product-id').val() != '' && $(this).find('.product-id').val() == selectedProductId){
            isItemAdded = true;      
        }
    });    

    return isItemAdded;
}

$(document).ready(function(){
    $(".fade").mosaic();
    $("#createOutfit").on("click", function(e){
        e.preventDefault(); 
        if(client_id != 0){
            $.blockUI({message: $("#outfit-box"), css: {top: "10px", left: $(window).width()/2 - $("#outfit-box").width()/2 + "px" }});
            getPurchasedItems(lastPurchasedItem);
            getLikedItems(lastLikedItem);
        }
    });

    $(".outfit-close").on("click", function(e){
       e.preventDefault();
       $.unblockUI(); 
       resetOutfitBox();
    });
    
    $(".btn-user-closet").on("click", function(e){
        e.preventDefault();
        if(getOutfitItemCount() < 5){
            $(".user-closet-cont").fadeIn(300);        
        }
        else{
            alert("You already have 5 items in the outfit. To add, remove one more item first.")
        }
    });
    $(".user-closet-close").on("click", function(e){
        e.preventDefault();
        $(".user-closet-cont").fadeOut(300);         
        $(".purchased-list-cont .selected-outfit-item, .liked-list-cont .selected-outfit-item").removeClass("selected-outfit-item");
    });

    $(".btn-srs-closet").on("click", function(e){
        e.preventDefault();
        if(getOutfitItemCount() < 5){
            $(".srs-closet-cont").fadeIn(300);        
        }
        else{
            alert("You already have 5 items in the outfit. To add, remove one more item first.")
        }      
    });
    $(".srs-closet-close").on("click", function(e){
        e.preventDefault();
        $(".srs-closet-items").html("");
        $(".srs-closet-cont").fadeOut(300);       
        $(".filter-selected").removeClass("filter-selected");   
    });
    
    $(".like-cont-link").on("click", function(e){
        e.preventDefault();
        if(!$(".liked-list-cont").is(":visible")){
            $(this).removeClass("gray-btn").addClass("black-btn");
            $(".purchased-cont-link").removeClass("black-btn").addClass("gray-btn");
            $(".purchased-list-cont").fadeOut(300, function(){
                $(".liked-list-cont").fadeIn(300);        
            });
        } 
    }); 
    $(".purchased-cont-link").on("click", function(e){
        e.preventDefault();
        if(!$(".purchased-list-cont").is(":visible")){
            $(this).removeClass("gray-btn").addClass("black-btn");
            $(".like-cont-link").removeClass("black-btn").addClass("gray-btn");
            $(".liked-list-cont").fadeOut(300, function(){
                $(".purchased-list-cont").fadeIn(300);        
            });
        } 
    });

    //Load more products
    $(".load-more-purchased").on('click', function(e){
        e.preventDefault();
        getPurchasedItems();
            
    }); 
    $(".load-more-liked").on('click', function(e){
        e.preventDefault();
        getLikedItems();
            
    });
    $(".load-more-closet").on('click', function(e){
        e.preventDefault();
        getClosetProducts();
    });


    $(".product-filter-menu .toggle-tab .product-categories li a").on('click', function(e){
        if(!inAjaxTransaction){
            $this = $(this);
            if($this.hasClass("filter-selected")){
                $this.removeClass("filter-selected");
                
                //Clear Brand and Color Filter
                $(".brand-filter li").removeClass("filter-selected");
                $(".color-filter li").removeClass("filter-selected");
                
                lastClosetItem = 0;
                $(".srs-closet-items").html("");
            }
            else{
                $(".product-categories li a").removeClass("filter-selected");
                $this.addClass("filter-selected");
                
                //Clear Brand and Color Filter
                $(".brand-filter li").removeClass("filter-selected");
                $(".color-filter li").removeClass("filter-selected");   
                             
                lastClosetItem = 0;
                $(".srs-closet-items").html("");
                getClosetProducts();
            }
        }
    });
    $(".product-filter-menu .toggle-tab .brand-filter li, .product-filter-menu .toggle-tab .color-filter li").on('click', function(e){
        if(!inAjaxTransaction){
            if($(this).hasClass("filter-selected")){
                $(this).removeClass("filter-selected");
            }
            else{
                $(this).addClass("filter-selected");
            }
            lastClosetItem = 0;
            $(".srs-closet-items").html("");
            getClosetProducts();
        }
    });

    // Handle the mosiac animations for the outfit section.
    $("#outfit-box").on('mouseenter', '.product-block', function(){
        $(this).find(".mosaic-overlay").stop().animate({"opacity":"1"},300);
    });
    $("#outfit-box").on('mouseleave', '.product-block', function(){
        $(this).find(".mosaic-overlay").stop().animate({"opacity":"0"},300);
    });
    $(".chat-container").on('mouseenter', '.product-block', function(){
        $(this).find(".mosaic-overlay").stop().animate({"opacity":"1"},300);
    });
    $(".chat-container").on('mouseleave', '.product-block', function(){
        $(this).find(".mosaic-overlay").stop().animate({"opacity":"0"},300);
    });


    // Remove a product from selected list of outfit items
    $("#outfit-box").on('click', '.remove-product', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var object = $(this).closest(".product-block");
        clearOutfitItem(object);
    });

    // Handle event of clicking on any product from liked items, purchased items or the closet.
    $(".srs-closet-items, .purchased-list-cont, .liked-list-cont").on("click", ".mosaic-overlay", function(e){
        var productBox = $(this).closest(".outfit-item");
        var selectedProductId = productBox.find('.product-id').val();

        var selectedCount = getSelectedCount();
        var outfitItemCount = getOutfitItemCount();
        var isItemAdded = outfitItemExists(selectedProductId);

        if(productBox.hasClass("selected-outfit-item")){
            productBox.removeClass("selected-outfit-item");
        }
        else if(isItemAdded){
            alert("You have already added this item.");   
        }
        else{
            if((selectedCount + outfitItemCount) < 5){
                productBox.addClass("selected-outfit-item");
            }
            else{
                alert("You have already selected max number of items."); 
            }
        }
    });

    $("#outfit-box").on('click', ".add-closet-outfit, .add-purchased-outfit, .add-liked-outfit", function(e){
        e.preventDefault();
        var selectedCount = getSelectedCount();
        var outfitItemCount = getOutfitItemCount();

        if(!selectedCount){
            alert("Please select an item first.");
        }
        else{
            if(outfitItemCount < 5){
                var isItemAdded;
                $(".srs-closet-items .selected-outfit-item, .purchased-list-cont .selected-outfit-item, .liked-list-cont .selected-outfit-item").each(function(){
                    var $this = $(this);
                    var outfitEntity = {
                        'id' : $this.find(".product-id").val(),
                        'slug' : $this.find(".product-slug").val(),
                        'price' : $this.find(".entity-price").text(),
                        'name' : $this.find(".entity-name").text(),
                        'img' : $this.find(".mosaic-backdrop img").data("src"),
                    }  
                    isItemAdded = outfitItemExists($this.find(".product-id").val());

                    if(!isItemAdded && outfitItemCount < 5){
                        displayOutfitItem(outfitEntity); 
                        $this.removeClass('selected-outfit-item');
                        outfitItemCount++;   
                    }
                });       
            }    
            $(".srs-closet-close, .user-closet-close").click();
        }
    });
    
    $("#add-outfit").on('click', function(e){
        e.preventDefault();

        var outfitId1 = $("#outfit1 .product-id").val();
        var outfitId2 = $("#outfit2 .product-id").val();
        var outfitId3 = $("#outfit3 .product-id").val();
        var outfitId4 = $("#outfit4 .product-id").val();
        var outfitId5 = $("#outfit5 .product-id").val();
        var outfitMsg = $("#outfitMessageToSend").val();
        
        if(outfitId1 == "" && outfitId2 == "" && outfitId3 == "" && outfitId4 == ""  && outfitId5 == ""){
            alert("Please select atleast one product to create an outfit.");
        }
        else{
            if(!$(this).hasClass("outfit-suggessted")){
                $(this).addClass("outfit-suggessted");
                var outfitLocation = $("#outfit-location").val();
                var outfitStyle = $("#outfit-style").val();
                
                $.post(
                    webroot + "outfits/postOutfit/",
                    {
                        outfit1 : outfitId1, 
                        outfit2 : outfitId2, 
                        outfit3 : outfitId3, 
                        outfit4 : outfitId4, 
                        outfit5 : outfitId5, 
                        outfit_location: outfitLocation, 
                        outfit_style: outfitStyle, 
                        user_id: client_id,
                        outfit_msg: outfitMsg
                    }, 
                    function(data){
                        var ret = $.parseJSON(data);
                        if(ret['status'] == "ok"){
                            $(".user-closet-close").click();
                            window.location = webroot + 'messages/index/' + client_id;    
                        }
                        else if(ret['status'] == "error" && ret['msg']){
                            alert(ret['msg']);    
                        }
                });
            }
        }
    });
});