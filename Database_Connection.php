<?php
// db_connection.php
echo "<h2>Database Connection</h2>";

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
    
    echo "✅ Connected successfully to MySQL using MySQLi (OO)<br>";
    echo "Server info: " . $mysqli->server_info . "<br>";
    echo "Client info: " . $mysqli->client_info . "<br>";
    echo "Host info: " . $mysqli->host_info . "<br>";
    $mysqli->close();
    
} catch (Exception $e) {
    echo "❌ " . $e->getMessage() . "<br>";
}

// Method 2: MySQLi Procedural
echo "<h3>Method 2: MySQLi Procedural</h3>";
try {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if (!$conn) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }
    
    echo "✅ Connected successfully to MySQL using MySQLi (Procedural)<br>";
    echo "Server info: " . mysqli_get_server_info($conn) . "<br>";
    mysqli_close($conn);
    
} catch (Exception $e) {
    echo "❌ " . $e->getMessage() . "<br>";
}

// Method 3: PDO
echo "<h3>Method 3: PDO (PHP Data Objects)</h3>";
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Connected successfully to MySQL using PDO<br>";
    echo "Server info: " . $pdo->getAttribute(PDO::ATTR_SERVER_INFO) . "<br>";
    echo "Client version: " . $pdo->getAttribute(PDO::ATTR_CLIENT_VERSION) . "<br>";
    
} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage() . "<br>";
}

// Connection status check
echo "<h3>Connection Status</h3>";
$connection_status = [
    'Extension Check' => 'MySQLi: ' . (extension_loaded('mysqli') ? '✅' : '❌') . ', PDO: ' . (extension_loaded('pdo_mysql') ? '✅' : '❌'),
    'Database Name' => DB_NAME,
    'Host' => DB_HOST
];

echo "<ul>";
foreach ($connection_status as $key => $value) {
    echo "<li><strong>$key:</strong> $value</li>";
}
echo "</ul>";
?>