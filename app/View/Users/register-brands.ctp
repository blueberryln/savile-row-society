<?php
$script = ' var brands = ' . json_encode($brands) . '; ' .
' $(document).ready(function(){ 
	   
        /* Brands */
       $( "#polos_tees-brands #selectable" ).bind("mousedown", function(e) {
         e.metaKey = true;
       }).selectable({
           stop: function() {
               $("#polos_tees-brands input:checkbox").prop("checked", false);
               $( ".ui-selected", this ).each(function() {  
                   $("p.error-msg").slideUp(300);
                   var selected_id = $(this).data("id");
                   $("#polos_tees-brands input:checkbox#" + selected_id).prop("checked", true);
               });
           }
       });
	   
       $( "#shirt-brands #selectable" ).bind("mousedown", function(e) {
         e.metaKey = true;
       }).selectable({
           stop: function() {
               $("#shirt-brands input:checkbox").prop("checked", false);
               $( ".ui-selected", this ).each(function() {
                   $("p.error-msg").slideUp(300);
                   var selected_id = $(this).data("id");
                   $("#shirt-brands input:checkbox#" + selected_id).prop("checked", true);
               });
           }
       });
	   
       $( "#pants-brands #selectable" ).bind("mousedown", function(e) {
         e.metaKey = true;
       }).selectable({
           stop: function() {
               $("#pants-brands input:checkbox").prop("checked", false);
               $( ".ui-selected", this ).each(function() {
                   $("p.error-msg").slideUp(300);
                   var selected_id = $(this).data("id");
                   $("#pants-brands input:checkbox#" + selected_id).prop("checked", true);
               });
           }
       });
	   
       $( "#jeans-brands #selectable" ).bind("mousedown", function(e) {
         e.metaKey = true;
       }).selectable({
           stop: function() {
               $("#jeans-brands input:checkbox").prop("checked", false);
               $( ".ui-selected", this ).each(function() {
                   $("p.error-msg").slideUp(300);
                   var selected_id = $(this).data("id");
                   $("#jeans-brands input:checkbox#" + selected_id).prop("checked", true);
               });
           }
       });
	   
       $( "#suits-brands #selectable" ).bind("mousedown", function(e) {
         e.metaKey = true;
       }).selectable({
           stop: function() {
               $("#suits-brands input:checkbox").prop("checked", false);
               $( ".ui-selected", this ).each(function() {
                   $("p.error-msg").slideUp(300);
                   var selected_id = $(this).data("id");
                   $("#suits-brands input:checkbox#" + selected_id).prop("checked", true);
               });
           }
       });
       
       if(brands){
            if(brands.polos_tees){
                for(var i = 0; i<brands.polos_tees.length; i++){
                    $("#polos_tees-brands > ol > li").each(function(){
                        if($(this).find("img").attr("alt") == brands.polos_tees[i]){
                            $(this).attr("class", "ui-state-default ui-selectee ui-selected"); 
                            var id = $(this).data("id");
                            $("#polos_tees-brands input:checkbox#" +  id).prop("checked", true);   
                        }
                    });
                }
            }
            if(brands.shirts){
                for(var i = 0; i<brands.shirts.length; i++){
                    $("#shirt-brands > ol > li").each(function(){
                        if($(this).find("img").attr("alt") == brands.shirts[i]){
                            $(this).attr("class", "ui-state-default ui-selectee ui-selected"); 
                            var id = $(this).data("id");
                            $("#shirt-brands input:checkbox#" +  id).prop("checked", true);   
                        }
                    });
                }
            }
            if(brands.pants){
                for(var i = 0; i<brands.pants.length; i++){
                    $("#pants-brands > ol > li").each(function(){
                        if($(this).find("img").attr("alt") == brands.pants[i]){
                            $(this).attr("class", "ui-state-default ui-selectee ui-selected"); 
                            var id = $(this).data("id");
                            $("#pants-brands input:checkbox#" +  id).prop("checked", true);   
                        }
                    });
                }
            }
            if(brands.jeans){
                for(var i = 0; i<brands.jeans.length; i++){
                    $("#jeans-brands > ol > li").each(function(){
                        if($(this).find("img").attr("alt") == brands.jeans[i]){
                            $(this).attr("class", "ui-state-default ui-selectee ui-selected"); 
                            var id = $(this).data("id");
                            $("#jeans-brands input:checkbox#" +  id).prop("checked", true);   
                        }
                    });
                }
            }
            if(brands.suits){
                for(var i = 0; i<brands.suits.length; i++){
                    $("#suits-brands > ol > li").each(function(){
                        if($(this).find("img").attr("alt") == brands.suits[i]){
                            $(this).attr("class", "ui-state-default ui-selectee ui-selected"); 
                            var id = $(this).data("id");
                            $("#suits-brands input:checkbox#" +  id).prop("checked", true);   
                        }
                    });
                }
            }
       }       
       
       $("ul.product-type li").click(function(){
            $("ul.product-type li").removeClass("selected");
            $(this).addClass("selected");           
       });
       
       $("#brands-continue").click(function(event){                
        if($("#polos_tees-brands li.ui-selected").length > 0 && $("#shirt-brands li.ui-selected").length > 0 && $("#pants-brands li.ui-selected").length > 0 && $("#jeans-brands li.ui-selected").length > 0 && $("#suits-brands li.ui-selected").length > 0)
        {
              $("p.error-msg").slideUp(300);                    
        }else{
            $("p.error-msg").slideDown(300);   
            $("div#brands>div.brand-block").each(function(){
                if($(this).find("li.ui-selected").length == 0)
                {
                    $("div#brands>div.brand-block").hide();
                    $(this).show();
                    $("ul.product-type li").removeClass("selected");
                    $("ul.product-type li").has("a[data-tab=\'" + $(this).attr("id") + "\']").addClass("selected");                                         
                    return false;
                }
            });
            
            event.preventDefault();     
        }
       });       
       
});
';
$this->Html->css('ui/jquery-ui', null, array('inline' => false));
$this->Html->css('ui/jquery.ui.theme', null, array('inline' => false));
$this->Html->script('//code.jquery.com/ui/1.10.3/jquery-ui.min.js', array('inline' => false));
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->script('brands.js', array('inline' => false));



