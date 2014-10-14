
<?php
if(isset($StylistBioData['StylistBio']['id'])!=''){ 
    $stylistBioId  = $StylistBioData['StylistBio']['id'];
 }else{
    $stylistBioId = '';
 }

$stylistid  = $user['User']['id'];
 ?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){

// stylist bio graphy
    $(document).on('click', '.actions a#submit_stylist_bio', function(e){
        e.preventDefault();
        
        var id = $("#id").val();
        var Bio = $("#StylebioStylistBio").val();
        alert(Bio);
        var BioId = '<?php echo $stylistBioId; ?>';
        var stylist_id = '<?php echo $stylistid; ?>';
        $.ajax({
            type: "POST",
            url: "<?php echo $this->webroot; ?>stylists/saveBiography/<?php echo $stylistid; ?>",
            data: {stylist_bio:Bio,id:id,BioId:BioId,stylist_id:stylist_id},
            cache: false,
            success: function(result){
                 //var data = $.parseJSON(result);
                 $(".user-desc").html(Bio);    
            }
                
            
        });
    });

// stylist inspration

    $(document).on('click', '.actions a#submit_stylist_inspiration', function(e){
        e.preventDefault();
        
        var id = $("#id").val();
        var inspiration = $("#inspiration").val();
        //alert(Bio);
        var BioId = '<?php echo $stylistBioId; ?>';
        var stylist_id = '<?php echo $stylistid; ?>';
        $.ajax({
            type: "POST",
            url: "<?php echo $this->webroot; ?>stylists/saveInspiration/<?php echo $stylistid; ?>",
            data: {stylist_inspiration:inspiration,id:id,BioId:BioId,stylist_id:stylist_id},
            cache: false,
            success: function(result){
                
                 $(".user-inspire-desc").text(inspiration);    
            }
                
            
        });
    });



 // stylist homw town submit_stylist_hometown   

    $(document).on('click', '.actions a#submit_stylist_hometown', function(e){
        e.preventDefault();
        
        var id = $("#id").val();
        var hometown = $("#hometown").val();
        //alert(Bio);
        var BioId = '<?php echo $stylistBioId; ?>';
        var stylist_id = '<?php echo $stylistid; ?>';
        $.ajax({
            type: "POST",
            url: "<?php echo $this->webroot; ?>stylists/saveHometown/<?php echo $stylistid; ?>",
            data: {hometown:hometown,id:id,BioId:BioId,stylist_id:stylist_id},
            cache: false,
            success: function(result){
                 
                 $("span#texthometown").text(hometown);    
            }
                
            
        });
    }); 

   // submit_stylist_funfact

    $(document).on('click', '.actions a#submit_stylist_funfact', function(e){
        e.preventDefault();
        
        var id = $("#id").val();
        var funfact = $("#funfact").val();
        //alert(Bio);
        var BioId = '<?php echo $stylistBioId; ?>';
        var stylist_id = '<?php echo $stylistid; ?>';
        $.ajax({
            type: "POST",
            url: "<?php echo $this->webroot; ?>stylists/saveFunfact/<?php echo $stylistid; ?>",
            data: {funfact:funfact,id:id,BioId:BioId,stylist_id:stylist_id},
            cache: false,
            success: function(result){
                 
                 $("span#textfunfact").text(funfact);    
            }
                
            
        });
    });

   // submit_stylist_fashion_tip

    $('.delete-potostream-img').on('click', function(e){
        e.preventDefault();

        var id = $("#id").val();
        var photoId = $(this).closest('li').find('img').data('photoid');
        var stylist_id = '<?php echo $stylistid; ?>';
        $(this).closest('li').remove();
        $.ajax({
            type: "POST",
            url: "<?php echo $this->webroot; ?>stylists/removePhoto/<?php echo $stylistid; ?>",
            data: {stylist_id:stylist_id, photo_id:photoId},
            cache: false,
            success: function(result){
                    
            }
        });
    });


    $(document).on('click', '.sosl-link-edit-pintrst .edit-save-btn', function(e){
        e.preventDefault();

        var id = $("#id").val();
        var pinterest = $("#stylist-pinterest-url").val();
        //alert(Bio);
        var BioId = '<?php echo $stylistBioId; ?>';
        var stylist_id = '<?php echo $stylistid; ?>';
        $.ajax({
            type: "POST",
            url: "<?php echo $this->webroot; ?>stylists/savePinterest/<?php echo $stylistid; ?>",
            data: {pinterest:pinterest,id:id,BioId:BioId,stylist_id:stylist_id},
            cache: false,
            success: function(result){
                 
            }
                
            
        });
        
    });


    $(document).on('click', '.sosl-link-edit-twtr .edit-save-btn', function(e){
        e.preventDefault();

        var id = $("#id").val();
        var twitter = $("#stylist-twitter-url").val();
        //alert(Bio);
        var BioId = '<?php echo $stylistBioId; ?>';
        var stylist_id = '<?php echo $stylistid; ?>';
        $.ajax({
            type: "POST",
            url: "<?php echo $this->webroot; ?>stylists/saveTwitter/<?php echo $stylistid; ?>",
            data: {twitter:twitter,id:id,BioId:BioId,stylist_id:stylist_id},
            cache: false,
            success: function(result){
                 
            }
                
            
        });
        
    });


    $(document).on('click', '.sosl-link-edit-linkin .edit-save-btn', function(e){
        e.preventDefault();

        var id = $("#id").val();
        var linkdin = $("#stylist-linkedin-url").val();
        //alert(Bio);
        var BioId = '<?php echo $stylistBioId; ?>';
        var stylist_id = '<?php echo $stylistid; ?>';
        $.ajax({
            type: "POST",
            url: "<?php echo $this->webroot; ?>stylists/saveLinkedin/<?php echo $stylistid; ?>",
            data: {linkdin:linkdin,id:id,BioId:BioId,stylist_id:stylist_id},
            cache: false,
            success: function(result){
                 
            }
                
            
        });
        
    });


    $(document).on('click', '.sosl-link-edit-fb .edit-save-btn', function(e){
        e.preventDefault();

        var id = $("#id").val();
        var facebook = $("#stylist-facebook-url").val();
        //alert(Bio);
        var BioId = '<?php echo $stylistBioId; ?>';
        var stylist_id = '<?php echo $stylistid; ?>';
        $.ajax({
            type: "POST",
            url: "<?php echo $this->webroot; ?>stylists/saveFacebook/<?php echo $stylistid; ?>",
            data: {facebook:facebook,id:id,BioId:BioId,stylist_id:stylist_id},
            cache: false,
            success: function(result){
                 
            }
                
            
        });
        
    });



   // submit social network

    $(document).on('click', '.actions a#submit_stylist_fashion_tip', function(e){
        e.preventDefault();
        var id = $("#id").val();
        var fashion_tip = $("#fashion_tip").val();
        var BioId = '<?php echo $stylistBioId; ?>';
        var stylist_id = '<?php echo $stylistid; ?>';
        $.ajax({
            type: "POST",
            url: "<?php echo $this->webroot; ?>stylists/saveFashionTip/<?php echo $stylistid; ?>",
            data: {fashion_tip:fashion_tip,id:id,BioId:BioId,stylist_id:stylist_id},
            cache: false,
            success: function(result){
                 $("span#textfashiontip").text(fashion_tip);    
            }
                
            
        });
    });


    // stylist photo stream

    // $(document).on('click', 'a#saveimg', function(e){
    //     e.preventDefault();
        
    //     //var id = $("#id").val();
    //     var uploaderbtn = $("#uploader-btn").val();
    //     var stylist_id = '<?php echo $stylistid; ?>';
    //     alert(uploaderbtn);
    //     $.ajax({
    //         type: "POST",
    //         url: "<?php echo $this->webroot; ?>stylists/savePhoto/<?php echo $stylistid; ?>",
    //         data: {image:uploaderbtn,stylist_id:stylist_id},
    //         cache: false,
    //         success: function(result){
    //             data = $.parseJSON(result);
    //             html = '';
    //             $.each(data, function(index){
    //                 html = html + this.StylistBio.fashion_tip;
                    
    //             });
    //              $("span#textfashiontip").text(html);    
    //             }
                
            
    //     });
    // });

   // submit outfit order number first (1)

    $(document).on('click', "#submit_outfit1", function(e){
        e.preventDefault();
        var outfit = $("#outfit").val();
        if(outfit == ""){
            return false;
        }
        var stylist_id = '<?php echo $stylistid; ?>';
        var order_id =  '1';
            $.ajax({
                type: "POST",
                url: "<?php echo $this->webroot; ?>stylists/saveOutfitFirst/<?php echo $stylistid; ?>",
                data: {order_id:order_id,outfit_id:outfit},
                cache: false,
                success: function(data){
                    location.reload();
                    data = $.parseJSON(data);
                    html = '';

                    $.each(data,  function (index){
                    html = html + '<li>';
                    html = html + '<div class="twelve columns top-outfits">';
                    html = html + '<div class="eleven columns container">';
                    html = html + '<h2>'+ this.outfit.Outfit.outfitname +'</h2>';
                    html = html + '<div class="outfit-products">';
                    html = html + '<ul>';
                    var entimg = this.entities;
                    $.each(entimg, function(index1){
                          
                    // var imgent = entimg[index1].Image;
                    // if(imgent != ''){
                        html = html + '<li><img src="<?php echo $this->webroot; ?>files/products/'+ entimg[index1].Image[0].name +'" alt=""  />';
                        html = html + '<div class="outfit-products-details">'+ entimg[index1].Entity.name+' $'+ entimg[index1].Entity.Price + '</div></li>';

                       
                    // }else{
                    //     html = html + '<li>';
                    //     html = html + '<div class="outfit-products-details">'+ entimg[index1].Entity.name+' $'+ entimg[index1].Entity.Price + '</div></li>';
                    // }
                    });
                    
                    html = html + '</ul>';
                    html = html + '</div>';
                    html = html + '</div>';
                    html = html + '</div>';
                    html = html + '</li>';
                //console.log("this.entities");
                });
                $("#OutfitFirst").html(html);

                }
            });
    });

    //  submit outfit order number Second (2) saveOutfitSecond


    $(document).on('click', "#submit_outfit2", function(e){
        e.preventDefault();
        var outfit2 = $("#outfit2").val();
        if(outfit2 == ""){
            return false;
        }
        var order_id = '2';
        //alert(outfit);
        var stylist_id = '<?php echo $stylistid; ?>';
         //alert(outfit);
            $.ajax({
                type: "POST",
                url: "<?php echo $this->webroot; ?>stylists/saveOutfitSecond/<?php echo $stylistid; ?>",
                data: {order_id:order_id,outfit_id:outfit2},
                cache: false,
                success: function(data){
                    location.reload();
                    data = $.parseJSON(data);
                    html = '';

                    $.each(data,  function (index){
                    html = html + '<li>';
                    html = html + '<div class="twelve columns top-outfits">';
                    html = html + '<div class="eleven columns container">';
                    html = html + '<h2>'+ this.outfit.Outfit.outfitname +'</h2>';
                    html = html + '<div class="outfit-products">';
                    html = html + '<ul>';
                    var entimg = this.entities;
                    $.each(entimg, function(index1){

                    // var imgent = entimg[index1].Image;
                    // if(imgent != ''){
                        html = html + '<li><img src="<?php echo $this->webroot; ?>files/products/'+ entimg[index1].Image[0].name +'" alt=""  />';
                        html = html + '<div class="outfit-products-details">'+ entimg[index1].Entity.name+' $'+ entimg[index1].Entity.Price + '</div></li>';

                       
                    // }else{
                    //     html = html + '<li>';
                    //     html = html + '<div class="outfit-products-details">'+ entimg[index1].Entity.name+' $'+ entimg[index1].Entity.Price + '</div></li>';
                    // }
                    });
                    
                    html = html + '</ul>';
                    html = html + '</div>';
                    html = html + '</div>';
                    html = html + '</div>';
                    html = html + '</li>';
                //console.log("this.entities");
                });
                $("#OutfitSecond").html(html);

                }
            });
    });

    // saveOutfitThird


    $(document).on('click', "#submit_outfit3", function(e){
        e.preventDefault();
        var outfit3 = $("#outfit3").val();
        if(outfit3 == ""){
            return false;
        }
        var stylist_id = '<?php echo $stylistid; ?>';
        var order_id = '3';
            $.ajax({
                type: "POST",
                url: "<?php echo $this->webroot; ?>stylists/saveOutfitThird/<?php echo $stylistid; ?>",
                data: {order_id:order_id,outfit_id:outfit3},
                cache: false,
                success: function(data){
                    location.reload();
                    data = $.parseJSON(data);
                    html = '';

                    $.each(data,  function (index){
                    html = html + '<li>';
                    html = html + '<div class="twelve columns top-outfits">';
                    html = html + '<div class="eleven columns container">';
                    html = html + '<h2>'+ this.outfit.Outfit.outfitname +'</h2>';
                    html = html + '<div class="outfit-products">';
                    html = html + '<ul>';
                    var entimg = this.entities;
                    $.each(entimg, function(index1){
                    //var imgent = entimg[index1].Image;
                    //if(imgent != ''){
                        html = html + '<li><img src="<?php echo $this->webroot; ?>files/products/'+ entimg[index1].Image[0].name +'" alt=""  />';
                        html = html + '<div class="outfit-products-details">'+ entimg[index1].Entity.name+' $'+ entimg[index1].Entity.Price + '</div></li>';

                       
                    //}else{
                       // html = html + '<li>';
                        //html = html + '<div class="outfit-products-details">'+ entimg[index1].Entity.name+' $'+ entimg[index1].Entity.Price + '</div></li>';
                    //}
                    });
                    
                    html = html + '</ul>';
                    html = html + '</div>';
                    html = html + '</div>';
                    html = html + '</div>';
                    html = html + '</li>';
                //console.log("this.entities");
                });
                $("#OutfitThird").html(html);

                }
            });
    });


});
</script>
<?php
$meta_description = 'As an SRS Man, great things are expected of you. But let us take care of the details. <br/> We\'ll perfect your image from head to toe.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>
<div>
    <div class="eleven columns container content inner stylistbio">
        <div class="twelve columns container stylistbio-section left">
            
            <?php echo $this->element('clientAside/userFilterBar'); ?>

            <div class="stylistbio-section-right">
                <div class="eleven columns container">
                    <div class="twelve columns">
                        <div class="stylistbio-profile left text-center">
                            <div class="profile-img">
                                <?php if($user['User']['profile_photo_url']): ?>
                                    <img src="<?php echo $this->webroot; ?>files/users/<?php echo $user['User']['profile_photo_url']; ?>" height='' alt="" />
                                <?php else: ?>
                                    <img src="<?php echo $this->webroot; ?>images/default-user.jpg" alt="" />
                                <?php endif; ?>
                                <div class="profile-img-edit">
                                    <span class="edit-section"><img src="<?php echo $this->webroot; ?>images/edit-icon.png" /></span>
                                </div>
                                
                            </div>
                            <div id="file-box-profile" class="box-modal notification-box" style="display: none;">
                                <div class="box-modal-inside">
                                    <a class="notification-close" href=""></a>
                                        <div class="vip-content">
                                            <h5 class="sign">Profile Image</h5>  
                                            <?php
                                                echo $this->Form->create('Stylists', array('type'=>'file','url'=>'saveProfilePhoto/'.$stylistid)); 
                                                    echo $this->Form->input('User.profile_photo_url', array('type' => 'file', 'id'=>'uploader-btn', 'label' => false));
                                                ?>  
                                               <input class="biography-upload-img" type="submit" value="submit">
                                                </form>
                                                    
                                        </div>
                                </div>
                           </div> 
                            <div class=" twelve columns social-networks">
                                <ul>
                                <?php 
                                if(isset($StylistBioData['StylistBio'])){
                                    $social = json_decode($StylistBioData['StylistBio']['stylist_social_link'],true);     
                                }
                                else{
                                    $social = array();
                                }
                                ?>
                                    <li class="pintrest">
                                        <a href="<?php echo isset($social['pinterest']) ? $social['pinterest'] : '#'; ?>" target="_blank" title="">Printrest</a>
                                        <div class="social-ntwrk-edit social-ntwrk-edit-pintrst">
                                            <span class="edit-section"><img src="<?php echo $this->webroot; ?>images/edit-icon.png" /></span>
                                        </div>
                                        
                                    </li>
                                    <li class="twitter">
                                        <a href="<?php echo isset($social['twiter']) ? $social['twiter'] : '#'; ?>" target="_blank" title="">Twitter</a>
                                        <div class="social-ntwrk-edit social-ntwrk-edit-twtr">
                                            <span class="edit-section"><img src="<?php echo $this->webroot; ?>images/edit-icon.png" /></span>
                                        </div>
                                    </li>
                                    <li class="linkdin">
                                        <a href="<?php echo isset($social['linkdin']) ? $social['linkdin'] : '#'; ?>" target="_blank" title="">Linkdin</a>
                                        <div class="social-ntwrk-edit social-ntwrk-edit-linkin">
                                            <span class="edit-section"><img src="<?php echo $this->webroot; ?>images/edit-icon.png" /></span>
                                        </div>
                                    </li>
                                    <li class="facebbok">
                                        <a href="<?php echo isset($social['facebook']) ? $social['facebook'] : '#'; ?>" target="_blank" title="">facebook</a>
                                        <div class="social-ntwrk-edit social-ntwrk-edit-fb">
                                            <span class="edit-section"><img src="<?php echo $this->webroot; ?>images/edit-icon.png" /></span>
                                        </div>
                                    </li>
                                </ul>
                                <form class="sosl-link-edit sosl-link-edit-pintrst" method="post" action="" name="edithometown">
                                    <label>Your Link Here</label>
                                    <div class="edit-content">
                                    <input type="text"  value="<?php echo isset($social['pinterest']) ? $social['pinterest'] : ''; ?>" placeholder="Pinterest link" id="stylist-pinterest-url">
                                   </div>
                                    <p class="actions">
                                    <a class="edit-save-btn primry-btn">Submit</a>
                                    <button class="cancel-btn secondry-btn" type="button">Cancel</button>
                                    </p>
                                </form>
                                <form class="sosl-link-edit sosl-link-edit-twtr" method="post" action="" name="edithometown">
                                    <label>Your Link Here</label>
                                    <div class="edit-content">
                                    <input type="text"  value="<?php echo isset($social['twiter']) ? $social['twiter'] : ''; ?>" placeholder="Twitter Link" id="stylist-twitter-url">
                                   </div>
                                    <p class="actions">
                                    <a class="edit-save-btn primry-btn">Submit</a>
                                    <button class="cancel-btn secondry-btn" type="button">Cancel</button>
                                    </p>
                                </form>
                                <form class="sosl-link-edit sosl-link-edit-linkin" method="post" action="" name="edithometown">
                                    <label>Your Link Here</label>
                                    <div class="edit-content">
                                    <input type="text"  value="<?php echo isset($social['linkdin']) ? $social['linkdin'] : ''; ?>" placeholder="Linkedin Link" id="stylist-linkedin-url">
                                   </div>
                                    <p class="actions">
                                    <a class="edit-save-btn primry-btn">Submit</a>
                                    <button class="cancel-btn secondry-btn" type="button">Cancel</button>
                                    </p>
                                </form>
                                <form class="sosl-link-edit sosl-link-edit-fb" method="post" action="" name="edithometown">
                                    <label>Your Link Here</label>
                                    <div class="edit-content">
                                    <input type="text"  value="<?php echo isset($social['facebook']) ? $social['facebook'] : ''; ?>" placeholder="Facebook Link" id="stylist-facebook-url">
                                   </div>
                                    <p class="actions">
                                    <a class="edit-save-btn primry-btn">Submit</a>
                                    <button class="cancel-btn secondry-btn" type="button">Cancel</button>
                                    </p>
                                </form>
                            </div>
                            <div class="stylistbio-heading-section">
                            <h1 class="stylistbio-heading"><?php echo $user['User']['first_name']; ?>’s Bio <span class="edit-section edit-section-stylistbio-heading"><img src="<?php echo $this->webroot; ?>images/edit-icon.png" /></span></h1>
                            <?php //print_r($StylistBioData);?>
                                        <form class="stylistbio-heading-edit" method="post" name="edithometown">
                                            <label><?php echo $user['User']['first_name']; ?>’s Bio</label>
                                            <div class="edit-content">
                                                <textarea name="data[StyleBio][stylist_bio]" rows="10" cols=""  id="StylebioStylistBio">
                                                <?php echo ($StylistBioData && $StylistBioData['StylistBio']) ? $StylistBioData['StylistBio']['stylist_bio'] : "" ?>
                                                </textarea>
                                            </div>
                                            <p class="actions">
                                            <a class="edit-save-btn primry-btn" id="submit_stylist_bio">Submit</a>
                                            <button class="cancel-btn secondry-btn" type="button">Cancel</button>
                                            </p>
                                        </form>
                                </div>
                            <div class="user-desc">
                                <?php echo ($StylistBioData && $StylistBioData['StylistBio']) ? $StylistBioData['StylistBio']['stylist_bio'] : "" ?>
                            </div>

                            <div class="stylist-insp">
                                <h1 class="stylistbio-heading"><?php echo $user['User']['first_name']; ?>’s Inspiration<span class="edit-section edit-section-stylist-insp"><img src="<?php echo $this->webroot; ?>images/edit-icon.png" /></span></h1>
                                <form class="stylist-insp-edit" method="post" action="" name="edithometown">
                                    <label>Inspiration</label>
                                    <div class="edit-content">
                                        <textarea  rows="10" cols=""  id="inspiration">
                                                <?php if($StylistBioData): 
                                                    echo $StylistBioData['StylistBio']['stylist_inspiration'];
                                                    else:
                                                    endif;
                                                ?>
                                                </textarea>

                                    </div>
                                    <p class="actions">
                                    <a class="edit-save-btn primry-btn" id="submit_stylist_inspiration">Submit</a>
                                    <button class="cancel-btn secondry-btn" type="button">Cancel</button>
                                    </p>
                                </form>
                            </div>
                            <div class="user-inspire-desc">
                                <?php if($StylistBioData): 
                                    echo $StylistBioData['StylistBio']['stylist_inspiration'];
                                    else:
                                    endif;
                                ?>
                             </div>
                        </div>
                        <div class="stylistbio-details right">
                            <div class="twelve columns left">
                                <div class="stylistbio-user"><?php echo $user['User']['first_name'].'&nbsp;'.$user['User']['last_name']; ?> | Stylist</div>
                            </div>
                            <div class="twelve columns left detials-section">
                                <div class="twelve columns details">
                                    <div class="home-town">
                                        <span class="style-upper">Hometown:</span> <span class="style-italic" id="texthometown">
                                        <?php if($StylistBioData): echo $StylistBioData['StylistBio']['hometown']; else: endif; ?>
                                        </span><span class="edit-section home-edit-section"><img src="<?php echo $this->webroot; ?>images/edit-icon.png" /></span>
                                        <form class="home-edit" method="post" action="" name="edithometown">
                                            <label>Your Home Town</label>
                                            <div class="edit-content">
                                            <?php if($StylistBioData): ?>
                                            <input type="text" id="hometown" value="<?php echo $StylistBioData['StylistBio']['hometown']; ?>" placeholder="Enter your Fun Fact">
                                            <?php else: ?>
                                             <input type="text" id="hometown" placeholder="Enter your Fun Fact">   
                                            <?php endif; ?>
                                       
                                            </div>
                                            <p class="actions">
                                            <a class="edit-save-btn primry-btn" id="submit_stylist_hometown">Submit</a>
                                            <button class="cancel-btn secondry-btn" type="button">Cancel</button>
                                            </p>
                                        </form>
                                    </div>
                                    <div class="fun-fact"><span class="style-upper">Fun Fact:</span> 
                                        <span class="style-italic" id="textfunfact">
                                        <?php if($StylistBioData): echo $StylistBioData['StylistBio']['funfact']; else: endif; ?>
                                        </span>
                                        <span class="edit-section fun-edit-section"><img src="<?php echo $this->webroot; ?>images/edit-icon.png" /></span>
                                        <form class="fun-edit" method="post" action="" name="edithometown">
                                            <label>Your Fun Fact</label>
                                            <div class="edit-content">
                                            <?php if($StylistBioData): ?>
                                                <input type="text" id="funfact" value="<?php echo $StylistBioData['StylistBio']['funfact']; ?>" placeholder="Enter Your Fun Fact">
                                            <?php else: ?>
                                                <input type="text" id="funfact" placeholder="Enter Your Fun Fact">   
                                            <?php endif; ?>
                                            </div>
                                            <p class="actions">
                                            <a class="edit-save-btn primry-btn" id="submit_stylist_funfact">Submit</a>
                                            <button class="cancel-btn secondry-btn" type="button">Cancel</button>
                                            </p>
                                        </form>
                                    </div>
                                    <div class="fashion-tips">
                                        <span class="style-upper">Number 1 Fashion Tip:</span> <span class="style-italic" id="textfashiontip">
                                        <?php if($StylistBioData): echo $StylistBioData['StylistBio']['fashion_tip']; else: endif; ?>
                                        </span>
                                        <span class="edit-section tip-edit-section"><img src="<?php echo $this->webroot; ?>images/edit-icon.png" /></span>
                                        <form class="tip-edit" method="post" action="" name="edithometown">
                                            <label>Your Fashion Tip</label>
                                            <div class="edit-content">
                                            <?php if($StylistBioData): ?>
                                                <input type="text" id="fashion_tip" value="<?php echo $StylistBioData['StylistBio']['fashion_tip']; ?>" placeholder="Enter Your Fun Fact">
                                            <?php else: ?>
                                                <input type="text" id="fashion_tip" placeholder="Enter Your Fun Fact">   
                                            <?php endif; ?>

                                            </div>
                                            <p class="actions">
                                            <a class="edit-save-btn primry-btn" id="submit_stylist_fashion_tip">Submit</a>
                                            <button class="cancel-btn secondry-btn" type="button">Cancel</button>
                                            </p>
                                        </form>
                                    </div>
                                </div>
                                <div class="twelve columns left user-photostream">
                                    <h1 class="stylistbio-heading photostream"><?php echo $user['User']['first_name']; ?>’s Photostream</h1>
                                    <div class="photostream-section">
                                        <ul id="itemContainer">
                                            <?php
                                            //print_r($photostreampicsstylist);
                                             foreach($photostreampicsstylist as $photostreampicss ): ?>
                                            <li>
                                                <a class="fancybox" href="<?php echo $this->webroot; ?>files/photostream/<?php echo $photostreampicss['StylistPhotostream']['image']; ?>" data-fancybox-group="gallery" title="<?php echo $photostreampicss['StylistPhotostream']['caption']; ?>">
                                                <img class='img-gal' src="<?php echo $this->webroot; ?>files/photostream/<?php echo $photostreampicss['StylistPhotostream']['image']; ?>" alt="" data-photoid = "<?php echo $photostreampicss['StylistPhotostream']['id']; ?>" />
                                                
                                                </a>
                                                <div class="photostream-edit-section">
                                                    <!-- <span class="edit-section tip-edit-photostream"><img src="<?php echo $this->webroot; ?>images/edit-icon.png" /></span>
                                                    <span class="edit-caption-txt">Edit Caption</span>
                                                    <span class="edit-caption-area">
                                                        <textarea name="" placeholder="I styled my friends wedding. I love the colors"></textarea>
                                                        <p class="actions">
                                                            <a class="edit-save-btn primry-btn" id="submit_stylist_fashion_tip">Submit</a>
                                                            <button class="cancel-btn secondry-btn" type="button">Cancel</button>
                                                        </p>
                                                    </span> -->
                                                    <button class="delete-potostream-img">Delete Photo</button>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                            
                                            </ul>
                                        <div class="submit"><a href="#" id="block-file-upload-photo" class="biography-upload-img left">Upload</a></div>

                                        <!--file upload-->
                                        <!--file upload -->
                                        <style type="text/css">
                                        .photostream input[type="checkbox"]{
                                            visibility: visible;
                                        }
                                        </style>
                                    <div id="file-box-photo" class="box-modal notification-box" style="display: none;">
                                        <div class="box-modal-inside">
                                            <a class="notification-close" href=""></a>
                                                <div class="vip-content">
                                                    <h5 class="sign">Photo Stream</h5>            
                                                       <?php
                                                        echo $this->Form->create('StylistPhotostream', array('type'=>'file','url'=>'savePhoto/'.$stylistid)); 
                                                            echo $this->Form->input('StylistPhotostream.image', array('type' => 'file', 'id'=>'uploader-btn', 'label' => false));
                                                            echo $this->Form->input('StylistPhotostream.caption');
                                                        ?>
                                                        <label>Make Me Profile Pic</label>
                                                        <input type="checkbox" name="data[StylistPhotostream][is_profile]" style="visibility: visible;"><br/>    
                                                        <input class="biography-upload-img" type="submit" value="submit">
                                                        </form>
                                                            
                                                </div>
                                        </div>
                                   </div> 
                                    
                                    
                                    <!-- file upload-->

                                        <div class="holder edit-biogrpy"></div>
                                    </div>
                                </div>
                                <div class="twelve columns left user-top-outfit">
                                    <h1 class="stylistbio-heading photostream top-outits-heading"><?php echo $user['User']['first_name']; ?>’s Top Outfits <span class="edit-section edit-outfit-section"><img src="<?php echo $this->webroot; ?>images/edit-icon.png" /></span></h1>

                                    <ul>
                                        <li id="OutfitFirst">
                                            <span class="edit-section edit-beachday-section right beachday-content-update1"><img src="<?php echo $this->webroot; ?>images/edit-icon.png" /></span>
                                            <form class="beachday-update1" method="post" action="" name="beachday">
                                                <label>Select Your Outfit</label>
                                                <div class="edit-content">
                                                    <span class="edit-content-icon"></span>
                                                    <select id="outfit">
                                                    <option value="">Please select an outfit</option>
                                                    <?php foreach($outfits as  $outfit): ?>
                                                        <?php if($outfit['Outfit']['outfit_name'] != ""): ?>
                                                            <option value="<?php echo $outfit['Outfit']['id'] ?>"><?php echo $outfit['Outfit']['outfit_name']; ?></option>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                    </select>
                                                    
                                                </div>
                                                <p class="actions">
                                                <a href="#" id="submit_outfit1" class="primry-btn">Submit</a>
                                                <button class="cancel-btn secondry-btn" type="button">Cancel</button>
                                                </p>
                                            </form>
                                            <div class="twelve columns top-outfits">
                                                <?php if(isset($my_outfit[0])): ?>
                                                <div class="eleven columns container">
                                                    <h2>
                                                    <?php if($my_outfit[0]['outfit']): $my_outfit[0]['outfit'][0]['Outfit']['outfit_name']; else: endif;
                                                    ?>
                                                    </h2>
                                                    <div class="outfit-products">
                                                        <ul>
                                                    <?php
                                                    $topoutfit1s = $my_outfit[0]['entities'];
                                                    foreach($topoutfit1s as $topoutfit1): 
                                                    ?>
                                                        <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $topoutfit1['Image'][0]['name']; ?>" alt="" />
                                                <div class="outfit-products-details"><?php echo $topoutfit1['Entity']['name']; ?>  $<?php echo $topoutfit1['Entity']['price']; ?></div></li>
                                                    <?php endforeach; ?>
                                                        <!-- <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit[0]['entities'][1]['Image'][0]['name']; ?>" alt="" height="108" width="122" /><div class="outfit-products-details"><?php echo $my_outfit[0]['entities'][1]['Entity']['name']; ?>  $<?php echo $my_outfit[0]['entities'][1]['Entity']['price']; ?></div></li>
                                                        <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit[0]['entities'][2]['Image'][0]['name']; ?>" alt="" height="108" width="122" /><div class="outfit-products-details"><?php echo $my_outfit[0]['entities'][2]['Entity']['name']; ?>  $<?php echo $my_outfit[0]['entities'][2]['Entity']['price']; ?></div></li>
                                                        <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit[0]['entities'][3]['Image'][0]['name']; ?>" alt="" height="108" width="122" /><div class="outfit-products-details"><?php echo $my_outfit[0]['entities'][3]['Entity']['name']; ?>  $<?php echo $my_outfit[0]['entities'][3]['Entity']['price']; ?></div></li>
                                                        <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $my_outfit[0]['entities'][4]['Image'][0]['name']; ?>" alt="" height="108" width="122" /><div class="outfit-products-details"><?php echo $my_outfit[0]['entities'][4]['Entity']['name']; ?>  $<?php echo $my_outfit[0]['entities'][4]['Entity']['price']; ?></div></li> -->
                                                        </ul>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                            <div class="eleven columns container">
                                            <h2>Please Select An outfit For First Ordering.</h2>
                                            </div>

                                            <?php endif; ?>
                                            </div>
                                        </li>
                                        <li id="OutfitSecond">
                                            <span class="edit-section edit-beachday-section right beachday-content-update2"><img src="<?php echo $this->webroot; ?>images/edit-icon.png" /></span>
                                            <form class="beachday-update2" method="post" action="" name="beachday">
                                                <label>Select Your Outfit</label>
                                                <div class="edit-content">
                                                    <span class="edit-content-icon"></span>
                                                    <select id="outfit2">
                                                    <option value="">Please select an outfit</option>
                                                    <?php foreach($outfits as  $outfit): ?>
                                                        <?php if($outfit['Outfit']['outfit_name'] != ""): ?>
                                                            <option value="<?php echo $outfit['Outfit']['id'] ?>"><?php echo $outfit['Outfit']['outfit_name']; ?></option>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                    </select>
                                                    
                                                </div>
                                                <p class="actions">
                                                <a href="#" id="submit_outfit2" class="primry-btn">Submit</a>
                                                <button class="cancel-btn secondry-btn" type="button">Cancel</button>
                                                </p>
                                            </form>
                                            <div class="twelve columns top-outfits">
                                                <?php if(isset($my_outfit[1])): ?>
                                                <div class="eleven columns container">
                                                    <h2>
                                                    <?php if($my_outfit[1]['outfit']): $my_outfit[1]['outfit'][0]['Outfit']['outfit_name']; else: endif;
                                                    ?>
                                                    </h2>
                                                    <div class="outfit-products">
                                                        <ul>
                                                    <?php
                                                        $topoutfit2s = $my_outfit[1]['entities'];
                                                        foreach($topoutfit2s as $topoutfit2): 
                                                    ?>
                                                        <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $topoutfit2['Image'][0]['name']; ?>" alt="" />
                                                <div class="outfit-products-details"><?php echo $topoutfit2['Entity']['name']; ?>  $<?php echo $topoutfit2['Entity']['price']; ?></div></li>
                                                    <?php endforeach; ?>
                                                            
                                                        </ul>
                                                    </div>
                                                </div>
                                               <?php else: ?>
                                                <div class="eleven columns container">
                                                <h2>Please Select An outfit For Second Ordering.</h2>
                                                </div>

                                                <?php endif; ?>
                                            </div>
                                        </li>
                                        <li id="OutfitThird">
                                            <span class="edit-section edit-beachday-section right beachday-content-update3"><img src="<?php echo $this->webroot; ?>images/edit-icon.png" /></span>
                                            <form class="beachday-update3" method="post" action="" name="beachday">
                                                <label>Select Your Outfit</label>
                                                <div class="edit-content">
                                                    <span class="edit-content-icon"></span>
                                                    <select id="outfit3">
                                                    <option value="">Please select an outfit</option>
                                                    <?php foreach($outfits as  $outfit): ?>
                                                        <?php if($outfit['Outfit']['outfit_name'] != ""): ?>
                                                            <option value="<?php echo $outfit['Outfit']['id'] ?>"><?php echo $outfit['Outfit']['outfit_name']; ?></option>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                    </select>
                                                    
                                                </div>
                                                <p class="actions">
                                                <a href="#" id="submit_outfit3" class="primry-btn">Submit</a>
                                                <button class="cancel-btn secondry-btn" type="button">Cancel</button>
                                                </p>
                                            </form>
                                            <div class="twelve columns top-outfits">
                                                <div class="twelve columns top-outfits">
                                                <?php if(isset($my_outfit[2])): ?>
                                                <div class="eleven columns container">
                                                    <h2>
                                                    <?php if($my_outfit[2]['outfit']): $my_outfit[2]['outfit'][0]['Outfit']['outfit_name']; else: endif;
                                                    ?>
                                                    </h2>
                                                    <div class="outfit-products">
                                                        <ul>
                                                    <?php
                                                        $topoutfit3s = $my_outfit[2]['entities'];
                                                        foreach($topoutfit3s as $topoutfit3): 
                                                    ?>
                                                        <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $topoutfit3['Image'][0]['name']; ?>" alt="" />
                                                <div class="outfit-products-details"><?php echo $topoutfit3['Entity']['name']; ?>  $<?php echo $topoutfit3['Entity']['price']; ?></div></li>
                                                    <?php endforeach; ?>
                                                            
                                                        </ul>
                                                    </div>
                                                </div>
                                               <?php else: ?>
                                                <div class="eleven columns container">
                                                <h2>Please Select An outfit For Third Ordering.</h2>
                                                </div>

                                                <?php endif; ?>
                                            </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="twelve columns left bottom-section">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
        </div>
        
    </div>
</div>

