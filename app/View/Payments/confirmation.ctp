<?php
$script = '
$(document).ready(function(){
    $("#lnk-fb-share").on("click", function(e){
        e.preventDefault(); 
        window.open(
          "https://www.facebook.com/sharer/sharer.php?s=100&p[title]=" + encodeURIComponent("Savile Row Society") + "&p[summary]=" + encodeURIComponent("I just added a new item to my Closet from www.SavileRowSociety.com! Check out their website, register to chat with one of their premier personal stylists, and make their virtual Closet, your reality.") + "&p[url]=" + encodeURIComponent("http://www.savilerowsociety.com") + "&p[images][0]=" + encodeURIComponent("http://www.savilerowsociety.com/img/SRS_600.png"), 
          "facebook-share-dialog", 
          "width=626,height=436"); 
    });    
});
';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
?>
<div class="content-container">
    <div class="eleven columns container content inner">
        <div class="twelve columns container left message-box">
            <div class="blank-space">&nbsp;</div>
            <div class="eleven columns container">
                <div class="container content inner">	
                    <div class="sixteen columns text-center">
                        <div class="eight columns center-block page-heading">
                            <h1>Transaction Summary</h1>
                        </div>
                        <div class="eight columns center-block">
                                <table border="1" width="100%" style="text-align: left; border: 1px solid #aaa;">
                                    <tr>
                                        <th style="padding: 3px 8px;">Transaction Status</th>
                                        <td style="border-left: 1px solid #aaa; padding: 3px 8px;"><?php echo ucfirst($transaction_complete); ?></td>
                                    </tr>
                                    <?php if($transaction_complete == "success") : ?>
                                    <tr style="border-top: 1px solid #aaa;">
                                        <th style="padding: 3px 8px;">Transaction Id</th>
                                        <td style="border-left: 1px solid #aaa; padding: 3px 8px;"><?php echo $transaction_data['Transaction']['transaction_id']; ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <tr style="border-top: 1px solid #aaa;">
                                        <th style="padding: 3px 8px;">Order Id</th>
                                        <td style="border-left: 1px solid #aaa; padding: 3px 8px;"><?php echo $transaction_data['Transaction']['order_id']; ?></td>
                                    </tr>
                                    <tr style="border-top: 1px solid #aaa;">
                                        <th style="padding: 3px 8px;">Total Amount</th>
                                        <td style="border-left: 1px solid #aaa; padding: 3px 8px;"><?php echo $transaction_data['Transaction']['amount']; ?></td>
                                    </tr>
                                    <tr style="border-top: 1px solid #aaa;">
                                        <th style="padding: 3px 8px;">Card Type</th>
                                        <td style="border-left: 1px solid #aaa; padding: 3px 8px;"><?php echo $transaction_data['Transaction']['card_type']; ?></td>
                                    </tr>
                                </table>
                        </div>
                        <div class="clear"></div>
                        <br />  <br />
                        <div class="twelve columns text-center transact-confirmation center-block">
                            <?php if($transaction_complete == "success") : ?>
                                <p class="text-justify">Thank you for shopping with Savile Row Society and supporting our partnering brands. We are committed to bringing you only the best product made by the most passionate people in the industry. Never hesitate to reach out to your personal stylist and feel free to ask us any questions at <a href="mailto:contactus@savilerowsociety.com">contactus@savilerowsociety.com</a>. We appreciate your patronage and continued support. Thank You.</p>
                                <br />

                                <br />  <br />
                                <img src="https://shareasale.com/sale.cfm?amount=<?php echo $transaction_data['Transaction']['amount']; ?>&tracking=<?php echo $transaction_data['Transaction']['order_id']; ?>&transtype=sale&merchantID=55349" width="1" height="1"> 
                            <?php endif; ?>
                        </div>
                        <div class="twelve columns center-block text-center">
                            <br />
                            <small>If not completely satisfied with your purchase, please email <a href="mailto:returns@Savilerowsociety.com">returns@Savilerowsociety.com</a></small>
                        </div>
                    </div>

                    <?php if($transaction_complete == "success") : ?>
                        <!-- Google Code for Checkout Conversion Page -->
                        <script type="text/javascript">
                        /* <![CDATA[ */
                        var google_conversion_id = 979436043;
                        var google_conversion_language = "en";
                        var google_conversion_format = "3";
                        var google_conversion_color = "ffffff";
                        var google_conversion_label = "XRdxCLXNoQgQi4SE0wM";
                        var google_conversion_value = 0;
                        var google_remarketing_only = false;
                        /* ]]> */
                        </script>
                        <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
                        </script>
                        <noscript>
                        <div style="display:inline;">
                        <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/979436043/?value=0&amp;label=XRdxCLXNoQgQi4SE0wM&amp;guid=ON&amp;script=0"/>
                        </div>
                        </noscript>

                        <script language='JavaScript'>
                            var OB_ADV_ID=21541;
                            var scheme = (("https:" == document.location.protocol) ? "https://" : "http://");
                            var str = '<script src="'+scheme+'widgets.outbrain.com/obtp.js" type="text/javascript"><\/script>';
                            document.write(str);
                        </script>

                    <?php endif; ?>

                    <div class="twelve columns">        
                        <?php
                        if (Configure::read('debug') > 0):
                            echo $this->element('exception_stack_trace');
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if(isset($sale_pixel)){
    if(strpos($sale_pixel, 'TransactionIDHere')){
        $sale_pixel = str_replace('TransactionIDHere', $transaction_data['Transaction']['transaction_id'], $sale_pixel);
    }
    echo $sale_pixel;
}
?>