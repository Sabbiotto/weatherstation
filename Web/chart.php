<?php 
    header('Content-Type: application/json');
    $conn = mysqli_connect("localhost", "root", "pwd-G0", "weatherstation");
    $sql = "SELECT temperature,humidity,timestamp FROM data ORDER BY ID ASC LIMIT 150";
    $result = mysqli_query($conn, $sql);
    $rows = array();
    while($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }
    $result->close();
    mysqli_close($conn);
    $json = json_encode($rows);
    print $json;
?>


