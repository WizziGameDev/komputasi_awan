<?php
require_once "../connection.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $connection = getConnection();

    $delete_supplier = "DELETE FROM supplier WHERE id = ?";
    $statement = $connection->prepare($delete_supplier);
    $statement->execute([$id]);

    $connection = null;
    header("location: ../../view/viewSupplier.php");
    exit();

} else {
    echo "No Supplier Id specified.";
}
