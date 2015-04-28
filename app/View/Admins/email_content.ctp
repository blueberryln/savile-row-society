<div class="col-md-12">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Modify Email Content</h3>
      <a class="btn btn-primary btn-sm btn-flat pull-right" href="/admins/email_content">Refresh</a>
    </div><!-- /.box-header -->
    <div class="box-body">
		<?php
		echo $this->Form->create('EmailContent');
		echo $this->Form->input('user_id',array('type' => 'checkbox','label'=>'User ID','checked'=>$EmailContent['EmailContent']['user_id']));
		echo $this->Form->input('email',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['email']));
		echo $this->Form->input('first_name',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['first_name']));
		echo $this->Form->input('last_name',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['last_name']));
		echo $this->Form->input('phone',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['phone']));
		echo $this->Form->input('birthdate',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['birthdate']));
		echo $this->Form->input('location',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['location']));
		echo $this->Form->input('zip',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['zip']));
		echo $this->Form->input('skype',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['skype']));
		echo $this->Form->input('stylist_id',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['stylist_id']));
		echo $this->Form->input('is_phone',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['is_phone']));
		echo $this->Form->input('is_skype',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['is_skype']));
		echo $this->Form->input('comments',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['comments']));
		echo $this->Form->input('profile_photo_url',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['profile_photo_url']));
		echo $this->Form->input('landing_offer',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['landing_offer']));
		echo $this->Form->input('date_created',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['date_created']));
		echo $this->Form->input('neck_size',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['neck_size']));
		echo $this->Form->input('jacket_size',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['jacket_size']));
		echo $this->Form->input('pant_waist',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['pant_waist']));
		echo $this->Form->input('pant_length',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['pant_length']));
		echo $this->Form->input('shoe_size',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['shoe_size']));
		echo $this->Form->input('style_pref',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['style_pref']));

		echo $this->Form->input('Submit',array('type'=>'submit','class'=>'btn btn-primary','label'=>false));
		?>
	</div>
  </div>
</div>

