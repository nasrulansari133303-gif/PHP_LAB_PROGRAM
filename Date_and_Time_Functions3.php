<?php
echo "<h2>MySQL Date and Time Functions (CURDATE, CURTIME, UNIX_TIMESTAMP, FROM_UNIXTIME)</h2>";

// 1. CURDATE() / CURRENT_DATE
echo "<h3>1. CURDATE() / CURRENT_DATE</h3>";
$currentDate = date("Y-m-d");
echo "CURDATE(): $currentDate<br>";
$currentDate2 = date("Y/m/d");
echo "CURRENT_DATE (alternate format): $currentDate2<br>";
$currentDate3 = date("d-m-Y");
echo "CURRENT_DATE (d-m-Y): $currentDate3<br><br>";

// 2. CURTIME() / CURRENT_TIME()
echo "<h3>2. CURTIME() / CURRENT_TIME()</h3>";
$currentTime = date("H:i:s");
echo "CURTIME(): $currentTime<br>";
$currentTime12 = date("h:i:s A");
echo "CURRENT_TIME (12-hour format): $currentTime12<br>";
$currentTime24 = date("H:i");
echo "CURRENT_TIME (24-hour without seconds): $currentTime24<br><br>";

// 3. UNIX_TIMESTAMP()
echo "<h3>3. UNIX_TIMESTAMP()</h3>";
$unixTimestamp = time();
echo "UNIX_TIMESTAMP(): $unixTimestamp<br>";

// Current timestamp with microtime
$microTimestamp = microtime(true);
echo "UNIX_TIMESTAMP() with microseconds: $microTimestamp<br>";

// Timestamp for a specific date
$specificDate = "2024-01-01 00:00:00";
$specificTimestamp = strtotime($specificDate);
echo "UNIX_TIMESTAMP('$specificDate'): $specificTimestamp<br><br>";

// 4. FROM_UNIXTIME()
echo "<h3>4. FROM_UNIXTIME()</h3>";

// Convert timestamp to date
$timestamp1 = time();
$convertedDate = date("Y-m-d H:i:s", $timestamp1);
echo "FROM_UNIXTIME($timestamp1): $convertedDate<br>";

// Different formats
echo "FROM_UNIXTIME($timestamp1, '%Y-%m-%d'): " . date("Y-m-d", $timestamp1) . "<br>";
echo "FROM_UNIXTIME($timestamp1, '%Y-%m-%d %H:%i:%s'): " . date("Y-m-d H:i:s", $timestamp1) . "<br>";
echo "FROM_UNIXTIME($timestamp1, '%M %d, %Y'): " . date("F d, Y", $timestamp1) . "<br>";
echo "FROM_UNIXTIME($timestamp1, '%W, %M %d, %Y'): " . date("l, F d, Y", $timestamp1) . "<br>";

// Specific timestamp conversion
$specificTimestamp2 = 1704067200; // 2024-01-01 00:00:00
$convertedSpecific = date("Y-m-d H:i:s", $specificTimestamp2);
echo "FROM_UNIXTIME($specificTimestamp2): $convertedSpecific<br><br>";

// Demonstration with different timestamps
echo "<h3>Demonstration with Different Timestamps:</h3>";

$timestamps = array(
    time(),
    strtotime("2024-01-01"),
    strtotime("2024-12-25"),
    strtotime("2025-07-04")
);

echo "<table border='1' cellpadding='8'>";
echo "<tr><th>UNIX_TIMESTAMP</th><th>FROM_UNIXTIME (Y-m-d)</th><th>FROM_UNIXTIME (M d, Y)</th></tr>";
foreach ($timestamps as $ts) {
    echo "<tr>";
    echo "<td>$ts</td>";
    echo "<td>" . date("Y-m-d", $ts) . "</td>";
    echo "<td>" . date("M d, Y", $ts) . "</td>";
    echo "</tr>";
}
echo "</table><br>";

// Practical examples
echo "<h3>Practical Examples:</h3>";

// 1. Calculate age from timestamp
echo "<h4>Calculate Age:</h4>";
$birthDate = "1990-06-15";
$birthTimestamp = strtotime($birthDate);
$currentTimestamp = time();
$age = floor(($currentTimestamp - $birthTimestamp) / (60 * 60 * 24 * 365.25));
echo "Birth Date: $birthDate<br>";
echo "Age: $age years<br><br>";

// 2. Time since specific date
echo "<h4>Time Since Specific Date:</h4>";
$pastDate = "2024-01-01 00:00:00";
$pastTimestamp = strtotime($pastDate);
$currentTimestamp = time();
$secondsDiff = $currentTimestamp - $pastTimestamp;
$days = floor($secondsDiff / (60 * 60 * 24));
$hours = floor(($secondsDiff % (60 * 60 * 24)) / (60 * 60));
$minutes = floor(($secondsDiff % (60 * 60)) / 60);

echo "Past Date: $pastDate<br>";
echo "Current Date: " . date("Y-m-d H:i:s", $currentTimestamp) . "<br>";
echo "Time Difference: $days days, $hours hours, $minutes minutes<br><br>";

// 3. Date arithmetic
echo "<h4>Date Arithmetic:</h4>";

// Add 7 days to current date
$futureDate = date("Y-m-d", strtotime("+7 days"));
echo "Current Date: " . date("Y-m-d") . "<br>";
echo "Current Date + 7 days: $futureDate<br>";

// Subtract 30 days
$pastDate = date("Y-m-d", strtotime("-30 days"));
echo "Current Date - 30 days: $pastDate<br>";

// Add 3 months
$futureMonth = date("Y-m-d", strtotime("+3 months"));
echo "Current Date + 3 months: $futureMonth<br><br>";

// 4. Complete date and time functions summary
echo "<h3>Complete Date and Time Summary:</h3>";

echo "<table border='1' cellpadding='8'>";
echo "<tr><th>Function</th><th>PHP Equivalent</th><th>Result</th></tr>";
echo "<tr><td>CURDATE()</td><td>date('Y-m-d')</td><td>" . date("Y-m-d") . "</td></tr>";
echo "<tr><td>CURRENT_DATE</td><td>date('Y-m-d')</td><td>" . date("Y-m-d") . "</td></tr>";
echo "<tr><td>CURTIME()</td><td>date('H:i:s')</td><td>" . date("H:i:s") . "</td></tr>";
echo "<tr><td>CURRENT_TIME</td><td>date('H:i:s')</td><td>" . date("H:i:s") . "</td></tr>";
echo "<tr><td>UNIX_TIMESTAMP()</td><td>time()</td><td>" . time() . "</td></tr>";
echo "<tr><td>FROM_UNIXTIME()</td><td>date('Y-m-d H:i:s', timestamp)</td><td>" . date("Y-m-d H:i:s", time()) . "</td></tr>";
echo "</table><br>";

// 5. Timezone handling
echo "<h4>Timezone Handling:</h4>";
date_default_timezone_set('America/New_York');
echo "Current time in New York: " . date("Y-m-d H:i:s") . "<br>";

date_default_timezone_set('Asia/Kolkata');
echo "Current time in India: " . date("Y-m-d H:i:s") . "<br>";

date_default_timezone_set('Europe/London');
echo "Current time in London: " . date("Y-m-d H:i:s") . "<br>";

// Reset to default timezone
date_default_timezone_set('UTC');
echo "Current time in UTC: " . date("Y-m-d H:i:s") . "<br>";
?>