
<div class="container content inner">       
    <div class="sixteen columns text-center">
        <h1><?php echo __('Outfits'); ?></h1>
    </div>
    <!-- <div class="sixteen columns text-center order-filter">
        <ul class="ordered-items">
            <li>
                <label for="startDate">User id:</label>
                <input name="user-id" id="userId" type="text" style="width: 150px;">
            </li>
            <li>
                <label for="startDate">Name (First/Last name):</label>
                <input name="user-name" id="userName" type="text" style="width: 150px;">
            </li>
            <li>
                <label for="startDate">Email:</label>
                <input name="usere-email" id="userEmail" type="text" style="width: 150px;">
            </li>       
        </ul>
        <a href="" class="btn-user-search link-btn black-btn">Search</a>
        <br><br>
    </div> -->

    <div class="sixteen columns">
        <div class="users index">
            <table cellpadding="0" cellspacing="0">
                
                
                
                <tr>
                    <th>id</th>
                    <th>first_name</th>
                    <th>order_id</th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>

                
                 <?php echo $this->Form->create('Userhighlighted'); ?>
                    <tr class="user-row">
                    <?php 
echo $this->Form->input('Userhighlighted.id', array('type' => 'hidden'));
//echo $this->Form->input('UserPreference.id', array('type' => 'hidden'));
echo $this->Form->input('Userhighlighted.user_id', array('type' => 'hidden'));
?>
                        <td>
                        <?php echo $highlight[0]['User']['id']; ?>&nbsp;</td>
                        <td><?php echo $highlight[0]['User']['first_name'].'&nbsp;'.$highlight[0]['User']['last_name'];; ?>&nbsp;</td>
                        <td><input type="text" name="data[Userhighlighted][order_id]" value="<?php echo $highlight[0]['Userhighlighted']['order_id']; ?>"></td> 
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

