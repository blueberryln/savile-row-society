<div class="container content inner">       
    <div class="sixteen columns text-center">
        <h1><?php echo __('HighLighted Outfits'); ?></h1>
    </div>
    

    <div class="sixteen columns">
        <div class="users index">
            <?php echo $this->Form->create("TopOutfit"); ?>
                <table cellpadding="0" cellspacing="0" width=>
                    <tr>
                        <td>
                            Outfits<br>
                            <select name="data[TopOutfit][outfit_id]" required>
                               <option value="">Select Outfit</option>
                               <?php  foreach ($outfits as  $value) { ?>
                                   <option value="<?php echo $value['Outfit']['id']; ?>"><?php echo $value['Outfit']['outfit_name']; ?></option>
                               <?php } ?>
                            </select>
                        </td>
                        <td>
                            Order Number:<br>
                            <input type="text" name="data[TopOutfit][order_id]" required>
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
                 foreach ($topoutfits as  $outfitDetail ): ?>
                 
                    <tr class="user-row">
                        <td><?php echo $outfitDetail['TopOutfit']['id']; ?>&nbsp;</td>
                        <td><?php echo $outfitDetail['Outfit']['outfit_name']; ?></td>
                        <td><?php echo $outfitDetail['TopOutfit']['order_id']; ?>&nbsp;</td>
                        <td class="actions">
                            <?php
                                $highlighted_id = $outfitDetail['TopOutfit']['id'];
                                echo $this->Html->link(__('Edit'), array('action' => 'edit_topoutfit', $highlighted_id)); 
                            ?>
                            <?php 
                                echo $this->Form->postLink(__('Delete'), array('action' => 'delete_topoutfit', $outfitDetail['TopOutfit']['id']), null, 'Are you sure you want to delete the outfit?'); 
                            ?>
                        </td>

                    </tr>
                <?php  endforeach; ?>
            </table>

        </div>
    </div>
</div>

