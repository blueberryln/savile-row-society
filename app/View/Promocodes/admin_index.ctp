<div class="container content inner">		
    <div class="sixteen columns text-center">
        <h1><?php echo __('Promocodes'); ?></h1>
    </div>
    <div class="sixteen columns text-center">
        <?php
            echo $this->Html->link('Add new Promocode', array('action' => 'add'), array('class' => 'link-btn black-btn'));
        ?>
    </div>
    <div class="sixteen columns">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?php echo $this->Paginator->sort('id'); ?></th>
                <th>Name</th>
                <th><?php echo $this->Paginator->sort('promo_code'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php foreach ($promocodes as $promocode): ?>
                <tr>
                    <td width="30"><?php echo h($promocode['Promocode']['id']); ?>&nbsp;</td>
                    <td><?php echo h(ucfirst($promocode['Promocode']['name'])); ?>&nbsp;</td>
                    <td><?php echo h($promocode['Promocode']['code']); ?>&nbsp;</td>
                    <td class="actions">
                            
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