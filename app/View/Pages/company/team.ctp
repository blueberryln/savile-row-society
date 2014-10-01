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
<div class="content-container">
    <div class="eleven columns container content inner">
        <div class="eight columns text-center page-heading">
            <h1>Meet the crew</h1>
            <em>Savile Row Society consists of a growing team of menswear specialists, lifestyle fashionistas, finance moguls, technology geeks, product junkies, and fitness fanatics to bring men all the goods to work smarter, play harder, and feel better.</em>
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
                        <img src="<?php echo $this->request->webroot; ?>img/Vincent.jpg" data-member-name="Vincent Bourzeix" class="fadein-image" />
                    </div>
                    <div>
                        <div class="name">Vincent Bourzeix</div>
                        <span class="title">Chief Operating Officer</span>
                        <div class="desc">
                            <p>After an experience in Investment banking and in the New York start-up world, Vincent joined SRS in the early days. With family in the Fashion industry and a passion for men's style, he loved the concept and believes in the mission of helping men looking better easier.</p>
                            <p>As COO, Vincent plays a key role in the organization of SRS, overseeing customer acquisition, leading innovation of the web platform and managing the optimization of the company's operations. He also oversees the shoe collection, because he is crazy about shoes.</p>
                            <p>Vincent Holds an MSc in Mobile communication from Télécom ParisTech and an MSc in Management Science &amp; Engineering from Columbia University.</p>
                        </div>
                        <div class="text-center info-btn">
                            <a class="more-info-text" href="#" title="More Info">More Info</a>
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
                        <img src="<?php echo $this->request->webroot; ?>img/Leslie GILBERT.png" data-member-name="Leslie Gilbert-Morales" class="fadein-image" />
                    </div>
                    <div>
                        <div class="name">Leslie Gilbert-Morales </div>
                        <span class="title">Head of Personal Styling</span> 
                        <div class="desc">
                            <p>
                            Leslie began her career over ten years ago as a merchandiser and buyer. Leslie quickly embraced the path she created as a freelance stylist and working with high-profile executive leaders. She is the founder of Enhance Your Style, a full-service image enhancing company.
                            </p>
                            <p>
                            As Head of Personal Styling, Leslie oversees the training and support our team of personal shoppers. She brings her styling expertise and personal shopper experience to help create the best personal shopping platform for stylists and members.  
                            </p>
                            <p>
                            Leslie earned a technical degree in Merchandise Marketing from the Fashion Institute of Design and Merchandising in Los Angeles as well as a B.S. degree in Economics from CUNY. She pursued her styling training Fashion Institute of Technology
                            </p>                 
                        </div>
                        <div class="text-center info-btn">
                            <a class="more-info-text" href="#" title="More Info">More Info</a>
                        </div>
                    </div>
                </div>


                <div class="team-member">
                    <div>
                        <img src="<?php echo $this->request->webroot; ?>img/Jon CLINE.png" data-member-name="Jon Cline" class="fadein-image" width='203' height='230' />
                    </div>
                    <div>
                        <div class="name">Jon Cline </div>
                        <span class="title">Head of Made to Measure</span>
                         
                        <div class="desc">
                            <p>
                                Jon Cline is a familiar name in the men’s fashion industry. Jon, previously a fourth generation owner of the infamous H. Herzfeld on 57th Street, has dedicated his life to dressing the best people, in the best products. His knowledge of menswear is unquestionable, as is his contribution to the men’s fashion industry.
                            </p>
                            <p>

                                As Chief Fashion Officer, Jon provides Savile Row Society with his expertise and experience as a consultant, VIP Stylist, and a practiced tailor for SRS’s private label custom wear collection.His wisdom and experience bring that je ne sais quoi that brings the best out of all the team. 

                            </p>
                                    
                        </div>
                        <div class="text-center info-btn">
                            <a class="more-info-text" href="#" title="More Info">More Info</a>
                        </div>
                    </div>
                </div>





                <div class="team-member">
                    <div>
                        <img src="<?php echo $this->request->webroot; ?>img/blogger-05.1.jpg" data-member-name="Casey Golden" class="fadein-image" />
                    </div>
                    <div>
                        <div class="name">Casey Golden</div>
                        <span class="title">Head of Ready to wear</span>
                        <div class="desc">
                            <p>From West Coast to East Coast, Casey has dressed some of the most amazing people and worked with some of the best personal shopper's in the industry. Since, she has been the catalyst behind the brand creation of both Apparel Manufacturers and Specialty Retailers introducing new creative strategies or building them from the ground up.</p>
                            <p>With Savile Row Society, she applies her extensive knowledge of the industry as our Fashion Director to ensure our members have the best product, the best fit and the best shopping experience with our stylist team.</p>
                            <p>Casey studied international Business in Paris, France at The American University of Paris and came back to the states to spend 2 years in Apparel Design.</p>    
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