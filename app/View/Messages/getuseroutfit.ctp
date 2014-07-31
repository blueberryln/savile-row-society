<?php
$script = '
$(document).ready(function(){
    $(".fade").mosaic();
    $(".remove-product").click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        var object = $(this).closest(".product-block");
        var id = object.find(".product-id").val();
        $.post("' . $this->request->webroot . 'api/wishlist/remove", { product_id: id }, 
            function(data) {
                var ret = $.parseJSON(data);
                if(ret["status"] == "ok"){
                   object.parent().remove();
                }
            }
        );
    });
    $(".mosaic-overlay").not(".remove-product").on("click", function(e){
        e.preventDefault();
        var container = $(".remove-product");
        var productBlock = $(this).closest(".product-block");
        var productSlug = productBlock.find(".product-slug").val();
        var productId = productBlock.find(".product-id").val();
        window.location = "' . $this->request->webroot . 'product/" + productId + "/" + productSlug;
    });
});
';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->script("mosaic.1.0.1.min.js", array('inline' => false));
$this->Html->meta('description', 'First mover', array('inline' => false));
?>
<div class="content-container">
    <div class="nine-five columns container content inner"> 
        <div class="twelve columns text-center page-heading">
            <h1>User's Outfits</h1>
        </div>
            <div class="eleven columns omega product-listing center-block wishlist text-center">
                <div class="mycloset-tabs text-center">
                    
                </div> 
                                    <style>
                    table, td, th {
                        border: 1px solid green;

                    }

                    th {
                        background-color: gray;
                        color: white;
                    }
                    </style>
                <table align="center" cellpadding="0" cellspacing="0">
                <tr>
                <td>outfit name</td>
                <td>product name</td>
                <td>outfit image</td>
                <td>outfit brands</td>
                <td>outfit total price</td>
                </tr>
                
                <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                </tr>
                
                </tr>
                <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                </tr>
                

                   <tr>
                   
                     <td>
                    <?php 
                    
                     foreach ($outfitnames as $key => $value) { ?><?php echo  $value[0]['Outfit']['outfitname']; ?> 
                    <?php } ?>
                    </td>
                    </tr>
                    <?php  
                    //foreach ($entity_list  as $entity) { 
                    //print_r($outfitnames);
                   
                    for ($i=0; $i < count($entity_list) ; $i++) { 
                        $entity = $entity_list[$i];
                        //print_r($item);

                        echo $entity[0]['Entity']['name'];
                   
                     ?>
                        
                   
                        <tr>
                        
                        

                   
                

                        
                   
                    
                    <td>
                            
                                <?php echo  $entity[0]['Entity']['name']; ?>
                            
                    </td>
                    <td>
                       <?php
                           echo $entity[0]['Image'][0]['name'];
                            ?>
                           
                    </td>
                    <td><?php
                           echo $entity[0]['Brand']['name'];
                            ?></td>
                    <td>
                           $<?php 
                            $sum = $entity[0]['Entity']['price'];
                            echo $sum;
                            ?>
                    </td>
                
               
                <?php    } ?>
                 </tr>
                    
                </table>
                <?php
                //echo count($entity_list);
                 //print_r($entity_list);
                
                
                 //if ($entity_list) : ?>
                    <?php 
                    //for($i = 0; $i < count($entity_list); $i++){
                         //$item = $entity_list[$i];
                        //print_r($item);
                        //}exit;

                    ?>
                        <?php //if(isset($item['Entity']) && $item['Entity']) : ?>
                            <!-- <div class="product-box">
                                <div class="product-block">
                                    <input type="hidden" value="<?php echo $item['Entity']['slug']; ?>" class="product-slug">
                                    <input type="hidden" value="<?php echo $item ['Entity']['id']; ?>" class="product-id">
                                    <div class="product-list-image mosaic-block fade">
                                        <div class="mosaic-overlay">
                                            <a href="" class="remove-product"></a>
                                            <div class="mini-product-details">
                                               <span>$<?php echo $item['Entity']['price']; ?></span>
                                               <span><?php echo $item['Entity']['name']; ?></span>
                                            </div>
                                        </div>
                                        <?php 
                                        if($item['Image']){
                                            $img_src = $this->request->webroot . "files/products/" . $item['Image'][0]['name'];
                                        }
                                        else{
                                            $img_src = $this->request->webroot . "img/photo_not_available.png";
                                        }
                                        ?>
                                        <div class="mosaic-backdrop">
                                            <img src="<?php echo $img_src; ?>" alt="<?php echo $item['Entity']['name']; ?>" />
                                        </div>
                                    </div>
                                    <div class="product-list-links">
                                        <a href="<?php echo $this->request->webroot . 'product/' . $item['Entity']['id'] . '/' . $item['Entity']['slug']; ?>" class="btn-buy">Buy</a>
                                    </div>
                                </div>
                            </div> -->
                        <?php //endif;?>
                    <?php
                    //     if($i == (count($entity_list)-1) && count($entity_list) % 5 == 4){
                    //         echo '<div class="product-box"><div class="product-block"></div></div>';
                    //     }
                    //     if($i == (count($entity_list)-1) && count($entity_list) % 5 == 3){
                    //         echo '<div class="product-box"><div class="product-block"></div></div>';
                    //         echo '<div class="product-box"><div class="product-block"></div></div>';  
                    //     }
                    //     else if($i == (count($entity_list)-1) && count($entity_list) % 5 == 2){
                    //         echo '<div class="product-box"><div class="product-block"></div></div>'; 
                    //         echo '<div class="product-box"><div class="product-block"></div></div>'; 
                    //         echo '<div class="product-box"><div class="product-block"></div></div>'; 
                    //     }
                    //     else if($i == (count($entity_list)-1) && count($entity_list) % 5 == 1){
                    //         echo '<div class="product-box"><div class="product-block"></div></div>'; 
                    //         echo '<div class="product-box"><div class="product-block"></div></div>'; 
                    //         echo '<div class="product-box"><div class="product-block"></div></div>'; 
                    //         echo '<div class="product-box"><div class="product-block"></div></div>'; 
                    //     }
                    // }
                    ?> 
                <?php //else: ?>
                    <!-- <h2 class="subhead text-center">There are no liked items.</h2>   -->
                <?php //endif; ?>
                <div class="clear"></div>
                <div class="pagination my-closet">
                    <?php
                    // echo $this->Paginator->prev('>', array(), null, array('class' => 'prev disabled'));
                    // echo $this->Paginator->numbers(array('separator' => '', 'class' => 'page-links'));
                    // echo $this->Paginator->next('>', array(), null, array('class' => 'next disabled'));
                    ?>
                </div>
                <div class="text-center">
                    <br />
                    <a href="<?php echo $this->webroot . 'closet'; ?>" class="link-btn gold-btn continue-shopping">CONTINUE BROWSING</a>                
                </div><br />
            </div>
            <div class="clear"></div>
            
    </div>
</div>
