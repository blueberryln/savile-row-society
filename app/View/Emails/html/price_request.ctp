<table style="width: 100%; background: #fff;">
    <tr>
        <td>
            <center>  
                <table cellpadding="0" cellspacing="0" border="0" width="600" style="margin:0 auto;">
                    <tr>
                           <td style="background-color: #000; text-align:center; padding: 8px 0;"><img src="http://www.savilerowsociety.com/img/logo.png" alt="Savile Row Society" /></td>
                       </tr>
                    <tr>
                        <td valign="top">
                              <br />
                            Hello,
                            <br/><br/>
                            <?php echo $user['User']['full_name']; ?> has requested price for:
                            <a href="<?php echo Configure::read('Social.callback_url') . "product/" . $entity['Entity']['id'] . "/" . $entity['Entity']['slug']; ?>"><?php echo $entity['Entity']['name']; ?></a>
                            
                            <br /><br />
                            Request Details: <br />
                            Quantity: <?php echo $data['PriceRequest']['quantity']; ?><br />
                            Size: <?php echo $data['PriceRequest']['size']; ?><br />
                            Comment: <?php echo $data['PriceRequest']['comment']; ?><br />
                        </td>
                    </tr>
                </table>
            </center>
        </td>
    </tr>
</table>
