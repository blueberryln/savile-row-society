    <script type="text/javascript">
    
Array.prototype.unique = function() {
    var unique = [];
    for (var i = 0; i < this.length; i++) {
        if (unique.indexOf(this[i]) == -1) {
            unique.push(this[i]);
        }
    }
    return unique;
};

String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

$(document).ready(function(){
    var $scrollbar  = $('#scrollbar3');
    $scrollbar.tinyscrollbar({ axis: "y"});
    var scrollbarData = $scrollbar.data("plugin_tinyscrollbar");


    $('#crt-new-otft').on('click', function(e){
        e.preventDefault();
        $("#reuse-outfit-id").val('');
        outFit();
        scrollbarData.update();
    });


    $('.message-area').on('click', '.outfit-quick-view', function(e){
        e.preventDefault();
        
        var clientOutfit = $(this).closest('.client-outfits'),
            outfitName = clientOutfit.find('.outfit-name').text(),
            outfitId = clientOutfit.find('.outfit-id').val(),
            outfitPrice = clientOutfit.find('.outfit-price').val(),
            brandList = clientOutfit.find('.outfit-brands').val().split(","),
            userList = clientOutfit.find('.outfit-users').val().split(",");
        
        $('.pop-outfit-name').text(outfitName);
        $('#pop-outfit-id').val(outfitId);
        $('.pop-outfit-price').text(outfitPrice);

        var brandListHtml = $('.otft-overview-box-brnds ul');
        brandListHtml.html('');
        for(var i=0; i<brandList.length; i++){
            brandListHtml.append('<li>' + brandList[i] + '</li>');
        }

        var userListHtml = $('.otft-overview-box-recmnd ul');
        userListHtml.html('');
        for(var i=0; i<userList.length; i++){
            userListHtml.append('<li>' + userList[i] + '</li>');
        }

        var imgListHtml = $('.view-otft-list'),
            curImgPath = '';
        imgListHtml.html('');

        clientOutfit.find('.client-outfits-img li img').each(function(){
            curImgPath = $(this).attr('src');
            imgListHtml.append('<li><img src="' + curImgPath + '"></li>');
        });

        $('.pop-outfit-details').attr('href', '/messages/outfitdetails/' + outfitId);
        


        var blockTop = $(window).height()/2 - $("#view-otft-popup").height()/2 + $(window).scrollTop();
        $.blockUI({message: $('#view-otft-popup'), css: {position: "absolute", top: (blockTop > 0) ? blockTop : "0px"}});
        $('.blockOverlay').click($.unblockUI);
    });


    
    $("#createoutfitbitton").on('click',function(){
        var selectvalue = $("#selectfilter option:selected" ).val();

        var reuseOutfitId = $("#reuse-outfit-id").val(),
            reuseQueryString = "";

        if(reuseOutfitId != ""){
            reuseQueryString = "?reuse=" + reuseOutfitId;
        }
        window.location = selectvalue + reuseQueryString;
    });

    $(".create-outfit-user-row").on('click', function(e){
        e.preventDefault();

        var reuseOutfitId = $("#reuse-outfit-id").val(),
            userOutfitUrl = $(this).attr('href'),
            reuseQueryString = "";

        if(reuseOutfitId != ""){
            reuseQueryString = "?reuse=" + reuseOutfitId;
        }
        window.location = userOutfitUrl + reuseQueryString; 
    });

    // book mark outfit

    $(document).on('click',"#outfitbook", function(){
        
        $this = $(this);
        var productBlock = $this.closest("#findOutfitId");
        var outfitId = productBlock.find("#outfitidquickview").val();
        var stylist_id = '<?php echo $user_id; ?>';
        //alert(outfitId);
        $.ajax({
                url: '<?php echo $this->webroot; ?>api/bookmarkedOutfit',
                cache: false,
                type: 'POST',
                data : {outfitId:outfitId,stylist_id:stylist_id},
                success: function(result){
                }
            });    

    });

    $('#searchbyoutfit').on('input', function(){
        $('.active').removeClass('active');
        $(this).addClass('active');
        var pageAction = "search";

        loadOutfits(pageAction, true);
    });

    $('.my-outfit-filters a').on('click', function(e){
        e.preventDefault();
        $('.active').removeClass('active');
        $('#searchbyoutfit').val('');
        $(this).addClass('active');
        var pageAction = $(this).data('filter');

        loadOutfits(pageAction, true);
    });


    //Load more pagination
    $("#loadMoreProduct a").on('click', function(e){
        e.preventDefault();
        $this = $(this);
        var pageAction = $('.active').data('filter');
    
        loadOutfits(pageAction, false);
        
    });
    
    $(".modal-user-search").on('keyup',function(){
         var usersearch = $("#modalusersearch").val();
         usersearch = usersearch.toLowerCase();
            
        $(".myclient-popup #searchuserlist li .myclient-name").each(function(){
            var stringuser = $(this).text().toLowerCase();
            if(stringuser.indexOf(usersearch) > -1){
                $(this).closest('li').show();
            }else{
                $(this).closest('li').hide();
            }
        });
    });

    $(".pop-outfit-reuse").on('click', function(e){
        e.preventDefault();

        $("#reuse-outfit-id").val($('#pop-outfit-id').val());
        outFit();
    })

    var currentRequest = false;

    function loadOutfits(pageAction, reset){
        if(typeof reset == 'undefined'){
            reset = false;
        }

        var outfitCont = $('#outfitpaging'),
            pageVal = parseInt($('#listPage').val());

        if(reset){
            pageVal = 1;
            $('#listPage').val(2);
        }

        var postData = {
            page: pageVal,
            pageAction: pageAction,
            search_text: $('#searchbyoutfit').val(),
        };

        currentRequest = $.ajax({
            url: '/messages/myoutfits',
            type: 'POST',
            cache: false,
            data: postData,
            success: function(data){
                var ret = $.parseJSON(data);

                if(reset){
                    outfitCont.html('');
                    $('#load-more').show();
                }
                if(ret['status'] == 'ok'){
                    $('#listPage').val(pageVal + 1);
                    var outfits = ret['outfits'];
                    var html = '';
                    for(i=0; i < outfits.length; i++){
                        var outfit = outfits[i],
                            itemHtml = '',
                            outfitPrice = 0,
                            outfitName = outfit['Outfit']['outfit_name'] ? outfit['Outfit']['outfit_name'] : '',
                            imagePath = '',
                            userList = [],
                            brandList = [];

                        for(j=0; j < outfit['OutfitItem'].length; j++){
                            if(outfit['OutfitItem'][j]['product']['Image'].length){
                                imagePath = outfit['OutfitItem'][j]['product']['Image'][0]['name'];
                            }
                            else{
                                imagePath = 'images/image_not_available.png';
                            }
                            brandList.push(outfit['OutfitItem'][j]['product']['Brand']['name']);
                            outfitPrice += parseInt(outfit['OutfitItem'][j]['product']['Entity']['price']);

                            itemHtml += '<li><img src="<?php echo $this->webroot; ?>files/products/' + imagePath +'" alt="" /></li>';
                        }   

                        for(var j = 0; j < outfit['Message'].length; j++){
                            userList.push(outfit['Message'][j]['UserTo']['first_name'].capitalize() + ' ' + outfit['Message'][j]['UserTo']['last_name'].capitalize());
                        }

                        brandList = brandList.unique();
                        userList = userList.unique();
                        brandList = brandList.join(',');
                        userList = userList.join(',');

                        html += '<div class="twelve columns client-outfits left" id="findOutfitId">' + 
                                    '<div class="eleven columns container client-outfits-area pad-none" >' + 
                                        '<h1 class="outfit-name">' + outfitName + '</h1>' + 
                                        '<input type="hidden" id="outfitidquickview" data-id="' + outfit['Outfit']['id'] + '" value="' + outfit['Outfit']['id'] + '">' + 
                                        '<div class="twelve columns client-outfits-img pad-none">' + 
                                            '<ul>' + 
                                            itemHtml + 
                                            '</ul>' + 
                                            '<input type="hidden" id="totalpriceoutfit" value="' + outfitPrice + '">' + 
                                            '<input type="hidden" class="outfit-brands" value="' + brandList + '">' + 
                                            '<input type="hidden" class="outfit-users" value="' + userList + '">' + 
                                            '<div class="outfit-quick-view"><a href="#" id="quickoutfit"><span class="outfit-quick-view-icons"><img src="<?php echo $this->webroot; ?>images/search-icon.png" alt="" /></span>Outfit Quick View</a></div>' + 
                                        '</div>' + 
                                        '<div class="twelve columns left client-outfit-bottom pad-none">' + 
                                            '<div class="client-comments left"><h2>Stylist Comment</h2><div class="client-comments-text left">' + outfit['Message'][0]['Message']['body'] + '</div></div>' + 
                                            '<div class="bkmrk-outfit right" ><a href="#"" id="outfitbook">Bookmark Outfit</a></div>' +
                                        '</div>' + 
                                    '</div>' + 
                                '</div>';
                    }

                    outfitCont.append(html);


                    
                }
                else if(ret['status'] == 'redirect'){
                    location = '/messages/index';
                }
                else{
                    $('#load-more').hide();
                }
            }

        });

    } 


});



