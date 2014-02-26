<?php
$meta_description = 'As finance, technology, and marketing professionals, we know that it’s possible for men to raise their standing—due in part to the way in which they style themselves.';
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
?>
<div class="content-container">
    <div class="eleven columns container content inner">
        <div class="eight columns text-center page-heading">
            <h1>Meet the crew</h1>
            <em>Savile Row Society consists of a growing team of menswear specialists, lifestyle fashionistas, finance moguls, technology geeks, product junkies, and fitness fanatics to bring men all the goods to work smarter, play harder, and feel better.</em>
        </div>
        <div class="twelve columns team text-center">	            
            <div class="team-member">
                <div>
                    <img src="<?php echo $this->request->webroot; ?>img/team-member-01.jpg" data-member-name="Lisa Dolan" class="fadein-image" />
                </div>
                <div>
                    <div class="name">Lisa Dolan</div>
                    <span class="tm-email">(lisa@savilerowsociety.com)</span>
                    <span class="title">Chief Executive Officer</span>
                    <div class="sub-title">(Formerly worked in corporate finance, MBA at...</div>
                    <div class="desc">                        
                        <p>Lisa Dolan was born and raised a New Yorker, coming of age during the Great Recession. She graduated from Johns Hopkins in 2008, gaining a B.A. with a major in International Studies and minors in Entrepreneurship and French.</p><p>Lisa Dolan was born and raised a New Yorker, coming of age during the Great Recession. She graduated from Johns Hopkins in 2008, gaining a B.A. with a major in International Studies and minors in Entrepreneurship and French.</p>
                        <p>During her five-year career in finance, the last 18 months were spent in the investment banking division of a well-known institution, where she toiled on the 43rd floor of a midtown Manhattan office building. It was there that she was exposed to the professional lives of incredibly skilled, hard-working, unassuming investment bankers. Her prior work experiences were with a premier credit card provider with a great membership rewards program, as well as a boutique investment management firm.</p>
                        <p>Having graduated in the midst of a recession, Lisa quickly recognized the importance of personal branding. Men today no longer remain with one company or profession for their entire career, making it much harder to create a brand for themselves. Personal image is more important than ever for career mobility and advancement. </p>
                        <p>In addition to this, Lisa noted that most professional men today simply do not have the time, energy, or desire to go store-to-store to shop in order to enhance their personal image. This observation is what gave her the inspiration and drive to found Savile Row Society, Inc. (SRS).</p>
                        <p>Through SRS, Lisa hopes to enhance the personal branding of professional males and to transform men’s shopping through an incredibly seamless, online, personalized fashion service. Alongside Lisa’s incredibly talented colleagues,  the SRS team plans to provide its members with impeccable service and value for their time, effort, and money.</p>
                        <p>Savile Row Society's focus is to provide perfectly customized outfits for its members, as well as grooming recommendations and style advice from noteworthy men who have made branding a part of their business toolkit. SRS will also have discounts at various restaurants and other businesses for its members. It is an invite-only, exclusive club, with the mission to create new opportunities and possibilities for its members.</p>
                        <p>Today, Lisa likes to work long hours on SRS, trying out the best bars and restaurants New York City has to offer. She also competes athletically, participating in both duathlons (cycling and running) and triathlons (swimming, cycling, and running). She looks forward to seeing you on the starting line as a member of Savile Row Society, Inc.</p>
                    </div>                    
                    <div class="text-center info-btn">
                        <a class="more-info-text" href="#" title="Show more">More Info</a>
                    </div>
                </div>
                
            </div>
            
            <div class="team-member">
                <div>
                    <img src="<?php echo $this->request->webroot; ?>img/VincentBourzeix.jpg" data-member-name="Vincent Bourzeix" class="fadein-image" />
                </div>
                <div>
                    <div class="name">Vincent Bourzeix</div>
                    <span class="tm-email">(vincent@savilerowsociety.com)</span>
                    <span class="title">Business Development</span>
                    <div class="sub-title">(MSc in Management Science and Engineering...</div>
                    <div class="desc">
                        <p>Vincent is responsible for business development at Savile Row Society. He graduated as an Engineer in 2011 in France and is currently pursuing a Master’s degree in Management Science & Engineering at Columbia University.</p>
                        <p>After experiencing the New York start-up environment through projects at Columbia, he decided to join SRS for its revolutionary approach to dealing with male consumers, and its amazing team.</p>
                        <p>His diverse experience in various industries in Paris and in consulting in New York gives him a global outlook that he can apply to explore the strategic opportunities of Savile Row Society.</p>
                    </div>
                    <div class="text-center info-btn">
                        <a class="more-info-text" href="#" title="More Info">More Info</a>
                    </div>
                </div>
            </div>
            
            <div class="team-member">
                <div>
                    <img src="<?php echo $this->request->webroot; ?>img/team-member-11.jpg" data-member-name="Pallavi Singhal" class="fadein-image" />
                </div>
                <div>
                    <div class="name">Pallavi Singhal</div>
                    <span class="tm-email">(pallavi@savilerowsociety.com)</span>
                    <span class="title">Co-Chief Technology Officer</span> 
                    <div class="sub-title">(Founder of Mobikasa, MBA at IE Business School.)</div>
                    <div class="desc"></div>
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
                    <span class="tm-email">(prateek@savilerowsociety.com)</span>
                    <span class="title">Co-Chief Technology Officer</span> 
                    <div class="sub-title">(Managing Director at Mobikasa, BBA at Parsons...</div>
                    <div class="desc">
                        <p>Prateek Sachdev (CTO) heads our development team and India office. He previously worked for various luxury brands in NYC including four years at Versace. Prateek graduated from Parsons School of Design majoring in Design & Management and has in-depth knowledge of various technology platforms including iOS, Android, .net, PHP, Magento, Wordpress, HTML5, and SEO.</p>                        
                    </div>
                    <div class="text-center info-btn">
                        <a class="more-info-text" href="#" title="More Info">More Info</a>
                    </div>
                </div>
            </div>
            
            <div class="team-member">
                <div>
                    <img src="<?php echo $this->request->webroot; ?>img/joye-tm.jpg" data-member-name="Joey Glazer" class="fadein-image" />
                </div>
                <div>
                    <div class="name">Joey Glazer</div>
                    <span class="tm-email">(joey@savilerowsociety.com)</span>
                    <span class="title">President, Custom Clothing</span>
                    <div class="sub-title">(Former Director of Sartorial classifications at...</div>
                    <div class="desc">
                        <p>Since childhood, Joey has been drawn to the intricate designs and details of well-made clothing and the lifestyle behind it. It has never been about selling a garment but building a lifetime relationship with his clients that transcends generations. </p>
                        <p>There is something to be said for family referrals and the sense of tradition that has remained in menswear. He truly enjoys the art behind a creating a well dressed man and fortunate that his point of view has become widely respected and appreciated not only by his clients but by their peers.</p>
                        <p>Signing on to the Savile Row Society team, Joey is excited about a new platform and always feels privileged to continue to style the wardrobes of men who demand perfection.</p>
                        <p><strong>Who's your personal fashion icon? </strong> Elvis Presley</p>
                        <p><strong>Designer/Brand that speaks to you?</strong> Tom Ford</p>
                        <p>Beyond the color and magazine spreads Joey gets to know who you are and assists his clients by separating what you want from what you need. Until you have what you need to get dressed you’ll never really understand what you want. The basics are never the most fun to purchase but until you have a foundation there is no point in buying the novelty pieces. You have to be able to stand up before you can run; a mistake many men make is going from a poor suit to fashion loosing the content and refinement of building a proper wardrobe. It takes time and your first 6 months dressing well will generate a personal style to guide you through the next 6 months of purchases. It is not my taste; it is my ability to develop your taste. </p>
                        <p>Signing on to the Savile Row Society team, Joey is excited about a new platform and always feels privileged to continue to style the wardrobes of men who demand perfection</p>
                        <p><strong>What three items could you not live without? </strong>Brown Suede Ankle boots, Rembrandt Toothpaste and my gym membership. </p>        
                        <div class="fastfacts">
                            <div class="fastfacts caption"><strong>Fast facts</strong></div>
                            <div>RESTAURANT: il Pescatore</div>
                            <div>GADGET: IPAD</div>
                            <div>BOOK: Good to Great</div>
                            <div>CAR: 1980 Mercedes 450 SL</div>
                            <div>ESSENTIAL ITEM: Handmade Navy Blazer</div>
                            <div>GROOMING: Please!</div>
                            <div>JEANS: Levi’s 501 Button fly</div>
                            <div>SHOES: Tod’s</div>
                            <div>FAVORITE CITY: Venice</div>
                        </div>
                        <div>
                            <iframe class="max-width-adj" width="460" height="170" src="//www.youtube.com/embed/ZIeZdN1rYAQ?rel=0" frameborder="0" allowfullscreen></iframe>
                        </div>
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
                    <span class="tm-email">(casey@savilerowsociety.com)</span>
                    <span class="title">Fashion Director</span>
                    <div class="sub-title">(US Specialty store account executive at Ralph...</div> 
                    <div class="desc">
                        <p>Casey studied international Business in Paris, France at The American University of Paris and came back to the states to spend 2 years in Apparel Design. After learning that she would never love sewing, she sold her books and started working at a luxury specialty retailer known for their menswear edit.</p>  
                        <p>From West Coast to East Coast, Casey has dressed some of the most amazing people and worked with some of the best personal shopper’s in the industry. Since, she has been the catalyst behind the brand creation of both Apparel Manufacturers and Specialty Retailers introducing new creative strategies or building them from the ground up. </p>
                        <p>She is excited to apply her extensive knowledge of the industry as our Fashion Director to ensure our SRS members have the best product, the best fit and the best shopping experience with our stylist team.</p>
                        <p>Casey is excited to join the Savile Row Society, an armoire of menswear enthusiasts! </p>
                        <div class="fastfacts">
                            <div class="fastfacts caption"><strong>Fast facts</strong></div>
                            <div>RESTAURANT: Piazza Italia; Portland, OR</div>
                            <div>GADGET: Wireless IPOD Shuffle Headphones</div>                    
                            <div>BOOK: Vanity fair by W.M Thackeray</div>
                            <div>DRINK: Laphroaig Scotch, neat</div>
                            <div>CAR: 1956 Porsche Speedster</div>                    
                            <div>ESSENTIAL ITEM: Right Hand ring by Beverly K</div>
                            <div>DRESS: Lela Rose</div>
                            <div>COSMETIC PRODUCT: Mac</div>
                            <div>WATCH: Hermes double wrap</div>                    
                            <div>JEANS: We are Replay</div>
                            <div>SHOES: Christian Louboutin</div>
                            <div>BAG: Givenchy</div>
                            <div>FAVORITE CITY: Paris</div>
                        </div>
                        <div>
                            <iframe class="max-width-adj" width="460" height="170" src="//www.youtube.com/embed/VlLYFFr7dU8?rel=0" frameborder="0" allowfullscreen></iframe>                            
                        </div>
                    </div>
                    <div class="text-center info-btn">
                        <a class="more-info-text" href="#" title="More Info">More Info</a>
                    </div>
                </div>
            </div>
            
            
            <div class="team-member">
                <div>
                    <img src="<?php echo $this->request->webroot; ?>img/Deborah_Sequeira.jpg" data-member-name="Deborah Sequeira" class="fadein-image" />
                </div>
                <div>
                    <div class="name">Deborah Sequeira</div>
                    <span class="tm-email">(deborah@savilerowsociety.com)</span>
                    <span class="title">Logistics Lead</span>
                    <div class="sub-title">(MSc in Operation Research at Columbia University.)</div>
                    <div class="desc">
                        <p>Deborah serves as Lead of Logistics for Savile Row Society. She graduated as an Industrial Engineer in 2011 and is currently pursuing a Master’s degree in Operations Research at Columbia University.</p>
                        <p>Deborah connected with Lisa, CEO of SRS, at Columbia and after hearing Lisa’s vision for the company, was excited to bring her expertise to the table and help develop SRS’s Logistics and Operations.</p>
                        <p> She has worked in several different types of industries through the past 5 years and her diverse background brings a unique perspective to SRS one that will help it run more efficiently and improve the overall experience of SRS clients. She is eager to apply her skills to the men’s styling industry.
                        In her free time, Deborah enjoys reading a good book, visiting new restaurants and soaking up all New York City has to offer. </p>
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
                    <span class="tm-email">(andrea@savilerowsociety.com)</span>
                    <span class="title">Business Operations</span>
                    <div class="sub-title">(BA in Critical media and Critical Cultural Studies...</div>
                    <div class="desc">
                        <p>Andrea Luongo, born and raised in Philadelphia, knew from an early age that she would one day move to New York City and pursue a career in the fashion industry.  Andrea graduated from Rollins College in 2013, earning a B.A. in Critical Media and Critical Cultural Studies with a minor in English.</p> 
                        <p>Andrea was initiated into the National Honor Society Phi Eta Sigma and served as Panhellenic Delegate for her sorority Alpha Omicron Pi. Throughout the last four years, Andrea has gained experience in the corporate retail world, working as a sales associate in the men’s department of American Eagle Outfitters and as a personal stylist for the family-owned-and-run designer swimwear and resortwear company, Shirley and Co.</p>  
                        <p>It was at Shirley and Co. that Andrea realized her passion for personal shopping and styling.</p>  
                        <p>Andrea’s other fashion experience includes an internship during the spring semester of her junior year at the London showroom Dekeyser Fashion R Ltd, owned and run by fashion legend Robert Dekeyser.</p>
                    </div>
                    <div class="text-center info-btn">
                        <a class="more-info-text" href="#" title="More Info">More Info</a>
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