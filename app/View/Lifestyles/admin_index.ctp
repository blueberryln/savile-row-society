<div class="container content inner">		
    <div class="sixteen columns text-center">
        <h1><?php echo __('Lifestyles'); ?></h1>
    </div>
    <div class="sixteen columns text-center">
        <?php
            echo $this->Html->link('Add new Lifestyle', array('action' => 'add'), array('class' => 'link-btn black-btn'));
        ?>
    </div>
    <div class="sixteen columns">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?php echo $this->Paginator->sort('id'); ?></th>
                <th>Lifestyle Image</th>
                <th><?php echo $this->Paginator->sort('name'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php foreach ($lifestyles as $lifestyle): ?>
                <tr>
                    <td width="30"><?php echo h($lifestyle['Lifestyle']['id']); ?>&nbsp;</td>
                    <td width="200"><img src="<?php echo $this->webroot; ?>files/lifestyles/<?php echo $lifestyle['Lifestyle']['image']; ?>" style="max-height:200px; max-width: 200px;" /></td>
                    <td><?php echo h(ucfirst($lifestyle['Lifestyle']['name'])); ?>&nbsp;</td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $lifestyle['Lifestyle']['id'])); ?>
                        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $lifestyle['Lifestyle']['id']), null, __('Are you sure you want to delete # %s?', $lifestyle['Lifestyle']['name'])); ?>
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