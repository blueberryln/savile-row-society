<?php
$class_th = ' style="background-color:#000000;color:#FFFFFF;font-family:Arial;font-size:12px;text-align:center"';
$class = ' style="font-family:Arial;font-size:11px;border:1px solid #CCCCCC;color:#333333;height:20px;text-align:left"';
?>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th<?php echo $class_th; ?>>ID</th>
        <th<?php echo $class_th; ?>>Name</th>
        <th<?php echo $class_th; ?>>Description</th>
        <th<?php echo $class_th; ?>>Product Code</th>
        <th<?php echo $class_th; ?>>SKU</th>
        <th<?php echo $class_th; ?>>Price</th>
        <th<?php echo $class_th; ?>>Is Gift</th>
        <th<?php echo $class_th; ?>>Is Featured</th>
        <th<?php echo $class_th; ?>>Show?</th>
        <th<?php echo $class_th; ?>>Category</th>
        <th<?php echo $class_th; ?>>Brand</th>
        <th<?php echo $class_th; ?>>Color</th>
        <th<?php echo $class_th; ?>>Sizes</th>
        <th<?php echo $class_th; ?>>Created date</th>
        <th<?php echo $class_th; ?>>Updated date</th>
    </tr>
    <?php foreach ($products as $product): ?>
        <tr>
            <td valign="top"<?php echo $class; ?>><?php echo h($product['Entity']['id']); ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo h($product['Entity']['name']); ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo h($product['Entity']['description']); ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo h($product['Entity']['productcode']); ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo h($product['Entity']['sku']); ?></td>
            <td valign="top"<?php echo $class; ?>>$<?php echo h($product['Entity']['price']); ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo ($product['Entity']['is_gift']) ? 'Yes' : 'No'; ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo ($product['Entity']['is_featured']) ? 'Yes' : 'No'; ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo ($product['Entity']['show']) ? 'Yes' : 'No'; ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo (isset($product['Category']['category_id']) && isset($categories[$product['Category']['category_id']])) ? $categories[$product['Category']['category_id']] : 'N/A'; ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo h($product['Brand']['name']); ?></td>
            <td valign="top"<?php echo $class; ?>>
                <?php 
                    if(count($product['Color']) > 0){
                        $color_txt = '';
                        for($i=0; $i < count($product['Color']); $i++){
                            if($i != count($product['Color'])-1){
                                $color_txt = $color_txt . $product['Color'][$i]['name'] . '/ ';    
                            }
                            else{
                                $color_txt = $color_txt . $product['Color'][$i]['name'];
                            }
                        }
                        
                        echo $color_txt;
                    }
                    else{
                        echo "Not specified.";
                    }
                ?>
            </td>
            <td valign="top"<?php echo $class; ?>>
                <?php 
                    if(count($product['Detail']) > 0){
                        $size_txt = '';
                        for($i=0; $i < count($product['Detail']); $i++){
                            if($i != count($product['Detail'])-1){
                                $size_txt = $size_txt . $sizes[$product['Detail'][$i]['size_id']] . '/ ';    
                            }
                            else{
                                $size_txt = $size_txt . $sizes[$product['Detail'][$i]['size_id']];
                            }
                        }
                        
                        echo $size_txt;
                    }
                    else{
                        echo "N/A";
                    }
                ?>
            </td>
            <td valign="top"<?php echo $class; ?>><?php echo $this->Time->format('F jS, Y H:i', $product['Entity']['created']); ?></td>
            <td valign="top"<?php echo $class; ?>><?php echo $this->Time->format('F jS, Y H:i', $product['Entity']['updated']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>