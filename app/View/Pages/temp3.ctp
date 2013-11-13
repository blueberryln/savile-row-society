<?php
$script = '
$(document).ready(function(){ 
    
     
    $(".fancybox").fancybox({                    
				helpers: {
					title : {
						type : "over"
					},
					overlay : {
						speedOut : 1000
					}
				}
			}); 
    $(".fancybox").eq(0).trigger("click");
    ' . $logged_script . '
});
';
$this->Html->script("jquery.fancybox.js", array('inline' => false));
//$this->Html->script("jquery.fancybox.pack.js", array('inline' => false));
$this->Html->script("lightbox-2.6.min.js", array('inline' => false));
echo $this->Html->css("jquery.fancybox.css");
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$meta_description = $entity['Entity']['name'];
if ($entity) {
    $meta_description = Sanitize::html($entity['Entity']['description'], array('remove' => true));
}
$this->Html->meta('description', $meta_description, array('inline' => false));

// Progduct information for facebook open graph tags
$page_url = "//www.savilerowsociety.com" . $this->webroot . 'product/' . $entity['Entity']['id'] . '/' . $entity['Entity']['slug'];
if(count($entity['Image']) > 0){
    $img_src = "//www.savilerowsociety.com" . $this->webroot . 'files/products/' . $entity['Image'][0]['name']; 
}
else{
    $img_src = "//www.savilerowsociety.com" . $this->webroot . 'img/image_not_available.png';                    
}

$this->Html->meta(array('property'=> 'og:title', 'content' => $entity['Entity']['name'] . ' - Savile Row Society', ),'',array('inline'=>false));
$this->Html->meta(array('property'=> 'og:description', 'content' => $entity['Entity']['description']),'',array('inline'=>false));
$this->Html->meta(array('property'=> 'og:url', 'content' => $page_url),'',array('inline'=>false));
$this->Html->meta(array('property'=> 'og:image', 'content' => $img_src),'',array('inline'=>false));


// columns size
$columns = 'eleven';
?>
<div class="container content inner">	
    <div class="one columns alpha omega">&nbsp;</div>
    <div class="sixteen columns product-detail-cont">
        <input type="hidden" value="<?php echo $entity['Entity']['id']; ?>" class="product-id">
        <div class="one columns alpha omega">&nbsp;</div>       
    </div>
    <div class="fourteen columns details-margin row">
        <div class="lifestyle-images">            
            <a id="first" class="fancybox" data-fancybox-group="lifestyle" rel="gallery" title="title one" href="<?php echo $this->request->webroot; ?>/img/1.jpg"></a>
            <a class="fancybox second" data-fancybox-group="lifestyle" rel="gallery" title="title two" href="<?php echo $this->request->webroot; ?>/img/2.jpg"></a> 
            
        </div>
    </div>
</div>