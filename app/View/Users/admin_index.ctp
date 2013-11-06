<?php
$script = '
$(document).ready(function(){

    $(".detail").click(function(e){
        e.preventDefault();
        var userRow = $(this).closest(".user-row").next(".user-data-row").find("div");
        if(userRow.is(":visible")){
            userRow.slideUp(300);
        }
        else{
            $(".user-data-row div").slideUp(300);
            userRow.slideDown(300);


        }
    });

});
';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
?>
<div class="container content inner">		
    <div class="sixteen columns text-center">
        <h1><?php echo __('Users'); ?></h1>
    </div>
    <div class="sixteen columns">
        <div class="users index">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th><?php echo $this->Paginator->sort('id'); ?></th>
                    <th><?php echo $this->Paginator->sort('email'); ?></th>
                    <th><?php echo $this->Paginator->sort('first_name'); ?></th>
                    <th><?php echo $this->Paginator->sort('last_name'); ?></th>
                    <th><?php echo $this->Paginator->sort('location');?></th>
                    <th><?php echo $this->Paginator->sort('zip code');?></th>
                    <th><?php echo $this->Paginator->sort('personal shopper'); ?></th>
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
                        <td><?php echo h($user['User']['personal_shopper']); ?>&nbsp;</td>
                        <td><?php echo $this->Time->timeAgoInWords($user['User']['created'], array('F jS, Y H:i')); ?>&nbsp;</td>
                        <td class="actions">
                            <a target="_blank" href="<?php echo $this->webroot; ?>messages/index/<?php echo $user['User']['id']; ?>">Chat</a>
                            <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id'])); ?>
                            <a class="detail" href="">Detail</a>
                        </td>

                    </tr>
                    <tr class="user-data-row">
                        <td colspan="9" style="border: none; padding: 0px;">
                            <div class="hide">
                                <table  style="float:left; width: 462px; border-bottom: 1px solid #cccccc">
                                    <tr>
                                        <td style="border: none;">Phone:</td>
                                        <td style="border: none;">
                                        <?php
                                            if(!isset($user['User']['phone']) || $user['User']['phone'] == ""){
                                                echo 'N/A';
                                            }
                                            else{
                                                echo h($user['User']['phone']);
                                            }
                                        ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border: none;">Social Network:</td>
                                        <td style="border: none;"><?php
                                            if(isset($user['User']['social_network']))
                                                echo h($user['User']['social_network']);
                                            else
                                                echo 'N/A'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border: none;">Social Network Id:</td>
                                        <td style="border: none;"><?php
                                            if(isset($user['User']['social_network_id']))
                                                echo h($user['User']['social_network_id']);
                                            else
                                                echo 'N/A'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border: none;">Title:</td>
                                        <td style="border: none;"><?php
                                            if(isset($user['User']['title']))
                                                echo h($user['User']['title']);
                                            else
                                                echo 'N/A'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border: none;">Friend Email:</td>
                                        <td style="border: none;"><?php
                                            if(isset($user['User']['friend_email']))
                                                echo h($user['User']['friend_email']);
                                            else
                                                echo 'N/A'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border: none;">Last Updated:</td>
                                        <td style="border: none;"><?php
                                            if(isset($user['User']['updated']))
                                                echo $this->Time->timeAgoInWords($user['User']['updated'], array('F jS, Y H:i'));
                                            else
                                                echo 'N/A'; ?>
                                        </td>
                                    </tr>

                                </table>
                                <table  style="float:right; width: 462px;border-bottom: 1px solid #cccccc;border-left: 1px solid #cccccc">
                                    <tr>
                                        <td style="border: none;">Birth Date:</td>
                                        <td style="border: none;"><?php
                                            if(isset($user['User']['birthdate']))
                                                echo date('d-M-Y', strtotime($user['User']['birthdate']));
                                            else
                                                echo 'N/A'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border: none;">Industry:</td>
                                        <td style="border: none;"><?php
                                            if(isset($user['User']['industry']))
                                                echo h($user['User']['industry']);
                                            else
                                                echo 'N/A'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border: none;">Refer Medium:</td>
                                        <td style="border: none;"><?php
                                            if(isset($user['User']['refer_medium']))
                                                echo h($user['User']['refer_medium']);
                                            else
                                                echo 'N/A'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border: none;">Heard From:</td>
                                        <td style="border: none;"><?php 
                                            if(isset($user['User']['heard_from']))
                                                echo h($user['User']['heard_from']);
                                            else
                                                echo 'N/A'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border: none;">Active:</td>
                                        <td style="border: none;"><?php
                                            if(isset($user['User']['active']))
                                                echo h($user['User']['active']);
                                            else
                                                echo 'N/A'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border: none;">Stylist:</td>
                                        <td style="border: none;"><?php 
                                        if(isset($user['User']['stylist_id'])){
                                            echo $stylists[$user['User']['stylist_id']];
                                        }
                                        else{
                                            echo "Not assigned";
                                        }
                                        ?>
                                        </td>
                                    </tr>

                                </table>




                            </div>
                        </td>
                    </tr>
                <?php   endforeach; ?>
            </table>

        </div>
    </div>
    <div class="sixteen columns text-center">
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
</div>

