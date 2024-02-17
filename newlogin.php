<?php
session_start();

// Database connection details
$host = "localhost";
$dbname = "login";
$username = "root";
$password = "";

// Establish database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve input from login form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Prepare SQL statement to fetch user data
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify if user exists and password is correct
    if ($user && password_verify($password, $user["password"])) {
        // Authentication successful
        $_SESSION["username"] = $user["username"];
        $_SESSION["password"] = $user["password"];
        // Redirect user to dashboard or any authenticated page
        header("Location: homepage.php");
        exit();
    } else {
        // Authentication failed
        $error_message = "Invalid username or password";
    }
}
function is_username_wrong(array|bool $result){
    if(!$result) {
     return true;
    }else{
     return false;   
    }
 }
 
 // checks if password is wrong
 function is_password_wrong(string $pwd, string $hashedPwd){
     if(!password_verify($pwd,$hashedPwd)) {
      return true;
     }else{
      return false;   
     }
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Login</header>
            <?php if(isset($error_message)) { ?>
        <p><?php echo $error_message; ?></p>
    <?php } ?>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="field input">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
            </div>

            <div class="field input">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="field input">
                <input type="submit" class="btn" value="login" required>
            </div>

            <div class="links">
                Don't have an account?<a href="newregister.html">Sign Up</a>
            </div>
        </form>
        </div>
    </div>
</body>
</html>