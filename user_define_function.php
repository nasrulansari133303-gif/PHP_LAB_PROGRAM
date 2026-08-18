<?php
echo "<h2>Calculator with User-Defined Functions</h2>";

// Calculator functions
function add($a, $b) {
    return $a + $b;
}

function subtract($a, $b) {
    return $a - $b;
}

function multiply($a, $b) {
    return $a * $b;
}

function divide($a, $b) {
    if ($b == 0) {
        return "Error: Division by zero!";
    }
    return $a / $b;
}

function power($a, $b) {
    return pow($a, $b);
}

function modulus($a, $b) {
    if ($b == 0) {
        return "Error: Modulus by zero!";
    }
    return $a % $b;
}

function calculate($num1, $num2, $operation) {
    switch ($operation) {
        case 'add':
            return add($num1, $num2);
        case 'subtract':
            return subtract($num1, $num2);
        case 'multiply':
            return multiply($num1, $num2);
        case 'divide':
            return divide($num1, $num2);
        case 'power':
            return power($num1, $num2);
        case 'modulus':
            return modulus($num1, $num2);
        default:
            return "Invalid operation";
    }
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['calculate'])) {
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    $operation = $_POST['operation'];
    
    if (is_numeric($num1) && is_numeric($num2)) {
        $num1 = (float)$num1;
        $num2 = (float)$num2;
        $result = calculate($num1, $num2, $operation);
        
        $operationSymbols = array(
            'add' => '+',
            'subtract' => '-',
            'multiply' => '×',
            'divide' => '÷',
            'power' => '^',
            'modulus' => '%'
        );
        
        echo "<div style='background-color: #e8f4f8; padding: 15px; border: 1px solid #ccc; margin: 10px 0;'>";
        echo "<h3>Result:</h3>";
        echo "<strong>$num1 " . $operationSymbols[$operation] . " $num2 = $result</strong>";
        echo "</div>";
    } else {
        echo "<div style='background-color: #ffebee; padding: 15px; border: 1px solid #ffcdd2; margin: 10px 0;'>";
        echo "<strong>Error: Please enter valid numbers!</strong>";
        echo "</div>";
    }
}
?>

<!-- Calculator Form -->
<style>
    .calculator-form {
        background-color: #f5f5f5;
        padding: 20px;
        border-radius: 8px;
        max-width: 400px;
        margin: 20px 0;
    }
    .calculator-form input, .calculator-form select {
        padding: 8px;
        margin: 5px 0;
        width: 100%;
        box-sizing: border-box;
    }
    .calculator-form input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
        font-size: 16px;
        margin-top: 10px;
    }
    .calculator-form input[type="submit"]:hover {
        background-color: #45a049;
    }
</style>

<div class="calculator-form">
    <h3>Simple Calculator</h3>
    <form method="POST">
        <label>Enter First Number:</label>
        <input type="text" name="num1" placeholder="e.g., 10" required>
        
        <label>Select Operation:</label>
        <select name="operation" required>
            <option value="add">Addition (+)</option>
            <option value="subtract">Subtraction (-)</option>
            <option value="multiply">Multiplication (×)</option>
            <option value="divide">Division (÷)</option>
            <option value="power">Power (^)</option>
            <option value="modulus">Modulus (%)</option>
        </select>
        
        <label>Enter Second Number:</label>
        <input type="text" name="num2" placeholder="e.g., 5" required>
        
        <input type="submit" name="calculate" value="Calculate">
    </form>
</div>

<!-- Calculator with More Features -->
<h3>Advanced Calculator Features:</h3>
<div style="background-color: #fff3e0; padding: 15px; border: 1px solid #ffcc80; margin: 10px 0;">
    <?php
    // Demonstration of all functions
    echo "<strong>Function Demonstrations:</strong><br>";
    echo "add(10, 5) = " . add(10, 5) . "<br>";
    echo "subtract(10, 5) = " . subtract(10, 5) . "<br>";
    echo "multiply(10, 5) = " . multiply(10, 5) . "<br>";
    echo "divide(10, 5) = " . divide(10, 5) . "<br>";
    echo "power(2, 3) = " . power(2, 3) . "<br>";
    echo "modulus(10, 3) = " . modulus(10, 3) . "<br>";
    echo "divide(10, 0) = " . divide(10, 0) . "<br>";
    ?>
</div>

<!-- Multiple Operations Form -->
<div style="background-color: #e8f5e9; padding: 15px; border: 1px solid #a5d6a7; margin: 10px 0;">
    <h4>Batch Calculation:</h4>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['batch_calculate'])) {
        $numbers = $_POST['numbers'];
        $operation = $_POST['batch_operation'];
        
        if (!empty($numbers)) {
            $numArray = array_map('trim', explode(',', $numbers));
            $numArray = array_map('floatval', $numArray);
            
            echo "<strong>Results:</strong><br>";
            $result = $numArray[0];
            for ($i = 1; $i < count($numArray); $i++) {
                $result = calculate($result, $numArray[$i], $operation);
            }
            echo "Result: $result<br>";
        }
    }
    ?>
    
    <form method="POST">
        <label>Enter numbers (comma separated):</label>
        <input type="text" name="numbers" placeholder="e.g., 10, 5, 2" style="width: 300px;">
        <select name="batch_operation">
            <option value="add">Add All</option>
            <option value="subtract">Subtract All</option>
            <option value="multiply">Multiply All</option>
        </select>
        <input type="submit" name="batch_calculate" value="Batch Calculate">
    </form>
</div>