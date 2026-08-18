<?php
// insert_data.php
echo "<h2>Insert Data Into MySQL Using MySQLi and PDO</h2>";

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
    
    // Insert single record
    $sql = "INSERT INTO users (username, email, password, full_name, gender) 
            VALUES ('john_doe', 'john@example.com', '" . password_hash('password123', PASSWORD_DEFAULT) . "', 'John Doe', 'Male')";
    
    if ($mysqli->query($sql) === TRUE) {
        $last_id = $mysqli->insert_id;
        echo "✅ New record inserted successfully (MySQLi OO). ID: $last_id<br>";
    } else {
        echo "❌ Error: " . $mysqli->error . "<br>";
    }
    
    // Insert multiple records
    $users = [
        ['jane_smith', 'jane@example.com', 'Jane Smith', 'Female'],
        ['bob_wilson', 'bob@example.com', 'Bob Wilson', 'Male'],
        ['alice_brown', 'alice@example.com', 'Alice Brown', 'Female']
    ];
    
    $insert_count = 0;
    foreach ($users as $user) {
        $username = $user[0];
        $email = $user[1];
        $full_name = $user[2];
        $gender = $user[3];
        $password = password_hash('password123', PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (username, email, password, full_name, gender) 
                VALUES ('$username', '$email', '$password', '$full_name', '$gender')";
        
        if ($mysqli->query($sql) === TRUE) {
            $insert_count++;
        }
    }
    echo "✅ Inserted $insert_count records successfully (MySQLi OO)<br>";
    
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
    
    // Insert into products table
    $products = [
        ['Laptop', 'High-performance laptop', 999.99, 10, 'Electronics'],
        ['Smartphone', 'Latest model smartphone', 699.99, 25, 'Electronics'],
        ['Headphones', 'Wireless noise-canceling headphones', 199.99, 50, 'Audio'],
        ['Mouse', 'Ergonomic wireless mouse', 49.99, 100, 'Accessories'],
        ['Keyboard', 'Mechanical gaming keyboard', 149.99, 30, 'Accessories']
    ];
    
    $insert_count = 0;
    $sql = "INSERT INTO products (product_name, description, price, quantity, category) 
            VALUES (:product_name, :description, :price, :quantity, :category)";
    $stmt = $pdo->prepare($sql);
    
    foreach ($products as $product) {
        $stmt->execute([
            ':product_name' => $product[0],
            ':description' => $product[1],
            ':price' => $product[2],
            ':quantity' => $product[3],
            ':category' => $product[4]
        ]);
        $insert_count++;
    }
    echo "✅ Inserted $insert_count records into products table (PDO)<br>";
    
    // Last inserted ID
    $last_id = $pdo->lastInsertId();
    echo "Last Inserted ID: $last_id<br>";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

// Display inserted data
echo "<h3>Inserted Data:</h3>";
displayData();
?>

<?php
function displayData() {
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        
        // Display users
        $result = $conn->query("SELECT id, username, email, full_name, gender, registration_date FROM users LIMIT 5");
        echo "<strong>Users Table:</strong><br>";
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
        
        // Display products
        $result = $conn->query("SELECT id, product_name, price, quantity, category FROM products");
        echo "<strong>Products Table:</strong><br>";
        if ($result->num_rows > 0) {
            echo "<table border='1' cellpadding='5'>";
            echo "<tr><th>ID</th><th>Product Name</th><th>Price</th><th>Quantity</th><th>Category</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['product_name'] . "</td>";
                echo "<td>$" . number_format($row['price'], 2) . "</td>";
                echo "<td>" . $row['quantity'] . "</td>";
                echo "<td>" . $row['category'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No records found.<br>";
        }
        
        $conn->close();
        
    } catch (Exception $e) {
        echo "❌ " . $e->getMessage() . "<br>";
    }
}
?>