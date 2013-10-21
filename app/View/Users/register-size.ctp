<?php
 
$script = ' var size = ' . json_encode($size) . '; ' .
' $(document).ready(function(){ 
            
        /* Your size */
        function toFeet(n) {
            return Math.floor(n / 12) + "\'" + (n % 12) + \'"\';
        }
        function toInches(n){
            return Math.floor(n / 12) * 12 + (n % 12);
        }
	// alert(toFeet(size.height));    
       $( "#height-slider" ).slider({
			min: 60,
			max: 84,
			step: 1,
			value: (size) ? size.height : 70,       
           slide: function( event, ui ) {
               $( "#height-result-display" ).val( toFeet(ui.value) );
               $( "#height-result").val( toInches(ui.value) );
           }
       });
       $( "#weight-slider" ).slider({
			min: 100,
			max: 350,
			step: 5,
			value: (size) ? size.weight.split(" lbs")[0] : 180,     
           slide: function( event, ui ) {
               $( "#weight-result" ).val( ui.value + " lbs" );
           }
       });
       
       $( "#height-result-display" ).val( toFeet($( "#height-slider" ).slider( "value" )) );
       $( "#height-result" ).val( toInches($( "#height-slider" ).slider( "value" )) );
       $( "#weight-result" ).val( $( "#weight-slider" ).slider( "value" ) + " lbs");

       $( "#denim-kind #selectable" ).bind("mousedown", function (e) {
           e.metaKey = false;
           }).selectable({
           stop: function() {
               $("#denim-kind input:checkbox").prop("checked", false);
               $( ".ui-selected", this ).each(function() {
                   var selected_id = $(this).data("id");
                   $("#denim-kind input:checkbox#" + selected_id).prop("checked", true);
               });
           }
       });
       
       if(size){
           $("#shirtSize").val(size.shirt_size);
           $("#suit_sizing").val(size.us_suit_sizing);
           $("#pantSize").val(size.pant_size);
           $("#jeans").val(size.denim_kind);
           $("#shirtType").val(size.shirt_type);
           if(size.shirt_type == "dress"){
                $(".chest-size").css({"display" : "block"});
                $("#chestSize").val(size.chest_size); 
           }
           
           if(size.body_shape){
                var selectedId = getIdFromString(size.body_shape);
                if(selectedId != 0){
                    var liCondition = \'li[data-id = "\' + selectedId + \'"]\';
                    var inputCondition = "#" + selectedId;
                
                    $(liCondition).addClass("selected");
                    $(inputCondition).prop("checked", true);
                }
            }

           //var denimTypeSelector = "li:contains(\"" + size.denim_kind + "\")";
//           $(denimTypeSelector).attr("class", "ui-state-default ui-selectee ui-selected");
//           var denimTypeId = $(denimTypeSelector).data("id");
//           $("#denim-kind input:checkbox#" + denimTypeId).prop("checked", true);
//
//           var wearSuiteSelector = "li:contains(\"" + size.wear_suit + "\")";
//           $(wearSuiteSelector).attr("class", "ui-state-default ui-selectee ui-selected");
//           var wearSuiteId = $(wearSuiteSelector).data("id");
//           $("#wear-suite input:checkbox#" + wearSuiteId).prop("checked", true);
            
           $("#wardrobe").val(size.HappyWithWardrobe);           
           $("#jeansSpend").val(size.SpendMoreThen200OnJeans);

            //debugger;
       }

        function getIdFromString(s){
            switch(s){
                case "BIG OR LARGE": return 1;                
                case "AVERAGE": return 2;
                case "ATHLETIC": return 3;
                default: return 0;
            }
        }

         $("span.size-chart").click(function(){
            if($("div#size-chart-box").is(":visible")) {
                $("div#size-chart-box").slideUp(300); 
            }
            else {
                $("div#size-chart-box").slideDown(300);
            }
         }); 
         
         $("#pantSize").click(function(){
            if($("div#size-chart-box").is(":visible")) {
                $("div#size-chart-box").slideUp(300); 
            }
            else {
                $("div#size-chart-box").slideDown(300);
            }
         });    
         
    
         $("#size-chart-box li").click(function(){
            $("#size-chart-box li").removeClass("selected");
            $(this).addClass("selected");
            var selectedSize = $(this).text();
            $("input#pantSize").val(selectedSize);
            $("#size-chart-box").slideUp(500);        
         }); 
         
         $("#selectable-shape li").click(function(){
            $("#selectable-shape li").removeClass("selected");
            $(this).addClass("selected");

            $("#body-shape input:checkbox").prop("checked", false);
            var selected_id = $(this).data("id");
            $("#body-shape input:checkbox#" + selected_id).prop("checked", true);
         });
         
         $("#shirtType").change(function(){
            if($("#shirtType option:selected").val() == "dress")
            {
            $(".chest-size").slideDown(300);
            }else
            {
            $(".chest-size").slideUp(300);
            }
        });
});
$(document).mouseup(function(e) {
    var sizeBox = $("#size-chart-box");
    if(sizeBox.is(":visible") && sizeBox.has(e.target).length == 0) {
        sizeBox.slideUp(300); 
    }
});   
';

