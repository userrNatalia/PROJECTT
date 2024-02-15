<?php 

$con = mysqli_connect("localhost","root","","register/signup") or die("Couldn't connect");

echo"Welcome Onboard Farmer";

?>

<?php
// Database connection parameters
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "register/signup"; 
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["register"])) {
        // Registration form submitted
        $username = $_POST["username"];
        $email = $_POST["email"];
        $age = $_POST["age"];
        $password = $_POST["password"];

        // Hash the password before storing it in the database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and bind SQL statement for registration
        $stmt = $conn->prepare("INSERT INTO users (username, email, age, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $username, $email, $age, $hashed_password);

        // Execute SQL statement
        if ($stmt->execute() === TRUE) {
            echo "Registration successful";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } elseif (isset($_POST["login"])) {
        // Login form submitted
        $username = $_POST["login_username"];
        $password = $_POST["login_password"];

        // SQL query for login
        $sql = "SELECT * FROM userrs WHERE username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row["password"])) {
                echo "Login successful";
            } else {
                echo "Invalid username or password";
            }
        } else {
            echo "Invalid username or password";
        }
    }
}

// Close connection
$conn->close();
?>
