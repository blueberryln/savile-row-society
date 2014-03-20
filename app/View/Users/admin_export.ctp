<?php
$class_th = ' style="background-color:#000000;color:#FFFFFF;font-family:Arial;font-size:12px;text-align:center"';
$class = ' style="font-family:Arial;font-size:11px;border:1px solid #CCCCCC;color:#333333;height:20px;text-align:left"';
?>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th<?php echo $class_th; ?>>ID</th>
        <th<?php echo $class_th; ?>>Email</th>
        <th<?php echo $class_th; ?>>First name</th>
        <th<?php echo $class_th; ?>>Last name</th>
        <th<?php echo $class_th; ?>>Phone</th>
        <th<?php echo $class_th; ?>>Birthday</th>
        <th<?php echo $class_th; ?>>Industry</th>
        <th<?php echo $class_th; ?>>Location</th>
        <th<?php echo $class_th; ?>>Zip</th>
        <th<?php echo $class_th; ?>>Style Profile</th>
        <th<?php echo $class_th; ?>>Stylist</th>
        <th<?php echo $class_th; ?>>Personal Shopper</th>
        <th<?php echo $class_th; ?>>Shopper Email</th>
        <th<?php echo $class_th; ?>>Refer Medium</th>
        <th<?php echo $class_th; ?>>Created date</th>
        <th<?php echo $class_th; ?>>Updated date</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td valign="top"<?php echo $class; ?>><?php echo h($user['User']['id']); ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo h($user['User']['email']); ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo h($user['User']['first_name']); ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo h($user['User']['last_name']); ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo h($user['User']['phone']); ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo ($user['User']['birthdate']) ? h($user['User']['birthdate']) : 'unavailable'; ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo ($user['User']['industry']) ? h($user['User']['industry']) : 'unavailable'; ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo ($user['User']['location']) ? h($user['User']['location']) : 'unavailable'; ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo ($user['User']['zip']) ? h($user['User']['zip']) : 'unavailable'; ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo ($user['User']['zip']) ? 'Complete' : 'N/A'; ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo ($user['User']['stylist_id'] && isset($stylists[$user['User']['stylist_id']])) ? h($stylists[$user['User']['stylist_id']]) : 'N/A'; ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo ($user['User']['personal_shopper']) ? h($user['User']['personal_shopper']) : 'N/A'; ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo ($user['User']['shopper_email']) ? h($user['User']['shopper_email']) : 'N/A'; ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo ($user['User']['refer_medium']) ? h($user['User']['refer_medium']) : 'N/A'; ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo $this->Time->format('F jS, Y H:i', $user['User']['created']); ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo $this->Time->format('F jS, Y H:i', $user['User']['updated']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>