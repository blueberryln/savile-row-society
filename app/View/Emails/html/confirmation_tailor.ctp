<table style="width: 100%; background: #fff;">
    <tr>
        <td>
            <center> 
                <table  cellpadding="0" cellspacing="0" border="0" width="600">
                    <tr>
                            <td style="background-color: #000; text-align:center; padding: 8px 0;"><img src="http://www.savilerowsociety.com/img/logo.png" alt="Savile Row Society" /></td>
                    </tr>
                    <tr>
                        <td valign="top">
                
                            <p>You have requested for a tailor appointment. Following are the details you have provided.</p>
                            <b>Name:</b> <?php echo $user['User']['first_name']; ?> <?php echo $user['User']['last_name']; ?><br/><br/>
                            <b>E-mail:</b> <?php echo $user['User']['email']; ?><br/><br/>
                            <b>Phone:</b> <?php echo $user['User']['phone']; ?><br/><br/>
                            <b>Type:</b> <br />
                            <?php
                            foreach ($data['Booking']['booking_type_id'] as $value) {
                
                                if ($value == 1) {
                                    echo '-Meeting with my personal Stylist<br/>';
                                }
                                if ($value == 2) {
                                    echo '-Made to measure fitting<br/>';
                                }
                                if ($value == 3) {
                                    echo '-Specific occasion (please detail below)<br/>';
                                }
                             }
                            ?><br/>
                            <b>Comment:</b> <?php echo $data['Booking']['comment']; ?><br />
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