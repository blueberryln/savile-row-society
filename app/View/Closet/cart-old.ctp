<?php
$script = '
$(document).ready(function(){
    $(".btn-checkout-confitm").click(function(e) {
        $.post("' . $this->request->webroot . 'api/order/save?" + $("#Purchase").serialize(),
            function(data) {
                if(data != 0){
                    //$("#Purchase").submit();
                }
            }
        );
    });
    $(".remove").click(function(e) {
        e.preventDefault();
        
        var object = $(this).parent();
        var id = $(this).data("product_id");
        $.post("' . $this->request->webroot . 'api/cart/remove", { product_id: id }, 
            function(data) {
                if(data != 0){
                
                 $.get("' . $this->request->webroot . 'api/cart/count", 
                    function(data) {
                        $("#cart-items-count").html(data.count);
                    }, "json"
                );
                    location.reload();             
                }
            }
        );
    });
});
';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->meta('description', 'First mover', array('inline' => false));
?>
<div class="container content inner">	
    <div class="sixteen columns text-center">
        <h1>Your Cart</h1>
    </div>
    <div class="fourteen offset-by-one columns">
        <?php if ($cart_list) : ?>
            <?php
                $total_price = 0.00;
            ?>
            <table class="cart-checkout" cellpadding="0">
                <thead>
                    <th></th>
                    <th></th>
                    <th class="text-left">Products</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Price</th>
                </thead>
                <tbody>
                    <?php foreach ($cart_list as $item) : ?>
                        <?php
                            $total_price = $total_price + $item['Entity']['price'];
                        ?>
                        <tr>
                            <td></td>
                            <td class="product-thumb"><img src="/srs_server/img/detail_view.png" /></td>
                            <td>
                                <h6><?php echo $item['Entity']['name']; ?></h6>
                                <?php
                                    $description = String::truncate($item['Entity']['description'], 25, array('ellipsis' => '...', 'exact' => true, 'html' => false));
                                ?>
                                <small class="description"><?php echo $description; ?></small>
                            </td>
                            <td class="text-center"><?php echo $item['CartItem']['quantity']; ?></td>
                            <td class="text-center"><?php echo $this->Number->currency($item['Entity']['price']); ?></td>
                            <td class="text-center"><?php echo $this->Number->currency($item['Entity']['price'] * $item['CartItem']['quantity']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="last">
                        <td></td>
                        <td></td>
                        <td colspan="3" class="text-center">Total Amount</td>
                        <td class="text-center"><?php echo $this->Number->currency($total_price); ?></td>
                    </tr>
                </tbody>
            </table>
        <?php else : ?>
            <h2 class="subhead text-center">There are no items in the cart.</h2>
        <?php endif; ?>
        <div class="mycart text-center">
            <a href="<?php echo $this->webroot; ?>closet" class="link-btn gold-btn continue-shopping">CONTINUE SHOPPING</a>
            <a href="" class="link-btn green-btn update-quantity">UPDATE QUANTITY</a>
            <a href="" class="link-btn black-btn checkout">CHECKOUT</a>
        </div>
        <div class="clear"></div> <br /><br /><br /><br /><br /><br /><br /><br /><br />
        
        <?php if ($products) : ?>
        <?php
        $fp_timestamp = time();
        $fp_sequence = "1" . time(); // Enter an invoice or other unique number.
        $fingerprint = AuthorizeNetSIM_Form::getFingerprint($api_login_id, $transaction_key, $total_price, $fp_sequence, $fp_timestamp);
        ?>
        <form id="Purchase" method="post" action="https://secure.authorize.net/gateway/transact.dll">
    
            <input type='hidden' name="x_login" value="<?php echo $api_login_id; ?>" />
            <input type='hidden' name="x_fp_hash" value="<?php echo $fingerprint; ?>" />
            <input type='hidden' name="x_amount" value="<?php echo $total_price; ?>" />
            <input type='hidden' name="x_fp_timestamp" value="<?php echo $fp_timestamp; ?>" />
            <input type='hidden' name="x_fp_sequence" value="<?php echo $fp_sequence; ?>" />
            <input type='hidden' name="x_version" value="3.1">
            <input type='hidden' name="x_show_form" value="payment_form">
            <input type='hidden' name="x_test_request" value="false" />
            <input type='hidden' name="x_method" value="cc">
    
            <input type='hidden' name="x_description" value="" />
    
            <input type='hidden' name="x_cust_id" value="<?php echo $data['x_cust_id']; ?>" />
            <input type='hidden' name="x_first_name" value="<?php echo $data['x_first_name']; ?>" />
            <input type='hidden' name="x_last_name" value="<?php echo $data['x_last_name']; ?>" />
            <input type='hidden' name="x_email" value="<?php echo $data['x_email']; ?>" />
            <input type='hidden' name="x_phone" value="<?php echo $data['x_phone']; ?>" />
    
            <input type='hidden' name="x_header_html_payment_form" value="<style type='text/css' media='all'>td{font-size:16px;} input{font-size:12px;} .Page{background-color: #FFFFFF;padding: 20px;text-align: center; width:700px;} #btnSubmit{background-color:#333;border:medium none;color:#FFF;display:inline-block;font-family:Montserrat,sans-serif;text-transform:uppercase;text-decoration:none;margin:5px 0;padding:5px 10px;font-size: 18px;}</style>" />
            <input type='hidden' name="x_logo_url " value="<?php echo $data['x_logo_url']; ?>" />
            <input type='hidden' name="x_color_background" value="#EBEBEB" />
    
            <?php foreach ($products as $product) : ?>
                <?php
                $name = String::truncate($product['Entity']['name'], 25, array('ellipsis' => '...', 'exact' => true, 'html' => false));
                $description = String::truncate($product['Entity']['description'], 25, array('ellipsis' => '...', 'exact' => true, 'html' => false));
                if (empty($description)) {
                    $description = '-';
                }
                $price = 0.00;
                if ($product['Entity']['price'] && $product['Entity']['price'] > 0) {
                    $price = $product['Entity']['price'];
                }
                ?>
                <input TYPE="hidden" name="x_line_item" VALUE="<?php echo $name; ?><|><?php echo $description; ?><|><|><?php echo $product['Entity']['quantity']; ?><|><?php echo $price; ?><|>Y" />
            <?php endforeach; ?>
    
            <!--<input type="button" value="Confirm purchase" class="btn-checkout-confitm" />-->
        </form>
        <?php endif; ?>
    </div>
</div>
