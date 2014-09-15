<script type="text/javascript">
$(document).ready(function(){
    $("#sortdate").change(function(){
        var valueSelected = this.value;
        $.ajax({
            type: "POST",
            url: "<?php echo $this->webroot; ?>messages/userPurchasesSorting/<?php echo $clientid; ?>",
            data: {valueSelected:valueSelected},
            cache: false,
            success: function(result){
                
                data = $.parseJSON(result);
                
                html = '';
                html = html + '<ul>';
                html = html + '<li>';
                html = html + '<div class="purchase-dtls-date heading left">Date</div>';
                html = html + '<div class="purchase-dtls-items heading left">Item</div>';
                html = html + '<div class="purchase-dtls-outfit heading left">Outfit</div>';
                html = html + '<div class="purchase-dtls-price heading left">Price</div>';
                html = html + '</li>';
             $.each(data,  function (index){
                html = html + '<li>';
                html = html + '<div class="purchase-dtls-date left">'+ this.purchase_data_sort.created +'</div>';
                html = html + '<div class="purchase-dtls-items left">';
            html = html + '<div class="purchase-dtls-items-img"><img src="<?php echo $this->webroot; ?>files/products/'+ this.purchase_data_sort.imagename +'" alt=""/></div>';
            html = html + '<div class="purchase-dtls-items-desc">'+ this.purchase_data_sort.name +'<span>'+ this.purchase_data_sort.brandname +'</span></div>';
                html = html + '</div>';
                html = html + '<div class="purchase-dtls-outfit left">'+ this.purchase_data_sort.outfitname +'</div>';
                html = html + '<div class="purchase-dtls-price left">$'+ this.purchase_data_sort.price +'</div>';
                html = html + '</li>'; 
            });
                html = html + '</ul>';
            $("#sortbydate").html(html);
            }
        });

    });

});

</script>

<div class="content-container">
    <div class="twelve columns black">&nbsp;</div>
    <div class="twelve columns container">
        <div class="eleven columns container message-box-area">
            <div class="twelve columns container left message-box">
                <div class="eleven columns container pad-none">
                    <div class="twelve columns message-box-heading pad-none">
                        <h1><?php echo $client['User']['first_name'].'&nbsp;'.$client['User']['last_name']; ?> | <span>Purchase Items</span></h1>
                        <div class="client-img-small"><img src="<?php echo $this->webroot; ?>files/users/<?php echo $client['User']['profile_photo_url']; ?>" alt="" /></div>
                    </div>
                    <div class="my-profile-img m-ver">
                        
                        <div class="client-img-small right">
                        </div>
                        <span id="dd-nav-switcher"><img src="<?php echo $this->webroot; ?>images/nav-switcher-icon.png" alt="" /></span>
                    </div>
                    <div class="dd-nav">
                        <ul>
                            <li><a href="<?php echo $this->webroot; ?>messages/index/<?php echo $clientid; ?>">Messages</a></li>
                            <li class="active"><a href="<?php echo $this->webroot; ?>messages/usersoutfits/<?php echo $clientid; ?>">Outfits</a></li>
                            <li><a href="<?php echo $this->webroot; ?>messages/userpurchases/<?php echo $clientid; ?>">Purchases/Likes</a></li>
                            <li><a href="<?php echo $this->webroot; ?>messages/userprofiles/<?php echo $clientid; ?>">Profile</a></li>
                        </ul>
                    </div>
                    <div class="twelve columns left inner-content pad-none">
                        <div class="inner-left left">
                            <div class="left-pannel left">
                                <div class="client-img"><img src="<?php echo $this->webroot; ?>files/users/<?php echo $client['User']['profile_photo_url']; ?>" alt=""/></div>
                                <div class=" twelve columns left left-nav">
                                    <ul>
                                        <li><a href="<?php echo $this->webroot; ?>messages/index/<?php echo $clientid; ?>">Messages</a></li>
                                        <li><a href="<?php echo $this->webroot; ?>messages/usersoutfits/<?php echo $clientid; ?>">Outfits</a></li>
                                        <li class="active"><a href="<?php echo $this->webroot; ?>messages/userpurchases/<?php echo $clientid; ?>">Purchases/Likes</a></li>
                                        <li><a href="<?php echo $this->webroot; ?>messages/userprofiles/<?php echo $clientid; ?>">Profile</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="right-pannel product-detials right">
                                <div class="twelve columns message-area left pad-none">
                                    <div class="eleven columns container pad-none">
                                        <div class="short-by-date">
                                            <span class="short-by-date-arrow"><img src="<?php echo $this->webroot; ?>images/down-arrow.png" alt=""/></span>
                                            <select id="sortdate">
                                                <option value="DESC">Sort By Date DESC</option>
                                                <option value="ASC">Sort By Date ASC</option>
                                            </select>
                                        </div>
                                        <div class="tab-btns purchase active"><a href="<?php echo $this->webroot; ?>messages/userpurchases/<?php echo $clientid; ?>" title="">Purchase</a>
                                            
                                        </div>
                                        <div class="tab-btns likes"><a href="<?php echo $this->webroot; ?>messages/stylistuserlikes/<?php echo $clientid; ?>" title="">Likes</a></div>
                                        <div class="twelve columns purchase-container left">
                                            <div class="eleven columns container purchase-area pad-none">
                                                <div class="twelve columns left purchase-dtls">
                                                   <ul id='sortbydate'>
                                                   
                                                        <li>
                                                            <div class="purchase-dtls-date heading left">Date</div>
                                                            <div class="purchase-dtls-items heading left">Item</div>
                                                            <div class="purchase-dtls-outfit heading left">Outfit</div>
                                                            <div class="purchase-dtls-price heading left">Price</div>
                                                       </li>
                                                   
                                                       <?php foreach ($purchases as $purchase): //print_r($purchase); ?>
                                                       <li>
                                                            <div class="purchase-dtls-date left"><?php echo $purchase['purchase_data']['created']; ?></div>
                                                            <div class="purchase-dtls-items left">
                                                                <div class="purchase-dtls-items-img"><img src="<?php echo $this->webroot; ?>files/products/<?php echo $purchase['purchase_data']['imagename']; ?>" alt=""/></div>
                                                                <div class="purchase-dtls-items-desc"><?php echo $purchase['purchase_data']['name']; ?><span><?php echo $purchase['purchase_data']['brandname']; ?></span></div>
                                                           </div>
                                                            <div class="purchase-dtls-outfit left"><?php echo $purchase['purchase_data']['outfitname']; ?></div>
                                                            <div class="purchase-dtls-price left">$<?php echo $purchase['purchase_data']['price']; ?></div>
                                                       </li> 
                                                       <?php endforeach; ?>
                                                       
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
            </div>
        </div>
    </div>
</div>