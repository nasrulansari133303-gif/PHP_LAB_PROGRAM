<?php
// select_data.php
echo "<h2>Select Data From MySQL Database</h2>";

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
    
    // 1. SELECT all records
    echo "<strong>1. SELECT All Records:</strong><br>";
    $result = $mysqli->query("SELECT id, username, email, full_name, gender, registration_date FROM users");
    
    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Full Name</th><th>Gender</th><th>Registration Date</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['full_name'] . "</td>";
            echo "<td>" . $row['gender'] . "</td>";
            echo "<td>" . $row['registration_date'] . "</td>";
            echo "</tr>";
        }
        echo "</table><br>";
    } else {
        echo "No records found.<br>";
    }
    
    // 2. SELECT with WHERE clause
    echo "<strong>2. SELECT with WHERE Clause:</strong><br>";
    $result = $mysqli->query("SELECT * FROM users WHERE gender = 'Female'");
    
    if ($result->num_rows > 0) {
        echo "Female users:<br>";
        while ($row = $result->fetch_object()) {
            echo "Username: " . $row->username . ", Email: " . $row->email . "<br>";
        }
    } else {
        echo "No female users found.<br>";
    }
    echo "<br>";
    
    // 3. SELECT with ORDER BY
    echo "<strong>3. SELECT with ORDER BY:</strong><br>";
    $result = $mysqli->query("SELECT username, email FROM users ORDER BY username ASC");
    
    if ($result->num_rows > 0) {
        echo "Users sorted by username (ASC):<br>";
        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            echo "Username: " . $row[0] . ", Email: " . $row[1] . "<br>";
        }
    }
    echo "<br>";
    
    // 4. SELECT with JOIN (if orders table exists)
    echo "<strong>4. SELECT with JOIN:</strong><br>";
    // Create orders table for demonstration
    $mysqli->query("CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        product_name VARCHAR(100),
        quantity INT,
        order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )");
    
    // Insert sample order
    $mysqli->query("INSERT INTO orders (user_id, product_name, quantity) VALUES (1, 'Laptop', 2)");
    $mysqli->query("INSERT INTO orders (user_id, product_name, quantity) VALUES (2, 'Smartphone', 1)");
    
    $result = $mysqli->query("
        SELECT u.username, u.email, o.product_name, o.quantity, o.order_date 
        FROM users u 
        JOIN orders o ON u.id = o.user_id
    ");
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "User: " . $row['username'] . " ordered " . $row['product_name'] . " x " . $row['quantity'] . "<br>";
        }
    } else {
        echo "No orders found.<br>";
    }
    echo "<br>";
    
    // 5. SELECT with LIMIT
    echo "<strong>5. SELECT with LIMIT:</strong><br>";
    $result = $mysqli->query("SELECT username, email FROM users LIMIT 3");
    
    if ($result->num_rows > 0) {
        echo "First 3 users:<br>";
        while ($row = $result->fetch_assoc()) {
            echo "Username: " . $row['username'] . ", Email: " . $row['email'] . "<br>";
        }
    }
    echo "<br>";
    
    // 6. SELECT with COUNT
    echo "<strong>6. SELECT with COUNT:</strong><br>";
    $result = $mysqli->query("SELECT COUNT(*) as total FROM users");
    $row = $result->fetch_assoc();
    echo "Total users: " . $row['total'] . "<br>";
    
    $result = $mysqli->query("SELECT gender, COUNT(*) as count FROM users GROUP BY gender");
    echo "Users by gender:<br>";
    while ($row = $result->fetch_assoc()) {
        echo $row['gender'] . ": " . $row['count'] . "<br>";
    }
    echo "<br>";
    
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
    
    // 1. SELECT with fetchAll
    echo "<strong>1. SELECT with fetchAll:</strong><br>";
    $stmt = $pdo->query("SELECT product_name, price, quantity FROM products WHERE category = 'Electronics'");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Electronics products:<br>";
    foreach ($products as $product) {
        echo "Product: " . $product['product_name'] . ", Price: $" . $product['price'] . ", Qty: " . $product['quantity'] . "<br>";
    }
    echo "<br>";
    
    // 2. SELECT with fetch (single row)
    echo "<strong>2. SELECT with fetch (single row):</strong><br>";
    $stmt = $pdo->query("SELECT * FROM products WHERE id = 1");
    $product = $stmt->fetch(PDO::FETCH_OBJ);
    
    if ($product) {
        echo "Product: " . $product->product_name . "<br>";
        echo "Description: " . $product->description . "<br>";
        echo "Price: $" . $product->price . "<br>";
    }
    echo "<br>";
    
    // 3. SELECT with fetchColumn
    echo "<strong>3. SELECT with fetchColumn:</strong><br>";
    $stmt = $pdo->query("SELECT COUNT(*) FROM products");
    $count = $stmt->fetchColumn();
    echo "Total products: $count<br><br>";
    
    // 4. SELECT with fetchAll and PDO::FETCH_CLASS
    echo "<strong>4. SELECT with fetchAll and PDO::FETCH_CLASS:</strong><br>";
    class Product {
        public $product_name;
        public $price;
        public $category;
        
        public function getInfo() {
            return $this->product_name . " (" . $this->category . ") - $" . $this->price;
        }
    }
    
    $stmt = $pdo->query("SELECT product_name, price, category FROM products LIMIT 3");
    $products = $stmt->fetchAll(PDO::FETCH_CLASS, 'Product');
    
    foreach ($products as $product) {
        echo $product->getInfo() . "<br>";
    }
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}
?>