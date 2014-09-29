<?php
$script = '
$(document).ready(function(){

    $("#ColorCode").ColorPicker({
	onSubmit: function(hsb, hex, rgb, el) {
        $(el).val("#"+hex);
        $(el).ColorPickerHide();
    },
    onChange: function(hsb, hex, rgb) {
        $("#ColorCode").val("#"+hex);
    },
	onBeforeShow: function () {
    $("#ColorCode").ColorPickerSetColor(this.value);
}
})
.bind("keyup", function(){
    $("#ColorCode").ColorPickerSetColor(this.value);
});

$("#ColorCode").on("focus", function(e){
    $("#ColorCode").click();        
});



});
';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->script('color/colorpicker.js', array('inline' => false));
echo $this->Html->css('/css/color/colorpicker',null,array('inline' => false));

?>

<div class="container content inner">
    <div class="sixteen columns text-center">
        <h1><?php echo __('New Color'); ?></h1>
    </div>
    <div class="sixteen columns">
        <div class="colors form">
            <?php echo $this->Form->create('Color'); ?>
            <fieldset class="fifteen columns product-color">
                <legend><?php echo __('Color Groups'); ?></legend>
                <?php
                echo $this->Form->input('Colorgroup', array('label' => '', 'multiple' => 'checkbox'));
                ?>
            </fieldset>
            <fieldset>
                <legend><?php echo __('Basic Info'); ?></legend>
                <?php
                echo $this->Form->input('name');
                echo $this->Form->input('code', array('autocomplete' => 'off'));
                ?>
            </fieldset>
            <div class="clearfix"></div>
            <div class="text-center">
                <?php echo $this->Form->end(__('Save')); ?>
            </div>
        </div>
    </div>
</div>