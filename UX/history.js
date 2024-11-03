



$(document).ready(function () {

    getFindGroup("", "")
    // });

    $(".findHistory").on("input", "#findOrder", function (e) {
        e.preventDefault();
        group = $(".historyOn").attr("id")
        if (reqOpen == true) {
            reqOpen = false
            getFindGroup($(this).val(), group)
        }


    });

    let reqOpen = false

    $(".group_type").on("click", "button", function (e) {
        e.preventDefault();
        classI = $(this).attr("class")
        group = $(this).attr("id")
        console.log(reqOpen);


        if (reqOpen == true && classI !== "historyOn") {
            reqOpen = false
            $(".group_type button").removeClass("historyOn")
            $(this).addClass("historyOn")
            getFindGroup($("#findOrder").val(), group)
            console.log(reqOpen);


        }
    });

    $(".data_history_cont").on("click", ".data ol", function (e) {
        e.preventDefault()
        state = $(this).attr("id")
        if (state && state == "page-dir-cont") {
            let refno = $(this).find(".key").attr("id")
            // getOrderRecord(refno)
        }
    });


    $(".data_history_cont").on("click", ".main-dir-link button", function (e) {
        e.preventDefault()
        // console.log($(this).attr("id"));
        let page = $(this).attr("id")
        let searchVal
        if (page != "pageON" && reqOpen == true) {
            reqOpen = false
            searchVal = $("#findOrder").val()
            group = $(".historyOn").attr("id")
            getFindGroup(searchVal, group, page)
        }
    });





    function getOrderRecord(refno) {
        formData = new FormData()
        formData.append('transac', "getOrderRecord")
        formData.append('refno', refno)
        $.ajax({
            url: '../view/historyView.php.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('.history_info').html(response);
            }
        });
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
