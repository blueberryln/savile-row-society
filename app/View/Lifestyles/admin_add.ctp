<?php
$script = '
$(document).ready(function(){
    
});
';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));

?>
<div class="container content inner">		
    <div class="sixteen columns text-center">
        <h1><?php echo __('New Lifestyle'); ?></h1>
    </div>
    <div class="sixteen columns">
        <div class="products form">
            <?php echo $this->Form->create('Lifestyle', array('type' => 'file')); ?>
            <fieldset class="fifteen columns">
                <legend><?php echo __('Basic Info'); ?></legend>
                <?php
                echo $this->Form->input('name', array('label' => 'Lifestyle Name'));
                echo $this->Form->input('image', array('type' => 'file', 'label' => 'Lifestyle Image'));
                ?>
            </fieldset>
            <div class="clearfix"></div>
            <div class="text-center">
                <?php echo $this->Form->end(__('Save')); ?>
            </div>
        </div>
    </div>
</div>