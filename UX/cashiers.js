$(document).ready(function () {
    const today = new Date();
    const adultDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate()).toISOString().split('T')[0];

    $("#bd").attr('max', adultDate);


    $(".shw").click(function (e) {
        e.preventDefault();
        hs = $(this).closest("ol").hasClass("newOL");

        if (!hs) {
            $("#users ol").removeClass("newOL")
            $(".infoDD .shw button").html(`<i class="fas fa-arrow-down"></i> Show more.`)
            $(this).closest("ol").addClass("newOL")
            $(this).find(".smcntrl").html(`<i class="fas fa-arrow-up"></i> Show less.`)
        } else {
            $("#users ol").removeClass("newOL")
            $(this).find(".smcntrl").html(`<i class="fas fa-arrow-down"></i> Show more.`)
        }
    });


    $(".picSend i").click(function (e) {
        e.preventDefault();
        $("#picmhen").trigger("click");
    });

    $("#picmhen").on("change", function () {
        handleimg()
        
    });
    $(".addCashier").on("click", function () {
        $("#overlay").show();
        $(".addCSR").show();
        $("#users ol").removeClass("newOL")
        
    });
    $("#cancelAdd").on("click", function () {
        $("#overlay").hide();
        $(".addCSR").hide();
        
    });


    
    $('#addCashierFrm').on('keydown','#age', function(event) {
        if (event.key === 'Enter') {
            $('#nxt1').trigger("click") 
        }
    });
    $('#addCashierFrm').on('keydown','#addr', function(event) {
        if (event.key === 'Enter') {
            $('#nxt2').trigger("click") 
        }
    });

    $('#addCashierFrm').on('keydown','#cpw', function(event) {
        if (event.key === 'Enter') {
            $('#addCashierFrm').trigger("submit") 
        }
    });


    $("#nxt1").click(function (e) {
        e.preventDefault();

        formData = new FormData()
        formData.append('transac', 'firstSec')
        formData.append('fn', $("#fn").val())
        formData.append('mn', $("#mn").val())
        formData.append('ln', $("#ln").val())
        formData.append('age', $("#age").val())
        $.ajax({
            url: '../Views/employees.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.error === "") {
                    $(".fsec").hide();
                    $(".msec").show();
                    $(".lsec").hide();
                    $(".errtype").html("");
                    $("#addCashierFrm input").removeClass("invin")
                }
            }, error: function (xhr) {
                const errorMessage = xhr.responseJSON?.error || '';
                $(".errtype").html(errorMessage);
                if ($(".errtype p").html() == "Fill in all fields.") {
                    $("#addCashierFrm input").removeClass("invin")
                    if (mt($("#fn").val())) {
                        $("#fn").addClass("invin") 
                    }else{
                        $("#fn").removeClass('invin')
                    }
                    
                    if (mt($("#mn").val())) {
                        $("#mn").addClass("invin") 
                    }else{
                        $("#mn").removeClass('invin')
                    }
                    
                    if (mt($("#ln").val())) {
                        $("#ln").addClass("invin") 
                    }else{
                        $("#ln").removeClass('invin')
                    }
                    
                    if (mt($("#age").val())) {
                        $("#age").addClass("invin") 
                    }else{
                        $("#age").removeClass('invin')
                    }

                }else if ($(".errtype p").html() == "User must be 18 - 50Y/O.") {
                    $("#age").addClass("invin")
                }
            }
        });


        // if (
        //     !ce($("#fn").val()) &&
        //     !ce($("#mn").val()) &&
        //     !ce($("#ln").val()) &&
        //     !ce($("#age").val())
        // ) {
        //     $(".fsec").hide();
        //     $(".msec").show();
        //     $(".lsec").hide();
        //     $(".errtype").html("");
        // } else {
        //     $(".errtype").html("<p>Fill in all fields.</p>");
        // }

    });

    $("#nxt2").click(function (e) {
        e.preventDefault();

        formData = new FormData()
        formData.append('transac', 'secondSec')
        formData.append('cn', $("#cn").val())
        formData.append('bd', $("#bd").val())
        formData.append('em', $("#em").val())
        formData.append('addr', $("#addr").val())
        $.ajax({
            url: '../Views/employees.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.error === "") {
                    $(".fsec").hide();
                    $(".msec").hide();
                    $(".lsec").show();
                    $(".errtype").html("");
                    $("#addCashierFrm input").removeClass("invin")
                }
            }, error: function (xhr) {
                const errorMessage = xhr.responseJSON?.error || '';
                $(".errtype").html(errorMessage);
                if ($(".errtype p").html() == "Fill in all fields.") {
                    $("#addCashierFrm input").removeClass("invin")

                    if (mt($("#cn").val())) {
                        $("#cn").addClass("invin") 
                    }else{
                        $("#cn").removeClass('invin')
                    }
                    
                    if (mt($("#bd").val())) {
                        $("#bd").addClass("invin") 
                    }else{
                        $("#bd").removeClass('invin')
                    }
                    
                    if (mt($("#em").val())) {
                        $("#em").addClass("invin") 
                    }else{
                        $("#em").removeClass('invin')
                    }
                    
                    if (mt($("#addr").val())) {
                        $("#addr").addClass("invin") 
                    }else{
                        $("#addr").removeClass('invin')
                    }

                }else if ($(".errtype p").html() == "User must be 18 - 50Y/O.") {
                    $("#bd").addClass("invin")
                }else if ($(".errtype p").html() == "Email already in used." || $(".errtype p").html() == "Invalid email.") {
                    $("#em").addClass("invin") 
                }else if ($(".errtype p").html() == "Enter a valid and 11 digits CP no.") {
                    $("#cn").addClass("invin")
                } 
            }
        });
        // if (
        //     !ce() &&
        //     !ce($("#bd").val()) &&
        //     !ce($("#em").val()) &&
        //     !ce($("#addr").val())
        // ) {
        //     $(".fsec").hide();
        //     $(".msec").hide();
        //     $(".lsec").show();
        //     $(".errtype").html("");

        // } else {
        //     $(".errtype").html("<p>Fill in all fields.</p>");
        // }
    });

    $("#back1").click(function (e) {
        e.preventDefault();
        $(".fsec").show();
        $(".msec").hide();
        $(".lsec").hide();

    });

    $("#back2").click(function (e) {
        e.preventDefault();
        $(".fsec").hide();
        $(".msec").show();
        $(".lsec").hide();

    });

    $("#addCashierFrm").on("submit", function (a) {
        a.preventDefault();
        formData = new FormData(this)
        formData.append('transac', 'allSec')
        $.ajax({
            url: '../Views/employees.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.error === "success") {
                    $("#addCashierFrm input").val("")
                    handleimg()
                    $(".fsec").show();
                    $(".msec").hide();
                    $(".lsec").hide();
                    $("#overlay").hide();
                    $(".errtype").html("");
                    $(".addCSR").hide();
                    $("#addCashierFrm input").removeClass("invin")
                    $(".picSend > *").removeClass("invin")
                    notify("Account created successfully...")
                }
            }, error: function (xhr) {
                const errorMessage = xhr.responseJSON?.error || '';
                $(".errtype").html(errorMessage);
                let i = 0
                if ($(".errtype p").html() == "Fill in all fields.") {
                    if (mt($("#un").val())) {
                        $("#un").addClass("invin")
                    } else {
                        $("#un").removeClass('invin')
                    }

                    if (mt($("#pw").val())) {
                        $("#pw").addClass("invin")
                    } else {
                        $("#pw").removeClass('invin')
                    }

                    if (mt($("#cpw").val())) {
                        $("#cpw").addClass("invin")
                    } else {
                        $("#cpw").removeClass('invin')
                    }

                    if ($("#picmhen").prop('files').length === 0) {
                        $(".picSend > *").addClass("invin")
                    } else {
                        $(".picSend > *").removeClass("invin")
                    }

                } else if ($(".errtype p").html() == "User must be 18 - 50Y/O.") {
                    $("#addCashierFrm input").removeClass("invin")
                    $("#bd").addClass("invin")
                } else if ($(".errtype p").html() == "Email already in used." || $(".errtype p").html() == "Invalid email.") {
                    $("#addCashierFrm input").removeClass("invin")
                    $("#em").addClass("invin")
                } else if ($(".errtype p").html() == "Enter a valid and 11 digits CP no.") {
                    $("#addCashierFrm input").removeClass("invin")
                    $("#cn").addClass("invin")
                } else if ($(".errtype p").html() == "Only JPG and PNG files are allowed for profile pictures." ||
                    $(".errtype p").html() == "Please insert a profile." ||
                    $(".errtype p").html() == "The file size exceeds the maximum allowed limit (3 MB)." ||
                    $(".errtype p").html() == "Only JPG and PNG files are allowed for profile pictures."
                ) {
                    i = 1;
                    $(".picSend > *").removeClass("invin")
                    $("#addCashierFrm input").removeClass("invin")
                    $(".picSend > *").addClass("invin")
                    $("#cn").addClass("invin")
                } else if ($(".errtype p").html() == "User name already exist.") {
                    $("#addCashierFrm input").removeClass("invin")
                    $("#un").addClass("invin")
                } else if ($(".errtype p").html() == "Password must be 8 - 16 characters only.") {
                    $("#addCashierFrm input").removeClass("invin")
                    $("#pw").addClass("invin")
                } else if ($(".errtype p").html() == "Password didn't match.") {
                    $("#addCashierFrm input").removeClass("invin")
                    $("#pw").addClass("invin")
                    $("#cpw").addClass("invin")
                }
                if ($(".errtype p").html() != "Fill in all fields." && i === 0) {
                    $(".picSend > *").removeClass("invin")
                }
            }
        });
    });


    $("#submit").click(function (e) {
        e.preventDefault();

        $("#addCashierFrm").trigger("submit");





        // if (
        //     !ce($("#un").val()) &&
        //     !ce($("#pw").val()) &&
        //     !ce($("#cpw").val())
        // ) {
        //     if ($("#pw").val() === $("#cpw").val()) {
        //         if ($("#picmhen").val() != "") {
        //             $(".fsec").hide();
        //             $(".msec").hide();
        //             $(".lsec").hide();
        //         } else {
        //             $(".errtype").html("<p>Insert a display picture.</p>");
        //         }
        //     } else {
        //         $(".errtype").html("<p>Password did not match.</p>");

        //     }
        // } else {
        //     $(".errtype").html("<p>Fill in all fields.</p>");

        // }

    });


    function handleimg() {
        const profileImage6 = $('#prPic');
        const input6 = $('#picmhen')[0];
    
        const file = input6.files[0];
        if (file) {
            const reader = new FileReader();
    
            reader.onload = function () {
                profileImage6.attr('src', reader.result);
            };
    
            reader.readAsDataURL(file);
        } else {
            profileImage6.attr('src', '../image/dpTemplate.png');
    
        }
    }


    function mt(arg) {
        if (arg.trim() == "") {
            return true
        }else{
            return false
        }
    }



    function notify(msg) {
        notif = `<div class="notification">
                        <i class="fas fa-check"></i>
                        <h5>${msg}...</h5>
                    </div>`;
        $(".cashiers_cont").append(notif);
    
        setTimeout(() => {
            $(".notification i").css("animation-name", "on_notif");
        }, 1500);
    
        setTimeout(() => {
            $(".notification").css("transform", "translateX(20rem)");
        }, 4000);
    
        setTimeout(() => {
            // $(".notification").detach();
        }, 6000);
    }


});