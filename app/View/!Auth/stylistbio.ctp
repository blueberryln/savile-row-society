<div class="content-container">
    <div class="container content inner register-about">	
        <div class="eight columns register-steps center-block">
	        <div class="five columns pref-time left">
				<?php echo $this->Form->create('Stylistbio', array('type'=>'file')); ?>
					<table>
						<tr>
							<td><?php echo $this->Form->input('Stylistbio.hometown'); ?></td>
						</tr>
						<tr>
							<td><?php echo $this->Form->input('Stylistbio.funfect'); ?></td>
						</tr>
						<tr>
							<td><?php echo $this->Form->input('Stylistbio.fashiontip'); ?></td>
						</tr>
						<tr>
							<td><label>Facebook:</label><input type="text" name="data[Stylistbio][stylist_social_link][facebook]"></td>
						</tr>
						<tr>
							<td><label> Printrest:</label><input type="text" name="data[Stylistbio][stylist_social_link][pintrest]"></td>
						</tr>
						<tr>
							<td><label> Twiter:</label><input type="text" name="data[Stylistbio][stylist_social_link][twiter]"></td>
						</tr>
						<tr>
							<td><label> Linkdin:</label><input type="text" name="data[Stylistbio][stylist_social_link][linkdin]"></td>
						</tr>
					</table>
				</div>
				<div class="five columns pref-time right">
					<table>
						<tr>
							<td><?php echo $this->Form->input('Stylistbio.stylist_bio'); ?></td>
						</tr>
						<tr>
							<td><?php echo $this->Form->input('Stylistbio.stylist_inspiration'); ?></td>
						</tr>
						<tr>
							<td><?php echo $this->Form->input('Stylistphotostream.image', array('type'=>'file')); ?></td>
						</tr>
						<tr>
							<td><label> Make Profile Pic :</label><input type="checkbox" name="data[Stylistphotostream][is_profile]"></td>
						</tr>
						<tr>
							<td><label>Caption:</label><input type="text" name="data[Stylistphotostream][caption]"></td>
						</tr>
					</table>
				</div>
				<div class="text-center about-submit">
                    <div class="submit">                            
                      <?php echo $this->Form->end('submit'); ?> 
                    </div>
                 
            </div> 
		</div>
	</div>
</div>