<div class="container content inner">		
    <div class="sixteen columns text-center">
        <h1><?php echo __('Edit Styles'); ?></h1>
    </div>
    <div class="sixteen columns">
        <div class="brands form">
            <?php 
			 echo $this->Form->create('Style', array('type' => 'file')); ?>
            <fieldset>
                <legend><?php echo __('Basic Info'); ?></legend>
                <?php
                    echo $this->Form->input('Style.id',array('type'=>'hidden'));
                    
                    echo $this->Form->input('Style.name',array('label'=>'Name','required','placeholder'=>'Stylish Name'));
                    echo $this->Form->input('image',array('type'=>'file'));
                    echo $this->Form->input('Style.order',array('label'=>'Ordering','required','placeholder'=>'Ordering Stylish Name'));
                    echo $this->Form->input('Style.status', array('options' => array(
                                                   ''=>'Please Select Status',
                                                    '1'=>'Active',
                                                    '0'=>'In-Active'
                                                    
                                                ))); 
                ?>
 </fieldset>
            <div class="clearfix"></div>
            <div class="text-center">
                <?php echo $this->Form->end(__('Update')); ?>
            </div>
        </div>
    </div>
</div>