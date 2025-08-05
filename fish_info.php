<?php
if (isset($_POST['selected_fish'])) {
    $selected_fish = $_POST['selected_fish'];

    // Database connection
    $conn = new mysqli("localhost", "root", "", "Aquasense");
    if ($conn->connect_error) {
        die("Connection failed: {$conn->connect_error}");
    }

    // Get fish_id from Fish table
    $stmt = $conn->prepare("SELECT fish_id FROM Fish WHERE fish_name = ?");
    $stmt->bind_param("s", $selected_fish);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $fish = $result->fetch_assoc();
        $fish_id = $fish['fish_id'];

        // Get environmental info
        $stmt2 = $conn->prepare("SELECT * FROM Fish_Environmental_Info WHERE fish_id = ?");
        $stmt2->bind_param("i", $fish_id);
        $stmt2->execute();
        $info = $stmt2->get_result()->fetch_assoc();

        // Extract numeric values for stocking density and market price
        preg_match_all('/\d+\.?\d*/', $info['stocking_density_range'], $stocking_matches);
        preg_match_all('/\d+\.?\d*/', $info['market_price_range'], $market_matches);

        $stocking_min = isset($stocking_matches[0][0]) ? (float)$stocking_matches[0][0] : 0;
        $stocking_max = isset($stocking_matches[0][1]) ? (float)$stocking_matches[0][1] : $stocking_min;
        $market_min = isset($market_matches[0][0]) ? (float)$market_matches[0][0] : 0;
        $market_max = isset($market_matches[0][1]) ? (float)$market_matches[0][1] : $market_min;

        // HTML starts here
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>$selected_fish - Aqua Sense Info</title>
            <link href='https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css' rel='stylesheet'>
        </head>
        <body class='bg-blue-100 min-h-screen flex items-center justify-center px-4'>

            <div class='bg-white shadow-lg rounded-xl w-full max-w-2xl p-8 border-t-8 border-blue-600'>
                <h1 class='text-3xl font-bold text-blue-700 mb-6 text-center'>Environmental Info: <span class='text-gray-800'>$selected_fish</span></h1>

                <div class='grid grid-cols-1 sm:grid-cols-2 gap-6 text-gray-700 text-lg'>
                    <div>
                        <span class='font-semibold text-blue-800'>pH Range:</span>
                        <p>{$info['ph_range']}</p>
                    </div>
                    <div>
                        <span class='font-semibold text-blue-800'>Temperature Range:</span>
                        <p>{$info['temp_range']}</p>
                    </div>
                    <div>
                        <span class='font-semibold text-blue-800'>Harvest Time:</span>
                        <p>{$info['harvest_time']}</p>
                    </div>
                    <div>
                        <span class='font-semibold text-blue-800'>Market Price Range:</span>
                        <p>{$info['market_price_range']}</p>
                    </div>
                    <div class='sm:col-span-2'>
                        <span class='font-semibold text-blue-800'>Stocking Density Range:</span>
                        <p>{$info['stocking_density_range']}</p>
                    </div>
                </div>

                <div class='mt-10 border-t pt-8'>
                    <h2 class='text-2xl font-bold text-blue-700 mb-4 text-center'>Personalized Recommendation</h2>
                    <form id='recommendationForm' class='flex flex-col items-center gap-4'>
                        <label class='font-semibold text-gray-700'>
                            Size of Pond (in decimal):
                            <input type='number' step='1' min='1' id='pondSize' class='ml-2 border rounded px-2 py-1' required>
                        </label>
                        <button type='submit' class='bg-yellow-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded transition'>Get Recommendation</button>
                    </form>
                    <div id='recommendationResult' class='mt-6 text-lg text-center'></div>
                </div>

                <div class='mt-8 text-center'>
                    <a href='index.php' class='inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded transition'>
                        ← Back to Selection
                    </a>
                </div>
            </div>
            <script>
                document.getElementById('recommendationForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    var pondSize = parseInt(document.getElementById('pondSize').value, 10);
                    if (isNaN(pondSize) || pondSize <= 0) {
                        document.getElementById('recommendationResult').innerHTML = '<span class=\"text-red-500\">Please enter a valid pond size.</span>';
                        return;
                    }
                    // Stocking density range
                    var stockingMin = $stocking_min;
                    var stockingMax = $stocking_max;
                    var marketMin = $market_min;
                    var marketMax = $market_max;
                    var optimalMin = Math.round(stockingMin * pondSize);
                    var optimalMax = Math.round(stockingMax * pondSize);

                    // Revenue = number of fish * market price (assuming 1 fish per unit price)
                    var revenueMin = Math.round(optimalMin * marketMin);
                    var revenueMax = Math.round(optimalMax * marketMax);
                    var revenueMax = Math.round(optimalMax * (marketMax/2));

                    var result = '<div class=\"mb-2\"><span class=\"font-semibold text-blue-800\">Optimal Stocking for your pond:</span> ' +
                        optimalMin + ' - ' + optimalMax + ' fish</div>';
                    result += '<div><span class=\"font-semibold text-blue-800\">Estimated Revenue:</span> ' +
                        revenueMin + ' - ' + revenueMax + ' Taka </div>';

                    document.getElementById('recommendationResult').innerHTML = result;
                });
            </script>
        </body>
        </html>";
    } else {
        echo "<p class='text-center text-red-500 mt-10'>Fish not found in the database.</p>";
    }
} else {
}
?>
