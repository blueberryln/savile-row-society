<?php
$meta_description = 'Meet the premier personal stylists at Savile Row Society who will transform your wardrobe';
$meta_keywords = 'Savile Row Society, Personal stylist, personal shopping';
$this->Html->meta("keywords", $meta_keywords, array("inline" => false));
$this->Html->meta('description', $meta_description, array('inline' => false));
?>
<div class="content-container">
    <div class="eleven columns container content inner stylistbio">
        <div class="twelve columns container stylistbio-section left">
            <a class="open-left-pannel" href="#" title=""><img src="<?php echo $this->webroot; ?>images/arrow-next.png" alt="" /></a>
            <div class="stylistbio-section-left text-center">
                <div class=" twelve columns stylistbion-arrow"><img src="<?php echo $this->webroot; ?>images/back-arrow.png" alt="" /></div>
                <div class="twelve columns">
                    <div class="eleven columns container stylistbio-short-note">
                        <div class="short-note">Learn more about all the Savile Row Stylists by clicking through our list of current stylists. </div>
                    </div>
                </div>
                 <div class="twelve columns">
                    <div class="eleven columns container stylistbio-list">
                        <h3>SRS Stylist List</h3>
                        <div id="scrollbar1">
                            <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
            <div class="viewport">
                 <div class="overview">
                        <ul>
                        <?php foreach ($stylistlist as  $stylist): ?>
                            <li><a href="<?php echo $this->webroot; ?>users/stylistbiography/<?php echo $stylist['User']['id']; ?>">
                                <div class="left stylistbio-list-img">
                                    <?php
                                    if($stylist['User']['profile_photo_url']){
                                        echo "<img src='" . $this->webroot . "files/users/" . $stylist['User']['profile_photo_url'] . "' alt='' />";
                                    }
                                    else{
                                        echo "<img src='" . $this->webroot . "images/default-user.jpg' alt='' />";
                                    }
                                    ?>
                                </div>
                                <div class="left stylistbio-list-name"><?php echo $stylist['User']['first_name'].'&nbsp;'.$stylist['User']['last_name'] ?></div></a>
                            </li>
                            <?php endforeach; ?>
                            
                        </ul>
                     </div>
                </div>
                            </div>
                       
                    </div>
                </div>
                
            </div>
            <div class="stylistbio-section-right">
                <div class="eleven columns container">
                    <div class="twelve columns">
                        <div class="stylistbio-profile left text-center">
                            <div class="profile-img">
                                <?php
                                if($user_profile_photo){
                                    echo "<img src='" . $this->webroot . "files/users/" . $user_profile_photo ."' alt='' />";
                                }
                                else{
                                    echo "<img src='" . $this->webroot . "images/default-user.jpg' alt='' />";
                                }
                                ?>
                            </div>
                            <div class=" twelve columns social-networks">
                                <ul>
                                <?php  $social = json_decode(isset($find_array[0]['Stylistbio']['stylist_social_link']),true); 
                                //print_r($social);
                                
                                ?>
                                    <li class="pintrest"><a href="<?php echo $social['pintrest']; ?>" target="blank" title="">Printrest</a></li>
                                    <li class="twitter"><a href="<?php echo $social['twiter']; ?>" target="blank" title="">Twitter</a></li>
                                    <li class="linkdin"><a href="<?php echo $social['linkdin']; ?>" target="blank" title="">Linkdin</a></li>
                                    <li class="facebbok"><a href="<?php echo $social['facebook']; ?>" target="blank" title="">facebook</a></li>
                                <?php  //} ?>
                                </ul>
                            </div>
                            <h1 class="stylistbio-heading"><?php echo $user_first_name; ?>’s Bio</h1>
                            <div class="user-desc">
                                <?php if(isset($find_array[0]['Stylistbio'])!='') {  echo $find_array[0]['Stylistbio']['stylist_bio']; }else{} ?>
                            </div>
                            <h1 class="stylistbio-heading"><?php echo $user_first_name; ?>’s Inspiration</h1>
                            <div class="user-inspire-desc"> <?php if(isset($find_array[0]['Stylistbio'])!='') { echo $find_array[0]['Stylistbio']['stylist_inspiration']; }else{} ?></div>
                        </div>
                        <div class="stylistbio-details right">
                            <div class="twelve columns left">
                                <div class="stylistbio-user"><?php echo $user_first_name.'&nbsp;'.$user_last_name; ?> | Stylist</div>
                                <div class="start-today"><a href="javascript:;">get started with <?php echo $user_first_name; ?> Today!</a></div>
                            </div>
                            <div class="twelve columns left detials-section">
                                <div class="twelve columns details">
                                    <div class="home-town"><span class="style-upper">Hometown:</span> <span class="style-italic"><?php if(isset($find_array[0]['Stylistbio']['hometown'])!='') {  echo $find_array[0]['Stylistbio']['hometown']; }else{} ?></span></div>
                                    <div class="fun-fact"><span class="style-upper">Fun Fact:</span> <span class="style-italic"><?php if(isset($find_array[0]['Stylistbio']['funfect'])!='') {  echo $find_array[0]['Stylistbio']['funfect']; }else{} ?></span></div>
                                    <div class="fashion-tips"><span class="style-upper">Number 1 Fashion Tip:</span> <span class="style-italic"><?php if(isset($find_array[0]['Stylistbio']['fashiontip'])!='') {  echo $find_array[0]['Stylistbio']['fashiontip']; }else{} ?></span></div>
                                </div>
                                <div class="twelve columns left user-photostream">
                                    <h1 class="stylistbio-heading photostream"><?php echo $user_first_name; ?>’s Photostream</h1>
                                    <div class="photostream-section">
                                        <ul id="itemContainer">
                                            <?php  foreach ($stylistphoto as $stylistphoto): ?>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>files/photostream/<?php echo $stylistphoto['Stylistphotostream']['image']; ?>" data-fancybox-group="gallery" title="<?php echo $stylistphoto['Stylistphotostream']['caption']; ?>">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>files/photostream/<?php echo $stylistphoto['Stylistphotostream']['image']; ?>" alt="" />
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                            </li>
                                            </ul>
                                        <div class="holder"></div>
                                    </div>
                                </div>
                                <div class="twelve columns left user-top-outfit">
                                    <h1 class="stylistbio-heading photostream top-outits-heading"><?php echo $user_first_name; ?>’s Top Outfits</h1>
                                    <ul>
                                    <?php foreach($my_outfit as $my_outfit): ?>
                                        <li>
                                            <div class="twelve columns top-outfits">
                                                <div class="eleven columns container">
                                                    <h2><?php echo $my_outfit['outfit']['Outfit']['outfitname']; ?></h2>
                                                    <div class="outfit-products">
                                                        <ul>
                                                            <?php foreach($my_outfit['entities'] as $entities): ?>
                                                                <li>
                                                            <img src="<?php echo $this->webroot; ?>files/products/<?php if(isset($entities['Image'][0])!='') {  echo $entities['Image'][0]['name']; }else{} ?>" />
                                                            <div class="outfit-products-details"><?php if(isset($entities['Entity'])!=''){ echo $entities['Entity']['name']; }else{} ?>  $<?php if(isset($entities['Entity'])!=''){ echo $entities['Entity']['price']; }else{} ?></div>
                                                        </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                        
                                        
                                    </ul>
                                </div>
                            </div>
                            <div class="twelve columns left bottom-section">
                                <div class="stylistbio-user">Like <?php echo $user_first_name; ?>’s Style?</div>
                                <div class="start-today"><a href="javascript:;">get started with <?php echo $user_first_name; ?> Today!</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
        </div>
        
    </div>
</div>