<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

// If proceed button is clicked, redirect based on role
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['proceed'])) {
    if ($_SESSION['role'] === 'student') {
        header("Location: student.php");
        exit();
    } elseif ($_SESSION['role'] === 'teacher') {
        header("Location: teacher.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>San Isidro College - Lost & Found System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            /* Unique background with overlay for readability */
            background: linear-gradient(rgba(30,60,120,0.5), rgba(2,136,209,0.5)), url('sicbuilding.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            color: #333;
        }
        header {
            background: #116DD2cc;
            color: white;
            text-align: center;
            padding: 20px 0;
        }
        header .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        header .logo {
            max-width: 150px;
        }
        header .college-title h2,
        header .college-title h3 {
            margin: 0;
        }
        .container {
            display: flex;
            justify-content: center;
            margin: 30px;
        }
        .auth-card {
            display: flex;
            flex-direction: row;
            width: 100%;
            max-width: 1300px; /* Expanded width for a much wider box */
            min-width: 320px;
            background: rgba(255,255,255,0.95);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .left-side {
            padding: 30px;
            background: #0288d1e6;
            color: white;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-width: 0;
        }
        .right-side {
            padding: 30px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-width: 0;
        }
        h1, h2 {
            margin-bottom: 20px;
        }
        .welcome-list {
            margin-top: 10px;
            margin-bottom: 10px;
            padding-left: 20px;
        }
        .welcome-list li {
            margin-bottom: 8px;
        }
        .proceed-btn {
            margin-top: 30px;
            background: #116DD2;
            color: white;
            padding: 12px 40px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            border-radius: 4px;
            font-size: 1.1em;
            transition: background 0.2s;
        }
        .proceed-btn:hover {
            background: #1642BF;
        }
        footer {
            text-align: center;
            padding: 1px;
            background-color: #116DD2cc;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="logo.png" alt="San Isidro College Logo" class="logo">
            <div class="college-title">
                <h2>SAN ISIDRO COLLEGE</h2>
                <h3>LOST AND FOUND SYSTEM</h3>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="auth-card">
                <div class="left-side">
                    <h1>Welcome to the SIC Lost & Found System!</h1>
                    <p style="font-size:1.2em;">
                        We are glad to have you here. This platform is dedicated to helping our SIC community recover lost items and return found belongings to their rightful owners.
                    </p>
                    <ul class="welcome-list">
                        <li>🔎 Report lost items and let others help you find them.</li>
                        <li>👐 Found something? Post it here and help a fellow ISIDRAN.</li>
                        <li>🤝 Let's work together to keep our campus honest and caring.</li>
                        <li>📢 For any concerns, please contact the admin or visit the SIC office.</li>
                    </ul>
                    <p style="margin-top:15px;font-style:italic;">Your honesty and kindness make SIC a better place for everyone!</p>
                </div>
                <div class="right-side">
                    <h2>Mabuhay, ISIDRAN!</h2>
                    <p style="font-size:1.1em;text-align:center;">
                        You are now logged in.<br>
                        Click proceed to go to your dashboard.
                    </p>
                    <form method="POST">
                        <button type="submit" name="proceed" class="proceed-btn">Proceed</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <p>⚠️ Please be honest. Helping each other builds trust. | © 2025 Lost & Found System</p>
    </footer>
</body>
</html>