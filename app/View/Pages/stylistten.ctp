<div class="content-container">
    <div class="twelve columns black">
        <div class="eleven columns container">
            <div class="twelve columns container left ">
                <div class="ten columns left admin-nav">
                    <ul>
                        <li class="active"><a href="#" title="">My Clients</a></li>
                        <li><a href="#" title="">Dashboard</a></li>
                        <li><a href="#" title="">My outfits</a></li>
                        <li><a href="#" title="">The CLoset</a></li>
                    </ul>
                </div>
                <div class="two columns right admin-top-right">
                    <ul>
                        <li><a href="#" title=""><img class="cart-icons" src="<?php echo $this->webroot; ?>images/cart-icon.png" alt="" />(<span class="no-of-items">0</span>) </a></li>
                        <li>
                            <a href="#" title=""><span class="client-nav-switcher"><img src="<?php echo $this->webroot; ?>images/menu-dropdown-icon.png" alt="" /></span></a>
                            <div class="admin-top-right-dropdown">
                                <ul>
                                    <li><a href="#" title="">view my cart/checkout</a></li>
                                    <li><a href="#" title="">refer a friend</a></li>
                                    <li><a href="#" title="">sign out</a></li>
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
                <div class="eleven columns container">
                    <div class="twelve columns left myoutfit-section">
                        <div class="four columns left otft-lft">
                            <div class="eleven columns container">
                                <div class="twelve columns left">
                                    <div class="twelve columns left otft-lft-top">
                                        <div class="otft-lft-top-heading">
                                            <h3>Create a New Outfit</h3>
                                            <p>Drag &amp; Drop up to 5 items from <br />the closet to the box below</p>
                                        </div>
                                    </div>
                                    <div class="eleven columns container">
                                        <div class="twelve columns left otft-lft-title">
                                            <h1>Outfit Title</h1>
                                            <input type="text" name="" placeholder="" />
                                            <p>styled for  Kyle Harper <span>(</span> <span class="otft-lft-txt">Change</span> <span>)</span></p>
                                        </div>
                                    </div>
                                    <div class="eleven columns container">
                                        <div class="twelve columns left drp-section">
                                            <div class="eleven columns container otft-drp-area">
                                                <div class="twelve columns left pdct-drp-sec">
                                                    <div class="basket">
                                                        <div class="basket_list">
                                                            <ul>
<!--
                                                                <li><strong>Drag &amp; drop <br />items here</strong></li>
                                                                <li><strong>Drag &amp; drop <br />items here</strong></li>
                                                                <li><strong>Drag &amp; drop <br />items here</strong></li>
                                                                <li><strong>Drag &amp; drop <br />items here</strong></li>
                                                                <li><strong>Drag &amp; drop <br />items here</strong></li>
-->
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="twelve columns left otft-drp-ttl">
                                                        Total Outfit Price: $1600.00
                                                        <p><a href="" title="">clear all</a></p>
                                                    </div>
                                                </div>
                                            </div>
