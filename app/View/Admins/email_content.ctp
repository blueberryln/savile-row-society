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
		echo $this->Form->input('user_type_id',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['user_type_id']));
		echo $this->Form->input('email',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['email']));
		echo $this->Form->input('first_name',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['first_name']));
		echo $this->Form->input('last_name',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['last_name']));
		echo $this->Form->input('username',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['username']));
		echo $this->Form->input('phone',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['phone']));
		echo $this->Form->input('social_network',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['social_network']));
		echo $this->Form->input('social_network_id',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['social_network_id']));
		echo $this->Form->input('social_network_token',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['social_network_token']));
		echo $this->Form->input('social_network_secret',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['social_network_secret']));
		echo $this->Form->input('title',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['title']));
		echo $this->Form->input('birthdate',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['birthdate']));
		echo $this->Form->input('industry',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['industry']));
		echo $this->Form->input('location',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['location']));
		echo $this->Form->input('zip',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['zip']));
		echo $this->Form->input('skype',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['skype']));
		echo $this->Form->input('preferences',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['preferences']));
		echo $this->Form->input('referred_by',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['referred_by']));
		echo $this->Form->input('vip_discount_flag',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['vip_discount_flag']));
		echo $this->Form->input('vip_discount',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['vip_discount']));
		echo $this->Form->input('stylist_notification',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['stylist_notification']));
		echo $this->Form->input('stylist_id',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['stylist_id']));
		echo $this->Form->input('is_editor',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['is_editor']));
		echo $this->Form->input('is_event',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['is_event']));
		echo $this->Form->input('is_admin',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['is_admin']));
		echo $this->Form->input('is_stylist',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['is_stylist']));
		echo $this->Form->input('view_stylist',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['view_stylist']));
		echo $this->Form->input('random_stylist',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['random_stylist']));
		echo $this->Form->input('lead',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['lead']));
		echo $this->Form->input('active',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['active']));
		echo $this->Form->input('is_phone',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['is_phone']));
		echo $this->Form->input('is_skype',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['is_skype']));
		echo $this->Form->input('is_srs_msg',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['is_srs_msg']));
		echo $this->Form->input('comments',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['comments']));
		echo $this->Form->input('profile_photo_url',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['profile_photo_url']));
		echo $this->Form->input('show_closet_popup',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['show_closet_popup']));
		echo $this->Form->input('landing_offer',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['landing_offer']));
		echo $this->Form->input('created',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['created']));
		echo $this->Form->input('updated',array('type' => 'checkbox','checked'=>$EmailContent['EmailContent']['updated']));
		echo $this->Form->input('Submit',array('type'=>'submit','class'=>'btn btn-primary','label'=>false));
		?>
	</div>
  </div>
</div>

