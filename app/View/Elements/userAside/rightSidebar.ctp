<?php

if($stylist['User']['profile_photo_url']){
    $stylist_image_src = $this->webroot . 'files/users/' . $stylist['User']['profile_photo_url'];
}
else{
    $stylist_image_src = $this->webroot . 'images/default-user.jpg';
}
?>

<div class="inner-right right">
    <div class="twelve columns text-center my-profile">
        <div class="my-profile-img">
            <a href="<?php echo $this->webroot; ?>users/stylistbiography/<?php echo $stylist['User']['id']; ?>" title=""><img src="<?php echo $stylist_image_src; ?>" alt="" /></a>
        </div>
        <div class="my-profile-detials">
           <?php echo ucwords($stylist['User']['first_name'].' '.$stylist['User']['last_name']); ?>
            <span>My Stylist</span>
            <a class="view-profile" href="<?php echo $this->webroot; ?>users/stylistbiography/<?php echo $stylist['User']['id']; ?>">View My Profile</a> 
        </div>
    </div>
</div>