<div class="container content inner">
    <div class="sixteen columns text-center">
        <h1>Payment Confirmation</h1>
    </div>
    <div class="fifteen columns offset-by-half product-listing text-center">
        <?php if($transaction_complete == "success") : ?>
            <p>The transaction is complete. We will contact you shortly.</p>
        <?php else : ?>
            <p>The transaction could not be completed. Please try again.</p>
        <?php endif; ?>
    </div>
    <div class="clear"></div>
    <br /><br /><br />
</div>
