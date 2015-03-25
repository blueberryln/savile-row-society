<script type="text/javascript">
    $(document).ready(function(){

        $(".left-user-search").on('keyup',function(){
             var usersearch = $("#usersearch").val();
             usersearch = usersearch.toLowerCase();
                
            $("#searchuserlist li .myclient-name").each(function(){
                var stringuser = $(this).text().toLowerCase();
                if(stringuser.indexOf(usersearch) > -1){
                    $(this).closest('li').show();
                }else{
                    $(this).closest('li').hide();
                }
            });
        });

    });
</script>

<div class="myclient-left left">
    <div class="myclient-topsec"> 
        <div class="filter-myclient-area">
            <div class="filter-myclient">
                <span class="downarw"></span>
                <select onchange="location = this.options[this.selectedIndex].value;">
                    <option>Filter Clients</option>
                    <?php  foreach($userlists as $filterclient ): ?>
                    <option value="<?php echo $this->webroot; ?>messages/index/<?php echo $filterclient['User']['id']; ?>"><?php echo ucfirst($filterclient['User']['first_name']) . '&nbsp;' . ucfirst($filterclient['User']['last_name']); ?></option>
                     <?php endforeach; ?>
                    
                </select>
            </div>
        </div>
        <div class="search-myclient-area">
            <div class="search-myclient left-user-search">
                <span class="srch"></span>
                <input type="text" name="myclient-search" id="usersearch" />
            </div>
        </div>
        <div class="myclient-list dsktp_only">
            <div id="scrollbar6">
            <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
                <div class="viewport">
                     <div class="overview">
                        <ul id="searchuserlist">
                        <?php  foreach($userlists as $searchuserclient){?>
                            <li>
                                <a href="<?php echo $this->webroot; ?>messages/index/<?php echo $searchuserclient['User']['id']; ?>" title="">
                                    <div class="myclient-img">
                                        <?php if($searchuserclient['User']['profile_photo_url']): ?>
                                            <img src="<?php echo $this->webroot; ?>files/users/<?php echo $searchuserclient['User']['profile_photo_url']; ?>" alt=""/>
                                        <?php else: ?>
                                            <img src="<?php echo $this->webroot; ?>images/default-user.jpg" alt=""/>    
                                        <?php endif; ?>
                                    </div>
                                    <div class="myclient-dtl">
                                        <span class="myclient-name"><?php echo ucfirst($searchuserclient['User']['first_name']) . '&nbsp;' . ucfirst($searchuserclient['User']['last_name']); ?></span>
                                        <span class="myclient-status">last active at <?php echo date ('d F Y',$searchuserclient['User']['updated']); ?></span>
                                    </div>
                                </a>
                            </li>
                        <?php } ?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="myclient-list tab_n_mob">
           
                        <ul id="searchuserlist">
                        <?php  foreach($userlists as $searchuserclient){?>
                            <li>
                                <a href="<?php echo $this->webroot; ?>messages/index/<?php echo $searchuserclient['User']['id']; ?>" title="">
                                    <div class="myclient-img">
                                        <?php if($searchuserclient['User']['profile_photo_url']): ?>
                                            <img src="<?php echo $this->webroot; ?>files/users/<?php echo $searchuserclient['User']['profile_photo_url']; ?>" alt=""/>
                                        <?php else: ?>
                                            <img src="<?php echo $this->webroot; ?>images/default-user.jpg" alt=""/>    
                                        <?php endif; ?>
                                    </div>
                                    <div class="myclient-dtl">
                                        <span class="myclient-name"><?php echo $searchuserclient['User']['first_name'].'&nbsp;'.$searchuserclient['User']['last_name']; ?></span>
                                        <span class="myclient-status">last active at <?php echo date ('d F Y',$searchuserclient['User']['updated']); ?></span>
                                    </div>
                                </a>
                            </li>
                        <?php } ?>

                        </ul>
                    </div>
    </div>
</div>