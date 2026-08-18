<?php
echo "<h2>Type Casting with settype() and gettype()</h2>";

// Demonstration variables
$integerVar = 42;
$floatVar = 3.14;
$stringVar = "123";
$booleanVar = true;
$arrayVar = array(1, 2, 3);
$nullVar = null;

echo "<h3>Original Variables:</h3>";
echo "integerVar = $integerVar (Type: " . gettype($integerVar) . ")<br>";
echo "floatVar = $floatVar (Type: " . gettype($floatVar) . ")<br>";
echo "stringVar = $stringVar (Type: " . gettype($stringVar) . ")<br>";
echo "booleanVar = " . ($booleanVar ? "true" : "false") . " (Type: " . gettype($booleanVar) . ")<br>";
echo "arrayVar = "; print_r($arrayVar); echo " (Type: " . gettype($arrayVar) . ")<br>";
echo "nullVar = " . (is_null($nullVar) ? "null" : "not null") . " (Type: " . gettype($nullVar) . ")<br><br>";

// Using settype() to change types
echo "<h3>Using settype() to change types:</h3>";

// 1. Integer to String
$testVar = 456;
echo "Before: \$testVar = $testVar (Type: " . gettype($testVar) . ")<br>";
settype($testVar, "string");
echo "After settype(\$testVar, 'string'): \$testVar = $testVar (Type: " . gettype($testVar) . ")<br><br>";

// 2. String to Integer
$testVar2 = "789";
echo "Before: \$testVar2 = $testVar2 (Type: " . gettype($testVar2) . ")<br>";
settype($testVar2, "int");
echo "After settype(\$testVar2, 'int'): \$testVar2 = $testVar2 (Type: " . gettype($testVar2) . ")<br><br>";

// 3. Float to Integer
$testVar3 = 99.99;
echo "Before: \$testVar3 = $testVar3 (Type: " . gettype($testVar3) . ")<br>";
settype($testVar3, "int");
echo "After settype(\$testVar3, 'int'): \$testVar3 = $testVar3 (Type: " . gettype($testVar3) . ")<br><br>";

// 4. String to Boolean
$testVar4 = "Hello";
echo "Before: \$testVar4 = $testVar4 (Type: " . gettype($testVar4) . ")<br>";
settype($testVar4, "bool");
echo "After settype(\$testVar4, 'bool'): \$testVar4 = " . ($testVar4 ? "true" : "false") . " (Type: " . gettype($testVar4) . ")<br><br>";

// 5. Integer to Float
$testVar5 = 100;
echo "Before: \$testVar5 = $testVar5 (Type: " . gettype($testVar5) . ")<br>";
settype($testVar5, "float");
echo "After settype(\$testVar5, 'float'): \$testVar5 = $testVar5 (Type: " . gettype($testVar5) . ")<br><br>";

// Type casting using type casting operators
echo "<h3>Type Casting using casting operators:</h3>";

$castVar = "123.45";
echo "Original: \$castVar = $castVar (Type: " . gettype($castVar) . ")<br>";

$intCasted = (int)$castVar;
echo "(int) cast: $intCasted (Type: " . gettype($intCasted) . ")<br>";

$floatCasted = (float)$castVar;
echo "(float) cast: $floatCasted (Type: " . gettype($floatCasted) . ")<br>";

$stringCasted = (string)$intCasted;
echo "(string) cast: $stringCasted (Type: " . gettype($stringCasted) . ")<br>";

$boolCasted = (bool)$castVar;
echo "(bool) cast: " . ($boolCasted ? "true" : "false") . " (Type: " . gettype($boolCasted) . ")<br>";

$arrayCasted = (array)$castVar;
echo "(array) cast: ";
print_r($arrayCasted);
echo " (Type: " . gettype($arrayCasted) . ")<br>";

$objectCasted = (object)$castVar;
echo "(object) cast: ";
print_r($objectCasted);
echo " (Type: " . gettype($objectCasted) . ")<br><br>";

// Practical example
echo "<h3>Practical Example - Form Input Processing:</h3>";
$_POST['age'] = "25";
$_POST['price'] = "99.99";
$_POST['name'] = "John";

echo "Before casting:<br>";
echo "Age: " . $_POST['age'] . " (Type: " . gettype($_POST['age']) . ")<br>";
echo "Price: " . $_POST['price'] . " (Type: " . gettype($_POST['price']) . ")<br>";
echo "Name: " . $_POST['name'] . " (Type: " . gettype($_POST['name']) . ")<br>";

// Cast for calculations
$ageCasted = (int)$_POST['age'];
$priceCasted = (float)$_POST['price'];

echo "<br>After casting for calculations:<br>";
echo "Age (int): $ageCasted (Type: " . gettype($ageCasted) . ")<br>";
echo "Price (float): $priceCasted (Type: " . gettype($priceCasted) . ")<br>";
echo "Total (Age * Price): " . ($ageCasted * $priceCasted) . "<br>";
?>