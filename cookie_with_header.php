<?php
// cookie_with_header.php
echo "<h2>Cookie with Header</h2>";

// Set cookie using setcookie() which sends HTTP headers
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['set_cookie'])) {
    $name = $_POST['name'];
    $value = $_POST['value'];
    $expire = time() + (3600 * 24 * 30); // 30 days
    
    // Set cookie - this must be before any HTML output
    setcookie($name, $value, $expire, "/");
    
    // Redirect to show cookie was set
    header("Location: " . $_SERVER['PHP_SELF'] . "?cookie_set=1");
    exit();
}

// Check if cookie was just set
if (isset($_GET['cookie_set']) && $_GET['cookie_set'] == 1) {
    echo "<div style='background-color: #d4edda; padding: 15px; border: 1px solid #c3e6cb; margin: 10px 0;'>";
    echo "<strong>Cookie set successfully using header!</strong><br>";
    echo "</div>";
}

// Set a cookie using header() function directly
if (isset($_POST['set_header_cookie'])) {
    $header_name = $_POST['header_cookie_name'];
    $header_value = $_POST['header_cookie_value'];
    
    // Using header() to set cookie
    header("Set-Cookie: $header_name=$header_value; path=/; expires=" . gmdate('D, d M Y H:i:s T', time() + 3600 * 24 * 30));
    
    echo "<div style='background-color: #d4edda; padding: 15px; border: 1px solid #c3e6cb; margin: 10px 0;'>";
    echo "<strong>Cookie set using header() function!</strong><br>";
    echo "Name: $header_name<br>";
    echo "Value: $header_value<br>";
    echo "</div>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cookie with Header</title>
    <style>
        .form-container {
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            max-width: 400px;
            margin: 20px 0;
        }
        .form-container input {
            padding: 8px;
            margin: 5px 0;
            width: 100%;
            box-sizing: border-box;
        }
        .form-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        .form-container input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <!-- Method 1: Using setcookie() -->
    <div class="form-container">
        <h3>Method 1: Using setcookie()</h3>
        <form method="POST">
            <label>Cookie Name:</label>
            <input type="text" name="name" placeholder="Enter cookie name" required>
            
            <label>Cookie Value:</label>
            <input type="text" name="value" placeholder="Enter cookie value" required>
            
            <input type="submit" name="set_cookie" value="Set Cookie (setcookie)">
        </form>
    </div>
    
    <!-- Method 2: Using header() -->
    <div class="form-container">
        <h3>Method 2: Using header()</h3>
        <form method="POST">
            <label>Cookie Name:</label>
            <input type="text" name="header_cookie_name" placeholder="Enter cookie name" required>
            
            <label>Cookie Value:</label>
            <input type="text" name="header_cookie_value" placeholder="Enter cookie value" required>
            
            <input type="submit" name="set_header_cookie" value="Set Cookie (header)">
        </form>
    </div>
    
    <div style="margin-top: 20px;">
        <h3>Current Cookies:</h3>
        <?php
        if (count($_COOKIE) > 0) {
            echo "<table border='1' cellpadding='8'>";
            echo "<tr><th>Cookie Name</th><th>Cookie Value</th></tr>";
            foreach ($_COOKIE as $key => $value) {
                echo "<tr><td>$key</td><td>$value</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No cookies set yet.";
        }
        ?>
    </div>
    
    <div style="margin-top: 20px; background-color: #fff3cd; padding: 15px; border: 1px solid #ffeeba;">
        <h4>Important Note:</h4>
        <p>Cookies must be set before any HTML output. Both setcookie() and header() 
        methods send HTTP headers, so they must be called before any content is sent 
        to the browser.</p>
    </div>
</body>
</html>