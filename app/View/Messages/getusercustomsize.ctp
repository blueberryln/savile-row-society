<div class="content-container">
    <div class="container content inner timeline">
    	<!-- <div class="chat-msg-box cur-user-msg">
    	<div class="message-caption"> Notes:</div>
    		<div class="message-body"></div>
    	</div> -->
    <?php echo $this->Form->create('Usersizeinformation');?>
    	<div class="seven columns center-block">
    		<h1 class="text-center">Custom Shirt Measurements</h1>
	    		<div class="five columns pref-time left">
		            <div class="pref-options">
			            Neck :<input type="text" name="data[Usersizeinformation][custom_shirt_measurement][neck]">
			            Chest :<input type="text" name="data[Usersizeinformation][custom_shirt_measurement][chest]">
			            Waist :<input type="text" name="data[Usersizeinformation][custom_shirt_measurement][waist]">
			            Hip :<input type="text" name="data[Usersizeinformation][custom_shirt_measurement][hip]">
			            Over Arm :<input type="text" name="data[Usersizeinformation][custom_shirt_measurement][over_arm]">
			            Tail :<input type="text" name="data[Usersizeinformation][custom_shirt_measurement][tail]">
			            Yoke :<input type="text" name="data[Usersizeinformation][custom_shirt_measurement][yoke]">
		            </div>
	    		</div>

			    <div class="five columns pref-time right">
			        <div class="pref-options">
			            
			            Left Sleeve :<input type="text" name="data[Usersizeinformation][custom_shirt_measurement][left_sleeve]">
			            Right Sleeve :<input type="text" name="data[Usersizeinformation][custom_shirt_measurement][right_sleeve]">
			            Left Cuff :<input type="text" name="data[Usersizeinformation][custom_shirt_measurement][left_cuff]">
			            Right Cuff :<input type="text" name="data[Usersizeinformation][custom_shirt_measurement][right_cuff]">
			            Height/ Weight :<input type="text" name="data[Usersizeinformation][custom_shirt_measurement][height]" style="width:100px;">
						<input type="text" name="data[Usersizeinformation][custom_shirt_measurement][width]"  style="width:100px;">
						Posture :<input type="text" name="data[Usersizeinformation][custom_shirt_measurement][posture]">
						Shoulder Line :<input type="text" name="data[Usersizeinformation][custom_shirt_measurement][shoulder_line]">
			        </div>
			    </div>

			    <h1 class="text-center">Custom Jacket Measurements</h1>
	    		<div class="five columns pref-time left">
		            <div class="pref-options">
			            Chest :<input type="text" name="data[Usersizeinformation][custom_jacket_measurement][chest]">
			            Over Arm Chest :<input type="text" name="data[Usersizeinformation][custom_jacket_measurement][over_arm_chest]">
			            
			            Coat Waist :<input type="text" name="data[Usersizeinformation][custom_jacket_measurement][coat_waist]">
			            Seat :<input type="text" name="data[Usersizeinformation][custom_jacket_measurement][seat]">
			            ½ Girth :<input type="text" name="data[Usersizeinformation][custom_jacket_measurement][half_girth]">
			            Coat Length :<input type="text" name="data[Usersizeinformation][custom_jacket_measurement][coat_length]">
			            Sleeve Inseam R / L :<input type="text" name="data[Usersizeinformation][custom_jacket_measurement][sleeve_inseam_r]" style="width:100px;">
			            <input type="text" name="data[Usersizeinformation][custom_jacket_measurement][sleeve_inseam_l]" style="width:100px;">
		            </div>
	    		</div>

			    <div class="five columns pref-time right">
			        <div class="pref-options">
			            
			            ½ Back :<input type="text" name="data[Usersizeinformation][custom_jacket_measurement][half_back]">
			            Point to Point :<input type="text" name="data[Usersizeinformation][custom_jacket_measurement][point_to_point]">
			            Actual Skin Bicep :<input type="text" name="data[Usersizeinformation][custom_jacket_measurement][actual_skin_bicep]">
			            Chest Fullness :<input type="text" name="data[Usersizeinformation][custom_jacket_measurement][chest_fullness]">
			            Shoulder Measurement R / L :<input type="text" name="data[Usersizeinformation][custom_jacket_measurement][shoulder_measurement_r]" style="width:100px;">
						<input type="text" name="data[Usersizeinformation][custom_jacket_measurement][shoulder_measurement_l]"  style="width:100px;">
						Posture :<input type="text" name="data[custom_jacket_measurement][custom_jacket_measurement][posture]">
						<br>
						<br>
						<br>
						<br>
					</div>
			    </div>
			    
			    <h1 class="text-center">Custom Trouser Measurements</h1>
	    		<div class="five columns pref-time left">
		            <div class="pref-options">
			            Pant Waist :<input type="text" name="data[Usersizeinformation][custom_trouser_measurement][pant_waist]">
			            Abdomen :<input type="text" name="data[Usersizeinformation][custom_trouser_measurement][abdomen]">
			            Outseam :<input type="text" name="data[Usersizeinformation][custom_trouser_measurement][outseam]">
			            Inseam :<input type="text" name="data[Usersizeinformation][custom_trouser_measurement][inseam]">
			            Knee :<input type="text" name="data[Usersizeinformation][custom_trouser_measurement][knee]">
			        </div>
	    		</div>

			    <div class="five columns pref-time right">
			        <div class="pref-options">
			            
			            Actual Skin Thigh :<input type="text" name="data[Usersizeinformation][custom_trouser_measurement][actual_skin_thigh]">
			            Front to Floor :<input type="text" name="data[Usersizeinformation][custom_trouser_measurement][front_to_floor]">
			            Back to Floor :<input type="text" name="data[Usersizeinformation][custom_trouser_measurement][back_to_floor]">
			            Rise :<input type="text" name="data[Usersizeinformation][custom_trouser_measurement][rise]">
			            Bottom :<input type="text" name="data[custom_jacket_measurement][custom_trouser_measurement][bottom]">
					</div>
			    </div>

			    <h1 class="text-center">Custom Vest Measurements</h1>
			    Opening From Center Back :<input type="text" name="data[Usersizeinformation][custom_vest_measurement][opening_from_center_back]">
			    Vest Front Length From Center Back :<input type="text" name="data[Usersizeinformation][custom_vest_measurement][vest_front_length_from_center_back]">
			    Vest Back Length From Center Back :<input type="text" name="data[Usersizeinformation][custom_vest_measurement][vest_back_length_from_center_back]">
    		
    		</div>
    	<div class="text-center about-submit">
            <div class="submit">                            
                        <?php echo $this->Form->end(__('Submit')); ?>
            </div>
        </div>	
		
	</div>
</div>
