<?php
$script = '
$(document).ready(function(){
    
});
';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));

$data = $this->request->data;
?>
<div class="container content inner">		
    <div class="sixteen columns text-center">
        <h1><?php echo __('Edit Lifestyle'); ?></h1>
    </div>
    <div class="sixteen columns">
        <div class="products form">
            <?php echo $this->Form->create('Lifestyle', array('type' => 'file')); ?>
            <fieldset class="fifteen columns">
                <legend><?php echo __('Basic Info'); ?></legend>
                <?php
                echo $this->Form->input('name', array('label' => 'Lifestyle Name'));
                echo $this->Form->input('caption', array('label' => 'Lifestyle Caption'));
                echo $this->Form->input('image', array('type' => 'file', 'label' => 'Lifestyle Image'));
                ?>
            </fieldset>
            <div class="text-center">
                <?php echo $this->Form->end(__('Save')); ?>
            </div>
            <br />
            <fieldset class="fifteen columns">
                <legend><?php echo __('Lifestyle Products'); ?></legend>
                    <div class="products index">
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <th>Product Entity Id</th>
                                <th>Name</th>
                                <th>Product Code</th>
                                <th class="actions"><?php echo __('Actions'); ?></th>
                            </tr>
                            <?php if(isset($data['LifestyleItem']) && count($data['LifestyleItem']) > 0) : ?>
                                <?php
                                foreach($data['LifestyleItem'] as $item){
                                ?>
                                <tr>
                                    <td><?php echo $item['Entity']['id']; ?></td>
                                    <td><a href="<?php echo $this->webroot; ?>product/<?php echo $item['Entity']['id']; ?>/<?php echo $item['Entity']['slug']; ?>" target="_blank"><?php echo $item['Entity']['name']; ?></a></td>
                                    <td><?php echo $item['Entity']['productcode']; ?></td>
                                    <td><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete_item', $item['id']), null, 'Are you sure you want to delete this item'); ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                            <?php else : ?>
                                <tr>
                                <td colspan="4" class="text-center">
                                <?php echo "No product variants have been added yet."; ?>
                                </td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>

                <div class="clear"></div>
                <br>
            </fieldset>
            <br />
            <?php echo $this->Form->create('Lifestyle', array('action' => 'add_items')); ?>
            <fieldset class="fifteen columns">
                <legend><?php echo __('Add Products'); ?></legend>
                <?php echo $this->Form->input('id'); ?>
                <?php echo $this->Form->input('product_entity_id', array('type' => 'text', 'label'=>'Product Entity ID')); ?>
            </fieldset>
            <div class="text-center">
                <?php echo $this->Form->end(__('Add')); ?>
            </div>
        </div>
    </div>
</div>