<div class="content ajax">		
    <div class="sixteen columns">
        <div class="products form">
            <br/><br/>
            <?php if(count($sizes) > 0) : ?>
                <?php echo $this->Form->create('Detail'); ?>
                <fieldset class="fifteen columns">
                    <legend><?php echo __('Size Details'); ?></legend>
                    <?php
                    echo $this->Form->input('size_id', array('label' => 'Size', 'type' => 'select'));
                    echo $this->Form->input('stock', array('value' => 0));
                    echo "<br />";
                    echo $this->Form->input('show', array('type' => 'checkbox', 'label' => 'Show', 'checked' => 'checked'));
                    ?>
                </fieldset>
                <div class="clearfix"></div>
                <div class="text-center">
                    <?php echo $this->Form->end(__('Add')); ?>
                </div>
            <?php else : ?>
                <fieldset class="fifteen columns">
                    <legend><?php echo __('Size Details'); ?></legend>
                    <br />
                    There are no more sizes to add.
                    <div class="clearfix"></div>
                    <br />
                </fieldset>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>