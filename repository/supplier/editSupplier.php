<?php

require_once "../connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id = $_POST["id"] ?? "";
    $name = $_POST["name"] ?? "";
    $email = $_POST["email"] ?? "";
    $contact = $_POST["contact"] ?? "";
    $address = $_POST["address"] ?? "";

    // Validasi input form
    if (!empty($id) && !empty($name) && !empty($email) && !empty($contact) && !empty($address)) {
        // Membuka koneksi database
        $connection = getConnection();

        // Query update data
        $query_update = "UPDATE supplier SET name = ?, email = ?, contact = ?, address = ? WHERE id = ?";
        $statement = $connection->prepare($query_update);

        // Eksekusi query dengan parameter
        $statement->execute([$name, $email, $contact, $address, $id]);

        // Redirect ke halaman view supplier setelah update
        header("Location: ../../view/viewSupplier.php");
        
        // Menutup koneksi
        $connection = null;
        exit();
    } else {
        // Jika data tidak lengkap, kirim pesan error
        $errorMessage = "Complete your input";
        header("Location: ../../view/viewSupplier.php?error=$errorMessage");
        exit();
    }
}
