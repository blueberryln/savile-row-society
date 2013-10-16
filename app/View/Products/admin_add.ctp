<div class="container content inner">		
    <div class="sixteen columns text-center">
        <h1><?php echo __('New Product Type'); ?></h1>
    </div>
    <div class="sixteen columns">
        <div class="products form">
            <?php echo $this->Form->create('Product'); ?>
            <fieldset class="fifteen columns">
                <legend><?php echo __('Basic Info'); ?></legend>
                <?php
                echo $this->Form->input('brand_id');
                echo $this->Form->input('name', array('label' => 'Parent Product Name'));
                ?>
            </fieldset>
            <fieldset class="fifteen columns">
                <legend><?php echo __('Categories'); ?></legend>
                <?php
                echo $this->Form->input('Category', array('label' => '', 'type' => 'select'));
                ?>
            </fieldset>
            <fieldset class="fifteen columns">
                <legend><?php echo __('Product Variants'); ?></legend>
                Save the product type first, to add product type variants.
                <?php
                /*echo $this->Form->input('show', array('type' => 'checkbox'));
                echo "<br>";
                echo $this->Form->input('color', array('label' => 'Color', 'type' => 'select'));
                echo $this->Form->input('price');
                echo $this->Form->input('slug');
                echo $this->Form->input('sku');
                echo $this->Form->input('stock');*/
                ?>
            </fieldset>
            <!-- <fieldset class="fifteen columns properties">
                <legend><?php echo __('Properties'); ?></legend>
                To enter properties, please save the Product.
                <div class="clear"></div>
            </fieldset>
            <fieldset class="fifteen columns attachments">
                <legend><?php echo __('Images'); ?></legend>
                To enter images, please save the Product.
                <div class="clear"></div>
            </fieldset> -->
            <div class="clearfix"></div>
            <div class="text-center">
                <?php echo $this->Form->end(__('Save')); ?>
            </div>
        </div>
    </div>
</div>