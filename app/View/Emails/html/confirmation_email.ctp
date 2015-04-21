<body style=" font-family: Arial; text-align: center; font-size: 14px; color: #595959; background: #F2F2F2; margin: 0; padding: 0;">

    <table cellspacing="0" cellpadding="0" style=" width: 640px; margin: 5px auto; text-align: left; background-color: #ffffff;">
        
        <tbody style="background-color: #ffffff;">
          
        <tr>
            <td style="text-align: center; padding: 20px 0 15px;"><img src="http://www.savilerowsociety.com/img/srs_logo_black.png" alt="Logo" /></td>
        </tr>
        
        <tr>
            <td style="border-top: 1px solid #CFCFCF; border-bottom: 1px solid #CFCFCF; padding: 0px 15px; color: #595959">
            <p style="padding-top: 15px;">Hi <?= ucfirst($results['User']['first_name']); ?>,</p>

                <div style=" padding: 5px 0;">
                    <p>Thank you for signing up for Savile Row Society.</p>

                    <p>Please <a href = "<?php echo 'http://'.host.'/activation/'.base64_encode(convert_uuencode($results['User']['id'])).'/'.base64_encode(convert_uuencode($results['User']['landing_offer'])); ?>">click here</a> to activate your Savile Row Society account. or simply copy and paste the given URL in your browser's address bar:</p>
                    <p><?php echo 'http://'.host.'/activation/'.base64_encode(convert_uuencode($results['User']['id'])).'/'.base64_encode(convert_uuencode($results['User']['landing_offer'])); ?></p>

                </div>

                <p style="margin-bottom: 10px; margin-top: 15px;">Cheers,<br>
                The Savile Row Society Team</p>
            
            </td>        
        </tr>
        
        <tr>
            <td style="padding: 5px 0;">
                <p style="font-size: 11px; text-align: center; font-family: arial;"><span style="color: #A0A0A0;">If you have any question, please email us at </span><a href="mailto:contactus@savilerowsociety.com" style="color: #444;">contactus@savilerowsociety.com</a></p>
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