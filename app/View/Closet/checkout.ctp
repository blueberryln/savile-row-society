<?php
$script = '
    var country = "' . $this->request->data['billing']['billcountry'] . '";
    $("#billCountry").val(country);
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    function goToByScroll(id){
      // Remove "link" from the ID
        id = id.replace("link", "");
          // Scroll
        $("html,body").animate({
            scrollTop: $("#"+id).offset().top},
            300);
    }
    
    $(".copy-billing-info").on("change", function(e){
        if($(this).is(":checked")){
            $("#shipFirstName").val($("#billFirstName").val());
            $("#shipLastName").val($("#billLastName").val()); 
            $("#shipCompany").val($("#billCompany").val()); 
            $("#shipCity").val($("#billCity").val()); 
            $("#shipAddress").val($("#billAddress").val());   
            $("#shipState").val($("#billState").val()); 
            $("#shipCountry").val($("#billCountry").val());     
            $("#shipZip").val($("#billZip").val());   
        }
        else{
            $(".shipping-data").find("input[type=text], select").val("");
        }
    });
    
    $("#confirm-payment").on("click", function(e){
        e.preventDefault();
        var isError = false;
        $this = $(this);
        //Validate all required fields for empty values
        $(":input[required=\"\"], :input[required]").each(function(){
            if($(this).val() == ""){
                $(this).addClass("input-error");
                isError = true;
            }
            else if($(this).hasClass("input-error")){
                $(this).removeClass("input-error");
            }
        });

        //Validate card number to be of 13 or more digits
        if($("#billCardNumber").val().length < 13){
            $("#billCardNumber").addClass("input-error");
            isError = true;
        }
        
        //Validate card cvv/cvv2 to be of 3 or 4 digits
        if($("#billCardCode").val().length < 3 || $("#billCardCode").val().length > 4){
            $("#billCardCode").addClass("input-error");
            isError = true;
        }
        
        /*var d = new Date();
        var curMonth = d.getMonth();
        var curYear = d.getFullYear();
        curMonth = curMonth +1;
        
        //Validate card expiry date
        if($("#billingExpYear").val() == curYear && $("#billingExpMonth").val() < curMonth){
            $("#billingExpMonth").addClass("input-error");
            isError = true;    
        }
        
        //Scroll to section where there is error.
        if(!isError){
            $this.closest("form").submit();   
        }
        else{
            var cardErrorElement = $("#card-data").find(".input-error");
            if(cardErrorElement.length){
                cardErrorElement.first().focus();
                goToByScroll("card-data");
                return false;
            }

            var billingErrorElement = $("#billing-data").find(".input-error");
            if(billingErrorElement.length){
                billingErrorElement.first().focus();
                goToByScroll("billing-data");
                return false;
            }

            var shippingErrorElement = $("#shipping-data").find(".input-error");
            if(shippingErrorElement.length){
                shippingErrorElement.first().focus();
                goToByScroll("shipping-data");
                return false;
            }
        }*/
        
        $.ajax({
            url: "' . Router::url('/', true) . 'closet/validatecard",
            type: "POST",
            data: {
                cardNumber: $("#billCardNumber").val(),
                cardCode: $("#billCardCode").val(),    
            },
            success: function(data){
                var ret = $.parseJSON(data);
                if(ret["status"] == "error"){
                    if(ret["errors"]["cardnumber"]){
                        $("#billCardNumber").addClass("input-error");
                        isError = true;        
                    }
                    if(ret["errors"]["cardcode"]){
                        $("#billCardCode").addClass("input-error");
                        isError = true;        
                    }
                }
                var d = new Date();
                var curMonth = d.getMonth();
                var curYear = d.getFullYear();
                curMonth = curMonth +1;
                
                //Validate card expiry date
                if($("#billingExpYear").val() == curYear && $("#billingExpMonth").val() < curMonth){
                    $("#billingExpMonth").addClass("input-error");
                    isError = true;    
                }
                
                //Scroll to section where there is error.
                if(!isError){
                    $this.closest("form").submit();   
                }
                else{
                    var cardErrorElement = $("#card-data").find(".input-error");
                    if(cardErrorElement.length){
                        cardErrorElement.first().focus();
                        goToByScroll("card-data");
                        return false;
                    }
        
                    var billingErrorElement = $("#billing-data").find(".input-error");
                    if(billingErrorElement.length){
                        billingErrorElement.first().focus();
                        goToByScroll("billing-data");
                        return false;
                    }
        
                    var shippingErrorElement = $("#shipping-data").find(".input-error");
                    if(shippingErrorElement.length){
                        shippingErrorElement.first().focus();
                        goToByScroll("shipping-data");
                        return false;
                    }
                }
                
            }
        });
    });
    
    //Action event on click on the remove promo code link
    $(".remove-pc").on("click", function(e){
        e.preventDefault();
        
        $("#promocode").val("");
        $(this).fadeOut();    
        $("#promocode").removeAttr("readonly");              
        $(".cart-discount").text("$0.00");  
        var total = $("#checkout-initial-price").val();
        total = parseFloat(total).toFixed(2);
        $(".cart-total").text("$" + total);
        $("#checkout-total-price").val(total); 
    });
    
    $("#apply-promo").on("click", function(e){
        e.preventDefault();  
        var promoCode = $("#promocode").val(); 
        var is_editable = true;
        if($("#promocode").attr("readonly") == "readonly"){
            is_editable = false;   
        }
        
        if(promoCode != "" && is_editable){
            $.ajax({
                url: "' . Router::url('/', true) . 'closet/validate_promo_code/" + promoCode,
                type: "POST",
                data: {},
                success: function(data){
                    var ret = $.parseJSON(data);
                    if(ret["status"] == "ok"){
                        if(ret["percent"]){
                            var discount = parseFloat(ret["amount"]).toFixed(2);
                            var total = $("#checkout-initial-price").val();
                            
                            discount = Math.floor(discount * total / 100);
                            
                            total = parseFloat(total-discount).toFixed(2);
                            $(".cart-discount").text("$" + discount);     
                            $(".cart-total").text("$" + total);  
                            $("#checkout-total-price").val(total);
                        }
                        else{
                            var discount = parseFloat(ret["amount"]).toFixed(2);
                            var total = $("#checkout-initial-price").val();
                            total = parseFloat(total-discount).toFixed(2);
                            $(".cart-discount").text("$" + discount);     
                            $(".cart-total").text("$" + total);  
                            $("#checkout-total-price").val(total);
                        }
                        
                        $("#promocode").attr({"readonly":"readonly"});     
                        var notificationDetails = new Array();
                        notificationDetails["msg"] = "Promo Code has been applied successfully.";
                        showNotification(notificationDetails, true); 
                        $(".remove-pc").fadeIn().removeClass("hide");
                    }
                    else if(ret["status"] == "error"){ 
                        $(".cart-discount").text("$0.00");  
                        var total = $("#checkout-initial-price").val();
                        total = parseFloat(total).toFixed(2);
                        $(".cart-total").text("$" + total);
                        $("#checkout-total-price").val(total);
                        
                        if(ret["info"] == "login"){
                            location = "' . $this->webroot . '";
                        }
                        else if(ret["info"] == "used"){
                            var notificationDetails = new Array();
                            notificationDetails["msg"] = "You have already used this promo code.";
                            showNotification(notificationDetails, true);
                        }
                        else if(ret["info"] == "invalid"){
                            var notificationDetails = new Array();
                            notificationDetails["msg"] = "Sorry! Invalid Promo Code.";
                            showNotification(notificationDetails, true);
                        }
                        else if(ret["info"] == "null"){
                            var notificationDetails = new Array();
                            notificationDetails["msg"] = "Sorry! Invalid Promo Code.";
                            showNotification(notificationDetails, true);
                        }
                        $("#promocode").val(""); 
                    }
                }
            });
        }
    });
