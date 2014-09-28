<script type="text/javascript">
    $(document).ready(function(){

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
                       // data:{user_id:user_id},
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
                        data:{colorid:mycolour,brandid:mybrand,subcategoryid:mysubcategory},
                        cache: false,
                        success: function(result){
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
                        $(".myclst-prdct-list").html(html);     
                    }
                });
            });


    // closet product popup quick view

    $(".myclst-quick-view").on('click',function(){
        $this = $(this);
        var productBlock = $this.closest(".myclst-prdt-overlay");
        var id = productBlock.find("#prid").val();
        alert(id);
    })


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
                            <div class="twelve columns left myclst-prdct-list" >
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
                                                    <input type="hiddent" value="<?php echo $product['Entity']['name']; ?>" id="prid">
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

                <div id="myclst-popup" style="display: none">
                                <div class="box-modal">
                                    <div class="box-modal-inside">
                                        <a href="#" title="" class="otft-close"></a>
                                        <div class="myclst-popup-content">
                                            <div class="twelve columns left product-dtl-area pad-none">
                                                <div class="product-dtl-img left"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_1.jpg" alt=""/></div>
                                                <div class="product-dtl-desc left">
                                                    <h3>Item Quickview</h3>
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
                                    </div>
                                </div>
                            </div>

                <!--popup quick view-->
                
                
                
                
            </div>
        </div>
    </div>
</div>
