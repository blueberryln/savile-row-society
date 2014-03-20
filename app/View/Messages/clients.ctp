<?php
$script = ' 
var uid = ' . $user_id . ';
var webroot = "' . $this->webroot . '";
';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
?>
<div class="content-container">
    <div class="container content inner timeline">	
            <div class="user-container">
                <?php if(!$is_admin) : ?>
                    <br />
                    <h5 class="new-clients-head">New Clients</h5>
                    <div class="new-clients">
                    <?php if(isset($new_clients) && count($new_clients) > 0) {
                        foreach($new_clients as $new_cl){
                            echo '<div class="client-row">' . 
                                '<a href="' . $this->webroot . 'messages/index/' . $new_cl['User']['id'] . '">' . $new_cl['User']['first_name'] . '</a> has been assigned to you.' . 
                            '</div>';    
                        }    
                    }
                    ?>
                    </div>
                <?php endif; ?>
            </div>            
            <div class="stylist-talk">
                <h4 class='nine columns talk-to'>TALK WITH YOUR CLIENT</h4>
                <?php if(!$is_admin) : ?>
                    <?php
                    echo $this->Form->input('user_to_id', array('label' => '', 'type' => 'select', 'options' => $clients, 'name' => 'data[Message][user_to_id]', 'empty' => "Select Client", 'class' => 'select_client'));
                    ?>          
                <?php endif; ?>    
                
                <h4 class='talk-to'>MESSAGE NOTIFICATIONS</h4>
                <?php if($notification_data && count($notification_data) > 0) : ?> 
                    <table class="stylist-notification-table">
                        <?php foreach($notification_data as $notification) : ?>
                        <tr>
                            <td>
                                <a href="<?php echo $this->webroot; ?>messages/index/<?php echo $notification['User']['id']; ?>"><b><?php echo ucwords($notification['User']['full_name']); ?></b> has sent you <?php echo $notification[0]['unread_count']; ?> new message(s).</a>
                            </td>
                        </tr>    
                        <?php endforeach; ?>
                    </table>
                <?php else : ?>
                    <table class="stylist-notification-table">
                        <tr>
                            <td>
                                <a class="text-center">No new message(s).</a>
                            </td>
                        </tr>    
                    </table>
                <?php endif; ?>
            </div>   
            <div class="clear-fix"></div>
    </div>
</div>
<script>
    window.onload = function() {
        
        function loadNewClients(){
            var clientBox = $(".new-clients");
            var clientString = clientArray.join(',');
            $.ajax({
               url: '<?php echo $this->webroot; ?>api/getNewClients',
               type: 'POST',
               data: {
                'clientString': clientString, 
               },
               success: function(data){
                    var ret = $.parseJSON(data);
                    if(ret['status'] == 'ok'){
                        for(i=0; i<ret['clients'].length; i++){
                            html =  '<div class="client-row">' + 
                                        '<a href="<?php echo $this->webroot; ?>messages/index/' + ret['clients'][i]['User']['id'] + '">' + ret['clients'][i]['User']['first_name'] + '</a> has been assigned to you.' + 
                                    '</div>';   
                                    
                            clientBox.prepend(html); 
                            clientArray.push(ret['clients'][i]['User']['id']);
                        }    
                    }
               } 
            });
        }
        
        $("#user_to_id").change(function(e) {
            e.preventDefault();
            userId =  $("#user_to_id").val();
            window.location = webroot + "messages/index/" + userId;
        })
    }
    

</script>


