<?php
    // Include the Functions File
    require_once('functions.php');

    // Investment Variable
    $investment = 0;
    $interest_rate = 0;
    $years = 0;

    // Currency Format
    $investment_f = '';
    $yearly_rate_f = '';
    $future_value_f = '';

    // Error Message
    $error_message = '';

    // Get the data from the form
    getData($investment, $interest_rate, $years);

    // Validate Investment
    $error_message = validateInvestment($investment, $interest_rate, $years);
    
    // if an error message exists, go to the index page
    if ($error_message != '') {
        include('index.php');
        exit();
    }

    // Calculate the future value
    $future_value = calculateFutureValue($investment, $years, $interest_rate);

    // Apply currency and percent formatting
    currencyFormat($investment_f, $yearly_rate_f, $future_value_f)
?>
<!DOCTYPE html>
<html>
<head>
    <title>Future Value Calculator</title>
    <link rel="stylesheet" type="text/css" href="main.css"/>
</head>
<body>
    <main>
        <h1>Future Value Calculator</h1>

        <label>Investment Amount:</label>
        <span><?php echo htmlspecialchars($investment_f); ?></span><br />

        <label>Yearly Interest Rate:</label>
        <span><?php echo htmlspecialchars($yearly_rate_f); ?></span><br />

        <label>Number of Years:</label>
        <span><?php echo htmlspecialchars($years); ?></span><br />

        <label>Future Value:</label>
        <span><?php echo htmlspecialchars($future_value_f); ?></span><br />
        
        <p>This calculation was done on <?php echo date('m/d/Y'); ?>.</p>

        <br>
        <p>Another Calculation? --> <a href="index.php"> Click Here </a> <--- </p>
    </main>
</body>
</html>