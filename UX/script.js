$(document).ready(function () {



    setNewBody();

    $(".side_nav2d li").hide()

    $(".side_nav2d li").each(function (index) {
        $(this).delay(index * 200).show(200);
    });


    $(".side_nav li").click(function (e) { 
        e.preventDefault();

        let clicked_location = $(this).attr("id");
        console.log(clicked_location);

        
        window.location.href = clicked_location ;
        
        
    });
    $("#screencontroll").click(function (e) { 
        e.preventDefault();
        if (!document.fullscreenElement) {
            $("#screencontroll img").attr("src", "../image/offscreen.png")
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
            $("#screencontroll img").attr("src", "../image/fullscreen.png")

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





    $("#counter_body ").on("click","li:nth-child(1)",function (e) { 
        e.preventDefault();
        let hasclass = $(this).next(".qntity").hasClass("quantityShow");
        
        if (hasclass) {
            
            $(this).find(".arrow_controll i").removeClass("arrow");
            $(this).next(".qntity").removeClass("quantityShow");
            $(this).closest("ol").removeClass("bxselected");
        }else{
            $(".arrow_controll i").removeClass("arrow");
            $(".qntity").removeClass("quantityShow");
            $("#counter_body ol").removeClass("bxselected");
            $(this).closest("ol").addClass("bxselected");
            $(this).find(".arrow_controll i").addClass("arrow");
            $(this).next(".qntity").addClass("quantityShow");
        }
        console.log("hhhh");

    });
    //  $(this).closest("qntity") 
  
    function setNewBody() {
        const theme = localStorage.getItem('theme');

        if (theme === "light") {
            console.log("light mode");
            
            document.body.classList.remove("dark_mode")
            document.body.classList.remove("monokai_mode")
        }else if(theme === "monokai"){
            console.log("monokai mode");
            document.body.classList.remove("dark_mode")
            document.body.classList.add("monokai_mode")
        }else if(theme === "dark_modern"){
            console.log("dark mode");
            document.body.classList.remove("monokai_mode")
            document.body.classList.add("dark_mode")
            
        }else{
            console.log("light mode");
            document.body.classList.remove("dark_mode")
            document.body.classList.remove("monokai_mode")
        }

        

    }

});