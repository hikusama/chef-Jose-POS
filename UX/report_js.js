$(document).ready(function () {
    const today = new Date().toISOString().split('T')[0]
    
    $("#frD").attr('max', today);
    $("#toD").attr('max', today);

    $("#frAnl").attr('max', today);
    $("#toAnl").attr('max', today);
    let bdcontt
    let data_presentation_wrap = $(".analytics .data_presentation_wrap").detach();

    // const samp = new Date();

    // // let samp = (currYr - 1).toString() + " - " + currYr.toString()

    // $(".recordDate").html(samp.getMonth() + "/" + samp.getDate() + "/" + samp.getFullYear());
    $(".recordDate").html(today);
    
    getItems("proddR", "highest", "singleAnl", "sales-data", today, "")




    let start = $(".start");
    let end = $(".end").detach();

    let startAnl = $(".startAnl");
    let endAnl = $(".endAnl").detach();

    $("#singleT").prop("checked", true)

    $(".rangeType").on("click", "input", function (e) {
        // e.preventDefault();
        let alrc = $(this).hasClass("ch")
        let id = $(this).attr("id")

        if (!alrc) {
            $("#" + id).prop("checked", true)

            $(".rangeType input").removeClass("ch");
            $(this).addClass("ch");
            let Rtype = $(this).val();

            if (Rtype === "single") {
                $(".start p").html("Go to")
                $(".end").detach()
            } else if (Rtype === "double") {
                $(".start p").html("Start")
                $(".dateRangeT").append(end);
            }
        } else {
            $("#" + id).prop("checked", true)
        }
        console.log("#" + id);


    });
    $("#traceReport").click(function (e) {
        e.preventDefault();
        sTrForm("b")
    });
    $(".menu").click(function (e) {
        e.preventDefault();
        sTrForm("b", "d")
    });
    $("#eksmen").click(function (e) {
        e.preventDefault();
        sTrForm("x")
    });
    $("#bkAnl").click(function (e) {
        e.preventDefault();
        sTrForm("x", "s")
    });






    $(".rk li button").click(function (e) {
        e.preventDefault();
        let hs = $(this).hasClass("onRank")

        if (!hs) {
            $(".rk li button").removeClass("onRank");
            $(this).addClass("onRank");

        }


    });



    $(".orb li button").click(function (e) {
        e.preventDefault();
        let hs = $(this).hasClass("onOrdered")

        if (!hs) {
            $(".orb li button").removeClass("onOrdered");
            $(this).addClass("onOrdered");

        }


    });



    $(".data-type li button").click(function (e) {
        e.preventDefault();
        let hs = $(this).hasClass("onDataType")

        if (!hs) {
            $(".data-type li button").removeClass("onDataType");
            $(this).addClass("onDataType");

        }


    });




    let an = $("#singleAnl").attr("id")
    $("#" + an).prop("checked", true)

    $(".rt").on("click", "input", function (e) {

        let hs = $(this).hasClass("selAnl")
        let id = $(this).attr("id")

        if (!hs) {
            $(".rt input").removeClass("selAnl")
            $(".rt label").removeClass("selP")
            $("#" + id).next().addClass("selP")
            $(this).addClass("selAnl")
            $(this).prop("checked", true)

            let anlRtype = $(this).val();

            if (anlRtype === "singleAnl") {
                $(".startAnl p").html("Go to")
                $(".endAnl").detach()
                console.log(anlRtype);
            } else if (anlRtype === "doubleAnl") {
                $(".startAnl p").html("Start")
                $(".dateThings").append(endAnl);
                console.log(anlRtype);

            }


        } else {

        }





    });


    let month = ['   Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec   '];
    let week = ['   Mon', 'Tue', 'Wed', 'Thu', 'Selected', 'Sat', 'Sun   '];



    let itemdataweek;

    let itemdatamonth;


    $("#itemAnalyticalData").on("click", "ol", function (e) {
        e.preventDefault();



        let hs = $(this).hasClass("NOL")

        if (!hs) {
            $(".analytics .data_presentation_wrap").detach();

            $("#itemAnalyticalData ol").removeClass("NOL");
            $(this).addClass("NOL");
            bdcontt = $(this).find(".bdcontt").detach();
            $(this).find(".contIn").append(bdcontt);

            $(this).append(data_presentation_wrap);
            $("#itemAnalyticalData .btt button").removeClass("onSt");
            $(this).find("#week").addClass("onSt")


            $(".analytics .data_presentation_wrap").show();
            let chart = `<canvas id="itemdataweek"></canvas><canvas id="itemdatamonth"></canvas>`
            $("#itemAnalyticalData .dataChartEach").html(chart);
            itemdatamonth = createChart("month");
            $("#itemdatamonth").hide();
            itemdataweek = createChart("week");


        }




    });



    $(".analytics").on("click", ".btt button", function (e) {
        e.preventDefault();
        e.stopPropagation();

        let hs = $(this).hasClass("onSt")
        let id = $(this).attr("id")

        if (!hs) {
            $(".btt button").removeClass("onSt");
            $(this).addClass("onSt");

            if (id === "week") {
                console.log(1);
                $("#itemdataweek").show();
                $("#itemdatamonth").hide();


            } else if (id === "month") {
                console.log(2);
                $("#itemdatamonth").show();
                $("#itemdataweek").hide();

            }


        }

    });
    $(".analytics").on("click", ".btt #rmX", function (e) {
        e.preventDefault();
        e.stopPropagation();
        console.log(45454);

        $("#itemAnalyticalData ol").removeClass("NOL");
        $(".analytics .data_presentation_wrap").detach();
        $(this).closest(".ssum").find(".bdcontt").detach();
        $(this).closest(".ssum").append(bdcontt);


    });

    $(".menuBody").on("click", "#updateAnl", function (e) {
        e.preventDefault();
        let itemtype = $(".onRank").attr("id")
        let order = $(".onOrdered").attr("id")
        let rtype = $('.rt input[name="rTypeAnl"]:checked').val()

        let data = $(".onDataType").attr("id")
        let from = $('.startAnl input[name="fromAnl"]').val()

        let to = ""
        if (rtype === "doubleAnl") {
            to = $('.endAnl input[name="toR"]').val()
        }
        getItems(itemtype, order, rtype, data, from, to)

    });






    function getItems(itemtype, order, rTypeAnl, data, from, to) {
        formData = new FormData()
        formData.append('transac', 'getItems')
        formData.append('itemtype', itemtype)
        formData.append('data', data)
        formData.append('order', order)
        formData.append('rTypeAnl', rTypeAnl)
        formData.append('from', from)
        formData.append('to', to)

        $.ajax({
            type: 'POST',
            url: '../Views/reportsView.php',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                $('#itemAnalyticalData').html(response.item);
                $('#itemAnalyticalData').children().hide();
                $('#itemAnalyticalData').children().each(function (index) {
                    $(this).delay(index * 100).fadeIn(200);
                });
                $(".anlerr").html("")
            }, error: function (xhr) {
                const errorMessage = xhr.responseJSON?.error || '';
                $(".anlerr").html(errorMessage);
            }
        });
    }



    function createChart(range) {
        let chartNgiao;

        if (range === "week") {
            return new Chart("itemdataweek", {
                type: "line",
                outLineColor: "rgb(255 0 89 / 80%)",
                data: {
                    labels: week,
                    datasets: [{
                        label: 'This week',
                        data: [30, 20, 600, 250, 250, 82, 10],
                        //   data: [],
                        borderColor: "rgb(0 226 255 / 80%)",
                        fill: false
                    }, {
                        label: 'Last week',
                        data: [45, 500, 230, 105, 180, 495, 840],
                        //   data: [],
                        borderColor: "rgb(255 0 89 / 80%)",
                        fill: false
                    }]
                },
                options: {
                    legend: { display: true },
                    scales: {
                    }
                }
            });
        } else if (range === "month") {
            return new Chart("itemdatamonth", {
                type: "line",
                outLineColor: "rgb(255 0 89 / 80%)",
                data: {
                    labels: month,
                    datasets: [{
                        label: 'This year',
                        data: [30, 20, 600, 250, 250, 82, 10, 55, 600, 200, 360, 2500],
                        //   data: [],
                        borderColor: "rgb(0 226 255 / 80%)",
                        fill: false
                    }, {
                        label: 'Last year',
                        data: [45, 500, 230, 105, 180, 495, 800, 1230, 600, 845, 950, 67],
                        //   data: [],
                        borderColor: "rgb(255 0 89 / 80%)",
                        fill: false
                    }]
                },
                options: {
                    legend: { display: true },
                    scales: {
                    }
                }
            });
        }



        // return chartNgiao;
    }


    function sTrForm(act, own) {


        if (!own) {

            if (act === "x") {
                $(".trace_form").removeClass("Ntrace_form")
            } else {
                $(".trace_form").addClass("Ntrace_form")
            }
        } else {
            if (act === "x") {
                $(".menuBodyAsNgiao22").css("right", "-23rem")
                $(".menuBodyAsNgiao").removeClass("menuBodyAsNgiao22")
            } else {
                $(".menuBodyAsNgiao").addClass("menuBodyAsNgiao22")
                $(".menuBodyAsNgiao22").css("right", "1rem")
            }

        }
    }
});