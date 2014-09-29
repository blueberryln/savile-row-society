<div class="container content inner">		
    <div class="sixteen columns text-center">
        <h1><?php echo __('New Stylish'); ?></h1>
    </div>
    <div class="sixteen columns">
        <div class="brands form">
            <?php echo $this->Form->create('Style', array('type' => 'file'));?>
            <fieldset>
                <legend><?php echo __('Basic Info'); ?></legend>
                <?php
                echo $this->Form->input('name',array('label'=>'Name','required','placeholder'=>'Stylish Name'));
                ?>
                <?php
                echo $this->Form->input('Style.image',array('type'=>'file','required'));
                ?>
                <?php
                echo $this->Form->input('order',array('label'=>'Ordering','required','placeholder'=>'Ordering Stylish Name'));
                ?>
               <?php echo $this->Form->input('status', 
                                        array('options' => array(
                                               ''=>'Please Select Status',
                                                '1'=>'Active',
                                                '0'=>'In-Active'
    
                ))); ?>

            </fieldset>
            <div class="clearfix"></div>
            <div class="text-center">
                <?php echo $this->Form->end(__('Save')); ?>
            </div>
        </div>
    </div>
</div>