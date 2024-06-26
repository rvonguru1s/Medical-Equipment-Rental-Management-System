<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Landing Page</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0; /* Light gray background */
            text-align: center;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            overflow: hidden;
            background-color: #ffffff; /* White background */
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Soft shadow */
            padding: 20px;
        }
        .header {
            background: #007bff; /* Blue background */
            color: #ffffff; /* White text color */
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .header h1 {
            margin: 0;
        }
        .button-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }
        .button {
            padding: 15px 30px;
            font-size: 18px;
            cursor: pointer;
            background-color: #28a745; /* Green button color */
            color: #ffffff; /* White text color */
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #218838; /* Darker green on hover */
        }
        .button:focus {
            outline: none;
        }
        @media (max-width: 768px) {
            .container {
                width: 90%;
            }
            .button-container {
                flex-direction: column;
            }
            .button {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Welcome to the Client Page</h1>
    </div>

    <div class="button-container">
        <form action="equipmentList.php" method="post">
            <input type="submit" class="button" value="View Available Equipment">
        </form>

        <form action="rentalForm.php" method="post">
            <input type="submit" class="button" value="Rent Equipment">
        </form>
    </div>
</div>
</body>
</html>
