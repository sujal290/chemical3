<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit;
}

// Database connection
$conn = new mysqli("localhost", "root", "", "cim_system2");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user's name for welcome message
$username = $_SESSION['username'];
$full_name = $_SESSION['first_name'] . ' ' . $_SESSION['middle_name'] . ' ' . $_SESSION['last_name'];
$desig_fullname = $_SESSION['desig_fullname'];
$group_fullname = $_SESSION['group_fullname'];

// Pagination
$limit = 10; // Number of entries per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Search filter
$search = isset($_GET['search']) ? $_GET['search'] : '';
$search_condition = $search ? "WHERE chemical_name LIKE '%$search%'" : '';

// Query to fetch chemicals for the current page with search filter
$query = "SELECT * FROM chemicals $search_condition LIMIT $start, $limit";
$result = $conn->query($query);

// Total number of entries with search filter applied
$total_query = "SELECT COUNT(*) FROM chemicals $search_condition";
$total_result = $conn->query($total_query);
$total_entries = $total_result->fetch_row()[0];

// Calculate total pages
$total_pages = ceil($total_entries / $limit);

// Calculate pagination range
$pagination_range = 5; // Number of pages to show in the pagination bar
$pagination_start = max(1, $page - floor($pagination_range / 2));
$pagination_end = min($total_pages, $pagination_start + $pagination_range - 1);
$pagination_start = max(1, $pagination_end - $pagination_range + 1);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* General styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            background-color: #e0f7fa;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 15px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .welcome-message {
            font-size: 1.5em;
            color: #555555;
            text-align: left;
            margin-bottom: 10px;
            font-weight:500;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 30px;
            gap: 10px;
            margin-top: 6px;
        }

        .button-container button {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .button-container .add-chemical {
            background-color: #388e3c;
            color: #fff;
        }

        .button-container .print {
            background-color: #0288d1;
            color: #fff;
        }

        .button-container .add-chemical:hover {
            background-color: #4caf50;
        }

        .button-container .print:hover {
            background-color: #039be5;
        }

        .search-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-container input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1em;
            width: 250px;
        }

        .search-container h2 {
            margin: 0;
            font-size: 27px;
            color: #00796b;
            font-family: 'Georgia', serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            text-align: center;
        }

        table th,
        table td {
            border: 1px solid #ccc;
            padding: 6px;
        }

        table th {
            background-color: #00796b;
            color: #fff;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #e0f7fa;
        }

        .logout-container {
            text-align: center;
        }

        .logout-container button {
            padding: 9px 16px;
            cursor: pointer;
            background-color: #d32f2f;
            color: #fff;
            transition: background-color 0.3s ease, color 0.3s ease;
            border: none;
            border-radius: 6px;
        }

        .logout-container button:hover {
            background-color: #f44336;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 10px 0;
        }

        .pagination a {
            padding: 6px 7px;
            text-decoration: none;
            border: 1px solid #00796b;
            border-radius: 4px;
            color: #00796b;
        }

        .pagination a.active {
            background-color: #00796b;
            color: #fff;
        }

        .pagination a:hover {
            background-color: #039be5;
            color: #fff;
        }
    </style>
    <script>
        function searchChemicals() {
            let input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("search");
            filter = input.value.toUpperCase();
            table = document.getElementById("chemicalsTable");
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td");
                let found = false;
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                }
                tr[i].style.display = found ? "" : "none";
            }
        }
    </script>
</head>

<body>

    <div class="container" id = "content">
        <?php include 'navbar.php'; ?>
        <div class="welcome-message">Welcome, <?php echo $username; ?></div>

        <div class="button-container">
            <button class="view-chemical" onclick="window.location.href='view_details.php'">View Details</button>
            <button class="add-chemical" onclick="window.location.href='my_form.php'">Add Chemicals</button>
            <button id="printButton" class="print">Print</button>
            <div class="logout-container">
                <button onclick="window.location.href='logout.php'">Logout</button>
            </div>
        </div>

        <div class="grouping">
            <div class="search-container">
                <h2>Available Chemicals</h2>
                <input type="text" id="search" name="search" placeholder="Search..." onkeyup="searchChemicals()">
            </div>

            <div style="overflow-x:auto;">
                <table id="chemicalsTable">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Full Name</th>
                            <th>Designation</th>
                            <th>Group Name</th>
                            <th>CAS No.</th>
                            <th>Chemical Name</th>
                            <th>Common Name</th>
                            <th>Grade</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Remarks</th>
                            <th>Create Date & Time</th>
                            <th>Update Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $serial_number = ($page - 1) * $limit + 1; // Initialize serial number for current page

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $serial_number++ . "</td>";
                                echo "<td>" . $full_name . "</td>";
                                echo "<td>" . $desig_fullname . "</td>";
                                echo "<td>" . $group_fullname . "</td>";
                                echo "<td>" . $row['cas_no'] . "</td>";
                                echo "<td>" . $row['chemical_name'] . "</td>";
                                echo "<td>" . $row['common_name'] . "</td>";
                                echo "<td>" . $row['grade'] . "</td>";
                                echo "<td>" . $row['quantity'] . "</td>";
                                echo "<td>" . $row['unit'] . "</td>";
                                echo "<td>" . $row['remark'] . "</td>";
                                echo "<td>" . $row['is_created'] . "</td>";
                                echo "<td>" . $row['is_updated'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='13'>No chemicals found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?>&search=<?php echo $search; ?>">&laquo; Prev</a>
                <?php endif; ?>

                <?php for ($i = $pagination_start; $i <= $pagination_end; $i++): ?>
                    <a href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>" class="<?php if ($page == $i) echo 'active'; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?php echo $page + 1; ?>&search=<?php echo $search; ?>">Next &raquo;</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <form id="printForm" action="print.php" method="post" style="display: none;">
        <input type="hidden" name="pageContent" id="pageContent">
    </form>

    <script>
        document.getElementById('printButton').addEventListener('click', function() {
            // Get the content of the page
            var content = document.getElementById('content').innerHTML;
            // Set the content to the hidden input field
            document.getElementById('pageContent').value = content;
            // Submit the form
            document.getElementById('printForm').submit();
        });
    </script>


</body>

</html>
