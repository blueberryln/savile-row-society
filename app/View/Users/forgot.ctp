<?php
$meta_description = 'Reset your SRS password.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>
<script>
window.registerProcess = true;
</script>
<div id="topmost" class="content-container content-container-privacy">
    <div class="eleven columns container content inner">
        <div class="twelve columns container left message-box">
            <div class="blank-space">&nbsp;</div>
            <div class="eleven columns container aboutus">
                <div class="ten columns text-center page-heading">
                    <h1>Reset Password</h1>
                </div>
                <div class="seven columns page-content aboutus-content">
                <?php echo $this->Form->create('User'); ?>
                    <div class="five columns center-block text-center">
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
</div>