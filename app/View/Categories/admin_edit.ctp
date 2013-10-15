<div class="container content inner">		
    <div class="sixteen columns text-center">
        <h1><?php echo __('Edit Category'); ?></h1>
    </div>
    <div class="sixteen columns">
        <div class="categories form">
            <?php echo $this->Form->create('Category'); ?>
            <fieldset>
                <legend><?php echo __('Basic Info'); ?></legend>
                <?php
                echo $this->Form->input('id');
                echo $this->Form->input('name');
                echo $this->Form->input('slug');
                echo $this->Form->input('parent_id', array('empty'=>'None'));
//                echo $this->Form->input('lft', array('label' => 'Is after...', 'type' => 'select', 'options' => $lft));
//                echo $this->Form->input('rght', array('label' => 'and before...', 'type' => 'select', 'options' => $rght));
                ?>
            </fieldset>
            <div class="clearfix"></div>
            <div class="text-center">
                <?php echo $this->Form->end(__('Update')); ?>
            </div>
        </div>
    </div>
</div>