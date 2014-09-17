<script type="text/javascript">
    $(document).ready(function(){


    $(".search-myclient").on('keydown',function(){
         
         //var r = $('input').focus();
         var usersearch = $("#usersearch").val();
         //alert(usersearch);
          $.ajax({
                type:"POST",
                url:"<?php echo $this->webroot; ?>messages/stylistUserFilterList/<?php echo $clientid; ?>",
                data:{usersearch:usersearch},
                cache: false,
                    success: function(result){
                        data = $.parseJSON(result);

            html = '';
            html = html + '<ul>';
            
            $.each(data,  function (index){
                html = html + '<li>';
                html = html + '<a href="<?php echo $this->webroot; ?>messages/index/'+ this.User.id +'" title="">';
                html = html + '<div class="myclient-img">';
                html = html + '<img src="<?php echo $this->webroot; ?>files/users/'+ this.User.profile_photo_url +'" alt=""/>';
                html = html + '</div>';
                html = html + '<div class="myclient-dtl">';
                html = html + '<span class="myclient-name">'+ this.User.first_name +'&nbsp;'+ this.User.last_name +'</span>';
                html = html + '<span class="myclient-status">last active at '+ this.User.updated +'</span>';
                html = html + '</div>';
                html = html + '</a>';
                html = html + '</li>';      
                
                });
            html = html + '</ul>';
                $("#searchuserlist").html(html);

                }

             }); 


    });
});

</script>
<?php
    $img = "";
        if(isset($client) && $client['User']['profile_photo_url'] && $client['User']['profile_photo_url'] != ""){
            $img = $this->webroot . "files/users/" . $client['User']['profile_photo_url'];
         }else{
            $img = $this->webroot . "img/dummy_image.jpg";    
        }
?>
<div class="content-container">
    <div class="twelve columns black">
        <div class="eleven columns container">
            <div class="twelve columns container left ">
                <div class="ten columns left admin-nav">
                    <ul>
                        <li class="active"><a href="#" title="">My Clients</a></li>
                        <li><a href="#" title="">Dashboard</a></li>
                        <li><a href="#" title="">My outfits</a></li>
                        <li><a href="#" title="">The CLoset</a></li>
                    </ul>
                </div>
                <div class="two columns right admin-top-right">
                    <ul>
                        <li><a href="#" title=""><img class="cart-icons" src="<?php echo $this->webroot; ?>images/cart-icon.png" alt="" />(<span class="no-of-items">0</span>) </a></li>
                        <li>
                            <a href="#" title=""><span class="client-nav-switcher"><img src="<?php echo $this->webroot; ?>images/menu-dropdown-icon.png" alt="" /></span></a>
                            <div class="admin-top-right-dropdown">
                                <ul>
                                    <li><a href="#" title="">view my cart/checkout</a></li>
                                    <li><a href="#" title="">refer a friend</a></li>
                                    <li><a href="#" title="">sign out</a></li>
                                </ul>
                            </div>
                        </li>

                    </ul>    
                </div>
            </div>
        </div>
        
    </div>
    <div class="twelve columns container">
        <div class="eleven columns container message-box-area">
            <div class="twelve columns container left message-box">
                
                
                <div class="myclient-left left">
                    <div class="myclient-topsec"> 
                        <div class="filter-myclient-area">
                            <div class="filter-myclient">
                                <span class="downarw"></span>
                                <select>
                                    <option>Filter Clients</option>
                                    <option>Filter Clients</option>
                                    <option>Filter Clients</option>
                                </select>
                            </div>
                        </div>
                        <div class="search-myclient-area">
                            <div class="search-myclient">
                                <span class="srch"></span>
                                <input type="text" name="myclient-search" id="usersearch" />
                            </div>
                        </div>
                        <div class="myclient-list">
                            <ul id="searchuserlist">
                            <?php  foreach($userlists as $userlist ): ?>
                                <li <?php if($userlist['User']['id']==$clientid){ echo "class='active'"; } ?>>
                                    <a href="<?php echo $this->webroot; ?>messages/index/<?php echo $userlist['User']['id']; ?>" title="">
                                        <div class="myclient-img">
                                            <img src="<?php echo $this->webroot; ?>files/users/<?php echo $userlist['User']['profile_photo_url']; ?>" alt=""/>
                                        </div>
                                        <div class="myclient-dtl">
                                            <span class="myclient-name"><?php echo $userlist['User']['first_name'].'&nbsp;'.$userlist['User']['last_name']; ?></span>
                                            <span class="myclient-status">last active at <?php echo date ('d F Y',$userlist['User']['updated']); ?></span>
                                        </div>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                                
                            </ul>
                        </div>
                    </div>
                </div>
                
                
                <div class="myclient-right right">
                    <div class="twelve columns left inner-content pad-none">
                         <div class="twelve columns myclient-heading pad-none">
                            <h1><?php echo $client['User']['first_name'].'&nbsp;'.$client['User']['last_name']; ?> | <span>NOTES</span></h1>
                            <div class="client-img-small"><img src="<?php echo $this->webroot; ?>files/users/<?php echo $client['User']['profile_photo_url']; ?>" alt="" /></div>
                        </div>
                        <div class="inner-left inner-myclient left">
