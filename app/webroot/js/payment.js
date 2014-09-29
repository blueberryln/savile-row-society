function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
function isAlphaNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if((charCode > 47 && charCode < 58) || (charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123)) {
        return true;
    }
    return false;
}
function goToByScroll(id){
  // Remove "link" from the ID
    id = id.replace("link", "");
      // Scroll
    var scrollTopVal = $("#"+id).offset().top - $(".header").height();
    $("html,body").animate({
        scrollTop: scrollTopVal},
        300);
}

$(function(){
	$("#billCountry").val(country);

	/**
	 * Payment Steps
	 */
	$("#continue-1").on('click', function(e){
		e.preventDefault();
		$(".promo-code-cont").hide();
		$(this).closest(".continue-block").slideUp(300, function(){
			$("#step-2").slideDown(500);
		});
	});

	$("#continue-2").on('click', function(e){
		e.preventDefault();
		var loader = $(this).closest(".continue-block").find(".loader"),
        	isError = false,
        	$this = $(this);
		loader.removeClass("hide");
        if($this.hasClass('clicked')){
            return false;
        }
        else{
            $this.addClass('clicked');
        }

        $(".billing-shipping :input[required=\"\"], .billing-shipping :input[required]").each(function(){
            if($(this).val() == ""){
                $(this).addClass("input-error");
                isError = true;
            }
            else if($(this).hasClass("input-error")){
                $(this).removeClass("input-error");
            }
        });

        if(isError){
            var billingErrorElement = $("#billing-data").find(".input-error");
            var shippingErrorElement = $("#shipping-data").find(".input-error");
            if(billingErrorElement.length){
                billingErrorElement.first().focus();
                goToByScroll("billing-data-head");
            }
            else if(shippingErrorElement.length){
                shippingErrorElement.first().focus();
                goToByScroll("shipping-data-head");
            }
            loader.addClass("hide");
            $this.removeClass('clicked');
        }
        else{
        	goToByScroll("step-1");
            var zipcode = $("#shipZip").val();
            var country = $("#shipCountry").val();
            if($(".copy-billing-info").is(":checked")){
                zipcode = $("#billZip").val();
            }

            var total = parseFloat($("#checkout-total-price").val());
            
            $.ajax({
                url: baseUrl + "payments/calculateTaxTotal/" + zipcode,
                type: "POST",
                data: {
                	total: total,
                    country: country,
                },
                success: function(data){
                    var ret = $.parseJSON(data);
                    if(ret["tax"] > 0) {
                        $("#checkout-tax").val(ret["tax"]);
                        $(".cart-tax-percent").text(" " + ret["tax"] + "%");

                        $(".cart-tax").text("$" + ret["tax_amount"]);     
                        $(".cart-total").text("$" + ret["new_total"]);  
                        $("#checkout-total-price").val(ret["new_total"]);
                    }
                    else{
                        $(".cart-tax-percent").text("");
                    }
                    $this.closest(".continue-block").slideUp(300, function(){
                    	$("#step-2").slideUp(500, function(){
                    		$("#step-3").slideDown(500);
                    	});	
                    });  
                    $this.removeClass('clicked');     
                }
            });
        }
	});


	/**
	 * Copy Billing Info
	 */
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

	/**
	 * Promocode logic
	 */
	
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
        var promoCode = $("#promocode").val(),
            is_editable = true;
        if($("#promocode").attr("readonly") == "readonly"){
            is_editable = false;   
        }
        
        if(promoCode != "" && is_editable){
            $.ajax({
                url: baseUrl + "payments/validate_promo_code/" + promoCode,
                type: "POST",
                data: {},
                success: function(data){
                    var ret = $.parseJSON(data);
                    if(ret["status"] == "ok"){
                        var discount = parseFloat(ret["amount"]),
                            total = parseFloat($("#checkout-initial-price").val());

                        if(ret["percent"]){
                            discount = Math.floor(discount * total / 100);
                            discount = discount.toFixed(2);
                            
                            total = parseFloat(total-discount).toFixed(2);
                            $(".cart-discount").text("$" + discount);     
                            $(".cart-total").text("$" + total);  
                            $("#checkout-total-price").val(total);
                        }
                        else{
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


	/**
	 * Make payment
	 */
	$("#confirm-payment").on("click", function(e){
        e.preventDefault();
        var isError = false;
        $this = $(this);

        if($this.hasClass('clicked')){
            return false;
        }
        else{
            $this.addClass('clicked');
        }

        /**
         * Validate billing and shipping data and refresh page if error
         */
        $(".billing-shipping :input[required=\"\"], .billing-shipping :input[required]").each(function(){
            if($(this).val() == ""){
                location = baseUrl + '/checkout';
            }
        });

        /**
         * Validate Card data
         */
        $("#step-3 :input[required=\"\"], #step-3 :input[required]").each(function(){
            if($(this).val() == ""){
                $(this).addClass("input-error");
                isError = true;
            }
            else if($(this).hasClass("input-error")){
                $(this).removeClass("input-error");
            }
        });
        
        
        if(isError){
        	var cardErrorElement = $("#card-data").find(".input-error");
            if(cardErrorElement.length){
                cardErrorElement.first().focus();
                goToByScroll("step-3");
                $this.removeClass('clicked');
                return false;
            }	
            $this.removeClass('clicked');
        }
        else{
            var loader = $this.closest('.continue-block').find('.loader');
            loader.removeClass("hide");
        	$.ajax({
	            url: baseUrl + "payments/validatecard",
	            type: "POST",
	            data: {
	                cardNumber: $("#billCardNumber").val(),
	                cardCode: $("#billCardCode").val(),    
	            },
	            success: function(data){
	                var ret = $.parseJSON(data);
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

			        //Validate card expiry date
			        var d = new Date();
			        var curMonth = d.getMonth();
			        var curYear = d.getFullYear();
			        curMonth = curMonth +1;
			        if($("#billingExpYear").val() == curYear && $("#billingExpMonth").val() < curMonth){
			            $("#billingExpMonth").addClass("input-error");
			            isError = true;    
			        }


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
	                

	                //Scroll to section where there is error.
	                if(!isError){
	                    $this.closest("form").submit();   
	                }
	                else{
                        loader.addClass('loader');
	                    var cardErrorElement = $("#card-data").find(".input-error");
	                    if(cardErrorElement.length){
	                        cardErrorElement.first().focus();
	                        goToByScroll("step-3");

	                    }
                        $this.removeClass('clicked');
	                }
	                
	            }
	        });
        }
    
    });

});