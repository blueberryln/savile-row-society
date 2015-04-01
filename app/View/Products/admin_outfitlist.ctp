
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
                <!-- commented by shubham -->
                    <!-- <th><?php /*echo $this->Paginator->sort('id'); ?></th>
                    <th><?php echo $this->Paginator->sort('outfit_name'); ?></th>
                    <th><?php echo $this->Paginator->sort('stylist_id');*/ ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th> -->
                <!-- commented by shubham -->
                <!-- added by shubham -->
                    <th><a href ="javascript:void(0)">Id</a></th>
                    <th><a href ="javascript:void(0)">Outfitname</a></th>
                    <th><a href ="javascript:void(0)">Stylist</a></th>
                    <th class="actions"><a href ="javascript:void(0)">Actions</a></th>
                <!-- added by shubham -->
                </tr>

                <?php foreach ($outfitall as  $outfitcomplete ): ?>
                 
                    <tr class="user-row">
                        <td><?php echo $outfitcomplete['Outfit']['id']; ?>&nbsp;</td>
                        <td><?php echo $outfitcomplete['Outfit']['outfit_name']; ?>&nbsp;</td>
                        <td><?php echo $outfitcomplete['User1']['stylistname']; ?>&nbsp;</td>
                       
                        
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
                                        <td>Name Of Clients:</td>
                                        <td>
                                            <?php echo  $outfitcomplete['User']['username']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Product Contained Id:</td>
                                        
                                        <td>
                                            <?php echo $productid = str_replace(',','<br>',$outfitcomplete[0]['GROUP_CONCAT(`OutfitItem`.`product_entity_id`)']); ?>
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

