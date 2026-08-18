<?php
echo "<h2>MySQL Date and Time Functions (PHP Implementation)</h2>";

// Get current date
$currentDate = date("Y-m-d");
$timestamp = time();

echo "<h3>Current Date Information:</h3>";
echo "Current Date: $currentDate<br>";
echo "Current Timestamp: $timestamp<br><br>";

// 1. DAYOFWEEK() - Returns day of week (1 = Sunday, 7 = Saturday)
echo "<h4>1. DAYOFWEEK() - Day of Week (1=Sunday, 7=Saturday)</h4>";
$dayOfWeek = date("w", $timestamp);
// Convert to MySQL format (1=Sunday, 7=Saturday)
$dayOfWeekMySQL = ($dayOfWeek == 0) ? 7 : $dayOfWeek;
echo "DAYOFWEEK(): $dayOfWeekMySQL<br>";

$dayNames = array(
    1 => "Sunday",
    2 => "Monday",
    3 => "Tuesday",
    4 => "Wednesday",
    5 => "Thursday",
    6 => "Friday",
    7 => "Saturday"
);
echo "Day Name: " . $dayNames[$dayOfWeekMySQL] . "<br><br>";

// 2. WEEKDAY() - Returns day of week (0=Monday, 6=Sunday)
echo "<h4>2. WEEKDAY() - Day of Week (0=Monday, 6=Sunday)</h4>";
$weekDay = date("w", $timestamp);
// Convert to MySQL format (0=Monday, 6=Sunday)
$weekDayMySQL = ($weekDay == 0) ? 6 : $weekDay - 1;
echo "WEEKDAY(): $weekDayMySQL<br>";

$weekDayNames = array(
    0 => "Monday",
    1 => "Tuesday",
    2 => "Wednesday",
    3 => "Thursday",
    4 => "Friday",
    5 => "Saturday",
    6 => "Sunday"
);
echo "Day Name: " . $weekDayNames[$weekDayMySQL] . "<br><br>";

// 3. DAYOFMONTH() - Day of month
echo "<h4>3. DAYOFMONTH() - Day of Month</h4>";
$dayOfMonth = date("j", $timestamp);
echo "DAYOFMONTH(): $dayOfMonth<br><br>";

// 4. DAYOFYEAR() - Day of year (1-366)
echo "<h4>4. DAYOFYEAR() - Day of Year</h4>";
$dayOfYear = date("z", $timestamp) + 1;
echo "DAYOFYEAR(): $dayOfYear<br><br>";

// 5. DAYNAME() - Full day name
echo "<h4>5. DAYNAME() - Full Day Name</h4>";
$dayName = date("l", $timestamp);
echo "DAYNAME(): $dayName<br><br>";

// Demonstration with different dates
echo "<h3>Demonstration with Different Dates:</h3>";

$testDates = array(
    "2024-01-01",
    "2024-12-25",
    "2025-07-04",
    "2024-02-29"
);

foreach ($testDates as $date) {
    $ts = strtotime($date);
    echo "<strong>Date: $date</strong><br>";
    echo "DAYOFWEEK(): " . (date("w", $ts) == 0 ? 7 : date("w", $ts)) . "<br>";
    echo "WEEKDAY(): " . (date("w", $ts) == 0 ? 6 : date("w", $ts) - 1) . "<br>";
    echo "DAYOFMONTH(): " . date("j", $ts) . "<br>";
    echo "DAYOFYEAR(): " . (date("z", $ts) + 1) . "<br>";
    echo "DAYNAME(): " . date("l", $ts) . "<br><br>";
}

// Additional date functions
echo "<h3>Additional Date Functions:</h3>";

// Current date and time
echo "<h4>Current Date & Time:</h4>";
echo "Date: " . date("Y-m-d") . "<br>";
echo "Time: " . date("H:i:s") . "<br>";
echo "Date & Time: " . date("Y-m-d H:i:s") . "<br><br>";

// Different date formats
echo "<h4>Various Date Formats:</h4>";
echo "Y-m-d: " . date("Y-m-d") . "<br>";
echo "d/m/Y: " . date("d/m/Y") . "<br>";
echo "M d, Y: " . date("M d, Y") . "<br>";
echo "l, F jS, Y: " . date("l, F jS, Y") . "<br>";
echo "D, M j, Y: " . date("D, M j, Y") . "<br><br>";

// Practical example - Calculate days until next birthday
echo "<h3>Practical Example - Days Until Next Birthday:</h3>";
$birthday = "1990-06-15";
$birthdayDate = new DateTime($birthday);
$currentDateObj = new DateTime();
$nextBirthday = new DateTime(date("Y") . "-" . $birthdayDate->format("m-d"));

if ($nextBirthday < $currentDateObj) {
    $nextBirthday->modify('+1 year');
}

$daysUntil = $currentDateObj->diff($nextBirthday)->days;
echo "Birthday: $birthday<br>";
echo "Next Birthday: " . $nextBirthday->format("Y-m-d") . " (" . $nextBirthday->format("l") . ")<br>";
echo "Days until next birthday: $daysUntil days<br>";
?>