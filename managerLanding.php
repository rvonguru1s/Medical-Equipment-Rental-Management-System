<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5; /* Light gray background */
            color: #495057; /* Gray text color */
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            background-color: #ffffff; /* White background */
            padding: 20px;
            border-radius: 15px; /* Rounded corners */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Soft shadow */
        }

        h2 {
            margin-bottom: 30px;
            color: #007bff; /* Blue color */
        }

        .list-group {
            margin-bottom: 30px;
        }

        .list-group-item {
            background-color: #f8f9fa; /* Light gray background */
            border-color: #dee2e6; /* Light border */
            color: #495057; /* Gray text color */
            cursor: pointer;
            transition: background-color 0.2s ease; /* Smooth transition */
        }

        .list-group-item:hover {
            background-color: #e9ecef; /* Slightly darker gray on hover */
        }

        .col-md-4 {
            border-right: 1px solid #dee2e6; /* Right border for separation */
        }

        .col-md-8 {
            padding-left: 30px;
        }

        label {
            font-weight: bold;
            color: #343a40; /* Dark gray */
        }

        .btn-primary {
            background-color: #007bff; /* Blue */
            border-color: #007bff;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3; /* Darker blue on hover */
            border-color: #0056b3;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .error-message {
            color: red;
            margin-top: 20px;
        }

        .section-title {
            font-size: 18px;
            margin-bottom: 15px;
            color: #007bff;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 10px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        }

        .content-header {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Manager Dashboard</h2>
        <div class="row">
            <!-- Left Column for Buttons -->
            <div class="col-md-4">
                <h3 class="section-title">Inventory Management</h3>
                <div class="list-group">
                    <button onclick="showContent('updateInventory')" class="list-group-item list-group-item-action">Update Inventory</button>
                    <button onclick="showContent('addEquipment')" class="list-group-item list-group-item-action">Add Equipment</button>
                    <button onclick="showContent('takeOrder')" class="list-group-item list-group-item-action">Take Order</button>
                </div>

                <h3 class="section-title">Reports and Analysis</h3>
                <div class="list-group">
                    <button onclick="showContent('customerReport')" class="list-group-item list-group-item-action">Customer Information Report</button>
                    <button onclick="showContent('rentalReport')" class="list-group-item list-group-item-action">Rental Report</button>
                    <button onclick="showContent('unpaidCustomersReport')" class="list-group-item list-group-item-action">Unpaid Customers Report</button>
                    <button onclick="showContent('paymentsPaidReport')" class="list-group-item list-group-item-action">Payments Report</button>
                    <button onclick="showContent('profitReport')" class="list-group-item list-group-item-action">Profit Calculation</button>
                </div>
            </div>

            <!-- Right Column for Content -->
            <div class="col-md-8">
                <div id="contentArea">
                    <!-- Content will be loaded here based on button click -->
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript and Fetch Functions -->
    <script>
        function getUpdateInventoryForm() {
            return `
            <div class="content-header">
                <h3>Update Inventory</h3>
            </div>
            <form id="updateInventoryForm">
                <div class="mb-3">
                    <label for="equipmentId" class="form-label">Equipment ID</label>
                    <input type="number" class="form-control" id="equipmentId" name="equipmentId" required>
                </div>
                <div class="mb-3">
                    <label for="equipmentName" class="form-label">Equipment Name</label>
                    <input type="text" class="form-control" id="equipmentName" name="equipmentName">
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        `;
        }

        function addEquipmentForm() {
            return `
            <div class="content-header">
                <h3>Add New Equipment</h3>
            </div>
            <form id="addEquipmentForm">
                <div class="mb-3">
                    <label for="newEquipmentName" class="form-label">Equipment Name</label>
                    <input type="text" class="form-control" id="newEquipmentName" name="newEquipmentName" required>
                </div>
                <div class="mb-3">
                    <label for="newEquipmentDescription" class="form-label">Description</label>
                    <textarea class="form-control" id="newEquipmentDescription" name="newEquipmentDescription"></textarea>
                </div>
                <div class="mb-3">
                    <label for="manufacturer" class="form-label">Manufacturer</label>
                    <input type="text" class="form-control" id="manufacturer" name="manufacturer">
                </div>
                <div class="mb-3">
                    <label for="rentPricePerDay" class="form-label">Rent Price Per Day</label>
                    <input type="text" class="form-control" id="rentPricePerDay" name="rentPricePerDay">
                </div>
                <div class="mb-3">
                    <label for="newEquipmentQuantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" id="newEquipmentQuantity" name="newEquipmentQuantity" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Equipment</button>
            </form>
        `;
        }

        function showContent(contentId) {
            var contentArea = document.getElementById('contentArea');

            if (contentId === 'updateInventory') {
                contentArea.innerHTML = getUpdateInventoryForm();
                document.getElementById('updateInventoryForm').addEventListener('submit', function (e) {
                    e.preventDefault();
                    updateInventory();
                });
            }

            if (contentId === 'addEquipment') {
                contentArea.innerHTML = addEquipmentForm();
                document.getElementById('addEquipmentForm').addEventListener('submit', function (e) {
                    e.preventDefault();
                    addNewEquipment();
                });
            }

            if (contentId === 'customerReport') {
                fetch('fetchCustomerReport.php')
                    .then(response => response.text())
                    .then(data => {
                        contentArea.innerHTML = data;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            if (contentId === 'rentalReport') {
                fetch('fetchRentalReport.php')
                    .then(response => response.text())
                    .then(data => {
                        contentArea.innerHTML = data;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            if (contentId === 'unpaidCustomersReport') {
                fetch('fetchUnpaidCustomersReport.php')
                    .then(response => response.text())
                    .then(data => {
                        contentArea.innerHTML = data;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            if (contentId === 'paymentsPaidReport') {
                fetch('fetchPaymentsPaidReport.php')
                    .then(response => response.text())
                    .then(data => {
                        contentArea.innerHTML = data;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            if (contentId === 'profitReport') {
                contentArea.innerHTML = `
            <div class="content-header">
                <h3>Profit Calculation for a Month</h3>
            </div>
            <form id="profitReportForm">
                <div class="mb-3">
                    <label for="month" class="form-label">Month</label>
                    <input type="month" class="form-control" id="month" name="month" required>
                </div>
                <button type="submit" class="btn btn-primary">Generate Report</button>
            </form>
            <div id="profitReportResult"></div>
        `;

                document.getElementById('profitReportForm').addEventListener('submit', function (e) {
                    e.preventDefault();
                    generateProfitReport();
                });
            }

            if (contentId === 'takeOrder') {
                contentArea.innerHTML = `
                <div class="content-header">
                    <h3>Take Order</h3>
                </div>
                <form id="takeOrderForm">
                    <div class="mb-3">
                        <label for="clientId" class="form-label">Client ID</label>
                        <input type="number" class="form-control" id="clientId" name="clientId" required>
                    </div>
                    <div class="mb-3">
                        <label for="equipmentId" class="form-label">Equipment ID</label>
                        <input type="number" class="form-control" id="equipmentId" name="equipmentId" required>
                    </div>
                    <div class="mb-3">
                        <label for="startDate" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="startDate" name="startDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="endDate" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="endDate" name="endDate" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Order</button>
                </form>
                <div id="orderReceipt"></div>
            `;

                document.getElementById('takeOrderForm').addEventListener('submit', function (e) {
                    e.preventDefault();
                    submitOrder();
                });
            }
        }

        function submitOrder() {
            var formData = new FormData(document.getElementById('takeOrderForm'));

            fetch('processTakeOrder.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('orderReceipt').innerHTML = data;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function generateProfitReport() {
            var formData = new FormData(document.getElementById('profitReportForm'));

            fetch('fetchProfitReport.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('profitReportResult').innerHTML = data;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function updateInventory() {
            var formData = new FormData(document.getElementById('updateInventoryForm'));

            fetch('processUpdateInventory.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    alert(data); // Display success/error message
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function addNewEquipment() {
            var formData = new FormData(document.getElementById('addEquipmentForm'));

            fetch('processAddEquipment.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    alert(data); // Display success/error message
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
</body>

</html>
