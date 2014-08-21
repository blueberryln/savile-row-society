<?php
$script = ' 
    $(function(){
        $("div.submit input").click(function(event){             
            if($("input").val() == "" || $("select").val() == "")
            {                                      
                $("p.error-msg").slideDown(300);                
                event.preventDefault();            
            }
        });
    });
';

$this->Html->script('//code.jquery.com/ui/1.10.3/jquery-ui.min.js', array('inline' => false));
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
?>
<?php
$script = ' 
$(document).ready(function(){ 

        $("#your-style li").click(function(){
            $("p.error-msg").slideUp(300);
            if($(this).hasClass("ui-selected")){
                $(this).removeClass("ui-selected");
                var selected_id = $(this).data("id");
                $("#your-style input:checkbox#" + selected_id).prop("checked", false);    
            }
            else{
                $(this).addClass("ui-selected");
                var selected_id = $(this).data("id");
                $("#your-style input:checkbox#" + selected_id).prop("checked", true);
            }
            
        });

        function getIdFromString(s){
            switch(s){
                case "Formal": return 1;
                case "Casual": return 2;
                case "Business Casual": return 3;
                default: return 0;    
            }
        }
        
        
        
        
});
';



//$this->Html->css('ui/jquery-ui', null, array('inline' => false));
//$this->Html->css('ui/jquery.ui.theme', null, array('inline' => false));
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));

$meta_description = 'Sign up for Savile Row Society, a groundbreaking online, personalized fashion service.';
$this->Html->meta('description', $meta_description, array('inline' => false));

// call this line to exclude lyout from rendering. 
// this is necesary because this view is opening as popup, and don't need to have header, footer etc as rest of the pages.
// $this->layout = 'ajax'

?>
<script>
window.registerProcess = true;
</script>

<script>
  $(function() {
    $( "#tabs" ).tabs();
  });
  </script>
<div class="content-container">
    <div class="container content inner register-about">	
        <div class="eight columns register-steps center-block">
           
          
        <!--   <hr / style="margin-bottom:5px;">
            <h1 class="text-center" style="font-size: 20px;">Select The Styles You Prefer</h1>-->
           


        </div>
<script>
$(document).ready(function() {
    $("#cont1").on("click", function(e){
        e.preventDefault();
        if($(".style-check:checked").length){
            $("p.style-error").slideUp(300);
            $("a[href='#tabs-2']#t2").trigger("click");    
        }
        else{
            $("p.style-error").slideDown(300);
        }
	});
	$("#cont2").on("click", function(e){
        e.preventDefault();
        if($("#neckSize").val() && $("#jacketSize").val() && $("#pantWaist").val() && $("#pantLength").val() && $("#shoeSize").val()){
            $("p.size-error").slideUp(300);
            $("a[href='#tabs-3']#t3").trigger("click");   
        }
        else{
            $("p.size-error").slideDown(300);
        }
	});

    $(".about-submit input[type=submit]").on('click', function(e){
        if($("#first-name").val() && $("#last-name").val() && $("#register-password").val() && $("#register-email").val() && $("#confirm-register-password")){
            $("p.about-error").slideUp(300);
        }
        else {
            e.preventDefault();
            $("p.about-error").slideDown(300); 
        }
    });
	
	
});
</script>
<style>
.ui-state-active{
color:#396; !important	
	}
	.ui-state-active a{
color:#396; !important	
	}
</style>
<div id="tabs">
  <ul style="list-style: disc" class="hide">
    <li style="float:left; margin-left:232px;"><br /><div style="margin-left:-30px;"><a href="#tabs-1" id="t1" class="register-tabs">Style</a></div></li>
    <li style="float:left; margin-left:232px;"><br /><div style="margin-left:-30px;"><a href="#tabs-2" id="t2" class="register-tabs">Size</a></div></li>
    <li style="float:left; margin-left:232px;"><br /><div style="margin-left:-30px;"><a href="#tabs-3" id="t3" class="register-tabs">Info</a></div></li>
  </ul>
  <div id="tabs-1">
    <div class="seven columns center-block">
            <?php 
echo $this->Form->create('User', array('type' => 'file'));?>
            <br />

            <!--<input type="hidden" value="<?php //echo $user_id ?>" name="data[User][id]" />--> 
            <div class="hi-message">
                <p><img src="<?php echo $this->webroot; ?>img/b.png" alt=""></p>
                <h4 class="hi-message" style="margin: 2px -1px 24px 72px;">Select The Styles You Prefer</h4>
                <p style="margin-top: -25px;
