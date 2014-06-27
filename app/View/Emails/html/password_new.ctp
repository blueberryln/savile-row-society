<body style=" font-family: Arial; text-align: center; font-size: 14px; color: #595959; background: #F2F2F2; margin: 0; padding: 0;">

    <table cellspacing="0" cellpadding="0" style=" width: 640px; margin: 5px auto; text-align: left; background-color: #ffffff;">
        
        <tbody style="background-color: #ffffff;">
          
        <tr>
            <td style="text-align: center; padding: 20px 0 15px;"><img src="http://www.savilerowsociety.com/img/srs_logo_black.png" alt="Logo" /></td>
        </tr>
        
        <tr>
            <td style="border-top: 1px solid #CFCFCF; border-bottom: 1px solid #CFCFCF; padding: 0px 15px; color: #595959">
            
                <p style="padding-top: 15px;">Hi <?php echo ucfirst($user['User']['first_name']); ?>,</p>

                <div style=" padding: 5px 0;">
                    <p >Your new password is: <?php echo $new_password; ?></p>
                    <p>To sign-in, please follow the link below:<br>
                        <a href="<?php echo Configure::read('Social.callback_url'); ?>signin"><?php echo Configure::read('Social.callback_url'); ?>signin</a>    
                    <p>
                </div>

                <p style="margin-bottom: 10px; margin-top: 15px;">Cheers,<br>
                The Savile Row Society Team</p>
            
            </td>        
        </tr>
        
        <tr>
            <td style="padding: 5px 0;">
                <p style="font-size: 11px; text-align: center; font-family: arial;"><span style="color: #A0A0A0;">If you have any question, please email us at </span><a href="mailto:contactus@savilerowsocitety.com" style="color: #444;">contactus@savilerowsocitety.com</a></p>
            </td>
        </tr>
            
        </tbody> 
    </table>
    <br>
    <table cellspacing="0" cellpadding="0" style="width: 640px; margin: auto; text-align: center;">
        <tr>
            <td>
                <p style="font-size: 11px; text-align: center; margin: 0px; color: #A0A0A0;">Savile Row Society, Inc. </p>
                
                <p style="font-size: 11px; text-align: center; margin: 0px; color: #A0A0A0;">1115 Broadway | New York, NY, 10010</p>
            </td>
        </tr>
    </table>
</body>