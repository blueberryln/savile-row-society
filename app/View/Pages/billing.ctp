<?php
 
$script = ' var size = ' . json_encode($size) . '; ' .
'$(document).ready(function(){ 
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
	   
       $( "#wear-suite #selectable" ).bind("mousedown", function (e) {
           e.metaKey = false;
           }).selectable({
           stop: function() {
               $("#wear-suit input:checkbox").prop("checked", false);
               $( ".ui-selected", this ).each(function() {
                   var selected_id = $(this).data("id");
                   $("#wear-suite input:checkbox#" + selected_id).prop("checked", true);
               });
           }
       });
       
       if(size){
           $("#shirt-size").val(size.shirt_size);
           $("#us-suit-sizing").val(size.us_suit_sizing);
           $("#denim-size").val(size.denim_size);
           $("#denim-type").val(size.denim_type);
           // $("#wear-suit")

           var denimTypeSelector = "li:contains(\"" + size.denim_kind + "\")";
           $(denimTypeSelector).attr("class", "ui-state-default ui-selectee ui-selected");
           var denimTypeId = $(denimTypeSelector).data("id");
           $("#denim-kind input:checkbox#" + denimTypeId).prop("checked", true);

           var wearSuiteSelector = "li:contains(\"" + size.wear_suit + "\")";
           $(wearSuiteSelector).attr("class", "ui-state-default ui-selectee ui-selected");
           var wearSuiteId = $(wearSuiteSelector).data("id");
           $("#wear-suite input:checkbox#" + wearSuiteId).prop("checked", true);
            
           $("#happy-with-wardrobe").val(size.HappyWithWardrobe);           
           $("#spend-more-then-200-on-jeans").val(size.SpendMoreThen200OnJeans);

            //debugger;
       }
    $("span.size-chart").click(function(){
       $("div#size-chart-box").toggle();           
    });
    
    $("#size-chart-box li").click(function(){
        $("#size-chart-box li").removeClass("selected");
        $(this).addClass("selected");
        var selectedSize = $(this).text();
        $("input#pantSize").val(selectedSize);        
    });    
    
    //$.blockUI({message: $("#signin-box")});
    $.blockUI({message: $("#register-box")});
});
';

