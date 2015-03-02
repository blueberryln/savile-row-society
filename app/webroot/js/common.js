String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

Array.prototype.unique = function() {
    var unique = [];
    for (var i = 0; i < this.length; i++) {
        if (unique.indexOf(this[i]) == -1) {
            unique.push(this[i]);
        }
    }
    return unique;
};

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
    //$("div.content-container").css({"min-height":contentMinH});        
}

/* function to show signin popup*/
function signUp(e) {
    var blockTop = $(window).height()/2 - $("#signup-popup").height()/2;
    var blockLeft = $(window).width()/2 - $("#signin-popup").width()/2;
    $.blockUI({message: $('#signup-popup'), css: {position: "absolute", top: (blockTop > 0) ? blockTop : "0px", left: (blockLeft >0) ? blockLeft : 0}});
    $('.blockOverlay').click($.unblockUI);
}

/* function to show signup popup*/
function signIn() {
    var blockTop = $(window).height()/2 - $("#signin-popup").height()/2;
    var blockLeft = $(window).width()/2 - $("#signin-popup").width()/2;
    $.blockUI({message: $('#signin-popup'), css: {position: "absolute", top: (blockTop > 0) ? blockTop : "0px", left: (blockLeft >0) ? blockLeft : 0}});
    $('.blockOverlay').click($.unblockUI);
}

function quickSignUp() {
    var blockTop = $(window).height()/2 - $("#quick-signup-popup").height()/2;
    var blockLeft = $(window).width()/2 - $("#quick-signup-popup").width()/2;
    $.blockUI({message: $('#quick-signup-popup'), css: {position: "absolute", top: (blockTop > 0) ? blockTop : "0px", left: (blockLeft >0) ? blockLeft : 0}});
    $('.blockOverlay').click($.unblockUI);
}

function affiliatePopup(e) {
    var blockTop = $(window).height()/2 - $("#affiliate-popup").height()/2;
    var blockLeft = $(window).width()/2 - $("#affiliate-popup").width()/2;
    $.blockUI({message: $('#affiliate-popup'), css: {position: "absolute", top: (blockTop > 0) ? blockTop : "0px", left: (blockLeft >0) ? blockLeft : 0}});
    $('.blockOverlay').click($.unblockUI);
}


/* function to show create outfit popup*/
function outFit() {
    var blockTop = $(window).height()/2 - $("#create-otft-popup").height()/2;
    $.blockUI({message: $('#create-otft-popup'), css: {position: "fixed", top: (blockTop > 0) ? blockTop : "0px"}});
    $('.blockOverlay').click($.unblockUI);
}

function reuseoutFit() {
    var blockTop = $(window).height()/2 - $("#reuse-otft-popup").height()/2;
    $.blockUI({message: $('#reuse-otft-popup'), css: {position: "absolute", top: (blockTop > 0) ? blockTop : "0px"}});
    $('.blockOverlay').click($.unblockUI);
}

function viewoutFit() {
    var blockTop = $(window).height()/2 - $("#view-otft-popup").height()/2;
    $.blockUI({message: $('#view-otft-popup'), css: {position: "absolute", top: (blockTop > 0) ? blockTop : "0px"}});
    $('.blockOverlay').click($.unblockUI);
}

function cnfrmoutFit() {
    var blockTop = $(window).height()/2 - $("#cnfrm-otft-popup").height()/2;
    $(window).scrollTop(0);
    $.blockUI({message: $('#cnfrm-otft-popup'), css: {position: "absolute", top: (blockTop > 0) ? blockTop : "0px"}});
    $('.blockOverlay').click($.unblockUI);
}

function myClst() {
    var blockTop = $(window).height()/2 - $("#myclst-popup").height()/2;
    $.blockUI({message: $('#myclst-popup'), css: {position: "absolute", top: (blockTop > 0) ? blockTop : "0px"}});
    $('.blockOverlay').click($.unblockUI);
}


