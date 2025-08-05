<?php
// Show errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// DB connection info
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Aquasense";

// Connect
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Only handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input
    $name = trim($_POST['name']);
    $mobile = trim($_POST['mobile']);
    $password = $_POST['password'];
    $gender = trim($_POST['gender']);

    // Basic validation
    if (empty($name) || empty($mobile) || empty($password) || empty($gender)) {
        echo "All fields are required.";
        exit();
    }

    // Check if mobile already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE mobile = ?");
    $stmt->bind_param("s", $mobile);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "This mobile number is already registered. Please login.";
    } else {
        // Encrypt password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (name, mobile, password, gender) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $mobile, $hashedPassword, $gender);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful! Redirecting to login...'); window.location.href='login.html';</script>";
            exit();
        } else {
            echo "Error inserting data: " . $stmt->error;
        }
    }

    $stmt->close();
}

$conn->close();
?>
