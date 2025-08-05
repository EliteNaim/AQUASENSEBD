<?php
// Start the session
session_start();

// Include the database connection
require_once 'db.php'; // database connection

// Check if the request to get recommendations is made
if (isset($_POST['get_recommendations'])) {
    // Get the location from the POST data
    $location = $_POST['location'];

    // Prepare the SQL query to fetch fish recommendations based on the location
    $stmt = $conn->prepare("SELECT fish_name FROM Fish WHERE location LIKE ?");
    $stmt->bind_param('s', "%$location%");  // Using LIKE to match locations containing the given location
    $stmt->execute();
    
    // Get the result of the query
    $fish_result = $stmt->get_result();
    
    // Initialize an empty array to store fish recommendations
    $fish_recommendations = [];
    
    // Fetch the fish names from the result and store them in the array
    while ($fish_row = $fish_result->fetch_assoc()) {
        $fish_recommendations[] = $fish_row['fish_name'];
    }

    // Return the fish recommendations as a JSON response
    echo json_encode($fish_recommendations);
}
?>
