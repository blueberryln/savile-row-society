<div class="container content inner">	
    <div class="sixteen columns text-center">
        <!--<h1><?php echo $name; ?></h1>-->
        <div class="eight columns offset-by-four">
            <h1>Transaction Summary</h1>
        </div>
        <div class="fourteen columns offset-by-one text-justify omega alpha">
                <p>Thank you for shopping with Savile Row Society and supporting our partnering brands. We are committed to bringing you only the best product made by the most passionate people in the industry. Never hesitate to reach out to your personal stylist, where we make our virtual <a href="<?php echo $this->webroot; ?>closet">CLOSET</a> your reality. We appreciate your patronage and continued support. Thank You.</p>
                <br />
        </div>
        <div class="eight columns offset-by-four">
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
                <br />  <br />
                <a class="link-btn black-btn back-btn" href="<?php echo $this->webroot; ?>closet">Go To Closet</a>
        </div>
        <div class="fourteen columns offset-by-one text-justify omega alpha">
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
            var google_conversion_label = "XRdxCLXNoQgQi4SE0wM"; var google_conversion_value = 0; var google_remarketing_only = false;
            /* ]]> */
        </script>
        <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
        <noscript>
            <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt=""  
            src="//www.googleadservices.com/pagead/conversion/979436043/?value=0&amp;label=XRdxCLXNoQgQi4SE0wM&amp;guid=ON&amp;script=0"/>
            </div>
        </noscript>

    <?php endif; ?>
    
    <div class="fourteen offset-by-one columns">        
        <?php
        if (Configure::read('debug') > 0):
            echo $this->element('exception_stack_trace');
        endif;
        ?>
    </div>
</div>
