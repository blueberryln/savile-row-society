/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



$(document).ready(function(){
    $(".brand-link").click(function(){
       // hide all
        $(".brand-block").css("display","none");

       // make visible selectedlink
        var id = "#" + $(this).data("tab") ;
       $(id).fadeIn(250);
//        $(id).css("display", "block");
       // reset class attribute
       $(".brand-link").each(function(){
           var originCss = $(this).data("origin-css");
           $(this).children("i").attr("class",originCss);
       });
       
        var bg = $(this).children("i").attr("class");
       $(this).children("i").attr("class", bg + "-focus");
    });
});