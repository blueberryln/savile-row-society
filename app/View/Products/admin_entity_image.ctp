<div class="content ajax">		
    <div class="sixteen columns">
        <div class="products form">
            <br/><br/>
            <?php echo $this->Form->create('Image', array('type' => 'file')); ?>
            <fieldset class="fifteen columns">
                <legend><?php echo __('Image upload'); ?></legend>
                <?php
                echo $this->Form->input('name', array('type' => 'file', 'label' => 'Attach image'));
                ?>
            </fieldset>
            <div class="clearfix"></div>
            <div class="text-center">
                <?php echo $this->Form->end(__('Upload')); ?>
            </div>
        </div>
    </div>
</div>