$this->Html->css('ui/jquery-ui', null, array('inline' => false));
$this->Html->css('ui/jquery.ui.theme', null, array('inline' => false));
$this->Html->script('http://code.jquery.com/ui/1.10.3/jquery-ui.min.js', array('inline' => false));
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

     <div class="sixteen columns alpha omega text-center  offset-by-three">
        <div class="reg-step3"></div>
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
            <div id="body-shape">
                <h4>WHAT SHAPE IS YOUR BODY?</h4>
                <ul id="selectable-shape">
                    <li><img src="app/webroot/img/blogger-02.jpg" /> BIG OR LARGE</li>
                    <li><img src="app/webroot/img/team-member-06.jpg" /> LEAN/THIN</li>
                    <li><img src="app/webroot/img/team-member-01.jpg" /> AVERAGE</li>
                    <li><img src="app/webroot/img/team-member-06.jpg" /> ATHLETIC</li>
                </ul> 
            </div>
            <div class="clear"></div> 
        </div>        
        <div class="contact-container style-preference">
                <div class="srs-form columns five offset-by-two omega">
                    <div class="form">
                        <div class="input text required">
                            <label for="shirtType">SHIRT TYPE</label>                            
                            <select tabindex="" id="shirtType" >
                                <option value="">SPORT SHIRT</option>
                                <option value="">SPORT SHIRT</option>
                                <option value="">SPORT SHIRT</option>
                                <option value="">SPORT SHIRT</option>
                            </select>
                        </div>
        
                        <div class="input text required">
                            <label for="jeans">WHAT KIND OF JEANS DO YOU WEAR?</label>                            
                            <select tabindex="" id="jeans" >
                                <option value="">RELAXED FIT</option>
                                <option value="">BOOT CUT</option>
                                <option value="">STRAIGHT LEG</option>
                                <option value="">SLIM</option>
                            </select>
                        </div>
        
                        <div class="input text required">
                            <label for="jeans">Tell us a little about you suit size you wear(sizes 36-48)</label>                            
                            <select tabindex="" id="jeans" >
                                <option value="">Size</option>
                                <option value="36">36</option>
                                <option value="38">38</option>
                                <option value="40">40</option>
                                <option value="41">41</option>
                                <option value="42">42</option>
                                <option value="44">44</option>
                                <option value="46">46</option>
                                <option value="48">48</option>                                
                                <option value="Don't know">Don't know</option>
                            </select>
                        </div>
        
                        <div class="input text required">
                            <label for="wardrobe">How happy are you with your wardrobe?</label>                            
                            <select tabindex="" id="wardrobe" >
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
                    </div>
            	</div>
                <div class="srs-form columns five offset-by-two alpha">
                    <div class="form form1">
                        <div class="input text required">
                            <label for="shirtSize">shirt size:</label>                            
                            <select tabindex="" id="shirtSize" >
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
        
                        <div class="input text required pant-size">
                            <label for="pantSize">pant size: <span class="size-chart">SIZE CHART</span></label>
                            <input id="pantSize" type="text" required="required" maxlength="45" readonly />                      
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
                                    <li>xxl</li>
                                    <li>32l</li>
                                    <li>42x32</li>
                                    <li>29x30</li>
                                </ul>
                            </div>
                        </div>
        
                        <div class="input text required">
                            <label for="jeansSpend">Have you ever spend $200 on a pair of jeans</label>                            
                            <select tabindex="" id="jeansSpend" >
                                <option value="">YES</option>
                                <option value="">NO</option>
                                <option value="">STRAIGHT LEG</option>
                                <option value="">SLIM</option>
                            </select>
                        </div>
                             
                        <div class="input text required">
                            <label for="wear">how often do you</label>                            
                            <select tabindex="" id="wear" >
                                <option value="">OPTION 1</option>
                                <option value="">OPTION 2</option>
                                <option value="">OPTION 3</option>
                                <option value="">OPTION 4</option>
                            </select>
                        </div>                              
                    </div>  
                </div>
                    <div class="clear"></div>
                    
                <div class="profile text-center" >
                    <a class="link-btn black-btn" id="confirm-payment" tabindex="25" href="">Continue</a>
                </div>
            </div>
            
        <div class="clearfix"></div>        
    </div>
</div>
<div id="signin-box" class="hide box-modal notification-box">
    <div class="box-modal-inside">
        <a class="notification-close" href=""></a>
        <div class="signin-content">
            <h5 class="sign">SIGN IN</h5>            
            <img src="app/webroot/img/facebook.png" />
            <img src="app/webroot/img/linkedin.png" /> 
            <h6 class="sign-or">OR</h6>   
            <form id="register-form" method="" action="">
                <input type="text" id="register-email" placeholder="EMAIL" />
                <input type="password" id="register-password" placeholder="PASSWORD" />
                
                <div class="text-left signin-options">
                    <input id="remember-me" type="checkbox" />  
                    <label for="remember-me">Remember me</label>                     
                    <span class="forget-passwrd"><a href="">Forgot your password?</a></span> 
                </div>
                 
                <a class="link-btn black-btn signin-btn" href="">SIGN IN</a> 
            </form> 
        </div> 
    </div>
</div>

<div id="register-box" class="hide box-modal notification-box">
    <div class="box-modal-inside">
        <a class="notification-close" href=""></a>
        <div class="signup-content">
            <h5 class="sign">SIGN UP</h5>            
            <img src="app/webroot/img/facebook.png" />
            <img src="app/webroot/img/linkedin.png" /> 
            <h6 class="sign-or">OR</h6>   
            <form id="register-form" method="" action="">
                <input type="text" id="first-name" placeholder="FIRST NAME" />
                <input type="TEXT" id="last-name" placeholder="LAST NAME" />
                <input type="text" id="register-email" placeholder="EMAIL" />
                <input type="password" id="register-password" placeholder="PASSWORD" />
                
                <div class="text-left signup-options">                                       
                    <span class="already-member">Already a Member? <a href="">SIGN IN</a></span> 
                </div>
                 
                <a class="link-btn black-btn signup-btn" href="">SIGN UP</a> 
            </form> 
        </div>
            
        
    </div>
</div>