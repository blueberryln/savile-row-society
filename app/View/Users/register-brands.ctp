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
                    //$("#polos_tees-brands > ol > li:contains(\"" + brands.polos_tees[i]  + "\")").attr("class", "ui-state-default ui-selectee ui-selected");
//                    var id = $("#polos_tees-brands > ol > li:contains(\"" + brands.polos_tees[i]  + "\")").data("id");
//                    $("#polos_tees-brands input:checkbox#" +  id).prop("checked", true);
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
                    //$("#shirt-brands > ol > li:contains(\"" + brands.shirts[i]  + "\")").attr("class", "ui-state-default ui-selectee ui-selected");
//                    var id = $("#shirt-brands > ol > li:contains(\"" + brands.shirts[i]  + "\")").data("id");
//                    $("#shirt-brands input:checkbox#" +  id).prop("checked", true);

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
                    //$("#pants-brands > ol > li:contains(\"" + brands.pants[i]  + "\")").attr("class", "ui-state-default ui-selectee ui-selected");
//                    var id = $("#pants-brands > ol > li:contains(\"" + brands.pants[i]  + "\")").data("id");
//                    $("#pants-brands input:checkbox#" +  id).prop("checked", true);
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
                    //$("#jeans-brands > ol > li:contains(\"" + brands.jeans[i]  + "\")").attr("class", "ui-state-default ui-selectee ui-selected");
//                    var id = $("#jeans-brands > ol > li:contains(\"" + brands.jeans[i]  + "\")").data("id");
//                    $("#jeans-brands input:checkbox#" +  id).prop("checked", true);
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
                    //$("#suits-brands > ol > li:contains(\"" + brands.suits[i]  + "\")").attr("class", "ui-state-default ui-selectee ui-selected");
//                    var id = $("#suits-brands > ol > li:contains(\"" + brands.suits[i]  + "\")").data("id");
//                    $("#suits-brands input:checkbox#" +  id).prop("checked", true);
                }
            }
       }
       
       $("ul.product-type li").click(function(){
            $("ul.product-type li").removeClass("selected");
            $(this).addClass("selected");            
       });
      
      $("ul.brands-logo li").click(function(){
            $("ul.brands-logo li").removeClass("selected");
            $(this).addClass("selected");
       });
});
';
$this->Html->css('ui/jquery-ui', null, array('inline' => false));
$this->Html->css('ui/jquery.ui.theme', null, array('inline' => false));
$this->Html->script('http://code.jquery.com/ui/1.10.3/jquery-ui.min.js', array('inline' => false));
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->script('brands.js', array('inline' => false));



$meta_description = 'Sign up for Savile Row Society, a groundbreaking online, personalized fashion service.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>

