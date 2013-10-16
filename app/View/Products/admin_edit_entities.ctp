<?php
$script = '
$(document).ready(function(){
    $("#upload-image").click(function(e) {
        e.preventDefault();
        $.blockUI({ message: $("#upload") });
        $(".blockOverlay").click($.unblockUI);
        $.ajax({
           url: "' . $this->request->webroot . 'admin/products/entities/upload/' . $id . '" 
        }).done(function(res){
            $("#upload").html(res);
        });
    });
    
    $("#add-size").click(function(e) {
        e.preventDefault();
        $.blockUI({ message: $("#block-size") });
        $(".blockOverlay").click($.unblockUI);
        $.ajax({
           url: "' . $this->request->webroot . 'admin/products/entities/sizeadd/' . $id . '" 
        }).done(function(res){
            $("#block-size").html(res);
        });
    });
    
    $(".edit-detail").click(function(e) {
        e.preventDefault();
        var detail_id = $(this).data("detail_id");
        $.blockUI({ message: $("#block-size") });
        $(".blockOverlay").click($.unblockUI);
        $.ajax({
           url: "' . $this->request->webroot . 'admin/products/entities/sizeedit/" + detail_id 
        }).done(function(res){
            $("#block-size").html(res);
        });
    });
    
    $(".remove-image").click(function(e) {
        e.preventDefault();
        var image_id = $(this).data("image_id");
        $.ajax({
           url: "' . $this->request->webroot . 'admin/products/entities/remove/" + image_id 
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
        <h1><?php echo __('Edit Product Variant'); ?></h1>
    </div>	
    <div class="sixteen columns">
        <div class="products form">
            <?php echo $this->Form->create('Entity', array('type' => 'file')); ?>
            <fieldset class="fifteen columns" style="max-height: 140px; overflow-y: auto;">
                <legend><?php echo __('Product Color'); ?></legend>
                <?php
                echo $this->Form->input('Color', array('label' => '', 'multiple' => 'checkbox'));
                ?>
            </fieldset>
            <fieldset class="fifteen columns">
                <legend><?php echo __('Product Details'); ?></legend>
                <?php
                echo $this->Form->input('id');
                echo $this->Form->input('product_id', array('type' => 'hidden', 'value' => $product_id));
                echo $this->Form->input('user_id', array('type' => 'hidden'));
                echo $this->Form->input('name', array('required'));
                echo $this->Form->input('description', array('rows'=> '5', 'required'));
                echo $this->Form->input('product_code', array('required' => false, 'label' => 'Product Id', 'maxlength' => 50));
                echo $this->Form->input('sku', array('required' => false));
                echo $this->Form->input('slug', array('required' => false));
                echo $this->Form->input('price', array('required'));
                echo $this->Form->input('show', array('type' => 'checkbox'));
                ?>
            </fieldset>
            <fieldset class="fifteen columns">
                <legend><?php echo __('Size & Stock Details'); ?></legend>
                <?php
                    $backorderflag = false; 
                    if($sizes){
                        foreach($sizes as $size){
                        ?>
                            <div class="two columns product-size">
                                Size: <?php echo $size['Size']['name']; ?><br />
                                Stock: <?php echo $size['Detail']['stock']; ?>
                                <br /><br />
                                <a href="#" class="edit-detail" data-detail_id="<?php echo $size['Detail']['id']; ?>">Edit</a>
                            </div>   
                            <?php 
                            if($size['Detail']['stock'] == 0){
                                $backorderflag = true;        
                            }
                            ?>
                        <?php
                        }    
                    }
                ?>
                <div class="clear"></div>
                <br />
                <a href="#" id="add-size" class="btn">Add New Size</a>
                <br /><br />
                <b>Note</b>: Backorder Product 
            </fieldset>
            <fieldset class="fifteen columns">
                <legend><?php echo __('Images'); ?></legend>
                <?php if ($images) : ?>
                    <?php foreach ($images as $file) : ?>
                        <div class="three columns attachment">
                            <img src="<?php echo $this->request->webroot . 'products/resize/' . $file['Image']['name'] . '/160/160'; ?>" class="product-image" />
                            <a href="#" class="remove-image" data-image_id="<?php echo $file['Image']['id']; ?>">Remove</a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <div class="clear"></div>
                <a href="#" id="upload-image" class="btn">Upload image</a> 
            </fieldset>
            <div class="clearfix"></div>
            <div class="text-center">
                <?php echo $this->Form->end(__('Update')); ?>
                <form method="post" action="<?php echo $this->webroot; ?>admin/products/entities/add/<?php echo $product_id; ?>/<?php echo $this->request->data['Entity']['id']; ?>">
                    <div class="submit"><input type="submit" value="Copy This Product" /></div>
                </form>
                <a href="<?php echo $this->webroot; ?>admin/products/entities/add/<?php echo $product_id; ?>" id="upload-image" class="btn">Add Product Variant</a> 
                <a href="<?php echo $this->webroot; ?>admin/products/edit/<?php echo $product_id; ?>" id="upload-image" class="btn">Back to parent type page</a> 
            </div>
        </div>
    </div>
</div>

<div id="block-size"></div>
<div id="upload"></div>