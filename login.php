<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ISO Portal</title>
    <style>
        /* General styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0; /* Changed background color to light grey */
            color: #333;
        }

        .main-content {
            display: flex;
            flex-grow: 1;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 50px;
            box-sizing: border-box;
            background: linear-gradient(135deg, #ffd700, #ffd700); /* Gradient background */
            background: hsla(217, 100%, 50%, 1);

background: linear-gradient(90deg, hsla(217, 100%, 50%, 1) 0%, hsla(186, 100%, 69%, 1) 100%);

background: -moz-linear-gradient(90deg, hsla(217, 100%, 50%, 1) 0%, hsla(186, 100%, 69%, 1) 100%);

background: -webkit-linear-gradient(90deg, hsla(217, 100%, 50%, 1) 0%, hsla(186, 100%, 69%, 1) 100%);

filter: progid: DXImageTransform.Microsoft.gradient( startColorstr="#0061FF", endColorstr="#60EFFF", GradientType=1 );
        }

        .login-container {
            display: flex;
            /* background-color: #fdf9e1; Light yellow background */
    background-color: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            max-width: 1000px;
            width: 100%;
        }

        .login-box {
            width: 60%;
            padding-right: 20px;
            margin-left: 10px;
            margin-right: 12px;
        }

        .image-container {
            width: 40%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .image-fix {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
        }

        .image-container h1 {
            margin-bottom: 20px;
            font-size: 28px;
            text-align: center;
            color: #6b705c; /* Darker yellow for text */
        }

        .image-container img {
            width: 70%;
            padding-bottom: 10px;
        }

        .login-box h2 {
            margin-bottom: 15px;
            color: #333;
            font-size: 24px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 16px;
            margin-bottom: 8px;
            color: #555;
        }

        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            margin-top: -5px;
            box-shadow: 0 0 10px rgba(219, 211, 176, 0.5); /* Soft shadow */
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="password"]:focus {
            border-color: #ffd700; /* Brighter yellow on focus */
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.8); /* More pronounced focus shadow */
            outline: none;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 6px;
            background-color: #007bff; /* blue button */
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-left: 8px;
            margin-top: 10px;
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.5); /* Subtle button shadow */
        }

        .btn:hover {
            background-color: #0056b3; /* Darker yellow on hover */
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            color: #555;
        }

        .register-link a {
            color: #ffd700; /* Light yellow link color */
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        footer {
        background: linear-gradient(to bottom, #0C7EC2, #085B8E);   /* Adjusted to light yellow gradient */
            color: #fff;
            text-align: center;
            padding: 10px 0;
            margin-top: auto;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }

            .login-box,
            .image-container {
                width: 100%;
            }

            .image-container {
                margin-top: 20px;
            }
        }

        @media (max-width: 576px) {
            .header h1 {
                font-size: 18px;
            }

            .header img {
                height: 40px;
            }

            .login-box h2 {
                font-size: 18px;
            }

            .form-group label {
                font-size: 14px;
            }

            .form-group input[type="text"],
            .form-group input[type="password"],
            .btn {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="main-content">
        <div class="login-container">
            <div class="image-fix">
                <div class="image-container">
                    <h1>ISO Portal</h1>
                    <img src="./images/iso.png" alt="Image">
                </div>
            </div>
            <div class="login-box">
                <h2>Login</h2>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <input type="submit" class="btn" name="login" value="Login">
                </form>
            </div>
        </div>
    </div>
    <footer>
        <p>Designed and maintained by <br>QRS&IT group</p>
    </footer>


</body>
</html>
