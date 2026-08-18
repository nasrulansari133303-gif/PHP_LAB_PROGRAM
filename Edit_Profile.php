<?php
// edit_profile.php
session_start();

echo "<h2>Edit Profile Page</h2>";

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'testdb');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: 4.9_login_authentication.php?page=login");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';
$message_type = '';

try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Get user data
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    
    if (!$user) {
        throw new Exception("User not found.");
    }
    
    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
        $full_name = $conn->real_escape_string($_POST['full_name']);
        $email = $conn->real_escape_string($_POST['email']);
        $phone = $conn->real_escape_string($_POST['phone']);
        $address = $conn->real_escape_string($_POST['address']);
        $gender = $conn->real_escape_string($_POST['gender']);
        $dob = $conn->real_escape_string($_POST['dob']);
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        // Validate
        $errors = array();
        
        if (empty($full_name)) {
            $errors[] = "Full name is required.";
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email address.";
        }
        
        // Check if email already exists for other users
        if ($email != $user['email']) {
            $check = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
            $check->bind_param("si", $email, $user_id);
            $check->execute();
            $check_result = $check->get_result();
            if ($check_result->num_rows > 0) {
                $errors[] = "Email already exists. Please use a different email.";
            }
            $check->close();
        }
        
        // Handle password change
        $password_update = "";
        if (!empty($current_password) || !empty($new_password) || !empty($confirm_password)) {
            if (empty($current_password)) {
                $errors[] = "Current password is required to change password.";
            } elseif (!password_verify($current_password, $user['password'])) {
                $errors[] = "Current password is incorrect.";
            } elseif (empty($new_password)) {
                $errors[] = "New password is required.";
            } elseif (strlen($new_password) < 6) {
                $errors[] = "New password must be at least 6 characters long.";
            } elseif ($new_password != $confirm_password) {
                $errors[] = "New passwords do not match.";
            } else {
                $password_update = ", password = '" . password_hash($new_password, PASSWORD_DEFAULT) . "'";
            }
        }
        
        // If no errors, update profile
        if (empty($errors)) {
            $sql = "UPDATE users SET 
                    full_name = '$full_name',
                    email = '$email',
                    phone = '$phone',
                    address = '$address',
                    gender = '$gender',
                    date_of_birth = '$dob'
                    $password_update
                    WHERE id = $user_id";
            
            if ($conn->query($sql) === TRUE) {
                // Update session data
                $_SESSION['full_name'] = $full_name;
                $_SESSION['email'] = $email;
                
                $message = "Profile updated successfully!";
                $message_type = "success";
                
                // Refresh user data
                $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
                $stmt->close();
            } else {
                $message = "Error updating profile: " . $conn->error;
                $message_type = "error";
            }
        } else {
            $message = implode("<br>", $errors);
            $message_type = "error";
        }
    }
    
    $conn->close();
    
} catch (Exception $e) {
    $message = "Error: " . $e->getMessage();
    $message_type = "error";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 700px;
            margin: 30px auto;
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        h2 {
            color: #333;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .profile-header .user-info {
            font-size: 14px;
            color: #666;
        }
        .profile-header .user-info strong {
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
            font-size: 14px;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
            font-family: inherit;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            border-color: #667eea;
            outline: none;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        .btn-secondary {
            background: #f5f5f5;
            color: #555;
        }
        .btn-secondary:hover {
            background: #e0e0e0;
        }
        .btn-danger {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(245, 87, 108, 0.4);
        }
        .btn-group {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        .message {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid;
        }
        .success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border-color: #2e7d32;
        }
        .error {
            background-color: #ffebee;
            color: #c62828;
            border-color: #c62828;
        }
        .section-title {
            font-size: 18px;
            color: #333;
            margin: 25px 0 15px 0;
            padding-bottom: 5px;
            border-bottom: 2px solid #eee;
        }
        .readonly-field {
            background-color: #f5f5f5;
            color: #666;
        }
        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            .container {
                padding: 20px;
            }
            .btn-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-header">
            <h2>✏️ Edit Profile</h2>
            <div class="user-info">
                <strong><?php echo htmlspecialchars($user['username']); ?></strong> 
                (ID: <?php echo $user['id']; ?>)
            </div>
        </div>
        
        <?php if ($message): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <!-- Personal Information -->
            <div class="section-title">Personal Information</div>
            
            <div class="form-group">
                <label for="username">Username (Cannot be changed)</label>
                <input type="text" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" class="readonly-field" readonly>
            </div>
            
            <div class="form-group">
                <label for="full_name">Full Name *</label>
                <input type="text" id="full_name" name="full_name" 
                       value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" 
                           value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" 
                           value="<?php echo htmlspecialchars($user['phone']); ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label for="address">Address</label>
                <textarea id="address" name="address"><?php echo htmlspecialchars($user['address']); ?></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="gender">Gender *</label>
                    <select id="gender" name="gender" required>
                        <option value="Male" <?php echo ($user['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo ($user['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                        <option value="Other" <?php echo ($user['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" 
                           value="<?php echo htmlspecialchars($user['date_of_birth']); ?>">
                </div>
            </div>
            
            <!-- Password Change Section -->
            <div class="section-title">Change Password</div>
            <div style="background: #f5f5f5; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <p style="font-size: 14px; color: #666; margin-bottom: 15px;">
                    Leave these fields empty if you don't want to change your password.
                </p>
                
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" 
                           placeholder="Enter your current password">
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" 
                               placeholder="Enter new password (min 6 characters)">
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" 
                               placeholder="Confirm new password">
                    </div>
                </div>
            </div>
            
            <!-- Account Information (Readonly) -->
            <div class="section-title">Account Information</div>
            <div style="background: #f9f9f9; padding: 15px; border-radius: 8px;">
                <div class="form-row">
                    <div class="form-group">
                        <label>Registration Date</label>
                        <input type="text" value="<?php echo $user['registration_date']; ?>" class="readonly-field" readonly>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <input type="text" value="<?php echo $user['status']; ?>" class="readonly-field" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label>Last Login</label>
                    <input type="text" value="<?php echo $user['last_login'] ?: 'Never'; ?>" class="readonly-field" readonly>
                </div>
            </div>
            
            <!-- Buttons -->
            <div class="btn-group">
                <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
                <button type="reset" class="btn btn-secondary">Reset Form</button>
                <a href="4.9_login_authentication.php?page=home" class="btn btn-secondary" style="text-decoration: none; text-align: center;">Back to Home</a>
            </div>
        </form>
        
        <div style="margin-top: 20px; padding: 15px; background: #fff3cd; border-radius: 8px; border-left: 4px solid #ffc107;">
            <p style="font-size: 13px; color: #856404;">
                <strong>Note:</strong> Fields marked with * are required. Your username cannot be changed.
                Password change is optional - leave password fields empty to keep your current password.
            </p>
        </div>
    </div>
</body>
</html>