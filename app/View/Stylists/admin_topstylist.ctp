<div class="container content inner">       
    <div class="sixteen columns text-center">
        <h1><?php echo __('HighLighted Stylists'); ?></h1>
    </div>
    

    <div class="sixteen columns">
        <div class="users index">
            <?php echo $this->Form->create('TopStylist'); ?>
                <table cellpadding="0" cellspacing="0" width=>
                    <tr>
                        <td>
                            Stylists<br>
                            <select name="data[TopStylist][user_id]" required>
                               <option value="">Select Stylist</option>
                               <?php  foreach ($stylists as  $value) { ?>
                                   <option value="<?php echo $value['User']['id']; ?>"><?php echo $value['User']['first_name']; ?></option>
                               <?php } ?>
                            </select>
                        </td>
                        <td>
                            Order Number:<br>
                            <input type="text" name="data[TopStylist][order_id]" required>
                        </td>
                        <td>
                            <?php echo $this->Form->end('ADD'); ?>
                        </td>
                    </tr>
                </table>
            </form>

            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Order</th>
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
                                echo $this->Html->link(__('Edit'), array('action' => 'edit_topstylist', $highlighted_id)); 
                            ?>
                            <?php 
                                echo $this->Form->postLink(__('Delete'), array('action' => 'delete_topstylist', $highlighted_id), null, 'Are you sure you want to delete the stylist?'); 
                            ?>
                        </td>

                    </tr>
                <?php  endforeach; ?>
            </table>

        </div>
    </div>
</div>

