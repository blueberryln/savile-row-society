<div class="content-container">
    <div class="container content inner timeline">
    <?php foreach ($notes as  $note) { ?>
    <div class="chat-msg-box cur-user-msg">
    	<div class="message-caption"> Notes:</div>
    	<div class="message-body"><?php echo $note['Stylistnote']['created']; ?> :- <?php echo $note['Stylistnote']['notes']; ?></div>
    </div>
    <?php } ?>
	<table align="center">
	<?php 
echo $this->Form->create('Stylistnote', array('type' => 'file'));?>
		<tr>
			<td><textarea name="data[Stylistnote][notes]"></textarea></td>
		</tr>
		<tr>
			<td><input type="file" name="data[Stylistnote][image]"></td>
		</tr>
		<tr>
		<td><?php echo $this->Form->end(__('Submit')); ?></td>	
		</tr>
	</table>
	</div>
</div>

