<?php
if($user['User']['profile_photo_url']){
    $user_image_src = $this->webroot . 'files/users/' . $user['User']['profile_photo_url'];
}
else{
    $user_image_src = $this->webroot . 'images/default-user.jpg';
}

if($stylist['User']['profile_photo_url']){
    $stylist_image_src = $this->webroot . 'files/users/' . $stylist['User']['profile_photo_url'];
}
else{
    $stylist_image_src = $this->webroot . 'images/default-user.jpg';
}

$page_title = '';
if($sideBarTab == "purchase"){
    $page_title = 'Purchased Items';
}
else if($sideBarTab == "like"){
    $page_title = 'Liked Items';
}
else if($sideBarTab == "profile"){
    $page_title = 'Profile';
}
else if($sideBarTab == "message"){
    $page_title = 'Messages';
}
else if($sideBarTab == "outfit"){
    $page_title = 'Outfits';
}
else if($sideBarTab == "detail"){
    $page_title = 'Outfit Detail';
}
else if($sideBarTab == "refer"){
    $page_title = 'Refer A Friend';
}
?>

<div class="twelve columns message-box-heading pad-none">
    <h1><?php echo ucwords($user['User']['first_name'].' '.$user['User']['last_name']); ?> | <span><?php echo $page_title; ?></span></h1>
    <div class="client-img-small"><img src="<?php echo $user_image_src; ?>" alt="" /></div>
</div>
<div class="my-profile-img m-ver">
    <h2><?php echo ucwords($stylist['User']['first_name'].' '.$stylist['User']['last_name']); ?><span>My Stylist</span></h2>
    <div class="client-img-small right">
    <a href="<?php echo $this->webroot; ?>stylists/stylistbiography/<?php echo $stylist['User']['id']; ?>" title=""><img src="<?php echo $stylist_image_src; ?>" id="user_image"  /></a>
    </div>
    <span id="dd-nav-switcher"><img src="<?php echo $this->webroot; ?>images/nav-switcher-icon.png" alt="" /></span>
</div>
<div class="dd-nav">
    <ul>
        <li <?php echo ($sideBarTab == 'message') ? "class='active'" : '';  ?>><a href="<?php echo $this->webroot; ?>messages/index">Messages</a></li>
        <li <?php echo ($sideBarTab == 'outfit' || $sideBarTab == 'detail') ? "class='active'" : '';  ?>><a href="<?php echo $this->webroot; ?>user/outfits">Outfits</a></li>
        <li <?php echo ($sideBarTab == 'purchase' || $sideBarTab == 'like') ? "class='active'" : '';  ?>><a href="<?php echo $this->webroot; ?>user/purchases">Purchases/Likes</a></li>
        <li <?php echo ($sideBarTab == 'profile') ? "class='active'" : '';  ?>><a href="<?php echo $this->webroot; ?>user/profile">Profile</a></li>
        <li <?php echo ($sideBarTab == 'refer') ? "class='active'" : '';  ?>><a href="<?php echo $this->webroot; ?>refer-a-friend">Refer A Friend</a></li>
    </ul>
</div>
<div class="twelve columns left inner-content pad-none">
    <div class="inner-left left">
        <div class="left-pannel left">
            <div class="client-img"><img src="<?php echo $user_image_src; ?>"  alt=""/></div>
            <div class=" twelve columns left left-nav">
                <ul>
                    <li <?php echo ($sideBarTab == 'message') ? "class='active'" : '';  ?>><a href="<?php echo $this->webroot; ?>messages/index">Messages</a></li>
                    <li <?php echo ($sideBarTab == 'outfit' || $sideBarTab == 'detail') ? "class='active'" : '';  ?>><a href="<?php echo $this->webroot; ?>user/outfits">Outfits</a></li>
                    <li <?php echo ($sideBarTab == 'purchase' || $sideBarTab == 'like') ? "class='active'" : '';  ?>><a href="<?php echo $this->webroot; ?>user/purchases">Purchases/Likes</a></li>
                    <li <?php echo ($sideBarTab == 'profile') ? "class='active'" : '';  ?>><a href="<?php echo $this->webroot; ?>user/profile">Profile</a></li>
                    <li <?php echo ($sideBarTab == 'refer') ? "class='active'" : '';  ?>><a href="<?php echo $this->webroot; ?>refer-a-friend">Refer A Friend</a></li>
                </ul>
            </div>
        </div>