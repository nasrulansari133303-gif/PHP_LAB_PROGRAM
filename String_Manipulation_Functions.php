<?php
echo "<h2>MySQL String Manipulation Functions (PHP Implementation)</h2>";

// Sample strings
$sampleString1 = "  Hello World  ";
$sampleString2 = "MySQL";
$sampleString3 = "Programming";
$sampleString4 = "Hello World! This is a PHP program.";

echo "<h3>Sample Strings:</h3>";
echo "String 1: '$sampleString1'<br>";
echo "String 2: '$sampleString2'<br>";
echo "String 3: '$sampleString3'<br>";
echo "String 4: '$sampleString4'<br><br>";

// 1. Length() - String length
echo "<h4>1. Length() - String Length</h4>";
echo "Length of '$sampleString1': " . strlen($sampleString1) . " characters<br>";
echo "Length of '$sampleString2': " . strlen($sampleString2) . " characters<br>";
echo "Length of '$sampleString3': " . strlen($sampleString3) . " characters<br><br>";

// 2. concat() - Concatenate strings
echo "<h4>2. concat() - Concatenate Strings</h4>";
$concatenated = $sampleString2 . " " . $sampleString3;
echo "Concatenated: '$sampleString2' + ' ' + '$sampleString3' = '$concatenated'<br>";
$concatenated2 = "Hello" . " " . "World" . "!" . " " . "This is PHP.";
echo "Multiple concatenation: '$concatenated2'<br><br>";

// 3. concat_ws() - Concatenate with separator
echo "<h4>3. concat_ws() - Concatenate with Separator</h4>";
$words = array("Hello", "World", "PHP", "Programming");
$concatenatedWs = implode(" - ", $words);
echo "concat_ws with '-' separator: '$concatenatedWs'<br>";
$concatenatedWs2 = implode(" | ", $words);
echo "concat_ws with '|' separator: '$concatenatedWs2'<br><br>";

// 4. trim(), rtrim(), ltrim()
echo "<h4>4. trim(), rtrim(), ltrim()</h4>";
$stringWithSpaces = "  Trim me!  ";
echo "Original: '$stringWithSpaces'<br>";
echo "trim(): '" . trim($stringWithSpaces) . "'<br>";
echo "ltrim(): '" . ltrim($stringWithSpaces) . "'<br>";
echo "rtrim(): '" . rtrim($stringWithSpaces) . "'<br>";
echo "trim with specific characters: '" . trim($stringWithSpaces, " !") . "'<br><br>";

// 5. lpad(), rpad(), locate()
echo "<h4>5. lpad(), rpad(), locate()</h4>";

// lpad - left pad
$stringToPad = "Hello";
echo "Original: '$stringToPad'<br>";
echo "lpad (10 chars, '*'): '" . str_pad($stringToPad, 10, "*", STR_PAD_LEFT) . "'<br>";
echo "lpad (15 chars, '-='): '" . str_pad($stringToPad, 15, "-=", STR_PAD_LEFT) . "'<br>";

// rpad - right pad
echo "rpad (10 chars, '*'): '" . str_pad($stringToPad, 10, "*", STR_PAD_RIGHT) . "'<br>";
echo "rpad (15 chars, '-='): '" . str_pad($stringToPad, 15, "-=", STR_PAD_RIGHT) . "'<br>";

// locate - find position
$searchString = "Hello World! This is a PHP program.";
$searchWord = "PHP";
$position = strpos($searchString, $searchWord);
echo "locate('$searchWord' in '$searchString'): Position = $position<br>";
$searchWord2 = "is";
$position2 = strpos($searchString, $searchWord2);
echo "locate('$searchWord2' in '$searchString'): Position = $position2<br>";

// locate with starting position
$position3 = strpos($searchString, "is", $position2 + 1);
echo "locate('is' from position " . ($position2 + 1) . "): Position = $position3<br><br>";

// Additional string functions
echo "<h3>Additional String Functions:</h3>";

// substr
echo "<h4>substr() - Extract substring</h4>";
$text = "Hello World";
echo "Original: '$text'<br>";
echo "substr(0, 5): '" . substr($text, 0, 5) . "'<br>";
echo "substr(6): '" . substr($text, 6) . "'<br>";
echo "substr(-5): '" . substr($text, -5) . "'<br><br>";

// replace
echo "<h4>replace() - Replace string</h4>";
$original = "I love Java";
echo "Original: '$original'<br>";
echo "Replace 'Java' with 'PHP': '" . str_replace("Java", "PHP", $original) . "'<br><br>";

// upper/lower
echo "<h4>UPPER/LOWER - Case Conversion</h4>";
$mixedCase = "Hello World!";
echo "Original: '$mixedCase'<br>";
echo "UPPER: '" . strtoupper($mixedCase) . "'<br>";
echo "LOWER: '" . strtolower($mixedCase) . "'<br><br>";

// Practical demonstration
echo "<h3>Practical Example - Data Cleaning:</h3>";
$userData = array(
    "  John Doe  ",
    "  jane.smith@email.com  ",
    "  New York  "
);

echo "Original Data:<br>";
foreach ($userData as $data) {
    echo "'$data'<br>";
}

echo "<br>Cleaned Data:<br>";
foreach ($userData as $data) {
    $cleaned = trim($data);
    $cleaned = strtolower($cleaned);
    echo "'$cleaned'<br>";
}
?>