$('.load-more').on('click', function(e){
        e.preventDefault();

        var pageNo = $('#pageNumber').val();
        var sort = $('#sortdate').val();
        if(sort != ''){
            sort = '?sort=' + sort;
        }

        $.ajax({
            url: '/user/outfits' + sort,
            type: 'Post',
            data: {
                page: pageNo,
            },
            success: function(data){
                var ret = $.parseJSON(data);

                if(ret.length){
                    for(var i=0; i<ret.length; i++){

                        var html = '<div class="twelve columns client-outfits left" >' + 
                                        '<div class="eleven columns container client-outfits-area pad-none" >' + 
                                            '<h1>' + 
                                            ret[i]['Outfit']['outfit_name']) +     
                                            '</h1>' + 
                                            '<div class="twelve columns client-outfits-img pad-none">'
                                                '<ul>'
                                                    <?php 
                                                    $entities = $outfit['OutfitItem'];
                                                    foreach($entities as $entity){
                                                    ?>
                                                
                                                    <li>
                                                        <?php
                                                            if(count($entity['product']['Image'])){
                                                                echo '<img src="' . $this->webroot . 'files/products/' . $entity['product']['Image'][0]['name'] . '" alt="" />';
                                                            }
                                                            else{
                                                                echo '<img src="' . $this->webroot . 'images/image_not_available.png" alt="">';
                                                            }
                                                        ?>
                                                        
                                                        <div class="product-desc">
                                                            <span class="product-name"><?php echo $entity['product']['Entity']['name']; ?></span>
                                                            <span class="product-brand"><?php echo $entity['product']['Brand']['name']; ?></span>
                                                            <span class="product-price">$<?php echo $entity['product']['Entity']['price']; ?></span>
                                                            <span class="product-dtls"><a href="<?php echo $this->webroot; ?>messages/outfitdetails/<?php echo $outfit['Outfit']['id']; ?>" title="">Details</a></span>
                                                            <span class="bottm-links outfit-page-item">
                                                                <a class="add-to-cart" data-product_id="<?php echo $entity['product']['Entity']['id']; ?>" href="" title="">Add to Cart +</a>
                                                                <input type="hidden" id="product_id" class="product-id" value="<?php echo $entity['product']['Entity']['id']; ?>">
                                                                <input type="hidden" id="outfit_id" class="outfit_id" value="<?php echo $outfit['Outfit']['id']; ?>"> 
                                                               
                                                                <a href="#" id="<?php echo $entity['product']['Entity']['id'].'-'.$user_id; ?>" class="thumb-icon"></a>
                                                              
                                                            </span>
                                                        </div>
                                                    </li>
                                                    <?php }  ?>
                                                </ul>
                                            </div>
                                        
                                            <div class="twelve columns left client-outfit-bottom pad-none">
                                                <div class="client-comments left">
                                                    <h2>Stylist Comment</h2>
                                                    <div class="client-comments-text left"><b><?php echo ucfirst($outfit['Stylist']['first_name']); ?></b> - <?php echo $outfit['Message']['body']; ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                    }
                }
                else{
                    $('.load-more').hide();    
                }
            }
        });
    });