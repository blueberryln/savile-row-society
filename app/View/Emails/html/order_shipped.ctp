<table cellpadding="0" cellspacing="0" border="0" style="max-width:550">
    <tr>
        <td style="background-color: #000; text-align:center; padding: 8px 0;"><img src="http://www.savilerowsociety.com/img/logo.png" alt="Savile Row Society" /></td>
    </tr>
    <tr>
        <td valign="top">
        	<br />
            Hi <?php echo $shipped_order['User']['full_name']; ?>,
            <br /><br />
            Your order has been shipped!
            <br /><br />
            Below is your order summary: 
            <br />
            <strong>Name :</strong> <?php echo $shipped_order['User']['full_name']; ?>
            <br />
            <strong>Date of order :</strong> <?php echo date('d-M-Y' , strtotime($shipped_order['Order']['created'])); ?>
            <br />
            <strong>Shipping Address :</strong> <?php echo $shipped_order['ShippingAddress']['address'] . ', ' . $shipped_order['ShippingAddress']['city'] . ', ' . $shipped_order['ShippingAddress']['state'] . ', ' . $shipped_order['ShippingAddress']['country'] . ' - ' . $shipped_order['ShippingAddress']['zip']; ?>
            <br /><br />
           	<table cellspacing="0" cellpadding="5" border="0" width="100%" style="border: 1px solid #444; border-bottom: none; border-right: none;">
           		<tr style="background-color:#000; color: #eee; font-weight:normal; font-size: 14px; text-align:center;">
           			<th width="20%">&nbsp;</th>
           			<th width="40%">Item Description</th>
           			<th width="20%">Quantity</th>
           			<th width="20%">Price</th>
           		</tr>
                <?php foreach($shipped_order['OrderItem'] as $item) : ?>
               		<tr>
               			<td style="border-bottom: 1px solid #444; border-right: 1px solid #444;"><img src="http://localhost/srs_server/files/products/152_8_R4100004.jpg" style="max-width:110px;"></td>
               			<td style="border-bottom: 1px solid #444; border-right: 1px solid #444;"><?php echo $item['Entity']['name']; ?></td>
               			<td style="text-align: center; border-bottom: 1px solid #444; border-right: 1px solid #444;"><?php echo $item['OrderItem']['quantity']; ?></td>
               			<td style="text-align: right; border-bottom: 1px solid #444; border-right: 1px solid #444;">$ <?php echo $item['OrderItem']['quantity'] * $item['OrderItem']['price']; ?></td>	
               		</tr>
                <?php endforeach; ?>
                
           		<tr>
           			<td style="text-align: left; font-weight: bold; background-color: #000; color: #eee; border-bottom: 1px solid #444; border-right: 1px solid #444;">Total</td>
           			<td style="text-align: right; border-bottom: 1px solid #444; border-right: 1px solid #444;">$ <?php $shipped_order['Order']['total_price']; ?></td>	
           		</tr>
           	</table>
            
            <br /><br />
            For any queries please contact us at, <a href="mailto:admin@savilerowsociety.com">admin@savilerowsociety.com</a>
            <br /><br />
            Thanks,
            <br/>
            <a href="http://www.savilerowsociety.com">Savile Row Society</a>
            
        </td>
    </tr>
</table>