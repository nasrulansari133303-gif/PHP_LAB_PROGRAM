<?php
// register_to_database.php
echo "<h2>Registration Form with Database Storage</h2>";

// Database configuration
$host = 'localhost';
$db_username = 'root';
$db_password = '';
$database = 'testdb';

// Create connection
$conn = new mysqli($host, $db_username, $db_password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create users table if it doesn't exist
$create_table_sql = "CREATE TABLE IF NOT EXISTS users (
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
    status ENUM('Active', 'Inactive', 'Suspended') DEFAULT 'Active'
)";

if ($conn->query($create_table_sql) === FALSE) {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Handle form submission
$registration_message = '';
$registration_status = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    // Get form data
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $dob = $conn->real_escape_string($_POST['dob']);
    
    // Validate data
    $errors = array();
    
    if (empty($username) || strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters long.";
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }
    
    if (strlen($_POST['password']) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }
    
    if (empty($full_name)) {
        $errors[] = "Full name is required.";
    }
    
    if (empty($gender)) {
        $errors[] = "Gender is required.";
    }
    
    // Check if username already exists
    $check_username = $conn->query("SELECT id FROM users WHERE username = '$username'");
    if ($check_username->num_rows > 0) {
        $errors[] = "Username already exists. Please choose a different username.";
    }
    
    // Check if email already exists
    $check_email = $conn->query("SELECT id FROM users WHERE email = '$email'");
    if ($check_email->num_rows > 0) {
        $errors[] = "Email already registered. Please use a different email.";
    }
    
    // If no errors, insert into database
    if (empty($errors)) {
        $sql = "INSERT INTO users (username, email, password, full_name, phone, address, gender, date_of_birth) 
                VALUES ('$username', '$email', '$password', '$full_name', '$phone', '$address', '$gender', '$dob')";
        
        if ($conn->query($sql) === TRUE) {
            $registration_message = "Registration successful!";
            $registration_status = 'success';
            
            // Clear form data (for security)
            $_POST = array();
        } else {
            $registration_message = "Error: " . $conn->error;
            $registration_status = 'error';
        }
    } else {
        $registration_message = "Please fix the following errors:<br>";
        foreach ($errors as $error) {
            $registration_message .= "• " . $error . "<br>";
        }
        $registration_status = 'error';
    }
}

// Get total registered users
$total_users = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            border-color: #4CAF50;
            outline: none;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }
        .form-group .radio-group {
            display: flex;
            gap: 20px;
            padding-top: 5px;
        }
        .form-group .radio-group label {
            font-weight: normal;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .form-group .radio-group input {
            width: auto;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .message {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .info-box {
            background-color: #e8f4f8;
            padding: 15px;
            border-radius: 4px;
            margin-top: 20px;
            border-left: 4px solid #4CAF50;
        }
        .required::after {
            content: " *";
            color: red;
        }
        .stats {
            display: flex;
            justify-content: space-between;
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .stats span {
            font-weight: bold;
            color: #4CAF50;
        }
        .view-users {
            display: inline-block;
            background-color: #2196F3;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            margin-top: 10px;
        }
        .view-users:hover {
            background-color: #1976D2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Registration</h2>
        
        <?php if ($registration_message): ?>
            <div class="message <?php echo $registration_status; ?>">
                <?php echo $registration_message; ?>
            </div>
        <?php endif; ?>
        
        <div class="stats">
            <span>Total Registered Users: <?php echo $total_users; ?></span>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?view=users" class="view-users">View All Users</a>
        </div>
        
        <?php if (isset($_GET['view']) && $_GET['view'] == 'users'): ?>
            <!-- View Users -->
            <h3>Registered Users</h3>
            <?php
            $users_result = $conn->query("SELECT id, username, email, full_name, gender, registration_date, status FROM users ORDER BY id DESC");
            if ($users_result->num_rows > 0) {
                echo "<table border='1' cellpadding='8' style='width: 100%; border-collapse: collapse;'>";
                echo "<tr style='background-color: #f5f5f5;'>";
                echo "<th>ID</th><th>Username</th><th>Email</th><th>Full Name</th><th>Gender</th><th>Reg Date</th><th>Status</th>";
                echo "</tr>";
                while ($row = $users_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                    echo "<td>" . $row['gender'] . "</td>";
                    echo "<td>" . date('Y-m-d', strtotime($row['registration_date'])) . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No users registered yet.</p>";
            }
            ?>
            <br>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>">Back to Registration</a>
            
        <?php else: ?>
            <!-- Registration Form -->
            <form method="POST">
                <div class="form-group">
                    <label class="required" for="username">Username:</label>
                    <input type="text" id="username" name="username" 
                           value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" 
                           placeholder="Choose a username (min 3 characters)" required>
                </div>
                
                <div class="form-group">
                    <label class="required" for="email">Email:</label>
                    <input type="email" id="email" name="email" 
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" 
                           placeholder="Enter your email" required>
                </div>
                
                <div class="form-group">
                    <label class="required" for="password">Password:</label>
                    <input type="password" id="password" name="password" 
                           placeholder="Create a password (min 6 characters)" required>
                </div>
                
                <div class="form-group">
                    <label class="required" for="full_name">Full Name:</label>
                    <input type="text" id="full_name" name="full_name" 
                           value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>" 
                           placeholder="Enter your full name" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number:</label>
                    <input type="tel" id="phone" name="phone" 
                           value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" 
                           placeholder="Enter your phone number">
                </div>
                
                <div class="form-group">
                    <label for="address">Address:</label>
                    <textarea id="address" name="address" placeholder="Enter your address"><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?></textarea>
                </div>
                
                <div class="form-group">
                    <label class="required" for="gender">Gender:</label>
                    <div class="radio-group">
                        <label><input type="radio" name="gender" value="Male" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Male') ? 'checked' : ''; ?>> Male</label>
                        <label><input type="radio" name="gender" value="Female" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Female') ? 'checked' : ''; ?>> Female</label>
                        <label><input type="radio" name="gender" value="Other" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Other') ? 'checked' : ''; ?>> Other</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" id="dob" name="dob" 
                           value="<?php echo isset($_POST['dob']) ? htmlspecialchars($_POST['dob']) : ''; ?>">
                </div>
                
                <button type="submit" name="register" class="btn">Register</button>
            </form>
            
            <div class="info-box">
                <strong>Registration Guidelines:</strong>
                <ul style="margin: 10px 0 0 20px;">
                    <li>Username must be at least 3 characters long</li>
                    <li>Password must be at least 6 characters long</li>
                    <li>All fields marked with * are required</li>
                    <li>Your data will be stored securely in the database</li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// Close connection
$conn->close();
?>