<?php
function getConnection() {
    $host = 'db';  // Nama host sesuai dengan nama service di docker-compose
    $dbname = 'fp_web';
    $username = 'root';
    $password = '12345';

    try {
        return new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    } catch (PDOException $e) {
        die('Connection failed: ' . $e->getMessage());
    }
}
?>