function newAddress() {
    var blockTop = $(window).height()/2 - $("#newaddess-popup").height()/2;
    $.blockUI({message: $('#newaddress-popup'), css: {position: "absolute", top: (blockTop > 0) ? blockTop : "0px"}});
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

    $('.blockOverlay').click($.unblockUI);
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
    else if(showAffiliatePopup){
        affiliatePopup();
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
    // $(window).resize(function(){
    //     footerFix();        
    //     if ($("#menu-switcher").css("display") == "none") {
    //        $(".header .menu").css("display","block");
    //     }else{
    //         $(".header .menu").css("display","none");
    //     }
    // });


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
    $('#quick-signup-popup').on('click', '#show-signin-popup', function(e){
        e.preventDefault();
        signIn();
    });
    
    /* attach to sign up event on signin popup form.
     * on click open sign-up popup form
     * */
    // $('#signin-popup').on('click', '#show-signup-popup', function(e){
    //     e.preventDefault();
    //     signUp();
    // });
    
    /* attach to create-outft event on create outfit.
     * on click open create-outft popup form
     * */
    //  $('#crt-new-otft').on('click', function(e){
    //     e.preventDefault();
    //     $("#reuse-outfit-id").val('');
    //     outFit();
    // });
    
    // $('#reuse-otft').on('click', function(e){
    //     e.preventDefault();
    //     reuseoutFit();
    // });
    
    // $('.outfit-quick-view').on('click', function(e){
    //     e.preventDefault();
    //     viewoutFit();
    // });
    
    
    
    
    
    
    // $('.myclst-quick-view').on('click', function(e){
    //     e.preventDefault();
    //     myClst();
    // });
    
    
    $('#signup-popup, #signin-popup, #crt-new-otft', '#affiliate-popup').on('click', '.notification-close', function(e){
        e.preventDefault();
        $.unblockUI();
    });
    
    $('#crt-new-otft').on('click', '.otft-close', function(e){
        e.preventDefault();
        $.unblockUI();
    });
    

    $('#quick-signup-popup').on('click', '.signup-btn', function(e){ 
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
        
        console.log(error);
        return false;
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


    $('#quick-signup-popup').on('click', '.signup-btn', function(e){
        e.preventDefault();
        var error = false;
        
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

    
    $('.multi-action').on('click', function(e){
        e.preventDefault();
        var blockTop = $(window).height()/2 - $("#multi-popup").height()/2;
        $.blockUI({message: $('#multi-popup'), css: {top: (blockTop > 0) ? blockTop : "0px"}});
        $('.blockOverlay').click($.unblockUI);
    });


    $(window).resize(function(){
       $(".blockMsg").css({'left' : $(window).width() / 2 - $(".blockMsg ").width()/2});
    });


    if($('#flash-box').length){
        $.blockUI({message: $('#flash-box'), timeout: 1700});
    }
    if($('#forgot-flash-box').length){
        $.blockUI({message: $('#forgot-flash-box')});
    }
    $('.blockOverlay, .notification-close, .otft-close').on('click', function(e){
        e.preventDefault();
        $.unblockUI();
    });
    $('#signup-popup, #signin-popup').on('click', '.notification-close', function(e){
        e.preventDefault();
        $.unblockUI();
        
    });
    $("#cnfrm").on('click', '.otft-close', function(e){
        e.preventDefault();
        $.unblockUI();   
    });
    
    $("#cnfrm").on('click', '.otft-close', function(e){
        e.preventDefault();
        $.unblockUI();   
    });

    $('#create-otft-popup,  #reuse-otft-popup, #view-otft-popup, #cnfrm-otft-popup, #myclst-popup').on('click', '.otft-close', function(e){
        e.preventDefault();
        $.unblockUI();
    });
    
    $("#cnfrm-otft-popup").on('click', '.cnfrm-otft-edit-sec', function(e){
        e.preventDefault();
        $.unblockUI();   
    });
    
    
    
//    $('.cnfrm-otft-edit-sec').click(function(){
//        $('#cnfrm-otft-popup').preventDefault();
//        $.unblockUI();
//    })
//    $('#cnfrm-otft-popup').on('click', '.cnfrm-otft-edit-sec', function(e){
//        e.preventDefault();
//        $.unblockUI();
//        return false; 
//    });
   
    $("#block-vip-access,#block-vip-access-link, #multi-vip-access").on("click", function(e){
        e.preventDefault();
        $.blockUI({message: $('#vip-box')});
        $('.blockOverlay').click($.unblockUI);
    });



$("#block-request-access").on("click", function(e){
        e.preventDefault();
        $.blockUI({message: $('#request-box')});
        $('.blockOverlay').click($.unblockUI);
    });

//upload file 
$("#block-file-upload-photo").on("click", function(e){
        e.preventDefault();
        $.blockUI({message: $('#file-box-photo')});
        $('.blockOverlay').click($.unblockUI);
    });
    
$(".profile-img-edit").on("click", "img", function(e){
        e.preventDefault();
        $.blockUI({message: $('#file-box-profile')});
        $('.blockOverlay').click($.unblockUI);
    });

//add new address
$("#block-request-address").on("click", function(e){
        e.preventDefault();
        $.blockUI({message: $('#requestaddress-box')});
        $('.blockOverlay').click($.unblockUI);
    });  
    
    
$("#block-step-access").on("click", function(e){
        e.preventDefault();
        $.blockUI({message: $('#step-box')});
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


    $(".btn-request-invite").on('click', function(e){
        e.preventDefault();
        var inviteEmail = $("#invite-email").val();
        if(inviteEmail){
            $.ajax({
                url: "/users/requestinvite",
                data : {
                    'invite-email' : inviteEmail,
                },
                cache: false,
                type: 'POST',
                success: function(res) {
                    var res = jQuery.parseJSON(res);
                    if (res['status']=='ok') {
                        $("#request-invite-block").hide();
                        $("#request-invite-status").show();
                    }
                    else if(res['status']=='member'){
                        var notificationDetails = new Array();
                        notificationDetails["msg"] = "You are already a member of Savile Row Society.";
                        showNotification(notificationDetails, true); 
                    }
                    else {
                        var notificationDetails = new Array();
                        notificationDetails["msg"] = "The request could not be completed right now. Please try after some time.";
                        showNotification(notificationDetails, true); 
                    }
                },
                error: function(res) {
                    
                }
            }).done(function(res){
                callInAction = false;
            });
        } 
    });
});
