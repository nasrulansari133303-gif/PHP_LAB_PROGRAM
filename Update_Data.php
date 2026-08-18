<?php
// update_data.php
echo "<h2>Update Data In MySQL Table Using MySQLi and PDO</h2>";

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'testdb');

// Method 1: MySQLi Object-Oriented
echo "<h3>Method 1: MySQLi Object-Oriented</h3>";
try {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($mysqli->connect_error) {
        throw new Exception("Connection failed: " . $mysqli->connect_error);
    }
    
    // 1. UPDATE single field
    echo "<strong>1. UPDATE Single Field:</strong><br>";
    $sql = "UPDATE users SET status = 'Active' WHERE username = 'john_doe'";
    
    if ($mysqli->query($sql) === TRUE) {
        echo "✅ Updated " . $mysqli->affected_rows . " row(s)<br>";
    } else {
        echo "❌ Error: " . $mysqli->error . "<br>";
    }
    
    // 2. UPDATE multiple fields
    echo "<br><strong>2. UPDATE Multiple Fields:</strong><br>";
    $sql = "UPDATE users SET full_name = 'Johnathan Doe', phone = '555-1234' WHERE username = 'john_doe'";
    
    if ($mysqli->query($sql) === TRUE) {
        echo "✅ Updated " . $mysqli->affected_rows . " row(s)<br>";
    } else {
        echo "❌ Error: " . $mysqli->error . "<br>";
    }
    
    // 3. UPDATE with Prepared Statement
    echo "<br><strong>3. UPDATE with Prepared Statement:</strong><br>";
    $stmt = $mysqli->prepare("UPDATE users SET email = ?, phone = ? WHERE username = ?");
    $email = "johnathan@example.com";
    $phone = "555-5678";
    $username = "john_doe";
    $stmt->bind_param("sss", $email, $phone, $username);
    
    if ($stmt->execute()) {
        echo "✅ Updated " . $stmt->affected_rows . " row(s)<br>";
    } else {
        echo "❌ Error: " . $stmt->error . "<br>";
    }
    $stmt->close();
    
    // 4. UPDATE with calculation
    echo "<br><strong>4. UPDATE with Calculation:</strong><br>";
    // Add 10% price increase to all products in Electronics category
    $sql = "UPDATE products SET price = price * 1.10 WHERE category = 'Electronics'";
    
    if ($mysqli->query($sql) === TRUE) {
        echo "✅ Updated " . $mysqli->affected_rows . " product(s) with 10% price increase<br>";
    } else {
        echo "❌ Error: " . $mysqli->error . "<br>";
    }
    
    // 5. UPDATE with JOIN
    echo "<br><strong>5. UPDATE with JOIN:</strong><br>";
    // Update product quantity based on orders
    $sql = "UPDATE products p 
            JOIN orders o ON p.id = o.product_id 
            SET p.quantity = p.quantity - o.quantity 
            WHERE o.status = 'completed'";
    
    // 6. UPDATE with multiple conditions
    echo "<br><strong>6. UPDATE with Multiple Conditions:</strong><br>";
    $sql = "UPDATE users SET status = 'Inactive' WHERE status = 'Active' AND last_login < DATE_SUB(NOW(), INTERVAL 30 DAY)";
    
    if ($mysqli->query($sql) === TRUE) {
        echo "✅ Updated " . $mysqli->affected_rows . " inactive user(s)<br>";
    } else {
        echo "❌ Error: " . $mysqli->error . "<br>";
    }
    
    // 7. UPDATE with LIMIT
    echo "<br><strong>7. UPDATE with LIMIT:</strong><br>";
    // Insert some test data first
    for ($i = 0; $i < 5; $i++) {
        $mysqli->query("INSERT INTO users (username, email, password, full_name, gender) 
                       VALUES ('update_test_$i', 'update_$i@example.com', 'password', 'Update Test $i', 'Male')");
    }
    
    $sql = "UPDATE users SET status = 'Active' WHERE username LIKE 'update_test_%' LIMIT 3";
    if ($mysqli->query($sql) === TRUE) {
        echo "✅ Updated " . $mysqli->affected_rows . " test user(s) (LIMIT 3)<br>";
    } else {
        echo "❌ Error: " . $mysqli->error . "<br>";
    }
    
    $mysqli->close();
    
} catch (Exception $e) {
    echo "❌ " . $e->getMessage() . "<br>";
}

// Method 2: PDO
echo "<h3>Method 2: PDO</h3>";
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // 1. UPDATE with PDO
    echo "<strong>1. UPDATE with PDO:</strong><br>";
    $sql = "UPDATE products SET quantity = 100 WHERE category = 'Accessories'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    echo "✅ Updated " . $stmt->rowCount() . " product(s)<br>";
    
    // 2. UPDATE with Named Parameters
    echo "<br><strong>2. UPDATE with Named Parameters:</strong><br>";
    $sql = "UPDATE products SET price = :price, quantity = :quantity WHERE product_name = :name";
    $stmt = $pdo->prepare($sql);
    
    $data = [
        ':price' => 599.99,
        ':quantity' => 50,
        ':name' => 'Smartphone'
    ];
    $stmt->execute($data);
    
    echo "✅ Updated " . $stmt->rowCount() . " product(s) using named parameters<br>";
    
    // 3. UPDATE with Positional Parameters
    echo "<br><strong>3. UPDATE with Positional Parameters:</strong><br>";
    $sql = "UPDATE products SET price = ?, quantity = ? WHERE product_name = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([199.99, 75, 'Headphones']);
    
    echo "✅ Updated " . $stmt->rowCount() . " product(s) using positional parameters<br>";
    
    // 4. UPDATE with Transaction
    echo "<br><strong>4. UPDATE with Transaction:</strong><br>";
    try {
        $pdo->beginTransaction();
        
        // Update product quantity
        $sql = "UPDATE products SET quantity = quantity - 1 WHERE product_name = 'Laptop'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        // Insert into orders table
        $sql = "INSERT INTO orders (user_id, product_name, quantity) VALUES (:user_id, :product, :qty)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => 1,
            ':product' => 'Laptop',
            ':qty' => 1
        ]);
        
        $pdo->commit();
        echo "✅ Transaction successful! Product quantity updated and order placed.<br>";
        
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "❌ Transaction failed: " . $e->getMessage() . "<br>";
    }
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

