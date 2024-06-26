<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Equipment Rental System - Login Selection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet"> <!-- Custom Font -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"> <!-- Icons -->
    <style>
        body {
            background: linear-gradient(135deg, #a8edea, #fed6e3); /* Gradient background */
            font-family: 'Poppins', sans-serif; /* Custom font */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #343a40; /* Dark gray text */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1); /* Light text shadow */
            overflow: hidden; /* Prevent scrollbars */
        }
        .container {
            background: rgba(255, 255, 255, 0.2); /* Semi-transparent background */
            padding: 3rem 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Subtle shadow */
            text-align: center;
            max-width: 800px; /* Maximum width for the container */
            backdrop-filter: blur(10px); /* Blur effect for background */
        }
        .btn {
            padding: 0.75rem 1.5rem;
            font-size: 1.25rem; /* Larger font size */
            border-radius: 50px; /* Rounded buttons */
            margin-top: 1rem;
            transition: all 0.3s ease; /* Smooth transition for hover effect */
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn i {
            margin-right: 8px; /* Space between icon and text */
        }
        .btn-manager {
            background-color: #ff6f61; /* Coral */
            border-color: #ff6f61;
            color: #ffffff; /* White text */
            width: 45%; /* Adjust width for side-by-side layout */
        }
        .btn-manager:hover {
            background-color: #e55a4e; /* Darker coral on hover */
            border-color: #e55a4e;
            transform: translateY(-5px); /* Lift effect on hover */
            box-shadow: 0 5px 15px rgba(229, 90, 78, 0.5); /* Shadow on hover */
        }
        .btn-client {
            background-color: #17a2b8; /* Teal */
            border-color: #17a2b8;
            color: #ffffff; /* White text */
            width: 45%; /* Adjust width for side-by-side layout */
        }
        .btn-client:hover {
            background-color: #138496; /* Darker teal on hover */
            border-color: #138496;
            transform: translateY(-5px); /* Lift effect on hover */
            box-shadow: 0 5px 15px rgba(19, 132, 150, 0.5); /* Shadow on hover */
        }
        h1 {
            font-weight: 700; /* Bold font */
            margin-bottom: 1rem;
            font-size: 2.5rem; /* Larger font size */
        }
        p {
            margin-bottom: 2rem;
            font-size: 1.2rem; /* Larger font size */
        }
        .button-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        @media (max-width: 768px) {
            .button-container {
                flex-direction: column;
            }
            .btn {
                width: 80%;
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>LifeLine Equipment Rentals</h1>
        <p>Welcome to our system. Please select your role:</p>
        <div class="button-container">
            <button type="button" class="btn btn-manager" onclick="window.location.href='managerLogin.php'"><i class="fas fa-user-tie"></i> Manager Login</button>
            <button type="button" class="btn btn-client" onclick="window.location.href='clientLogin.php'"><i class="fas fa-user"></i> Client Login</button>
        </div>
    </div>
</body>
</html>
