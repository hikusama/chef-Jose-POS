$(document).ready(function () {



    setNewBody();

    $(".side_nav2d li").hide()

    $(".side_nav2d li").each(function (index) {
        $(this).delay(index * 200).show(200);
    });


    $(".side_nav").on("click","li",function (e) {
        e.preventDefault();
        he = $(this).hasClass("on_select");
        id = $(this).attr("id")
        
        
        if (he === false) {
            $(".side_nav2d li").removeClass("on_select")
            $(this).addClass("on_select")
            
            let clicked_location = $(this).attr("id");
            if (clicked_location == "logoutMhen") {
                window.location.href = "../logout.php";
            } else {
                window.location.href = clicked_location + ".php";
            }

        }

    });
    $(".header_inner").on("click","#screencontroll",function (e) {
        e.preventDefault();
        if (!document.fullscreenElement) {
            $("#screencontroll").html(`<i class="fas fa-compress"></i>`);
            $("#screencontroll").attr("title","Exit full screen.");

            if (document.documentElement.requestFullscreen) {
                document.documentElement.requestFullscreen();
            } else if (document.documentElement.mozRequestFullScreen) { // Firefox
                document.documentElement.mozRequestFullScreen();
            } else if (document.documentElement.webkitRequestFullscreen) { // Chrome, Safari, Opera
                document.documentElement.webkitRequestFullscreen();
            } else if (document.documentElement.msRequestFullscreen) { // IE/Edge
                document.documentElement.msRequestFullscreen();
            }
        } else {
            $("#screencontroll").html(`<i class="fas fa-expand"></i>`);
            $("#screencontroll").attr("title","View full screen.");

            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.mozCancelFullScreen) { // Firefox
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) { // Chrome, Safari, Opera
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) { // IE/Edge
                document.msExitFullscreen();
            }
        }
    });
    $("#refresh").click(function (e) {
        e.preventDefault();
        location.reload()
    });





    $("#counter_body ").on("click", "li:nth-child(1)", function (e) {
        e.preventDefault();
        let hasclass = $(this).next(".qntity").hasClass("quantityShow");

        if (hasclass) {

            $(this).find(".arrow_controll i").removeClass("arrow");
            $(this).next(".qntity").removeClass("quantityShow");
            $(this).closest("ol").removeClass("bxselected");
        } else {
            $(".arrow_controll i").removeClass("arrow");
            $(".qntity").removeClass("quantityShow");
            $("#counter_body ol").removeClass("bxselected");
            $(this).closest("ol").addClass("bxselected");
            $(this).find(".arrow_controll i").addClass("arrow");
            $(this).next(".qntity").addClass("quantityShow");
        }

    });
    //  $(this).closest("qntity") 

    function setNewBody() {
        const theme = localStorage.getItem('theme');

        if (theme === "light") {

            document.body.classList.remove("dark_mode")
            document.body.classList.remove("monokai_mode")
        } else if (theme === "monokai") {
            document.body.classList.remove("dark_mode")
            document.body.classList.add("monokai_mode")
        } else if (theme === "dark_modern") {
            document.body.classList.remove("monokai_mode")
            document.body.classList.add("dark_mode")

        } else {
            document.body.classList.remove("dark_mode")
            document.body.classList.remove("monokai_mode")
        }



    }

});