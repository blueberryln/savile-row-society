<div class="content ajax">		
    <div class="sixteen columns">
        <div class="products form">
            <br/><br/>
            <?php echo $this->Form->create('Detail'); ?>
            <fieldset class="fifteen columns">
                <legend><?php echo __('Edit Size Details'); ?></legend>
                <?php
                echo $this->Form->input('id');
                echo $this->Form->input('product_entity_id', array('type' => 'hidden'));
                echo $this->Form->input('size_id', array('label' => 'Size', 'type' => 'select'));
                echo $this->Form->input('stock');
                echo "<br />";
                echo $this->Form->input('show', array('type' => 'checkbox', 'label' => 'Show', 'checked' => 'checked'));
                ?>
            </fieldset>
            <div class="clearfix"></div>
            <div class="text-center">
                <?php echo $this->Form->end(__('Update')); ?>
            </div>
        </div>
    </div>
</div>