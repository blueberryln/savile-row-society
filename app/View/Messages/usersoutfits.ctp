<?php
if($user_id){   
?>
<script type="text/javascript">
 $(document).ready(function(){
    $(document).on("click", ".thumb-icon", function(e) {
        e.preventDefault();
        alert('hi');
        $this = $(this);
        var productBlock = $this.closest(".bottm-links");
        var productId = productBlock.find("#product_id").val();
        var outfit_id = productBlock.find("#outfit_id").val();
            $.ajax({
                type:"POST",
                url : "<?php echo $this->request->webroot; ?>api/wishlist/save",
                data:{product_id: productId,outfit_id:outfit_id},
                cache: false,
                success: function(result){
                //$(".thumb-icon").addClass('thumb-icon-like');

               }
            });
    });
 });
</script>   
<?php
}
//$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->script("mosaic.1.0.1.min.js", array('inline' => false));
$this->Html->meta('description', 'First mover', array('inline' => false));
?>
<?php
$script = '
$(document).ready(function(){  
    
    $(document).on("click",".add-to-cart", function(e) {
        e.preventDefault();
        var productBlock = $(this).closest(".outfit-page-item"),
            productQuantity = productBlock.find("select.product-quantity").val(),
            productSize = productBlock.find(".product-size").val();
            var id = productBlock.find(".product-id").val();
            var quantity = parseInt(productQuantity) + 1;
            var size = productSize;
            alert(id);
            
        
        $.post("' . $this->request->webroot . 'api/cart/save", { product_id: id, product_quantity: 1, product_size: 23 },
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
';
$this->Html->script("jquery.colorbox-min.js", array('inline' => false));
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->css('colorbox', null, array('inline' => false));

?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#sortdate").change(function(){
                var sorting = this.value;
                $.ajax({
                    type:"POST",
                    url:"<?php echo $this->webroot; ?>messages/usersoutfitssorting/<?php echo $user_id; ?>",
                    data:{sorting:sorting},
                    cache: false,
                    success: function(result){
                        data = $.parseJSON(result);
                        html = '';
                    $.each(data, function(index){
                        var outfitData = this.outfit[0];
                        html = html + '<div class="twelve columns client-outfits left">';
                        html = html + '<div class="eleven columns container client-outfits-area pad-none">';
                        html = html + '<h1>'+ this.outfit[0].Outfit.outfitname +'</h1>';
                        html = html + '<div class="twelve columns client-outfits-img pad-none">';
                        html = html + '<ul>';
                        var entitiesData = this.entities; 
                    $.each(entitiesData, function(index1){
                        var entitiesDataNew = entitiesData[index1].Image 
                        $.each(entitiesDataNew, function(index2){
                        
                        html = html + '<li>';
                        html = html + '<img src="<?php echo $this->webroot; ?>files/products/'+ entitiesDataNew[index2].name +'" alt="" />';
                    });
                        html = html + '<div class="product-desc">';
                        html = html + '<span class="product-name">'+ entitiesData[index1].Entity.name +'</span>';
                        html = html + '<span class="product-brand">'+ entitiesData[index1].Brand.name +'</span>';
                        html = html + '<span class="product-price">$'+ entitiesData[index1].Entity.price +'</span>';
                        html = html + '<span class="product-dtls"><a href="<?php echo $this->webroot; ?>messages/outfitdetails/'+ outfitData.Outfit.id +'" title="">Details</a></span>';
                        html = html + '<span class="bottm-links outfit-page-item ">';
                        html = html + '<a class="add-to-cart"  data-product_id="'+ entitiesData[index1].Entity.id +'" href="" title="">Add to Cart +</a>';
                        html = html +'<input type="hidden" id="product_id" class="product-id" value="'+ entitiesData[index1].Entity.id +'">';
                        html = html +'<input type="hidden" id="outfit_id" class="outfit_id" value="'+ outfitData.Outfit.id +'">';
                        html = html + '<a id="'+ entitiesData[index1].Entity.id +'-'+ outfitData.Outfit.user_id +'" class="thumb-icon" href="#"/></a>';
                        html = html + '</span>';
                        html = html + '</div>';
                        html = html + '</li>';
                    });
                
                        html = html + '</ul>';
                        html = html + '</div>';
                        html = html + '<div class="twelve columns left client-outfit-bottom pad-none">';
                        html = html + '<div class="client-comments left">';
                        html = html + '<h2>Stylist Comment</h2>';
                        html = html + '<div class="client-comments-text left">'+ this.comments +'<a href="javascript:;" title="">Read More</a></div>';
                        html = html + '</div>';
                        html = html + '<div class="share-outfit right">Share Outfit</div>';
                        html = html + '</div>';
                        html = html + '</div>';
                        html = html + '</div>';
                        //console.log(this.entities[1].Image[0].name);
                    });
                $("#ascsort").html(html);
                    }
                });
            $(".client-outfits-img li").hover(function(){
                    $(".product-desc").css("display","block");
                    },function(){
                    $(".product-desc").css("display","none");
            });    
           
        });
    });

</script>
<?php
    $img = "";
        if(isset($Userdata) && $Userdata[0]['User']['profile_photo_url'] && $Userdata[0]['User']['profile_photo_url'] != ""){
            $img = $this->webroot . "files/users/" . $Userdata[0]['User']['profile_photo_url'];
         }else{
            $img = $this->webroot . "img/dummy_image.jpg";    
        }
?>
<div class="content-container">
    <div class="twelve columns black">&nbsp;</div>
    <div class="twelve columns container">
        <div class="eleven columns container message-box-area">
            <div class="twelve columns container left message-box">
                <div class="eleven columns container pad-none">
                    <div class="twelve columns message-box-heading pad-none">
                        <h1><?php echo $Userdata[0]['User1']['first_name'].'&nbsp;'.$Userdata[0]['User1']['last_name']; ?> | <span>Outfits</span></h1>
                        <div class="client-img-small"><img src="<?php echo $this->webroot; ?>files/users/<?php echo $Userdata[0]['User1']['profile_photo_url']; ?>" alt="" /></div>
                    </div>
                    <div class="my-profile-img m-ver">
                        <h2><?php echo $Userdata[0]['User']['first_name'].'&nbsp;'.$Userdata[0]['User']['last_name']; ?><span>My Stylist</span></h2>
                        <div class="client-img-small right">
                        <a href="<?php echo $this->webroot; ?>Auth/stylistbiography/<?php echo $Userdata[0]['User']['id']; ?>" title=""><img src="<?php echo $img; ?>" id="user_image" height='134' width='151' /></a>
                        </div>
                        <span id="dd-nav-switcher"><img src="<?php echo $this->webroot; ?>images/nav-switcher-icon.png" alt="" /></span>
                    </div>
                    <div class="dd-nav">
                        <ul>
                            <li><a href="<?php echo $this->webroot; ?>messages/index">Messages</a></li>
                            <li class="active"><a href="<?php echo $this->webroot; ?>messages/usersoutfits/<?php echo $user_id; ?>">Outfits</a></li>
                            <li><a href="<?php echo $this->webroot; ?>messages/userpurchases/<?php echo $user_id; ?>">Purchases/Likes</a></li>
                            <li><a href="<?php echo $this->webroot; ?>messages/userprofiles/<?php echo $user_id; ?>">Profile</a></li>
                        </ul>
                    </div>
                    <div class="twelve columns left inner-content pad-none">
                        <div class="inner-left left">
                            <div class="left-pannel left">
                                <div class="client-img"><img src="<?php echo $this->webroot; ?>files/users/<?php echo $Userdata[0]['User1']['profile_photo_url']; ?>" height="134" width="148" alt=""/></div>
                                <div class="twelve columns left left-nav">
                                    <ul>
                                        <li><a href="<?php echo $this->webroot; ?>messages/index">Messages</a></li>
                                        <li class="active"><a href="<?php echo $this->webroot; ?>messages/usersoutfits/<?php echo $user_id; ?>">Outfits</a></li>
                                        <li><a href="<?php echo $this->webroot; ?>messages/userpurchases/<?php echo $user_id; ?>">Purchases/Likes</a></li>
                                        <li><a href="<?php echo $this->webroot; ?>messages/userprofiles/<?php echo $user_id; ?>">Profile</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="right-pannel right">
                                <div class="twelve columns message-area left pad-none">
                                    <div class="eleven columns container pad-none">
                                        <div class="short-by-date">
                                            <span class="short-by-date-arrow"><img src="<?php echo $this->webroot; ?>images/down-arrow.png" alt=""/></span>
                                            <select id="sortdate">
                                            <option value="">Sort By Date</option>
                                                <option value="DESC">Sort By Date DESC</option>
                                                <option value="ASC">Sort By Date ASC</option>
                                            </select>
                                        </div>
                                        <div id="ascsort">
                                        <?php foreach ($my_outfits as $my_outfit): ?>
                                            <?php //print_r($my_outfit); ?>
                                        <div class="twelve columns client-outfits left" >

                                            <div class="eleven columns container client-outfits-area pad-none" >
                                                <h1><?php echo $my_outfit['outfit'][0]['Outfit']['outfitname']; ?></h1>
                                                <div class="twelve columns client-outfits-img pad-none">
                                                    <ul>
                                                    <?php if(isset($my_outfit['entities'][0])!=''){ ?>
                                                        <?php ?>
                                                        <li>
                                                            <img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit['entities'][0]['Image'][0]['name']; ?>" alt="" />
                                                            <div class="product-desc">
                                                                <span class="product-name"><?php echo $my_outfit['entities'][0]['Entity']['name']; ?></span>
                                                                <span class="product-brand"><?php echo $my_outfit['entities'][0]['Brand']['name']; ?></span>
                                                                <span class="product-price">$<?php echo $my_outfit['entities'][0]['Entity']['price']; ?></span>
                                                                <span class="product-dtls"><a href="<?php echo $this->webroot; ?>messages/outfitdetails/<?php echo $my_outfit['outfit'][0]['Outfit']['id']; ?>" title="">Details</a></span>
                                                                <span class="bottm-links outfit-page-item">
                                                                    <a class="add-to-cart" data-product_id="<?php echo $my_outfit['entities'][0]['Entity']['id']; ?>" href="" title="">Add to Cart +</a>
                                                                    
                                                                    <input type="hidden" id="product_id" class="product-id" value="<?php echo $my_outfit['entities'][0]['Entity']['id']; ?>">
                                                                    
                                                                    <input type="hidden" id="outfit_id" value="<?php echo $my_outfit['outfit'][0]['Outfit']['id']; ?>"> 
                                                                   
                                                                    
                                                                <a href="#" id="<?php echo $my_outfit['entities'][0]['Entity']['id'].'-'.$user_id; ?>" class="thumb-icon"></a>
                                                                
                                                                
                                                                    <?php //endforeach; ?>   
                                                                </span>
                                                            </div>
                                                        </li>
                                                        <?php }else{} ?>
                                                         <?php if(isset($my_outfit['entities'][1])!=''){ ?>
                                                        <li>
                                                            <img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit['entities'][1]['Image'][0]['name']; ?>" alt="" />
                                                            <div class="product-desc">
                                                                <span class="product-name"><?php echo $my_outfit['entities'][1]['Entity']['name']; ?></span>
                                                                <span class="product-brand"><?php echo $my_outfit['entities'][1]['Brand']['name']; ?></span>
                                                                <span class="product-price">$<?php echo $my_outfit['entities'][1]['Entity']['price']; ?></span>
                                                                <span class="product-dtls"><a href="<?php echo $this->webroot; ?>messages/outfitdetails/<?php echo $my_outfit['outfit'][0]['Outfit']['id']; ?>" title="">Details</a></span>
                                                                <span class="bottm-links outfit-page-item">
                                                                    <a class="add-to-cart" href="javascript:;" title="">Add to Cart +</a>
                                                                    <input type="hidden" id="product_id" value="<?php echo $my_outfit['entities'][1]['Entity']['id']; ?>"> 
                                                                    <input type="hidden" id="outfit_id" value="<?php echo $my_outfit['outfit'][0]['Outfit']['id']; ?>"> 
                                                                    <a href="#" id="<?php echo $my_outfit['entities'][1]['Entity']['id'].'-'.$user_id; ?>" class="thumb-icon"></a>
                                                                       
                                                                </span>
                                                            </div>
                                                        </li>
                                                        <?php }else{} ?>
                                                        <?php if(isset($my_outfit['entities'][2])!=''){ ?>
                                                        <li>
                                                            <img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit['entities'][2]['Image'][0]['name']; ?>" alt="" />
                                                            <div class="product-desc">
                                                                <span class="product-name"><?php echo $my_outfit['entities'][2]['Entity']['name']; ?></span>
                                                                <span class="product-brand"><?php echo $my_outfit['entities'][2]['Brand']['name']; ?></span>
                                                                <span class="product-price">$<?php echo $my_outfit['entities'][2]['Entity']['price']; ?></span>
                                                                <span class="product-dtls"><a href="<?php echo $this->webroot; ?>messages/outfitdetails/<?php echo $my_outfit['outfit'][0]['Outfit']['id']; ?>" title="">Details</a></span>
                                                                <span class="bottm-links outfit-page-item">
                                                                    <a class="add-to-cart" href="" title="">Add to Cart +</a>
                                                                    <input type="hidden" id="product_id" value="<?php echo $my_outfit['entities'][2]['Entity']['id']; ?>"> 
                                                                    <input type="hidden" id="outfit_id" value="<?php echo $my_outfit['outfit'][0]['Outfit']['id']; ?>"> 
                                                                    <a href="#" id="<?php echo $my_outfit['entities'][2]['Entity']['id'].'-'.$user_id; ?>" class="thumb-icon"></a>
                                                                       
                                                                </span>
                                                            </div>
                                                        </li>
                                                        <?php }else{} ?>
                                                         <?php if(isset($my_outfit['entities'][3])!=''){ ?>
                                                        <li>
                                                            <img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit['entities'][3]['Image'][0]['name']; ?>" alt="" />
                                                            <div class="product-desc">
                                                                <span class="product-name"><?php echo $my_outfit['entities'][3]['Entity']['name']; ?></span>
                                                                <span class="product-brand"><?php echo $my_outfit['entities'][3]['Brand']['name']; ?></span>
                                                                <span class="product-price">$<?php echo $my_outfit['entities'][3]['Entity']['price']; ?></span>
                                                                <span class="product-dtls"><a href="<?php echo $this->webroot; ?>messages/outfitdetails/<?php echo $my_outfit['outfit'][0]['Outfit']['id']; ?>" title="">Details</a></span>
                                                                <span class="bottm-links outfit-page-item">
                                                                    <a class="add-to-cart" href="javascript:;" title="">Add to Cart +</a>
                                                                    <input type="hidden" id="product_id" value="<?php echo $my_outfit['entities'][3]['Entity']['id']; ?>"> 
                                                                    <input type="hidden" id="outfit_id" value="<?php echo $my_outfit['outfit'][0]['Outfit']['id']; ?>"> 
                                                                    <a href="#" id="<?php echo $my_outfit['entities'][3]['Entity']['id'].'-'.$user_id; ?>" class="thumb-icon"></a>
                                                                       
                                                                </span>
                                                            </div>
                                                        </li>
                                                        <?php }else{} ?>
                                                        <?php if(isset($my_outfit['entities'][4])!=''){ ?>
                                                        <li>
                                                            <img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit['entities'][4]['Image'][0]['name']; ?>" alt="" />
                                                            <div class="product-desc">
                                                                <span class="product-name"><?php echo $my_outfit['entities'][4]['Entity']['name']; ?></span>
                                                                <span class="product-brand"><?php echo $my_outfit['entities'][4]['Brand']['name']; ?></span>
                                                                <span class="product-price">$<?php echo $my_outfit['entities'][4]['Entity']['price']; ?></span>
                                                                <span class="product-dtls"><a href="javascript:;" title="">Details</a></span>
                                                                <span class="bottm-links outfit-page-item">
                                                                    <a class="add-to-cart" href="<?php echo $this->webroot; ?>messages/outfitdetails/<?php echo $my_outfit['outfit'][0]['Outfit']['id']; ?>" title="">Add to Cart +</a>
                                                                    <input type="hidden" id="product_id" value="<?php echo $my_outfit['entities'][4]['Entity']['id']; ?>"> 
                                                                    <input type="hidden" id="outfit_id" value="<?php echo $my_outfit['outfit'][0]['Outfit']['id']; ?>"> 
                                                                    <a href="#" id="<?php echo $my_outfit['entities'][4]['Entity']['id'].'-'.$user_id; ?>" class="thumb-icon"></a>
                                                                       
                                                                </span>
                                                            </div>
                                                        </li>
                                                        <?php }else{   } ?>
                                                       
                                                    </ul>

                                                </div>
                                            
                                                 
                                                <div class="twelve columns left client-outfit-bottom pad-none">
                                                    <div class="client-comments left">
                                                        <h2>Stylist Comment</h2>
                                                        <div class="client-comments-text left">Kyle- <?php echo $my_outfit['comments']; ?> <a href="javascript:;" title="">Read More</a></div>
                                                    </div>
                                                    <div class="share-outfit right">Share Outfit</div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                         
                                      </div>  

                                    </div>
                                    <div class="pagination usersoutfits">
                    <?php
                    //echo $this->Paginator->prev('>', array(), null, array('class' => 'prev disabled'));
                    //echo $this->Paginator->numbers(array('separator' => '', 'class' => 'page-links'));
                    //echo $this->Paginator->next('>', array(), null, array('class' => 'next disabled'));
                    ?>
                </div>
                                </div>
                            </div>
                       
                        </div> 
                        <div class="inner-right right">
                            <div class="twelve columns text-center my-profile">
                                <div class="my-profile-img">
                                    <a href="<?php echo $this->webroot; ?>Auth/stylistbiography/<?php echo $Userdata[0]['User']['id']; ?>" title=""><img src="<?php echo $this->webroot; ?>files/users/<?php echo $Userdata[0]['User']['profile_photo_url']; ?>" alt="" data-name="Haspel" /></a>
                                </div>
                                <div class="my-profile-detials">
                                    <?php echo $Userdata[0]['User']['first_name'].'&nbsp;'.$Userdata[0]['User']['last_name']; ?>
                                    <span>My Stylist</span>
                                    <a class="view-profile" href="<?php echo $this->webroot; ?>Auth/stylistbiography/<?php echo $Userdata[0]['User']['id']; ?>">View My Profile</a> 
                                </div>
                                
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>