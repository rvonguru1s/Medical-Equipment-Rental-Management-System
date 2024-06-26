<?php
session_start();

// Check if the ClientID is set in the session
if (!isset($_SESSION['client_id'])) {
    die("Client ID is not set. Please log in again.");
}

// Database connection parameters
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "medicalequipmentrental";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// CSS styles as a PHP string
$css_styles = <<<CSS
<style>
    body {
        font-family: "Helvetica", Arial, sans-serif;
        background-color: #e9f7ef;
        color: #555;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        flex-direction: column;
    }

    .unavailable-message {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 90%;
        max-width: 500px;
        text-align: center;
    }

    .unavailable-message h3 {
        color: #e53935;
        margin-bottom: 20px;
    }

    .unavailable-message ul {
        list-style: none;
        padding: 0;
        margin: 0 0 20px 0;
    }

    .unavailable-message ul li {
        background-color: #ffd7d7;
        color: #c62828;
        margin: 5px 0;
        padding: 10px;
        border-radius: 5px;
    }

    .availability-form {
        margin-top: 20px;
        text-align: left;
    }

    .availability-form label {
        display: block;
        margin-bottom: 5px;
        color: #333;
    }

    .availability-form input[type="date"],
    .availability-form button {
        width: calc(100% - 20px);
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        box-sizing: border-box;
    }

    .availability-form button {
        background-color: #4caf50;
        color: #fff;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .availability-form button:hover {
        background-color: #45a049;
    }

    .cancel-link {
        display: block;
        margin-top: 20px;
        color: #e53935;
        text-decoration: none;
    }

    .cancel-link:hover {
        text-decoration: underline;
    }
</style>
CSS;

// Output the CSS styles within the head section
echo $css_styles;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $equipment_id = $conn->real_escape_string($_POST['equipment_id']);
    $start_date = $conn->real_escape_string($_POST['start_date']);
    $end_date = $conn->real_escape_string($_POST['end_date']);
    $client_id = $_SESSION['client_id']; // Retrieved from session

    // Validate date format and order
    $start_timestamp = strtotime($start_date);
    $end_timestamp = strtotime($end_date);
    if ($start_timestamp === false || $end_timestamp === false || $start_timestamp >= $end_timestamp) {
        die("Invalid date range. Please select valid start and end dates.");
    }

    // Check availability of the equipment for the requested period
    $availability_query = "SELECT start_date, end_date FROM rentals WHERE equipment_id = ? AND NOT (end_date <= ? OR start_date >= ?)";
    $availability_stmt = $conn->prepare($availability_query);
    $availability_stmt->bind_param("iss", $equipment_id, $start_date, $end_date);
    $availability_stmt->execute();
    $availability_result = $availability_stmt->get_result();

    if ($availability_result->num_rows > 0) {
        // Equipment is not available for the selected dates
        echo '<div class="unavailable-message">';
        echo '<h3>The selected equipment is not available for the requested dates.</h3>';
        echo "<p>Please select a different start date or cancel your request.</p>";

        // Provide availability information
        echo "<h4>Unavailable Dates:</h4><ul>";
        while ($row = $availability_result->fetch_assoc()) {
            echo "<li>" . htmlspecialchars($row['start_date']) . " to " . htmlspecialchars($row['end_date']) . "</li>";
        }
        echo "</ul>";

        // Provide form to change start date or cancel
        echo '<form method="post" action="">
                <input type="hidden" name="equipment_id" value="' . htmlspecialchars($equipment_id) . '">
                <label for="start_date">Change Start Date:</label>
                <input type="date" name="start_date" value="' . htmlspecialchars($start_date) . '" required>
                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" value="' . htmlspecialchars($end_date) . '" required>
                <button type="submit">Check Availability</button>
              </form>';
        echo '<a href="cancel.php" class="cancel-link">Cancel Request</a>'; // Link to cancel the request
        echo '</div>';
        exit();
    }

    // Calculate rental price and proceed with rental processing
    $rental_days = ($end_timestamp - $start_timestamp) / (60 * 60 * 24);

    // Fetch the rent price per day from the database for the selected equipment
    $stmt = $conn->prepare("SELECT rent_price_per_day FROM medicalequipment WHERE id = ?");
    $stmt->bind_param("i", $equipment_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Equipment not found.");
    }

    $equipment = $result->fetch_assoc();
    $rent_price_per_day = $equipment['rent_price_per_day'];
    $total_price = $rent_price_per_day * $rental_days;

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Insert the new rental into the rentals table
        $insert_stmt = $conn->prepare("INSERT INTO rentals (client_id, equipment_id, start_date, end_date, total_price) VALUES (?, ?, ?, ?, ?)");
        $insert_stmt->bind_param("iissd", $client_id, $equipment_id, $start_date, $end_date, $total_price);
        $insert_stmt->execute();

        // Decrease equipment quantity in store
        $quantity = 1;
        $update_stmt = $conn->prepare("UPDATE medicalequipment SET quantity_in_store = quantity_in_store - ? WHERE id = ?");
        $update_stmt->bind_param("ii", $quantity, $equipment_id);
        $update_stmt->execute();

        // Commit transaction
        $conn->commit();

        // Redirect to receipt page with rental ID
        header("Location: receipt.php?rental_id=" . $insert_stmt->insert_id);
        exit();
    } catch (mysqli_sql_exception $exception) {
        // Rollback transaction on error
        $conn->rollback();
        die("Error processing rental: " . $exception->getMessage());
    }
}

// Display the equipment selection form
$sql = "SELECT id, name FROM medicalequipment";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<form method="post" action="">
            <label for="equipment_id">Select Equipment:</label>
            <select name="equipment_id" required>';
    while ($row = $result->fetch_assoc()) {
        echo '<option value="'        .htmlspecialchars($row["id"]) . '">' . htmlspecialchars($row["name"]) . '</option>';
    }
    echo '</select>
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" value="' . (isset($_POST['start_date']) ? htmlspecialchars($_POST['start_date']) : '') . '" required>
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" value="' . (isset($_POST['end_date']) ? htmlspecialchars($_POST['end_date']) : '') . '" required>
            <button type="submit">Check Availability</button>
          </form>';
} else {
    echo "No equipment available.";
}

$conn->close();
?>

