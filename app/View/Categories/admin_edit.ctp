<?php
$script = '
var categoryList = ' . json_encode($category_list) . ';
var parentId = ' . $parent_id . ';
var parentParentId = ' . $parent_parent_id . ';

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
    var catSelected = $("#CategoryParentId").val();
    if(catSelected != "" && categoryList[catSelected]["children"].length > 0){
        addSubcategoryList(categoryList[catSelected]["children"]);
    }
    
    if(parentId && parentParentId){
        $("#CategoryParentId").val(parentParentId); 
        addSubcategoryList(categoryList[parentParentId]["children"]); 
        $("#sub-category").val(parentId);           
    }
    
    $("#CategoryParentId").on("change", function(e){
        var catSelected = $(this).val();
        if(catSelected == ""){
            $("#sub-category").closest("div").addClass("hide");   
            $("#sub-category").html("");    
        }
        else if(categoryList[catSelected]["children"].length > 0){
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
        <h1><?php echo __('Edit Category'); ?></h1>
    </div>
    <div class="sixteen columns">
        <div class="categories form">
            <?php echo $this->Form->create('Category'); ?>
            <fieldset>
                <legend><?php echo __('Basic Info'); ?></legend>
                <?php
                echo $this->Form->input('id');
                echo $this->Form->input('name');
                echo $this->Form->input('slug');
                echo $this->Form->input('order');
                echo $this->Form->input('parent_id', array('empty'=>'None'));
//                echo $this->Form->input('lft', array('label' => 'Is after...', 'type' => 'select', 'options' => $lft));
//                echo $this->Form->input('rght', array('label' => 'and before...', 'type' => 'select', 'options' => $rght));
                ?>
                <div class="input select hide">
                    <label for="sub-category">Sub Category</label>
                    <select name="data[Category][SubCategory]" id="sub-category"></select>
                </div>
            </fieldset>
            <div class="clearfix"></div>
            <div class="text-center">
                <?php echo $this->Form->end(__('Update')); ?>
            </div>
        </div>
    </div>
</div>