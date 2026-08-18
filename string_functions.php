<?php
echo "<h2>String Functions Demonstration</h2>";

// Sample string
$sampleString = "Hello World! This is a sample string for demonstration.";
echo "<h3>Sample String:</h3>";
echo "$sampleString<br><br>";

// 1. strlen()
echo "<h4>1. strlen() - String Length</h4>";
echo "Length of string: " . strlen($sampleString) . " characters<br><br>";

// 2. strpos()
echo "<h4>2. strpos() - Find position of substring</h4>";
$searchWord = "sample";
$position = strpos($sampleString, $searchWord);
if ($position !== false) {
    echo "Found '$searchWord' at position: $position<br>";
} else {
    echo "'$searchWord' not found<br>";
}

$searchLetter = "W";
$position2 = strpos($sampleString, $searchLetter);
echo "Found '$searchLetter' at position: $position2<br><br>";

// 3. str_word_count()
echo "<h4>3. str_word_count() - Count words</h4>";
echo "Number of words: " . str_word_count($sampleString) . "<br>";
echo "Word count with positions: ";
print_r(str_word_count($sampleString, 1));
echo "<br>";
echo "Word count with positions and characters: ";
print_r(str_word_count($sampleString, 2));
echo "<br><br>";

// 4. strrev()
echo "<h4>4. strrev() - Reverse string</h4>";
echo "Original: $sampleString<br>";
echo "Reversed: " . strrev($sampleString) . "<br><br>";

// 5. strtolower()
echo "<h4>5. strtolower() - Convert to lowercase</h4>";
echo "Original: $sampleString<br>";
echo "Lowercase: " . strtolower($sampleString) . "<br><br>";

// 6. strtoupper()
echo "<h4>6. strtoupper() - Convert to uppercase</h4>";
echo "Original: $sampleString<br>";
echo "Uppercase: " . strtoupper($sampleString) . "<br><br>";

// Additional string functions
echo "<h3>Additional String Functions:</h3>";

// ucfirst() - Capitalize first character
echo "<h4>ucfirst()</h4>";
echo "Original: hello world<br>";
echo "ucfirst: " . ucfirst("hello world") . "<br><br>";

// ucwords() - Capitalize each word
echo "<h4>ucwords()</h4>";
echo "Original: hello world! this is php<br>";
echo "ucwords: " . ucwords("hello world! this is php") . "<br><br>";

// substr() - Extract substring
echo "<h4>substr()</h4>";
echo "Original: $sampleString<br>";
echo "First 10 characters: " . substr($sampleString, 0, 10) . "<br>";
echo "From position 6: " . substr($sampleString, 6) . "<br><br>";

// str_replace() - Replace string
echo "<h4>str_replace()</h4>";
echo "Original: I love PHP<br>";
echo "Replaced: " . str_replace("PHP", "JavaScript", "I love PHP") . "<br><br>";

// trim() - Remove whitespace
echo "<h4>trim()</h4>";
$stringWithSpaces = "  Hello World!  ";
echo "Original: '$stringWithSpaces'<br>";
echo "Trimmed: '" . trim($stringWithSpaces) . "'<br><br>";

// Practical example
echo "<h3>Practical Example:</h3>";
$userInput = "  John Doe  ";
$email = "JOHN.DOE@EXAMPLE.COM";

echo "User Input: '$userInput'<br>";
echo "Trimmed: '" . trim($userInput) . "'<br>";
echo "Email: $email<br>";
echo "Lowercase Email: " . strtolower($email) . "<br>";
echo "First Name: " . explode(" ", trim($userInput))[0] . "<br>";
echo "Last Name: " . explode(" ", trim($userInput))[1] . "<br>";
?>