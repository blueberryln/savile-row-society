<?php
$script = '
$(document).ready(function(){
    $("#lnk-fb-share").on("click", function(e){
        e.preventDefault(); 
        window.open(
          "https:www.facebook.com/sharer/sharer.php?s=100&p[title]=" + encodeURIComponent("Savile Row Society") + "&p[summary]=" + encodeURIComponent("I just completed my Style Profile on www.SavileRowSociety.com! Check out their website, fill our your Style Profile to chat with one of their premier personal stylists, and make their virtual Closet, your reality.") + "&p[url]=" + encodeURIComponent("http:www.savilerowsociety.com") + "&p[images][0]=" + encodeURIComponent("http:www.savilerowsociety.com/img/SRS_600.png"), 
          "facebook-share-dialog", 
          "width=626,height=436"); 
      
    });    
});
';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$meta_description = 'Sign up for Savile Row Society, a groundbreaking online, personalized fashion service.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>
<input type="hidden" value="<?php echo $user_id ?>" name="data[User][id]" />
<div class="content-container">
    <div class="container content inner register-finish">	
        <div class="eight columns text-center page-heading">
            <h1>PROFILE</h1>
        </div>	
        <div class="eight columns register-steps center-block">
            <div class="profile-tabs text-center">
                        <a class="link-btn gold-btn my-style" href="<?php echo $this->webroot; ?>profile/about">My Style</a>
                        <a class="link-btn black-btn my-profile" href="<?php echo $this->webroot; ?>myprofile">My Profile</a>
            </div>
        </div>
        <div class="twelve columns text-center" id="reg-step">
            <div class="reg-step6"><img src="<?php echo $this->webroot; ?>img/reg-step6.png"/></div>
        </div>
        <div class="twelve columns">

            <div class="hi-message text-center">
                <h4 class="hi-message">COMPLETED</h4>
                <p>Thank you for taking the time to introduce yourself to us. You're officially Hooked Up! Use Promo Code "SRS20".</p>
                <p>
                    Thank you for completing our quick style profile. We are matching your responses with a stylist who suits you. In the meantime, you can browse The Closet or book an appointment with our tailor. We look forward to many successful years of helping you build your wardrobe. Thank you for choosing Savile Row Society for your personal shopping services. <br />Tailor your life. 
                </p>
                <p>Sometimes our knocks go unheard - Make sure that you're up to date on everything Savile Row Society by checking your Promotions tab in Gmail!</p>
                <h5>Thank you</h5>
                <h5>The SRS Team</h5>
                <br />
                <?php echo $this->Form->create('FinishStep', array('url' => '/register/saveFinish')); ?>
                <textarea name="data[Message][body]" class="six columns im-request" placeholder="Have any immediate requests? We'll assign your comments to your stylist."></textarea>
                <div class="text-center about-submit">
                    <br/>                       
                    <div class="submit">                
                        <input type="submit" class="submit" value="Submit" /><br />
                        <a class="link-btn gold-btn" href="<?php echo $this->webroot; ?>closet">Have a look in The Closet</a>
                        
                        <div class="product-share" style="float: none;">
                            <span>Share:</span>
                            <a href="" id="lnk-fb-share"></a>
                            <a href="mailto:?subject=Welcome to SAVILE ROW SOCIETY&body=Hello, %0D%0A%0D%0AI just completed my Style Profile on http://www.SavileRowSociety.com! Check out their website, fill out your Style Profile to chat with one of their premier personal stylists, and make their virtual Closet, your reality." id="lnk-email"></a>
                        </div>                                                       
                    </div>           
                </div>
                </form>
            </div>
            
        </div>
    </div>
</div>