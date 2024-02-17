<?php
/*
session_start(); // Start session for storing user's login state

// Database connection parameters
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "login"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from login form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Prepare and bind SQL statement to retrieve user's details
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Fetch user's details
        $row = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $row["password"])) {
            // Password is correct, set session variables and redirect to dashboard
            $_SESSION["username"] = $username;
            $_SESSION["email"] = $row["email"];
            // Redirect to dashboard or any other page
            header("Location: homepage.php");
            exit();
        } else {
            // Incorrect password
            $error_message = "Incorrect username or password";
        }
    } else {
        // User does not exist
        $error_message = "User does not exist";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();*/


session_start();

// Database connection
$conn = new mysqli('localhost', 'username', 'password', 'database_name');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to authenticate user
function authenticateUser($username, $password, $conn) {
    // Query database for user
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password matches, return user data
            return $row;
        } else {
            // Incorrect password
            return false;
        }
    } else {
        // User not found
        return false;
    }
}

// Check if login form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Authenticate user
    $user = authenticateUser($username, $password, $conn);
    if ($user) {
        // Authentication successful, store user data in session
        $_SESSION['user'] = $user;
        header("Location: homepage.php"); // Redirect to dashboard or another page
        exit();
    } else {
        // Authentication failed, display error message
        $error = "Incorrect username or password";
    }
}


?>
