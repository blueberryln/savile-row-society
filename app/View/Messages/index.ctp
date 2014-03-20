<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
// ref1: generate java script objects - serialize data from server into json (see ref1 in MessageControler.php
// this code is changedto use timer to load data
// $script = ' var notReadedMessages = ' . json_encode($not_readed_messages) . '; ';
// include generated java script block
// $this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->script('http://knockoutjs.com/downloads/knockout-2.3.0.js', array('inline' => false));
?>
<div class="container content inner timeline">	

    <div class="sixteen columns">

        <?php
        if (!$is_stylist) {
            echo '<div class=" five columns stylist-img">';
            echo '<img class=" " src="' . $this->request->webroot . 'img/messages-casey.png" alt="Casey Golden" />';

            // echo '<img class="three columns " src="' .  $this->request->webroot  . 'img/blogger-05.2.jpg" alt="Casey Golden" />';
            echo '</div>';

            // echo '<div class=" eight columns send-to-stylist">';
            // echo $this->Form->create('Message', array('url' => '/messages/user/send_message_to_stylist')); 
            // echo $this->Form->textarea('Message.body', array( "label"=>"", "placeholder" => "Send question to stylist")); 
            // echo '<input type="button" id="send_message" value="Send message" class="btn-submit"/>';
            // echo '</div>';
        }
        ?>

        <!--
        <div class="eight columns aplha not-readed-messages default-message-box">
            <div class=" eight columns aplha message ">
        <?php
        if ($is_stylist) {
            echo '<div class="one columns message profile-img">';
            echo '<img class="" src="#" data-bind="attr: {src: \'' . $this->webroot . '/files/users/\' +  UserFrom.profile_photo_url}"/> ';
            echo '</div>';
        }
        ?>
                <div class="six columns message m-content">
                    <b class='user-name' data-bind="text: UserFrom.first_name"></b>&nbsp;<b class='user-name' data-bind="text: UserFrom.last_name"></b>
                    <p class='body' data-bind="html: Message.body"></p>
                </div>
                <div class="seven columns txt-ans">
        <?php
        echo $this->Form->textarea('Message.body', array("label" => "", "placeholder" => "Enter your message"));
        ?>
                    <input type="button"  value="Reply" class="reply-message" data-bind="attr:{ 'data-id' : Message.id , 'data-from' : Message.user_from_id , 'data-to' : Message.user_to_id}"/>
                </div>
            </div>
            
        </div>
        -->

        <div class="eight columns aplha " data-bind="foreach: NotReaded">
            <?php
            if (!$is_stylist) {
                echo'<h4>TALK TO YOUR STYLIST</h4>';
            }
            ?>
            <div class=" eight columns aplha message ">
                <?php
                if ($is_stylist) {
                    echo '<div class="two columns message profile-img">';
                    echo '<img class="" src="#" data-bind="attr: {src: \'' . $this->webroot . '/img/users/\' +  UserFrom.profile_photo_url}"/> ';
                    echo '</div>';
                }
                ?>
                <div class="six columns message m-content">
                    <b class='user-name' data-bind="text: UserFrom.first_name"></b>&nbsp;<b class='user-name' data-bind="text: UserFrom.last_name"></b>
                    <p class='body' data-bind="html: Message.body"></p>
                </div>
                <div class="seven columns txt-ans">
                    <?php
                    echo $this->Form->textarea('Message.body', array("label" => "", "placeholder" => "Enter your message"));
                    ?>
                    <input type="button"  value="Reply" class="reply-message" data-bind="attr:{ 'data-id' : Message.id , 'data-from' : Message.user_from_id , 'data-to' : Message.user_to_id}"/>
                </div>
            </div>

        </div>
    </div>


</div>

<script>
    window.onload = function() {
        // prepare data for ui binding. 
        // notReadedMessages is object from server serialized into  json format (see ref1)
        var messages = null;
        function loadMessages() {
            $.ajax({
                url: "<?php echo $this->webroot; ?>messages/getNotReadedMessages"
                        //, data: _data
                        , success: function(res) {
                    res = jQuery.parseJSON(res);
                    messages = {NotReaded: res};
                    ko.applyBindings(messages);
                    attachEvents();
                }
                , error: function(res) {
                    alert(res);
                }
            })
        }

        function startTimer() {
            loadMessages();
            // var timer = setInterval(function(){loadMessages();}, 1000); 
        }
        startTimer();
        //var messages = { NotReaded: notReadedMessages};
        //ko.applyBindings(messages);
        function attachEvents() {
            // event handler for reply message button
            $(".reply-message").click(function() {
                // get message attributes

                var fromUserId = $(this).data("from");
                var toUserId = $(this).data("to");
                var messageId = $(this).data("id");
                // find html element with txt value for message (it is button(this) neighbor element)
                // and extract value (message text)
                var message = $($(this).siblings("#MessageBody")).val();
                //create data object for ajax message
                var _data = {
                    body: message
                            , user_to_id: fromUserId
                            , user_from_id: toUserId
                            , reply_to_id: messageId
                }
                // send ajax message to reply on message
                $.ajax({
                    url: "<?php echo $this->webroot; ?>messages/reply"
                            , type: 'POST'
                            //, dataType : 'json'
                            , data: _data
                            , success: function(res) {

                    }
                    , error: function(res) {
                        alert("error");
                    }
                }).done(function(res) {
                    //alert(res);
                })
            });
            // send message to stylist
            /*
             $("#send_message").click(function(){
             $.ajax({
             url:"<?php echo $this->webroot; ?>messages/send_message_to_stylist"
             , type:'POST'
             //, dataType : 'json'
             , data: { Message: $("#MessageBody").val()}
             ,success:function(res){
             alert(res);
             }
             ,error:function(res){
             alert("error");
             }
             }).done(function(res){
             //alert(res);
             })
             //alert('a');
             }) */
        }
    }
</script>