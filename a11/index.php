<?php
// Start session management with a persistent cookie
$lifetime = 60 * 60 * 24 * 14;    // 2 weeks in seconds
// $lifetime = 0;                      // per-session cookie
session_set_cookie_params($lifetime, '/');
session_start();

/********* PASS BY VALUE ********/
// Create a cart array if needed
// if (empty($_SESSION['cart13'])) { 
//     $_SESSION['cart13'] = array();
// } else {
//     $cart = $_SESSION['cart13'];    // Copy $_SESSION['cart13'] to $cart
// }


/********* PASS BY REFERENCE ********/
if (empty($_SESSION['cart13'])) { 
    $cart = array();
} else {
    $cart = $_SESSION['cart13'];    // Copy $_SESSION['cart13'] to $cart
}

// Create a table of products
$products = array();
$products['MMS-1754'] = array('name' => 'Flute', 'cost' => '149.50');
$products['MMS-6289'] = array('name' => 'Trumpet', 'cost' => '199.50');
$products['MMS-3408'] = array('name' => 'Clarinet', 'cost' => '299.50');

// Include cart functions
require_once('cart.php');

// Get the action to perform
$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'show_add_item';
    }
}

/********* PASS BY VALUE ********/
// Add or update cart as needed
// switch($action) {
//     case 'add':
//         $key = filter_input(INPUT_POST, 'productkey');
//         $quantity = filter_input(INPUT_POST, 'itemqty');
//         add_item($cart, $key, $quantity);

//         // update $cart
//         $cart = $_SESSION['cart13'];
//         include('cart_view.php');
//         break;
//     case 'update':
//         $new_qty_list = filter_input(INPUT_POST, 'newqty', 
//                 FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
//         foreach($new_qty_list as $key => $qty) {
//             if ($cart[$key]['qty'] != $qty) {
//                 update_item($cart, $key, $qty);
//             }
//         }

//         // update cart
//         $cart = $_SESSION['cart13'];
//         include('cart_view.php');
//         break;

//     case 'show_cart':
//         include('cart_view.php');
//         break;

//     case 'show_add_item':
//         include('add_item_view.php');
//         break;

//     case 'empty_cart':
//         unset($_SESSION['cart13']);
//         include('cart_view.php');
//         break;
// }

/********* PASS BY REFERENCE ********/
switch($action) {
    case 'add':
        $key = filter_input(INPUT_POST, 'productkey');
        $quantity = filter_input(INPUT_POST, 'itemqty');
        dainguyen\cart\add_item($cart, $key, $quantity);

        // update cart
        $_SESSION['cart13'] = $cart;

        include('cart_view.php');
        break;

    case 'update':
        $new_qty_list = filter_input(INPUT_POST, 'newqty', 
                FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        foreach($new_qty_list as $key => $qty) {
            if ($cart[$key]['qty'] != $qty) {
                dainguyen\cart\update_item($cart, $key, $qty);
            }
        }

        // update cart
        $_SESSION['cart13'] = $cart;
        include('cart_view.php');
        break;

    case 'show_cart':
        include('cart_view.php');
        break;

    case 'show_add_item':
        include('add_item_view.php');
        break;

    case 'empty_cart':
        // empty the array
        $cart = array();
        $_SESSION['cart13'] = $cart;
        include('cart_view.php');
        break;
}
?>