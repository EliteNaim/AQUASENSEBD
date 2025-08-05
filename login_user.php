<?php
session_start(); // Start session

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Aquasense";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mobile = trim($_POST['mobile']);
    $password = $_POST['password'];

    // Prepare statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE mobile = ?");
    $stmt->bind_param("s", $mobile);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check user
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            // Successful login
            $_SESSION['name'] = $row['name'];
            $_SESSION['mobile'] = $row['mobile'];
            $_SESSION['user_id'] = $row['user_id'];
            // Success message and redirect
            echo "<script>
                    alert('Login Successful! Redirecting to home page...');
                    window.location.href = 'index.php';
                  </script>";
            exit();
        } else {
            // Wrong password
            echo "<script>alert('Wrong credentials!'); window.location.href='login.html';</script>";
            exit();
        }
    } else {
        // No such mobile number
        echo "<script>alert('Wrong credentials!'); window.location.href='login.html';</script>";
        exit();
    }

    
}

$conn->close();
?>
