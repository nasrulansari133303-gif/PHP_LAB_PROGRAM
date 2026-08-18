<?php
// create_session.php
session_start();

echo "<h2>Create Session</h2>";

// Set session variables
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_session'])) {
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['login_time'] = date("Y-m-d H:i:s");
    $_SESSION['user_id'] = rand(1000, 9999);
    
    echo "<div style='background-color: #d4edda; padding: 15px; border: 1px solid #c3e6cb; margin: 10px 0;'>";
    echo "<strong>Session Created Successfully!</strong><br>";
    echo "Welcome, " . $_SESSION['username'] . "!<br>";
    echo "Session ID: " . session_id() . "<br>";
    echo "</div>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Session</title>
    <style>
        .session-form {
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            max-width: 400px;
            margin: 20px 0;
        }
        .session-form input {
            padding: 8px;
            margin: 5px 0;
            width: 100%;
            box-sizing: border-box;
        }
        .session-form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        .session-form input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="session-form">
        <h3>Create a Session</h3>
        <form method="POST">
            <label>Username:</label>
            <input type="text" name="username" placeholder="Enter username" required>
            
            <label>Email:</label>
            <input type="email" name="email" placeholder="Enter email" required>
            
            <input type="submit" name="create_session" value="Create Session">
        </form>
    </div>
    
    <div style="margin-top: 20px;">
        <h3>Session Information:</h3>
        <?php
        if (session_status() == PHP_SESSION_ACTIVE) {
            echo "<table border='1' cellpadding='8'>";
            echo "<tr><th>Session Key</th><th>Value</th></tr>";
            foreach ($_SESSION as $key => $value) {
                echo "<tr><td>$key</td><td>$value</td></tr>";
            }
            echo "</table>";
            
            echo "<br><strong>Session ID:</strong> " . session_id() . "<br>";
            echo "<strong>Session Status:</strong> Active<br>";
            echo "<strong>Session Name:</strong> " . session_name() . "<br>";
        } else {
            echo "No session active. Please create a session.";
        }
        ?>
    </div>
</body>
</html>