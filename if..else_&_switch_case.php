<?php
// Get current month number (1-12)
$currentMonth = date("n");
$monthName = date("F");

echo "<h2>Current Month: $monthName</h2>";

// Method 1: Using if..elseif..else
echo "<h3>Using if..elseif..else:</h3>";
if ($currentMonth == 1) {
    echo "January";
} elseif ($currentMonth == 2) {
    echo "February";
} elseif ($currentMonth == 3) {
    echo "March";
} elseif ($currentMonth == 4) {
    echo "April";
} elseif ($currentMonth == 5) {
    echo "May";
} elseif ($currentMonth == 6) {
    echo "June";
} elseif ($currentMonth == 7) {
    echo "July";
} elseif ($currentMonth == 8) {
    echo "August";
} elseif ($currentMonth == 9) {
    echo "September";
} elseif ($currentMonth == 10) {
    echo "October";
} elseif ($currentMonth == 11) {
    echo "November";
} else {
    echo "December";
}
echo "<br>";

// Method 2: Using switch case
echo "<h3>Using switch case:</h3>";
switch ($currentMonth) {
    case 1:
        echo "January";
        break;
    case 2:
        echo "February";
        break;
    case 3:
        echo "March";
        break;
    case 4:
        echo "April";
        break;
    case 5:
        echo "May";
        break;
    case 6:
        echo "June";
        break;
    case 7:
        echo "July";
        break;
    case 8:
        echo "August";
        break;
    case 9:
        echo "September";
        break;
    case 10:
        echo "October";
        break;
    case 11:
        echo "November";
        break;
    case 12:
        echo "December";
        break;
    default:
        echo "Invalid month";
}
echo "<br>";

// Additional information
echo "<h3>Additional Information:</h3>";
echo "Month Number: " . $currentMonth . "<br>";
echo "Month Name (short): " . date("M") . "<br>";
echo "Month Name (full): " . date("F") . "<br>";
echo "Days in current month: " . date("t") . "<br>";
echo "Year: " . date("Y") . "<br>";

// Season detection using switch
echo "<h3>Season:</h3>";
switch ($currentMonth) {
    case 12:
    case 1:
    case 2:
        echo "Winter";
        break;
    case 3:
    case 4:
    case 5:
        echo "Spring";
        break;
    case 6:
    case 7:
    case 8:
        echo "Summer";
        break;
    case 9:
    case 10:
    case 11:
        echo "Autumn/Fall";
        break;
    default:
        echo "Unknown season";
}
?>