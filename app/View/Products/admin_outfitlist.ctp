
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
                    <th><?php echo $this->Paginator->sort('id'); ?></th>
                    <th><?php echo $this->Paginator->sort('outfitname'); ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>

                <?php
                    //print_r($alloutfitlists);exit;
                 foreach ($alloutfitlists as $outfitlist): ?>
                 
                    <tr class="user-row">
                        <td><?php echo $outfitlist['Outfit']['id']; ?>&nbsp;</td>
                        <td><?php echo $outfitlist['Outfit']['outfitname']; ?>&nbsp;</td>
                        
                        <td class="actions">
                            <!--<a target="_blank" href="<?php echo $this->webroot; ?>messages/index/<?php echo $user['User']['id']; ?>">Chat</a>-->
                            <?php //echo $this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id'])); ?>
                            <a class="detail" href="">Detail</a>
                        </td>

                    </tr>
                    <tr class="user-data-row">
                        <td colspan="9" style="border: none; padding: 0px;">
                            <div class="hide">
                                <table  style="float:left; width: 470px; border-bottom: 1px solid #cccccc;background-color: #E0E0E0;">

                                    <tr>
                                        <td>Number Of Clients:</td>
                                        <td>
                                            <?php
                                            //print_r($usercount);
                                                echo $stylist[0]['usercount'];
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
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
                                    </tr>
                                    
                                    
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
            echo $this->Paginator->counter(array(
                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
            ));
            ?>  </p>
        <div class="paging">
            <?php
            echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
            echo $this->Paginator->numbers(array('separator' => ''));
            echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
            ?>
        </div>
    </div>
</div>

