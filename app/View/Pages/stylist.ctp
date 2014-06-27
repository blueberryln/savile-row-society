<?php
$meta_description = 'As a member, you will be up to date on styles, always look put together, and develop a wardrobe that captures the look you desire.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>
<div class="content-container">
    <div class="container content inner booking">
        <div class="hero">
            <div class="sixteen columns text-center">
                <?php if($has_stylist) : ?>
                    <a class="link-btn black-btn get-style-btn" href="<?php echo $this->webroot; ?>messages">Get Style Suggesstion</a>
                <?php endif; ?>
                <h1>Welcome to Savile Row Society!</h1>
                <h6>
                    We've matched you with Casey, our premier personal stylist. <br/>
                    You can make any request to her or <a href="<?php echo $this->request->webroot; ?>booking">book an appointment</a> with our tailor. <br/>
                    Before we get to know you, check out our highlighted products available in the <a href="<?php echo $this->request->webroot; ?>closet">The Closet</a>.
                </h6>
                <br/><br/>
            </div>
            <h2>SRS Selected Stylist for You</h2>
            <div class="eleven columns blogger-box center-block">
                <div class="three columns sub-blogger ">
                    <img class="ten columns fadein-image" src="<?php echo $this->request->webroot; ?>img/blogger-05.2.jpg" alt="Casey Golden" />
                </div>
                <!-- <div class="ten columns alpha omega team-member text-justiy">        -->
           
                <div class="eight columns sub-blogger" >

                    <div class="name">Casey Golden</div>
                    <div class="title">Stylist</div>
                    <p>Casey's seen more men in their boxers than she should ever admit.  She has been a personal shopper and stylist for nearly a decade. Her specialty is immediately identifying your unique style and creating a lifestyle functional wardrobe around it. Casey accomplishes these tasks in a truly effortless way, leaving you with a style that looks polished, yet natural. In her own words, Casey reassures you that  "You can take all the credit--I was never here."</p>
                    <p>She truly believes that getting dressed in the morning should be easier than brewing a pot of coffee and that NO "style" or "matching" decisions should occur that early in the morning.</p>
                    <div class="long-desc hide">
                        <p>Casey creates an effortless wardrobe based on function, and then finds the best pieces in key elements that will allow you to perfectly coordinate outfits without having to think it-because she already did. Her experience in the best (and some of the worst) closets allows SRS to develop our member's wardrobes at any pace by using her unique lifestyle mapping guide to evolve your style naturally.</p>
                        <p>Casey studied International Business in France at the American University of Paris before coming back to the States to spend two years in apparel design.  After realizing she knew more about sewing than her classmates, she sold her books and began working at Mario's, a luxury specialty store well-known for its menswear collection.</p>
                    
                        <br />
                        <!--<div>
                            <iframe class="max-width-adj" width="460" height="315"  src="//www.youtube.com/embed/VlLYFFr7dU8" frameborder="0" allowfullscreen></iframe>
                            <br /><br />
                        </div>-->
                    </div>
                    <div class="text-center">
                        <a class="show-more-text" href="#" title="Show more">Show more</a>
                    </div>
                </div>
            </div><br>      
        </div>
    </div>
</div>