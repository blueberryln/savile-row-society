<div id="forgot-flash-box" class="hide box-modal">
     <div class="box-modal-inside">
        <a class="notification-close" href=""></a>
        <div class="signin-content"> 
            <h5 class="sign">SIGN IN</h5>            
            <div>
                <?php echo $message; ?>
            </div>
            <br>
            <?php $results_inactive = $this->Session->read('results_inactive'); 
            if(isset($results_inactive)){
                unset($_SESSION['results_inactive']); ?>
                <div class="email_cnf_msg"></div>
                <button class="cnf_email_btn btn_chat_now">Send Activation Email</button>

            <?php } else { ?>
            <p class="text-center center-block"><span class="forget-passwrd"><a href="<?php echo $this->request->webroot; ?>forgot" style="float:none;">Forgot your password?</a></span> </p>
            <?php } ?>
            <br>
        </div> 
    </div>
</div>

<script>
    $(document).on('click','.cnf_email_btn', function(){
        $(this).attr('disabled',true);
        var results_inactive ='<?php echo json_encode($results_inactive); ?>';
        var message = ['<p>Some problem occured. Try again later.</p>','<p>Email sent successfully. Please check your email inbox.</p>'];
        if(results_inactive){
            $.ajax({
                type : 'post',
                url : '/users/send_activation_email',
                data : {data : results_inactive},
                'success' : function(response){
                    $('.email_cnf_msg').html(message[response]);
                    $('.cnf_email_btn').removeAttr('disabled');
                }
            })
        }
    });

</script>