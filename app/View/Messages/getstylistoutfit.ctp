<?php
foreach ($my_outfit as $my_outfit) {
	//print_r($my_outfit);

echo $my_outfit['outfit']['Outfit']['outfitname'].'&nbsp&nbsp&nbsp&nbsp';
echo$outfitid = $my_outfit['outfit']['Outfit']['id'];  ?>
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

