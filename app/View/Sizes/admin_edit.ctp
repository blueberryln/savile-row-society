<div class="container content inner">		
    <div class="sixteen columns text-center">
        <h1><?php echo __('Edit Size'); ?></h1>
    </div>
    <div class="sixteen columns">
        <div class="sizes form">
            <?php echo $this->Form->create('Size'); ?>
            <fieldset>
                <legend><?php echo __('Basic Info'); ?></legend>
                <?php
                echo $this->Form->input('id');
                echo $this->Form->input('name');
                ?>
            </fieldset>
            <div class="clearfix"></div>
            <div class="text-center">
                <?php echo $this->Form->end(__('Update')); ?>
            </div>
        </div>
    </div>
</div>