<?php

require_once "../connection.php";

session_start();
$connection = getConnection();

$action_type = $_GET['action_type'];
if ($action_type == 'delete') {
    $id = $_GET['id'];

    if (!empty($id)) {
        /* SELECT */
        $query = "SELECT * FROM detail_purchase WHERE purchase_id = ?";
        $statement = $connection->prepare($query);
        $statement->execute([$id]);

        // Check data if have
        if ($statement->rowCount() > 0) {
            while ($row = $statement->fetch()) {
                $query_item = "UPDATE item SET stock = stock - ? WHERE code = ? ";
                $statement_item = $connection->prepare($query_item);
                $statement_item->execute([$row['quantity'], $row['item_code']]);
            }
        }

        // Delete from detail_purchase
        $query_delete_detail = "DELETE FROM detail_purchase WHERE purchase_id = ?";
        $statement_delete_detail = $connection->prepare($query_delete_detail);
        $statement_delete_detail->execute([$id]);

        // Delete from purchase
        $query_delete_purchase = "DELETE FROM purchase WHERE id = ?";
        $statement_delete_purchase = $connection->prepare($query_delete_purchase);
        $statement_delete_purchase->execute([$id]);

        $connection = null;
        header("location: ../../view/viewPurchase.php");
        exit();
    }
}
