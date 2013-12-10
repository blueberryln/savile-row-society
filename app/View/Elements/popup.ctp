<?php
$profileLinkScript = '';
$scriptProfile = '';
if(!isset($registerSharePopup) && isset($profilePopup) && $profilePopup['completeProfile']){
    
    if(isset($profilePopup['isProfile']) && $profilePopup['isProfile']){
        $profileLinkScript = '
            $(".complete-profile").click(function(e){
                e.preventDefault();
                $("#profile-popup").fadeOut();
                $(".blockOverlay").fadeOut();
            });
        ';
    }
    $scriptProfile = '
        $(document).ready(function(){
            $.blockUI({message: $("#profile-popup")});
        ' . $profileLinkScript . '   
        });
    ';  
     
}
$this->Html->scriptBlock($scriptProfile, array('safe' => true, 'inline' => false));
?>


<!-- inside this element open signin view -->
<div id="signin-popup" style="display: none">

</div>
<!-- inside this element open signin view (start signup wizard) -->
<div id="signup-popup" style="display: none">

</div>

<div id="profile-popup" class="hide box-modal notification-box">
    <div class="box-modal-inside">
        <a class="notification-close" href=""></a>
        <h5 class="welcome-srs">Welcome to savile row society!</h5> 
        <!--<div class="notification-msg">To be able to match you with one of our premier personal stylists, please complete this quick style profile.</div>-->
        <div class="notification-msg">Fill out your style profile so we can serve you best. It's fun, quick, and we hook you up as we'll give you a promo code at completion! Get Started Now!</div>                   
        <div class="notification-buttons">
            <a class="link-btn black-btn complete-style-btn" href="<?php echo $this->request->webroot; ?>profile/about">COMPLETE MY STYLE PROFILE</a>
        </div>
        <h6 class="popup-or">OR</h6>
        <p>Check out our curated collection in <a href="<?php echo $this->request->webroot; ?>closet">The Closet</a> or book an appointment with our <a href="<?php echo $this->request->webroot; ?>booking">tailor</a>.</p>   
        
        <p>Sometimes our knocks go unheard - Make sure that you're up to date on everything Savile Row Society by checking your Promotions tab in Gmail</p>
    </div>
</div>