<?php
$this->append('header');
echo $this->element('header');
$this->end();

$meta_description = 'We pride ourselves in our high quality, our personalization, and handmade clothing; we take great pride in fulfilling our brand name: Savile Row Society.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>

<?php echo $this->element('contacts/custom_wear-menu'); ?>

<div class="twelve columns">
    <?php echo $this->Form->create('Contact', array('type' => 'file')); ?>
    <?php
    echo $this->Form->hidden('contact_type_id', array('value' => 3));
    echo $this->Form->input('first_name', array('value' => $user['User']['first_name']));
    echo $this->Form->input('last_name', array('value' => $user['User']['last_name']));
    echo $this->Form->input('email', array('value' => $user['User']['email']));
    echo $this->Form->input('phone', array('value' => $user['User']['phone']));
    echo $this->Form->input('message');
    ?>
    <?php echo $this->Form->end(__('Send')); ?>
</div>