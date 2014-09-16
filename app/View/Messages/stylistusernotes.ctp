<script type="text/javascript">
$(document).ready(function(){
    $("#sortdate").change(function(){

        var valueSelected = this.value;
        //alert(valueSelected);
        $.ajax({
            type: "POST",
            url: "<?php echo $this->webroot; ?>messages/userLikesAsc/<?php echo $clientid; ?>",
            data: {valueSelected:valueSelected},
            cache: false,
            success: function(result){
            //alert(result);
            data = $.parseJSON(result);
            html = '';
            html = html + '<ul>';
            html = html + '<li><div class="purchase-dtls-date heading left">Date</div><div class="purchase-dtls-items heading left">Item</div><div class="purchase-dtls-outfit heading left">Outfit</div><div class="purchase-dtls-price heading left">Price</div></li>';
            $.each(data,  function (index){
                html = html + '<li>';7
                html = html + '<div class="purchase-dtls-date left">'+this.Wishlist.created +'</div>';
                html = html + '<div class="purchase-dtls-items left">';
                html = html + '<div class="purchase-dtls-items-img"><img src="<?php echo $this->webroot; ?>files/products/'+ this.Image[0].name+'" alt=""  /></div>';
                html = html + '<div class="purchase-dtls-items-desc">'+this.Entity.name +'<span>'+ this.Brand.name +'</span></div>';
                html = html + '</div>';
                html = html + '<div class="purchase-dtls-outfit left">'+this.Outfit.outfitname +'</div>';        
                html = html + '<div class="purchase-dtls-price left">$'+ this.Entity.price +'</div>';
                html = html + '</li>';        
                
                });
            html = html + '</ul>';
                $("#ascsort").html(html);
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
                        <h1><?php echo $client['User']['first_name'].'&nbsp;'.$client['User']['last_name']; ?> | <span>NOTES</span></h1>
                        <div class="client-img-small"><img src="$img" alt="" /></div>
                    </div>
                    <div class="my-profile-img m-ver">
                        
                        <div class="client-img-small right">
                       
                        </div>
                        <span id="dd-nav-switcher"><img src="<?php echo $this->webroot; ?>images/nav-switcher-icon.png" alt="" /></span>
                    </div>
                    <div class="dd-nav">
                        <ul>
                            <li><a href="?php echo $this->webroot; ?>messages/index/<?php echo $clientid; ?>">Messages</a></li>
                            <li class="active"><a href="<?php echo $this->webroot; ?>messages/usersoutfits/<?php echo $clientid; ?>">Outfits</a></li>
                            <li><a href="<?php echo $this->webroot; ?>messages/userpurchases/<?php echo $clientid; ?>">Purchases/Likes</a></li>
                            <li><a href="<?php echo $this->webroot; ?>messages/userprofiles/<?php echo $clientid; ?>">Profile</a></li>
                        </ul>
                    </div>
                    <div class="twelve columns left inner-content pad-none">
                        <div class="inner-left left">
                            <div class="left-pannel left">
                                <div class="client-img"><img src="<?php echo $this->webroot; ?>files/users/<?php echo $client['User']['profile_photo_url']; ?>"  alt=""/></div>
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
                                    
                                        <div class="twelve columns purchase-container left">
                                            <div class="eleven columns container purchase-area pad-none">
                                                <div class="twelve columns left purchase-dtls">
                                                   <ul>
                                                   
                                                        <li>
                                                            <table>
                                                                <?php foreach ($usernotes as $usernote): ?>
                                                             <tr> 
                                                             <td><?php echo $usernote['Stylistnote']['created'] ?>&nbsp;&nbsp;</td>
                                                            <td><?php echo $usernote['Stylistnote']['notes'] ?></td>
                                                            <td>&nbsp;Edit</td>
                                                            <td>&nbsp;<a href="<?php echo $this->webroot; ?>messages/removestylistusernotes/<?php echo $usernote['Stylistnote']['id'] ?>">Delete</a></td>
                                                            </tr>
                                                              
                                                            <?php endforeach; ?>
                                                            </table>
                                                            
                                                            
                                                       </li>

                                                       <br>
                                                       <br>
                                                       <br>
                                                       <br>
                                                       <li>
                                                           <?php echo $this->Form->create('Stylistnote'); ?>
                                                            <?php echo $this->Form->input('Stylistnote.notes',array('type'=>'text')); ?>
                                                            <?php echo $this->Form->end(__('Submit')); ?> 
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
            </div>
        </div>
    </div>
</div>