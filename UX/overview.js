$(document).ready(function () {
    const ctx = document.getElementById('myBarChart');

    const type = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];

    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: type,
            datasets: [{
                label: 'Monthly Income',
                data: [12, 19, 3, 5, 2, 3, 7, 10, 6, 8, 9, 4],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',  
                    'rgba(54, 162, 235, 0.2)',  
                    'rgba(255, 206, 86, 0.2)',  
                    'rgba(75, 192, 192, 0.2)',  
                    'rgba(153, 102, 255, 0.2)', 
                    'rgba(255, 159, 64, 0.2)',  
                    'rgba(255, 205, 86, 0.2)',  
                    'rgba(75, 192, 192, 0.2)',  
                    'rgba(201, 203, 207, 0.2)', 
                    'rgba(54, 162, 235, 0.2)',  
                    'rgba(153, 102, 255, 0.2)', 
                    'rgba(255, 99, 132, 0.2)'   
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',   
                    'rgba(54, 162, 235, 1)',   
                    'rgba(255, 206, 86, 1)',   
                    'rgba(75, 192, 192, 1)',   
                    'rgba(153, 102, 255, 1)',  
                    'rgba(255, 159, 64, 1)',   
                    'rgba(255, 205, 86, 1)',   
                    'rgba(75, 192, 192, 1)',   
                    'rgba(201, 203, 207, 1)',  
                    'rgba(54, 162, 235, 1)',   
                    'rgba(153, 102, 255, 1)',  
                    'rgba(255, 99, 132, 1)'    
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
