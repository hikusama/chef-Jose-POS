

$(document).ready(function () {








    let dcPie = new Chart("discount_pie_ChartD", {
        type: "pie",
        data: {
            labels: ["Today", "Yesterday"],
            datasets: [{
                backgroundColor: ["rgb(0 226 255 / 80%)", "rgb(255 0 89 / 80%)"],
                data: [50, 70]
            }]
        }
    });


    let pmMPie = new Chart("pmethod_pie_ChartD", {
        type: "pie",
        data: {
            labels: ["Cash", "G-Cash"],
            datasets: [{
                backgroundColor: ["rgb(0 226 255 / 80%)", "rgb(255 0 89 / 80%)"],
                data: [50, 70]
            }]
        }
    });
    


    const type = ['   Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun   '];

    let salesTodaysSection = new Chart("todSalesLineChart", {
        type: "line",
        outLineColor: "rgb(255 0 89 / 80%)",
        data: {
            labels: type,
            datasets: [{
                label: 'This week',
                data: [350, 50, 80, 50, 100, 20,420],
                borderColor: "rgb(0 226 255 / 80%)",
                fill: false
            }, {
                label: 'Last week',
                data: [50, 30, 80, 45, 75, 40,310],

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
                data: [350, 50, 80, 50, 100, 20,420],
                // data: [],
                borderColor: "rgb(0 226 255 / 80%)",
                fill: false
            }, {
                label: 'Last week',
                data: [50, 30, 80, 45, 75, 40,310],

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
            labels: ["  Snacks","Drinks","Desert","Beverages","Coffee","Milk tea","Pizza  "],
            datasets: [{
                label: 'Category',
                data:cat,
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
                data: [350, 50, 80, 50, 100, 20,420],
                // data: [],
                borderColor: "rgb(0 226 255 / 80%)",
                fill: false
            }, {
                label: 'Last week',
                data: [50, 30, 80, 45, 75, 40,310],

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

    let csdcPie = new Chart("cs_discount_pie_ChartD", {
        type: "pie",
        data: {
            labels: ["Present", "Last day"],
            datasets: [{
                backgroundColor: ["rgb(0 226 255 / 80%)", "rgb(255 0 89 / 80%)"],
                data: [50, 70]
            }]
        }
    });
    let cspmMPie = new Chart("cs_pmethod_pie_ChartD", {
        type: "pie",
        data: {
            labels: ["Cash", "G-Cash"],
            datasets: [{
                backgroundColor: ["rgb(0 226 255 / 80%)", "rgb(255 0 89 / 80%)"],
                data: [50, 70]
            }]
        }
    });


    let cssalesTodaysSection = new Chart("csSalesLineChart", {
        type: "line",
        outLineColor: "rgb(255 0 89 / 80%)",
        data: {
            labels: type,
            datasets: [{
                label: 'Current week',
                data: [350, 50, 80, 50, 100, 20,420],
                borderColor: "rgb(0 226 255 / 80%)",
                fill: false
            }, {
                label: 'Last week',
                data: [50, 30, 80, 45, 75, 40,310],

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

    let csordersTodaysSection = new Chart("csOrdLineChart", {
        type: "line",
        outLineColor: "rgb(255 0 89 / 80%)",
        data: {
            labels: type,
            datasets: [{
                label: 'Current week',
                data: [350, 50, 80, 50, 900, 2000,4200],
                // data: [],
                borderColor: "rgb(0 226 255 / 80%)",
                fill: false
            }, {
                label: 'Last week',
                data: [50, 30, 80, 45, 75, 40,310],

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

    let cscat = [350, 50, 80, 50, 100, 20, 420];
    const bgC = rndColor(cscat.length)

    let cscatTodaysSection = new Chart("csCatBarChart", {
        type: "bar",
        outLineColor: "rgb(255 0 89 / 80%)",
        data: {
            labels: ["  Snacks","Drinks","Desert","Beverages","Coffee","Milk tea","Pizza  "],
            datasets: [{
                label: 'Category',
                data: cscat,
                // data: [],
                backgroundColor: bgC,
                fill: false,
            }]
        },
        options: {
            legend: { display: true },
            scales: {

            }
        }
    });


    let csdcTodaysSection = new Chart("csDcLineChart", {
        type: "line",
        outLineColor: "rgb(255 0 89 / 80%)",
        data: {
            labels: type,
            datasets: [{
                label: 'Current week',
                data: [350, 50, 80, 50, 100, 20,420],
                // data: [],
                borderColor: "rgb(0 226 255 / 80%)",
                fill: false
            }, {
                label: 'Last week',
                data: [50, 30, 80, 45, 75, 40,310],

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