<?php
$meta_description = 'As an SRS Man, great things are expected of you. But let us take care of the details. <br/> We\'ll perfect your image from head to toe.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>

<div class="content-container stylist-biography-section">
    <div class="eleven columns container content inner stylistbio">
        <div class="twelve columns container stylistbio-section left">
            <a class="open-left-pannel" href="#" title=""><img src="<?php echo $this->webroot; ?>images/arrow-next.png" alt="" /></a>
            <div class="stylistbio-section-left text-center">
                <div class=" twelve columns stylistbion-arrow"><img src="<?php echo $this->webroot; ?>images/back-arrow.png" alt="" /></div>
                <div class="twelve columns">
                    <div class="eleven columns container stylistbio-short-note">
                        <div class="short-note">Learn more about all the Savile Row Stylists by scrolling through our list of current stylists</div>
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
                        <?php foreach ($stylists as  $stylist): ?>
                            <li><a href="<?php echo $this->webroot; ?>stylists/stylistbiography/<?php echo $stylist['User']['id']; ?>">
                                <div class="left stylistbio-list-img">
                                <?php if($stylist['User']['profile_photo_url']): ?>
                                    <img src="<?php echo $this->webroot; ?>files/users/<?php echo $stylist['User']['profile_photo_url'] ?>" alt="" /></div>
                                <?php else: ?>
                                    <img src="<?php echo $this->webroot; ?>images/default-user.jpg" alt="" /></div>    
                                <?php endif; ?>
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
                                <?php if($users['User']['profile_photo_url']): ?>
                                   <img src="<?php echo $this->webroot; ?>files/users/<?php echo $users['User']['profile_photo_url']; ?>" alt="" />
                                <?php else: ?>
                                    <img src="<?php echo $this->webroot; ?>images/default-user.jpg" alt="" />   
                                <?php endif; ?>
                            </div>
                            <div class=" twelve columns social-networks">
                                <ul>
                                <?php 
                                if(isset($StylistBioData[0]['StylistBio'])){
                                    $social = json_decode($StylistBioData[0]['StylistBio']['stylist_social_link'],true);     
                                }
                                else{
                                    $social = array();
                                }
                                ?>
                                    <li class="pintrest"><a href="<?php echo isset($social['pinterest']) ? $social['pinterest'] : '#'; ?>" target="blank" title="">Printrest</a></li>
                                    <li class="twitter"><a href="<?php echo isset($social['twitter']) ? $social['twitter'] : '#'; ?>" target="blank" title="">Twitter</a></li>
                                    <li class="linkdin"><a href="<?php echo isset($social['linkdin']) ? $social['linkdin'] : '#'; ?>" target="blank" title="">Linkdin</a></li>
                                    <li class="facebbok"><a href="<?php echo isset($social['facebook']) ? $social['facebook'] : '#'; ?>" target="blank" title="">facebook</a></li>
                                <?php  //} ?>
                                </ul>
                            </div>
                            <h1 class="stylistbio-heading"><?php echo $users['User']['first_name']; ?>’s Bio</h1>
                            <div class="user-desc">
                                <?php if($StylistBioData): 
                                    echo $StylistBioData[0]['StylistBio']['stylist_bio'];
                                    else:
                                    endif;
                                ?>
                            </div>
                            <h1 class="stylistbio-heading"><?php echo $users['User']['first_name']; ?>’s Inspiration</h1>
                            <div class="user-inspire-desc">
                                <?php if($StylistBioData): 
                                    echo $StylistBioData[0]['StylistBio']['stylist_inspiration'];
                                    else:
                                    endif;
                                ?>
                            </div>
                        </div>
                        <div class="stylistbio-details right">
                            <div class="twelve columns left">
                                <div class="stylistbio-user"><?php echo $users['User']['first_name'].'&nbsp;'.$users['User']['last_name']; ?> | Stylist</div>
                                
                                <?php if(!$is_logged): ?>
                                    <div class="start-today"><a href="/users/register?refer=<?php echo $users['User']['id']; ?>">get started with <?php echo $users['User']['first_name']; ?> Today!</a></div>
                                <?php endif; ?>
                            </div>
                            <div class="twelve columns left detials-section">
                                <div class="twelve columns details">
                                    <div class="home-town"><span class="style-upper">Hometown:</span> <span class="style-italic">
                                     <?php if($StylistBioData): echo $StylistBioData[0]['StylistBio']['hometown']; else: endif; ?>
                                    </span></div>
                                    <div class="fun-fact"><span class="style-upper">Fun Fact:</span> <span class="style-italic">
                                        <?php if($StylistBioData): echo $StylistBioData[0]['StylistBio']['funfact']; else: endif; ?>
                                    </span></div>
                                    <div class="fashion-tips"><span class="style-upper">Number 1 Fashion Tip:</span> <span class="style-italic"><?php if($StylistBioData): echo $StylistBioData[0]['StylistBio']['fashion_tip']; else: endif; ?></span></div>
                                </div>
                                <div class="twelve columns left user-photostream">
                                    <h1 class="stylistbio-heading photostream"><?php echo $users['User']['first_name']; ?>’s Photostream</h1>
                                    <div class="photostream-section">
                                        <ul id="itemContainer">
                                            <?php
                                            //print_r($photostreampicsstylist);
                                             foreach($photostreampicsstylist as $photostreampicss ): ?>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>files/photostream/<?php echo $photostreampicss['StylistPhotostream']['image']; ?>" data-fancybox-group="gallery" title="<?php echo $photostreampicss['StylistPhotostream']['caption']; ?>">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>files/photostream/<?php echo $photostreampicss['StylistPhotostream']['image']; ?>" alt="" data-photoid = "<?php echo $photostreampicss['StylistPhotostream']['id']; ?>" />
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                            </ul>
                                        <?php if(count($photostreampicsstylist)): ?>
                                            <div class="holder"></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="twelve columns left user-top-outfit">
                                    <h1 class="stylistbio-heading photostream top-outits-heading"><?php echo $users['User']['first_name']; ?>’s Top Outfits</h1>
                                    <ul>
                                    <?php foreach($my_outfit as $my_outfit): ?>
                                        <li>
                                            <div class="twelve columns top-outfits">
                                                <div class="eleven columns container">
                                                    <h2><?php if($my_outfit['outfit']): echo ucfirst($my_outfit['outfit'][0]['Outfit']['outfit_name']); else: endif;
                                                    ?></h2>
                                                    <input type="hidden" class="outfit_id" value="<?php echo $my_outfit['outfit'][0]['Outfit']['id']; ?>">
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
                                <div class="stylistbio-user">Like <?php echo $users['User']['first_name']; ?>’s Style?</div>
                                <?php if(!$is_logged): ?>
                                    <div class="start-today"><a href="/users/register?refer=<?php echo $users['User']['id']; ?>">get started with <?php echo $users['User']['first_name']; ?> Today!</a></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
    
    <div class="stylistbio-section-left text-center m-ver">
                        <div class=" twelve columns stylistbion-arrow"><img src="<?php echo $this->webroot; ?>images/back-arrow.png" alt="" /></div>
                        <div class="twelve columns">
                            <div class="eleven columns container stylistbio-short-note">
                                <div class="short-note">Learn more about all the Savile Row Stylists by clicking through our list of current stylists. </div>
                            </div>
                        </div>
                         <div class="twelve columns">
                            <div class="eleven columns container stylistbio-list">
                                <h3>SRS Stylist List</h3>
                                <div id="scrollbar8">
                                    <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
                    <div class="viewport">
                         <div class="overview">
                                <ul>
                                <?php foreach ($stylists as  $stylist): ?>
                                    <li><a href="<?php echo $this->webroot; ?>stylists/stylistbiography/<?php echo $stylist['User']['id']; ?>">
                                        <div class="left stylistbio-list-img">
                                        <?php if($stylist['User']['profile_photo_url']): ?>
                                            <img src="<?php echo $this->webroot; ?>files/users/<?php echo $stylist['User']['profile_photo_url'] ?>" alt="" /></div>
                                        <?php else: ?>
                                            <img src="<?php echo $this->webroot; ?>images/default-user.jpg" alt="" /></div>    
                                        <?php endif; ?>
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
    </div>
</div>

<script>
    $(function(){
        $(".outfit-products").on('click', function(e){
            e.preventDefault();
            var outfitBlock = $(this).closest('.top-outfits');
            var outfitId = outfitBlock.find('.outfit_id').val();

            location = '/guest/outfitdetails/' + outfitId;
        });
    });
</script>