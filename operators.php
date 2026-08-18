<?php
echo "<h2>PHP Operators Demonstration</h2>";

// Arithmetic Operators
echo "<h3>1. Arithmetic Operators</h3>";
$a = 20;
$b = 5;

echo "a = $a, b = $b<br>";
echo "a + b = " . ($a + $b) . "<br>";
echo "a - b = " . ($a - $b) . "<br>";
echo "a * b = " . ($a * $b) . "<br>";
echo "a / b = " . ($a / $b) . "<br>";
echo "a % b = " . ($a % $b) . "<br>";
echo "a ** b = " . ($a ** $b) . "<br>";

// Assignment Operators
echo "<h3>2. Assignment Operators</h3>";
$x = 10;
echo "x = $x<br>";
$x += 5;
echo "x += 5: $x<br>";
$x -= 3;
echo "x -= 3: $x<br>";
$x *= 2;
echo "x *= 2: $x<br>";
$x /= 4;
echo "x /= 4: $x<br>";
$x %= 5;
echo "x %= 5: $x<br>";

// Comparison Operators
echo "<h3>3. Comparison Operators</h3>";
$p = 10;
$q = "10";

echo "p = 10, q = '10'<br>";
echo "p == q: " . ($p == $q ? "True" : "False") . "<br>";
echo "p === q: " . ($p === $q ? "True" : "False") . "<br>";
echo "p != q: " . ($p != $q ? "True" : "False") . "<br>";
echo "p !== q: " . ($p !== $q ? "True" : "False") . "<br>";
echo "p > q: " . ($p > $q ? "True" : "False") . "<br>";
echo "p < q: " . ($p < $q ? "True" : "False") . "<br>";
echo "p >= q: " . ($p >= $q ? "True" : "False") . "<br>";
echo "p <= q: " . ($p <= $q ? "True" : "False") . "<br>";

// Logical Operators
echo "<h3>4. Logical Operators</h3>";
$m = true;
$n = false;

echo "m = true, n = false<br>";
echo "m AND n: " . ($m && $n ? "True" : "False") . "<br>";
echo "m OR n: " . ($m || $n ? "True" : "False") . "<br>";
echo "NOT m: " . (!$m ? "True" : "False") . "<br>";
echo "m XOR n: " . ($m xor $n ? "True" : "False") . "<br>";

// Increment/Decrement Operators
echo "<h3>5. Increment/Decrement Operators</h3>";
$count = 5;
echo "count = $count<br>";
echo "++count: " . ++$count . "<br>";
echo "count++: " . $count++ . "<br>";
echo "count after post-increment: $count<br>";
echo "--count: " . --$count . "<br>";
echo "count--: " . $count-- . "<br>";
echo "count after post-decrement: $count<br>";

// String Operators
echo "<h3>6. String Operators</h3>";
$str1 = "Hello";
$str2 = " World!";
echo "str1 = '$str1', str2 = '$str2'<br>";
echo "str1 . str2: " . ($str1 . $str2) . "<br>";
$str1 .= $str2;
echo "str1 .= str2: $str1<br>";
?>