$meta_description = 'Sign up for Savile Row Society, a groundbreaking online, personalized fashion service.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>

<script>
window.registerProcess = true;
</script>
<div class="content-container">
  <div class="eleven columns container content inner preferences register-brands">	
      <div class="eight columns text-center page-heading">
          <h1>PROFILE</h1>
      </div>	
      <div class="eight columns register-steps center-block">
          <div class="profile-tabs text-center">
                      <a class="link-btn gray-btn my-style" href="<?php echo $this->webroot; ?>profile/about">My Style</a>
                      <a class="link-btn black-btn my-profile" href="<?php echo $this->webroot; ?>myprofile">My Profile</a>
          </div>
      </div>
      <div class="twelve columns text-center" id="reg-step">
          <div class="reg-step4"><img src="<?php echo $this->webroot; ?>img/reg-step4.png"/></div>
      </div>

      <div class="twelve columns">
          <?php echo $this->Form->create('User', array('url' => '/register/saveBrands')); ?>
          <input type="hidden" value="<?php echo $user_id ?>" name="data[User][id]" />
          <div class="hi-message twelve columns text-center">
              <h4 class="hi-message">Brands you prefer</h4>
              <p></p>
          </div>        
          <div class="twelve columns center-block">
              <ul class="product-type">
                  <li class="selected">
                      <a data-tab="polos_tees-brands" class="brand-link" data-origin-css='brands-pools'>
                          <span>Polos &amp; tees</span>
                      </a>
                  </li>
                   <li>
                      <a data-tab="jeans-brands" class="brand-link" data-origin-css='brands-jeans'>
                          <span>Jeans</span>
                      </a>
                  </li>
                   <li>
                      <a data-tab="pants-brands" class="brand-link" data-origin-css='brands-pants'>
                          <span>Pants</span>
                      </a>
                  </li>
                   <li>
                      <a data-tab="shirt-brands" class="brand-link" data-origin-css='brands-shirts'>
                          <span>Shirts</span>
                      </a>
                  </li>
                  <li>
                      <a data-tab="suits-brands" class="brand-link" data-origin-css='brands-suits'>
                          <span>Suits</span>
                      </a>
                  </li>
              </ul>
          </div>
          <div>
              <div id="brands" >
                  <div id="polos_tees-brands" class="brand-block">
                     
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][polos_tees][]" value="Hugo Boss" id="1" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][polos_tees][]" value="Banana Republic" id="2" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][polos_tees][]" value="Calvin Klein" id="3" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][polos_tees][]" value="J. Crew" id="4" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][polos_tees][]" value="Lacoste" id="5" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][polos_tees][]" value="Nike" id="6" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][polos_tees][]" value="Peter Miller" id="7" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][polos_tees][]" value="John Varvatos" id="8" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][polos_tees][]" value="Polo Ralph Lauren" id="9" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][polos_tees][]" value="Vineyard Vines" id="10" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][polos_tees][]" value="VK Nagrani" id="11" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][polos_tees][]" value="Agave" id="12" />
                      <ol id="selectable" class="brands-logo">
                          <li class="ui-state-default" data-id="1"><img src="<?php echo $this->webroot; ?>img/brands/tees/hugo-boss.jpg" class="fadein-image" alt="Hugo Boss" /></li>
                          <li class="ui-state-default" data-id="2"><img src="<?php echo $this->webroot; ?>img/brands/tees/banana-replublic.jpg" class="fadein-image" alt="Banana Republic" /></li>
                          <li class="ui-state-default" data-id="3"><img src="<?php echo $this->webroot; ?>img/brands/tees/calvin-klein.jpg" class="fadein-image" alt="Calvin Klein" /></li>
                          <li class="ui-state-default" data-id="4"><img src="<?php echo $this->webroot; ?>img/brands/tees/jcrew.jpg" class="fadein-image" alt="J. Crew" /></li>
                          <li class="ui-state-default" data-id="5"><img src="<?php echo $this->webroot; ?>img/brands/tees/lacoste.jpg" class="fadein-image" alt="Lacoste" /></li>
                          <li class="ui-state-default" data-id="6"><img src="<?php echo $this->webroot; ?>img/brands/tees/nike.jpg" class="fadein-image" alt="Nike" /></li>
                          <li class="ui-state-default" data-id="7"><img src="<?php echo $this->webroot; ?>img/brands/tees/peter-millar.jpg" class="fadein-image" alt="Peter Miller" /></li>
                          <li class="ui-state-default" data-id="8"><img src="<?php echo $this->webroot; ?>img/brands/tees/john-varvatos.jpg" class="fadein-image" alt="John Varvatos" /></li>
                          <li class="ui-state-default" data-id="9"><img src="<?php echo $this->webroot; ?>img/brands/tees/ralph-lauren.jpg" class="fadein-image" alt="Polo Ralph Lauren" /></li>
                          <li class="ui-state-default" data-id="10"><img src="<?php echo $this->webroot; ?>img/brands/tees/vineyard-vines.jpg" class="fadein-image" alt="Vineyard Vines" /></li>
                          <li class="ui-state-default" data-id="11"><img src="<?php echo $this->webroot; ?>img/brands/tees/vknagrani.png" class="fadein-image" alt="VK Nagrani" /></li>
                          <li class="ui-state-default" data-id="12"><img src="<?php echo $this->webroot; ?>img/brands/tees/agave.jpg" class="fadein-image" alt="Agave" /></li>
                      </ol>
                  </div>
                  <div class="clear"></div>
                  
                   <div id="jeans-brands" class="brand-block hide">
                     

                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][jeans][]" value="Acne" id="1" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][jeans][]" value="Adriano Goldschmied" id="2" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][jeans][]" value="Diesel" id="3" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][jeans][]" value="Levis" id="4" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][jeans][]" value="Burberry" id="5" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][jeans][]" value="J brand Denim" id="6" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][jeans][]" value="Lucky Brand" id="7" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][jeans][]" value="Rag & Bone" id="8" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][jeans][]" value="7 for all Mankind Jeans" id="9" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][jeans][]" value="True Religion" id="10" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][jeans][]" value="Big Star" id="11" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][jeans][]" value="Agave" id="12" />
                      <ol id="selectable" class="brands-logo">
                          <li class="ui-state-default" data-id="1"><img src="<?php echo $this->webroot; ?>img/brands/jeans/acne.jpg" class="fadein-image" alt="Acne" /></li>
                          <li class="ui-state-default" data-id="2"><img src="<?php echo $this->webroot; ?>img/brands/jeans/adriano.jpg" class="fadein-image" alt="Adriano Goldschmied" /></li>
                          <li class="ui-state-default" data-id="3"><img src="<?php echo $this->webroot; ?>img/brands/jeans/diesel.jpg" class="fadein-image" alt="Diesel" /></li>
                          <li class="ui-state-default" data-id="4"><img src="<?php echo $this->webroot; ?>img/brands/jeans/levis.jpg" class="fadein-image" alt="Levis" /></li>
                          <li class="ui-state-default" data-id="5"><img src="<?php echo $this->webroot; ?>img/brands/jeans/burberry.jpg" class="fadein-image" alt="Burberry" /></li>
                          <li class="ui-state-default" data-id="6"><img src="<?php echo $this->webroot; ?>img/brands/jeans/jbrand.jpg" class="fadein-image" alt="J brand Denim" /></li>
                          <li class="ui-state-default" data-id="7"><img src="<?php echo $this->webroot; ?>img/brands/jeans/lucky-brand.jpg" class="fadein-image" alt="Lucky Brand" /></li>
                          <li class="ui-state-default" data-id="8"><img src="<?php echo $this->webroot; ?>img/brands/jeans/rag-bone.jpg" class="fadein-image" alt="Rag & Bone" /></li>
                          <li class="ui-state-default" data-id="9"><img src="<?php echo $this->webroot; ?>img/brands/jeans/for-all-mankind.jpg" class="fadein-image" alt="7 for all Mankind Jeans" /></li>
                          <li class="ui-state-default" data-id="10"><img src="<?php echo $this->webroot; ?>img/brands/jeans/true-religion.jpg" class="fadein-image" alt="True Religion" /></li>
                          <li class="ui-state-default" data-id="11"><img src="<?php echo $this->webroot; ?>img/brands/jeans/big-star.jpg" class="fadein-image" alt="Big Star" /></li>
                          <li class="ui-state-default" data-id="12"><img src="<?php echo $this->webroot; ?>img/brands/jeans/agave.jpg" class="fadein-image" alt="Agave" /></li>
                      </ol>
                  </div>
                   <div class="clear"></div>
                  
                   <div id="pants-brands" class="brand-block hide">
                      

                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][pants][]" value="Brioni" id="1" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][pants][]" value="Incotex" id="2" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][pants][]" value="Hugo Boss" id="3" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][pants][]" value="Dolce & Gabbana" id="4" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][pants][]" value="Banana Republic" id="5" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][pants][]" value="Hiltl" id="6" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][pants][]" value="Gucci" id="7" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][pants][]" value="Jil Sander" id="8" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][pants][]" value="Zegna" id="9" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][pants][]" value="MCQ Alexander Mcqueen" id="10" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][pants][]" value="Michael Bastian" id="11" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][pants][]" value="Armani" id="12" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][pants][]" value="Abercrombie" id="13" />
                      <ol id="selectable" class="brands-logo">
                          <li class="ui-state-default" data-id="1"><img src="<?php echo $this->webroot; ?>img/brands/pants/brioni.jpg" class="fadein-image" alt="Brioni" /></li>
                          <li class="ui-state-default" data-id="2"><img src="<?php echo $this->webroot; ?>img/brands/pants/incotex.jpg" class="fadein-image" alt="Incotex" /></li>
                          <li class="ui-state-default" data-id="3"><img src="<?php echo $this->webroot; ?>img/brands/pants/hugo-boss.jpg" class="fadein-image" alt="Hugo Boss" /></li>
                          <li class="ui-state-default" data-id="4"><img src="<?php echo $this->webroot; ?>img/brands/pants/dolce-gabana.jpg" class="fadein-image" alt="Dolce & Gabbana" /></li>
                          <li class="ui-state-default" data-id="5"><img src="<?php echo $this->webroot; ?>img/brands/pants/banana-replublic.jpg" class="fadein-image" alt="Banana Republic" /></li>
                          <li class="ui-state-default" data-id="6"><img src="<?php echo $this->webroot; ?>img/brands/pants/hilti.jpg" class="fadein-image" alt="Hiltl" /></li>
                          <li class="ui-state-default" data-id="7"><img src="<?php echo $this->webroot; ?>img/brands/pants/gucci.jpg" class="fadein-image" alt="Gucci" /></li>
                          <li class="ui-state-default" data-id="8"><img src="<?php echo $this->webroot; ?>img/brands/pants/jil-sander.jpg" class="fadein-image" alt="Jil Sander" /></li>
                          <li class="ui-state-default" data-id="9"><img src="<?php echo $this->webroot; ?>img/brands/pants/ermenegildo-zegna.jpg" class="fadein-image" alt="Zegna" /></li>
                          <li class="ui-state-default" data-id="10"><img src="<?php echo $this->webroot; ?>img/brands/pants/mcqueen.jpg" class="fadein-image" alt="MCQ Alexander Mcqueen" /></li>
                          <li class="ui-state-default" data-id="11"><img src="<?php echo $this->webroot; ?>img/brands/pants/michael-bastian.jpg" class="fadein-image" alt="Michael Bastian" /></li>
                          <li class="ui-state-default" data-id="12"><img src="<?php echo $this->webroot; ?>img/brands/pants/emporio-armani.jpg" class="fadein-image" alt="Armani" /></li>
                          <li class="ui-state-default" data-id="13"><img src="<?php echo $this->webroot; ?>img/brands/pants/Abercrombie-n-Fitch.jpg" class="fadein-image" alt="Abercrombie" /></li>
                      </ol>
                  </div>
                   <div class="clear"></div>

                  <div id="shirt-brands" class="brand-block hide">
                      
                      
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Etro" id="1" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Ascot Chang" id="2" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Brooks Brothers" id="3" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Robert Graham" id="4" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Burberry" id="5" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="J. Crew" id="6" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Prada" id="7" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Eton" id="8" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Hugo Boss" id="9" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="John Varvatos" id="10" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Tom Ford" id="11" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Zara" id="12" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Abercrombie" id="13" />
                      <ol id="selectable" class="brands-logo">
                          <li class="ui-state-default" data-id="1"><img src="<?php echo $this->webroot; ?>img/brands/shirts/etro.jpg" class="fadein-image" alt="Etro" /></li>
                          <li class="ui-state-default" data-id="2"><img src="<?php echo $this->webroot; ?>img/brands/shirts/ascoi-chang.jpg" class="fadein-image" alt="Ascot Chang" /></li>
                          <li class="ui-state-default" data-id="3"><img src="<?php echo $this->webroot; ?>img/brands/shirts/brooks-brothers.jpg" class="fadein-image" alt="Brooks Brothers" /></li>
                          <li class="ui-state-default" data-id="4"><img src="<?php echo $this->webroot; ?>img/brands/shirts/robert-graham.jpg" class="fadein-image" alt="Robert Graham" /></li>
                          <li class="ui-state-default" data-id="5"><img src="<?php echo $this->webroot; ?>img/brands/shirts/burberry.jpg" class="fadein-image" alt="Burberry" /></li>
                          <li class="ui-state-default" data-id="6"><img src="<?php echo $this->webroot; ?>img/brands/shirts/jcrew.jpg" class="fadein-image" alt="J. Crew" /></li>
                          <li class="ui-state-default" data-id="7"><img src="<?php echo $this->webroot; ?>img/brands/shirts/prada.jpg" class="fadein-image" alt="Prada" /></li>
                          <li class="ui-state-default" data-id="8"><img src="<?php echo $this->webroot; ?>img/brands/shirts/eton.jpg" class="fadein-image" alt="Eton" /></li>                        
                          <li class="ui-state-default" data-id="9"><img src="<?php echo $this->webroot; ?>img/brands/shirts/hugo-boss.jpg" class="fadein-image" alt="Hugo Boss" /></li>
                          <li class="ui-state-default" data-id="10"><img src="<?php echo $this->webroot; ?>img/brands/shirts/john-varvatos.jpg" class="fadein-image" alt="John Varvatos" /></li>
                          <li class="ui-state-default" data-id="11"><img src="<?php echo $this->webroot; ?>img/brands/shirts/tom-ford.jpg" class="fadein-image" alt="Tom Ford" /></li>
                          <li class="ui-state-default" data-id="12"><img src="<?php echo $this->webroot; ?>img/brands/shirts/zara.jpg" class="fadein-image" alt="Zara" /></li>
                          <li class="ui-state-default" data-id="13"><img src="<?php echo $this->webroot; ?>img/brands/shirts/Abercrombie-n-Fitch.jpg" class="fadein-image" alt="Abercrombie" /></li>
                      </ol>
                  </div>
                  <div class="clear"></div>               

                  <div id="suits-brands" class="brand-block hide">                     

                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][suits][]" value="Armani" id="1" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][suits][]" value="Brooks Brothers" id="2" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][suits][]" value="Etro" id="3" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][suits][]" value="Prada" id="4" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][suits][]" value="Burberry" id="5" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][suits][]" value="Gucci" id="6" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][suits][]" value="Brioni" id="7" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][suits][]" value="Canalli" id="8" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][suits][]" value="Hugo Boss" id="9" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][suits][]" value="Paul Smith" id="10" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][suits][]" value="Thom Browne" id="11" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][suits][]" value="SUITSUPPLY" id="12" />
                      <ol id="selectable" class="brands-logo">
                          <li class="ui-state-default" data-id="1"><img src="<?php echo $this->webroot; ?>img/brands/suits/enporio-armani.jpg" class="fadein-image" alt="Armani" /></li>
                          <li class="ui-state-default" data-id="2"><img src="<?php echo $this->webroot; ?>img/brands/suits/brooks-brothers.jpg" class="fadein-image" alt="Brooks Brothers" /></li>
                          <li class="ui-state-default" data-id="3"><img src="<?php echo $this->webroot; ?>img/brands/suits/etro.jpg" class="fadein-image" alt="Etro" /></li>
                          <li class="ui-state-default" data-id="4"><img src="<?php echo $this->webroot; ?>img/brands/suits/prada.jpg" class="fadein-image" alt="Prada" /></li>
                          <li class="ui-state-default" data-id="5"><img src="<?php echo $this->webroot; ?>img/brands/suits/burberry.jpg" class="fadein-image" alt="Burberry" /></li>
                          <li class="ui-state-default" data-id="6"><img src="<?php echo $this->webroot; ?>img/brands/suits/gucci.jpg" class="fadein-image" alt="Gucci" /></li>
                          <li class="ui-state-default" data-id="7"><img src="<?php echo $this->webroot; ?>img/brands/suits/brioni.jpg" class="fadein-image" alt="Brioni" /></li>
                          <li class="ui-state-default" data-id="8"><img src="<?php echo $this->webroot; ?>img/brands/suits/canali.jpg" class="fadein-image" alt="Canalli" /></li>
                          <li class="ui-state-default" data-id="9"><img src="<?php echo $this->webroot; ?>img/brands/suits/hugo-boss.jpg" class="fadein-image" alt="Hugo Boss" /></li>
                          <li class="ui-state-default" data-id="10"><img src="<?php echo $this->webroot; ?>img/brands/suits/paul-smith.jpg" class="fadein-image" alt="Paul Smith" /></li>
                          <li class="ui-state-default" data-id="11"><img src="<?php echo $this->webroot; ?>img/brands/suits/thombrowne.jpg" class="fadein-image" alt="Thom Browne" /></li>
                          <li class="ui-state-default" data-id="12"><img src="<?php echo $this->webroot; ?>img/brands/suits/suitsupply_logo.png" class="fadein-image" alt="SUITSUPPLY" /></li>
                      </ol>
                  </div>
              </div>
          </div>
          <div class="clear"></div>
          <div class="text-center brands-cont">
              <br/>                          
              <div class="submit">                            
                  <a class="link-btn black-btn back-btn" href="<?php echo $this->webroot; ?>users/register/size/<?php echo $user_id; ?>">Back</a> 
                  <input id="brands-continue" type="submit" value="Continue" />
                  <p class="error-msg">Please select atleast one brand from each category.</p> 
              </div>            
          </div>            
          </form>
          
      </div>
  </div>
</div>