<div class="container content inner">	
    <div class="sixteen columns text-center">
        <h1><?php echo $name; ?></h1>
    </div>
    <div class="fourteen offset-by-one columns">
        <p class="error">
            <strong><?php echo __d('cake', 'Error'); ?>: </strong>
            <?php echo __d('cake', 'An Internal Error Has Occurred.'); ?>
        </p>
        <?php
        if (Configure::read('debug') > 0):
            echo $this->element('exception_stack_trace');
        endif;
        ?>
    </div>
</div>