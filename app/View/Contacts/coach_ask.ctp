<?php
$this->append('header');
echo $this->element('header');
$this->end();

$meta_description = 'Savil.Me, Inc. is designed to enhance the personal branding of professional males and transform men’s shopping through a groundbreaking online, personalized fashion service.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>

<?php echo $this->element('contacts/coach-menu'); ?>

<div class="twelve columns">
    <?php echo $this->Form->create('Contact', array('type' => 'file')); ?>
    <?php
    echo $this->Form->hidden('contact_type_id', array('value' => 2));
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