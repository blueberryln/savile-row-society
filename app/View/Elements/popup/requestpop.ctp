<script type="text/javascript">
    
$(document).ready(function(){
  $("#block-step-access").click(function(){
        var input=$("#email").val();
            $.post("api/requestinvite",
            {
              email: input
            },
       
            function(data){
                 //if(data){
              alert("Data: " + data);

           //}
        });

  });
});


</script>


<div id="request-box" class="box-modal notification-box" style="display: none;">
    <div class="box-modal-inside">
        <a class="notification-close" href=""></a>
        <div class="vip-content">
            <h5 class="sign"><img src="<?php echo $this->webroot; ?>img/logo.png"</h5> 
            <hr/ style='border: solid #AF9A59;clear: both;height: 0;border-width: 1px 0 0;margin: 8px 46px 25px;'>           
            <p>Due to high demand in our beta period, we have placed you on our waitlist and will notify you as soon as we are able to service you.</p> 
            
            <form method="post" action="api/requestinvite">
                <input type="text" class="vip-access-code" id="semail" style="width: 216px;height: 32px;margin: 0px 0px 20px 0px;" required name="data[email]" placeholder="Enter email address...">

                <?php 

                    //     $options = array(
                    //     'label' => 'Request Invite',
                    //     'class' => 'link-btn black-btn vip-access-btn'
                    //     );
                    // echo $this->Form->end($options); ?> <a href="#" class="link-btn black-btn" id="block-step-access">Request Invite</a> <!--<input type="submit" class="link-btn black-btn" value="Request Invite" id="block-step-access"  />-->
            </form> 
            <a href="" id="block-vip-access-link" >Have been referred?</a>
        </div> 
    </div>
</div>