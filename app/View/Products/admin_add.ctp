<?php
$script = '
var categoryList = ' . json_encode($category_list) . ';
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
function addSubSubcategoryList(subSubCategories){
    $("#sub-sub-category").html("");
    if(subSubCategories.length > 0){
        $("#sub-sub-category").append("<option value>None</option>");
        for(i=0; i<subSubCategories.length; i++){
            $("#sub-sub-category").append("<option value=\"" + subSubCategories[i]["Category"]["id"] + "\">" + subSubCategories[i]["Category"]["name"] + "</option>");        
        }
        $("#sub-sub-category").closest("div").removeClass("hide");
    }
    else{
        $("#sub-sub-category").closest("div").addClass("hide");    
    }
}
$(document).ready(function(){
    var catSelected = $("#CategoryCategory").val();
    if(categoryList[catSelected]["children"].length > 0){
        addSubcategoryList(categoryList[catSelected]["children"]);
    }
    
    $("#CategoryCategory").on("change", function(e){
        var catSelected = $(this).val();
        $("#sub-category").html("");
        $("#sub-sub-category").html("");
        $("#sub-sub-category").closest("div").addClass("hide"); 
        if(categoryList[catSelected]["children"].length > 0){
            addSubcategoryList(categoryList[catSelected]["children"]);
        }   
        else{
            $("#sub-category").closest("div").addClass("hide");   
            $("#sub-category").html(""); 
            $("#sub-sub-category").closest("div").addClass("hide");
        }
    });
    
    $("#sub-category").on("change", function(e){
        var catSelected = $("#CategoryCategory").val();
        var subCatSelected = $(this).val();
        $("#sub-sub-category").html(""); 
        if(categoryList[catSelected]["children"].length > 0){
            subCategories = categoryList[catSelected]["children"];
            for(i=0; i < subCategories.length; i++){
                if(subCategories[i]["Category"]["id"] == subCatSelected && subCategories[i]["children"].length > 0){
                    addSubSubcategoryList(subCategories[i]["children"])  
                    break;  
                }
                else{
                    $("#sub-sub-category").closest("div").addClass("hide");    
                }
            }
        }        
    });
});
';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));

?>
<div class="container content inner">		
    <div class="sixteen columns text-center">
        <h1><?php echo __('New Product Type'); ?></h1>
    </div>
    <div class="sixteen columns">
        <div class="products form">
            <?php echo $this->Form->create('Product'); ?>
            <fieldset class="fifteen columns">
                <legend><?php echo __('Basic Info'); ?></legend>
                <?php
                echo $this->Form->input('brand_id');
                echo $this->Form->input('name', array('label' => 'Parent Product Name'));
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
                <div class="input select hide">
                    <label for="sub-sub-category">Sub Sub Category</label>
                    <select name="data[Category][SubSubCategory]" id="sub-sub-category"></select>
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
                Save the product type first, to add product type variants.
                <?php
                /*echo $this->Form->input('show', array('type' => 'checkbox'));
                echo "<br>";
                echo $this->Form->input('color', array('label' => 'Color', 'type' => 'select'));
                echo $this->Form->input('price');
                echo $this->Form->input('slug');
                echo $this->Form->input('sku');
                echo $this->Form->input('stock');*/
                ?>
            </fieldset>
            <!-- <fieldset class="fifteen columns properties">
                <legend><?php echo __('Properties'); ?></legend>
                To enter properties, please save the Product.
                <div class="clear"></div>
            </fieldset>
            <fieldset class="fifteen columns attachments">
                <legend><?php echo __('Images'); ?></legend>
                To enter images, please save the Product.
                <div class="clear"></div>
            </fieldset> -->
            <div class="clearfix"></div>
            <div class="text-center">
                <?php echo $this->Form->end(__('Save')); ?>
            </div>
        </div>
    </div>
</div>