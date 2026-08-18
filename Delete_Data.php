<?php
// delete_data.php
echo "<h2>Delete Data From MySQL Table Using MySQLi and PDO</h2>";

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
    
    // 1. DELETE with WHERE clause
    echo "<strong>1. DELETE with WHERE Clause:</strong><br>";
    $sql = "DELETE FROM users WHERE username = 'prep_user'";
    
    if ($mysqli->query($sql) === TRUE) {
        echo "✅ Deleted " . $mysqli->affected_rows . " row(s) successfully<br>";
    } else {
        echo "❌ Error: " . $mysqli->error . "<br>";
    }
    
    // 2. DELETE with Prepared Statement
    echo "<br><strong>2. DELETE with Prepared Statement:</strong><br>";
    $stmt = $mysqli->prepare("DELETE FROM orders WHERE user_id = ?");
    $user_id = 1;
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        echo "✅ Deleted " . $stmt->affected_rows . " order(s) for user ID $user_id<br>";
    } else {
        echo "❌ Error: " . $stmt->error . "<br>";
    }
    $stmt->close();
    
    // 3. DELETE with LIMIT (delete limited rows)
    echo "<br><strong>3. DELETE with LIMIT:</strong><br>";
    // First, insert some test data
    for ($i = 0; $i < 5; $i++) {
        $mysqli->query("INSERT INTO users (username, email, password, full_name, gender) 
                       VALUES ('test_user_$i', 'test_$i@example.com', 'password', 'Test User $i', 'Male')");
    }
    
    $sql = "DELETE FROM users WHERE username LIKE 'test_user_%' LIMIT 3";
    if ($mysqli->query($sql) === TRUE) {
        echo "✅ Deleted " . $mysqli->affected_rows . " test users (LIMIT 3)<br>";
    } else {
        echo "❌ Error: " . $mysqli->error . "<br>";
    }
    
    // 4. Soft Delete (update status instead of actual delete)
    echo "<br><strong>4. Soft Delete (Update Status):</strong><br>";
    $sql = "UPDATE users SET status = 'Deleted' WHERE username LIKE 'test_user_%'";
    if ($mysqli->query($sql) === TRUE) {
        echo "✅ Soft deleted " . $mysqli->affected_rows . " user(s)<br>";
    } else {
        echo "❌ Error: " . $mysqli->error . "<br>";
    }
    
    // 5. DELETE all records (be careful!)
    echo "<br><strong>5. DELETE All Records (with caution):</strong><br>";
    $sql = "DELETE FROM products WHERE product_name LIKE 'Test%'";
    // $sql = "TRUNCATE TABLE products"; // Faster but resets auto-increment
    
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
    
    // 1. DELETE with PDO
    echo "<strong>1. DELETE with PDO:</strong><br>";
    $sql = "DELETE FROM products WHERE quantity = 0";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    echo "✅ Deleted " . $stmt->rowCount() . " product(s) with zero quantity<br>";
    
    // 2. DELETE with Named Parameters
    echo "<br><strong>2. DELETE with Named Parameters:</strong><br>";
    $sql = "DELETE FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':username' => 'test_user_4']);
    
    echo "✅ Deleted " . $stmt->rowCount() . " user(s) using named parameters<br>";
    
    // 3. DELETE with Positional Parameters
    echo "<br><strong>3. DELETE with Positional Parameters:</strong><br>";
    $sql = "DELETE FROM users WHERE username LIKE ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['test_user_%']);
    
    echo "✅ Deleted " . $stmt->rowCount() . " user(s) using positional parameters<br>";
    
    // 4. DELETE with Transaction
    echo "<br><strong>4. DELETE with Transaction:</strong><br>";
    try {
        $pdo->beginTransaction();
        
        $sql = "DELETE FROM orders WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':user_id' => 2]);
        
        $deleted_orders = $stmt->rowCount();
        
        // Delete the user as well
        $sql = "DELETE FROM users WHERE id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':user_id' => 2]);
        
        $deleted_users = $stmt->rowCount();
        
        $pdo->commit();
        echo "✅ Transaction successful! Deleted $deleted_orders orders and $deleted_users user<br>";
        
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "❌ Transaction failed: " . $e->getMessage() . "<br>";
    }
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

// Display remaining data
echo "<h3>Remaining Data After Deletions:</h3>";
displayRemainingData();
?>

<?php
function displayRemainingData() {
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        
        // Count remaining users
        $result = $conn->query("SELECT COUNT(*) as total FROM users");
        $row = $result->fetch_assoc();
        echo "Total users: " . $row['total'] . "<br>";
        
        // Count remaining products
        $result = $conn->query("SELECT COUNT(*) as total FROM products");
        $row = $result->fetch_assoc();
        echo "Total products: " . $row['total'] . "<br>";
        
        $conn->close();
        
    } catch (Exception $e) {
        echo "❌ " . $e->getMessage() . "<br>";
    }
}

echo "<h3>Important Notes:</h3>";
echo "<ul>";
echo "<li>✅ Use WHERE clause to avoid deleting all records</li>";
echo "<li>✅ Consider using soft delete (status column) instead of hard delete</li>";
echo "<li>✅ Use transactions for multiple related deletions</li>";
echo "<li>✅ Always backup data before running delete operations</li>";
echo "<li>✅ Use prepared statements to prevent SQL injection</li>";
echo "</ul>";
?>