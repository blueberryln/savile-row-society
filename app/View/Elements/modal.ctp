<div class="alert alert-<?php echo $class; ?>">
    <?php if ($class == 'error') : ?>
        <h3 class="alert-heading"><?php echo $title; ?></h3>
    <?php elseif ($class == 'success') : ?>
        <h3 class="alert-heading"><?php echo $title; ?></h3>
    <?php elseif ($class == 'info') : ?>
        <h3 class="alert-heading"><?php echo $title; ?></h3>
    <?php endif; ?>
    <?php echo $message; ?>
</div>
<div id="overlay"></div>