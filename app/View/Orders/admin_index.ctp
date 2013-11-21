<?php
$script = '
    $(document).ready(function(){
        $(".print-order").on("click", function(e){
            e.preventDefault();
            var href = $(this).attr("href");
            
            window.open(
              href, 
              "facebook-share-dialog", 
              "width=" + $(window).width() + ",height=" + $(window).height()); 
        });
    });
';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
?>
<div class="container content inner">
    <div class="sixteen columns text-center">
        <h1><?php echo __('Orders'); ?></h1>
    </div>
    <div class="sixteen columns">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?php echo $this->Paginator->sort('id'); ?></th>
                <th>User</th>
                <th>Products</th>
                <th><?php echo $this->Paginator->sort('total_price'); ?></th>
                <th><?php echo $this->Paginator->sort('created'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo h($order['Order']['id']); ?>&nbsp;</td>
                    <td><?php echo h($order['User']['full_name']); ?>&nbsp;</td>
                    <td>
                        <?php foreach($order['OrderItem'] as $item) : ?>
                             - <?php echo $item['Entity']['name']; ?><br>
                        <?php endforeach; ?>
                    </td>
                    <td><?php echo h($order['Order']['total_price']); ?>&nbsp;</td>
                    <td><?php echo $this->Time->format($order['Order']['created'], '%d-%m-%Y'); ?>&nbsp;</td>
                    <td class="actions">
                        <?php if($order['Order']['shipped'] == 1) : ?>
                            Shipped.
                        <?php else : ?>
                            <?php echo $this->Html->link(__('Mark Shipped'), array('action' => 'shipped', $order['Order']['id']), null, __('Are you sure you want to mark the order shipped?')); ?>
                        <?php endif; ?>
                        <a href="<?php echo $this->webroot;?>admin/orders/download/<?php echo $order['Order']['id'];?>" class="print-order">Print Order Pdf </a> <?php echo isset($this->value); ?>
                    </td>
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