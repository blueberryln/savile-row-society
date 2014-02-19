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
    $.ajax({
        url: "/register"
    }).done(function(res) {
        $("#signup-popup").html(res);
        $.blockUI({message: $('#signup-popup')});
        $('.blockOverlay').click($.unblockUI);
        //addReferrerToSignUp();
    });
}

/* function to show signup popup*/
function signIn() {
    $.ajax({
        url: "/signin"
    }).done(function(res) {
        $("#signin-popup").html(res);
        $.blockUI({message: $('#signin-popup')});
        $('.blockOverlay').click($.unblockUI);
        //addReferrerToLogIn();
    });
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

    $(window).resize(function(){
       $(".blockMsg").css({'left' : $(window).width() / 2 - $(".blockMsg ").width()/2});
    });
    
});
