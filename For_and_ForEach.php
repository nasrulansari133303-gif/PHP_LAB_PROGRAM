<?php
// Method 1: Using for loop
echo "<h3>Using For Loop:</h3>";
for ($i = 5; $i <= 10; $i++) {
    echo $i . " ";
}
echo "<br>";

// Method 2: Using foreach loop
echo "<h3>Using Foreach Loop:</h3>";
$numbers = array(5, 6, 7, 8, 9, 10);
foreach ($numbers as $num) {
    echo $num . " ";
}
echo "<br>";

// Method 3: Using foreach with range()
echo "<h3>Using Foreach with range():</h3>";
foreach (range(5, 10) as $num) {
    echo $num . " ";
}
echo "<br>";

// Method 4: For loop with step
echo "<h3>For loop with step (even numbers from 5 to 10):</h3>";
for ($i = 5; $i <= 10; $i+=2) {
    echo $i . " ";
}
echo "<br>";

// Method 5: Nested for loop
echo "<h3>Nested For Loop (Multiplication Table 5x):</h3>";
for ($i = 5; $i <= 10; $i++) {
    echo "5 x $i = " . (5 * $i) . "<br>";
}

// Method 6: For loop with break
echo "<h3>For loop with break:</h3>";
for ($i = 5; $i <= 15; $i++) {
    if ($i > 10) {
        break;
    }
    echo $i . " ";
}
echo "<br>";

// Method 7: For loop with continue
echo "<h3>For loop with continue (skip even numbers):</h3>";
for ($i = 5; $i <= 10; $i++) {
    if ($i % 2 == 0) {
        continue;
    }
    echo $i . " ";
}
?>