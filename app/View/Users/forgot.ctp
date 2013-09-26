<?php
$meta_description = 'Reset your SRS password.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>
<script>
window.registerProcess = true;
</script>
<div class="container content inner">	
    <div class="sixteen columns text-center">
        <h1>Reset password</h1>
    </div>
    <div class="sixteen columns">
        <?php echo $this->Form->create('User'); ?>
        <div class="five columns offset-by-five">
            <?php echo $this->Form->input('email'); ?>
        </div>
        <div class="clearfix"></div>
        <div class="text-center">
            <?php echo $this->Form->end(__('Reset')); ?>
        </div>
    </div>
</div>