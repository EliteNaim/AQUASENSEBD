<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Step 1: Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Aquasense";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Handle form submission
$recommendations = [];
$foodAmount = 0;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selectedFishName = $_POST['fish_name'];
    $selectedWeightRange = $_POST['weight_range'];
    $numberOfFish = $_POST['number_of_fish'];

    if (!is_numeric($numberOfFish) || $numberOfFish <= 0) {
        die('Invalid number of fish');
    }

    $foodAmount = 0;

    $stmt = $conn->prepare("SELECT food_type, feed_rate_percent, weight_range_g FROM food WHERE fish_name = ? AND weight_range_g = ?");
    $stmt->bind_param("ss", $selectedFishName, $selectedWeightRange);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $weightRange = $row['weight_range_g'];
            if (strpos($weightRange, '–') !== false) {
                list($minWeight, $maxWeight) = explode('–', $weightRange);
            } elseif (strpos($weightRange, '-') !== false) {
                list($minWeight, $maxWeight) = explode('-', $weightRange);
            } else {
                $minWeight = $weightRange;
                $maxWeight = $weightRange;
            }
            $minWeight = (int)$minWeight;
            $maxWeight = (int)$maxWeight;
            $avgWeight = ($minWeight + $maxWeight) / 2;
            $totalWeight = ($numberOfFish * $avgWeight) / 1000;
            $foodAmount = ($totalWeight * $row['feed_rate_percent']) / 100;
            $recommendations[] = [
                'food_type' => $row['food_type'],
                'feed_rate_percent' => $row['feed_rate_percent'],
                'food_amount' => $foodAmount
            ];
        }
    } else {
        $recommendations[] = "No recommendations found.";
    }
    $stmt->close();
}

