<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Page</title>

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

</head>
<body>
    <div class="print-container">
        <?php
        if (isset($_POST['pageContent'])) {
            echo $_POST['pageContent'];
        } else {
            echo '<p>No content to print.</p>';
        }
        ?>
    </div>

    <!-- <button class="no-print" onclick="window.print()">Print This Page</button> -->
    
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
