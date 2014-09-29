<div class="container content inner">
    <br />
    <table cellspacing="0" cellpadding="0" style=" width: 640px; margin: 5px auto; text-align: left; background-color: #ffffff;">
        
        <tbody style="background-color: #ffffff;">
          
        <tr>
            <td style="text-align: center; padding: 20px 0 15px;"><img src="http://www.savilerowsociety.com/img/srs_logo_black.png" alt="Logo" /></td>
        </tr>
        
        <tr>
            <td style="border-top: 1px solid #CFCFCF; border-bottom: 1px solid #CFCFCF; padding: 0px 15px; color: #595959">
            
                <p style="padding-top: 15px;">Hi <?php echo ucwords($shipped_order['User']['full_name']); ?>,</p>

                <div style=" padding: 5px 0;">
                    <p >Thank you for shopping with Savile Row Society.</p>
                    <p>Your order has been received and we are working towards fulfilling it. You will receive an email when your order is on the way. </p>
                    <p>Below is your order summary</p>

                    <table>
                      <tr>
                        <td valign="top"><b>Bill To:</b></td>
                        <td>
                            <?php echo ucfirst($shipped_order['User']['first_name']); ?><br>  
                            <?php echo $shipped_order['User']['BillingAddress']['address']; ?><br>
                            <?php echo $shipped_order['User']['BillingAddress']['city']; ?>, <?php echo $shipped_order['User']['BillingAddress']['state']; ?> - <?php echo $shipped_order['User']['BillingAddress']['zip']; ?><br>
                            <?php echo $shipped_order['User']['BillingAddress']['country']; ?><br>
                            <?php echo $shipped_order['User']['BillingAddress']['fax']; ?>
                        </td>
                      </tr>
                      <tr>
                        <td valign="top"><b>Ship To:</b></td>
                        <td>
                            <?php echo ucfirst($shipped_order['ShippingAddress']['first_name']) . " " . ucfirst($shipped_order['ShippingAddress']['last_name']); ?><br>  
                            <?php echo $shipped_order['ShippingAddress']['address']; ?><br>
                            <?php echo $shipped_order['ShippingAddress']['city']; ?>, <?php echo $shipped_order['ShippingAddress']['state']; ?> - <?php echo $shipped_order['ShippingAddress']['zip']; ?><br>
                            <?php echo $shipped_order['ShippingAddress']['country']; ?>
                        </td>
                      </tr>
                      <tr>
                        <td valign="top"><b>Payment Type:</b></td>
                        <td>
                            <?php echo ucfirst($shipped_order['Transactions']['card_type']); ?>
                        </td>
                      </tr>
                      <tr>
                        <td valign="top"><b>Credit Card Number:</b></td>
                        <td>
                            <?php echo ucfirst($shipped_order['Transactions']['account_number']); ?>
                        </td>
                      </tr>
                    </table>
                    <br>
                    <p><b>Order Information</b></p>
                    <table cellspacing="0" cellpadding="5" border="0" width="100%" style="border: 1px solid #aaa; border-bottom: none; border-right: none;">
                      <tr style="background-color:#ccc; color: #444; font-weight:normal; font-size: 14px; text-align:center;border-bottom: 1px solid #aaa;">
                        <th width="20%">SKU</th>
                        <th width="40%">Item Name</th>
                        <th width="20%">Quantity</th>
                        <th width="20%">Price</th>
                      </tr>
                      <?php foreach($shipped_order['OrderItem'] as $item) : ?>
                          <tr>
                            <td style="border-bottom: 1px solid #aaa; border-right: 1px solid #aaa;"><?php echo $item['Entity']['productcode']; ?></td>
                            <td style="border-bottom: 1px solid #aaa; border-right: 1px solid #aaa;">
                                    <?php echo $item['Entity']['name']; ?>
                                    <br />
                                    <b>Size: </b><?php echo $sizes[$item['size_id']]; ?>
                                </td>
                            <td style="text-align: center; border-bottom: 1px solid #aaa; border-right: 1px solid #aaa;"><?php echo $item['quantity']; ?></td>
                            <td style="text-align: right; border-bottom: 1px solid #aaa; border-right: 1px solid #aaa;"><?php echo $this->Number->format($item['quantity'] * $item['price'], array('places' => 2, 'before' => '$')); ?></td>  
                          </tr>
                        <?php endforeach; ?>
                          <tr>
                            <td colspan="3" style="text-align: left; font-weight: bold; background-color: #ccc; color: #444; border-bottom: 1px solid #aaa; border-right: 1px solid #aaa;">(-)Discount</td>
                            <td style="text-align: right; border-bottom: 1px solid #aaa; border-right: 1px solid #aaa;"><?php echo $this->Number->format($shipped_order['Order']['promo_discount'], array('places' => 2, 'before' => '$')); ?></td> 
                          </tr>
                          <tr>
                            <td colspan="3" style="text-align: left; font-weight: bold; background-color: #ccc; color: #444; border-bottom: 1px solid #aaa; border-right: 1px solid #aaa;">(-)Tax @ <?php echo $this->Number->format($shipped_order['Order']['tax'], array('places' => 2)); ?>%</td>
                            <td style="text-align: right; border-bottom: 1px solid #aaa; border-right: 1px solid #aaa;"><?php echo $this->Number->format($shipped_order['Order']['tax_amount'], array('places' => 2, 'before' => '$')); ?></td> 
                          </tr>
                      <tr>
                        <td colspan="3" style="text-align: left; font-weight: bold; background-color: #ccc; color: #444; border-bottom: 1px solid #aaa; border-right: 1px solid #aaa;">Total</td>
                        <td style="text-align: right; border-bottom: 1px solid #aaa; border-right: 1px solid #aaa;"><?php echo $this->Number->format($shipped_order['Order']['final_price'], array('places' => 2, 'before' => '$')); ?></td>  
                      </tr>
                    </table>
                </div>

                <p style="margin-bottom: 5px; padding-bottom: 0">Best,</p> 
                <p style="padding-bottom: 15px;">The Savile Row Society Team</p>
            
            </td>        
        </tr>
        
        <tr>
            <td style="padding: 5px 0;">
                <p style="font-size: 11px; text-align: center; font-family: arial;"><span style="color: #A0A0A0;">If you have any question, please email us at </span><a href="mailto:contactus@savilerowsocitety.com" style="color: #444;">contactus@savilerowsocitety.com</a></p>
            </td>
        </tr>
            
        </tbody> 
        
        <tfoot>
            
            <tr>
                <td style="padding-top: 10px;">
                    <p style="font-size: 11px; text-align: center; margin: 0px; color: #A0A0A0;">Savile Row Society, Inc. </p>
                    
                    <p style="font-size: 11px; text-align: center; margin: 0px; color: #A0A0A0;">1115 Broadway | New York, NY, 10010</p>
                </td>
            </tr>
        
        </tfoot>
        
    </table>
    
    <div class="thank-you-note" style="page-break-before: always;">
        <center>
            <img src="<?php echo $this->webroot; ?>img/thank_you-note.jpg" style="max-width: 100%;" />
        </center>
    </div>
</div>
<script>
    window.onload = function() { window.print(); }
</script>
