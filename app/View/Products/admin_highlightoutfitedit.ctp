
<div class="container content inner">       
    <div class="sixteen columns text-center">
        <h1><?php echo __('Outfits'); ?></h1>
    </div>
    <div class="sixteen columns">
        <div class="users index">
            <table cellpadding="0" cellspacing="0">
                
                
                
                <tr>
                    <th>id</th>
                    <th>Outfit Name</th>
                    <th>order_id</th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>

                
                 <?php echo $this->Form->create('Highlightoutfit'); ?>
                    <tr class="user-row">
                    <?php 
                    echo $this->Form->input('Highlightoutfit.id', array('type' => 'hidden'));
                    echo $this->Form->input('Highlightoutfit.order_id', array('type' => 'hidden'));
                    ?>
                        <td>
                        <?php echo $highlightoutfits[0]['Highlightoutfit']['id']; ?>&nbsp;</td>
                        <td><?php echo $highlightoutfits[0]['Outfit']['outfitname']; ?>&nbsp;</td>
                        <td><input type="text" name="data[Highlightoutfit][order_id]" value="<?php echo $highlightoutfits[0]['Highlightoutfit']['order_id']; ?>"></td> 
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

