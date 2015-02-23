<div class="content ajax">		
    <div class="sixteen columns">
        <div class="products form">
            <br/><br/>
            <?php echo $this->Form->create('Attachment', array('type' => 'file')); ?>
            <fieldset class="fifteen columns">
                <legend><?php echo __('Image upload'); ?></legend>
                <?php
                echo $this->Form->input('Image', array('type' => 'file', 'label' => 'Attach image'));
                echo $this->Form->input('Color', array('label' => 'For color', 'type' => 'select'));
                ?>
            </fieldset>
            <div class="clearfix"></div>
            <div class="text-center">
                <?php echo $this->Form->end(__('Upload')); ?>
            </div>
        </div>
    </div>
</div>