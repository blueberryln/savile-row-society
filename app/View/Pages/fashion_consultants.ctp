
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
	                        <img src="<?php echo HTTP_ROOT; ?>files/users/<?php echo $stylist['User']['profile_photo_url']; ?>"  />                      
	                        <?php } else{ ?>
	                        <img src="<?php echo HTTP_ROOT; ?>images/default-user.jpg"s/>                       
	                        <?php } ?>
							<span class="hover_part2">
								<span class="get_started" style="">GET STARTED</span>
					 		</span>
					    </a>
					</h3>
				</div>
				<a href="/stylists/stylistbiography/<?php echo $stylist['User']['id']; ?>">
					<span class="consultant-name"><?php echo $stylist['User']['full_name']; ?></span>
				</a>
			</li>
		<?php } ?>
		</ul>

		<div class="loader">
			<a href="#"><span class="load_more" style="">LOAD MORE</span></a>
	    </div>
	</div>
</div>