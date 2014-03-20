<div class="row">
    <h2 class="span9"><?php echo __('Add New Post'); ?></h2>
    <div class="span3 text-right">
        <?php echo $this->Html->link(__('List Posts'), array('action' => 'index'), array('class' => 'btn')); ?>
    </div>
</div>
<div class="row">
    <div class="span12">
        <?php echo $this->Form->create('Post'); ?>
        <fieldset>
            <legend><?php echo __('Admin Add Post'); ?></legend>
            <?php
            echo $this->Form->input('user_id');
            echo $this->Form->input('category_id');
            echo $this->Form->input('title');
            echo $this->Form->input('slug');
            echo $this->Form->input('content');
            echo $this->Form->input('except');
            echo $this->Form->input('date');
            echo $this->Form->input('pubished');
            echo $this->Form->input('Tag');
            echo $this->Form->input('UserType');
            ?>
        </fieldset>
        <?php echo $this->Form->end(__('Submit')); ?>
    </div>
</div>