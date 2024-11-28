<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            margin: 20px;
            height: 80vh;
            background-color: rgb(10,45,45);
            background: url('partials/R.t.png') no-repeat center center fixed;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .container {
            text-align: center;
            padding: 40px;
            border-radius: 20px;
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
            margin-left: 20px;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 20px;
            background-color: white;
            border-radius: 20px;
            padding: 10px;
        }

        p {
            font-family: 'Arial', sans-serif;
            font-size: 1.1em;
            margin-bottom: 30px;
            color: #333;
            background-color: white;
            border-radius: 20px;
            padding: 10px;
        }

        .button-group {
            display: flex;
            gap: 20px;
            justify-content: center;
        }

        .btn {
            padding: 10px 20px;
            text-decoration: none;
            color: white;
            background-color: #007bff;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>WELCOME</h1>
        <p>Connecting Aspirants</p>
        <div class="button-group">
            <a href="register.php" class="btn">Register</a>
            <a href="login.php" class="btn">Login</a>
        </div>
    </div>
</body>
</html>