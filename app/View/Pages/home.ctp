<script type="text/javascript">
    $(document).ready(function(){
        $('.product_placeholder ul li a').hover(function(){
            $('.hover_part').hide();
            $('.hover_part',this).show();
        });
    });
    $(document).ready(function(){
        $('.slick-slide h3 a').hover(function(){
            $('.hover_part').hide();
            $('.hover_part',this).show();
        });
    });   


$('.nav_wrapper a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
    var target = $(this.hash);
     target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
});

$('.container a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
    var target = $(this.hash);
     target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
         //console.log(target.offset().top());
      if (target.length) {                         
        $('html,body').animate({
          scrollTop: target.offset().top - 105
        }, 1000);
        return false;
      }
    }
});




</script>
    <!-- Wrapper -->
    <div class="container">
        <!-- banner -->
        <section id="banner_wrapper">
            <section class="slider">
                <div class="flexslider">
                    <ul class="slides">
                        <li>
                            <img src="<?php echo HTTP_ROOT ?>img/home/slide1.jpg" alt="SHOP NOW WITH YOUR PERSONAL STYLIST" />
                            <span>
                                <div class="heading">SHOP WITH YOUR <br>PERSONAL STYLIST</div>
                                <p>Online & In-Person</p>
                                <a href="Javascript:;">Tell Me More</a>
                                <a href="<?php echo $this->webroot; ?>users/register" class="getStarted">Get Started</a>
                            </span>
                        </li>
                        <li class="slide_second">
                            <img src="<?php echo HTTP_ROOT ?>img/home/slide3.jpg" alt="SHOP NOW WITH YOUR PERSONAL STYLIST" />
                            <span>
                                <div class="heading">blog title</div>
                                <p>This is the content of your post. The more your write <br>more you have to read. <br><br>Read on...</p>
                            </span>
                        </li>
                        <li class="GetSocial">
                            <img src="<?php echo HTTP_ROOT ?>img/home/slide2.jpg" alt="SHOP NOW WITH YOUR PERSONAL STYLIST" />
                            <span>
                                <div class="heading">get social</div>
                                <p>Aenean sollicitudin, lorem quis bibendum auctor...</p>
                                <ul>
                                    <li><a href="#" class="instagram">@savilerowsociety</a></li>
                                    <li><a href="#" class="facebook">SavileRowSociety</a></li>
                                    <li><a href="#" class="twitter">@SRSocietydotcom</a></li>
                                </ul>
                            </span>
                        </li>
                    </ul>
                </div>
            </section>
        </section>
        <!-- /banner -->

        <!-- rightImages -->
        <div class="rightImages">
            <div class="row">
                <ul>
                    <li><a href="#" class="looksByOccasion">looks by occasion</a></li>
                    <li><a href="#" class="shopByItems">shop by items</a></li>
                    <li><a href="#" class="shopMen">shop men’s</a></li>
                </ul>
            </div>
        </div>
        <!-- /rightImages -->
        <div id="two" style="margin-top:0px;"></div>
        <!-- Top Outfits -->
        <section id="top_outfits_wrapper">
            <div class="center_row">
                
                <!-- Section_Main_Heading -->
                <div class="Section_Main_Heading">
                    <h1>Top Looks</h1>
                    <h3>Select outfits styled by our Top Stylists.</h3>
                </div>
                <!-- /Section_Main_Heading -->

                <!-- column -->
            <?php if($topOutfits): ?>
                <?php $outfit_count = 1; foreach ($topOutfits as $outfit) {
                    if($outfit_count >= 4)
                        {break;}
                  ?>
                <div class="column">
                    
                    <!-- heading -->
                    <div class="heading_wrapper">
                        <span><?= $outfit['Outfit']['outfit_name']; ?></span>
                    </div>
                    <!-- /heading -->

                    <!-- product_placeholder -->
                    <div class="product_placeholder">
                        <ul>
                        <?php 
                            $count = 1;
                            if($user) {
                                $path = 'messages/'; 
                            }
                            else {
                                $path = 'guest/';
                            }
                            foreach($outfit['OutfitItem'] as $item) {
                                if(count($item['product']['Image']) && $count++ <= 4){
                        ?>
                            <li><a href="<?php echo $this->webroot;echo $path.'outfitdetails/'.$outfit['Outfit']['id']; ?>"><img src="<?php echo HTTP_ROOT ?>files/products/<?php echo $item['product']['Image'][0]['name']; ?>"/><span class="hover_part">$<?php echo $item['product']['Entity']['price']; ?></span></a></li>
                            <?php }
                            } ?>
                        </ul>
                    </div>
                    <!-- /product_placeholder -->

                    <div class="row">
                        <div class="author_name"> <!-- Styled by <span><?php echo $outfit['Stylist']['first_name'].' '.$outfit['Stylist']['last_name'] ;?></span> --> <a href="#">
                        <?php if(!empty($outfit['Stylist']['profile_photo_url']))  {?>
                            <img src="<?php echo HTTP_ROOT.'files/users/'.$outfit['Stylist']['profile_photo_url'] ?>" alt="" />
                        <?php } else{ ?>
                            <img src="<?php echo HTTP_ROOT.'images/default-user.jpg'; ?>" alt="" />
                        <?php } ?>
                        </a> <div class="designer_name"> By <?= $outfit['Stylist']['first_name'].' '.$outfit['Stylist']['last_name']; ?></div> </div>
                       
                    </div>

                    <!-- <div class="row message_icon_wrapper">
                        <a href="#" class="icon_message"><img src="<?php echo HTTP_ROOT ?>img/home/icon_message.png" alt="message" /></a>
                        <span><?= count($outfit['OutfitComment']); ?></span>
                    </div> -->

                    <div class="row recent_comments_wrapper">
                        <div>
                            <?php $num = 1; 
                            $comment_count = count($outfit['OutfitComment']);
                            foreach($outfit['OutfitComment'] as $outfit_comments) { 
                                if($num >= 3){break;}
                                ?>
                            <div class="section">
                                <span class="name"><?php if($outfit_comments['user_id']){
                                   echo $outfit_comments['User']['full_name'];
                                    } 
                                    else{
                                        echo 'Guest';
                                        } ?></span>
                                <span class="comment"><?= $outfit_comments['comment'] ?></span>
                                <span class="recently_time">2d</span>
                            </div>
                            <?php $num++; } ?>
                        </div>
                            <?php if($comment_count >= 3){?>
                            <div class="view_all_comments">
                                <a href="#">view all comments</a>
                            </div>
                            <?php } ?>
                        
                        <form method="POST" class="comment_form send_comment">
                            <input type = "hidden" name="data[OutfitComment][outfit_id]" value = "<?php echo $outfit['Outfit']['id']; ?>"/>
                            <input type="text" name="data[OutfitComment][comment]" class="comment_box" placeholder = "Write your comment here."/>
                            <button class="submit_comment">Post</button>
                             <?php if($user): ?>
                        <a href="<?php echo $this->webroot; ?>messages/outfitdetails/<?php echo $outfit['Outfit']['id']; ?>" class="btn_shop_this_outfits">Shop This Outfits</a>
                        <?php else: ?>
                        <a href="<?php echo $this->webroot; ?>guest/outfitdetails/<?php echo $outfit['Outfit']['id']; ?>" class="btn_shop_this_outfits">Shop This Outfits</a>
                         <?php endif; ?>    
                        </form>

                    </div>
                </div>
                <?php ++$outfit_count; }
                endif;
                ?>
                <!-- /column -->

               

                <!-- viewAll -->
                <div class="viewAll">
                    <a href="#">
                        See More Outfits
                    </a>
                </div>
                <!-- /viewAll -->
            </div>
        </section>
        <!-- /Top Outfits -->

        <!-- SignUp_Wrapper -->
        <div id="SignUp_Wrapper">
            <div class="center_row">
                <span>Want personalized looks minus the hassle and cost?</span>
                <a href="<?php echo $this->webroot; ?>users/register" class="btn_signUp">Sign Up</a>
            </div>
        </div>
        <!-- /SignUp_Wrapper -->
        <div id="three"></div>
        <!-- featuredStylists-Wrapper -->
        <div class="featuredStylists-Wrapper">
            <div class="center_row">
                <!-- Section_Main_Heading -->
                <div class="Section_Main_Heading">
                    <h1>featured stylists</h1>
                </div>
                <!-- /Section_Main_Heading -->
                <div class="for_mobile_device">
                    <div class="slider multiple-items" style="max-width:765px;">
                    <?php foreach($topStylists as $topstylist): ?>
                        <div>
                            <h3>
                                <a title = "<?php echo $topstylist['User']['first_name'].' '.$topstylist['User']['last_name']; ?>" href="<?php echo $this->webroot; ?>stylists/stylistbiography/<?php echo $topstylist['User']['id']; ?>?refer=<?php echo $topstylist['User']['id']; ?>">
                                
                                <?php if($topstylist['User']['profile_photo_url']): ?>
                                <img src="<?php echo HTTP_ROOT; ?>files/users/<?php echo $topstylist['User']['profile_photo_url']; ?>"  />                      
                                <?php else: ?>
                                <img src="<?php echo HTTP_ROOT; ?>images/default-user.jpg"  />                       
                                <?php endif; ?>
                                <span class="hover_part">
                                    <!-- <a href="#">Get Started</a> -->
                                    With <?php echo $topstylist['User']['first_name'].' '.$topstylist['User']['last_name']; ?>
                                </span>
                                </a>
                            </h3>
                        </div>
                    <?php endforeach; ?>    
                    </div>
                </div>
                <div class="last_slide">
                    <a href="#"><img src="<?php echo HTTP_ROOT ?>img/home/see_all_stylists.jpg" /> <span class="btn_seeAllStylists">See All Stylists</span></a>
                </div>
            </div>
        </div>
        <!-- /featuredStylists-Wrapper -->

        <!-- three_steps_wrapper -->
        <div class="three_steps_wrapper">
            <div class="center_row">
            
                <!-- Section_Main_Heading -->
                <div class="Section_Main_Heading">
                    <h1>how it works to shop with a stylist</h1>
                </div>
                <!-- /Section_Main_Heading -->

                <!-- Steps_Section -->
                <div class="Steps_Section">
                    
                    <!-- column -->
                    <div class="column">
                        <a href="#"><img src="<?php echo HTTP_ROOT ?>img/home/step1.jpg" /></a>
                        <h2>Get Started with your Stylist</h2>
                        <span>&nbsp;</span>
                        <p>Sign Up, fill out your style profile & Connect With Your Stylist.</p>
                    </div>
                    <!-- /column -->

                    <!-- column -->
                    <div class="column">
                        <a href="#"><img src="<?php echo HTTP_ROOT ?>img/home/step2.jpg" /></a>
                        <h2>Get Your Hand Selected Looks</h2>
                        <span>&nbsp;</span>
                        <p>Your stylist handpicks items individualized to your style, taste and needs</p>
                    </div>
                    <!-- /column -->

                    <!-- column -->
                    <div class="column">
                        <a href="#"><img src="<?php echo HTTP_ROOT ?>img/home/step3.jpg" /></a>
                        <h2>Your Looks, to Your Doorstep</h2>
                        <span>&nbsp;</span>
                        <p>Order only the items you want and get them delivered to your doorstep</p>
                    </div>
                    <!-- /column -->

                </div>
                <!-- /Steps_Section -->
            </div>
        </div>
        <!-- /three_steps_wrapper -->
        <div id="four"></div>
        <!-- blog_wrapper -->
        <div class="blog_wrapper">
            <div class="center_row">
                <!-- Section_Main_Heading -->
                <div class="Section_Main_Heading">
                    <h1>the <span>blog</span></h1>
                </div>
                <!-- /Section_Main_Heading -->

                <!-- row -->
                <div class="row">
                <?php foreach($posts as $post) {?>
                    <div class="column">
                        <a href="<?= $post['Blog']['link'] ?>">
                            <img src="<?php echo HTTP_ROOT.'files/blog/'.$post['Blog']['image']; ?>" alt="" />
                        </a>
                        <span><?php echo String::truncate($post['Blog']['title'],35,array('ellipsis' => '  ...  ','exact' => false  ));?></span>
                    </div>
                <?php } ?>
                </div>
                <!-- /row -->
            </div>
        </div>
        <!-- /blog_wrapper -->


    </div>
    <!-- /Wrapper -->

    <script>
    /*-----Outfit comment submit start-------*/
    
    $('.comment_form').submit(function(e){
        e.preventDefault();
    });
    $('.submit_comment').click(function(e){
        //e.preventDefault();
        var cmnt = $(this).prev('.comment_box').val().trim();
        var data = $(this).parent('form').serialize();
        if(cmnt){
            $.ajax({
                url : '/comments/add_comment',
                type: 'POST',
                data : data,
                success: function(res){
                    if(res=='success'){

                    }
                }
            });
            $(this).prev('.comment_box').val('');
        }
    });
    /*-----Outfit comment submit end-------*/


</script>
