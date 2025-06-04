<?php
require 'db.php';

$register_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm-password']);
    $role = isset($_POST['role']) ? $_POST['role'] : '';

    // Institutional email validation
    if (!preg_match('/^[a-zA-Z0-9._%+-]+@sic\.edu\.ph$/', $email)) {
        $register_error = "Please use your institutional email (@sic.edu.ph)!";
    } elseif ($password !== $confirmPassword) {
        $register_error = "Passwords do not match!";
    } elseif ($role !== 'student' && $role !== 'teacher') {
        $register_error = "Please select your role!";
    } else {
        $stmt = $conn->prepare("SELECT * FROM account WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $register_error = "Email already registered!";
        } else {
            $hashedPassword = $password; // For production, use password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO account (email, password, role) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $email, $hashedPassword, $role);

            if ($stmt->execute()) {
                header("Location: login.php?registered=1");
                exit();
            } else {
                $register_error = "Error registering account: " . $stmt->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>San Isidro College - Lost & Found System</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(rgba(30,60,120,0.5), rgba(2,136,209,0.5)), url('sicbuilding.jpg') no-repeat center center fixed;
        background-size: cover;
        margin: 0;
        padding: 0;
        color: #333;
    }
    header { background: #116DD2cc; color: white; text-align: center; padding: 20px 0; }
    header .logo-container { display: flex; align-items: center; justify-content: center; flex-direction: column; }
    header .logo { max-width: 150px; }
    header .college-title h2, header .college-title h3 { margin: 0; }
    .container { display: flex; justify-content: center; margin: 30px; }
    .auth-card {
        display: flex;
        width: 80%;
        max-width: 900px;
        background: rgba(255,255,255,0.97);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
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
    }
    .right-side {
        padding: 30px;
        flex: 1;
    }
    h1 { margin-bottom: 20px; }
    .account-prompt { font-size: 1.2em; margin: 10px 0; }
    .secondary-btn {
        background: #FFB300;
        color: white;
        padding: 10px;
        border: none;
        cursor: pointer;
        border-radius: 4px;
        text-decoration: none;
        display: inline-block;
        margin-top: 10px;
    }
    .secondary-btn:hover { background: #FF9800; }
    form {
        display: flex;
        flex-direction: column;
        gap: 15px;
        background: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .input-container {
        display: flex;
        flex-direction: column;
    }
    input, select {
        padding: 10px;
        font-size: 1em;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    select {
        background: #f9f9f9;
    }
    button {
        background: #116DD2;
        color: white;
        padding: 10px;
        border: none;
        font-weight: bold;
        cursor: pointer;
        border-radius: 4px;
        font-size: 1em;
    }
    button:hover { background: #1642BF; }
    .error-message {
        color: red;
        margin-bottom: 10px;
        text-align: center;
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
        <img src="logo.png" alt="San Isidro College Logo" class="logo" />
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
                <h1>Welcome!</h1>
                <p class="account-prompt">Already have an account?</p>
                <a href="login.php" class="secondary-btn">LOG IN</a>
            </div>
            <div class="right-side">
                <h2>Register Account</h2>
                <p class="email-prompt">Enter your Institutional email account:</p>
                <?php if ($register_error): ?>
                    <div class="error-message"><?php echo $register_error; ?></div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="input-container">
                        <input type="email" id="email" name="email" placeholder="Email" required pattern="^[a-zA-Z0-9._%+-]+@sic\.edu\.ph$" title="Use your institutional email (@sic.edu.ph)" />
                    </div>
                    <div class="input-container">
                        <input type="password" id="password" name="password" placeholder="Password" required />
                    </div>
                    <div class="input-container">
                        <input type="password" id="confirm-password" name="confirm-password" placeholder="Repeat Password" required />
                    </div>
                    <div class="input-container">
                        <select name="role" required>
                            <option value="">Select Role</option>
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                        </select>
                    </div>
                    <button type="submit" class="btn primary-btn">REGISTER</button>
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
