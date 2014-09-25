<?php
$meta_description = 'As an SRS Man, great things are expected of you. But let us take care of the details. <br/> We\'ll perfect your image from head to toe.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>

<div class="content-container">
    <div class="eleven columns container content inner stylistbio">
        <div class="twelve columns container stylistbio-section left">
            <a class="open-left-pannel" href="#" title=""><img src="<?php echo $this->webroot; ?>images/arrow-next.png" alt="" /></a>
           

<?php
$stylistbioid  = $find_array[0]['Stylistbio']['id'];
$stylistid  = $find_array[0]['Stylistbio']['stylist_id'];
 ?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){

    $("#submit").on('click', function(e){
        e.preventDefault();

        var hometown = $("#hometown").val();
        var id = $("#id").val();
        $.ajax({
            type: "POST",
            url: "<?php echo $this->webroot; ?>Auth/updatestylistbiographyhometown/<?php echo $stylistbioid; ?>",
            data: {hometown:hometown,id:id},
            cache: false,
            success: function(result){
            //alert(result);
            }
        });
    });
 
    $("#submitfun").on('click', function(e){
        e.preventDefault();

        var funfect = $("#funfect").val();
        var id = $("#id").val();
        $.ajax({
            type: "POST",
            url: "<?php echo $this->webroot; ?>Auth/updatestylistbiographyfunfect/<?php echo $stylistbioid; ?>",
            data: {funfect:funfect,id:id},
            cache: false,
            success: function(result){
            //alert(url);
            }
        });
    });
    
    $("#submit_stylist_inspiration").on('click',function(e){
        e.preventDefault();
        var id = $("#id").val();
        var Inspiration = $("#StylebioStylistInspiration").val();
        $.ajax({
            type: "POST",
            url: "<?php echo $this->webroot; ?>Auth/updatestylistbiographyInspiration/<?php echo $stylistbioid; ?>",
            data: {stylist_inspiration:Inspiration,id:id},
            cache: false,
            success: function(result){
                //alert(result);
            }
        });
    });

    $("#submit_stylist_bio").on('click',function(e){
        e.preventDefault();
        var id = $("#id").val();
        var Bio = $("#StylebioStylistBio").val();
        $.ajax({
            type: "POST",
            url: "<?php echo $this->webroot; ?>Auth/updateStylistBiographyBio/<?php echo $stylistbioid; ?>",
            data: {stylist_bio:Bio,id:id},
            cache: false,
            success: function(result){
                //alert(result);
            }
        });
    });

    $("#submit_fashiontip").on('click',function(e){
        e.preventDefault();
        var id = $("#id").val();
        var fashiontip = $("#fashiontip").val();
        $.ajax({
            type: "POST",
            url: "<?php echo $this->webroot; ?>Auth/updateStylistBiographyFashionTip/<?php echo $stylistbioid; ?>",
            data: {fashiontip:fashiontip,id:id},
            cache: false,
            success: function(result){
                //alert(result);
            }
        });
    });
    
    $("#file-upload-submit").on('click',function(e){
        e.preventDefault();
        var caption = $("#caption").val();
        var fileupload = $("#files span").text();
        var is_profile = $("#is_profile").val();
        //alert(fileupload);
        $.ajax({
            type: "POST",
            url: "<?php echo $this->webroot; ?>Auth/updateStylistBiographyimage/<?php echo $stylistid; ?>",
            data: {image:fileupload,caption:caption,is_profile:is_profile},
            cache: false,
            success: function(result){
                //alert(result);
            }
        });
    });
    $("#topoutfit").click(function(){
    $("#topout").toggle();
    });

    

});
</script>

            <div class="stylistbio-section-right">
                <div class="eleven columns container">
                    <div class="twelve columns">
                        <div class="stylistbio-profile left text-center">
                            <div class="profile-img"><img src="<?php echo $this->webroot; ?>files/photostream/<?php echo $find_array[0]['Stylistphotostream']['image']; ?>" width='277' height='309' alt="" /></div>
                            <div class=" twelve columns social-networks">
                                
                                <ul>
                                <?php $social = json_decode($find_array[0]['Stylistbio']['stylist_social_link'],true); ?>
                                    <li class="printrest"><a href="<?php echo $social['pintrest']; ?>" target="blank" title="">Printrest</a></li>
                                    <li class="twitter"><a href="<?php echo $social['twiter']; ?>" target="blank" title="">Twitter</a></li>
                                    <li class="linkdin"><a href="<?php echo $social['linkdin']; ?>" target="blank" title="">Linkdin</a></li>
                                    <li class="facebbok"><a href="<?php echo $social['facebook']; ?>" target="blank" title="">facebook</a></li>
                                </ul>
                            </div>
                            <h1 class="stylistbio-heading"><?php echo $find_array[0]['User']['first_name']; ?>’s Bio</h1>
                            <div class="user-desc">
                            <div class="input taxtarea"><textarea name="data[Stylebio][stylist_bio]"  rows="10" cols="30"  id="StylebioStylistBio"><?php echo $find_array[0]['Stylistbio']['stylist_bio']; ?></textarea><a href="#" id="submit_stylist_bio">submit</a></div>
                               
                            </div>
                            <h1 class="stylistbio-heading"><?php echo $find_array[0]['User']['first_name']; ?>’s Inspiration</h1>
                            <div class="user-inspire-desc">
                            <div class="input taxtarea"><textarea name="data[Stylebio][stylist_inspiration]"  rows="10" cols="30"  id="StylebioStylistInspiration"><?php echo $find_array[0]['Stylistbio']['stylist_inspiration']; ?></textarea><a href="#" id="submit_stylist_inspiration">submit</a></div>
                            
                            </div>
                        </div>
                        <div class="stylistbio-details right">
                            <div class="twelve columns left">
                                <div class="stylistbio-user"><?php echo $find_array[0]['User']['first_name'].'&nbsp;'.$find_array[0]['User']['last_name']; ?> | Stylist</div>
                                <div class="start-today"><a href="javascript:;">get started with <?php echo $find_array[0]['User']['first_name']; ?> Today!</a></div>
                            </div>
                            <div class="twelve columns left detials-section">
                                <div class="twelve columns details">
                                    <div class="home-town"><span class="style-upper">Hometown:</span>
                                     <span class="style-italic">
                                     <input type="text" name="data[Stylebio][hometown]" id="hometown" value="<?php echo $find_array[0]['Stylistbio']['hometown']; ?>"><a href="#" id="submit">submit</a>
                                     
                                     </span>
                                     

                                     </div>
                                     
                                     
                                   <div class="fun-fact"><span class="style-upper">Fun Fact:</span> <span class="style-italic">
                                    <input type="hidden" name="data[Stylistbio][id]" id="id" value="<?php echo $find_array[0]['Stylistbio']['id']; ?>">

                                    <input type="text" name="data[Stylistbio][funfect]" id="funfect" value="<?php echo $find_array[0]['Stylistbio']['funfect']; ?>"><a href="#" id="submitfun">submit</a></span></div>
                                    </form>
                                    <div class="fashion-tips"><span class="style-upper">Number 1 Fashion Tip:</span> <span class="style-italic">
                                    <input type="text" name="data[Stylistbio][fashiontip]" id="fashiontip" value="<?php echo $find_array[0]['Stylistbio']['fashiontip']; ?>">
                                    <a href="#" id="submit_fashiontip">Submit</a>
                                    

                                    </span></div>
                                </div>
                                <div class="twelve columns left user-photostream">
                                    <h1 class="stylistbio-heading photostream"><?php echo $find_array[0]['User']['first_name']; ?>’s Photostream</h1>
                                    <div class="photostream-section">
                                        <ul id="itemContainer">
                                            <?php  foreach ($stylistphoto as $stylistphoto): ?>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>files/photostream/<?php echo $stylistphoto['Stylistphotostream']['image']; ?>" data-fancybox-group="gallery" title="<?php echo $stylistphoto['Stylistphotostream']['caption']; ?>">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>files/photostream/<?php echo $stylistphoto['Stylistphotostream']['image']; ?>" alt="" />
                                                </a>
                                            </li>
                                        <?php endforeach; ?>

                                            <!-- 
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_1.jpg" data-fancybox-group="gallery" title="img-1">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_1.jpg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_2.jpg" data-fancybox-group="gallery" title="img-2">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_2.jpg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_3.jpg" data-fancybox-group="gallery" title="img-3">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_3.jpg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_4.jpg" data-fancybox-group="gallery" title="img-4">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_4.jpg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_5.jpg" data-fancybox-group="gallery" title="img-5">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_5.jpg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_6.jpg" data-fancybox-group="gallery" title="img-6">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_6.jpg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_7.jpg" data-fancybox-group="gallery" title="img-7">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_7.jpg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_8.jpg" data-fancybox-group="gallery" title="img-8">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_8.jpg" alt="" />
                                                </a>
                                            </li>
                                            

                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_2.jpg" data-fancybox-group="gallery" title="img-2">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_2.jpg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_3.jpg" data-fancybox-group="gallery" title="img-3">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_3.jpg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_4.jpg" data-fancybox-group="gallery" title="img-4">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_4.jpg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_5.jpg" data-fancybox-group="gallery" title="img-5">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_5.jpg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_6.jpg" data-fancybox-group="gallery" title="img-6">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_6.jpg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_7.jpg" data-fancybox-group="gallery" title="img-7">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_7.jpg" alt="" />
                                                </a>
                                            </li>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_8.jpg" data-fancybox-group="gallery" title="img-8">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>images/stylistbio/photo-stream_8.jpg" alt="" />
                                                </a>
