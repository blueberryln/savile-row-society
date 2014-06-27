<div class="container content inner">	
    <div class="sixteen columns text-center">
        <!--<h1><?php echo $name; ?></h1>-->
        <div class="error-msg eight columns offset-by-four">
            <div class="error">
            <h1>We're Sorry</h1>
            <span>The page you have requested cannot be found.</span>
            </div>       
        </div>
    </div>
    <div class="fourteen offset-by-one columns">        
        <?php
        if (Configure::read('debug') > 0):
            echo $this->element('exception_stack_trace');
        endif;
        ?>
    </div>
</div>