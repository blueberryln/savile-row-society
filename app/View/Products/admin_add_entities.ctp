<div class="container content inner">
    <div class="sixteen columns text-center">
        <h1><?php echo __('New Product Variant'); ?></h1>
    </div>	
    <div class="sixteen columns">
        <div class="products form">
            <?php if(count($colors) > 0) : ?>
                <?php echo $this->Form->create('Entity', array('type' => 'file')); ?>
                <fieldset class="fifteen columns" style="max-height: 140px; overflow-y: auto;">
                    <legend><?php echo __('Product Color'); ?></legend>
                    <?php
                    echo $this->Form->input('Color', array('label' => '', 'multiple' => 'checkbox'));
                    ?>
                </fieldset>
                <fieldset class="fifteen columns">
                    <legend><?php echo __('Product Details'); ?></legend>
                    <?php
                    echo $this->Form->input('name', array('required'));
                    echo $this->Form->input('description', array('rows'=> '5', 'required'));
                    echo $this->Form->input('sku', array('required' => false));
                    echo $this->Form->input('slug', array('required' => false));
                    echo $this->Form->input('price', array('required'));
                    echo $this->Form->input('show', array('type' => 'checkbox', 'checked' => 'checked'));
                    ?>
                </fieldset>
                <fieldset class="fifteen columns">
                    <legend><?php echo __('Size & Stock Details'); ?></legend>
                    Save the product variant first, to add size details.
                </fieldset>
                <fieldset class="fifteen columns">
                    <legend><?php echo __('Images'); ?></legend>
                    Save the product variant first, to add images.
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