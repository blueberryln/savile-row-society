<div class="row">
    <div class="span9 form">
        <?php echo $this->Form->create('Post'); ?>
        <fieldset>
            <legend><?php echo __('Admin Edit Post'); ?></legend>
            <?php
            echo $this->Form->input('id');
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
    <div class="span3">
        <h3><?php echo __('Actions'); ?></h3>
        <ul>

            <li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Post.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Post.id'))); ?></li>
            <li><?php echo $this->Html->link(__('List Posts'), array('action' => 'index')); ?></li>
            <li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
            <li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
            <li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
            <li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
            <li><?php echo $this->Html->link(__('List Comments'), array('controller' => 'comments', 'action' => 'index')); ?> </li>
            <li><?php echo $this->Html->link(__('New Comment'), array('controller' => 'comments', 'action' => 'add')); ?> </li>
            <li><?php echo $this->Html->link(__('List Tags'), array('controller' => 'tags', 'action' => 'index')); ?> </li>
            <li><?php echo $this->Html->link(__('New Tag'), array('controller' => 'tags', 'action' => 'add')); ?> </li>
            <li><?php echo $this->Html->link(__('List User Types'), array('controller' => 'user_types', 'action' => 'index')); ?> </li>
            <li><?php echo $this->Html->link(__('New User Type'), array('controller' => 'user_types', 'action' => 'add')); ?> </li>
        </ul>
    </div>
</div>