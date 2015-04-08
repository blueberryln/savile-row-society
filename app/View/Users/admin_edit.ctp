<div class="container content inner">		
    <div class="sixteen columns text-center">
        <h1><?php echo __('Edit User'); ?></h1>
    </div>
    <div class="sixteen columns">
        <div class="products form">
            <?php echo $this->Form->create('User'); ?>
            <fieldset>
                <legend><?php echo __('Admin Edit User'); ?></legend>
                <?php
                echo $this->Form->input('id');
                echo $this->Form->input('email');
                echo $this->Form->input('password');
                echo $this->Form->input('first_name');
                echo $this->Form->input('last_name');
                echo $this->Form->input('zip');
                echo $this->Form->input('phone');
                //echo $this->Form->input('title');
                echo $this->Form->input('referred_by',array('disabled' => 'disabled'));
                //echo $this->Form->input('location');
                echo $this->Form->input('skype');
                //echo $this->Form->input('heard_from');
                echo $this->Form->input('stylist_id', array('empty' => 'Select Stylist'));
                echo $this->Form->input('is_editor');
                echo $this->Form->input('is_stylist');
                echo $this->Form->input('view_stylist');
                echo $this->Form->input('random_stylist');
                echo $this->Form->input('is_admin');
                echo $this->Form->input('is_event');
                echo $this->Form->input('lead');
                echo $this->Form->input('active');
                ?>
            </fieldset>
            <fieldset>
                <legend><?php echo __('Actions'); ?></legend>
                <a href="<?php echo $this->webroot; ?>auth/profile/<?php echo $id; ?>" class="btn">Edit Preferences</a> <!-- | <?php //echo $this->Html->link(__('Delete user'), array('action' => 'delete', $id), null, __('Are you sure you want to delete this user?')); ?>-->
            </fieldset>
            <div class="clearfix"></div>
            <div class="text-center">
                <div class="submit">
                    <input type="submit" value="Update">
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
            
        </div>
    </div>
</div>