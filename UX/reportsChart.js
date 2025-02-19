

$(document).ready(function () {


    getSQD()
    getTCatData()
    getTLineChartData()




    let dcPie = new Chart("discount_pie_ChartD", {
        type: "pie",
        data: {
            labels: ["Today", "Yesterday"],
            datasets: [{
                backgroundColor: ["rgb(0 226 255 / 80%)", "rgb(255 0 89 / 80%)"],
                data: [0, 0]
            }]
        }
    });


    let pmMPie = new Chart("pmethod_pie_ChartD", {
        type: "pie",
        data: {
            labels: ["Cash", "G-Cash"],
            datasets: [{
                backgroundColor: ["rgb(0 226 255 / 80%)", "rgb(255 0 89 / 80%)"],
                data: [0, 0]
            }]
        }
    });



    let type = ['   Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun   '];
    let bymonth = ['   Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec   '];

    let salesTodaysSection = new Chart("todSalesLineChart", {
        type: "line",
        outLineColor: "rgb(255 0 89 / 80%)",
        data: {
            labels: type,
            datasets: [{
                label: 'This week',
                data: [],
                borderColor: "rgb(0 226 255 / 80%)",
                fill: false
            }, {
                label: 'Last week',
                data: [],

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

    let ordersTodaysSection = new Chart("todOrdLineChart", {
        type: "line",
        outLineColor: "rgb(255 0 89 / 80%)",
        data: {
            labels: type,
            datasets: [{
                label: 'This week',
                data: [],
                // data: [],
                borderColor: "rgb(0 226 255 / 80%)",
                fill: false
            }, {
                label: 'Last week',
                data: [],

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



    let cat = [350, 50, 80, 50, 100, 20, 420];
    const bg = rndColor(cat.length)

    let catTodaysSection = new Chart("todCatBarChart", {
        type: "bar",
        outLineColor: "rgb(255 0 89 / 80%)",
        data: {
            labels: [],
            datasets: [{
                label: 'Category',
                data: [],
                // data: [],
                backgroundColor: bg,
                // borderColor: "rgb(0 226 255 / 80%)",
                fill: false
            }]
        },
        options: {
            legend: { display: true },
            scales: {

            }
        }
    });


    let dcTodaysSection = new Chart("todDcLineChart", {
        type: "line",
        outLineColor: "rgb(255 0 89 / 80%)",
        data: {
            labels: type,
            datasets: [{
                label: 'This week',
                data: [],
                // data: [],
                borderColor: "rgb(0 226 255 / 80%)",
                fill: false
            }, {
                label: 'Last week',
                data: [],

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




    /*                customized                   */




    $("#tform").on("submit", function (e) {
        e.preventDefault();
        let formData = new FormData(this)
        let dr = $(this).find(".ch").val()
        getCSSQD(formData, dr);
        getCSCatData(formData);
        let rtype = $(".ch").attr("value")
        if (rtype === "single") {
            getCSLineChartData(rtype, "weekcs");
            $("#weekcs").addClass("onSingleD");
        }
        // $(".findBy li").removeClass("onSingleD");
    });

    $("#upTr").click(function (e) {
        e.preventDefault();
        $("#tform").trigger("submit");
    });

    $(".findBy li").click(function (e) {
        e.preventDefault();
        let hs = $(this).hasClass("onSingleD")
        let id = $(this).attr("id")
        let rtype = $(".ch").attr("value")

        if (!hs) {
            $(".findBy li").removeClass("onSingleD");
            $(this).addClass("onSingleD");
            getCSLineChartData(rtype, id);
        }


    });




    let csdcPie = new Chart("cs_discount_pie_ChartD", {
        type: "pie",
        data: {
            labels: ["Present", "Last day"],
            datasets: [{
                backgroundColor: ["rgb(0 226 255 / 80%)", "rgb(255 0 89 / 80%)"],
                data: [0, 0]
            }]
        }
    });

    let cspmMPie = new Chart("cs_pmethod_pie_ChartD", {
        type: "pie",
        data: {
            labels: ["Cash", "G-Cash"],
            datasets: [{
                backgroundColor: ["rgb(0 226 255 / 80%)", "rgb(255 0 89 / 80%)"],
                data: [0, 0]
            }]
        }
    });


    let cscatTodaysSection = new Chart("csCatBarChart", {
        type: "bar",
        outLineColor: "rgb(255 0 89 / 80%)",
        data: {
            labels: [],
            datasets: [{
                label: 'Category',
                // data: cscat,
                data: [],
                backgroundColor: [],
                fill: false,
            }]
        },
        options: {
            legend: { display: true },
            scales: {

            }
        }
    });

    let cssalesSection = new Chart("csSalesLineChart", {
        type: "line",
        outLineColor: "rgb(255 0 89 / 80%)",
        data: {
            labels: type,
            datasets: [{
                label: 'Selected week',
                // data: [350, 50, 80, 50, 100, 20, 420],
                data: [],
                borderColor: "rgb(0 226 255 / 80%)",
                fill: false
            }, {
                label: 'Before',
                // data: [50, 30, 80, 45, 75, 40, 310],
                data: [],

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

    let csordersSection = new Chart("csOrdLineChart", {
        type: "line",
        outLineColor: "rgb(255 0 89 / 80%)",
        data: {
            labels: type,
            datasets: [{
                label: 'Selected week',
                data: [],
                // data: [350, 50, 80, 50, 900, 2000, 4200],
                // data: [],
                borderColor: "rgb(0 226 255 / 80%)",
                fill: false
            }, {
                label: 'Before',
                data: [],
                // data: [50, 30, 80, 45, 75, 40, 310],

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




    let csdcSection = new Chart("csDcLineChart", {
        type: "line",
        outLineColor: "rgb(255 0 89 / 80%)",
        data: {
            labels: type,
            datasets: [{
                label: 'Selected week',
                data: [],
                borderColor: "rgb(0 226 255 / 80%)",
                fill: false
            }, {
                label: 'Before',
                data: [],
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

    let nr = `<div class="norec"><i class="fa fa-exclamation-circle"></i><p>No record.</p></div>`;



    function getSQD() {

        formData = new FormData()
        formData.append('transac', "getTSqData")
        $.ajax({
            type: 'POST',
            url: '../Views/reportsView.php',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                dcPie.data.datasets[0].data = response.discount
                pmMPie.data.datasets[0].data = response.pMethod
                $(".orders_line").html(response.todayOrders)
                $(".discount_line").html("₱" + response.todayDiscount)
                $(".sales_line").html("₱" + response.todaySales)
                if (response.discount[0] === 0 && response.discount[1] === 0) {
                    $("#discount_pie_ChartD").parent().append(nr);
                } else {
                    $("#discount_pie_ChartD").parent().find(".norec").detach();
                }
                if (response.pMethod[0] === 0 && response.pMethod[1] === 0) {
                    $("#pmethod_pie_ChartD").parent().append(nr);
                } else {
                    $("#pmethod_pie_ChartD").parent().find(".norec").detach();
                }
                dcPie.update()
                pmMPie.update()

                $(".sttoday").html("₱" + response.todaySales);
                $(".dttoday").html("₱" + response.todayDiscount);
                $(".ottoday").html(response.todayOrders);

                $(".swweek").html("₱" + response.salesweek);
                $(".dwweek").html("₱" + response.discountweek);
                $(".owweek").html(response.ordersweek);

                $(".smmonth").html("₱" + response.salesmonth);
                $(".dmmonth").html("₱" + response.discountmonth);
                $(".ommonth").html(response.ordersmonth);


                let pr = response.rates

                $(".sttrate").html(pr.salesT);
                $(".dttrate").html(pr.discountT);
                $(".ottrate").html(pr.ordersT);

                $(".swrate").html(pr.salesW);
                $(".dwrate").html(pr.discountW);
                $(".owrate").html(pr.ordersW);

                $(".smrate").html(pr.salesM);
                $(".dmrate").html(pr.discountM);
                $(".omrate").html(pr.ordersM);
            }
        });
    }
    /*
                "salesT" => $Std,
                "salesM" => $Stm,
                "salesW" => $Stw,
    
                "discountT" => $Dtd,
                "discountM" => $Dtm,
                "discountW" => $Dtw,
    
                "ordersT" => $Otd,
                "ordersM" => $Otm,
                "ordersW" => $Otw,
            ];
    
    
    */


    function getTCatData() {

        formData = new FormData()
        formData.append('transac', "getTCatData")
        $.ajax({
            type: 'POST',
            url: '../Views/reportsView.php',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                catTodaysSection.data.labels = response.name
                catTodaysSection.data.datasets[0].data = response.sold

                if (response.conf === false) {
                    $("#todCatBarChart").parent().append(nr);
                } else {
                    $("#todCatBarChart").parent().find(".norec").detach();
                }

                catTodaysSection.update()

            }
        });
    }


    function getTLineChartData() {

        formData = new FormData()
        formData.append('transac', "getTWeekData")
        $.ajax({
            type: 'POST',
            url: '../Views/reportsView.php',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                salesTodaysSection.data.datasets[0].data = response.tsales
                dcTodaysSection.data.datasets[0].data = response.tdiscount
                ordersTodaysSection.data.datasets[0].data = response.torders

                salesTodaysSection.data.datasets[1].data = response.lsales
                dcTodaysSection.data.datasets[1].data = response.ldiscounts
                ordersTodaysSection.data.datasets[1].data = response.lorders

                // if (((response.tsales).length == 0) && ((response.lsales).length == 0)) {
                //     $("#todSalesLineChart").parent().append(nr);
                // } else {
                //     $("#todSalesLineChart ").parent().find(".norec").detach();
                // }

                // if (((response.tdiscount).length == 0) && ((response.ldiscounts).length == 0)) {
                //     $("#todDcLineChart").parent().append(nr);
                // } else {
                //     $("#todDcLineChart").parent().find(".norec").detach();
                // }
                // if (((response.torders).length == 0) && ((response.lorders).length == 0)) {
                //     $("#todOrdLineChart").parent().append(nr);
                // } else {
                //     $("#todOrdLineChart").parent().find(".norec").detach();
                // }
                salesTodaysSection.update()
                dcTodaysSection.update()
                ordersTodaysSection.update()

            }
        });
    }

    function checkVal() {

    }
    let txtbaseddata = $(".txtbaseddata");
    let charthings = $(".charthings");


    function getCSSQD(formData, dr) {

        if (dr == "single") {
            $(".typer").append(charthings);
            $(".txtbaseddata").detach()
            $(".sone h3").html("Single range")
        } else if (dr == "double") {
            $(".typer").append(txtbaseddata);
            $(".txtbaseddata").show();
            $(".charthings").detach()
            $(".sone h3").html("Double range")
        }

        formData.append('transac', "getCSSQD")
        $.ajax({
            type: 'POST',
            url: '../Views/reportsView.php',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                if (!response.error) {

                    csdcPie.data.datasets[0].data = response.discount
                    cspmMPie.data.datasets[0].data = response.pMethod
                    $(".cs_orders_line").html(response.todayOrders)
                    $(".cs_discount_line").html("₱" + response.todayDiscount)
                    $(".cs_sales_line").html("₱" + response.todaySales)
                    if (response.discount[0] === 0 && response.discount[1] === 0) {
                        $("#cs_discount_pie_ChartD").parent().append(nr);
                    } else {
                        $("#cs_discount_pie_ChartD").parent().find(".norec").detach();
                    }
                    if (response.pMethod[0] === 0 && response.pMethod[1] === 0) {
                        $("#cs_pmethod_pie_ChartD").parent().append(nr);
                    } else {
                        $("#cs_pmethod_pie_ChartD").parent().find(".norec").detach();
                    }
                    csdcPie.update()
                    cspmMPie.update()
                    $(".er33").html("");
                    if (dr == "double") {
                        st = new Date(formData.get("from"))
                        en = new Date(formData.get("to"))
                        st2 = formData.get("from")
                        en2 = formData.get("to")
                        rd = (en - st) / (1000 * 60 * 60 * 24);
                        $(".Rd").html(rd);
                        $(".Rdr").html(st2 + " - " + en2);
                        $(".Ror").html(response.todayOrders);
                        $(".Rsl").html("₱" + response.todaySales);
                        $(".Rdc").html("₱" + response.todayDiscount);
                    }



                    /*
<td class="Rd">--</td>
                                            <td class="Rdr">-----</td>
                                            <td class="Ror">---</td>
                                            <td class="Rsl">---</td>
                                            <td class="Rdc">


                    */
                } else {
                    $(".er33").html(response.error);
                }
            }
        });
    }

    function getCSCatData(formData) {

        formData.append('transac', "getCSCatData")
        $.ajax({
            type: 'POST',
            url: '../Views/reportsView.php',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                if (!response.error) {

                    cscatTodaysSection.data.labels = response.name
                    cscatTodaysSection.data.datasets[0].data = response.sold
                    cscatTodaysSection.data.datasets[0].backgroundColor = rndColor((response.sold).length)
                    $(".recordDate").html(response.date);
                    if (response.conf == 0) {
                        $("#csCatBarChart").parent().append(nr);
                    } else {
                        $("#csCatBarChart").parent().find(".norec").detach();
                    }
                    cscatTodaysSection.update()
                }



            }
        });
    }



    function getCSLineChartData(rtype, id) {
        formData = new FormData()
        from = $("#frD").val()
        formData.append('type', id)
        formData.append('rtype', rtype)
        formData.append('from', from)
        formData.append('transac', "getCSLineData")
        $.ajax({
            type: 'POST',
            url: '../Views/reportsView.php',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                if (id == "monthcs") {

                    cssalesSection.data.labels = bymonth
                    csdcSection.data.labels = bymonth
                    csordersSection.data.labels = bymonth

                    cssalesSection.data.datasets[0].label = ["Selected year"]
                    csdcSection.data.datasets[0].label = ["Selected year"]
                    csordersSection.data.datasets[0].label = ["Selected year"]

                    cssalesSection.data.datasets[1].label = ["Before"]
                    csdcSection.data.datasets[1].label = ["Before"]
                    csordersSection.data.datasets[1].label = ["Before"]
                } else if (id == "weekcs") {
                    cssalesSection.data.labels = type
                    csdcSection.data.labels = type
                    csordersSection.data.labels = type

                    cssalesSection.data.datasets[0].label = ["Selected week"]
                    csdcSection.data.datasets[0].label = ["Selected week"]
                    csordersSection.data.datasets[0].label = ["Selected week"]

                    cssalesSection.data.datasets[1].label = ["Before"]
                    csdcSection.data.datasets[1].label = ["Before"]
                    csordersSection.data.datasets[1].label = ["Before"]
                }
                cssalesSection.data.datasets[0].data = response.tsales
                csdcSection.data.datasets[0].data = response.tdiscounts
                csordersSection.data.datasets[0].data = response.torders

                cssalesSection.data.datasets[1].data = response.lsales
                csdcSection.data.datasets[1].data = response.ldiscounts
                csordersSection.data.datasets[1].data = response.lorders

                cssalesSection.update()
                csdcSection.update()
                csordersSection.update()

            }
        });





    }



    // function getCSLineChartData(formData) {

    //     formData.append('transac', "getCSLineChartData")
    //     $.ajax({
    //         type: 'POST',
    //         url: '../Views/reportsView.php',
    //         data: formData,
    //         contentType: false,
    //         processData: false,
    //         dataType: 'json',
    //         success: function (response) {
    //             cssalesTodaysSection.data.datasets[0].data = response.tsales
    //             csdcTodaysSection.data.datasets[0].data = response.tdiscount
    //             csordersTodaysSection.data.datasets[0].data = response.torders

    //             cssalesTodaysSection.data.datasets[1].data = response.lsales
    //             csdcTodaysSection.data.datasets[1].data = response.ldiscounts
    //             csordersTodaysSection.data.datasets[1].data = response.lorders

    //             cssalesTodaysSection.update()
    //             csdcTodaysSection.update()
    //             csordersTodaysSection.update()

    //         }
    //     });
    // }


    // const today = new Date().toISOString().split('T')[0]
    // $('#todayRecordPDF').click(function () {
    //     $(this).hide()
    //     dcPie.toBase64Image()
    //     pmMPie.toBase64Image()
    //     catTodaysSection.toBase64Image()
    //     salesTodaysSection.toBase64Image()
    //     dcTodaysSection.toBase64Image()
    //     ordersTodaysSection.toBase64Image()
        
    //     const content = $('.todays-report').html();
    //     $(this).show()

    //     $.ajax({
    //         url: '../Views/generate_pdf.php',
    //         type: 'POST',
    //         data: { html: content },
    //         xhrFields: {
    //             responseType: 'blob',
    //         },
    //         success: function (data) {
    //             // Create a download link for the PDF
    //             const blob = new Blob([data], { type: 'application/pdf' });
    //             const link = document.createElement('a');
    //             link.href = window.URL.createObjectURL(blob);
    //             link.download = 'chefJose' + today + '.pdf';
    //             link.click();
    //         },
    //         error: function () {
    //             alert('Failed to generate PDF.');
    //         }
    //     });
    // });









    function rndColor(size) {
        const colors = [];

        for (let index = 0; index < size; index++) {
            const r = Math.floor(Math.random() * 256)
            const g = Math.floor(Math.random() * 256)
            const b = Math.floor(Math.random() * 256)
            const a = 0.8;
            colors.push(`rgba(${r},${g},${b},${a})`)
        }

        return colors;




    }




});