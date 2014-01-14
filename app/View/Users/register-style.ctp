<?php
$script = ' 
var style = ' . json_encode($style) . ';  
var wear_suit = ' . json_encode($wear_suit) . ';' .
'$(document).ready(function(){ 

        /* Your style */
        $( "#your-style #selectable" ).bind("mousedown", function (e) {
            e.metaKey = false;
            }).selectable({
            stop: function() {
                $("#your-style input:checkbox").prop("checked", false);
                $( ".ui-selected", this ).each(function() {
                    var selected_id = $(this).data("id");
                    $("#your-style input:checkbox#" + selected_id).prop("checked", true);
                });
            }
        });
        /* Suite Frequency */
        $( "#suite-frequency #selectable" ).bind("mousedown", function (e) {
            e.metaKey = false;
            }).selectable({
            stop: function() {
                $("#suite-frequency input:checkbox").prop("checked", false);
                $( ".ui-selected", this ).each(function() {
                    var selected_id = $(this).data("id");
                    $("#suite-frequency input:checkbox#" + selected_id).prop("checked", true);
                });
            }
        });
        function getIdFromString(s){
            switch(s){
                case "Business": return 1;
                case "Lifestyle": return 2;
                case "Complete Overhaul": return 3;
                case "Every Day": return 4;
                case "Couple Times a Week": return 5;
                case "Never": return 6;
                default: return 0;    
            }
        }
        
        // Mark saved style as selected
        var selectedId = getIdFromString(style);
        if(selectedId != 0){
            var liCondition = \'li[data-id = "\' + selectedId + \'"]\';            
            var inputCondition = "#" + selectedId;

            $(liCondition).attr("class", "ui-state-default ui-selectee ui-selected");
            $(inputCondition).prop("checked", true);
        }
        
        // Mark saved wear suit as selected
        var wearSuit = getIdFromString(wear_suit);
        if(selectedId != 0){
            var liCondition = \'li[data-id = "\' + wearSuit + \'"]\';            
            var inputCondition = "#" + wearSuit;

            $(liCondition).attr("class", "ui-state-default ui-selectee ui-selected");
            $(inputCondition).prop("checked", true);
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
<div class="content-container">
    <div class="container content inner preferences register-style">	
        <div class="eight columns text-center page-heading">
            <h1>PROFILE</h1>
        </div>	
        <div class="eight columns register-steps center-block">
            <div class="profile-tabs text-center">
                        <a class="link-btn gray-btn my-style" href="<?php echo $this->webroot; ?>profile/about">My Style</a>
                        <a class="link-btn black-btn my-profile" href="<?php echo $this->webroot; ?>myprofile">My Profile</a>
            </div>
        </div>
        <div class="sixteen columns text-center" id="reg-step">
            <div class="reg-step2"><img src="<?php echo $this->webroot; ?>img/reg-step2.png"/></div>
        </div>
        <div class="nine columns center-block">
            <?php echo $this->Form->create('User', array('url' => '/register/saveStyle', 'id' => 'register-size')); ?>
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
                    <input class="hide" type="checkbox" name="data[UserPreference][Style]" value="Business" id="1" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Style]" value="Lifestyle" id="2" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Style]" value="Complete Overhaul" id="3" />
                    <ol id="selectable">
                        <li class="ui-state-default" data-id="1"><img src="<?php echo $this->request->webroot; ?>img/preferences/your-style-1.jpg" class="fadein-image" /><br/>Business</li>
                        <li class="ui-state-default" data-id="2"><img src="<?php echo $this->request->webroot; ?>img/preferences/your-style-2.jpg" class="fadein-image" /><br/>Lifestyle</li>
                        <li class="ui-state-default" data-id="3"><img src="<?php echo $this->request->webroot; ?>img/preferences/your-style-3.jpg" class="fadein-image" /><br/>Complete Overhaul</li>
                    </ol>
                </div>
            </div><br/>
            <div class="hi-message fourteen columns">
                
                <h4>Your suit wearing frequency</h4>
                <p>
                    To better understand your needs we'd like to know your suit wearing frequency 
                </p>
                <input type="hidden" value="<?php echo $user_id ?>" name="data[User][id]" />
            </div>
            <div class="twelve columns">
                <!--<h5>To better understand your needs <br/>we’d like to know if your focus is</h5>-->
                <div id="suite-frequency">
                    <input class="hide" type="checkbox" name="data[UserPreference][wear_suit]" value="Every Day" id="4" />
                    <input class="hide" type="checkbox" name="data[UserPreference][wear_suit]" value="Couple Times a Week" id="5" />
                    <input class="hide" type="checkbox" name="data[UserPreference][wear_suit]" value="Never" id="6" />
                    <ol id="selectable">
                        <li class="ui-state-default" data-id="4"><img src="<?php echo $this->request->webroot; ?>img/preferences/frequency-1.png" class="fadein-image" /><br/>Every Day</li>
                        <li class="ui-state-default" data-id="5"><img src="<?php echo $this->request->webroot; ?>img/preferences/frequency-2.png" class="fadein-image" /><br/>Couple Times a Week</li>
                        <li class="ui-state-default" data-id="6"><img src="<?php echo $this->request->webroot; ?>img/preferences/frequency-3.jpg" class="fadein-image" /><br/>Never</li>
                    </ol>
                </div>
            </div>
            <div class="clear-fix"></div>
            <div class="text-center about-submit">
                         <br/>
                            <!--<?php echo $this->Form->end(__('Continue')); ?>-->
                            <div class="submit">                            
                                <a class="link-btn black-btn back-btn" href="<?php echo $this->webroot; ?>profile/about">Back</a> 
                                <input type="submit" value="Continue" />      
                            </div>                 
                         </form>
            </div>
        </div>
    </div>
</div>