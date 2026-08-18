<?php
// create_table.php
echo "<h2>Create MySQL Table Using MySQLi and PDO</h2>";

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'testdb');

// Create database if not exists
function createDatabase($conn, $dbName) {
    $sql = "CREATE DATABASE IF NOT EXISTS $dbName";
    if ($conn->query($sql) === TRUE) {
        echo "✅ Database '$dbName' created or already exists.<br>";
        return true;
    } else {
        echo "❌ Error creating database: " . $conn->error . "<br>";
        return false;
    }
}

// Method 1: MySQLi Object-Oriented
echo "<h3>Method 1: MySQLi Object-Oriented</h3>";
try {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS);
    
    if ($mysqli->connect_error) {
        throw new Exception("Connection failed: " . $mysqli->connect_error);
    }
    
    // Create database if not exists
    createDatabase($mysqli, DB_NAME);
    
    // Select database
    $mysqli->select_db(DB_NAME);
    
    // SQL to create users table
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        full_name VARCHAR(100) NOT NULL,
        phone VARCHAR(20),
        address TEXT,
        gender ENUM('Male', 'Female', 'Other') NOT NULL,
        date_of_birth DATE,
        registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        last_login TIMESTAMP NULL,
        status ENUM('Active', 'Inactive', 'Suspended') DEFAULT 'Active',
        INDEX idx_username (username),
        INDEX idx_email (email)
    )";
    
    if ($mysqli->query($sql) === TRUE) {
        echo "✅ Table 'users' created successfully using MySQLi (OO)<br>";
        
        // Show table structure
        $result = $mysqli->query("DESCRIBE users");
        echo "<br><strong>Table Structure:</strong><br>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Field'] . "</td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Null'] . "</td>";
            echo "<td>" . $row['Key'] . "</td>";
            echo "<td>" . $row['Default'] . "</td>";
            echo "<td>" . $row['Extra'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "❌ Error creating table: " . $mysqli->error . "<br>";
    }
    
    $mysqli->close();
    
} catch (Exception $e) {
    echo "❌ " . $e->getMessage() . "<br>";
}

// Method 2: PDO
echo "<h3>Method 2: PDO</h3>";
try {
    $dsn = "mysql:host=" . DB_HOST . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME);
    echo "✅ Database '" . DB_NAME . "' created or already exists (PDO).<br>";
    
    // Select database
    $pdo->exec("USE " . DB_NAME);
    
    // Create products table
    $sql = "CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        product_name VARCHAR(100) NOT NULL,
        description TEXT,
        price DECIMAL(10, 2) NOT NULL,
        quantity INT DEFAULT 0,
        category VARCHAR(50),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_product_name (product_name),
        INDEX idx_category (category)
    )";
    
    $pdo->exec($sql);
    echo "✅ Table 'products' created successfully using PDO<br>";
    
    // Show table structure
    $stmt = $pdo->query("DESCRIBE products");
    echo "<br><strong>Table Structure (Products):</strong><br>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . $row['Default'] . "</td>";
        echo "<td>" . $row['Extra'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}
?>