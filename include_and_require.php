<?php
// Create the file to be included (in real scenario, this would be a separate file)

// For demonstration, we'll create the content here
// In practice, create a file called 'header.php' with the following content:
/*
<?php
// header.php
echo "<div style='background-color: #4CAF50; color: white; padding: 10px;'>";
echo "<h2>Welcome to My Website</h2>";
echo "<p>This is included header</p>";
echo "</div>";
?>
*/

// Create a file called 'footer.php' with the following content:
/*
<?php
// footer.php
echo "<div style='background-color: #333; color: white; padding: 10px;'>";
echo "<p>&copy; 2025 All Rights Reserved</p>";
echo "</div>";
?>
*/

// Create a file called 'config.php' with the following content:
/*
<?php
// config.php
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "testdb");
?>
*/

echo "<h2>Demonstrating Include and Require Functions</h2>";

// Using include
echo "<h3>1. Using include:</h3>";
echo "The 'header.php' file will be included using include<br>";

// Uncomment these when you have the actual files
// include('header.php');

// Simulating include
echo "<div style='background-color: #4CAF50; color: white; padding: 10px;'>";
echo "<h2>Welcome to My Website</h2>";
echo "<p>This is included header</p>";
echo "</div>";

// Using include_once (prevents multiple inclusions)
echo "<h3>2. Using include_once:</h3>";
echo "The 'header.php' will be included only once<br>";
// include_once('header.php');

// Using require
echo "<h3>3. Using require:</h3>";
echo "The 'footer.php' file will be included using require<br>";
// require('footer.php');

// Simulating require
echo "<div style='background-color: #333; color: white; padding: 10px;'>";
echo "<p>&copy; 2025 All Rights Reserved</p>";
echo "</div>";

// Using require_once
echo "<h3>4. Using require_once:</h3>";
echo "The 'footer.php' will be included only once<br>";
// require_once('footer.php');

// Including a configuration file
echo "<h3>5. Including a config file:</h3>";
// require_once('config.php');

// Simulating config
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "testdb");

echo "Database Configuration:<br>";
echo "Host: " . DB_HOST . "<br>";
echo "User: " . DB_USER . "<br>";
echo "Database: " . DB_NAME . "<br>";

// Difference between include and require
echo "<h3>6. Key Differences:</h3>";
echo "include: Produces a warning if file not found, script continues<br>";
echo "require: Produces a fatal error if file not found, script stops<br>";
echo "include_once/require_once: Ensures file is included only once<br>";

// Example of error handling with include
echo "<h3>7. Including a non-existent file:</h3>";
echo "Trying to include non_existent_file.php using include:<br>";
@include('non_existent_file.php');
echo "Script continues after include error<br>";

echo "Trying to include non_existent_file.php using require:<br>";
// @require('non_existent_file.php'); // Uncomment to see fatal error
echo "This line won't execute if require fails<br>";

// Practical example: Function from included file
echo "<h3>8. Using functions from included files:</h3>";
// Assume we have a file 'functions.php'
/*
<?php
// functions.php
function calculateSum($a, $b) {
    return $a + $b;
}
function calculateProduct($a, $b) {
    return $a * $b;
}
?>
*/

// Simulating functions
function calculateSum($a, $b) {
    return $a + $b;
}
function calculateProduct($a, $b) {
    return $a * $b;
}

// include('functions.php');
echo "Sum of 10 and 20: " . calculateSum(10, 20) . "<br>";
echo "Product of 10 and 20: " . calculateProduct(10, 20) . "<br>";
?>