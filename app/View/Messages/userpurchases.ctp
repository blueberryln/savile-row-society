<script type="text/javascript">
$(document).ready(function(){
    $("#sortdate").change(function(){
        var valueSelected = this.value;
        $.ajax({
            type: "POST",
            url: "<?php echo $this->webroot; ?>messages/userPurchasesSorting/<?php echo $user_id; ?>",
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
                        <h1><?php echo $Userdata[0]['User1']['first_name'].'&nbsp;'.$Userdata[0]['User1']['last_name']; ?> | <span>Purchase Items</span></h1>
                        <div class="client-img-small"><img src="<?php echo $this->webroot; ?>files/users/<?php echo $Userdata[0]['User1']['profile_photo_url']; ?>" alt="" /></div>
                    </div>
                    <div class="my-profile-img m-ver">
                        <h2><?php echo $Userdata[0]['User']['first_name'].'&nbsp;'.$Userdata[0]['User']['last_name']; ?><span>My Stylist</span></h2>
                        <div class="client-img-small right">
                        <a href="<?php echo $this->webroot; ?>Auth/stylistbiography/<?php echo $Userdata[0]['User']['id']; ?>" title=""><img src="<?php echo $img; ?>" id="user_image"  /></a>
                        </div>
                        <span id="dd-nav-switcher"><img src="<?php echo $this->webroot; ?>images/nav-switcher-icon.png" alt="" /></span>
                    </div>
                    <div class="dd-nav">
                        <ul>
                            <li><a href="<?php echo $this->webroot; ?>messages/index">Messages</a></li>
                            <li class="active"><a href="<?php echo $this->webroot; ?>messages/usersoutfits/<?php echo $user_id; ?>">Outfits</a></li>
                            <li><a href="<?php echo $this->webroot; ?>messages/userpurchases/<?php echo $user_id; ?>">Purchases/Likes</a></li>
                            <li><a href="<?php echo $this->webroot; ?>messages/profiles/<?php echo $user_id; ?>">Profile</a></li>
                        </ul>
                    </div>
                    <div class="twelve columns left inner-content pad-none">
                        <div class="inner-left left">
                            <div class="left-pannel left">
                                <div class="client-img"><img src="<?php echo $this->webroot; ?>files/users/<?php echo $Userdata[0]['User1']['profile_photo_url']; ?>"  alt=""/></div>
                                <div class=" twelve columns left left-nav">
                                    <ul>
                                        <li><a href="<?php echo $this->webroot; ?>messages/index">Messages</a></li>
                                        <li><a href="<?php echo $this->webroot; ?>messages/usersoutfits/<?php echo $user_id; ?>">Outfits</a></li>
                                        <li class="active"><a href="<?php echo $this->webroot; ?>messages/userpurchases/<?php echo $user_id; ?>">Purchases/Likes</a></li>
                                        <li><a href="<?php echo $this->webroot; ?>messages/profiles/<?php echo $user_id; ?>">Profile</a></li>
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
                                        <div class="tab-btns purchase active"><a href="<?php echo $this->webroot; ?>messages/userpurchases/<?php echo $user_id; ?>" title="">Purchase</a>
                                            
                                        </div>
                                        <div class="tab-btns likes"><a href="<?php echo $this->webroot; ?>messages/userlikes/<?php echo $user_id; ?>" title="">Likes</a></div>
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
                                                   
                                                       <?php 
                                                       if($purchases):
                                                       foreach ($purchases as $purchase):?>
                                                       <li>
                                                            <div class="purchase-dtls-date left"><?php echo $purchase['purchase_data']['created']; ?></div>
                                                            <div class="purchase-dtls-items left">
                                                                <div class="purchase-dtls-items-img"><img src="<?php echo $this->webroot; ?>files/products/<?php echo $purchase['purchase_data']['imagename']; ?>" alt=""/></div>
                                                                <div class="purchase-dtls-items-desc"><?php echo $purchase['purchase_data']['name']; ?><span><?php echo $purchase['purchase_data']['brandname']; ?></span></div>
                                                           </div>
                                                            <div class="purchase-dtls-outfit left"><?php echo $purchase['purchase_data']['outfitname']; ?></div>
                                                            <div class="purchase-dtls-price left">$<?php echo $purchase['purchase_data']['price']; ?></div>
                                                       </li> 
                                                       <?php
                                                            endforeach;
                                                            else:
                                                                echo "<h1>There Is no Purchase items.</h1>";
                                                            endif; 
                                                        ?>
                                                       
                                                    </ul>
                                                </div>   
                                            </div>
                                        </div>
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