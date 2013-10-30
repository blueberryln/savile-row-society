<table cellpadding="0" cellspacing="0" border="0" width="600">
    <tr>
        <td class="logo" background="#000000"><img align="center" src="http://www.savilerowsociety.com/img/logo.png" alt="Savile Row Society" /></td>
    </tr>
    <tr>
        <td valign="top">
            <br />
            Hi <?php echo $user['User']['first_name']; ?>,
            <br/><br/>
            Your new password is <strong><?php echo $new_password; ?></strong>
            <br/><br/>
            To signin please follow the link below:
            <br/>
            <a href="<?php echo Configure::read('Social.callback_url'); ?>signin"><?php echo Configure::read('Social.callback_url'); ?>signin</a>
            <br/><br/>
            Thanks,
            <br/>
            <a href="http://www.savilerowsociety.com">Savile Row Society</a>
        </td>
    </tr>
    <tr>
         <td>
            <br /><br />
            For any queries please contact us at, <a href="mailto:contact@savilerowsociety.com">contact@savilerowsociety.com</a>
            <br /><br />
            Thanks,
            <br/>
            <a href="http://www.savilerowsociety.com">Savile Row Society</a>
            <br /><br /><br />
         </td>
        </tr>
</table>
