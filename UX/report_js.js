$(document).ready(function () {
    const today = new Date().toISOString().split('T')[0]
    let isReqItemAnalOpen = false;

    $("#frD").attr('max', today);
    $("#toD").attr('max', today);

    $("#frAnl").attr('max', today);
    $("#toAnl").attr('max', today);
    let bdcontt
    let data_presentation_wrap = $(".analytics .data_presentation_wrap").detach();

    // const samp = new Date();

    // // let samp = (currYr - 1).toString() + " - " + currYr.toString()

    // $(".recordDate").html(samp.getMonth() + "/" + samp.getDate() + "/" + samp.getFullYear());
    $(".recordDate").html("Select date first.");
    $(".dateAnalytics").html(today);

    getItems("proddR", "highest", "singleAnl", "sales-data", today, "", 1)


    // let graphPitem = $(".graphNgiao");
    // let tablePitem = $(".table-data").detach();


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
            } else if (anlRtype === "doubleAnl") {
                $(".startAnl p").html("Start")
                $(".dateThings").append(endAnl);

            }


        } else {

        }





    });


    let month = ['   Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec   '];
    let week = ['   Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun   '];



    let itemdataweek;

    let itemdatamonth;


    $("#itemAnalyticalData").on("click", "ol", function (e) {
        e.preventDefault();

        let rtype = $('.rt input[name="rTypeAnl"]:checked').val()


        if (rtype === "doubleAnl") {
            to = $('.endAnl input[name="toR"]').val()
            if (!to) {
                return;
            }
        }

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



            //pass
            let itemtype = $(".onRank").attr("id")
            let rtype = $('.rt input[name="rTypeAnl"]:checked').val()

            let data = $(".onDataType").attr("id")
            let from = $('.startAnl input[name="fromAnl"]').val()
            from = (from) ? from : today
            let id = $(this).find(".picMhen img").attr("id")
            let to = ""
            if (rtype === "doubleAnl") {
                to = $('.endAnl input[name="toR"]').val()
            }

            getItemAnal(id, itemtype, rtype, data, from, to)


        }




    });


    $("#itemAnalyticalData").on("click", ".main-dir-link button", function (e) {
        let page = $(this).attr("id")

        let itemtype = $(".onRank").attr("id")
        let order = $(".onOrdered").attr("id")
        let rtype = $('.rt input[name="rTypeAnl"]:checked').val()

        let data = $(".onDataType").attr("id")
        let from = $('.startAnl input[name="fromAnl"]').val()
        if (!from) {
            from = today
        }

        let to = ""
        if (rtype === "doubleAnl") {
            to = $('.endAnl input[name="toR"]').val()
        }
        if (page != "pageON") {
            getItems(itemtype, order, rtype, data, from, to, page)

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
                $("#itemdataweek").show();
                $("#itemdatamonth").hide();


            } else if (id === "month") {
                $("#itemdatamonth").show();
                $("#itemdataweek").hide();

            }


        }

    });

    $(".middle_side").on("input", "#findItem input", function (e) {
        e.preventDefault();
        let search = $(this).val()
        let page = $(".middle_side #pageON").html()
        let itemtype = $(".onRank").attr("id")
        let order = $(".onOrdered").attr("id")
        let rtype = $('.rt input[name="rTypeAnl"]:checked').val()

        let data = $(".onDataType").attr("id")
        let from = $('.startAnl input[name="fromAnl"]').val()

        if (!from) {
            from = today
        }

        let to = ""
        if (rtype === "doubleAnl") {
            to = $('.endAnl input[name="toR"]').val()
            dateNg = from + " - " + to
            $(".dateAnalytics").html(dateNg);
        } else {
            $(".dateAnalytics").html(from);

        }


        getItems(itemtype, order, rtype, data, from, to, 1, search)
    });

    $(".middle_side").on("click", ".showThings", function (e) {
        e.preventDefault();
        hs = $(this).parent().hasClass('hidePart')

        if (hs) {
            $(".todays-report").addClass('hidePart')
            $(".cstmRp").addClass('hidePart')
            $(".showThings h5").html('<i class="fas fa-arrow-left"></i> <p>Show more</p> <i class="fas fa-arrow-right"></i>')

            $(this).parent().removeClass('hidePart')
            $(this).find('h5').html('<i class="fas fa-arrow-right"></i> <p>Show less</p> <i class="fas fa-arrow-left"></i>')
            console.log(55);


        } else {
            $(".showThings h5").html('<i class="fas fa-arrow-left"></i> <p>Show more</p> <i class="fas fa-arrow-right"></i>')
            $(".todays-report").addClass('hidePart')
            $(".cstmRp").addClass('hidePart')
        }



    })
    $(".analytics").on("click", ".btt #rmX", function (e) {
        e.preventDefault();
        e.stopPropagation();

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
            dateNg = from + " - " + to
            $(".dateAnalytics").html(dateNg);
        } else {
            $(".dateAnalytics").html(from);

        }


        getItems(itemtype, order, rtype, data, from, to, 1)


    });



    $('#todayRecordPDF').click(function () {
        const today = new Date().toISOString().split('T')[0]

        $.ajax({
            url: '../Views/generate_pdf.php',
            type: 'POST',
            data: {
                transac : "todayReports",
                start : today
            },
            xhrFields: {
                responseType: 'blob',
            },
            success: function (data) {
                // Create a download link for the PDF
                const blob = new Blob([data], { type: 'application/pdf' });
                const link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'chefJose' + today + '.pdf';
                link.click();
                window.URL.revokeObjectURL(link)
            },
            error: function () {
                alert('Failed to generate PDF.');
            }
        });
    });


    $('#exportPdfCD').click(function () {
        let fdate = $("#frD").val() 
        let toD = $("#toD").val() 

        
        const today = new Date().toISOString().split('T')[0]

        let formData = new FormData()
        
        formData.append('transac', 'todayReports')
        if (fdate == "") {
            formData.append('start', today)
        }else{
            formData.append('start', fdate)
            if (toD != "") {
                formData.append('end', toD)
            }
        }
        console.log(fdate);
        console.log(toD);
        $.ajax({
            url: '../Views/generate_pdf.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            xhrFields: {
                responseType: 'blob',
            },
            success: function (data) {
                // Create a download link for the PDF
                const blob = new Blob([data], { type: 'application/pdf' });
                const link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'chefJose' + today + '.pdf';
                link.click();
                window.URL.revokeObjectURL(link)
            },
            error: function () {
                alert('Failed to generate PDF.');
            }
        });
    });






    function rtype(t) {

        if (t === "singleAnl") {
            $(".graphNgiao").show();
            $(".table-data").hide();
            let chart = `<canvas id="itemdataweek"></canvas><canvas id="itemdatamonth"></canvas>`
            $("#itemAnalyticalData .dataChartEach").html(chart);
            itemdatamonth = createChart("month");
            $("#itemdatamonth").hide();
            itemdataweek = createChart("week");
        } else {

            $(".graphNgiao").hide();
            $(".table-data").show();
        }
        $(".analytics .data_presentation_wrap").show();

    }
    function getItems(itemtype, order, rTypeAnl, data, from, to, page, search = "") {
        isReqItemAnalOpen = false;
        formData = new FormData()
        formData.append('transac', 'getItems')
        formData.append('itemReqType', 'itemWdata')
        formData.append('search', search)
        formData.append('page', page)
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

                isReqItemAnalOpen = true;
                $("#bkAnl").trigger("click");
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


    function getItemAnal(id, itemtype, rTypeAnl, data, from, to) {

        if (isReqItemAnalOpen) {

            isReqItemAnalOpen = false;
            formData = new FormData()
            formData.append('transac', 'getItems')
            formData.append('itemReqType', 'itemAnal')
            formData.append('itemtype', itemtype)
            formData.append('data', data)
            formData.append('rTypeAnl', rTypeAnl)
            formData.append('from', from)
            formData.append('to', to)
            formData.append('itemID', id)
            $.ajax({
                type: 'POST',
                url: '../Views/reportsView.php',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    isReqItemAnalOpen = true;
                    if (response.rangeType == "singleAnl") {
                        rtype("singleAnl")

                        itemdataweek.data.datasets[0].data = response.tw
                        itemdataweek.data.datasets[1].data = response.lw

                        itemdatamonth.data.datasets[0].data = response.tm
                        itemdatamonth.data.datasets[1].data = response.lm

                        itemdataweek.update()
                        itemdatamonth.update()
                    } else {

                        rtype("doubleAnl")
                        $(".ddtit").html(response.dataType)
                        st = new Date(from)
                        en = new Date(to)
                        rd = (en - st) / (1000 * 60 * 60 * 24);

                        $(".daytd").html(rd + "D")
                        $(".datertd").html(response.range)
                        if (response.dataType === "Orders") {
                            $(".datatd").html(response.slsum)
                        } else {
                            $(".datatd").html("₱" + response.slsum)
                        }

                    }
                }, error: function (xhr) {
                    const errorMessage = xhr.responseJSON?.error || '';
                    // $(".anlerr").html(errorMessage);
                }
            });


        }

    }


    function createChart(range) {

        if (range === "week") {
            return new Chart("itemdataweek", {
                type: "line",
                outLineColor: "rgb(255 0 89 / 80%)",
                data: {
                    labels: week,
                    datasets: [{
                        label: 'Selected week',
                        data: [0, 0, 0, 0, 0, 0, 0],
                        //   data: [],
                        borderColor: "rgb(0 226 255 / 80%)",
                        fill: false
                    }, {
                        label: 'Week before',
                        data: [0, 0, 0, 0, 0, 0, 0],
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
                        label: 'Selected year',
                        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        //   data: [],
                        borderColor: "rgb(0 226 255 / 80%)",
                        fill: false
                    }, {
                        label: 'Year before',
                        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
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