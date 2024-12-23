$(document).ready(function () {
    const today = new Date();
    const adultDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate()).toISOString().split('T')[0];
    let loader = $("#loadNt")
    $("#bd").attr('max', adultDate);
    let editArg = [];
    findEmployee("", 1)
    let changeReq = [];
    let img_change = 0;
    $("#searchUser").on("input", "input", function (e) {
        e.preventDefault();
        let search = $(this).val()
        findEmployee(search, 1)


    });
    $(".cashiers_cont").on("click", "#cancelEdit", function (e) {
        e.preventDefault();

        $("#overlay").hide();
        $(".addCSREdit").hide();

    });

    $("#users").on("click", "#editUs", function (e) {
        e.preventDefault();
        $("#overlay").show();
        $(".addCSREdit").show();
        // if(prompt("Type 'delete' to confirm.") === "delete"){
        //     popthis($(this).closest("ol"))
        //     delEmployee(id);
        // }
        let id = $(this).parent().attr("dt")

        editGet(id)

    });
    $("#users").on("click", "#delUs", function (e) {
        e.preventDefault();
        let id = $(this).parent().attr("dt")

        if (prompt("Type 'delete' to confirm.") === "delete") {
            popthis($(this).closest("ol"))
            delEmployee(id);
        }


    });
    $("#users").on("click", ".shw", function (e) {
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

    $(".cashiers_cont .addCSR").on("click", ".picSend i", function (e) {
        e.preventDefault();
        $("#picmhen").trigger("click");
    });
    $(".cashiers_cont .addCSREdit").on("click", ".picSend i", function (e) {
        e.preventDefault();
        $("#picmhendpEdit").trigger("click");
    });

    $(".cashiers_cont .addCSREdit").on("change", "#picmhen", function (e) {
        handleimg('#prPic', '#picmhen')

    });
    $(".cashiers_cont .addCSREdit").on("change", "#picmhendpEdit", function (e) {
        handleimg('#prPicEdit', '#picmhendpEdit')
        changeReq.push({field:$(this).attr('name'), value : "profilePic"});
        
        const input6 = $("#picmhendpEdit")[0];

        const file = input6.files[0];
        if (!file) {

        }
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



    $('#addCashierFrm').on('keydown', '#age', function (event) {
        if (event.key === 'Enter') {
            $('#nxt1').trigger("click")
        }
    });
    $('#addCashierFrm').on('keydown', '#addr', function (event) {
        if (event.key === 'Enter') {
            $('#nxt2').trigger("click")
        }
    });

    $('#addCashierFrm').on('keydown', '#cpw', function (event) {
        if (event.key === 'Enter') {
            $('#addCashierFrm').trigger("submit")
        }
    });

    $('.cashiers_cont').on('keydown', '#ageEdit', function (event) {
        if (event.key === 'Enter') {
            $('#nxt1Edit').trigger("click")
        }
    });
    $('.cashiers_cont').on('keydown', '#addrEdit', function (event) {
        if (event.key === 'Enter') {
            $('#nxt2Edit').trigger("click")
        }
    });

    $('.cashiers_cont').on('keydown', '#cpwEdit', function (event) {
        if (event.key === 'Enter') {
            $('#editCashierFrm').trigger("submit")
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
                    } else {
                        $("#fn").removeClass('invin')
                    }

                    if (mt($("#mn").val())) {
                        $("#mn").addClass("invin")
                    } else {
                        $("#mn").removeClass('invin')
                    }

                    if (mt($("#ln").val())) {
                        $("#ln").addClass("invin")
                    } else {
                        $("#ln").removeClass('invin')
                    }

                    if (mt($("#age").val())) {
                        $("#age").addClass("invin")
                    } else {
                        $("#age").removeClass('invin')
                    }

                } else if ($(".errtype p").html() == "User must be 18 - 50Y/O.") {
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
        formData.append('age', $("#age").val())
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
                if (response.error === "success") {
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
                    } else {
                        $("#cn").removeClass('invin')
                    }

                    if (mt($("#bd").val())) {
                        $("#bd").addClass("invin")
                    } else {
                        $("#bd").removeClass('invin')
                    }

                    if (mt($("#em").val())) {
                        $("#em").addClass("invin")
                    } else {
                        $("#em").removeClass('invin')
                    }

                    if (mt($("#addr").val())) {
                        $("#addr").addClass("invin")
                    } else {
                        $("#addr").removeClass('invin')
                    }

                } else if ($(".errtype p").html() == "User must be 18 - 50Y/O." || $(".errtype p").html() == "Age and Birth Year doesn't match.") {
                    $("#bd").addClass("invin")
                } else if ($(".errtype p").html() == "Email already in used." || $(".errtype p").html() == "Invalid email.") {
                    $("#em").addClass("invin")
                } else if ($(".errtype p").html() == "Enter a valid and 11 digits CP no.") {
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

                } else if ($(".errtype p").html() == "User must be 18 - 50Y/O." || $(".errtype p").html() == "Age and Birth Year doesn't match.") {
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

    });
    $("#submitEdit").click(function (e) {
        e.preventDefault();

        $("#addCashierFrm").trigger("submit");

    });

    $(".cashiers_cont").on("click", "#nxt1Edit", function (e) {
        e.preventDefault();

        formData = new FormData()
        formData.append('transac', 'firstSec')
        formData.append('fn', $("#fnEdit").val())
        formData.append('mn', $("#mnEdit").val())
        formData.append('ln', $("#lnEdit").val())
        formData.append('age', $("#ageEdit").val())
        $.ajax({
            url: '../Views/employees.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.error === "") {
                    $(".fsecEdit").hide();
                    $(".msecEdit").show();
                    $(".lsecEdit").hide();
                    $(".errtypeEdit").html("");
                    $("#editCashierFrm input").removeClass("invin")
                }
            }, error: function (xhr) {
                const errorMessage = xhr.responseJSON?.error || '';
                $('.errtypeEdit').html(errorMessage);
                if ($(".errtypeEdit p").html() == "Fill in all fields.") {
                    $("#editCashierFrm input").removeClass("invin")
                    if (mt($("#fnEdit").val())) {
                        $("#fnEdit").removeClass("newB")
                        $("#fnEdit").addClass("invin")
                    } else {
                        $("#fnEdit").removeClass('invin')
                    }

                    if (mt($("#mnEdit").val())) {
                        $("#mnEdit").removeClass("newB")
                        $("#mnEdit").addClass("invin")
                    } else {
                        $("#mnEdit").removeClass('invin')
                    }

                    if (mt($("#lnEdit").val())) {
                        $("#lnEdit").removeClass("newB")
                        $("#lnEdit").addClass("invin")
                    } else {
                        $("#lnEdit").removeClass('invin')
                    }

                    if (mt($("#ageEdit").val())) {
                        $("#ageEdit").removeClass("newB")
                        $("#ageEdit").addClass("invin")
                    } else {
                        $("#ageEdit").removeClass('invin')
                    }

                } else if ($(".errtypeEdit p").html() == "User must be 18 - 50Y/O.") {
                    $("#ageEdit").removeClass("newB")
                    $("#ageEdit").addClass("invin")
                }
            }
        });
    });

    $(".cashiers_cont").on("click", "#nxt2Edit", function (e) {
        e.preventDefault();

        formData = new FormData()
        formData.append('transac', 'secondSec')
        formData.append('edit', 1)
        formData.append('age', $("#ageEdit").val())
        formData.append('cn', $("#cnEdit").val())
        formData.append('bd', $("#bdEdit").val())
        formData.append('em', $("#emEdit").val())
        formData.append('addr', $("#addrEdit").val())
        $.ajax({
            url: '../Views/employees.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.error === "success") {
                    $(".fsecEdit").hide();
                    $(".msecEdit").hide();
                    $(".lsecEdit").show();
                    $(".errtypeEdit").html("");
                    $("#editCashierFrm input").removeClass("invin")
                }
            }, error: function (xhr) {
                const errorMessage = xhr.responseJSON?.error || '';
                $(".errtypeEdit").html(errorMessage);
                if ($(".errtypeEdit p").html() == "Fill in all fields.") {
                    $("#editCashierFrm input").removeClass("invin")

                    if (mt($("#cnEdit").val())) {
                        $("#cnEdit").removeClass('newB')
                        $("#cnEdit").addClass("invin")
                    } else {
                        $("#cnEdit").removeClass('invin')
                    }

                    if (mt($("#bdEdit").val())) {
                        $("#bdEdit").removeClass('newB')
                        $("#bdEdit").addClass("invin")
                    } else {
                        $("#bdEdit").removeClass('invin')
                    }

                    if (mt($("#emEdit").val())) {
                        $("#emEdit").removeClass('newB')
                        $("#emEdit").addClass("invin")
                    } else {
                        $("#emEdit").removeClass('invin')
                    }

                    if (mt($("#addrEdit").val())) {
                        $("#addrEdit").removeClass('newB')
                        $("#addrEdit").addClass("invin")
                    } else {
                        $("#addrEdit").removeClass('invin')
                    }


                } else if ($(".errtypeEdit p").html() == "User must be 18 - 50Y/O." || $(".errtypeEdit p").html() == "Age and Birth Year doesn't match.") {
                    $("#bdEdit").removeClass("newB")
                    $("#bdEdit").addClass("invin")
                } else if ($(".errtypeEdit p").html() == "Email already in used." || $(".errtypeEdit p").html() == "Invalid email.") {
                    $("#emEdit").removeClass("newB")
                    $("#emEdit").addClass("invin")
                } else if ($(".errtypeEdit p").html() == "Enter a valid and 11 digits CP no.") {
                    $("#cnEdit").removeClass("newB")
                    $("#cnEdit").addClass("invin")
                }
            }
        });

    });

    $(".cashiers_cont").on("click", "#back1Edit", function (e) {
        e.preventDefault();
        $(".fsecEdit").show();
        $(".msecEdit").hide();
        $(".lsecEdit").hide();

    });

    $(".cashiers_cont").on("click", "#back2Edit", function (e) {
        e.preventDefault();
        $(".fsecEdit").hide();
        $(".msecEdit").show();
        $(".lsecEdit").hide();

    });







    // first section

    $(".cashiers_cont").on("input", "#fnEdit", function (e) {
        e.preventDefault();
        inp = $(this).val()

        if (inp.trim() === "") {
            $(this).removeClass("newB");
            $(this).addClass("invin");
            if (changeReq['fn']) {
                delete changeReq['fn']
            }
        } else if (inp.trim() != editArg.fName) {
            $(this).addClass("newB");
            $(this).removeClass("invin");
            changeReq.push({field:$(this).attr('id'), value : "fName"});
            

        } else {
            $(this).removeClass("invin");
            $(this).removeClass("newB");
            if (changeReq['fn']) {
                delete changeReq['fn']
            }
        }


    });


    $(".cashiers_cont").on("input", "#mnEdit", function (e) {
        e.preventDefault();
        inp = $(this).val()

        if (inp.trim() === "") {
            $(this).removeClass("newB");
            $(this).addClass("invin"); if (changeReq['mn']) {
                delete changeReq['mn']
            }
        } else if (inp.trim() != editArg.mName) {
            $(this).addClass("newB");
            $(this).removeClass("invin");
            changeReq.push({field:$(this).attr('id'), value : "mName"});
            

        } else {
            $(this).removeClass("invin");
            $(this).removeClass("newB");
            if (changeReq['mn']) {
                delete changeReq['mn']
            }
        }


    });
    $(".cashiers_cont").on("input", "#lnEdit", function (e) {
        e.preventDefault();
        inp = $(this).val()

        if (inp.trim() === "") {
            $(this).removeClass("newB");
            $(this).addClass("invin"); if (changeReq['ln']) {
                delete changeReq['ln']
            }
        } else if (inp.trim() != editArg.lName) {
            $(this).addClass("newB");
            $(this).removeClass("invin");
            changeReq.push({field:$(this).attr('id'), value : "lName"});
            

        } else {
            $(this).removeClass("invin");
            $(this).removeClass("newB");
            if (changeReq['ln']) {
                delete changeReq['ln']
            }
        }


    });
    $(".cashiers_cont").on("input", "#ageEdit", function (e) {
        e.preventDefault();
        inp = $(this).val()

        if (inp.trim() === "") {
            $(this).removeClass("newB");
            $(this).addClass("invin"); if (changeReq['age']) {
                delete changeReq['age']
            }
        } else if (inp.trim() != editArg.age) {
            $(this).addClass("newB");
            $(this).removeClass("invin");
            changeReq.push({field:$(this).attr('id'), value : "age"});
            

        } else {
            $(this).removeClass("invin");
            $(this).removeClass("newB"); if (changeReq['age']) {
                delete changeReq['age']
            }
        }

    });


    // second section

    $(".cashiers_cont").on("input", "#cnEdit", function (e) {
        e.preventDefault();
        inp = $(this).val()

        if (inp.trim() === "") {
            $(this).removeClass("newB");
            changeReq.push({field:$(this).attr('id'), value : "contactno"});
            
            $(this).addClass("invin"); if (changeReq['cn']) {
                delete changeReq['cn']
            }
        } else if (inp.trim() != editArg.contactno) {
            $(this).addClass("newB");
            $(this).removeClass("invin");
            changeReq.push({field:$(this).attr('id'), value : "contactno"});
            

        } else {
            $(this).removeClass("invin");
            $(this).removeClass("newB"); if (changeReq['cn']) {
                delete changeReq['cn']
            }
        }


    });
    $(".cashiers_cont").on("input", "#bdEdit", function (e) {
        e.preventDefault();
        inp = $(this).val()

        if (inp.trim() === "") {
            $(this).removeClass("newB");
            $(this).addClass("invin");
            if (changeReq['bd']) {
                delete changeReq['bd']
            }
        } else if (inp.trim() != editArg.birthdate) {
            $(this).addClass("newB");
            $(this).removeClass("invin");
            changeReq.push({field:$(this).attr('id'), value : "birthdate"});
            

        } else {
            $(this).removeClass("invin");
            $(this).removeClass("newB");
            if (changeReq['bd']) {
                delete changeReq['bd']
            }
        }


    });
    $(".cashiers_cont").on("input", "#emEdit", function (e) {
        e.preventDefault();
        inp = $(this).val()

        if (inp.trim() === "") {
            $(this).removeClass("newB");
            $(this).addClass("invin");
            if (changeReq['em']) {
                delete changeReq['em']
            }
        } else if (inp.trim() != editArg.email) {
            $(this).addClass("newB");
            $(this).removeClass("invin");
            changeReq.push({field:$(this).attr('id'), value : "email"});
            

        } else {
            $(this).removeClass("invin");
            $(this).removeClass("newB");
            if (changeReq['em']) {
                delete changeReq['em']
            }
        }


    });
    $(".cashiers_cont").on("input", "#addrEdit", function (e) {
        e.preventDefault();
        inp = $(this).val()

        if (inp.trim() === "") {
            $(this).removeClass("newB");
            $(this).addClass("invin");
            if (changeReq['addr']) {
                delete changeReq['addr']
            }
        } else if (inp.trim() != editArg.address) {
            $(this).addClass("newB");
            $(this).removeClass("invin");
            changeReq.push({field:$(this).attr('id'), value : "address"});
            

        } else {
            $(this).removeClass("invin");
            $(this).removeClass("newB");
            if (changeReq['addr']) {
                delete changeReq['addr']
            }
        }

    });


    // last section

    $(".cashiers_cont").on("input", "#unEdit", function (e) {
        e.preventDefault();
        inp = $(this).val()


        if (inp.trim() === "") {
            $(this).removeClass("newB");
            $(this).addClass("invin");
            if (changeReq['un']) {
                delete changeReq['un']
            }
        } else if (inp.trim() != editArg.userName) {
            $(this).addClass("newB");
            $(this).removeClass("invin");
            changeReq.push({field:$(this).attr('id'), value : "userName"});
            
            

        } else {
            $(this).removeClass("invin");
            $(this).removeClass("newB");
            if (changeReq['un']) {
                delete changeReq['un']
            }
        }

    });






    $(".cashiers_cont").on("submit", "#editCashierFrm", function (a) {
        a.preventDefault();
        let id = $(this).find("#prPicEdit").attr("class")
        console.log(changeReq);
        formData = new FormData(this)
        formData.append('transac', 'allSecEdit')
        formData.append('userID', id)
        formData.append('modifieds', JSON.stringify(changeReq))

        $.ajax({
            url: '../Views/employees.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.error === "success") {
                    $("#editCashierFrm input").val("")
                    $(".fsecEdit").show();
                    $(".msecEdit").hide();
                    $(".lsecEdit").hide();
                    $("#overlay").hide();
                    $(".errtypeEdit").html("");
                    $(".addCSREdit").hide();
                    $("#editCashierFrm input").removeClass("invin")
                    $(".addCSREdit .picSend > *").removeClass("invin")
                    notify("Account updated successfully...")
                    findEmployee("",1)
                }
            }, error: function (xhr) {
                const errorMessage = xhr.responseJSON?.error || '';
                $(".errtypeEdit").html(errorMessage);
                let i = 0
                if ($(".errtypeEdit p").html() == "Fill in all fields.") {
                    if (mt($("#unEdit").val())) {
                        $("#unEdit").addClass("invin")
                    } else {
                        $("#unEdit").removeClass('invin')
                    }

                } else if ($(".errtypeEdit p").html() == "Only JPG and PNG files are allowed for profile pictures." ||
                    $(".errtypeEdit p").html() == "Please insert a profile." ||
                    $(".errtypeEdit p").html() == "The file size exceeds the maximum allowed limit (3 MB)." ||
                    $(".errtypeEdit p").html() == "Only JPG and PNG files are allowed for profile pictures."
                ) {
                    i = 1;
                    $(".picSend > *").removeClass("invin")
                    $("#editCashierFrm input").removeClass("invin")
                    $(".addCSREdit .picSend > *").addClass("invin")
                    $("#cnEdit").addClass("invin")
                } else if ($(".errtypeEdit p").html() == "User name already exist.") {
                    $("#editCashierFrm input").removeClass("invin")
                    $("#unEdit").addClass("invin")
                } else if ($(".errtypeEdit p").html() == "Password must be 8 - 16 characters only.") {
                    $("#editCashierFrm input").removeClass("invin")
                    $("#pwEdit").addClass("invin")
                } else if ($(".errtypeEdit p").html() == "Password didn't match.") {
                    $("#editCashierFrm input").removeClass("invin")
                    $("#pwEdit").addClass("invin")
                    $("#cpwEdit").addClass("invin")
                }
                if ($(".errtypeEdit p").html() != "Fill in all fields." && i === 0) {
                    $(".addCSREdit .picSend > *").removeClass("invin")
                    if (changeReq['pc']) {
                        $(".addCSREdit .picSend > *").removeClass("newB")
                    }
                }
            }
        });
    });
























    function editGet(id) {
        $(loader).detach();
        $('.addCSREdit').html(loader);
        $(loader).show();
        formData = new FormData()
        formData.append('transac', "editGet")
        formData.append('id', id)
        $.ajax({
            url: '../Views/employees.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                editArg = response.row;


                setTimeout(() => {
                    $('.addCSREdit').html(response.error);
                    insertF($('.addCSREdit #prPicEdit').attr('src'))

                }, 1500);
            }, error: function (xhr) {
                const errorMessage = xhr.responseJSON?.error || '';
                $('.addCSREdit').html(errorMessage);

            }
        });
    }

    function insertF(imgSrc) {
        let input3 = $('#picmhendpEdit')[0];
        fetch(imgSrc)
            .then(response => response.blob())
            .then(blob => {
                const file = new File([blob], "image.png", { type: "image/png" });
                const fileList = new DataTransfer();
                fileList.items.add(file);
                input3.files = fileList.files;

            });
    }





    function findEmployee(name, page) {
        formData = new FormData()
        formData.append('transac', "findEmployee")
        formData.append('name', name)
        formData.append('page', page)
        $.ajax({
            url: '../Views/employees.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                // $('#users').html(response.err);
                display(response.error)

            }, error: function (xhr) {
                const errorMessage = xhr.responseJSON?.error || '';
                $('#users').html(errorMessage);

            }
        });
    }


    function delEmployee(id) {
        formData = new FormData()
        formData.append('transac', "delAccount")
        formData.append('id', id)
        $.ajax({
            url: '../Views/employees.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.error === "success") {
                    notify("Deleted successfully....")
                }
            }, error: function (xhr) {
                const errorMessage = xhr.responseJSON?.error || '';
                notifyError(errorMessage)
            }
        });
    }











    function display(rows) {
        $('#users').html(rows);
        $('#users').children().hide();

        $('#users').children().each(function (index) {
            $(this).delay(index * 100).fadeIn(200);
        });

    }






    function handleimg(dp, fl) {
        console.log("hey:" + dp);
        console.log("hey:" + fl);

        const profileImage6 = $(dp);
        const input6 = $(fl)[0];

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
        } else {
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
            $(".notification").detach();
        }, 6000);
    }

    function popthis(elementOBJ) {

        $(elementOBJ).addClass("deleting")
        setTimeout(() => {
            $(elementOBJ).detach()
        }, 700);

    }
    function notifyError(msg) {
        notif = `<div class="notification n2">
                        <i class="fas fa-plus" style="transform:rotate(45deg);background-color:red;"></i>
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
            $(".notification").detach();
        }, 6000);
    }






});