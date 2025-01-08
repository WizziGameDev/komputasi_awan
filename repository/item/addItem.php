<?php

require_once "../connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data
    $name = $_POST["name"] ?? "";
    $price = $_POST["price"] ?? "";
    $stock = $_POST["stock"] ?? "";
    $size = $_POST["size"] ?? "";
    $category = $_POST["category"] ?? "";

    // Check if fields are not empty
    if (!empty($name) && !empty($price) && !empty($stock) && !empty($category)) {
        try {
            $connection = getConnection();

            // Update query to insert data without needing to specify ID
            $query = "INSERT INTO item (name, price, stock, category" . (empty($size) ? "" : ", size") . ") 
            VALUES (?, ?, ?, ?" . (empty($size) ? "" : ", ?") . ")";
                       $statement = $connection->prepare($query);
            $statement->execute([$name, $price, $stock, $category, $size]);

            // Close the connection
            $connection = null;

            // Redirect after successful insertion
            header("Location: ../../view/viewItem.php");
            exit();
        } catch (PDOException $e) {
            // Handle any potential errors
            $errorMessage = "Error: " . $e->getMessage();
            echo "<script>
                alert('$errorMessage');
                window.history.go(-1);
            </script>";
            $connection = null;
            exit();
        }
    } else {
        // Handle error for incomplete input
        $errorMessage = "Please complete all fields.";
        echo "<script>
                alert('$errorMessage');
                window.history.go(-1); 
            </script>";
        $connection = null;
        exit();
    }
}
