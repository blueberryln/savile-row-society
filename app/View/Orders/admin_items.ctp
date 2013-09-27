<div class="container content inner">
    <div class="sixteen columns text-center">
        <h1><?php echo __('Ordered Items'); ?></h1>
    </div>
    <div class="sixteen columns">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?php echo $this->Paginator->sort('id'); ?></th>
                <th><?php echo $this->Paginator->sort('brand_name'); ?></th>
                <th>Product</th>
                <th>Size</th>
                <th><?php echo $this->Paginator->sort('created'); ?></th>
            </tr>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo h($item['OrderItem']['id']); ?>&nbsp;</td>
                    <td><?php echo h($item['Brand']['name']); ?>&nbsp;</td>
                    <td><?php echo $item['Entity']['name']; ?></td>
                    <td><?php echo h($sizes[$item['OrderItem']['size_id']]); ?>&nbsp;</td>
                    <td><?php echo $this->Time->format($item['OrderItem']['created'], '%d-%m-%Y'); ?>&nbsp;</td>
                    
                </tr>
            <?php endforeach; ?>
        </table>
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