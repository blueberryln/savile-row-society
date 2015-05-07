<?php
$script = '
$(function() {

    $(".publish").click(function(e){
        var object = $(this);
        $.post("' . $this->request->webroot . 'admin/contacts/publish/", { id: object.attr("data-id"), state: object.attr("data-state") }, 
            function(data){
                if(data != 0) {
                    if(object.attr("data-state") == "true"){
                        object.find(".txt").html("Unpublish");
                        object.attr("data-state", "false");
                    } else {
                        object.find(".txt").html("Publish");
                        object.attr("data-state", "true");
                    }
                } else {
                    alert("There was a problem!");
                }
            });
        e.preventDefault();
    });
    
    $(".delete").click(function(e){
        var object = $(this);
        $.post("' . $this->request->webroot . 'admin/contacts/delete/", { id: object.attr("data-id"), attachemnt_id: object.attr("data-attachemntid") }, 
            function(data){
                if(data != 0) {
                    $("#submission-" + object.attr("data-id")).slideUp();
                } else {
                    alert("There was a problem!");
                }
            });
        e.preventDefault();
    });
    
});';
$this->Html->scriptBlock($script, $options = array('safe' => true, 'inline' => false));
?>
<div class="sixteen columns">
    <h1>Personal stylist</h1>
    <h4>
        Submission list
    </h4>
</div>

<?php if ($contacts) : ?>
    <?php foreach ($contacts as $contact): ?>
        <div id="submission-<?php echo h($contact['Contact']['id']); ?>" data-id="<?php echo h($contact['Contact']['id']); ?>" class="submission">
            <div class="four columns">
                <?php if (isset($contact['Attached'][0]['Attachment']['name'])) : ?>
                    <img src="<?php echo HTTP_ROOT; ?>files/coach/<?php echo $contact['Attached'][0]['Attachment']['name']; ?>" />
                <?php else : ?>
                    <div class="no-image">No image attached.</div>
                <?php endif; ?>
            </div>
            <div class="twelve columns">                
                <div class="name">
                    <?php echo h($contact['Contact']['full_name']); ?><br/>
                    <a href="mailto:<?php echo h($contact['Contact']['email']); ?>"><?php echo h($contact['Contact']['email']); ?></a>
                    <?php if (!empty($contact['Contact']['phone'])) : ?>
                        <br/>Phone: <?php echo h($contact['Contact']['phone']); ?>
                    <?php endif; ?>
                </div>
                <div class="date"><?php echo $this->Time->timeAgoInWords($contact['Contact']['created'], array('F jS, Y H:i')); ?></div>
                <div class="text"><?php echo h($contact['Contact']['message']); ?></div>
                <div class="actions">
                    <?php
                    $attachment_id = 0;
                    if (isset($contact['Attached'][0]['Attachment']['name'])) {
                        $attachment_id = $contact['Attached'][0]['Attachment']['id'];
                    }

                    $state = "true";
                    $state_txt = "Publish";
                    if ($contact['Contact']['show'] == true) {
                        $state = "false";
                        $state_txt = "Unpublish";
                    }
                    ?>
                    <a class="delete" data-id="<?php echo h($contact['Contact']['id']); ?>" data-attachemntid="<?php echo $attachment_id; ?>" href="#"><i class="icon-trash"></i> Delete</a> <a class="publish" data-id="<?php echo h($contact['Contact']['id']); ?>" data-state="<?php echo $state; ?>" href="#"><i class="icon-bullhorn"></i> <span class="txt"><?php echo $state_txt; ?></span></a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="sixteen columns">

        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} submissions out of {:count} total, starting on submission {:start}, ending on {:end}')
        ));
        ?>
        <div class="paging">
            <?php
            echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
            echo $this->Paginator->numbers(array('separator' => ''));
            echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
            ?>
        </div>

    </div>

<?php else : ?>
    There is no submissions to show. 
<?php endif; ?>