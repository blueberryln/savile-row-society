// For Fade in images
function fadeInImages(){
    $(".fadein-image").each(function() {
        if (this.complete) {
            //$(this).animate({opacity : 1}, 300);
            $(this).fadeTo(300, 1);
        } else {
            $(this).load(function() {
                //$(this).animate({opacity : 1}, 300);
                $(this).fadeTo(300,1);
            });
        }
    }); 
}

// To fix footer at bottom and margin top of content container
function footerFix(){
    var winH = $(window).height();
    var headerH = $("div.header").height();
    var footerH = $("div.footer").height();
    var contentMinH = winH - (headerH + footerH); 
    $("div.content-container").css({"min-height":contentMinH});        
}

/* function to show signin popup*/
function signUp(e) {
    var blockTop = $(window).height()/2 - $("#signup-popup").height()/2;
    $.blockUI({message: $('#signup-popup'), css: {position: "absolute", top: (blockTop > 0) ? blockTop : "0px"}});
    $('.blockOverlay').click($.unblockUI);
}

/* function to show signup popup*/
function signIn() {
    var blockTop = $(window).height()/2 - $("#signin-popup").height()/2;
    $.blockUI({message: $('#signin-popup'), css: {position: "absolute", top: (blockTop > 0) ? blockTop : "0px"}});
    $('.blockOverlay').click($.unblockUI);
}

function showNotification(notificationDetails, isFade){
    if(isFade === undefined)
        isFade = false;
    $(".notification-check").addClass('hide');
    $(".notification-buttons").addClass('hide');
    $(".notification-msg").html(notificationDetails['msg']);
    
    if(notificationDetails['check']){
        $(".notification-check").removeClass('hide');
        $(".notification-check").html(notificationDetails['check']);
    }
    if(notificationDetails['button']){
        $(".notification-buttons").removeClass('hide');
        $(".notification-buttons").html(notificationDetails['button']);
    }
    if(isFade){
        $.blockUI({message: $('#notification-box'), timeout: 3000});
    }
    else{
        $.blockUI({message: $('#notification-box')});
    }   
}

// function addReferrerToSignUp(){
//     if(ref_url != undefined){
//         $('#referUrl').val(ref_url);
//     }
// }

// function addReferrerToLogIn(){
//     if(ref_url != undefined){
//         $('#referUrlLogIn').val(ref_url);
//     }
// }

jQuery(function(){

    $(".card-menu ul li:last-child").click(function(){
        $(this).next(".submenu-container").show();
    });


    if(showRegisterPopup){
        signUp();    
    }

    fadeInImages();
    footerFix();
    $(".show-more-text").toggle(function() {
        $(this)
            .addClass('up')
            .parent()
                .parent()
                    .find('.long-desc')
                    .slideDown(800); 
        }, function() {
            $(this)
                .removeClass('up')
                .parent()
                    .parent()
                        .find('.long-desc')
                        .slideUp(800);
        });
    $(window).resize(function(){
        footerFix();        
        if ($("#menu-switcher").css("display") == "none") {
           $(".header .menu").css("display","block");
        }else{
            $(".header .menu").css("display","none");
        }
    });


    $("#show-signup").click(function(e) {
        signUp(e);
    });
    /* attach to sign in event on signup popup form.
     * on click opent sign-in popup form
     * */
    $('#signup-popup').on('click', '#show-signin-popup', function(e){
        e.preventDefault();
        signIn();
    });
    
    /* attach to sign up event on signin popup form.
     * on click open sign-up popup form
     * */
    $('#signin-popup').on('click', '#show-signup-popup', function(e){
        e.preventDefault();
        signUp();
    });
    

    $('#signup-popup, #signin-popup').on('click', '.notification-close', function(e){
        e.preventDefault();
        $.unblockUI();
    });

    $('#signin-popup').on('click', '.signin-btn', function(e){ 
        e.preventDefault();
        var error = false;
        if($("#signin-email").val() == "")
        {              
            $("#signin-email").addClass("err-msg");
            error = true;                   
        }
        else{
            $("#signin-email").removeClass("err-msg");
        }
        if($("#signin-password").val() == "")
        {              
            $("#signin-password").addClass("err-msg"); 
            error = true;                 
        }
        else{
            $("#signin-password").removeClass("err-msg");
        }
        
        if(error){
            var authElement = $(".err-msg");
            if(authElement.length){
                authElement.first().focus(); 
            }     
            return false;    
        }   else{            
            $("#signin-form").submit();
        }   
    });

    $('#signup-popup').on('click', '.signup-btn', function(e){
        e.preventDefault();
        var error = false;
        if($("#first-name").val() == "")
        {
            $("#first-name").addClass("err-msg");
            error = true;
        }
        else{
            $("#first-name").removeClass("err-msg");
        }
        if($("#last-name").val() == "")
        {
            $("#last-name").addClass("err-msg");
            error = true;
        }
        else{
            $("#last-name").removeClass("err-msg");   
        }
        if($("#register-email").val() == "")
        {              
            $("#register-email").addClass("err-msg");
            error = true;                   
        }
        else{
            $("#register-email").removeClass("err-msg");
        }
        if($("#register-password").val() == "")
        {              
            $("#register-password").addClass("err-msg"); 
            error = true;                 
        }
        else{
            $("#register-password").removeClass("err-msg");
        }
        
        if(error){
            var authElement = $(".err-msg");
            if(authElement.length){
                authElement.first().focus(); 
            }     
            return false;    
        }   else{            
            $("#register-form").submit();
        } 
           
    });


    $(window).resize(function(){
       $(".blockMsg").css({'left' : $(window).width() / 2 - $(".blockMsg ").width()/2});
    });


    if($('#flash-box').length){
        $.blockUI({message: $('#flash-box'), timeout: 5000});
    }
    $('.blockOverlay, .notification-close').on('click', function(e){
        e.preventDefault();
        $.unblockUI();
    });
    $('#signup-popup, #signin-popup').on('click', '.notification-close', function(e){
        e.preventDefault();
        $.unblockUI();
    });


    $("#block-vip-access").on("click", function(e){
        e.preventDefault();
        $.blockUI({message: $('#vip-box')});
        $('.blockOverlay').click($.unblockUI);
    });

    $(".vip-access-btn").on("click", function(e){
        e.preventDefault();
        var vipCode = $(".vip-access-code").val();
        if(vipCode != ''){
            location = "/users/refer/" + vipCode;
        }
    });

    $("#msg-notifications, #myaccount-drop").click(function(e){
        e.preventDefault();
        if($(this).siblings(".submenu-container").is(":visible")){
            $(this).siblings(".submenu-container").hide();    
        }
        else{
            $(this).siblings(".submenu-container").show();    
        }
    });

    $(document).on('touchstart', function(e){
        //alert("hdhkdj");
        var container = $(".submenu-container");
        if(container.is(":visible") && container.has(e.target).length === 0 ){
            container.hide();
        }    
    });
});
