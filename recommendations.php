<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Aquasense";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$recommendations = [];

// Check if the 'location' parameter exists in the URL
if (isset($_GET['location'])) {
    $division = $conn->real_escape_string($_GET['location']);

    // Get fish_id(s) from Fish_Environmental_Info where division matches
    $sql = "SELECT fish_id FROM Fish_Environmental_Info WHERE division = '$division'";
    $result = $conn->query($sql);

    $fish_ids = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $fish_ids[] = $row['fish_id'];
        }
    }

    if (!empty($fish_ids)) {
        $ids = implode(',', array_map('intval', $fish_ids));
        // Get fish names from Fish table
        $sql2 = "SELECT fish_name FROM Fish WHERE fish_id IN ($ids)";
        $result2 = $conn->query($sql2);

        if ($result2 && $result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {
                $recommendations[] = $row['fish_name'];
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fish Recommendations</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 text-gray-900">

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg mt-8">
        <h2 class="text-3xl font-semibold text-center text-blue-600 mb-6">Fish Recommendations for Your Division</h2>

        <?php if (isset($_GET['location'])): ?>
            <h3 class="text-xl text-blue-500 text-center mb-4">Recommended Fish for <?php echo htmlspecialchars($_GET['location']); ?>:</h3>
            <?php if (!empty($recommendations)): ?>
                <ul class="space-y-4">
                    <?php foreach ($recommendations as $fish): ?>
                        <li class="bg-blue-100 p-4 rounded-lg shadow-md text-blue-800 font-medium">
                            <?php echo htmlspecialchars($fish); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-yellow-500 text-center font-medium mt-6">No recommendations found for this division.</p>
            <?php endif; ?>
        <?php else: ?>
            <p class="text-yellow-500 text-center font-medium mt-6">Please provide a division in the URL (e.g., ?location=Dhaka).</p>
        <?php endif; ?>
    </div>



    
</body>
</html>

<?php
$conn->close();
?>
