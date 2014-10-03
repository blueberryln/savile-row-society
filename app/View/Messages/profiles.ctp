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
                url:"<?php echo $this->webroot; ?>user/profile",
                data:{first_name:first_name,last_name:last_name,email:email,phone:phone,skype:skype,comments:comments,is_phone:squared,is_skype:squared_1,is_srs_msg:squared_2,id:id},
                cache: false,
                success: function(result){

                }

             });
        });

    });  


</script>
    <div class="twelve columns container">
        <div class="eleven columns container message-box-area">
            <div class="twelve columns container left message-box">
                <div class="eleven columns container pad-none">
                    
                        <?php echo $this->element('userAside/leftSidebar'); ?>

                            <div class="right-pannel right">
                                <div class="twelve columns message-area left pad-none">
                                    <?php
                                    echo $this->Form->create('User');
                                    ?>
                                    <div class="eleven columns container pad-none">
                                        <div class="twelve columns left client-profile pad-none">
                                            <div class="eleven columns container pad-none">
                                                <div class="five columns pref-time client-prof left">
                                                    <div class="pref-options">
                                                        <div class="input text required">
                                                        

                                                        <input name="data[User][id]" id="id" type="hidden" value="<?php echo $user['User']['id']; ?>">
                                                        <input name="data[User][first_name]" id="First_name"  required="required" value="<?php echo $user['User']['first_name']; ?>" type="text" placeholder="First Name">
                                                        </div>
                                                        <div class="input email required">
                                                            <input name="data[User][email]" id="email" required="required" value="<?php echo $user['User']['email']; ?>" type="email" placeholder="Email">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="five columns pref-time client-prof right">
                                                    <div class="pref-options">
                                                         <div class="input text required">
                                                             <input name="data[User][last_name]" id="last_name" required="required" value="<?php echo $user['User']['last_name']; ?>" type="text" placeholder="Last Name">
                                                        </div>
                                                        <div class="input password required">
                                                            <input name="Password" style=" -webkit-text-security: disc;"  value='<?php echo $user['User']['password']; ?>' type="password" placeholder="Password">
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
                                                            <input name="data[User][phone]" id="phone" value="<?php echo $user['User']['phone']; ?>" type="tel" placeholder="Phone number">
                                                        </div>
                                                        <div class="input text skype">
                                                            <input name="data[User][skype]" id="skype" value="<?php echo $user['User']['skype']; ?>" type="text" placeholder="Skype ID">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="five columns pref-time client-prof right">
                                                    <div class="pref-options">
                                                        <div class="connect">
                                                            <div class="squared">
                                                                <input type="checkbox" id="squared"  <?php if($user['User']['is_phone']==true){ ?> checked <?php }else{} ?> name="data[User][is_phone]">
                                                                <label for="squared"></label>
                                                            </div>
                                                            <label>I'd like to be connected on the phone:</label>
                                                        </div>
                                                        <div class="connect">
                                                            <div class="squared">
                                                                <input type="checkbox"  id="squared_1" <?php if($user['User']['is_skype']==true){ ?> checked <?php }else{} ?>  name="data[User][is_skype]">
                                                                <label for="squared_1"></label>
                                                            </div>
                                                            <label>I'd like to be connected through Skype:</label>
                                                        </div>
                                                        <div class="connect">
                                                             <div class="squared">
                                                                <input type="checkbox"   <?php if($user['User']['is_srs_msg']==true){ ?> checked <?php }else{} ?> id="squared_2" name="data[User][is_srs_msg]">
                                                                <label for="squared_2"></label>
                                                            </div>
                                                            <label>I'd prefer to be contacted through the SRS Messaging System:</label>
                                                        </div>
                                
                                                    </div>
                                                </div>
                                                <div class="ten columns left additional-comment pad-none">
                                                    <div class="twelve columns container additional-comment-text pad-none">
                                                        <textarea name="data[User][comments]" id="comments" placeholder="Additional comments."><?php echo $user['User']['comments']; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        <div class="twelve columns left client-profile client-address client-card-dtls pad-none">
                                            <div class="eleven columns container pad-none">
                                               
                                                <div class="twelve columns left pad-none">
                                                    <br>
                                                    <div class="update-changes pad-none">
                                                        <div class="about-submit text-center"><div class="submit"><input type="submit" value="Save Changes"></div></div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </form>

                                </div>
                            </div>
                        
                        </div>
                        
                        <?php echo $this->element('userAside/rightSidebar'); ?>
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

