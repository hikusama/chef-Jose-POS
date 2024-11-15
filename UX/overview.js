$(document).ready(function () {
  const ctx = document.getElementById('myBarChart');

  // const type = ['   1st', '2nd', '3rd', '4rth'];
  const type = ['   Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec   '];

  var myLineChart = new Chart("myBarChart", {
    type: "line",
    outLineColor: "rgba(255, 99, 132, 0.4)",
    data: {
      labels: type,
      datasets: [{
        label: 'This year',
        data: [860, 1140, 1060, 1060, 1070, 1110, 1330, 2210, 7830, 2478],
        borderColor: "rgba(54, 162, 235, .8)",
        fill: false
      }, {
        label: 'Last year',
        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        borderColor: "rgba(255, 99, 132, 0.4)",
        fill: false
      }]
    },
    options: {
      legend: { display: false },

    }
  });

  var pieChartWk = new Chart("pieChartWk", {
    type: "pie",
    data: {
      labels: ["This week","Last Week"],
      datasets: [{
        backgroundColor: ["rgba(54, 162, 235, .8)","rgba(255, 99, 132, 0.4)"],
        data: [50,70]
      }]
    }
  });

  var pieChartD = new Chart("pieChartD", {
    type: "pie",
    data: {
      labels: ["Today","Yesterday"],
      datasets: [{
        backgroundColor: ["rgba(54, 162, 235, .8)","rgba(255, 99, 132, 0.4)"],
        data: [80,10]
      }]
    }
  });
 



});
