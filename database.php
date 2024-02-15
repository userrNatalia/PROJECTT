<?php 

$servername = "localhost";
$username = "root";
$password = "";
$database = "login";

//create connection
$conn = new mysqli($servername, $username, $password, $database);

//check connection
if ($conn->connect_error) {
    die("Connection Failed: " .$conn->connect_error);
}

//retrieve form data
$username = $_POST['username'];
$email = $_POST['email'];
$age = $_POST['age'];
$password = $_POST['password'];

//insert data into uses table
$sql = ("INSERT into users(username, email, age, password) VALUES ('$username', '$email', '$age', '$password')");

if($conn->query($sql) === TRUE) {
    echo "New record created successfully";
}
else {
    echo "Error: " .$sql . "<br>" .$conn->error;
}
//close connection
$conn->close();
header("Location: homepage.php");
exit();

?>