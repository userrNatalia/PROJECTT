<?php
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "signup";
$conn = "";


    $conn =mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    if (!$conn) {
        die("Something went wrong: " . mysqli_connect_error()); 
    }

?>

