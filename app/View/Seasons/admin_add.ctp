<div class="container content inner">		
    <div class="sixteen columns text-center">
        <h1><?php echo __('New Season'); ?></h1>
    </div>
    <div class="sixteen columns">
        <div class="categories form">
            <?php echo $this->Form->create('Season'); ?>
            <fieldset>
                <legend><?php echo __('Basic Info'); ?></legend>
                <?php
                echo $this->Form->input('name');
                echo $this->Form->input('slug');
                ?>
            </fieldset>
            <div class="clearfix"></div>
            <div class="text-center">
                <?php echo $this->Form->end(__('Save')); ?>
            </div>
        </div>
    </div>
</div>