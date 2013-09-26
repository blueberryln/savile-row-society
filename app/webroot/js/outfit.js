var lastLikedItem = 0;
var lastPurchasedItem = 0;

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
        html =  "<div class='three columns alpha row'>" + 
                    "<div class='product-block'>" + 
                        "<input type='hidden' value='" + data['Entity']['slug'] + "' class='product-slug'>" + 
                        "<input type='hidden' value='" + data['Entity']['id'] + "' class='product-id'>" + 
                        "<div class='product-list-image mosaic-block fade'>" + 
                            "<div class='mosaic-overlay' style='display: block;'>" + 
                                "<a href='' class='remove-product'></a>" + 
                				"<div class='mini-product-details'>" + 
            					   "<span>" + data['Entity']['price'] + "</span>" + 
            					   "<span>" + data['Entity']['name'] + "</span>" + 
                				"</div>" + 
                			"</div>" + 
                            "<div class='mosaic-backdrop' style='display: block;'>" + 
                                "<img src='" + img_src + "' alt='" + data['Entity']['name'] + "'>" + 
                            "</div>" + 
                        "</div>" + 
                    "</div>" + 
                "</div>";
                
        purchasedCont.append(html);
    }
}

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
        html =  "<div class='three columns alpha row'>" + 
                    "<div class='product-block'>" + 
                        "<input type='hidden' value='" + data['Entity']['slug'] + "' class='product-slug'>" + 
                        "<input type='hidden' value='" + data['Entity']['id'] + "' class='product-id'>" + 
                        "<div class='product-list-image mosaic-block fade'>" + 
                            "<div class='mosaic-overlay' style='display: block;'>" + 
                                "<a href='' class='remove-product'></a>" + 
                				"<div class='mini-product-details'>" + 
            					   "<span>" + data['Entity']['price'] + "</span>" + 
            					   "<span>" + data['Entity']['name'] + "</span>" + 
                				"</div>" + 
                			"</div>" + 
                            "<div class='mosaic-backdrop' style='display: block;'>" + 
                                "<img src='" + img_src + "' alt='" + data['Entity']['name'] + "'>" + 
                            "</div>" + 
                        "</div>" + 
                    "</div>" + 
                "</div>";
                
        likedCont.append(html);
    }
}

// Function to get purchased items
function getPurchasedItems(){
    $.ajax({
        url: webroot + "outfits/getPurchasedItems/" + lastPurchasedItem,
        data: {},
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

// Function to get liked items
function getLikedItems(lastPurchasedItem){
    $.ajax({
        url: webroot + "outfits/getLikedItems/" + lastLikedItem,
        data: {},
        success: function(data){
            var ret = $.parseJSON(data);
            if(ret["status"] == "ok"){
                if(ret["total"] == 0){
                    $(".liked-list-cont .product-listing-box").html("<p>User has not purchased any item yet.");         
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

$(document).ready(function(){
    $(".fade").mosaic();
    $("#createOutfit").on("click", function(e){
        e.preventDefault(); 
        $.blockUI({message: $("#outfit-box"), css: {top: "10px", left: $(window).width()/2 - $("#outfit-box").width()/2 + "px" }});
        getPurchasedItems(lastPurchasedItem);
        getLikedItems(lastLikedItem);
    });
    //$.blockUI({message: $("#outfit-box"), css: {top: "0", left: $(window).width()/2 - $("#outfit-box").width()/2 + "px" }});
    
    $(".outfit-close").on("click", function(e){
       e.preventDefault();
       $.unblockUI(); 
    });
    
    $(".btn-user-closet").on("click", function(e){
        e.preventDefault();
        $(".user-closet-cont").fadeIn(300);        
    });
    $(".btn-srs-closet").on("click", function(e){
        e.preventDefault();
        $(".srs-closet-cont").fadeIn(300);        
    });
    
    $(".srs-closet-close").on("click", function(e){
        e.preventDefault();
        $(".srs-closet-cont").fadeOut(300);           
    });
    
    $(".user-closet-close").on("click", function(e){
        e.preventDefault();
        $(".user-closet-cont").fadeOut(300);         
    });
    
    // Remove a product from selected list of outfit items
    $(".remove-product").click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        var object = $(this).closest(".product-block");
        var id = object.find(".product-id").val();
    });
    
    $(".like-cont-link").on("click", function(e){
        e.preventDefault();
        if(!$(".liked-list-cont").is(":visible")){
            $(this).removeClass("gray-btn").addClass("gold-btn");
            $(".purchased-cont-link").removeClass("gold-btn").addClass("gray-btn");
            $(".purchased-list-cont").fadeOut(300, function(){
                $(".liked-list-cont").fadeIn(300);        
            });
        } 
    }); 
    $(".purchased-cont-link").on("click", function(e){
        e.preventDefault();
        if(!$(".purchased-list-cont").is(":visible")){
            $(this).removeClass("gray-btn").addClass("gold-btn");
            $(".like-cont-link").removeClass("gold-btn").addClass("gray-btn");
            $(".liked-list-cont").fadeOut(300, function(){
                $(".purchased-list-cont").fadeIn(300);        
            });
        } 
    });
    
    $(".load-more-purchased").on('click', function(e){
        e.preventDefault();
        getPurchasedItems();
            
    }); 
    
    $(".load-more-liked").on('click', function(e){
        e.preventDefault();
        getLikedItems();
            
    }); 
    
});