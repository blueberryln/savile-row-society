<script type="text/javascript">
$(document).ready(function(){
   $("#sortdate").change(function(){
        var sortOrder = $(this).val();
        location = location.href.split('?')[0] + '?sort=' + sortOrder;
   }); 
});
</script>

    <div class="twelve columns container">
        <div class="eleven columns container message-box-area">
            <div class="twelve columns container left message-box">
                <div class="eleven columns container pad-none">

                    <?php echo $this->element('userAside/leftSidebar'); ?>
                            
                            <div class="right-pannel product-detials right">
                                <div class="twelve columns message-area left pad-none">
                                    <div class="eleven columns container pad-none">
                                        <div class="short-by-date">
                                            <span class="short-by-date-arrow"><img src="<?php echo $this->webroot; ?>images/down-arrow.png" alt=""/></span>
                                            <select id="sortdate">
                                                <option value="desc" <?php echo ($pageOrder == 'desc') ? 'selected' : ''; ?>>Sort By Date DESC</option>
                                                <option value="asc" <?php echo ($pageOrder == 'asc') ? 'selected' : ''; ?>>Sort By Date ASC</option>
                                            </select>
                                        </div>
                                        <div class="tab-btns purchase"><a href="<?php echo $this->webroot; ?>user/purchases" title="">Purchase</a>
                                            
                                        </div>
                                        <div class="tab-btns likes active"><a href="<?php echo $this->webroot; ?>user/likes" title="">Likes</a></div>
                                        <div class="twelve columns purchase-container left">
                                            <div class="eleven columns container purchase-area pad-none">
                                                <div class="twelve columns left purchase-dtls">
                                                   <div id="scrollbar2">
                                                        <div class="scrollbar">
                                                            <div class="track">
                                                                <div class="thumb">
                                                                    <div class="end">
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="viewport">
                                                            <div class="overview">
                                                                <ul id='sortbydate'>
                                                                
                                                                    <li>
                                                                        <div class="purchase-dtls-date heading left">Date</div>
                                                                        <div class="purchase-dtls-items heading left">Item</div>
                                                                        <div class="purchase-dtls-outfit heading left">Brand</div>
                                                                        <div class="purchase-dtls-price heading left">Price</div>
                                                                   </li>
                                                               
                                                                   <?php 
                                                                   if(count($likeitems)):
                                                                       foreach ($likeitems as $value): ?>
                                                                           <li>
                                                                                <div class="purchase-dtls-date left"><?php echo date('d/m/Y', strtotime($value['Wishlist']['created'])); ?></div>
                                                                                <div class="purchase-dtls-items left">
                                                                                    <div class="purchase-dtls-items-img">
                                                                                        <?php if(count($value['Image'])): ?>
                                                                                            <img src="<?php echo $this->webroot; ?>files/products/<?php echo $value['Image'][0]['name']; ?>" alt=""/>
                                                                                        <?php else: ?>
                                                                                            <img src="<?php echo $this->webroot; ?>images/image_not_available.png" alt="">
                                                                                        <?php endif; ?>
                                                                                        
                                                                                    </div>
                                                                                    <div class="purchase-dtls-items-desc"><?php echo $value['Entity']['name']; ?></div>
                                                                               </div>
                                                                               <div class="purchase-dtls-outfit left"><?php echo $value['Brand']['name']; ?></div>
                                                                                <div class="purchase-dtls-price left">$<?php echo $value['Entity']['price']; ?></div>
                                                                           </li> 
                                                                       <?php
                                                                        endforeach;
                                                                    else:
                                                                        echo "<h1>There are no liked items to display. Contact your stylist to get started..</h1>";
                                                                    endif; 
                                                                    ?>
                                                                   
                                                                </ul>
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
                        
                        <?php echo $this->element('userAside/rightSidebar'); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
