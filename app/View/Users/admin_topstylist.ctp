<div class="container content inner">       
    <div class="sixteen columns text-center">
        <h1><?php echo __('HighLighted Stylists'); ?></h1>
    </div>
    

    <div class="sixteen columns">
        <div class="users index">
            <table cellpadding="0" cellspacing="0">
                
                <tr>
                	<th>STYLIST LIST</th>
                	<th>
                    	<?php echo $this->Form->create('TopStylist'); ?>
                    	<select name="data[TopStylist][user_id]" required>
                    	   <option value="">Select Stylist</option>
                    	   <?php  foreach ($stylists as  $value) { ?>
                    	       <option value="<?php echo $value['User']['id']; ?>"><?php echo $value['User']['first_name']; ?></option>
                    	   <?php } ?>
                    	</select>
                	</th>
                	<th> Order Number: <input type="text" name="data[TopStylist][order_id]" required> </th> 
                	<th><?php echo $this->Form->end('ADD HIGHLIGHTED'); ?></th>
                </tr>
                
                <tr>
                    <th><?php echo $this->Paginator->sort('id'); ?></th>
                    <th><?php echo $this->Paginator->sort('first_name'); ?></th>
                    <th><?php echo $this->Paginator->sort('order_id'); ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>

                <?php
                foreach ($topStylists as  $stylist ): ?>
                 
                    <tr class="user-row">
                        <td><?php echo $stylist['User']['id']; ?>&nbsp;</td>
                        <td><?php echo $stylist['User']['first_name'].'&nbsp;'.$stylist['User']['last_name'];; ?>&nbsp;</td>
                        <td><?php echo $stylist['TopStylist']['order_id']; ?>&nbsp;</td>
                        <td class="actions">
                            <?php
                                $highlighted_id = $stylist['TopStylist']['id'];
                                echo $this->Html->link(__('Edit'), array('action' => 'editTopStylist', $highlighted_id)); 
                            ?>
                        </td>

                    </tr>
                <?php  endforeach; ?>
            </table>
        </div>
    </div>
</div>

