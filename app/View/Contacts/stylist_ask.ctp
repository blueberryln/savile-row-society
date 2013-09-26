<?php
$this->append('header');
echo $this->element('header');
$this->end();

$meta_description = 'At SRS, your personal stylists are fitting experts. Our stylists are here to give you new head to toe outfits or simply to find a better fitting or a replacement of those old jeans.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>

<?php echo $this->element('contacts/stylist-menu'); ?>

<div class="twelve columns">
    <?php echo $this->Form->create('Contact', array('type' => 'file')); ?>
    <?php
    echo $this->Form->hidden('contact_type_id', array('value' => 1));
    echo $this->Form->input('first_name', array('value' => $user['User']['first_name']));
    echo $this->Form->input('last_name', array('value' => $user['User']['last_name']));
    echo $this->Form->input('email', array('value' => $user['User']['email']));
    echo $this->Form->input('phone', array('value' => $user['User']['phone']));
    echo $this->Form->input('message');
    ?>
    <?php echo $this->Form->input('image', array('type' => 'file', 'label' => 'Attach image')); ?>
    <div class="tip">Up to 300 kB in image size.</div>
    <?php echo $this->Form->end(__('Send')); ?>
</div>