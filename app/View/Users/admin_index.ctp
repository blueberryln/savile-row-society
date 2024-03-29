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
        <h1><?php echo __('Users'); ?></h1>
    </div>
    <div class="sixteen columns text-center order-filter">
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
    </div>
    <div class="sixteen columns">
        <div class="users index">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th><?php echo $this->Paginator->sort('id'); ?></th>
                    <th><?php echo $this->Paginator->sort('email'); ?></th>
                    <th><?php echo $this->Paginator->sort('first_name'); ?></th>
                    <th><?php echo $this->Paginator->sort('last_name'); ?></th>
                    <th><?php echo $this->Paginator->sort('location');?></th>
                    <th><?php echo $this->Paginator->sort('zip');?></th>
                    <th><?php echo $this->Paginator->sort('created'); ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>

                <?php foreach ($users as $user): ?>
                    <tr class="user-row">
                        <td><?php echo h($user['User']['id']); ?>&nbsp;</td>
                        <td><?php echo h($user['User']['email']); ?>&nbsp;</td>
                        <td><?php echo h($user['User']['first_name']); ?>&nbsp;</td>
                        <td><?php echo h($user['User']['last_name']); ?>&nbsp;</td>
                        <td><?php echo h($user['User']['location']); ?>&nbsp;</td>
                        <td><?php echo h($user['User']['zip']); ?>&nbsp;</td>
                        <td><?php echo $this->Time->timeAgoInWords($user['User']['created'], array('F jS, Y H:i')); ?>&nbsp;</td>
                        <td class="actions">
                            <a target="_blank" href="<?php echo $this->webroot; ?>messages/index/<?php echo $user['User']['id']; ?>">Chat</a>
                            <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id'])); ?>
                            <a class="detail" href="">Detail</a>
                        </td>

                    </tr>
                    <tr class="user-data-row">
                        <td colspan="9" style="border: none; padding: 0px;">
                            <div class="hide">
                                <table  style="float:left; width: 470px; border-bottom: 1px solid #cccccc;background-color: #E0E0E0;">

                                    <tr>
                                        <td>Is Stylist:</td>
                                        <td>
                                            <?php
                                                if(!isset($user['User']['is_stylist'])|| $user['User']['is_stylist']==""){
                                                    echo 'N/A';
                                                }
                                                else{
                                                    echo h($user['User']['is_stylist']);
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Is Editor:</td>
                                        <td>
                                            <?php
                                            if(!isset($user['User']['is_editor'])|| $user['User']['is_editor']==""){
                                                echo 'N/A';
                                            }
                                            else{
                                                echo h($user['User']['is_editor']);
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Is Admin:</td>
                                        <td>
                                            <?php
                                            if(!isset($user['User']['is_admin'])|| $user['User']['is_admin']==""){
                                                echo 'N/A';
                                            }
                                            else{
                                                echo h($user['User']['is_admin']);
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Phone:</td>
                                        <td>
                                            <?php
                                            if(!isset($user['User']['phone'])|| $user['User']['phone']==""){
                                                echo 'N/A';
                                            }
                                            else{
                                                echo h($user['User']['phone']);
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Skype:</td>
                                        <td><?php
                                            if(!isset($user['User']['skype'])||$user['User']['skype']==""){
                                                echo "N/A";
                                            }
                                            else{
                                                echo $user['User']['skype'];
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Stylist:</td>
                                        <td><?php
                                            if(isset($user['User']['stylist_id'])){
                                                echo $stylists[$user['User']['stylist_id']];
                                            }
                                            else{
                                                echo "Not assigned";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                     <tr>
                                        <td>Active:</td>
                                        <td>
                                            <?php
                                            if(!isset($user['User']['active'])|| $user['User']['active']==""){
                                                echo 'N/A';
                                            }
                                            else{
                                                echo h($user['User']['active']);
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Updated:</td>
                                        <td>
                                            <?php
                                            if(!isset($user['User']['updated'])|| $user['User']['updated']==""){
                                                echo 'N/A';
                                            }
                                            else{
                                                echo $this->Time->timeAgoInWords($user['User']['updated'], array('F jS, Y H:i'));
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Eligible for $50 discount:</td>
                                        <td>
                                            <?php
                                            if(isset($user['User']['vip_discount_flag']) && $user['User']['vip_discount_flag'] == 1){
                                                echo 'Yes';
                                            }
                                            else{
                                                echo 'No';
                                            }
                                            ?> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>VIP User:</td>
                                        <td>
                                            <?php
                                            if(isset($user['User']['vip_discount']) && $user['User']['vip_discount'] == 1){
                                                echo 'Yes';
                                            }
                                            else{
                                                echo 'No';
                                            }
                                            ?> 
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Referred Id:</td>
                                        <td>
                                            <?php
                                            if($user['User']['referred_by']!=""){
                                                
                                                echo $user['User']['referred_by'];
                                            }
                                            else{
                                                echo 'No';
                                            }
                                            ?> 
                                        </td>
                                    </tr>
                                </table>
                                <table  style="float:right; width: 470px;border-bottom: 1px solid #cccccc;border-left: 1px solid #cccccc;background-color: #E0E0E0;">
                                    
                                 
                                    
                                      
                                    <tr>
                                        <td>Neck Size:</td>
                                        <td>
                                            <?php
                                            if(isset($user['UserPreference']['neck_size'])  == ""){
                                                echo 'N/A';
                                            }
                                            else{
                                                echo $user['UserPreference']['neck_size'];
                                            }
                                            ?> 
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>Jacket Size:</td>
                                        <td>
                                        <?php
                                        if(isset($user['UserPreference']['jacket_size'])  == ""){
                                            echo 'N/A';
                                        }
                                        else{
                                            echo $user['UserPreference']['jacket_size'];
                                        }
                                        ?> 
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Pant Waist:</td>
                                        <td>
                                        <?php
                                        if(isset($user['UserPreference']['pant_waist']) == ""){
                                            echo 'N/A';
                                        }
                                        else{
                                            echo $user['UserPreference']['pant_waist'];
                                        }
                                        ?> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pant Length:</td>
                                        <td>
                                        <?php
                                        if(isset($user['UserPreference']['pant_length'])  == ""){
                                            echo 'N/A';
                                        }
                                        else{
                                            echo $user['UserPreference']['pant_length'];
                                        }
                                        ?> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Shoe Size:</td>
                                        <td>
                                        <?php
                                        if(isset($user['UserPreference']['shoe_size']) == ""){
                                            echo 'N/A';
                                        }
                                        else{
                                            echo $user['UserPreference']['shoe_size'];
                                        }
                                        ?> 
                                        </td>
                                    </tr>

                                     
                                    <?php 
                                    $user_styles = explode(',', $user['UserPreference']['style_pref']);
                                    //print_r($users);exit;
                                    foreach ($styles as $style) { ?>
                                        <tr>
                                        <td>Look: <?php echo $style['Style']['name']; ?></td>
                                        <td>
                                        <?php
                                        
                                        if(in_array($style['Style']['id'], $user_styles))
                                        {
                                            echo "Yes";

                                        }else{
                                            echo "No";
                                        }
                                        
                                            
                                            
                                        ?> 
                                        </td>
                                    </tr>


                                    <?php  } ?>
                               
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
            ?>	</p>
        <div class="paging">
            <?php
            echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
            echo $this->Paginator->numbers(array('separator' => ''));
            echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
            ?>
        </div>
    </div>
</div>

