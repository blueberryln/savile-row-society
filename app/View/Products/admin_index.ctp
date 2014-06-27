<?php
$script = '
    $(function() {
        $(".btn-product-search").on("click", function(e){
            e.preventDefault();
            var productId = $( "#productId" ).val();
            var productCode = $( "#productCode" ).val();
            var productName = $("#productName").val();
            if(productId == "" && productCode == "" && productName == ""){
                return false;
            }
            productId = (productId=="") ? "null" : productId;
            productCode = (productCode=="") ? "null" : productCode;
            productName = (productName=="") ? "null" : productName;

            window.location = "' . $this->webroot . 'admin/products/search/" + productId + "/" + productCode + "/" + productName;
        });
    });
    ';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
?>

<div class="container content inner">		
    <div class="sixteen columns text-center">
        <h1><?php echo __('Products'); ?></h1>
    </div>
    <div class="sixteen columns text-center order-filter">
        <ul class="ordered-items">
            <li>
                <label for="startDate">Product id:</label>
                <input name="product-id" id="productId" type="text" style="width: 150px;">
            </li>
            <li>
                <label for="startDate">Product code:</label>
                <input name="product-code" id="productCode" type="text" style="width: 150px;">
            </li>
            <li>
                <label for="startDate">Product name:</label>
                <input name="product-name" id="productName" type="text" style="width: 150px;">
            </li>       
        </ul>
        <a href="" class="btn-product-search link-btn black-btn">Search</a>
        <br><br>
    </div>
    <div class="sixteen columns">
        <div class="products index">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th><?php echo $this->Paginator->sort('id'); ?></th>
                    <th><?php echo $this->Paginator->sort('name'); ?></th>
                    <th><?php echo $this->Paginator->sort('brand_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('updated'); ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo h($product['Product']['id']); ?>&nbsp;</td>
                        <td><?php echo h($product['Product']['name']); ?>&nbsp;</td>
                        <td><?php echo h($product['Brand']['name']); ?>&nbsp;</td>
                        <td><?php echo $this->Time->timeAgoInWords($product['Product']['updated'], array('F jS, Y H:i')); ?>&nbsp;</td>
                        <td class="actions">
                            <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $product['Product']['id'])); ?>
                            <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $product['Product']['id']), null, __('Are you sure you want to delete # %s?', $product['Product']['id'])); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
    <div class="sixteen columns text-center">
        <br />
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