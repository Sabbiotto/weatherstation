<?php
    function connection($dbuser, $dbpass, $dbname){
        $conn = mysqli_connect("localhost", $dbuser, $dbpass, $dbname);
        return $conn;
    }

    $resultsPerPage = 30;

    function select($dbuser, $dbpass,$dbname, $table){
        if (isset($_GET["page"])){ 
            $page  = $_GET["page"];
        } else {
            $page=1;
        };
        
        $startFrom = ($page-1) * $GLOBALS["resultsPerPage"];
        $conn = connection($dbuser, $dbpass, $dbname);
        $sql = "SELECT * FROM data ORDER BY ID DESC LIMIT $startFrom, ". $GLOBALS["resultsPerPage"];
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;
    }

    function getTotal($dbuser, $dbpass, $dbname, $table){
        $conn = connection($dbuser, $dbpass, $dbname);
        $sql = "SELECT COUNT(ID) AS total FROM $table";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $totalPages = ceil($row["total"] / $GLOBALS["resultsPerPage"]);
        mysqli_close($conn);
        return $totalPages;
    }

    function insert($dbname, $dbuser, $dbpass, $table, $temperature, $humidity){
        $conn = connection($dbuser, $dbpass, $dbname);
        $sql = "INSERT INTO $table (temperature, humidity) VALUES ('$temperature', '$humidity')";
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;
    }

    //make a function that modyfies the element value when the name is time in the database
    function update($dbname, $dbuser, $dbpass, $table, $name, $value){
        $conn = connection($dbuser, $dbpass, $dbname);
        $sql = "UPDATE $table SET $name = '$value' WHERE ID = 1";
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        return $result;
    }
?>