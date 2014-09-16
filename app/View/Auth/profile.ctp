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
    <div class="twelve columns container content inner register-about">	
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
        if($("#first-name").val() && $("#last-name").val() && $("#register-email").val()){
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
<div class="eleven columns container container-box register-box-main">
    <div class="eleven columns container stylist-boxes">
        <div id="tabs">
          <ul style="list-style: disc" class="hide">
            <li style="float:left; margin-left:232px;"><br /><div style="margin-left:-30px;"><a href="#tabs-1" id="t1" class="register-tabs">Style</a></div></li>
            <li style="float:left; margin-left:232px;"><br /><div style="margin-left:-30px;"><a href="#tabs-2" id="t2" class="register-tabs">Size</a></div></li>
            <li style="float:left; margin-left:232px;"><br /><div style="margin-left:-30px;"><a href="#tabs-3" id="t3" class="register-tabs">Info</a></div></li>
          </ul>
          <div id="tabs-1">
           <div class="eleven columns center-block step1-text-aera">
                    <?php 
        echo $this->Form->create('User', array('type' => 'file'));
        echo $this->Form->input('User.id', array('type' => 'hidden'));
        echo $this->Form->input('UserPreference.id', array('type' => 'hidden'));
        echo $this->Form->input('UserPreference.user_id', array('type' => 'hidden'));
        ?>
                    <br />
                    <div class="twelve columns text-center page-heading">
                        <div class="hi-message">
                        <div class="twelve columns text-center page-heading">
                        <p><img src="<?php echo $this->webroot; ?>images/register-setp-1.png" alt=""></p>
                        </div>
                        <div class="twelve columns text-center page-heading">
                        <h4 class="hi-message">Style Profile | Step 1</h4>
                        <div class="hi-message-text">Select the style/outfit that you prefer. You may select more than one.</div>
                        </div>
                    </div>
                   </div>

                    <div class="srs-form">
                        <div class="form">






                       <div class="hi-message twelve columns text-center">


                        <div class="clear-fix"></div>
                    </div>
                        <div class="eleven columns container step1-text-aera ">
                        <!--ward row-->
                        <div class="container inner preferences register-style">	

                <div class="nine columns center-block step1-text-aera">



                    <div class="twelve columns step1-text-aera">

                        <div id="your-style">
                         <ol id="selectable" style="margin-left: 22px;">
                    <?php
                      $user_styles = explode(',', $this->data['UserPreference']['style_pref']);
                         foreach ($styles as $style): ?> 
                      <?php 

                      if(in_array($style['Style']['id'], $user_styles))  { 

                        ?>
                        <input class="hide style-check" type="checkbox" name="data[UserPreference][style_pref][]"   value="<?php echo $style['Style']['id']; ?>" id="<?php echo $style['Style']['id']; ?>" checked />
                      <li class="ui-state-default ui-selected" style="width:150px;padding:5px 5px 0px 5px;height: 230px;" onclick="yes();" 
                       data-id="<?php echo $style['Style']['id']; ?>">
                        <img src="<?php echo $this->request->webroot; ?>files/user_styles/<?php echo $style['Style']['image']; ?>" class="fadein-image" /></li>

                      <?php }else{ ?>
                      <input class="hide style-check" type="checkbox" name="data[UserPreference][style_pref][]"   value="<?php echo $style['Style']['id']; ?>" id="<?php echo $style['Style']['id']; ?>" />
                      <li class="ui-state-default" style="width:150px;padding:5px 5px 0px 5px;height: 230px;" onclick="yes();" 
                       data-id="<?php echo $style['Style']['id']; ?>">
                       <img src="<?php echo $this->request->webroot; ?>files/user_styles/<?php echo $style['Style']['image']; ?>" class="fadein-image" /></li>
                               <?php } ?>
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
                                <li><a class="setp-btn" id="cont1" href="#tabs-2">Next</a> 
                               </li>
                               </ul>
                               </div>
                                <p class="error-msg style-error">Please select atleast one style option.</p> 
                            </div>

                    </div> 
                </div>
          </div>
          <div id="tabs-2" class="step1-text-aera">
                    <div class="eight columns center-block step2-text-aera">
                        <br />

                        <div class="hi-message">
                            <p><img src="<?php echo $this->webroot; ?>images/register-setp-2.png" alt=""></p>
                            <h4 class="hi-message text-center">Style Profile | Step 2</h4>
                            <div class="hi-message-text">
                               What are your best measurements? This information helps your stylist select items with a perfect fit.
                            </div>
                        </div>
                   </div>
                   <div class="three columns center-block profile-stp2"> 
                    <div class="input text required styled-select">
                        <span class="arrow-icon">&nbsp;</span>
<!--                         <label for="neckSize" class="text-center">NECK SIZE:</label> -->
                         <?php
                            echo $this->Form->input('UserPreference.neck_size', array(
                                                                    'options' => array(
                                                                    '14'=>'14', 
                                                                    '14.5'=>'14.5',
                                                                    '15'=>'15',
                                                                    '15.5'=>'15.5',
                                                                    '16'=>'16',
                                                                    '16.5'=>'16.5',
                                                                    '17'=>'17',
                                                                    '17.5'=>'17.5',
                                                                    'I don’t know'=>'I don’t know'),
                                                                    'empty' => 'Neck Size','label' => false,
                                                                    "id"=>"neckSize",
                                                                    ));
                          ?>
                        <a class="tt-icon"  target="1">
                            <img src="<?php echo $this->webroot; ?>images/tt-icon.png" alt="" />
                        </a>
                        <div id="div1" class="tt-content">
                            <h4>INSTRUCTIONS</h4>
                            <p>Est ei erat mucius quaeque. Ei his quas phaedrum, efficiantur mediocritatem ne sed, hinc oratio blandit ei sed. </p>
                            <span class="tt-arrow"></span>
                        </div>
                        <!-- <select name="data[UserPreference][neck_size]" tabindex="" required="required" id="neckSize" >
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
                        </select>  -->

                    </div>


                     <div class="input text required styled-select">
                         <span class="arrow-icon">&nbsp;</span>
<!--                        <label for="jacketSize" class="text-center">Suit Size:</label>     -->
                        <?php

                        echo $this->Form->input('UserPreference.jacket_size',
                                                                        array(
                                                                    'options' => array(
                                                                        '36'=>'36',
                                                                        '37'=>'37',
                                                                        '38'=>'38',
                                                                        '39'=>'39',
                                                                        '40'=>'40',
                                                                        '41'=>'41',
                                                                        '42'=>'42',
                                                                        '43'=>'43',
                                                                        '44'=>'44',
                                                                        '45'=>'45',
                                                                        '46'=>'46',
                                                                        '47'=>'47',
                                                                        '48'=>'48',
                                                                        'I don’t know'=>'I don’t know'),
                                                                        'empty'=>'Suit Size','label' => false,
                                                                        "id"=>"jacketSize",
                                                                            ));

                         ?> 
                         <a class="tt-icon"  target="2">
                            <img src="<?php echo $this->webroot; ?>images/tt-icon.png" alt="" />
                        </a>
                        <div id="div2" class="tt-content">
                            <h4>INSTRUCTIONS</h4>
                            <p>Est ei erat mucius quaeque. Ei his quas phaedrum, efficiantur mediocritatem ne sed, hinc oratio blandit ei sed. </p>
                            <span class="tt-arrow"></span>
                        </div>
                        <!-- <select name="data[UserPreference][jacket_size]" tabindex="" required="required" id="jacketSize" >
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
                        </select> -->
                    </div>

                    <div class="input text required styled-select">
                        <span class="arrow-icon">&nbsp;</span>
<!--                        <label for="pantWaist" class="text-center">PANT WAIST:</label>-->
                        <?php

                                    echo $this->form->input('UserPreference.pant_waist',  array(
                                                                'options' => array(              
                                                                        '28'=>'28',
                                                                        '29'=>'29',
                                                                        '30'=>'30',
                                                                        '31'=>'31',
                                                                        '32'=>'32',
                                                                        '33'=>'33',
                                                                        '34'=>'34',
                                                                        '35'=>'35',
                                                                        '36'=>'36',
                                                                        '37'=>'37',
                                                                        '38'=>'38',
                                                                        'I don’t know'=>'I don’t know',),
                                                                        'empty'=>'Pant Waist', 'label'=>false, "id"=>"pantWaist",));
                         ?>
                        <a class="tt-icon"  target="3">
                            <img src="<?php echo $this->webroot; ?>images/tt-icon.png" alt="" />
                        </a>
                        <div id="div3" class="tt-content">
                            <h4>INSTRUCTIONS</h4>
                            <p>Est ei erat mucius quaeque. Ei his quas phaedrum, efficiantur mediocritatem ne sed, hinc oratio blandit ei sed. </p>
                            <span class="tt-arrow"></span>
                        </div>
                        <!-- <select name="data[UserPreference][pant_waist]" tabindex="" required="required" id="jacketSize" >
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
                        </select> -->
                    </div>

                    <div class="input text required styled-select">
                        <span class="arrow-icon">&nbsp;</span>
<!--                        <label for="pantLength" class="text-center">PANT LENGHT:</label> -->
                             <?php
                             echo $this->form->input('UserPreference.pant_length',  array(
                                                                'options' => array(              
                                                                        '28'=>'28',
                                                                        '29'=>'29',
                                                                        '30'=>'30',
                                                                        '31'=>'31',
                                                                        '32'=>'32',
                                                                        '33'=>'33',
                                                                        '34'=>'34',
                                                                        'I don’t know'=>'I don’t know',),
                                                                        'empty'=>'Pant Length', 'label'=>false, 'id'=>'pantLength',));

                              ?>
                                <a class="tt-icon"  target="4">
                                    <img src="<?php echo $this->webroot; ?>images/tt-icon.png" alt="" />
                                </a>
                                <div id="div4" class="tt-content">
                                    <h4>INSTRUCTIONS</h4>
                                    <p>Est ei erat mucius quaeque. Ei his quas phaedrum, efficiantur mediocritatem ne sed, hinc oratio blandit ei sed. </p>
                                    <span class="tt-arrow"></span>
                                </div>
                        <!-- <select name="data[UserPreference][pant_length]" tabindex="" required="required" id="pantLength" >
                            <option value="">Pant Length</option>
                            <option value="28">28</option>
                            <option value="29">29</option>
                            <option value="30">30</option>
                            <option value="31">31</option>
                            <option value="32">32</option>
                            <option value="33">33</option>
                            <option value="34">34</option>
                             <option value="I don’t know">I don’t know</option>
                        </select> -->
                    </div>
                  <div class="input text required styled-select">
                      <span class="arrow-icon">&nbsp;</span>
<!--                        <label for="shoeSize" class="text-center">SHOE SIZE:</label> -->
                        <?php
                             echo $this->form->input('UserPreference.shoe_size',  array(
                                                                'options' => array(              
                                                                        '7'=>'7',
                                                                        '7.5'=>'7.5',
                                                                        '8'=>'8',
                                                                        '8.5'=>'8.5',
                                                                        '9'=>'9',
                                                                        '9.5'=>'9.5',
                                                                        '10'=>'10',
                                                                        '10.5'=>'10.5',
                                                                        '11'=>'11',
                                                                        '11.5'=>'11.5',
                                                                        '12'=>'12',
                                                                        '12.5'=>'12.5',
                                                                        '13'=>'13',
                                                                        '13.5'=>'13.5',
                                                                        '14'=>'14',
                                                                        'I don’t know'=>'I don’t know',),
                                                                        'empty'=>'Shoe Size', 'label'=>false, 'id'=>"shoeSize",));

                              ?>
                              <a class="tt-icon"  target="5">
                                    <img src="<?php echo $this->webroot; ?>images/tt-icon.png" alt="" />
                                </a>
                                <div id="div5" class="tt-content">
                                    <h4>INSTRUCTIONS</h4>
                                    <p>Est ei erat mucius quaeque. Ei his quas phaedrum, efficiantur mediocritatem ne sed, hinc oratio blandit ei sed. </p>
                                    <span class="tt-arrow"></span>
                                </div>
                        <!-- <select name="data[UserPreference][shoe_size]" tabindex="" required="required" id="shoeSize" >
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
                        </select> -->
                    </div>

                    <div class="clear-fix"></div>
                    <br>
                    <div class="text-center about-submit">

                            <div class="submit">                            
                               <div id="tabs">
                               <ul> <!--<li><a class="link-btn black-btn back-btn" id="back2" href="#tabs-1">Back</a> </li>-->
                                <li><a class="setp-btn" id="cont2" href="#tabs-3">Next</a>  
                               </li>
                               </ul>
                               </div>
                                <p class="error-msg size-error">All the fields are mandatory.</p>
                            </div>

                    </div> 


                </div>
          </div>
          <div id="tabs-3">
            <div class="seven columns center-block step3-text-aera">
                    <br />

                    <div class="hi-message">
                        <p><img src="<?php echo $this->webroot; ?>images/register-setp-3.png" alt=""></p>
                        <h4 class="hi-message">Style Profile | Step 3</h4>
                        <div class="hi-message-text">
                          Please complete the following fields.
                        </div>
                    </div>

                <div class="twelve columns left profile-stp3">
                    <h1>General Info</h1>
                    <div class="eleven columns center-block step3-text-aera">
                        <div class="five columns pref-time left">
                            <div class="pref-options">
                                <?php
                                    echo $this->Form->input('User.first_name', array('id' => 'first-name', "label"=> false,'required', 'placeholder' => 'FIRST NAME'));
                                    echo $this->Form->input('User.email', array('id' => 'register-email', "label"=> false,'required', 'placeholder' => 'EMAIL'));
                                   
                                ?>
                            </div>
                        </div>
                         <div class="five columns pref-time right">
                            <div class="pref-options">      
                              <?php
                                echo $this->Form->input('User.last_name', array('id' => 'last-name', "label"=> false, 'required', 'placeholder' => 'LAST NAME'));
                                echo $this->Form->input('User.zip', array("label"=> false, "placeholder" => "Zipcode"));
                               ?> 
                                
                                </div>
                            </div>
                        </div>
                    </div>
                
                <div class="twelve columns left profile-stp3">
                    <h1>Communication preferences</h1>
                    <h3>This information will be given to the stylist so they know they best way to contact you.</h3>
                    <div class="eleven columns center-block step3-text-aera">
                        <div class="five columns pref-time left">
                            <div class="pref-options">
                                <?php
                                    echo $this->Form->input('User.phone', array("label"=> false, "placeholder" => "Phone Number"));
                                    echo $this->Form->input('User.skype', array("label"=> false, 'placeholder' => 'Skype Id'));
                                ?>
                            </div>
                        </div>
                         <div class="five columns pref-time right">
                            <div class="pref-options">
                                <div class="connect">
                                    <div class="squared">
                                        <input type="checkbox" id="squared" <?php if($this->data['User']['is_phone']=='1'){ ?> checked <?php } else{} ?> name="data[User][is_phone]">
<!--                                        <input type="checkbox" id="squared" name="data[User][is_phone]">-->
                                        <label for="squared"></label>
                                    </div>
                                    <label>I 'd like to connected on the phone :</label>
                                </div>
                                <div class="connect">
                                    <div class="squared">
                                        <input type="checkbox" id="squared_1" <?php if($this->data['User']['is_skype']=='1'){ ?> checked <?php } else{} ?> name="data[User][is_skype]">
<!--                                        <input type="checkbox" id="squared_1" name="data[User][is_skype]">-->
                                        <label for="squared_1"></label>
                                    </div>
                                    <label>I 'd like to connected through Skype :</label>
                                </div>
                                <div class="connect">
                                     <div class="squared">
<!--                                        <input type="checkbox" id="squared_2" name="data[User][is_srs_msg]">-->
                                         <input type="checkbox" id="squared_2" <?php if($this->data['User']['is_srs_msg']=='1'){ ?> checked <?php } else{} ?> name="data[User][is_srs_msg]">
                                        <label for="squared_2"></label>
                                    </div>
                                    <label>I’d prefer to be contacted through SRS Messaging  System :</label>
                                </div>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                
                
                <div class="twelve columns left clear-fix step3-text-aera">
                    <div class="eleven columns center-block step3-text-aera">
                        <div class="five columns pref-time left">
                            <div class="pref-options">
                            <?php                            
                                echo $this->Form->input('User.comments', array("type"=>"textarea",'label'=>false));
                            ?>
                            
                            </div>
                        </div>
                         <div class="five columns pref-time right">
                            <div class="pref-options ">
                                <div class="seven columns center-block uplod-profile-img">
                                <div class='empty-img' id='photo-holder'>
                                    <?php if($this->data['User']['profile_photo_url']){
                                        ?>
                                         <img src='<?php echo $this->webroot ."files/users/". $this->data['User']['profile_photo_url']; ?>' id='user-photo'/>
                                        <?php
                                       }else{ ?>
                                        <img src='<?php echo $this->webroot . "img/dummy_image.jpg"; ?>' id='user-photo'/>
                                      <?php } ?>
                                    </div>
                                    </div>
                                    <input type='button' value='Upload profile Photo' id='upload-img' class="gray-btn"/>

                                    <?php
                                        echo $this->Form->input('User.profile_photo_url', array('type' => 'file', 'id'=>'uploader-btn', 'label' => false));
                                    ?>
                                
                                </div>
                            </div>
                        </div>
                    </div>
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