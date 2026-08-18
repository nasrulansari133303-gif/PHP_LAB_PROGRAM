<?php
// read_cookie.php
echo "<h2>Read Cookie</h2>";

// Check if cookie name is provided
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['read_cookie'])) {
    $cookie_name = $_POST['cookie_name'];
    
    if (isset($_COOKIE[$cookie_name])) {
        echo "<div style='background-color: #d4edda; padding: 15px; border: 1px solid #c3e6cb; margin: 10px 0;'>";
        echo "<strong>Cookie Found!</strong><br>";
        echo "Cookie Name: $cookie_name<br>";
        echo "Cookie Value: " . $_COOKIE[$cookie_name] . "<br>";
        echo "</div>";
    } else {
        echo "<div style='background-color: #f8d7da; padding: 15px; border: 1px solid #f5c6cb; margin: 10px 0;'>";
        echo "<strong>Cookie Not Found!</strong><br>";
        echo "Cookie '$cookie_name' does not exist.<br>";
        echo "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Read Cookie</title>
    <style>
        .read-form {
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            max-width: 400px;
            margin: 20px 0;
        }
        .read-form input {
            padding: 8px;
            margin: 5px 0;
            width: 100%;
            box-sizing: border-box;
        }
        .read-form input[type="submit"] {
            background-color: #2196F3;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        .read-form input[type="submit"]:hover {
            background-color: #1976D2;
        }
    </style>
</head>
<body>
    <div class="read-form">
        <h3>Read a Cookie</h3>
        <form method="POST">
            <label>Cookie Name:</label>
            <input type="text" name="cookie_name" placeholder="Enter cookie name to read" required>
            <input type="submit" name="read_cookie" value="Read Cookie">
        </form>
    </div>
    
    <div style="margin-top: 20px;">
        <h3>All Available Cookies:</h3>
        <?php
        if (count($_COOKIE) > 0) {
            echo "<table border='1' cellpadding='8'>";
            echo "<tr><th>Cookie Name</th><th>Cookie Value</th></tr>";
            foreach ($_COOKIE as $key => $value) {
                echo "<tr><td>$key</td><td>$value</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No cookies available.";
        }
        ?>
    </div>
</body>
</html>