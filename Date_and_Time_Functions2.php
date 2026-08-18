<?php
echo "<h2>MySQL Date and Time Functions (HOUR, MINUTE, SECOND, DATE_FORMAT, DATE_SUB)</h2>";

// Get current date and time
$currentDateTime = date("Y-m-d H:i:s");
$timestamp = time();

echo "<h3>Current Date & Time:</h3>";
echo "Current DateTime: $currentDateTime<br>";
echo "Timestamp: $timestamp<br><br>";

// 1. HOUR() - Extract hour
echo "<h4>1. HOUR() - Extract Hour</h4>";
$hour = date("H", $timestamp);
echo "HOUR(): $hour<br>";
$hour12 = date("h", $timestamp);
echo "HOUR() (12-hour): $hour12<br>";
$hour24 = date("G", $timestamp);
echo "HOUR() (24-hour without leading zero): $hour24<br><br>";

// 2. MINUTE() - Extract minute
echo "<h4>2. MINUTE() - Extract Minute</h4>";
$minute = date("i", $timestamp);
echo "MINUTE(): $minute<br><br>";

// 3. SECOND() - Extract second
echo "<h4>3. SECOND() - Extract Second</h4>";
$second = date("s", $timestamp);
echo "SECOND(): $second<br><br>";

// 4. DATE_FORMAT() - Format date
echo "<h4>4. DATE_FORMAT() - Format Date</h4>";
$date = date("Y-m-d H:i:s");

echo "Original Date: $date<br>";
echo "DATE_FORMAT('%Y-%m-%d'): " . date("Y-m-d", strtotime($date)) . "<br>";
echo "DATE_FORMAT('%d/%m/%Y'): " . date("d/m/Y", strtotime($date)) . "<br>";
echo "DATE_FORMAT('%M %d, %Y'): " . date("F d, Y", strtotime($date)) . "<br>";
echo "DATE_FORMAT('%W, %M %d, %Y'): " . date("l, F d, Y", strtotime($date)) . "<br>";
echo "DATE_FORMAT('%h:%i %p'): " . date("h:i A", strtotime($date)) . "<br>";
echo "DATE_FORMAT('%Y-%m-%d %H:%i:%s'): " . date("Y-m-d H:i:s", strtotime($date)) . "<br><br>";

// 5. DATE_SUB() - Subtract from date
echo "<h4>5. DATE_SUB() - Subtract from Date</h4>";

// Subtract days
$dateSubDays = date("Y-m-d", strtotime("-7 days"));
echo "DATE_SUB('$currentDateTime', INTERVAL 7 DAY): $dateSubDays<br>";

// Subtract months
$dateSubMonths = date("Y-m-d", strtotime("-3 months"));
echo "DATE_SUB('$currentDateTime', INTERVAL 3 MONTH): $dateSubMonths<br>";

// Subtract years
$dateSubYears = date("Y-m-d", strtotime("-1 year"));
echo "DATE_SUB('$currentDateTime', INTERVAL 1 YEAR): $dateSubYears<br>";

// Subtract hours
$dateSubHours = date("Y-m-d H:i:s", strtotime("-5 hours"));
echo "DATE_SUB('$currentDateTime', INTERVAL 5 HOUR): $dateSubHours<br>";

// Subtract minutes
$dateSubMinutes = date("Y-m-d H:i:s", strtotime("-30 minutes"));
echo "DATE_SUB('$currentDateTime', INTERVAL 30 MINUTE): $dateSubMinutes<br>";

// Subtract seconds
$dateSubSeconds = date("Y-m-d H:i:s", strtotime("-45 seconds"));
echo "DATE_SUB('$currentDateTime', INTERVAL 45 SECOND): $dateSubSeconds<br><br>";

// Demonstration with different dates
echo "<h3>Demonstration with Different Dates:</h3>";

$testDateTime = "2024-12-25 15:30:45";
$ts = strtotime($testDateTime);

echo "<strong>Test DateTime: $testDateTime</strong><br>";
echo "HOUR(): " . date("H", $ts) . "<br>";
echo "MINUTE(): " . date("i", $ts) . "<br>";
echo "SECOND(): " . date("s", $ts) . "<br>";

echo "DATE_FORMAT as 'M d, Y': " . date("M d, Y", $ts) . "<br>";
echo "DATE_FORMAT as 'h:i A': " . date("h:i A", $ts) . "<br>";

echo "DATE_SUB (7 days): " . date("Y-m-d", strtotime("-7 days", $ts)) . "<br>";
echo "DATE_SUB (2 months): " . date("Y-m-d", strtotime("-2 months", $ts)) . "<br><br>";

// Practical examples
echo "<h3>Practical Examples:</h3>";

// 1. Time difference
echo "<h4>Time Difference Calculation:</h4>";
$startTime = "09:00:00";
$endTime = "17:30:00";
$diff = strtotime($endTime) - strtotime($startTime);
$hours = floor($diff / 3600);
$minutes = floor(($diff % 3600) / 60);
echo "Start: $startTime<br>";
echo "End: $endTime<br>";
echo "Difference: $hours hours and $minutes minutes<br><br>";

// 2. Date difference
echo "<h4>Date Difference Calculation:</h4>";
$startDate = "2024-01-01";
$endDate = "2024-12-31";
$diffDays = (strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24);
echo "Start: $startDate<br>";
echo "End: $endDate<br>";
echo "Difference: $diffDays days<br><br>";

// 3. Formatting for display
echo "<h4>Date Formatting Examples:</h4>";
$dateNow = date("Y-m-d H:i:s");
echo "Original: $dateNow<br>";
echo "US Format: " . date("m/d/Y h:i A", strtotime($dateNow)) . "<br>";
echo "UK Format: " . date("d/m/Y H:i", strtotime($dateNow)) . "<br>";
echo "ISO Format: " . date("Y-m-d\TH:i:sO", strtotime($dateNow)) . "<br>";
?>