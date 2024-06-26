<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Light gray background */
            font-family: Arial, sans-serif; /* Change font family */
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            width: 100%;
            max-width: 400px;
            border: none; /* Remove border */
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Shadow effect */
        }
        .card-header {
            background-color: #007bff; /* Blue header background */
            color: #ffffff; /* White text */
            border-radius: 10px 10px 0 0;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            border-bottom: 2px solid #0056b3; /* Darker blue border bottom */
        }
        .card-body {
            padding: 20px;
        }
        .form-label {
            font-weight: bold;
            color: #495057; /* Dark gray */
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #ced4da; /* Light gray border */
            padding: 10px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            font-weight: bold; /* Bold font weight */
        }
        .form-control:focus {
            border-color: #007bff; /* Blue border on focus */
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); /* Blue shadow on focus */
        }
        .btn-primary {
            background-color: #007bff; /* Blue */
            border-color: #007bff;
            border-radius: 8px;
            width: 100%;
            padding: 12px;
            font-size: 18px;
            transition: background-color 0.3s ease;
            font-weight: bold; /* Bold font weight */
        }
        .btn-primary:hover {
            background-color: #0056b3; /* Darker blue on hover */
            border-color: #0056b3;
        }
        .alert-danger {
            background-color: #f8d7da; /* Light red background */
            border-color: #f5c6cb; /* Red border */
            color: #721c24; /* Dark red text */
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 15px;
            font-weight: bold; /* Bold font weight */
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header">
           Client Login
        </div>
        <div class="card-body">
            <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid_credentials') : ?>
                <div class="alert alert-danger" role="alert">
                    Invalid email or password. Please try again.
                </div>
            <?php endif; ?>
            <form action="processClientLogin.php" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
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

</body>
</html>
