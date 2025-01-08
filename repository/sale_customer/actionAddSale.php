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
    header("location: ../../view/viewAddSale.php");
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
    header("location: ../../view/viewAddSale.php");
    exit();
}

// Clear Session
if (isset($_GET['action_type'])) {
    $action_type = $_GET['action_type'];

    if ($action_type === 'clear_session') {
        unset($_SESSION['cart']);
        header("location: ../../view/viewSale.php");
    }
}

// Submit to Database
if ($action_type == 'submit') {
    $customer_name = $_POST['customer_name'];

    // check cart not null
    if (!empty($_SESSION['cart'])) {

        // check customer code
        if (!empty($customer_name)) {
        
                $query_sale = "INSERT INTO sale (tgl_sale, customer_name) VALUES (NOW(), ?)";
                $statement_sale = $connection->prepare($query_sale);
                $statement_sale->execute([$customer_name]);
                $id = $connection->lastInsertId();

                /* SQL */
                foreach ($_SESSION['cart'] as $cart_item) {
                    $item_id = $cart_item['id'];
                    $quantity = $cart_item['quantity'];
                    $price = $cart_item['price'];
                    $total_price = $quantity * $price;

                    /* Detail Sale */
                    $query_detail = "INSERT INTO detail_sale (sale_id, item_id, quantity, price, total_price) VALUES (?,?,?,?,?)";
                    $statement_detail = $connection->prepare($query_detail);
                    $statement_detail->execute([$id, $item_id, $quantity, $price, $total_price]);

                    /* Min Stock in Table Item */
                    $query_item = "UPDATE item SET stock = stock - ? WHERE id = ?";
                    $statement_item = $connection->prepare($query_item);
                    $statement_item->execute([$quantity, $item_id]);

                }

                $connection = null;
                $_SESSION['cart'] = array();
                header("location: ../../view/generateReceiptSale.php?sale_id=$id");
                exit();

        } else {
            /* ELSE empty customer code */
            $_SESSION['error_message'] = "Complete your input customer name";
            header("location: ../../view/viewAddSale.php");
            exit();
        }
    } else {
        /* ELSE cart null */
        $_SESSION['error_message'] = "Complete Your Input Cart";
        session_write_close();
        header("location: ../../view/viewAddSale.php");
        exit();
    }
}
