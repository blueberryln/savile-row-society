<?php
 
$script = ' var size = ' . json_encode($size) . '; ' .
' $(document).ready(function(){ 

   if(size){
       $("#jacketSize").val(size.jacket_size);
       $("#neckSize").val(size.neck_size);
       $("#poloSize").val(size.polo_size);
       $("#pantSize").val(size.pant_size);
       $("#shoeSize").val(size.shoe_size);
    }

});  
';

$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));

$meta_description = 'Sign up for Savile Row Society, a groundbreaking online, personalized fashion service.';
$this->Html->meta('description', $meta_description, array('inline' => false));


?>
<script>
window.registerProcess = true;

</script>
<div class="content-container">
    <div class="container content inner preferences register-size">	
        <div class="eight columns register-steps center-block">
            <div class="profile-tabs text-center">
                <a class="link-btn gold-btn my-style" href="<?php echo $this->webroot; ?>profile/about">My Style</a>
                <a class="link-btn black-btn my-profile" href="<?php echo $this->webroot; ?>myprofile">My Profile</a>
            </div>

            <h1 class="text-center">Your Size</h1>
        </div>
        <div class="seven columns center-block">
            <?php echo $this->Form->create('User', array('url' => '/register/saveSize')); ?>
            <input type="hidden" value="<?php echo $user_id ?>" name="data[User][id]" />
            
            <div class="input text required">
                <label for="jeans">Jacket Size</label>                            
                <select name="data[UserPreference][Size][jacket_size]" tabindex="" id="jacketSize" >
                    <option value="">Jacket Size:</option>
                    <option value="36">36</option>
                    <option value="38">38</option>
                    <option value="40">40</option>
                    <option value="41">41</option>
                    <option value="42">42</option>
                    <option value="44">44</option>
                    <option value="46">46</option>
                    <option value="48">48</option>                
                </select>
            </div>

            <div class="input text required">
                <label for="shirtSize">NECK SIZE:</label>                            
                <select name="data[UserPreference][Size][neck_size]" tabindex="" id="neckSize" >
                    <option value="">Neck Size</option>
                    <option value="14">14</option>
                    <option value="14.5">14.5</option>
                    <option value="15">15</option>
                    <option value="15.5">15.5</option>
                    <option value="16">16</option>
                    <option value="16.5">16.5</option>
                    <option value="17">17</option>
                    <option value="17.5">17.5</option>
                </select>
            </div>

            <div class="input text required chest-size">
                <label for="chestSize">POLO SIZE:</label>                            
                <select name="data[UserPreference][Size][polo_size]" tabindex="" id="poloSize" >
                    <option value="">Polo Size</option>
                    <option value="37">37</option>
                    <option value="38">38</option>
                    <option value="39">39</option>
                    <option value="40">40</option>
                    <option value="41">41</option>
                    <option value="42">42</option>
                    <option value="43">43</option>
                    <option value="44">44</option>
                </select>
            </div>

            <div class="input text required chest-size">
                <label for="chestSize">PANT SIZE:</label>                            
                <select name="data[UserPreference][Size][pant_size]" tabindex="" id="pantSize" >
                    <option value="">Pant Size</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                    <option value="32">32</option>
                    <option value="33">33</option>
                    <option value="34">34</option>
                    <option value="35">35</option>
                    <option value="36">36</option>
                    <option value="37">37</option>
                    <option value="38">38</option>
                    <option value="39">39</option>
                    <option value="40">40</option>
                </select>
            </div>

            <div class="input text required chest-size">
                <label for="chestSize">SHOE SIZE:</label>                            
                <select name="data[UserPreference][Size][shoe_size]" tabindex="" id="shoeSize" >
                    <option value="">Shoe Size</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                </select>
            </div>
                        
            <div class="clear-fix"></div>
            <div class="text-center about-submit">
                 <br/>                       
                    <div class="submit">                            
                        <a class="link-btn black-btn back-btn" href="<?php echo $this->webroot; ?>users/register/style/<?php echo $user_id; ?>">Back</a> 
                        <input type="submit" value="Continue" />                                                       
                    </div>
                 </form>
            </div>
        </div>
    </div>
</div>
