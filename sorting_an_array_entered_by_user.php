<?php
echo "<h2>Sorting an Array Entered by User</h2>";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $arrayValues = $_POST['array_values'];
    
    if (!empty($arrayValues)) {
        $userArray = array_map('trim', explode(',', $arrayValues));
        
        echo "<h3>Original Array:</h3>";
        echo "Array: ";
        print_r($userArray);
        echo "<br><br>";
        
        // 1. sort() - Sort array in ascending order (re-indexes)
        $sortedAsc = $userArray;
        sort($sortedAsc);
        echo "<h4>1. sort() - Ascending (re-indexed):</h4>";
        echo "Array: ";
        print_r($sortedAsc);
        echo "<br>";
        
        // 2. rsort() - Sort array in descending order (re-indexes)
        $sortedDesc = $userArray;
        rsort($sortedDesc);
        echo "<h4>2. rsort() - Descending (re-indexed):</h4>";
        echo "Array: ";
        print_r($sortedDesc);
        echo "<br>";
        
        // 3. asort() - Sort array in ascending order (preserves keys)
        $asortedAsc = $userArray;
        asort($asortedAsc);
        echo "<h4>3. asort() - Ascending (preserves keys):</h4>";
        echo "Array: ";
        print_r($asortedAsc);
        echo "<br>";
        
        // 4. arsort() - Sort array in descending order (preserves keys)
        $asortedDesc = $userArray;
        arsort($asortedDesc);
        echo "<h4>4. arsort() - Descending (preserves keys):</h4>";
        echo "Array: ";
        print_r($asortedDesc);
        echo "<br>";
        
        // 5. ksort() - Sort array by keys in ascending order
        $ksortedAsc = $userArray;
        ksort($ksortedAsc);
        echo "<h4>5. ksort() - Sort by keys ascending:</h4>";
        echo "Array: ";
        print_r($ksortedAsc);
        echo "<br>";
        
        // 6. krsort() - Sort array by keys in descending order
        $ksortedDesc = $userArray;
        krsort($ksortedDesc);
        echo "<h4>6. krsort() - Sort by keys descending:</h4>";
        echo "Array: ";
        print_r($ksortedDesc);
        echo "<br>";
        
        // Display as strings
        echo "<h4>Sorted Arrays as Strings:</h4>";
        echo "Original: " . implode(", ", $userArray) . "<br>";
        echo "Ascending: " . implode(", ", $sortedAsc) . "<br>";
        echo "Descending: " . implode(", ", $sortedDesc) . "<br>";
        
        // Sorting with numeric values
        echo "<h4>Sorting with numeric values:</h4>";
        $numericArray = array_map('intval', $userArray);
        sort($numericArray);
        echo "Numeric Ascending: " . implode(", ", $numericArray) . "<br>";
        rsort($numericArray);
        echo "Numeric Descending: " . implode(", ", $numericArray) . "<br>";
    } else {
        echo "Please enter some values!";
    }
}
?>

<form method="POST">
    <h3>Enter array values (comma separated):</h3>
    <input type="text" name="array_values" placeholder="e.g., 5, 2, 8, 1, 9" size="50">
    <input type="submit" name="submit" value="Sort Array">
</form>