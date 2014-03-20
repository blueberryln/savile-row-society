<?php
$meta_description = 'Reset your SRS password.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>
<script>
window.registerProcess = true;
</script>
<div class="content-container">
    <div class="container content inner">   
        <div class="ten columns text-center page-heading">
            <h1>Reset password</h1>
        </div>	
        <div class="eleven columns page-content text-center">
            <?php echo $this->Form->create('User'); ?>
            <div class="five columns center-block">
                <?php echo $this->Form->input('email'); ?>
            </div>
            <div class="clearfix"></div>
            <div class="text-center">
                <input type="submit" value="Reset" class="black-btn link-btn">
            </div>
            </form>
        </div>
    </div>
</div>