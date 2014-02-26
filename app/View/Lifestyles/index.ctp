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
    
    $("#slides").slidesjs({
        width: 940,
        height: 528,
        navigation: false,
          active: true,
      });

    $(".slidesjs-previous").click(function(){
        console.log("previous");
    })
    $(".slidesjs-next").click(function(){
        console.log("next");
    })
});
';

$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->script("mosaic.1.0.1.min.js", array('inline' => false));
$this->Html->script("jquery.slides.min.js", array('inline' => false));

$meta_description = 'Show your support and desire to be an SRS member by sporting one of our iPhones/iPad cases!';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>
<style type="text/css">
    .slidesjs-pagination-item{
        display: none;
    }
</style>

<div class="container content inner">	
    <div class="sixteen columns text-center">
        <h1>Lookbooks</h1>
    </div>
    <div class="fifteen offset-by-half columns omega">
        <div class="twelve columns omega product-listing">
            <div class="product-top-offset"></div>
            <div class="text-center" id="slides">
                <?php
                    foreach($lifestyles as $lifestyle){
                    ?>
                        <img src="<?php echo $this->request->webroot; ?>files/lifestyles/<?php echo $lifestyle['Lifestyle']['image']; ?>" class="fadein-image max-width-adj" data-lifestyle-id="<?php echo $lifestyle['Lifestyle']['id']; ?>" />
                    <?php      
                    }
                ?>
                <a href="#" class="slidesjs-previous slidesjs-navigation">&lt;</a>
                <a href="#" class="slidesjs-next slidesjs-navigation">&gt;</a>
            </div>

            <table class="lb-products">
                <thead>    
                    <tr>               
                        <th width="15%"></th>
                        <th width="55%"></th>
                        <th width="30%"></th>
                    </tr> 
                </thead>
                
                <tbody>
                    
                </tbody>
            </table>

        </div>
    </div>
    <div class="clearfix"></div>
    <div class="sixteen columns">
        
    </div>
</div>

<script type="text/javascript">
<?php
echo '
    var lifestyles = ' . json_encode($lifestyles) . ',
    lifestylesIds = ' . json_encode($lifestyle_ids) . ',
    entities = ' . json_encode($entities) . ';';
?>
var loadLookbookItems = function(lookbookId){
    var lookbookProductBox = $(".lb-products tbody");

    if(lifestyles[lookbookId] != undefined){
        var curLookbook = lifestyles[lookbookId],
            curLookbookLength = curLookbook.LifestyleItem.length,
            curLookbookItemHtml = "";
        if(curLookbookLength){
            for(var i=0; i<curLookbookLength; i++){
                var curEntityId = curLookbook["LifestyleItem"][i]["product_entity_id"],
                    curEntity = entities[curEntityId];
                
                var entityDesc = curEntity["Entity"]["description"].substr(0, 120);
                if(curEntity["Image"] != undefined){
                    entityImage = "<?php echo $this->request->webroot; ?>products/resize/" + curEntity["Image"][0]["name"] + "/65/87"; 
                }
                else{
                    entityImage = "<?php echo $this->request->webroot; ?>img/image_not_available-small.png";
                } 

                curLookbookItemHtml = 
                    "<tr class='lifestyle-product-block'>" +
                        "<td class='v-top product-thumb text-center'>" +
                            "<div class='product-thumb-cont'>" + 
                                "<a href='<?php echo $this->request->webroot; ?>product/" + curEntity['Entity']['id']  + "/" + curEntity['Entity']['slug'] + "'>" + 
                                    "<img src='" + entityImage + "' alt='' />" + 
                                "</a>" +
                            "</div>" +
                        "</td>" + 
                        "<td class='v-top'>" + 
                            "<h6><a href='<?php echo $this->request->webroot; ?>product/" + curEntity['Entity']['id'] + "/" + curEntity['Entity']['slug'] + "'>" + curEntity['Entity']['name'] + "</a></h6>" + 
                            "<small class='description'>" + entityDesc + "</small>" + 
                        "</td>" + 
                        "<td class='like-dislike-links'>" + 
                            "<input type='hidden' value='" + curEntity['Entity']['id'] + "' class='product-id' />";

                var loggedUser = "<?php echo $user_id ? $user_id : 0; ?>";

                if(loggedUser){
                    var dislikeClass = (curEntity['Dislike']['id']) ? "disliked" : "";
                    var likeClass = (curEntity['Wishlist']['id']) ? "liked" : "";
                    curLookbookItemHtml += "<a href='' class='thumbs-up " + likeClass + "'></a>" + 
                    "<a class='link-btn gold-btn lb-to-cart' href='<?php echo $this->request->webroot; ?>product/" + curEntity['Entity']['id'] + "/" + curEntity['Entity']['slug'] + "'>BUY</a>" + 
                    "<a href='' class='thumbs-down " + dislikeClass + "'></a>" + 
                    "<td></tr>";
                }
                else{
                    curLookbookItemHtml += "<a class='link-btn gold-btn lb-to-cart' href='<?php echo $this->request->webroot; ?>product/" + curEntity['Entity']['id'] + "/" + curEntity['Entity']['slug'] + "'>BUY</a>" + 
                    "</td></tr>";
                }  
                
                lookbookProductBox.append(curLookbookItemHtml);     
            }
        } 
        window.location.hash = lookbookId;   
    }    
}
$(document).ready(function(){
    loadLookbookItems(lifestylesIds[0]);
});

</script>