</script>

    <div class="twelve columns container">
        <div class="eleven columns container message-box-area">
            <div class="twelve columns container left message-box">
                
                <?php echo $this->element('clientAside/userFilterBar'); ?>
                
                
                <div class="myoutfit-right right">
                    <div class="twelve columns left inner-content my-outfit pad-none">
                        <div class="inner-left inner-myclient left">
<!--                            <div class="dashboard-pannel left">&nbsp;</div>-->
                            <div class="left-pannel left">
                                <a id="crt-new-otft" href="#" class="crt-new-outfit">Create New Outfit</a>
                                <!--popup -->
                                <div id="create-otft-popup" style="display: none">
                                    <div class="box-modal">
                                        <div class="box-modal-inside">
                                            <a href="#" title="" class="otft-close"></a>
                                            <div class="crt-new-otft-content">
                                                <div class="five columns left otft-pop-lft">
                                                    <div class="myclient-popup left">
                                                        <div class="myclient-topsec"> 
                                                            <input type="hidden" id="reuse-outfit-id" value="">
                                                            <div class="filter-myclient-area">
                                                                <div class="filter-myclient" >
                                                                    <span class="downarw"></span>
                                                                    <select id="selectfilter">
                                                                    <option value="">Filter Clients</option>
                                                                    <?php foreach($userlists as $clientout): ?>
                                                                    <option value="<?php echo $this->webroot; ?>outfits/create/<?php echo $clientout['User']['id']; ?>"><?php echo $clientout['User']['first_name'].'&nbsp;'.$clientout['User']['last_name']; ?></option>
                                                                     <?php endforeach; ?>
                                                                    
                                                                </select>
                                                                </div>
                                                            </div>
                                                            <div class="search-myclient-area">
                                                                <div class="search-myclient modal-user-search">
                                                                    <span class="srch"></span>
                                                                    <input type="text" name="myclient-search" id="modalusersearch" />
                                                                </div>
                                                            </div>
                                                            <div class="myclient-list">
                                                                <div id="scrollbar3">
                                                                    <div class="scrollbar">
                                                                        <div class="track">
                                                                            <div class="thumb">
                                                                                <div class="end"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="viewport">
                                                                        <div class="overview">
                                                                            <ul id="searchuserlist">
                                                                            <?php 
                                                                            //$userlist = $searchforoutfit;
                                                                             foreach($userlists as $usersearchforoutfit):?>
                                                                                <li>
                                                                                    <a href="<?php echo $this->webroot; ?>outfits/create/<?php echo $usersearchforoutfit['User']['id']; ?>" title="" class="create-outfit-user-row">
                                                                                        <div class="myclient-img">
                                                                                            <?php if($usersearchforoutfit['User']['profile_photo_url']): ?>
                                                                                                <img src="<?php echo $this->webroot; ?>files/users/<?php echo $usersearchforoutfit['User']['profile_photo_url']; ?>" alt=""/>
                                                                                            <?php else: ?>
                                                                                                <img src="<?php echo $this->webroot; ?>images/default-user.jpg" alt=""/>    
                                                                                            <?php endif; ?>
                                                                                        </div>
                                                                                        <div class="myclient-dtl">
                                                                                            <span class="myclient-name"><?php echo $usersearchforoutfit['User']['first_name'].'&nbsp;'.$usersearchforoutfit['User']['last_name']; ?></span>
                                                                                            <span class="myclient-status">last active at <?php echo date ('d F Y',$usersearchforoutfit['User']['updated']); ?></span>
                                                                                        </div>
                                                                                    </a>
                                                                                </li>
                                                                            <?php endforeach; ?>
                                                                                
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="five columns right otft-pop-rgt">
                                                    <div class="eleven columns container">
                                                        <div class="twelve columns left otft-pop-rgt-area">
                                                            <div class="otft-pop-rgt-top">
                                                                <h1>Create A new Outfit</h1>
                                                                <p>Please select a client from your client list on the left.</p>
                                                                <a class="popup-cont-btn setp-btn" href="#" id="createoutfitbitton" title="">Continue</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--popup-->
                                <div class="my-outfit-filters">
                                    <div class="outfit-fltr">
                                        <p>Outfit Filter</p>
                                        <ul>
                                            <li><a href="" data-filter="all" class="active">All Outfits</a></li>
                                            <li><a href="" data-filter="bookmark">Bookmarked Outfits</a></li>
                                        </ul>
                                    </div>
                                    <div class="outfit-srt">
                                        <p>Sort By</p>
                                        <ul>
                                            <li><a href="" data-filter="atoz">Name A-Z</a></li>
                                            <li><a href="" data-filter="date">Date</a></li>
                                        </ul>
                                    </div>
                                    <div class="myoutfit-srch">
                                        <span></span>
                                        <input type="text" name="" id="searchbyoutfit" placeholder="Search Outfits" data-filter="search" />
                                    </div>
                                </div>
                                
                                
                            </div>
                            <div class="right-pannel right">
                                <div class="twelve columns message-area left pad-none" id="listdat">
                                    <div class="eleven columns container pad-none" id="outfitpaging">
                                        <?php foreach ($outfits as  $outfit) : ?>  
                                        
                                            <div class="twelve columns client-outfits left" id="findOutfitId">
                                                <div class="eleven columns container client-outfits-area pad-none" >
                                                    <h1 class="outfit-name"><?php echo ucfirst($outfit['Outfit']['outfit_name']); ?></h1>
                                                    <input type="hidden" data-id="<?php echo $outfit['Outfit']['id']; ?>" value="<?php echo $outfit['Outfit']['id']; ?>" class="outfit-id">
                                                    <div class="twelve columns client-outfits-img pad-none">
                                                       
                                                        <ul>

                                                        <?php
                                                        $totalpriceoutfit = 0;
                                                        $brand_list = array();
                                                        $user_list = array();
                                                        foreach ($outfit['OutfitItem'] as $value) : ?>
                                                            <?php  
                                                                $totalpriceoutfit += $value['product']['Entity']['price']; 
                                                                $brand_list[] = trim($value['product']['Brand']['name']);
                                                            ?>
                                                            <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $value['product']['Image'][0]['name']; ?>" alt="" /></li>
                                                            
                                                        <?php endforeach;

                                                        foreach($outfit['Message'] as $value){
                                                            $user_list[] = ucwords($value['UserTo']['first_name'] . ' ' . $value['UserTo']['last_name']);
                                                        } 
                                                            $brand_list = array_values(array_unique($brand_list));
                                                            $brand_list = implode(',', $brand_list);
                                                            $user_list = array_values(array_unique($user_list));
                                                            $user_list = implode(',', $user_list);
                                                        ?>
                                                        </ul>
                                                        <input type="hidden" class="outfit-price" value="<?php echo $totalpriceoutfit; ?>">
                                                        <input type="hidden" class="outfit-brands" value="<?php echo $brand_list; ?>">
                                                        <input type="hidden" class="outfit-users" value="<?php echo $user_list; ?>">

                                                        <div class="outfit-quick-view"><a href="#" id="quickoutfit"><span class="outfit-quick-view-icons"><img src="<?php echo $this->webroot; ?>images/search-icon.png" alt="" /></span>Outfit Quick View</a></div>
                                                    </div>
                                                    <div class="twelve columns left client-outfit-bottom pad-none">
                                                        <div class="client-comments left"><h2>Stylist Comment</h2><div class="client-comments-text left"><?php echo $outfit['Message'][0]['Message']['body']; ?></div></div>
                                                        <div class="bkmrk-outfit right" ><a href='#' id="outfitbook">Bookmark Outfit</a></div>
                                                        
                                                    </div>
                                                </div>
                                            </div>   

                                        <?php endforeach; ?> 
                                    
                                    </div>
                                    <p id="loadMoreProduct">
                                        <span class="hide"><img src="<?php echo $this->webroot; ?>img/ajax-loader.gif" width="20" /></span>
                                        <input type="hidden" id="listPage" value="<?php echo $page; ?>">
                                        <a href="#" id="load-more">Load More Products</a>
                                    </p>
                                    
                                </div>
                            </div>
                        
                        </div>
                    </div>
                
                </div>

            </div>
        </div>
    </div>
