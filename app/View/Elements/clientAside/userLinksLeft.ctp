<?php
if($client_user['User']['profile_photo_url']){
    $user_image_src = HTTP_ROOT . 'files/users/' . $client_user['User']['profile_photo_url'];
}
else{
    $user_image_src = HTTP_ROOT . 'images/default-user.jpg';
}

$page_title = '';
if($sideBarTab == "feed"){
    $page_title = 'Activity Feed';
}
else if($sideBarTab == "message"){
    $page_title = 'Messages';
}
else if($sideBarTab == "outfit"){
    $page_title = 'Outfits';
}
else if($sideBarTab == "purchase"){
    $page_title = 'Purchased Items';
}
else if($sideBarTab == "like"){
    $page_title = 'Liked Items';
}
else if($sideBarTab == "note"){
    $page_title = 'Notes &amp; Gallery';
}
else if($sideBarTab == "measurement"){
    $page_title = 'Measurements';
}
?>


    <div class="twelve columns myclient-heading pad-none">
        <h1><?php echo ucwords($client_user['User']['first_name'].' '.$client_user['User']['last_name']); ?> | <span><?php echo $page_title; ?></span></h1>
        <div class="client-img-small"><img src="<?php echo HTTP_ROOT; ?>files/users/<?php echo $client_user['User']['profile_photo_url']; ?>" alt="" />
        </div>
    </div>
    <div class="inner-left inner-myclient left">
        <div class="left-pannel left">
            <div class="client-img">
                <img src="<?php echo $user_image_src; ?>" alt="" />
            </div>
            <div class=" twelve columns left left-nav">
                <ul>
                   <li <?php echo ($sideBarTab == 'feed') ? 'class="active"' : ''; ?>><a href="<?php echo $this->webroot; ?>messages/userfeed/<?php echo $client_user['User']['id']; ?>">Activity Feed</a></li>
                    <li <?php echo ($sideBarTab == 'message') ? 'class="active"' : ''; ?>><a href="<?php echo $this->webroot; ?>messages/index/<?php echo $client_user['User']['id']; ?>">Messages</a></li>
                    <li <?php echo ($sideBarTab == 'outfit') ? 'class="active"' : ''; ?>><a href="<?php echo $this->webroot; ?>messages/outfits/<?php echo $client_user['User']['id']; ?>">Outfits</a></li>
                    <li <?php echo ($sideBarTab == 'purchase' || $sideBarTab == 'like') ? 'class="active"' : ''; ?>><a href="<?php echo $this->webroot; ?>messages/purchase/<?php echo $client_user['User']['id']; ?>">Purchases/Likes</a></li>
                    <li <?php echo ($sideBarTab == 'note') ? 'class="active"' : ''; ?>><a href="<?php echo $this->webroot; ?>messages/notes/<?php echo $client_user['User']['id']; ?>">Notes &amp; Gallery</a></li>
                    <li <?php echo ($sideBarTab == 'measurement') ? 'class="active"' : ''; ?>><a href="<?php echo $this->webroot; ?>messages/measurements/<?php echo $client_user['User']['id']; ?>">Measurements</a></li>
                </ul>
            </div>
        </div>