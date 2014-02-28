<?php
$script = '

$(document).ready(function(){   
    $(".thumbs-up").click(function(e) {
        e.preventDefault();
        $this = $(this);
        var productBlock = $this.closest(".like-dislike-links");
        var productId = productBlock.find(".product-id").val();
        if(!$this.hasClass("liked")){
            $.post("' . $this->request->webroot . 'api/wishlist/save", { product_id: productId},
                function(data) {
                    var ret = $.parseJSON(data);
                    if(ret["status"] == "ok"){
                        $this.addClass("liked");
                        productBlock.find(".thumbs-down").removeClass("disliked");
                    }
                    
                    if(ret["profile_status"] == "incomplete"){
                        var notificationDetails = new Array();
                        notificationDetails["msg"] = ret["profile_msg"];
                        notificationDetails["button"] = "<a href=\"' . $this->webroot . 'profile/about\" class=\"link-btn gold-btn\">Complete Style Profile</a>";
                        showNotification(notificationDetails);
                    }
                }
            );
        }
        else{
            $.post("' . $this->request->webroot . 'api/wishlist/remove", { product_id: productId},
                function(data) {
                    var ret = $.parseJSON(data);
                    if(ret["status"] == "ok"){
                        $this.removeClass("liked");
                    }
                }
            );
        }
    });
    $(".thumbs-down").click(function(e) {
        e.preventDefault();
        $this = $(this);
        var productBlock = $this.closest(".like-dislike-links");
        var productId = productBlock.find(".product-id").val();
        if(!$this.hasClass("disliked")){
            $.post("' . $this->request->webroot . 'api/dislike/save", { product_id: productId},
                function(data) {
                    var ret = $.parseJSON(data);
                    if(ret["status"] == "ok"){
                        $this.addClass("disliked");
                        productBlock.find(".thumbs-up").removeClass("liked");
                    }
                }
            );
        }
        else{
            $.post("' . $this->request->webroot . 'api/dislike/remove", { product_id: productId},
                function(data) {
                    var ret = $.parseJSON(data);
                    if(ret["status"] == "ok"){
                        $this.removeClass("disliked");
                    }
                }
            );
        }
    });
});
';

$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->script("mosaic.1.0.1.min.js", array('inline' => false));
$this->Html->css('flexslider', null, array("inline" => false));

$meta_description = 'Show your support and desire to be an SRS member by sporting one of our iPhones/iPad cases!';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>
<style type="text/css">
    .slidesjs-pagination-item{
        display: none;
    }
</style>
<div class="content-container">
    <div class="twelve columns content inner">	
        <div class="closet-tabs text-center">
            <a href="<?php echo $this->webroot . 'closet'; ?>" class="link-btn black-btn">Curated Collection</a>
            <a href="<?php echo $this->webroot . 'lookbooks/'; ?>" class="link-btn gold-btn">Lookbooks</a>
        </div>
        <div class="twelve columns">
            <div class="twelve columns">
                <div class="product-top-offset"></div>
                <div class="flexslider text-center" >
                    <ul class="slides">
                        <?php
                        foreach($lifestyles as $lifestyle){
                        ?>
                            <li><img src="<?php echo $this->request->webroot; ?>files/lifestyles/<?php echo $lifestyle['Lifestyle']['image']; ?>" class="fadein-image max-width-adj" data-lifestyle-id="<?php echo $lifestyle['Lifestyle']['id']; ?>" />
                            </li>
                        <?php      
                        }
                    ?>
                    </ul>    
                </div>
                <div class="lifestyle-table center-block">
                    <table class="lb-products">
                        <thead>    
                            <tr>               
                                <th width="20%"></th>
                                <th width="55%"></th>
                                <th width="25%"></th>
                            </tr> 
                        </thead>
                        
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="sixteen columns">
            
        </div>
    </div>
</div>
<script src="/js/jquery.flexslider-min.js"></script>
<script type="text/javascript">
<?php
echo '
    var lifestyles = ' . json_encode($lifestyles) . ',
    lifestylesIds = ' . json_encode($lifestyle_ids) . ',
    entities = ' . json_encode($entities) . ';';
