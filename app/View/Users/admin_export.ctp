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
        <th<?php echo $class_th; ?>>Is Active</th>
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
            <td valign="top"<?php echo $class; ?>>
                <? if ($user['User']['active'] == 1): ?>
                    Yes
                <?php else : ?>
                    No
                <?php endif; ?>
            </td>
            <td valign="top"<?php echo $class; ?>><?php echo $this->Time->format('F jS, Y H:i', $user['User']['created']); ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo $this->Time->format('F jS, Y H:i', $user['User']['updated']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>