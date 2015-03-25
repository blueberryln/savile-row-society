

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
                                <h2>Blog Title</h2>
                                <p>This is the content of your post. The more your write <br>more you have to read. Read on...</p>
                                <p class="cutOff">(This should be a link to blog post on header, we can still keep the <br>two call for action below)</p>
                                <a href="Javascript:;">Tell Me More</a>
                                <a href="<?php echo $this->webroot; ?>users/register" class="getStarted">Get Started</a>
                            </span>
                        </li>
                        <li>
                            <img src="<?php echo HTTP_ROOT ?>img/home/slide1.jpg" alt="SHOP NOW WITH YOUR PERSONAL STYLIST" />
                            <span>
                                <h2>Blog Title</h2>
                                <p>This is the content of your post. The more your write <br>more you have to read. Read on...</p>
                                <p class="cutOff">(This should be a link to blog post on header, we can still keep the <br>two call for action below)</p>
                                <a href="Javascript:;">Tell Me More</a>
                                <a href="<?php echo $this->webroot; ?>users/register" class="getStarted">Get Started</a>
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
                <a href="#" class="img_hover"><img src="<?php echo HTTP_ROOT ?>img/home/img1.jpg" alt="" /></a>
            </div>
            <div class="row">
                <a href="#" class="img_hover"><img src="<?php echo HTTP_ROOT ?>img/home/img2.jpg" alt="" /></a>
            </div>
            <div class="row">
                <a href="#" class="img_hover"><img src="<?php echo HTTP_ROOT ?>img/home/img3.jpg" alt="" /></a>
            </div>
        </div>
        <!-- /rightImages -->

        <!-- Top Outfits -->
        <section id="top_outfits_wrapper">
            <div class="center_row">
                
                <!-- Section_Main_Heading -->
                <div class="Section_Main_Heading">
                    <h1>Top Outfits</h1>
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
                            <li><a href="<?php echo $this->webroot;echo $path.'outfitdetails/'.$outfit['Outfit']['id']; ?>"><img src="<?php echo HTTP_ROOT ?>files/products/<?php echo $item['product']['Image'][0]['name']; ?>"/></a></li>
                            <?php }
                            } ?>
                        </ul>
                    </div>
                    <!-- /product_placeholder -->

                    <div class="row">
                        <div class="author_name"> Styled by <span><?php echo $outfit['Stylist']['first_name'].' '.$outfit['Stylist']['last_name'] ;?></span> </div>
                        <?php if($user): ?>
                        <a href="<?php echo $this->webroot; ?>messages/outfitdetails/<?php echo $outfit['Outfit']['id']; ?>" class="btn_shop_this_outfits">Shop This Outfits</a>
                        <?php else: ?>
                        <a href="<?php echo $this->webroot; ?>guest/outfitdetails/<?php echo $outfit['Outfit']['id']; ?>" class="btn_shop_this_outfits">Shop This Outfits</a>
                         <?php endif; ?>    
                    </div>

                    <div class="row message_icon_wrapper">
                        <a href="#" class="icon_message"><img src="<?php echo HTTP_ROOT ?>img/home/icon_message.png" alt="message" /></a>
                        <span><?= count($outfit['OutfitComment']); ?></span>
                    </div>

                    <div class="row recent_comments_wrapper">
                        <?php $num = 1; 
                        $comment_count = count($outfit['OutfitComment']);
                        foreach($outfit['OutfitComment'] as $outfit_comments) { 
                            if($num >= 3){break;}
                            ?>
                        <div class="section">
                            <span class="name"><?= $outfit_comments['User']['full_name'] ?></span>
                            <span class="comment"><?= $outfit_comments['comment'] ?></span>
                            <span class="recently_time">2d</span>
                        </div>
                        <?php $num++; } ?>

                        <?php if($comment_count >= 3){?>
                        <div class="view_all_comments">
                            <a href="#">view all comments</a>
                        </div>
                        <?php } ?>
                        
                        <form method="POST" class="comment_form send_comment">
                            <input type = "hidden" name="data[OutfitComment][outfit_id]" value = "<?php echo $outfit['Outfit']['id']; ?>"/>
                            <input type="text" name="data[OutfitComment][comment]" class="comment_box" placeholder = "Write your comment here."/>
                            <button class="submit_comment">Post</button>
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
                        <a href="">
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

</script>