
	
<form method="post" action="/messages/copyoutfituser/<?php echo $user_id; ?>">
<?php

foreach ($my_outfit as $my_outfit) {
	$outfitid = $my_outfit['outfit']['Outfit']['id']; 
echo $my_outfit['outfit']['Outfit']['outfitname'].'&nbsp&nbsp&nbsp&nbsp';
echo $outfitid; ?>
<input type="radio" name="data[OutfitItem][outfit_id]" value="<?php echo $outfitid; ?>"><br>

<?php		
}

?>


<select name="data[Useroutfit][user_id]">
<?php 
//print_r($userlist);
foreach ($userlist as $userlist) { ?>

<option value="<?php echo $userlist['User']['id']; ?>"><?php echo $userlist['User']['first_name']; ?></option>
	
<?php

}
?>
</select>


<?php
echo $this->Form->end('Submit');
 ?>
