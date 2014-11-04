<script type="text/javascript">
    $(document).ready(function(){


    
    $("#createoutfitbitton").on('click',function(){
        var selectvalue = $("#selectfilter option:selected" ).val();
        window.location = selectvalue;
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

    $('.my-outfit-filters a').on('click', function(e){
        e.preventDefault();
        $('.active').removeClass('active');
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
                            imagePath = '';

                        for(j=0; j < outfit['OutfitItem'].length; j++){
                            if(outfit['OutfitItem'][j]['product']['Image'].length){
                                imagePath = outfit['OutfitItem'][j]['product']['Image'][0]['name'];
                            }
                            else{
                                imagePath = 'images/image_not_available.png';
                            }

                            outfitPrice += parseInt(outfit['OutfitItem'][j]['product']['Entity']['price']);

                            itemHtml += '<li><img src="<?php echo $this->webroot; ?>files/products/' + imagePath +'" alt="" /></li>';
                        }   

                        html += '<div class="twelve columns client-outfits left" id="findOutfitId">' + 
                                    '<div class="eleven columns container client-outfits-area pad-none" >' + 
                                        '<h1>' + outfitName + '</h1>' + 
                                        '<input type="hidden" id="outfitidquickview" data-id="' + outfit['Outfit']['id'] + '" value="' + outfit['Outfit']['id'] + '">' + 
                                        '<div class="twelve columns client-outfits-img pad-none">' + 
                                            '<ul>' + 
                                            itemHtml + 
                                            '</ul>' + 
                                            '<input type="hidden" id="totalpriceoutfit" value="' + outfitPrice + '">' + 
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
                                                                <div id="scrollbar7">
                                                        <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
                                                            <div class="viewport">
                                                                 <div class="overview">
                                                            <ul id="searchuserlist">
                                                            <?php 
                                                            //$userlist = $searchforoutfit;
                                                             foreach($userlists as $usersearchforoutfit):?>
                                                                <li>
                                                                    <a href="<?php echo $this->webroot; ?>outfits/create/<?php echo $usersearchforoutfit['User']['id']; ?>" title="">
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
                                        <input type="text" name="" id="searchbyoutfit" placeholder="Search Outfits" />
                                    </div>
                                </div>
                                
                                
                            </div>
                            <div class="right-pannel right">
                                <div class="twelve columns message-area left pad-none" id="listdat">
                                    <div class="eleven columns container pad-none" id="outfitpaging">
                                        <?php foreach ($outfits as  $outfit) : ?>  
                                        
                                            <div class="twelve columns client-outfits left" id="findOutfitId">
                                                <div class="eleven columns container client-outfits-area pad-none" >
                                                    <h1><?php echo ucfirst($outfit['Outfit']['outfit_name']); ?></h1>
                                                    <input type="hidden" id="outfitidquickview" data-id="<?php echo $outfit['Outfit']['id']; ?>" value="<?php echo $outfit['Outfit']['id']; ?>">
                                                    <div class="twelve columns client-outfits-img pad-none">
                                                       
                                                        <ul>

                                                        <?php
                                                        $totalpriceoutfit = 0;
                                                        foreach ($outfit['OutfitItem'] as $value) : ?>
                                                            <?php  $totalpriceoutfit += $value['product']['Entity']['price']; ?>
                                                            <li><img src="<?php echo $this->webroot; ?>files/products/<?php echo $value['product']['Image'][0]['name']; ?>" alt="" /></li>
                                                            
                                                        <?php endforeach; ?>
                                                        <input type="hidden" id="totalpriceoutfit" value="<?php echo $totalpriceoutfit; ?>">
                                                        </ul>

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
                                <p>Outfit Name: <span class="pop-outfit-name">Beach Day</span></p>
                                <p>Total Cost: $<span class="pop-outfit-price">1300.00</span></p>
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
                            <div class="twelve columns left otft-overview-links ">
                                <a class="left" href="" title="" class="pop-outfit-reuse">Resuse Outfit</a>
                                <a class="right" href="" title="" class="pop-outfit-details">See Full Outfit Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

