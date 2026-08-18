<?php
// Method 1: Using built-in functions
$numbers = array(45, 78, 23, 90, 12, 56, 34, 89);

echo "Array elements: ";
print_r($numbers);
echo "<br>";

$maxNumber = max($numbers);
$minNumber = min($numbers);

echo "Maximum number: " . $maxNumber . "<br>";
echo "Minimum number: " . $minNumber . "<br>";

// Method 2: Using custom logic
function findMax($arr) {
    $max = $arr[0];
    for ($i = 1; $i < count($arr); $i++) {
        if ($arr[$i] > $max) {
            $max = $arr[$i];
        }
    }
    return $max;
}

function findMin($arr) {
    $min = $arr[0];
    for ($i = 1; $i < count($arr); $i++) {
        if ($arr[$i] < $min) {
            $min = $arr[$i];
        }
    }
    return $min;
}

echo "Using custom functions:<br>";
echo "Maximum number: " . findMax($numbers) . "<br>";
echo "Minimum number: " . findMin($numbers) . "<br>";

// Method 3: Taking user input
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    $num3 = $_POST['num3'];
    
    $maxInput = max($num1, $num2, $num3);
    $minInput = min($num1, $num2, $num3);
    
    echo "<br>User Input Results:<br>";
    echo "Numbers: $num1, $num2, $num3<br>";
    echo "Maximum: " . $maxInput . "<br>";
    echo "Minimum: " . $minInput . "<br>";
}
?>

<form method="POST">
    Enter three numbers:<br>
    Number 1: <input type="number" name="num1"><br>
    Number 2: <input type="number" name="num2"><br>
    Number 3: <input type="number" name="num3"><br>
    <input type="submit" value="Find Max & Min">
</form>