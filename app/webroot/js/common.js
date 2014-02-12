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
    $("div.content-container").css({"min-height":contentMinH, "margin-top" : headerH});        
}

/* function to show signin popup*/
function signUp(e) {
    $.blockUI({message: $('#signup-popup'), css: {top: '8%'}});
    $('.blockOverlay').click($.unblockUI);
    $.ajax({
        url: "/register"
    }).done(function(res) {
        $("#signup-popup").html(res);
        overrideEmail();
        addReferrerToSignUp();
    });
}

/* function to show signup popup*/
function signIn() {
    $.blockUI({message: $('#signin-popup')});
    $('.blockOverlay').click($.unblockUI);
    $.ajax({
        url: "/signin"
    }).done(function(res) {
        $("#signin-popup").html(res);
        addReferrerToLogIn();
    });
}

jQuery(function(){
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
    
});
