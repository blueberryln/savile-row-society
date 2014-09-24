<script type="text/javascript">
    $(document).ready(function(){


    $(".search-myclient").on('keydown',function(){
         
         //var r = $('input').focus();
         var usersearch = $("#usersearch").val();
         //alert(usersearch);
          $.ajax({
                type:"POST",
                url:"<?php echo $this->webroot; ?>messages/stylistUserFilterList/<?php echo $clientid; ?>",
                data:{usersearch:usersearch},
                cache: false,
                    success: function(result){
                        data = $.parseJSON(result);

            html = '';
            html = html + '<ul>';
            
            $.each(data,  function (index){
                html = html + '<li>';
                html = html + '<a href="<?php echo $this->webroot; ?>messages/index/'+ this.User.id +'" title="">';
                html = html + '<div class="myclient-img">';
                html = html + '<img src="<?php echo $this->webroot; ?>files/users/'+ this.User.profile_photo_url +'" alt=""/>';
                html = html + '</div>';
                html = html + '<div class="myclient-dtl">';
                html = html + '<span class="myclient-name">'+ this.User.first_name +'&nbsp;'+ this.User.last_name +'</span>';
                html = html + '<span class="myclient-status">last active at '+ this.User.updated +'</span>';
                html = html + '</div>';
                html = html + '</a>';
                html = html + '</li>';      
                
                });
            html = html + '</ul>';
                $("#searchuserlist").html(html);

                    }

             }); 


    });
});

</script>
<?php
    $img = "";
        if(isset($client) && $client['User']['profile_photo_url'] && $client['User']['profile_photo_url'] != ""){
            $img = $this->webroot . "files/users/" . $client['User']['profile_photo_url'];
         }else{
            $img = $this->webroot . "img/dummy_image.jpg";    
        }
?>
<div class="content-container">
    <div class="twelve columns black">
        <div class="eleven columns container">
            <div class="twelve columns container left ">
                <div class="ten columns left admin-nav">
                    <ul>
                        <li class="active"><a href="#" title="">My Clients</a></li>
                        <li><a href="<?php echo $this->webroot; ?>messages/stylistdashboard" title="">Dashboard</a></li>
                        <li><a title="" href="<?php echo $this->webroot; ?>messages/stylisttotaloutfit">My outfits</a></li>
                        <li><a href="<?php echo $this->webroot; ?>messages/stylistcloset" title="">The CLoset</a></li>
                    </ul>
                </div>
                <div class="two columns right admin-top-right">
                    <ul>
                    <li><a href="<?php echo $this->request->webroot; ?>cart"><img class="cart-icons" src="<?php echo $this->webroot; ?>images/cart-icon.png" alt="" /> (<span class="cart-items-count"><?php echo $cart_items; ?></span>)</a></li>
                       <!--  <li><a href="#" title=""><img class="cart-icons" src="<?php echo $this->webroot; ?>images/cart-icon.png" alt="" />(<span class="no-of-items">0</span>) </a></li> -->
                        <li>
                            <a href="#" title=""><span class="client-nav-switcher"><img src="<?php echo $this->webroot; ?>images/menu-dropdown-icon.png" alt="" /></span></a>
                            <div class="admin-top-right-dropdown">
                                <ul>
                                    <li><a href="#" title="">view my cart/checkout</a></li>
                                    <li><a href="#" title="">refer a friend</a></li>
                                    <li><a href="<?php echo $this->request->webroot; ?>signout" title="">sign out</a></li>
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
                
                
                <div class="myclient-left left">
                    <div class="myclient-topsec"> 
                        <div class="filter-myclient-area">
                            <div class="filter-myclient">
                                <span class="downarw"></span>
                                <select onchange="location = this.options[this.selectedIndex].value;">
                                    <option>Filter Clients</option>
                                    <?php  foreach($userlists as $userlist ): ?>
                                    <option value="<?php echo $this->webroot; ?>messages/index/<?php echo $userlist['User']['id']; ?>"><?php echo $userlist['User']['first_name'].'&nbsp;'.$userlist['User']['last_name']; ?></option>
                                     <?php endforeach; ?>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="search-myclient-area">
                            <div class="search-myclient">
                                <span class="srch"></span>
                                <input type="text" name="myclient-search" id="usersearch" />
                            </div>
                        </div>
                        <div class="myclient-list">
                            <ul id="searchuserlist">
                            <?php  foreach($userlists as $userlist ): ?>
                                <li <?php if($userlist['User']['id']==$clientid){ echo "class='active'"; } ?>>
                                    <a href="<?php echo $this->webroot; ?>messages/index/<?php echo $userlist['User']['id']; ?>" title="">
                                        <div class="myclient-img">
                                            <img src="<?php echo $this->webroot; ?>files/users/<?php echo $userlist['User']['profile_photo_url']; ?>" alt=""/>
                                        </div>
                                        <div class="myclient-dtl">
                                            <span class="myclient-name"><?php echo $userlist['User']['first_name'].'&nbsp;'.$userlist['User']['last_name']; ?></span>
                                            <span class="myclient-status">last active at <?php echo date ('d F Y',$userlist['User']['updated']); ?></span>
                                        </div>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                                
                            </ul>
                        </div>
                    </div>
                </div>
                
                
                <div class="myclient-right right">
                    <div class="twelve columns left inner-content pad-none">
                         <div class="twelve columns myclient-heading pad-none">
                            <h1><?php echo $client['User']['first_name'].'&nbsp;'.$client['User']['last_name']; ?> | <span>Measurements </span></h1>
                            <div class="client-img-small"><img src="<?php echo $this->webroot; ?>files/users/<?php echo $client['User']['profile_photo_url']; ?>" alt="" /></div>
                        </div>
                        <div class="inner-left inner-myclient left">