// Display updated data
echo "<h3>Updated Data:</h3>";
displayUpdatedData();

// Best Practices for UPDATE operations
echo "<h3>Best Practices for UPDATE Operations:</h3>";
echo "<ul>";
echo "<li>✅ Always use WHERE clause to specify which records to update</li>";
echo "<li>✅ Use prepared statements to prevent SQL injection</li>";
echo "<li>✅ Use transactions for multiple related updates</li>";
echo "<li>✅ Validate data before updating</li>";
echo "<li>✅ Consider using soft delete (status column) instead of hard delete</li>";
echo "<li>✅ Log important updates for auditing</li>";
echo "<li>✅ Use LIMIT clause when updating a specific number of records</li>";
echo "</ul>";
?>

<?php
function displayUpdatedData() {
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        
        // Display users
        $result = $conn->query("SELECT username, email, full_name, phone, status FROM users LIMIT 5");
        echo "<strong>Users Table:</strong><br>";
        if ($result->num_rows > 0) {
            echo "<table border='1' cellpadding='5'>";
            echo "<tr><th>Username</th><th>Email</th><th>Full Name</th><th>Phone</th><th>Status</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['full_name'] . "</td>";
                echo "<td>" . ($row['phone'] ? $row['phone'] : 'N/A') . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "</tr>";
            }
            echo "</table><br>";
        }
        
        // Display products
        $result = $conn->query("SELECT product_name, price, quantity, category FROM products LIMIT 5");
        echo "<strong>Products Table:</strong><br>";
        if ($result->num_rows > 0) {
            echo "<table border='1' cellpadding='5'>";
            echo "<tr><th>Product</th><th>Price</th><th>Quantity</th><th>Category</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['product_name'] . "</td>";
                echo "<td>$" . number_format($row['price'], 2) . "</td>";
                echo "<td>" . $row['quantity'] . "</td>";
                echo "<td>" . $row['category'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        
        $conn->close();
        
    } catch (Exception $e) {
        echo "❌ " . $e->getMessage() . "<br>";
    }
}
?>