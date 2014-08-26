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
                            <!-- <li>
                                <div class="left stylistbio-list-img"><img src="<?php echo $this->webroot; ?>images/stylistbio/small-img.jpg" alt="" /></div>
                                <div class="left stylistbio-list-name">Jane Doe</div>
                            </li>
                            <li>
                                <div class="left stylistbio-list-img"><img src="<?php echo $this->webroot; ?>images/stylistbio/small-img.jpg" alt="" /></div>
                                <div class="left stylistbio-list-name">Jane Doe</div>
                            </li>
                            <li>
                                <div class="left stylistbio-list-img"><img src="<?php echo $this->webroot; ?>images/stylistbio/small-img.jpg" alt="" /></div>
                                <div class="left stylistbio-list-name">Jane Doe</div>
                            </li>
                            <li>
                                <div class="left stylistbio-list-img"><img src="<?php echo $this->webroot; ?>images/stylistbio/small-img.jpg" alt="" /></div>
                                <div class="left stylistbio-list-name">Jane Doe</div>
                            </li>
                            <li>
                                <div class="left stylistbio-list-img"><img src="<?php echo $this->webroot; ?>images/stylistbio/small-img.jpg" alt="" /></div>
                                <div class="left stylistbio-list-name">Jane Doe</div>
                            </li>
                            <li>
                                <div class="left stylistbio-list-img"><img src="<?php echo $this->webroot; ?>images/stylistbio/small-img.jpg" alt="" /></div>
                                <div class="left stylistbio-list-name">Jane Doe</div>
                            </li>
                            <li>
                                <div class="left stylistbio-list-img"><img src="<?php echo $this->webroot; ?>images/stylistbio/small-img.jpg" alt="" /></div>
                                <div class="left stylistbio-list-name">Jane Doe</div>
                            </li>
                            <li>
                                <div class="left stylistbio-list-img"><img src="<?php echo $this->webroot; ?>images/stylistbio/small-img.jpg" alt="" /></div>
                                <div class="left stylistbio-list-name">Jane Doe</div>
                            </li>
                            <li>
                                <div class="left stylistbio-list-img"><img src="<?php echo $this->webroot; ?>images/stylistbio/small-img.jpg" alt="" /></div>
                                <div class="left stylistbio-list-name">Jane Doe</div>
                            </li>
                            <li>
                                <div class="left stylistbio-list-img"><img src="<?php echo $this->webroot; ?>images/stylistbio/small-img.jpg" alt="" /></div>
                                <div class="left stylistbio-list-name">Jane Doe</div>
                            </li>
                            <li>
                                <div class="left stylistbio-list-img"><img src="<?php echo $this->webroot; ?>images/stylistbio/small-img.jpg" alt="" /></div>
                                <div class="left stylistbio-list-name">Jane Doe</div>
                            </li>
                            <li>
                                <div class="left stylistbio-list-img"><img src="<?php echo $this->webroot; ?>images/stylistbio/small-img.jpg" alt="" /></div>
                                <div class="left stylistbio-list-name">Jane Doe</div>
                            </li>
                            <li>
                                <div class="left stylistbio-list-img"><img src="<?php echo $this->webroot; ?>images/stylistbio/small-img.jpg" alt="" /></div>
                                <div class="left stylistbio-list-name">Jane Doe</div>
                            </li>
                            <li>
                                <div class="left stylistbio-list-img"><img src="<?php echo $this->webroot; ?>images/stylistbio/small-img.jpg" alt="" /></div>
                                <div class="left stylistbio-list-name">Jane Doe</div>
                            </li> -->
                            
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
                            <div class="profile-img"><img src="<?php echo $this->webroot; ?>files/photostream/<?php echo $find_array[0]['Stylistphotostream']['image']; ?>" width='277' height='309' alt="" /></div>
                            <div class=" twelve columns social-networks">
                                <?php //print_r($find_array); ?>
                                <ul>
                                <?php $social = json_decode($find_array[0]['Stylistbio']['stylist_social_link'],true); ?>
                                    <li class="printrest"><a href="<?php echo $social['pintrest']; ?>" target="blank" title="">Printrest</a></li>
                                    <li class="twitter"><a href="<?php echo $social['twiter']; ?>" target="blank" title="">Twitter</a></li>
                                    <li class="linkdin"><a href="<?php echo $social['linkdin']; ?>" target="blank" title="">Linkdin</a></li>
                                    <li class="facebbok"><a href="<?php echo $social['facebook']; ?>" target="blank" title="">facebook</a></li>
                                </ul>
                            </div>
                            <h1 class="stylistbio-heading"><?php echo $find_array[0]['User']['first_name']; ?>’s Bio</h1>
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
                                    <div class="home-town"><span class="style-upper">Hometown:</span> <span class="style-italic" \\><?php echo $find_array[0]['Stylistbio']['hometown']; ?></span></div>
                                    <div class="fun-fact"><span class="style-upper">Fun Fact:</span> <span class="style-italic"><?php echo $find_array[0]['Stylistbio']['funfect']; ?></span></div>
                                    <div class="fashion-tips"><span class="style-upper">Number 1 Fashion Tip:</span> <span class="style-italic"><?php echo $find_array[0]['Stylistbio']['fashiontip']; ?></span></div>
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
                                            <!-- 
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_1.jpg" data-fancybox-group="gallery" title="img-1">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_1.jpg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_2.jpg" data-fancybox-group="gallery" title="img-2">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_2.jpg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_3.jpg" data-fancybox-group="gallery" title="img-3">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_3.jpg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_4.jpg" data-fancybox-group="gallery" title="img-4">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_4.jpg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_5.jpg" data-fancybox-group="gallery" title="img-5">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_5.jpg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_6.jpg" data-fancybox-group="gallery" title="img-6">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_6.jpg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_7.jpg" data-fancybox-group="gallery" title="img-7">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_7.jpg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_8.jpg" data-fancybox-group="gallery" title="img-8">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_8.jpg" alt="" />
                                                </a>
                                            </li>
                                            

                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_2.jpg" data-fancybox-group="gallery" title="img-2">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_2.jpg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_3.jpg" data-fancybox-group="gallery" title="img-3">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_3.jpg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_4.jpg" data-fancybox-group="gallery" title="img-4">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_4.jpg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_5.jpg" data-fancybox-group="gallery" title="img-5">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_5.jpg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_6.jpg" data-fancybox-group="gallery" title="img-6">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_6.jpg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_7.jpg" data-fancybox-group="gallery" title="img-7">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_7.jpg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_8.jpg" data-fancybox-group="gallery" title="img-8">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_8.jpg" alt="" />
                                                </a>
