




$(document).ready(function () {
    $("#body_Pnav_cat li").click(function (e) {
        e.preventDefault();
        let hasclass = $(this).hasClass("on_nav_select");

        if (hasclass) {

        } else {

            $("#body_Pnav_cat li").removeClass("on_nav_select");
            $(this).addClass("on_nav_select");

        }

    });
    let interval = "";

    $("#addProduct").click(function (e) {
        e.preventDefault();
        $("#overlay_prod").show();
        $("#addProductForm").show();

        setTimeout(() => {
            console.log("sada");
            $(".label_style").addClass("newlabel_style");
        }, 600);

        interval = setInterval(() => {
            manipulated = $("#overlay_prod").css("display", "none");
            if (manipulated) {
                $("#overlay_prod").show();
            }
        }, 800);



    });

    $("#addpic").change(function (e) {
        e.preventDefault();
        const input = $('#addpic')[0];

        if (input) {
            imagePick();
        }
    });

    $("#canc").click(function (e) {
        e.preventDefault();
        clearInterval(interval)
        $(".label_style").removeClass("newlabel_style");
        $("#overlay_prod").hide();
        $("#addProductForm").hide();



    });










});


function imagePick() {
    const profileImage = $('#imgdisplay');
    const input = $('#addpic')[0];
    const file = input.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function () {
            profileImage.attr('src', reader.result);
        };
        reader.readAsDataURL(file);
    } else {
        profileImage.attr('src', '../images/sample.png');

    }

}