jQuery(function(){
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
        // console.log($(window).width());
        if ($("#menu-switcher").css("display") == "none") {
           $(".header .menu").css("display","block");
        }else{
            $(".header .menu").css("display","none");
        }
    });
});
