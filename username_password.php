<?php
// remember_me_login.php
echo "<h2>Remember Me Login</h2>";

// Check if remember me cookie exists
$remembered_username = '';
$remembered_password = '';

if (isset($_COOKIE['remember_username'])) {
    $remembered_username = $_COOKIE['remember_username'];
}
if (isset($_COOKIE['remember_password'])) {
    $remembered_password = $_COOKIE['remember_password'];
}

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember_me = isset($_POST['remember_me']) ? $_POST['remember_me'] : '';
    
    // Validate credentials (demo)
    $valid_username = 'admin';
    $valid_password = 'password123';
    
    if ($username == $valid_username && $password == $valid_password) {
        // Set session
        session_start();
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['login_time'] = date("Y-m-d H:i:s");
        
        // Set remember me cookies if checked
        if ($remember_me == 'on') {
            $expiry = time() + (30 * 24 * 60 * 60); // 30 days
            setcookie('remember_username', $username, $expiry, "/");
            setcookie('remember_password', $password, $expiry, "/");
            setcookie('remember_me', 'true', $expiry, "/");
            
            $login_message = "Login successful! Credentials remembered for 30 days.";
        } else {
            // Clear remember me cookies if they exist
            setcookie('remember_username', '', time() - 3600, "/");
            setcookie('remember_password', '', time() - 3600, "/");
            setcookie('remember_me', '', time() - 3600, "/");
            
            $login_message = "Login successful! Credentials not remembered.";
        }
        
        echo "<div style='background-color: #d4edda; padding: 15px; border: 1px solid #c3e6cb; margin: 10px 0;'>";
        echo "<strong>$login_message</strong><br>";
        echo "Welcome, $username!<br>";
        echo "</div>";
    } else {
        echo "<div style='background-color: #f8d7da; padding: 15px; border: 1px solid #f5c6cb; margin: 10px 0;'>";
        echo "<strong>Invalid username or password!</strong>";
        echo "</div>";
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_start();
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Check if logged in
session_start();
$is_logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Remember Me Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .form-group input[type="text"]:focus,
        .form-group input[type="password"]:focus {
            border-color: #4CAF50;
            outline: none;
        }
        .form-group input[type="checkbox"] {
            margin-right: 10px;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .btn-logout {
            background-color: #f44336;
        }
        .btn-logout:hover {
            background-color: #d32f2f;
        }
        .remember-me {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .remember-me input {
            width: auto;
        }
        .user-info {
            background-color: #e8f4f8;
            padding: 15px;
            border-radius: 4px;
            margin: 15px 0;
            border-left: 4px solid #4CAF50;
        }
        .info-box {
            background-color: #fff3cd;
            padding: 15px;
            border-radius: 4px;
            margin-top: 20px;
            border: 1px solid #ffeeba;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($is_logged_in): ?>
            <!-- Logged In View -->
            <h2>Welcome!</h2>
            <div class="user-info">
                <p><strong>Username:</strong> <?php echo $_SESSION['username']; ?></p>
                <p><strong>Login Time:</strong> <?php echo $_SESSION['login_time']; ?></p>
                <?php if (isset($_COOKIE['remember_me']) && $_COOKIE['remember_me'] == 'true'): ?>
                    <p><strong>Status:</strong> Credentials are remembered</p>
                <?php else: ?>
                    <p><strong>Status:</strong> Credentials are not remembered</p>
                <?php endif; ?>
            </div>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?logout=1" class="btn btn-logout">Logout</a>
            
        <?php else: ?>
            <!-- Login Form -->
            <h2>Login</h2>
            
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" 
                           value="<?php echo htmlspecialchars($remembered_username); ?>" 
                           placeholder="Enter username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" 
                           value="<?php echo htmlspecialchars($remembered_password); ?>" 
                           placeholder="Enter password" required>
                </div>
                
                <div class="form-group remember-me">
                    <input type="checkbox" id="remember_me" name="remember_me" 
                           <?php echo isset($_COOKIE['remember_me']) && $_COOKIE['remember_me'] == 'true' ? 'checked' : ''; ?>>
                    <label for="remember_me">Remember me</label>
                </div>
                
                <button type="submit" name="login" class="btn">Login</button>
            </form>
            
            <div class="info-box">
                <strong>Demo Credentials:</strong><br>
                Username: admin<br>
                Password: password123<br><br>
                <strong>How Remember Me works:</strong><br>
                <ul style="margin: 10px 0;">
                    <li>When checked, username and password are stored in cookies for 30 days</li>
                    <li>When unchecked, any existing remember me cookies are deleted</li>
                    <li>Credentials are automatically filled on return visits</li>
                    <li>Cookies are stored securely (though password is plain text in this demo)</li>
                </ul>
            </div>
            
            <?php if (isset($_COOKIE['remember_me']) && $_COOKIE['remember_me'] == 'true'): ?>
                <div style="background-color: #d4edda; padding: 15px; border-radius: 4px; margin-top: 10px; border: 1px solid #c3e6cb;">
                    <strong>You have saved credentials!</strong> Your username and password are remembered.
                </div>
            <?php endif; ?>
            
        <?php endif; ?>
    </div>
</body>
</html>