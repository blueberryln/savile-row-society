<?php
$this->append('header');
echo $this->element('header');
$this->end();

$meta_description = 'Savil.Me, Inc. is designed to enhance the personal branding of professional males and transform men’s shopping through a groundbreaking online, personalized fashion service.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>

<?php echo $this->element('contacts/coach-menu'); ?>

<div class="twelve columns blog">
    <?php if ($submissions) : ?>
        <?php foreach ($submissions as $submission) : ?>
            <div class="post">
                <div class="datetime"><?php echo $this->Time->timeAgoInWords($submission['Contact']['created'], array('F jS, Y H:i')); ?></div>
                <div class="title"><?php echo $submission['Contact']['full_name']; ?></div>
                <p>
                    <?php if (isset($submission['Attached'][0]['Attachment']['name'])) : ?>
                        <img src="<?php echo HTTP_ROOT; ?>files/coach/<?php echo $submission['Attached'][0]['Attachment']['name']; ?>" />
                    <?php endif; ?>
                    <?php echo $submission['Contact']['message']; ?>
                </p>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        There are no submissions.
    <?php endif; ?>
</div>