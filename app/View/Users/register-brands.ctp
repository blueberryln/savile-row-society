<?php
$script = ' var brands = ' . json_encode($brands) . '; ' .
' $(document).ready(function(){ 
	    var jeans = "50-300",
          shoes = "100-500",
          polo_tees = "50-200",
          shirt = "50-300",
          suits = "400-2000";

      if(brands && brands.range){
        if(brands.range.jeans){
          jeans = brands.range.jeans;  
        }

        if(brands.range.shoes){
          shoes = brands.range.shoes;  
        }

        if(brands.range.polo_tees){
          polo_tees = brands.range.polo_tees;  
        }

        if(brands.range.shirt){
          shirt = brands.range.shirt;  
        }

        if(brands.range.suits){
          suits = brands.range.suits;  
        }
      }

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
	   
       $( "#shoes-brands #selectable" ).bind("mousedown", function(e) {
         e.metaKey = true;
       }).selectable({
           stop: function() {
               $("#shoes-brands input:checkbox").prop("checked", false);
               $( ".ui-selected", this ).each(function() {
                   $("p.error-msg").slideUp(300);
                   var selected_id = $(this).data("id");
                   $("#shoes-brands input:checkbox#" + selected_id).prop("checked", true);
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
            if(brands.shoes){
                for(var i = 0; i<brands.shoes.length; i++){
                    $("#shoes-brands > ol > li").each(function(){
                        if($(this).find("img").attr("alt") == brands.shoes[i]){
                            $(this).attr("class", "ui-state-default ui-selectee ui-selected"); 
                            var id = $(this).data("id");
                            $("#shoes-brands input:checkbox#" +  id).prop("checked", true);   
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
        if($("#polos_tees-brands li.ui-selected").length > 0 && $("#shirt-brands li.ui-selected").length > 0 && $("#shoes-brands li.ui-selected").length > 0 && $("#jeans-brands li.ui-selected").length > 0 && $("#suits-brands li.ui-selected").length > 0)
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


        $("#polo-range-slider").slider({
          range: true,
          min: 50,
          max: 200,
          values: [ polo_tees.split("-")[0], polo_tees.split("-")[1] ],
          slide: function( event, ui ) {
            $("#polo-range").val(ui.values[ 0 ] + "-" + ui.values[1] );
            $("#polo-range-text").text("$" + ui.values[ 0 ] + " - $" + ui.values[1] );
          }
        });
        $("#polo-range").val($("#polo-range-slider").slider("values", 0) + "-" + $("#polo-range-slider").slider("values", 1));  
        $("#polo-range-text").text("$" + $("#polo-range-slider").slider("values", 0) + " - $" + $("#polo-range-slider").slider("values", 1)); 


        $("#jeans-range-slider").slider({
          range: true,
          min: 50,
          max: 300,
          values: [ jeans.split("-")[0], jeans.split("-")[1] ],
          slide: function( event, ui ) {
            $("#jeans-range").val(ui.values[ 0 ] + "-" + ui.values[1] );
            $("#jeans-range-text").text("$" + ui.values[ 0 ] + " - $" + ui.values[1] );
          }
        });
        $("#jeans-range").val($("#jeans-range-slider").slider("values", 0) + "-" + $("#jeans-range-slider").slider("values", 1));
        $("#jeans-range-text").text("$" + $("#jeans-range-slider").slider("values", 0) + " - $" + $("#jeans-range-slider").slider("values", 1));   

        $("#shoes-range-slider").slider({
          range: true,
          min: 100,
          max: 500,
          values: [ shoes.split("-")[0], shoes.split("-")[1] ],
          slide: function( event, ui ) {
            $("#shoes-range").val(ui.values[ 0 ] + "-" + ui.values[1] );
            $("#shoes-range-text").text("$" + ui.values[ 0 ] + " - $" + ui.values[1] );
          }
        });
        $("#shoes-range").val($("#shoes-range-slider").slider("values", 0) + "-" + $("#shoes-range-slider").slider("values", 1));
        $("#shoes-range-text").text("$" + $("#shoes-range-slider").slider("values", 0) + " - $" + $("#shoes-range-slider").slider("values", 1));  

        $("#shirt-range-slider").slider({
          range: true,
          min: 50,
          max: 300,
          values: [ shirt.split("-")[0], shirt.split("-")[1] ],
          slide: function( event, ui ) {
            $("#shirt-range").val(ui.values[ 0 ] + "-" + ui.values[1] );
            $("#shirt-range-text").text("$" + ui.values[ 0 ] + " - $" + ui.values[1] );
          }
        });
        $("#shirt-range").val($("#shirt-range-slider").slider("values", 0) + "-" + $("#shirt-range-slider").slider("values", 1)); 
        $("#shirt-range-text").text("$" + $("#shirt-range-slider").slider("values", 0) + " - $" + $("#shirt-range-slider").slider("values", 1));  

        $("#suits-range-slider").slider({
          range: true,
          min: 400,
          max: 2000,
          values: [ suits.split("-")[0], suits.split("-")[1] ],
          slide: function( event, ui ) {
            $("#suits-range").val(ui.values[ 0 ] + "-" + ui.values[1] );
            $("#suits-range-text").text("$" + ui.values[ 0 ] + " - $" + ui.values[1] );
          }
        });
        $("#suits-range").val($("#suits-range-slider").slider("values", 0) + "-" + $("#suits-range-slider").slider("values", 1)); 
        $("#suits-range-text").text("$" + $("#suits-range-slider").slider("values", 0) + " - $" + $("#suits-range-slider").slider("values", 1)); 
       
});
';
$this->Html->css('ui/jquery-ui', null, array('inline' => false));
$this->Html->css('ui/jquery.ui.theme', null, array('inline' => false));
$this->Html->script('//code.jquery.com/ui/1.10.3/jquery-ui.min.js', array('inline' => false));
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->script("jquery.ui.touch-punch.min.js", array('inline' => false));
$this->Html->script('brands.js', array('inline' => false));



$meta_description = 'Sign up for Savile Row Society, a groundbreaking online, personalized fashion service.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>

<script>
window.registerProcess = true;
</script>
<div class="content-container">
  <div class="container content inner preferences register-brands">	
      <div class="eight columns register-steps center-block">
          <div class="profile-tabs text-center">
              <a class="link-btn gold-btn my-style" href="<?php echo $this->webroot; ?>register/wardrobe">My Style</a>
              <a class="link-btn black-btn my-profile" href="<?php echo $this->webroot; ?>myprofile">My Profile</a>
          </div>

          <h1 class="text-center">Brands</h1>
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
                   <!--<li>
                      <a data-tab="pants-brands" class="brand-link" data-origin-css='brands-pants'>
                          <span>Pants</span>
                      </a>
                  </li>-->
                  <li>
                      <a data-tab="shoes-brands" class="brand-link" data-origin-css='brands-shoes'>
                          <span>Shoes</span>
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
          <div class="twelve columns center-block">

              <div id="brands" >
                  <div id="polos_tees-brands" class="brand-block">
                     
                      <p>
                        <label for="polo-range">How much do you usually spend on Polos &amp; Tees ($50 - $200)?</label>
                        <input type="hidden" id="polo-range" name="data[UserPreference][Brands][range][polo_tees]">
                      </p>
                      <div id="polo-range-slider"></div>
                      <p id="polo-range-text" class="text-center"></p>

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
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][polos_tees][]" value="Fred Perry" id="11" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][polos_tees][]" value="Agave" id="12" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][polos_tees][]" value="None" id="13" />

                      <ol id="selectable" class="brands-logo eleven columns center-block">
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
                          <li class="ui-state-default" data-id="11"><img src="<?php echo $this->webroot; ?>img/brands/tees/fred-perry.png" class="fadein-image" alt="Fred Perry" /></li>
                          <li class="ui-state-default" data-id="12"><img src="<?php echo $this->webroot; ?>img/brands/tees/agave.jpg" class="fadein-image" alt="Agave" /></li>
                          <li class="ui-state-default" data-id="13" style="line-height: 16px; padding-top: 5px;"><img alt="None" class="hide">None of these brands are among my favorites</li>

                      </ol>
                  </div>
                  <div class="clear"></div>
                  
                   <div id="jeans-brands" class="brand-block hide">
                     
                      <p>
                        <label for="jeans-range">How much do you usually spend on Jeans ($50 - $300)?</label>
                        <input type="hidden" id="jeans-range" name="data[UserPreference][Brands][range][jeans]">
                      </p>
                      <div id="jeans-range-slider"></div>
                      <p id="jeans-range-text" class="text-center"></p>

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
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][jeans][]" value="None" id="13" />
                      <ol id="selectable" class="brands-logo eleven columns center-block">
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
                          <li class="ui-state-default" data-id="13" style="line-height: 16px; padding-top: 5px;"><img alt="None" class="hide">None of these brands are among my favorites</li>
                      </ol>
                  </div>
                   <div class="clear"></div>
                  
                   <div id="shoes-brands" class="brand-block hide">
                      
                      <p>
                        <label for="shoes-range">How much do you usually spend on shoes ($100 - $500)?</label>
                        <input type="hidden" id="shoes-range" name="data[UserPreference][Brands][range][shoes]">
                      </p>
                      <div id="shoes-range-slider"></div>
                      <p id="shoes-range-text" class="text-center"></p>
  
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shoes][]" value="Allen Edmonds" id="4" />   
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shoes][]" value="Berluti" id="5" />     
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shoes][]" value="Church" id="6" />     
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shoes][]" value="Cole Haan" id="7" />     
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shoes][]" value="Ferragamo" id="8" />     
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shoes][]" value="JM Weston" id="9" />     
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shoes][]" value="John Lobb" id="10" />     
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shoes][]" value="Johnston &amp; Murphy" id="11" />     
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shoes][]" value="Nike" id="12" />     
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shoes][]" value="Sperry" id="13" />     
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shoes][]" value="Ted Baker" id="14" />     
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shoes][]" value="Tods" id="15" />  
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shoes][]" value="None" id="16" />                    
                      <ol id="selectable" class="brands-logo eleven columns center-block">                       
                          <li class="ui-state-default" data-id="4"><img src="<?php echo $this->webroot; ?>img/brands/shoes/Allen Edmonds.jpg" class="fadein-image" alt="Allen Edmonds" /></li>       
                          <li class="ui-state-default" data-id="5"><img src="<?php echo $this->webroot; ?>img/brands/shoes/Berluti.png" class="fadein-image" alt="Berluti" /></li>                        
                          <li class="ui-state-default" data-id="6"><img src="<?php echo $this->webroot; ?>img/brands/shoes/Church.jpg" class="fadein-image" alt="Church" /></li>                        
                          <li class="ui-state-default" data-id="7"><img src="<?php echo $this->webroot; ?>img/brands/shoes/Cole Haan.jpg" class="fadein-image" alt="Cole Haan" /></li>                        
                          <li class="ui-state-default" data-id="8"><img src="<?php echo $this->webroot; ?>img/brands/shoes/Ferragamo.jpg" class="fadein-image" alt="Ferragamo" /></li>                        
                          <li class="ui-state-default" data-id="9"><img src="<?php echo $this->webroot; ?>img/brands/shoes/JM Weston.jpg" class="fadein-image" alt="JM Weston" /></li>                        
                          <li class="ui-state-default" data-id="10"><img src="<?php echo $this->webroot; ?>img/brands/shoes/john_lobb.png" class="fadein-image" alt="John Lobb" /></li>                        
                          <li class="ui-state-default" data-id="11"><img src="<?php echo $this->webroot; ?>img/brands/shoes/JohnstonMurphy.jpg" class="fadein-image" alt="Johnston &amp; Murphy" /></li>                        
                          <li class="ui-state-default" data-id="12"><img src="<?php echo $this->webroot; ?>img/brands/shoes/Nike.jpg" class="fadein-image" alt="Nike" /></li>                        
                          <li class="ui-state-default" data-id="13"><img src="<?php echo $this->webroot; ?>img/brands/shoes/Sperry.jpg" class="fadein-image" alt="Sperry" /></li>                        
                          <li class="ui-state-default" data-id="14"><img src="<?php echo $this->webroot; ?>img/brands/shoes/Ted Baker.jpg" class="fadein-image" alt="Ted Baker" /></li>                        
                          <li class="ui-state-default" data-id="15"><img src="<?php echo $this->webroot; ?>img/brands/shoes/Tods.jpg" class="fadein-image" alt="Tods" /></li> 
                          <li class="ui-state-default" data-id="16" style="line-height: 16px; padding-top: 5px;"><img alt="None" class="hide">None of these brands are among my favorites</li>                      
                      </ol>
                  </div>
                   <div class="clear"></div>

                  <div id="shirt-brands" class="brand-block hide">
                      
                      <p>
                        <label for="shirt-range">How much do you usually spend on Shirts ($50 - $300)?</label>
                        <input type="hidden" id="shirt-range" name="data[UserPreference][Brands][range][shirt]">
                      </p>
                      <div id="shirt-range-slider"></div>
                      <p id="shirt-range-text" class="text-center"></p>

                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Etro" id="1" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Ascot Chang" id="2" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Brooks Brothers" id="3" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Burberry" id="5" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="J. Crew" id="6" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Prada" id="7" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Eton" id="8" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Hugo Boss" id="9" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Ralph Lauren" id="10" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Tom Ford" id="11" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Zara" id="12" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Abercrombie" id="13" />
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="None" id="14" />
                      <ol id="selectable" class="brands-logo eleven columns center-block">
                          <li class="ui-state-default" data-id="1"><img src="<?php echo $this->webroot; ?>img/brands/shirts/etro.jpg" class="fadein-image" alt="Etro" /></li>
                          <li class="ui-state-default" data-id="2"><img src="<?php echo $this->webroot; ?>img/brands/shirts/ascoi-chang.jpg" class="fadein-image" alt="Ascot Chang" /></li>
                          <li class="ui-state-default" data-id="3"><img src="<?php echo $this->webroot; ?>img/brands/shirts/brooks-brothers.jpg" class="fadein-image" alt="Brooks Brothers" /></li>
                          <li class="ui-state-default" data-id="5"><img src="<?php echo $this->webroot; ?>img/brands/shirts/burberry.jpg" class="fadein-image" alt="Burberry" /></li>
                          <li class="ui-state-default" data-id="6"><img src="<?php echo $this->webroot; ?>img/brands/shirts/jcrew.jpg" class="fadein-image" alt="J. Crew" /></li>
                          <li class="ui-state-default" data-id="7"><img src="<?php echo $this->webroot; ?>img/brands/shirts/prada.jpg" class="fadein-image" alt="Prada" /></li>
                          <li class="ui-state-default" data-id="8"><img src="<?php echo $this->webroot; ?>img/brands/shirts/eton.jpg" class="fadein-image" alt="Eton" /></li>                        
                          <li class="ui-state-default" data-id="9"><img src="<?php echo $this->webroot; ?>img/brands/shirts/hugo-boss.jpg" class="fadein-image" alt="Hugo Boss" /></li>
                          <li class="ui-state-default" data-id="10"><img src="<?php echo $this->webroot; ?>img/brands/shirts/ralph-lauren.jpg" class="fadein-image" alt="Ralph Lauren" /></li>
                          <li class="ui-state-default" data-id="11"><img src="<?php echo $this->webroot; ?>img/brands/shirts/tom-ford.jpg" class="fadein-image" alt="Tom Ford" /></li>
                          <li class="ui-state-default" data-id="12"><img src="<?php echo $this->webroot; ?>img/brands/shirts/zara.jpg" class="fadein-image" alt="Zara" /></li>
                          <li class="ui-state-default" data-id="13"><img src="<?php echo $this->webroot; ?>img/brands/shirts/Abercrombie-n-Fitch.jpg" class="fadein-image" alt="Abercrombie" /></li>
                          <li class="ui-state-default" data-id="14" style="line-height: 16px; padding-top: 5px;"><img alt="None" class="hide">None of these brands are among my favorites</li>
                      </ol>
                  </div>
                  <div class="clear"></div>               

                  <div id="suits-brands" class="brand-block hide">  

                      <p>
                        <label for="suits-range">How much do you usually spend on Suits ($400 - $2,000)?</label>
                        <input type="hidden" id="suits-range" name="data[UserPreference][Brands][range][suits]">
                      </p>
                      <div id="suits-range-slider"></div>
                      <p id="suits-range-text" class="text-center"></p>                   

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
                      <input class="hide" type="checkbox" name="data[UserPreference][Brands][suits][]" value="None" id="13" />
                      <ol id="selectable" class="brands-logo eleven columns center-block">
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
                          <li class="ui-state-default" data-id="13" style="line-height: 16px; padding-top: 5px;"><img alt="None" class="hide">None of these brands are among my favorites</li>
                      </ol>
                  </div>

              </div>
          </div>
          <div class="clear"></div>
          <div class="text-center brands-cont">
              <br/>                          
              <div class="submit">                            
                  <a class="link-btn black-btn back-btn" href="<?php echo $this->webroot; ?>profile/about/<?php echo $user_id; ?>">Back</a> 
                  <input id="brands-continue" type="submit" value="Continue" />
                  <p class="error-msg">Please select atleast one brand from each category.</p> 
              </div>            
          </div>            
          </form>
          
      </div>
  </div>
</div>