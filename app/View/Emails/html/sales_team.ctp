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
                    <?php if($EmailContent['EmailContent']['user_type_id'] && $user['User']['user_type_id']){
                    echo "<p>User Type ID :".$user['User']['user_type_id']."</p>";
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
                    <?php if($EmailContent['EmailContent']['username'] && $user['User']['username']){
                    echo "<p>User Name :".$user['User']['username']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['phone'] && $user['User']['phone']){
                    echo "<p>Phone :".$user['User']['phone']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['social_network'] && $user['User']['social_network']){
                    echo "<p>Social Network :".$user['User']['social_network']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['social_network_id'] && $user['User']['social_network_id']){
                    echo "<p>Social Network ID :".$user['User']['social_network_id']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['social_network_token'] && $user['User']['social_network_token']){
                    echo "<p>Social Network Token :".$user['User']['social_network_token']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['social_network_secret'] && $user['User']['social_network_secret']){
                    echo "<p>Social Network Secret :".$user['User']['social_network_secret']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['title'] && $user['User']['title']){
                    echo "<p>Title :".$user['User']['title']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['birthdate'] && $user['User']['birthdate']){
                    echo "<p>Birth Date :".$user['User']['birthdate']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['industry'] && $user['User']['industry']){
                    echo "<p>Industry :".$user['User']['industry']."</p>";
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
                    <?php if($EmailContent['EmailContent']['preferences'] && $user['User']['preferences']){
                    echo "<p>Preferences :".$user['User']['preferences']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['referred_by'] && $user['User']['referred_by']){
                    echo "<p>Referred_by :".$user['User']['referred_by']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['vip_discount_flag'] && $user['User']['vip_discount_flag']){
                    echo "<p>Vip Discount Flag :".$user['User']['vip_discount_flag']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['vip_discount'] && $user['User']['vip_discount']){
                    echo "<p>Vip Discount :".$user['User']['vip_discount']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['stylist_id'] && $stylist['User']['full_name']){
                    echo "<p>Stylist :".$stylist['User']['full_name']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['is_editor'] && $user['User']['is_editor']){
                    echo "<p>Is Editor :".$user['User']['is_editor']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['is_event'] && $user['User']['is_event']){
                    echo "<p>Is Event :".$user['User']['is_event']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['is_admin'] && $user['User']['is_admin']){
                    echo "<p>Is Admin :".$user['User']['is_admin']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['is_stylist'] && $user['User']['is_stylist']){
                    echo "<p>Is Stylist:".$user['User']['is_stylist']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['view_stylist'] && $user['User']['view_stylist']){
                    echo "<p>View Stylist :".$user['User']['view_stylist']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['random_stylist'] && $user['User']['random_stylist']){
                    echo "<p>Random Stylist :".$user['User']['random_stylist']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['lead'] && $user['User']['lead']){
                    echo "<p>Lead :".$user['User']['lead']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['active'] && $user['User']['active']){
                    echo "<p>Active :".$user['User']['active']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['is_phone'] && $user['User']['is_phone']){
                    echo "<p>Is Phone :".$user['User']['is_phone']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['is_skype'] && $user['User']['is_skype']){
                    echo "<p>Is Skype :".$user['User']['is_skype']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['is_srs_msg'] && $user['User']['is_srs_msg']){
                    echo "<p>Is SRS Message :".$user['User']['is_srs_msg']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['comments'] && $user['User']['comments']){
                    echo "<p>Comments :".$user['User']['comments']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['profile_photo_url'] && $user['User']['profile_photo_url']){
                    echo "<p>Profile Photo Url :".$user['User']['profile_photo_url']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['show_closet_popup'] && $user['User']['show_closet_popup']){
                    echo "<p>Show Closet Popup :".$user['User']['show_closet_popup']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['landing_offer'] && $user['User']['landing_offer']){
                    echo "<p>Landing Offer :".$user['User']['landing_offer']."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['date_created'] && $user['User']['created']){
                    echo "<p>Date Created :".date('m/d/Y',$user['User']['created'])."</p>";
                    } ?>
                    <?php if($EmailContent['EmailContent']['date_updated'] && $user['User']['updated']){
                    echo "<p>Date Updated :".date('m/d/Y',$user['User']['updated'])."</p>";
                    } ?>
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