<?php
$script = '
    $(function() {
        $(".btn-user-search").on("click", function(e){
            e.preventDefault();
            var userId = $( "#userId" ).val();
            var userName = $( "#userName" ).val();
            var userEmail = $("#userEmail").val();
            if(userId == "" && userName == "" && userEmail == ""){
                return false;
            }
            userId = (userId=="") ? "null" : userId;
            userName = (userName=="") ? "null" : userName;
            userEmail = (userEmail=="") ? "null" : userEmail;

            window.location = "' . $this->webroot . 'admin/users/search/" + userId + "/" + userName + "/" + userEmail;
        });
    });
    ';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
?>

<div class="container content inner">		
    <div class="sixteen columns text-center">
        <h1><?php echo __('Users'); ?></h1>
    </div>
    <div class="sixteen columns text-center order-filter">
        <ul class="ordered-items">
            <li>
                <label for="startDate">User id:</label>
                <input name="user-id" id="userId" type="text" style="width: 150px;" value="<?php echo $user_id; ?>">
            </li>
            <li>
                <label for="startDate">Name (First/Last name):</label>
                <input name="user-name" id="userName" type="text" style="width: 150px;" value="<?php echo $user_name; ?>">
            </li>
            <li>
                <label for="startDate">Email:</label>
                <input name="usere-email" id="userEmail" type="text" style="width: 150px;" value="<?php echo $email; ?>">
            </li>       
        </ul>
        <a href="" class="btn-user-search link-btn black-btn">Search</a>
        <br><br>
    </div>
    <div class="sixteen columns">
        <div class="users index">
            <?php if($users) : ?>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th><?php echo $this->Paginator->sort('id'); ?></th>
                    <th><?php echo $this->Paginator->sort('email'); ?></th>
                    <th><?php echo $this->Paginator->sort('first_name'); ?></th>
                    <th><?php echo $this->Paginator->sort('last_name'); ?></th>
                    <th><?php echo $this->Paginator->sort('location');?></th>
                    <th><?php echo $this->Paginator->sort('zip');?></th>
                    <th><?php echo $this->Paginator->sort('created'); ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
                <?php foreach ($users as $user): ?>
                    <tr class="user-row">
                        <td><?php echo h($user['User']['id']); ?>&nbsp;</td>
                        <td><?php echo h($user['User']['email']); ?>&nbsp;</td>
                        <td><?php echo h($user['User']['first_name']); ?>&nbsp;</td>
                        <td><?php echo h($user['User']['last_name']); ?>&nbsp;</td>
                        <td><?php echo h($user['User']['location']); ?>&nbsp;</td>
                        <td><?php echo h($user['User']['zip']); ?>&nbsp;</td>
                        <td><?php echo $this->Time->timeAgoInWords($user['User']['created'], array('F jS, Y H:i')); ?>&nbsp;</td>
                        <td class="actions">
                            <a target="_blank" href="<?php echo $this->webroot; ?>messages/index/<?php echo $user['User']['id']; ?>">Chat</a>
                            <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id'])); ?>
                            <a class="detail" href="">Detail</a>
                        </td>
                    </tr>
                <?php   endforeach; ?>
            </table>
            <?php else : ?>
                <p style="text-align: center;">No users found.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php if($users) : ?>
    <div class="sixteen columns text-center">
        <br />
        <p>
            <?php
            echo $this->Paginator->counter(array(
                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
            ));
            ?>	</p>
        <div class="paging">
            <?php
            echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
            echo $this->Paginator->numbers(array('separator' => ''));
            echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
            ?>
        </div>
    </div>
    <?php endif; ?>
</div>