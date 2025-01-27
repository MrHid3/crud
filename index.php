<!DOCTYPE html>
<html lang="en">
<head>
    <title>gotki</title>
</head>
<style>
    table, tr, td{
        border: 2px solid black;
    }
</style>
</html>
<table>
<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $db_server = "127.0.0.1";
    $db_user = "root";
    $db_password = "";
    $db_name = "niegotki";
    $conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);
    $keys = array();
    if($conn){
        if(isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["sex"]) && isset($_POST["sex2"])){
            try {
                $name = $_POST["name"];
                $surname = $_POST["surname"];
                $sex = $_POST["sex"];
                $sex2 = $_POST["sex2"];

                $query = mysqli_prepare($conn, "insert into gotki (name, surname, sex, moresex) values ('" . $name . "', '" . $surname . "', '" . $sex . "', '" . $sex2 . "')");
                mysqli_stmt_execute($query);
                $result = mysqli_stmt_get_result($query);
            }catch(Exception $e){}
        }
    $query = mysqli_prepare($conn, "SELECT * FROM gotki");
    mysqli_stmt_execute($query);
    $result = mysqli_stmt_get_result($query);
    $arr = mysqli_fetch_all($result);
    for($i = 0; $i < count($arr); $i++) {
        $keys[] = $arr[$i][0];;
    }
    for($i = 0; $i < count($keys); $i++){
        if(isset($_POST[$keys[$i]]) && $_POST[$keys[$i]] == "delete"){
            $query = mysqli_prepare($conn, "delete from gotki where name = '" . $keys[$i] . "'");
            mysqli_stmt_execute($query);
        }else if(isset($_POST[$keys[$i]]) && $_POST[$keys[$i]] == "update" && isset($_POST["nameupdate"]) && isset($_POST["surnameupdate"]) && isset($_POST["sexupdate"]) && isset($_POST["sex2update"])){
            $query = mysqli_prepare($conn, "update gotki set name = '". $_POST["nameupdate"]."', surname = '". $_POST["surnameupdate"]."', sex = '". $_POST["sexupdate"]."', moresex = '". $_POST["sex2update"]."'  where name = '" . $keys[$i] . "'");
            mysqli_stmt_execute($query);
        }
    }

    $query = mysqli_prepare($conn, "SELECT * FROM gotki");
    mysqli_stmt_execute($query);
    $result = mysqli_stmt_get_result($query);
    $arr = mysqli_fetch_all($result);
    echo "<tr>";
    echo "<td>name</td>";
    echo "<td>surname</td>";
    echo "<td>sex</td>";
    echo "<td>sex</td>";
    echo "<td>delete</td>";
    echo "<td>edycja</td>";
    for($i = 0; $i < count($arr); $i++){
        echo "<tr>";
        if(isset($_POST[$keys[$i]]) && $_POST[$keys[$i]] == "edit"){
            echo"<form method='post' action='./index.php'>
            <td><input type='text' name='nameupdate' value='{$arr[$i][0]}'></td>
            <td><input type='text' name='surnameupdate' value='{$arr[$i][1]}'></td>
            <td><input type='text' name='sexupdate' value='{$arr[$i][2]}'></td>
            <td><input type='number' name='sex2update' value='{$arr[$i][3]}'></td>
            <td><input type='submit' value='update' name='{$keys[$i]}'></td>
            </form>";
        }else{
            for($j = 0; $j < count($arr[$i]); $j++){
                echo "<td>".$arr[$i][$j]."</td>";
            }
            $value = $arr[$i][0];
            $keys[] = $value;
            echo "<td><form method='post' action='index.php'><input type='submit' value='delete' name='$value'></form></td>";
            echo "<td><form method='post' action='index.php'><input type='submit' value='edit' name='$value'></form></td>";
        }
        echo "</tr>";
    }
    echo"<form method='post' action='./index.php'>
    <input type='text' name='name' placeholder='name'>
    <input type='text' name='surname' placeholder='surname'>
    <input type='text' name='sex' placeholder='sex'>
    <input type='number' name='sex2' placeholder='0'>
    <input type='submit' value='submit'>
    </form>";
}
?>

</table>
