<?php
echo "<h2>Array Creation in PHP</h2>";

// 1. Numeric Array for Monday to Saturday
echo "<h3>1. Numeric Array - Days of Week</h3>";
$daysOfWeek = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

echo "Days of Week (Numeric Array):<br>";
foreach ($daysOfWeek as $index => $day) {
    echo "Index $index: $day<br>";
}
echo "<br>";

// 2. Associative Array for Months with Total Days
echo "<h3>2. Associative Array - Months with Days</h3>";
$monthsDays = array(
    "January" => 31,
    "February" => 28,
    "March" => 31,
    "April" => 30,
    "May" => 31,
    "June" => 30,
    "July" => 31,
    "August" => 31,
    "September" => 30,
    "October" => 31,
    "November" => 30,
    "December" => 31
);

echo "Months and their days:<br>";
foreach ($monthsDays as $month => $days) {
    echo "$month has $days days<br>";
}
echo "<br>";

// 3. Multidimensional Array for Laptops
echo "<h3>3. Multidimensional Array - Laptops</h3>";
$laptops = array(
    "Dell" => array(
        "models" => array(
            array("model" => "XPS 13", "price" => 1200),
            array("model" => "Inspiron 15", "price" => 800),
            array("model" => "Latitude 7420", "price" => 1500)
        )
    ),
    "HP" => array(
        "models" => array(
            array("model" => "Spectre x360", "price" => 1300),
            array("model" => "Pavilion 14", "price" => 700),
            array("model" => "EliteBook 840", "price" => 1400)
        )
    ),
    "Apple" => array(
        "models" => array(
            array("model" => "MacBook Pro", "price" => 2000),
            array("model" => "MacBook Air", "price" => 1200)
        )
    )
);

// Display laptops with company name, model, and price
echo "Laptop Details:<br>";
foreach ($laptops as $company => $details) {
    echo "<strong>Company: $company</strong><br>";
    foreach ($details['models'] as $laptop) {
        echo "&nbsp;&nbsp;Model: " . $laptop['model'] . " - Price: $" . $laptop['price'] . "<br>";
    }
    echo "<br>";
}

// Alternative way to access multidimensional array
echo "<h4>Accessing specific elements:</h4>";
echo "Dell XPS 13 Price: $" . $laptops['Dell']['models'][0]['price'] . "<br>";
echo "HP Spectre x360 Price: $" . $laptops['HP']['models'][0]['price'] . "<br>";
echo "Apple MacBook Pro Price: $" . $laptops['Apple']['models'][0]['price'] . "<br>";
?>