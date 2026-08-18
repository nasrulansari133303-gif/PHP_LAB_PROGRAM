<?php
// destroy_session.php
session_start();

echo "<h2>Destroy Session</h2>";

// Handle session destruction
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['destroy_session'])) {
        // Clear all session variables
        $_SESSION = array();
        
        // If session cookie is used, delete it
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Finally, destroy the session
        session_destroy();
        
        echo "<div style='background-color: #d4edda; padding: 15px; border: 1px solid #c3e6cb; margin: 10px 0;'>";
        echo "<strong>Session Destroyed Successfully!</strong><br>";
        echo "All session data has been cleared.<br>";
        echo "</div>";
    }
    
    if (isset($_POST['unset_session'])) {
        // Remove specific session variables
        unset($_SESSION['username']);
        unset($_SESSION['email']);
        
        echo "<div style='background-color: #d4edda; padding: 15px; border: 1px solid #c3e6cb; margin: 10px 0;'>";
        echo "<strong>Specific Session Variables Unset!</strong><br>";
        echo "Username and email have been removed from session.<br>";
        echo "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Destroy Session</title>
    <style>
        .destroy-form {
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            max-width: 400px;
            margin: 20px 0;
        }
        .destroy-form input[type="submit"] {
            padding: 10px;
            margin: 5px 0;
            width: 100%;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .destroy-form .destroy-btn {
            background-color: #f44336;
            color: white;
        }
        .destroy-form .destroy-btn:hover {
            background-color: #d32f2f;
        }
        .destroy-form .unset-btn {
            background-color: #ff9800;
            color: white;
        }
        .destroy-form .unset-btn:hover {
            background-color: #f57c00;
        }
    </style>
</head>
<body>
    <div class="destroy-form">
        <h3>Session Management</h3>
        <form method="POST">
            <input type="submit" name="destroy_session" value="Destroy Entire Session" class="destroy-btn">
            <br><br>
            <input type="submit" name="unset_session" value="Unset Specific Session Variables" class="unset-btn">
        </form>
    </div>
    
    <div style="margin-top: 20px;">
        <h3>Current Session Data:</h3>
        <?php
        if (session_status() == PHP_SESSION_ACTIVE) {
            if (count($_SESSION) > 0) {
                echo "<table border='1' cellpadding='8'>";
                echo "<tr><th>Session Key</th><th>Value</th></tr>";
                foreach ($_SESSION as $key => $value) {
                    echo "<tr><td>$key</td><td>$value</td></tr>";
                }
                echo "</table>";
                echo "<br><strong>Session ID:</strong> " . session_id() . "<br>";
            } else {
                echo "<em>Session is active but empty. Data has been cleared.</em>";
            }
        } else {
            echo "<em>No session active. Please create a session first.</em>";
        }
        ?>
    </div>
    
    <div style="margin-top: 20px; background-color: #fff3cd; padding: 15px; border: 1px solid #ffeeba;">
        <h4>Session Destruction Process:</h4>
        <ol>
            <li>Clear all session variables using $_SESSION = array()</li>
            <li>Delete the session cookie if it exists</li>
            <li>Destroy the session using session_destroy()</li>
        </ol>
        <p><strong>Note:</strong> After destroying a session, you need to start a new session 
        with session_start() to use session features again.</p>
    </div>
</body>
</html>