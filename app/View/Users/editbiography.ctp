<div class="content-container">
    <div class="eleven columns container content inner stylistbio">
        <div class="twelve columns container stylistbio-section left">
            <a class="open-left-pannel" href="#" title=""><img src="<?php echo $this->webroot; ?>images/arrow-next.png" alt="" /></a>
           

<?php
$stylistbioid  = $find_array[0]['Stylistbio']['id'];
$stylistid  = $user['User']['id'];
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
            url: "<?php echo $this->webroot; ?>users/updatestylistbiographyhometown/<?php echo $stylistbioid; ?>",
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
            url: "<?php echo $this->webroot; ?>users/updatestylistbiographyfunfect/<?php echo $stylistbioid; ?>",
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
            url: "<?php echo $this->webroot; ?>users/updatestylistbiographyInspiration/<?php echo $stylistbioid; ?>",
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
            url: "<?php echo $this->webroot; ?>users/updateStylistBiographyBio/<?php echo $stylistbioid; ?>",
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
            url: "<?php echo $this->webroot; ?>users/updateStylistBiographyFashionTip/<?php echo $stylistbioid; ?>",
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
        var fileupload = $("#uploader-btn").val();
        var is_profile = $("#is_profile").val();
        alert(fileupload);
        $.ajax({
            type: "POST",
            url: "<?php echo $this->webroot; ?>users/updateStylistBiographyimage/<?php echo $stylistid; ?>",
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
    $("#topoutfit2").click(function(){
    $("#topout2").toggle();
    });
    $("#topoutfit3").click(function(){
    $("#topout3").toggle();
    });

    

});
</script>
<?php //echo $find_array[0]['Stylistphotostream']['image']; die;?>
            <div class="stylistbio-section-right">
                <div class="eleven columns container">
                    <div class="twelve columns">
                        <div class="stylistbio-profile left text-center">
                            <div class="profile-img"><img src="<?php echo $this->webroot; ?>files/users/<?php echo $user['User']['profile_photo_url']; ?>" width='277' height='309' alt="" /></div>
                            <div class=" twelve columns social-networks">
                                
                                <ul>
                                <?php $social = json_decode($find_array[0]['Stylistbio']['stylist_social_link'],true); ?>
                                    <li class="printrest"><a href="<?php echo $social['pintrest']; ?>" target="blank" title="">Printrest</a></li>
                                    <li class="twitter"><a href="<?php echo $social['twiter']; ?>" target="blank" title="">Twitter</a></li>
                                    <li class="linkdin"><a href="<?php echo $social['linkdin']; ?>" target="blank" title="">Linkdin</a></li>
                                    <li class="facebbok"><a href="<?php echo $social['facebook']; ?>" target="blank" title="">facebook</a></li>
                                </ul>
                            </div>
                            <h1 class="stylistbio-heading"><?php echo $user['User']['first_name']; ?>’s Bio</h1>
                            <div class="user-desc">
                            <div class="input taxtarea"><textarea name="data[Stylebio][stylist_bio]"  rows="10" cols="30"  id="StylebioStylistBio"><?php echo $find_array[0]['Stylistbio']['stylist_bio']; ?></textarea><a href="#" id="submit_stylist_bio">submit</a></div>
                               
                            </div>
                            <h1 class="stylistbio-heading"><?php echo $user['User']['first_name']; ?>’s Inspiration</h1>
                            <div class="user-inspire-desc">
                            <div class="input taxtarea"><textarea name="data[Stylebio][stylist_inspiration]"  rows="10" cols="30"  id="StylebioStylistInspiration"><?php echo $find_array[0]['Stylistbio']['stylist_inspiration']; ?></textarea><a href="#" id="submit_stylist_inspiration">submit</a></div>
                            
                            </div>
                        </div>
                        <div class="stylistbio-details right">
                            <div class="twelve columns left">
                                <div class="stylistbio-user"><?php echo $user['User']['first_name'].'&nbsp;'.$user['User']['last_name']; ?> | Stylist</div>
                                <div class="start-today"><a href="javascript:;">get started with <?php echo $user['User']['first_name']; ?> Today!</a></div>
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

                                            </li>
                                            
                                            

                                        </ul>
                                        <div class="holder"></div>
                                    </div>
                                    <div class="submit"><a href="#" id="block-file-upload-photo" class="link-btn black-btn">Upload</a></div>
                                    <!--drag & drop data -->
                                    <?php
                                    // echo $this->html->css('drag/css/bootstrap.min');
                                    // echo $this->html->css('drag/css/jquery.fileupload');
                                    ?>
                                   
                                     <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
                                     <!--file upload -->
                                    <div id="file-box-photo" class="box-modal notification-box" style="display: none;">
                                    <div class="box-modal-inside">
                                    <a class="notification-close" href=""></a>
                                    <div class="vip-content">
                                    <h5 class="sign">Photo Stream</h5>            
                                           
                                            <div class='empty-img' id='photo-holder'>
                                            <img src='<?php echo $this->webroot . "img/dummy_image.jpg";//echo $image_url; ?>' id='user-photo'/>
                                            </div>                
                                            <!-- <input type='button' value='Upload photo' id='upload-img' class="gray-btn"/> -->
                                            <span style="position:relative; height:150px;">
                                            <input type="file" name="files[]" id="uploader-btn" style="display:block;height:150px;color: transparent;"><span class="hideformatefile"></span>
                                            <span> Drop Here</span>
                                            </span>
                                            
                                            
                                   

                                    <input type="text" class="file-photo" name="data[Stylistphotostream][caption]" id='caption' placeholder="Enter Caption">
                                    <input type="checkbox" id='is_profile' name="data[Stylistphotostream][is_profile]">: Make My Profile Pic.
                                     <a href="#" class="link-btn black-btn file-box-photo" id="file-upload-submit" class="btn btn-primary"> Submit</a> 
                                    </div> 
                                    </div>
                                    </div>
                                   

                                                <style>
                                                .hideformatefile{
                                                    background: #fff;
                                                    position: absolute;
                                                    top: -145px;
                                                    left: -153px;
                                                    width: 100px;
                                                    height: 24px;
                                                }
                                               
                                                    #upload-img{
                                                        width:100px;
                                                    }
                                                    #uploader-btn{
                                                        display: none;
                                                    }
                                                    #user-photo{
                                                        /*width:100px;*/
                                                        height: 100px;
                                                        opacity: 0;
                                                    }
                                                </style>
                                        <script>
                                            window.onload=function(){
                                                $("#upload-img").click(function(e){
                                                    e.preventDefault();
                                                $("#uploader-btn").click();
                                                    });
                                                $("#uploader-btn").change(function(){

                                                    var input = document.getElementById("uploader-btn");
                                                    if (input.files && input.files[0]) {
                                                    var reader = new FileReader();
                                                    reader.onload = function (e) {
                                                    $('#user-photo' ).attr('src', e.target.result);
                                                    $('#user-photo' ).css('opacity', 1);
                                                    $('#photo-holder' ).attr('class', '');
                                                    };
                                                    reader.readAsDataURL(input.files[0]);
                                                
                                                    }
                                                });
                                                if($('#user-photo').attr('src') != "#"){
                                                    $('#user-photo').css('opacity', 1);
                                                    $('#photo-holder' ).attr('class', '');
                                                }
                                            }
                                        </script> 
                                    

                                </div>
                                <div class="twelve columns left user-top-outfit">
                                    <h1 class="stylistbio-heading photostream top-outits-heading"><?php echo $find_array[0]['User']['first_name']; ?>’s Top Outfits</h1>
                                    <p id="topoutfit">Edit</p>
                                    <?php //print_r($stylistoutfit); ?>
                                    <?php if(isset($stylistoutfit[0]) != null){ ?>
                                    <input type="hidden" name="data[StylistTopOutfit][id]" id="id" value="<?php echo $stylistoutfit[0]['StylistTopOutfit']['id'] ?>" >
                                    <?php }else{} ?>
                                    
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
                                            <!-- <option value="2">2</option>
                                            <option value="3">3</option> -->
                                        </select>
                                        <a href="#" id="submit_outfit">Submit</a>
                                    </div>
                                    
                                    <script>
                                    $(document).ready(function(){
                                    $("#submit_outfit").on('click',function(e){
                                        e.preventDefault();
                                            var order = $("#order").val();
                                            var outfit = $("#outfit").val();
                                            var id = $("#id").val();
                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?php echo $this->webroot; ?>users/updateStylistBiographyoutfit/<?php echo $stylistid; ?>",
                                                    data: {order_id:order,outfit_id:outfit,id:id},
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
                                                        $.each(data,  function (index){
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
                                                            $("#stylisttopoutfit").html(html);

                                                        }
                                                });
                                                
                                        $("#topout").hide( "slow", function() {
                                        });
                                    });
                                });
                                    </script>

                                    <ul>
                                    <?php //print_r($my_outfit); ?>
                                        <li id="stylisttopoutfit">
                                            <?php if(isset($stylistoutfit[0]) != null){ ?>
                                            <div class="twelve columns top-outfits">
                                                <div class="eleven columns container">
                                                    <h2><?php echo $my_outfit[0]['outfit']['Outfit']['outfitname']; ?></h2>
                                                    <div class="outfit-products">
                                                        <ul>
                                                        <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit[0]['entities'][0]['Image'][0]['name']; ?>" alt="" height="108" width="122" /><div class="outfit-products-details"><?php echo $my_outfit[0]['entities'][0]['Entity']['name']; ?>  $<?php echo $my_outfit[0]['entities'][0]['Entity']['price']; ?></div></li>
                                                        <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit[0]['entities'][1]['Image'][0]['name']; ?>" alt="" height="108" width="122" /><div class="outfit-products-details"><?php echo $my_outfit[0]['entities'][1]['Entity']['name']; ?>  $<?php echo $my_outfit[0]['entities'][1]['Entity']['price']; ?></div></li>
                                                        <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit[0]['entities'][2]['Image'][0]['name']; ?>" alt="" height="108" width="122" /><div class="outfit-products-details"><?php echo $my_outfit[0]['entities'][2]['Entity']['name']; ?>  $<?php echo $my_outfit[0]['entities'][2]['Entity']['price']; ?></div></li>
                                                        <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit[0]['entities'][3]['Image'][0]['name']; ?>" alt="" height="108" width="122" /><div class="outfit-products-details"><?php echo $my_outfit[0]['entities'][3]['Entity']['name']; ?>  $<?php echo $my_outfit[0]['entities'][3]['Entity']['price']; ?></div></li>
                                                        <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit[0]['entities'][4]['Image'][0]['name']; ?>" alt="" height="108" width="122" /><div class="outfit-products-details"><?php echo $my_outfit[0]['entities'][4]['Entity']['name']; ?>  $<?php echo $my_outfit[0]['entities'][4]['Entity']['price']; ?></div></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php }else{} ?> 

                                        </li>
                                            

                                        <!-- top outfit 2 -->
                                        <p id="topoutfit2">Edit</p>
                                        <?php if(isset($stylistoutfit[1]) != null){ ?>
                                    <input type="hidden" name="data[StylistTopOutfit][id]" id="id2" value="<?php echo $stylistoutfit[1]['StylistTopOutfit']['id'] ?>" >
                                   
                                    <?php }else{ ?>

                                        <input type="hidden" name="data[StylistTopOutfit][id]" id="id2" value="" >
                                        <?php } ?>
                                    <div id="topout2" style="display:none;">
                                        <select id="outfit2">
                                            <option>Pleasa Select Outfit</option>
                                            <?php foreach($outfits as  $outfit): ?>
                                                <option value="<?php echo $outfit['Outfit']['id'] ?>"><?php echo $outfit['Outfit']['outfitname'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <br>
                                        <select id="order2">
                                            <option>Please Select Order</option>
                                            <!-- <option value="1">1</option> -->
                                            <option value="2">2</option>
                                            <!-- <option value="3">3</option> -->
                                        </select>
                                        <a href="#" id="submit_outfit2">Submit</a>
                                    </div>

                                    <script>
                                    $(document).ready(function(){
                                    $("#submit_outfit2").on('click',function(e){
                                        e.preventDefault();
                                            var order = $("#order2").val();
                                            var outfit = $("#outfit2").val();
                                            var id  = $("#id2").val();
                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?php echo $this->webroot; ?>users/updateStylistBiographyoutfit2/<?php echo $stylistid; ?>",
                                                    data: {order_id:order,outfit_id:outfit,id:id},
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
                                                            $("#stylisttopoutfit2").html(html);

                                                        }
                                                });
                                                
                                        $("#topout2").hide( "slow", function() {
                                        });
                                    });
                                });
                                    </script>
                                    <li id="stylisttopoutfit2">
                                        <?php if(isset($stylistoutfit[1]) != null){ ?>
                                        <div class="twelve columns top-outfits">
                                                <div class="eleven columns container">
                                                    <h2><?php echo $my_outfit[1]['outfit']['Outfit']['outfitname']; ?></h2>
                                                    <div class="outfit-products">
                                                        <ul>
                                                        <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit[1]['entities'][0]['Image'][0]['name']; ?>" alt="" height="108" width="122" /><div class="outfit-products-details"><?php echo $my_outfit[1]['entities'][0]['Entity']['name']; ?>  $<?php echo $my_outfit[1]['entities'][0]['Entity']['price']; ?></div></li>
                                                        <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit[1]['entities'][1]['Image'][0]['name']; ?>" alt="" height="108" width="122" /><div class="outfit-products-details"><?php echo $my_outfit[1]['entities'][1]['Entity']['name']; ?>  $<?php echo $my_outfit[1]['entities'][1]['Entity']['price']; ?></div></li>
                                                        <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit[1]['entities'][2]['Image'][0]['name']; ?>" alt="" height="108" width="122" /><div class="outfit-products-details"><?php echo $my_outfit[1]['entities'][2]['Entity']['name']; ?>  $<?php echo $my_outfit[1]['entities'][2]['Entity']['price']; ?></div></li>
                                                        <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit[1]['entities'][3]['Image'][0]['name']; ?>" alt="" height="108" width="122" /><div class="outfit-products-details"><?php echo $my_outfit[1]['entities'][3]['Entity']['name']; ?>  $<?php echo $my_outfit[1]['entities'][3]['Entity']['price']; ?></div></li>
                                                        <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit[1]['entities'][4]['Image'][0]['name']; ?>" alt="" height="108" width="122" /><div class="outfit-products-details"><?php echo $my_outfit[1]['entities'][4]['Entity']['name']; ?>  $<?php echo $my_outfit[1]['entities'][4]['Entity']['price']; ?></div></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php }else{} ?>
                                    </li>

                                    <!--top outfit 3-->
                                    
                                        <p id="topoutfit3">Edit</p>
                                        <?php
                                        //print_r($stylistoutfit);
                                         if(isset($stylistoutfit[2]) != null){ ?>
                                    <input type="hidden" name="data[StylistTopOutfit][id]" id="id3" value="<?php echo $stylistoutfit[2]['StylistTopOutfit']['id'] ?>" >
                                    <?php }else{} ?>
                                    <div id="topout3" style="display:none;">
                                        <select id="outfit3">
                                            <option>Pleasa Select Outfit</option>
                                            <?php foreach($outfits as  $outfit): ?>
                                                <option value="<?php echo $outfit['Outfit']['id'] ?>"><?php echo $outfit['Outfit']['outfitname'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <br>
                                        <select id="order3">
                                            <option>Please Select Order</option>
                                            <option value="3">3</option>
                                        </select>
                                        <a href="#" id="submit_outfit3">Submit</a>
                                    </div>

                                    <script>
                                    $(document).ready(function(){
                                    $("#submit_outfit3").on('click',function(e){
                                        e.preventDefault();
                                            var order = $("#order3").val();
                                            var outfit = $("#outfit3").val();
                                            var id = $("#id3").val();
                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?php echo $this->webroot; ?>users/updateStylistBiographyoutfit3/<?php echo $stylistid; ?>",
                                                    data: {order_id:order,outfit_id:outfit,id:id},
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
                                                            $("#stylisttopoutfit3").html(html);

                                                        }
                                                });
                                                
                                        $("#topout3").hide( "slow", function() {
                                        });
                                    });
                                });
                                    </script>
                                    <li id="stylisttopoutfit3">
                                            <?php if(isset($stylistoutfit[2]) != null){ ?>
                                        <div class="twelve columns top-outfits">
                                                <div class="eleven columns container">
                                                    <h2><?php echo $my_outfit[2]['outfit']['Outfit']['outfitname']; ?></h2>
                                                    <div class="outfit-products">
                                                        <ul>
                                                        <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit[2]['entities'][0]['Image'][0]['name']; ?>" alt="" height="108" width="122" /><div class="outfit-products-details"><?php echo $my_outfit[2]['entities'][0]['Entity']['name']; ?>  $<?php echo $my_outfit[2]['entities'][0]['Entity']['price']; ?></div></li>
                                                        <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit[2]['entities'][1]['Image'][0]['name']; ?>" alt="" height="108" width="122" /><div class="outfit-products-details"><?php echo $my_outfit[2]['entities'][1]['Entity']['name']; ?>  $<?php echo $my_outfit[2]['entities'][1]['Entity']['price']; ?></div></li>
                                                        <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit[2]['entities'][2]['Image'][0]['name']; ?>" alt="" height="108" width="122" /><div class="outfit-products-details"><?php echo $my_outfit[2]['entities'][2]['Entity']['name']; ?>  $<?php echo $my_outfit[2]['entities'][2]['Entity']['price']; ?></div></li>
                                                        <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit[2]['entities'][3]['Image'][0]['name']; ?>" alt="" height="108" width="122" /><div class="outfit-products-details"><?php echo $my_outfit[2]['entities'][3]['Entity']['name']; ?>  $<?php echo $my_outfit[2]['entities'][3]['Entity']['price']; ?></div></li>
                                                        <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit[2]['entities'][4]['Image'][0]['name']; ?>" alt="" height="108" width="122" /><div class="outfit-products-details"><?php echo $my_outfit[2]['entities'][4]['Entity']['name']; ?>  $<?php echo $my_outfit[2]['entities'][4]['Entity']['price']; ?></div></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php }else{} ?>


                                    </li>





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