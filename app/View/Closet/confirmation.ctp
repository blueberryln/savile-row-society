<div class="container content inner">	
    <div class="sixteen columns text-center">
        <!--<h1><?php echo $name; ?></h1>-->
        <div class="error-msg eight columns offset-by-four">
            <div class="error">
                <h1>Transaction Summary</h1>
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
                <br />
            </div>       
        </div>
    </div>
    <div class="fourteen offset-by-one columns">        
        <?php
        if (Configure::read('debug') > 0):
            echo $this->element('exception_stack_trace');
        endif;
        ?>
    </div>
</div>
