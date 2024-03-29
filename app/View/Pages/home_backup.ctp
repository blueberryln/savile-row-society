<script type="text/javascript">
    // $(document).ready(function(){
    //     $('.product_placeholder ul li a').hover(function(){
    //         $('.hover_part').hide();
    //         $('.hover_part',this).show();
    //     });
    // });
    /*$(window).load(function(){
        $('.slick-slide h3 a').hover(function(){
            $('.hover_part').hide();
            $('.hover_part',this).show();
        });
    });*/   

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

$(document).on('click','.view_all_comments',function(){
    var outfit_id = $(this).attr('rel');
    $.ajax({
        url: '/Pages/get_comment/'+outfit_id,
        success: function(response){
            $('.comment_append'+outfit_id).html(response);
        }
    });
    $(this).remove();
});



</script>
   


<?php

if(isset($noindex)){
    echo $this->Html->meta(array('name' => 'robots', 'content' => 'noindex, nofollow'),null,array('inline'=>false));
}

$meta_description = "Savile Row Society is a mens personal shopping platform that connects professional men with personal stylists. Buy Mens designer fashion clothing Online at USA favourite online fashion shopping website - savilerowsociety.com";
$meta_keywords = "Savile Row Society, Personal stylist, personal shopping, Menswear online shopping, Men's fashion clothing Online, Buy Mens Clothing Online, personal online shopping, online fashion website, Online shopping website, online fashion shopping";
$img_src = "//www.savilerowsociety.com/img/SRS_600.png";

