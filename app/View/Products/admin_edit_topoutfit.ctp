<div class="container content inner">       
    <div class="sixteen columns text-center">
        <h1><?php echo __('TopOutfit'); ?></h1>
    </div>
    <div class="sixteen columns">
        <div class="users index">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th>id</th>
                    <th>OutfitName</th>
                    <th>order_id</th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
                 <?php echo $this->Form->create('edit_topoutfit'); ?>
                    <tr class="user-row">
                    <?php 
                        echo $this->Form->input('TopOutfit.id', array('type' => 'hidden'));
                        echo $this->Form->input('TopOutfit.outfit_id', array('type' => 'hidden'));
                    ?>
                        <td>
                        <?php echo $outfit['Outfit']['id']; ?>&nbsp;</td>
                        <td><?php echo $outfit['Outfit']['outfit_name']; ?>&nbsp;</td>
                        <td><input type="text" name="data[TopOutfit][order_id]" value="<?php echo $this->request->data['TopOutfit']['order_id']; ?>"></td> 
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

