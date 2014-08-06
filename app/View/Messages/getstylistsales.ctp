<?php


 ?>

 <table>
 	<tr>
 		<td>Amount</td>
 		<td>Client</td>
 		<td>Brand</td>
 		<td>Product</td>
 		<td>Quantity</td>
 		<td>Date</td>
 	</tr>
 	<?php foreach ($saleshistory as $key => $saleshistory) { 
 		//print_r($saleshistory);
			
 		?>
 	<tr>
 		<td><?php echo $saleshistory['orderlist']['Order']['final_price']; ?></td>
 		<td><?php echo $saleshistory['userdetail']['User']['first_name'].'&nbsp&nbsp'.$saleshistory['userdetail']['User']['last_name']; ?></td>
 		<td><?php echo $saleshistory['brand'][0]['Brand']['name']; ?></td>
 		
 			<tr>
 		<td><?php echo $saleshistory['orderdetailsuser']['Entity']['name']; ?></td>
 		<td><?php echo $saleshistory['orderdetailsuser']['OrderItem']['quantity']; ?></td>
 		<td><?php echo $saleshistory['orderdetailsuser']['OrderItem']['created']; ?></td>
 	<?php //} ?>
 	</tr>
<?php } ?>

 </table>