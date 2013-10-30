<table cellpadding="0" cellspacing="0" border="0" width="600">
    <tr>
           <td style="background-color: #000; text-align:center; padding: 8px 0;"><img src="http://www.savilerowsociety.com/img/logo.png" alt="Savile Row Society" /></td>
       </tr>
    <tr>
        <td valign="top">
              <br />
            Hi <?php echo $user['User']['first_name']; ?>,
            <br/><br/>
            There was recently a request to change the password on your account.
            <br/><br/>
            If you requested this password change, please reset your current password by following the link below:
            <br/>
            <a href="<?php echo Configure::read('Social.callback_url'); ?>reset/<?php echo $user['User']['id']; ?>/<?php echo $user['User']['password']; ?>"><?php echo Configure::read('Social.callback_url'); ?>reset/<?php echo $user['User']['id']; ?>/<?php echo $user['User']['password']; ?></a>
            <br/><br/>
            If you don't want to change your password, just ignore this message.
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
