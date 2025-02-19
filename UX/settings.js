

$(document).ready(function () {
    let loadNt = $("#loadNt").detach();
    $(".loadPa").html(loadNt);
    let loadNtCombo = $(".loadPa").detach();
    let theme_selected = "";
    let interval;
    let cpwout = $(".cpw-outer").detach()
    let cprsout = $(".pinfo-outer").detach()
    let loginInfo = []
    let personalInfo = []
    let imageChange = 0





    // localStorage.setItem('theme', 'light');

    const theme = localStorage.getItem('theme');
    if (!theme) {
        localStorage.setItem('theme', 'light');
        const themeempt = localStorage.getItem('theme');
        document.getElementById(themeempt).checked = true;
        $("#" + themeempt).closest("label").addClass("selected_class");
    } else {
        document.getElementById(theme).checked = true;
        $(".themes_select label").removeClass("selected_class");
        $("#" + theme).closest("label").addClass("selected_class");


    }
    setNewBody()

    // $(".middle_side").on("click", "#valF", function (e) {
    //     let hasclass = $(".firstForm").hasClass("dpl");
    //     if (hasclass) {
    //         $(".firstForm").removeClass("dpl")
    //         $(".secondForm").addClass("dpl")
    //     }
    // })

    $(".addm").on("click", "#creatempacc", function () {
        window.location.href = "cashiers.php"
    });

    $(".themes_select label").click(function (e) {
        e.preventDefault();
        theme_selected = ""

        let hasclass = $(this).hasClass("selected_class");
        let rad = $(this).find("input").attr("id");

        if (hasclass) {

        } else {
            $(".themes_select label").removeClass("selected_class");
            $(this).addClass("selected_class");
            document.getElementById(rad).checked = true;


        }
        if (findTrue()) {
            theme_selected = findTrue();
            $("#save_theme").addClass("inv");

        } else {
            $("#save_theme").removeClass("inv");

        }
    });
    let intervalId;
    $("#save_theme").click(function (e) {
        e.preventDefault();

        if (theme_selected != "") {

            // conf = confirm("Are you sure you want to change theme?")
            // if (conf) {

            //     localStorage.setItem('theme', theme_selected);
            //     theme_selected = ""
            //     $("#save_theme").removeClass("inv");


            // }
            let hasclass = $(this).hasClass("New_confirm_change");
            if (!hasclass) {
                $(".confirm_change").addClass("New_confirm_change");
                $(".overlay_settings").show();
                intervalId = setInterval(() => {
                    $(".overlay_settings").show();
                    check_ov = $(".overlay_settings").css("display", "none");
                    if (check_ov) {

                        $(".overlay_settings").show();
                    } else {
                        $(".overlay_settings").hide();
                    }
                }, 500);
            } else {

            }
            // $(".confirm_change").show();


        } else {

        }


    });

    $(".overlay_settings").hide();

    $("#changetheme_yes").click(function (e) {
        e.preventDefault();
        clearInterval(intervalId);
        $(".overlay_settings").hide();
        $(".confirm_change").removeClass("New_confirm_change");

        localStorage.setItem('theme', theme_selected);
        theme_selected = ""
        $("#save_theme").removeClass("inv");

        setNewBody();
        $(".notif_settings").addClass("notifsw");
        setTimeout(() => {
            $(".notif_settings").removeClass("notifsw");
        }, 3000);


    });

    $("#changetheme_no").click(function (e) {
        e.preventDefault();
        clearInterval(intervalId);
        $(".overlay_settings").hide();
        $(".confirm_change").removeClass("New_confirm_change");

    });


    $("#edit_prof").click(function (e) {
        e.preventDefault();
        $(".middle_side").append(cprsout)
        $(cprsout).show()
        $("#overlay_prod").show();

        getFormData("personalData")

        interval = setInterval(() => {
            manipulated = $("#overlay_prod").css("display", "none");
            if (manipulated) {
                $("#overlay_prod").show();
            }
        }, 800);
    });
    $(".settings_cont").on("click", "#change_pw", function (e) {
        e.preventDefault();
        $(".middle_side").append(cpwout)
        $(cpwout).show()
        $("#overlay_prod").show();

        getFormData("loginData")


        interval = setInterval(() => {
            manipulated = $("#overlay_prod").css("display", "none");
            if (manipulated) {
                $("#overlay_prod").show();
            }
        }, 800);
    });
    $(".middle_side").on("click", "#exitEditPw", function (e) {
        e.preventDefault();
        $("#overlay_prod").hide()
        $(".pinfo-inner").html("");
        $(".cpw-inner").html("");
        $(".cpw-outer").detach()
        $(".pinfo-outer").detach()

        clearInterval(interval)
    });



    // E IN

    $(".middle_side").on("input", "#fname", function (e) {
        e.preventDefault();
        val = $(this).val()
        $(this).removeClass("modif")
        $(this).removeClass("emptyI")

        if (ce(val)) {
            $(this).addClass("emptyI")
        } else if (val != personalInfo.fName) {
            $(this).addClass("modif")
        }
    });
    $(".middle_side").on("input", "#mname", function (e) {
        e.preventDefault();
        val = $(this).val()
        $(this).removeClass("modif")
        $(this).removeClass("emptyI")

        if (ce(val)) {
            $(this).addClass("emptyI")
        } else if (val != personalInfo.mName) {
            $(this).addClass("modif")
        }
    });
    $(".middle_side").on("input", "#lname", function (e) {
        e.preventDefault();
        val = $(this).val()
        $(this).removeClass("modif")
        $(this).removeClass("emptyI")

        if (ce(val)) {
            $(this).addClass("emptyI")
        } else if (val != personalInfo.lName) {
            $(this).addClass("modif")
        }
    });
    $(".middle_side").on("input", "#age", function (e) {
        e.preventDefault();
        val = $(this).val()
        $(this).removeClass("modif")
        $(this).removeClass("emptyI")

        if (ce(val)) {
            $(this).addClass("emptyI")
        } else if (val != personalInfo.age) {
            $(this).addClass("modif")
        }
    });
    $(".middle_side").on("input", "#Address", function (e) {
        e.preventDefault();
        val = $(this).val()
        $(this).removeClass("modif")
        $(this).removeClass("emptyI")

        if (ce(val)) {
            $(this).addClass("emptyI")
        } else if (val != personalInfo.address) {
            $(this).addClass("modif")
        }
    });
    $(".middle_side").on("input", "#Contactno", function (e) {
        e.preventDefault();
        val = $(this).val()
        $(this).removeClass("modif")
        $(this).removeClass("emptyI")

        if (ce(val)) {
            $(this).addClass("emptyI")
        } else if (val != personalInfo.contactno) {
            $(this).addClass("modif")
        }
    });
    $(".middle_side").on("input", "#email", function (e) {
        e.preventDefault();
        val = $(this).val()
        $(this).removeClass("modif")
        $(this).removeClass("emptyI")

        if (ce(val)) {
            $(this).addClass("emptyI")
        } else if (val != personalInfo.email) {
            $(this).addClass("modif")
        }
    });

    $(".middle_side").on("change", "#Birthdate", function (e) {
        e.preventDefault();
        val = $(this).val()
        $(this).removeClass("modif")
        $(this).removeClass("emptyI")
        $(".sbon").attr("id", "validateCPINFO")
        $(".sbon").html(`<i class="fas fa-check-square"></i> Validate`)
        $(".sbon").attr("value", "validate")
        $(".responseCPINFO").html(``)

        if (ce(val)) {
            $(this).addClass("emptyI")
        } else if (val != personalInfo.birthdate) {
            $(this).addClass("modif")
        }
    });

    $(".middle_side").on("change", "#imgSelect", function (e) {
        e.preventDefault();
        imagePick()
        $(".sbon").attr("id", "validateCPINFO")
        $(".sbon").html(`<i class="fas fa-check-square"></i> Validate`)
        $(".sbon").attr("value", "validate")
        $(".responseCPINFO").html(``)
        imageChange = 1
    });




    // A IN

    $(".middle_side").on("input", "#aname", function (e) {
        e.preventDefault();
        val = $(this).val()
        $(this).removeClass("modif")
        $(this).removeClass("emptyI")

        if (ce(val)) {
            $(this).addClass("emptyI")
        } else if (val != personalInfo.name) {
            $(this).addClass("modif")
        }
    });

    $(".middle_side").on("input", "#email", function (e) {
        e.preventDefault();
        val = $(this).val()
        $(this).removeClass("modif")
        $(this).removeClass("emptyI")

        if (ce(val)) {
            $(this).addClass("emptyI")
        } else if (val != personalInfo.email) {
            $(this).addClass("modif")
        }

    });


    $(".middle_side").on("input", "#username", function (e) {
        e.preventDefault();
        val = $(this).val()
        $(this).removeClass("modif")
        $(this).removeClass("emptyI")

        if (ce(val)) {
            $(this).addClass("emptyI")
        } else if (val != loginInfo.userName) {
            $(this).addClass("modif")
        }

    });
    $(".middle_side").on("input", "#curpw", function (e) {
        e.preventDefault();
        val = $(this).val()
        npw = $("#npw").val()
        cnpw = $("#cnpw").val()

        if (ce(val)) {
            $(this).removeClass("emptyI")
            $("#npw").removeClass("emptyI")
            $("#cnpw").removeClass("emptyI")
        }

    });
    $(".middle_side").on("input", "#npw", function (e) {
        e.preventDefault();
        val = $(this).val()
        npw = $("#curpw").val()
        cnpw = $("#cnpw").val()

        if (ce(val)) {
            $(this).removeClass("emptyI")
            $("#curpw").removeClass("emptyI")
            $("#cnpw").removeClass("emptyI")
        }

    });
    $(".middle_side").on("input", "#cnpw", function (e) {
        e.preventDefault();
        val = $(this).val()
        npw = $("#npw").val()
        cnpw = $("#curpw").val()

        if (ce(val)) {
            $(this).removeClass("emptyI")
            $("#npw").removeClass("emptyI")
            $("#curpw").removeClass("emptyI")
        }

    });


    $(".middle_side").on("input", ".firstForm input", function (e) {
        e.preventDefault();
        $(".sbon").attr("id", "validateCPINFO")
        $(".sbon").html(`<i class="fas fa-check-square"></i> Validate`)
        $(".sbon").attr("value", "validate")
        $(".responseCPINFO").html(``)

    });

    $(".middle_side").on("input", ".secondForm input", function (e) {
        e.preventDefault();
        $(".sbon").attr("id", "validateCPINFO")
        $(".sbon").html(`<i class="fas fa-check-square"></i> Validate`)
        $(".sbon").attr("value", "validate")
        $(".responseCPINFO").html(``)

    });

    $(".middle_side").on("input", "#changepw input", function (e) {
        e.preventDefault();
        $(".logG").attr("id", "validateNPW")
        $(".logG").html(`<i class="fas fa-check-square"></i> Validate`)
        $(".logG").attr("value", "validate")
        $(".responseCpw").html(``)

    });

    $(".middle_side").on("input", "#changeAdpinfo input", function (e) {
        e.preventDefault();
        $(".adIn").attr("id", "valFAd")
        $(".adIn").html(`<i class="fas fa-check-square"></i> Validate`)
        $(".adIn").attr("value", "validate")
        $(".responseCPINFO").html(``)

    });




    $(".middle_side").on("click", "#valF", function (e) {
        e.preventDefault();
        validatePersonalF()
    });


    $(".middle_side").on("click", "#backCPINFO", function (e) {
        e.preventDefault();
        $(".sbon").attr("type", "button")
        $(".secondForm").removeClass("dpl")
        $(".firstForm").addClass("dpl")
    });


    $(".middle_side").on("submit", "#changeAdpinfo", function (e) {
        e.preventDefault();
        formData = new FormData(this)
        passExePersonalFAd(formData)
    });

    $(".middle_side").on("submit", "#changepinfo", function (e) {
        e.preventDefault();
        formData = new FormData(this)
        passExePersonalF(formData)
    });

    $(".middle_side").on("submit", "#changepw", function (e) {
        e.preventDefault();
        formData = new FormData(this)
        passExeLoginF(formData)
    });



















    function validatePersonalF() {
        formData = new FormData()
        formData.append('transac', "validateP")
        formData.append('fn', $("#fname").val())
        formData.append('mn', $("#mname").val())
        formData.append('ln', $("#lname").val())
        formData.append('age', $("#age").val())
        $.ajax({
            url: '../views/settingsView.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.res === "failed") {
                    let errors = Object.values(response.listErr)
                    errors.forEach((value) => {
                        id = "#" + value
                        $(id).removeClass("modif")
                        $(id).removeClass("emptyI")
                        $(id).addClass("emptyI")
                    })
                    $(".responseCPINFO").html(response.msg)
                } else if (response.res === "good") {
                    $(".firstForm").removeClass("dpl")
                    $(".secondForm").addClass("dpl")
                    $(".sbon").attr("type", "submit")

                }
            }
        });

    }

    function passExePersonalF(formData) {
        let type = $(".sbon").attr("value")
        formData.append('transac', "executingEm")
        formData.append('type', type)
        formData.append('imgChange', imageChange)

        $.ajax({
            url: '../views/settingsView.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.res === "failed") {
                    let errors = Object.values(response.listErr)
                    if (response.go) {
                        $(".secondForm").removeClass("dpl")
                        $(".firstForm").addClass("dpl")
                    }

                    errors.forEach((value) => {
                        if (value === "img") {
                            $(".selP > *").removeClass("modifP")
                            $(".selP > *").removeClass("emptyIP")
                            $(".selP > *").addClass("emptyIP")
                        } else {
                            id = "#" + value
                            $(id).removeClass("modif")
                            $(id).removeClass("emptyI")
                            $(id).addClass("modif")
                        }
                    })

                } else if (response.res === "good") {

                    if (response.action === "validated") {
                        $(".sbon").attr("id", "submitCPINFO")
                        $(".sbon").html(`<i class="fas fa-plus"></i> Submit`)
                        $(".sbon").attr("value", "execute")

                    } else if (response.action === "executed") {
                        $("#exitEditPw").trigger("click")
                        notify(response.msg)
                    } else if (response.action === "executionFailed") {
                        $("#exitEditPw").trigger("click")
                        notify(response.msg, "plus")
                    }

                }
                $(".responseCPINFO").html(response.msg)

            }
        });
    }


    function passExePersonalFAd(formData) {
        let type = $(".adIn").attr("value")
        formData.append('transac', "executingAd")
        formData.append('type', type)

        $.ajax({
            url: '../views/settingsView.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.res === "failed") {
                    let errors = Object.values(response.listErr)
                    errors.forEach((value) => {
                        id = "#" + value
                        $(id).removeClass("modif")
                        $(id).removeClass("emptyI")
                        $(id).addClass("modif")
                    })

                } else if (response.res === "good") {
                    if (response.action === "validated") {
                        $(".adIn").attr("id", "submitFAd")
                        $(".adIn").html(`<i class="fas fa-plus"></i> Submit`)
                        $(".adIn").attr("value", "execute")

                    } else if (response.action === "executed") {
                        $("#exitEditPw").trigger("click")
                        notify(response.msg)
                    } else if (response.action === "executionFailed") {
                        $("#exitEditPw").trigger("click")
                        notify(response.msg, "plus")
                    }

                }
                $(".responseCPINFO").html(response.msg)

            }
        });
    }



    function passExeLoginF(formData) {
        let type = $(".logG").attr("value")
        formData.append('transac', "executingLoginf")
        formData.append('type', type)

        $.ajax({
            url: '../views/settingsView.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.res === "failed") {
                    let errors = Object.values(response.listErr)
                    errors.forEach((value) => {
                        id = "#" + value
                        if (value === "curpwD") {
                            id = "#curpw"
                            $(id).removeClass("modif")
                            $(id).removeClass("emptyI")
                            $(id).addClass("modifPP")
                        } else {
                            if (value === "curpw") {
                                $(id).removeClass("modifPP")
                                $(id).addClass("emptyI")
                                $("#npw").removeClass("modif")
                                $("#cnpw").removeClass("modif")
                                $("#npw").removeClass("emptyI")
                                $("#cnpw").removeClass("emptyI")
                                $("#npw").val("")
                                $("#cnpw").val("")
                            } else {
                                $(id).removeClass("modif")
                                $(id).removeClass("emptyI")
                                $(id).addClass("emptyI")
                            }
                        }
                    })

                } else if (response.res === "good") {

                    if (response.action === "validated") {
                        $(".logG").attr("id", "submitNPW")
                        $(".logG").html(`<i class="fas fa-plus"></i> Submit`)
                        $(".logG").attr("value", "execute")
                        let errors = Object.values(response.listGood)
                        if (errors) {
                            errors.forEach((value) => {
                                id = "#" + value
                                $(id).removeClass("modif")
                                $(id).removeClass("emptyI")
                                $(id).addClass("modif")
                            })
                        }
                    } else if (response.action === "executed") {
                        $("#exitEditPw").trigger("click")
                        notify(response.msg)
                    } else if (response.action === "executionFailed") {
                        $("#exitEditPw").trigger("click")
                        notify(response.msg, "plus")
                    }

                }
                $(".responseCpw").html(response.msg)

            }
        });
    }





    function ce(arg) {
        if (arg === "") {
            return true
        }
        return false
    }


    function getFormData(type) {
        formData = new FormData()
        formData.append('transac', "getForm")
        formData.append('formType', type)
        $.ajax({
            url: '../views/settingsView.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.formType == "loginData") {
                    $(".cpw-inner").html(response.form);
                    $(".cpw-inner > *").hide()
                    $(".cpw-inner").append(loadNtCombo);
                    $(loadNtCombo).html(loadNt)
                    $(loadNt).show()
                    loginInfo = response.orgData
                    setTimeout(() => {
                        $(loadNtCombo).detach()
                        $(".cpw-inner > *").show()
                        $(".cpw-outer").show();
                    }, 800);
                } else if (response.formType == "personalData") {
                    $(".pinfo-inner").html(response.form);
                    $(".pinfo-inner > *").hide()
                    $(".pinfo-inner").append(loadNtCombo);
                    $(loadNtCombo).html(loadNt)
                    $(loadNt).show()
                    personalInfo = response.orgData
                    setTimeout(() => {
                        $(loadNtCombo).detach()
                        $(".pinfo-inner > *").show()
                        $(".pinfo-outer").show();
                    }, 800);
                    let i = $(".middle_side").find(".imgwrSet img").hasClass("dta");
                    if (i) {
                        insertF($("#dpf").attr('src'), "#imgSelect")
                    }
                }

            }
        });
    }




    function findTrue() {
        const theme = localStorage.getItem('theme');


        let isTheme1 = document.getElementById("light");
        let isTheme2 = document.getElementById("monokai");
        let isTheme3 = document.getElementById("dark_modern");


        if ((isTheme1.checked) && isTheme1.value != theme) {
            return "light"

        } else if ((isTheme2.checked) && isTheme2.value != theme) {
            return "monokai"

        } else if ((isTheme3.checked) && isTheme3.value != theme) {
            return "dark_modern"
        }


        return false

    }

    function notify(msg, f = "check") {
        let notif = `<div class="notification">
                    <i class="fas fa-${f}"></i>
                    <h5>${msg}...</h5>
                </div>`;
        $(".middle_side").append(notif);

        if (f === "plus") {
            $(".notification").addClass("newNotif")
        }
        setTimeout(() => {
            $(".notification i").css("animation-name", "on_notif");
        }, 1500);

        setTimeout(() => {
            $(".notification").css("transform", "translateX(20rem)");
        }, 4000);

        setTimeout(() => {
            $(".notification").detach();
        }, 6000);
    }


    function setNewBody() {
        const theme = localStorage.getItem('theme');

        if (theme === "light") {
<<<<<<< HEAD
            
            document.body.classList.remove("dark_mode")
            document.body.classList.remove("monokai_mode")
        }else if(theme === "monokai"){
            document.body.classList.remove("dark_mode")
            document.body.classList.add("monokai_mode")
        }else if(theme === "dark_modern"){
            document.body.classList.remove("monokai_mode")
            document.body.classList.add("dark_mode")
            
        }else{
=======

            document.body.classList.remove("dark_mode")
            document.body.classList.remove("monokai_mode")
        } else if (theme === "monokai") {
            document.body.classList.remove("dark_mode")
            document.body.classList.add("monokai_mode")
        } else if (theme === "dark_modern") {
            document.body.classList.remove("monokai_mode")
            document.body.classList.add("dark_mode")

        } else {
>>>>>>> dockerized
            document.body.classList.remove("dark_mode")
            document.body.classList.remove("monokai_mode")
        }



    }

    function insertF(imgSrc, inputFile) {
        let input3 = $(inputFile)[0];
        fetch(imgSrc)
            .then(response => response.blob())
            .then(blob => {
                const file = new File([blob], "image.png", { type: "image/png" });
                const fileList = new DataTransfer();
                fileList.items.add(file);
                input3.files = fileList.files;

            });
    }

    function imagePick() {
        const profileImage = $(".imgwrSet img");
        const input = $("#imgSelect")[0];
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function () {
                profileImage.attr('src', reader.result);
            };
            reader.readAsDataURL(file);

            $(".selP > *").removeClass("emptyIP")
            $(".selP > *").addClass("modifP")

        } else {
            profileImage.attr('src', '../image/dpTemplate.png');
            $(".selP > *").removeClass("modifP")
            $(".selP > *").addClass("emptyIP")

        }

    }
});







function getid(s) {
    return document.getElementById(s)
}



