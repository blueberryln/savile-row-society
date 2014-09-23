<script>


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
                                //itemsize = basket.find("#size").val();
                                //alert(itemsize);

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
                
                // This function runs onc ean item is added to the basket
                function addBasket(basket, move) {
                    //var src = $('img').attr('src');
                    //alert(src);
                    var src =move.find("img").attr('src');
                    //var itemsize =move.find("#size").val();
                    basket.find("ul").append('<li data-id="' + move.attr("data-id") + '">'

                            + '<span class="name">' + move.find("h3").html() + '</span>'
                            + '<span class="prc-img">' + + '</span>'
                            + '<img src="'+src+'" />'
                            + '<select id="size"><option value="25">25</option> <option value="26">26</option> <option value="27">27</option><option value="28">28</option><option value="29">29</option></select>'
                            + '<button class="delete">&#10005;</button>');
                }

                 // The function that is triggered once delete button is pressed
                $(".basket ul li button.delete").live("click", function () {
                    $(this).closest("li").remove();
                });

}

            $(function () {

               
                dragAndDropOutfit();

            //get client like data
            $("#clientlikes").live("click", function () {
                var user_id = $("#user_id").val();

                $.ajax({
                        type:"POST",
                        url:"<?php echo $this->webroot; ?>Messages/getUserLikeAjax/<?php echo $client_id; ?>",
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
                        url:"<?php echo $this->webroot; ?>Messages/getUserLikeAjax/<?php echo $stylist_id; ?>",
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
                        url:"<?php echo $this->webroot; ?>Messages/closetAjaxProductData/<?php echo $client_id ?>",
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
            $(".sbmt-btn").on("click", function () {
                        var src = $('#dataid img').map(function(i,n) {
                       return $(n).attr('src');
                         }).get().join(',');
                             
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

                        //alert(size);

                        $.ajax({
                            type:"POST",
                            url:"<?php echo $this->webroot; ?>Messages/setFinalOutfitData",
                            data:{outfitid:liIds,user_id:user_id,out_name:outfitname,size_id:size,outfit_msg:comments,src:src},
                            cache: false,
                            success: function(result){
                            data = $.parseJSON(result);
                            html = '';
                            html = html + '<div id="cnfrm-otft-popup" style="display: none">';
                            html = html + '<div class="box-modal">';
                            html = html + '<div class="box-modal-inside">';
                            html = html + '<a href="#" title="" class="otft-close"></a>';
                            html = html + '<div class="twelve columns left cnfrm-otft-content">';
                            html = html + '<div class="twelve columns left cnfrm-otft-top">';
                            html = html + '<h1>'+ data[0].outfitname +'</h1>';
                            
                            html = html + '<span class="otft-prc right">outfit price: '+ outfitname +'</span>';
                            html = html + '</div>';
                            html = html + '<div class="twelve columns left cnfrm-otft-middle">';
                            html = html + '<div class="eleven columns container">';
                            html = html + '<div class="twelve columns left cnfrm-otft-itms">';
                            html = html + '<div class="right shp-this-otft">shop this outfit &gt;</div>';
                            html = html + '<ul>';
                            
                            $.each(data,  function (index){
                                var src = this.src;
                                $.each(src,  function (index1){
                            html = html + '<li >';
                            html = html + '<img src="'+ src[index1] +'" alt="" />';
                            html = html + '<div class="cnfrm-otft-prdct-dtl">White knight twills<br />Whit &amp; co<br />$600.00</div>';
                            html = html + '</li>';
                        });
                            });
                            
                            
                            html = html + '</ul>';
                            html = html + '</div>';
                            html = html + '</div>';
                            html = html + '</div>';
                            html = html + '<div class="twelve columns left cnfrm-otft-bottom">';
                            html = html + '<div class="eleven columns container">';
                            html = html + '<div class="twelve columns left otft-stylist-review">';
                            html = html + '<p>Dear Kyle<br/>I have created an outfit for your upcoming weekend in the hamptons. I think these pieces are versatile enought to easily be incorporated into day and night time looks. If you have any questions, please get in contact with me.</p><br/>';
                            html = html + '<p>Your Stylist,<br/>Lisa</p>';
                            html = html + '</div>';
                            html = html + '</div>';
                            html = html + '</div>';
                            html = html + '<div class="twelve columns left cnfrm-bottom-link">';
                            html = html + '<div class="eleven columns container">';
                            html = html + '<div class="twelve columns left otft-btm-links">';
                            html = html + '<div class="cnfrm-otft-edit left"><a href="#" title="">Edit</a></div>';
                            html = html + '<div class="cnfrm-otft-social left">';
                            html = html + '<ul>';
                            html = html + '<li class="cnfrm-otft-social-fb"><a href="#" title="">facebook</a></li>';
                            html = html + '<li class="cnfrm-otft-social-twtr"><a href="#" title="">twitter</a></li>';
                            html = html + '<li class="cnfrm-otft-social-pntrst"><a href="#" title="">pintrest</a></li>';
                            html = html + '</ul>';
                            html = html + '</div>';
                            html = html + '<div class="cnfrm-otft-send right"><a href="#" title="" id="subfinaloutfit">Send <span></span></a></div>';
                            html = html + '</div>';
                            html = html + '</div>';
                            html = html + '</div>';
                            html = html + '</div>';
                            html = html + '</div>';
                            html = html + '</div>';
                            html = html + '</div>';
                             $("#cnfrm").html(html); 
                             dragAndDropOutfit();  
                        }
                    }); 
                });
    
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
                            $(".cnfrm-otft-content").html("<h1>Your Outfit Hasbeen Submitted Successfully.</h1>");
                            location.reload();
                
                    }
                }); 
            });
             

        });



