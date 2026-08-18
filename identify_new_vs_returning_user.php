<?php
// new_returning_user.php
echo "<h2>New vs Returning User Identification</h2>";

// Set cookie for user identification
$cookie_name = "user_visit";
$cookie_expiry = time() + (30 * 24 * 60 * 60); // 30 days

// Check if cookie exists
if (isset($_COOKIE[$cookie_name])) {
    // Returning user
    $visit_data = unserialize($_COOKIE[$cookie_name]);
    $visit_count = $visit_data['count'] + 1;
    $first_visit = $visit_data['first_visit'];
    $last_visit = date("Y-m-d H:i:s");
    
    // Update cookie
    $visit_data = array(
        'count' => $visit_count,
        'first_visit' => $first_visit,
        'last_visit' => $last_visit
    );
    setcookie($cookie_name, serialize($visit_data), $cookie_expiry, "/");
    
    $user_type = "Returning User";
    $message = "Welcome back! This is your $visit_count visit.";
} else {
    // New user
    $visit_count = 1;
    $first_visit = date("Y-m-d H:i:s");
    $last_visit = $first_visit;
    
    // Set cookie for new user
    $visit_data = array(
        'count' => $visit_count,
        'first_visit' => $first_visit,
        'last_visit' => $last_visit
    );
    setcookie($cookie_name, serialize($visit_data), $cookie_expiry, "/");
    
    $user_type = "New User";
    $message = "Welcome! This is your first visit.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>New vs Returning User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .user-info {
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .new-user {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .returning-user {
            background-color: #cce5ff;
            border: 1px solid #b8daff;
            color: #004085;
        }
        .stats {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 4px;
            margin-top: 20px;
            border-left: 4px solid #4CAF50;
        }
        .actions {
            margin-top: 20px;
        }
        .btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-right: 10px;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .btn-delete {
            background-color: #f44336;
        }
        .btn-delete:hover {
            background-color: #d32f2f;
        }
        .btn-refresh {
            background-color: #2196F3;
        }
        .btn-refresh:hover {
            background-color: #1976D2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Identification System</h2>
        
        <div class="user-info <?php echo ($user_type == 'New User') ? 'new-user' : 'returning-user'; ?>">
            <h3><?php echo $user_type; ?></h3>
            <p><?php echo $message; ?></p>
        </div>
        
        <div class="stats">
            <h4>Visit Statistics:</h4>
            <p><strong>Total Visits:</strong> <?php echo $visit_count; ?></p>
            <p><strong>First Visit:</strong> <?php echo $first_visit; ?></p>
            <p><strong>Last Visit:</strong> <?php echo $last_visit; ?></p>
            <p><strong>Cookie Name:</strong> <?php echo $cookie_name; ?></p>
        </div>
        
        <div class="actions">
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-refresh">Refresh Page</a>
            
            <?php if (isset($_GET['delete']) && $_GET['delete'] == 'cookie'): ?>
                <?php
                // Delete the cookie
                setcookie($cookie_name, "", time() - 3600, "/");
                echo "<div style='background-color: #f8d7da; padding: 15px; border-radius: 4px; margin: 10px 0; border: 1px solid #f5c6cb;'>";
                echo "<strong>Cookie deleted! Refresh the page to be treated as a new user.</strong>";
                echo "</div>";
                ?>
            <?php else: ?>
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>?delete=cookie" class="btn btn-delete">Delete Cookie (Reset)</a>
            <?php endif; ?>
        </div>
        
        <div style="margin-top: 20px; background-color: #fff3cd; padding: 15px; border-radius: 4px; border: 1px solid #ffeeba;">
            <h4>How it works:</h4>
            <ol>
                <li>When you first visit, a cookie is created to store your visit information</li>
                <li>On subsequent visits, the cookie is read to identify you as a returning user</li>
                <li>Visit count, first visit time, and last visit time are tracked</li>
                <li>Cookie expires after 30 days of inactivity</li>
            </ol>
        </div>
        
        <div style="margin-top: 20px; background-color: #e8f4f8; padding: 15px; border-radius: 4px; border-left: 4px solid #2196F3;">
            <h4>All Cookies:</h4>
            <?php
            if (count($_COOKIE) > 0) {
                echo "<ul>";
                foreach ($_COOKIE as $key => $value) {
                    echo "<li><strong>$key:</strong> $value</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No cookies set.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>