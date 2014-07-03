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
var style = ' . json_encode($style) . ',
    madeToMeasure = ' . json_encode($made_to_measure) . ';  
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
        
        // Mark saved style as selected
        if(style && style.length > 0){
            for(var i = 0; i < style.length; i++){
                var selectedId = getIdFromString(style[i]);
                if(selectedId != 0){
                    var liCondition = \'li[data-id = "\' + selectedId + \'"]\';            
                    var inputCondition = "#" + selectedId;

                    $(liCondition).attr("class", "ui-state-default ui-selectee ui-selected");
                    $(inputCondition).prop("checked", true);
                }    
            }
        }
        

        $("#madeToMeasure").val(madeToMeasure);
        
        $("div.submit input").click(function(event){            
            if($("div#your-style").find("li.ui-selected").length == 0 || $("select#madeToMeasure").val() == "")
            {
                event.preventDefault();
                $("p.error-msg").slideDown(300);
            }            
        });

        $("select#madeToMeasure").change(function(event){
            if( !$("select#madeToMeasure").val() == ""){
                $("p.error-msg").slideUp(300);
            }
        });
});
';



$this->Html->css('ui/jquery-ui', null, array('inline' => false));
$this->Html->css('ui/jquery.ui.theme', null, array('inline' => false));
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


<div class="content-container">
    <div class="container content inner register-about">	
        <div class="eight columns register-steps center-block">
           

            <h1 class="text-center">Registration Process</h1>
        </div>

        
        <div class="seven columns center-block">
            <?php  echo $this->Form->Create('User');
echo $this->Form->create('User', array('url' => 'Auth/finsh'));?>
            
            <input type="hidden" value="<?php //echo $user_id ?>" name="data[User][id]" />
            <div class="hi-message">
                <h4 class="hi-message"><?php //echo ucwords($full_name); ?></h4>
                <p>
                    Use this space to introduce yourself, tell us
                </p>
            </div>
            
            <div class="srs-form">
                <div class="form">
                 <?php
                    echo $this->Form->input('User.first_name', array('id' => 'first-name', 'label' => 'First Name:','required', 'placeholder' => 'FIRST NAME'));
                    echo $this->Form->input('User.last_name', array('id' => 'last-name', 'label' => 'Last Name:','required', 'placeholder' => 'LAST NAME'));
                    echo $this->Form->input('User.email', array('id' => 'register-email', 'label' => 'Email:','required', 'placeholder' => 'EMAIL'));
                    echo $this->Form->input('User.password', array('id' => 'register-password', 'label' => 'Password:','required', 'placeholder' => 'PASSWORD'));
					echo $this->Form->password('User.Confirm_password', array('id' => 'register-password', 'label' => 'Confirm Password:', 'placeholder' => 'CONFIRM PASSWORD'));
					echo $this->Form->input('User.skype', array( 'label' => 'Skype Id:', 'placeholder' => 'Skype Id'));
                ?>     
                
                
                
                <div class="input select dob">
                <label for="UserDayDay">Date of birth</label>
                <?php 
                    echo $this->Form->day('User.day', array('div' => false, 'empty' => 'Day', 'label' => false,  'name' => 'data[User][day]'));
                    echo $this->Form->month('User.month', array('monthNames' => false, 'div' => false, 'empty' => 'Month', 'label' => false,  'name' => 'data[User][month]'));
                    echo $this->Form->year('User.year', 1900, date('Y'), array('div' => false, 'empty' => 'Year', 'label' => false, 'class' => 'last',  'name' => 'data[User][year]'));         
                ?>          
                </div>      
                <?php   
                    echo $this->Form->input('User.zip', array("label"=>"Zipcode", "placeholder" => "Zipcode"));
                ?>
                
                <?php   
                    echo $this->Form->input('User.phone_no', array("label"=>"Phone Number", "placeholder" => "Phone Number"));
                ?>
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
                <div style="margin-left:-211px">
                <!--ward row-->
                <div class="container content inner preferences register-style">	
        
        <div class="nine columns center-block">
            
            
            
            <div class="twelve columns">
               
                <div id="your-style">
                    
                    
                    <!--<input class="hide" type="checkbox" name="data[UserPreference][style_pref]" value="Casual" id="2" />
                    <input class="hide" type="checkbox" name="data[UserPreference][style_pref]" value="Business Casual" id="3" />-->
                    
                    <ol id="selectable">
                      <?php
					  //foreach ($styles as $style): ?>
                     <?php
					  foreach ($styles as $style): ?> 
                      <input class="hide" type="checkbox" name="data[UserPreference][style_pref]" value="<?php echo $style['Style']['id']; ?>" id="<?php echo $style['Style']['id']; ?>" />
                      <li class="ui-state-default" data-id="<?php echo $style['Style']['id']; ?>"><img src="<?php echo $this->request->webroot; ?>img/preferences/<?php echo $style['Style']['image']; ?>" class="fadein-image" /><br/><?php echo $style['Style']['name']; ?></li>
                       <?php //echo $style['Style']['name']; //echo $style['Style']['name'];
               // echo $this->Form->input('name');
                //echo $this->Form->input('name', array('label' => 'Parent Product Name'));
                ?>
                       <?php endforeach; ?>
                       <!-- <li class="ui-state-default" data-id="2"><img src="<?php echo $this->request->webroot; ?>img/preferences/your-style-2.jpg" class="fadein-image" /><br/>Casual</li>
                        <li class="ui-state-default" data-id="3"><img src="<?php echo $this->request->webroot; ?>img/preferences/your-style-3.png" class="fadein-image" /><br/>Business Casual</li>
                        <li class="ui-state-default" data-id="1"><img src="<?php echo $this->request->webroot; ?>img/preferences/your-style-1.jpg" class="fadein-image" /><br/>Formal</li>-->
                    </ol>
                </div>
            </div>
            
          
              
           
        </div>
    </div> 
                <!--ward row end-->
                <!--style register-->
                


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
<!--style register end-->

<!--Size register end-->

  
    </div>
    
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
                <!--size register end-->
                
                

                <!--brand register-->
                
             <!--brand register-->
             
                <div class="clear-fix"></div>
                
                
                
                
                

                
                
                
                
                </div>
            </div>

            <div class="text-center about-submit">
                <?php echo $this->Form->end(__('Save')); ?>
                <!--<input type="submit" value="Continue" />  -->
                <p class="error-msg">All the fields are mandatory.</p>    
                   
            </div>
            
        </div>
        
    </div>
</div>