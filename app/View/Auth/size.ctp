<?php
 
$script = ' var size = ' . json_encode($size) . '; ' .
' $(document).ready(function(){ 
        
        $("div.submit input").click(function(event){
            if($("#jacketSize").val() == "" || $("#neckSize").val() == "" || $("#poloSize").val() == "" || $("#pantSize").val() == "" || $("#shoeSize").val() == "" )
            {                
                $("p.error-msg").slideDown(300);
                event.preventDefault();
            }
        });         

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
            

            <ul style="list-style-type: disc;"><li style="float: left;margin-left:109px; color:#ccc"><br /><div style="margin: 0px 0px 0px -30px; color:#ccc">Style</div></li><li style="float: left;margin-left:200px;color:#396"><br /><div style="margin: 0px 0px 0px -30px; color:#396">Size</div></li><li style="float: left;margin-left:200px;color:#CCC"><br /><div style="margin: 0px 0px 0px -30px;color:#CCC">Info</div></li></ul>
           <hr / style="margin-bottom:5px;">
            <h1 class="text-center" style="font-size: 20px;">What are your basic measurements?</h1>
          
        </div>
         <div class="hi-message">
               
                <p style='margin: -15px 0px 30px 185px;
width: 630px;'>
                    Before we have the opportunity to take your measurements in the showroom, 
let your stylist get an idea of what will fit you best.

                </p>
            </div>
        <div class="seven columns center-block">
            <?php echo $this->Form->create('UserPreference'); ?>
          
            
             <div class="input text required">
                <label for="jeans">Suit Size:</label>                            
                <select name="data[UserPreference][jacket_size]" tabindex="" required="required" id="jacketSize" >
                    <option value="">Suit Size</option>
                    <option value="36">36</option>
                    <option value="38">38</option>
                    <option value="40">40</option>                    
                    <option value="42">42</option>
                    <option value="44">44</option>
                    <option value="46">46</option>
                    <option value="48">48</option>                
                </select>
            </div>


           
            <div class="input text required">
                <label for="shirtSize">NECK SIZE:</label>                            
                <select name="data[UserPreference][neck_size]" tabindex="" required="required" id="neckSize" >
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
                <select name="data[UserPreference][polo_size]" tabindex="" required="required" id="poloSize" >
                    <option value="">Polo Size</option>
                    <option value="xs">xs</option>
                    <option value="s">s</option>
                    <option value="m">m</option>
                    <option value="l">l</option>
                    <option value="xl">xl</option>
                    <option value="xxl">xxl</option>
                    <option value="xxxl">xxxl</option>                    
                </select>
            </div>

            <div class="input text required chest-size">
                <label for="chestSize">PANT SIZE:</label>                            
                <select name="data[UserPreference][pant_size]" tabindex="" required="required" id="pantSize" >
                    <option value="">Pant Size</option>
                    <option value="s">s</option>
                    <option value="m">m</option>
                    <option value="l">l</option>
                    <option value="xl">xl</option>
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
                    <option value="41">41</option>
                    <option value="42">42</option>
                    <option value="43">43</option>
                    <option value="44">44</option>
                </select>
            </div>
          <div class="input text required chest-size">
                <label for="chestSize">SHOE SIZE:</label>                            
                <select name="data[UserPreference][shoe_size]" tabindex="" required="required" id="shoeSize" >
                    <option value="">Shoe Size</option>                    
                    <option value="7">7</option>
                    <option value="7.5">7.5</option>
                    <option value="8">8</option>
                    <option value="8.5">8.5</option>
                    <option value="9">9</option>
                    <option value="9.5">9.5</option>
                    <option value="10">10</option>
                    <option value="10.5">10.5</option>
                    <option value="11">11</option>
                    <option value="11.5">11.5</option>
                    <option value="12">12</option>
                    <option value="12.5">12.5</option>
                    <option value="13">13</option>
                    <option value="13.5">13.5</option>
                    <option value="14">14</option>
                </select>
            </div>
                        
            <div class="clear-fix"></div>
            <div class="text-center about-submit">
                 <br/>   
                                     
                    <div class="submit">                            
                        <!--<a class="link-btn black-btn back-btn" href="<?php echo $this->webroot; ?>users/register/style/">Back</a>--> 
                        <?php echo $this->Form->end(__('Continue')); ?>
                        <p class="error-msg">All the fields are mandatory.</p>
                    </div>
                 </form>
            </div>
        </div>
    </div>
</div>
