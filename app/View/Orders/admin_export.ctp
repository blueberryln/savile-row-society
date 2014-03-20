<?php
$class_th = ' style="background-color:#000000;color:#FFFFFF;font-family:Arial;font-size:12px;text-align:center"';
$class = ' style="font-family:Arial;font-size:11px;border:1px solid #CCCCCC;color:#333333;height:20px;text-align:left"';
?>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th<?php echo $class_th; ?>>ID</th>
        <th<?php echo $class_th; ?>>Brand Name</th>
        <th<?php echo $class_th; ?>>Product</th>
        <th<?php echo $class_th; ?>>Quantity</th>
        <th<?php echo $class_th; ?>>Size</th>
        <th<?php echo $class_th; ?>>Created date</th>
    </tr>
    <?php foreach ($items as $item): ?>
        <tr>
            <td valign="top"<?php echo $class; ?>><?php echo h($item['OrderItem']['id']); ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo h($item['Brand']['name']); ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo h($item['Entity']['name']); ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo h($item['OrderItem']['quantity']); ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo h($sizes[$item['OrderItem']['size_id']]); ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo $this->Time->format('F jS, Y H:i', $item['OrderItem']['created']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>