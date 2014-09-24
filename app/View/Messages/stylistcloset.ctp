<script type="text/javascript">
    $(document).ready(function(){


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
                            html = html + '<div">';
                            html = html + '<ul">';
            
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
                       // data:{user_id:user_id},
                        cache: false,
                        success: function(result){
                            //alert(result);
                        data = $.parseJSON(result);
                            html = '';
                            html = html + '<div">';
                            html = html + '<ul">';
            
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


        $('.colorsearch').live("click",function() {
                var colorid = $(this).attr("data-color_id");

                console.log(colorid);
                $.ajax({
                        type:"POST",
                        url:"<?php echo $this->webroot; ?>messages/closetAjaxColorProductSearchData",
                        data:{colorid:colorid},
                        cache: false,
                        success: function(result){
                                
                    }
                });
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
                    <div class="twelve columns left mycloset-section">
                        <div class="twelve columns left myclst-rgt-heading">
                                <div class="eleven columns container">
                                    <div class="seven columns left myclst-rgt-nav">
                                        <ul>
                                            <li class="active"><a href="#" title="" id="closetdata">The Closet</a>
                                                <ul>
                                                <div class="ctg-one" style="overflow-y:scroll;height:350px;width:200px;">
                                                    <?php foreach ($categories as $category): ?>
                                                    <h3><?php echo $category['Category']['name']; ?></h3>
                                                        <?php if ($category['children']) : ?>
                                                            <?php foreach ($category['children'] as $subcategory): ?>
                                                                <input type="checkbox" name="" value="<?php echo $subcategory['Category']['id']; ?>" id="s<?php echo $subcategory['Category']['id']; ?>" data-category_id="<?php echo $subcategory['Category']['id']; ?>" />
                                                                <label for="s<?php echo $subcategory['Category']['id']; ?>" class=""><?php echo $subcategory['Category']['name']; ?><span></span></label>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </div>   
                                                

                                                
                                                    <div class="ctg-one third-block" style="overflow-y:scroll;max-height:300px;">
                                                        <h3>Brands</h3>
                                                        <?php if($brands) : ?>
                                                            <?php foreach($brands as $brand) : ?>
                                                                <input type="checkbox" name="" value="<?php echo $brand['Brand']['id']; ?>" id="b<?php echo $brand['Brand']['id']; ?>" data-brand_id="<?php echo $brand['Brand']['id']; ?>" />
                                                                <label for="b<?php echo $brand['Brand']['id']; ?>" class=""><?php echo $brand['Brand']['name']; ?><span></span></label>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                        
                                                        
                                                    </div>
                                                    <div class="ctg-one forth-block" style="overflow-y:scroll;max-height:300px;">
                                                        <h3>Colors</h3>
                                                        
                                                        <?php if($colors) : ?>
                                                            <?php foreach($colors as $color) :?>
                                                                <input type="checkbox" name="" class="colorsearch" data-color_id="<?php echo $color['Colorgroup']['id']; ?>" value="<?php echo $color['Colorgroup']['id']; ?>" id="c<?php echo $color['Colorgroup']['id']; ?>" />
                                                                <label for="c<?php echo $color['Colorgroup']['id']; ?>"  class=""><?php echo $color['Colorgroup']['name']; ?><span></span></label>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>

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
                            <div class="twelve columns left myclst-prdct-list">
                                <div>
                                    <ul>
                                        <li>
                                            <a href="#">
                                                <div class="myclst-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_1.jpg" alt="" /></div>
                                               <div class="myclst-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="myclst-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_2.jpg" alt="" /></div>
                                                <div class="myclst-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="myclst-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_3.jpg" alt="" /></div>
                                                <div class="myclst-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="myclst-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_4.jpg" alt="" /></div>
                                                <div class="myclst-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                                
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="myclst-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_5.jpg" alt="" /></div>
                                                <div class="myclst-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="myclst-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_1.jpg" alt="" /></div>
                                                <div class="myclst-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="myclst-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_2.jpg" alt="" /></div>
                                               <div class="myclst-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="myclst-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_3.jpg" alt="" /></div>
                                                <div class="myclst-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="myclst-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_1.jpg" alt="" /></div>
                                               <div class="myclst-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="myclst-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_2.jpg" alt="" /></div>
                                                <div class="myclst-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="myclst-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_3.jpg" alt="" /></div>
                                                <div class="myclst-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="myclst-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_4.jpg" alt="" /></div>
                                                <div class="myclst-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                                
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="myclst-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_5.jpg" alt="" /></div>
                                                <div class="myclst-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="myclst-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_1.jpg" alt="" /></div>
                                                <div class="myclst-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="myclst-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_2.jpg" alt="" /></div>
                                               <div class="myclst-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="myclst-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_3.jpg" alt="" /></div>
                                                <div class="myclst-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="myclst-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_5.jpg" alt="" /></div>
                                                <div class="myclst-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="myclst-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_1.jpg" alt="" /></div>
                                                <div class="myclst-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="myclst-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_2.jpg" alt="" /></div>
                                               <div class="myclst-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="myclst-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_3.jpg" alt="" /></div>
                                                <div class="myclst-prdt-overlay">
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