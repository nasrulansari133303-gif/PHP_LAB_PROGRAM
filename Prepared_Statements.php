<?php
// prepared_statements.php
echo "<h2>PHP MySQL Prepared Statements Demonstration</h2>";

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'testdb');

// Method 1: MySQLi Prepared Statements
echo "<h3>Method 1: MySQLi Prepared Statements</h3>";
try {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($mysqli->connect_error) {
        throw new Exception("Connection failed: " . $mysqli->connect_error);
    }
    
    // 1. INSERT with prepared statement
    echo "<strong>1. INSERT with Prepared Statement:</strong><br>";
    $stmt = $mysqli->prepare("INSERT INTO users (username, email, password, full_name, gender) VALUES (?, ?, ?, ?, ?)");
    $username = "prep_user";
    $email = "prep@example.com";
    $password = password_hash("pass123", PASSWORD_DEFAULT);
    $full_name = "Prepared User";
    $gender = "Male";
    
    $stmt->bind_param("sssss", $username, $email, $password, $full_name, $gender);
    
    if ($stmt->execute()) {
        echo "✅ Inserted successfully. ID: " . $stmt->insert_id . "<br>";
    } else {
        echo "❌ Error: " . $stmt->error . "<br>";
    }
    $stmt->close();
    
    // 2. SELECT with prepared statement
    echo "<br><strong>2. SELECT with Prepared Statement:</strong><br>";
    $stmt = $mysqli->prepare("SELECT id, username, email, full_name FROM users WHERE gender = ? AND status = ?");
    $gender = "Male";
    $status = "Active";
    $stmt->bind_param("ss", $gender, $status);
    $stmt->execute();
    $result = $stmt->get_result();
    
    echo "Male users:<br>";
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row['id'] . ", Username: " . $row['username'] . ", Email: " . $row['email'] . "<br>";
    }
    $stmt->close();
    
    // 3. UPDATE with prepared statement
    echo "<br><strong>3. UPDATE with Prepared Statement:</strong><br>";
    $stmt = $mysqli->prepare("UPDATE users SET status = ? WHERE username = ?");
    $new_status = "Suspended";
    $username = "prep_user";
    $stmt->bind_param("ss", $new_status, $username);
    
    if ($stmt->execute()) {
        echo "✅ Updated " . $stmt->affected_rows . " row(s)<br>";
    } else {
        echo "❌ Error: " . $stmt->error . "<br>";
    }
    $stmt->close();
    
    // 4. DELETE with prepared statement (soft delete - updating status)
    echo "<br><strong>4. DELETE (Soft Delete) with Prepared Statement:</strong><br>";
    $stmt = $mysqli->prepare("UPDATE users SET status = 'Inactive' WHERE username = ?");
    $username = "prep_user";
    $stmt->bind_param("s", $username);
    
    if ($stmt->execute()) {
        echo "✅ Soft deleted user: " . $username . "<br>";
    } else {
        echo "❌ Error: " . $stmt->error . "<br>";
    }
    $stmt->close();
    
    // 5. SELECT with LIKE pattern
    echo "<br><strong>5. SELECT with LIKE Pattern:</strong><br>";
    $stmt = $mysqli->prepare("SELECT username, email FROM users WHERE username LIKE ?");
    $pattern = "%j%";
    $stmt->bind_param("s", $pattern);
    $stmt->execute();
    $result = $stmt->get_result();
    
    echo "Users with 'j' in username:<br>";
    while ($row = $result->fetch_assoc()) {
        echo "Username: " . $row['username'] . ", Email: " . $row['email'] . "<br>";
    }
    $stmt->close();
    
    $mysqli->close();
    
} catch (Exception $e) {
    echo "❌ " . $e->getMessage() . "<br>";
}

// Method 2: PDO Prepared Statements
echo "<h3>Method 2: PDO Prepared Statements</h3>";
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // 1. INSERT with PDO prepared statement
    echo "<strong>1. INSERT with PDO Prepared Statement:</strong><br>";
    $sql = "INSERT INTO products (product_name, description, price, quantity, category) 
            VALUES (:name, :desc, :price, :qty, :cat)";
    $stmt = $pdo->prepare($sql);
    
    $data = [
        ':name' => 'PDO Product',
        ':desc' => 'Product created with PDO prepared statement',
        ':price' => 299.99,
        ':qty' => 15,
        ':cat' => 'Electronics'
    ];
    
    if ($stmt->execute($data)) {
        echo "✅ Inserted successfully. ID: " . $pdo->lastInsertId() . "<br>";
    }
    
    // 2. SELECT with PDO prepared statement
    echo "<br><strong>2. SELECT with PDO Prepared Statement:</strong><br>";
    $sql = "SELECT product_name, price, quantity FROM products WHERE category = :category AND quantity > :min_qty";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':category' => 'Electronics', ':min_qty' => 5]);
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Electronics products with quantity > 5:<br>";
    foreach ($results as $row) {
        echo "Product: " . $row['product_name'] . ", Price: $" . $row['price'] . ", Qty: " . $row['quantity'] . "<br>";
    }
    
    // 3. UPDATE with PDO prepared statement
    echo "<br><strong>3. UPDATE with PDO Prepared Statement:</strong><br>";
    $sql = "UPDATE products SET quantity = quantity + :add_qty WHERE product_name = :name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':add_qty' => 5, ':name' => 'PDO Product']);
    
    echo "✅ Updated " . $stmt->rowCount() . " row(s)<br>";
    
    // 4. DELETE with PDO prepared statement
    echo "<br><strong>4. DELETE with PDO Prepared Statement:</strong><br>";
    $sql = "DELETE FROM products WHERE product_name = :name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':name' => 'PDO Product']);
    
    echo "✅ Deleted " . $stmt->rowCount() . " row(s)<br>";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

// Benefits of Prepared Statements
echo "<h3>Benefits of Prepared Statements:</h3>";
echo "<ul>";
echo "<li>✅ Protection against SQL injection</li>";
echo "<li>✅ Better performance (prepared statements are compiled once)</li>";
echo "<li>✅ Cleaner code with parameter binding</li>";
echo "<li>✅ Automatic handling of data types</li>";
echo "<li>✅ Support for complex queries</li>";
echo "</ul>";
?>