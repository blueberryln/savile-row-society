<?php
$script = '
var categoryList = ' . json_encode($category_list) . ';
var isSubcategory = ' . $is_subcategory . ';
var parentCategory = ' . json_encode($parent_category) . ';
var selectedCategory = "' . $selected_category_id . '";
function addSubcategoryList(subCategories){
    $("#sub-category").html("");
    if(subCategories.length > 0){
        $("#sub-category").append("<option value>None</option>");
        for(i=0; i<subCategories.length; i++){
            $("#sub-category").append("<option value=\"" + subCategories[i]["Category"]["id"] + "\">" + subCategories[i]["Category"]["name"] + "</option>");        
        }
        $("#sub-category").closest("div").removeClass("hide");
    }
    else{
        $("#sub-category").closest("div").addClass("hide");    
    }
}
$(document).ready(function(){
    if(isSubcategory){
        var parentCat = parentCategory["Category"]["parent_id"];
        $("#CategoryCategory").val(parentCat); 
        if(categoryList[parentCat]["children"].length > 0){
            addSubcategoryList(categoryList[parentCat]["children"]);
            $("#sub-category").val(selectedCategory);
        }             
    }
    else{
        $("#CategoryCategory").val(selectedCategory);   
        if(categoryList[selectedCategory]["children"].length > 0){
            addSubcategoryList(categoryList[selectedCategory]["children"]);
        } 
    }
    
    $("#CategoryCategory").on("change", function(e){
        var catSelected = $(this).val();
        if(categoryList[catSelected]["children"].length > 0){
            addSubcategoryList(categoryList[catSelected]["children"]);
        }   
        else{
            $("#sub-category").closest("div").addClass("hide"); 
            $("#sub-category").html("");   
        }
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
                echo $this->Form->input('Category', array('label' => 'Category', 'type' => 'select'));
                ?>
                <div class="input select hide">
                    <label for="sub-category">Sub Category</label>
                    <select name="data[Category][SubCategory]" id="sub-category"></select>
                </div>
            </fieldset>
            <fieldset class="fifteen columns">
                <legend><?php echo __('Seasons'); ?></legend>
                <?php
                echo $this->Form->input('season_id', array('label' => '', 'type' => 'select', 'empty' => 'None'));
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