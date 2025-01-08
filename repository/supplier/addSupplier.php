<?php

require_once "../connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data
    $name = $_POST["name"] ?? "";
    $email = $_POST["email"] ?? "";
    $contact = $_POST["contact"] ?? "";
    $address = $_POST["address"] ?? "";

    if (!empty($name) && !empty($email) && !empty($contact) && !empty($address)) {
        try {
            $connection = getConnection();

            // Corrected query to insert only specific columns
            $query_success = "INSERT INTO supplier (name, email, contact, address) VALUES (?,?,?,?)";
            $statement = $connection->prepare($query_success);
            $statement->execute([$name, $email, $contact, $address]);
            $connection = null;

            header("location: ../../view/viewSupplier.php");

        } catch (PDOException $e) {
            // Handle if primary key same
            $errorMessage = "ID already exists. Use another ID.";
            echo "<script>
                alert('$errorMessage');
                window.history.go(-1);
            </script>";
            $connection = null;
            exit();
        }

    } else {
        // Handle error not complete
        $errorMessage = "Complete your input";
        echo "<script>
                alert('$errorMessage');
                window.history.go(-1); 
            </script>";
        $connection = null;
    }
    exit();
}
