<?php
    $user_id = $Userdata[0]['User1']['id'];
?>

<script type="text/javascript">
    $(document).ready(function(){
        $("#save").on('click', function(e){
             e.preventDefault();
             var id = $("#id").val();
             var first_name = $("#First_name").val();
             var last_name = $("#last_name").val();
             var email = $("#email").val();
             var phone = $("#phone").val();
             var skype = $("#skype").val();
             //jQuery(this).attr("data-id");
             var squared = $("#squared").is(":checked");
             if(squared==true){
                var squared = 1; 
             }else if(squared==false){
                var squared = 0;
             }
             var squared_1 = $("#squared_1").is(":checked");
             if(squared_1==true){
                var squared_1 = 1; 
             }else if(squared_1==false){
                var squared_1 = 0;
             }
             var squared_2 = $("#squared_2").is(":checked");
             if(squared_2==true){
                var squared_2 = 1; 
             }else if(squared_2==false){
                var squared_2 = 0;
             }
             var comments = $("#comments").val();
             //alert(squared);
             $.ajax({
                type:"POST",
                url:"<?php echo $this->webroot; ?>messages/userprofiles/<?php echo $user_id; ?>",
                data:{first_name:first_name,last_name:last_name,email:email,phone:phone,skype:skype,comments:comments,is_phone:squared,is_skype:squared_1,is_srs_msg:squared_2,id:id},
                cache: false,
                    success: function(result){

                    }

             });

             //alert(first_name);

        });

    });  


</script>
    <div class="twelve columns container">
        <div class="eleven columns container message-box-area">
            <div class="twelve columns container left message-box">
                <div class="eleven columns container pad-none">
                    <div class="twelve columns message-box-heading pad-none">
                        <h1><?php echo $Userdata[0]['User1']['first_name'].'&nbsp;'.$Userdata[0]['User1']['last_name']; ?> | <span>Profile</span></h1>
                        <div class="client-img-small"><img src="<?php echo $this->webroot; ?>files/users/<?php echo $Userdata[0]['User1']['profile_photo_url']; ?>" alt="" /></div>
                    </div>
                    <div class="my-profile-img m-ver">
                        <h2><?php echo $Userdata[0]['User']['first_name'].'&nbsp;'.$Userdata[0]['User']['last_name']; ?><span>My Stylist</span></h2>
                        <div class="client-img-small right">
                        <a href="javascript:;" title=""><img src="<?php echo $this->webroot; ?>files/users/<?php echo $Userdata[0]['User']['profile_photo_url']; ?>" alt="" /></a>
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
                                <div class="client-img">

                                <img src="<?php echo $this->webroot; ?>files/users/<?php echo $Userdata[0]['User1']['profile_photo_url']; ?>" alt="" height='134' width='148' /></div>
                                <div class=" twelve columns left left-nav">
                                    <ul>
                                        <li><a href="<?php echo $this->webroot; ?>messages/index">Messages</a></li>
                                        <li><a href="<?php echo $this->webroot; ?>messages/usersoutfits/<?php echo $user_id; ?>">Outfits</a></li>
                                        <li><a href="<?php echo $this->webroot; ?>messages/userpurchases/<?php echo $user_id; ?>">Purchases/Likes</a></li>
                                        <li class="active"><a href="<?php echo $this->webroot; ?>messages/userprofiles/<?php echo $user_id; ?>">Profile</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="right-pannel right">
                                <div class="twelve columns message-area left pad-none">
                                    <div class="eleven columns container pad-none">
                                        <div class="twelve columns left client-profile pad-none">
                                            <div class="eleven columns container pad-none">
                                                <div class="five columns pref-time client-prof left">
                                                    <div class="pref-options">
                                                        <div class="input text required">
                                                        

                                                        <input name="data[User][id]" id="id" type="hidden" value="<?php echo $Userdata[0]['User1']['id']; ?>">
                                                            <input name="data[User][first_name]" id="First_name"  required="required" value="<?php echo $Userdata[0]['User1']['first_name']; ?>" <?php if($Userdata[0]['User1']['is_stylist']){ ?> readonly <?php } ?> type="text">
                                                        </div>
                                                        <div class="input email required">
                                                            <input name="data[User][email]" id="email" required="required" value="<?php echo $Userdata[0]['User1']['email']; ?>" <?php if($Userdata[0]['User1']['is_stylist']){ ?> readonly <?php } ?> type="email">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="five columns pref-time client-prof right">
                                                    <div class="pref-options">
                                                         <div class="input text required">
                                                             <input name="data[User][last_name]" id="last_name" required="required" value="<?php echo $Userdata[0]['User1']['last_name']; ?>" <?php if($Userdata[0]['User1']['is_stylist']){ ?> readonly <?php } ?> type="text">
                                                        </div>
                                                        <div class="input password required">
                                                            <input name="Password" style=" -webkit-text-security: disc;"  value='<?php echo $Userdata[0]['User1']['password']; ?>' <?php if($Userdata[0]['User1']['is_stylist']){ ?> readonly <?php } ?> type="password">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="twelve columns left client-profile pad-none">
                                            <div class="eleven columns container pad-none">
                                                <h1>Communication preferences</h1>
                                                <div class="five columns pref-time client-prof left">
                                                    <div class="pref-options">
                                                        <div class="input tel">
                                                            <input name="data[User][phone]" id="phone" <?php if($Userdata[0]['User1']['is_stylist']){ ?> readonly <?php } ?> value="<?php echo $Userdata[0]['User1']['phone']; ?>" type="tel">
                                                        </div>
                                                        <div class="input text skype">
                                                            <input name="data[User][skype]" id="skype" <?php if($Userdata[0]['User1']['is_stylist']){ ?> readonly <?php } ?> value="<?php echo $Userdata[0]['User1']['skype']; ?>" type="text" >
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="five columns pref-time client-prof right">
                                                    <div class="pref-options">
                                                        <div class="connect">
                                                            <div class="squared">
                                                                <input type="checkbox" id="squared"  <?php if($Userdata[0]['User1']['is_phone']==true){ ?> checked <?php }else{} ?> name="data[User][is_phone]">
                                                                <label for="squared"></label>
                                                            </div>
                                                            <label>I 'd like to connected on the phone :</label>
                                                        </div>
                                                        <div class="connect">
                                                            <div class="squared">
                                                                <input type="checkbox"  id="squared_1" <?php if($Userdata[0]['User1']['is_skype']==true){ ?> checked <?php }else{} ?>  name="data[User][is_skype]">
                                                                <label for="squared_1"></label>
                                                            </div>
                                                            <label>I 'd like to connected through Skype :</label>
                                                        </div>
                                                        <div class="connect">
                                                             <div class="squared">
                                                                <input type="checkbox"   <?php if($Userdata[0]['User1']['is_srs_msg']==true){ ?> checked <?php }else{} ?> id="squared_2" name="data[User][is_srs_msg]">
                                                                <label for="squared_2"></label>
                                                            </div>
                                                            <label>I’d prefer to be contacted through SRS Messaging  System :</label>
                                                        </div>
                                
                                                    </div>
                                                </div>
                                                <div class="ten columns left additional-comment pad-none">
                                                    <div class="eleven columns container additional-comment-text pad-none">
                                                        <h4>Additional comments.</h4>
                                                         <textarea name="data[User][comments]" id="comments"><?php echo $Userdata[0]['User1']['comments']; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        <div class="twelve columns left client-profile client-address client-card-dtls pad-none">
                                            <div class="eleven columns container pad-none">
                                               
                                                <div class="twelve columns left pad-none">
                                                   
                                                    <div class="five columns update-changes right pad-none">
                                                        <a class="save-changes" href="#" id="save" >Save Changes</a>
                                                    </div>
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
                                    <a href="javascript:;" title="">
                                        <?php
                                            if($Userdata[0]['User']['profile_photo_url']){
                                                echo '<img src="' . $this->webroot . 'files/users/' . $Userdata[0]['User']['profile_photo_url'] . '" alt="" height="132" width="151" />';        
                                            }
                                            else{
                                                echo '<img src="' . $this->webroot . 'images/default-user.jpg" width="151">'; 
                                            }
                                        ?>
                                    </a>
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


