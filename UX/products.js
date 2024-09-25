




$(document).ready(function () {
    addPorm = $("#addProductForm").detach();
    // $(".myproducts").detach(addPorm);
    $("#addProductForm").detach();
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
        $(".myproducts").append(addPorm);

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

    $(".myproducts").on("change","#addpic",function (e) {
        e.preventDefault();
        const input = $('#addpic')[0];
        console.log("entered111");

        if (input) {
            imagePick();
        }
    });

    $(".myproducts").on("click", "#canc", function (e) {
        e.preventDefault();
        clearInterval(interval)
        $(".label_style").removeClass("newlabel_style");
        $("#overlay_prod").hide();
        $("#addProductForm").detach();


    });

    // $("#submit_prod").click(function (e) { 
    //     $("#submit_form").submit(); 
    // });  method="post" action="../views/productView.php"

    $(".myproducts").on("submit", "#submit_form", function (e) {
        e.preventDefault();
        formData = new FormData(this)
        formData.append("transac", "addProd")

        $.ajax({
            url: '../views/productView.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('.response').html(response);
            }
        });

    });
    $(".more_showPane").click(function (e) {
        e.preventDefault();
        hasClass = $(this).closest("li").find(".action_selectNew").hasClass("action_selectNew");

        if (!hasClass) {
            console.log("hello");
            $(".action_select").removeClass("action_selectNew");
            $(this).closest("li").find(".action_select").addClass("action_selectNew");
        } else {

            $(".action_select").removeClass("action_selectNew");
        }
    });











});


function imagePick() {
    const profileImage = $('#imgdisplay');
    const input = $('#addpic')[0];
    const file = input.files[0];
    console.log("entered");

    if (file) {
        const reader = new FileReader();
        reader.onload = function () {
            profileImage.attr('src', reader.result);
        };
        reader.readAsDataURL(file);
        console.log("readed");
        
    } else {
        profileImage.attr('src', '../images/sample.png');

    }

}