<!--                            <div class="dashboard-pannel left">&nbsp;</div>-->
                            <div class="left-pannel left">
                                <div class="client-img"><img src="<?php echo $this->webroot; ?>files/users/<?php echo $client['User']['profile_photo_url']; ?>" alt="" /></div>
                                <div class=" twelve columns left left-nav">
                                    <ul>
                                        <li><a href="<?php echo $this->webroot; ?>messages/stylistuseractivityfeed/<?php echo $clientid; ?>">Activity Feed</a></li>
                                        <li><a href="<?php echo $this->webroot; ?>messages/index/<?php echo $clientid; ?>">Messages</a></li>
                                        <li><a href="<?php echo $this->webroot; ?>messages/stylistuseroutfits/<?php echo $clientid; ?>">Outfits</a></li>
                                        <li class="active"><a href="<?php echo $this->webroot; ?>messages/stylistuserpurchase/<?php echo $clientid; ?>">Purchases/Likes</a></li>
                                        <li><a href="<?php echo $this->webroot; ?>messages/stylistusernotes/<?php echo $clientid; ?>">Notes &amp; Gallery</a></li>
                                        <li><a href="<?php echo $this->webroot; ?>messages/stylistusermeasurements/<?php echo $clientid; ?>">Measurements</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="right-pannel right">
                                <div class="twelve columns message-area left pad-none">
                                    <div class="eleven columns container pad-none">
                                        <div class="twelve columns left msrmnt-block">
                                            <div class="ten columns center-block">
                                                <div class="twelve columns left msrmnt-section">
                                                    <h1>Profile Sizes</h1>
                                                    
                                                </div>
                                                <div class="five columns left">
                                                    <div class="twelve columns left">
                                                        <div class="six columns left msrmnt-label"><label>Jacket</label></div>
                                                        <div class=" six columns left msrmnt-input-area">
                                                        <input type="text" name="" value="<?php echo $userprofile[0]['UserPreference']['jacket_size'] ?>"  /></div>
                                                    </div>
                                                    <div class="twelve columns left">
                                                        <div class="six columns left msrmnt-label"><label>Pant Waist</label></div>
                                                        <div class=" six columns left msrmnt-input-area">
                                                        <input type="text" name="" value="<?php echo $userprofile[0]['UserPreference']['pant_waist'] ?>" /></div>
                                                    </div>
                                                    <div class="twelve columns left">
                                                        <div class="six columns left msrmnt-label"><label>Pant Length</label></div>
                                                        <div class=" six columns left msrmnt-input-area">
                                                        <input type="text" name="" value="<?php echo $userprofile[0]['UserPreference']['pant_length'] ?>" /></div>
                                                    </div>
                                                </div>
                                                <div class="five columns right">
                                                    <div class="twelve columns left">
                                                        <div class="six columns left msrmnt-label"><label>Neck</label></div>
                                                        <div class=" six columns left msrmnt-input-area">
                                                        <input type="text" name="" value="<?php echo $userprofile[0]['UserPreference']['neck_size'] ?>" /></div>
                                                    </div>
                                                    <div class="twelve columns left">
                                                        <div class="six columns left msrmnt-label"><label>Shoe</label></div>
                                                        <div class=" six columns left msrmnt-input-area">
                                                        <input type="text" name="" value="<?php echo $userprofile[0]['UserPreference']['shoe_size'] ?>" /></div>
                                                    </div>
                                                </div>
                                                <div class="twelve columns left">
                                                    <div class="three columns left msrmnt-label"><label>Style Profile Comments</label></div>
                                                    <div class="nine columns left msrmnt-input-area"><textarea name="comment"> <?php echo $client['User']['comments']; ?> </textarea></div>
                                                </div>
                                                <?php echo $this->Form->create('UserSizeInformation');?>
                                                <div class="twelve columns left cstm-msrmnt">
                                                    <div class="twelve columns left cstm-msrmnt-section">
                                                        <h1>Custom Measurements</h1>
                                                    </div>
                                                </div>
                                                <?php
                                                //print_r($customdata);
                                                if(isset($customdata[0]['UserSizeInformation'])){


                                                $customdatashirt = json_decode($customdata[0]['UserSizeInformation']['custom_shirt_measurement'],true);
                                                $customdatajacket = json_decode($customdata[0]['UserSizeInformation']['custom_jacket_measurement'],true);
                                                $customdatatrouser = json_decode($customdata[0]['UserSizeInformation']['custom_trouser_measurement'],true);
                                                $customdatavest = json_decode($customdata[0]['UserSizeInformation']['custom_vest_measurement'],true);
                                                    //print_r($customdatas);
                                            }
                                                 ?>
                                        <input type="hidden" name="data[UserSizeInformation][id]"   value="<?php echo $customdata[0]['UserSizeInformation']['id']; ?>">
                                                <div class="twelve columns left cstm-msrmnt-content">
                                                    <div id="horizontalTab">
                                                        <ul>
                                                            <li><a href="#11">Shirt</a></li>
                                                            <li><a href="#12">Jacket</a></li>
                                                            <li><a href="#13">Trousers</a></li>
                                                            <li><a href="#14">Vests</a></li>
                                                            
                                                        </ul>

                                                        <div id="11">
                                                        
                                                            <div class="twelve columns left">
                                                                <div class="three columns left">
                                                                    <label>Neck</label>
                                                                    
                                                                    <input type="text" name="data[UserSizeInformation][custom_shirt_measurement][neck]" <?php  if(isset($customdatashirt['neck'])!=''){ ?> value="<?php echo $customdatashirt['neck']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                <div class="three columns left cstm-msrmnt-center">
                                                                    <label>Chest</label>
                                                                   <input type="text" name="data[UserSizeInformation][custom_shirt_measurement][chest]" <?php  if(isset($customdatashirt['chest'])!=''){ ?> value="<?php echo $customdatashirt['chest']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                <div class="three columns left">
                                                                    <label>Waist</label>
                                                                    <input type="text" name="data[UserSizeInformation][custom_shirt_measurement][waist]" <?php  if(isset($customdatashirt['waist'])!=''){ ?> value="<?php echo $customdatashirt['waist']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                            </div>
                                                            <div class="twelve columns left">
                                                                <div class="three columns left">
                                                                    <label>Hip</label>
                                                                   <input type="text" name="data[UserSizeInformation][custom_shirt_measurement][hip]" <?php  if(isset($customdatashirt['hip'])!=''){ ?> value="<?php echo $customdatashirt['hip']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                <div class="three columns left cstm-msrmnt-center">
                                                                    <label>Over Arm </label>
                                                                    <input type="text" name="data[UserSizeInformation][custom_shirt_measurement][over_arm]" <?php  if(isset($customdatashirt['over_arm'])!=''){ ?> value="<?php echo $customdatashirt['over_arm']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                <div class="three columns left">
                                                                    <label>Tail </label>
                                                                    <input type="text" name="data[UserSizeInformation][custom_shirt_measurement][tail]" <?php  if(isset($customdatashirt['tail'])!=''){ ?> value="<?php echo $customdatashirt['tail']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                            </div>
                                                            <div class="twelve columns left">
                                                                <div class="three columns left">
                                                                    <label> Yoke</label>
                                                                   <input type="text" name="data[UserSizeInformation][custom_shirt_measurement][yoke]" <?php  if(isset($customdatashirt['yoke'])!=''){ ?> value="<?php echo $customdatashirt['yoke']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                <div class="three columns left cstm-msrmnt-center">
                                                                    <label> Left Sleeve</label>
                                                                    <input type="text" name="data[UserSizeInformation][custom_shirt_measurement][left_sleeve]" <?php  if(isset($customdatashirt['left_sleeve'])!=''){ ?> value="<?php echo $customdatashirt['left_sleeve']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                <div class="three columns left">
                                                                    <label>Right Sleeve</label>
                                                                    <input type="text" name="data[UserSizeInformation][custom_shirt_measurement][right_sleeve]" <?php  if(isset($customdatashirt['right_sleeve'])!=''){ ?> value="<?php echo $customdatashirt['right_sleeve']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                            </div>
                                                            <div class="twelve columns left">
                                                                <div class="three columns left">
                                                                    <label>Left Cuff </label>
                                                                    <input type="text" name="data[UserSizeInformation][custom_shirt_measurement][left_cuff]" <?php  if(isset($customdatashirt['left_cuff'])!=''){ ?> value="<?php echo $customdatashirt['left_cuff']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                <div class="three columns left cstm-msrmnt-center">
                                                                    <label> Right Cuff </label>
                                                                  <input type="text" name="data[UserSizeInformation][custom_shirt_measurement][right_cuff]" <?php  if(isset($customdatashirt['right_cuff'])!=''){ ?> value="<?php echo $customdatashirt['right_cuff']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                <div class="three columns left">
                                                                    <label>Height</label>
                                                                    <input type="text" name="data[UserSizeInformation][custom_shirt_measurement][height]" <?php  if(isset($customdatashirt['height'])!=''){ ?> value="<?php echo $customdatashirt['height']; ?>" <?php  }else{  ?> value = ""  <?php } ?>  >
                                                                 </div>
                                                                 <div class="three columns left">
                                                                    <label>Weight </label>
                                                                    <input type="text" name="data[UserSizeInformation][custom_shirt_measurement][weight]" <?php  if(isset($customdatashirt['weight'])!=''){ ?> value="<?php echo $customdatashirt['weight']; ?>" <?php  }else{  ?> value = ""  <?php } ?>  >
                                                                 </div>
                                                                 <div class="three columns left cstm-msrmnt-center">
                                                                    <label>Posture </label>
                                                                     <input type="text" name="data[UserSizeInformation][custom_shirt_measurement][posture]" <?php  if(isset($customdatashirt['posture'])!=''){ ?> value="<?php echo $customdatashirt['posture']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                 </div>
                                                                 <div class="three columns left ">
                                                                    <label>Shoulder Line  </label>
                                                                    <input type="text" name="data[UserSizeInformation][custom_shirt_measurement][shoulder_line]" <?php  if(isset($customdatashirt['shoulder_line'])!=''){ ?> value="<?php echo $customdatashirt['shoulder_line']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                 </div>
                                                            </div>
                                                            <div class="twelve columns left">
                                                                <div class="three columns left msrmnt-label"><label>Custom  Measurement Comments</label></div>
                                                                <div class="nine columns left msrmnt-input-area"><textarea name="data[UserSizeInformation][custom_measurement_comments]"> <?php  if(isset($customdata[0]['UserSizeInformation']['custom_measurement_comments'])!=''){  echo $customdata[0]['UserSizeInformation']['custom_measurement_comments'];  }else{   } ?>  </textarea></div>
                                                            </div>
                                                        </div>
                                                            
                                                        <div id="12">
                                                            <div class="twelve columns left">
                                                                <div class="three columns left">
                                                                    <label>Chest</label>
                                                                     <input type="text" name="data[UserSizeInformation][custom_jacket_measurement][chest]" <?php  if(isset($customdatajacket['chest'])!=''){ ?> value="<?php echo $customdatajacket['chest']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                <div class="three columns left cstm-msrmnt-center">
                                                                    <label>Over Arm Chest </label>
                                                                    <input type="text" name="data[UserSizeInformation][custom_jacket_measurement][over_arm_chest]" <?php  if(isset($customdatajacket['over_arm_chest'])!=''){ ?> value="<?php echo $customdatajacket['over_arm_chest']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                <div class="three columns left">
                                                                    <label> Coat Waist </label>
                                                                   <input type="text" name="data[UserSizeInformation][custom_jacket_measurement][coat_waist]" <?php  if(isset($customdatajacket['coat_waist'])!=''){ ?> value="<?php echo $customdatajacket['coat_waist']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                            </div>
                                                            <div class="twelve columns left">
                                                                <div class="three columns left">
                                                                    <label> Seat </label>
                                                                   <input type="text" name="data[UserSizeInformation][custom_jacket_measurement][seat]" <?php  if(isset($customdatajacket['seat'])!=''){ ?> value="<?php echo $customdatajacket['seat']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                <div class="three columns left cstm-msrmnt-center">
                                                                    <label>½ Girth </label>
                                                                    <input type="text" name="data[UserSizeInformation][custom_jacket_measurement][half_girth]" <?php  if(isset($customdatajacket['half_girth'])!=''){ ?> value="<?php echo $customdatajacket['half_girth']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                <div class="three columns left">
                                                                    <label>Coat Length </label>
                                                                    <input type="text" name="data[UserSizeInformation][custom_jacket_measurement][coat_length]" <?php  if(isset($customdatajacket['coat_length'])!=''){ ?> value="<?php echo $customdatajacket['coat_length']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                            </div>
                                                            <div class="twelve columns left">
                                                                <div class="three columns left">
                                                                    <label>Sleeve Inseam R</label>
                                                                    <input type="text" name="data[UserSizeInformation][custom_jacket_measurement][sleeve_inseam_r]" <?php  if(isset($customdatajacket['sleeve_inseam_r'])!=''){ ?> value="<?php echo $customdatajacket['sleeve_inseam_r']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                <div class="three columns left cstm-msrmnt-center">
                                                                    <label>Sleeve Inseam L</label>
                                                                    <input type="text" name="data[UserSizeInformation][custom_jacket_measurement][sleeve_inseam_l]" <?php  if(isset($customdatajacket['sleeve_inseam_l'])!=''){ ?> value="<?php echo $customdatajacket['sleeve_inseam_l']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                <div class="three columns left">
                                                                    <label>½ Back </label>
                                                                     <input type="text" name="data[UserSizeInformation][custom_jacket_measurement][half_back]" <?php  if(isset($customdatajacket['half_back'])!=''){ ?> value="<?php echo $customdatajacket['half_back']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                            </div>
                                                            <div class="twelve columns left">
                                                                <div class="three columns left">
                                                                    <label>Point to Point </label>
                                                                     <input type="text" name="data[UserSizeInformation][custom_jacket_measurement][point_to_point]" <?php  if(isset($customdatajacket['point_to_point'])!=''){ ?> value="<?php echo $customdatajacket['point_to_point']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                <div class="three columns left cstm-msrmnt-center">
                                                                    <label>Actual Skin Bicep </label>
                                                                    <input type="text" name="data[UserSizeInformation][custom_jacket_measurement][actual_skin_bicep]" <?php  if(isset($customdatajacket['actual_skin_bicep'])!=''){ ?> value="<?php echo $customdatajacket['actual_skin_bicep']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                <div class="three columns left">
                                                                    <label>Chest Fullness</label>
                                                                     <input type="text" name="data[UserSizeInformation][custom_jacket_measurement][chest_fullness]" <?php  if(isset($customdatajacket['chest_fullness'])!=''){ ?> value="<?php echo $customdatajacket['chest_fullness']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                <div class="three columns left">
                                                                    <label>Shoulder Measurement R </label>
                                                                     <input type="text" name="data[UserSizeInformation][custom_jacket_measurement][shoulder_measurement_r]" <?php  if(isset($customdatajacket['shoulder_measurement_r'])!=''){ ?> value="<?php echo $customdatajacket['shoulder_measurement_r']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                <div class="three columns left cstm-msrmnt-center">
                                                                    <label>Shoulder Measurement L </label>
                                                                     <input type="text" name="data[UserSizeInformation][custom_jacket_measurement][shoulder_measurement_l]" <?php  if(isset($customdatajacket['shoulder_measurement_l'])!=''){ ?> value="<?php echo $customdatajacket['shoulder_measurement_l']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                <div class="three columns left">
                                                                    <label>Posture </label>
                                                                     <input type="text" name="data[UserSizeInformation][custom_jacket_measurement][posture]" <?php  if(isset($customdatajacket['posture'])!=''){ ?> value="<?php echo $customdatajacket['posture']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                

                                                            </div>
                                                            
                                                        </div>
                                                        <div id="13">
                                                            <div class="twelve columns left">
                                                                <div class="three columns left">
                                                                    <label>Pant Waist </label>
                                                                     <input type="text" name="data[UserSizeInformation][custom_trouser_measurement][pant_waist]" <?php  if(isset($customdatatrouser['pant_waist'])!=''){ ?> value="<?php echo $customdatatrouser['pant_waist']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                <div class="three columns left cstm-msrmnt-center">
                                                                    <label>Abdomen </label>
                                                                    <input type="text" name="data[UserSizeInformation][custom_trouser_measurement][abdomen]" <?php  if(isset($customdatatrouser['abdomen'])!=''){ ?> value="<?php echo $customdatatrouser['abdomen']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                <div class="three columns left">
                                                                    <label>Outseam</label>
                                                                     <input type="text" name="data[UserSizeInformation][custom_trouser_measurement][outseam]" <?php  if(isset($customdatatrouser['outseam'])!=''){ ?> value="<?php echo $customdatatrouser['outseam']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                            </div>
                                                            <div class="twelve columns left">
                                                                <div class="three columns left">
                                                                    <label>Inseam </label>
                                                                    <input type="text" name="data[UserSizeInformation][custom_trouser_measurement][inseam]" <?php  if(isset($customdatatrouser['inseam'])!=''){ ?> value="<?php echo $customdatatrouser['inseam']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                <div class="three columns left cstm-msrmnt-center">
                                                                    <label>Knee</label>
                                                                     <input type="text" name="data[UserSizeInformation][custom_trouser_measurement][knee]" <?php  if(isset($customdatatrouser['knee'])!=''){ ?> value="<?php echo $customdatatrouser['knee']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                <div class="three columns left">
                                                                    <label>Actual Skin Thigh </label>
                                                                     <input type="text" name="data[UserSizeInformation][custom_trouser_measurement][actual_skin_thigh]" <?php  if(isset($customdatatrouser['actual_skin_thigh'])!=''){ ?> value="<?php echo $customdatatrouser['actual_skin_thigh']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                            </div>
                                                            <div class="twelve columns left">
                                                                <div class="three columns left">
                                                                    <label>Front to Floor </label>
                                                                    <input type="text" name="data[UserSizeInformation][custom_trouser_measurement][front_to_floor]" <?php  if(isset($customdatatrouser['front_to_floor'])!=''){ ?> value="<?php echo $customdatatrouser['front_to_floor']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                <div class="three columns left cstm-msrmnt-center">
                                                                    <label>Back to Floor </label>
                                                                    <input type="text" name="data[UserSizeInformation][custom_trouser_measurement][back_to_floor]" <?php  if(isset($customdatatrouser['back_to_floor'])!=''){ ?> value="<?php echo $customdatatrouser['back_to_floor']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                <div class="three columns left">
                                                                    <label>Rise</label>
                                                                     <input type="text" name="data[UserSizeInformation][custom_trouser_measurement][rise]" <?php  if(isset($customdatatrouser['rise'])!=''){ ?> value="<?php echo $customdatatrouser['rise']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                            </div>
                                                            <div class="twelve columns left">
                                                                <div class="three columns left">
                                                                    <label>Bottom</label>
                                                                     <input type="text" name="data[UserSizeInformation][custom_trouser_measurement][bottom]" <?php  if(isset($customdatatrouser['bottom'])!=''){ ?> value="<?php echo $customdatatrouser['bottom']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                
                                                                
                                                            </div>
                                                           
                                                        </div>
                                                            
                                                        <div id="14">
                                                            <div class="twelve columns left">
                                                                <div class="three columns left">
                                                                    <label>Opening From Center Back </label>
                                                                    <input type="text" name="data[UserSizeInformation][custom_vest_measurement][opening_from_center_back]" <?php  if(isset($customdatavest['opening_from_center_back'])!=''){ ?> value="<?php echo $customdatavest['opening_from_center_back']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                <div class="three columns left cstm-msrmnt-center">
                                                                    <label>Vest Front Length From Center Back </label>
                                                                    <input type="text" name="data[UserSizeInformation][custom_vest_measurement][vest_front_length_from_center_back]" <?php  if(isset($customdatavest['vest_front_length_from_center_back'])!=''){ ?> value="<?php echo $customdatavest['vest_front_length_from_center_back']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                                <div class="three columns left">
                                                                    <label> Vest Back Length From Center Back </label>
                                                                   <input type="text" name="data[UserSizeInformation][custom_vest_measurement][vest_back_length_from_center_back]" <?php  if(isset($customdatavest['vest_back_length_from_center_back'])!=''){ ?> value="<?php echo $customdatavest['vest_back_length_from_center_back']; ?>" <?php  }else{  ?> value = ""  <?php } ?> >
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                           
                                                            
                                                        </div>
                                                       

                                                    </div>
                                                
                                                </div>

                                            </div>

                                        </div>

                                    <div class="text-center about-submit">
                                    <div class="submit">                            
                                    <?php echo $this->Form->end(__('Submit')); ?>
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