<<<<<<< HEAD:app/View/Auth/stylistbiography.ctp
                                            </li> -->

                                            </li>
                                            
                                            

                                        </ul>
                                        <div class="holder"></div>
                                    </div>
<!--
                                        <a class="link-older-photos right" href="javascript:;" title="">Older Photos &gt; </a>
                                        <a class="link-newer-photos left" href="javascript:;" title="">  &lt;Newer Photos  </a>
-->
                                </div>
                                <div class="twelve columns left user-top-outfit">
                                    <h1 class="stylistbio-heading photostream top-outits-heading"><?php echo $find_array[0]['User']['first_name']; ?>’s Top Outfits</h1>
                                    <ul>
                                        <li>
                                            <div class="twelve columns top-outfits">
                                                <div class="eleven columns container">
                                                    <h2>Beach Day</h2>
                                                    <div class="outfit-products">
                                                        <ul>
                                                            <li>
                                                                <img src="<?php echo $this->webroot; ?>images/stylistbio/top-outfilt_1.jpg" alt="" />
                                                           </li>
                                                            <li><img src="<?php echo $this->webroot; ?>images/stylistbio/top-outfilt_2.jpg" alt="" /></li>
                                                            <li><img src="<?php echo $this->webroot; ?>images/stylistbio/top-outfilt_3.jpg" alt="" /><div class="outfit-products-details">Teal Swim Shorts Ben Sherman $88.00</div></li>
                                                            <li><img src="<?php echo $this->webroot; ?>images/stylistbio/top-outfilt_4.jpg" alt="" /></li>
                                                            <li><img src="<?php echo $this->webroot; ?>images/stylistbio/top-outfilt_5.jpg" alt="" /></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="twelve columns top-outfits">
                                                <div class="eleven columns container">
                                                    <h2>Beach Day</h2>
                                                    <div class="outfit-products">
                                                        <ul>
                                                            <li>
                                                                <img src="<?php echo $this->webroot; ?>images/stylistbio/top-outfilt_1.jpg" alt="" />
                                                           </li>
                                                            <li><img src="<?php echo $this->webroot; ?>images/stylistbio/top-outfilt_2.jpg" alt="" /></li>
                                                            <li><img src="<?php echo $this->webroot; ?>images/stylistbio/top-outfilt_3.jpg" alt="" /><div class="outfit-products-details">Teal Swim Shorts Ben Sherman $88.00</div></li>
                                                            <li><img src="<?php echo $this->webroot; ?>images/stylistbio/top-outfilt_4.jpg" alt="" /></li>
                                                            <li><img src="<?php echo $this->webroot; ?>images/stylistbio/top-outfilt_5.jpg" alt="" /></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="twelve columns top-outfits">
                                                <div class="eleven columns container">
                                                    <h2>Beach Day</h2>
                                                    <div class="outfit-products">
                                                        <ul>
                                                            <li>
                                                                <img src="<?php echo $this->webroot; ?>images/stylistbio/top-outfilt_1.jpg" alt="" />
                                                           </li>
                                                            <li><img src="<?php echo $this->webroot; ?>images/stylistbio/top-outfilt_2.jpg" alt="" /></li>
                                                            <li><img src="<?php echo $this->webroot; ?>images/stylistbio/top-outfilt_3.jpg" alt="" /><div class="outfit-products-details">Teal Swim Shorts Ben Sherman $88.00</div></li>
                                                            <li><img src="<?php echo $this->webroot; ?>images/stylistbio/top-outfilt_4.jpg" alt="" /></li>
                                                            <li><img src="<?php echo $this->webroot; ?>images/stylistbio/top-outfilt_5.jpg" alt="" /></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
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