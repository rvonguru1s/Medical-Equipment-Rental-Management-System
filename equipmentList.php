<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Available Equipment List</title>
    <style>
        /* Basic Reset */
        body, h1, table, th, td {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
        }

        /* Body styling */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9; /* Light gray background */
            color: #333;
            line-height: 1.6;
            padding: 20px;
            text-align: center;
        }

        /* Heading styling */
        h1 {
            font-family: 'Arial', sans-serif; /* Change font to Arial, sans-serif */
            text-align: center;
            color: #1e88e5; /* Blue for heading */
            margin-bottom: 30px;
            font-size: 2.5em;
        }

        /* Table Styling */
        table {
            width: 80%; /* Adjusted width to 80% */
            margin: 0 auto; /* Center align the table */
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background-color: #ffffff; /* White background for the table */
        }

        th, td {
            padding: 10px; /* Reduced padding for th and td */
            text-align: left;
            border: 1px solid #ddd; /* Light gray border */
            font-size: 0.9em; /* Reduced font size for th and td */
        }

        th {
            background-color: #1e88e5; /* Blue header */
            color: white;
            font-size: 1em;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2; /* Light gray for even rows */
        }

        tr:hover {
            background-color: #e0e0e0; /* Darker gray on hover */
        }

        /* Responsive styling */
        @media screen and (max-width: 600px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            th, td {
                padding: 10px;
            }

            th {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                margin-bottom: 10px;
            }

            td {
                position: relative;
                padding-left: 50%;
                text-align: right;
            }

            td:before {
                position: absolute;
                top: 6px;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                text-align: left;
                font-weight: bold;
            }

            /* Label the data */
            td:nth-of-type(1):before { content: "EquipmentID"; }
            td:nth-of-type(2):before { content: "Name"; }
            td:nth-of-type(3):before { content: "Description"; }
        }
    </style>
</head>
<body>
    <h1>AVAILABLE EQUIPMENT LIST</h1>
    <table>
        <thead>
            <tr>
                <th>Equipment ID</th>
                <th>Name</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Start the PHP session if needed
            session_start();
            
            // Database connection parameters
            $servername = "localhost:3307"; // Replace with your server name
            $username = "root"; // Replace with your database username
            $password = ""; // Replace with your database password
            $dbname = "medicalequipmentrental"; // Replace with your database name
            
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            // SQL query to select data from medicalequipment table
            $sql = "SELECT ID, Name, Description FROM medicalequipment"; // Adjust column names as per your database schema
            
            $result = $conn->query($sql);
            
            // Check if there are any results
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["ID"]) . "</td>"; // Use "ID" instead of "EquipmentID"
                    echo "<td>" . htmlspecialchars($row["Name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Description"]) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No results found</td></tr>"; // Adjust colspan if more columns are present
            }
            
            // Close the database connection
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
