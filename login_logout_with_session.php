<?php
// login_logout.php - Main file with login, logout, and home page functionality
session_start();

// Database connection (replace with your credentials)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'testdb';

try {
    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    // If database doesn't exist, use hardcoded credentials for demo
    $useDatabase = false;
}

// Hardcoded users for demonstration (if database not available)
$demoUsers = array(
    'admin' => 'password123',
    'user' => 'user123',
    'john' => 'john123'
);

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Try database login if available
    if (isset($conn) && $conn && !$conn->connect_error) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['login_time'] = date("Y-m-d H:i:s");
            header("Location: " . $_SERVER['PHP_SELF'] . "?page=home");
            exit();
        } else {
            $login_error = "Invalid username or password!";
        }
    } else {
        // Demo login
        if (isset($demoUsers[$username]) && $demoUsers[$username] == $password) {
            $_SESSION['user_id'] = rand(1, 100);
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $username . '@example.com';
            $_SESSION['login_time'] = date("Y-m-d H:i:s");
            header("Location: " . $_SERVER['PHP_SELF'] . "?page=home");
            exit();
        } else {
            $login_error = "Invalid username or password!";
        }
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    // Clear all session variables
    $_SESSION = array();
    
    // Delete session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // Destroy session
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF'] . "?page=login");
    exit();
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['username']);
}

// Get current page
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// If not logged in and trying to access home, redirect to login
if ($page == 'home' && !isLoggedIn()) {
    header("Location: " . $_SERVER['PHP_SELF'] . "?page=login");
    exit();
}

// If logged in and trying to access login, redirect to home
if ($page == 'login' && isLoggedIn()) {
    header("Location: " . $_SERVER['PHP_SELF'] . "?page=home");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login System with Session</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
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
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        .form-group input:focus {
            border-color: #4CAF50;
            outline: none;
        }
        button, .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }
        button:hover, .btn:hover {
            background-color: #45a049;
        }
        .btn-logout {
            background-color: #f44336;
        }
        .btn-logout:hover {
            background-color: #d32f2f;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            border: 1px solid #f5c6cb;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            border: 1px solid #c3e6cb;
        }
        .user-info {
            background-color: #e8f4f8;
            padding: 15px;
            border-radius: 4px;
            margin: 15px 0;
            border-left: 4px solid #4CAF50;
        }
        .nav {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }
        .nav a {
            margin-right: 15px;
            color: #4CAF50;
            text-decoration: none;
        }
        .nav a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($page == 'login'): ?>
            <!-- Login Page -->
            <h2>Login</h2>
            <?php if (isset($login_error)): ?>
                <div class="error"><?php echo $login_error; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" placeholder="Enter username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                </div>
                <button type="submit" name="login">Login</button>
            </form>
            
            <div style="margin-top: 20px; background-color: #fff3cd; padding: 15px; border-radius: 4px; border: 1px solid #ffeeba;">
                <strong>Demo Credentials:</strong><br>
                admin / password123<br>
                user / user123<br>
                john / john123
            </div>
            
        <?php elseif ($page == 'home'): ?>
            <!-- Home Page -->
            <div class="nav">
                <span style="float: right;">
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?logout=1" class="btn btn-logout">Logout</a>
                </span>
                <h2>Home Page</h2>
            </div>
            
            <div class="success">
                <strong>Welcome to the Home Page!</strong>
            </div>
            
            <div class="user-info">
                <h3>User Information:</h3>
                <p><strong>User ID:</strong> <?php echo $_SESSION['user_id']; ?></p>
                <p><strong>Username:</strong> <?php echo $_SESSION['username']; ?></p>
                <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
                <p><strong>Login Time:</strong> <?php echo $_SESSION['login_time']; ?></p>
                <p><strong>Session ID:</strong> <?php echo session_id(); ?></p>
            </div>
            
            <div style="margin-top: 20px; padding: 15px; background-color: #e8f5e9; border-radius: 4px; border-left: 4px solid #4CAF50;">
                <h4>Protected Content</h4>
                <p>This content is only visible to logged-in users. If you try to access this page 
                directly without logging in, you will be redirected to the login page.</p>
            </div>
            
        <?php endif; ?>
    </div>
</body>
</html>