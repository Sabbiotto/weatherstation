function changeColor() {
    var tempList = document.getElementsByClassName("temp");
    Array.from(tempList).forEach(function(temp) {
        if (parseInt(temp.innerHTML) > 30) {
            temp.style.color = "red";
        }
        if (parseInt(temp.innerHTML) < 10) {
            temp.style.color = "blue";
        }
    });

}

//make a function that taken the timestamp, the temperature and the humidity from a databas calculates the average temperature and humidity of the last day, week, month and year and returns them as an array
function getAverage() {
    var count=0;
    var date = new Date();
    var month = date.getMonth() + 1;
    var day = date.getDate();
    var year = date.getFullYear();
    var hour = date.getHours();
    var minute = date.getMinutes();
    var second = date.getSeconds();
    var currentTimestamp = year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + second;

    var temp = [];
    var hum = [];

    $.ajax({
        url: "chart.php",
        method: "GET",
        success: function(data) {
            var averageTemp = 0;
            var averageHum = 0;
            for (i in data) {
                if ((new Date(data[i].timestamp).getDate()) == (new Date(currentTimestamp).getDate())) {
                    var temperature = parseInt(data[i].temperature);
                    var humidity = parseInt(data[i].humidity);
                    averageTemp += temperature;
                    averageHum += humidity;
                    count++;
                }
            }
            averageTempDay = averageTemp / count;
            averageHumDay = averageHum / count;
            averageTemp=0;
            averageHum=0;
            count=0;

            for (i in data) {
                if ((new Date(data[i].timestamp).getMonth() + 1) == (new Date(currentTimestamp).getMonth() + 1)) {
                    var temperature = parseInt(data[i].temperature);
                    var humidity = parseInt(data[i].humidity);
                    averageTemp += temperature;
                    averageHum += humidity;
                    count++;
                }
            }
            averageTempMonth = averageTemp / count;
            averageHumMonth = averageHum / count;
            averageTemp=0;
            averageHum=0;
            count=0;

            for (i in data) {
                if ((new Date(data[i].timestamp).getFullYear()) == (new Date(currentTimestamp).getFullYear())) {
                    var temperature = parseInt(data[i].temperature);
                    var humidity = parseInt(data[i].humidity);
                    averageTemp += temperature;
                    averageHum += humidity;
                    count++;
                }
            }
            averageTempYear = averageTemp / count;
            averageHumYear = averageHum / count;
        },
        error: function(data, error) {
            console.log(data, error);
        },
        complete: function() {
            document.getElementById("averageTempDay").innerText = averageTempDay.toFixed(2);
            document.getElementById("averageTempMonth").innerText = averageTempMonth.toFixed(2);
            document.getElementById("averageTempYear").innerText = averageTempYear.toFixed(2);
            document.getElementById("averageHumDay").innerText = averageHumDay.toFixed(2);
            document.getElementById("averageHumMonth").innerText = averageHumMonth.toFixed(2);
            document.getElementById("averageHumYear").innerText = averageHumYear.toFixed(2);
        }
    });
}

changeColor();
getAverage();