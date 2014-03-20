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
<div class="content-container">
    <div class="container content inner preferences register-style">	
        <div class="eight columns register-steps center-block">
            <div class="profile-tabs text-center">
                <a class="link-btn gold-btn my-style" href="<?php echo $this->webroot; ?>profile/about">My Style</a>
                <a class="link-btn black-btn my-profile" href="<?php echo $this->webroot; ?>myprofile">My Profile</a>
            </div>

            <h1 class="text-center">Your wardrobe needs</h1>
        </div>
        <div class="nine columns center-block">
            <?php echo $this->Form->create('User', array('url' => '/register/saveWardrobe', 'id' => 'register-wardrobe')); ?>
            <div class="hi-message twelve columns">
                
                <h4>Your stylist should focus on</h4>
                <p>
                    To better understand your needs we'd like to know if your focus in 
                </p>
                <input type="hidden" value="<?php echo $user_id ?>" name="data[User][id]" />
            </div>
            
            <div class="twelve columns">
                <!--<h5>To better understand your needs <br/>we’d like to know if your focus is</h5>-->
                <div id="your-style">
                    <input class="hide" type="checkbox" name="data[UserPreference][Style][]" value="Formal" id="1" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Style][]" value="Casual" id="2" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Style][]" value="Business Casual" id="3" />
                    <ol id="selectable">
                        <li class="ui-state-default" data-id="2"><img src="<?php echo $this->request->webroot; ?>img/preferences/your-style-2.jpg" class="fadein-image" /><br/>Casual</li>
                        <li class="ui-state-default" data-id="3"><img src="<?php echo $this->request->webroot; ?>img/preferences/your-style-3.png" class="fadein-image" /><br/>Business Casual</li>
                        <li class="ui-state-default" data-id="1"><img src="<?php echo $this->request->webroot; ?>img/preferences/your-style-1.jpg" class="fadein-image" /><br/>Formal</li>
                    </ol>
                </div>
            </div><br/>
            <div class="hi-message fourteen columns">
                
                <h4>Made To Measure</h4>
                <img src="<?php echo $this->request->webroot; ?>img/booking-1.jpg" alt="">
                <div class="clear-fix"></div>
                <br />
                <div class="form form1 text-center columns seven center-block">
                    <label for="madeToMeasure">Are you interested in our Made-to-Measure collection?</label> 
                    <div class="input text">                          
                        <select name="data[UserPreference][made_to_measure]" tabindex="" id="madeToMeasure" >
                            <option value="">Are you interested?</option>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="clear-fix"></div>
            <div class="text-center about-submit">
                         <br/>
                            <!--<?php echo $this->Form->end(__('Continue')); ?>-->
                            <div class="submit">                            
                                <a class="link-btn black-btn back-btn" href="<?php echo $this->webroot; ?>profile/about">Back</a> 
                                <input type="submit" value="Continue" />   
                                <p class="error-msg">All the fields are mandatory.</p>   
                            </div>                 
                         </form>
            </div>
        </div>
    </div>
</div>