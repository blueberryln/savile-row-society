<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
    <tr>
        <td class="logo" background="#000000"><img align="center" src="http://www.savilerowsociety.com/img/logo.png" alt="Savile Row Society" /></td>
    </tr>
    <tr>
        <td valign="top">
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
</table>
