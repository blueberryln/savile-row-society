<script>

var overall = 0;
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
            if(itemsize >= 5){
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
                    + '<button class="delete">&#10005;</button>';

        basket.find("ul").append(html);
        
        overall = overall + parseInt(price); 
        $("#total").html(overall);
    }
    
    // The function that is triggered once delete button is pressed
    $(".basket ul li button.delete").live("click", function () {
        var targetLi = $(this).closest("li"),
            price = parseInt(targetLi.data('price'));

        targetLi.remove();

        if($('.basket-limit').length){
            $('.basket-limit').remove();
        }

        overall = overall - price;

        $("#total").html(overall);
    });                      
                
}

            $(function () {

               

            //get client like data
            $("#clientlikes").live("click", function () {
                var user_id = $("#user_id").val();

                $.ajax({
                        type:"POST",
                        url:"<?php echo $this->webroot; ?>Messages/getUserLikeAjax/<?php echo $client['User']['id']; ?>",
                        data:{user_id:user_id},
                        cache: false,
                        success: function(result){
                            //alert(result);
                        data = $.parseJSON(result);
                            html = '';
                            html = html + '<div id="product">';
                            html = html + '<ul class="clear">';
            
                        $.each(data,  function (index){
                            html = html + '<li  data-id="'+ this.Entity.id +'">';
                            html = html + '<a href="#">';
                            html = html + '<div class="otft-prdt-img"><img src="<?php echo $this->webroot; ?>files/products/'+ this.Image[0].name +'" alt="" /></div>';
                            html = html + '<div class="otft-prdt-overlay">';
                            html = html + '<h3>'+ this.Entity.name +'</h3>';
                            var desr = this.Entity.description;
                            html = html + '<p>'+ desr.substr(0,25) +'</p>';
                            html = html + '</div>';
                            html = html + '</a>';
                            html = html + '</li>';

                        });
                        html = html + '<ul>';            
                        html = html + '</div>';
                        $(".otft-prdct-list").html(html);   
                        dragAndDropOutfit();        
                    }
                });
            });

         //get stylist like data
            $("#stylistlikes").live("click", function () {
                var stylist_id = $("#stylist_id").val();

                $.ajax({
                        type:"POST",
                        url:"<?php echo $this->webroot; ?>Messages/getUserLikeAjax/<?php echo $user['User']['id']; ?>",
                        data:{stylist_id:stylist_id},
                        cache: false,
                        success: function(result){
                            //alert(result);
                        data = $.parseJSON(result);
                            html = '';
                            html = html + '<div id="product">';
                            html = html + '<ul class="clear">';
            
                        $.each(data,  function (index){
                            html = html + '<li  data-id="'+ this.Entity.id +'">';
                            html = html + '<a href="#">';
                            html = html + '<div class="otft-prdt-img"><img src="<?php echo $this->webroot; ?>files/products/'+ this.Image[0].name +'" alt="" /></div>';
                            html = html + '<div class="otft-prdt-overlay">';
                            html = html + '<h3>'+ this.Entity.name +'</h3>';
                            var desr = this.Entity.description;
                            html = html + '<p>'+ desr.substr(0,25) +'</p>';
                            html = html + '</div>';
                            html = html + '</a>';
                            html = html + '</li>';

                        });
                        html = html + '<ul>';            
                        html = html + '</div>';
                        $(".otft-prdct-list").html(html);   
                        dragAndDropOutfit();        
                    }
                });
            });

        //get closet ajax data 
            $("#closetdata").live("click", function () {
                var user_id = $("#user_id").val();
                $.ajax({
                        type:"POST",
                        url:"<?php echo $this->webroot; ?>Messages/closetAjaxProductData/<?php echo $client['User']['id'] ?>",
                        data:{user_id:user_id},
                        cache: false,
                        success: function(result){
                            //alert(result);
                        data = $.parseJSON(result);
                            html = '';
                            html = html + '<div id="product">';
                            html = html + '<ul class="clear">';
            
                        $.each(data,  function (index){
                            html = html + '<li  data-id="'+ this.Entity.id +'">';
                            html = html + '<a href="#">';
                            var imgs = this.Image;
                        $.each(imgs,  function (index1){
                            html = html + '<div class="otft-prdt-img"><img src="<?php echo $this->webroot; ?>files/products/'+ imgs[index1].name +'" alt="" /></div>';
                        });
                            html = html + '<div class="otft-prdt-overlay">';
                            html = html + '<h3>'+ this.Entity.name +'</h3>';
                            var desr = this.Entity.description;
                            html = html + '<p>'+ desr.substr(0,25) +'</p>';
                            html = html + '</div>';
                            html = html + '</a>';
                            html = html + '</li>';

                        });
                        html = html + '<ul>';            
                        html = html + '</div>';
                        $(".otft-prdct-list").html(html);   
                        dragAndDropOutfit();        
                    }
                });
            });

//get final submission outfit data
            
    
    // subfinaloutfit
            $("#subfinaloutfit").live("click", function () {
                   
                    //var id = $(".basket ul li").attr("data-id");
                    var outfitname = $("#outfitname").val();
                    var stylist_id = $("#stylist_id").val();
                    var user_id = $("#user_id").val();
                    //var size = $("#size").val();
                    var comments = $("#comments").val();
                    //var id = ui.draggable.attr("data-id")
                   var liIds = $('#dataid li').map(function(i,n) {
                       return $(n).attr('data-id');
                         }).get().join(',');
                   var size = $('#dataid select').map(function(i,n) {
                       return $(n).val();
                         }).get().join(',');

                    alert(size);

                    $.ajax({
                        type:"POST",
                        url:"<?php echo $this->webroot; ?>Messages/postOutfit",
                        data:{outfitid:liIds,user_id:user_id,out_name:outfitname,size_id:size,outfit_msg:comments},
                        cache: false,
                        success: function(result){
                            $(".cnfrm-otft-content").html("<h1>Your Outfit Has been Submitted Successfully.</h1>");
                            location.reload();
                
                    }
                }); 
            });

// sort closet by date sortbydate

    $("#sortbydate").change('live',function () {
        var sorting =  this.value;
        alert(sorting);
                $.ajax({
                        type:"POST",
                        url:"<?php echo $this->webroot; ?>Messages/closetAjaxProductData/<?php echo $user['User']['id']; ?>",
                        data:{sorting:sorting},
                        cache: false,
                        success: function(result){
                            //alert(result);
                        data = $.parseJSON(result);
                            html = '';
                            html = html + '<div id="product">';
                            html = html + '<ul class="clear">';
            
                        $.each(data,  function (index){
                            html = html + '<li  data-id="'+ this.Entity.id +'">';
                            html = html + '<a href="#">';
                            html = html + '<div class="otft-prdt-img"><img src="<?php echo $this->webroot; ?>files/products/'+ this.Image[0].name +'" alt="" /></div>';
                            html = html + '<div class="otft-prdt-overlay">';
                            html = html + '<h3>'+ this.Entity.name +'</h3>';
                            var desr = this.Entity.description;
                            html = html + '<p>'+ desr.substr(0,25) +'</p>';
                            html = html + '</div>';
                            html = html + '</a>';
                            html = html + '</li>';

                        });
                        html = html + '<ul>';            
                        html = html + '</div>';
                        $(".otft-prdct-list").html(html);   
                        dragAndDropOutfit();   
                                
                    }
                });
            });


// closettextsearch

    $(".otft-right-top-srch").on('keydown', function () {
        var closettextsearch =  $("#closettextsearch").val();
        //alert(closettextsearch);
                $.ajax({
                        type:"POST",
                        url:"<?php echo $this->webroot; ?>Messages/closetAjaxProductData/<?php echo $user['User']['id']; ?>",
                        data:{closettextsearch:closettextsearch},
                        cache: false,
                        success: function(result){
                            //alert(result);
                        data = $.parseJSON(result);
                            html = '';
                            html = html + '<div id="product">';
                            html = html + '<ul class="clear">';
            
                        $.each(data,  function (index){
                            html = html + '<li  data-id="'+ this.Entity.id +'">';
                            html = html + '<a href="#">';
                            html = html + '<div class="otft-prdt-img"><img src="<?php echo $this->webroot; ?>files/products/'+ this.Image[0].name +'" alt="" /></div>';
                            html = html + '<div class="otft-prdt-overlay">';
                            html = html + '<h3>'+ this.Entity.name +'</h3>';
                            var desr = this.Entity.description;
                            html = html + '<p>'+ desr.substr(0,25) +'</p>';
                            html = html + '</div>';
                            html = html + '</a>';
                            html = html + '</li>';

                        });
                        html = html + '<ul>';            
                        html = html + '</div>';
                        $(".otft-prdct-list").html(html);   
                        dragAndDropOutfit();  
                                
                    }
                });
            });



    //pagination


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
                success: function(result){
                    data = $.parseJSON(result);
                            html = '';
                            
                        $.each(data,  function (index){
                            html = html + '<li  data-id="'+ this.Entity.id +'">';
                            html = html + '<a href="#">';
                            html = html + '<div class="otft-prdt-img"><img src="<?php echo $this->webroot; ?>files/products/'+ this.Image[0].name +'" alt="" /></div>';
                            html = html + '<div class="otft-prdt-overlay">';
                            html = html + '<h3>'+ this.Entity.name +'</h3>';
                            var desr = this.Entity.description;
                            html = html + '<p>'+ desr.substr(0,25) +'</p>';
                            html = html + '</div>';
                            html = html + '</a>';
                            html = html + '</li>';

                        });
                        $(".clear").append(html);   
                        dragAndDropOutfit();
                    
                }    
            });
        });


    //search data filter closet

    var myCheckboxescolour = new Array();
        var mycolour;
        var myCheckboxesbrand = new Array();
        var mybrand;
        var myCheckboxessubcategory = new Array();
        var mysubcategory;
        var myCheckboxescategory = new Array();
        var mycategory;
        $('.colorsearch').live("click",function() {
                mycolour='';
                mybrand='';
                mysubcategory='';
                mycategory= '';
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
                else if(jQuery(this).attr('title')=='category')
                {    
                    if(this.checked==true)
                    {
                        myCheckboxescategory.push(jQuery(this).val());
                    }
                    else
                    {   
                        removindexitem =new Array(); 
                        removindexitem= jQuery.inArray(jQuery(this).val(), myCheckboxescategory);// Uncheckbox here 
                        myCheckboxescategory.splice(removindexitem ,1);
                    
                    }
                }
                mycolour = myCheckboxescolour.join(",");
                mybrand = myCheckboxesbrand.join(",");
                mysubcategory = myCheckboxessubcategory.join(",");
                mycategory = myCheckboxescategory.join(",");
                //console.log(mybrand);
                $.ajax({
                        type:"POST",
                        url:"<?php echo $this->webroot; ?>messages/closetAjaxColorProductSearchData",
                        data:{colorid:mycolour,brandid:mybrand,subcategoryid:mysubcategory,categoryid:mycategory},
                        cache: false,
                        success: function(result){
                            data = $.parseJSON(result);
                            html = '';
                            html = html + '<div id="product">';
                            html = html + '<ul class="clear">';
            
                        $.each(data,  function (index){
                            html = html + '<li  data-id="'+ this.Entity.id +'">';
                            html = html + '<a href="#">';
                            var imgs = this.Image;
                        $.each(imgs,  function (index1){
                            html = html + '<div class="otft-prdt-img"><img src="<?php echo $this->webroot; ?>files/products/'+ imgs[index1].name +'" alt="" /></div>';
                        });
                            html = html + '<div class="otft-prdt-overlay">';
                            html = html + '<h3>'+ this.Entity.name +'</h3>';
                            var desr = this.Entity.description;
                            html = html + '<p>'+ desr.substr(0,25) +'</p>';
                            html = html + '</div>';
                            html = html + '</a>';
                            html = html + '</li>';

                        });
                        html = html + '<ul>';            
                        html = html + '</div>';
                        $(".otft-prdct-list").html(html);   
                        dragAndDropOutfit();

                    }
                });
            });

});

