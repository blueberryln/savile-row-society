<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable" width="600">
    <tr>
            <td style="background-color: #000; text-align:center; padding: 8px 0;"><img src="http://www.savilerowsociety.com/img/logo.png" alt="Savile Row Society" /></td>
    </tr>
    <tr>
        <td valign="top">

            <p>You have requested for a tailor appointment. Following are the details you have provided.</p>
            Name: <?php echo $user['User']['first_name']; ?> <?php echo $user['User']['last_name']; ?><br/>
            E-mail: <?php echo $user['User']['email']; ?><br/>
            Phone: <?php echo $user['User']['phone']; ?><br/>
            <?php
            if ($data['Booking']['booking_type_id'] == 1) {
                echo 'Type: A free personal appointment<br/>';
            }
            if ($data['Booking']['booking_type_id'] == 2) {
                echo 'Type: An initial measurement<br/>';
            }
            if ($data['Booking']['booking_type_id'] == 3) {
                echo 'Type: A collection and fitting<br/>';
            }
            ?>
            Date: <?php echo date('m/d/Y', $data['Booking']['date_start']); ?><br/>
        </td>
    </tr>
    <tr>
            <br /><br />
            For any queries please contact us at, <a href="mailto:contact@savilerowsociety.com">contact@savilerowsociety.com</a>
            <br /><br />
            Thanks,
            <br/>
            <a href="http://www.savilerowsociety.com">Savile Row Society</a>
            <br /><br /><br />
    </tr>
</table>