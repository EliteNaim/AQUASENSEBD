<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - AquaSense</title>
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #00aaff, #aaffcc);
            margin: 0;
            padding: 0;
        }

        /* Header Styling */
        header {
            background-color: #007BFF;
            color: white;
            text-align: center;
            padding: 40px 20px;
            width: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            font-size: 36px;
            margin: 0;
            font-weight: bold;
        }

        /* Dashboard Content Styling */
        .container {
            width: 100%;
            max-width: 800px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            margin: 50px auto;
        }

        h2 {
            text-align: center;
            font-size: 22px;
            color: #333;
            margin-bottom: 20px;
        }

        .user-info {
            margin-bottom: 20px;
            text-align: center;
            font-size: 18px;
        }

        .user-info p {
            margin: 5px 0;
        }

        .button-container {
            text-align: center;
        }

        button {
            padding: 12px 20px;
            background-color: #007BFF;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #005bb5;
        }

        /* Footer Styling */
        footer {
            background-color: #007BFF;
            color: white;
            text-align: center;
            padding: 15px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 12px;
        }

        footer a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        footer a:hover {
            color: #ffcc00;
        }

    </style>
</head>
<body>

    <!-- Header -->
    <header>
        <h1>Welcome to AquaSense, <?php echo $_SESSION['username']; ?>!</h1>
        <p>Your trusted partner in sustainable aquaculture</p>
    </header>

    <!-- Dashboard Content -->
    <div class="container">
        <h2>Your Dashboard</h2>

        <div class="user-info">
            <p><strong>Username:</strong> <?php echo $_SESSION['username']; ?></p>
            <p><strong>Mobile Number:</strong> <?php echo $_SESSION['mobile']; ?></p>
        </div>

        <!-- Content area where the user can manage their ponds and other details -->
        <div class="button-container">
            <button onclick="window.location.href='manage_ponds.php'">Manage Your Ponds</button>
        </div>
    </div>

    <!-- Logout Button -->
    <div class="button-container">
        <form action="logout.php" method="POST">
            <button type="submit">Logout</button>
        </form>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 AquaSense</p>
        <p><a href="/privacy">Privacy Policy</a> | <a href="/terms">Terms of Service</a></p>
    </footer>

</body>
</html>
