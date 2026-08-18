<?php
echo "<h2>Merge Two Arrays</h2>";

// Method 1: Using array_merge()
echo "<h3>Method 1: Using array_merge()</h3>";
$array1 = array("red", "green", "blue");
$array2 = array("yellow", "orange", "purple");

echo "Array 1: ";
print_r($array1);
echo "<br>";
echo "Array 2: ";
print_r($array2);
echo "<br>";

$mergedArray = array_merge($array1, $array2);
echo "Merged Array: ";
print_r($mergedArray);
echo "<br><br>";

// Method 2: Using + operator
echo "<h3>Method 2: Using + operator</h3>";
$array3 = array("a" => "apple", "b" => "banana");
$array4 = array("c" => "cherry", "d" => "date");
echo "Array 3: ";
print_r($array3);
echo "<br>";
echo "Array 4: ";
print_r($array4);
echo "<br>";
$mergedArray2 = $array3 + $array4;
echo "Merged Array (+): ";
print_r($mergedArray2);
echo "<br><br>";

// Method 3: Using array_merge() with numeric keys
echo "<h3>Method 3: array_merge() with numeric keys</h3>";
$array5 = array(0 => "one", 1 => "two", 2 => "three");
$array6 = array(0 => "four", 1 => "five");
echo "Array 5: ";
print_r($array5);
echo "<br>";
echo "Array 6: ";
print_r($array6);
echo "<br>";
$mergedArray3 = array_merge($array5, $array6);
echo "Merged Array (numeric keys re-indexed): ";
print_r($mergedArray3);
echo "<br><br>";

// Method 4: Merging multiple arrays
echo "<h3>Method 4: Merging multiple arrays</h3>";
$arr1 = array(1, 2, 3);
$arr2 = array(4, 5, 6);
$arr3 = array(7, 8, 9);
$arr4 = array(10, 11, 12);

$mergedMultiple = array_merge($arr1, $arr2, $arr3, $arr4);
echo "Merged Multiple Arrays: ";
print_r($mergedMultiple);
echo "<br><br>";

// Method 5: Merging associative arrays
echo "<h3>Method 5: Merging associative arrays</h3>";
$assoc1 = array("name" => "John", "age" => 25);
$assoc2 = array("city" => "New York", "country" => "USA");
echo "Assoc Array 1: ";
print_r($assoc1);
echo "<br>";
echo "Assoc Array 2: ";
print_r($assoc2);
echo "<br>";
$mergedAssoc = array_merge($assoc1, $assoc2);
echo "Merged Associative Array: ";
print_r($mergedAssoc);
echo "<br><br>";

// Method 6: Merging with duplicate keys
echo "<h3>Method 6: Handling duplicate keys</h3>";
$dup1 = array("a" => "apple", "b" => "banana", "c" => "cherry");
$dup2 = array("b" => "blueberry", "d" => "date");
echo "Array with dup1: ";
print_r($dup1);
echo "<br>";
echo "Array with dup2: ";
print_r($dup2);
echo "<br>";
$mergedDup = array_merge($dup1, $dup2);
echo "Merged (duplicate 'b' overwritten by second array): ";
print_r($mergedDup);
echo "<br><br>";

// Method 7: array_merge_recursive()
echo "<h3>Method 7: Using array_merge_recursive()</h3>";
$rec1 = array("a" => "apple", "b" => "banana");
$rec2 = array("b" => "blueberry", "c" => "cherry");
echo "Rec Array 1: ";
print_r($rec1);
echo "<br>";
echo "Rec Array 2: ";
print_r($rec2);
echo "<br>";
$mergedRecursive = array_merge_recursive($rec1, $rec2);
echo "Merged Recursive: ";
print_r($mergedRecursive);
echo "<br><br>";

// Method 8: User input arrays
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $array1Input = $_POST['array1'];
    $array2Input = $_POST['array2'];
    
    if (!empty($array1Input) && !empty($array2Input)) {
        $userArray1 = array_map('trim', explode(',', $array1Input));
        $userArray2 = array_map('trim', explode(',', $array2Input));
        
        echo "<h3>User Input Arrays:</h3>";
        echo "Array 1: ";
        print_r($userArray1);
        echo "<br>";
        echo "Array 2: ";
        print_r($userArray2);
        echo "<br>";
        
        $userMerged = array_merge($userArray1, $userArray2);
        echo "Merged User Arrays: ";
        print_r($userMerged);
        echo "<br>";
        echo "Merged (string): " . implode(", ", $userMerged) . "<br><br>";
    }
}
?>

<!-- User input form -->
<form method="POST">
    <h3>Enter two arrays to merge (comma separated):</h3>
    Array 1: <input type="text" name="array1" placeholder="e.g., a, b, c" size="30"><br>
    Array 2: <input type="text" name="array2" placeholder="e.g., d, e, f" size="30"><br>
    <input type="submit" name="submit" value="Merge Arrays">
</form>

<hr>

<!-- Additional examples with different data types -->
<?php
echo "<h3>Additional Examples:</h3>";

// Merging arrays with different data types
$mixed1 = array(1, "hello", 3.14, true);
$mixed2 = array("world", false, 42);
$mixedMerged = array_merge($mixed1, $mixed2);
echo "Mixed Array Merge: ";
print_r($mixedMerged);
echo "<br>";

// Merging and maintaining type
$numeric = array(10, 20, 30);
$string = array("one", "two", "three");
$mergedNumericString = array_merge($numeric, $string);
echo "Numeric and String Arrays: ";
print_r($mergedNumericString);
echo "<br>";

// Merging with array_combine (creates key-value pairs)
$keys = array("name", "age", "city");
$values = array("Alice", 30, "London");
$combined = array_combine($keys, $values);
echo "Combined Array (keys + values): ";
print_r($combined);
echo "<br>";

// Counting merged array
$countMerged = count($mergedMultiple);
echo "Count of merged multiple array: $countMerged elements<br>";
?>