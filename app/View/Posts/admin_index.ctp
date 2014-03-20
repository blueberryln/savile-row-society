<div class="row">
    <h2 class="span9"><?php echo __('Posts'); ?></h2>
    <div class="span3 text-right">
        <?php echo $this->Html->link(__('Add New Post'), array('action' => 'add'), array('class' => 'btn')); ?>
    </div>
</div>
<div class="row">
    <div class="span12">
        <table class="table">
            <tr>
                <th><?php echo $this->Paginator->sort('id'); ?></th>
                <th><?php echo $this->Paginator->sort('user_id'); ?></th>
                <th><?php echo $this->Paginator->sort('category_id'); ?></th>
                <th><?php echo $this->Paginator->sort('title'); ?></th>
                <th><?php echo $this->Paginator->sort('slug'); ?></th>
                <th><?php echo $this->Paginator->sort('date'); ?></th>
                <th><?php echo $this->Paginator->sort('pubished'); ?></th>
                <th><?php echo $this->Paginator->sort('created'); ?></th>
                <th><?php echo $this->Paginator->sort('updated'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php foreach ($posts as $post): ?>
                <tr>
                    <td><?php echo h($post['Post']['id']); ?></td>
                    <td>
                        <?php echo $this->Html->link($post['User']['email'], array('controller' => 'users', 'action' => 'view', $post['User']['id'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($post['Category']['name'], array('controller' => 'categories', 'action' => 'view', $post['Category']['id'])); ?>
                    </td>
                    <td><?php echo h($post['Post']['title']); ?></td>
                    <td><?php echo h($post['Post']['slug']); ?></td>
                    <td><?php echo $this->Time->format('F jS, Y', $post['Post']['date']); ?></td>
                    <td><?php echo h($post['Post']['pubished']); ?></td>
                    <td><?php echo $this->Time->format('F jS, Y H:i', $post['Post']['created']); ?></td>
                    <td><?php echo $this->Time->format('F jS, Y H:i', $post['Post']['updated']); ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('View'), array('action' => 'view', $post['Post']['id'])); ?>
                        <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $post['Post']['id'])); ?>
                        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $post['Post']['id']), null, __('Are you sure you want to delete # %s?', $post['Post']['id'])); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
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