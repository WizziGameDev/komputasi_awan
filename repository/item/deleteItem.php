<?php
require_once "../connection.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $connection = getConnection();

    $delete_item = "DELETE FROM item WHERE id = ?";
    $statement = $connection->prepare($delete_item);
    $statement->execute([$id]);

    $connection = null;
    header("location: ../../view/viewItem.php");
    exit();

} else {
    echo "No Customer Code specified.";
}

