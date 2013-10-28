<?php
$brands_info = array(
    "bernard" => array("title" => "For The Man Who Values Tradition","desc" => "When MRket asked how he would define Bernard Zins, owner Frank Zins stated, &quot;Bernard Zins is a prestigious pant company from Paris with Family tradition and experiences. We have worked for the most prestigious Maisons de Couture (Herm&egrave;s, Lanvin, Yves Saint-Laurent, Burberry,Yamamoto) and are now presenting exclusively the Bernard Zins line.&quot;", "id" => "6"),
    "7diamonds" => array("title" => "For The Man Who Is Drawn To Details", "desc" => "Since its inception in the spring of 2000, 7 Diamonds has established itself as a lifestyle brand. Associated with the highest standard of quality; our inimitable products are brought to life through our focus on sophisticated designs, intricate detail and comfort. Our orientation towards detail, passion for fine fabrics, and drive to consistently and continually set fashion trends is what has earned 7 Diamonds the reputation it enjoys today.", "id" => "4"),
    "agave" => array("title" => "For The Man With That West Coast Mentality", "desc" => "Designed in Portland and handcrafted in California, Agave remains true to its roots of designing and crafting the best tailored, most beautiful and highest quality denim jeans, authentically sewn and hand-finished exclusively in California. Agave is represented by friends, artisans and passionate people who stand for Courage, Compassion amp; Conservation. Agave is an adventure lifestyle with an ecological point of view combined with luxury and ALWAYS beautiful denim and sumptuous tees.", "id" => "3"),
    "cafebleu" => array("title" => "For The Man Who Appreciates Getting Lost In A New City", "desc" => "Cafebleu takes it cue from the modern influence of Carnaby Street, London in the mid 1960's and early 1970's that was shaped by the music of Motown, jazz, fusion, rhythm and funk.<br><br>
 Cafebleu gives men an impeccably designed quality garment available in an array of colors to express their own style with fabrics that fit their body and lifestyle.
", "id" => "7"),
    "castaway" => array("title" => "For The Man Who Likes To Kick Back And Relax By The Beach", "desc" => "Castaway Nantucket Island is as exceptional as it is classic, as imaginative as it is familiar. We craft traditional coastal clothing that has passed the test of time - embroidered Bermuda shorts, seersucker shirts, corduroy pants, and more - with our love of the sea, sport, friends, and family in mind.", "id" => "8"),
    "edwardamrah" => array("title" => "For The Man Who Loves To Rock A Bowtie", "desc" => "Edward Armah: A Signature Name for High-End Designer Dress Furnishing for Men High-end affordable designer garments allure every man. Our custom bowties are an embodiment of the vividness in our style, class, design and exuberant taste and passion towards offering the finest quality accessories for men. Be it our custom fashion bowties or 4 in 1 bowties, Edward Armah has been instrumental in revolutionizing the way men used to dress formally.", "id" => "20"),
    "mclip" => array("title" => "For The Man Who Is Tired Of His Wallet", "desc" => "The World&apos;s Finest Money Clip&apos; and &apos;Finally, A Money Clip that Works&apos; ... these are the registered trademarks and descriptions that we take very seriously about our product. From superior base metal materials and ultra-high machined tolerances for each component part, to individually hand selected hides and finishes, the M-Clip is constructed and assembled by hand with one goal in mind: to make the absolute best, most functional, highest quality money clip you can buy - anywhere.", "id" => "20"),
    "mooregiles" => array("title" => "For The Man Who Loves The Luxurious", "desc" => "Founded in 1933 in Lynchburg, Va., Moore amp; Giles is dedicated to designing and developing the most innovative and luxurious natural leathers for the high-end hospitality, aviation and residential interior design industries. In January 2007, we introduced a collection of leather bags and accessories as an additional avenue to showcase the inherent beauty and timeless appeal of our natural leathers.", "id" => "14"),
    "paulevans" => array("title" => "For The Man Who Takes Pride In His Shoes", "desc" => "Luxury men's footwear based in New York City.<br><br> 
High quality dress shoes made in Europe using time-honored craftsmanship and the finest materials.<br><br>
Calf leather uppers, matching leather soles, leather lining. Goodyear/blake construction. Smart colors.<br><br>
What do your shoes say about you?  
", "id" => "19"),
    "margopetite" => array("title" => "For The Man Who Lives In Cashmere", "desc" => "From beginnings as an array of menswear swatches on a sewing table in Providence&apos;s historic College Hill, Margo Petitti has stitched squares into patchwork, and has woven her lifelong interest into a fashion force. Forever valuing classic styles, Margo Petitti scarves and pocket squares gather glen plaid, herringbone, houndstooth, and birdseye weaves into one of a kind accessories. A truly American company, Margo Petitti apparel is fashioned in Fall River, Massachusetts from the finest Italian woolens, silks, and cashmere.", "id" => "13"),
    "saxx" => array("title" => "For The Active Man", "desc" => "On a fishing trip in Alaska, our inventor experienced intense chafing that left him wondering why men&apos;s underwear wasn&apos;t designed for how men are actually built. When he returned, he couldn&apos;t shake the notion that a better design was possible. He teamed up with a designer and started brainstorming and working on prototypes. On the fourteenth attempt they combined four key innovations resulting in a new level of comfort and performance.", "id" => "15"),
    "smathers" => array("title" => "For The Man Who Can Be Found At The Derby", "desc" => "In 2004, while roommates at Bowdoin College, we decided to start a company that offered needlepoint belts. We set out to make the belts more available, attractive and affordable. We began testing the market in the spring of 2005, and quickly, the once treasured gift became the epicenter of a thriving business. Smathers amp; Branson defines their mission: &apos;to offer the finest products with customer service to match.&apos;", "id" => "9"),
    "nagrani" => array("title" => "For The Man Who Takes Risks", "desc" => "Great clothing should be made to get better with age and be designed to offer a timeless aesthetic. In addition, it must function to enhance your way of life. It is this philosophy that I bring forth each time I create a new garment. Reserved for men of discerning taste, I continuously work to find ways to make something better. I never set out to be something for everyone; instead, I want to be everything to someone.", "id" => "16"),
    "A&F" => array("title" => "", "desc" => "", "id" => ""),
);

$script = '
var brandsInfo = ' . json_encode($brands_info) . ';
$(document).ready(function(){    
    
    
    
    $("ul#branding-partners li").click(function(){
        var brandImage = $(this).find("img");
        var brandName = brandImage.data("name");
        var brandDesc = brandsInfo[brandName]["desc"];
        var brandTitle = brandsInfo[brandName]["title"];
        var brandID = brandsInfo[brandName]["id"];
        imgSrc = brandImage.attr("src");
        $("div.brand-logo img").attr("src",imgSrc);
        $("p.brand-title").html(brandTitle);
        $("p.brand-desc").html(brandDesc);  
        if(brandID != ""){
            $(".brand-info .link-btn").attr({href:"' .$this->webroot . 'closet/all/" + brandID + "/none/brand"});
            $(".brand-info .link-btn").show();
        }
        else{
            $(".brand-info .link-btn").hide();
        }
        $.blockUI({message: $("#brandinfo-box"),css:{top:"50px"}});
        
    });
});
';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));

$meta_description = 'Savile Row Society partners with brands that have a strong foundation built with passion and have the integrity to produce quality products that our members can feel good about supporting and sporting.';
$this->Html->meta('description', $meta_description, array('inline' => false));
?>

<div class="container content inner">
    <div class="sixteen columns text-center">
        <h1>Branding partners</h1>
    </div>
    
    <div class="fourteen columns alpha omega offset-by-two">
            <ul id="branding-partners">
                <li><img src="<?php echo $this->webroot; ?>img/branding-partners/Bernard_zins.jpg" class="fadein-image" alt="Bernard Zins" data-name="bernard" /></li>
                <li><img src="<?php echo $this->webroot; ?>img/branding-partners/7diamonds.png" class="fadein-image" alt="7 Diamonds" data-name="7diamonds"  /></li>
                <li><img src="<?php echo $this->webroot; ?>img/branding-partners/agave.jpg" class="fadein-image" alt="AGAVE" data-name="agave"  /></li>
                <li><img src="<?php echo $this->webroot; ?>img/branding-partners/CafeBleu.jpg" class="fadein-image" alt="CafeBleu" data-name="cafebleu"  /></li>
                <li><img src="<?php echo $this->webroot; ?>img/branding-partners/castaway.jpg" class="fadein-image" alt="Castaway" data-name="castaway"  /></li>
                <li><img src="<?php echo $this->webroot; ?>img/branding-partners/edward.png" class="fadein-image" alt="Edward Amrah" data-name="edwardamrah"  /></li>
                <li><img src="<?php echo $this->webroot; ?>img/branding-partners/mclip.gif" class="fadein-image" alt="M-Clip" data-name="mclip"  /></li>
                <li><img src="<?php echo $this->webroot; ?>img/branding-partners/MooreandGiles.jpg" class="fadein-image" alt="MooreandGiles" data-name="mooregiles"  /></li>
                <li><img src="<?php echo $this->webroot; ?>img/branding-partners/paulevans.png" class="fadein-image" alt="Paul & Evans" data-name="paulevans"  /></li>
                <li><img src="<?php echo $this->webroot; ?>img/branding-partners/petiti.png" class="fadein-image" alt="Margo Petite" data-name="margopetite"  /></li>
                <li><img src="<?php echo $this->webroot; ?>img/branding-partners/saxx-underwear.png" class="fadein-image" alt="SAXX-Underwear" data-name="saxx"  /></li>
                <li><img src="<?php echo $this->webroot; ?>img/branding-partners/smathersAndBransonLogo.png" class="fadein-image" alt="Smathers And Branson" data-name="smathers"  /></li>
                <li><img src="<?php echo $this->webroot; ?>img/branding-partners/vknagrani.png" class="fadein-image" alt="VK Nagrani" data-name="nagrani"  /></li>
                <li><img src="<?php echo $this->webroot; ?>img/branding-partners/Abercrombie-&-Fitch.jpg" class="fadein-image" alt="Abercrombie-&-Fitch" data-name="A&F"  /></li>
                  
            </ul>
    </div>
</div>
<div id="brandinfo-box" class="box-modal notification-box hide">
    <div class="box-modal-inside">
        <a class="notification-close" href=""></a>
        <div class="brand-info">
            <div class="brand-logo"><img src="" class="fadein-image" alt="Bernard Zins" /></div>  
            <div class="notification-msg">
                <p class="brand-title"></p>
                <p class="brand-desc">
                </p>  
            </div>
            <a href="" class="link-btn black-btn brand-btn">see products</a> 
             
        </div> 
    </div>
</div>
