<div class="container content inner">		
    <div class="sixteen columns text-center">
        <h1><?php echo __('New Users'); ?></h1>
    </div>
    <div class="sixteen columns">
        <div class="users index">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th><?php echo $this->Paginator->sort('id'); ?></th>
                    <th><?php echo $this->Paginator->sort('email'); ?></th>
                    <th><?php echo $this->Paginator->sort('full_name'); ?></th>
                    <th>Style Profile</th>
                    <th><?php echo $this->Paginator->sort('zip'); ?></th>
                    <th><?php echo $this->Paginator->sort('created'); ?></th>
                    <th><?php echo __('Actions'); ?></th>
                </tr>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo h($user['User']['id']); ?>&nbsp;</td>
                        <td><?php echo h($user['User']['email']); ?>&nbsp;</td>
                        <td><?php echo h($user['User']['full_name']); ?>&nbsp;</td>
                        <td>
                            <?php
                                $preference = unserialize($user['User']['preferences']);
                                if(!isset($preference['UserPreference']['is_complete'])|| $user['User']['industry']==""){
                                    echo 'Incomplete';
                                }
                                else{
                                    echo 'Complete';
                                }
                            ?>
                        </td>
                        <?php if($user['User']['zip']) : ?>
                            <td><?php echo h($user['User']['zip']); ?>&nbsp;</td>
                        <?php else : ?>
                            <td>Not Available</td>
                        <?php endif; ?>
                        <td><?php echo $this->Time->timeAgoInWords($user['User']['created'], array('F jS, Y H:i')); ?>&nbsp;</td>
                        <td>
                            <?php echo $this->Html->link(__('Assign Stylist'), array('action' => 'assign_stylist', $user['User']['id'])); ?><br />
                            <?php if($user['User']['preferences']) : ?>
                                <a target="_blank" href="<?php echo $this->webroot; ?>users/register/style/<?php echo $user['User']['id']; ?>">View Style Profile</a>
                            <?php else : ?>
                                <span>View Style Profile</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
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