$this->Html->css('ui/jquery-ui', null, array('inline' => false));
$this->Html->css('ui/jquery.ui.theme', null, array('inline' => false));
$this->Html->script('//code.jquery.com/ui/1.10.3/jquery-ui.min.js', array('inline' => false));
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



<div class="container content inner preferences register-size">	

    <div class="sixteen columns text-center">
        <h1>PROFILE</h1>
    </div>	
    <div class="fifteen columns offset-by-half register-steps">
        <div class="profile-tabs text-center">
                    <a class="link-btn gold-btn" href="<?php echo $this->webroot; ?>profile/about">My Style</a>
                    <a class="link-btn gray-btn" href="<?php echo $this->webroot; ?>myprofile">My Profile</a>
        </div>
    </div>
    <div class="sixteen columns text-center">
        <div class="reg-step3"><img src="<?php echo $this->webroot; ?>img/reg-step3.png"/></div>
    </div>
    <div class="sixteen columns about">
        <?php echo $this->Form->create('User', array('url' => '/register/saveSize')); ?>
        <input type="hidden" value="<?php echo $user_id ?>" name="data[User][id]" />
        <div class="hi-message fourteen columns offset-by-two alpha omega">
            <h4 class="hi-message">Just a little information</h4>
            <p>
                
            </p>
        </div>
        
        <div class="twelve columns offset-by-two alpha omega text-center size-info">
            <h5 class="text-left">Measure up</h5>
            <div id="height" class="five columns alpha text-center">
                <label for="height-result">Height:</label>
                <div id="height-slider" class="slider"></div>
                <input type="text" id="height-result-display" name="data[UserPreference][Size][height]" class="five columns alpha omega text-center result" />
                <input type="hidden" id="height-result" name="data[UserPreference][Size][height]" />
            </div>
            <div id="weight" class="five columns offset-by-two alpha text-center">
                <label for="weight-result">Weight:</label>
                <div id="weight-slider" class="slider"></div>
                <input type="text" id="weight-result" name="data[UserPreference][Size][weight]" class="five columns alpha omega text-center result" />
            </div>
            <div class="clear"></div>
            <div id="body-shape" class="twelve columns alpha omega text-center">
                <h4>WHAT SHAPE IS YOUR BODY?</h4>
                <input class="hide" type="checkbox" name="data[UserPreference][Size][body_shape]" value="BIG OR LARGE" id="1" />
                <input class="hide" type="checkbox" name="data[UserPreference][Size][body_shape]" value="AVERAGE" id="2" />
                <input class="hide" type="checkbox" name="data[UserPreference][Size][body_shape]" value="ATHLETIC" id="3" />
                <ul id="selectable-shape">
                    <li data-id="1"><img src="<?php echo $this->webroot; ?>img/body-shape-1.jpg" class="fadein-image" />BIG OR LARGE</li>                    
                    <li data-id="2"><img src="<?php echo $this->webroot; ?>img/body-shape-2.jpg" class="fadein-image" />AVERAGE</li>
                    <li data-id="3"><img src="<?php echo $this->webroot; ?>img/body-shape-3.jpg" class="fadein-image" />ATHLETIC</li>
                </ul> 
            </div>  
        </div>
        
         <div class="contact-container style-preference">
                <div class="srs-form columns five offset-by-two omega">
                    <div class="form">
                        <div class="input text required">
                            <label for="shirtType">SHIRT TYPE</label>                            
                            <select name="data[UserPreference][Size][shirt_type]" tabindex="" id="shirtType" >
                                <option value="">SELECT SHIRT TYPE</option>
                                <option value="sport">SPORT SHIRT</option>
                                <option value="dress">DRESS SHIRT</option>
                            </select>
                        </div>
        
                        <div class="input text required">
                            <label for="jeans">WHAT KIND OF JEANS DO YOU WEAR?</label>                            
                            <select name="data[UserPreference][Size][denim_kind]" tabindex="" id="jeans" >
                                <option value="DON'T KNOW">DON'T KNOW</option>
                                <option value="RELAXED FIT">RELAXED FIT</option>
                                <option value="BOOT CUT">BOOT CUT</option>
                                <option value="STRAIGHT LEG">STRAIGHT LEG</option>
                                <option value="SLIM">SLIM</option>
                                <option value="EXTRA SLIM">EXTRA SLIM</option>
                            </select>
                        </div>
        
                        <div class="input text required">
                            <label for="jeans">Tell us a little about your suit size you wear (sizes 36-48)</label>                            
                            <select name="data[UserPreference][Size][us_suit_sizing]" tabindex="" id="suit_sizing" >
                                <option value="">Size</option>
                                <option value="36">36</option>
                                <option value="38">38</option>
                                <option value="40">40</option>
                                <option value="41">41</option>
                                <option value="42">42</option>
                                <option value="44">44</option>
                                <option value="46">46</option>
                                <option value="48">48</option>                                
                                <option value="Other">Other</option>                                
                                <option value="Don't know">Don't know</option>
                            </select>
                        </div>
        
                        <div class="input text required">
                            <label for="wardrobe">How happy are you with your wardrobe?</label>                            
                            <select name="data[UserPreference][Size][HappyWithWardrobe]" tabindex="" id="wardrobe" >
                                <option value="Very Happy">Very Happy</option>
                                <option value="Happy">Happy</option>
                                <option value="Not Very Happy">Not Very Happy</option>
                                <option value="Not Happy">Not Happy</option>                                
                            </select>
                        </div>
                    </div>
            	</div>
                <div class="srs-form columns five offset-by-two alpha">
                    <div class="form form1">
                        <div class="input text required">
                            <label for="shirtSize">shirt size:</label>                            
                            <select name="data[UserPreference][Size][shirt_size]" tabindex="" id="shirtSize" >
                                <option value="">Size</option>
                                <option value="14">14</option>
                                <option value="14.5">14.5</option>
                                <option value="15">15</option>
                                <option value="15.5">15.5</option>
                                <option value="16">16</option>
                                <option value="16.5">16.5</option>
                                <option value="17">17</option>
                                <option value="17.5">17.5</option>
                                <option value="Other">Other</option>
                                <option value="Don't know">Don't know</option>
                            </select>
                        </div>
                        <div class="input text required chest-size">
                            <label for="chestSize">Chest size:</label>                            
                            <select name="data[UserPreference][Size][chest_size]" tabindex="" id="chestSize" >
                                <option value="">Size</option>
                                <option value="37">37</option>
                                <option value="38">38</option>
                                <option value="39">39</option>
                                <option value="40">40</option>
                                <option value="41">41</option>
                                <option value="42">42</option>
                                <option value="43">43</option>
                                <option value="44">44</option>
                                <option value="Other">Other</option>
                                <option value="Don't know">Don't know</option>
                            </select>
                        </div>
        
                        <div class="input text required pant-size">
                            <label for="">pant size: <span class="size-chart">SIZE CHART</span></label>
                            <input id="pantSize" type="text" name="data[UserPreference][Size][pant_size]" required="required" maxlength="45" readonly />                      
                            <div id="size-chart-box">
                                <ul>
                                    <li>s</li>
                                    <li>m</li>
                                    <li>l</li>
                                    <li>xl</li>
                                    <li>xxl</li>
                                    <li>28</li>
                                    <li>29</li>
                                    <li>30</li>                                    
                                    <li>31</li>
                                    <li>32</li>
                                    <li>32l</li>
                                    <li>33</li>
                                    <li>34</li>
                                    <li>34l</li>
                                    <li>35</li>
                                    <li>36</li>
                                    <li>36l</li>
                                    <li>38</li>
                                    <li>40</li>
                                    <li>28x30</li>
                                    <li>28x32</li>
                                    <li>28x34</li>
                                    <li>29x30</li>
                                    <li>29x32</li>                                    
                                    <li>29x34</li>
                                    <li>30x30</li>
                                    <li>30x32</li>
                                    <li>30x34</li>
                                    <li>31x30</li>
                                    <li>31x32</li>
                                    <li>31x34</li>
                                    <li>32x30</li>
                                    <li>32x32</li>
                                    <li>32x34</li>
                                    <li>33x30</li>
                                    <li>33x32</li>
                                    <li>33x34</li>
                                    <li>34x30</li>
                                    <li>34x32</li>                                    
                                    <li>34x34</li>
                                    <li>35x30</li>
                                    <li>35x32</li>
                                    <li>36x30</li>
                                    <li>36x32</li>
                                    <li>36x34</li>
                                    <li>38x32</li>
                                    <li>35x34</li>
                                    <li>40x30</li>
                                    <li>40x32</li>
                                    <li>40x34</li>
                                    <li>42x30</li>
                                    <li>42x32</li>
                                    <li>42x34</li>
                                    <li>34/34</li>
                                </ul>
                            </div>
                        </div>
        
                        <div class="input text required">
                            <label for="jeansSpend">Have you ever spend $200 on a pair of jeans</label>                            
                            <select name="data[UserPreference][Size][SpendMoreThen200OnJeans]" tabindex="" id="jeansSpend" >
                                <option value="YES">YES</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                             
                                                      
                    </div>  
                </div>
                    
                <div class="clear"></div>
                <div class="text-center about-submit">
                     <br/>
                        <!--<?php echo $this->Form->end(__('Continue')); ?>-->
                        <div class="submit">                            
                            <a class="link-btn black-btn back-btn" href="<?php echo $this->webroot; ?>users/register/style/<?php echo $user_id; ?>">Back</a> 
                            <input type="submit" value="Continue" />                                                       
                        </div>                        
                     <br/>
                     </form>
                </div>
            </div>
        
        <!--<div class="twelve columns offset-by-two alpha omega text-center">
            <h5>Measure up</h5>
            <div id="height" class="three columns alpha text-center">
                <label for="height-result">Height:</label>
                <div id="height-slider" class="slider"></div>
                <input type="text" id="height-result-display" name="data[UserPreference][Size][height]" class="three columns alpha omega text-center result" />
                <input type="hidden" id="height-result" name="data[UserPreference][Size][height]" />
            </div>
            <div id="weight" class="three columns alpha text-center">
                <label for="weight-result">Weight:</label>
                <div id="weight-slider" class="slider"></div>
                <input type="text" id="weight-result" name="data[UserPreference][Size][weight]" class="three columns alpha omega text-center result" />
            </div>
            <div id="size" class="three columns omega text-center">
                <label for="shirt-size">Shirt size:</label>
                <select name="data[UserPreference][Size][shirt_size]" id="shirt-size" required=required >
                    <option value="">Size</option>
                    <option value="14">14</option>
                    <option value="14.5">14.5</option>
                    <option value="15">15</option>
                    <option value="15.5">15.5</option>
                    <option value="16">16</option>
                    <option value="16.5">16.5</option>
                    <option value="17">17</option>
                    <option value="17.5">17.5</option>
                    <option value="Other">Other</option>
                    <option value="Don't know">Don't know</option>
                </select>
            </div>
        
        
            <div id="size" class="three columns omega text-center">
                <label for="denim-size">Denim size:</label>	
                <select name="data[UserPreference][Size][denim_size]" id="denim-size" required=required >
                    <option value="">Size</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                    <option value="32">32</option>
                    <option value="33">33</option>
                    <option value="34">34</option>
                    <option value="36">36</option>
                    <option value="38">38</option>
                    <option value="40">40</option>
                    <option value="42">42</option>
                    <option value="Other">Other</option>
                    <option value="Don't know">Don't know</option>
                </select>
            </div>
            <div class="clearfix"></div>

            <div id="denim">
                <h4>
                    What kind of
                    <select name="data[UserPreference][Size][denim_type]" id="denim-type" required=required >
                        <option value="Jeans">jeans</option>
                        <option value="Pants">pants</option>
                    </select>
                    do you wear?
                </h4>
                <div id="denim-kind">
                    <input class="hide" type="checkbox" name="data[UserPreference][Size][denim_kind]" value="Relaxed fit" id="1" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Size][denim_kind]" value="Boot cut" id="2" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Size][denim_kind]" value="Straight leg" id="3" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Size][denim_kind]" value="Slim" id="4" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Size][denim_kind]" value="Extra slim" id="5" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Size][denim_kind]" value="Don't know" id="6" />
                    <ol id="selectable">
                        <li class="ui-state-default" data-id="1">Relaxed fit</li>
                        <li class="ui-state-default" data-id="2">Boot cut</li>
                        <li class="ui-state-default" data-id="3">Straight leg</li>
                        <li class="ui-state-default" data-id="4">Slim</li>
                        <li class="ui-state-default" data-id="5">Extra slim</li>
                        <li class="ui-state-default" data-id="6">Don't know</li>
                    </ol>
                </div>
                <div class="clearfix"></div>
                <h4>Have you ever spend $200 on a pair of jeans</h4>
                <div class="twelve columns alpha omega text-center">
                    <select name="data[UserPreference][Size][SpendMoreThen200OnJeans]" id="spend-more-then-200-on-jeans" required=required >
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="clearfix"></div>

                <h4>Tell us a little about you wearing suits</h4>
                <div class="twelve columns alpha omega text-center">
                    <label for="denim-size">US suit sizing</label>
                    <select name="data[UserPreference][Size][us_suit_sizing]" id="us-suit-sizing" required=required >
                        <option value="">Size</option>
                        <option value="38">38</option>
                        <option value="40">40</option>
                        <option value="41">41</option>
                        <option value="42">42</option>
                        <option value="44">44</option>
                        <option value="46">46</option>
                        <option value="48">48</option>
                        <option value="50">50</option>
                        <option value="52">52</option>
                        <option value="54">54</option>
                        <option value="56">56</option>
                        <option value="58">58</option>
                        <option value="Don't know">Don't know</option>
                    </select>
                    <br/><br/>
                </div>

                <div class="clearfix"></div>
                
                <div id="wear-suite" class="twelve columns alpha omega text-center">
                    <input class="hide" type="checkbox" name="data[UserPreference][Size][wear_suit]" value="Only on special occasions" id="1" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Size][wear_suit]" value="1-3 times a week" id="2" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Size][wear_suit]" value="All week" id="3" />
                    <ol id="selectable">
                        <li class="ui-state-default" data-id="1">Only on special occasions</li>
                        <li class="ui-state-default" data-id="2">1-3 times a week</li>
                        <li class="ui-state-default" data-id="3">All week</li>
                    </ol>
                </div>
                <div class="clearfix"></div>
                
            </div>
        </div>
        <div class="thirteen columns offset-by-two alpha omega text-center">
            <h4>How happy are you with your current wardrobe on a scale of 1-10?</h4>
                 <div class="twelve columns alpha omega text-center">
                    <select name="data[UserPreference][Size][HappyWithWardrobe]" id="happy-with-wardrobe" required=required >
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>
        </div>-->
        
    </div>
</div>

<script>
   
</script>