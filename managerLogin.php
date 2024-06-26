<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
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
        }
        .container {
            background: rgba(255, 255, 255, 0.8); /* Semi-transparent background */
            padding: 2rem 3rem;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Subtle shadow */
            text-align: center;
            max-width: 500px; /* Maximum width for the container */
            backdrop-filter: blur(10px); /* Blur effect for background */
        }
        .card {
            border: none; /* Remove border */
            border-radius: 15px;
            box-shadow: none; /* Remove shadow */
        }
        .card-header {
            background-color: #007bff; /* Blue header background */
            color: #ffffff; /* White text */
            border-radius: 15px 15px 0 0;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            border-bottom: none; /* Remove bottom border */
        }
        .form-label {
            font-weight: 600;
            color: #495057; /* Darker gray */
        }
        .form-control {
            border-radius: 10px;
            border: 1px solid #ced4da; /* Light gray border */
            padding: 10px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .form-control:focus {
            border-color: #007bff; /* Blue border on focus */
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25); /* Blue shadow on focus */
        }
        .btn-primary {
            background-color: #007bff; /* Blue */
            border-color: #007bff;
            border-radius: 10px;
            width: 100%;
            padding: 12px;
            font-size: 18px;
            transition: background-color 0.3s ease;
            margin-top: 10px; /* Margin top */
        }
        .btn-primary:hover {
            background-color: #0056b3; /* Darker blue on hover */
            border-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                   Manager Login
                </div>
                <div class="card-body">
                    <form action="processmanagerLogin.php" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