<div class="address-overlay"></div>
<div class="newaddress-popup" style="display:none;">
    <div class="newaddress left">
        <div class="newaddress-heading">
            <a href="" class="notification-close"></a>
            <div class="newaddress-content">
                <h2>Add New Address</h2>
                <div class="address-top-dtls left">
                    <div class="input text required">
                        <input name="Full_name" required="required" placeholder="Full Name" type="text">
                    </div>
                    <div class="input addressone required">
                        <input name="addressone" required="required" placeholder="Address Line 1 (Street address, P.O. box, c/o" type="email">
                    </div>
                    <div class="input addresstwo required">
                        <input name="addresstwo" required="required" placeholder="Address Line 2 (Apartment, suite, unit, building, floor, etc)" type="email">
                    </div>
                </div>
                <div class="address-bottom-dtls left">
                    <div class="five columns address-bottom-left left">
                        <div class="input text required">
                            <input name="City" required="required" placeholder="City" type="text">
                        </div>
                        <div class="input text required">
                            <input name="Zip_Code" required="required" placeholder="Zip Code" type="text">
                        </div>
                    </div>
                    
                        <div class="address-bottom-right right">
                            <div class="input text required">
                                    <input name="State" required="required" placeholder="State" type="text">
                                </div>
                            <div class="pref-time">
                                <div class="pref-options">
                                    <div class="connect">
                                        <div class="squared">
                                            <input type="checkbox" id="squared" name="data[User][is_phone]">
                                            <label for="squared"></label>
                                        </div>
                                        <label>This address is my billing address.</label>
                                    </div>
                                    <div class="connect">
                                        <div class="squared">
                                            <input type="checkbox" id="squared_1" name="data[User][is_skype]">
                                            <label for="squared_1"></label>
                                        </div>
                                        <label>Make this my default address</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                </div>
                <a class="save-address" href="#" title="">Save</a>
            </div>
        </div>
    </div>
</div>

