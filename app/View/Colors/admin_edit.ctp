<?php
$script = '
$(document).ready(function(){

    $("#ColorCode").ColorPicker({
	onSubmit: function(hsb, hex, rgb, el) {
    $(el).val("#"+hex);
    $(el).ColorPickerHide();
},
	onBeforeShow: function () {
    $("#ColorCode").ColorPickerSetColor("#"+this.value);
}
})
.bind("keyup", function(){
    $("#ColorCode").ColorPickerSetColor("#"+this.value);
});



});
';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->script('color/colorpicker.js', array('inline' => false));
echo $this->Html->css('/css/color/colorpicker',null,array('inline' => false));

?>
<div class="container content inner">
    <div class="sixteen columns text-center">
        <h1><?php echo __('Edit Color'); ?></h1>
    </div>
    <div class="sixteen columns">
        <div class="colors form">
            <?php echo $this->Form->create('Color'); ?>
            <fieldset>
                <legend><?php echo __('Basic Info'); ?></legend>
                <?php
                echo $this->Form->input('id');
                echo $this->Form->input('name');
                echo $this->Form->input('code');
                ?>
            </fieldset>
            <div class="clearfix"></div>
            <div class="text-center">
                <?php echo $this->Form->end(__('Update')); ?>
            </div>
        </div>
    </div>
</div>