<!--                            <div class="dashboard-pannel left">&nbsp;</div>-->
                            <div class="left-pannel left">
                                <div class="client-img"><img src="<?php echo $this->webroot; ?>files/users/<?php echo $client['User']['profile_photo_url']; ?>" alt=""/></div>
                                <div class=" twelve columns left left-nav">
                                    <ul>
                                        <li><a href="javascript:;">Activity Feed</a></li>
                                        <li><a href="javascript:;">Messages</a></li>
                                        <li><a href="javascript:;">Outfits</a></li>
                                        <li class="active"><a href="javascript:;">Purchases/Likes</a></li>
                                        <li><a href="javascript:;">Notes &amp; Gallery</a></li>
                                        <li><a href="javascript:;">Measurements</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="right-pannel right note-gal-sec">
                                <div class="twelve columns notes-area left pad-none">
                                    <div class="eleven columns container pad-none">
                                        <div class="twelve columns left note-area-heading">
                                            <div class="notes-heading">
                                                <ul>
                                                    <li>
                                                        <div class="notes-date">Date</div>
                                                        <div class="notes-dtl">Stylist Notes</div>
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="twelve columns notes-txt-area left pad-none">
                                    <div class="eleven columns container pad-none">
                                        <div class="notes-content-area">
                                            <ul>
                                            <?php foreach ($usernotes as $usernote): ?>
                                                <li><div class="notes-date"><?php echo $usernote['Stylistnote']['created'] ?></div>
                                                    <div class="notes-dtl"><?php echo $usernote['Stylistnote']['notes'] ?></div>
                                                    <div class="notes-btns">
                                                        <a href="#" title="">Edit</a>
                                                        <a href="<?php echo $this->webroot; ?>messages/removestylistusernotes/<?php echo $usernote['Stylistnote']['id'] ?>">Delete</a>
                                                    </div>
                                                </li> 
                                             <?php endforeach; ?>  
                                               
                                            </ul>
                                            <?php echo $this->Form->create('Stylistnote'); ?>
                                            <div class="twelve columns type-note left">
                                                <div class="type-note-area">
                                                <?php echo $this->Form->input('Stylistnote.notes',array('type'=>'text','label'=>false,)); ?>
                                                </div>
                                                <div class="note-save">
                                                <input type="submit" name="submit" class="savenotes">
                                                <?php //echo $this->Form->end(__('Submit'),array('class'=>'savenotes')); ?>
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="twelve columns gal-area left pad-none">
                                    <h1>Kyle's Gallery</h1>
                                    <div class="gallery-area">
                                        <div class="eleven columns container pad-none">
                                            <div class="twelve columns myclient-gallery left pad-none">
                                                <ul class="slider3">
                                                    <li><img src="<?php echo $this->webroot; ?>images/how-it-works/fs_img_2.jpg" /></li>
                                                    <li><img src="<?php echo $this->webroot; ?>images/how-it-works/fs_img_2.jpg" /></li>
                                                    <li><img src="<?php echo $this->webroot; ?>images/how-it-works/fs_img_2.jpg" /></li>
                                                </ul>
                                            </div>
                                            <div class="twelve columns left gal-btns"><a class="upload-gal-photos" href="#" title="">Upload Photos</a></div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        
                        </div>
                    </div>
                
                </div>
                
                
                <div class="eleven columns container pad-none">
                    <div class="my-profile-img m-ver">
                        <h2>LISA D.<span>My Stylist</span></h2>
                        <div class="client-img-small right">
                        <a href="javascript:;" title=""><img src="<?php echo $this->webroot; ?>images/my-profile/my-profile-img.jpg" alt="" /></a>
                        </div>
                        <span id="dd-nav-switcher"><img src="<?php echo $this->webroot; ?>images/nav-switcher-icon.png" alt="" /></span>
                    </div>
                    <div class="dd-nav">
                        <ul>
                            <li><a href="javascript:;">Messages</a></li>
                            <li class="active"><a href="javascript:;">Outfits</a></li>
                            <li><a href="javascript:;">Purchases/Likes</a></li>
                            <li><a href="javascript:;">Profile</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>