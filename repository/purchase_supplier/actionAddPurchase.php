<?php session_start();

require_once "../connection.php";
$connection = getConnection();

// Add Item
$action_type = $_GET['action_type'];
if($action_type=='add_item') {

    $id = $_GET['id'];
    $product_name = $_GET['product_name'];
    $size = $_GET['size'];
    $quantity = $_GET['quantity'];
    $price = $_GET['price'];

    $product_arr = array(
        'id'=>$id,
        'product_name'=>$product_name,
        'size' => $size,
        'quantity'=>$quantity,
        'price'=>$price,
    );

    if(!empty($_SESSION['cart'])) {

        $product_ids = array_column($_SESSION['cart'], 'id');
        if(in_array($id, $product_ids)) {

            foreach($_SESSION['cart'] as $key => $val) {

                if($_SESSION['cart'][$key]['id'] == $id) {

                    $_SESSION['cart'][$key]['quantity'] = $_SESSION['cart'][$key]['quantity'] + $quantity;

                }
            }
        }
        else {
            $_SESSION['cart'][] = $product_arr;
        }
    }
    else {
        $_SESSION['cart'][] = $product_arr;
    }
    header("location: ../../view/viewAddPurchase.php");
}

// Delete Item
if ($action_type == 'remove_item') {
    $id = $_GET['id'];
    $quantity = isset($_GET['quantity']) ? intval($_GET['quantity']) : 1;

    if (!empty($_SESSION['cart'])) {
        $product_ids = array_column($_SESSION['cart'], 'id');

        if (in_array($id, $product_ids)) {
            foreach ($_SESSION['cart'] as $key => $val) {
                if ($_SESSION['cart'][$key]['id'] == $id) {
                    $_SESSION['cart'][$key]['quantity'] -= $quantity;

                    if ($_SESSION['cart'][$key]['quantity'] <= 0) {
                        unset($_SESSION['cart'][$key]);
                    }

                    break;
                }
            }
        }
    }
    header("location: ../../view/viewAddPurchase.php");
    exit();
}

// Clear Session
if (isset($_GET['action_type'])) {
    $action_type = $_GET['action_type'];

    if ($action_type === 'clear_session') {
        unset($_SESSION['cart']);
        header("location: ../../view/viewPurchase.php");
        exit();
    }
}

// Submit to Database
if ($action_type == 'submit') {
    $supplier_id = $_POST['supplier_id']; // Ensure this is the supplier ID

    // Check cart is not empty
    if (!empty($_SESSION['cart'])) {
        // Check supplier ID
        if (!empty($supplier_id)) {
            $query_supplier = "SELECT * FROM supplier WHERE id = ?";
            $statement = $connection->prepare($query_supplier);
            $statement->execute([$supplier_id]);
            $check_id = $statement->rowCount();

            // Proceed if supplier exists
            if ($check_id != 0) {
                $query_purchase = "INSERT INTO purchase (tgl_purchase, supplier_id) VALUES (NOW(), ?)";
                $statement_purchase = $connection->prepare($query_purchase);
                $statement_purchase->execute([$supplier_id]);
                $purchase_id = $connection->lastInsertId();

                foreach ($_SESSION['cart'] as $cart_item) {
                    $item_id = $cart_item['id']; // Use 'id' for item ID
                    $quantity = $cart_item['quantity'];
                    $price = $cart_item['price'];
                    $total_price = $quantity * $price;

                    // Insert detail purchase
                    $query_detail = "INSERT INTO detail_purchase (purchase_id, item_id, quantity, price, total_price) VALUES (?, ?, ?, ?, ?)";
                    $statement_detail = $connection->prepare($query_detail);
                    $statement_detail->execute([$purchase_id, $item_id, $quantity, $price, $total_price]);

                    // Update stock in item table
                    $query_item = "UPDATE item SET stock = stock + ? WHERE id = ?"; // Ensure this uses the correct field name
                    $statement_item = $connection->prepare($query_item);
                    $statement_item->execute([$quantity, $item_id]); // Use item_id to update stock
                }

                // Clear session and redirect with success message
                $connection = null;
                $_SESSION['cart'] = array();
                header("location: ../../view/generateReceiptPurchase.php?purchase_id=$purchase_id");
                exit();
            } else {
                // Supplier ID not found
                $_SESSION['error_message'] = "Supplier ID doesn't exist";
                header("location: ../../view/viewAddPurchase.php");
                exit();
            }
        } else {
            // Supplier ID is empty
            $_SESSION['error_message'] = "Please select a supplier.";
            header("location: ../../view/viewAddPurchase.php");
            exit();
        }
    } else {
        // Cart is empty
        $_SESSION['error_message'] = "Your cart is empty.";
        header("location: ../../view/viewAddPurchase.php");
        exit();
    }
}
