<div class="container content inner">		
    <div class="sixteen columns text-center">
        <h1><?php echo __('Assign Stylist'); ?></h1>
    </div>
    <div class="sixteen columns">
        <div class="products form">
            <?php echo $this->Form->create('User'); ?>
            <fieldset>
                <legend><?php echo __('Assign Stylist'); ?></legend>
                <?php
                echo $this->Form->input('id');
                echo $this->Form->input('stylist_id', array('empty' => 'Select Stylist'));
                echo $this->Form->input('personal_shopper');
                echo $this->Form->input('email');
                echo $this->Form->input('first_name');
                echo $this->Form->input('last_name');
                echo $this->Form->input('industry');
                echo $this->Form->input('zip');
                ?>
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