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
                            Hi <?php echo ucfirst($to_name); ?>,
                            <br/>
                            <?php if($to_stylist) : ?>
                                <?php if($is_photo) : ?>
                                    Your client - <?php echo ucfirst($from_name); ?>, has sent you a photo:
                                    <br /><br />
                                    <img src="<?php echo Configure::read('Social.callback_url'); ?>files/chat/<?php echo $photo_url; ?>" />
                                <?php else : ?>
                                    Your client - <?php echo ucfirst($from_name); ?> has sent you a message:
                                    <br /><br />
                                    <b>Message:</b><br />
                                    <?php echo $message; ?> 
                                <?php endif; ?>
                                
                            <?php else : ?>
                                Your personal stylist - <?php echo ucfirst($from_name); ?>, has sent a new message:
                                <br /><br />
                                <b>Message:</b><br />
                                <?php echo $message; ?> 
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                         <td>
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