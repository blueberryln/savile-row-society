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
                            Hi <?php echo ucwords($user['User']['full_name']); ?>,
                            <br/><br/>
                            You have purchased a new gift card. Details for the gift card are as follows:
                            <br /><br />
                            <b>Name:</b> <?php echo $item['Entity']['name']; ?><br/>
                            <b>Description:</b> <?php echo $item['Entity']['description']; ?><br/><br />
                            <b>Quantity:</b> <?php echo $item['OrderItem']['quantity']; ?><br/>
                            <b>Gift Card Id:</b> 
                            <?php 
                                if($item['OrderItem']['quantity'] == 1){
                                    echo $item['OrderItem']['gift_card_id'];
                                }
                                else if($item['OrderItem']['quantity'] > 1){
                                    for($i = 1; $i <= $item['OrderItem']['quantity']; $i++){
                                        if($i != $item['OrderItem']['quantity']){
                                            echo $item['OrderItem']['gift_card_id'] . "-" . $i . ",";
                                        }
                                        else{
                                            echo $item['OrderItem']['gift_card_id'] . "-" . $i . ",";
                                        }    
                                    }
                                }
                            ?>
                            <br/>
                            <b>Price:</b> <?php echo $item['OrderItem']['price']; ?><br/>
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
