<!-- 
functions.php 

Description: make the future value calculator looks more clean
by seperating its function to a seperated file.
-->
<?php
// get data from the form
function getData (&$investment, &$interest_rate, &$years) {
    $investment = filter_input(INPUT_POST, 'investment',
        FILTER_VALIDATE_FLOAT);
    $interest_rate = filter_input(INPUT_POST, 'interest_rate',
        FILTER_VALIDATE_FLOAT);
    $years = filter_input(INPUT_POST, 'years',
        FILTER_VALIDATE_INT);
}

function validateInvestment($investment, $interest_rate, $years) {
    // validate investment
    if ($investment === FALSE ) {
        $error_message = 'Investment must be a valid number.'; 
    } else if ( $investment <= 0 ) {
        $error_message = 'Investment must be greater than zero.'; 
    // validate interest rate
    } else if ( $interest_rate === FALSE )  {
        $error_message = 'Interest rate must be a valid number.'; 
    } else if ( $interest_rate <= 0) {
        $error_message = 'Interest rate must be greater than zero .';
    } else if ( $interest_rate > 15 ) {
        $error_message = 'Interest rate must be less than or equal to 15.';
    // validate years
    } else if ( $years === FALSE ) {
        $error_message = 'Years must be a valid whole number.';
    } else if ( $years <= 0 ) {
        $error_message = 'Years must be greater than zero.';
    } else if ( $years > 30 ) {
        $error_message = 'Years must be less than 31.';
    // set error message to empty string if no invalid entries
    } else {
        $error_message = ''; 
    }
    return $error_message;
}

// Caculate Furture Value
function calculateFutureValue($investment, $years, $interest_rate) {
    $future_value = $investment;
    for ($i = 1; $i <= $years; $i++) {
        $future_value += $future_value * $interest_rate *.01;
    }

    return $future_value;
}

// Currency Format
function currencyFormat(&$investment_f, &$yearly_rate_f, &$future_value_f) {
    // Access global variables
    global $investment, $interest_rate, $future_value;

    $investment_f = '$'.number_format($investment, 2);
    $yearly_rate_f = $interest_rate.'%';
    $future_value_f = '$'.number_format($future_value, 2);
}
?>