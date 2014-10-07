<?php
$meta_description = "Meet the team at Savile Row Society";
$meta_keywords = "Savile Row Society, management";
$script='
    jQuery(function(){
        jQuery("div.team-member").on("click", function(){
            var memberImage = jQuery(this).find("img").attr("src");
            var memberName  = jQuery(this).find("img").data("member-name");
            var memberEmail = jQuery(this).find("span.tm-email").text();
            var memberTitle = jQuery(this).find("span.title").text();
            var memberDesc = jQuery(this).find("div.desc").html();
            console.log(memberDesc);

            jQuery("div.tm-image img").attr("src", memberImage);
            jQuery("p.tm-name").html(memberName);
            jQuery("span.tm-email-id").html(memberEmail);
            jQuery("p.tm-title").html(memberTitle);
            jQuery("div.tm-pdesc").html(memberDesc);            
            $.blockUI({message: $("#tm-details"),css:{top:"50px"}});
            $(".blockOverlay").click($.unblockUI);
        });
    });
';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->meta('description', $meta_description, array('inline' => false));
$this->Html->meta('keywords', $meta_keywords, array('inline' => false));
?>
<div class="content-container content-container-team">
    <div class="eleven columns container content inner">
        <div class="twelve columns container left message-box">
            <div class="blank-space">&nbsp;</div>
                <div class="eleven columns container">
                    <div class="ten columns text-center page-heading">
                        <h1>Meet the crew</h1>
                        <h3>Savile Row Society consists of a growing team of menswear specialists, lifestyle fashionistas, technology geeks and product junkies to bring men all the goods to work smarter, play harder, and feel better</h3>
                    </div>
                    <div class="twelve columns team text-center">	           
                        <div class="team-member-container"> 
                            <div class="team-member">
                                <div>
                                    <img src="<?php echo $this->request->webroot; ?>img/team-member-01.jpg" data-member-name="Lisa Dolan" class="fadein-image" />
                                </div>
                                <div>
                                    <div class="name">Lisa Dolan</div>
                                    <!-- <span class="tm-email">(lisa@savilerowsociety.com)</span> -->
                                    <span class="title">Chief Executive Officer</span>
                                    <!-- <div class="sub-title">(Formerly worked in corporate finance, MBA at...</div> -->
                                    <div class="desc">     
                                        <p>Prior to founding Savile Row Society, Lisa worked in the financial services industry.  Her previous position was as an associate at a premier investment bank where she covered consumer and retail companies.  Lisa has also worked at two other financial firms in diverse services. In these positions, Lisa observed that many professional men do not have the time, energy, or desire to shop by going store-to-store or to browse thru hundreds of product images online.</p>

                                        <p>Having studied the consumer on-the-job, Lisa recognized the opportunity for customizing a man's image by selecting the correct clothing and accessories using proprietary products as well as the well-known best in class brands. This observation is what gave her the inspiration and drive to found an inventory-less, digital personal shopping platform, named Savile Row Society (SRS).  Through SRS, Lisa hopes to transform men's shopping through a seamless, omni-channel personalized style service. </p>

                                        <p>Lisa holds a BA in International Studies and a minor in both Entrepreneurship &amp; Management and French from Johns Hopkins University;  She is a member of the Columbia Business School Class of 2014 but has taken a leave of absence to pursue SRS full time.</p>
                                    </div>                    
                                    <div class="text-center info-btn">
                                        <a class="more-info-text" href="#" title="Show more">More Info</a>
                                    </div>
                                </div>

                            </div>


                            <div class="team-member">
                                <div>
                                    <img src="<?php echo $this->request->webroot; ?>img/AndreaLuongo.jpg" data-member-name="Andrea Luongo" class="fadein-image" />
                                </div>
                                <div>
                                    <div class="name">Andrea Luongo</div>
                                    <span class="title">Fashion Manager</span>
                                    <div class="desc">
                                        <p>Throughout the last four years, Andrea has gained experience in the retail world, working at the London-based Fashion R Ltd. Showroom, and as a sales associate and personal stylist for the family-owned-and-run designer swimwear and resortwear company, Shirley and Co. It was at Shirley and Co. that Andrea realized her passion for personal shopping and styling.</p>
                                        <p>As Fashion Manager, Andrea is responsible for establishing and sustaining the relationships of Savile Row Society's partnering brands. She also works directly in The Closet, maintaining SRS's curated collection of products.</p>
                                        <p>Andrea graduated from Rollins College in 2013, earning a B.A. in Critical Media and Critical Cultural Studies with a minor in English. She also held leadership positions in her sorority Alpha Omicron Pi, and was initiated into the national honor society Phi Eta Sigma.</p>
                                    </div>
                                    <div class="text-center info-btn">
                                        <a class="more-info-text" href="#" title="More Info">More Info</a>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="team-member-container">    
                            <div class="team-member">
                                <div>
                                    <img src="<?php echo $this->request->webroot; ?>img/team-member-12.jpg" data-member-name="Matt" class="fadein-image" />
                                </div>
                                <div>
                                    <div class="name">Matt “M-P” Markezin-Press</div>
                                    <span class="title">Manager, Operations, Finance &amp; Website </span> 
                                    <div class="desc">
                                        <p>Before joining SRS, Matt, or “M-P” as he is popularly known at SRS, spent four years working as an equity research analyst. He started with a focus on medical devices and diagnostic equipment at Jefferies and eventually moved to cover IT hardware at Barclays. While in the finance world he honed his skills in financial modeling, corporate development and the finer points of Microsoft Excel. Having decided he’d had enough of Barclays in early 2014 and began to educate himself in various forms of coding, design, web development and why everyone wears the same J. Crew button down. </p>
                                        <p>As Manager of Finance, Operations and our Web Platform, M-P is responsible for working with our friends at Mobikasa to keep the website running and making sure our day-to-day operations are on track.</p>
                                        <p>Matt or ‘M-P’, graduated from Northwestern University in 2010, earning a B.A. in Economics. In his spare time he enjoys playing hockey and getting lost in the Wikipedia Universe.</p>                        
                                    </div>
                                    <div class="text-center info-btn">
                                        <a class="more-info-text" href="#" title="More Info">More Info</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="team-member">
                                <div>
                                    <img src="<?php echo $this->request->webroot; ?>img/team-member-10.jpg" data-member-name="Prateek Sachdev" class="fadein-image" />
                                </div>
                                <div>
                                    <div class="name">Prateek Sachdev</div>
                                    <span class="title">Website Manager</span> 
                                    <div class="desc">
                                        <p>Before leading the development of SRS website, Prateek spent 4 years working for Versace USA at different positions on the retail operations department. He then founded Mobikasa, a development company with operations in India and in the US. </p>
                                        <p>As website manager, Prateek is responsible of the ground-braking online personal shopping platform that is Savile Row Society. His expertise on design and technology shaped a website that renew men’s shopping experience.  </p>
                                        <p>Prateek holds a BBA in Design and Management from Parsons School of Design.</p>                        
                                    </div>
                                    <div class="text-center info-btn">
                                        <a class="more-info-text" href="#" title="More Info">More Info</a>
                                    </div>
                                </div>
                            </div>



                        </div>

                    </div>
                    </div>
        </div>
    </div>
    <div id="tm-details" class="box-modal notification-box hide">
        <div class="box-modal-inside">
            <a class="notification-close" href=""></a>
            <div class="tm-info">
                <div class="tm-image"><img src="" class="fadein-image" /></div>
                <div class="tm-msg">
                    <p class="tm-name"></p>
                    <span class="tm-email-id"></span>
                    <p class="tm-title"></p>
                    <div class="tm-pdesc"></p>  
                </div>
            </div> 
        </div>
    </div>
</div>