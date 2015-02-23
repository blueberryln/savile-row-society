<?php
$this->append('header');
echo $this->element('header');
$this->end();

$meta_description = 'At SRS, your personal stylists are fitting experts. Our stylists are here to give you new head to toe outfits or simply to find a better fitting or a replacement of those old jeans.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>

<?php echo $this->element('contacts/stylist-menu'); ?>

<div class="twelve columns blog">
    <?php if ($submissions) : ?>
        <?php foreach ($submissions as $submission) : ?>
            <div id="<?php echo $submission['Contact']['id']; ?>" class="twelve columns aplha omega post">
                <div class="datetime">Submitted <?php echo $this->Time->timeAgoInWords($submission['Contact']['created'], array('F jS, Y H:i')); ?></div>
                <div class="title"><?php echo $submission['Contact']['full_name']; ?></div>
                <p>
                    <?php if (isset($submission['Attached'][0]['Attachment']['name'])) : ?>
                        <img class="six columns alpha" src="<?php echo HTTP_ROOT; ?>files/stylist/<?php echo $submission['Attached'][0]['Attachment']['name']; ?>" />
                    <?php endif; ?>
                    <?php echo $submission['Contact']['message']; ?>
                </p>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        There are no submissions.
    <?php endif; ?>
</div>