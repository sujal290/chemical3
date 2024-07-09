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

// Retrieve username, desig_id, and group name from session
$username = $_SESSION['username'];
$desig_id = $_SESSION['desig_id'];
$group_id = $_SESSION['group_id'];
$desig_fullname = $_SESSION['desig_fullname'];
$group_fullname = $_SESSION['group_fullname'];
$full_name = $_SESSION['first_name'] . ' ' . $_SESSION['middle_name'] . ' ' . $_SESSION['last_name'];

$error = ""; // Initialize the error variable
$success = false; // Initialize the success variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $casNumber = $_POST['casNumber'];
    $chemicalName = $_POST['chemicalName'];
    $commonName = $_POST['commonName'];
    $grade = $_POST['grade'] == 'OTHERS' ? $_POST['customGrade'] : $_POST['grade'];
    $quantity = $_POST['quantity'];
    $unit = $_POST['unit'];
    $remarks = $_POST['remarks'];

    // Prepare and execute SQL query to insert into chemicals table
    $insertStmt = $conn->prepare("INSERT INTO chemicals (username, desig_id, cas_no, chemical_name, common_name, grade, quantity, unit, remark, is_created, is_updated) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");
    
    if (!$insertStmt) {
        die('Error preparing statement: ' . $conn->error);
    }
    
    // Bind parameters
    $insertStmt->bind_param("siisssdss", $username, $desig_id, $casNumber, $chemicalName, $commonName, $grade, $quantity, $unit, $remarks);

    // Execute statement
    if ($insertStmt->execute()) {
        $success = true; // Set success flag
    } else {
        $error = "Error: " . $insertStmt->error;
    }

    $insertStmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Chemical</title>
    <style>
         body {
        font-family: Arial, sans-serif;
        background-color: skyblue;/* Set background color to orange */
        margin: 0;
        padding: 0;
    }
    .container {
        width: 50%;
        margin-top: 45px;
        margin-left: auto;
        margin-right: auto;
        background: #FFE0B2;
      
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
        font-family: Cambria, sans-serif; /* Set font family to Cambria */
        text-align: center;
        color: #000000;
    }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            color: #000000;
            font-weight: bold; /* Make labels bold */
        }
        input[type="text"], input[type="number"], select {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
        }
        .btn {
            padding: 10px;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            width: 48%;
            text-align: center;
        }
        .btn.add {
            background: #28a745;
        }
        .btn.add:hover {
            background: #218838;
        }
        .btn.back {
            background: #007bff;
        }
        .btn.back:hover {
            background: #0056b3;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
        #customGradeContainer {
            display: none;
        }
    </style>
    <script>
        function toggleCustomGrade() {
            var gradeSelect = document.getElementById("grade");
            var customGradeContainer = document.getElementById("customGradeContainer");
            if (gradeSelect.value === "OTHERS") {
                customGradeContainer.style.display = "block";
            } else {
                customGradeContainer.style.display = "none";
            }
        }

        function showAlert(message) {
            alert(message);
        }
    </script>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h1>Add New Chemical Details</h1>
        <?php if ($success) : ?>
            <script>
                showAlert("Chemical Added Successfully");
            </script>
        <?php elseif (!empty($error)) : ?>
            <div class="error">
                <?php echo "Error adding chemical: " . $error; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="Username"><b>Username</b></label>
            <input type="text" id="Username" name="username" value="<?php echo htmlspecialchars($full_name); ?>" readonly required>

            <label for="desig_id"><b>Designation Name</b></label>
            <input type="text" id="desig_id" name="desig_id" value="<?php echo htmlspecialchars($desig_fullname); ?>" readonly required>
            
            <label for="group_id"><b>Group Name</b></label>
            <input type="text" id="group_id" name="group_id" value="<?php echo htmlspecialchars($group_fullname); ?>" readonly required>
            
            <label for="casNumber"><b>CAS No.</b></label>
            <input type="text" id="casNumber" name="casNumber" required>
            
            <label for="chemicalName"><b>Chemical Name</b></label>
            <input type="text" id="chemicalName" name="chemicalName" required>
            
            <label for="commonName"><b>Common Name</b></label>
            <input type="text" id="commonName" name="commonName">
            
            <label for="grade"><b>Grade</b></label>
            <select id="grade" name="grade" onchange="toggleCustomGrade()" required>
                <option value="">Select Grade</option>
                <option value="AR">AR</option>
                <option value="LR">LR</option>
                <option value="XR">XR</option>
                <option value="HPLC">HPLC</option>
                <option value="OTHERS">Others</option>
            </select>
            
            <div id="customGradeContainer">
                <label for="customGrade"><b>Custom Grade</b></label>
                <input type="text" id="customGrade" name="customGrade">
            </div>

            <label for="quantity"><b>Quantity</b></label>
            <input type="number" id="quantity" name="quantity" step="0.01" min="1" required>
            
            <label for="unit"><b>Unit</b></label>
            <select id="unit" name="unit" required>
                <option value="">Select Unit</option>
                <option value="L">L</option>
                <option value="ml">ml</option>
                <option value="kg">kg</option>
                <option value="gm">gm</option>
                <option value="Packets">Packets</option>
            </select>
            
            <label for="remarks"><b>Remarks</b></label>
            <input type="text" id="remarks" name="remarks">
            
            <div class="button-container">
                <input type="submit" class="btn add" value="Add Chemical">
                <button type="button" class="btn back" onclick="window.location.href='dashboard.php';">BACK</button>
            </div>
        </form>
    </div>
</body>
</html>
