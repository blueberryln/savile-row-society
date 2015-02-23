<table cellpadding="0" cellspacing="0">
    <tr>
        <th>id</th>
        <th>title</th>
        <th>description</th>
        <th>link</th>
        <th>image_link</th>
        <th>condtition</th>
        <th>category</th>
        <th>availability</th>
        <th>price</th>
        <th>brand</th>
        <th>gender</th>
        <th>age_group</th>
        <th>color</th>
        <th>size</th>
        <th>item_group_id</th>
    </tr>
    <?php foreach ($products as $product): ?>
        <tr>
            <td valign="top"><?php echo (isset($product['p']['id']) && $product['p']['id']) ? h($product['p']['id']) : '';  ?></td>
            <td valign="top"><?php echo (isset($product['p']['title']) && $product['p']['title']) ? h($product['p']['title']) : '';  ?></td>
            <td valign="top"><?php echo (isset($product['p']['description']) && $product['p']['description']) ? h($product['p']['description']) : '';  ?></td>
            <td valign="top"><?php echo (isset($product['0']['link']) && $product['0']['link']) ? h($product['0']['link']) : '';  ?></td>
            <td valign="top"><?php echo (isset($product['0']['image link']) && $product['0']['image link']) ? h($product['0']['image link']) : '';  ?></td>
            <td valign="top"><?php echo (isset($product['0']['condition']) && $product['0']['condition']) ? h($product['0']['condition']) : '';  ?></td>
            <td valign="top"><?php echo (isset($product['0']['category']) && $product['0']['category']) ? h($product['0']['category']) : '';  ?></td>
            <td valign="top"><?php echo (isset($product['0']['availability']) && $product['0']['availability']) ? h($product['0']['availability']) : '';  ?></td>
            <td valign="top"><?php echo (isset($product['0']['price']) && $product['0']['price']) ? h($product['0']['price']) : '';  ?></td>
            <td valign="top"><?php echo (isset($product['b']['name']) && $product['b']['name']) ? h($product['b']['name']) : '';  ?></td>
            <td valign="top"><?php echo (isset($product['0']['gender']) && $product['0']['gender']) ? h($product['0']['gender']) : '';  ?></td>
            <td valign="top"><?php echo (isset($product['0']['age_group']) && $product['0']['age_group']) ? h($product['0']['age_group']) : '';  ?></td>
            <td valign="top"><?php echo (isset($product['0']['color']) && $product['0']['color']) ? h($product['0']['color']) : '';  ?></td>
            <td valign="top"><?php echo (isset($product['0']['size']) && $product['0']['size']) ? h($product['0']['size']) : '';  ?></td>
            <td valign="top"><?php echo (isset($product['pr']['item_group_id']) && $product['pr']['item_group_id']) ? h($product['pr']['item_group_id']) : '';  ?></td>
    <?php endforeach; ?>
</table>