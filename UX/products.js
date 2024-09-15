




$(document).ready(function () {
    $("#body_Pnav_cat li").click(function (e) { 
        e.preventDefault();
        let hasclass = $(this).hasClass("on_nav_select");

        if (hasclass) {
            
        }else{
            
            $("#body_Pnav_cat li").removeClass("on_nav_select");
            $(this).addClass("on_nav_select");

        }

    });

    $("#addProduct").click(function (e) { 
        e.preventDefault();
        console.log("ngiao");
        
    });







});