<script>
window.registerProcess = true;
</script>
<div class="container content inner preferences register-brands">	
    <div class="sixteen columns text-center">
        <h1>PROFILE</h1>
    </div>	
    <div class="fifteen columns offset-by-half register-steps">
        <div class="profile-tabs text-center">
                    <a class="link-btn gold-btn" href="<?php echo $this->webroot; ?>profile/about">My Style</a>
                    <a class="link-btn gray-btn" href="<?php echo $this->webroot; ?>myprofile">My Profile</a>
        </div>
    </div>
    <div class="thirteen columns alpha omega text-center offset-by-three">
        <div class="reg-step4"></div>
    </div>

    <div class="sixteen columns text-center">
        <?php echo $this->Form->create('User', array('url' => '/register/saveBrands')); ?>
        <input type="hidden" value="<?php echo $user_id ?>" name="data[User][id]" />
        <div class="hi-message fourteen columns offset-by-one alpha omega">
            <h4 class="hi-message">Brands you prefer</h4>
            <p></p>
        </div>        
        <div class="fourteen columns offset-by-one alpha omega">
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
        <div class="fourteen columns  alpha omega text-center offset-by-two">
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
                    <ol id="selectable" class="brands-logo">
                        <li class="ui-state-default" data-id="1"><img src="<?php echo $this->webroot; ?>img/brands/tees/hugo-boss.jpg" alt="Hugo Boss" /></li>
                        <li class="ui-state-default" data-id="2"><img src="<?php echo $this->webroot; ?>img/brands/tees/banana-replublic.jpg" alt="Banana Republic" /></li>
                        <li class="ui-state-default" data-id="3"><img src="<?php echo $this->webroot; ?>img/brands/tees/calvin-klein.jpg" alt="Calvin Klein" /></li>
                        <li class="ui-state-default" data-id="4"><img src="<?php echo $this->webroot; ?>img/brands/tees/jcrew.jpg" alt="J. Crew" /></li>
                        <li class="ui-state-default" data-id="5"><img src="<?php echo $this->webroot; ?>img/brands/tees/lacoste.jpg" alt="Lacoste" /></li>
                        <li class="ui-state-default" data-id="6"><img src="<?php echo $this->webroot; ?>img/brands/tees/nike.jpg" alt="Nike" /></li>
                        <li class="ui-state-default" data-id="7"><img src="<?php echo $this->webroot; ?>img/brands/tees/peter-millar.jpg" alt="Peter Miller" /></li>
                        <li class="ui-state-default" data-id="8"><img src="<?php echo $this->webroot; ?>img/brands/tees/john-varvatos.jpg" alt="John Varvatos" /></li>
                        <li class="ui-state-default" data-id="9"><img src="<?php echo $this->webroot; ?>img/brands/tees/ralph-lauren.jpg" alt="Polo Ralph Lauren" /></li>
                        <li class="ui-state-default" data-id="10"><img src="<?php echo $this->webroot; ?>img/brands/tees/vineyard-vines.jpg" alt="Vineyard Vines" /></li>
                    </ol>
                </div>
                <div class="clear"></div>

                <div id="shirt-brands" class="brand-block">
                    
                    
                    <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Etro" id="1" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Ascot Chang" id="2" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Brooks Brothers" id="3" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Robert Graham" id="4" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Burberry" id="5" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="J. Crew" id="6" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Prada" id="7" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Eton" id="8" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Ralph Lauren" id="9" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Hugo Boss" id="10" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="John Varvatos" id="11" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Tom Ford" id="12" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Brands][shirts][]" value="Zara" id="13" />
                    <ol id="selectable" class="brands-logo">
                        <li class="ui-state-default" data-id="1"><img src="<?php echo $this->webroot; ?>img/brands/shirts/etro.jpg" alt="Etro" /></li>
                        <li class="ui-state-default" data-id="2"><img src="<?php echo $this->webroot; ?>img/brands/shirts/ascoi-chang.jpg" alt="Ascot Chang" /></li>
                        <li class="ui-state-default" data-id="3"><img src="<?php echo $this->webroot; ?>img/brands/shirts/brooks-brothers.jpg" alt="Brooks Brothers" /></li>
                        <li class="ui-state-default" data-id="4"><img src="<?php echo $this->webroot; ?>img/brands/shirts/robert-graham.jpg" alt="Robert Graham" /></li>
                        <li class="ui-state-default" data-id="5"><img src="<?php echo $this->webroot; ?>img/brands/shirts/burberry.jpg" alt="Burberry" /></li>
                        <li class="ui-state-default" data-id="6"><img src="<?php echo $this->webroot; ?>img/brands/shirts/jcrew.jpg" alt="J. Crew" /></li>
                        <li class="ui-state-default" data-id="7"><img src="<?php echo $this->webroot; ?>img/brands/shirts/prada.jpg" alt="Prada" /></li>
                        <li class="ui-state-default" data-id="8"><img src="<?php echo $this->webroot; ?>img/brands/shirts/eton.jpg" alt="Eton" /></li>
                        <li class="ui-state-default" data-id="9"><img src="<?php echo $this->webroot; ?>img/brands/shirts/ralph-lauren.jpg" alt="Ralph Lauren" /></li>
                        <li class="ui-state-default" data-id="10"><img src="<?php echo $this->webroot; ?>img/brands/shirts/hugo-boss.jpg" alt="Hugo Boss" /></li>
                        <li class="ui-state-default" data-id="11"><img src="<?php echo $this->webroot; ?>img/brands/shirts/john-varvatos.jpg" alt="John Varvatos" /></li>
                        <li class="ui-state-default" data-id="12"><img src="<?php echo $this->webroot; ?>img/brands/shirts/tom-ford.jpg" alt="Tom Ford" /></li>
                        <li class="ui-state-default" data-id="13"><img src="<?php echo $this->webroot; ?>img/brands/shirts/zara.jpg" alt="Zara" /></li>
                    </ol>
                </div>
                <div class="clear"></div>

                <div id="pants-brands" class="brand-block">
                    

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
                    <ol id="selectable" class="brands-logo">
                        <li class="ui-state-default" data-id="1"><img src="<?php echo $this->webroot; ?>img/brands/pants/brioni.jpg" alt="Brioni" /></li>
                        <li class="ui-state-default" data-id="2"><img src="<?php echo $this->webroot; ?>img/brands/pants/incotex.jpg" alt="Incotex" /></li>
                        <li class="ui-state-default" data-id="3"><img src="<?php echo $this->webroot; ?>img/brands/pants/hugo-boss.jpg" alt="Hugo Boss" /></li>
                        <li class="ui-state-default" data-id="4"><img src="<?php echo $this->webroot; ?>img/brands/pants/dolce-gabana.jpg" alt="Dolce & Gabbana" /></li>
                        <li class="ui-state-default" data-id="5"><img src="<?php echo $this->webroot; ?>img/brands/pants/banana-replublic.jpg" alt="Banana Republic" /></li>
                        <li class="ui-state-default" data-id="6"><img src="<?php echo $this->webroot; ?>img/brands/pants/hilti.jpg" alt="Hiltl" /></li>
                        <li class="ui-state-default" data-id="7"><img src="<?php echo $this->webroot; ?>img/brands/pants/gucci.jpg" alt="Gucci" /></li>
                        <li class="ui-state-default" data-id="8"><img src="<?php echo $this->webroot; ?>img/brands/pants/jil-sander.jpg" alt="Jil Sander" /></li>
                        <li class="ui-state-default" data-id="9"><img src="<?php echo $this->webroot; ?>img/brands/pants/ermenegildo-zegna.jpg" alt="Zegna" /></li>
                        <li class="ui-state-default" data-id="10"><img src="<?php echo $this->webroot; ?>img/brands/pants/mcqueen.jpg" alt="MCQ Alexander Mcqueen" /></li>
                        <li class="ui-state-default" data-id="11"><img src="<?php echo $this->webroot; ?>img/brands/pants/michael-bastian.jpg" alt="Michael Bastian" /></li>
                        <li class="ui-state-default" data-id="12"><img src="<?php echo $this->webroot; ?>img/brands/pants/emporio-armani.jpg" alt="Armani" /></li>
                    </ol>
                </div>
                <div class="clear"></div>

                <div id="jeans-brands" class="brand-block">
                   

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
                    <ol id="selectable" class="brands-logo">
                        <li class="ui-state-default" data-id="1"><img src="<?php echo $this->webroot; ?>img/brands/jeans/acne.jpg" alt="Acne" /></li>
                        <li class="ui-state-default" data-id="2"><img src="<?php echo $this->webroot; ?>img/brands/jeans/adriano.jpg" alt="Adriano Goldschmied" /></li>
                        <li class="ui-state-default" data-id="3"><img src="<?php echo $this->webroot; ?>img/brands/jeans/diesel.jpg" alt="Diesel" /></li>
                        <li class="ui-state-default" data-id="4"><img src="<?php echo $this->webroot; ?>img/brands/jeans/levis.jpg" alt="Levis" /></li>
                        <li class="ui-state-default" data-id="5"><img src="<?php echo $this->webroot; ?>img/brands/jeans/burberry.jpg" alt="Burberry" /></li>
                        <li class="ui-state-default" data-id="6"><img src="<?php echo $this->webroot; ?>img/brands/jeans/jbrand.jpg" alt="J brand Denim" /></li>
                        <li class="ui-state-default" data-id="7"><img src="<?php echo $this->webroot; ?>img/brands/jeans/lucky-brand.jpg" alt="Lucky Brand" /></li>
                        <li class="ui-state-default" data-id="8"><img src="<?php echo $this->webroot; ?>img/brands/jeans/rag-bone.jpg" alt="Rag & Bone" /></li>
                        <li class="ui-state-default" data-id="9"><img src="<?php echo $this->webroot; ?>img/brands/jeans/for-all-mankind.jpg" alt="7 for all Mankind Jeans" /></li>
                        <li class="ui-state-default" data-id="10"><img src="<?php echo $this->webroot; ?>img/brands/jeans/true-religion.jpg" alt="True Religion" /></li>
                        <li class="ui-state-default" data-id="11"><img src="<?php echo $this->webroot; ?>img/brands/jeans/big-star.jpg" alt="Big Star" /></li>
                    </ol>
                </div>
                <div class="clear"></div>

                <div id="suits-brands" class="brand-block">                     

                    <input class="hide" type="checkbox" name="data[UserPreference][Brands][suits][]" value="Armani" id="1" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Brands][suits][]" value="Brooks Brothers" id="2" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Brands][suits][]" value="Etro" id="3" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Brands][suits][]" value="Prada" id="4" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Brands][suits][]" value="Burberry" id="5" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Brands][suits][]" value="Gucci" id="7" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Brands][suits][]" value="Brioni" id="8" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Brands][suits][]" value="Canalli" id="9" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Brands][suits][]" value="Hugo Boss" id="10" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Brands][suits][]" value="Paul Smith" id="11" />
                    <input class="hide" type="checkbox" name="data[UserPreference][Brands][suits][]" value="Thom Browne" id="12" />
                    <ol id="selectable" class="brands-logo">
                        <li class="ui-state-default" data-id="1"><img src="<?php echo $this->webroot; ?>img/brands/suits/enporio-armani.jpg" alt="Armani" /></li>
                        <li class="ui-state-default" data-id="2"><img src="<?php echo $this->webroot; ?>img/brands/suits/brooks-brothers.jpg" alt="Brooks Brothers" /></li>
                        <li class="ui-state-default" data-id="3"><img src="<?php echo $this->webroot; ?>img/brands/suits/etro.jpg" alt="Etro" /></li>
                        <li class="ui-state-default" data-id="4"><img src="<?php echo $this->webroot; ?>img/brands/suits/prada.jpg" alt="Prada" /></li>
                        <li class="ui-state-default" data-id="5"><img src="<?php echo $this->webroot; ?>img/brands/suits/burberry.jpg" alt="Burberry" /></li>
                        <li class="ui-state-default" data-id="7"><img src="<?php echo $this->webroot; ?>img/brands/suits/gucci.jpg" alt="Gucci" /></li>
                        <li class="ui-state-default" data-id="8"><img src="<?php echo $this->webroot; ?>img/brands/suits/brioni.jpg" alt="Brioni" /></li>
                        <li class="ui-state-default" data-id="9"><img src="<?php echo $this->webroot; ?>img/brands/suits/canali.jpg" alt="Canalli" /></li>
                        <li class="ui-state-default" data-id="10"><img src="<?php echo $this->webroot; ?>img/brands/suits/hugo-boss.jpg" alt="Hugo Boss" /></li>
                        <li class="ui-state-default" data-id="11"><img src="<?php echo $this->webroot; ?>img/brands/suits/paul-smith.jpg" alt="Paul Smith" /></li>
                        <li class="ui-state-default" data-id="12"><img src="<?php echo $this->webroot; ?>img/brands/suits/thombrowne.jpg" alt="Thom Browne" /></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="text-center brands-cont">
            <br/>
            <?php echo $this->Form->end(__('Continue')); ?>
            <br/>
            <br /><br /><br />
            <br /><br />
        </div>
    </div>
</div>

<script>
    
    window.onload= function(){
        $("#polos_tees-brands").css("display","block");
    }

</script>