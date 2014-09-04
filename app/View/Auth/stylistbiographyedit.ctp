<?php
$meta_description = 'As an SRS Man, great things are expected of you. But let us take care of the details. <br/> We\'ll perfect your image from head to toe.';
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
                        <?php foreach ($stylists as  $stylist): ?>
                            <li><a href="<?php echo $this->webroot; ?>Auth/stylistbiography/<?php echo $stylist['User']['id']; ?>">
                                <div class="left stylistbio-list-img"><img src="<?php echo $this->webroot; ?>files/photostream/<?php echo $stylist['Stylistphotostream']['image'] ?>" width='31' height='31' alt="" /></div>
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
                            <div class="profile-img"><img src="<?php echo $this->webroot; ?>images/stylistbio/profile-img.jpg" width='277' height='' alt="" /></div>
                            <div class=" twelve columns social-networks">
                                <ul>
                                <?php $social = json_decode($find_array[0]['Stylistbio']['stylist_social_link'],true); ?>
                                    <li class="pintrest"><a href="<?php echo $social['pinterest']; ?>" target="blank" title="">Printrest</a></li>
                                    <li class="twitter"><a href="<?php echo $social['twiter']; ?>" target="blank" title="">Twitter</a></li>
                                    <li class="linkdin"><a href="<?php echo $social['linkdin']; ?>" target="blank" title="">Linkdin</a></li>
                                    <li class="facebbok"><a href="<?php echo $social['facebook']; ?>" target="blank" title="">facebook</a></li>
                                </ul>
                            </div>
                            <h1 class="stylistbio-heading"><?php echo $find_array[0]['User']['first_name']; ?>’s Bio <span class="edit-section-stylistbio-heading"><img src="<?php echo $this->webroot; ?>images/edit-icon.png" /></span></h1>
                            
                                        <form class="stylistbio-heading-edit" method="post" action="" name="edithometown">
                                            <label>Your Fun Fact</label>
                                            <div class="edit-content">
                                                <input type="text" placeholder="Edit your Fun Fact" name="hometown">
                                            </div>
                                            <p class="actions">
                                            <input class="edit-save-btn primry-btn" type="submit" value="Save">
                                            <button class="cancel-btn secondry-btn" type="button">Cancel</button>
                                            </p>
                                        </form>
                            <div class="user-desc">
                                <?php echo $find_array[0]['Stylistbio']['stylist_bio']; ?>
                            </div>
                            <h1 class="stylistbio-heading"><?php echo $find_array[0]['User']['first_name']; ?>’s Inspiration</h1>
                            <div class="user-inspire-desc"> <?php echo $find_array[0]['Stylistbio']['stylist_inspiration']; ?></div>
                        </div>
                        <div class="stylistbio-details right">
                            <div class="twelve columns left">
                                <div class="stylistbio-user"><?php echo $find_array[0]['User']['first_name'].'&nbsp;'.$find_array[0]['User']['last_name']; ?> | Stylist</div>
                                <div class="start-today"><a href="javascript:;">get started with <?php echo $find_array[0]['User']['first_name']; ?> Today!</a></div>
                            </div>
                            <div class="twelve columns left detials-section">
                                <div class="twelve columns details">
                                    <div class="home-town">
                                        <span class="style-upper">Hometown:</span> <span class="style-italic">San Diego, California</span><span class="edit-section home-edit-section"><img src="<?php echo $this->webroot; ?>images/edit-icon.png" /></span>
                                        <form class="home-edit" method="post" action="" name="edithometown">
                                            <label>Your Home Town</label>
                                            <div class="edit-content">
                                                <input type="text" placeholder="Edit your Home Town" name="hometown">
                                            </div>
                                            <p class="actions">
                                            <input class="edit-save-btn primry-btn" type="submit" value="Save">
                                            <button class="cancel-btn secondry-btn" type="button">Cancel</button>
                                            </p>
                                        </form>
                                    </div>
                                    <div class="fun-fact"><span class="style-upper">Fun Fact:</span> 
                                        <span class="style-italic">I can drink a 6 pack in 2 minutes</span>
                                        <span class="edit-section fun-edit-section"><img src="<?php echo $this->webroot; ?>images/edit-icon.png" /></span>
                                        <form class="fun-edit" method="post" action="" name="edithometown">
                                            <label>Your Fun Fact</label>
                                            <div class="edit-content">
                                                <input type="text" placeholder="Edit your Fun Fact" name="hometown">
                                            </div>
                                            <p class="actions">
                                            <input class="edit-save-btn primry-btn" type="submit" value="Save">
                                            <button class="cancel-btn secondry-btn" type="button">Cancel</button>
                                            </p>
                                        </form>
                                    </div>
                                    <div class="fashion-tips">
                                        <span class="style-upper">Number 1 Fashion Tip:</span> <span class="style-italic">Men- get your suits fitted correctly;<br>Women- the more leopard the better.</span>
                                        <span class="edit-section tip-edit-section"><img src="<?php echo $this->webroot; ?>images/edit-icon.png" /></span>
                                        <form class="tip-edit" method="post" action="" name="edithometown">
                                            <label>Your Fashion Tip</label>
                                            <div class="edit-content">
                                                <input type="text" placeholder="Edit your Fashion Tip" name="hometown">
                                            </div>
                                            <p class="actions">
                                            <input class="edit-save-btn primry-btn" type="submit" value="Save">
                                            <button class="cancel-btn secondry-btn" type="button">Cancel</button>
                                            </p>
                                        </form>
                                    </div>
                                </div>
                                <div class="twelve columns left user-photostream">
                                    <h1 class="stylistbio-heading photostream"><?php echo $find_array[0]['User']['first_name']; ?>’s Photostream</h1>
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
                                    <h1 class="stylistbio-heading photostream top-outits-heading"><?php echo $find_array[0]['User']['first_name']; ?>’s Top Outfits</h1>
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
                                                            <img src="<?php echo $this->webroot; ?>files/products/<?php echo $entities['Image'][0]['name']; ?>" height="108" width="122" />
                                                            <div class="outfit-products-details"><?php echo $entities['Entity']['name'] ?>  $<?php echo $entities['Entity']['price']; ?></div>
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
                                <div class="stylistbio-user">Like <?php echo $find_array[0]['User']['first_name']; ?>’s Style?</div>
                                <div class="start-today"><a href="javascript:;">get started with <?php echo $find_array[0]['User']['first_name']; ?> Today!</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
        </div>
        
    </div>
</div>
