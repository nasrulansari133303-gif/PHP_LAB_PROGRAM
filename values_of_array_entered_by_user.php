<?php
// Method 1: Using HTML form to get user input
echo "<h2>Array Values Entered by User</h2>";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $arrayValues = $_POST['array_values'];
    
    // Convert comma-separated string to array
    if (!empty($arrayValues)) {
        $userArray = array_map('trim', explode(',', $arrayValues));
        
        echo "<h3>Array values entered by user:</h3>";
        echo "Original Array:<br>";
        print_r($userArray);
        echo "<br><br>";
        
        // Display in different formats
        echo "Array values with index:<br>";
        foreach ($userArray as $index => $value) {
            echo "Index [$index] => $value<br>";
        }
        
        echo "<br>Array values (comma separated): " . implode(", ", $userArray) . "<br>";
        
        // Array statistics
        echo "<br><h3>Array Statistics:</h3>";
        echo "Number of elements: " . count($userArray) . "<br>";
        echo "First element: " . reset($userArray) . "<br>";
        echo "Last element: " . end($userArray) . "<br>";
    } else {
        echo "No values entered!";
    }
}
?>

<!-- Method 1: Simple input form -->
<form method="POST">
    <h3>Enter array values (comma separated):</h3>
    <input type="text" name="array_values" placeholder="e.g., apple, banana, orange" size="50">
    <input type="submit" name="submit" value="Submit">
</form>

<hr>

<?php
// Method 2: Using multiple input fields
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit2'])) {
    echo "<h3>Array from Multiple Inputs:</h3>";
    $arrayElements = array();
    
    for ($i = 0; $i < 5; $i++) {
        if (!empty($_POST["element$i"])) {
            $arrayElements[] = $_POST["element$i"];
        }
    }
    
    if (!empty($arrayElements)) {
        echo "Array: ";
        print_r($arrayElements);
        echo "<br>";
        echo "Values: " . implode(", ", $arrayElements);
    } else {
        echo "No values entered!";
    }
}
?>

<!-- Method 2: Multiple input fields form -->
<form method="POST">
    <h3>Enter 5 array elements:</h3>
    Element 1: <input type="text" name="element0"><br>
    Element 2: <input type="text" name="element1"><br>
    Element 3: <input type="text" name="element2"><br>
    Element 4: <input type="text" name="element3"><br>
    Element 5: <input type="text" name="element4"><br>
    <input type="submit" name="submit2" value="Submit Array">
</form>

<hr>

<?php
// Method 3: Using $_GET method
if (isset($_GET['values'])) {
    $getArray = explode(',', $_GET['values']);
    echo "<h3>Array from GET method:</h3>";
    echo "Array: ";
    print_r($getArray);
    echo "<br>";
    echo "Values: " . implode(", ", $getArray);
}
?>

<!-- Method 3: GET method form -->
<form method="GET">
    <h3>Enter array values (GET method):</h3>
    <input type="text" name="values" placeholder="e.g., red, green, blue" size="50">
    <input type="submit" value="Submit GET">
</form>

<?php
// Method 4: Predefined array demonstration
echo "<h3>Array with different data types:</h3>";
$mixedArray = array(10, "Hello", 3.14, true, "World");
echo "Mixed Array: ";
print_r($mixedArray);
echo "<br>";

foreach ($mixedArray as $key => $value) {
    echo "Element $key: $value (Type: " . gettype($value) . ")<br>";
}
?>