$this->Html->meta("keywords", $meta_keywords, array("inline" => false));
$this->Html->meta('description', $meta_description, array('inline' => false));
$this->Html->meta(array('property'=> 'og:title', 'content' => 'Savile Row Society', ),'',array('inline'=>false));
$this->Html->meta(array('property'=> 'og:description', 'content' => $meta_description),'',array('inline'=>false));
$this->Html->meta(array('property'=> 'og:url', 'content' => "//www.savilerowsociety.com/"),'',array('inline'=>false));
$this->Html->meta(array('property'=> 'og:image', 'content' => $img_src),'',array('inline'=>false));
?>

    <!-- Wrapper -->
    <div class="container_wrapper">
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
                                <a href="/#nine9">Tell Me More</a>
                                <a href="<?php echo $this->webroot; ?>users/register" class="getStarted">Get Started</a>
                            </span>
                        </li>
                        <li class="slide_second">
                            <img src="<?php echo HTTP_ROOT ?>img/home/slide3.jpg" alt="SHOP NOW WITH YOUR PERSONAL STYLIST" />
                            <span>
                                <div class="heading"><a target="_blank" style="outline: none;margin: 0;padding: 0;color: #fff;text-decoration: none;text-transform: uppercase;font-size: 31px;line-height: normal;background:none;" href="http://www.savilerowsociety.com/blog/">blog title</a></div>
                                <p>This is the content of your post. The more your write <br>more you have to read. <br><br><a target="_blank" style="outline: none;margin: 0;padding: 0;color: #fff;text-decoration: none;text-transform: uppercase;font-size: 17px;line-height: normal;background:none;"  href = "http://www.savilerowsociety.com/blog/">Read on...</a></p>
                            </span>
                        </li>
                        <li class="GetSocial">
                            <img src="<?php echo HTTP_ROOT ?>img/home/slide2.jpg" alt="SHOP NOW WITH YOUR PERSONAL STYLIST" />
                            <span>
                                <div class="heading">get social</div>
                                <p>For the latest news and access to special offers, follow us on social media.</p>
                                <ul>
                                    <li><a target="_blank" href="https://instagram.com/savilerowsociety" class="instagram">@savilerowsociety</a></li>
                                    <li><a target="_blank" href="https://www.facebook.com/SavileRowSociety" class="facebook">SavileRowSociety</a></li>
                                    <li><a target="_blank" href="https://twitter.com/SRSocietydotcom" class="twitter">@SRSocietydotcom</a></li>
                                </ul>
                            </span>
                        </li>
                        <!-- <li>
                            <img src="<?php echo HTTP_ROOT ?>img/home/slide1.jpg" alt="SHOP NOW WITH YOUR PERSONAL STYLIST" />
                        </li>
                        <li>
                            <img src="<?php echo HTTP_ROOT ?>img/home/slide3.jpg" alt="SHOP NOW WITH YOUR PERSONAL STYLIST" />
                        </li> -->
                    </ul>
                </div>
            </section>
        </section>
        <!-- /banner -->

        <!-- rightImages -->
        <div class="rightImages">
            <!-- <a href="#"><img src="<?php //echo HTTP_ROOT ?>img/home/img1.jpg" alt="looks by occasion" />
                <span class="hover_section"><img src="<?php //echo HTTP_ROOT ?>img/home/img1-hover.jpg" alt="looks by occasion" /></span>
            </a>
            <a href="#"><img src="<?php //echo HTTP_ROOT ?>img/home/img2.jpg" alt="shop by items" />
                <span class="hover_section"><img src="<?php //echo HTTP_ROOT ?>img/home/img2-hover.jpg" alt="shop by items" /></span>
            </a>
            <a href="#"><img src="<?php //echo HTTP_ROOT ?>img/home/img3.jpg" alt="shop men's" />
                <span class="hover_section"><img src="<?php //echo HTTP_ROOT ?>img/home/img3-hover.jpg" alt="shop men's" /></span>
            </a> -->

            <a href="#" class="looksByOccasion"><span><span class="col-text">looks by occasion</span></span></a>
            <a href="#" class="shopByItems"><span><span class="col-text">shop by items</span></span></a>
            <a href="#" class="shopMen"><span><span class="col-text">shop men's</span></span></a>


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
                            <li><a href="<?php echo $this->webroot;echo $path.'outfitdetails/'.$outfit['Outfit']['id']; ?>"><img src="<?php echo HTTP_ROOT ?>files/products/<?php echo $item['product']['Image'][0]['name']; ?>"/><span class="hover_part"><span>$<?php echo $item['product']['Entity']['price']; ?></span></span></a></li>
                            <?php }
                            } ?>
                        </ul>
                    </div>
                    <!-- /product_placeholder -->

                    <div class="row">
                        <div class="author_name"> <!-- Styled by <span><?php echo $outfit['Stylist']['first_name'].' '.$outfit['Stylist']['last_name'] ;?></span> --> <a href="/stylists/stylistbiography/<?= $outfit['Stylist']['id']; ?>">
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
                        <div class="scrollbar9">
                                    <div class="scrollbar" style="display: block;"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
                    <div class="viewport">
                         <div class="overview">
                                <div class = "comment_append<?= $outfit['Outfit']['id']; ?>">
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
                                        <span class="recently_time"><?php
                                            $tm = $outfit_comments['time'];
                                            $rcs = 0;
                                            $cur_tm = time(); 
                                            $dif = $cur_tm-$tm;
                                            $pds = array('s','m','h','d','w','m','y','dec');
                                            $lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);

                                            for($v = sizeof($lngh)-1; (($no = $dif/$lngh[$v])<=1); $v--); if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);
                                                $no = floor($no);
                                                /*if($no <> 1)
                                                    $pds[$v] .='s';*/
                                                $x = sprintf("%d %s ",$no,$pds[$v]);
                                                if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0))
                                                    $x .= time_ago($_tm);
                                                echo $x;
                                        ?></span>
                                    </div>
                                    <?php $num++; } ?>
                                </div>
                                </div>
                                </div>
                            </div>


                            <?php if($comment_count >= 3){?>
                            <div class="view_all_comments" rel="<?= $outfit['Outfit']['id']; ?>">
                                <a href="javascript:void(0)">view all comments</a>
                            </div>
                            <?php } ?>
                        
                        <form method="POST" class="comment_form send_comment">
                            <input type = "hidden" name="data[OutfitComment][outfit_id]" class="outfit_id" value = "<?php echo $outfit['Outfit']['id']; ?>"/>
                            <input type="text" name="data[OutfitComment][comment]" class="comment_box" placeholder = "Write your comment here."/>
                            <button class="submit_comment">Post</button>
                             <?php if($user): ?>
                        <a href="<?php echo $this->webroot; ?>messages/outfitdetails/<?php echo $outfit['Outfit']['id']; ?>" class="btn_shop_this_outfits">Shop This Outfit</a>
                        <?php else: ?>
                        <a href="<?php echo $this->webroot; ?>guest/outfitdetails/<?php echo $outfit['Outfit']['id']; ?>" class="btn_shop_this_outfits">Shop This Outfit</a>
                         <?php endif; ?>    
                        </form>

                    </div>
                </div>
                <?php ++$outfit_count; }
                endif;
                ?>
                <!-- /column -->

               

                <!-- viewAll -->
                <!-- <div class="viewAll">
                    <a href="#">
                        See More Outfits
                    </a>
                </div> -->
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

                <div style="position: relative;">
                    <div class="for_mobile_device">
                        <div class="multiple-items slider after-load">
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
                                        <span>With <?php echo $topstylist['User']['first_name'].' '.$topstylist['User']['last_name']; ?></span>
                                    </span>
                                    </a>
                                </h3>
                            </div>
                        <?php endforeach; ?>    
                        </div>
                    </div>
                    <div class="last_slide">
                        <a href="/stylists/stylistbiography/772?refer=772"><img src="<?php echo HTTP_ROOT ?>img/home/see_all_stylists.jpg" /> <span class="btn_seeAllStylists">See All Stylists</span></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /featuredStylists-Wrapper -->



        <div id = "nine9"></div>
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
                    <a href="<?= $post['Blog']['link'] ?>">    
                        <div class="column">
                            <img src="<?php echo HTTP_ROOT.'files/blog/'.$post['Blog']['image']; ?>" alt="" />
                        <span><?php echo String::truncate($post['Blog']['title'],35,array('ellipsis' => '  ...  ','exact' => false  ));?></span>
                        </div>
                    </a>
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
        var user = '<?php echo $user['User']['full_name']; ?>';
        var outfit_id = $(this).parent().children('.outfit_id').val();
        var pre_mod = '<?= PRE_MOD ?>';
        if(user == ''){
            user = 'Guest';
        }
        var apnd = '<div class="section"><span class="name">'+user+'</span><span class="comment">'+cmnt+'</span><span class="recently_time">now</span></div>';
        if(cmnt){
            $.ajax({
                url : '/comments/add_comment',
                type: 'POST',
                data : data,
                success: function(res){
                    if(res=='success'){
                        if(pre_mod != 1){
                            $('.comment_append'+outfit_id).prepend(apnd);
                        }

                    }
                }
            });
            $(this).prev('.comment_box').val('');
        }
    });
    /*-----Outfit comment submit end-------*/


</script>