</script>
        
        <?php //print_r($products); ?>
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
                    <div class="twelve columns left myoutfit-section">
                        <div class="four columns left otft-lft">
                            <div class="eleven columns container">
                                <div class="twelve columns left">
                                    <div class="twelve columns left otft-lft-top">
                                        <div class="otft-lft-top-heading">
                                            <h3>Create a New Outfit</h3>
                                            <p>Drag &amp; Drop up to 5 items from <br />the closet to the box below</p>
                                        </div>
                                    </div>
                                    <div class="eleven columns container">
                                        <div class="twelve columns left otft-lft-title">
                                            <h1>Outfit Title</h1>
                                            <input type="text" name="" placeholder="" id="outfitname" />
                                            <input type="hidden" name="" placeholder="" id="user_id" value="<?php echo $client_id ?>" />
                                            <input type="hidden" name="" placeholder="" id="stylist_id" value="<?php echo $stylist_id; ?>" />
                                            <p>styled for  <?php echo $clientname; ?> <span>(</span> <span class="otft-lft-txt">Change</span> <span>)</span></p>
                                        </div>
                                    </div>
                                    <div class="eleven columns container">
                                        <div class="twelve columns left drp-section">
                                            <div class="eleven columns container otft-drp-area">
                                                <div class="twelve columns left pdct-drp-sec">
                                                    <div class="basket">
                                                        <div class="basket_list">
                                                            <ul id="dataid">
                                                               
                                                                <!-- <li><strong>Drag &amp; drop <br />items here</strong></li>
                                                                <li><strong>Drag &amp; drop <br />items here</strong></li>
                                                                <li><strong>Drag &amp; drop <br />items here</strong></li>
                                                                <li><strong>Drag &amp; drop <br />items here</strong></li>
                                                                <li><strong>Drag &amp; drop <br />items here</strong></li> -->
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="twelve columns left otft-drp-ttl">
                                                        Total Outfit Price: $1600.00
                                                        <p><a href="" title="">clear all</a></p>
                                                    </div>
                                                </div>
                                            </div>
<!--                                            <div class="otft-drp-btm-line left">&nbsp;</div>-->
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
                                            <li class="active"><a href="#" title="" id="closetdata">The Closet</a></li>
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
                                            <input type="text" name="" />
                                        </div>
                                        <div class="otft-right-top-srt">
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
                            <div class="twelve columns left otft-prdct-list">
                                <div id="product">
                                    <ul class="clear">
                                    <?php  for($i = 0; $i < count($products); $i++){
                                                $product = $products[$i];
                                                //print_r($product);
                                                    ?>
                                        <li  data-id="<?php echo $product['Entity']['id']; ?>">
                                        <?php foreach ($product['Detail'] as $key => $details) { ?>
                                        <input type="hidden" id="size" value="<?php echo $details['size_id'];?>">
                                        <?php } ?>
                                        
                                            <a href="#">
                                                <div class="otft-prdt-img"><img src="<?php echo $this->webroot; ?>files/products/<?php echo $product['Image'][0]['name']; ?>" alt="" /></div>
                                               <div class="otft-prdt-overlay">
                                                    <h3><?php echo $product['Entity']['name']; ?></h3>
                                                    <p><?php echo substr($product['Entity']['description'],0,25); ?></p>
                                                </div>
                                            </a>
                                        </li>
                                    <?php } ?>

                                        <!-- <li data-id="2">
                                            <a href="#">
                                                <div class="otft-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_2.jpg" alt="" /></div>
                                                <div class="otft-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li data-id="3">
                                            <a href="#">
                                                <div class="otft-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_3.jpg" alt="" /></div>
                                                <div class="otft-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li data-id="4">
                                            <a href="#">
                                                <div class="otft-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_4.jpg" alt="" /></div>
                                                <div class="otft-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                                
                                            </a>
                                        </li>
                                        <li data-id="5">
                                            <a href="#">
                                                <div class="otft-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_5.jpg" alt="" /></div>
                                                <div class="otft-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li data-id="6">
                                            <a href="#">
                                                <div class="otft-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_1.jpg" alt="" /></div>
                                                <div class="otft-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li data-id="7">
                                            <a href="#">
                                                <div class="otft-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_2.jpg" alt="" /></div>
                                               <div class="otft-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li data-id="8">
                                            <a href="#">
                                                <div class="otft-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_3.jpg" alt="" /></div>
                                                <div class="otft-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li> -->
                                    </ul>
                                    <div class="pagination userlikes">
                                        <?php
                                        echo $this->Paginator->prev('>', array(), null, array('class' => 'prev disabled'));
                                        echo $this->Paginator->numbers(array('separator' => '', 'class' => 'page-links'));
                                        echo $this->Paginator->next('>', array(), null, array('class' => 'next disabled'));
                                        ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                
                
               
                
                
                
                
                
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
//      window.onload = function() {
//         alert('hi');
//         function loadCloset() {
           
//             $.ajax({
//                 url: "<?php echo $this->webroot; ?>closet/index/",
//                 cache: false,
//                 type: 'POST',
//                 success: function(res) {
//                     alert(res);
//                     res = jQuery.parseJSON(res);
//                     if (res['status']=='ok') {
//                         var arrMsg = res['Messages'];
//                         if(arrMsg.length){
//                             for(var i=0; i < arrMsg.length; i++){
//                                 var html = showChatMsg(arrMsg[i]);
//                                 chatContainer.append(html);
//                                 firstMsgId = arrMsg[i]['Message']['id'];
//                             }
//                             if(res['msg_remaining'] > 0){
//                                 $("#loadOldMsgs").fadeIn(300);    
//                             }
                            
//                         }
//                         else{  
                            
//                         } 
//                     }
//                 },
//                 error: function(res) {
                    
//                 }
//             });
//         }

//      }
</script>