$fishNamesResult = $conn->query("SELECT DISTINCT fish_name FROM food");
$weightRangesResult = $conn->query("SELECT DISTINCT TRIM(weight_range_g) AS weight_range_g FROM food ORDER BY weight_range_g");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AquaSense Food Recommendation</title>
    <!-- AquaSense Theme Styles -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0093d0;
            --secondary: #005b7f;
            --accent: #00c2a0;
            --background: #f4fafd;
            --white: #fff;
            --gray: #e6eef3;
            --text: #222;
        }
        body {
            font-family: 'Montserrat', Arial, sans-serif;
            background: var(--background);
            color: var(--text);
            margin: 0;
            padding: 0;
        }
        header {
            background: linear-gradient(90deg, var(--primary) 60%, var(--accent) 100%);
            color: var(--white);
            padding: 32px 0 24px 0;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,147,208,0.08);
        }
        header h1 {
            margin: 0;
            font-size: 2.5rem;
            letter-spacing: 2px;
            font-weight: 700;
        }
        .container {
            max-width: 540px;
            margin: 40px auto;
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,93,127,0.08);
            padding: 32px 36px 28px 36px;
        }
        form label {
            font-weight: 600;
            color: var(--secondary);
            display: block;
            margin-bottom: 6px;
        }
        form select, form input[type="number"] {
            width: 100%;
            padding: 10px 12px;
            border: 1.5px solid var(--gray);
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 1rem;
            background: var(--background);
            transition: border 0.2s;
        }
        form select:focus, form input[type="number"]:focus {
            border-color: var(--primary);
            outline: none;
        }
        button[type="submit"] {
            background: linear-gradient(90deg, var(--primary) 60%, var(--accent) 100%);
            color: var(--white);
            border: none;
            border-radius: 8px;
            padding: 12px 32px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,147,208,0.08);
            transition: background 0.2s;
        }
        button[type="submit"]:hover {
            background: linear-gradient(90deg, var(--secondary) 60%, var(--accent) 100%);
        }
        h2 {
            color: var(--primary);
            margin-top: 32px;
            font-size: 1.4rem;
            font-weight: 700;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        ul li {
            background: var(--gray);
            border-radius: 8px;
            margin-bottom: 18px;
            padding: 18px 20px;
            box-shadow: 0 1px 4px rgba(0,93,127,0.04);
        }
        strong {
            color: var(--secondary);
        }
        @media (max-width: 600px) {
            .container {
                padding: 18px 8px 18px 8px;
            }
            header h1 {
                font-size: 1.5rem;
            }
        }
        /* AquaSense Logo Style */
        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
        }
        .logo-icon {
            width: 44px;
            height: 44px;
            margin-right: 12px;
        }
        .logo-text {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 1px;
            color: var(--white);
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <!-- Simple AquaSense Logo SVG -->
            <svg class="logo-icon" viewBox="0 0 48 48" fill="none">
                <ellipse cx="24" cy="24" rx="22" ry="22" fill="#00c2a0" />
                <path d="M24 10C18 18 12 24 24 38C36 24 30 18 24 10Z" fill="#0093d0"/>
                <circle cx="24" cy="24" r="7" fill="#fff" opacity="0.7"/>
            </svg>
            <span class="logo-text">AquaSense</span>
        </div>
        <h1>Food Recommendation System</h1>
    </header>
    <div class="container">
        <!-- Step 6: Display the form -->
        <form method="POST" action="">
            <label for="fish_name">Select Fish:</label>
            <select name="fish_name" id="fish_name" required>
                <option value="">-- Select Fish --</option>
                <?php
                // Reset pointer for fishNamesResult
                $fishNamesResult->data_seek(0);
                while ($row = $fishNamesResult->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($row['fish_name']); ?>"
                        <?php if (isset($selectedFishName) && $selectedFishName == $row['fish_name']) echo 'selected'; ?>>
                        <?= htmlspecialchars($row['fish_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="weight_range">Select Weight Range:</label>
            <select name="weight_range" id="weight_range" required>
                <option value="">-- Select Weight Range --</option>
                <?php
                // Reset pointer for weightRangesResult
                $weightRangesResult->data_seek(0);
                while ($row = $weightRangesResult->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($row['weight_range_g']); ?>"
                        <?php if (isset($selectedWeightRange) && $selectedWeightRange == $row['weight_range_g']) echo 'selected'; ?>>
                        <?= htmlspecialchars($row['weight_range_g']); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="number_of_fish">Number of Fish:</label>
            <input type="number" name="number_of_fish" id="number_of_fish" min="1" required
                value="<?= isset($numberOfFish) ? htmlspecialchars($numberOfFish) : '' ?>"><br>

            <button type="submit">Get Recommendations</button>
        </form>

        <!-- Step 7: Display Results -->
        <h2>Recommendations:</h2>
        <?php if (!empty($recommendations)): ?>
            <?php if (is_array($recommendations[0])): ?>
                <ul>
                    <?php foreach ($recommendations as $recommendation): ?>
                        <li>
                            <strong>Food Type:</strong> <?= htmlspecialchars($recommendation['food_type']); ?><br>
                            <strong>Feed Rate Percentage:</strong> <?= htmlspecialchars($recommendation['feed_rate_percent']); ?>%<br>
                            <strong>Food Amount Needed:</strong> <?= number_format($recommendation['food_amount'], 2); ?> kg<br>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p><?= htmlspecialchars($recommendations[0]); ?></p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <!-- Available Fish Food in BD Segment -->
    <div class="container" style="margin-top: 32px;">
        <h2>Available Fish Food in BD</h2>
        <?php
        // Determine selected food type from recommendations if available
        $matchedFoodType = null;
        if (!empty($recommendations) && is_array($recommendations[0]) && isset($recommendations[0]['food_type'])) {
            $matchedFoodType = $recommendations[0]['food_type'];
        }

        // Prepare query: try to match food_type, else get random 5 rows
        if ($matchedFoodType) {
            $stmt = $conn->prepare("SELECT c_id, food_type, product_name, company FROM food_company WHERE food_type = ?");
            $stmt->bind_param("s", $matchedFoodType);
            $stmt->execute();
            $foodResult = $stmt->get_result();
        }

        if (empty($foodResult) || $foodResult->num_rows == 0) {
            // No match or no recommendation, get random 5 rows
            $foodResult = $conn->query("SELECT c_id, food_type, product_name, company FROM food_company ORDER BY RAND() LIMIT 5");
        }
        ?>

        <table style="width:100%; border-collapse:collapse; margin-top:16px;">
            <thead>
                <tr style="background: var(--gray);">
                    <th style="padding:8px; border-radius:6px 0 0 6px;">Food Type</th>
                    <th style="padding:8px;">Product Name</th>
                    <th style="padding:8px; border-radius:0 6px 6px 0;">Company</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $foodResult->fetch_assoc()): ?>
                    <tr style="background: var(--background); border-bottom:1px solid var(--gray);">
                        <td style="padding:8px;"><?= htmlspecialchars($row['food_type']); ?></td>
                        <td style="padding:8px;"><?= htmlspecialchars($row['product_name']); ?></td>
                        <td style="padding:8px;"><?= htmlspecialchars($row['company']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php if (isset($stmt)) $stmt->close(); ?>
    </div>
    
</body>
</html>

<?php
$conn->close();
?>
