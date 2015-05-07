<div class="content ajax">		
    <div class="sixteen columns">
        <div class="products form">
            <br/><br/>
            <?php echo $this->Form->create('Property', array('type' => 'file')); ?>
            <fieldset class="fifteen columns">
                <legend><?php echo __('Add properties'); ?></legend>
                <?php
                echo $this->Form->input('color_id', array('label' => 'Color', 'type' => 'select'));
                echo $this->Form->input('size_id', array('label' => 'Size', 'type' => 'select'));
                echo $this->Form->input('stock', array('label' => 'Stock'));
                echo $this->Form->input('sku', array('label' => 'Sku'));
                ?>
            </fieldset>
            <div class="clearfix"></div>
            <div class="text-center">
                <?php echo $this->Form->end(__('Add')); ?>
            </div>
        </div>
    </div>
</div>