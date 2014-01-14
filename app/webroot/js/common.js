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
jQuery(function(){
    fadeInImages();
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
