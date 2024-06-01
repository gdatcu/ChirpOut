<?php
require 'config/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChirpOut App</title>
    <style>
        /* Apply basic reset to remove default margins and paddings */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Style for the body to center content and set a background color */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container for the main content */
        .container {
            background-color: #fff;
            padding: 20px 40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        /* Heading style */
        h1 {
            font-size: 2em;
            color: #333;
            margin-bottom: 10px;
        }

        /* Paragraph style */
        p {
            font-size: 1.2em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to ChirpOut App</h1>
        <p>Hello! You're logged in right now!</p>
        <br>
        <h3>Take your time and remember, no matter what today brings, you'll be ready!</h3>
    </div>
</body>
</html>
