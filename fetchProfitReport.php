<?php

include 'C:/xampp/htdocs/Medical equipment rental/dbconnect.php'; // Ensure this path is correct

$totalIncome = 0;
$totalExpenses = 0;
$totalProfit = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $monthYear = $_POST['month'];
    list($year, $month) = explode('-', $monthYear);

    $pdo = openDatabaseConnection();

    // Calculate total income from rentals in the selected month
    $incomeQuery = "
        SELECT SUM(total_price) AS totalIncome
        FROM Rentals
        WHERE MONTH(start_date) = ? AND YEAR(start_date) = ? AND payment_status = 'paid'
    ";
    $stmt = $pdo->prepare($incomeQuery);
    $stmt->execute([$month, $year]);
    $incomeResult = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalIncome = $incomeResult['totalIncome'] ?? 0;

    // Example expenses query (modify as per your database schema)
    // $expensesQuery = "SELECT SUM(amount) AS totalExpenses FROM Expenses WHERE MONTH(date) = ? AND YEAR(date) = ?";
    // $stmt = $pdo->prepare($expensesQuery);
    // $stmt->execute([$month, $year]);
    // $expensesResult = $stmt->fetch(PDO::FETCH_ASSOC);
    // $totalExpenses = $expensesResult['totalExpenses'] ?? 0;

    // Calculate total profit (income - expenses)
    $totalProfit = $totalIncome - $totalExpenses;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profit Calculation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="month"] {
            padding: 8px;
            font-size: 1em;
        }
        input[type="submit"] {
            padding: 8px 16px;
            font-size: 1em;
            background-color: #009879;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #007f67;
        }
        .result {
            margin-top: 20px;
            padding: 10px;
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
            border: 1px solid transparent;
            border-radius: .25rem;
        }
    </style>
</head>
<body>
    <h2>Profit Calculation</h2>
    <form method="POST" action="">
        <label for="month">Select Month and Year:</label>
        <input type="month" id="month" name="month" required>
        <input type="submit" value="Calculate Profit">
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <div class="result">
            <h3>Total Profit for <?php echo htmlspecialchars($monthYear); ?></h3>
            <p>Total Income: $<?php echo number_format($totalIncome, 2); ?></p>
            <p>Total Expenses: $<?php echo number_format($totalExpenses, 2); ?></p>
            <p>Total Profit: $<?php echo number_format($totalProfit, 2); ?></p>
        </div>
    <?php endif; ?>
</body>
</html>
