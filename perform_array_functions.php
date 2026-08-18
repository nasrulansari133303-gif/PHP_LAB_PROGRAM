<?php
echo "<h2>Array Functions Demonstration</h2>";

// Sample array for demonstration
$months = array(
    "January" => 31,
    "February" => 28,
    "March" => 31,
    "April" => 30,
    "May" => 31,
    "June" => 30
);

echo "<h3>Original Array (Months):</h3>";
print_r($months);
echo "<br><br>";

// 1. array_change_key_case()
echo "<h4>1. array_change_key_case()</h4>";
$lowerKeys = array_change_key_case($months, CASE_LOWER);
echo "Keys in Lowercase: ";
print_r($lowerKeys);
echo "<br>";

$upperKeys = array_change_key_case($months, CASE_UPPER);
echo "Keys in Uppercase: ";
print_r($upperKeys);
echo "<br><br>";

// 2. array_chunk()
echo "<h4>2. array_chunk()</h4>";
$chunkedArray = array_chunk($months, 2);
echo "Array Chunked into 2 elements each:<br>";
print_r($chunkedArray);
echo "<br><br>";

// 3. array_count_values()
echo "<h4>3. array_count_values()</h4>";
$colors = array("red", "blue", "red", "green", "blue", "red");
echo "Original Array: ";
print_r($colors);
echo "<br>";
$countValues = array_count_values($colors);
echo "Count of values: ";
print_r($countValues);
echo "<br><br>";

// 4. array_pop()
echo "<h4>4. array_pop()</h4>";
$popArray = array("apple", "banana", "orange", "grape");
echo "Original Array: ";
print_r($popArray);
echo "<br>";
$poppedElement = array_pop($popArray);
echo "Popped Element: $poppedElement<br>";
echo "Array after pop: ";
print_r($popArray);
echo "<br><br>";

// 5. array_push()
echo "<h4>5. array_push()</h4>";
$pushArray = array("apple", "banana");
echo "Original Array: ";
print_r($pushArray);
echo "<br>";
array_push($pushArray, "orange", "grape");
echo "Array after push: ";
print_r($pushArray);
echo "<br><br>";

// 6. array_unshift()
echo "<h4>6. array_unshift()</h4>";
$unshiftArray = array("orange", "grape");
echo "Original Array: ";
print_r($unshiftArray);
echo "<br>";
array_unshift($unshiftArray, "apple", "banana");
echo "Array after unshift: ";
print_r($unshiftArray);
echo "<br><br>";

// 7. array_shift()
echo "<h4>7. array_shift()</h4>";
$shiftArray = array("apple", "banana", "orange", "grape");
echo "Original Array: ";
print_r($shiftArray);
echo "<br>";
$shiftedElement = array_shift($shiftArray);
echo "Shifted Element: $shiftedElement<br>";
echo "Array after shift: ";
print_r($shiftArray);
echo "<br><br>";

// Additional demonstration with a numeric array
echo "<h4>Additional Demonstration:</h4>";
$numbers = array(10, 20, 30, 40, 50);
echo "Numeric Array: ";
print_r($numbers);
echo "<br>";

// array_pop with numeric array
$lastElement = array_pop($numbers);
echo "Popped: $lastElement, Array now: ";
print_r($numbers);
echo "<br>";

// array_push with numeric array
array_push($numbers, 60, 70);
echo "After push: ";
print_r($numbers);
echo "<br>";

// array_shift with numeric array
$firstElement = array_shift($numbers);
echo "Shifted: $firstElement, Array now: ";
print_r($numbers);
echo "<br>";

// array_unshift with numeric array
array_unshift($numbers, 5, 15);
echo "After unshift: ";
print_r($numbers);
echo "<br>";
?>