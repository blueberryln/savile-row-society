<script>
            $(function () {

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
                    basket.find("ul").append('<li data-id="' + move.attr("data-id") + '">'

                            + '<span class="name">' + move.find("h3").html() + '</span>'
                           // + '<span class="prc-img">' + + '</span>'
                            + '<img src="'+src+'" />'
                            + '<select><option>25</option> <option>25</option> <option>25</option></select>'
                            + '<button class="delete">&#10005;</button>');
                }


                // The function that is triggered once delete button is pressed
                $(".basket ul li button.delete").live("click", function () {
                    $(this).closest("li").remove();
                });

            });
        </script>
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
                                            <input type="text" name="" placeholder="" />
                                            <p>styled for  Kyle Harper <span>(</span> <span class="otft-lft-txt">Change</span> <span>)</span></p>
                                        </div>
                                    </div>
                                    <div class="eleven columns container">
                                        <div class="twelve columns left drp-section">
                                            <div class="eleven columns container otft-drp-area">
                                                <div class="twelve columns left pdct-drp-sec">
                                                    <div class="basket">
                                                        <div class="basket_list">
                                                            <ul>
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
                                                <textarea placeholder="Write a comment to your client before you send outfit"></textarea>
                                                <a class="sbmt-btn" href="#" title="">Submit Outfit</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="eight columns right otft-rgt">
                            <div class="twelve columns left otft-rgt-heading">
                                <div class="eleven columns container">
                                    <div class="twelve columns left otft-rgt-nav">
                                        <ul>
                                            <li class="active"><a href="#" title="">The Closet</a></li>
                                            <li>|</li>
                                            <li><a href="#" title="">Client Likes</a></li>
                                            <li>|</li>
                                            <li><a href="#" title="">Purchased</a></li>
                                            <li>|</li>
                                            <li><a href="#" title="">My Bookmarks</a></li>
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
                                        <li data-id="1">
                                            <a href="#">
                                                <div class="otft-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_1.jpg" alt="" /></div>
                                               <div class="otft-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li data-id="2">
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
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                
                
                
                
                
                
            </div>
        </div>
    </div>
</div>