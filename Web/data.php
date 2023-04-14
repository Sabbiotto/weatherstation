<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Wheather Station Hub</title>
    </head>
    <body>
        <div class="parent">
            <div class="child parent">
                <h1 class="text">Data Registered</h1>
                <div class="text">
                    <form action="data.php" method="POST">
                        Time between mesurements in seconds: <input type="number" name="time">
                        <input type="submit" value="Submit">
                    </form>
                    <?php
                        require_once "functions.php";
                        if (isset($_POST["time"])){
                            $time = $_POST["time"];
                            update("weatherstation", "root", "pwd-G0", "settings", "value", $time);
                        }
                    ?>
                </div>
                <div class="table">
                    <?php
                        require_once "functions.php";
                        $result = select("root", "pwd-G0", "weatherstation", "data");
                        echo "<table id='dataTable' class='text'>";
                        echo "<tr id=tableTOP>";
                        echo "<th>Timestamp</th>";
                        echo "<th>Temperature</th>";
                        echo "<th>Humidity</th>";
                        echo "<th>Dew Point</th>";
                        echo "</tr>";
                        while($row = mysqli_fetch_array($result)){
                            $t= $row['temperature'];
                            $h= $row['humidity'];
                            $thi = ($t*1.8+32)-(0.55-0.0055*$h)*(($t*1.8+32)-58);
                            echo "<tr>";
                            echo "<td>" . $row['timestamp'] . "</td>";
                            echo "<td><p class='temp'>" . $t . "°</p></td>";
                            echo "<td>" . $h . "%</td>";
                            echo "<td>" . $thi . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    ?> 
                </div>
                <div class="text">
                    Page: 
                    <?php
                        require_once "functions.php";
                        $totalPages = getTotal("root", "pwd-G0", "weatherstation", "data");

                        for ($i=1; $i<=$totalPages; $i++) {
                            echo "<a href='data.php?page=".$i."'";
                            if ($i==$GLOBALS["page"])  echo " class='curPage'";
                            echo ">".$i."</a> ";
                        };
                    ?>
                </div>
                <div class="avgs text">
                    <div class="parent child2">
                        Average Day Stats:<div id="averageTempDay"></div>°-<div id="averageHumDay"></div>%<br>
                    </div>
                    <div class="parent child2">
                        Average Month Stats:<div id="averageTempMonth"></div>°-<div id="averageHumMonth"></div>%<br>
                    </div>
                    <div class="parent child2">
                        Average Year Stats:<div id="averageTempYear"></div>°-<div id="averageHumYear"></div>%<br>
                    </div>
                </div>
                <div class="chartContainer">
                    <canvas id="chart"></canvas>
                </div>
            </div>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.js" integrity="sha512-6DC1eE3AWg1bgitkoaRM1lhY98PxbMIbhgYCGV107aZlyzzvaWCW1nJW2vDuYQm06hXrW0As6OGKcIaAVWnHJw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>    
    <script src="./app.js"></script>
    <script src="./script.js"></script>            
</html>