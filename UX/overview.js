$(document).ready(function () {

  const currYr = new Date().getFullYear()

  let samp = (currYr - 1).toString() + " - " + currYr.toString()

  $(".mnt").next().append(samp);


  countOrders()
  graphMonthData()
  getPieData()
  getSales()
  getTopProd()
  getDiscount()

  const ctx = document.getElementById('myBarChart');

  // const type = ['   1st', '2nd', '3rd', '4rth'];
  const type = ['   Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec   '];

  let monthData = new Chart("myBarChart", {
    type: "line",
    outLineColor: "rgb(255 0 89 / 80%)",
    data: {
      labels: type,
      datasets: [{
        label: 'This year',
        // data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        data: [],
        borderColor: "rgb(0 226 255 / 80%)",
        fill: false
      }, {
        label: 'Last year',
        // data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        data: [],
        borderColor: "rgb(255 0 89 / 80%)",
        fill: false
      }]
    },
    options: {
      legend: { display: true },
      scales: {
        x: { title: { display: true, text: 'Months' } },
        y: { title: { display: true, text: 'Amount' } }
      }
    }
  });

  let pieChartWk = new Chart("pieChartWk", {
    type: "pie",
    data: {
      labels: ["This week", "Last Week"],
      datasets: [{
        backgroundColor: ["rgb(0 226 255 / 80%)", "rgb(255 0 89 / 80%)"],
        data: [50, 70]
      }]
    }
  });

  let pieChartD = new Chart("pieChartD", {
    type: "pie",
    data: {
      labels: ["Today", "Yesterday"],
      datasets: [{
        backgroundColor: ["rgb(0 226 255 / 80%)", "rgb(255 0 89 / 80%)"],
        data: [80, 10]
      }]
    }
  });




  function countOrders() {


    formData = new FormData()
    formData.append('transac', 'countOrders')

    $.ajax({
      type: 'POST',
      url: '../Views/overviewView.php',
      data: formData,
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function (response) {


        $(".data-TD").html(response.today);
        $(".data-WK").html(response.thisweek);
        $(".data-A").html(response.total);
        $(".data-FLD").html(response.fromlastday);
        $(".data-FLW").html(response.fromlastweek);

      }, error: function (xhr, status, error) {

      }
    });

  }



  function graphMonthData() {



    formData = new FormData()
    formData.append('transac', 'graphMonthData')

    $.ajax({
      type: 'POST',
      url: '../Views/overviewView.php',
      data: formData,
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function (response) {

        monthData.data.datasets[0].data = response.thisYear;
        monthData.data.datasets[1].data = response.lastYear;
        monthData.update()

        $(".highCur p").html("₱" + response.maxThisYear.toString());
        $(".lowCur p").html("₱" + response.minThisYear.toString());
        $(".highLast p").html("₱" + response.maxLastYear.toString());
        $(".lowLast p").html("₱" + response.minLastYear.toString());
      }, error: function (xhr, status, error) {

      }
    });
  }




  function getPieData() {

    formData = new FormData()
    formData.append('transac', "piesData")

    $.ajax({
      type: 'POST',
      url: '../Views/overviewView.php',
      data: formData,
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function (response) {
        pieChartD.data.datasets[0].data = [response.today_total, response.yesterday_total]
        pieChartWk.data.datasets[0].data = [response.thisweek, response.lastweek]

        pieChartWk.update()
        pieChartD.update()
      }, error: function (xhr, status, error) {

      }
    });

  }



  function getSales() {

    formData = new FormData()
    formData.append('transac', "salesData")

    $.ajax({
      type: 'POST',
      url: '../Views/overviewView.php',
      data: formData,
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function (response) {

        $(".tdSales").html("₱" + response.today_total);
        $(".tmSales").html("₱" + response.thismonth);
        $(".ttlSales").html("₱" + response.total);

      }, error: function (xhr, status, error) {

      }
    });

  }
  function getDiscount() {

    formData = new FormData()
    formData.append('transac', "discountData")

    $.ajax({
      type: 'POST',
      url: '../Views/overviewView.php',
      data: formData,
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function (response) {

        $(".dstSales").html("₱" + response.today_total);
        $(".dstmSales").html("₱" + response.thismonth);
        $(".dsttlSales").html("₱" + response.total);

      }, error: function (xhr, status, error) {

      }
    });

  }


  function getTopProd() {

    formData = new FormData()
    formData.append('transac', "getTopProd")

    $.ajax({
      type: 'POST',
      url: '../Views/overviewView.php',
      data: formData, 
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function (response) {

        $(".data-top-products").html(response.prod);

      }, error: function (xhr, status, error) {

      }
    });

  }



});
