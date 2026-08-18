<?php
// delete_cookie.php
echo "<h2>Delete Cookie</h2>";

// Delete cookie function
function deleteCookie($cookie_name) {
    if (isset($_COOKIE[$cookie_name])) {
        // Set cookie with past expiration date
        setcookie($cookie_name, "", time() - 3600, "/");
        return true;
    }
    return false;
}

// Handle cookie deletion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_cookie'])) {
        $cookie_name = $_POST['cookie_name'];
        if (deleteCookie($cookie_name)) {
            echo "<div style='background-color: #d4edda; padding: 15px; border: 1px solid #c3e6cb; margin: 10px 0;'>";
            echo "<strong>Cookie Deleted Successfully!</strong><br>";
            echo "Cookie '$cookie_name' has been deleted.<br>";
            echo "</div>";
        } else {
            echo "<div style='background-color: #f8d7da; padding: 15px; border: 1px solid #f5c6cb; margin: 10px 0;'>";
            echo "<strong>Cookie Not Found!</strong><br>";
            echo "Cookie '$cookie_name' does not exist or was already deleted.<br>";
            echo "</div>";
        }
    }
    
    if (isset($_POST['delete_all_cookies'])) {
        $count = 0;
        foreach ($_COOKIE as $key => $value) {
            setcookie($key, "", time() - 3600, "/");
            $count++;
        }
        echo "<div style='background-color: #d4edda; padding: 15px; border: 1px solid #c3e6cb; margin: 10px 0;'>";
        echo "<strong>All Cookies Deleted!</strong><br>";
        echo "Deleted $count cookies.<br>";
        echo "</div>";
        
        // Refresh the page to update the cookie list
        header("Refresh:0");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Cookie</title>
    <style>
        .delete-form {
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            max-width: 400px;
            margin: 20px 0;
        }
        .delete-form input {
            padding: 8px;
            margin: 5px 0;
            width: 100%;
            box-sizing: border-box;
        }
        .delete-form input[type="submit"] {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        .delete-form input[type="submit"]:hover {
            background-color: #d32f2f;
        }
        .delete-form .delete-all {
            background-color: #ff9800;
        }
        .delete-form .delete-all:hover {
            background-color: #f57c00;
        }
    </style>
</head>
<body>
    <div class="delete-form">
        <h3>Delete a Specific Cookie</h3>
        <form method="POST">
            <label>Cookie Name to Delete:</label>
            <select name="cookie_name" required>
                <option value="">Select a cookie</option>
                <?php
                if (count($_COOKIE) > 0) {
                    foreach ($_COOKIE as $key => $value) {
                        echo "<option value='$key'>$key</option>";
                    }
                } else {
                    echo "<option value=''>No cookies available</option>";
                }
                ?>
            </select>
            <input type="submit" name="delete_cookie" value="Delete Cookie">
        </form>
    </div>
    
    <div class="delete-form">
        <h3>Delete All Cookies</h3>
        <form method="POST">
            <input type="submit" name="delete_all_cookies" value="Delete All Cookies" class="delete-all">
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
            echo "No cookies available. You can create cookies in the previous examples.";
        }
        ?>
    </div>
</body>
</html>