<<<<<<< HEAD:app/View/Auth/stylistbiography.ctp
                                            </li> -->

                                            </li>
                                            
                                            

                                        </ul>
                                        <div class="holder"></div>
                                    </div>
                                    <div class="submit"><a href="#" id="block-file-upload-photo" class="link-btn black-btn">Upload</a></div>
                                    <!--drag & drop data -->
                                    <?php
                                    echo $this->html->css('drag/css/bootstrap.min');
                                    echo $this->html->css('drag/css/jquery.fileupload');
                                    ?>
                                   
                                     <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
                                     <!--file upload -->
                                    <div id="file-box-photo" class="box-modal notification-box" style="display: none;">
                                    <div class="box-modal-inside">
                                    <a class="notification-close" href=""></a>
                                    <div class="vip-content">
                                    <h5 class="sign">Photo Stream</h5>            
                                        <!-- <div class="container"> -->
                                            <!-- The fileinput-button span is used to style the file input field as button -->
                                           <?php //echo $this->Form->create('Stylistphotostream',array('url'=> 'updateStylistBiographyimage','enctype'=>'multipart/form-data')); ?>
                                    
                                            <span class="btn btn-success fileinput-button">
                                            <i class="glyphicon glyphicon-plus"></i>
                                            <span>Drag & Drop Your Image Here</span>
                                            <!-- The file input field used as target for the file upload widget -->
                                             <input id="fileupload" type="file" name="files[]"  multiple> 
                                            <?php //echo $this->form->input('Stylistphotostream.image',array('type'=>'file','id'=>'fileupload')); ?>
                                            </span>
                                            <br>
                                            <br>
                                            <!-- The global progress bar -->
                                            <!-- <div id="progress" class="progress">
                                            <div class="progress-bar progress-bar-success"></div>
                                            </div> -->
                                            <!-- The container for the uploaded files -->
                                            <div id="files" class="files"></div>
                                            <br>
                                            <div class="panel panel-default">

                                            </div>
                                        <!-- </div> -->

                                    <!-- <form> -->
                                    <input type="text" class="file-photo" name="data[Stylistphotostream][caption]" id='caption' placeholder="Enter Caption">
                                    <input type="checkbox" id='is_profile' name="data[Stylistphotostream][is_profile]">: Make My Profile Pic.
                                    <?php //echo $this->Form->end('Submit'); ?>
                                     <a href="#" class="link-btn black-btn file-box-photo" id="file-upload-submit" class="btn btn-primary"> Submit</a> 
                                    <!-- </form>  -->
                                    </div> 
                                    </div>
                                    </div>
                                    <!-- file upload-->
                                    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
                                    <?php
                                    echo $this->html->script('drag/js/vendor/jquery.ui.widget.js');
                                    echo $this->html->script('drag/js/load-image.min.js');
                                    echo $this->html->script('drag/js/jquery.fileupload.js');
                                    echo $this->html->script('drag/js/jquery.fileupload-process.js');
                                    echo $this->html->script('drag/js/jquery.fileupload-image.js');
                                    ?>
                                    <script>
                                    /*jslint unparam: true, regexp: true */
                                    /*global window, $ */
                                    $(function () {
                                    'use strict';
                                    // Change this to the location of your server-side upload handler:
                                    var url = window.location.hostname === '127.0.0.1' ?
                                    '//SRS/' : '<?php echo $this->webroot; ?>server/php/',
                                    uploadButton = $('<button/>')
                                    .addClass('btn btn-primary')
                                    .prop('disabled', true)
                                    .text('Processing...')
                                    .on('click', function () {
                                    var $this = $(this),
                                    data = $this.data();
                                    $this
                                    .off('click')
                                    .text('Abort')
                                    .on('click', function () {
                                    $this.remove();
                                    data.abort();
                                    });
                                    data.submit().always(function () {
                                    $this.remove();
                                    });
                                    });
                                    $('#fileupload').fileupload({
                                    url: url,
                                    dataType: 'json',
                                    autoUpload: false,
                                    acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
                                    maxFileSize: 5000000, // 5 MB
                                    // Enable image resizing, except for Android and Opera,
                                    // which actually support image resizing, but fail to
                                    // send Blob objects via XHR requests:

                                    disableImageResize: /Android(?!.*Chrome)|Opera/
                                    .test(window.navigator.userAgent),

                                    previewMaxWidth: 100,
                                    previewMaxHeight: 100,
                                    previewCrop: true
                                    }).on('fileuploadadd', function (e, data) {
                                    data.context = $('<div/>').appendTo('#files');
                                    $.each(data.files, function (index, file) {
                                    var node = $('<p/>')
                                    .append($('<span/>').text(file.name));
                                    if (!index) {
                                    node
                                    .append('<br>')
                                    .append(uploadButton.clone(true).data(data));
                                    }
                                    node.appendTo(data.context);
                                    });
                                    }).on('fileuploadprocessalways', function (e, data) {
                                    var index = data.index,
                                    file = data.files[index],
                                    node = $(data.context.children()[index]);
                                    if (file.preview) {
                                    node
                                    .prepend('<br>')
                                    .prepend(file.preview);
                                    }
                                    if (file.error) {
                                    node
                                    .append('<br>')
                                    .append($('<span class="text-danger"/>').text(file.error));
                                    }
                                    if (index + 1 === data.files.length) {
                                    data.context.find('button')
                                    .text('Upload')
                                    .prop('disabled', !!data.files.error);
                                    }
                                    }).on('fileuploadprogressall', function (e, data) {
                                    // var progress = parseInt(data.loaded / data.total * 100, 10);
                                    // $('#progress .progress-bar').css(
                                    // 'width',
                                    // progress + '%'
                                    // );
                                    }).on('fileuploaddone', function (e, data) {
                                    $.each(data.result.files, function (index, file) {
                                    if (file.url) {
                                    var link = $('<a>')
                                    .attr('target', '_blank')
                                    .prop('href', file.url);
                                    $(data.context.children()[index])
                                    .wrap(link);
                                    } else if (file.error) {
                                    var error = $('<span class="text-danger"/>').text(file.error);
                                    $(data.context.children()[index])
                                    .append('<br>')
                                    .append(error);
                                    }
                                    });
                                    }).on('fileuploadfail', function (e, data) {
                                    $.each(data.files, function (index, file) {
                                    var error = $('<span class="text-danger"/>').text('File upload failed.');
                                    $(data.context.children()[index])
                                    .append('<br>')
                                    .append(error);
                                    });
                                    }).prop('disabled', !$.support.fileInput)
                                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
                                    });
 
                                    </script>
