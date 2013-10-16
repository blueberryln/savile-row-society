<?php
$script = '
$(document).ready(function(){
    $("#upload-image").click(function(e) {
        e.preventDefault();
        $.blockUI({ message: $("#upload") });
        $(".blockOverlay").click($.unblockUI);
        $.ajax({
           url: "' . $this->request->webroot . 'admin/products/upload/' . $id . '" 
        }).done(function(res){
            $("#upload").html(res);
        });
    });
    $("#add-property").click(function(e) {
        e.preventDefault();
        $.blockUI({ message: $("#properties") });
        $(".blockOverlay").click($.unblockUI);
        $.ajax({
           url: "' . $this->request->webroot . 'admin/products/properties/' . $id . '" 
        }).done(function(res){
            $("#properties").html(res);
        });
    });
    $(".remove-property").click(function(e) {
        e.preventDefault();
        var property_id = $(this).data("property_id");
        $.ajax({
           url: "' . $this->request->webroot . 'admin/products/properties_remove/" + property_id 
        }).done(function(res){
            location.reload();
        });
    });
    $(".remove-attachment").click(function(e) {
        e.preventDefault();
        var attachment_id = $(this).data("attachment_id");
        $.ajax({
           url: "' . $this->request->webroot . 'admin/products/upload_remove/" + attachment_id 
        }).done(function(res){
            location.reload();
        });
    });
});
';

$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
?>
<div class="container content inner">		
    <div class="sixteen columns text-center">
        <h1><?php echo __('Edit Product Type'); ?></h1>
    </div>
    <div class="sixteen columns">
        <div class="products form">
            <?php echo $this->Form->create('Product'); ?>
            <fieldset class="fifteen columns">
                <legend><?php echo __('Basic Info'); ?></legend>
                <?php
                echo $this->Form->input('id');
                echo $this->Form->input('brand_id');
                echo $this->Form->input('name', array('label' => 'Parent Product Name'));
                ?>
                <?php
                /*echo $this->Form->input('slug');
                echo $this->Form->input('price');
                echo $this->Form->input('sku');
                echo $this->Form->input('image', array('label' => 'Default image', 'type' => 'select', 'options' => $images_list));
                echo $this->Form->input('stock');
                echo $this->Form->input('show');*/
                ?>
            </fieldset>
            <fieldset class="fifteen columns">
                <legend><?php echo __('Categories'); ?></legend>
                <?php
                echo $this->Form->input('Category', array('label' => '', 'type' => 'select'));
                ?>
            </fieldset>
            <fieldset class="fifteen columns">
                <legend><?php echo __('Product Variants'); ?></legend>
                <?php if($entities) : ?>
                    <div class="products index">
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th class="actions"><?php echo __('Actions'); ?></th>
                            </tr>
                            <?php foreach($entities as $entity): ?>
                                <tr>
                                    <td><?php echo h($entity['id']); ?>&nbsp;</td>
                                    <td><?php echo h($entity['name']); ?>&nbsp;</td>
                                    <td class="actions">
                                        <?php echo $this->Html->link(__('Edit'), array('action' => 'entities', 'edit' ,$entity['id'])); ?>
                                        <?php echo $this->Html->link(__('Delete'), array('action' => 'entities', 'delete', $entity['id']), null, __('Are you sure you want to delete this product?')); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php else : ?>
                    <?php echo "No product variants have been added yet."; ?>
                <?php endif; ?>

                <div class="clear"></div>
                <br>
                <a href="<?php echo $this->request->webroot . 'admin/products/entities/add/' . $id; ?>" id="add-entity" class="btn">Add Product Variant</a>
            </fieldset>
            <div class="clearfix"></div>
            <div class="text-center">
                <?php echo $this->Form->end(__('Update')); ?>
            </div>
        </div>
    </div>
</div>
<div id="properties"></div>
<div id="upload"></div>