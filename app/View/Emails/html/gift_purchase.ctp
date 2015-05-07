<table style="width: 100%; background: #fff;">
    <tr>
        <td>
            <center>
                <table cellpadding="0" cellspacing="0" border="0" width="600">
                    <tr>
                        <td style="background-color: #000; text-align:center; padding: 8px 0;"><img src="http://www.savilerowsociety.com/img/logo.png" alt="Savile Row Society" /></td>
                    </tr>
                    <tr>
                        <td valign="top">
                            <br />
                            Hi <?php echo ucwords($gift_details['OrderGiftItem']['recipient_name']); ?>,
                            <br/><br/>
                            <?php echo ucwords($user['User']['full_name']); ?> has gifted you a Savile Row Society gift card.<br />
                            <br />Message:<br /> 
                            <?php echo $gift_details['OrderGiftItem']['message']; ?><br />
                            
                            Visit <a href="http://www.savilerowsociety.com">Savile Row Society</a> to redeem your gift card.<br /><br /> 
                            Details for the gift card are as follows:
                            <br /><br />
                            <b>Name:</b> <?php echo $item['Entity']['name']; ?><br/>
                            <b>Description:</b> <?php echo $item['Entity']['description']; ?><br/><br />
                            <b>Gift Card Id:</b> <?php echo $gift_details['OrderGiftItem']['gift_card_uniqid']; ?>
                            <br/>
                            <b>Price:</b> <?php echo $item['OrderItem']['price']; ?><br/><br />
                            <center>
                            <?php 
                                if($img_src != ""){
                                    echo "<img src='http://www.savilerowsociety.com/files/products/" . $img_src . "' height='400'>"; 
                                }   
                            ?>
                            </center>
                        </td>
                    </tr>
                    <tr>
                         <td>
                            <br /><br />
                            For any queries please contact us at, <a href="mailto:contactus@savilerowsociety.com">contactus@savilerowsociety.com</a>
                            <br /><br />
                            Thanks,
                            <br/>
                            <a href="http://www.savilerowsociety.com">Savile Row Society</a>
                            <br /><br /><br />
                         </td>
                        </tr>
                </table>
            </center>
        </td>
    </tr>
</table>
