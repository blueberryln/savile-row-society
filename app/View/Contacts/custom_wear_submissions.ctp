<?php
$this->append('header');
echo $this->element('header');
$this->end();

$meta_description = 'We pride ourselves in our high quality, our personalization, and handmade clothing; we take great pride in fulfilling our brand name: Savile Row Society.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>

<?php echo $this->element('contacts/custom_wear-menu'); ?>

<div class="twelve columns blog">
    <?php if ($submissions) : ?>
        <?php foreach ($submissions as $submission) : ?>
            <div class="post">
                <div class="datetime"><?php echo $this->Time->timeAgoInWords($submission['Contact']['created'], array('F jS, Y H:i')); ?></div>
                <div class="title"><?php echo $submission['Contact']['full_name']; ?></div>
                <p>
                    <?php echo $submission['Contact']['message']; ?>
                </p>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        There are no submissions.
    <?php endif; ?>
</div>