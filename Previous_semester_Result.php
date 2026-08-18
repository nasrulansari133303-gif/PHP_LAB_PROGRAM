<?php
// Define constants for semester details
define("SEMESTER", "Previous Semester");
define("YEAR", 2025);

// Variables for student results
$studentName = "John Doe";
$rollNumber = "CS-2024-001";
$subject1 = 85;
$subject2 = 78;
$subject3 = 92;
$subject4 = 70;
$subject5 = 88;

// Calculate total and percentage
$totalMarks = $subject1 + $subject2 + $subject3 + $subject4 + $subject5;
$totalSubjects = 5;
$maxMarks = 500;
$percentage = ($totalMarks / $maxMarks) * 100;

// Determine grade
if ($percentage >= 90) {
    $grade = "A+";
} elseif ($percentage >= 80) {
    $grade = "A";
} elseif ($percentage >= 70) {
    $grade = "B";
} elseif ($percentage >= 60) {
    $grade = "C";
} elseif ($percentage >= 50) {
    $grade = "D";
} else {
    $grade = "F";
}

// Display result
echo "<h2>" . SEMESTER . " Result - " . YEAR . "</h2>";
echo "Student Name: " . $studentName . "<br>";
echo "Roll Number: " . $rollNumber . "<br>";
echo "Subject 1: " . $subject1 . "<br>";
echo "Subject 2: " . $subject2 . "<br>";
echo "Subject 3: " . $subject3 . "<br>";
echo "Subject 4: " . $subject4 . "<br>";
echo "Subject 5: " . $subject5 . "<br>";
echo "Total Marks: " . $totalMarks . "/" . $maxMarks . "<br>";
echo "Percentage: " . number_format($percentage, 2) . "%<br>";
echo "Grade: " . $grade . "<br>";
?>