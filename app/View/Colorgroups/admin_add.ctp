<div class="container content inner">
    <div class="sixteen columns text-center">
        <h1><?php echo __('New Color Group'); ?></h1>
    </div>
    <div class="sixteen columns">
        <div class="colors form">
            <?php echo $this->Form->create('Colorgroup'); ?>
            <fieldset>
                <legend><?php echo __('Basic Info'); ?></legend>
                <?php
                echo $this->Form->input('name');
                ?>
            </fieldset>
            <div class="clearfix"></div>
            <div class="text-center">
                <?php echo $this->Form->end(__('Save')); ?>
            </div>
        </div>
    </div>
</div>