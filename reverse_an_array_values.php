<?php
echo "<h2>Reverse an Array</h2>";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $arrayValues = $_POST['array_values'];
    
    if (!empty($arrayValues)) {
        $originalArray = array_map('trim', explode(',', $arrayValues));
        
        echo "<h3>Original Array:</h3>";
        print_r($originalArray);
        echo "<br><br>";
        
        // Method 1: Using array_reverse() function
        $reversedArray1 = array_reverse($originalArray);
        echo "<h3>Method 1: Using array_reverse()</h3>";
        print_r($reversedArray1);
        echo "<br>";
        
        // Method 2: Using for loop with decreasing index
        echo "<h3>Method 2: Using for loop</h3>";
        $reversedArray2 = array();
        for ($i = count($originalArray) - 1; $i >= 0; $i--) {
            $reversedArray2[] = $originalArray[$i];
        }
        print_r($reversedArray2);
        echo "<br>";
        
        // Method 3: Using while loop
        echo "<h3>Method 3: Using while loop</h3>";
        $reversedArray3 = array();
        $j = count($originalArray) - 1;
        while ($j >= 0) {
            $reversedArray3[] = $originalArray[$j];
            $j--;
        }
        print_r($reversedArray3);
        echo "<br>";
        
        // Method 4: Using array_reverse() with preserve keys
        echo "<h3>Method 4: Using array_reverse() with preserve keys</h3>";
        $reversedArray4 = array_reverse($originalArray, true);
        print_r($reversedArray4);
        echo "<br>";
        
        // Method 5: Using manual swapping
        echo "<h3>Method 5: Using manual swapping</h3>";
        $reversedArray5 = $originalArray;
        $len = count($reversedArray5);
        for ($i = 0; $i < $len / 2; $i++) {
            $temp = $reversedArray5[$i];
            $reversedArray5[$i] = $reversedArray5[$len - 1 - $i];
            $reversedArray5[$len - 1 - $i] = $temp;
        }
        print_r($reversedArray5);
        echo "<br>";
        
        // Display as string
        echo "<h3>Reversed Array as String:</h3>";
        echo "Original: " . implode(", ", $originalArray) . "<br>";
        echo "Reversed: " . implode(", ", $reversedArray1) . "<br>";
        
        // Check if array is palindrome
        echo "<h3>Check if array is palindrome:</h3>";
        if ($originalArray == array_reverse($originalArray)) {
            echo "The array is a palindrome!<br>";
        } else {
            echo "The array is not a palindrome.<br>";
        }
        
    } else {
        echo "Please enter some values!";
    }
}
?>

<!-- Simple form to input array -->
<form method="POST">
    <h3>Enter array values (comma separated):</h3>
    <input type="text" name="array_values" placeholder="e.g., a, b, c, d" size="50">
    <input type="submit" name="submit" value="Reverse Array">
</form>

<hr>

<?php
// Multiple input method
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit2'])) {
    $arrayElements = array();
    
    for ($i = 0; $i < 5; $i++) {
        if (!empty($_POST["element$i"])) {
            $arrayElements[] = $_POST["element$i"];
        }
    }
    
    if (!empty($arrayElements)) {
        echo "<h3>Multiple Input Array:</h3>";
        echo "Original Array: ";
        print_r($arrayElements);
        echo "<br>";
        
        $reversed = array_reverse($arrayElements);
        echo "Reversed Array: ";
        print_r($reversed);
        echo "<br>";
        
        echo "Original (string): " . implode(", ", $arrayElements) . "<br>";
        echo "Reversed (string): " . implode(", ", $reversed) . "<br>";
    }
}
?>

<!-- Multiple input form -->
<form method="POST">
    <h3>Enter 5 array elements to reverse:</h3>
    Element 1: <input type="text" name="element0"><br>
    Element 2: <input type="text" name="element1"><br>
    Element 3: <input type="text" name="element2"><br>
    Element 4: <input type="text" name="element3"><br>
    Element 5: <input type="text" name="element4"><br>
    <input type="submit" name="submit2" value="Reverse Array">
</form>