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
                html = html + '<img src="<?php echo HTTP_ROOT; ?>files/users/'+ this.User.profile_photo_url +'" alt=""/>';
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
                                    <option value="<?php echo $this->webroot; ?>messages/stylisteachusersales/<?php echo $userlist['User']['id']; ?>"><?php echo $userlist['User']['first_name'].'&nbsp;'.$userlist['User']['last_name']; ?></option>
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
                                    <a href="<?php echo $this->webroot; ?>messages/stylisteachusersales/<?php echo $userlist['User']['id']; ?>" title="">
                                        <div class="myclient-img">
                                            <img src="<?php echo HTTP_ROOT; ?>files/users/<?php echo $userlist['User']['profile_photo_url']; ?>" alt=""/>
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
                
                
                <div class="myaccount-right">
                    <div class="twelve columns left myaccount-heading">
                        <h1>My Account</h1>
                    </div>
                    <div class="twelve columns left myaccount-sales-dtl">
                        <p>Total Number of Clients: <?php echo $userclient[0][0]['usercount']; ?></p>
                        <p>Average Monthly Sales: $<?php echo  $avgsalepermonths =   round($totalSale[0][0]['finalamount']/12); ?></p>
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
                        <p style="float:left;">Sales Snapshot: <?php echo $client['User']['username']; ?></p>
                        <p style="float:right;"><a href="<?php echo $this->webroot; ?>messages/stylistallusersales">Clear Client Filter</a></p>
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
                        <p>Itemized Sales List: <?php echo $client['User']['username']; ?></p>
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
                                  echo  $saleshistory['orderdetailsuser']['OrderItem']['created'];
                                    ?></div>
                                    <div class="itm-sls-list-item"><span class="sls-itm-img"><img src="<?php echo HTTP_ROOT; ?>files/products/<?php echo $saleshistory['orderdetailsuser']['Image']['name']; ?>" alt=""/></span><?php echo $saleshistory['orderdetailsuser']['Entity']['name']; ?>, <?php echo $saleshistory['orderdetailsuser']['Brand']['name']; ?> </div>
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
                
                
                
            </div>
        </div>
    </div>
</div>