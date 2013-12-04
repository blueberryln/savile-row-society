<?php
$script = '
$(document).ready(function(){
    $("#add-more-image").click(function(e) {
        e.preventDefault();
        $(this).before("<input type=\"file\" name=\"data[Image][name][]\"><br><br>");
    });
});
';

$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
?>
<div class="container content inner">
    <div class="sixteen columns text-center">
        <h1><?php echo __('New Product Variant'); ?></h1>
    </div>	
    <div class="sixteen columns">
        <div class="products form">
            <?php if(count($colors) > 0) : ?>
                <?php echo $this->Form->create('Entity', array('type' => 'file')); ?>
                <fieldset class="fifteen columns product-color">
                    <legend><?php echo __('Product Color'); ?></legend>
                    <?php
                    echo $this->Form->input('Color', array('label' => '', 'multiple' => 'checkbox'));
                    ?>
                </fieldset>
                <fieldset class="fifteen columns">
                    <legend><?php echo __('Product Details'); ?></legend>
                    <?php
                    echo $this->Form->input('order', array('required', 'label' => 'Product Order'));
                    echo $this->Form->input('name', array('required', 'label' => 'Product Name'));
                    echo $this->Form->input('description', array('rows'=> '5', 'required'));
                    echo $this->Form->input('productcode', array('required' => false, 'label' => 'Product Id', 'maxlength' => 50));
                    echo $this->Form->input('sku', array('required' => false));
                    echo $this->Form->input('slug', array('required' => false));
                    echo $this->Form->input('price', array('required'));
                    echo $this->Form->input('is_gift', array('type' => 'checkbox'));
                    echo $this->Form->input('is_featured', array('type' => 'checkbox'));
                    echo $this->Form->input('show', array('type' => 'checkbox', 'checked' => 'checked'));
                    ?>
                </fieldset>
                <fieldset class="fifteen columns">
                    <legend><?php echo __('Size & Stock Details'); ?></legend>
                    Save the product variant first, to add size details.
                </fieldset>
                <fieldset class="fifteen columns">
                    <legend><?php echo __('Images'); ?></legend>
                    <?php echo $this->Form->input('image', array('type' => 'file', 'label' => 'Attach image', 'name' => 'data[Image][name][]', 'id' => false, 'div' => false)); ?>
                    <br /><br />
                    <a href="#" id="add-more-image" class="btn">Add More Image</a>
                </fieldset>
                <div class="clearfix"></div>
                <div class="text-center">
                    <?php echo $this->Form->end(__('Add')); ?>
                </div>
            <?php else : ?>
                
            <?php endif; ?>
        </div>
    </div>
</div>