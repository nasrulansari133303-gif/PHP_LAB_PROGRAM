<?php
// create_cookie.php
echo "<h2>Create Cookie</h2>";

// Set cookie if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_cookie'])) {
    $cookie_name = $_POST['cookie_name'];
    $cookie_value = $_POST['cookie_value'];
    $cookie_expiry = $_POST['cookie_expiry'];
    
    // Calculate expiry time
    $expiry_time = time() + ($cookie_expiry * 24 * 60 * 60); // Convert days to seconds
    
    // Set cookie
    setcookie($cookie_name, $cookie_value, $expiry_time, "/");
    
    echo "<div style='background-color: #d4edda; padding: 15px; border: 1px solid #c3e6cb; margin: 10px 0;'>";
    echo "<strong>Cookie Created Successfully!</strong><br>";
    echo "Cookie Name: $cookie_name<br>";
    echo "Cookie Value: $cookie_value<br>";
    echo "Expires in: $cookie_expiry days<br>";
    echo "</div>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Cookie</title>
    <style>
        .cookie-form {
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            max-width: 400px;
            margin: 20px 0;
        }
        .cookie-form input {
            padding: 8px;
            margin: 5px 0;
            width: 100%;
            box-sizing: border-box;
        }
        .cookie-form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        .cookie-form input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="cookie-form">
        <h3>Create a Cookie</h3>
        <form method="POST">
            <label>Cookie Name:</label>
            <input type="text" name="cookie_name" placeholder="Enter cookie name" required>
            
            <label>Cookie Value:</label>
            <input type="text" name="cookie_value" placeholder="Enter cookie value" required>
            
            <label>Expiry (days):</label>
            <input type="number" name="cookie_expiry" value="30" min="1" required>
            
            <input type="submit" name="create_cookie" value="Create Cookie">
        </form>
    </div>
    
    <div style="margin-top: 20px;">
        <h3>Current Cookies:</h3>
        <?php
        if (count($_COOKIE) > 0) {
            echo "<ul>";
            foreach ($_COOKIE as $key => $value) {
                echo "<li><strong>$key:</strong> $value</li>";
            }
            echo "</ul>";
        } else {
            echo "No cookies set yet.";
        }
        ?>
    </div>
</body>
</html>