';
$this->Html->scriptBlock($script, array('safe' => true, 'inline' => false));
$this->Html->meta('description', 'First mover', array('inline' => false));
?>
<div class="container content inner payment">	
    
    <?php echo $this->Form->create("billing", array('url' => Router::url('/', true) . 'payment')); ?>
    <div class="sixteen columns text-center">
        <h1 class="sub">ORDER INFORMATION</h1>
    </div> 
    <div class="fourteen offset-by-one columns my-cart">
        <?php if ($cart_list) : ?>
            <?php
                $total_price = 0.00;
            ?>
            <table class="cart-checkout" cellpadding="0" cellspacing="1">
                <thead>
                    <th></th>
                    <th></th>
                    <th class="text-left" width="457">Products</th>
                    <th width="90px">Quantity</th>
                    <th width="90px">Unit Price</th>
                    <th width="90px" class="text-right">Price</th>
                </thead>
                <tbody>
                    <?php foreach ($cart_list as $item) : ?>
                        <?php
                            $total_price = $total_price + $item['Entity']['price'] * $item['CartItem']['quantity'];
                        ?>
                        <tr>
                            <td class="v-top">
                                <input type="hidden" class="cart-item-id" value="<?php echo $item['CartItem']['id']; ?>"> &nbsp; &nbsp;
                            </td>
                            <?php 
                                if($item['Image']){
                                    $img_src = $this->request->webroot . "files/products/" . $item['Image'][0]['name'];
                                }
                                else{
                                    $img_src = $this->request->webroot . "img/photo_not_available.png";
                                }
                            ?>
                            <td class="product-thumb"><div class="cart-thumbnail"><img src="<?php echo $img_src; ?>" /></div></td>
                            <td class="v-top">
                                <h6><?php echo $item['Entity']['name']; ?></h6>
                                <?php
                                    $description = String::truncate($item['Entity']['description'], 25, array('ellipsis' => '...', 'exact' => true, 'html' => false));
                                ?>
                                <small class="description"><?php echo $description; ?></small>
                                <small class="description">SIZE: <?php echo $item['Size']['name']; ?></small>
                                <?php if($item['Color'] && count($item['Color']) > 0) : ?>
                                    <small class="description">Color:
                                        <?php
                                            for($i = 0; $i < count($item['Color']); $i++){
                                                if((count($item['Color'])-1) == $i){
                                                    echo $item['Color'][$i]['name'];
                                                }
                                                else{
                                                    echo $item['Color'][$i]['name'] . '/ ';
                                                }
                                            }
                                        ?>
                                    </small>
                                <?php endif; ?>
                            </td>
                            <td class="text-center"><?php echo $item['CartItem']['quantity']; ?>
                                <!--<select id="quantity">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>-->
                            
                            </td>
                            <td class="text-center"><?php echo $this->Number->currency($item['Entity']['price']); ?></td>
                            <td class="text-right item-price"><?php echo $this->Number->currency($item['Entity']['price'] * $item['CartItem']['quantity']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="last">
                        <td colspan="3" rowspan="2">
                            <!-- Enable only when total is equal or more than $120 -->
                            <?php if($total_price >= 120) : ?> 
                                <div class="srs-form columns three omega">
                                    <div class="form">
                                       <div class="input text" style="margin-bottom: 0;">
                                            <?php
                                                echo $this->Form->input('promocode', array('div'=> false, 'label'=> false, 'id'=>'promocode', 'style' => 'letter-spacing:1px;', 'autocomplete' => 'off', 'placeholder' => 'Promo Code'));
                                            ?>
                                       </div>
                                       <a href="" class="remove-pc hide">Remove Promo Code</a>                    
                                    </div>
                                </div>
                                <div class="srs-form columns two omega">
                                    <div class="form">
                                        <div class="input text" style="margin-bottom: 0;">
                                            <a href="#" id="apply-promo" class="link-btn black-btn " style="padding: 7px 15px; margin: 0; width: auto; ">Apply</a>
                                        </div>                   
                                    </div>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td colspan="2" class="text-right bold">(-) Discount:</td>
                        <td class="text-right cart-discount"><?php echo $this->Number->currency(0); ?></td>
                    </tr>
                    <tr class="last">
                        <td colspan="2" class="text-right bold">Total Amount:</td>
                        <td class="text-right cart-total"><?php echo $this->Number->currency($total_price); ?></td>
                    </tr>
                </tbody>
            </table>
            <input type="hidden" name="checkout-cart-id" value="<?php echo $cart_id; ?>" />
            <input type="hidden" name="checkout-initial-price" id="checkout-initial-price"  value="<?php echo $total_price; ?>" />
            <input type="hidden" name="checkout-total-price" id="checkout-total-price"  value="<?php echo $total_price; ?>" />
        <?php endif; ?>
        <div class="clear"></div>
    </div>
    

    <div class="sixteen columns text-center">
        <h1 class="sub">PAYMENT INFORMATION</h1>
    </div>    
    
    <div class="fifteen columns offset-by-half">
        <div class="profile-tabs text-center">
            <img src="app/webroot/img/credit-card-strip.jpg"/>                   
        </div>
    </div>
    
    <div class="card-expiration" id="card-data">
        <div class="srs-form columns five offset-by-one omega">
            <div class="form">
                   <div class="input text required card-number">
                            <?php
                                echo $this->Form->input('billcardnumber', array('label'=>'Card Number','required'=>'required', 'id'=>'billCardNumber', 'maxlength'=>'16', 'tabindex'=>'1', 'onkeypress' => 'return isNumber(event)', 'style' => 'letter-spacing:1px;', 'autocomplete' => 'off'));
                            ?>
                            <small>*(enter number without spaces or dashes)</small> 
                   </div>                    
            </div>
        </div>
        <div class="srs-form columns two offset-by-half omega">
            <div class="form">
                   <div class="input text required">
                            <?php
                                echo $this->Form->input('billcardcode', array('label'=>'CVV/ CVV2','required'=>'required', 'id'=>'billCardCode', 'maxlength'=>'4', 'tabindex'=>'2', 'autocomplete' => 'off'));
                            ?>
                   </div>                    
            </div>
        </div>
        <div class="srs-form columns three offset-by-half omega">
            <div class="form">
                   <div class="input text required">
                            <label>Expiration Date</label>
                            <?php echo $this->Form->month('exp', array('empty' => 'Month', 'monthNames' => false, 'tabindex'=>'3', 'required')); ?>
                            <small>*(mm)</small>                            
                   </div>                    
            </div>
        </div>
        <div class="srs-form columns three omega">
            <div class="form">
                   <div class="input text required">
                            <label for="ExpirationDate">&nbsp;</label>
                            <?php echo $this->Form->year('exp', date('Y'), date('Y', strtotime('+10 year')), array('orderYear' => 'asc', 'empty' => 'Year', 'tabindex'=>'4', 'required')); ?>
                            <small>*(yyyy)</small>
                   </div>                    
            </div>
        </div>
    </div>
    <div class="fourteen columns divider"></div>

    <div class="sixteen columns text-center">
        <h1 class="sub">BILLING INFORMATION</h1>
    </div> 
            
    <div class="contact-container billing-shipping" id="billing-data">
        <div class="srs-form columns five offset-by-two omega">            
            <div class="form">
                <div class="input text required">
                    <?php
                        echo $this->Form->input('billfirst_name', array('label'=>'First Name','required'=>'required', 'id'=>'billFirstName', 'maxlength'=>'45', 'tabindex'=>'5'));
                    ?>
                </div>

                <div class="input text required">
                    <?php
                        echo $this->Form->input('billcompany', array('label'=>'Company', 'id'=>'billCompany', 'maxlength'=>'45', 'tabindex'=>'7'));
                    ?>
                </div>

                <div class="input text required">
                    <?php
                        echo $this->Form->input('billaddress', array('label'=>'Address','required'=>'required', 'id'=>'billAddress', 'tabindex'=>'9', 'maxlength'=>'255'));
                    ?>
                </div>

                <div class="input text required">
                    <?php
                        echo $this->Form->input('billstate', array('label'=>'State/Province','required'=>'required', 'id'=>'billState', 'tabindex'=>'11', 'maxlength'=>'45'));
                    ?>
                </div>

                <div class="input text required">
                    <?php
                        //echo $this->Form->select('billcountry', $country_list, array('options' => $country_list, 'empty' => 'PLEASE SELECT ONE COUNTRY', 'selected' => true, 'value' => $this->request->data['billing']['billcountry']));
                    ?>
                    <label for="billCountry">Country</label>
                    <select required="required" id="billCountry" tabindex="13" name="data[billing][billcountry]">
                        <option value="">SELECT COUNTRY</option>
                        <option value="USA">USA</option>
                        <option value="CAN">CANADA</option>
                    </select>
                </div>
            </div>
    	</div>
        <div class="srs-form columns five offset-by-two alpha">
            <div class="form form1">   
                 <div class="input text required">
                     <?php
                        echo $this->Form->input('billlast_name', array('label'=>'Last Name','required'=>'required', 'id'=>'billLastName', 'tabindex'=>'6', 'maxlength'=>'45'));
                     ?>
                 </div>

                 <div class="input text required">
                     <?php
                        echo $this->Form->input('billemail', array('label'=>'Email', 'id'=>'billEmail', 'maxlength'=>'255', 'tabindex'=>'8', 'readonly'=>'readonly'));
                     ?>
                 </div>

                 <div class="input text required">
                     <?php
                        echo $this->Form->input('billcity', array('label'=>'City','required'=>'required', 'id'=>'billCity', 'tabindex'=>'10', 'maxlength'=>'45'));
                     ?>
                 </div>

                 <div class="input text required">
                     <?php
                        echo $this->Form->input('billzip', array('label'=>'Zipcode','required'=>'required', 'id'=>'billZip', 'tabindex'=>'12', 'maxlength'=>'16'));
                     ?>
                 </div>

                 <div class="input text required">
                     <?php
                        echo $this->Form->input('billphone', array('label'=>'Phone', 'required' => 'required', 'id'=>'billPhone', 'tabindex'=>'14', 'maxlength'=>'45'));
                     ?>
                 </div>
            </div>  
        </div>
            <div class="clear"></div>   
    </div>
    <div class="fourteen columns divider"></div>
    
    <div class="sixteen columns text-center">
        <h1 class="sub">SHIPPING INFORMATION</h1>
        
        <h6 class="ten columns offset-by-two alpha omega text-left"><?php echo $this->Form->checkbox('copybilling', array('label' => false, 'type' => 'checkbox','tabindex'=>'16', 'class' => 'copy-billing-info', 'style' => 'width: auto;' )); ?> Same as Billing Information</h6>
    </div>
    <div class="clear"></div>
    <div class="contact-container billing-shipping shipping-data" id="shipping-data">
        <div class="srs-form columns five offset-by-two omega">
            <div class="form">
                <div class="input text required">
                    <?php
                    echo $this->Form->input('shipfirst_name', array('label'=>'First Name','required'=>'required', 'id'=>'shipFirstName', 'tabindex'=>'17', 'maxlength'=>'45'));
                    ?>
                </div>

                <div class="input text required">
                    <?php
                    echo $this->Form->input('shipcompany', array('label'=>'Company', 'id'=>'shipCompany', 'tabindex'=>'19', 'maxlength'=>'45'));
                    ?>
                </div>

                <div class="input text required">
                    <?php
                    echo $this->Form->input('shipaddress', array('label'=>'Address','required'=>'required', 'id'=>'shipAddress', 'tabindex'=>'21', 'maxlength'=>'255'));
                    ?>
                </div>

                <div class="input text required">
                    <?php
                    echo $this->Form->input('shipzip', array('label'=>'Zipcode','required'=>'required', 'id'=>'shipZip', 'tabindex'=>'23', 'maxlength'=>'16'));
                    ?>
                </div>
            </div>
    	</div>
        <div class="srs-form columns five offset-by-two alpha">
            <div class="form form1">
                <div class="input text required">
                    <?php
                        echo $this->Form->input('shiplast_name', array('label'=>'Last Name','required'=>'required', 'id'=>'shipLastName', 'tabindex'=>'18', 'maxlength'=>'45'));
                    ?>
                </div>

                <div class="input text required">
                    <?php
                        echo $this->Form->input('shipcity', array('label'=>'City','required'=>'required', 'id'=>'shipCity', 'tabindex'=>'20', 'maxlength'=>'45'));
                    ?>
                </div>

                <div class="input text required">
                    <?php
                        echo $this->Form->input('shipstate', array('label'=>'State/Province','required'=>'required', 'id'=>'shipState', 'tabindex'=>'22', 'maxlength'=>'45'));
                    ?>
                </div>
                     
                <div class="input text required">
                    <label for="billCountry">Country</label>
                    <select required="required" tabindex="24" id="shipCountry" name="data[billing][shipcountry]">
                        <option value="">SELECT COUNTRY</option>
                        <option value="USA">USA</option>
                        <option value="CAN">CANADA</option>
                    </select>
                </div>                              
            </div>  
        </div>
            <div class="clear"></div>
            
        <div class="profile text-center" >
            <a class="link-btn black-btn" id="confirm-payment" tabindex="25" href="">Submit</a>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
    
    
</div>