



$(document).ready(function () {

    getFindGroup("", "")
    // e.preventDefault();
    // });



    $(".history_info").on("click", "#delReceipt", function (e) {
        e.preventDefault();

        if (reqOpen == true) {
            reqOpen = false
            let rf = $(this).parent().attr('id');
            $(".data").find("#" + rf).parent().addClass("rmByRf")
            setTimeout(() => {
                $(".data").find(".rmByRf").detach()
            }, 450);
            delOrder($(this).parent().attr('id'))

        }


    });
    $(".history_info").on("click", "#print_receipt", function (e) {
        e.preventDefault();

        formData = new FormData()
        formData.append('transac', "print")
        $.ajax({
            url: '../views/historyView.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {

            }, complete: function () {
                is = $('.history_info >*:nth-child(1)').hasClass('lgu');
                if (!is) {
                    clearPane()
                    $(".data_history_cont .data ol").removeClass("onHistoryDp")

                }
                window.open("printPage.php", "blank")
            }
        });

    });
    $(".findHistory").on("input", "#findOrder", function (e) {
        e.preventDefault();
        group = $(".historyOn").attr("id")
        if (reqOpen == true) {
            reqOpen = false
            getFindGroup($(this).val(), group)
            is = $('.history_info >*:nth-child(1)').hasClass('lgu');
            if (!is) {
                clearPane()
            }
        }


    });

    let reqOpen = false

    $(".group_type").on("click", "button", function (e) {
        e.preventDefault();
        classI = $(this).attr("class")
        group = $(this).attr("id")


        if (reqOpen == true && classI !== "historyOn") {
            is = $('.history_info >*:nth-child(1)').hasClass('lgu');
            if (!is) {
                clearPane()
            }
            reqOpen = false
            $(".group_type button").removeClass("historyOn")
            $(this).addClass("historyOn")
            getFindGroup($("#findOrder").val(), group)


        }
    });

    $(".data_history_cont").on("click", ".data ol", function (e) {
        e.preventDefault()
        hasC = $(this).hasClass("onHistoryDp");

        if (!hasC && reqOpen) {
            $(".data_history_cont .data ol").removeClass("onHistoryDp")
            $(this).addClass("onHistoryDp")
            let refno = $(this).find(".key").attr("id")
            getOrderRecord(refno)
        }
    });


    $(".data_history_cont").on("click", ".main-dir-link button", function (e) {
        e.preventDefault()
        let page = $(this).attr("id")
        let searchVal
        if (page != "pageON" && reqOpen == true) {
            is = $('.history_info >*:nth-child(1)').hasClass('lgu');
            if (!is) {
                clearPane()
            }
            reqOpen = false
            searchVal = $("#findOrder").val()
            group = $(".historyOn").attr("id")
            getFindGroup(searchVal, group, page)
        }
    });





    function getOrderRecord(refno) {
        reqOpen = false;
        formData = new FormData()
        formData.append('transac', "getOrderRecord")
        formData.append('refno', refno)
        $.ajax({
            url: '../views/historyView.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('.history_info').html(response);
                reqOpen = true;

            }
        });
    }
    function delOrder(refno) {
        reqOpen = false;
        formData = new FormData()
        formData.append('transac', "deleteOrder")
        formData.append('refno', refno)
        $.ajax({
            url: '../views/historyView.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                reqOpen = true;
                clearPane()

            }
        });
    }
    function clearPane() {
        $('.history_info').html(`<img src="../image/logo.png" class="lgu" id="dpLogo" alt="logo">`);
    }



    function getFindGroup(searchVal, g, page = 1) {

        formData = new FormData()
        formData.append("transac", "getFindGroup")
        formData.append("searchVal", searchVal)
        formData.append("group", g)
        formData.append("page", page)

        $.ajax({
            url: '../Views/historyView.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('.data').html("");
                $('.data').html(response);
                $('.data ol').hide();
                // $(".loading_sc").show();
                // $(".loading_sc").hide();
                $(".data ol").each(function (index) {
                    $(this).delay(index * 100).fadeIn(200);
                });


            }, complete: function () {
                return reqOpen = true

            }
        });
    }
});