?>
var loadLookbookItems = function(lookbookId){
    var lookbookProductBox = $(".lb-products tbody");
    lookbookProductBox.html('');

    if(lifestyles[lookbookId] != undefined){
        var curLookbook = lifestyles[lookbookId],
            curLookbookLength = curLookbook["LifestyleItem"].length,
            curLookbookItemHtml = "";
        if(curLookbookLength){
            for(var i=0; i<curLookbookLength; i++){
                var curEntityId = curLookbook["LifestyleItem"][i]["product_entity_id"];
                if(entities[curEntityId]){
                    var curEntity = entities[curEntityId];
                    
                    var entityDesc = curEntity["Entity"]["description"].substr(0, 120);
                    if(curEntity["Image"] != undefined){
                        entityImage = "<?php echo $this->request->webroot; ?>products/resize/" + curEntity["Image"][0]["name"] + "/65/87"; 
                    }
                    else{
                        entityImage = "<?php echo $this->request->webroot; ?>img/image_not_available-small.png";
                    } 

                    curLookbookItemHtml = 
                        "<tr class='lifestyle-product-block'>" +
                            "<td class='product-thumb text-center'>" +
                                "<div class='product-thumb-cont'>" + 
                                    "<a href='<?php echo $this->request->webroot; ?>product/" + curEntity['Entity']['id']  + "/" + curEntity['Entity']['slug'] + "'>" + 
                                        "<img src='" + entityImage + "' alt='' />" + 
                                    "</a>" +
                                "</div>" +
                            "</td>" + 
                            "<td class=''>" + 
                                "<h6><a href='<?php echo $this->request->webroot; ?>product/" + curEntity['Entity']['id'] + "/" + curEntity['Entity']['slug'] + "'>" + curEntity['Entity']['name'] + "</a></h6>" + 
                                "<small class='description'>" + entityDesc + "</small>" + 
                            "</td>" + 
                            "<td class='like-dislike-links text-center'>" + 
                                "<input type='hidden' value='" + curEntity['Entity']['id'] + "' class='product-id' />";

                    if(curEntity['Wishlist'] != undefined){
                        var dislikeClass = (curEntity['Dislike']['id']) ? "disliked" : "";
                        var likeClass = (curEntity['Wishlist']['id']) ? "liked" : "";
                        curLookbookItemHtml += "<a href='' class='thumbs-up " + likeClass + "'></a>" + 
                        "<a class='link-btn black-btn lb-to-cart' href='<?php echo $this->request->webroot; ?>product/" + curEntity['Entity']['id'] + "/" + curEntity['Entity']['slug'] + "'>BUY</a>" + 
                        "<a href='' class='thumbs-down " + dislikeClass + "'></a>" + 
                        "<td></tr>";
                    }
                    else{
                        curLookbookItemHtml += "<a class='link-btn black-btn lb-to-cart' href='<?php echo $this->request->webroot; ?>product/" + curEntity['Entity']['id'] + "/" + curEntity['Entity']['slug'] + "'>BUY</a>" + 
                        "</td></tr>";
                    }  
                    
                    lookbookProductBox.append(curLookbookItemHtml); 
                }    
            }
        } 
        window.location.hash = lookbookId;  
    }    
}
$(document).ready(function(){
    var loadLookbookId = window.location.hash.replace("#","");
    if(loadLookbookId != "" && loadLookbookId > 0 && lifestyles[loadLookbookId] != undefined){

        $(".flexslider").flexslider({
            animation: "slide",
            animationSpeed: 300,  
            animationLoop: true,
            slideshow: false,          
            slideshowSpeed: 4000, 
            video: true,
            useCSS: true,
            pauseOnAction: false,
            controlNav: false,
            directionNav: true,
            keyboard: false,
            startAt: lifestylesIds.indexOf(loadLookbookId),
            after: function(slider) {
                var newLookbookId = $(".flex-active-slide img").data("lifestyle-id");
                console.log(newLookbookId);
                loadLookbookItems(newLookbookId);
            }                
        });
        loadLookbookItems(loadLookbookId);
    }
    else{
        $(".flexslider").flexslider({
            animation: "slide",
            animationSpeed: 300,  
            animationLoop: true,
            slideshow: false,          
            slideshowSpeed: 4000, 
            video: true,
            useCSS: true,
            pauseOnAction: false,
            controlNav: false,
            directionNav: true,
            keyboard: false,
            after: function(slider) {
                var newLookbookId = $(".flex-active-slide img").data("lifestyle-id");
                console.log(newLookbookId);
                loadLookbookItems(newLookbookId);
            }                
        });    
        loadLookbookItems(lifestylesIds[0]);
    }
});

</script>