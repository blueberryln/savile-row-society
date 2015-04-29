<body style=" font-family: Arial; text-align: center; font-size: 14px; color: #595959; background: #F2F2F2; margin: 0; padding: 0;">

    <table cellspacing="0" cellpadding="0" style=" width: 640px; margin: 5px auto; text-align: left; background-color: #ffffff;">
        
        <tbody style="background-color: #ffffff;">
          
        <tr>
            <td style="text-align: center; padding: 20px 0 15px;"><img src="http://www.savilerowsociety.com/img/srs_logo_black.png" alt="Logo" /></td>
        </tr>
        
        <tr>
            <td style="border-top: 1px solid #CFCFCF; border-bottom: 1px solid #CFCFCF; padding: 0px 15px; color: #595959">
            <p style="padding-top: 15px;">Hi,</p>

                <div style=" padding: 5px 0;">
                    <p >We have a new user who has just signed up with us. Below are the details of the user.</p>
                </div>

                <div style=" padding: 5px 0;">
                    <?php if($EmailContent['EmailContent']['user_id'] && $user['User']['id']){
                    echo "<p>User ID :".$user['User']['id']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['email'] && $user['User']['email']){
                    echo "<p>Email:".$user['User']['email']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['first_name'] && $user['User']['first_name']){
                    echo "<p>First Name :".$user['User']['first_name']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['last_name'] && $user['User']['last_name']){
                    echo "<p>Last Name :".$user['User']['last_name']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['phone'] && $user['User']['phone']){
                    echo "<p>Phone :".$user['User']['phone']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['birthdate'] && $user['User']['birthdate']){
                    echo "<p>Birth Date :".$user['User']['birthdate']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['location'] && $user['User']['location']){
                    echo "<p>Location :".$user['User']['location']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['zip'] && $user['User']['zip']){
                    echo "<p>Zip :".$user['User']['zip']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['skype'] && $user['User']['skype']){
                    echo "<p>Skype :".$user['User']['skype']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['stylist_id'] && $stylist['User']['full_name']){
                    echo "<p>Stylist :".$stylist['User']['full_name']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['is_phone'] && $user['User']['is_phone']){
                    echo "<p>Is Phone :".$user['User']['is_phone']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['is_skype'] && $user['User']['is_skype']){
                    echo "<p>Is Skype :".$user['User']['is_skype']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['comments'] && $user['User']['comments']){
                    echo "<p>Comments :".$user['User']['comments']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['landing_offer'] && $user['User']['landing_offer']){
                    echo "<p>Landing Offer :".$user['User']['landing_offer']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['date_created'] && $user['User']['created']){
                    echo "<p>Date Created :".date('m/d/Y',$user['User']['created'])."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['profile_photo_url'] && $user['User']['profile_photo_url']){
                    echo "<p>Profile Photo : <img src =".HTTP_ROOT."files/users/".$user['User']['profile_photo_url']."/></p>";
                    } ?>
                    <?php if($user['UserPreference']['user_id']) { ?>
                        <?php if($EmailContent['EmailContent']['neck_size'] && $user['UserPreference']['neck_size']){
                        echo "<p>Neck Size :".$user['UserPreference']['neck_size']."</p>";
                        } ?>
                        <?php if($EmailContent['EmailContent']['jacket_size'] && $user['UserPreference']['jacket_size']){
                        echo "<p>Suit Size :".$user['UserPreference']['jacket_size']."</p>";
                        } ?>
                        <?php if($EmailContent['EmailContent']['pant_waist'] && $user['UserPreference']['pant_waist']){
                        echo "<p>Pant Waist :".$user['UserPreference']['pant_waist']."</p>";
                        } ?>
                        <?php if($EmailContent['EmailContent']['pant_length'] && $user['UserPreference']['pant_length']){
                        echo "<p>Pant Length :".$user['UserPreference']['pant_length']."</p>";
                        } ?>
                        <?php if($EmailContent['EmailContent']['shoe_size'] && $user['UserPreference']['shoe_size']){
                        echo "<p>Shoe Size :".$user['UserPreference']['shoe_size']."</p>";
                        } ?>
                        <?php if($EmailContent['EmailContent']['style_pref'] && $user['UserPreference']['style_pref']){
                            echo "<p>Style Profile :</p>";
                            $selected_styles= explode(',',$user['UserPreference']['style_pref']);
                            foreach($selected_styles as $selected_style){
                                echo "<p><img src =".HTTP_ROOT."files/user_styles/".$style[$selected_style]."/></p>";
                            }
                        } ?>

                    <?php } ?>
                    
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