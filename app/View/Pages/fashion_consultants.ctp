
<div class="content-container content-container-brands">
    <div class="eleven columns container container-box coming-soon-box">
        <div class="blank-space">&nbsp;</div>
        <div class="coming-soon-text fashion_heading">OUR FASHION CONSULTANTS</div>

	    <ul class="fashion_consultant">
	    <?php foreach($stylists as $stylist) { ?>
		    <li class="column-4">
		    	<div class="consultant-container">
			    	<h3>
			    		<a href="/stylists/stylistbiography/<?php echo $stylist['User']['id']; ?>">
			    			<?php if($stylist['User']['profile_photo_url']){ ?>
	                        <img src="<?php echo HTTP_ROOT; ?>files/users/<?php echo $stylist['User']['profile_photo_url']; ?>"/>                      
	                        <?php } else{ ?>
	                        <img src="<?php echo HTTP_ROOT; ?>images/default-user.jpg"/>         
	                        <?php } ?>
							<span class="hover_part2">
								<span class="get_started" style="">GET STARTED</span>
					 		</span>
					    </a>
					</h3>
				</div>
				<a href="/stylists/stylistbiography/<?php echo $stylist['User']['id']; ?>">
					<span class="consultant-name"><?php echo substr($stylist['User']['full_name'],0,25); ?></span>
				</a>
			</li>
		<?php } ?>
		</ul>

		<div class="loader">
			<a href="javascript:void(0)" class="load_more_btn" onclick="load_more_stylists(<?php echo $limit;?>);"><span class="load_more" style="">LOAD MORE</span></a>
	    </div>
	</div>
</div>
<script>
	var offset = 0;
	function load_more_stylists(limit){
	    offset = offset + limit;
	    var data = {offset:offset,limit:limit};
	    $.ajax({
	    	url : '/Pages/fashion_consultants_pager',
	    	type : 'post',
	    	data : data,
	    	success : function(res){
	    		if(res!=''){
	    			$('ul.fashion_consultant').append(res);
	    		} else{
	    			$('div.loader').remove();
	    		}
	    	}
	    });
	}
</script>