<?php
$script = '
$(document).ready(function(){
    $(".remove-cart-item").click(function(e) {
        e.preventDefault();
        $this = $(this);
        var parentRow = $this.closest("tr");
        var cartItemId = $this.parent().find(".cart-item-id").val();
        $.post("' . $this->request->webroot . 'api/cart/remove", { cart_item_id: cartItemId },
            function(data) {
                var ret = $.parseJSON(data);
                if(ret["status"] == "ok"){
                    if(ret["count"] > 0){
                        var cartTotal = $(".cart-total").text().substr(1);
                        var itemPrice = (parentRow.find(".item-price").text()).substr(1);
                        var newTotal = cartTotal - itemPrice;
                        newTotal = parseFloat(newTotal).toFixed(2);
                        $(".cart-total").text("$" + newTotal);
                        $(".cart-items-count").html(ret["count"]);
                        parentRow.remove();
                        var notificationDetails = new Array();
                        notificationDetails["msg"] = "Item removed from the cart.";
                        showNotification(notificationDetails, true);
                    }
                    else{
                        var notificationDetails = new Array();
                        notificationDetails["msg"] = "Item removed from the cart.";
                        showNotification(notificationDetails, true);
                        $(".cart-items-count").html(ret["count"]);
                        $(".cart-checkout").remove();
                        $(".my-cart").prepend("<h2 class=\"subhead text-center\">There are no items in the cart.</h2>");
                        $(".my-cart .checkout").remove();  
                        $(".my-cart .update-quantity").remove();  
                    }
                }
            }
        );
    });
});
';

$update_script = '
    
    $(".update-quantity").on("click", function(e){
        e.preventDefault();
        var cartItems = new Array();
        $(".cart-row").each(function(){
            if($(this).find(".cart-item-gift").val() != "1"){
                cartItemId = $(this).find(".cart-item-id").val();
                cartItemQuantity = parseInt($(this).find(".product-quantity").val()) + 1;
                cartItems.push({"item-id" : cartItemId, "quantity" : cartItemQuantity}); 
            }   
        });
        console.log(cartItems);
        if(cartItems.length > 0){
            $.post("' . $this->request->webroot . 'api/cart/update", { items: cartItems },
                function(data) {
                    console.log(data);
                    window.location.reload();
                }
            );    
        }
        console.log(cartItems);
    });
';

$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->meta('description', 'First mover', array('inline' => false));
?>
<div class="content-container">
    <div class="container content inner">	
        <div class="ten columns text-center page-heading">
            <h1>My Cart</h1>
        </div>
        <div class="ten columns my-cart center-block">
            <?php if ($cart_list) : ?>
                <?php
                    $total_price = 0.00;
                ?>
                <table class="cart-checkout" cellpadding="0" cellspacing="1">
                    <thead>
                        <th width="13px"></th>
                        <th></th>
                        <th class="text-left" width="457">Products</th>
                        <th width="90px">Quantity</th>
                        <th width="90px">Unit Price</th>
                        <th width="90px">Price</th>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_list as $item) : ?>
                            <?php
                                $total_price = $total_price + $item['Entity']['price'] * $item['CartItem']['quantity'];
                            ?>
                            <tr class="cart-row">
                                <td class="v-top">
                                    <input type="hidden" class="cart-item-gift" value="<?php echo ($item['CartItem']['is_gift']) ? '1' : '0'; ?>">
                                    <input type="hidden" class="cart-item-id" value="<?php echo $item['CartItem']['id']; ?>">
                                    <a href="" class="remove-cart-item"><img src="app/webroot/img/cross_menue.png" width="10" height="10" /></a>
                                </td>
                                <?php 
                                    if($item['Image']){
                                        $img_src = $this->request->webroot . "files/products/" . $item['Image'][0]['name'];
                                    }
                                    else{
                                        $img_src = $this->request->webroot . "img/photo_not_available.png";
                                    }
                                ?>
                                <td class="product-thumb"><div class="cart-thumbnail"><a href="<?php echo $this->webroot; ?>product/<?php echo $item['Entity']['id'] . '/' . $item['Entity']['slug'];?>"><img src="<?php echo $img_src; ?>" /></a></div></td>
                                <td class="v-top">
                                    <h6><a href="<?php echo $this->webroot; ?>product/<?php echo $item['Entity']['id'] . '/' . $item['Entity']['slug'];?>"><?php echo $item['Entity']['name']; ?></a></h6>
                                    <?php
                                        $description = String::truncate($item['Entity']['description'], 25, array('ellipsis' => '...', 'exact' => true, 'html' => false));
                                    ?>
                                    <small class="description"><?php echo $description; ?></small>
                                    <small class="description">SIZE: <?php echo $item['Size']['name']; ?></small>
                                    <?php if($item['Color'] && count($item['Color']) > 0) : ?>
                                        <small class="description">Color:
                                            <?php
                                                for($i = 0; $i < count($item['Color']); $i++){
                                                    if((count($item['Color'])-1) == $i){
                                                        echo $item['Color'][$i]['name'];
                                                    }
                                                    else{
                                                        echo $item['Color'][$i]['name'] . '/ ';
                                                    }
                                                }
                                            ?>
                                        </small>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?php //echo $item['CartItem']['quantity']; ?>
                                    <?php
                                    if($item['CartItem']['is_gift']){
                                        echo $item['CartItem']['quantity'];    
                                    }
                                    else{
                                        $min_quantity = 1;
                                        $max_quantity = 10;
                                        if($item['CartItem']['quantity'] >= 10){
                                            $max_quantity = $item['CartItem']['quantity'];   
                                        } 
                                        // echo $this->Form->input('product-quantity', array('class'=>'product-quantity', 'options' => range($min_quantity,$max_quantity), 'label' => false, 'div' => false, 'value' => $item['CartItem']['quantity']-1));
                                        echo $item['CartItem']['quantity'];
                                    } 
                                    ?>    
                                </td>
                                <td class="text-center"><?php echo $this->Number->currency($item['Entity']['price']); ?></td>
                                <td class="text-center item-price"><?php echo $this->Number->currency($item['Entity']['price'] * $item['CartItem']['quantity']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="last">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td colspan="2" class="text-center bold">Total Amount:</td>
                            <td class="text-center cart-total"><?php echo $this->Number->currency($total_price); ?></td>
                        </tr>
                    </tbody>
                </table>
            <?php else : ?>
                <h2 class="subhead text-center">There are no items in the cart.</h2>
            <?php endif; ?>
            <div class="mycart text-center">
                <?php if ($cart_list) : ?>
                    <a href="<?php echo $this->webroot; ?>closet" class="link-btn black-btn continue-shopping">CONTINUE SHOPPING</a>
                    <!-- <a href="" class="link-btn green-btn update-quantity">UPDATE QUANTITY</a> -->
                    <a href="<?php echo $this->webroot; ?>checkout" class="link-btn gold-btn checkout">CHECKOUT</a>
                <?php else : ?>
                    <a href="<?php echo $this->webroot; ?>closet" class="link-btn black-btn continue-shopping">CONTINUE SHOPPING</a>
                <?php endif; ?>
            </div>
            <div class="clear"></div> <br />
        </div>
    </div>
</div>