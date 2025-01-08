<?php

require_once "../connection.php";

session_start();
$connection = getConnection();

$action_type = $_GET['action_type'];
if ($action_type == 'delete') {
    $id = $_GET['id'];

    if (!empty($id)) {
        /* SELECT */
        $query = "SELECT * FROM detail_sale WHERE sale_id = ?";
        $statement = $connection->prepare($query);
        $statement->execute([$id]);

        // Check data if have
        if ($statement->rowCount() > 0) {
            while ($row = $statement->fetch()) {
                $query_item = "UPDATE item SET stock = stock + ? WHERE id = ? ";
                $statement_item = $connection->prepare($query_item);
                $statement_item->execute([$row['quantity'], $row['item_id']]);
            }
        }

        // Delete from detail_sale
        $query_delete_detail = "DELETE FROM detail_sale WHERE sale_id = ?";
        $statement_delete_detail = $connection->prepare($query_delete_detail);
        $statement_delete_detail->execute([$id]);

        // Delete from sale
        $query_delete_sale = "DELETE FROM sale WHERE id = ?";
        $statement_delete_sale = $connection->prepare($query_delete_sale);
        $statement_delete_sale->execute([$id]);

        $connection = null;
        header("location: ../../view/viewSale.php");
        exit();
    }
}
