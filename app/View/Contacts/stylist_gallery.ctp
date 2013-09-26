<?php
$this->append('header');
echo $this->element('header');
$this->end();

$script = '
    $(document).ready(function(){
    
     var $container = $("#grid");
    
      $container.imagesLoaded( function(){
        $container.isotope({
          itemSelector : ".photo"
        });
      });
      
    });
';

$this->Html->css('isotope', null, array('inline' => false));
$this->Html->script('jquery.isotope.min', array('inline' => false));
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));

$meta_description = 'At SRS, your personal stylists are fitting experts. Our stylists are here to give you new head to toe outfits or simply to find a better fitting or a replacement of those old jeans.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>
<div id="grid" class="photos clearfix isotope">
    <?php if ($submissions) : ?>
        <div class="photo isotope-item">
            <a href="<?php echo $this->request->webroot; ?>personal-stylist/ask">
                <img src="<?php echo $this->request->webroot; ?>img/stylist-ask.jpg" />
            </a>
        </div>
        <?php foreach ($submissions as $submission) : ?>
            <div class="photo isotope-item">
                <a href="<?php echo $this->request->webroot; ?>personal-stylist/submissions#<?php echo $submission['Contact']['id']; ?>">
                    <?php if (isset($submission['Attached'][0]['Attachment']['name'])) : ?>
                        <img src="<?php echo $this->request->webroot; ?>files/stylist/<?php echo $submission['Attached'][0]['Attachment']['name']; ?>" />
                    <?php else : ?>
                        <img src="<?php echo $this->request->webroot; ?>img/personal-shopper-default.jpg" />
                    <?php endif; ?>
                </a>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        There are no submissions.
    <?php endif; ?>
</div>