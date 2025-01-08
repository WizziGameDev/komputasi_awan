<?php

require_once "../connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form
    $id = $_POST["id"] ?? "";
    $name = $_POST["name"] ?? "";
    $price = $_POST["price"] ?? "";
    $stock = $_POST["stock"] ?? "";
    $size = $_POST["size"] ?? "";
    $category = $_POST["category"] ?? "";

    // Check if null
    if (!empty($id) && !empty($name) && !empty($price) && !empty($stock) && !empty($category)) {
        try {
            $connection = getConnection();

            $query = "UPDATE item SET name = ?, price = ?, stock = ?, category = ?, size = ? WHERE id = ?";
            $statement = $connection->prepare($query);
            $statement->execute([$name, $price, $stock, $category, $size, $id]);
            $connection = null;

            // Redirect if success
            header("location: ../../view/viewItem.php");
            exit();
        } catch (PDOException $e) {
            // Handle Error Update
            $errorMessage = "Error updating item: " . $e->getMessage();
            echo "<script>
                alert('$errorMessage');
                window.history.go(-1);
            </script>";
            exit();
        }
    } else {
        // Handle error not complete
        $errorMessage = "Complete your input";
        echo "<script>
                alert('$errorMessage');
                window.history.go(-1); 
            </script>";
        exit();
    }
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