font-size: 14px;
margin-left: 2px;">
                   Your selection gives your stylist an initial impression of what you want to look like.
                </p>
            </div>
            
            <div class="srs-form">
                <div class="form">
                
                
                
                
                      
               
               <div class="hi-message twelve columns text-center">
                               
                
                <div class="clear-fix"></div>
            </div>
                <div style="margin-left:-211px">
                <!--ward row-->
                <div class="container content inner preferences register-style">	
        
        <div class="nine columns center-block">
            
            
            
            <div class="twelve columns">
               
                <div id="your-style">
                 <ol id="selectable" style="margin-left: 22px;">
                      
			     <?php foreach ($styles as $style): ?> 
                          <input class="hide style-check" type="checkbox" name="data[UserPreference][style_pref][]"   value="<?php echo $style['Style']['id']; ?>" id="<?php echo $style['Style']['id']; ?>" />
                          <li class="ui-state-default" style="width:150px;padding:5px 5px 0px 5px;height: 230px;" onclick="yes();"  data-id="<?php echo $style['Style']['id']; ?>"><img src="<?php echo $this->request->webroot; ?>files/user_styles/<?php echo $style['Style']['image']; ?>" class="fadein-image" /></li>
                       
                 <?php endforeach; ?>
                       
                 </ol>
                </div>
            </div>
        </div>
    </div> 
               

  
    </div>
    
                
            
                
                </div>
            </div>

              <div class="text-center about-submit">
                                     
                    <div class="submit">                            
                       <div id="tabs">
                       <ul> 
                        <li><a class="link-btn black-btn back-btn" id="cont1" href="#tabs-2">Continue</a> 
                       </li>
                       </ul>
                       </div>
                        <p class="error-msg style-error">Please select atleast one style option.</p> 
                    </div>
                 
            </div> 
        </div>
  </div>
  <div id="tabs-2">
            <div class="seven columns center-block">
                <br />
                
                <div class="hi-message">
                    <p><img src="<?php echo $this->webroot; ?>img/c.png" alt=""></p>
                    <h4 class="hi-message text-center" style="margin: 0 -1px 24px 0;">What are your basic measurements?</h4>
                    <p class="text-center" style="margin-top: -25px;
    font-size: 14px;">
                       Before we have the opportunity to take your measurements in the showroom, <br> 
    let your stylist get an idea of what will fit you best.

                    </p>
                </div>
           </div>
           <div class="four columns center-block"> 
            <div class="input text required">
                <label for="neckSize" class="text-center">NECK SIZE:</label>                            
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
                    <option value="I don’t know">I don’t know</option>
                </select>
            </div>
          
            
             <div class="input text required">
                <label for="jacketSize" class="text-center">Suit Size:</label>                            
                <select name="data[UserPreference][jacket_size]" tabindex="" required="required" id="jacketSize" >
                    <option value="">Suit Size</option>
                    <option value="36">36</option>
                    <option value="37">37</option>
                    <option value="38">38</option>
                    <option value="39">39</option>
                    <option value="40">40</option>
                    <option value="41">41</option>                    
                    <option value="42">42</option>
                    <option value="43">43</option>
                    <option value="44">44</option>
                    <option value="45">45</option>
                    <option value="46">46</option>
                    <option value="47">47</option>
                    <option value="48">48</option>
                     <option value="I don’t know">I don’t know</option>                
                </select>
            </div>

            <div class="input text required chest-size">
                <label for="pantWaist" class="text-center">PANT WAIST:</label>                            
                <select name="data[UserPreference][pant_waist]" tabindex="" required="required" id="pantWaist" >
                    <option value="">Pant Waist</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">3l</option>
                    <option value="32">32</option>
                    <option value="33">33</option>
                    <option value="34">34</option>
                    <option value="35">35</option>
                    <option value="36">36</option>
                    <option value="37">37</option>
                    <option value="38">38</option>
                    <option value="I don’t know">I don’t know</option>                                        
                </select>
            </div>

            <div class="input text required chest-size">
                <label for="pantLength" class="text-center">PANT LENGHT:</label>                            
                <select name="data[UserPreference][pant_length]" tabindex="" required="required" id="pantLength" >
                    <option value="">Pant Length</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                    <option value="32">32</option>
                    <option value="33">33</option>
                    <option value="34">34</option>
                     <option value="I don’t know">I don’t know</option>
                </select>
            </div>
          <div class="input text required chest-size">
                <label for="shoeSize" class="text-center">SHOE SIZE:</label>                            
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
                    <option value="I don’t know">I don’t know</option>
                </select>
            </div>
                        
            <div class="clear-fix"></div>
            <br>
            <div class="text-center about-submit">
                                      
                    <div class="submit">                            
                       <div id="tabs">
                       <ul> <!--<li><a class="link-btn black-btn back-btn" id="back2" href="#tabs-1">Back</a> </li>-->
                        <li><a class="link-btn black-btn back-btn" id="cont2" href="#tabs-3">Continue</a> 
                       </li>
                       </ul>
                       </div>
                        <p class="error-msg size-error">All the fields are mandatory.</p>
                    </div>
                 
            </div> 
            
            
        </div>
  </div>
  <div id="tabs-3">
    <div class="seven columns center-block">
            <br />
            
            <div class="hi-message">
                <p><img src="<?php echo $this->webroot; ?>img/d.png" alt=""></p>
                <h4 class="hi-message" style="margin: 2px -1px 24px 72px;">Tell us more about yourself</h4>
                <p style="margin-top: -25px; font-size: 14px; margin-left: 2px;">
                  Help our stylists get to know you better to create a more personalized experience.
                </p>
            </div>
            
            <div class="five columns pref-time left">
            <div class="pref-options">
                <?php
                    echo $this->Form->input('User.first_name', array('id' => 'first-name', 'label' => 'First Name*','required', 'placeholder' => 'FIRST NAME'));
                    echo $this->Form->input('User.last_name', array('id' => 'last-name', 'label' => 'Last Name*','required', 'placeholder' => 'LAST NAME'));
                    echo $this->Form->input('User.zip', array("label"=>"Zipcode", "placeholder" => "Zipcode"));
    				echo $this->Form->input('User.password', array('type' => 'password', 'id' => 'register-password', 'label' => 'Password*', 'required','placeholder' => 'PASSWORD'));
    			    echo $this->Form->input('User.confirm_password', array('type' => 'password', 'id' => 'confirm-register-password', 'label' => 'Confirm Password*','required', 'placeholder' => 'CONFIRM PASSWORD'));
    			?>
                <label>Additional Comments :</label><textarea name="data[User][comments]"></textarea>
            </div>
            </div>
            
             <div class="five columns pref-time right">
            <div class="pref-options">      
              <?php
               echo $this->Form->input('User.email', array('id' => 'register-email', 'label' => 'Email*','required', 'placeholder' => 'EMAIL'));
					echo $this->Form->input('User.phone', array("label"=>"Phone No", "placeholder" => "Phone Number"));
				    echo $this->Form->input('User.skype', array( 'label' => 'Skype Id', 'placeholder' => 'Skype Id'));
					
					
                ?> 
                <label>I 'd like to connected on the phone :</label><input type="checkbox" name="data[User][is_phone]">
                <label>I 'd like to connected through Skype :</label><input type="checkbox" name="data[User][is_skype]">
                <label>I 'd like to connected using SRS masseging System :</label><input type="checkbox" name="data[User][is_srs_msg]">
                
                <div class="hi-message twelve columns text-center">
               <div class='empty-img' id='photo-holder'>
                <img src='<?php echo $this->webroot . "img/dummy_image.jpg";//echo $image_url; ?>' id='user-photo'/>
                </div>                
                <input type='button' value='Upload photo' id='upload-img' class="gray-btn"/>

                <?php
                    echo $this->Form->input('User.profile_photo_url', array('type' => 'file', 'id'=>'uploader-btn', 'label' => false));
                ?>
                <div class="clear-fix"></div>
            </div>
                </div></div>
                
                    
                 </div>
                    
            <div class="clear-fix"></div>
            <div class="text-center about-submit">
                   
                                     
                    <div class="submit">                            
                        <!--<a class="link-btn black-btn back-btn" href="<?php echo $this->webroot; ?>users/register/style/">Back</a>--> 
                       <!--<a class="link-btn black-btn back-btn" id="back3" href="#tabs-2">Back</a>-->
						<?php echo $this->Form->end(__('Submit')); ?>
                    </div>
                        <p class="error-msg about-error">Please complete all mandatory fields.</p>
                 
            </div>
        </div>
  </div>
</div>

        
    </form>    
        
    </div>
</div>

<style>
    #upload-img{
        width:100px;
    }
    #uploader-btn{
        display: none;
    }
    #user-photo{
        /*width:100px;*/
        height: 100px;
        opacity: 0;
        
    }
</style>
<script>
    window.onload=function(){
        $("#upload-img").click(function(e){
            e.preventDefault();
            $("#uploader-btn").click();
        });
        $("#uploader-btn").change(function(){
        
            var input = document.getElementById("uploader-btn");
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#user-photo' ).attr('src', e.target.result);
                    $('#user-photo' ).css('opacity', 1);
                    $('#photo-holder' ).attr('class', '');
                };
                reader.readAsDataURL(input.files[0]);
//                    if (self.showName) {
//                        $(self).append("<p>" + input.files[0].name + "</p>");
//                    }
                // 
            }
        });
        if($('#user-photo').attr('src') != "#"){
            $('#user-photo').css('opacity', 1);
            $('#photo-holder' ).attr('class', '');
        }
    }
</script> 