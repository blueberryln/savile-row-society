<?php
$script = '
    $(function() {
        $( "#startDate" ).datepicker({ dateFormat: "dd-mm-yy" });
        $( "#endDate" ).datepicker({ dateFormat: "dd-mm-yy" });
        $(".btn-order-filter").on("click", function(e){
            e.preventDefault();
            var startDate = $( "#startDate" ).val();
            var endDate = $( "#endDate" ).val();
            var brandId = $( "#brand_id" ).val();
            if(startDate == "" && endDate == "" && brandId == ""){
                return false;
            }
            startDate = (startDate=="") ? "none" : startDate;
            endDate = (endDate=="") ? "none" : endDate;
            brandId = (brandId=="") ? 0 : brandId;

            window.location = "' . $this->webroot . 'admin/orders/items/" + brandId + "/" + startDate + "/" + endDate;
        });
        
        $(".btn-order-export").on("click", function(e){
            e.preventDefault();
            var startDate = $( "#startDate" ).val();
            var endDate = $( "#endDate" ).val();
            var brandId = $( "#brand_id" ).val();
            startDate = (startDate=="") ? "none" : startDate;
            endDate = (endDate=="") ? "none" : endDate;
            brandId = (brandId=="") ? 0 : brandId;

            window.location = "' . $this->webroot . 'admin/orders/export/" + brandId + "/" + startDate + "/" + endDate;
        });
    });
    ';
$this->Html->css('ui/jquery-ui', null, array('inline' => false));
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->script('http://code.jquery.com/ui/1.10.3/jquery-ui.min.js', array('inline' => false));
?>
<div class="container content inner">
    <div class="sixteen columns text-center">
        <h1><?php echo __('Ordered Items'); ?></h1>
    </div>
    <div class="sixteen columns text-center order-filter">
        <ul class="ordered-items">
            <li>
                <label for="startDate">Start Date:</label>
                <input name="start-date" id="startDate" type="text" style="width: 150px;">
            </li>
            <li>
                <label for="startDate">End Date:</label>
                <input name="start-date" id="endDate" type="text" style="width: 150px;">
            </li>
            <li>
                <?php echo $this->Form->input('brand_id', array('empty'=>"Select Brand", 'div'=>false, 'label' => 'Brand:')); ?>
            </li>        
        </ul>
        <a href="" class="btn-order-filter link-btn black-btn">Filter Data</a>
        <a href="" class="btn-order-export link-btn black-btn">Export Data</a><br />        
        <!--<label for="startDate">Start Date:</label>
        <input name="start-date" id="startDate" type="text" style="width: 150px;">
        <label for="startDate">Start Date:</label>
        <input name="start-date" id="endDate" type="text" style="width: 150px;">
        <?php echo $this->Form->input('brand_id', array('empty'=>"Select Brand", 'div'=>false)); ?><br />
        <a href="" class="btn-order-filter link-btn black-btn">Filter Data</a>
        <a href="" class="btn-order-export link-btn black-btn">Export Data</a>-->
        <br><br>
    </div>
    <div class="sixteen columns">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?php echo $this->Paginator->sort('id'); ?></th>
                <th><?php echo $this->Paginator->sort('brand_name'); ?></th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Size</th>
                <th><?php echo $this->Paginator->sort('created'); ?></th>
            </tr>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo h($item['OrderItem']['id']); ?>&nbsp;</td>
                    <td><?php echo h($item['Brand']['name']); ?>&nbsp;</td>
                    <td><?php echo $item['Entity']['name']; ?></td>
                    <td><?php echo h($item['OrderItem']['quantity']); ?>&nbsp;</td>
                    <td><?php echo h($sizes[$item['OrderItem']['size_id']]); ?>&nbsp;</td>
                    <td><?php echo $this->Time->format($item['OrderItem']['created'], '%d-%m-%Y'); ?>&nbsp;</td>
                    
                </tr>
            <?php endforeach; ?>
        </table>
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