var temp = [];
var hum = [];
var time = [];
var chartdata = {
    labels: time,
    datasets : [{
        label: 'Temperature',
        backgroundColor: 'rgb(255, 99, 91)',
        borderColor: 'rgb(178, 69, 67)',
        data: temp
    },
    {
        label: 'Humidity',
        backgroundColor: 'rgb(99 , 97, 255)',
        borderColor: 'rgb(69, 67, 178)',
        data: hum
    }]
};

$(document).ready(function() {
    sendRequest();
    function sendRequest() {
        $.ajax({
            url: "chart.php",
            method: "GET",
            success: function(data) {
                for(var i in data) {
                    temp.push(data[i].temperature);
                    hum.push(data[i].humidity);
                    time.push(data[i].timestamp);
                }
                if (typeof myChart == 'undefined') {
                    myChart = new Chart("chart", {
                        type: 'line',
                        data: chartdata,
                        options: {
                            scales: {
                                x: {
                                    ticks:{
                                        display: false
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Time'
                                    },
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                } else {
                    setInterval(updateChart, 5010, data);
                }
            },
            error: function(data, status, error) {
                console.log(error);
            },
        });
    }

    function updateChart(data) {
        sendRequest();
        myChart.data.datasets.forEach((dataset) => {
            dataset.data.push(data);
        });
        myChart.update();
    }
});






