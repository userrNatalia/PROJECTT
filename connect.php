<?php

$firstName = $_POST['firstName'];
$secondName = $_POST['secondName'];
$email = $_POST['email'];
$password = $_POST['password'];

//database connection
$conn = new mysqli('localhost', 'root', '', 'signup');

//connection error check
if($conn->connect_error) {
    die('Connection Failed : '. $conn->connect_error);
} else {
    echo "Welcome user!";
    //database insertion
    $stmt = $conn->prepare("insert into users(firstName, secondName, email, password) values(?,?,?,?)");
    $stmt->bind_param("ssss", $firstName, $secondName, $email, $password);
    $stmt->execute();
    echo"registration successfully";
    $stmt->close();
    $conn->close();
}

?>