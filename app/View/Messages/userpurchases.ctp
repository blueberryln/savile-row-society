
<div class="content-container">
    <div class="twelve columns black">&nbsp;</div>
    <div class="twelve columns container">
        <div class="eleven columns container message-box-area">
            <div class="twelve columns container left message-box">
                <div class="eleven columns container pad-none">
                    <div class="twelve columns message-box-heading pad-none">
                        <h1>Kyle Harper | <span>Purchase Items</span></h1>
                        <div class="client-img-small"><img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt="" /></div>
                    </div>
                    <div class="my-profile-img m-ver">
                        <h2>LISA D.<span>My Stylist</span></h2>
                        <div class="client-img-small right">
                        <a href="javascript:;" title=""><img src="<?php echo $this->webroot; ?>images/my-profile/my-profile-img.jpg" alt="" /></a>
                        </div>
                        <span id="dd-nav-switcher"><img src="<?php echo $this->webroot; ?>images/nav-switcher-icon.png" alt="" /></span>
                    </div>
                    <div class="dd-nav">
                        <ul>
                            <li><a href="<?php echo $this->webroot; ?>messages/index">Messages</a></li>
                            <li class="active"><a href="<?php echo $this->webroot; ?>messages/usersoutfits/<?php echo $user_id; ?>">Outfits</a></li>
                            <li><a href="javascript:;">Purchases/Likes</a></li>
                            <li><a href="javascript:;">Profile</a></li>
                        </ul>
                    </div>
                    <div class="twelve columns left inner-content pad-none">
                        <div class="inner-left left">
                            <div class="left-pannel left">
                                <div class="client-img"><img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt=""/></div>
                                <div class=" twelve columns left left-nav">
                                    <ul>
                                        <li><a href="<?php echo $this->webroot; ?>messages/index">Messages</a></li>
                                        <li><a href="<?php echo $this->webroot; ?>messages/usersoutfits/<?php echo $user_id; ?>">Outfits</a></li>
                                        <li class="active"><a href="javascript:;">Purchases/Likes</a></li>
                                        <li><a href="javascript:;">Profile</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="right-pannel product-detials right">
                                <div class="twelve columns message-area left pad-none">
                                    <div class="eleven columns container pad-none">
                                        <div class="short-by-date">
                                            <span class="short-by-date-arrow"><img src="<?php echo $this->webroot; ?>images/down-arrow.png" alt=""/></span>
                                            <select>
                                                <option>Sort by Date</option>
                                                <option>7-Aug-2014</option>
                                                <option>7-Aug-2014</option>
                                                <option>7-Aug-2014</option>
                                                <option>7-Aug-2014</option>
                                                <option>7-Aug-2014</option>
                                            </select>
                                        </div>
                                        <div class="tab-btns purchase active"><a href="<?php echo $this->webroot; ?>messages/userpurchases/<?php echo $user_id; ?>" title="">Purchase</a>
                                            
                                        </div>
                                        <div class="tab-btns likes"><a href="<?php echo $this->webroot; ?>messages/userlikes/<?php echo $user_id; ?>" title="">Likes</a></div>
                                        <div class="twelve columns purchase-container left">
                                            <div class="eleven columns container purchase-area pad-none">
                                                <div class="twelve columns left purchase-dtls">
                                                   <ul>
                                                   
                                                        <li>
                                                            <div class="purchase-dtls-date heading left">Date</div>
                                                            <div class="purchase-dtls-items heading left">Item</div>
                                                            <div class="purchase-dtls-outfit heading left">Outfit</div>
                                                            <div class="purchase-dtls-price heading left">Price</div>
                                                       </li>
                                                   
                                                       <?php foreach ($purchases as $purchase): //print_r($purchase); ?>
                                                       <li>
                                                            <div class="purchase-dtls-date left"><?php echo $purchase['Entity']['updated']; ?></div>
                                                            <div class="purchase-dtls-items left">
                                                                <div class="purchase-dtls-items-img"><img src="<?php echo $this->webroot; ?>files/products/<?php echo $purchase['Image'][0]['name']; ?>" alt=""/></div>
                                                                <div class="purchase-dtls-items-desc"><?php echo $purchase['Entity']['name']; ?><span><?php echo $purchase['Brand']['name']; ?></span></div>
                                                           </div>
                                                            <div class="purchase-dtls-outfit left">Business Lunch</div>
                                                            <div class="purchase-dtls-price left">$<?php echo $purchase['Entity']['price']; ?></div>
                                                       </li> 
                                                       <?php endforeach; ?>
                                                       <!-- <li>
                                                            <div class="purchase-dtls-date left">11/06/2014</div>
                                                            <div class="purchase-dtls-items left">
                                                                <div class="purchase-dtls-items-img"><img src="<?php echo $this->webroot; ?>images/jacket.jpg" alt=""/></div>
                                                                <div class="purchase-dtls-items-desc">LaLa Jacket <span>Armani</span></div>
                                                           </div>
                                                            <div class="purchase-dtls-outfit left">Business Lunch</div>
                                                            <div class="purchase-dtls-price left">$105.00</div>
                                                       </li>
                                                       <li>
                                                            <div class="purchase-dtls-date left">11/06/2014</div>
                                                            <div class="purchase-dtls-items left">
                                                                <div class="purchase-dtls-items-img"><img src="<?php echo $this->webroot; ?>images/jacket.jpg" alt=""/></div>
                                                                <div class="purchase-dtls-items-desc">LaLa Jacket <span>Armani</span></div>
                                                           </div>
                                                            <div class="purchase-dtls-outfit left">Business Lunch</div>
                                                            <div class="purchase-dtls-price left">$105.00</div>
                                                       </li>
                                                       <li>
                                                            <div class="purchase-dtls-date left">11/06/2014</div>
                                                            <div class="purchase-dtls-items left">
                                                                <div class="purchase-dtls-items-img"><img src="<?php echo $this->webroot; ?>images/jacket.jpg" alt=""/></div>
                                                                <div class="purchase-dtls-items-desc">LaLa Jacket <span>Armani</span></div>
                                                           </div>
                                                            <div class="purchase-dtls-outfit left">Business Lunch</div>
                                                            <div class="purchase-dtls-price left">$105.00</div>
                                                       </li>  -->
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
                                    <a href="javascript:;" title=""><img src="<?php echo $this->webroot; ?>images/my-profile/my-profile-img.jpg" alt="" data-name="Haspel" /></a>
                                </div>
                                <div class="my-profile-detials">
                                    LISA D.
                                    <span>My Stylist</span>
                                    <a class="view-profile" href="javascript:;">View My Profile</a> 
                                </div>
                                
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>