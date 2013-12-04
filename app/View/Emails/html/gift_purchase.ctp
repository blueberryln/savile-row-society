<table style="width: 100%; background: #fff;">
    <tr>
        <td>
            <center>
                <table cellpadding="0" cellspacing="0" border="0" width="600">
                    <tr>
                        <td class="logo" background="#000000"><img align="center" src="http://www.savilerowsociety.com/img/logo.png" alt="Savile Row Society" /></td>
                    </tr>
                    <tr>
                        <td valign="top">
                            <br />
                            Hi <?php echo ucwords($user['User']['full_name']); ?>,
                            <br/><br/>
                            You have purchased a new gift card. Details for the gift card are as follows:
                            <br /><br />
                            Name: <?php echo $item['Entity']['name']; ?><br/>
                            Description: <?php echo $item['Entity']['description']; ?><br/>
                            Gift Card Id: <?php echo $item['OrderItem']['gift_card_id']; ?><br/>
                            Price: <?php echo $item['OrderItem']['price']; ?><br/>
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