<!--                                            <div class="otft-drp-btm-line left">&nbsp;</div>-->
                                        </div>
                                    </div>
                                    <div class="eleven columns container">
                                        <div class="twelve columns left otft-stylst-cmnt">
                                            <div class="left otft-stylst-cmnt-heading">
                                                <h1>Stylist Comments</h1>
                                                <textarea placeholder="Write a comment to your client before you send outfit"></textarea>
                                                <a id="sbmt-cnfrmation" class="sbmt-btn" href="#" title="">Submit Outfit</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="cnfrm-otft-popup" style="display: none">
                                        <div class="box-modal">
                                            <div class="box-modal-inside">
                                                <a href="#" title="" class="otft-close"></a>
                                                <div class="twelve columns left cnfrm-otft-content">
                                                    <div class="twelve columns left cnfrm-otft-top">
                                                        <h1>Weekend in the Hamptons</h1>
                                                        <span class="otft-prc right">outfit price: $1270</span>
                                                    </div>
                                                    <div class="twelve columns left cnfrm-otft-middle">
                                                        <div class="eleven columns container">
                                                            <div class="twelve columns left cnfrm-otft-itms">
                                                                <div class="right shp-this-otft">shop this outfit &gt;</div>
                                                                <ul>
                                                                    <li>
                                                                        <img src="<?php echo $this->webroot; ?>images/outfits/of_btm_1.jpg" alt="" />
                                                                        <div class="cnfrm-otft-prdct-dtl">
                                                                            White knight twills<br />
                                                                            Whit &amp; co<br />
                                                                            $600.00
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <img src="<?php echo $this->webroot; ?>images/outfits/of_btm_2.jpg" alt="" />
                                                                        <div class="cnfrm-otft-prdct-dtl">
                                                                            White knight twills<br />
                                                                            Whit &amp; co<br />
                                                                            $600.00
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <img src="<?php echo $this->webroot; ?>images/outfits/of_btm_4.jpg" alt="" />
                                                                        <div class="cnfrm-otft-prdct-dtl">
                                                                            White knight twills<br />
                                                                            Whit &amp; co<br />
                                                                            $600.00
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="twelve columns left cnfrm-otft-bottom">
                                                        <div class="eleven columns container">
                                                            <div class="twelve columns left otft-stylist-review">
                                                                <p>Dear Kyle<br/>
                                                                I've created an outfit for your upcoming weekend in the hamptons. I think these pieces are versatile enought to easily be incorporated into day and night time looks. If you have any questions, please get in contact with me.
                                                                </p><br/>
                                                                <p>Your Stylist,<br/>
                                                                Lisa</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="twelve columns left cnfrm-bottom-link">
                                                        <div class="eleven columns container">
                                                            <div class="twelve columns left otft-btm-links">
                                                                <div class="cnfrm-otft-edit left"><a href="#" title="">Edit</a></div>
                                                                <div class="cnfrm-otft-social left">
                                                                    <ul>
                                                                        <li class="cnfrm-otft-social-fb"><a href="#" title="">facebook</a></li>
                                                                        <li class="cnfrm-otft-social-twtr"><a href="#" title="">twitter</a></li>
                                                                        <li class="cnfrm-otft-social-pntrst"><a href="#" title="">pintrest</a></li>
                                                                    </ul>
                                                                </div>
                                                                <div class="cnfrm-otft-send right"><a href="#" title="">Send <span></span></a></div>
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
                        <div class="eight columns right otft-rgt">
                            <div class="twelve columns left otft-rgt-heading">
                                <div class="eleven columns container">
                                    <div class="twelve columns left otft-rgt-nav">
                                        <ul>
                                            <li class="active"><a href="#" title="">The Closet</a></li>
                                            <li>|</li>
                                            <li><a href="#" title="">Client Likes</a></li>
                                            <li>|</li>
                                            <li><a href="#" title="">Purchased</a></li>
                                            <li>|</li>
                                            <li><a href="#" title="">My Bookmarks</a></li>
                                            <li>|</li>
                                            <li><a href="#" title="">Client’s Sizes</a></li>
                                        </ul>
                                    </div>
                                    <div class="otft-right-top">
                                        <div class="otft-right-top-srch">
                                            <span></span>
                                            <input type="text" name="" />
                                        </div>
                                        <div class="otft-right-top-srt">
                                            <select>
                                                <option>Sort By</option>
                                                <option>Sort By</option>
                                                <option>Sort By</option>
                                                <option>Sort By</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="twelve columns left otft-prdct-list">
                                <div id="product">
                                    <ul class="clear">
                                        <li data-id="1">
                                            <a href="#">
                                                <div class="otft-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_1.jpg" alt="" /></div>
                                               <div class="otft-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li data-id="2">
                                            <a href="#">
                                                <div class="otft-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_2.jpg" alt="" /></div>
                                                <div class="otft-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li data-id="3">
                                            <a href="#">
                                                <div class="otft-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_3.jpg" alt="" /></div>
                                                <div class="otft-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li data-id="4">
                                            <a href="#">
                                                <div class="otft-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_4.jpg" alt="" /></div>
                                                <div class="otft-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                                
                                            </a>
                                        </li>
                                        <li data-id="5">
                                            <a href="#">
                                                <div class="otft-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_5.jpg" alt="" /></div>
                                                <div class="otft-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li data-id="6">
                                            <a href="#">
                                                <div class="otft-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_1.jpg" alt="" /></div>
                                                <div class="otft-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li data-id="7">
                                            <a href="#">
                                                <div class="otft-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_2.jpg" alt="" /></div>
                                               <div class="otft-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li data-id="8">
                                            <a href="#">
                                                <div class="otft-prdt-img"><img src="<?php echo $this->webroot; ?>images/outfits/of_btm_3.jpg" alt="" /></div>
                                                <div class="otft-prdt-overlay">
                                                    <h3>Some crazy circuit</h3>
                                                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
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