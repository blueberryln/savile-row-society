<?php
$script = '
 $(function() {
    $( "#PromocodeValidFrom" ).datepicker({ dateFormat: "dd-MM-yy" });
    $( "#PromocodeValidTo" ).datepicker({ dateFormat: "dd-MM-yy" });
    
});
';
$this->Html->css('ui/jquery-ui', null, array('inline' => false));
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->script('http://code.jquery.com/ui/1.10.3/jquery-ui.min.js', array('inline' => false));

?>
<div class="container content inner">		
    <div class="sixteen columns text-center">
        <h1><?php echo __('New PromoCode'); ?></h1>
    </div>
    <div class="sixteen columns">
        <div class="products form">
            <?php echo $this->Form->create('Promocode'); ?>
            <fieldset class="fifteen columns">
                <?php
                echo $this->Form->input('name', array('label' => 'Name', 'required'));
                echo $this->Form->input('code', array('label' => 'Code', 'required'));
                echo $this->Form->input('total_available', array('label' => 'Total Promo Code Use Count', 'default' => 0));
                echo $this->Form->input('use_per_customer', array('label' => 'Use per customer', 'default' => 0));
                echo $this->Form->input('valid_from', array('label' => 'Valid From Date', 'type' => 'text'));
                echo $this->Form->input('valid_to', array('label' => 'Valid To Date', 'type' => 'text'));
                echo $this->Form->input('minimum_total_amount', array('label' => 'Minimum Shopping Amount', 'default' => 0));
                echo $this->Form->input('type', array('label' => 'Promo Code Type', 'required'));
                echo $this->Form->input('discount_amount', array('label' => 'Discount Amount', 'required', 'default' => 0));
                echo $this->Form->input('active', array('label' => 'Active'));
                ?>
            </fieldset>
            <div class="clearfix"></div>
            <div class="text-center">
                <?php echo $this->Form->end(__('Save')); ?>
            </div>
        </div>
    </div>
</div>