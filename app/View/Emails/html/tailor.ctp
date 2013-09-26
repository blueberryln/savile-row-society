<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
    <tr>
        <td valign="top"> 
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
</table>