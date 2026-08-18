<?php
// Method 1: Using while loop
echo "<h3>Using While Loop:</h3>";
$i = 15;
while ($i <= 20) {
    echo $i . " ";
    $i++;
}
echo "<br>";

// Method 2: Using do-while loop
echo "<h3>Using Do-While Loop:</h3>";
$j = 15;
do {
    echo $j . " ";
    $j++;
} while ($j <= 20);
echo "<br>";

// Method 3: While loop with different increments
echo "<h3>While loop with increment of 2 (odd numbers):</h3>";
$k = 15;
while ($k <= 20) {
    echo $k . " ";
    $k += 2;
}
echo "<br>";

// Method 4: Nested while loop
echo "<h3>Nested While Loop - Multiplication Table:</h3>";
$m = 15;
while ($m <= 20) {
    $n = 1;
    while ($n <= 5) {
        echo "$m x $n = " . ($m * $n) . "&nbsp;&nbsp;";
        $n++;
    }
    echo "<br>";
    $m++;
}

// Method 5: While loop with break
echo "<h3>While loop with break:</h3>";
$p = 15;
while ($p <= 25) {
    if ($p > 20) {
        break;
    }
    echo $p . " ";
    $p++;
}
echo "<br>";

// Method 6: Do-while with condition check
echo "<h3>Do-While loop with condition (runs at least once):</h3>";
$q = 25;
do {
    echo $q . " ";
    $q++;
} while ($q <= 20);
echo "<br>This ran once even though condition was false!<br>";

// Method 7: While loop with continue
echo "<h3>While loop with continue (skip even numbers):</h3>";
$r = 15;
while ($r <= 20) {
    if ($r % 2 == 0) {
        $r++;
        continue;
    }
    echo $r . " ";
    $r++;
}
?>