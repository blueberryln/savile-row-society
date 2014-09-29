<div class="container content inner">       
    <div class="sixteen columns text-center">
        <h1><?php echo __('Stylist'); ?></h1>
    </div>
    <div class="sixteen columns">
        <div class="users index">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th>id</th>
                    <th>first_name</th>
                    <th>order_id</th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
                 <?php echo $this->Form->create('edit_topstylist'); ?>
                    <tr class="user-row">
                    <?php 
                        echo $this->Form->input('TopStylist.id', array('type' => 'hidden'));
                        echo $this->Form->input('TopStylist.user_id', array('type' => 'hidden'));
                    ?>
                        <td>
                        <?php echo $stylist['User']['id']; ?>&nbsp;</td>
                        <td><?php echo $stylist['User']['first_name'].'&nbsp;'.$stylist['User']['last_name'];; ?>&nbsp;</td>
                        <td><input type="text" name="data[TopStylist][order_id]" value="<?php echo $this->request->data['TopStylist']['order_id']; ?>"></td> 
                        <td class="actions">

                           <?php echo $this->Form->end('Submit'); ?>
                            
                        </td>

                    </tr>
                            </div>
                        </td>
                    </tr>
                <?php   //endforeach; ?>
            </table>

        </div>
    </div>
    
</div>

