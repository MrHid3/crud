<?php
    $db_server = "127.0.0.1";
    $db_user = "root";
    $db_password = "";
    $db_name = "niegotki";
    $conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);

    if($conn){
        $query = mysqli_prepare($conn, "SELECT * FROM gotki");
        mysqli_stmt_execute($query);
        $result = mysqli_stmt_get_result($query);
        $arr = mysqli_fetch_all($result);
        echo json_encode($arr);
    }
?>