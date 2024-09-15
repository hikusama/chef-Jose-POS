

$(document).ready(function () {


    $(".themes_select label").click(function (e) {
        e.preventDefault();

        let hasclass = $(this).hasClass("selected_class");

        if (hasclass) {

            $(".themes_select label").removeClass("selected_class");
        }else{
            
            $(".themes_select label").removeClass("selected_class");
            $(this).addClass("selected_class");
        }

    });
});