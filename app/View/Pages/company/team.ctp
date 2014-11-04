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
                                    <img src="<?php echo $this->request->webroot; ?>img/team-member-13.jpg" data-member-name="Shawn Koid" class="fadein-image" />
                                </div>
                                <div>
                                    <div class="name">Shawn Koid</div>
                                    <!-- <span class="tm-email">(lisa@savilerowsociety.com)</span> -->
                                    <span class="title">Marketing</span>
                                    <!-- <div class="sub-title">(Formerly worked in corporate finance, MBA at...</div> -->
                                    <div class="desc">     
                                        <p>Shawn has always had an enduring love for the fashion world. While she started by designing and sewing outfits, she explored other areas of the fashion industry through her work experiences as a brand manager at Randa Accessories, and public relations intern at Edelman PR and Fluorescent PR, Ltd. She also participated in the L’Oréal USA Brandstorm Competition 2014.</p>

                                        <p>Through her experiences, Shawn realized that she enjoys combining both her creative passions and her business skills, especially within an industry she holds close to her heart. As a Fashion Marketing and Customer Acquisition Strategist, Shawn is responsible for content creation for SRS’s social media and digital marketing, organizing events, and connecting clients with the SRS platform.</p>

                                        <p>Shawn graduated from Babson College, where she earned a B.A. in Business Management, with a concentration in marketing and communications.</p>
                                    </div>                    
                                    <div class="text-center info-btn">
                                        <a class="more-info-text" href="#" title="Show more">More Info</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="team-member">
                                <div>
                                    <img src="<?php echo $this->request->webroot; ?>img/team-member-14.jpg" data-member-name="Leslie Gilbert-Morales" class="fadein-image" />
                                </div>
                                <div>
                                    <div class="name">Leslie Gilbert-Morales</div>
                                    <span class="title">Head Stylist</span> 
                                    <div class="desc">
                                        <p>Leslie Gilbert-Morales is San Diego-born, New York City image consultant and stylist.  Leslie is the founder of Enhance Your Style, a full-service image enhancing company. She began her career over ten years ago as a merchandiser and buyer then made a move to the creative side. Upon arriving in New York in 2001, Leslie established her network in finance as well as pursuing her styling training at world renowned, Fashion Institute of Technology.  Leslie quickly embraced the path she created as a freelance stylist and working with high-profile executive leaders. Leslie routinely collaborates with corporate clients styling on-air personalities and marketing events.</p>
                                        <p>Recently, Leslie was the Senior Fashion Market Editor for the Westfield Style Magazine.  Her business network spans from brands and designers to public relations firms.  These relationships gain her access to the resources required to merchandise large projects. Leslie’s easygoing attitude and articulate critiques have gained her the trust from her clients to produce her best work: the client’s best image and style. Leslie earned a technical degree in Merchandise Marketing from the Fashion Institute of Design and Merchandising in Los Angeles as well as a B.S. degree in Economics from CUNY.  Leslie currently resides in downtown NYC with her husband Tom.</p>                        
                                    </div>
                                    <div class="text-center info-btn">
                                        <a class="more-info-text" href="#" title="More Info">More Info</a>
                                    </div>
                                </div>
                            </div>


                            <div class="team-member">
                                <div>
                                    <img src="<?php echo $this->request->webroot; ?>img/team-member-15.jpg" data-member-name="Mitch Wertheimer" class="fadein-image" />
                                </div>
                                <div>
                                    <div class="name">Mitch Wertheimer</div>
                                    <span class="title">Business Development</span>
                                    <div class="desc">
                                        <p>Mitch has an extensive background in the political arena, digital marketing, and e-commerce.  Prior to SRS, in early 2011, Mitch joined the team at TendonEase® where his primary focus was Retail and Online Sales, Product Development and Internet/Social Media. Mitch has served on several political campaigns in various capacities with a general focus on fundraising, digital marketing, and social media.  Now Mitch manages SRS's business-to-business and affiliate marketing partnerships.  Mitch completed his undergraduate and graduate training at the University of Florida earning a Bachelor’s Degree in Economics and a Master’s in Business / Entrepreneurship.</p>
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
                                    <img src="<?php echo $this->request->webroot; ?>img/team-member-16.jpg" data-member-name="James Vinson" class="fadein-image" />
                                </div>
                                <div>
                                    <div class="name">James Vinson</div>
                                    <!-- <span class="tm-email">(lisa@savilerowsociety.com)</span> -->
                                    <span class="title">Digital Marketing, Design &amp; Social Media</span>
                                    <!-- <div class="sub-title">(Formerly worked in corporate finance, MBA at...</div> -->
                                    <div class="desc">     
                                        <p>A recent graduate from the University of Connecticut, where he developed his tech skills working with the schools IT and website development. Following school, James secured a position with the advertising agency, CT1 Media. There, he was able to hone his skills in media planning and found that he wanted to pursue a career in digital marketing.</p>

                                        <p>With a love for all things social media, James eagerly joined the SRS Marketing team as an intern. His role emphasizes content creation, communication on social media platforms, assisting to develop the SRS branded marketing strategy, and email marketing management.</p>
                                    </div>                    
                                    <div class="text-center info-btn">
                                        <a class="more-info-text" href="#" title="Show more">More Info</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="team-member">
                                <div>
                                    <img src="<?php echo $this->request->webroot; ?>img/team-member-17.jpg" data-member-name="Conor Murphy" class="fadein-image" />
                                </div>
                                <div>
                                    <div class="name">Conor Murphy</div>
                                    <span class="title">Stylist Apprentice</span> 
                                    <div class="desc">
                                        <p>Conor Murphy is a Stylist Apprentice at Savile Row Society, as well as a weekly content contributor. Conor has been in love with fashion all his life. Born in Newburyport, Massachusetts, Conor attended the University of Massachusetts, Amherst, where he majored in Communication and minored in Mandarin Chinese, after observing the direction the industry was moving in.</p>
                                        <p>At SRS, Conor works with Fashion Manager, Andrea Luongo in sourcing from brands to assisting stylists with measurements and making sure clients needs are fully met. In addition to his work with stylists, Conor works on weekly blog content and consults on social media for the brand.</p>                        
                                    </div>
                                    <div class="text-center info-btn">
                                        <a class="more-info-text" href="#" title="More Info">More Info</a>
                                    </div>
                                </div>
                            </div>


                            <div class="team-member">
                                <div>
                                    <img src="<?php echo $this->request->webroot; ?>img/team-member-18.jpg" data-member-name="Bella Klycheva" class="fadein-image" />
                                </div>
                                <div>
                                    <div class="name">Bella Klycheva</div>
                                    <span class="title">Fashion &amp; Social Media </span>
                                    <div class="desc">
                                        <p>Bella Klycheva is currently studying Advertising and Marketing Communications at FIT. For more than 2 years, Bella has gained experience while working at fashion shows and fashion shoots. Since she started working at Savile Row Society, Bella has discovered a lot about men's fashion. She researches, works with social media, and updates the closet on the website. She loves her work at SRS because she has chance to work with smart and inspiring people.</p>
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
                                    <img src="<?php echo $this->request->webroot; ?>img/team-member-19.jpg" data-member-name="Alex Regensburg" class="fadein-image" />
                                </div>
                                <div>
                                    <div class="name">Alex Regensburg</div>
                                    <!-- <span class="tm-email">(lisa@savilerowsociety.com)</span> -->
                                    <span class="title">Business Development</span>
                                    <!-- <div class="sub-title">(Formerly worked in corporate finance, MBA at...</div> -->
                                    <div class="desc">     
                                        <p>Alex comes from a diverse business background and joins SRS to help with its growth. He has extensive experience consulting with Finance, Tech, and Logistics companies working with executives in each field. His work in Corporate America exuded the importance of a clean, professional appearance. "You can only make one first impression, so every professional needs to capture that moment and build upon it. If you look good, you feel good, you perform well." The mission of helping men achieve this in a seamless, systematic way is what sold Alex. He holds a B.A. from Indiana University.</p>
                                    </div>                    
                                    <div class="text-center info-btn">
                                        <a class="more-info-text" href="#" title="Show more">More Info</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        

                        <div class="team-member-container">    
                            
                            <div class="team-member">
                                <div>
                                    <img src="<?php echo $this->request->webroot; ?>img/team-member-20.jpg" data-member-name="Pallavi Singhal" class="fadein-image" />
                                </div>
                                <div>
                                    <div class="name">Pallavi Singhal</div>
                                    <span class="title">Website Manager</span> 
                                    <div class="desc">
                                        <p>Pallavi is a product development and strategy specialist at Mobikasa with 10+ years of experience in internal strategy to improve a company’s bottom line.  She is experienced in nurturing technology start-ups.  She is deeply passionate about building best in class products, along with her business knowledge she brings in technical knowledge, that enables teams to deliver cutting edge products.</p>                        
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
                            
                            <div class="team-member">
                                <div>
                                    <img src="<?php echo $this->request->webroot; ?>img/team-member-21.jpg" data-member-name="Whitney Baumann" class="fadein-image" />
                                </div>
                                <div>
                                    <div class="name">Whitney Baumann</div>
                                    <span class="title">Mobikasa – Web Design</span> 
                                    <div class="desc">
                                        <p>Whitney is a graphic designer at the Mobikasa New York office. She hails from California, where she graduated from San Diego State University before coming out to New York City to join Shillington's School of Design.</p>
                                        <p>Prior to joining the Mobikasa team, Whitney was a freelance graphic designer and illustrator. Her work with small business and non-profit clients consisted of primarily print design- from brand/identity development to product package design.</p>
                                        <p>Her focus has shifted since she started at Mobikasa. Working with clients like Savile Row Society allowed her to realize the importance, and relevance, of user centered design. To her, design should not just look good- it must be, above all, functional.</p>
                                        <p>Now she spends her days happily designing web/app interfaces, and painting with pixels.</p>
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
                                    <img src="<?php echo $this->request->webroot; ?>img/team-member-21.jpg" data-member-name="Saurabh Sharma" class="fadein-image" />
                                </div>
                                <div>
                                    <div class="name">Saurabh Sharma</div>
                                    <span class="title">Mobikasa – Web Development</span> 
                                    <div class="desc">
                                        <p>&nbsp;</p>                        
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