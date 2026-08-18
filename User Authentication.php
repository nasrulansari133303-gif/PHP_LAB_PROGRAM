<?php
// login_authentication.php
session_start();

echo "<h2>User Authentication System</h2>";

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'testdb');

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT id, username, email, password, full_name, status FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            // Check if user is active
            if ($user['status'] != 'Active') {
                $error = "Your account is " . $user['status'] . ". Please contact support.";
            } else {
                // Verify password
                if (password_verify($password, $user['password'])) {
                    // Login successful
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['full_name'] = $user['full_name'];
                    $_SESSION['login_time'] = date("Y-m-d H:i:s");
                    
                    // Update last login time
                    $update_stmt = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                    $update_stmt->bind_param("i", $user['id']);
                    $update_stmt->execute();
                    $update_stmt->close();
                    
                    header("Location: " . $_SERVER['PHP_SELF'] . "?page=home");
                    exit();
                } else {
                    $error = "Invalid password!";
                }
            }
        } else {
            $error = "Username or email not found!";
        }
        
        $stmt->close();
        $conn->close();
        
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    $_SESSION = array();
    
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF'] . "?page=login");
    exit();
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['username']);
}

// Get current page
$page = isset($_GET['page']) ? $_GET['page'] : 'login';

// If not logged in and trying to access home, show login
if ($page == 'home' && !isLoggedIn()) {
    $page = 'login';
}

// If logged in and trying to access login, show home
if ($page == 'login' && isLoggedIn()) {
    $page = 'home';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Authentication</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 450px;
        }
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
            font-size: 14px;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        .form-group input:focus {
            border-color: #667eea;
            outline: none;
        }
        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        .btn-logout {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .btn-logout:hover {
            box-shadow: 0 5px 20px rgba(245, 87, 108, 0.4);
        }
        .error {
            background-color: #ffebee;
            color: #c62828;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #c62828;
        }
        .success {
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #2e7d32;
        }
        .user-info {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .user-info p {
            margin: 8px 0;
            color: #555;
        }
        .user-info strong {
            color: #333;
        }
        .info-text {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-top: 20px;
        }
        .info-text a {
            color: #667eea;
            text-decoration: none;
        }
        .info-text a:hover {
            text-decoration: underline;
        }
        .register-link {
            margin-top: 20px;
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($page == 'login'): ?>
            <!-- Login Page -->
            <h2>🔐 Login</h2>
            
            <?php if (isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if (isset($_GET['registered']) && $_GET['registered'] == 1): ?>
                <div class="success">Registration successful! Please login.</div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username or Email</label>
                    <input type="text" id="username" name="username" 
                           placeholder="Enter your username or email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" 
                           placeholder="Enter your password" required>
                </div>
                
                <button type="submit" name="login" class="btn">Login</button>
            </form>
            
            <div class="register-link">
                <p>Don't have an account? <a href="4.10_edit_profile.php">Register here</a></p>
            </div>
            
            <div style="margin-top: 20px; padding: 15px; background: #f5f5f5; border-radius: 8px;">
                <p style="font-size: 13px; color: #666; text-align: center;">
                    <strong>Demo Credentials:</strong><br>
                    Username: john_doe<br>
                    Password: password123
                </p>
            </div>
            
        <?php else: ?>
            <!-- Home Page -->
            <h2>🏠 Welcome</h2>
            
            <div class="success">
                ✅ You are successfully logged in!
            </div>
            
            <div class="user-info">
                <h3 style="color: #333; margin-bottom: 15px;">User Profile</h3>
                <p><strong>User ID:</strong> <?php echo $_SESSION['user_id']; ?></p>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
                <p><strong>Full Name:</strong> <?php echo htmlspecialchars($_SESSION['full_name']); ?></p>
                <p><strong>Login Time:</strong> <?php echo $_SESSION['login_time']; ?></p>
                <p><strong>Session ID:</strong> <?php echo session_id(); ?></p>
            </div>
            
            <form method="GET">
                <button type="submit" name="logout" value="1" class="btn btn-logout">Logout</button>
            </form>
            
            <div style="margin-top: 20px; padding: 15px; background: #e3f2fd; border-radius: 8px; border-left: 4px solid #1976d2;">
                <p style="color: #1976d2; font-size: 14px;">
                    <strong>Protected Content:</strong> This page is only accessible to authenticated users.
                    Try accessing it directly after logging out - you'll be redirected to the login page.
                </p>
            </div>
            
        <?php endif; ?>
    </div>
</body>
</html>