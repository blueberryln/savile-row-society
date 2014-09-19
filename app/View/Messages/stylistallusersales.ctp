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
                
                
                <div class="myclient-left left">
                    <div class="myclient-topsec"> 
                        <div class="filter-myclient-area">
                            <div class="filter-myclient">
                                <span class="downarw"></span>
                                <select>
                                    <option>Filter Clients</option>
                                    <option>Filter Clients</option>
                                    <option>Filter Clients</option>
                                </select>
                            </div>
                        </div>
                        <div class="search-myclient-area">
                            <div class="search-myclient">
                                <span class="srch"></span>
                                <input type="text" name="myclient-search" />
                            </div>
                        </div>
                        <div class="myclient-list">
                            <ul>
                                <li>
                                    <a href="#" title="">
                                        <div class="myclient-img">
                                            <img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt=""/>
                                        </div>
                                        <div class="myclient-dtl">
                                            <span class="myclient-name">Kyle HARPER</span>
                                            <span class="myclient-status">last active at 4:30 PM</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="active">
                                    <a href="#" title="">
                                        <div class="myclient-img">
                                            <img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt=""/>
                                        </div>
                                        <div class="myclient-dtl">
                                            <span class="myclient-name">Kyle HARPER</span>
                                            <span class="myclient-status">last active at 4:30 PM</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="">
                                        <div class="myclient-img">
                                            <img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt=""/>
                                        </div>
                                        <div class="myclient-dtl">
                                            <span class="myclient-name">Kyle HARPER</span>
                                            <span class="myclient-status">last active at 4:30 PM</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="">
                                        <div class="myclient-img">
                                            <img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt=""/>
                                        </div>
                                        <div class="myclient-dtl">
                                            <span class="myclient-name">Kyle HARPER</span>
                                            <span class="myclient-status">last active at 4:30 PM</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                
                <div class="myaccount-right">
                    <div class="twelve columns left myaccount-heading">
                        <h1>My Account</h1>
                    </div>
                    <div class="twelve columns left myaccount-sales-dtl">
                        <p>Total Number of Clients: <?php echo $userclient[0][0]['usercount']; ?></p>
                        <p>Average Monthly Sales: $<?php echo  $avgsalepermonths =   $totalSale[0][0]['finalamount']/12; ?></p>
                        <p>Average Sale per Client: $<?php echo  $avgsalepercustomer =   round($totalSale[0][0]['finalamount']/$userclient[0][0]['usercount']); ?></p>
                    </div>
                    <div class="twelve columns left chart-table">
                        <table class="highchart" data-graph-container=".. .. .highchart-container" data-graph-type="line">
                          <thead>
                            <tr>
                              <th>Month</th>
                              <th>Sales</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($saleshistory as $sales):
                            $date = strtotime($sales['orderdetailsuser']['OrderItem']['created']);
                            $datefinal = strtolower(date('M', $date));    
                            ?>
                            
                            <tr>
                              <td><?php echo $datefinal; ?></td>
                              <td><?php echo $sales['orderdetailsuser']['Entity']['price']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                            <!-- <tr>
                              <td>Feb</td>
                              <td>2500</td>
                            </tr>
                            <tr>
                              <td>Mar</td>
                              <td>6000</td>
                            </tr>
                            <tr>
                              <td>Apr</td>
                              <td>12000</td>
                            </tr>
                            <tr>
                              <td>May</td>
                              <td>6500</td>
                            </tr>
                            <tr>
                              <td>Jun</td>
                              <td>5000</td>
                            </tr>
                            <tr>
                              <td>Jul</td>
                              <td>7500</td>
                            </tr>
                            <tr>
                              <td>Aug</td>
                              <td>15000</td>
                            </tr>
                            <tr>
                              <td>Sep</td>
                              <td>8500</td>
                            </tr>
                            <tr>
                              <td>Oct</td>
                              <td>10000</td>
                            </tr>
                            <tr>
                              <td>Nov</td>
                              <td>16500</td>
                            </tr>
                            <tr>
                              <td>Dec</td>
                              <td>9000</td>
                            </tr> -->
                              
                          </tbody>
                        </table>
                    </div>
                    <div class="twelve columns left sales-snapshot">
                        <p>Sales Snapshot: All Clients</p>
                        <div class="highchart-container">
                        </div>
                        <div class="twelve columns left ratio-analyize">
                            <ul>
                                <li>
                                    <div class="ratio-analyize-price">$<?php echo  $totalSale[0][0]['finalamount']; ?></div>
                                    <span>Total earnings</span>
                                </li>
                                <li>
                                    <div class="ratio-analyize-price">$<?php echo  $avgsalepermonths =   $totalSale[0][0]['finalamount']/12; ?></div>
                                    <span>MOnthlyRevenue</span>
                                </li>
                                <li>
                                    <div class="ratio-analyize-price"><?php echo $userclient[0][0]['usercount']; ?></div>
                                    <span>Total CUstomers</span>
                                </li>
                                <li>
                                    <div class="ratio-analyize-price">$<?php echo  $avgsalepercustomer =   round($totalSale[0][0]['finalamount']/$userclient[0][0]['usercount']); ?></div>
                                    <span>AVg. Sales Per Custom</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class=" twelve columns left itm-sls-list">
                        <p>Itemized Sales List: All Clients</p>
                        <div class="twelve columns left itm-sls-list-content">
                            <ul>
                            
                        
                                <li class="itm-sls-list-heading">
                                    <div class="itm-sls-list-date">date</div>
                                    <div class="itm-sls-list-item">Item</div>
                                    <div class="itm-sls-list-client">Client</div>
                                    <div class="itm-sls-list-outfit">OUtfit</div>
                                    <div class="itm-sls-list-amt">Amount</div>
                                </li>
                                <?php foreach ($saleshistory as $saleshistory): //print_r($saleshistory); ?>
                                <li class="itm-sls-list-section">
                                    <div class="itm-sls-list-date"><?php
                                    $date = strtotime($saleshistory['orderdetailsuser']['OrderItem']['created']);
                                     echo date('M', $date);
                                    
                                     ?></div>
                                    <div class="itm-sls-list-item"><span class="sls-itm-img"><img src="<?php echo $this->webroot; ?>files/products/<?php echo $saleshistory['orderdetailsuser']['Image']['name']; ?>" alt=""/></span><?php echo $saleshistory['orderdetailsuser']['Entity']['name']; ?>, <?php echo $saleshistory['orderdetailsuser']['Brand']['name']; ?> </div>
                                    <div class="itm-sls-list-client"><?php echo $saleshistory['userdetail']['User']['username']; ?></div>
                                    <div class="itm-sls-list-outfit">Beach day</div>
                                    <div class="itm-sls-list-amt">$<?php echo $saleshistory['orderdetailsuser']['Entity']['price']; ?></div>
                                </li>
                            <?php endforeach; ?>
                                <!-- <li class="itm-sls-list-section">
                                    <div class="itm-sls-list-date">7/27/2014</div>
                                    <div class="itm-sls-list-item"><span class="sls-itm-img"><img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt=""/></span>Solid Cali, Solid &amp; STripes </div>
                                    <div class="itm-sls-list-client">kyle harper</div>
                                    <div class="itm-sls-list-outfit">Beach day</div>
                                    <div class="itm-sls-list-amt">$130.00</div>
                                </li>
                                <li class="itm-sls-list-section">
                                    <div class="itm-sls-list-date">7/27/2014</div>
                                    <div class="itm-sls-list-item"><span class="sls-itm-img"><img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt=""/></span>Solid Cali, Solid &amp; STripes </div>
                                    <div class="itm-sls-list-client">kyle harper</div>
                                    <div class="itm-sls-list-outfit">Beach day</div>
                                    <div class="itm-sls-list-amt">$130.00</div>
                                </li>
                                <li class="itm-sls-list-section">
                                    <div class="itm-sls-list-date">7/27/2014</div>
                                    <div class="itm-sls-list-item"><span class="sls-itm-img"><img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt=""/></span>Solid Cali, Solid &amp; STripes </div>
                                    <div class="itm-sls-list-client">kyle harper</div>
                                    <div class="itm-sls-list-outfit">Beach day</div>
                                    <div class="itm-sls-list-amt">$130.00</div>
                                </li>
                                <li class="itm-sls-list-section">
                                    <div class="itm-sls-list-date">7/27/2014</div>
                                    <div class="itm-sls-list-item"><span class="sls-itm-img"><img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt=""/></span>Solid Cali, Solid &amp; STripes </div>
                                    <div class="itm-sls-list-client">kyle harper</div>
                                    <div class="itm-sls-list-outfit">Beach day</div>
                                    <div class="itm-sls-list-amt">$130.00</div>
                                </li>
                                <li class="itm-sls-list-section">
                                    <div class="itm-sls-list-date">7/27/2014</div>
                                    <div class="itm-sls-list-item"><span class="sls-itm-img"><img src="<?php echo $this->webroot; ?>images/my-profile/client-img.jpg" alt=""/></span>Solid Cali, Solid &amp; STripes </div>
                                    <div class="itm-sls-list-client">kyle harper</div>
                                    <div class="itm-sls-list-outfit">Beach day</div>
                                    <div class="itm-sls-list-amt">$130.00</div>
                                </li> -->
                            </ul>
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