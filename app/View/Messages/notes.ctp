
    <div class="twelve columns container">
        <div class="eleven columns container message-box-area">
            <div class="twelve columns container left message-box">
                
                
                <?php echo $this->element('clientAside/userFilterBar'); ?>
                
                
                <div class="myclient-right right">
                    <div class="twelve columns left inner-content pad-none">
                        
                            <?php echo $this->element('clientAside/userLinksLeft'); ?>

                            <div class="right-pannel right note-gal-sec">
                                <div class="twelve columns notes-area left pad-none">
                                    <div class="eleven columns container pad-none">
                                        <div class="twelve columns left note-area-heading">
                                            <div class="notes-heading">
                                                <ul>
                                                    <li>
                                                        <div class="notes-date">Date</div>
                                                        <div class="notes-dtl">Stylist Notes</div>
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="twelve columns notes-txt-area left pad-none">
                                    <div class="eleven columns container pad-none">
                                        <div class="notes-content-area">
                                            <ul>
                                            <?php foreach ($usernotes as $usernote): ?>
                                                <li><div class="notes-date"><?php echo date('d/m/Y', strtotime($usernote['StylistNote']['created'])); ?></div>
                                                    <div class="notes-dtl"><?php echo $usernote['StylistNote']['notes'] ?></div>
                                                    <div class="notes-btns">
                                                        <!-- <a href="#" title="">Edit</a> -->
                                                        <a href="<?php echo $this->webroot; ?>messages/removenotes/<?php echo $usernote['StylistNote']['id'] ?>">Delete</a>
                                                    </div>
                                                </li> 
                                             <?php endforeach; ?>  
                                               
                                            </ul>
                                            <?php echo $this->Form->create('StylistNote'); ?>
                                            <div class="twelve columns type-note left">
                                                <div class="type-note-area">
                                                <?php echo $this->Form->input('StylistNote.notes',array('type'=>'text','label'=>false,)); ?>
                                                </div>
                                                <div class="note-save">
                                                <input type="submit" name="submit" class="savenotes">
                                                <?php //echo $this->Form->end(__('Submit'),array('class'=>'savenotes')); ?>
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="twelve columns gal-area left pad-none">
                                    <h1>Kyle's Gallery</h1>
                                    <div class="gallery-area">
                                        <div class="eleven columns container pad-none">
                                            <div class="twelve columns myclient-gallery left pad-none">
                                                <ul class="slider3">
                                                    <li><img src="<?php echo $this->webroot; ?>images/how-it-works/fs_img_2.jpg" /></li>
                                                    <li><img src="<?php echo $this->webroot; ?>images/how-it-works/fs_img_2.jpg" /></li>
                                                    <li><img src="<?php echo $this->webroot; ?>images/how-it-works/fs_img_2.jpg" /></li>
                                                </ul>
                                            </div>
                                            <div class="twelve columns left gal-btns"><a class="upload-gal-photos" href="#" title="">Upload Photos</a></div>
                                        </div>
                                    </div> -->
                                    
                                </div>
                            </div>
                        
                        </div>
                    </div>
                
                </div>
                
                
                <div class="eleven columns container pad-none">
                    <div class="my-profile-img m-ver">
                        <h2>LISA D.<span>My Stylist</span></h2>
                        <div class="client-img-small right">
                        <a href="javascript:;" title=""><img src="<?php echo $this->webroot; ?>images/my-profile/my-profile-img.jpg" alt="" /></a>
                        </div>
                        <span id="dd-nav-switcher"><img src="<?php echo $this->webroot; ?>images/nav-switcher-icon.png" alt="" /></span>
                    </div>
                    <div class="dd-nav">
                        <ul>
                            <li><a href="javascript:;">Messages</a></li>
                            <li class="active"><a href="javascript:;">Outfits</a></li>
                            <li><a href="javascript:;">Purchases/Likes</a></li>
                            <li><a href="javascript:;">Profile</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>