<!--    
                                        <a class="link-older-photos right" href="javascript:;" title="">Older Photos &gt; </a>
                                        <a class="link-newer-photos left" href="javascript:;" title="">  &lt;Newer Photos  </a>
-->
                                </div>
                                <div class="twelve columns left user-top-outfit">
                                    <h1 class="stylistbio-heading photostream top-outits-heading"><?php echo $find_array[0]['User']['first_name']; ?>’s Top Outfits</h1>
                                    <p id="topoutfit">Edit</p>
                                    <div id="topout" style="display:none;">
                                        <select id="outfit">
                                            <option>Pleasa Select Outfit</option>
                                            <?php foreach($outfits as  $outfit): ?>
                                                <option value="<?php echo $outfit['Outfit']['id'] ?>"><?php echo $outfit['Outfit']['outfitname'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <br>
                                        <select id="order">
                                            <option>Please Select Order</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                        <a href="#" id="submit_outfit">Submit</a>
                                    </div>
                                    
                                    <script>
                                    $("#submit_outfit").on('click',function(e){
                                        e.preventDefault();
                                            var order = $("#order").val();
                                            var outfit = $("#outfit").val();
                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?php echo $this->webroot; ?>Auth/updateStylistBiographyoutfit/<?php echo $stylistid; ?>",
                                                    data: {order_id:order,outfit_id:outfit},
                                                    cache: false,
                                                    success: function(data){
                                                      data = $.parseJSON(data);
                                                      //alert(data);

                                                    html = '';

                                                    $.each(data,  function (index){
                                                        html = html + '<li>';
                                                        html = html + '<div class="twelve columns top-outfits">';
                                                        html = html + '<div class="eleven columns container">';
                                                        html = html + '<h2>'+this.outfit.Outfit.outfitname+'</h2>';
                                                        html = html + '<div class="outfit-products">';
                                                        html = html + '<ul>';
                                                        html = html + '<li><img src="<?php echo $this->webroot; ?>files/products/'+ this.entities[0].Image[0].name+'" alt="" height="108" width="122" /><div class="outfit-products-details">'+this.entities[0].Entity.name+'</div></li>';
                                                        html = html + '<li><img src="<?php echo $this->webroot; ?>files/products/'+ this.entities[1].Image[0].name+'" alt="" height="108" width="122" /><div class="outfit-products-details">'+this.entities[1].Entity.name+'</div></li>';
                                                        html = html + '<li><img src="<?php echo $this->webroot; ?>files/products/'+ this.entities[2].Image[0].name+'" alt="" height="108" width="122" /><div class="outfit-products-details">'+this.entities[2].Entity.name+'</div></li>';
                                                        html = html + '<li><img src="<?php echo $this->webroot; ?>files/products/'+ this.entities[3].Image[0].name+'" alt="" height="108" width="122" /><div class="outfit-products-details">'+this.entities[3].Entity.name+'</div></li>';
                                                        html = html + '<li><img src="<?php echo $this->webroot; ?>files/products/'+ this.entities[4].Image[0].name+'" alt="" height="108" width="122" /><div class="outfit-products-details">'+this.entities[4].Entity.name+'</div></li>';
                                                        html = html + '</ul>';
                                                        html = html + '</div>';
                                                        html = html + '</div>';
                                                        html = html + '</div>';
                                                        html = html + '</li>';
                                                        //console.log("this.entities");
                                                            });
                                                            $("#stylisttopoutfit").append(html);

                                                        }
                                                });
                                                
                                        $("#topout").hide( "slow", function() {
                                        });
                                    });
                                    </script>
                                    <ul id="stylisttopoutfit">
                                    <?php foreach ($my_outfit as $my_outfit): //print_r($my_outfit); ?>
                                        <li>
                                            <div class="twelve columns top-outfits">
                                                <div class="eleven columns container">
                                                    <h2><?php echo $my_outfit['outfit']['Outfit']['outfitname']; ?></h2>
                                                    <div class="outfit-products">
                                                        <ul>
                                                        <?php foreach ($my_outfit['entities'] as $entities): ?>
                                                        <li>
                                                            <img src="<?php echo $this->webroot; ?>files/products/<?php echo $entities['Image'][0]['name']; ?>" height="108" width="122" />
                                                            <div class="outfit-products-details"><?php echo $entities['Entity']['name'] ?>  $<?php echo $entities['Entity']['price']; ?></div>
                                                        </li>
                                                        <?php endforeach; ?>
                                                       </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li> 
                                    <?php endforeach; ?>
                                    </ul>
                                    
                                </div>
                            </div>
                            <div class="twelve columns left bottom-section">
                                <div class="stylistbio-user">Like <?php echo $find_array[0]['User']['first_name']; ?>’s Style?</div>
                                <div class="start-today"><a href="javascript:;">get started with <?php echo $find_array[0]['User']['first_name']; ?> Today!</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
        </div>
        
    </div>
</div>