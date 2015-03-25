
<?php
$script = '
$(document).ready(function(){

    $(".detail").click(function(e){
        e.preventDefault();
        var userRow = $(this).closest(".user-row").next(".user-data-row").find("div");
        if(userRow.is(":visible")){
            userRow.slideUp(300);
        }
        else{
            $(".user-data-row div").slideUp(300);
            userRow.slideDown(300);


        }
    });

    $(".btn-user-search").on("click", function(e){
        e.preventDefault();
        var userId = $( "#userId" ).val();
        var userName = $( "#userName" ).val();
        var userEmail = $("#userEmail").val();
        if(userId == "" && userName == "" && userEmail == ""){
            return false;
        }
        userId = (userId=="") ? "null" : userId;
        userName = (userName=="") ? "null" : userName;
        userEmail = (userEmail=="") ? "null" : userEmail;

        window.location = "' . $this->webroot . 'admin/users/search/" + userId + "/" + userName + "/" + userEmail;
    });

});
';
 $this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
?>
<div class="container content inner">       
    <div class="sixteen columns text-center">
        <h1><?php echo __('Outfits'); ?></h1>
    </div>
    <div class="sixteen columns text-center order-filter">
        <?php echo $this->Form->create('Highlightoutfit'); ?>
        <ul class="ordered-items">
           
            <li>
                <label for="startDate">Outfit List: </label>
                <select name="data[Highlightoutfit][outfit_id]">
                    <option>Please Select</option>
                    <?php foreach ($outfitli as $outname) { ?>
                    <option value="<?php echo $outname['Outfit']['id'] ?>"><?php echo $outname['Outfit']['outfitname'] ?></option>
                    <?php    } ?>
                    
                </select>
            </li>
            <li>
                <label for="startDate">Outfit Id:</label>
                <input name="data[Highlightoutfit][outfit_id2]" type="text" style="width: 150px;">
            </li>
            <li>
                <label for="startDate">Order Number:</label>
                <input name="data[Highlightoutfit][order_id]" type="text" style="width: 150px;" required>
            </li>
              
        </ul>
       <?php echo $this->Form->end('ADD HIGHLIGHTED OUTFIT'); ?>
       <!--  <a href="" class="btn-user-search link-btn black-btn">Search</a> -->
        <br><br>
    </div>
    <div class="sixteen columns">
        <div class="users index">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th>id</th>
                    <th><?php echo 'outfitname'; ?></th>
                    <th><?php echo 'order Number'; ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>

                <?php
                //print_r($highlightoutfits);
                //exit;
                 foreach ($highlightoutfits as  $outfitcomplete ):
                    $highlightoutfitid = $outfitcomplete['Highlightoutfit']['id'];
                  ?>
                 
                    <tr class="user-row">
                        <td><?php echo $outfitcomplete['Highlightoutfit']['outfit_id']; ?>&nbsp;</td>
                        <td><?php echo $outfitcomplete['Outfit']['outfitname']; ?>&nbsp;</td>
                        <td><?php echo $outfitcomplete['Highlightoutfit']['order_id']; ?>&nbsp;</td>
                       
                        
                        <td class="actions">
                            <!--<a target="_blank" href="<?php echo $this->webroot; ?>messages/index/<?php echo $user['User']['id']; ?>">Chat</a>-->
                            <?php echo $this->Html->link(__('Edit'), array('action' => 'highlightoutfitedit', $highlightoutfitid)); ?>
                            <!-- <a class="detail" href="">Detail</a> -->
                        </td>

                    </tr>
                    <tr class="user-data-row">
                        <td colspan="9" style="border: none; padding: 0px;">
                            <div class="hide">
                                <table  style="float:left; width: 470px; border-bottom: 1px solid #cccccc;background-color: #E0E0E0;">

                                    <!-- <tr>
                                        <td>Name Of Clients:</td>
                                        <td>
                                            <?php
                                            //print_r($usercount);
                                                echo  $outfitcomplete['outfituserdetails'][0]['User']['first_name'];
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Product Contained Id:</td>
                                        
                                        <td>
                                            <?php
                                            foreach ($outfitcomplete['Outfitproduct'] as  $proutfit) {
                                                echo  $proutfit['OutfitItem']['product_entity_id'].'<br>';
                                            }
                                            
                                            //print_r($usercount);
                                                
                                            ?>
                                        </td>
                                    </tr> -->
                                    <!--<tr>
                                        <td>Sales over the last 30 days :</td>
                                        <td>
                                            <?php
                                                echo "$2500";
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Number of outfit created :</td>
                                        <td><?php
                                                echo "5";
                                            
                                            ?>
                                        </td>
                                    </tr> -->
                                    
                                    
                                </table>
                                




                            </div>
                        </td>
                    </tr>
                <?php   endforeach; ?>
            </table>

        </div>
    </div>
    <div class="sixteen columns text-center">
        <p>
            <?php
            // echo $this->Paginator->counter(array(
            //     'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
            // ));
            ?>  </p>
        <div class="paging">
            <?php
           // echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
           // echo $this->Paginator->numbers(array('separator' => ''));
           // echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
            ?>
        </div>
    </div>
</div>

