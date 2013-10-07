<div class="container content inner">	
    <div class="sixteen columns text-center">
        <!--<h1><?php echo $name; ?></h1>-->
        <div class="error">
            <div class="error-msg six columns">
            <h1><strong>404 <span>Error</span></strong></h1>
            <span>Oops!The page you're looking for cannot be found.</span>
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