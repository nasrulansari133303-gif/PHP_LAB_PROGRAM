<?php
// limit_data.php
echo "<h2>Limit Data Selections From a MySQL Database</h2>";

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'testdb');

// Insert sample data for demonstration
function insertSampleData($conn) {
    // Check if we already have enough data
    $result = $conn->query("SELECT COUNT(*) as count FROM users");
    $row = $result->fetch_assoc();
    
    if ($row['count'] < 20) {
        // Insert 20 sample users
        for ($i = 1; $i <= 20; $i++) {
            $username = "user_$i";
            $email = "user$i@example.com";
            $password = password_hash("password123", PASSWORD_DEFAULT);
            $full_name = "User $i";
            $gender = ($i % 2 == 0) ? 'Female' : 'Male';
            
            $conn->query("INSERT INTO users (username, email, password, full_name, gender) 
                         VALUES ('$username', '$email', '$password', '$full_name', '$gender')");
        }
    }
}

// Method 1: MySQLi Object-Oriented
echo "<h3>Method 1: MySQLi Object-Oriented</h3>";
try {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($mysqli->connect_error) {
        throw new Exception("Connection failed: " . $mysqli->connect_error);
    }
    
    // Insert sample data if needed
    insertSampleData($mysqli);
    
    // 1. SELECT with LIMIT
    echo "<strong>1. SELECT with LIMIT (First 5 records):</strong><br>";
    $result = $mysqli->query("SELECT id, username, email, full_name FROM users LIMIT 5");
    
    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Full Name</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['full_name'] . "</td>";
            echo "</tr>";
        }
        echo "</table><br>";
    }
    
    // 2. SELECT with LIMIT and OFFSET (pagination)
    echo "<strong>2. SELECT with LIMIT and OFFSET (Pagination):</strong><br>";
    $page = 2;
    $records_per_page = 5;
    $offset = ($page - 1) * $records_per_page;
    
    $result = $mysqli->query("SELECT id, username, email FROM users LIMIT $offset, $records_per_page");
    
    if ($result->num_rows > 0) {
        echo "Page $page (Records $offset to " . ($offset + $records_per_page) . "):<br>";
        while ($row = $result->fetch_assoc()) {
            echo "ID: " . $row['id'] . ", Username: " . $row['username'] . ", Email: " . $row['email'] . "<br>";
        }
    }
    echo "<br>";
    
    // 3. SELECT with ORDER BY and LIMIT (Top N records)
    echo "<strong>3. SELECT with ORDER BY and LIMIT (Top 5 users by ID):</strong><br>";
    $result = $mysqli->query("SELECT username, full_name, registration_date FROM users ORDER BY id DESC LIMIT 5");
    
    if ($result->num_rows > 0) {
        echo "Latest 5 users:<br>";
        while ($row = $result->fetch_assoc()) {
            echo "Username: " . $row['username'] . ", Registered: " . $row['registration_date'] . "<br>";
        }
    }
    echo "<br>";
    
    // 4. SELECT with LIMIT and WHERE clause
    echo "<strong>4. SELECT with LIMIT and WHERE clause:</strong><br>";
    $result = $mysqli->query("SELECT username, email FROM users WHERE gender = 'Female' LIMIT 3");
    
    if ($result->num_rows > 0) {
        echo "First 3 female users:<br>";
        while ($row = $result->fetch_assoc()) {
            echo "Username: " . $row['username'] . ", Email: " . $row['email'] . "<br>";
        }
    }
    echo "<br>";
    
    // 5. SELECT with DISTINCT and LIMIT
    echo "<strong>5. SELECT with DISTINCT and LIMIT:</strong><br>";
    $result = $mysqli->query("SELECT DISTINCT gender FROM users LIMIT 10");
    
    if ($result->num_rows > 0) {
        echo "Distinct genders:<br>";
        while ($row = $result->fetch_assoc()) {
            echo $row['gender'] . "<br>";
        }
    }
    echo "<br>";
    
    // 6. SELECT with GROUP BY and LIMIT
    echo "<strong>6. SELECT with GROUP BY and LIMIT:</strong><br>";
    $result = $mysqli->query("SELECT gender, COUNT(*) as count FROM users GROUP BY gender LIMIT 2");
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo $row['gender'] . ": " . $row['count'] . " users<br>";
        }
    }
    echo "<br>";
    
    // 7. Pagination with total count
    echo "<strong>7. Pagination Example:</strong><br>";
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $records_per_page = 5;
    $offset = ($current_page - 1) * $records_per_page;
    
    // Get total records
    $total_result = $mysqli->query("SELECT COUNT(*) as total FROM users");
    $total_row = $total_result->fetch_assoc();
    $total_records = $total_row['total'];
    $total_pages = ceil($total_records / $records_per_page);
    
    // Get records for current page
    $result = $mysqli->query("SELECT id, username, email FROM users LIMIT $offset, $records_per_page");
    
    echo "Page $current_page of $total_pages (Total records: $total_records)<br>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "ID: " . $row['id'] . ", Username: " . $row['username'] . ", Email: " . $row['email'] . "<br>";
        }
    }
    
    // Pagination links
    echo "<br>Pages: ";
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $current_page) {
            echo "<strong>$i</strong> ";
        } else {
            echo "<a href='?page=$i'>$i</a> ";
        }
    }
    echo "<br><br>";
    
    // 8. SELECT with LIMIT in Prepared Statement
    echo "<strong>8. SELECT with LIMIT in Prepared Statement:</strong><br>";
    $stmt = $mysqli->prepare("SELECT username, email FROM users WHERE gender = ? LIMIT ?");
    $gender = "Male";
    $limit = 3;
    $stmt->bind_param("si", $gender, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "First $limit male users:<br>";
        while ($row = $result->fetch_assoc()) {
            echo "Username: " . $row['username'] . ", Email: " . $row['email'] . "<br>";
        }
    }
    $stmt->close();
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
    
    // 1. SELECT with LIMIT in PDO
    echo "<strong>1. SELECT with LIMIT in PDO:</strong><br>";
    $stmt = $pdo->query("SELECT product_name, price FROM products LIMIT 3");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($products as $product) {
        echo "Product: " . $product['product_name'] . ", Price: $" . $product['price'] . "<br>";
    }
    echo "<br>";
    
    // 2. SELECT with LIMIT and OFFSET in PDO
    echo "<strong>2. SELECT with LIMIT and OFFSET in PDO:</strong><br>";
    $stmt = $pdo->prepare("SELECT product_name, price FROM products LIMIT :offset, :limit");
    $stmt->bindValue(':offset', 2, PDO::PARAM_INT);
    $stmt->bindValue(':limit', 3, PDO::PARAM_INT);
    $stmt->execute();
    
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Records 3-5:<br>";
    foreach ($products as $product) {
        echo "Product: " . $product['product_name'] . ", Price: $" . $product['price'] . "<br>";
    }
    echo "<br>";
    
    // 3. SELECT with ORDER BY and LIMIT in PDO
    echo "<strong>3. SELECT with ORDER BY and LIMIT in PDO:</strong><br>";
    $stmt = $pdo->prepare("SELECT product_name, price FROM products ORDER BY price DESC LIMIT :limit");
    $stmt->bindValue(':limit', 3, PDO::PARAM_INT);
    $stmt->execute();
    
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Top 3 most expensive products:<br>";
    foreach ($products as $product) {
        echo "Product: " . $product['product_name'] . ", Price: $" . $product['price'] . "<br>";
    }
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

// Benefits and Use Cases
echo "<h3>Benefits and Use Cases of LIMIT:</h3>";
echo "<ul>";
echo "<li>✅ <strong>Pagination:</strong> Display data in pages (e.g., 10 records per page)</li>";
echo "<li>✅ <strong>Performance:</strong> Reduce data transfer by limiting results</li>";
echo "<li>✅ <strong>Top N Records:</strong> Show top sellers, latest posts, etc.</li>";
echo "<li>✅ <strong>Sampling:</strong> Get a sample of data for testing</li>";
echo "<li>✅ <strong>Batch Processing:</strong> Process large datasets in chunks</li>";
echo "<li>✅ <strong>Memory Management:</strong> Prevent memory exhaustion with large datasets</li>";
echo "</ul>";
?>