</div>
        </div>
</div>
</div>
</div>

<div id="view-otft-popup" style="display: none">
    <div class="box-modal">
        <div class="box-modal-inside">
            <a href="#" title="" class="otft-close"></a>
            <input type="hidden" id="pop-outfit-id" value="">
            <div class="view-otft-content">
                <h1>Outfit Quickview</h1>
                <div class="three columns left">
                    <div class="twelve columns left">
                        <div class="view-otft-list">
                            <ul>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="eight columns right">
                    <div class="twelve columns left">
                        <div class="view-otft-dtl">
                            <div class="view-otft-dtl-top">
                                <p>Outfit Name: <span class="pop-outfit-name"></span></p>
                                <p>Total Cost: $<span class="pop-outfit-price"></span></p>
                            </div>
                            <div class="otft-overview-box">
                                <span class="otft-overview-box-head">Overview</span>
                                <div class="otft-overview-box-recmnd">
                                    <p>Recommended To:</p>
                                    <ul>
                                        
                                    </ul>
                                </div>
                                <div class="otft-overview-box-brnds">
                                    <p>Brands:</p>
                                    <ul>
                                       
                                    </ul>
                                </div>
                            </div>
                            <div class="twelve columns left otft-overview-links">
                                <a class="left pop-outfit-reuse" href="" title="">Resuse Outfit</a>
                                <a class="right pop-outfit-details" href="" title="">See Full Outfit Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