$(document).ready(function(){
    $('.product-list-block').on('click', function(e){
        e.preventDefault();
    });
    $("#total").text(overall);
    dragAndDropOutfit();








    $(".sbmt-btn").on("click", function () {

        var outfitData = '';
        $('.basket ul li').each(function(){
            outfitData = outfitData + '<li >';
            outfitData = outfitData + '<img src="'+ $(this).find('img').attr('src') +'" alt="" />';
            outfitData = outfitData + '<div class="cnfrm-otft-prdct-dtl">' + $(this).find('.name').text() + '<br />Whit &amp; co<br />' + $(this).find('.prc-img').text() + '</div>';
            outfitData = outfitData + '</li>';
                              
        });


        var html = '';
        html = html +   '<div id="cnfrm-otft-popup" style="display: none">'+
                            '<div class="box-modal">'+
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
                                                        '<div class="cnfrm-otft-edit left"><a href="#" title="">Edit</a></div>' + 
                                                        '<div class="cnfrm-otft-social left">' + 
                                                        '</div>' + 
                                                    '<div class="cnfrm-otft-send right"><a href="#" title="" id="subfinaloutfit">Send <span></span></a></div>' + 
                                                '</div>' + 
                                            '</div>' + 
                                        '</div>' + 
                                    '</div>' + 
                                '</div>' + 
                            '</div>' + 
                        '</div>'; 

        $("#cnfrm").html(html); 
        cnfrmoutFit();

        
                             
                    //     var outfitname = ;
                    //     var stylist_id = $("#stylist_id").val();
                    //     var user_id = $("#user_id").val();
                    //     //var size = $("#size").val();
                    //     var comments = $("#comments").val();
                    //     //var id = ui.draggable.attr("data-id")
                    //    var liIds = $('#dataid li').map(function(i,n) {
                    //        return $(n).attr('data-id');
                    //          }).get().join(',');
                    //    var size = $('#dataid select').map(function(i,n) {
                    //        return $(n).val();
                    //          }).get().join(',');

                    //     //alert(size);

                    //     $.ajax({
                    //         type:"POST",
                    //         url:"<?php echo $this->webroot; ?>Messages/setFinalOutfitData",
                    //         data:{outfitid:liIds,user_id:user_id,out_name:outfitname,size_id:size,outfit_msg:comments,src:src},
                    //         cache: false,
                    //         success: function(result){
                    //         data = $.parseJSON(result);
                    //         html = '';
                    //         html = html + '<div id="cnfrm-otft-popup" style="display: none">';
                    //         html = html + '<div class="box-modal">';
                    //         html = html + '<div class="box-modal-inside">';
                    //         html = html + '<a href="#" title="" class="otft-close"></a>';
                    //         html = html + '<div class="twelve columns left cnfrm-otft-content">';
                    //         html = html + '<div class="twelve columns left cnfrm-otft-top">';
                    //         html = html + '<h1>'+ data[0].outfitname +'</h1>';
                            
                    //         html = html + '<span class="otft-prc right">outfit price: '+ outfitname +'</span>';
                    //         html = html + '</div>';
                    //         html = html + '<div class="twelve columns left cnfrm-otft-middle">';
                    //         html = html + '<div class="eleven columns container">';
                    //         html = html + '<div class="twelve columns left cnfrm-otft-itms">';
                    //         html = html + '<div class="right shp-this-otft">shop this outfit &gt;</div>';
                    //         html = html + '<ul>';
                            
                            
                            
                            
                            
                    //          cnfrmoutFit();
                    //     }
                    // }); 
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
                                        <p>Drag &amp; Drop up to 5 items from <br />the closet to the box below</p>
                                    </div>
                                    <div class="eleven columns container">
                                        <div class="twelve columns left otft-lft-title">
                                            <h1>Outfit Title</h1>
                                            <input type="text" name="" placeholder="" id="outfitname" />
                                            <input type="hidden" name="" placeholder="" id="user_id" value="<?php echo $client['User']['id']; ?>" />
                                            <input type="hidden" name="" placeholder="" id="stylist_id" value="<?php echo $user['User']['id']; ?>" />
                                            <p>styled for  <?php echo ucwords($client['User']['first_name'] . ' ' . $client['User']['last_name']); ?> <span>(</span> <span class="otft-lft-txt">Change</span> <span>)</span></p>
                                        </div>
                                    </div>
                                    <div class="eleven columns container">
                                        <div class="twelve columns left drp-section">
                                            <div class="eleven columns container otft-drp-area">
                                                <div class="twelve columns left pdct-drp-sec">
                                                    <div class="basket">
                                                        <div class="basket_list">
                                                            <ul id="dataid">
                                                                
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="twelve columns left otft-drp-ttl">
                                                        Total Amount is $<span id="total">0</span>
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
                                        </div>
                                    </div>

                                    <!--popupsubmit-->
                                    <div id="cnfrm"></div>
                                     
                                    <!--popup submit-->

                                </div>
                            </div>
                        </div>
                        <div class="eight columns right otft-rgt">
                            <div class="twelve columns left otft-rgt-heading">
                                <div class="eleven columns container">
                                    <div class="twelve columns left otft-rgt-nav">
                                        <ul>
                                            <li class="active"><a href="#" title="" id="closetdata">The Closet</a>

                                            <ul>
                                                <div class="ctg-one">
                                                    <div id="scrollbar3">
                                                        <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
                                                            <div class="viewport">
                                                                 <div class="overview">
                                                                    <?php foreach ($categories as $category): ?>
                                                                    <h3>
                                                                        <input type="checkbox" name="" title="category" class="colorsearch" value="<?php echo $category['Category']['id']; ?>" id="ca<?php echo $category['Category']['id']; ?>" data-category_id="<?php echo $category['Category']['id']; ?>" />
                                                                        <label for="ca<?php echo $category['Category']['id']; ?>" class=""><?php echo $category['Category']['name']; ?><span></span></label>
                                                                    </h3>
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
                                            <li>|</li>
                                            <li><a href="#" title="" id="clientlikes">Client Likes</a></li>
                                            <li>|</li>
                                            <li><a href="#" title="">Purchased</a></li>
                                            <li>|</li>
                                            <li><a href="#" title="" id="stylistlikes">My Bookmarks</a></li>
                                            <li>|</li>
                                            <li><a href="#" title="">Client’s Sizes</a></li>
                                        </ul>
                                    </div>
                                    <div class="otft-right-top">
                                        <div class="otft-right-top-srch">
                                            <span></span>
                                            <input type="text" name="" id="closettextsearch" />
                                        </div>
                                        <div class="otft-right-top-srt">
                                            <select id="sortbydate">
                                                <option>Sort By Date</option>
                                                <option value="DESC">Sort By Date DESC</option>
                                                <option value="ASC"> Sort By Date ASC</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="twelve columns left otft-prdct-list">
                                <div id="product">
                                    <ul class="clear">
                                    <?php  for($i = 0; $i < count($products); $i++){
                                                $product = $products[$i];
                                    ?>
                                        <li  data-id="<?php echo $product['Entity']['id']; ?>" data-price="<?php echo $product['Entity']['price']; ?>" data-brand="<?php echo $product['Brand']['name']; ?>" data-name="<?php echo $product['Entity']['name']; ?>">

                                        <select class="hide product-size-list">
                                        <?php 
                                            foreach ($product['Detail'] as $key => $details) 
                                        { ?>
                                                <option value="<?php echo $details['size_id']; ?>"><?php echo $sizes[$details['size_id']]; ?></option>
                                        <?php 
                                            } 
                                        ?>
                                        </select>
                                        
                                            <a href="" class="product-list-block">
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
                                    <p id="loadMoreProduct">

                                    <span class="hide"><img src="<?php echo $this->webroot; ?>img/ajax-loader.gif" width="20" /></span>
                                    <!-- <input type="hidden" id="limit" value="<?php echo $ProductRowCount; ?>"> -->
                                    <!-- <a href="" id="<?php echo $ProductRowCount; ?>">Load More Products</a> -->
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                           
            </div>
        </div>
    </div>
</div>
